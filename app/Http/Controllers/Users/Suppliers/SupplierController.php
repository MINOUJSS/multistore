<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Models\SupplierOrders;
use App\Http\Controllers\Controller;

class SupplierController extends Controller
{
    //
    public function index()
    {
        $supplier=Supplier::findOrfail(get_supplier_data(auth()->user()->tenant_id)->id);
        $orders=SupplierOrders::where('supplier_id',get_supplier_data(auth()->user()->tenant_id)->id)->get();
        // dd($supplier->orderToDay);
        return view('users.suppliers.index',compact('supplier','orders'));
    }
}
