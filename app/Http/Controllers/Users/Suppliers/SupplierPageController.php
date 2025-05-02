<?php

namespace App\Http\Controllers\Users\Suppliers;

use App\Models\SupplierPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SupplierPageController extends Controller
{
    //
    public function update(Request $request, $id)
    {
        $page = SupplierPage::findOrFail($id);

        // التحقق من أن الصفحة تعود لتاجر الدخول الحالي (حماية)
        if ($page->supplier_id !== get_supplier_data(auth()->user()->tenant_id)->id) {
            abort(403, 'غير مصرح لك بتعديل هذه الصفحة.');
        }

        // التحقق من البيانات
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            // 'slug' => 'required|string|max:255|unique:supplier_pages,slug,' . $page->id,
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
