<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Models\UserInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\BalanceTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class SupplierBillingController extends Controller
{
    //
    public function index()
    {
        dd(get_user_data_from_id(auth()->user()->id)->balance->outstanding_amount);
        $invoices = UserInvoice::all();
        return view('users.suppliers.billing.index',compact('invoices'));
    }
    //create invoice
    public function create()
    {
        // جلب المعاملات غير المفوترة
        $billings = BalanceTransaction::where('user_id', auth()->id())
            ->where('transaction_type', 'deduction')
            ->where('invoiced', 0)
            ->get();
    
        // if ($billings->isEmpty()) {
        //     return redirect()->back()->with('error', 'تم تسديد جميع فواتيرك لاتوجد فواتير جديدة');
        //     // return response()->json(['message' => 'لا توجد عمليات غير مفوترة'], 404);
        // }

        $totalAmount = $billings->sum('amount');

        // ✅ التحقق من أن إجمالي المعاملات يفوق 50 د.ج
        if ($totalAmount < 50) {
            return redirect()->back()->with('error', 'يجب أن تتجاوز قيمة الفاتورة 50 د.ج لإنشائها');
        }
    
        DB::beginTransaction();
    
        try {
            // إنشاء الفاتورة
            $invoice = UserInvoice::create([
                'user_id'      => auth()->id(),
                'invoice_number'=> 'INV-' . time(),
                'amount' => $billings->sum('amount'),
                'status'       => 'pending',
                'due_date'     => Carbon::now()->addDays(7), // مهلة السداد أسبوع
            ]);
    
            // إدخال تفاصيل الفاتورة وربطها بالفاتورة
            foreach ($billings as $billing) {
                $invoice->details()->create([
                    'item_name'  => $billing->description,
                    'quantity'   => 1,
                    'unit_price' => $billing->amount,
                    'total'      => $billing->amount,
                ]);
    
                // تحديث حالة المعاملة إلى "مفوتر"
                $billing->update([
                    'invoiced' => true,
                ]);
            }
    
            DB::commit();
            return redirect()->back()->with('success','تم إنشاء الفاتورة بنجاح');
            // return response()->json(['message' => 'تم إنشاء الفاتورة بنجاح', 'invoice_id' => $invoice->id]);
    
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('خطأ أثناء إنشاء الفاتورة: ' . $e->getMessage());
            
            return redirect()->back()->with('error','حدث خطاء اثناء انشاء الفاتورة');
            // return response()->json(['message' => 'حدث خطأ أثناء إنشاء الفاتورة'], 500);
        }
    }
    //show invoice
    public function show($id)
    {
        $invoice = UserInvoice::with('details')->findOrFail($id);

        return response()->json([
            'invoice_number' => $invoice->invoice_number,
            'invoice_date'   => $invoice->created_at->format('Y-m-d'),
            'total_amount'   => $invoice->amount,
            'status'         => $invoice->status,
            'payment_method' => $invoice->payment_method,
            'details'        => $invoice->details->map(function($detail) {
                return [
                    'item_name'  => $detail->item_name,
                    'quantity'   => $detail->quantity,
                    'unit_price' => $detail->unit_price,
                ];
            }),
        ]);
    }
    //pay invoice
    public function invoice_redirect(Request $request,$invoiceId)
    {
        // dd($request,$invoiceId); 
        $invoice=UserInvoice::findOrfail($invoiceId);
            //if payment method is wallet
            if ($request->payment_method == 'wallet') 
            {
                return view('users.suppliers.payments.wallet.invoice.index',compact('invoice'));
            }
            //if payment method is credit-card
            elseif($request->payment_method == 'credit-card')
            {
                return view('users.suppliers.payments.cib.invoice.index',compact('invoice'));
            }
            //if payment method is baridi-mob
            elseif($request->payment_method == 'baridi-mob')
            {
                return view('users.suppliers.payments.baridimob.invoice.index',compact('invoice'));
            }
            //if payment method is ccp
            else
            {
                return view('users.suppliers.payments.ccp.invoice.index',compact('invoice'));
            }

    }
    //
    public function pay_invoice(Request $request)
    {
        //dd($request);
        $invoice=UserInvoice::findOrfail($request->invoice_id);
        if($request->payment_method == 'wallet')
        {
            if(auth()->user()->balance->balance < auth()->user()->balance->outstanding_amount)
            {
                return redirect()->back()->with('error','رصيدك غير كافي');
            }else
            {
                auth()->user()->balance()->update([
                    'balance' => auth()->user()->balance->balance - $invoice->amount,
                    'outstanding_amount' =>auth()->user()->balance->outstanding_amount - $invoice->amount,
                ]);
                $invoice->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                    'payment_method' => $request->payment_method
                ]);
                return redirect()->route('supplier.billing')->with('paid','تم الدفع المبلغ من رصيدك في المنصة بنجاح');
            }
        }
        else
        {
            $validator = Validator::make($request->all(), [
                'invoice_id' => 'required|exists:user_invoices,id',
                'payment_proof' => 'required|mimetypes:application/pdf,image/jpeg,image/png|max:2048',
            ]);
        
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
        
            // $invoice = UserInvoice::findOrFail($request->invoice_id);
            // التحقق من عدم وجود ملف مسبق بنفس الاسم في المجلد
            if (Storage::disk('public')->exists('payment_proofs/'.$invoice->invoice_number)) {
                return redirect()->route('supplier.billing')->with('error', 'يوجد ملف إثبات دفع بنفس الاسم تم رفعه سابقاً.');
            }
            // حفظ الملف داخل مجلد secure
            $proofPath = $request->file('payment_proof')->store('payment_proofs/'.$invoice->invoice_number, 'public');
        
            // تحديث حالة الفاتورة
            $invoice->update([
                'status' => 'under_review',
                'payment_method' => 'baridimob',
                'payment_proof' => $proofPath, // يجب أن تضيف هذا العمود في جدول الفواتير إن لم يكن موجوداً
            ]);
        
            return redirect()->route('supplier.billing')->with('success', 'تم إرسال إيصال الدفع بنجاح، وسيتم مراجعته قريباً.');
        }
        return redirect()->back();
    }
    //
    public function deleteProof(UserInvoice $invoice)
    {
        $folderPath = 'payment_proofs/' . $invoice->invoice_number;
        if($invoice->status !='paid')
        {
            if ($invoice->payment_proof && Storage::disk('public')->exists($invoice->payment_proof)) {
                // حذف المجلد كاملاً (بما فيه إثبات الدفع)
                Storage::disk('public')->deleteDirectory($folderPath);

                // تحديث بيانات الفاتورة
                $invoice->update([
                    'payment_proof' => null,
                    'payment_method' => null,
                    'status' => 'pending', // أو 'pending'
                ]);

                return redirect()->route('supplier.billing')->with('success', 'تم حذف مجلد إيصال الدفع بنجاح.');
            }
        }

        return redirect()->route('supplier.billing')->with('error', 'لم يتم العثور على ملف إثبات الدفع.');
    }



}
