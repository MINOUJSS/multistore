<?php

namespace App\Console;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use App\Models\SupplierPlanSubscription;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Notifications\Users\Suppliers\SubscriptionExpiredNotification;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call(function () {
            $today = now();
    
            $expiredSubscriptions = SupplierPlanSubscription::where('plan_id','!=',1)->whereDate('subscription_end_date', '<=', $today)->get();
    
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
                    'status' =>'free',
                    'subscription_start_date' => now(),
                    'subscription_end_date' => now(),
                ]);
    
                // 📝 تسجيل العملية في السجل
                Log::info("تمت إعادة المورد ID {$supplierId} إلى الخطة المجانية بعد انتهاء الاشتراك (الخطة السابقة ID {$oldPlanId}).");
    
                // 🔔 إرسال إشعار للمورد
                // $user = User::find($supplierId); // يفترض أن supplier_id = user_id
                $user=get_user_data_from_supplier_id($supplierId);
                if ($user) {
                    Notification::send($user, new SubscriptionExpiredNotification());
                }
            }
        })->daily();
        //telegram response
       // $schedule->command('telegram:fetch-updates')->everyMinute();
    }

    /**
     * Register the commands for the application.
     */
    protected $commands = [
    \App\Console\Commands\MakeServiceCommand::class,
    \App\Console\Commands\FetchTelegramUpdates::class,
     ];
     
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
