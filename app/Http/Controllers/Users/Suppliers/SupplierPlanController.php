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
    //plan authorization
    public function plan_authorization($plan_id)
    {
        $plan = SupplierPlan::find($plan_id);
        // $array = [];
        // $array[] = $plan;
        // $array[] = $plan->Authorizations;
        // return response()->json($array);
        $html='<ul class="list-group list-group-flush mb-3" style="list-style: none">';
        foreach($plan->Authorizations as $authorization)
        {
            if($authorization->is_enabled !==0)
            {
                $html.='<li><i class="fas fa-check-circle text-success"></i> '.$authorization->description.'</li>';
            }else
            {
                $html.='<li><i class="fas fa-times-circle text-danger"></i> '.$authorization->description.'</li>';
            }
        }
        $html.='</ul>';
        return response()->json($html);
    }
}
