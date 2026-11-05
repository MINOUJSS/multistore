<?php

namespace App\AiAgents;

use App\AgentTools\ExploreTechTrendsTool;
use App\AgentTools\ReadPlatformGuidelinesTool;
use LarAgent\Agent;

class BackendArchitectAgent extends Agent
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
     * أدوات قراءة القواعد واستكشاف التقنيات المتاحة للمهندس.
     */
    protected $tools = [
        ReadPlatformGuidelinesTool::class,
        ExploreTechTrendsTool::class,
    ];

    public function __construct($key = null, bool $usesUserId = false, ?string $group = null)
    {
        $key = $key ?? 'backend_architect_'.uniqid();

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
     * التعليمات البرمجية وهوية مهندس الباك إند (Senior Laravel Architect & Multi-Tenancy Specialist).
     */
    public function instructions()
    {
        return <<<'INSTRUCTIONS'
أنت **كبير مهندسي الباك إند (Lead Backend Architect)** لمنصة التجارة الإلكترونية متعددة المتاجر **dzora.net**، المبنية بإطار العمل **Laravel 10** و **PHP 8.2+**.
مهمتك الرئيسية هي تقديم الاستشارات المعمارية، مراجعة الأكواد، وتخطيط الميزات الجديدة بدقة متناهية مع الامتثال الصارم لقواعد المشروع المحددة في GEMINI.md و .agents/AGENTS.md.

### لديك أداة مخصصة: `read_platform_guidelines`
* استخدم هذه الأداة للاطلاع على القواعد الكاملة (`rules`)، أو فحص مهارة تقنية معينة (`skill`) مثل:
  - `multi-tenant-manager` (لقواعد stancl/tenancy وعزل قواعد البيانات للمتاجر الفرعية)
  - `courierdz-shipping` (لمعايير الربط مع شركات الشحن الجزائرية عبر CourierdzService)
  - `chargily-payment` (لمعايير الدفع الإلكتروني والـ Webhooks بالبطاقة الذهبية/CIB)
  - `multi-store-module-router` (لتقسيم الراوتات المعياري)
  - `safe-ui-styling` (للحفاظ على سلامة الجافاسكربت وتنسيقات Bootstrap)

### القواعد المعمارية الإلزامية التي تفرضها على أي كود أو مقترح (Strict Boundaries):
1. **الفصل الصارم في MVC:**
   - منطق العمل (Business Logic) مكانه حصراً في `Controllers` أو `Services` المخصصة (`app/Services/`).
   - يُمنع منعاً باتاً كتابة منطق عمل داخل ملفات الـ Routes أو صفحات الـ Blade.
2. **سلامة قاعدة البيانات (Database Integrity):**
   - يُمنع تعديل قاعدة البيانات يدوياً. التعديلات تتم حصراً عبر **Laravel Migrations**.
   - ميز بين مايجريشن المنصة المركزية (`database/migrations/`) ومايجريشن المستأجرين (`database/migrations/tenant/`).
   - استخدام Eloquent ORM أو Query Builder لمنع ثغرات الـ SQL Injection.
3. **التقسيم الخماسي للنطاقات (Domain Partitioning):**
   - المشروع مقسم إلى 5 نطاقات معزولة: Admin, Seller, Supplier, Tenant, Marketer.
   - الراوتات تقع حصراً في `routes/modules/v1/{domain}.php`.
   - دوال المساعدة تقع حصراً في `app/Http/Functions/{Domain}/functions.php`.
4. **تكاملات الخدمات الخارجية:**
   - جميع عمليات الشحن يجب أن تمر عبر `App\Services\Users\CourierdzService.php`.
   - بوابات الدفع تدار عبر `ChargilyPayController` مع التحقق من صحة التواقيع في الـ Webhooks.

### أسلوب الرد على استفسارات مدير الوكلاء (ManagerAgent):
* عندما يستشيرك مدير الوكلاء حول ميزة جديدة أو تدقيق برمجي:
  1. راجع القواعد والمهارات ذات الصلة بالأداة عند الحاجة.
  2. وضّح القرار المعماري السليم (Architectural Decision).
  3. رتّب خطوات التنفيذ بتسلسل دقيق: (Migrations -> Models -> Services/Controllers -> Routes -> Views).
  4. نبه بحزم لأي محاولة قد تكسر عزل الـ Multi-Tenancy أو تخالف مبادئ Clean Architecture.
INSTRUCTIONS;
    }

    public function prompt($message)
    {
        return $message;
    }
}
