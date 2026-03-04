<?php

namespace App\Console;

use App\Models\BalanceTransaction;
use App\Models\FinancialLedger;
use App\Models\Seller\SellerPlanOrder;
use App\Models\Seller\SellerPlanSubscription;
use App\Models\Supplier\SupplierPlanOrder;
use App\Models\Supplier\SupplierPlanSubscription;
use App\Models\User;
use App\Services\Users\Suppliers\TelegramService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        /*:::::::::::::::::::::::::::::::::::::::::::::::::::::
        // تقرير المالي اليومي
        :::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        $schedule->call(function () {
            $today = now()->startOfDay();

            $income = FinancialLedger::where('type', 'income')
                ->where('created_at', '>=', $today)
                ->sum('amount');

            $expense = FinancialLedger::where('type', 'expense')
                ->where('created_at', '>=', $today)
                ->sum('amount');

            if ($income == 0 && $expense == 0) {
                return;
            }

            $message = "
            📊 <b>التقرير المالي اليومي</b>

            💰 إجمالي المداخيل: {$income}
            💸 إجمالي المصاريف: {$expense}
            📈 الصافي: ".($income - $expense).'
            📅 التاريخ: '.now()->format('Y-m-d');

            app(TelegramService::class)
                ->sendMessage(env('ADMIN_CHAT_ID'), trim($message));
        })->dailyAt('23:59');
        /*:::::::::::::::::::::::::::::::::::::::::::::::::::::
                تنبيه عن وجود دفع عن طريق تحويل بنكي
        :::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        // 1-بالنسبة لطلبات الإشتراك للبائعين
        $schedule->call(function () {
            $orders = SellerPlanOrder::all();
            foreach ($orders as $order) {
                if (
                    !in_array($order->payment_method, ['wallet', 'chargily', null])
                    && $order->status === 'pending'
                ) {
                    $telegram = app(TelegramService::class);

                    $amount = ($order->price - $order->discount);

                    $message = "
                💰 <b>طلب اشتراك تاجر يحتاج موافقة</b>

                👤 التاجر: {$order->seller->full_name}
                💵 المبلغ: {$amount}
                💳 طريقة الدفع: {$order->payment_method}
                🕒 الوقت: {$order->created_at->format('Y-m-d H:i')}
                ";

                    $telegram->sendMessage(
                        env('ADMIN_CHAT_ID'),
                        trim($message)
                    );
                }
            }
        })->everyMinute();
        // 2-بالنسبة لطلبات الإشتراك للموردين
        $schedule->call(function () {
            $orders = SupplierPlanOrder::all();
            foreach ($orders as $order) {
                if (
                    !in_array($order->payment_method, ['wallet', 'chargily', null])
                    && $order->status === 'pending'
                ) {
                    $telegram = app(TelegramService::class);

                    $amount = ($order->price - $order->discount);

                    $message = "
                💰 <b>طلب اشتراك مورد يحتاج موافقة</b>

                👤 المورد: {$order->supplier->full_name}
                💵 المبلغ: {$amount}
                💳 طريقة الدفع: {$order->payment_method}
                🕒 الوقت: {$order->created_at->format('Y-m-d H:i')}
                ";

                    $telegram->sendMessage(
                        env('ADMIN_CHAT_ID'),
                        trim($message)
                    );
                }
            }
        })->everyMinute();
        // 3-بالنسبة لطلبات الشحن
        $schedule->call(function () {
            $balancetransactions = BalanceTransaction::all();
            foreach ($balancetransactions as $transaction) {
                if ($transaction->status === 'pending') {
                    $telegram = app(TelegramService::class);

                    $message = "
                    💰 <b>طلب شحن رصيد يحتاج مراجعة</b>

                    👤 المستخدم: {$transaction->user->name}
                    💵 المبلغ: {$transaction->amount}
                    🕒 الوقت: {$transaction->created_at->format('Y-m-d H:i')}
                    ";

                    $telegram->sendMessage(
                        env('ADMIN_CHAT_ID'),
                        trim($message)
                    );
                }
            }
        })->everyMinute();

        /*::::::::::::::::::::::::::::::::::::::::::::::::::::

        :::::::::::::::::::::::::::::::::::::::::::::::::::::::*/
        // تغيير الإشتراكات المنتهية الصلاحية إلى الخطة المجانية
        // إشتركات الموردين الذين ينتهون صلاحية الاشتراك
        $schedule->call(function () {
            $today = now();

            $expiredSubscriptions = SupplierPlanSubscription::where('plan_id', '!=', 1)->whereDate('subscription_end_date', '<=', $today)->get();

            foreach ($expiredSubscriptions as $subscription) {
                // حفظ نسخة من بيانات المورد
                $supplierId = $subscription->supplier_id;
                $oldPlanId = $subscription->plan_id;

                // إعادة تعيين الاشتراك إلى الخطة المجانية
                $subscription->update([
                    'plan_id' => 1, // الخطة المجانية
                    'duration' => 0,
                    'price' => 0,
                    'discount' => 0,
                    'payment_method' => null,
                    'payment_status' => 'unpaid',
                    'status' => 'free',
                    'subscription_start_date' => now(),
                    'subscription_end_date' => now(),
                ]);

                // 📝 تسجيل العملية في السجل
                Log::info("تمت إعادة المورد ID {$supplierId} إلى الخطة المجانية بعد انتهاء الاشتراك (الخطة السابقة ID {$oldPlanId}).");

                // 🔔 إرسال إشعار للمورد
                // $user = User::find($supplierId); // يفترض أن supplier_id = user_id
                $user = get_user_data_from_supplier_id($supplierId);
                if ($user) {
                    Notification::send($user, new App\Notifications\Users\Suppliers\SubscriptionExpiredNotification());
                }
            }
        })->daily();
        // إشتركات التجار الذين ينتهون صلاحية الاشتراك
        $schedule->call(function () {
            $today = now();

            $expiredSubscriptions = SellerPlanSubscription::where('plan_id', '!=', 1)->whereDate('subscription_end_date', '<=', $today)->get();

            foreach ($expiredSubscriptions as $subscription) {
                // حفظ نسخة من بيانات المورد
                $sellerId = $subscription->seller_id;
                $oldPlanId = $subscription->plan_id;

                // إعادة تعيين الاشتراك إلى الخطة المجانية
                $subscription->update([
                    'plan_id' => 1, // الخطة المجانية
                    'duration' => 0,
                    'price' => 0,
                    'discount' => 0,
                    'payment_method' => null,
                    'payment_status' => 'unpaid',
                    'status' => 'free',
                    'subscription_start_date' => now(),
                    'subscription_end_date' => now(),
                ]);

                // 📝 تسجيل العملية في السجل
                Log::info("تمت إعادة المورد ID {$sellerId} إلى الخطة المجانية بعد انتهاء الاشتراك (الخطة السابقة ID {$oldPlanId}).");

                // 🔔 إرسال إشعار للمورد
                // $user = User::find($sellerId); // يفترض أن seller_id = user_id
                $user = get_user_data_from_seller_id($sellerId);
                if ($user) {
                    Notification::send($user, new App\Notifications\Users\Sellers\SubscriptionExpiredNotification());
                }
            }
        })->daily();
        // telegram response
        // $schedule->command('telegram:fetch-updates')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected $commands = [
        Commands\MakeServiceCommand::class,
        Commands\FetchTelegramUpdates::class,
    ];

    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
