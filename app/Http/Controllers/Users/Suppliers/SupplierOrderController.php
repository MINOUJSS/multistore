<?php

namespace App\Http\Controllers\Users\Suppliers;

use Illuminate\Http\Request;
use App\Models\SupplierOrders;
use App\Http\Controllers\Controller;

class SupplierOrderController extends Controller
{
    //
    public function index()
    {
        $orders=SupplierOrders::OrderBy('id','desc')->where('supplier_id',get_supplier_data(auth()->user()->tenant_id)->id)->get();
        //make all orders readed
        foreach($orders as $order)
        {
            $order->is_readed=true;
            $order->update();
        }
        return view('users.suppliers.orders.index',compact('orders'));
    }
    //
    public function order($id)
    {
        $order = SupplierOrders::with([
            'items.product',        // جلب معلومات المنتج
            'items.variation',  // جلب معلومات المتغير
            'items.attribute',  // جلب معلومات الخاصية
            'items.attribute.attribute'   // جلب معلومات الخاصية
        ])->findOrFail($id);
        //return $order;
        return response()->json($order);
    }
}
