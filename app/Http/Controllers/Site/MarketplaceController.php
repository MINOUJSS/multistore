<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Seller\SellerProducts;
use App\Models\Supplier\SupplierProducts;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    /**
     * Default dummy product names & slugs to filter out from marketplace
     */
    protected array $excludedNames = [
        'منتج 1', 'منتج 2', 'منتج 3', 'منتج 4',
        'منتج1', 'منتج2', 'منتج3', 'منتج4',
        'Product 1', 'Product 2', 'Product 3', 'Product 4',
        'product 1', 'product 2', 'product 3', 'product 4',
    ];

    /**
     * Display Sellers Marketplace (Retail & Dropship products)
     */
    public function sellersMarketplace(Request $request)
    {
        $query = SellerProducts::query()
            ->with([
                'seller.tenant.domains',
                'category',
                'activeDiscount',
                'images',
                'ratings',
            ])
            ->where('status', 'active')
            ->where('show_in_marketplace', 'yes')
            ->whereHas('seller', function ($q) {
                $q->whereNotNull('tenant_id')
                  ->whereHas('tenant', function ($t) {
                      $t->has('domains');
                  });
            });

        // Exclude default placeholder/dummy products
        $this->applyDefaultProductExclusions($query);

        // Filter: Search Keyword
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter: Category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter: Product Type (physical / digital)
        if ($request->filled('product_type') && in_array($request->product_type, ['physical', 'digital'])) {
            $query->where('product_type', $request->product_type);
        }

        // Filter: Min Price
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }

        // Filter: Max Price
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        // Filter: Free Shipping
        if ($request->filled('free_shipping') && in_array($request->free_shipping, ['yes', 'no'])) {
            $query->where('free_shipping', $request->free_shipping);
        }

        // Filter: Condition
        if ($request->filled('condition') && in_array($request->condition, ['new', 'used', 'refurbished'])) {
            $query->where('condition', $request->condition);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'popular':
                $query->withCount('visits')->orderBy('visits_count', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        // Distinct categories of active seller products
        $categoryIds = SellerProducts::where('status', 'active')
            ->where('show_in_marketplace', 'yes')
            ->whereNotNull('category_id')
            ->where(function ($q) {
                $this->applyDefaultProductExclusions($q);
            })
            ->pluck('category_id')
            ->unique();

        $categories = Category::whereIn('id', $categoryIds)->get();

        $totalProductsCount = SellerProducts::where('status', 'active')
            ->where('show_in_marketplace', 'yes')
            ->where(function ($q) {
                $this->applyDefaultProductExclusions($q);
            })->count();

        return view('site.marketplace.sellers', compact('products', 'categories', 'totalProductsCount'));
    }

    /**
     * Display Wholesale Suppliers Marketplace
     */
    public function suppliersMarketplace(Request $request)
    {
        $query = SupplierProducts::query()
            ->with([
                'supplier.tenant.domains',
                'category',
                'activeDiscount',
                'images',
                'ratings',
            ])
            ->where('status', 'active')
            ->where('show_in_marketplace', 'yes')
            ->whereHas('supplier', function ($q) {
                $q->whereNotNull('tenant_id')
                  ->whereHas('tenant', function ($t) {
                      $t->has('domains');
                  });
            });

        // Exclude default placeholder/dummy products
        $this->applyDefaultProductExclusions($query);

        // Filter: Search Keyword
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter: Category
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter: Min Price / Cost
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (float) $request->min_price);
        }

        // Filter: Max Price
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (float) $request->max_price);
        }

        // Filter: Minimum Order Quantity (MOQ max limit)
        if ($request->filled('max_moq')) {
            $query->where('minimum_order_qty', '<=', (int) $request->max_moq);
        }

        // Filter: Free Shipping
        if ($request->filled('free_shipping') && in_array($request->free_shipping, ['yes', 'no'])) {
            $query->where('free_shipping', $request->free_shipping);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'moq_asc':
                $query->orderBy('minimum_order_qty', 'asc');
                break;
            case 'popular':
                $query->withCount('visits')->orderBy('visits_count', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('id', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        // Distinct categories of active supplier products
        $categoryIds = SupplierProducts::where('status', 'active')
            ->where('show_in_marketplace', 'yes')
            ->whereNotNull('category_id')
            ->where(function ($q) {
                $this->applyDefaultProductExclusions($q);
            })
            ->pluck('category_id')
            ->unique();
        $categories = Category::whereIn('id', $categoryIds)->get();

        $totalProductsCount = SupplierProducts::where('status', 'active')
            ->where('show_in_marketplace', 'yes')
            ->where(function ($q) {
                $this->applyDefaultProductExclusions($q);
            })->count();

        return view('site.marketplace.suppliers', compact('products', 'categories', 'totalProductsCount'));
    }

    /**
     * Apply standard exclusions for default/dummy products created upon registration
     */
    protected function applyDefaultProductExclusions($query)
    {
        $query->whereNotIn('name', $this->excludedNames)
            ->where('name', 'not like', 'منتج 1%')
            ->where('name', 'not like', 'منتج 2%')
            ->where('name', 'not like', 'منتج 3%')
            ->where('name', 'not like', 'منتج 4%')
            ->where('slug', 'not like', '%-product-1')
            ->where('slug', 'not like', '%-product-2')
            ->where('slug', 'not like', '%-product-3')
            ->where('slug', 'not like', '%-product-4');
    }
}
