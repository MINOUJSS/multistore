<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierOrderAbandonedController extends Controller
{
    //
    public function index()
    {
        return view('users.suppliers.orders_abandoned.index');
    }
}
