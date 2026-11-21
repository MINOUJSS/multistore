<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierOrders;
use App\Models\Supplier\SupplierProducts;
use App\Models\Supplier\SupplierPlan;
use App\Models\Supplier\SupplierPlanSubscription;
use App\Models\Tenant;
use App\Models\User;
use App\Models\UserRequestsValidation;
use App\Services\Admins\Admin\SupplierStoreResetService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class SupplierController extends Controller
{
    // index
    public function index(Request $request)
    {
        $query = Supplier::with(['user.balance', 'tenant.domains', 'plan_subscription']);

        // Full-table search: name, phone, store name, email
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('store_name', 'like', "%{$search}%")
                  ->orWhere('tenant_id', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($u) use ($search) {
                      $u->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $suppliers = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        // 1. Supplier Accounts Stats
        $totalSuppliers = Supplier::count();
        $approvedSuppliers = Supplier::where('approval_status', 'approved')->count();
        $pendingSuppliers = Supplier::where('approval_status', 'pending')->count();
        $inactiveSuppliers = Supplier::where('status', 'inactive')->count();

        // 2. Activity Stats via last_seens (last 30 days)
        $activeDays = 30;
        $activeThreshold = now()->subDays($activeDays);
        $activeSuppliersCount = Supplier::whereHas('user.last_seen', function ($q) use ($activeThreshold) {
            $q->where('last_seen_at', '>=', $activeThreshold);
        })->count();
        $activityPercentage = $totalSuppliers > 0 ? round(($activeSuppliersCount / $totalSuppliers) * 100, 1) : 0;
        $inactiveActivityCount = max(0, $totalSuppliers - $activeSuppliersCount);

        // 3. Products Stats (Excluding default/dummy demo products)
        $excludedDummyProducts = [
            'منتج 1', 'منتج 2', 'منتج 3', 'منتج 4',
            'منتج1', 'منتج2', 'منتج3', 'منتج4',
            'Product 1', 'Product 2', 'Product 3', 'Product 4',
            'product 1', 'product 2', 'product 3', 'product 4',
        ];
        $realProductsQuery = SupplierProducts::whereNotIn('name', $excludedDummyProducts)
            ->where('name', 'not like', 'منتج 1%')
            ->where('name', 'not like', 'منتج 2%')
            ->where('name', 'not like', 'منتج 3%')
            ->where('name', 'not like', 'منتج 4%');
        $totalProducts = (clone $realProductsQuery)->count();
        $activeProducts = (clone $realProductsQuery)->where('status', 'active')->count();
        $avgProductsPerSupplier = $totalSuppliers > 0 ? round($totalProducts / $totalSuppliers, 1) : 0;

        // 4. Orders Stats
        $totalOrders = SupplierOrders::count();
        $deliveredOrders = SupplierOrders::where('status', 'delivered')->count();
        $pendingOrders = SupplierOrders::whereIn('status', ['pending', 'processing'])->count();
        $deliveryRate = $totalOrders > 0 ? round(($deliveredOrders / $totalOrders) * 100, 1) : 0;

        $supplierStats = [
            'total' => $totalSuppliers,
            'approved' => $approvedSuppliers,
            'pending' => $pendingSuppliers,
            'inactive' => $inactiveSuppliers,
            'active' => $activeSuppliersCount,
            'activity_percentage' => $activityPercentage,
            'inactive_activity' => $inactiveActivityCount,
            'period_days' => $activeDays,
            'total_products' => $totalProducts,
            'active_products' => $activeProducts,
            'avg_products' => $avgProductsPerSupplier,
            'total_orders' => $totalOrders,
            'delivered_orders' => $deliveredOrders,
            'pending_orders' => $pendingOrders,
            'delivery_rate' => $deliveryRate,
        ];

        $availablePlans = SupplierPlan::all();

        return view('admins.admin.supplier.index', compact('suppliers', 'supplierStats', 'availablePlans'));
    }

    // show
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        $user = get_user_data($supplier->tenant_id);

        // Financial & Payment Accounts
        $bankAccount = $user?->bank_settings;
        $chargilySetting = $user?->chargilySettings;

        // Orders Statistics
        $ordersCount = $supplier->orders()->count();
        $deliveredOrdersCount = $supplier->orders()->where('status', 'delivered')->count();
        $pendingOrdersCount = $supplier->orders()->whereIn('status', ['pending', 'processing'])->count();
        $ordersWithProofCount = $supplier->orders()
            ->whereNotNull('payment_proof')
            ->where('payment_proof', '!=', '')
            ->count();

        // Orders with payment proofs for auditing
        $ordersWithProofs = $supplier->orders()
            ->whereNotNull('payment_proof')
            ->where('payment_proof', '!=', '')
            ->orderBy('id', 'desc')
            ->take(20)
            ->get();

        $availablePlans = SupplierPlan::all();

        return view('admins.admin.supplier.show', compact(
            'supplier',
            'user',
            'bankAccount',
            'chargilySetting',
            'ordersCount',
            'deliveredOrdersCount',
            'pendingOrdersCount',
            'ordersWithProofCount',
            'ordersWithProofs',
            'availablePlans'
        ));
    }

    // destroy
    public function destroy($id)
    {
        try {
            // Start a transaction for atomicity
            \DB::beginTransaction();
            // select user
            $user = User::find($id);
            // Define the folder path and delete from R2 and local disks
            $folderPath = get_supplier_store_name($user->tenant_id);
            if (!empty($folderPath)) {
                $mediaService = app(\App\Services\Supplier\SupplierMediaService::class);
                $mediaService->deleteDirectory($folderPath);
            }
            // get supplier
            $supplier = Tenant::find($user->tenant_id);
            // delete supplier categories
            foreach (get_supplier_categories($user->tenant_id) as $category) {
                $category->delete();
            }
            // delete supplier
            $supplier->delete();
            // Commit the transaction
            \DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction
            \DB::rollBack();

            // if(!Storage::disk('public')->exists($folderPath))
            //     {
            //         Storage::disk('public')->makeDirectory($folderPath);
            //     }
            return redirect()->back()->with('success', 'تم حذف المورد بنجاح');
        }
    }

    // approve supplier
    public function approve($id)
    {
        $supplier = Supplier::find($id);
        $supplier->update(['approval_status' => 'approved']);
        // update status inuserRequestValidation table
        $user = get_user_data($supplier->tenant_id);
        $requestValidation = UserRequestsValidation::where('user_id', $user->id)->where('status', 'pending')->first();
        if ($requestValidation) {
            $requestValidation->update([
                'status' => 'approved',
                'approval_notes' => 'تم توثيق البائع دون توضيحات',
                'reviewed_at' => now(),
                'admin_id' => auth('admin')->id(),
            ]);
        }
        // insert reason
        $supplier->approveReasons()->create([
            'admin_id' => auth('admin')->id(),
            'status' => 'approved',
            'reason' => 'تم توثيق البائع دون توضيحات',
        ]);

        return response()->json(['success' => true, 'approval_status' => 'approved', 'message' => 'تم توثيق البائع بنجاح']);
    }

    // un approve supplier
    public function unapprove(Request $request)
    {
        $request->validate([
            'supplier_id' => 'required|exists:suppliers,id',
            'reason' => 'required|string|max:1000',
        ]);

        $supplier = Supplier::findOrFail($request->supplier_id);

        $supplier->update([
            'approval_status' => 'pending',
        ]);

        // insert reason
        $supplier->approveReasons()->create([
            'admin_id' => auth('admin')->id(),
            'status' => 'unapproved',
            'reason' => $request->reason,
        ]);

        // update status inuserRequestValidation table
        $user = get_user_data($supplier->tenant_id);
        $requestValidation = UserRequestsValidation::where('user_id', $user->id)->where('status', 'pending')->first();
        if ($requestValidation) {
            $requestValidation->update([
                'status' => 'rejected',
                'reject_reason' => $request->reason,
                'reviewed_at' => now(),
                'admin_id' => auth('admin')->id(),
            ]);
        }

        // return response()->json([
        //     'success' => true,
        //     'message' => 'تم حذف توثيق البائع بنجاح',
        // ]);
        return redirect()->back()->with(['approval_status' => 'unapproved', 'success' => true, 'message' => 'تم حذف توثيق البائع بنجاح']);
    }

    // change supplier password
    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $supplier = Supplier::findOrFail($id);
        $user = User::where('tenant_id', $supplier->tenant_id)->first();

        if (!$user) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json(['success' => false, 'message' => 'لم يتم العثور على حساب المستخدم المرتبط'], 442);
            }
            return redirect()->back()->with('error', 'لم يتم العثور على حساب المستخدم المرتبط');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'تم تغيير كلمة المرور بنجاح',
                'new_password' => $request->password,
            ]);
        }

        return redirect()->back()->with([
            'success' => 'تم تغيير كلمة المرور بنجاح',
            'new_password' => $request->password,
        ]);
    }

    /**
     * Reset supplier store to initial default settings and layout,
     * strictly preserving supplier's products, orders, and financial accounts.
     *
     * @param Request $request
     * @param int|string $id
     * @param SupplierStoreResetService $resetService
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function resetStore(Request $request, $id, SupplierStoreResetService $resetService)
    {
        $supplier = Supplier::findOrFail($id);
        $user = User::where('tenant_id', $supplier->tenant_id)->first() ?? get_user_data($supplier->tenant_id);

        if (!$user) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم العثور على حساب المستخدم المرتبط بهذا المورد.',
                ], 404);
            }
            return redirect()->back()->with('error', 'لم يتم العثور على حساب المستخدم المرتبط بهذا المورد.');
        }

        try {
            $resetService->reset($supplier, $user);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تمت إعادة ضبط متجر المورد إلى الوضعية الافتراضية بنجاح مع الحفاظ على جميع المنتجات والطلبات.',
                ]);
            }

            return redirect()->back()->with('success', 'تمت إعادة ضبط متجر المورد إلى الوضعية الافتراضية بنجاح.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Supplier Store Reset Failed: ' . $e->getMessage(), [
                'supplier_id' => $supplier->id,
                'exception' => $e,
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء إعادة ضبط المتجر: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'حدث خطأ أثناء إعادة ضبط المتجر: ' . $e->getMessage());
        }
    }

    /**
     * Manually upgrade a single supplier's subscription plan.
     */
    public function upgradePlan(Request $request, $id)
    {
        $request->validate([
            'plan_id' => 'required|exists:supplier_plans,id',
            'duration_days' => 'required|integer|min:1|max:3650',
            'extend_existing' => 'nullable|boolean',
            'notify_supplier' => 'nullable|boolean',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $supplier = Supplier::findOrFail($id);
            $plan = SupplierPlan::findOrFail($request->plan_id);
            $durationDays = (int) $request->duration_days;
            $extendExisting = $request->boolean('extend_existing', true);
            $notifySupplier = $request->boolean('notify_supplier', true);
            $notes = $request->input('notes', 'ترقية يدوية من قِبل إدارة المنصة');

            $subscription = SupplierPlanSubscription::firstOrNew(['supplier_id' => $supplier->id]);

            $now = Carbon::now();
            $startDate = $now;
            if ($extendExisting && $subscription->subscription_end_date && Carbon::parse($subscription->subscription_end_date)->isFuture()) {
                $endDate = Carbon::parse($subscription->subscription_end_date)->addDays($durationDays);
                $startDate = Carbon::parse($subscription->subscription_start_date ?? $now);
            } else {
                $endDate = (clone $now)->addDays($durationDays);
            }

            $subscription->supplier_id = $supplier->id;
            $subscription->plan_id = $plan->id;
            $subscription->duration = $durationDays;
            $subscription->price = 0.00;
            $subscription->discount = 0.00;
            $subscription->payment_method = 'admin_grant';
            $subscription->payment_status = 'paid';
            $subscription->status = 'paid';
            $subscription->change_subscription = true;
            $subscription->subscription_start_date = $startDate;
            $subscription->subscription_end_date = $endDate;
            $subscription->save();

            // Send notification to supplier
            if ($notifySupplier && $supplier->user) {
                $supplier->user->notifications()->create([
                    'user_id' => $supplier->user->id,
                    'sender_id' => auth('admin')->id(),
                    'type' => 'system',
                    'title' => 'تمت ترقية باقة اشتراك متجرك بنجاح 🎉',
                    'body' => $notes ? "تمت ترقية باقة متجرك إلى ({$plan->name}) لمدة {$durationDays} يوماً. ملاحظة: {$notes}" : "تمت ترقية باقة متجرك إلى ({$plan->name}) لمدة {$durationDays} يوماً بنجاح.",
                    'icon' => 'fas fa-gem',
                    'color' => 'success',
                    'action_url' => route('supplier.subscription'),
                ]);
            }

            $message = "تمت ترقية باقة المورد ({$supplier->store_name}) إلى خطة ({$plan->name}) لمدة {$durationDays} يوماً بنجاح.";

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                ]);
            }

            return redirect()->back()->with('success', $message);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Supplier Upgrade Plan Failed: " . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء ترقية الباقة: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'حدث خطأ أثناء ترقية الباقة: ' . $e->getMessage());
        }
    }

    /**
     * Bulk upgrade suppliers subscription plans with registration date filtering.
     */
    public function bulkUpgradePlan(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:supplier_plans,id',
            'duration_days' => 'required|integer|min:1|max:3650',
            'selection_mode' => 'required|string|in:all,registered_before,registered_after,registered_between,selected_ids',
            'before_date' => 'nullable|date',
            'after_date' => 'nullable|date',
            'from_date' => 'nullable|date',
            'to_date' => 'nullable|date',
            'selected_ids' => 'nullable|array',
            'selected_ids.*' => 'integer|exists:suppliers,id',
            'target_status' => 'nullable|string|in:all,approved,pending',
            'extend_existing' => 'nullable|boolean',
            'notify_suppliers' => 'nullable|boolean',
            'notes' => 'nullable|string|max:500',
        ]);

        try {
            $plan = SupplierPlan::findOrFail($request->plan_id);
            $durationDays = (int) $request->duration_days;
            $selectionMode = $request->input('selection_mode');
            $targetStatus = $request->input('target_status', 'all');
            $extendExisting = $request->boolean('extend_existing', true);
            $notifySuppliers = $request->boolean('notify_suppliers', true);
            $notes = $request->input('notes', 'ترقية جماعية من قِبل إدارة المنصة');

            $query = Supplier::query();

            // Status filter
            if ($targetStatus === 'approved') {
                $query->where('approval_status', 'approved');
            } elseif ($targetStatus === 'pending') {
                $query->where('approval_status', '!=', 'approved');
            }

            // Selection Mode / Date filtering
            switch ($selectionMode) {
                case 'registered_before':
                    if (!$request->filled('before_date')) {
                        return back()->with('error', 'يرجى تحديد تاريخ التسجيل المطلوب (قبل).');
                    }
                    $query->whereDate('created_at', '<=', Carbon::parse($request->before_date)->endOfDay());
                    break;

                case 'registered_after':
                    if (!$request->filled('after_date')) {
                        return back()->with('error', 'يرجى تحديد تاريخ التسجيل المطلوب (بعد).');
                    }
                    $query->whereDate('created_at', '>=', Carbon::parse($request->after_date)->startOfDay());
                    break;

                case 'registered_between':
                    if (!$request->filled('from_date') || !$request->filled('to_date')) {
                        return back()->with('error', 'يرجى تحديد التاريخ من وإلى بدقة.');
                    }
                    $query->whereDate('created_at', '>=', Carbon::parse($request->from_date)->startOfDay())
                          ->whereDate('created_at', '<=', Carbon::parse($request->to_date)->endOfDay());
                    break;

                case 'selected_ids':
                    $ids = $request->input('selected_ids', []);
                    if (empty($ids)) {
                        return back()->with('error', 'لم يتم تحديد أي مورد من الجدول للترقية.');
                    }
                    $query->whereIn('id', $ids);
                    break;

                case 'all':
                default:
                    // All suppliers
                    break;
            }

            $suppliers = $query->with(['plan_subscription', 'user'])->get();

            if ($suppliers->isEmpty()) {
                $msg = 'لم يتم العثور على أي مورد يطابق معايير الفلترة المحددة.';
                if ($request->ajax()) {
                    return response()->json(['success' => false, 'message' => $msg], 422);
                }
                return redirect()->back()->with('error', $msg);
            }

            $now = Carbon::now();
            $processedCount = 0;

            \DB::transaction(function () use ($suppliers, $plan, $durationDays, $extendExisting, $notifySuppliers, $notes, $now, &$processedCount) {
                foreach ($suppliers as $supplier) {
                    $subscription = $supplier->plan_subscription ?? SupplierPlanSubscription::firstOrNew(['supplier_id' => $supplier->id]);

                    $startDate = $now;
                    if ($extendExisting && $subscription->subscription_end_date && Carbon::parse($subscription->subscription_end_date)->isFuture()) {
                        $endDate = Carbon::parse($subscription->subscription_end_date)->addDays($durationDays);
                        $startDate = Carbon::parse($subscription->subscription_start_date ?? $now);
                    } else {
                        $endDate = (clone $now)->addDays($durationDays);
                    }

                    $subscription->supplier_id = $supplier->id;
                    $subscription->plan_id = $plan->id;
                    $subscription->duration = $durationDays;
                    $subscription->price = 0.00;
                    $subscription->discount = 0.00;
                    $subscription->payment_method = 'admin_grant';
                    $subscription->payment_status = 'paid';
                    $subscription->status = 'paid';
                    $subscription->change_subscription = true;
                    $subscription->subscription_start_date = $startDate;
                    $subscription->subscription_end_date = $endDate;
                    $subscription->save();

                    // Notify supplier
                    if ($notifySuppliers && $supplier->user) {
                        $supplier->user->notifications()->create([
                            'user_id' => $supplier->user->id,
                            'sender_id' => auth('admin')->id(),
                            'type' => 'system',
                            'title' => 'تمت ترقية باقة اشتراك متجرك بنجاح 🎉',
                            'body' => $notes ? "تمت ترقية باقة متجرك إلى ({$plan->name}) لمدة {$durationDays} يوماً. ملاحظة: {$notes}" : "تمت ترقية باقة متجرك إلى ({$plan->name}) لمدة {$durationDays} يوماً بنجاح.",
                            'icon' => 'fas fa-gem',
                            'color' => 'success',
                            'action_url' => route('supplier.subscription'),
                        ]);
                    }

                    $processedCount++;
                }
            });

            $message = "تمت بنجاح ترقية باقات {$processedCount} مورد إلى خطة ({$plan->name}) لمدة {$durationDays} يوماً.";

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'processed_count' => $processedCount,
                ]);
            }

            return redirect()->back()->with('success', $message);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Bulk Supplier Upgrade Plan Failed: " . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء الترقية الجماعية: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'حدث خطأ أثناء الترقية الجماعية: ' . $e->getMessage());
        }
    }
}
