<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Models\UserBalance;
use App\Models\UserInvoice;
use Illuminate\Http\Request;
use App\Models\Supplier\SupplierPlanOrder;
use App\Models\BalanceTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Supplier\SupplierPlanSubscription;

class PaymentsController extends Controller
{
    //
    public function recharge_requests()
    {
        $requests = BalanceTransaction::with('user')
                    ->whereIn('payment_method', ['baridimob', 'ccp'])
                    ->where('status','pending')
                    ->orderByDesc('created_at')
                    ->get();
        return view('admins.admin.payments.recharge_requests.index',compact('requests'));
    }
    //
    public function invoices_payments()
    {
        $invoices = UserInvoice::with('user')
        ->whereIn('payment_method', ['baridi-mob', 'ccp'])
        ->where('status','under_review')
        ->orderByDesc('created_at')
        ->get();
        return view('admins.admin.payments.invoices_payments.index',compact('invoices'));  
    }
     //
     public function subscribes_payments()
     {
         return view('admins.admin.payments.subscribes_payments.index');  
     }
     //
     public function suppliers_subscribes_payments()
     {
         $subscriptionRequests = SupplierPlanOrder::orderByDesc('created_at')
         ->where('status','pending')
         ->get();
         return view('admins.admin.payments.subscribes_payments.suppliers.index',compact('subscriptionRequests'));  
     }
     //
     public function approve_suppliers_subscribe_payment($id)
     {
         try {
             DB::beginTransaction();
     
             // الموافقة على الطلب
             $request = SupplierPlanOrder::findOrFail($id);
             $request->status = 'approved';
             $request->payment_status = 'paid';
             $request->save();
     
             // ترقية أو إنشاء اشتراك المورد
             $supplier_subscription = SupplierPlanSubscription::firstOrNew([
                 'supplier_id' => $request->supplier_id
             ]);

             // تفعيل الاشتراك
             $supplier_subscription->supplier_id = $request->supplier_id;

             $supplier_subscription->plan_id = $request->plan_id;
             $supplier_subscription->duration = $request->duration;
             $supplier_subscription->price = $request->price;
             $supplier_subscription->discount = $request->discount;
             $supplier_subscription->payment_method = $request->payment_method;
             $supplier_subscription->payment_status = 'paid';
             $supplier_subscription->subscription_start_date = now();
             $supplier_subscription->subscription_end_date = now()->addDays($request->duration);
             $supplier_subscription->status = 'paid';
             $supplier_subscription->change_subscription = true;
             $supplier_subscription->save();

             //حساب قيمة الاشتراك بعد خصم باقي الإشتراك القديم و شحن الباقي في المحفظة

     
             DB::commit(); // تأكيد كل العمليات
     
             return back()->with('success', 'تمت الموافقة على الطلب وتم تفعيل الاشتراك.');
     
         } catch (\Exception $e) {
             DB::rollBack(); // التراجع عن جميع العمليات
     
             // يُفضل تسجيل الخطأ في سجل الأخطاء أو إرسال إشعار للإدارة
             return back()->with('error', 'حدث خطأ أثناء معالجة الطلب: ' . $e->getMessage());
         }
     }
    //
    public function approve_recharge($id)
    {
        $request = BalanceTransaction::findOrFail($id);

        if ($request->status !== 'pending') {
            return back()->with('error', 'تمت معالجة هذا الطلب مسبقًا.');
        }

        // تحديث الحالة وزيادة الرصيد
        $request->status = 'approved';
        $request->save();

        // $user = $request->user;
        $user = \App\Models\User::find($request->user_id);
        $balance = $user->balance;
        $balance->balance += $request->amount;
        $request->description='تمت الموافقة على الطلب وتم شحن الرصيد.';
        $request->update();
        $balance->save();
        

        return back()->with('success', 'تمت الموافقة على الطلب وتم شحن الرصيد.');
    }
    //
    public function approve_invoice_payment($id)
    {
        $invoice = UserInvoice::findOrFail($id);

        if ($invoice->status !== 'under_review') {
            return back()->with('error', 'تمت معالجة هذا الطلب مسبقًا.');
        }

        // تحديث حالة الرصيد
        $balance=UserBalance::findOrFail($invoice->user_id);
        $balance->balance=$balance->balance-$invoice->amount;
        $balance->outstanding_amount=$balance->outstanding_amount-$invoice->amount;
        $balance->update();
        // تحديث الحالة الفاتورة
        $invoice->status = 'paid';
        $invoice->save();

        // update invoice description;
        $invoice->description='تمت الموافقة على الطلب وتم تسديد الفاتورة .';
        $invoice->update();
        

        return back()->with('success', 'تمت الموافقة على الطلب وتم تسديد الفاتورة.');
    }

}
