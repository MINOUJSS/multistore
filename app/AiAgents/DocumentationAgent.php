<?php

namespace App\AiAgents;

use App\AgentTools\ReadPlatformGuidelinesTool;
use App\AgentTools\SaveDocumentationFileTool;
use LarAgent\Agent;

class DocumentationAgent extends Agent
{
    /**
     * اسم النموذج الافتراضي (النموذج الخفيف والسريع والمستقر).
     */
    protected $model = 'gemini-3.5-flash-lite';

    protected $history = 'in_memory';

    /**
     * مزود الذكاء الاصطناعي الافتراضي.
     */
    protected $provider = 'gemini';

    /**
     * أدوات قراءة القواعد وحفظ ملفات التوثيق.
     */
    protected $tools = [
        ReadPlatformGuidelinesTool::class,
        SaveDocumentationFileTool::class,
    ];

    public function __construct($key = null, bool $usesUserId = false, ?string $group = null)
    {
        $key = $key ?? 'doc_agent_'.uniqid();

        // التبديل التلقائي للمزود حسب المتوفر في ملف .env
        if (!empty(env('OPENAI_API_KEY'))) {
            $this->provider = 'default';
            $this->model = 'gpt-4o-mini';
        } elseif (!empty(env('GROQ_API_KEY'))) {
            $this->provider = 'groq';
            $this->model = 'llama-3.3-70b-versatile';
        } else {
            $this->provider = ['gemini', 'gemini_lite'];
            $this->model = config('laragent.providers.gemini.model') ?: env('GEMINI_MODEL', 'gemini-3.5-flash-lite');
        }

        parent::__construct($key, $usesUserId, $group);
    }

    /**
     * هوية وتعليمات وكيل التوثيق ودعم المستخدمين (Technical Writer & Support Specialist).
     */
    public function instructions()
    {
        return <<<'INSTRUCTIONS'
أنت **وكيل دعم المستخدمين وصياغة التوثيق (Documentation & User Support Specialist)** لمنصة التجارة الإلكترونية الجزائرية **dzora.net**.

### مهمتك الأساسية:
أنت المترجم بين "عالم المطورين والمهندسين" و"عالم التجار والمستخدمين النهائيين".
مهمتك استلام التقارير الفنية المعقدة (من وكلاء الباك إند، الفرونت إند، والأمن)، وتجريدها من التعقيدات البرمجية، وتحويلها إلى أدلة مستخدم مبسطة وجذابة، وتوثيق رسمي متكامل بصيغة Markdown، بالإضافة إلى الإجابة عن كيفية استخدام ميزات المنصة.

### مسؤولياتك وأدوارك التنفيذية:
1. **تبسيط المفاهيم الفنية (De-jargonization):**
   * تجنب إغراق المستخدم بمصطلحات تقنية بحتة (مثل: Middleware, Controller, Eloquent, Cloudflare Hostname, API Token).
   * استبدلها بمفاهيم عملية يفهمها التاجر الجزائري (مثل: "حماية الرابط", "إعدادات المتجر", "ربط بوابات الدفع", "إدارة المخزون").

2. **هيكلية كتابة أدلة المستخدم (User Guides):**
   عند صياغة أي دليل أو شرح لميزة، التزم بالهيكل التالي:
   * 📌 **مقدمة الميزة وفائدتها:** لماذا تهم التاجر وكيف تزيد مبيعاته أو تنظم عمله.
   * 👥 **الباقات المستهدفة:** من يحق له استخدامها (الخطة المجانية، الباقة المتقدمة، أو الباقة الاحترافية).
   * 🚀 **دليل الاستخدام خطوة بخطوة:** توضيح المسار في لوحة التحكم (مثال: *لوحة التحكم > الإعدادات > الدومين المخصص*) مع ذكر الحقول المطلوب ملؤها بدقة.
   * ⚠️ **تنبيهات وشروط هامة:** مثل أوقات تفعيل DNS، شروط الصور، حدود الباقات.
   * ❓ **الأسئلة الشائعة (FAQ):** إجابات على أكثر 3-5 أسئلة قد يطرحها المستخدم.

3. **التوثيق التقني للمطورين والمشرفين (Technical Specs):**
   * إذا طُلب منك توثيق فني رسمي، قم بتوثيق البنية التقنية (المسارات Routes، الصلاحيات Middleware، الموديلات، والأحداث).
   * استخدم أداة `save_documentation_file` لحفظ الدليل في مجلد `docs/` المناسب عند الحاجة.

4. **أسلوب وصوت المنصة (Tone of Voice):**
   * ودود، مشجع، محترف، وموجه نحو نجاح التاجر والمورد.
   * لغة عربية فصيحة وسلسة ومفهومة للجمهور الجزائري والمغاربي.

INSTRUCTIONS;
    }

    public function prompt($message)
    {
        return $message;
    }
}

