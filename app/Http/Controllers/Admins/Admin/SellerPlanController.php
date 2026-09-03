<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller\SellerPlan;
use App\Models\Seller\SellerPlanPrices;
use App\Models\Seller\SellerPlanAuthorizations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SellerPlanController extends Controller
{
    /**
     * Display a listing of the seller plans.
     */
    public function index()
    {
        $plans = SellerPlan::withCount(['pricing', 'Authorizations', 'subscriptions'])
            ->orderBy('id', 'asc')
            ->get();

        $totalPlans = $plans->count();
        $totalSubscriptions = $plans->sum('subscriptions_count');
        $freePlansCount = $plans->where('price', '<=', 0)->count();
        $paidPlansCount = $plans->where('price', '>', 0)->count();

        return view('admins.admin.seller_plans.index', compact(
            'plans',
            'totalPlans',
            'totalSubscriptions',
            'freePlansCount',
            'paidPlansCount'
        ));
    }

    /**
     * Show the form for creating a new seller plan.
     */
    public function create()
    {
        return view('admins.admin.seller_plans.create');
    }

    /**
     * Store a newly created seller plan in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:191|unique:seller_plans,name',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'يرجى إدخال اسم الخطة.',
            'name.unique' => 'اسم هذه الخطة مسجل مسبقاً لدى خطة أخرى.',
            'price.required' => 'يرجى إدخال السعر الافتراضي للخطة.',
            'price.numeric' => 'يجب أن يكون السعر قيمة رقمية.',
        ]);

        $plan = SellerPlan::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.seller_plans.show', $plan->id)
            ->with('success', 'تم إنشاء خطة البائع بنجاح! يمكنك الآن إدارة فترات التسعير والصلاحيات الخاصة بها.');
    }

    /**
     * Display the specified seller plan with all pricing and authorizations.
     */
    public function show($id)
    {
        $plan = SellerPlan::with([
            'pricing' => function ($q) {
                $q->orderBy('duration', 'asc');
            },
            'Authorizations' => function ($q) {
                $q->orderBy('id', 'asc');
            },
            'subscriptions.Seller'
        ])->findOrFail($id);

        // Predefined common permissions presets for sellers / retailers
        $presets = [
            ['key' => 'store', 'label' => 'متجر إلكتروني إحترافي', 'default_value' => '1'],
            ['key' => 'free_sub_domane', 'label' => 'دومين فرعي مجاني', 'default_value' => '1'],
            ['key' => 'domane', 'label' => 'ربط دومين إحترافي خاص', 'default_value' => '1'],
            ['key' => 'max_products', 'label' => 'أقصى عدد منتجات مسموح به (أدخل رقماً أو 0 لغير محدود)', 'default_value' => '100'],
            ['key' => 'comission_for_orders', 'label' => 'إقتطاع على كل طلب (0 تعني بدون إقتطاع)', 'default_value' => '0'],
            ['key' => 'comission_for_orders_abandoned', 'label' => 'إقتطاع على كل طلب متروك', 'default_value' => '5'],
            ['key' => 'max_facebook_pixel', 'label' => 'عدد بيكسل فيسبوك المسموح به', 'default_value' => '2'],
            ['key' => 'max_tiktok_pixel', 'label' => 'عدد بيكسل تيكتوك المسموح به', 'default_value' => '1'],
            ['key' => 'max_google_analytics', 'label' => 'ربط جوجل أناليتيكس', 'default_value' => '1'],
            ['key' => 'max_microsoft_clarity', 'label' => 'ربط ميكروسوفت كلاريتي', 'default_value' => '1'],
            ['key' => 'google_sheet', 'label' => 'مزامنة جوجل شيت (Google Sheets)', 'default_value' => '1'],
            ['key' => 'max_telegram_notification', 'label' => 'إشعارات الطلبات الفورية على تليجرام', 'default_value' => '1'],
            ['key' => 'chargily_pay', 'label' => 'ميزة بوابة الدفع الإلكتروني (Chargily Pay)', 'default_value' => '1'],
            ['key' => 'bank_transfer', 'label' => 'ميزة الدفع عبر التحويل البنكي / بريدي موب', 'default_value' => '1'],
            ['key' => 'copy_right', 'label' => 'إزالة حقوق المنصة من أسفل المتجر', 'default_value' => '1'],
        ];

        return view('admins.admin.seller_plans.show', compact('plan', 'presets'));
    }

    /**
     * Show the form for editing the specified seller plan.
     */
    public function edit($id)
    {
        $plan = SellerPlan::findOrFail($id);
        return view('admins.admin.seller_plans.edit', compact('plan'));
    }

    /**
     * Update the specified seller plan in storage.
     */
    public function update(Request $request, $id)
    {
        $plan = SellerPlan::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:191|unique:seller_plans,name,' . $id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ], [
            'name.required' => 'يرجى إدخال اسم الخطة.',
            'name.unique' => 'اسم هذه الخطة مسجل مسبقاً لدى خطة أخرى.',
            'price.required' => 'يرجى إدخال السعر الافتراضي للخطة.',
            'price.numeric' => 'يجب أن يكون السعر قيمة رقمية.',
        ]);

        $plan->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.seller_plans.show', $plan->id)
            ->with('success', 'تم تحديث بيانات خطة البائع بنجاح.');
    }

    /**
     * Remove the specified seller plan from storage.
     */
    public function destroy($id)
    {
        $plan = SellerPlan::findOrFail($id);

        if ($plan->subscriptions()->count() > 0) {
            return redirect()->back()->with('error', 'لا يمكن حذف هذه الخطة لوجود ' . $plan->subscriptions()->count() . ' اشتراك(ات) تجار مرتبطين بها حالياً.');
        }

        $plan->delete();

        return redirect()->route('admin.seller_plans.index')
            ->with('success', 'تم حذف الخطة وجميع الأسعار والصلاحيات التابعة لها بنجاح.');
    }

    // ==========================================
    // PRICING TIERS MANAGEMENT
    // ==========================================

    /**
     * Store a pricing tier for the seller plan.
     */
    public function storePrice(Request $request, $planId)
    {
        $plan = SellerPlan::findOrFail($planId);

        $request->validate([
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
        ], [
            'duration.required' => 'يرجى تحديد المدة بالأيام.',
            'duration.integer' => 'يجب أن تكون المدة عدداً صحيحاً من الأيام.',
            'price.required' => 'يرجى إدخال سعر هذه المدة.',
            'price.numeric' => 'يجب أن يكون السعر قيمة رقمية.',
        ]);

        $exists = SellerPlanPrices::where('plan_id', $planId)
            ->where('duration', $request->duration)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'توجد فترة تسعير مسجلة مسبقاً بنفس عدد الأيام (' . $request->duration . ' يوم) لهذه الخطة.');
        }

        SellerPlanPrices::create([
            'plan_id' => $planId,
            'duration' => $request->duration,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
        ]);

        return redirect()->back()->with('success', 'تمت إضافة فترة التسعير بنجاح.');
    }

    /**
     * Update a pricing tier.
     */
    public function updatePrice(Request $request, $priceId)
    {
        $priceTier = SellerPlanPrices::findOrFail($priceId);

        $request->validate([
            'duration' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'discount' => 'nullable|numeric|min:0',
        ], [
            'duration.required' => 'يرجى تحديد المدة بالأيام.',
            'price.required' => 'يرجى إدخال السعر.',
        ]);

        $duplicate = SellerPlanPrices::where('plan_id', $priceTier->plan_id)
            ->where('duration', $request->duration)
            ->where('id', '!=', $priceId)
            ->exists();

        if ($duplicate) {
            return redirect()->back()->with('error', 'توجد فترة تسعير أخرى مسجلة بنفس عدد الأيام لهذه الخطة.');
        }

        $priceTier->update([
            'duration' => $request->duration,
            'price' => $request->price,
            'discount' => $request->discount ?? 0,
        ]);

        return redirect()->back()->with('success', 'تم تحديث فترة التسعير بنجاح.');
    }

    /**
     * Delete a pricing tier.
     */
    public function destroyPrice($priceId)
    {
        $priceTier = SellerPlanPrices::findOrFail($priceId);
        $priceTier->delete();

        return redirect()->back()->with('success', 'تم حذف فترة التسعير بنجاح.');
    }

    // ==========================================
    // AUTHORIZATIONS / PERMISSIONS MANAGEMENT
    // ==========================================

    /**
     * Store a new authorization/permission for the seller plan.
     */
    public function storeAuthorization(Request $request, $planId)
    {
        $plan = SellerPlan::findOrFail($planId);

        $request->validate([
            'permission_key' => 'required|string|max:191',
            'permission_value' => 'nullable|string|max:191',
            'description' => 'required|string|max:500',
        ], [
            'permission_key.required' => 'يرجى تحديد مفتاح الصلاحية.',
            'description.required' => 'يرجى إدخال وصف الصلاحية الظاهر للبائع.',
        ]);

        $exists = SellerPlanAuthorizations::where('plan_id', $planId)
            ->where('permission_key', $request->permission_key)
            ->exists();

        if ($exists) {
            return redirect()->back()->with('error', 'مفتاح الصلاحية [' . $request->permission_key . '] مسجل مسبقاً في هذه الخطة.');
        }

        SellerPlanAuthorizations::create([
            'plan_id' => $planId,
            'permission_key' => $request->permission_key,
            'permission_value' => $request->permission_value ?? '1',
            'description' => $request->description,
            'is_enabled' => $request->has('is_enabled') ? true : false,
        ]);

        return redirect()->back()->with('success', 'تمت إضافة الصلاحية إلى الخطة بنجاح.');
    }

    /**
     * Update an authorization/permission.
     */
    public function updateAuthorization(Request $request, $authId)
    {
        $authorization = SellerPlanAuthorizations::findOrFail($authId);

        $request->validate([
            'permission_key' => 'required|string|max:191',
            'permission_value' => 'nullable|string|max:191',
            'description' => 'required|string|max:500',
        ], [
            'permission_key.required' => 'يرجى تحديد مفتاح الصلاحية.',
            'description.required' => 'يرجى إدخال وصف الصلاحية.',
        ]);

        $duplicate = SellerPlanAuthorizations::where('plan_id', $authorization->plan_id)
            ->where('permission_key', $request->permission_key)
            ->where('id', '!=', $authId)
            ->exists();

        if ($duplicate) {
            return redirect()->back()->with('error', 'مفتاح الصلاحية [' . $request->permission_key . '] مستخدم مسبقاً في صلاحية أخرى لنفس الخطة.');
        }

        $authorization->update([
            'permission_key' => $request->permission_key,
            'permission_value' => $request->permission_value,
            'description' => $request->description,
            'is_enabled' => $request->has('is_enabled') ? true : false,
        ]);

        return redirect()->back()->with('success', 'تم تحديث بيانات الصلاحية بنجاح.');
    }

    /**
     * Toggle the enabled status of an authorization.
     */
    public function toggleAuthorization(Request $request, $authId)
    {
        $authorization = SellerPlanAuthorizations::findOrFail($authId);
        $authorization->is_enabled = !$authorization->is_enabled;
        $authorization->save();

        $statusText = $authorization->is_enabled ? 'مفعلة' : 'معطلة';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_enabled' => $authorization->is_enabled,
                'message' => 'تم تغيير حالة الصلاحية إلى (' . $statusText . ') بنجاح.',
            ]);
        }

        return redirect()->back()->with('success', 'تم تغيير حالة الصلاحية إلى (' . $statusText . ') بنجاح.');
    }

    /**
     * Delete an authorization from the seller plan.
     */
    public function destroyAuthorization($authId)
    {
        $authorization = SellerPlanAuthorizations::findOrFail($authId);
        $authorization->delete();

        return redirect()->back()->with('success', 'تم حذف الصلاحية من الخطة بنجاح.');
    }
}
