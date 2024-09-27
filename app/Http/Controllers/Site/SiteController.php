<?php

namespace App\Http\Controllers\Site;

use App\Models\Wilaya;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    //
    public function index()
    {
        return view('site.index');
    }
    //show_suppliers_plans
    public function show_suppliers_plans()
    {
        return view('site.show_suppliers_plans');
    }
    //show_sellers_plans
    public function show_sellers_plans()
    {
        return view('site.show_sellers_plans');
    }
    //show_affiliate_marketers_plans
    public function show_affiliate_marketers_plans()
    {
        return view('site.show_affiliate_marketers_plans');
    }
    //show_shipers_plans
    public function show_shipers_plans()
    {
        return view('site.show_shipers_plans');
    }
}
