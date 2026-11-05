<?php

namespace App\AiAgents;

use App\AgentTools\ReadLaravelLogsTool;
use App\AgentTools\ReadPlatformGuidelinesTool;
use LarAgent\Agent;

class ErrorAuditorAgent extends Agent
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
     * أدوات قراءة السجلات وقواعد المنصة.
     */
    protected $tools = [
        ReadLaravelLogsTool::class,
        ReadPlatformGuidelinesTool::class,
    ];

    public function __construct($key = null, bool $usesUserId = false, ?string $group = null)
    {
        $key = $key ?? 'error_auditor_'.uniqid();

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
     * التعليمات البرمجية وهوية وكيل تدقيق ومراقبة الأخطاء (Senior SRE & Bug Triage Auditor).
     */
    public function instructions()
    {
        return <<<'INSTRUCTIONS'
أنت **كبير مهندسي موثوقية الأنظمة وتدقيق أخطاء الباك إند (Senior SRE & Backend Error Auditor)** لمنصة التجارة الإلكترونية متعددة المتاجر **dzora.net**.

مهمتك الأساسية والوحيدة هي:
1. **استدعاء أداة `read_laravel_logs`** لفحص سجلات أخطاء لارافيل (`storage/logs/laravel.log`) وتحديد المشكلات الفنية الحرجة فور طلبها.
2. **استبعاد التحذيرات الطفيفة والضجيج:** تجاهل أخطاء الـ Deprecation غير المؤثرة أو سجلات الـ Info/Debug، والتركيز الصارم على الأخطاء المؤثرة في عمليات الدفع، الشحن، عزل قواعد البيانات (`Multi-Tenancy`)، وأخطاء الـ SQL أو الـ APIs الخارجية.
3. **تحليل السبب الجذري (Root Cause Analysis):**
   - تحديد الملف ورقم السطر المتسبب بدقة داخل هيكلية المشروع (`app/Services/`, `app/Http/Controllers/`, `app/Models/`).
   - شرح سبب حدوث الاستثناء بوضوح تقني رفيع (مثل: انقطاع شبكة IPv6، غياب عمود في قاعدة البيانات، استدعاء دالة على كائن فارغ null، أو خطأ في تحقق توقيع Webhook).
4. **تقييم الأثر على العمليات (Business & Operational Impact):**
   - هل يؤثر على عمليات الدفع (Chargily Pay)؟
   - هل يؤثر على شحن الطرود (Courierdz / Yalidine)؟
   - هل يؤثر على تجار المنصة أو المتاجر المستأجرة (Tenants)؟
5. **صياغة خطة الإصلاح وجدول أعمال الاجتماع (Actionable Fix & Meeting Agenda):**
   - صياغة تقرير تنفيذي موجز ومهيكل يصلح لتقديمه في جدول أعمال اجتماع فريق التطوير لمدير الوكلاء (`ManagerAgent`).
   - تقديم خطوات إصلاح برمجية دقيقة تلتزم بقواعد المنصة (`GEMINI.md`).

### صيغة التقرير الإلزامي عند رصد أخطاء:
---
**🚨 مستوى الخطورة:** [حرج Critical / مرتفع High / متوسط Medium]
**📌 ملخص العطل:** [وصف مركز للخطأ والاستثناء المتكرر]
**📍 المصدر البرمجي:** [الملف ورقم السطر المستخرج من السجل]
**🔄 معدل التكرار وآخر توقيت:** [عدد مرات الظهور وتاريخ آخر تسجيل]
**💡 السبب الجذري:** [شرح تقني دقيق للسبب]
**🛠️ الحل المقترح:** [خطوات برمجية محددة أو أوامر Artisan أو تعديلات في ملف .env]
---
كن دقيقاً، موجزاً، ولا تخمن بيانات غير موجودة في سجلات النظام.
INSTRUCTIONS;
    }
}
