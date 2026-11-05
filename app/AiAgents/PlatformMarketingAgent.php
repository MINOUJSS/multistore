<?php

namespace App\AiAgents;

use App\AgentTools\PlatformAnalyticsTool;
use App\AgentTools\WebSearchTrendsTool;
use LarAgent\Agent;

class PlatformMarketingAgent extends Agent
{
    /**
     * اسم النموذج الافتراضي.
     */
    protected $model = 'gemini-1.5-flash';

    protected $history = 'in_memory';

    /**
     * مزود الذكاء الاصطناعي.
     */
    protected $provider = 'gemini';

    /**
     * الأدوات المتاحة للوكيل.
     */
    protected $tools = [
        PlatformAnalyticsTool::class,
        WebSearchTrendsTool::class,
    ];

    public function __construct($key = null, bool $usesUserId = false, ?string $group = null)
    {
        $key = $key ?? 'marketing_agent_'.uniqid();

        // التبديل التلقائي للمزود حسب المتوفر في ملف .env
        if (!empty(env('OPENAI_API_KEY'))) {
            $this->provider = 'default';
            $this->model = 'gpt-4o-mini';
        } elseif (!empty(env('GROQ_API_KEY'))) {
            $this->provider = 'groq';
            $this->model = 'llama-3.3-70b-versatile';
        } else {
            $this->provider = 'gemini';
            $this->model = 'gemini-1.5-flash';
        }

        parent::__construct($key, $usesUserId, $group);
    }

    /**
     * التعليمات البرمجية وهوية الوكيل (System Instructions).
     */
    public function instructions()
    {
        return <<<'INSTRUCTIONS'
أنت خبير تسويق بالمحتوى ومتخصص في نمو منصات التجارة الإلكترونية لمنصة **dzora.net** الجزائرية.
منصة dzora.net هي منصة SaaS متعددة التجار (Multi-vendor) تتيح:
1. لكل تاجر الحصول على متجره الإلكتروني الخاص بنطاق مستقل أو فرعي.
2. ربط فوري مع شركات الشحن الجزائرية (Yalidine, ZrExpress, وغيرها).
3. دفع إلكتروني بالبطاقة الذهبية و CIB عبر Chargily Pay بالإضافة للدفع عند الاستلام.
4. شبكة موردين وتجار جملة تمكن التجار من الدروبشيبينغ المحلي دون الحاجة لشراء المخزون مسبقاً.

مهامك:
1. عند طلب كتابة منشور أو مقال تسويقي، قم أولاً باستدعاء أداة الإحصائيات `platform_analytics` للحصول على أرقام وحقائق حقيقية عن المنصة.
2. يمكنك استدعاء أداة البحث `web_search_trends` للاطلاع على تريندات السوق واهتمامات التجار والمتسوقين في الجزائر.
3. اكتب محتوى جذاباً، احترافياً، وبلهجة جزائرية مفهومة أو عربية تسويقية فصيحة ومقنعة (Copywriting)، يركز على الفائدة الملموسة للتاجر (حل مشكلة التوصيل، سهولة إطلاق المتجر، وفرص الربح).
4. اختم المنشور دائماً بدعوة واضحة لاتخاذ إجراء (Call to Action) تدعو للتسجيل في منصة dzora.net مع هاشتاغات ذكية ومناسبة للمنصات (فيسبوك، إنستغرام، لينكدإن).
INSTRUCTIONS;
    }

    public function prompt($message)
    {
        return $message;
    }
}
