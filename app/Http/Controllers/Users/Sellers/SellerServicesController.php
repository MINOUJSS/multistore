<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\BalanceTransaction;
use App\Models\PlatformService;
use App\Models\SellerServicePurchase;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SellerServicesController extends Controller
{
    /**
     * Display the Platform Services & Add-ons store for sellers.
     */
    public function index()
    {
        $user = auth()->user();

        // 1. Get current wallet balance
        $currentBalance = $user->balance ? (float) $user->balance->balance : 0.00;

        // 2. Retrieve all active platform services
        $services = PlatformService::active()->get();

        // Group services by category for tabs
        $categories = [
            'all' => 'جميع الباقات والخدمات',
            'payment' => 'بوابات الدفع (شارجلي)',
            'store_features' => 'الدفع بالتحويل البنكي',
            'ai_tools' => 'أدوات الذكاء الاصطناعي',
        ];

        // 3. Retrieve user's purchases with services
        $purchases = SellerServicePurchase::where('user_id', $user->id)
            ->with('service')
            ->latest()
            ->get();

        // Map active purchases by service_id
        $activePurchasesByService = [];
        foreach ($purchases as $purchase) {
            if ($purchase->isActive() && !isset($activePurchasesByService[$purchase->platform_service_id])) {
                $activePurchasesByService[$purchase->platform_service_id] = $purchase;
            }
        }

        // 4. Summarized Stats & Quotas for Hero Banner
        $chargilyRemainingOrders = $purchases->where('status', 'active')
            ->filter(fn($p) => $p->service && $p->service->category === 'payment')
            ->sum('orders_remaining');

        $bankTransferRemainingOrders = $purchases->where('status', 'active')
            ->filter(fn($p) => $p->service && $p->service->category === 'store_features')
            ->sum('orders_remaining');

        $aiCreditsBalance = $purchases->where('status', 'active')
            ->where('billing_type', 'credit_pack')
            ->sum('credits_remaining');

        // Total active distinct feature categories
        $activeFeaturesCount = ($chargilyRemainingOrders > 0 ? 1 : 0)
            + ($bankTransferRemainingOrders > 0 ? 1 : 0)
            + ($aiCreditsBalance > 0 ? 1 : 0);

        return view('users.sellers.services.index', compact(
            'services',
            'categories',
            'currentBalance',
            'purchases',
            'activePurchasesByService',
            'chargilyRemainingOrders',
            'bankTransferRemainingOrders',
            'aiCreditsBalance',
            'activeFeaturesCount'
        ));
    }

    /**
     * Purchase a platform service using Seller's wallet balance ONLY.
     */
    public function purchase(Request $request, $id)
    {
        $service = PlatformService::where('id', $id)->where('is_active', true)->firstOrFail();
        $user = auth()->user();

        // 1. Verify User Balance
        $userBalance = $user->balance;
        $currentBalance = $userBalance ? (float) $userBalance->balance : 0.00;

        if ($currentBalance < (float) $service->price) {
            return back()->with('error', 'رصيد محفظتك الحالي (' . number_format($currentBalance, 2) . ' د.ج) غير كافٍ لشراء ' . $service->name_ar . '. يرجى شحن رصيدك أولاً.');
        }

        try {
            DB::transaction(function () use ($user, $userBalance, $service) {
                // Deduct balance from UserBalance
                $userBalance->decrement('balance', $service->price);

                // Create a balance transaction record
                BalanceTransaction::create([
                    'user_id' => $user->id,
                    'transaction_type' => 'deduction',
                    'amount' => $service->price,
                    'description' => 'شراء باقة خدمة: ' . $service->name_ar,
                    'payment_method' => 'رصيد المحفظة',
                    'status' => 'approved',
                ]);

                // Calculate validity period & quotas
                $validityDays = $service->validity_days;
                $expiresAt = $validityDays ? Carbon::now()->addDays($validityDays) : null;
                $credits = $service->credits_amount ?? 0;
                $orders = $service->orders_limit ?? 0;

                // Create purchase record with new quota
                SellerServicePurchase::create([
                    'user_id' => $user->id,
                    'platform_service_id' => $service->id,
                    'paid_amount' => $service->price,
                    'status' => 'active',
                    'billing_type' => $service->billing_type,
                    'validity_days' => $validityDays,
                    'activated_at' => Carbon::now(),
                    'expires_at' => $expiresAt,
                    'credits_total' => $credits,
                    'credits_remaining' => $credits,
                    'orders_total' => $orders,
                    'orders_remaining' => $orders,
                    'meta_data' => [
                        'service_slug' => $service->slug,
                        'service_name_ar' => $service->name_ar,
                        'purchased_at' => Carbon::now()->toDateTimeString(),
                    ],
                ]);
            });

            // Customized success response
            if ($service->isOrderQuota()) {
                $msg = 'تهانينا! تم تفعيل «' . $service->name_ar . '» بنجاح وتمت إضافة ' . $service->orders_limit . ' طلبات إلى رصيد حسابك، وخصم ' . number_format($service->price, 2) . ' د.ج من محفظتك.';
            } elseif ($service->isCreditPack()) {
                $msg = 'تهانينا! تم تفعيل «' . $service->name_ar . '» بنجاح وتمت إضافة ' . $service->credits_amount . ' نقطة ذكاء اصطناعي إلى رصيدك.';
            } else {
                $msg = 'تهانينا! تم تفعيل «' . $service->name_ar . '» بنجاح وتم خصم ' . number_format($service->price, 2) . ' د.ج من محفظتك.';
            }

            return back()->with('success', $msg);
        } catch (\Exception $e) {
            return back()->with('error', 'حدث خطأ أثناء معالجة عملية الشراء: ' . $e->getMessage());
        }
    }
}
