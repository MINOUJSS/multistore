<?php

namespace App\Jobs;

use App\Mail\Admin\ReEngagementCampaignMail;
use App\Models\EmailCampaign;
use App\Models\EmailCampaignLog;
use App\Models\Seller\Seller;
use App\Models\Supplier\Supplier;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendEmailCampaignJob implements ShouldQueue
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

        if ($campaign->status === 'completed') {
            return;
        }

        $campaign->update([
            'status' => 'sending',
        ]);

        $recipients = $this->getRecipients($campaign->target_audience);
        $totalRecipients = count($recipients);

        $campaign->update([
            'total_recipients' => $totalRecipients,
        ]);

        $sentCount = 0;
        $failedCount = 0;

        foreach ($recipients as $recipient) {
            $email = $recipient['email'];
            $name = $recipient['name'];
            $storeName = $recipient['store_name'] ?? null;
            $type = $recipient['type'];
            $id = $recipient['id'];

            $login_url = match ($type) {
                'seller' => route('seller.login'),
                'supplier' => route('supplier.login'),
                default => url('/'),
            };

            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                continue;
            }

            if (!empty($recipient['skip_log_creation'])) {
                $log = EmailCampaignLog::where('campaign_id', $campaign->id)
                    ->where('recipient_email', $email)
                    ->first();
            } else {
                $log = EmailCampaignLog::create([
                    'campaign_id' => $campaign->id,
                    'recipient_email' => $email,
                    'recipient_name' => $name,
                    'recipient_type' => $type,
                    'recipient_id' => $id,
                    'status' => 'pending',
                ]);
            }

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
                    'sent_at' => now(),
                ]);

                $sentCount++;
            } catch (\Throwable $e) {
                Log::error("Failed to send campaign email to {$email}: " . $e->getMessage());

                $log->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);

                $failedCount++;
            }
        }

        $campaign->update([
            'status' => 'completed',
            'sent_count' => $sentCount,
            'failed_count' => $failedCount,
            'sent_at' => now(),
        ]);
    }

    /**
     * Get audience recipient list.
     */
    private function getRecipients(string $targetAudience): array
    {
        $recipients = [];

        switch ($targetAudience) {
            case 'all_sellers':
                $sellers = Seller::all();
                foreach ($sellers as $seller) {
                    $recipients[] = [
                        'id' => $seller->id,
                        'name' => $seller->full_name ?: ($seller->first_name . ' ' . $seller->last_name),
                        'email' => $seller->email,
                        'store_name' => $seller->store_name,
                        'type' => 'seller',
                    ];
                }
                break;

            case 'inactive_sellers':
                // Sellers created > 7 days ago or with no products / minimal activity
                $sellers = Seller::where('created_at', '<=', now()->subDays(7))->get();
                foreach ($sellers as $seller) {
                    $recipients[] = [
                        'id' => $seller->id,
                        'name' => $seller->full_name ?: ($seller->first_name . ' ' . $seller->last_name),
                        'email' => $seller->email,
                        'store_name' => $seller->store_name,
                        'type' => 'seller',
                    ];
                }
                break;

            case 'all_suppliers':
                $suppliers = Supplier::all();
                foreach ($suppliers as $supplier) {
                    $recipients[] = [
                        'id' => $supplier->id,
                        'name' => $supplier->full_name ?: ($supplier->first_name . ' ' . $supplier->last_name),
                        'email' => $supplier->email,
                        'store_name' => $supplier->store_name,
                        'type' => 'supplier',
                    ];
                }
                break;

            case 'inactive_suppliers':
                $suppliers = Supplier::where('created_at', '<=', now()->subDays(7))->get();
                foreach ($suppliers as $supplier) {
                    $recipients[] = [
                        'id' => $supplier->id,
                        'name' => $supplier->full_name ?: ($supplier->first_name . ' ' . $supplier->last_name),
                        'email' => $supplier->email,
                        'store_name' => $supplier->store_name,
                        'type' => 'supplier',
                    ];
                }
                break;

            case 'single_email':
                $existingLogs = EmailCampaignLog::where('campaign_id', $this->campaign->id)->get();
                foreach ($existingLogs as $log) {
                    $recipients[] = [
                        'id' => $log->recipient_id,
                        'name' => $log->recipient_name,
                        'email' => $log->recipient_email,
                        'store_name' => null,
                        'type' => $log->recipient_type ?: 'custom',
                        'skip_log_creation' => true,
                    ];
                }
                break;

            case 'all':
            default:
                $sellers = Seller::all();
                foreach ($sellers as $seller) {
                    $recipients[] = [
                        'id' => $seller->id,
                        'name' => $seller->full_name ?: ($seller->first_name . ' ' . $seller->last_name),
                        'email' => $seller->email,
                        'store_name' => $seller->store_name,
                        'type' => 'seller',
                    ];
                }
                $suppliers = Supplier::all();
                foreach ($suppliers as $supplier) {
                    $recipients[] = [
                        'id' => $supplier->id,
                        'name' => $supplier->full_name ?: ($supplier->first_name . ' ' . $supplier->last_name),
                        'email' => $supplier->email,
                        'store_name' => $supplier->store_name,
                        'type' => 'supplier',
                    ];
                }
                break;
        }

        return $recipients;
    }
}
