<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    //
    public function dashboard()
    {
        return view('users.suppliers.dashboard');
    }
}
