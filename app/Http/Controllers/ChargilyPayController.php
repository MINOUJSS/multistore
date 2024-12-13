<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SupplierPlanSubscription;

class ChargilyPayController extends Controller
{
    /**
     * The client will be redirected to the ChargilyPay payment page
     *
     */
    public function redirect(Request $request)
    {
        $amount_array = explode("<sup>د.ج</sup>/", $request->amount);
        $amount = $amount_array[0];
        $plan = get_supplier_plan_data($request->plan_id);

        $user = auth()->user();
        $currency = "dzd";
        // $amount = "25000";

        $payment = \App\Models\ChargilyPayment::create([
            "user_id"  => $user->id,
            "status"   => "pending",
            "currency" => $currency,
            "amount"   => $amount,
        ]);
        if ($payment) {
            $checkout = $this->chargilyPayInstance()->checkouts()->create([
                "metadata" => [
                    "payment_id" => $payment->id,
                    "supplier_id" => get_supplier_data($user->tenant_id)->id,
                ],
                "locale" => "ar",
                "amount" => $payment->amount,
                "currency" => $payment->currency,
                "description" => "Payment ID={$payment->id}",
                "success_url" => route("supplier.chargilypay.back"),
                "failure_url" => route("supplier.chargilypay.back"),
                "webhook_endpoint" => route("supplier.chargilypay.webhook_endpoint"),
            ]);
            if ($checkout) {
                return redirect($checkout->getUrl());
            }
        }
        return dd("Redirection failed");
    }
    /**
     * Your client you will redirected to this link after payment is completed ,failed or canceled
     *
     */
    public function back(Request $request)
    {
        $user = auth()->user();
        $checkout_id = $request->input("checkout_id");
        $checkout = $this->chargilyPayInstance()->checkouts()->get($checkout_id);
        $payment = null;

        if ($checkout) {
            $metadata = $checkout->getMetadata();
            $payment = \App\Models\ChargilyPayment::find($metadata['payment_id']);
            ////
            //// Is not recomended to process payment in back page / success or fail page
            //// Doing payment processing in webhook for best practices
            ////
        }
        dd($checkout,$payment);
    }
    /**
     * This action will be processed in the background
     */
    public function webhook()
    {
        $webhook = $this->chargilyPayInstance()->webhook()->get();
        if ($webhook) {
            //
            $checkout = $webhook->getData();
            //check webhook data is set
            //check webhook data is a checkout
            if ($checkout and $checkout instanceof \Chargily\ChargilyPay\Elements\CheckoutElement) {
                if ($checkout) {
                    $metadata = $checkout->getMetadata();
                    $payment = ChargilyPayment::find($metadata['payment_id']);
                    //get subscription
                    // $subscription=SupplierPlanSubscription::where('supplier_id',$metadata['supplier_id'])->first();
                    if ($payment) {
                        if ($checkout->getStatus() === "paid") {
                            //update payment status in database
                            $payment->status = "paid";
                            $payment->update();
                            /////
                            ///// Confirm your order
                            // $subscription->status='paid';
                            // $subscription->payment_status='paid';
                            // $subscription->update(); 
                            /////
                            return response()->json(["status" => true, "message" => "Payment has been completed"]);
                        } else if ($checkout->getStatus() === "failed" or $checkout->getStatus() === "canceled") {
                            //update payment status in database
                            $payment->status = "failed";
                            $payment->update();
                            /////
                            /////  Cancel your order
                            // $subscription->status='free';
                            // $subscription->payment_status='unpaid';
                            // $subscription->update(); 
                            /////
                            return response()->json(["status" => true, "message" => "Payment has been canceled"]);
                        }
                    }
                }
            }
        }
        return response()->json([
            "status" => false,
            "message" => "Invalid Webhook request",
        ], 403);
    }

    /**
     * Just a shortcut
     */
    protected function chargilyPayInstance()
    {
        return new \Chargily\ChargilyPay\ChargilyPay(new \Chargily\ChargilyPay\Auth\Credentials([
            "mode" => "test",
            "public" => "test_pk_dQD6KsE788otDQXgFrsVVzDt9wDmfo1dFupH5oKE",
            "secret" => "test_sk_gpdoJktjYvibE4ydPsWQs6tf062lu6Rj5N4hQCo3",
        ]));
    }
}
