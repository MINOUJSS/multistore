<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Services\Admins\Admin\ProductAnalyticsService;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    protected ProductAnalyticsService $analyticsService;

    public function __construct(ProductAnalyticsService $analyticsService)
    {
        $this->analyticsService = $analyticsService;
    }

    /**
     * Display a listing of subscribers' products with winning analytics.
     */
    public function index(Request $request)
    {
        $filters = [
            'type' => $request->get('type', 'all'),
            'search' => $request->get('search'),
            'category_id' => $request->get('category_id'),
            'status' => $request->get('status'),
            'sort_by' => $request->get('sort_by', 'winning_score'),
        ];

        $data = $this->analyticsService->getAnalyticsProducts($filters, 12);

        return view('admins.admin.products.index', [
            'products' => $data['paginator'],
            'summary' => $data['summary'],
            'categories' => $data['categories'],
            'filters' => $filters,
        ]);
    }

    /**
     * Display detailed intelligence sheet for a specific product.
     */
    public function show(string $type, int $id)
    {
        if (!in_array($type, ['seller', 'supplier'])) {
            abort(404, 'نوع المشترك غير صالح');
        }

        $product = $this->analyticsService->getProductDetails($type, $id);

        if (!$product) {
            return redirect()->route('admin.products.index')
                ->with('warning', 'المنتج المطلوب من المنتجات الافتراضية التجريبية المستبعدة من نظام استخبارات وتحليل المنتجات.');
        }

        return view('admins.admin.products.show', [
            'product' => $product,
            'type' => $type,
        ]);
    }
}
