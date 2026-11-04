<?php

namespace App\Http\Controllers\Admins\Admin;

use App\Http\Controllers\Controller;
use App\Models\MarketingPost;
use App\AiAgents\PlatformMarketingAgent;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Log;

class AiMarketingController extends Controller
{
    /**
     * عرض قائمة المنشورات والمقالات التسويقية المولدة بالذكاء الاصطناعي
     */
    public function index(Request $request)
    {
        $query = MarketingPost::latest();

        if ($request->filled('platform')) {
            $query->where('platform', $request->platform);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $posts = $query->paginate(10);

        $stats = [
            'total' => MarketingPost::count(),
            'approved' => MarketingPost::where('status', 'approved')->count(),
            'draft' => MarketingPost::where('status', 'draft')->count(),
            'published' => MarketingPost::where('status', 'published')->count(),
        ];

        return view('admins.admin.ai_marketing.index', compact('posts', 'stats'));
    }

    /**
     * تشغيل الوكيل الذكي لتوليد منشور/مقال تسويقي جديد
     */
    public function generate(Request $request)
    {
        $request->validate([
            'goal' => 'nullable|string|max:500',
            'platform' => 'required|in:facebook,instagram,linkedin,blog',
            'tone' => 'required|in:inspiring,professional,algerian_dialect,informative',
        ]);

        $platform = $request->input('platform', 'facebook');
        $tone = $request->input('tone', 'inspiring');
        $goal = $request->input('goal');

        // صياغة الطلب للوكيل
        $promptMessage = "قم بتحليل أرقام وبيانات المنصة واستطلع أحدث التريندات، ثم قم بصياغة محتوى تسويقي لمنصة [{$platform}].\n";
        $promptMessage .= "النبرة المطلوبة: [{$tone}].\n";

        if (!empty($goal)) {
            $promptMessage .= "الهدف الخاص بالمنشور: {$goal}\n";
        } else {
            $promptMessage .= "الهدف: تشجيع التجار وأصحاب المشاريع والشباب الجزائري على إطلاق متاجرهم والانضمام لـ dzora.net والاستفادة من عروض الشحن والدروبشيبينغ.\n";
        }

        $promptMessage .= "يرجى تقديم محتوى كامل يتضمن: عنواناً جذاباً، نص المنشور، وهاشتاغات مقترحة.\n";

        try {
            $agent = new PlatformMarketingAgent();
            
            // استدعاء الوكيل الذكي
            $agentResponse = $agent->respond($promptMessage);
            $generatedContent = is_object($agentResponse) && method_exists($agentResponse, 'getContent') 
                ? $agentResponse->getContent() 
                : (string)$agentResponse;

            if (empty(trim($generatedContent))) {
                throw new \Exception('لم يقم النموذج بإرجاع أي محتوى. يرجى التأكد من مفتاح الـ API في ملف .env.');
            }

            // استخراج العنوان إن وجد
            $title = null;
            $lines = explode("\n", trim($generatedContent));
            if (!empty($lines)) {
                $firstLine = trim(str_replace(['#', '*', 'العنوان:', 'عنوان:'], '', $lines[0]));
                $title = mb_substr($firstLine, 0, 150);
            }

            // حفظ المنشور في قاعدة البيانات
            MarketingPost::create([
                'title' => $title ?: 'منشور تسويقي لـ ' . ucfirst($platform),
                'content' => $generatedContent,
                'platform' => $platform,
                'prompt_used' => $promptMessage,
                'source_data_summary' => 'تم استدعاء بيانات المنصة عبر PlatformAnalyticsTool',
                'status' => 'draft',
            ]);

            Alert::success('تم التوليد بنجاح', 'قام الوكيل الذكي بتحليل البيانات وصياغة المنشور التسويقي بنجاح!');
            return redirect()->back();

        } catch (\Throwable $e) {
            Log::error('AI Marketing Agent Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);

            Alert::error('خطأ أثناء التوليد', 'حدث خطأ: ' . $e->getMessage() . ' (تأكد من إعداد مفتاح API في ملف .env)');
            return redirect()->back()->withInput();
        }
    }

    /**
     * تحديث حالة المنشور (اعتماد / نشر / مسودة)
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:draft,approved,published,rejected',
        ]);

        $post = MarketingPost::findOrFail($id);
        $post->status = $request->status;

        if ($request->status === 'published' && !$post->published_at) {
            $post->published_at = now();
        }

        $post->save();

        Alert::success('تم التحديث', 'تم تغيير حالة المنشور بنجاح.');
        return redirect()->back();
    }

    /**
     * حذف منشور تسويقي
     */
    public function destroy($id)
    {
        $post = MarketingPost::findOrFail($id);
        $post->delete();

        Alert::success('تم الحذف', 'تم حذف المنشور بنجاح.');
        return redirect()->back();
    }
}
