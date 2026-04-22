<?php

namespace App\Jobs\Users\Suppliers;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class sendOrderDataToGoogleSheet implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    protected $data;
    protected $tenant_id;

    /**
     * Create a new job instance.
     */
    public function __construct($tenant_id, $data)
    {
        $this->tenant_id = $tenant_id;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // //
        // $user=get_user_data($this->tenant_id);
        // $sheet=\App\Models\UserApps::where('user_id',$user->id)->where('app_name','google_sheets')->first();
        // $apiUrl=json_decode($sheet->data)->sheet_id;
        // $response = Http::post($apiUrl, [
        //     // 'token' => $this->token,
        //     'action' => 'addOrder',
        //     'order' => $this->data
        // ]);

        // // return $response->json();
        $user = get_user_data($this->tenant_id);

        $sheet = \App\Models\UserApps::where('user_id', $user->id)
            ->where('app_name', 'google_sheets')
            ->first();

        if (!$sheet) {
            return;
        }

        $config = json_decode($sheet->data);

        if (empty($config->sheet_id)) {
            return;
        }

        $scriptId = $config->sheet_id;

        // 🔥 هنا التصحيح
        $apiUrl = "https://script.google.com/macros/s/$scriptId/exec";

        try {
            $response = Http::timeout(10)->post($apiUrl, [
                'action' => 'addOrder',
                'tenant_id' => $this->tenant_id,
                'order' => $this->data,
            ]);

            if ($response->failed()) {
                \Log::error('Google Script Error', [
                    'response' => $response->body(),
                ]);
            }
        } catch (\Exception $e) {
            \Log::error('HTTP Error', [
                'message' => $e->getMessage(),
            ]);
        }
    }
}
