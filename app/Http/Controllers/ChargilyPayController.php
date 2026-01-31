<?php

namespace App\Http\Controllers;

use App\Models\Seller\SellerOrderItems;
use App\Models\Seller\SellerOrders;
use App\Models\Seller\SellerPlan;
use App\Models\Seller\SellerPlanOrder;
use App\Models\Seller\SellerPlanPrices;
use App\Models\Seller\SellerPlanSubscription;
use App\Models\Supplier\SupplierOrderItems;
use App\Models\Supplier\SupplierOrders;
use App\Models\Supplier\SupplierPlan;
use App\Models\Supplier\SupplierPlanOrder;
use App\Models\Supplier\SupplierPlanPrices;
use Illuminate\Http\Request;

class ChargilyPayController extends Controller
{
    /**
     * The client will be redirected to the ChargilyPay payment page.
     */
    public function redirect(Request $request)
    {
        $user = auth()->user();
        $currency = 'dzd';
        $amount = $request->amount;
        $type = $request->payment_type; // 'invoice' | 'subscription' | 'other'
        $referenceId = $request->reference_id;
        // dd($request);
        // validation
        if ($type == 'wallet_topup') {
            $validated = $request->validate([
                'amount' => 'required|numeric|min:50',
            ]);
        } elseif ($type == 'new_supplier_subscription') {
            // get plan data
            $plan = SupplierPlan::findOrFail($request->plan_id);
            $amount = $plan->price;
            $duration = '30';
            if ($request->sub_plan_id != 0) {
                $sub_plan = SupplierPlanPrices::find($request->sub_plan_id);
                if ($sub_plan) {
                    $amount = $sub_plan->price;
                    $duration = $sub_plan->duration;
                }
            }
            // التحقق من وجود طلب سابق معلق
            $existingOrder = SupplierPlanOrder::where('supplier_id', $referenceId)
            ->where('status', 'pending')
            ->first();
            if ($existingOrder) {
                // حذف الطلب السابق
                $existingOrder->delete();
            }
            // create order
            $order = SupplierPlanOrder::create([
                'plan_id' => $plan->id,
                'supplier_id' => get_supplier_data($user->tenant_id)->id,
                'duration' => $duration,
                'price' => $amount,
                'discount' => 0,
                'payment_method' => 'chargily',
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'start_date' => now(),
                'end_date' => now()->addDays($duration),
            ]);
        } elseif ($type == 'supplier_subscription') {
            $old_subscription = \App\Models\Supplier\SupplierPlanSubscription::where('supplier_id', $request->reference_id)->first();
            $rest_days = $old_subscription->duration - appDiffInDays(now(), $old_subscription->subscription_start_date);
            $order = SupplierPlanOrder::findOrFail($request->order_id);
            $new_plan = SupplierPlan::findOrFail($order->plan_id);
            // $amount=$new_plan->price;
            $duration = '30';
            if ($request->sub_plan_id != 0) {
                $sub_plan = SupplierPlanPrices::find($request->sub_plan_id);
                if ($sub_plan) {
                    // $amount=$sub_plan->price;
                    $duration = $sub_plan->duration;
                }
            }
            // التحقق من وجود طلب سابق معلق
            $existingOrder = SupplierPlanOrder::where('supplier_id', $referenceId)
            ->where('status', 'pending')
            ->first();
            if ($existingOrder) {
                // حذف الطلب السابق
                $existingOrder->delete();
                // // إلغاء الطلب السابق
                // $existingOrder->update([
                //     'payment_status' => 'failed',
                //     'status' => 'cancelled',
                // ]);
            }

            // If switching from basic plan (1) to plan 2 or 3, apply full new plan price
            if ($old_subscription->plan_id == 1 && in_array($new_plan->id, [2, 3])) {
                if (empty($request->sub_plan_id) || $request->sub_plan_id == 0) {
                    $amount = $new_plan->price;
                } else {
                    $sub_plan = SupplierPlanPrices::findOrFail($request->sub_plan_id);
                    $amount = $sub_plan->price;
                }
            } elseif ($old_subscription->plan_id == 2 && $new_plan->id == 3) {
                $rest = get_rest_off_current_supplier_plan(
                    $request->reference_id,
                    $old_subscription->plan_id,
                    $new_plan->id,
                    $rest_days
                );
                // $amount = $new_plan->price - $rest;
                $amount = $new_plan->price - $rest;
            } else {
                $amount = 0;
            }

            // create order
            $order = SupplierPlanOrder::create([
                'plan_id' => $order->plan_id,
                'supplier_id' => get_supplier_data($user->tenant_id)->id,
                'duration' => $duration,
                'price' => $amount,
                'discount' => 0,
                'payment_method' => 'chargily',
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'start_date' => now(),
                'end_date' => now()->addDays($duration),
            ]);
        } elseif ($type == 'supplier_order') {
            $order = SupplierOrders::findOrfail($request->reference_id);
            $order_items = SupplierOrderItems::where('order_id', $order->id)->get();
            $amount = $order->total_price;
            $user_id = get_user_data($request->tenant_id)->id;
            // check if payment exist
            $payment_exist = \App\Models\ChargilyPaymentForTenants::where('user_id', $user_id)->where('payment_type', 'supplier_order')->where('status', 'pending')->where('payment_reference_id', $order->id)->first();
            if ($payment_exist) {
                $payment_exist->delete();
            }
            $payment = \App\Models\ChargilyPaymentForTenants::create([
                'user_id' => $user_id,
                'status' => 'pending',
                'currency' => $currency,
                'amount' => $amount,
                'payment_type' => $type,
                'payment_reference_id' => $referenceId,
            ]);

            if ($payment) {
                $checkout = $this->chargilyPayForTenantsInstance($request->tenant_id)->checkouts()->create([
                    'metadata' => [
                        'payment_id' => $payment->id,
                        'payment_type' => $type,
                        'reference_id' => $referenceId,
                    ],
                    'locale' => 'ar',
                    'amount' => $payment->amount,
                    'currency' => $payment->currency,
                    'description' => "دفع من نوع {$type} رقم {$referenceId}",
                    'success_url' => route('tenant.chargilypay.back'),
                    'failure_url' => route('tenant.chargilypay.back'),
                    'webhook_endpoint' => route('chargilypay.webhook_endpoint'),
                ]);
                if ($checkout) {
                    // update checkout url
                    $payment->update([
                        'checkout_url' => $checkout->getUrl(),
                    ]);

                    return redirect($checkout->getUrl());
                }
            }
        }
        // start for seller
        elseif ($type == 'new_seller_subscription') {
            // get plan data
            $plan = SellerPlan::findOrFail($request->plan_id);
            $amount = $plan->price;
            $duration = '30';
            if ($request->sub_plan_id != 0) {
                $sub_plan = SellerPlanPrices::find($request->sub_plan_id);
                if ($sub_plan) {
                    $amount = $sub_plan->price;
                    $duration = $sub_plan->duration;
                }
            }
            // التحقق من وجود طلب سابق معلق
            $existingOrder = SellerPlanOrder::where('seller_id', $referenceId)
            ->where('status', 'pending')
            ->first();
            if ($existingOrder) {
                // حذف الطلب السابق
                $existingOrder->delete();
            }
            // create order
            $order = SellerPlanOrder::create([
                'plan_id' => $plan->id,
                'seller_id' => get_seller_data($user->tenant_id)->id,
                'duration' => $duration,
                'price' => $amount,
                'discount' => 0,
                'payment_method' => 'chargily',
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'start_date' => now(),
                'end_date' => now()->addDays($duration),
            ]);
        } elseif ($type == 'seller_subscription') {
            $old_subscription = SellerPlanSubscription::where('seller_id', $request->reference_id)->first();
            $rest_days = $old_subscription->duration - appDiffInDays(now(), $old_subscription->subscription_start_date);
            $order = SellerPlanOrder::findOrFail($request->order_id);
            $new_plan = SellerPlan::findOrFail($order->plan_id);
            // $amount=$new_plan->price;
            $duration = '30';
            if ($request->sub_plan_id != 0) {
                $sub_plan = SellerPlanPrices::find($request->sub_plan_id);
                if ($sub_plan) {
                    // $amount=$sub_plan->price;
                    $duration = $sub_plan->duration;
                }
            }
            // التحقق من وجود طلب سابق معلق
            $existingOrder = SellerPlanOrder::where('seller_id', $referenceId)
            ->where('status', 'pending')
            ->first();
            if ($existingOrder) {
                // حذف الطلب السابق
                $existingOrder->delete();
                // // إلغاء الطلب السابق
                // $existingOrder->update([
                //     'payment_status' => 'failed',
                //     'status' => 'cancelled',
                // ]);
            }

            // If switching from basic plan (1) to plan 2 or 3, apply full new plan price
            if ($old_subscription->plan_id == 1 && in_array($new_plan->id, [2, 3])) {
                if (empty($request->sub_plan_id) || $request->sub_plan_id == 0) {
                    $amount = $new_plan->price;
                } else {
                    $sub_plan = SellerPlanPrices::findOrFail($request->sub_plan_id);
                    $amount = $sub_plan->price;
                }
            } elseif ($old_subscription->plan_id == 2 && $new_plan->id == 3) {
                $rest = get_rest_off_current_seller_plan(
                    $request->reference_id,
                    $old_subscription->plan_id,
                    $new_plan->id,
                    $rest_days
                );
                // $amount = $new_plan->price - $rest;
                $amount = $new_plan->price - $rest;
            } else {
                $amount = 0;
            }

            // create order
            $order = SellerPlanOrder::create([
                'plan_id' => $order->plan_id,
                'seller_id' => get_seller_data($user->tenant_id)->id,
                'duration' => $duration,
                'price' => $amount,
                'discount' => 0,
                'payment_method' => 'chargily',
                'status' => 'pending',
                'payment_status' => 'unpaid',
                'start_date' => now(),
                'end_date' => now()->addDays($duration),
            ]);
        } elseif ($type == 'seller_order') {
            $order = SellerOrders::findOrfail($request->reference_id);
            $order_items = SellerOrderItems::where('order_id', $order->id)->get();
            $amount = $order->total_price;
            $user_id = get_user_data($request->tenant_id)->id;
            // check if payment exist
            $payment_exist = \App\Models\ChargilyPaymentForTenants::where('user_id', $user_id)->where('payment_type', 'supplier_order')->where('status', 'pending')->where('payment_reference_id', $order->id)->first();
            if ($payment_exist) {
                $payment_exist->delete();
            }
            $payment = \App\Models\ChargilyPaymentForTenants::create([
                'user_id' => $user_id,
                'status' => 'pending',
                'currency' => $currency,
                'amount' => $amount,
                'payment_type' => $type,
                'payment_reference_id' => $referenceId,
            ]);

            if ($payment) {
                $checkout = $this->chargilyPayForTenantsInstance($request->tenant_id)->checkouts()->create([
                    'metadata' => [
                        'payment_id' => $payment->id,
                        'payment_type' => $type,
                        'reference_id' => $referenceId,
                    ],
                    'locale' => 'ar',
                    'amount' => $payment->amount,
                    'currency' => $payment->currency,
                    'description' => "دفع من نوع {$type} رقم {$referenceId}",
                    'success_url' => route('tenant.chargilypay.back'),
                    'failure_url' => route('tenant.chargilypay.back'),
                    'webhook_endpoint' => route('chargilypay.webhook_endpoint'),
                ]);
                if ($checkout) {
                    // update checkout url
                    $payment->update([
                        'checkout_url' => $checkout->getUrl(),
                    ]);

                    return redirect($checkout->getUrl());
                }
            }
        }
        // end for seller

        if ($user !== null) {
            $payment = \App\Models\ChargilyPayment::create([
                'user_id' => $user->id,
                'status' => 'pending',
                'currency' => $currency,
                'amount' => $amount,
                'payment_type' => $type,
                'payment_reference_id' => $referenceId,
            ]);
            // get user type
            if ($user->type == 'seller') {
                $success_url = route('seller.chargilypay.back');
                $failure_url = route('seller.chargilypay.back');
            } else {
                $success_url = route('supplier.chargilypay.back');
                $failure_url = route('supplier.chargilypay.back');
            }

            if ($payment) {
                $checkout = $this->chargilyPayInstance()->checkouts()->create([
                    'metadata' => [
                        'payment_id' => $payment->id,
                        'payment_type' => $type,
                        'reference_id' => $referenceId,
                    ],
                    'locale' => 'ar',
                    'amount' => $payment->amount,
                    'currency' => $payment->currency,
                    'description' => "دفع من نوع {$type} رقم {$referenceId}",
                    'success_url' => $success_url,
                    'failure_url' => $failure_url,
                    'webhook_endpoint' => route('chargilypay.webhook_endpoint'),
                ]);
                if ($checkout) {
                    // update checkout url
                    $payment->update([
                        'checkout_url' => $checkout->getUrl(),
                    ]);

                    return redirect($checkout->getUrl());
                }
            }
        }

        return dd('Redirection failed');
    }

