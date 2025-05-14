<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Models\User;
use App\Models\UserBalance;
use App\Models\SupplierPlan;
use Illuminate\Http\Request;
use App\Models\SupplierPlanOrder;
use App\Models\BalanceTransaction;
use App\Models\SupplierPlanPrices;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\SupplierPlanSubscription;

class SupplierSubscriptionController extends Controller
{
    //
    public function index()
    {
        // $url=explode(request()->server('REQUEST_SCHEME').'://',route('supplier.subscription'));
        // $protocol=request()->server('REQUEST_SCHEME');
        // $newurl="{$url[1]}";     
        // dd($newurl);
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
    public function order_plan(Request $request,$plan_id)
    {
        // dd($request->sub_plan_id);
        $supplierId = get_supplier_data(auth()->user()->tenant_id)->id;
        $new_plan = SupplierPlan::findOrFail($plan_id);
        $old_subscription = SupplierPlanSubscription::where('supplier_id', $supplierId)->first();
        $rest_days = $old_subscription->duration - appDiffInDays(now(), $old_subscription->subscription_start_date);
        // التحقق من وجود طلب سابق معلق
        $existingOrder = SupplierPlanOrder::where('supplier_id', $supplierId)
            ->where('status', 'pending')
            ->first();
        if ($existingOrder) {
            // إلغاء الطلب السابق
            $existingOrder->update([
                'payment_status' => 'failed',
                'status' => 'cancelled',
            ]);
        }

        // تحديد مدة الاشتراك (عدد الأيام)
        if($request->sub_plan_id==0 || $request->sub_plan_id==null)
        {
            $subscriptionDuration = 30;
            $plan_price=$new_plan->price;
            $sub_plan=null;
        }else
        {
            $sub_plan=SupplierPlanPrices::where('id',$request->sub_plan_id)->first();
            $subscriptionDuration = $sub_plan->duration;
            $plan_price=$sub_plan->price;
        }
        
             // If switching from basic plan (1) to plan 2 or 3, apply full new plan price
             if (($old_subscription->plan_id == 1 && in_array($new_plan->id, [2, 3]))) {
                if( empty($request->sub_plan_id) || $request->sub_plan_id == 0)
                {
                    $price = $new_plan->price;
                }
                else
                {
                    $sub_plan = SupplierPlanPrices::findOrFail($request->sub_plan_id);
                    $price = $sub_plan->price;
                }
                
            }elseif($old_subscription->plan_id == 2 && $new_plan->id == 3)
            {
                $rest = get_rest_off_current_supplier_plan(
                    $supplierId,
                    $old_subscription->plan_id,
                    $new_plan->id,
                    $rest_days
                );
                //$price = $new_plan->price - $rest; 
                $price = $new_plan->price - $rest; 
            }
            else{   
                $price=0;              
            }

        // إنشاء طلب جديد
        $order = SupplierPlanOrder::create([
            'plan_id' => $new_plan->id,
            'supplier_id' => $supplierId,
            'duration' => $subscriptionDuration,
            'price' =>$price,
            'discount' => 0,
            'payment_method' => null,
            'payment_status' => 'unpaid',
            'status' => 'pending',
            'subscription_start_date' => now(),
            'subscription_end_date' => now()->addDays($subscriptionDuration),
        ]);

        // عرض صفحة الدفع
        return view('users.suppliers.subscription.order_plan.checkoute', compact('order','subscriptionDuration','price','old_subscription','sub_plan','plan_price'));
    }

    //
    function redirect(Request $request)
    {
                $order = SupplierPlanOrder::findOrFail($request->order_id);
    
        $old_subscription = SupplierPlanSubscription::where('supplier_id', $order->supplier_id)->first();
        if (!$old_subscription) {
            return back()->with('error', 'الاشتراك القديم غير موجود.');
        }
    
        $rest_days = $old_subscription->duration - appDiffInDays(now(), $old_subscription->subscription_start_date);
    
        $subscription_rest = get_rest_off_current_supplier_plan(
            $old_subscription->supplier_id,
            $old_subscription->plan_id,
            $order->plan_id,
            $rest_days
        );

            //$total = $order->price - $subscription_rest;
            $total=$order->price;
        
    
        // ✅ في حال كان هناك رصيد زائد يجب شحنه
        if ($total < 0 && $order->status != 'approved') {
            try {
                DB::beginTransaction();
        
                $user = auth()->user();
                
                $exists = BalanceTransaction::where('user_id', $user->id)
                    ->where('amount', abs($total))
                    ->where('description', 'تمت الموافقة على الطلب وتم شحن الرصيد.')
                    ->exists();

                if ($total < 0 && !$exists && $order->status != 'approved') {
                // تأكد من أن رصيد المستخدم موجود أو أنشئه
                if (!$user->balance) {
                    $user->balance()->create(['amount' => abs($total)]);
                } else {
                    $user->balance->balance += abs($total);
                    $user->balance->save();
                }
        
                // سجل المعاملة مرة واحدة فقط
                BalanceTransaction::create([
                    'user_id' => $user->id,
                    'transaction_type' => 'addition',
                    'amount' => abs($total),
                    'description' => 'تمت الموافقة على الطلب وتم شحن الرصيد.',
                    'payment_method' => 'نظام المنصة',
                ]);
                }
        
                // تحديث حالة الطلب
                $order->update([
                    'payment_status' => 'paid',
                    'status' => 'approved',
                    'payment_method' => $request->paymentMethod,
                ]);
        
                // تحديث الاشتراك
                $subscription = SupplierPlanSubscription::firstOrNew(['supplier_id' => $order->supplier_id]);
                $subscription->fill([
                    'plan_id' => $order->plan_id,
                    'duration' => $order->duration,
                    'price' => abs($order->price),
                    'discount' => $order->discount,
                    'payment_method' => $request->paymentMethod,
                    'change_subscription' => true,
                    'subscription_start_date' => now(),
                    'subscription_end_date' => now()->addDays($order->duration),
                ])->save();
        
                DB::commit();
        
                $plans = SupplierPlan::all();
                return view('users.suppliers.subscription.index', compact('plans'));
        
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('error', 'حدث خطأ أثناء معالجة العملية: ' . $e->getMessage());
            }
        }        
    
        // ✅ التوجيه لصفحة الدفع المناسبة
        $viewBase = 'users.suppliers.payments';
    
        return match ($request->paymentMethod) {
            'Chargily' => view("$viewBase.cib.subscribtion.index", compact('order', 'old_subscription', 'rest_days')),
            'baridimob' => view("$viewBase.baridimob.subscribtion.index", compact('order', 'old_subscription', 'rest_days')),
            'wallet' => view("$viewBase.wallet.subscribtion.index", compact('order', 'old_subscription', 'rest_days')),
            default => view("$viewBase.ccp.subscribtion.index", compact('order', 'old_subscription', 'rest_days')),
        };
    }
    
    //
    public function baridimob(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:supplier_plan_orders,id',
            'payment_method' => 'required|in:baridimob',
            'payment_proof' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);
   
        $order = SupplierPlanOrder::findOrFail($request->order_id);

        if ($order->payment_status === 'paid') {
            return back()->with('success', 'تم الدفع مسبقاً لهذا الاشتراك.');
        }
    
        // تخزين الإثبات
        $proofPath = $request->file('payment_proof')->store('supplier/'.get_supplier_store_name(auth()->user()->tenant_id).'/subscription_payment_proofs', 'public');
    
        // إنشاء سجل الدفع
        $order->payment_proof = $proofPath;
        $order->payment_method = $request->payment_method;
        $order->save();
    
        return redirect()->route('supplier.subscription')->with('success', 'تم إرسال إيصال الدفع بنجاح، وسيتم مراجعته قريباً.');
        // return back()->with('success', 'تم إرسال إيصال الدفع بنجاح، وسيتم مراجعته قريباً.');
    }
    //
    public function new_subscription_by_baridimob(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:supplier_plans,id',
            'payment_method' => 'required|in:baridimob',
            'payment_proof' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);
   
