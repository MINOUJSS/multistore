<?php

namespace App\Services\Admins\Admin;

use App\Models\Category;
use App\Models\Seller\SellerProducts;
use App\Models\Supplier\SupplierProducts;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ProductAnalyticsService
{
    /**
     * Get paginated products with analytics and winning product metrics.
     */
    public function getAnalyticsProducts(array $filters = [], int $perPage = 15): array
    {
        $type = $filters['type'] ?? 'all';
        $search = trim($filters['search'] ?? '');
        $categoryId = $filters['category_id'] ?? null;
        $status = $filters['status'] ?? null;
        $sortBy = $filters['sort_by'] ?? 'winning_score';

        $sellerProducts = collect();
        $supplierProducts = collect();

        // 1. Fetch Seller Products if type is 'all' or 'seller'
        if ($type === 'all' || $type === 'seller') {
            $sellerProducts = $this->querySellerProducts($search, $categoryId, $status);
        }

        // 2. Fetch Supplier Products if type is 'all' or 'supplier'
        if ($type === 'all' || $type === 'supplier') {
            $supplierProducts = $this->querySupplierProducts($search, $categoryId, $status);
        }

        // 3. Merge products into a single collection
        $allProducts = $sellerProducts->concat($supplierProducts);

        // 4. Calculate KPIs and Winning Scores for each item
        $enrichedProducts = $allProducts->map(function ($product) {
            return $this->enrichProductMetrics($product);
        });

        // 5. Apply Sorting
        $sortedProducts = $this->sortProducts($enrichedProducts, $sortBy);

        // 6. Manual Pagination for unified collection
        $page = LengthAwarePaginator::resolveCurrentPage();
        $paginatedItems = $sortedProducts->slice(($page - 1) * $perPage, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $paginatedItems,
            $sortedProducts->count(),
            $perPage,
            $page,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]
        );

        // 7. Calculate Global Dashboard Summary Metrics
        $summaryStats = $this->calculateGlobalStats($enrichedProducts);

        // 8. Categories for filter dropdown
        $categories = Category::all();

        return [
            'paginator' => $paginator,
            'summary' => $summaryStats,
            'categories' => $categories,
        ];
    }

    /**
     * Query Seller Products with aggregations.
     */
    protected function querySellerProducts(string $search, ?string $categoryId, ?string $status): Collection
    {
        $query = SellerProducts::query()
            ->with(['seller', 'category', 'images'])
            ->withSum('orderItems', 'quantity')
            ->withSum('orderItems', 'total_price')
            ->withCount('visits')
            ->withAvg('reviews', 'rating');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhereHas('seller', function ($sq) use ($search) {
                      $sq->where('store_name', 'like', "%{$search}%")
                         ->orWhere('full_name', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        return $query->get()->map(function ($p) {
            $p->subscriber_type = 'seller';
            $p->subscriber_name = $p->seller->full_name ?? ($p->seller->store_name ?? 'بائع غير معروف');
            $p->store_name = $p->seller->store_name ?? 'متجر بائع';
            $p->owner_id = $p->seller_id;
            return $p;
        });
    }

    /**
     * Query Supplier Products with aggregations.
     */
    protected function querySupplierProducts(string $search, ?string $categoryId, ?string $status): Collection
    {
        $query = SupplierProducts::query()
            ->with(['supplier', 'category', 'images'])
            ->withSum('orderItems', 'quantity')
            ->withSum('orderItems', 'total_price')
            ->withCount('visits')
            ->withAvg('reviews', 'rating');

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%")
                  ->orWhereHas('supplier', function ($sq) use ($search) {
                      $sq->where('store_name', 'like', "%{$search}%")
                         ->orWhere('full_name', 'like', "%{$search}%");
                  });
            });
        }

        if (!empty($categoryId)) {
            $query->where('category_id', $categoryId);
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        return $query->get()->map(function ($p) {
            $p->subscriber_type = 'supplier';
            $p->subscriber_name = $p->supplier->full_name ?? ($p->supplier->store_name ?? 'مورد غير معروف');
            $p->store_name = $p->supplier->store_name ?? 'متجر مورد بالجملة';
            $p->owner_id = $p->supplier_id;
            return $p;
        });
    }

    /**
     * Enrich product instance with calculated KPIs and Winning Product Score.
     */
    public function enrichProductMetrics($product)
    {
        $unitsSold = (int) ($product->order_items_sum_quantity ?? 0);
        $totalRevenue = (float) ($product->order_items_sum_total_price ?? 0);
        $price = (float) $product->price;
        $cost = (float) $product->cost;

        $profitPerUnit = max(0, $price - $cost);
        $estimatedProfit = $unitsSold * $profitPerUnit;
        $profitMarginPct = $price > 0 ? round(($profitPerUnit / $price) * 100, 1) : 0;

        $visits = (int) ($product->visits_count ?? 0);
        if ($visits === 0 && isset($product->view_count)) {
            $visits = (int) $product->view_count;
        }

        $conversionRate = $visits > 0 ? round(($unitsSold / $visits) * 100, 2) : ($unitsSold > 0 ? 100.0 : 0.0);
        $avgRating = round((float) ($product->reviews_avg_rating ?? 0), 1);

        // --- Winning Score Algorithm (0 to 100 Points) ---
        // 1. Sales Volume Score (Max 35 pts)
        $salesScore = min(35, round(($unitsSold / 30) * 35));

        // 2. Conversion Rate Score (Max 25 pts)
        $convScore = 0;
        if ($conversionRate >= 10) {
            $convScore = 25;
        } elseif ($conversionRate >= 5) {
            $convScore = 20;
        } elseif ($conversionRate >= 2) {
            $convScore = 14;
        } elseif ($conversionRate > 0) {
            $convScore = 8;
        }

        // 3. Profit Margin Score (Max 25 pts)
        $marginScore = 0;
        if ($profitMarginPct >= 40) {
            $marginScore = 25;
        } elseif ($profitMarginPct >= 25) {
            $marginScore = 18;
        } elseif ($profitMarginPct >= 10) {
            $marginScore = 12;
        } elseif ($profitMarginPct > 0) {
            $marginScore = 6;
        }

        // 4. Rating & Reviews Score (Max 15 pts)
        $ratingScore = $avgRating > 0 ? round(($avgRating / 5) * 15) : 10;

        $winningScore = min(100, $salesScore + $convScore + $marginScore + $ratingScore);

        // Assign Classification Tier
        if ($winningScore >= 75) {
            $tier = 'super_winner';
            $tierLabel = '🏆 منتج خارق';
            $tierBadge = 'bg-danger text-white';
        } elseif ($winningScore >= 50) {
            $tier = 'winner';
            $tierLabel = '🔥 منتج رابح';
            $tierBadge = 'bg-warning text-dark';
        } elseif ($winningScore >= 25) {
            $tier = 'promising';
            $tierLabel = '📈 أداء واعد';
            $tierBadge = 'bg-info text-dark';
        } else {
            $tier = 'low';
            $tierLabel = '❄️ نشاط منخفض';
            $tierBadge = 'bg-secondary text-white';
        }

        $product->analytics = (object) [
            'units_sold' => $unitsSold,
            'total_revenue' => $totalRevenue,
            'profit_per_unit' => $profitPerUnit,
            'estimated_profit' => $estimatedProfit,
            'profit_margin_pct' => $profitMarginPct,
            'visits' => $visits,
            'conversion_rate' => $conversionRate,
            'avg_rating' => $avgRating,
            'winning_score' => $winningScore,
            'tier' => $tier,
            'tier_label' => $tierLabel,
            'tier_badge' => $tierBadge,
        ];

        return $product;
    }

    /**
     * Sort the products collection according to chosen criteria.
     */
    protected function sortProducts(Collection $products, string $sortBy): Collection
    {
        return match ($sortBy) {
            'sales' => $products->sortByDesc(fn($p) => $p->analytics->units_sold),
            'revenue' => $products->sortByDesc(fn($p) => $p->analytics->total_revenue),
            'profit' => $products->sortByDesc(fn($p) => $p->analytics->estimated_profit),
            'conversion' => $products->sortByDesc(fn($p) => $p->analytics->conversion_rate),
            'visits' => $products->sortByDesc(fn($p) => $p->analytics->visits),
            'newest' => $products->sortByDesc(fn($p) => $p->created_at),
            default => $products->sortByDesc(fn($p) => $p->analytics->winning_score),
        };
    }

    /**
     * Calculate global dashboard KPIs.
     */
    protected function calculateGlobalStats(Collection $products): array
    {
        $totalProducts = $products->count();
        $totalWinners = $products->where('analytics.winning_score', '>=', 50)->count();
        $totalSalesUnits = $products->sum('analytics.units_sold');
        $totalRevenue = $products->sum('analytics.total_revenue');
        $totalProfit = $products->sum('analytics.estimated_profit');
        $avgConversion = $totalProducts > 0 ? round($products->avg('analytics.conversion_rate'), 2) : 0;

        $topProduct = $products->sortByDesc(fn($p) => $p->analytics->winning_score)->first();

        return [
            'total_products' => $totalProducts,
            'total_winners' => $totalWinners,
            'total_sales_units' => $totalSalesUnits,
            'total_revenue' => $totalRevenue,
            'total_profit' => $totalProfit,
            'avg_conversion' => $avgConversion,
            'top_product' => $topProduct,
        ];
    }

    /**
     * Get single product analytics details.
     */
    public function getProductDetails(string $type, int $id)
    {
        if ($type === 'seller') {
            $product = SellerProducts::with([
                'seller.user',
                'category',
                'images',
                'variations',
                'reviews',
                'orderItems.order'
            ])
            ->withSum('orderItems', 'quantity')
            ->withSum('orderItems', 'total_price')
            ->withCount('visits')
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);

            $product->subscriber_type = 'seller';
            $product->subscriber_name = $product->seller->full_name ?? ($product->seller->store_name ?? 'بائع');
            $product->store_name = $product->seller->store_name ?? 'متجر البائع';
            $product->owner_id = $product->seller_id;
        } else {
            $product = SupplierProducts::with([
                'supplier.user',
                'category',
                'images',
                'variations',
                'reviews',
                'orderItems.order'
            ])
            ->withSum('orderItems', 'quantity')
            ->withSum('orderItems', 'total_price')
            ->withCount('visits')
            ->withAvg('reviews', 'rating')
            ->findOrFail($id);

            $product->subscriber_type = 'supplier';
            $product->subscriber_name = $product->supplier->full_name ?? ($product->supplier->store_name ?? 'مورد');
            $product->store_name = $product->supplier->store_name ?? 'متجر المورد';
            $product->owner_id = $product->supplier_id;
        }

        return $this->enrichProductMetrics($product);
    }
}
