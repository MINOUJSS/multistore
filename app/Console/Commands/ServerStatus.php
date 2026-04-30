<?php 
namespace App\Console\Commands;

use App\Services\Users\Suppliers\TelegramService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ServerStatus extends Command
{
    protected $signature = 'server:status';
    protected $description = 'Check server health';

    public function handle()
    {
        // RAM
        $freeMemory = shell_exec('free -m');
        
        // Disk
        $disk = disk_free_space("/");
        $diskTotal = disk_total_space("/");

        $diskUsage = 100 - (($disk / $diskTotal) * 100);

        // CPU Load
        $load = sys_getloadavg();

        $data = [
            'cpu' => $load[0],
            'disk' => round($diskUsage, 2),
            'memory' => $freeMemory,
        ];

        // شرط التنبيه
        if ($data['cpu'] > 5 || $data['disk'] > 80) {
        $message =json_encode($data);
        //send with telegram
        app(TelegramService::class)
                ->sendMessage(env('ADMIN_CHAT_ID'), trim($message));

        //log info
        \Log::info('Server Status', $data);

            // Mail::raw("Server Alert:\n" . json_encode($data), function ($msg) {
            //     $msg->to('you@example.com')
            //         ->subject('🚨 Server Alert');
            // });

        }

        return 0;
    }
}
