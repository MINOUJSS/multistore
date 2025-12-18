<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Http\Controllers\Controller;
use App\Models\Supplier\SupplierPlan;
use App\Models\Supplier\SupplierPlanPrices;
use App\Models\Supplier\SupplierPlanSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierPaymentController extends Controller
{
    // redirect to the payment page
    public function redirect(Request $request)
    {
        // dd($request);
        $plan = SupplierPlan::findOrfail($request->plan);
        $price = $plan->price;
        $duration = 30;
        $sub_plan_id = 0;
        if ($request->sub_plan_id) {
            $sub_plan = SupplierPlanPrices::findOrFail($request->sub_plan_id);
            $price = $sub_plan->price;
            $sub_plan_id = $sub_plan->id;
            $duration = $sub_plan->duration;
        }

        // variables
        // $supplier_id=get_supplier_data(Auth::user()->tenant_id)->id;
        // $price_with_duration = $request->plan_price;
        // $price_array=explode('<sup>د.ج</sup>/',$price_with_duration);
        // $price=$price_array[0];
        // $duration=$price_array[1];
        // $payment_data=$request->all();
        // $plan=get_supplier_plan_data($request->plan);
        $supplier_id = get_supplier_data(Auth::user()->tenant_id)->id;

        if ($price == 0) {
            // subscribe with free plan
            $subscription = SupplierPlanSubscription::where('supplier_id', $supplier_id)->first();
            $subscription->plan_id = 1;
            $subscription->duration = 30;
            $subscription->status = 'free';
            $subscription->update();

            // update order status
            // redirect to dashboard page
            return redirect()->route('supplier.dashboard');
        } else {
            // redirect to the payment page
            if ($request->pay_method == 'algerian_credit_card') {
                // redirect to algerian credit card payment page
                // return redirect()->route('supplier.payment.algerian_credit_card')->with('payment_data',$payment_data);
                // return app()->call('App\Http\Controllers\ChargilyPayController@redirect', ['request' => new Request($request->all())]);

                return view('users.suppliers.payments.cib.new_subscribtion.index', compact('request', 'plan', 'sub_plan_id', 'duration', 'price'));
            } elseif ($request->pay_method == 'baridimob') {
                // redirect to baridimob payment page
                return view('users.suppliers.payments.baridimob.new_subscribtion.index', compact('request', 'plan', 'sub_plan_id', 'duration', 'price'));
            } else {
                // redirect to ccp payment page
                return view('users.suppliers.payments.ccp.new_subscribtion.index', compact('request', 'plan', 'sub_plan_id', 'duration', 'price'));
            }
        }
    }

    // algerian credit card payment page
    public function algerian_credit_card()
    {
        return view('users.suppliers.payments.cib.index');
    }

    // baridimob payment page
    public function baridimob()
    {
        return view('users.suppliers.payments.baridimob.index');
    }

    // ccp payment page
    public function ccp()
    {
        return view('users.suppliers.payments.ccp.index');
    }
}
