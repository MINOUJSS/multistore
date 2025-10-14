<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Models\userCoupons;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Supplier\SupplierProducts;
use App\Models\Supplier\SupplierProductsCoupons;

class SupplierProductsCouponsController extends Controller
{
    //
        public function index()
    {
        $supplier = get_supplier_data(auth()->user()->tenant_id);

        $coupons = userCoupons::where('user_id', auth()->id())
            ->where('is_active', true)
            ->get();

        $products = SupplierProducts::where('supplier_id', $supplier->id)->get();

        $relations = SupplierProductsCoupons::with(['coupon', 'product'])
            ->whereIn('product_id', $products->pluck('id'))
            ->get();

        return view('users.suppliers.coupons.products-coupons.index', compact('coupons', 'products', 'relations'));
    }
    //
    public function store(Request $request)
    {
        $request->validate([
            'product_ids' => 'required|array',
            'coupon_id' => 'required',
        ]);

        foreach ($request->product_ids as $product_id) {
            SupplierProductsCoupons::create([
                'product_id' => $product_id,
                'coupon_id' => $request->coupon_id,
            ]);
        }

        return redirect()->back();
    }
    //destroy
    public function destroy($id)
    {
        SupplierProductsCoupons::find($id)->delete();
        return redirect()->back();
    }
}
