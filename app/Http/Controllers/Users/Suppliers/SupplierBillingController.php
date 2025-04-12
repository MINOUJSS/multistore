<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierBillingController extends Controller
{
    //
    public function index()
    {
        return view('users.suppliers.billing.index');
    }
}
