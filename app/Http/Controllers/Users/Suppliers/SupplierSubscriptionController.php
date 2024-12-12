<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Models\SupplierPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierSubscriptionController extends Controller
{
    //
    public function index()
    {
        $plans=SupplierPlan::all();
        return view('users.suppliers.subscription.index',compact('plans'));
    }
    //cofirmation 
    public function confirmation()
    {
        $plans=SupplierPlan::all();
     return view('users.suppliers.subscription.confirmation',compact('plans'));   
    }
}
