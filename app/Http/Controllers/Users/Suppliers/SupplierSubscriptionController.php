<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Models\SupplierPlan;
use Illuminate\Http\Request;
use App\Models\SupplierPlanOrder;
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
    //suscribe invoice
    public function order_plan($plan_id)
    {
        $new_plan=SupplierPlan::findOrFail($plan_id);
        //check if supplier has old order
        $order=SupplierPlanOrder::where('supplier_id',get_supplier_data(auth()->user()->tenant_id)->id)->where('status','pending')->first();
        if($order)
        {
            //cancel old order
            $order->payment_status='failed';
            $order->status='cancelled';
            $order->update();
        }else
        {
                    //create order for new plan with payment method unaccepted wallet payment
         $order=SupplierPlanOrder::create([
            'plan_id'=>$new_plan->id,
            'supplier_id'=>get_supplier_data(auth()->user()->tenant_id)->id,
            'duration' => '30',
            'price' => $new_plan->price,
            'discount' => 0,
            'payment_method' => null,
            'payment_status' => 'unpaid',
            'status' => 'pending',
            'subscription_start_date' => now(),
            'subscription_end_date' => now()->addMonth(),
        ]);
        }
         //redirect to pay page
         return view('users.suppliers.subscription.order_plan.checkoute',compact('order'));

    }
}
