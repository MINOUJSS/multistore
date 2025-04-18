<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChargilyPayController extends Controller
{
    /**
     * The client will be redirected to the ChargilyPay payment page
     *
     */
    public function redirect(Request $request)
    {
        $user = auth()->user();
        $currency = "dzd";
        $amount = $request->amount;
        $type = $request->payment_type; // 'invoice' | 'subscription' | 'other'
        $referenceId = $request->reference_id;

        //validation 
        if($type=='wallet_topup')
        {
            $validated = $request->validate([
                'amount' => 'required|numeric|min:50',
            ]); 
        }
    
        $payment = \App\Models\ChargilyPayment::create([
            "user_id"  => $user->id,
            "status"   => "pending",
            "currency" => $currency,
            "amount"   => $amount,
            "payment_type" => $type,
            "payment_reference_id" => $referenceId,
        ]);

        if ($payment) {
            $checkout = $this->chargilyPayInstance()->checkouts()->create([
                "metadata" => [
                    "payment_id" => $payment->id,
                    "payment_type" => $type,
                    "reference_id" => $referenceId,
                ],
                "locale" => "ar",
                "amount" => $payment->amount,
                "currency" => $payment->currency,
                "description" => "دفع من نوع {$type} رقم {$referenceId}",
                "success_url" => route("supplier.chargilypay.back"),
                "failure_url" => route("supplier.chargilypay.back"),
                "webhook_endpoint" => route("chargilypay.webhook_endpoint"),
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
        //dd($checkout,$payment);
        if($payment!==null && $payment->status=='paid') 
        {
            return redirect()->route('supplier.dashboard')->with('success','تمت عملية الدفع بنجاح');
        }else
        {
            return redirect()->route('supplier.dashboard')->with('error','فشل في عملية الدفع');
        }
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
                    $payment = \App\Models\ChargilyPayment::find($metadata['payment_id']);

                    if ($payment) {
                        $status = $checkout->getStatus();
                        $payment->status = $status === 'paid' ? 'paid' : 'failed';
                        $payment->update();

                        // معالجة حسب نوع الدفع
                        switch ($payment->payment_type) {
                            case 'user_invoice':
                                $invoice = \App\Models\UserInvoice::find($payment->payment_reference_id);
                                if ($invoice && $status === 'paid') {
                                    $invoice->status = 'paid';
                                    $invoice->paid_at= now();
                                    $invoice->payment_method=$checkout->getPaymentMethod();
                                    $invoice->update();
                                    $user = get_user_data_from_id($invoice->user_id);
                                    $balance=$user->balance->balance-$invoice->amount;
                                    $outstanding=$user->balance->outstanding_amount - $invoice->amount;

                                    if ($user && $user->balance) {
                                        $user->balance()->update([
                                            'balance'=>$balance,
                                            'outstanding_amount' =>$outstanding,
                                        ]);
                                    }
                                }
                                break;

                            case 'supplier_subscription':
                                //update subscription status
                                $subscription = \App\Models\SupplierPlanSubscription::find($payment->payment_reference_id);
                                if ($subscription) {
                                    $subscription->payment_status = $status;
                                    $subscription->status = $status === 'paid' ? 'paid' : 'free';
                                    $subscription->update();
                                }
                                break;

                            case 'wallet_topup':
                                //update balance 
                                $user = get_user_data_from_id($payment->payment_reference_id);
                                $balance=\App\Models\UserBalance::where('user_id',$user->id)->first();
                                $balance->balance=$balance->balance + $checkout->getAmount();
                                $balance->update();
                                //insert new balance transaction
                                \App\Models\BalanceTransaction::create([
                                    'user_id' => $user->id,
                                    'transaction_type' => 'addition',
                                    'amount' => $checkout->getAmount(),
                                    'description' => 'شحن الرصيد بواسطة '.$checkout->getPaymentMethod().' رابط العملية: <a href="'.$checkout->getUrl().'" target="_blank">إضغط هنا</a>',
                                ]);

                                break;

                            case 'other':
                                // في المستقبل يمكن إضافة أنواع أخرى هنا
                                break;
                        }

                        return response()->json(["status" => true, "message" => "تمت معالجة الدفع بنجاح"]);
                    }

                    // $metadata = $checkout->getMetadata();
                    // $payment = \App\Models\ChargilyPayment::find($metadata['payment_id']);
                    // $supplier_subscription=\App\Models\SupplierPlanSubscription::where('supplier_id',$metadata['supplier_id'])->first();
                    // if ($payment) {
                    //     if ($checkout->getStatus() === "paid") {
                    //         //update payment status in database
                    //         $payment->status = "paid";
                    //         $payment->update();
                    //         /////
                    //         ///// Confirm your order
                    //         $supplier_subscription->payment_status='paid';
                    //         $supplier_subscription->status='paid';
                    //         $supplier_subscription->update();
                    //         /////
                    //         return response()->json(["status" => true, "message" => "Payment has been completed"]);
                    //     } else if ($checkout->getStatus() === "failed" or $checkout->getStatus() === "canceled") {
                    //         //update payment status in database
                    //         $payment->status = "failed";
                    //         $payment->update();
                    //         /////
                    //         /////  Cancel your order
                    //         $supplier_subscription->payment_status='failed';
                    //         $supplier_subscription->status='free';
                    //         $supplier_subscription->update();
                    //         /////
                    //         return response()->json(["status" => true, "message" => "Payment has been canceled"]);
                    //     }
                    // }
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
