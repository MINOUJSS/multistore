<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Seller\SellerProductCoupons;
use App\Models\Seller\SellerProducts;
use App\Models\userCoupons;
use Illuminate\Http\Request;

class SellerProductsCouponsController extends Controller
{
    public function index()
    {
        $seller = get_seller_data(auth()->user()->tenant_id);

        $coupons = userCoupons::where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        $products = SellerProducts::where('seller_id', $seller->id)->get();

        $relations = SellerProductCoupons::with(['coupon', 'product'])
            ->whereIn('product_id', $products->pluck('id'))
            ->get();

        return view('users.sellers.coupons.products-coupons.index', compact('coupons', 'products', 'relations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'coupon_id' => 'required',
        ]);

        foreach ($request->product_ids as $product_id) {
            SellerProductsCoupons::create([
                'product_id' => $product_id,
                'coupon_id' => $request->coupon_id,
            ]);
        }

        return redirect()->back();
    }

    // destroy
    public function destroy($id)
    {
        SellerProductsCoupons::find($id)->delete();

        return redirect()->back();
    }
}
