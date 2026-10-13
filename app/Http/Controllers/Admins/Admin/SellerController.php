<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller\Seller;
use App\Models\Seller\SellerOrders;
use App\Models\Seller\SellerProducts;
use App\Models\Tenant;
use App\Models\User;
use App\Models\BalanceTransaction;
use App\Models\UserBalance;
use App\Models\UserNotification;
use App\Models\UserRequestsValidation;
use App\Models\PlatformService;
use App\Models\SellerServicePurchase;
use App\Models\UserFreeOrder;
use App\Services\Admins\Admin\SellerStoreResetService;
use App\Services\Admins\Admin\SellerTempCleanupService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SellerController extends Controller
{
    // index
    public function index(Request $request)
    {
        $query = Seller::with(['user.balance', 'tenant.domains', 'plan_subscription']);

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

        $sellers = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();

        // 1. Seller Accounts Stats
        $totalSellers = Seller::count();
        $approvedSellers = Seller::where('approval_status', 'approved')->count();
        $pendingSellers = Seller::where('approval_status', 'pending')->count();
        $inactiveSellers = Seller::where('status', 'inactive')->count();

        // 2. Activity Stats via last_seens (last 30 days)
        $activeDays = 30;
        $activeThreshold = now()->subDays($activeDays);
        $activeSellersCount = Seller::whereHas('user.last_seen', function ($q) use ($activeThreshold) {
            $q->where('last_seen_at', '>=', $activeThreshold);
        })->count();
        $activityPercentage = $totalSellers > 0 ? round(($activeSellersCount / $totalSellers) * 100, 1) : 0;
        $inactiveActivityCount = max(0, $totalSellers - $activeSellersCount);

        // 3. Products Stats (Excluding default/dummy demo products)
        $excludedDummyProducts = [
            'منتج 1', 'منتج 2', 'منتج 3', 'منتج 4',
            'منتج1', 'منتج2', 'منتج3', 'منتج4',
            'Product 1', 'Product 2', 'Product 3', 'Product 4',
            'product 1', 'product 2', 'product 3', 'product 4',
        ];
        $realProductsQuery = SellerProducts::whereNotIn('name', $excludedDummyProducts)
            ->where('name', 'not like', 'منتج 1%')
            ->where('name', 'not like', 'منتج 2%')
            ->where('name', 'not like', 'منتج 3%')
            ->where('name', 'not like', 'منتج 4%');
        $totalProducts = (clone $realProductsQuery)->count();
        $activeProducts = (clone $realProductsQuery)->where('status', 'active')->count();
        $avgProductsPerSeller = $totalSellers > 0 ? round($totalProducts / $totalSellers, 1) : 0;

        // 4. Orders Stats
        $totalOrders = SellerOrders::count();
        $deliveredOrders = SellerOrders::where('status', 'delivered')->count();
        $pendingOrders = SellerOrders::whereIn('status', ['pending', 'processing'])->count();
        $deliveryRate = $totalOrders > 0 ? round(($deliveredOrders / $totalOrders) * 100, 1) : 0;

        $sellerStats = [
            'total' => $totalSellers,
            'approved' => $approvedSellers,
            'pending' => $pendingSellers,
            'inactive' => $inactiveSellers,
            'active' => $activeSellersCount,
            'activity_percentage' => $activityPercentage,
            'inactive_activity' => $inactiveActivityCount,
            'period_days' => $activeDays,
            'total_products' => $totalProducts,
            'active_products' => $activeProducts,
            'avg_products' => $avgProductsPerSeller,
            'total_orders' => $totalOrders,
            'delivered_orders' => $deliveredOrders,
            'pending_orders' => $pendingOrders,
            'delivery_rate' => $deliveryRate,
        ];

        // 5. Offline Temp Files Stats (> 1 hour)
        $offlineTempStats = app(SellerTempCleanupService::class)->getOfflineTempStats(1);

        return view('admins.admin.seller.index', compact('sellers', 'sellerStats', 'offlineTempStats'));
    }

    // show seller
    public function show($id)
    {
        $seller = Seller::findOrFail($id);
        $user = get_user_data($seller->tenant_id);

        // Financial & Payment Accounts
        $bankAccount = $user?->bank_settings;
        $chargilySetting = $user?->chargilySettings;

        // Orders Statistics
        $ordersCount = $seller->orders()->count();
        $deliveredOrdersCount = $seller->orders()->where('status', 'delivered')->count();
        $pendingOrdersCount = $seller->orders()->whereIn('status', ['pending', 'processing'])->count();
        $ordersWithProofCount = $seller->orders()
            ->whereNotNull('payment_proof')
            ->where('payment_proof', '!=', '')
            ->count();

        // Orders with payment proofs for auditing
        $ordersWithProofs = $seller->orders()
            ->whereNotNull('payment_proof')
            ->where('payment_proof', '!=', '')
            ->orderBy('id', 'desc')
            ->take(20)
            ->get();

        // Active Services Quotas & Free Orders
        $chargilyQuotaRemaining = $user
            ? (int) $user->servicePurchases()
                ->where('status', 'active')
                ->whereHas('service', fn($q) => $q->where('category', 'payment'))
                ->sum('orders_remaining')
            : 0;

        $bankTransferQuotaRemaining = $user
            ? (int) $user->servicePurchases()
                ->where('status', 'active')
                ->whereHas('service', fn($q) => $q->where('category', 'store_features')->orWhere('slug', 'like', 'bank_transfer%'))
                ->sum('orders_remaining')
            : 0;

        $freeOrdersRemaining = $user
            ? (int) ($user->freeOrder?->quantity ?? \App\Models\UserFreeOrder::where('user_id', $user->id)->value('quantity') ?? 0)
            : 0;

        // Pending identity/business validation request
        $hasPendingValidation = $user
            ? UserRequestsValidation::where('user_id', $user->id)->where('status', 'pending')->exists()
            : false;

        return view('admins.admin.seller.show', compact(
            'seller',
            'user',
            'bankAccount',
            'chargilySetting',
            'ordersCount',
            'deliveredOrdersCount',
            'pendingOrdersCount',
            'ordersWithProofCount',
            'ordersWithProofs',
            'chargilyQuotaRemaining',
            'bankTransferQuotaRemaining',
            'freeOrdersRemaining',
            'hasPendingValidation'
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
            $folderPath = get_seller_store_name($user->tenant_id);
            if (!empty($folderPath)) {
                $mediaService = app(\App\Services\Seller\SellerMediaService::class);
                $mediaService->deleteDirectory($folderPath);
            }
            // get seller
            $seller = Tenant::find($user->tenant_id);
            // delete seller categories
            foreach (get_seller_categories($user->tenant_id) as $category) {
                $category->delete();
            }
            // delete seller
            $seller->delete();
            // Commit the transaction
            \DB::commit();
        } catch (\Exception $e) {
            // Rollback the transaction
            \DB::rollBack();

            // if(!Storage::disk('public')->exists($folderPath))
            //     {
            //         Storage::disk('public')->makeDirectory($folderPath);
            //     }
            return redirect()->back()->with('success', 'تم حذف البائع بنجاح');
        }
    }

    // approve seller
    public function approve($id)
    {
        $seller = Seller::find($id);
        $seller->update(['approval_status' => 'approved']);
        // update status inuserRequestValidation table
        $user = get_user_data($seller->tenant_id);
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
        $seller->approveReasons()->create([
            'admin_id' => auth('admin')->id(),
            'status' => 'approved',
            'reason' => 'تم توثيق البائع دون توضيحات',
        ]);

        // send notification to user
        $user->notify(new \App\Notifications\Users\Sellers\SellerApprovedNotification($seller));
        // insert message in user notification table
        $user_notification = UserNotification::create([
            'user_id' => $user->id,
            'sender_id' => auth('admin')->id(),
            'type' => 'system',
            'title' => 'توثيق الحساب',
            'body' => 'تم توثيق حسابك بنجاح',
            'icon' => 'check-circle',
            'color' => 'success',
            'action_url' => route('seller.profile'),
            'is_read' => false,
        ]);

        return response()->json(['success' => true, 'approval_status' => 'approved', 'message' => 'تم توثيق البائع بنجاح']);
    }

    // un approve seller
    public function unapprove(Request $request)
    {
        $request->validate([
            'seller_id' => 'required|exists:sellers,id',
            'reason' => 'required|string|max:1000',
        ]);

        $seller = Seller::findOrFail($request->seller_id);

        $seller->update([
            'approval_status' => 'pending',
        ]);

        // insert reason
        $seller->approveReasons()->create([
            'admin_id' => auth('admin')->id(),
            'status' => 'unapproved',
            'reason' => $request->reason,
        ]);
        // update status inuserRequestValidation table
        $user = get_user_data($seller->tenant_id);
        $requestValidation = UserRequestsValidation::where('user_id', $user->id)->where('status', 'pending')->first();
        if ($requestValidation) {
            $requestValidation->update([
                'status' => 'rejected',
                'reject_reason' => $request->reason,
                'reviewed_at' => now(),
                'admin_id' => auth('admin')->id(),
            ]);
        }

        // send notification to user
        $user->notify(new \App\Notifications\Users\Sellers\SellerUnApprovedNotification($seller));
        // insert message in user notification table
        $user_notification = UserNotification::create([
            'user_id' => $user->id,
            'sender_id' => auth('admin')->id(),
            'type' => 'system',
            'title' => 'تم حذف أو رفض توثيق الحساب',
            'body' => 'تم حذف أو رفض توثيق الحساب  للسبب أو الأسباب التالية : '.$request->reason,
            'icon' => 'fas fa-ban',
            'color' => 'danger',
            'action_url' => route('seller.profile'),
            'is_read' => false,
        ]);

        // return response()->json([
        //     'success' => true,
        //     'message' => 'تم حذف توثيق البائع بنجاح',
        // ]);
        return redirect()->back()->with(['approval_status' => 'unapproved', 'success' => true, 'message' => 'تم حذف توثيق البائع بنجاح']);
    }

    // change seller password
    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);

        $seller = Seller::findOrFail($id);
        $user = User::where('tenant_id', $seller->tenant_id)->first();

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
     * Reset seller store to initial default settings and layout,
     * strictly preserving seller's products, orders, and financial accounts.
     *
     * @param Request $request
     * @param int|string $id
     * @param SellerStoreResetService $resetService
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function resetStore(Request $request, $id, SellerStoreResetService $resetService)
    {
        $seller = Seller::findOrFail($id);
        $user = User::where('tenant_id', $seller->tenant_id)->first() ?? get_user_data($seller->tenant_id);

        if (!$user) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم العثور على حساب المستخدم المرتبط بهذا البائع.',
                ], 404);
            }
            return redirect()->back()->with('error', 'لم يتم العثور على حساب المستخدم المرتبط بهذا البائع.');
        }

        try {
            $resetService->reset($seller, $user);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تمت إعادة ضبط متجر البائع إلى الوضعية الافتراضية بنجاح مع الحفاظ على جميع المنتجات والطلبات.',
                ]);
            }

            return redirect()->back()->with('success', 'تمت إعادة ضبط متجر البائع إلى الوضعية الافتراضية بنجاح.');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Seller Store Reset Failed: ' . $e->getMessage(), [
                'seller_id' => $seller->id,
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
     * Reset seller balance to 0.00 with mandatory reason,
     * logging the action in BalanceTransaction and notifying the seller.
     *
     * @param Request $request
     * @param int|string $id
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function resetBalance(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:1000',
        ], [
            'reason.required' => 'يرجى كتابة سبب تصفير الرصيد.',
            'reason.max' => 'يجب ألا يتجاوز السبب 1000 حرف.',
        ]);

        $seller = Seller::findOrFail($id);
        $user = User::where('tenant_id', $seller->tenant_id)->first() ?? get_user_data($seller->tenant_id);

        if (!$user) {
            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'لم يتم العثور على حساب المستخدم المرتبط بهذا البائع.',
                ], 404);
            }
            return redirect()->back()->with('error', 'لم يتم العثور على حساب المستخدم المرتبط بهذا البائع.');
        }

        try {
            \DB::beginTransaction();

            $userBalance = UserBalance::firstOrCreate(
                ['user_id' => $user->id],
                ['balance' => 0, 'outstanding_amount' => 0]
            );

            $previousBalance = (float) $userBalance->balance;

            // Reset balance to zero
            $userBalance->balance = 0;
            $userBalance->save();

            // Record transaction in BalanceTransaction
            BalanceTransaction::create([
                'user_id' => $user->id,
                'transaction_type' => 'admin_adjustment',
                'amount' => $previousBalance,
                'description' => 'تصفير الرصيد بواسطة إدارة المنصة. السبب: ' . $request->reason,
                'status' => 'completed',
            ]);

            // Notify seller via UserNotification
            UserNotification::create([
                'user_id' => $user->id,
                'sender_id' => auth('admin')->id(),
                'type' => 'system',
                'title' => 'تصفير رصيد المحفظة',
                'body' => 'تم تصفير رصيد محفظتك من قبل إدارة المنصة. السبب: ' . $request->reason,
                'icon' => 'fas fa-wallet',
                'color' => 'danger',
                'action_url' => route('seller.wallet'),
                'is_read' => false,
            ]);

            \DB::commit();

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'تم تصفير رصيد البائع بنجاح وتسجيل السبب.',
                    'previous_balance' => $previousBalance,
                ]);
            }

            return redirect()->back()->with('success', 'تم تصفير رصيد البائع بنجاح وتسجيل السبب.');
        } catch (\Throwable $e) {
            \DB::rollBack();

            \Illuminate\Support\Facades\Log::error('Seller Balance Reset Failed: ' . $e->getMessage(), [
                'seller_id' => $seller->id,
                'exception' => $e,
            ]);

            if ($request->wantsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء تصفير الرصيد: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'حدث خطأ أثناء تصفير الرصيد: ' . $e->getMessage());
        }
    }

    /**
     * Clean temp files for all offline sellers (inactivity > 1 hour).
     */
    public function cleanOfflineTemp(Request $request, SellerTempCleanupService $cleanupService)
    {
        try {
            $result = $cleanupService->cleanAllOfflineSellers(1);

            if ($result['deleted_files'] > 0) {
                return redirect()->back()->with(
                    'success',
                    "تم تنظيف الملفات المؤقتة بنجاح! تم حذف {$result['deleted_files']} ملف مؤقت لـ {$result['cleaned_sellers_count']} متجر غير متصل وتحرير {$result['freed_formatted']} من المساحة."
                );
            }

            return redirect()->back()->with('info', 'تم الفحص: لا توجد ملفات مؤقتة متراكمة للبائعين غير المتصلين حالياً (الذين لم ينشطوا منذ أكثر من ساعة).');
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Clean Offline Temp Failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء تنظيف الملفات المؤقتة: ' . $e->getMessage());
        }
    }

    /**
     * Clean temp files for a single seller if offline (inactivity > 1 hour).
     */
    public function cleanSingleSellerTemp($id, SellerTempCleanupService $cleanupService)
    {
        try {
            $seller = Seller::findOrFail($id);
            $result = $cleanupService->cleanForSeller($seller, 1);

            if (!$result['is_offline']) {
                return redirect()->back()->with('warning', "لا يمكن تنظيف الملفات؛ البائع ({$seller->store_name}) متصل حالياً أو كان نشطاً خلال الساعة الأخيرة.");
            }

            if ($result['deleted_files'] > 0) {
                return redirect()->back()->with(
                    'success',
                    "تم بنجاح حذف {$result['deleted_files']} ملف مؤقت لمتجر {$seller->store_name} وتحرير {$result['freed_formatted']} من المساحة."
                );
            }

            return redirect()->back()->with('info', "مجلد الملفات المؤقتة (temp) لمتجر {$seller->store_name} فارغ بالفعل ولا توجد ملفات متراكمة.");
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Clean Single Seller Temp Failed for ID {$id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء تنظيف الملفات المؤقتة: ' . $e->getMessage());
        }
    }

    /**
     * Add Chargily Pay orders, Bank Transfer orders, and Free Store Orders to the seller.
     */
    public function addServicesAndOrders(Request $request, $id)
    {
        $request->validate([
            'chargily_orders' => ['nullable', 'integer', 'min:0'],
            'bank_transfer_orders' => ['nullable', 'integer', 'min:0'],
            'free_orders' => ['nullable', 'integer', 'min:0'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $chargilyOrders = (int) $request->input('chargily_orders', 0);
        $bankTransferOrders = (int) $request->input('bank_transfer_orders', 0);
        $freeOrders = (int) $request->input('free_orders', 0);
        $notes = $request->input('notes') ?? 'إضافة يدوية من إدارة المنصة';

        if ($chargilyOrders <= 0 && $bankTransferOrders <= 0 && $freeOrders <= 0) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'يرجى إدخال كمية موجبة (أكبر من 0) لخدمة واحدة على الأقل لإضافتها.',
                ], 422);
            }
            return redirect()->back()->with('error', 'يرجى إدخال كمية موجبة (أكبر من 0) لخدمة واحدة على الأقل لإضافتها.');
        }

        try {
            \DB::beginTransaction();

            $seller = Seller::findOrFail($id);
            $user = User::where('tenant_id', $seller->tenant_id)->firstOrFail();
            $adminUser = auth('admin')->user();
            $adminInfo = $adminUser ? ($adminUser->name ?? $adminUser->email) : 'الإدارة';

            $addedItems = [];

            // 1. Add Chargily Pay Orders Quota
            if ($chargilyOrders > 0) {
                $chargilyService = PlatformService::firstOrCreate(
                    ['slug' => 'chargily_pay_5_orders'],
                    [
                        'name_ar' => 'باقة 5 طلبات دفع شارجلي (Chargily Pay)',
                        'name_en' => 'Chargily Pay - 5 Orders Pack',
                        'description_ar' => 'باقة تتيح قبول الدفع الإلكتروني بالبطاقة الذهبية و CIB لـ 5 طلبات متجر بنجاح دون أي التزام.',
                        'description_en' => 'Trial pack to accept Chargily electronic payments for 5 orders.',
                        'icon' => 'fa-solid fa-credit-card',
                        'category' => 'payment',
                        'price' => 0.00,
                        'billing_type' => 'order_quota',
                        'orders_limit' => 5,
                        'badge_text' => 'إضافة إدارية',
                        'badge_color' => 'secondary',
                        'features' => [
                            'قبول الدفع بالبطاقة الذهبية وبطاقات CIB',
                            'تأكيد الطلبات تلقائياً فور نجاح عملية الدفع',
                        ],
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );

                SellerServicePurchase::create([
                    'user_id' => $user->id,
                    'platform_service_id' => $chargilyService->id,
                    'paid_amount' => 0.00,
                    'status' => 'active',
                    'billing_type' => 'order_quota',
                    'orders_total' => $chargilyOrders,
                    'orders_remaining' => $chargilyOrders,
                    'meta_data' => [
                        'source' => 'admin_grant',
                        'granted_by' => $adminInfo,
                        'notes' => $notes,
                    ],
                ]);

                $addedItems[] = "{$chargilyOrders} طلب دفع شارجيلي";
            }

            // 2. Add Bank Transfer Orders Quota
            if ($bankTransferOrders > 0) {
                $bankService = PlatformService::firstOrCreate(
                    ['slug' => 'bank_transfer_3_orders'],
                    [
                        'name_ar' => 'باقة 3 طلبات دفع بالتحويل البنكي',
                        'name_en' => 'Bank Transfer - 3 Orders Pack',
                        'description_ar' => 'تفعيل خيار الدفع عبر التحويل البنكي و CCP وبريدي موب لـ 3 طلبات في متجرك.',
                        'description_en' => 'Accept bank transfer and BaridiMob payments for 3 orders.',
                        'icon' => 'fa-solid fa-building-columns',
                        'category' => 'store_features',
                        'price' => 0.00,
                        'billing_type' => 'order_quota',
                        'orders_limit' => 3,
                        'badge_text' => 'إضافة إدارية',
                        'badge_color' => 'secondary',
                        'features' => [
                            'إمكانية رفع إيصال الدفع البنكي',
                            'دعم الدفع عبر CCP وبريدي موب والتحويلات البنكية',
                        ],
                        'is_active' => true,
                        'sort_order' => 5,
                    ]
                );

                SellerServicePurchase::create([
                    'user_id' => $user->id,
                    'platform_service_id' => $bankService->id,
                    'paid_amount' => 0.00,
                    'status' => 'active',
                    'billing_type' => 'order_quota',
                    'orders_total' => $bankTransferOrders,
                    'orders_remaining' => $bankTransferOrders,
                    'meta_data' => [
                        'source' => 'admin_grant',
                        'granted_by' => $adminInfo,
                        'notes' => $notes,
                    ],
                ]);

                $addedItems[] = "{$bankTransferOrders} طلب تحويل بنكي";
            }

            // 3. Add Free Store Orders
            if ($freeOrders > 0) {
                $freeOrderRecord = UserFreeOrder::firstOrCreate(
                    ['user_id' => $user->id],
                    ['quantity' => 0]
                );
                $freeOrderRecord->increment('quantity', $freeOrders);

                $addedItems[] = "{$freeOrders} طلب متجر مجاني";
            }

            \DB::commit();

            $message = 'تم بنجاح شحن: ' . implode('، ', $addedItems) . ' لحساب البائع.';

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                ]);
            }

            return redirect()->back()->with('success', $message);
        } catch (\Throwable $e) {
            \DB::rollBack();
            \Illuminate\Support\Facades\Log::error("Add Services and Orders Failed for Seller {$id}: " . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء إضافة الخدمات والطلبات: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'حدث خطأ أثناء إضافة الخدمات والطلبات: ' . $e->getMessage());
        }
    }

    /**
     * Add services (Chargily Pay, Bank Transfer) and free store orders to all sellers in bulk.
     */
    public function bulkAddServicesAndOrders(Request $request)
    {
        $request->validate([
            'chargily_orders' => 'nullable|integer|min:0',
            'bank_transfer_orders' => 'nullable|integer|min:0',
            'free_orders' => 'nullable|integer|min:0',
            'target_audience' => 'nullable|string|in:all,approved,active',
            'notes' => 'nullable|string|max:500',
        ]);

        $chargilyOrders = (int) $request->input('chargily_orders', 0);
        $bankTransferOrders = (int) $request->input('bank_transfer_orders', 0);
        $freeOrders = (int) $request->input('free_orders', 0);
        $targetAudience = $request->input('target_audience', 'all');
        $notes = $request->input('notes', 'شحن جماعي بواسطة الإدارة لجميع البائعين');

        if ($chargilyOrders <= 0 && $bankTransferOrders <= 0 && $freeOrders <= 0) {
            $errMessage = 'يرجى إدخال كمية موجبة (أكبر من 0) لخدمة واحدة على الأقل للشحن الجماعي.';
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errMessage,
                ], 422);
            }
            return redirect()->back()->with('error', $errMessage);
        }

        try {
            $adminUser = auth('admin')->user();
            $adminInfo = $adminUser ? ($adminUser->name ?? $adminUser->email) : 'الإدارة';

            // Ensure platform services exist beforehand
            $chargilyService = null;
            if ($chargilyOrders > 0) {
                $chargilyService = PlatformService::firstOrCreate(
                    ['slug' => 'chargily_pay_5_orders'],
                    [
                        'name_ar' => 'باقة 5 طلبات دفع شارجلي (Chargily Pay)',
                        'name_en' => 'Chargily Pay - 5 Orders Pack',
                        'description_ar' => 'باقة تتيح قبول الدفع الإلكتروني بالبطاقة الذهبية و CIB لـ 5 طلبات متجر بنجاح دون أي التزام.',
                        'description_en' => 'Trial pack to accept Chargily electronic payments for 5 orders.',
                        'icon' => 'fa-solid fa-credit-card',
                        'category' => 'payment',
                        'price' => 0.00,
                        'billing_type' => 'order_quota',
                        'orders_limit' => 5,
                        'badge_text' => 'إضافة إدارية',
                        'badge_color' => 'secondary',
                        'features' => [
                            'قبول الدفع بالبطاقة الذهبية وبطاقات CIB',
                            'تأكيد الطلبات تلقائياً فور نجاح عملية الدفع',
                        ],
                        'is_active' => true,
                        'sort_order' => 1,
                    ]
                );
            }

            $bankService = null;
            if ($bankTransferOrders > 0) {
                $bankService = PlatformService::firstOrCreate(
                    ['slug' => 'bank_transfer_3_orders'],
                    [
                        'name_ar' => 'باقة 3 طلبات دفع بالتحويل البنكي',
                        'name_en' => 'Bank Transfer - 3 Orders Pack',
                        'description_ar' => 'تفعيل خيار الدفع عبر التحويل البنكي و CCP وبريدي موب لـ 3 طلبات في متجرك.',
                        'description_en' => 'Accept bank transfer and BaridiMob payments for 3 orders.',
                        'icon' => 'fa-solid fa-building-columns',
                        'category' => 'store_features',
                        'price' => 0.00,
                        'billing_type' => 'order_quota',
                        'orders_limit' => 3,
                        'badge_text' => 'إضافة إدارية',
                        'badge_color' => 'secondary',
                        'features' => [
                            'إمكانية رفع إيصال الدفع البنكي',
                            'دعم الدفع عبر CCP وبريدي موب والتحويلات البنكية',
                        ],
                        'is_active' => true,
                        'sort_order' => 5,
                    ]
                );
            }

            $query = Seller::with('user');
            if ($targetAudience === 'approved') {
                $query->where('approval_status', 'approved');
            } elseif ($targetAudience === 'active') {
                $query->where('status', 'active');
            }

            $processedCount = 0;

            \DB::transaction(function () use ($query, $chargilyOrders, $chargilyService, $bankTransferOrders, $bankService, $freeOrders, $adminInfo, $notes, &$processedCount) {
                $query->chunkById(100, function ($sellers) use ($chargilyOrders, $chargilyService, $bankTransferOrders, $bankService, $freeOrders, $adminInfo, $notes, &$processedCount) {
                    foreach ($sellers as $seller) {
                        $user = $seller->user;
                        if (!$user && $seller->tenant_id) {
                            $user = User::where('tenant_id', $seller->tenant_id)->first();
                        }
                        if (!$user) {
                            continue;
                        }

                        // 1. Add Chargily Quota
                        if ($chargilyOrders > 0 && $chargilyService) {
                            SellerServicePurchase::create([
                                'user_id' => $user->id,
                                'platform_service_id' => $chargilyService->id,
                                'paid_amount' => 0.00,
                                'status' => 'active',
                                'billing_type' => 'order_quota',
                                'orders_total' => $chargilyOrders,
                                'orders_remaining' => $chargilyOrders,
                                'meta_data' => [
                                    'source' => 'admin_bulk_grant',
                                    'granted_by' => $adminInfo,
                                    'notes' => $notes,
                                ],
                            ]);
                        }

                        // 2. Add Bank Transfer Quota
                        if ($bankTransferOrders > 0 && $bankService) {
                            SellerServicePurchase::create([
                                'user_id' => $user->id,
                                'platform_service_id' => $bankService->id,
                                'paid_amount' => 0.00,
                                'status' => 'active',
                                'billing_type' => 'order_quota',
                                'orders_total' => $bankTransferOrders,
                                'orders_remaining' => $bankTransferOrders,
                                'meta_data' => [
                                    'source' => 'admin_bulk_grant',
                                    'granted_by' => $adminInfo,
                                    'notes' => $notes,
                                ],
                            ]);
                        }

                        // 3. Add Free Store Orders
                        if ($freeOrders > 0) {
                            $freeOrderRecord = UserFreeOrder::firstOrCreate(
                                ['user_id' => $user->id],
                                ['quantity' => 0]
                            );
                            $freeOrderRecord->increment('quantity', $freeOrders);
                        }

                        $processedCount++;
                    }
                });
            });

            $addedItems = [];
            if ($chargilyOrders > 0) $addedItems[] = "{$chargilyOrders} طلب شارجلي";
            if ($bankTransferOrders > 0) $addedItems[] = "{$bankTransferOrders} طلب تحويل بنكي";
            if ($freeOrders > 0) $addedItems[] = "{$freeOrders} طلب متجر مجاني";

            $message = "تم بنجاح شحن (" . implode('، ', $addedItems) . ") لـ {$processedCount} بائع بنجاح.";

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'processed_count' => $processedCount,
                ]);
            }

            return redirect()->back()->with('success', $message);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Bulk Add Services and Orders Failed: " . $e->getMessage());

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'حدث خطأ أثناء الشحن الجماعي للخدمات والطلبات: ' . $e->getMessage(),
                ], 500);
            }

            return redirect()->back()->with('error', 'حدث خطأ أثناء الشحن الجماعي للخدمات والطلبات: ' . $e->getMessage());
        }
    }
}

