<?php

namespace App\Http\Controllers\Users\Sellers;

use App\Http\Controllers\Controller;
use App\Models\Seller\SellerProductLandingPage;
use App\Models\Seller\SellerProducts;
use App\Services\AI\GeminiLandingPageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SellerLandingPageController extends Controller
{
    protected GeminiLandingPageService $aiService;

    public function __construct(GeminiLandingPageService $aiService)
    {
        $this->aiService = $aiService;
    }

    /**
     * Get all landing pages for a specific product
     */
    public function index($productId): JsonResponse
    {
        $seller = get_seller_data(auth()->user()->tenant_id);
        $product = SellerProducts::where('seller_id', $seller->id)->findOrFail($productId);

        $landingPages = SellerProductLandingPage::where('product_id', $product->id)
            ->where('seller_id', $seller->id)
            ->orderBy('id', 'desc')
            ->get();

        $remainingCredits = $this->aiService->getUserRemainingCredits(auth()->user());
        $costPerGeneration = $this->aiService->getCreditsCost();

        // Build tenant storefront base URL for landing pages
        $tenantId = auth()->user()->tenant_id;
        $tenantData = get_tenant_data($tenantId);
        $primaryDomain = $tenantData?->domains[0]?->domain ?? null;

        $scheme = request()->server('REQUEST_SCHEME') ?: (request()->getScheme() ?: 'http');
        if ($primaryDomain) {
            $tenantUrl = $scheme . '://' . $primaryDomain;
        } else {
            $host = request()->getHost();
            $tenantUrl = $scheme . '://' . $tenantId . '.' . $host;
        }

        return response()->json([
            'success' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->image ? asset($product->image) : null,
            ],
            'landing_pages' => $landingPages,
            'remaining_credits' => $remainingCredits,
            'cost_per_generation' => $costPerGeneration,
            'tenant_url' => rtrim($tenantUrl, '/'),
        ]);
    }

    /**
     * Generate a new AI landing page for a product
     */
    public function generate(Request $request, $productId): JsonResponse
    {
        $request->validate([
            'marketing_angle' => 'required|string|in:general,pain_relief,gift,luxury,savings,speed,custom',
            'title' => 'nullable|string|max:255',
            'custom_prompt' => 'nullable|string|max:1000',
        ]);

        $user = auth()->user();
        $seller = get_seller_data($user->tenant_id);
        $product = SellerProducts::where('seller_id', $seller->id)->findOrFail($productId);

        $cost = $this->aiService->getCreditsCost();
        $availableCredits = $this->aiService->getUserRemainingCredits($user);

        if ($availableCredits < $cost) {
            return response()->json([
                'success' => false,
                'message' => "رصيد نقاط الذكاء الاصطناعي غير كافٍ. يتطلب توليد الصفحة {$cost} نقاط، ورصيدك الحالي هو {$availableCredits} نقطة. يرجى شحن باقة نقاط للمتابعة.",
                'remaining_credits' => $availableCredits,
                'required_credits' => $cost,
            ], 422);
        }

        // Generate content
        $angle = $request->input('marketing_angle', 'general');
        $customPrompt = $request->input('custom_prompt');
        $content = $this->aiService->generate($product, $angle, $customPrompt);

        // Deduct credits
        $this->aiService->deductCredits($user, $cost);

        // Generate unique slug
        $baseSlug = Str::slug($product->name . '-' . $angle);
        if (empty($baseSlug)) {
            $baseSlug = 'lp-' . $product->id . '-' . Str::random(5);
        }
        $slug = $baseSlug;
        $counter = 1;
        while (SellerProductLandingPage::where('seller_id', $seller->id)->where('slug', $slug)->exists()) {
            $slug = "{$baseSlug}-{$counter}";
            $counter++;
        }

        $title = $request->filled('title')
            ? $request->input('title')
            : "صفحة هبوط: {$product->name} (" . match ($angle) {
                'pain_relief' => 'زاوية حل المشكلة',
                'gift' => 'زاوية الهدية',
                'luxury' => 'زاوية الفخامة',
                'savings' => 'زاوية التوفير',
                'speed' => 'زاوية السرعة',
                'custom' => 'زاوية مخصصة',
                default => 'زاوية عامة',
            } . ")";

        $landingPage = SellerProductLandingPage::create([
            'seller_id' => $seller->id,
            'product_id' => $product->id,
            'title' => $title,
            'slug' => $slug,
            'marketing_angle' => $angle,
            'hero_headline' => $content['hero_headline'] ?? $product->name,
            'hero_subheadline' => $content['hero_subheadline'] ?? $product->short_description,
            'content_json' => $content,
            'theme_settings' => [
                'primary_color' => '#B03882',
                'show_countdown' => true,
                'show_reviews' => true,
            ],
            'status' => 'published',
            'credits_used' => $cost,
        ]);

        $newRemainingCredits = $this->aiService->getUserRemainingCredits($user);

        return response()->json([
            'success' => true,
            'message' => "تم توليد صفحة الهبوط بنجاح وتم خصم {$cost} نقاط من رصيدك.",
            'landing_page' => $landingPage,
            'remaining_credits' => $newRemainingCredits,
        ]);
    }

    /**
     * Get landing page data for editing
     */
    public function edit($id): JsonResponse
    {
        $seller = get_seller_data(auth()->user()->tenant_id);
        $landingPage = SellerProductLandingPage::where('seller_id', $seller->id)->findOrFail($id);

        return response()->json([
            'success' => true,
            'landing_page' => $landingPage,
        ]);
    }

    /**
     * Update landing page content
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'hero_headline' => 'required|string|max:500',
            'hero_subheadline' => 'nullable|string|max:1000',
            'status' => 'required|in:published,draft,paused',
        ]);

        $seller = get_seller_data(auth()->user()->tenant_id);
        $landingPage = SellerProductLandingPage::where('seller_id', $seller->id)->findOrFail($id);

        $content = $landingPage->content_json ?? [];

        // Allow editing benefits, faqs, guarantees if provided
        if ($request->has('benefits') && is_array($request->benefits)) {
            $content['benefits'] = $request->benefits;
        }
        if ($request->has('faqs') && is_array($request->faqs)) {
            $content['faqs'] = $request->faqs;
        }
        if ($request->has('pain_points') && is_array($request->pain_points)) {
            $content['pain_points'] = $request->pain_points;
        }

        $content['hero_headline'] = $request->hero_headline;
        $content['hero_subheadline'] = $request->hero_subheadline;

        $landingPage->update([
            'title' => $request->title,
            'hero_headline' => $request->hero_headline,
            'hero_subheadline' => $request->hero_subheadline,
            'status' => $request->status,
            'content_json' => $content,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث بيانات صفحة الهبوط بنجاح.',
            'landing_page' => $landingPage,
        ]);
    }

    /**
     * Toggle status between published and paused
     */
    public function toggleStatus($id): JsonResponse
    {
        $seller = get_seller_data(auth()->user()->tenant_id);
        $landingPage = SellerProductLandingPage::where('seller_id', $seller->id)->findOrFail($id);

        $newStatus = $landingPage->status === 'published' ? 'paused' : 'published';
        $landingPage->update(['status' => $newStatus]);

        return response()->json([
            'success' => true,
            'new_status' => $newStatus,
            'message' => $newStatus === 'published' ? 'تم تفعيل نشر صفحة الهبوط.' : 'تم إيقاف نشر صفحة الهبوط مؤقتاً.',
        ]);
    }

    /**
     * Delete a landing page
     */
    public function destroy($id): JsonResponse
    {
        $seller = get_seller_data(auth()->user()->tenant_id);
        $landingPage = SellerProductLandingPage::where('seller_id', $seller->id)->findOrFail($id);

        $landingPage->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف صفحة الهبوط بنجاح.',
        ]);
    }
}