        $order = new (SupplierPlanOrder::class);
        $order->plan_id = $request->plan_id;
        $order->supplier_id=get_supplier_data(auth()->user()->tenant_id)->id;
        $paln=SupplierPlan::where('id',$request->plan_id)->first();
        if($request->sub_plan_id==0 || $request->sub_plan_id==null)
        {
            $duration =30;
            $order->price =$paln->price;
        }else
        {
            $sub_plan=SupplierPlanPrices::where('id',$request->sub_plan_id)->first();
            $duration = $sub_plan->duration;
            $order->price =$sub_plan->price;
        }
        $order->duration=$duration;
        $order->discount = '0';
        $order->payment_status = 'unpaid';
        $order->status = 'pending';
        // تخزين الإثبات
        $proofPath = $request->file('payment_proof')->store('supplier/'.get_supplier_store_name(auth()->user()->tenant_id).'/subscription_payment_proofs', 'public');
    
        // إنشاء سجل الدفع
        $order->payment_proof = $proofPath;
        $order->payment_method = $request->payment_method;
        $order->start_date=now();
        $order->end_date=now()->addDays($duration);
        $order->save();
        //change subscription plan status
        $subscription=get_supplier_data(auth()->user()->tenant_id)->plan_subscription;
        $subscription->plan_id=1;
        $subscription->status='free';
        $subscription->save();
        //
        return redirect()->route('supplier.subscription')->with('success', 'تم إرسال إيصال الدفع بنجاح، وسيتم مراجعته قريباً.');
        // return back()->with('success', 'تم إرسال إيصال الدفع بنجاح، وسيتم مراجعته قريباً.');
    }
        //
        public function ccp(Request $request)
        {
            $request->validate([
                'order_id' => 'required|exists:supplier_plan_orders,id',
                'payment_method' => 'required|in:ccp',
                'payment_proof' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            ]);
        
            $order = SupplierPlanOrder::findOrFail($request->order_id);
        
            if ($order->payment_status === 'paid') {
                return back()->with('success', 'تم الدفع مسبقاً لهذا الاشتراك.');
            }
        
            // تخزين الإثبات
            $proofPath = $request->file('payment_proof')->store('supplier/'.get_supplier_store_name(auth()->user()->tenant_id).'/subscription_payment_proofs', 'public');
        
            // إنشاء سجل الدفع
            $order->payment_proof = $proofPath;
            $order->payment_method = $request->payment_method;
            $order->save();
        
            return redirect()->route('supplier.subscription')->with('success', 'تم إرسال إيصال الدفع بنجاح، وسيتم مراجعته قريباً.');
            // return back()->with('success', 'تم إرسال إيصال الدفع بنجاح، وسيتم مراجعته قريباً.');
        }
        //
        public function wallet(Request $request)
        {
            $request->validate([
                'order_id' => 'required|exists:supplier_plan_orders,id',
                'payment_method' => 'required|in:wallet',
                // 'payment_proof' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            ]);
        
            $order = SupplierPlanOrder::findOrFail($request->order_id);
        
            if ($order->payment_status === 'paid') {
                return back()->with('success', 'تم الدفع مسبقاً لهذا الاشتراك.');
            }

            //حساب مستحقات الإشتراك
            if ($request->old_subscription_plan_id == 1 && in_array($request->plan_id, [2, 3]))
            {
                $price=$order->price;
            }
            else
            {
                 $price=get_rest_off_current_supplier_plan($request->supplier_id, $request->old_subscription_plan_id, $request->plan_id, $request->rest_days) ;
            }
            //خصم المبلغ من الرصيد
            $balance=UserBalance::where('user_id',auth()->user()->id)->first();
            $balance->balance -= $price;
            $balance->save();
            //تسجيل هذا الخصم في سجل الرصيد
            $balance_transaction = new BalanceTransaction();
            $balance_transaction->user_id = $balance->user_id;
            $balance_transaction->amount = $price;
            $balance_transaction->transaction_type = 'deduction';
            $balance_transaction->description = 'دفع ثمن ترقية الإشتراك';
            $balance_transaction->payment_method = 'wallet';
            $balance_transaction->save();
            //
            $order->status='approved';
            $order->payment_status = 'paid';
            $order->payment_method = 'wallet';
            $order->save();
            //update supplier plan subscription
            $supplier_plan_subscription = SupplierPlanSubscription::where('supplier_id', $order->supplier_id)->first();
            $supplier_plan_subscription->plan_id = $order->plan_id;
            $supplier_plan_subscription->duration = $order->duration;
            $supplier_plan_subscription->price = $price;
            $supplier_plan_subscription->subscription_start_date = now();
            $supplier_plan_subscription->subscription_end_date = now()->addDays($order->duration);
            $supplier_plan_subscription->save();
        
            return redirect()->route('supplier.subscription')->with('success', 'تم ترقية الإشتراك بنجاح.');
            // return back()->with('success', 'تم إرسال إيصال الدفع بنجاح، وسيتم مراجعته قريباً.');
        }
            //
    public function new_subscription_by_ccp(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:supplier_plans,id',
            'payment_method' => 'required|in:ccp',
            'payment_proof' => 'required|file|mimes:jpeg,png,pdf|max:2048',
        ]);
   
        $order = new (SupplierPlanOrder::class);
        $order->plan_id = $request->plan_id;
        $order->supplier_id=get_supplier_data(auth()->user()->tenant_id)->id;
        $paln=SupplierPlan::where('id',$request->plan_id)->first();
        if($request->sub_plan_id==0 || $request->sub_plan_id==null)
        {
            $duration =30;
            $order->price =$paln->price;
        }else
        {
            $sub_plan=SupplierPlanPrices::where('id',$request->sub_plan_id)->first();
            $duration = $sub_plan->duration;
            $order->price =$sub_plan->price;
        }
        $order->duration=$duration;
        $order->discount = '0';
        $order->payment_status = 'unpaid';
        $order->status = 'pending';
        // تخزين الإثبات
        $proofPath = $request->file('payment_proof')->store('supplier/'.get_supplier_store_name(auth()->user()->tenant_id).'/subscription_payment_proofs', 'public');
    
        // إنشاء سجل الدفع
        $order->payment_proof = $proofPath;
        $order->payment_method = $request->payment_method;
        $order->start_date=now();
        $order->end_date=now()->addDays($duration);
        $order->save();
        //change subscription plan status
        $subscription=get_supplier_data(auth()->user()->tenant_id)->plan_subscription;
        $subscription->plan_id=1;
        $subscription->status='free';
        $subscription->save();
        //
        return redirect()->route('supplier.subscription')->with('success', 'تم إرسال إيصال الدفع بنجاح، وسيتم مراجعته قريباً.');
        // return back()->with('success', 'تم إرسال إيصال الدفع بنجاح، وسيتم مراجعته قريباً.');
    }

}