    /**
     * Your client you will redirected to this link after payment is completed ,failed or canceled.
     */
    public function back(Request $request)
    {
        $user = null;
        $checkout_id = $request->input('checkout_id');
        $checkout = $this->chargilyPayInstance()->checkouts()->get($checkout_id);
        $payment = null;

        if ($checkout) {
            $metadata = $checkout->getMetadata();
            $payment = \App\Models\ChargilyPayment::find($metadata['payment_id']);
            // //
            // // Is not recomended to process payment in back page / success or fail page
            // // Doing payment processing in webhook for best practices
            // //
        }
        // dd($checkout,$payment);
        if ($payment !== null && $payment->status == 'paid') {
            // get user type
            if ($payment->payment_type == 'wallet_topup') {
                $user = \App\Models\User::find($payment->reference_id);
            }
            if ($payment->payment_type == 'new_supplier_subscription' || $payment->payment_type == 'supplier_subscription' || $payment->payment_type == 'supplier_order' || ($user !== null && $user->type == 'supplier')) {
                return redirect()->route('supplier.dashboard')->with('success', 'تمت عملية الدفع بنجاح');
            } elseif ($payment->payment_type == 'new_seller_subscription' || $payment->payment_type == 'seller_subscription' || $payment->payment_type == 'seller_order' || ($user !== null && $user->type == 'seller')) {
                return redirect()->route('seller.dashboard')->with('success', 'تمت عملية الدفع بنجاح');
            }
        // return redirect()->route('supplier.dashboard')->with('success', 'تمت عملية الدفع بنجاح');
        } else {
            if ($payment->payment_type == 'new_supplier_subscription' || $payment->payment_type == 'supplier_subscription' || $payment->payment_type == 'supplier_order') {
                return redirect()->route('supplier.dashboard')->with('error', 'فشل في عملية الدفع');
            } elseif ($payment->payment_type == 'new_seller_subscription' || $payment->payment_type == 'seller_subscription' || $payment->payment_type == 'seller_order') {
                return redirect()->route('seller.dashboard')->with('error', 'فشل في عملية الدفع');
            }

            // return redirect()->route('supplier.dashboard')->with('error', 'فشل في عملية الدفع');
        }
    }

