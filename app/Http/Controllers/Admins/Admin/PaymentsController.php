<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Models\UserBalance;
use App\Models\UserInvoice;
use Illuminate\Http\Request;
use App\Models\BalanceTransaction;
use App\Http\Controllers\Controller;

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
