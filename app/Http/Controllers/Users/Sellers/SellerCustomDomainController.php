<?php

declare(strict_types=1);

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Domain;
use App\Services\CloudflareService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class SellerCustomDomainController extends Controller
{
    protected CloudflareService $cloudflareService;

    public function __construct(CloudflareService $cloudflareService)
    {
        $this->cloudflareService = $cloudflareService;
    }

    /**
     * Display seller custom domains management page.
     */
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();
        $tenant = $user->tenant;

        if (!$tenant) {
            return redirect()->route('seller.dashboard')->with('error', 'تعذر العثور على بيانات المتجر.');
        }

        $allDomains = $tenant->domains()->get();

        // Primary subdomain (ends with dzora.net or default host)
        $primaryDomain = $allDomains->first(function ($domain) {
            return str_ends_with($domain->domain, '.dzora.net') || empty($domain->cloudflare_id);
        });

        // Custom domains configured by the seller
        $customDomains = $allDomains->reject(function ($domain) use ($primaryDomain) {
            return $primaryDomain && $domain->id === $primaryDomain->id;
        });

        $fallbackOrigin = $this->cloudflareService->getFallbackOrigin();
        $isConfigured = $this->cloudflareService->isConfigured();

        return view('users.sellers.domain.index', compact(
            'tenant',
            'primaryDomain',
            'customDomains',
            'fallbackOrigin',
            'isConfigured'
        ));
    }

    /**
     * Store and register a new custom domain.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'domain' => [
                'required',
                'string',
                'max:190',
                'regex:/^(?:[a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z0-9][a-z0-9-]{0,61}[a-z0-9]$/i',
            ],
        ], [
            'domain.required' => 'يرجى إدخال اسم الدومين.',
            'domain.regex' => 'صيغة الدومين غير صالحة. يرجى إدخال دومين مثل: store.com أو shop.store.com دون http أو مسارات.',
        ]);

        $rawDomain = strtolower(trim($request->input('domain')));
        // Strip any protocol or trailing slashes if present
        $cleanDomain = preg_replace('#^https?://#', '', $rawDomain);
        $cleanDomain = rtrim($cleanDomain, '/');

        // Check against central domains
        $centralDomains = config('tenancy.central_domains', []);
        if (in_array($cleanDomain, $centralDomains, true) || str_ends_with($cleanDomain, '.dzora.net')) {
            return redirect()->back()->with('error', 'لا يمكن استخدام هذا النطاق كنطاق مخصص.');
        }

        // Check if domain already exists in system
        if (Domain::where('domain', $cleanDomain)->exists()) {
            return redirect()->back()->with('error', 'هذا الدومين مستخدم بالفعل أو تم حجزه مسبقاً.');
        }

        $user = Auth::user();
        $tenant = $user->tenant;

        if (!$tenant) {
            return redirect()->back()->with('error', 'تعذر العثور على المتجر الخاص بك.');
        }

        // Limit custom domains to 1 or 2 per seller
        $existingCount = $tenant->domains()->whereNotNull('cloudflare_id')->count();
        if ($existingCount >= 2) {
            return redirect()->back()->with('error', 'لقد وصلت إلى الحد الأقصى للدومينات المخصصة المسموح بها (2 دومين).');
        }

        // Call Cloudflare for SaaS API
        $cfResult = $this->cloudflareService->createCustomHostname($cleanDomain);

        if (!$cfResult['success']) {
            $errorMessage = !empty($cfResult['errors'])
                ? implode(' - ', $cfResult['errors'])
                : 'حدث خطأ أثناء تسجيل الدومين في Cloudflare.';

            return redirect()->back()->withInput()->with('error', $errorMessage);
        }

        try {
            $tenant->domains()->create([
                'domain' => $cleanDomain,
                'cloudflare_id' => $cfResult['id'],
                'status' => $cfResult['status'] ?? 'pending',
                'ssl_status' => $cfResult['ssl_status'] ?? 'pending_validation',
                'verification_errors' => !empty($cfResult['errors']) ? json_encode($cfResult['errors'], JSON_UNESCAPED_UNICODE) : null,
            ]);

            return redirect()->back()->with('success', 'تم ربط الدومين بنجاح! يرجى إضافة سجل CNAME في لوحة تحكم مزود الدومين الخاص بك وفق التعليمات أدناه.');
        } catch (\Throwable $e) {
            Log::error("Failed to save custom domain to database: " . $e->getMessage());

            // Rollback in Cloudflare if DB save fails
            if (!empty($cfResult['id'])) {
                $this->cloudflareService->deleteCustomHostname($cfResult['id']);
            }

            return redirect()->back()->withInput()->with('error', 'حدث خطأ أثناء حفظ بيانات الدومين: ' . $e->getMessage());
        }
    }

    /**
     * Check and refresh Cloudflare status for a custom domain.
     */
    public function checkStatus(int $id): RedirectResponse
    {
        $user = Auth::user();
        $tenant = $user->tenant;

        if (!$tenant) {
            return redirect()->back()->with('error', 'تعذر العثور على بيانات المتجر.');
        }

        $domain = $tenant->domains()->where('id', $id)->first();

        if (!$domain) {
            return redirect()->back()->with('error', 'الدومين المطلوب غير موجود.');
        }

        if (empty($domain->cloudflare_id)) {
            return redirect()->back()->with('error', 'هذا الدومين ليس دوميناً مخصصاً.');
        }

        $cfResult = $this->cloudflareService->getCustomHostname($domain->cloudflare_id);

        if ($cfResult['success']) {
            $domain->update([
                'status' => $cfResult['status'] ?? $domain->status,
                'ssl_status' => $cfResult['ssl_status'] ?? $domain->ssl_status,
            ]);

            $statusText = $domain->status === 'active' ? 'نشط ويعمل' : 'قيد التحقق (Pending)';
            return redirect()->back()->with('success', "تم تحديث حالة الدومين: {$statusText}");
        }

        return redirect()->back()->with('error', 'تعذر التحقق من حالة الدومين من مزود الخدمة حالياً.');
    }

    /**
     * Delete a custom domain.
     */
    public function destroy(int $id): RedirectResponse
    {
        $user = Auth::user();
        $tenant = $user->tenant;

        if (!$tenant) {
            return redirect()->back()->with('error', 'تعذر العثور على بيانات المتجر.');
        }

        $domain = $tenant->domains()->where('id', $id)->first();

        if (!$domain) {
            return redirect()->back()->with('error', 'الدومين المطلوب غير موجود.');
        }

        // Prevent deleting the primary subdomain
        if (empty($domain->cloudflare_id) && str_ends_with($domain->domain, '.dzora.net')) {
            return redirect()->back()->with('error', 'لا يمكن حذف الدومين الأساسي للمتجر.');
        }

        // Delete from Cloudflare
        if (!empty($domain->cloudflare_id)) {
            $this->cloudflareService->deleteCustomHostname($domain->cloudflare_id);
        }

        $domain->delete();

        return redirect()->back()->with('success', 'تم حذف الدومين المخصص بنجاح.');
    }
}
