<?php 
namespace App\Console\Commands;

use App\Services\Users\Suppliers\TelegramService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ServerStatus extends Command
{
    protected $signature = 'server:status';
    protected $description = 'Check server health (PHP only)';

    public function handle()
    {
        // 💽 Disk
        $diskTotal = disk_total_space('/');
        $diskFree  = disk_free_space('/');
        $diskUsage = round((1 - $diskFree / $diskTotal) * 100, 2);

        // 🧠 RAM
        $memoryUsage = round(memory_get_usage(true) / 1024 / 1024, 2); // MB
        $memoryPeak  = round(memory_get_peak_usage(true) / 1024 / 1024, 2); // MB

        // ⚙️ CPU (تقريبي عبر load)
        $cpuLoad = null;
        if (function_exists('sys_getloadavg')) {
            $load = sys_getloadavg();
            $cpuLoad = $load[0]; // 1 minute average
        }

        // 🌐 تحقق من الموقع نفسه
        try {
            // $response = Http::timeout(5)->get(config('app.url'));
            $response = Http::withoutVerifying()->get(config('app.url'));
            $appStatus = $response->successful() ? 'UP' : 'DOWN';
        } catch (\Exception $e) {
            $appStatus = 'DOWN';
        }

        //db
        try {
    \DB::connection()->getPdo();
    $dbStatus = 'UP';
} catch (\Exception $e) {
    $dbStatus = 'DOWN';
}

        $data = [
            'disk_usage' => $diskUsage . '%',
            'memory_usage' => $memoryUsage . ' MB',
            'memory_peak' => $memoryPeak . ' MB',
            'cpu_load' => $cpuLoad,
            'app_status' => $appStatus,
            'db_status' => $dbStatus,
            'time' => now()->toDateTimeString(),
        ];

        // 📄 Log دائم
        Log::info('Server Status', $data);

        // 🚨 شرط التنبيه
        if ($diskUsage > 85 || $memoryUsage > 200) {

            // Telegram (أفضل من email)
            $this->sendTelegramAlert($data);

        }

        // عرض في الكونسول
        $this->info(json_encode($data, JSON_PRETTY_PRINT));

        return 0;
    }

    private function sendTelegramAlert($data)
    {
        $token = env('TELEGRAM_BOT_TOKEN');
        $chatId = env('ADMIN_CHAT_ID');

        if (!$token || !$chatId) return;

        $message = "🚨 Server Alert\n" . json_encode($data, JSON_PRETTY_PRINT);

        Http::get("https://api.telegram.org/bot{$token}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $message
        ]);
    }
}

