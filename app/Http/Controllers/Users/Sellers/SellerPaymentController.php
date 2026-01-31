<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Seller\SellerPlan;
use App\Models\Seller\SellerPlanPrices;
use App\Models\Seller\SellerPlanSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerPaymentController extends Controller
{
    // redirect to the payment page
    public function redirect(Request $request)
    {
        // dd($request);
        $plan = SellerPlan::findOrfail($request->plan);
        $price = $plan->price;
        $duration = 30;
        $sub_plan_id = 0;
        if ($request->sub_plan_id) {
            $sub_plan = SellerPlanPrices::findOrFail($request->sub_plan_id);
            $price = $sub_plan->price;
            $sub_plan_id = $sub_plan->id;
            $duration = $sub_plan->duration;
        }

        // variables
        // $seller_id=get_seller_data(Auth::user()->tenant_id)->id;
        // $price_with_duration = $request->plan_price;
        // $price_array=explode('<sup>د.ج</sup>/',$price_with_duration);
        // $price=$price_array[0];
        // $duration=$price_array[1];
        // $payment_data=$request->all();
        // $plan=get_seller_plan_data($request->plan);
        $seller_id = get_seller_data(Auth::user()->tenant_id)->id;

        if ($price == 0) {
            // subscribe with free plan
            $subscription = SellerPlanSubscription::where('seller_id', $seller_id)->first();
            $subscription->plan_id = 1;
            $subscription->duration = 30;
            $subscription->status = 'free';
            $subscription->update();

            // update order status
            // redirect to dashboard page
            return redirect()->route('seller.dashboard');
        } else {
            // redirect to the payment page
            if ($request->pay_method == 'algerian_credit_card') {
                // redirect to algerian credit card payment page
                // return redirect()->route('seller.payment.algerian_credit_card')->with('payment_data',$payment_data);
                // return app()->call('App\Http\Controllers\ChargilyPayController@redirect', ['request' => new Request($request->all())]);

                return view('users.sellers.payments.cib.new_subscribtion.index', compact('request', 'plan', 'sub_plan_id', 'duration', 'price'));
            } elseif ($request->pay_method == 'baridimob') {
                // redirect to baridimob payment page
                return view('users.sellers.payments.baridimob.new_subscribtion.index', compact('request', 'plan', 'sub_plan_id', 'duration', 'price'));
            } else {
                // redirect to ccp payment page
                return view('users.sellers.payments.ccp.new_subscribtion.index', compact('request', 'plan', 'sub_plan_id', 'duration', 'price'));
            }
        }
    }

    // algerian credit card payment page
    public function algerian_credit_card()
    {
        return view('users.sellers.payments.cib.index');
    }

    // baridimob payment page
    public function baridimob()
    {
        return view('users.sellers.payments.baridimob.index');
    }

    // ccp payment page
    public function ccp()
    {
        return view('users.sellers.payments.ccp.index');
    }
}
