<?php

namespace App\Services\Platform;

use App\Models\Seller\Seller;
use App\Models\Seller\SellerProducts;
use App\Models\Seller\SellerProductsVisits;
use App\Models\Supplier\Supplier;
use App\Models\Supplier\SupplierProducts;
use App\Models\Supplier\SupplierProductsVisits;
use App\Models\UserApps;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StoreVisitorsReportService
{
    protected ?string $botToken;
    protected string $apiUrl;

    public function __construct()
    {
        $this->botToken = env('TELEGRAM_BOT_TOKEN');
        $this->apiUrl = "https://api.telegram.org/bot{$this->botToken}";
    }

    /**
     * Send periodic visitors reports to all subscribed sellers and suppliers.
     *
     * @param string $frequency 'daily', 'weekly', or 'monthly'
     * @param string $role 'all', 'seller', or 'supplier'
     * @return array
     */
    public function sendReports(string $frequency = 'daily', string $role = 'all'): array
    {
        $frequency = strtolower($frequency);
        if (!in_array($frequency, ['daily', 'weekly', 'monthly'])) {
            $frequency = 'daily';
        }

        // 1. Fetch active Telegram app subscriptions
        $query = UserApps::where('app_name', 'telegram_notifications')
            ->where('status', 'active')
            ->with(['user']);

        if ($role === 'seller') {
            $query->whereHas('user', function ($q) {
                $q->where('type', 'seller');
            });
        } elseif ($role === 'supplier') {
            $query->whereHas('user', function ($q) {
                $q->where('type', 'supplier');
            });
        }

        $subscriptions = $query->get();

        $results = [
            'frequency' => $frequency,
            'role' => $role,
            'total_subscribers' => $subscriptions->count(),
            'sent_count' => 0,
            'failed_count' => 0,
            'skipped_count' => 0,
            'details' => [],
        ];

        foreach ($subscriptions as $subscription) {
            $processResult = $this->processSubscriberReport($subscription, $frequency);

            if ($processResult['status'] === 'sent') {
                $results['sent_count']++;
            } elseif ($processResult['status'] === 'failed') {
                $results['failed_count']++;
            } else {
                $results['skipped_count']++;
            }

            $results['details'][] = $processResult;
        }

        Log::info("StoreVisitorsReportService: Completed sending {$frequency} reports", [
            'total' => $results['total_subscribers'],
            'sent' => $results['sent_count'],
            'failed' => $results['failed_count'],
            'skipped' => $results['skipped_count'],
        ]);

        return $results;
    }

    /**
     * Process report generation and sending for a single subscriber.
     *
     * @param UserApps $subscription
     * @param string $frequency
     * @return array
     */
    public function processSubscriberReport(UserApps $subscription, string $frequency): array
    {
        $user = $subscription->user;
        if (!$user) {
            return [
                'status' => 'skipped',
                'reason' => 'User not found for subscription ID ' . $subscription->id,
            ];
        }

        // Extract Chat ID safely
        $data = is_array($subscription->data) ? $subscription->data : json_decode($subscription->data, true);
        $chatId = $data['chat_id'] ?? null;

        if (empty($chatId)) {
            return [
                'status' => 'skipped',
                'user_id' => $user->id,
                'reason' => 'Chat ID is missing in user app data',
            ];
        }

        // Resolve store and role
        $role = $user->type;
        $store = null;
        $storeName = $user->name;

        if ($role === 'seller') {
            $store = Seller::where('tenant_id', $user->tenant_id)->first();
            if ($store && !empty($store->store_name)) {
                $storeName = $store->store_name;
            }
        } elseif ($role === 'supplier') {
            $store = Supplier::where('tenant_id', $user->tenant_id)->first();
            if ($store && !empty($store->store_name)) {
                $storeName = $store->store_name;
            }
        }

        if (!$store) {
            return [
                'status' => 'skipped',
                'user_id' => $user->id,
                'reason' => "No {$role} record found for tenant ID: {$user->tenant_id}",
            ];
        }

        // Calculate Date Ranges
        $periods = $this->calculatePeriods($frequency);

        // Calculate Visits & Comparison
        $analytics = $this->getStoreVisitsAnalytics($store, $role, $periods);

        // Build HTML Message
        $message = $this->buildReportMessage($storeName, $role, $frequency, $periods, $analytics);

        // Send via Telegram
        $sent = $this->sendTelegramMessage($chatId, $message);

        return [
            'status' => $sent ? 'sent' : 'failed',
            'user_id' => $user->id,
            'role' => $role,
            'store_name' => $storeName,
            'chat_id' => $chatId,
            'current_visits' => $analytics['current_visits'],
            'previous_visits' => $analytics['previous_visits'],
        ];
    }

    /**
     * Calculate current and previous date ranges based on frequency.
     *
     * @param string $frequency
     * @return array
     */
    protected function calculatePeriods(string $frequency): array
    {
        $now = Carbon::now();

        switch ($frequency) {
            case 'weekly':
                return [
                    'current_start' => $now->copy()->startOfWeek(),
                    'current_end' => $now->copy(),
                    'previous_start' => $now->copy()->subWeek()->startOfWeek(),
                    'previous_end' => $now->copy()->subWeek()->endOfWeek(),
                    'current_label' => 'هذا الأسبوع',
                    'previous_label' => 'الأسبوع الماضي',
                    'frequency_title' => 'الأسبوعي',
                ];

            case 'monthly':
                return [
                    'current_start' => $now->copy()->startOfMonth(),
                    'current_end' => $now->copy(),
                    'previous_start' => $now->copy()->subMonth()->startOfMonth(),
                    'previous_end' => $now->copy()->subMonth()->endOfMonth(),
                    'current_label' => 'هذا الشهر',
                    'previous_label' => 'الشهر الماضي',
                    'frequency_title' => 'الشهري',
                ];

            case 'daily':
            default:
                return [
                    'current_start' => $now->copy()->startOfDay(),
                    'current_end' => $now->copy(),
                    'previous_start' => $now->copy()->subDay()->startOfDay(),
                    'previous_end' => $now->copy()->subDay()->endOfDay(),
                    'current_label' => 'اليوم',
                    'previous_label' => 'الأمس',
                    'frequency_title' => 'اليومي',
                ];
        }
    }

    /**
     * Aggregate store visits and top visited products for the periods.
     *
     * @param mixed $store
     * @param string $role
     * @param array $periods
     * @return array
     */
    protected function getStoreVisitsAnalytics($store, string $role, array $periods): array
    {
        $isSeller = ($role === 'seller');

        // 1. Get Product IDs
        if ($isSeller) {
            $productIds = SellerProducts::where('seller_id', $store->id)->pluck('id')->toArray();
            $visitsModel = SellerProductsVisits::class;
        } else {
            $productIds = SupplierProducts::where('supplier_id', $store->id)->pluck('id')->toArray();
            $visitsModel = SupplierProductsVisits::class;
        }

        if (empty($productIds)) {
            return [
                'current_visits' => 0,
                'previous_visits' => 0,
                'difference' => 0,
                'percentage' => 0,
                'trend' => 'same',
                'top_products' => [],
            ];
        }

        // 2. Count current visits
        $currentVisits = $visitsModel::whereIn('product_id', $productIds)
            ->whereBetween('visited_at', [$periods['current_start'], $periods['current_end']])
            ->count();

        // 3. Count previous visits
        $previousVisits = $visitsModel::whereIn('product_id', $productIds)
            ->whereBetween('visited_at', [$periods['previous_start'], $periods['previous_end']])
            ->count();

        // 4. Comparison calculations
        $diff = $currentVisits - $previousVisits;
        if ($previousVisits > 0) {
            $percentage = round(($diff / $previousVisits) * 100, 1);
        } else {
            $percentage = $currentVisits > 0 ? 100.0 : 0.0;
        }

        $trend = 'same';
        if ($diff > 0) {
            $trend = 'up';
        } elseif ($diff < 0) {
            $trend = 'down';
        }

        // 5. Top 3 - 5 most visited products in current period
        $topProductsQuery = $visitsModel::select('product_id', DB::raw('COUNT(*) as views_count'))
            ->whereIn('product_id', $productIds)
            ->whereBetween('visited_at', [$periods['current_start'], $periods['current_end']])
            ->groupBy('product_id')
            ->orderByDesc('views_count')
            ->take(5);

        if ($isSeller) {
            $topProductsQuery->with(['product:id,name,price']);
        } else {
            $topProductsQuery->with(['product:id,name,price']);
        }

        $topProducts = $topProductsQuery->get()->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'name' => $item->product?->name ?? "منتج #{$item->product_id}",
                'price' => $item->product?->price ?? 0,
                'views_count' => $item->views_count,
            ];
        })->toArray();

        return [
            'current_visits' => $currentVisits,
            'previous_visits' => $previousVisits,
            'difference' => $diff,
            'percentage' => $percentage,
            'trend' => $trend,
            'top_products' => $topProducts,
        ];
    }

    /**
     * Build dynamic actionable tips and motivational guidance tailored to performance.
     *
     * @param array $analytics
     * @param string $frequency
     * @param string $role
     * @return array
     */
    protected function generateMotivationalGuidance(array $analytics, string $frequency, string $role): array
    {
        $tips = [];
        $trend = $analytics['trend'];
        $currentVisits = $analytics['current_visits'];
        $topProducts = $analytics['top_products'];

        // 1. Performance-based motivation & tips
        if ($trend === 'up') {
            $tips[] = "🚀 <b>أداء رائع ومبشر!</b> حركة الزوار تشهد نمواً ملحوظاً، والفرصة مثالية الآن لتحويل هذا الاهتمام إلى مبيعات مؤكدة وأرباح مضاعفة.";
            $tips[] = "🎯 <b>تكتيك رفع التحويل:</b> قدّم عروض حزم ترويجية (Bundles) أو خصماً محدود المدة لتحفيز الزائر على إتمام الشراء قبل مغادرة المتجر.";
            $tips[] = "⚡ <b>سرعة التأكيد:</b> اتصل بالعملاء فور وصول الطلبات لتأكيدها وتجهيز الشحن، فالسرعة ترفع نسبة استلام الطرود إلى أكثر من 85%.";
        } elseif ($trend === 'down') {
            $tips[] = "💪 <b>استعد الزخم!</b> التجارة الإلكترونية جولات والركود المؤقت يتبعه انطلاقة قوية متى ما اتخذت الخطوات الصحيحة.";
            $tips[] = "📢 <b>إعادة تنشيط الزيارات:</b> قم بتحديث إعلاناتك على منصات التواصل (فيسبوك، تيك توك، إنستغرام) وركز على صور وفيديوهات توضح فوائد منتجاتك عملياً.";
            $tips[] = "🎁 <b>عرض لا يُقاوم:</b> جرب إطلاق ميزة الشحن المجاني لمدة 48 ساعة أو كود تخفيض استثنائي لإعادة جذب الزوار المترددين.";
        } else {
            if ($currentVisits > 0) {
                $tips[] = "⚖️ <b>حركة زوار متوازنة:</b> زوار متجرك في وتيرة مستقرة، ولكن بإمكانك كسر هذا النمط والوصول لآفاق أوسع بمضاعفة جهود التسويق.";
            } else {
                $tips[] = "🌱 <b>بداية الانطلاق:</b> متجرك بانتظار زواره الأوائل! كل نجاح كبير في التجارة بدأ بخطوة أولى مدروسة.";
            }
            $tips[] = "📸 <b>تحسين العرض:</b> حسّن جودة الصور الرئيسية وعناوين المنتجات لتكون واضحة وجذابة تلفت الانتباه من النظرة الأولى.";
            $tips[] = "🌐 <b>النشر والمشاركة:</b> شارك روابط المنتجات والمتجر في المجموعات والمنصات ذات الصلة بنيش عملك.";
        }

        // 2. Specific advice for the top product
        if (!empty($topProducts)) {
            $bestProduct = $topProducts[0];
            $tips[] = "⭐ <b>نصيحة للمنتج المتصدر:</b> منتج <i>({$bestProduct['name']})</i> حصد أعلى نسبة اهتمام ({$bestProduct['views_count']} زيارة)! تأكد من توفر كميات كافية في المخزون، وضعه في صدارة متجرك، واقترح ملحقات مكملة له (Cross-selling).";
        }

        return $tips;
    }

    /**
     * Build HTML-formatted Telegram message.
     *
     * @param string $storeName
     * @param string $role
     * @param string $frequency
     * @param array $periods
     * @param array $analytics
     * @return string
     */
    protected function buildReportMessage(string $storeName, string $role, string $frequency, array $periods, array $analytics): string
    {
        $roleLabel = ($role === 'seller') ? 'بائع' : 'مورد';
        $title = "📊 <b>تقرير زوار المتجر {$periods['frequency_title']}</b>";
        $dateFormatted = Carbon::now()->format('Y-m-d');

        // Trend visual indicators
        $trendIcon = '⚖️';
        $trendSign = '';
        if ($analytics['trend'] === 'up') {
            $trendIcon = '🟢 ↗️';
            $trendSign = '+';
        } elseif ($analytics['trend'] === 'down') {
            $trendIcon = '🔴 ↘️';
            $trendSign = '';
        }

        $percentageStr = $trendSign . $analytics['percentage'] . '%';
        $diffStr = ($analytics['difference'] > 0 ? "+{$analytics['difference']}" : "{$analytics['difference']}");

        $msg = "{$title}\n";
        $msg .= "🏪 <b>المتجر:</b> {$storeName} (<i>{$roleLabel}</i>)\n";
        $msg .= "📅 <b>التاريخ:</b> {$dateFormatted}\n\n";

        $msg .= "👥 <b>مقارنة حركة الزوار:</b>\n";
        $msg .= "• {$periods['current_label']}: <b>{$analytics['current_visits']}</b> زائر\n";
        $msg .= "• {$periods['previous_label']}: <b>{$analytics['previous_visits']}</b> زائر\n";
        $msg .= "• معدل التغير: {$trendIcon} <b>{$percentageStr}</b> ({$diffStr} زائر)\n\n";

        // Top Visited Products section
        if (!empty($analytics['top_products'])) {
            $msg .= "🔥 <b>المنتجات الأكثر زيارة ({$periods['current_label']}):</b>\n";
            $badges = ['🥇', '🥈', '🥉', '🔹', '🔹'];
            foreach ($analytics['top_products'] as $index => $prod) {
                $badge = $badges[$index] ?? '•';
                $priceFormatted = number_format($prod['price'], 0, '.', ' ');
                $msg .= "{$badge} <b>{$prod['name']}</b>\n";
                $msg .= "   └ 👁️ <b>{$prod['views_count']}</b> زيارة | 💰 {$priceFormatted} دج\n";
            }
            $msg .= "\n";
        } else {
            $msg .= "ℹ️ <i>لم تُسجل أي زيارات للمنتجات خلال {$periods['current_label']}.</i>\n\n";
        }

        // Actionable & Motivational Guidance section
        $guidance = $this->generateMotivationalGuidance($analytics, $frequency, $role);
        $msg .= "💡 <b>توجيهات ونصائح لمضاعفة مبيعاتك:</b>\n";
        foreach ($guidance as $tip) {
            $msg .= "• {$tip}\n\n";
        }

        $msg .= "✨ <i>منصة Multi-Store تتمنى لك مبيعات وفيرة وتوفيقاً مستمراً!</i>";

        return trim($msg);
    }

    /**
     * Send HTML message to Telegram API.
     *
     * @param string|int $chatId
     * @param string $message
     * @return bool
     */
    public function sendTelegramMessage($chatId, string $message): bool
    {
        if (empty($this->botToken)) {
            Log::warning('StoreVisitorsReportService: TELEGRAM_BOT_TOKEN is not configured in .env');
            return false;
        }

        try {
            $response = Http::timeout(10)->post("{$this->apiUrl}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('StoreVisitorsReportService: Failed to send telegram message', [
                'chat_id' => $chatId,
                'status' => $response->status(),
                'response' => $response->json(),
            ]);

            return false;
        } catch (\Throwable $e) {
            Log::error('StoreVisitorsReportService: Exception while sending telegram message: ' . $e->getMessage(), [
                'chat_id' => $chatId,
            ]);
            return false;
        }
    }
}
