<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Seller\SellerFqa;
use App\Models\UserStoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SellerFqsController extends Controller
{
    public function index()
    {
        // Get the authenticated seller's ID
        $sellerId = get_seller_data(auth()->user()->tenant_id)->id;

        // Get all FAQs for this seller, ordered by 'order' then by creation date
        $faqs = SellerFqa::where('seller_id', $sellerId)
            ->orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();

        $faqs_status = UserStoreSetting::where('user_id', auth()->user()->id)->where('key', 'store_section_faqs_visibility')->first();

        return view('users.sellers.pages.sections.fqs.index', compact('faqs', 'faqs_status'));
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
            $faq = SellerFqa::create([
                'seller_id' => get_seller_data(auth()->user()->tenant_id)->id,
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
        $sellerFqa = SellerFqa::findOrfail($id);
        if ($sellerFqa->seller_id != get_seller_data(auth()->user()->tenant_id)->id) {
            abort(403, 'Unauthorized action.');
        }

        return response()->json($sellerFqa);
    }

    public function update(Request $request, $id)
    {
        $sellerFqa = SellerFqa::findOrfail($id);
        if ($SellerFqa->Seller_id != get_Seller_data(auth()->user()->tenant_id)->id) {
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
            $SellerFqa->update([
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
        $SellerFqa = SellerFqa::findOrfail($id);
        if ($sellerFqa->seller_id != get_seller_data(auth()->user()->tenant_id)->id) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $sellerFqa->delete();

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
