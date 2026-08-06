<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
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

        return view('admins.admin.email_campaigns.create', compact(
            'sellerCount',
            'inactiveSellerCount',
            'supplierCount',
            'inactiveSupplierCount',
            'totalUserCount'
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
            'target_audience' => 'required|string|in:all,all_sellers,inactive_sellers,all_suppliers,inactive_suppliers',
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

        // Dispatch background queue job
        SendEmailCampaignJob::dispatch($campaign);

        Alert::success('نجاح', 'تم إضافة حملة البريد الإلكتروني بنجاح وبدأ الإرسال في الخلفية.');

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
                    'متجر تجريبي'
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
}
