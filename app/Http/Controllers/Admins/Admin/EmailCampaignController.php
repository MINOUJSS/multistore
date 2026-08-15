<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\ResendFailedEmailCampaignJob;
use App\Jobs\SendEmailCampaignJob;
use App\Mail\Admin\ReEngagementCampaignMail;
use App\Models\EmailCampaign;
use App\Models\EmailCampaignLog;
use App\Models\Seller\Seller;
use App\Models\Supplier\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use RealRashid\SweetAlert\Facades\Alert;

class EmailCampaignController extends Controller
{
    /**
     * Display a listing of email campaigns.
     */
    public function index()
    {
        $campaigns = EmailCampaign::with('admin')->orderBy('id', 'desc')->paginate(10);
        $totalCampaigns = EmailCampaign::count();
        $totalSentCount = EmailCampaign::sum('sent_count');
        $totalRecipientsCount = EmailCampaign::sum('total_recipients');

        return view('admins.admin.email_campaigns.index', compact(
            'campaigns',
            'totalCampaigns',
            'totalSentCount',
            'totalRecipientsCount'
        ));
    }

    /**
     * Show the form for creating a new campaign.
     */
    public function create()
    {
        // Calculate counts for recipient audiences
        $sellerCount = Seller::count();
        $inactiveSellerCount = Seller::where('created_at', '<=', now()->subDays(7))->count();
        $supplierCount = Supplier::count();
        $inactiveSupplierCount = Supplier::where('created_at', '<=', now()->subDays(7))->count();
        $totalUserCount = $sellerCount + $supplierCount;

        // Registered platform user emails for autocomplete
        $registeredUsers = collect();

        $sellers = Seller::select('id', 'email', 'full_name', 'first_name', 'last_name', 'store_name')->get();
        foreach ($sellers as $seller) {
            $registeredUsers->push([
                'email' => $seller->email,
                'name' => $seller->full_name ?: ($seller->first_name . ' ' . $seller->last_name),
                'store' => $seller->store_name,
                'type' => 'بائع (Seller)',
            ]);
        }

        $suppliers = Supplier::select('id', 'email', 'full_name', 'first_name', 'last_name', 'store_name')->get();
        foreach ($suppliers as $supplier) {
            $registeredUsers->push([
                'email' => $supplier->email,
                'name' => $supplier->full_name ?: ($supplier->first_name . ' ' . $supplier->last_name),
                'store' => $supplier->store_name,
                'type' => 'مورد (Supplier)',
            ]);
        }

        return view('admins.admin.email_campaigns.create', compact(
            'sellerCount',
            'inactiveSellerCount',
            'supplierCount',
            'inactiveSupplierCount',
            'totalUserCount',
            'registeredUsers'
        ));
    }

    /**
     * Store a newly created campaign and trigger sending.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'target_audience' => 'required|string|in:all,all_sellers,inactive_sellers,all_suppliers,inactive_suppliers,single_email',
            'custom_email' => 'required_if:target_audience,single_email|nullable|email|max:255',
            'custom_name' => 'nullable|string|max:255',
            'content' => 'required|string',
        ]);

        $adminId = Auth::guard('admin')->id();

        // Calculate expected target count
        $expectedCount = match ($request->target_audience) {
            'all_sellers' => Seller::count(),
            'inactive_sellers' => Seller::where('created_at', '<=', now()->subDays(7))->count(),
            'all_suppliers' => Supplier::count(),
            'inactive_suppliers' => Supplier::where('created_at', '<=', now()->subDays(7))->count(),
            'all' => Seller::count() + Supplier::count(),
            'single_email' => 1,
            default => 0,
        };

        $campaign = EmailCampaign::create([
            'admin_id' => $adminId,
            'title' => $request->title,
            'subject' => $request->subject,
            'content' => $request->content,
            'target_audience' => $request->target_audience,
            'status' => 'queued',
            'total_recipients' => $expectedCount,
        ]);

        // If single_email target, pre-create the log entry
        if ($request->target_audience === 'single_email') {
            $targetEmail = trim($request->custom_email);
            $targetName = $request->custom_name;

            // Lookup if recipient is registered
            $seller = Seller::where('email', $targetEmail)->first();
            $supplier = Supplier::where('email', $targetEmail)->first();

            $recipientType = 'custom';
            $recipientId = null;

            if ($seller) {
                $recipientType = 'seller';
                $recipientId = $seller->id;
                $targetName = $targetName ?: ($seller->full_name ?: ($seller->first_name . ' ' . $seller->last_name));
            } elseif ($supplier) {
                $recipientType = 'supplier';
                $recipientId = $supplier->id;
                $targetName = $targetName ?: ($supplier->full_name ?: ($supplier->first_name . ' ' . $supplier->last_name));
            }

            EmailCampaignLog::create([
                'campaign_id' => $campaign->id,
                'recipient_email' => $targetEmail,
                'recipient_name' => $targetName ?: 'مستلم مخصص',
                'recipient_type' => $recipientType,
                'recipient_id' => $recipientId,
                'status' => 'pending',
            ]);
        }

        // Dispatch background queue job
        SendEmailCampaignJob::dispatch($campaign);

        Alert::success('نجاح', 'تم إضافة رسالة البريد بنجاح وبدأ الإرسال.');

        return redirect()->route('admin.email_campaigns.index');
    }

    /**
     * Display campaign details and logs.
     */
    public function show($id)
    {
        $campaign = EmailCampaign::with('admin')->findOrFail($id);
        $logs = EmailCampaignLog::where('campaign_id', $id)->orderBy('id', 'desc')->paginate(15);

        return view('admins.admin.email_campaigns.show', compact('campaign', 'logs'));
    }

    /**
     * Remove campaign.
     */
    public function destroy($id)
    {
        $campaign = EmailCampaign::findOrFail($id);
        $campaign->delete();

        Alert::success('نجاح', 'تم حذف الحملة البريدية بنجاح.');

        return redirect()->route('admin.email_campaigns.index');
    }

    /**
     * Send a test preview email to admin's email.
     */
    public function sendTestMail(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
            'test_email' => 'required|email',
        ]);

        try {
            Mail::to($request->test_email)->send(
                new ReEngagementCampaignMail(
                    $request->subject,
                    $request->content,
                    'مستخدم تجريبي',
                    'متجر تجريبي',
                    route('seller.login')
                )
            );

            return response()->json([
                'success' => true,
                'message' => 'تم إرسال البريد التجريبي بنجاح إلى ' . $request->test_email,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'فشل إرسال البريد التجريبي: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Resend only failed messages for a campaign.
     */
    public function resendFailed($id)
    {
        $campaign = EmailCampaign::findOrFail($id);

        $failedLogsCount = EmailCampaignLog::where('campaign_id', $campaign->id)
            ->where('status', 'failed')
            ->count();

        if ($failedLogsCount === 0 && $campaign->failed_count === 0) {
            Alert::info('تنبيه', 'لا توجد رسائل فاشلة لإعادة إرسالها لهذه الحملة.');
            return redirect()->back();
        }

        ResendFailedEmailCampaignJob::dispatch($campaign);

        Alert::success('نجاح', 'بدأت عملية إعادة إرسال الرسائل الفاشلة بنجاح.');

        return redirect()->back();
    }
}
