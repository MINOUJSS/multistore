<?php

namespace App\Jobs\Users\Suppliers;

use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class sendOrderDataToGoogleSheet implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $tenant_id;
    /**
     * Create a new job instance.
     */
    public function __construct($tenant_id,$data)
    {
        $this->tenant_id=$tenant_id;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        $user=get_user_data($this->tenant_id);
        $sheet=\App\Models\UserApps::where('user_id',$user->id)->where('app_name','google_sheets')->first();
        $apiUrl=json_decode($sheet->data)->sheet_id;
        $response = Http::post($apiUrl, [
            // 'token' => $this->token,
            'action' => 'addOrder',
            'order' => $this->data
        ]);

        // return $response->json();

    }
}