    /**
     * This action will be processed in the background.
     */
    public function webhook()
    {
        $webhook = $this->chargilyPayInstance()->webhook()->get();
        if ($webhook) {
            $checkout = $webhook->getData();
            // check webhook data is set
            // check webhook data is a checkout
            if ($checkout and $checkout instanceof \Chargily\ChargilyPay\Elements\CheckoutElement) {
                if ($checkout) {
                    $metadata = $checkout->getMetadata();
                    if ($metadata['payment_type'] == 'supplier_order') {
                        $payment = \App\Models\ChargilyPaymentForTenants::find($metadata['payment_id']);
                    } else {
                        $payment = \App\Models\ChargilyPayment::find($metadata['payment_id']);
                    }

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
                                    $invoice->paid_at = now();
                                    $invoice->payment_method = $checkout->getPaymentMethod();
                                    $invoice->update();
                                    $user = get_user_data_from_id($invoice->user_id);
                                    $balance = $user->balance->balance - $invoice->amount;
                                    $outstanding = $user->balance->outstanding_amount - $invoice->amount;

                                    if ($user && $user->balance) {
                                        $user->balance()->update([
                                            'balance' => $balance,
                                            'outstanding_amount' => $outstanding,
                                        ]);
                                    }
                                }
                                break;
                                // start supplier actions
                            case 'new_supplier_subscription':
                                // get order data
                                $order = SupplierPlanOrder::where('supplier_id', $payment->payment_reference_id)->where('status', 'pending')->first();
                                // update order status
                                if ($order) {
                                    $order->status = 'approved';
                                    $order->payment_status = 'paid';
                                    $order->update();
                                }
                                // update subscription status
                                $subscription = \App\Models\Supplier\SupplierPlanSubscription::find($payment->payment_reference_id);
                                if ($subscription) {
                                    $subscription->plan_id = $order->plan_id;
                                    $subscription->duration = $order->duration;
                                    $subscription->price = $checkout->getAmount();
                                    $subscription->discount = 0;
                                    $subscription->payment_method = $checkout->getPaymentMethod();
                                    $subscription->payment_status = $status;
                                    $subscription->subscription_start_date = now();
                                    $subscription->subscription_end_date = now()->addDays($order->duration);
                                    $subscription->status = $status === 'paid' ? 'paid' : 'free';
                                    $subscription->update();
                                }
                                break;

                            case 'supplier_subscription':
                                // get order data
                                $order = SupplierPlanOrder::where('supplier_id', $payment->payment_reference_id)->where('status', 'pending')->first();
                                // update order status
                                if ($order) {
                                    $order->status = 'approved';
                                    $order->payment_status = 'paid';
                                    $order->update();
                                }
                                // update subscription status
                                $subscription = \App\Models\Supplier\SupplierPlanSubscription::find($payment->payment_reference_id);
                                if ($subscription) {
                                    $subscription->plan_id = $order->plan_id;
                                    $subscription->duration = $order->duration;
                                    $subscription->price = $checkout->getAmount();
                                    $subscription->discount = 0;
                                    $subscription->payment_method = $checkout->getPaymentMethod();
                                    $subscription->payment_status = $status;
                                    $subscription->subscription_start_date = now();
                                    $subscription->subscription_end_date = now()->addDays($order->duration);
                                    $subscription->status = $status === 'paid' ? 'paid' : 'free';
                                    $subscription->update();
                                }
                                break;
                            case 'supplier_order':
                                // get order data
                                $order = SupplierOrders::find($payment->payment_reference_id);
                                // update order status
                                if ($order) {
                                    $order->payment_status = $status === 'paid' ? 'paid' : 'failed';
                                    $order->payment_method = $checkout->getPaymentMethod();
                                    $order->confirmation_status = $status === 'paid' ? 'confirmed' : 'pending';
                                    $order->confirmed_by_user_id = $status === 'paid' ? get_user_data(get_supplier_data_from_id($order->supplier_id)->tenant_id)->id : null;
                                    $order->confirmed_at = $status === 'paid' ? now() : null;
                                    $order->status = $status === 'paid' ? 'processing' : 'pending';
                                    $order->update();
                                }
                                // end supplier actions
                                // start seller actions
                                // no break
                            case 'new_seller_subscription':
                                // get order data
                                $order = SellerPlanOrder::where('seller_id', $payment->payment_reference_id)->where('status', 'pending')->first();
                                // update order status
                                if ($order) {
                                    $order->status = 'approved';
                                    $order->payment_status = 'paid';
                                    $order->update();
                                }
                                // update subscription status
                                $subscription = SellerPlanSubscription::find($payment->payment_reference_id);
                                if ($subscription) {
                                    $subscription->plan_id = $order->plan_id;
                                    $subscription->duration = $order->duration;
                                    $subscription->price = $checkout->getAmount();
                                    $subscription->discount = 0;
                                    $subscription->payment_method = $checkout->getPaymentMethod();
                                    $subscription->payment_status = $status;
                                    $subscription->subscription_start_date = now();
                                    $subscription->subscription_end_date = now()->addDays($order->duration);
                                    $subscription->status = $status === 'paid' ? 'paid' : 'free';
                                    $subscription->update();
                                }
                                break;

                            case 'seller_subscription':
                                // get order data
                                $order = SellerPlanOrder::where('seller_id', $payment->payment_reference_id)->where('status', 'pending')->first();
                                // update order status
                                if ($order) {
                                    $order->status = 'approved';
                                    $order->payment_status = 'paid';
                                    $order->update();
                                }
                                // update subscription status
                                $subscription = SellerPlanSubscription::find($payment->payment_reference_id);
                                if ($subscription) {
                                    $subscription->plan_id = $order->plan_id;
                                    $subscription->duration = $order->duration;
                                    $subscription->price = $checkout->getAmount();
                                    $subscription->discount = 0;
                                    $subscription->payment_method = $checkout->getPaymentMethod();
                                    $subscription->payment_status = $status;
                                    $subscription->subscription_start_date = now();
                                    $subscription->subscription_end_date = now()->addDays($order->duration);
                                    $subscription->status = $status === 'paid' ? 'paid' : 'free';
                                    $subscription->update();
                                }
                                break;
                            case 'seller_order':
                                // get order data
                                $order = SellerOrders::find($payment->payment_reference_id);
                                // update order status
                                if ($order) {
                                    $order->payment_status = $status === 'paid' ? 'paid' : 'failed';
                                    $order->payment_method = $checkout->getPaymentMethod();
                                    $order->confirmation_status = $status === 'paid' ? 'confirmed' : 'pending';
                                    $order->confirmed_by_user_id = $status === 'paid' ? get_user_data(get_seller_data_from_id($order->seller_id)->tenant_id)->id : null;
                                    $order->confirmed_at = $status === 'paid' ? now() : null;
                                    $order->status = $status === 'paid' ? 'processing' : 'pending';
                                    $order->update();
                                }
                                // end seller actions

                                // no break
                            case 'wallet_topup':
                                // update balance
                                $user = get_user_data_from_id($payment->payment_reference_id);
                                $balance = \App\Models\UserBalance::where('user_id', $user->id)->first();
                                $balance->balance = $balance->balance + $checkout->getAmount();
                                $balance->update();
                                // insert new balance transaction
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

                        return response()->json(['status' => true, 'message' => 'تمت معالجة الدفع بنجاح']);
                    }

                    // $metadata = $checkout->getMetadata();
                    // $payment = \App\Models\ChargilyPayment::find($metadata['payment_id']);
                    // $supplier_subscription=\App\Models\Supplier\SupplierPlanSubscription::where('supplier_id',$metadata['supplier_id'])->first();
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
            'status' => false,
            'message' => 'Invalid Webhook request',
        ], 403);
    }

    /**
     * Just a shortcut.
     */
    protected function chargilyPayInstance()
    {
        return new \Chargily\ChargilyPay\ChargilyPay(new \Chargily\ChargilyPay\Auth\Credentials([
            'mode' => 'test',
            'public' => 'test_pk_dQD6KsE788otDQXgFrsVVzDt9wDmfo1dFupH5oKE',
            'secret' => 'test_sk_gpdoJktjYvibE4ydPsWQs6tf062lu6Rj5N4hQCo3',
        ]));
    }

    protected function chargilyPayForTenantsInstance($tenant_id)
    {
        $user = get_user_data($tenant_id);
        $settings = $user->chargilySettings;
        // dd($settings);

        return new \Chargily\ChargilyPay\ChargilyPay(new \Chargily\ChargilyPay\Auth\Credentials([
            'mode' => $settings->mode,
            'public' => $settings->public_key,
            'secret' => $settings->secret_key,
        ]));
    }
}
