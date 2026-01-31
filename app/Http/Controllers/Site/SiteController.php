<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Supplier\SupplierPlan;

class SiteController extends Controller
{
    public function index()
    {
        return view('site.index');
    }

    // show_suppliers_plans
    public function show_suppliers_plans()
    {
        $plans = SupplierPlan::all();

        return view('site.show_suppliers_plans', compact('plans'));
    }

    // show_sellers_plans
    public function show_sellers_plans()
    {
        $plans = SupplierPlan::all();

        return view('site.show_sellers_plans', compact('plans'));
    }

    // show_affiliate_marketers_plans
    public function show_affiliate_marketers_plans()
    {
        return view('site.show_affiliate_marketers_plans');
    }

    // show_shipers_plans
    public function show_shipers_plans()
    {
        return view('site.show_shipers_plans');
    }
}
