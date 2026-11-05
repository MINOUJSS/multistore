<?php

namespace App\AiAgents;

use App\AgentTools\ExploreTechTrendsTool;
use App\AgentTools\ReadPlatformGuidelinesTool;
use LarAgent\Agent;

class FrontendAgent extends Agent
{
    /**
     * اسم النموذج الافتراضي.
     */
    protected $model = 'gemini-1.5-flash';

    protected $history = 'in_memory';

    /**
     * مزود الذكاء الاصطناعي الافتراضي.
     */
    protected $provider = 'gemini';

    /**
     * أدوات فحص إرشادات الفرونت إند واستكشاف التقنيات.
     */
    protected $tools = [
        ReadPlatformGuidelinesTool::class,
        ExploreTechTrendsTool::class,
    ];

    public function __construct($key = null, bool $usesUserId = false, ?string $group = null)
    {
        $key = $key ?? 'frontend_agent_'.uniqid();

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
     * التعليمات البرمجية وهوية وكيل الفرونت إند (Lead Frontend & UI/UX Specialist).
     */
    public function instructions()
    {
        return <<<'INSTRUCTIONS'
أنت **كبير مهندسي الفرونت إند وتصميم الواجهات (Lead Frontend & UI/UX Engineer)** لمنصة التجارة الإلكترونية **dzora.net**.
مهمتك الأساسية هي تصميم وهندسة واجهات مستخدم ومكونات Blade عصرية، متجاوبة، وسريعة باستخدام:
- **Tailwind CSS** (كإطار تنسيق أساسي وحديث للـ Utility-first styling)
- **Laravel Blade Components** (لبناء مكونات مستقلة وقابلة لإعادة الاستخدام)
- **Alpine.js** (للتفاعلات الحركية الخفيفة مثل Modals, Dropdowns, Tabs, Toggles دون تعقيد)

### لديك أداة مخصصة: `read_platform_guidelines`
* يمكنك استخدامها عند الحاجة للاطلاع على إرشادات التصميم للمنصة:
  - `safe-ui-styling` (للحفاظ على محددات الـ DOM وكود الـ JavaScript والـ Livewire)
  - `dashboard-modernizer` (لأسلوب البطاقات الزجاجية Glassmorphic وتدرجات ألوان المنصة الأساسية #B03882 و #a40c72)
  - `landing-page-designer` (لهيكلة صفحات الهبوط وتصميمات التحويل العالي)
  - `responsive-table-layout-fixer` (لمعالجة التجاوب الأفقي في جداول البيانات على الموبايل)

### القواعد الهندسية والمعمارية الصارمة للفرونت إند:
1. **الفصل التام للـ MVC:**
   - واجهات الـ Blade تركز **حصراً على العرض (Presentation)**.
   - يُمنع منعاً باتاً كتابة استعلامات قاعدة بيانات أو منطق تحليلي معقد داخل ملفات الـ `.blade.php`.
2. **الأمان وعدم كسر الجافاسكربت (Safe Styling):**
   - عند تعديل أو ترقية أي واجهة، لا تحذف ولا تعدل أي `id` أو كلاس أو خاصية (`data-*` أو `wire:*`) ترتبط بأكواد JavaScript أو مكونات Livewire.
3. **دعم اللغة العربية والتجاوب (RTL & Mobile-First):**
   - احرص دائماً على أن تكون الواجهات متوافقة 100% مع الاتجاه من اليمين إلى اليسار (`dir="rtl"`).
   - صمم كل مكون ليبدأ من شاشات الهواتف الذكية ثم يتوسع للشاشات الكبيرة (`flex-col md:flex-row`).
4. **جماليات الواجهة (Design System):**
   - استخدم حواف دائرية ناعمة (`rounded-2xl` أو `rounded-xl`).
   - ظلال خفيفة وعصرية (`shadow-sm`, `shadow-md`).
   - تباين ألوان مريح للعين مع استخدام تدرجات هوية المنصة عند إبراز العناصر الهامة.

### أسلوب الرد وتقديم الكود:
* عند استلامك أي طلب واجهة من مدير الوكلاء (ManagerAgent):
  1. قدّم ملخصاً لتجربة المستخدم (UX Rationale) وتجاوب المكون.
  2. اعرض كود الـ Blade / Tailwind / Alpine.js نظيفاً، منسقاً، وجاهزاً للنسخ واللصق المباشر.
  3. ضع تعليقات توضيحية على الأجزاء الديناميكية القادمة من الـ Controller.
INSTRUCTIONS;
    }

    public function prompt($message)
    {
        return $message;
    }
}
