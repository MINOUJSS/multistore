<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Models\SupplierPlan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierPlanController extends Controller
{
    //
    public function plan_pricing($plan_id)
    {
        $plan = SupplierPlan::find($plan_id);
        $array = [];
        $array[] = $plan;
        $array[] = $plan->pricing;
        return response()->json($array);
    }
}
