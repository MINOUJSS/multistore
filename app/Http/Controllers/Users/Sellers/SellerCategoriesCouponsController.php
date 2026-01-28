<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\UserCategoriesCoupons;
use App\Models\userCoupons;
use Illuminate\Http\Request;

class SellerCategoriesCouponsController extends Controller
{
    /**
     * عرض نموذج ربط كوبون بقسم.
     */
    public function index()
    {
        $coupons = userCoupons::where('is_active', true)->get();
        $categories = Category::all();
        $linkedCategories = UserCategoriesCoupons::with(['coupon', 'category'])->latest()->get();

        return view('users.sellers.coupons.categories-coupons.index', compact('coupons', 'categories', 'linkedCategories'));
    }

    /**
     * حفظ الربط بين الكوبون والقسم.
     */
    public function store(Request $request)
    {
        $request->validate([
            'coupon_id' => 'required|exists:user_coupons,id',
            'category_id' => 'required|exists:categories,id',
        ]);

        // منع التكرار
        $exists = UserCategoriesCoupons::where('coupon_id', $request->coupon_id)
            ->where('category_id', $request->category_id)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('warning', '⚠️ هذا القسم مرتبط بالفعل بهذا الكوبون.');
        }

        // إنشاء الربط
        UserCategoriesCoupons::create([
            'coupon_id' => $request->coupon_id,
            'category_id' => $request->category_id,
        ]);

        return redirect()->back()->with('success', '✅ تم ربط الكوبون بالقسم بنجاح.');
    }

    /**
     * حذف الربط بين الكوبون والقسم.
     */
    public function destroy($id)
    {
        $link = UserCategoriesCoupons::findOrFail($id);
        $link->delete();

        return redirect()->back()->with('success', '🗑️ تم حذف الربط بنجاح.');
    }
}
