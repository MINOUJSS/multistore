<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Seller\SellerPage;
use Illuminate\Http\Request;

class SellerPageController extends Controller
{
    public function update(Request $request, $id)
    {
        $page = SellerPage::findOrFail($id);

        // التحقق من أن الصفحة تعود لتاجر الدخول الحالي (حماية)
        if ($page->seller_id !== get_seller_data(auth()->user()->tenant_id)->id) {
            abort(403, 'غير مصرح لك بتعديل هذه الصفحة.');
        }

        // التحقق من البيانات
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            // 'slug' => 'required|string|max:255|unique:seller_pages,slug,' . $page->id,
            'content' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string|max:255',
            'status' => 'required|in:published,draft',
        ]);

        // تحديث البيانات
        $page->update($validated);

        return redirect()->back()->with('success', 'تم تحديث الصفحة بنجاح.');
    }
}
