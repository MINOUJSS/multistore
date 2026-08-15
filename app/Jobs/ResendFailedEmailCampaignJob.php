<?php

namespace App\Jobs;

use App\Mail\Admin\ReEngagementCampaignMail;
use App\Models\EmailCampaign;
use App\Models\EmailCampaignLog;
use App\Models\Seller\Seller;
use App\Models\Supplier\Supplier;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ResendFailedEmailCampaignJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public EmailCampaign $campaign;

    /**
     * Create a new job instance.
     */
    public function __construct(EmailCampaign $campaign)
    {
        $this->campaign = $campaign;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $campaign = $this->campaign;

        // Fetch only failed logs for this campaign
        $failedLogs = EmailCampaignLog::where('campaign_id', $campaign->id)
            ->where('status', 'failed')
            ->get();

        if ($failedLogs->isEmpty()) {
            return;
        }

        $campaign->update([
            'status' => 'sending',
        ]);

        foreach ($failedLogs as $log) {
            $email = $log->recipient_email;
            $name = $log->recipient_name;
            $type = $log->recipient_type;
            $recipientId = $log->recipient_id;

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            // Lookup recipient store name if registered seller or supplier
            $storeName = null;
            if ($type === 'seller' && $recipientId) {
                $seller = Seller::find($recipientId);
                $storeName = $seller?->store_name;
            } elseif ($type === 'supplier' && $recipientId) {
                $supplier = Supplier::find($recipientId);
                $storeName = $supplier?->store_name;
            }

            $login_url = match ($type) {
                'seller' => route('seller.login'),
                'supplier' => route('supplier.login'),
                default => url('/'),
            };

            try {
                Mail::to($email)->send(
                    new ReEngagementCampaignMail(
                        $campaign->subject,
                        $campaign->content,
                        $name,
                        $storeName,
                        $login_url
                    )
                );

                $log->update([
                    'status' => 'sent',
                    'error_message' => null,
                    'sent_at' => now(),
                ]);
            } catch (\Throwable $e) {
                Log::error("Failed to resend campaign email to {$email}: " . $e->getMessage());

                $log->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);
            }
        }

        // Recalculate campaign statistics
        $sentCount = EmailCampaignLog::where('campaign_id', $campaign->id)->where('status', 'sent')->count();
        $newFailedCount = EmailCampaignLog::where('campaign_id', $campaign->id)->where('status', 'failed')->count();

        $campaign->update([
            'status' => ($newFailedCount > 0) ? 'failed' : 'completed',
            'sent_count' => $sentCount,
            'failed_count' => $newFailedCount,
        ]);
    }
}
