<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\BalanceTransaction;
use Illuminate\Http\Request;

class SellerWalletController extends Controller
{
    public function index()
    {
        $current_balance = auth()->user()->balance->balance; // أو طريقة حساب أخرى
        $pending_balance = BalanceTransaction::where('user_id', auth()->id())
                                ->where('transaction_type', 'addition')
                                ->where('status', 'pending')
                                ->sum('amount');
        $additions = BalanceTransaction::where('user_id', auth()->user()->id)->where('transaction_type', 'addition')->where('status', '!=', 'null')->get();

        return view('users.sellers.payments.wallet.charge.index', compact('additions', 'current_balance', 'pending_balance'));
    }

    public function showAddition($id)
    {
        $addition = BalanceTransaction::where('user_id', auth()->user()->id)->where('transaction_type', 'addition')->findOrFail($id);

        return response()->json([
            'id' => $addition->id,
            'amount' => number_format($addition->amount, 2, ',', '.'),
            'payment_method' => $addition->payment_method,
            'description' => $addition->description ?? '---',
            'created_at' => $addition->created_at->format('Y-m-d H:i'),
        ]);
    }

    public function payWithBaridiMob(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50',
            'description' => 'nullable|string|max:500',
            'payment_proof' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048', // max 2MB
        ]);

        try {
            // رفع ملف إثبات الدفع
            $proofPath = $request->file('payment_proof')->store('seller/'.get_seller_store_name(auth()->user()->tenant_id).'/wallet_proofs', 'public');

            // إنشاء سجل في قاعدة البيانات
            BalanceTransaction::create([
                'user_id' => auth()->id(),
                'amount' => $request->amount,
                'payment_method' => 'BaridiMob',
                'description' => 'الرصيد قيد المعالجة',
                'payment_proof' => $proofPath,
                'status' => 'pending', // قيد المراجعة
            ]);

            return redirect()->back()->with('success', 'تم إرسال طلب شحن الرصيد عبر بريدي موب بنجاح، وسيتم مراجعته في أقرب وقت.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء معالجة الطلب: '.$e->getMessage());
        }
    }

    public function payWithCcp(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:50',
            'description' => 'nullable|string|max:500',
            'payment_proof' => 'required|file|mimes:jpeg,png,jpg,pdf|max:2048', // max 2MB
        ]);

        try {
            // رفع ملف إثبات الدفع
            $proofPath = $request->file('payment_proof')->store('seller/'.get_seller_store_name(auth()->user()->tenant_id).'/wallet_proofs', 'public');

            // إنشاء سجل في قاعدة البيانات
            BalanceTransaction::create([
                'user_id' => auth()->id(),
                'amount' => $request->amount,
                'payment_method' => 'Ccp',
                'description' => 'الرصيد قيد المعالجة',
                'payment_proof' => $proofPath,
                'status' => 'pending', // قيد المراجعة
            ]);

            return redirect()->back()->with('success', 'تم إرسال طلب شحن الرصيد عبر بريدي الجزائر (CCP) بنجاح، وسيتم مراجعته في أقرب وقت.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء معالجة الطلب: '.$e->getMessage());
        }
    }
}
