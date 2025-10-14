<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Models\Supplier\SupplierFqa;
use Illuminate\Http\Request;
use App\Models\UserStoreSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class SupplierFqsController extends Controller
{
    public function index()
    {
        // Get the authenticated supplier's ID
        $supplierId = get_supplier_data(auth()->user()->tenant_id)->id;

        // Get all FAQs for this supplier, ordered by 'order' then by creation date
        $faqs = SupplierFqa::where('supplier_id', $supplierId)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        //
        $faqs_status = UserStoreSetting::where('user_id', auth()->user()->id)->where('key', 'store_section_faqs_visibility')->first();

        return view('users.suppliers.pages.sections.fqs.index', compact('faqs', 'faqs_status'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ], [
            'question.required' => 'حقل السؤال مطلوب',
            'answer.required' => 'حقل الإجابة مطلوب',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $faq = SupplierFqa::create([
                'supplier_id' => get_supplier_data(auth()->user()->tenant_id)->id,
                'question' => $request->question,
                'answer' => $request->answer,
                'order' => $request->order ?? 0,
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم إضافة السؤال بنجاح',
                'data' => $faq,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: '.$e->getMessage(),
            ], 500);
        }
    }

    public function edit($id)
    {
        $supplierFqa = SupplierFqa::findOrfail($id);
        if ($supplierFqa->supplier_id != get_supplier_data(auth()->user()->tenant_id)->id) {
            abort(403, 'Unauthorized action.');
        }

        return response()->json($supplierFqa);
    }

    public function update(Request $request, $id)
    {
        $supplierFqa = SupplierFqa::findOrfail($id);
        if ($supplierFqa->supplier_id != get_supplier_data(auth()->user()->tenant_id)->id) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        try {
            $supplierFqa->update([
                'question' => $request->question,
                'answer' => $request->answer,
                'order' => $request->order ?? 0,
                'status' => $request->status,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'تم تحديث السؤال بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ: '.$e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $supplierFqa = SupplierFqa::findOrfail($id);
        if ($supplierFqa->supplier_id != get_supplier_data(auth()->user()->tenant_id)->id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $supplierFqa->delete();

            return response()->json([
                'success' => true,
                'message' => 'تم حذف السؤال بنجاح',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'حدث خطأ أثناء الحذف',
            ], 500);
        }
    }

    // updateStatus
    public function updateStatus(Request $request)
    {
        $faqs_status = UserStoreSetting::where('user_id', auth()->user()->id)->where('key', 'store_section_faqs_visibility')->first();
        if ($request->faqs_status == 'on') {
            $faqs_status->value = 'true';
        } else {
            $faqs_status->value = 'false';
        }
        $faqs_status->save();

        // return response()->json([
        //     'success' => true,
        //     'message' => 'تم تحديث حالة السلايدر بنجاح',
        // ]);
        return redirect()->back()->with('success', 'تم تحديث حالة الأسئلة الشائعة  بنجاح');
    }
}
