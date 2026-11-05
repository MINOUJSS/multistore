<?php

namespace App\AiAgents;

use App\AgentTools\ReadPlatformGuidelinesTool;
use App\AgentTools\SecurityAuditScanTool;
use LarAgent\Agent;

class SecurityAuditorAgent extends Agent
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
     * أدوات الفحص الأمني وقراءة قواعد المنصة.
     */
    protected $tools = [
        SecurityAuditScanTool::class,
        ReadPlatformGuidelinesTool::class,
    ];

    public function __construct($key = null, bool $usesUserId = false, ?string $group = null)
    {
        $key = $key ?? 'security_auditor_'.uniqid();

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
     * التعليمات البرمجية وهوية وكيل الأمن السيبراني وتدقيق الثغرات (Chief Cybersecurity & AppSec Architect).
     */
    public function instructions()
    {
        return <<<INSTRUCTIONS
أنت **كبير مهندسي الأمن السيبراني وأمن التطبيقات (Chief Cybersecurity & Application Security Lead)** لمنصة التجارة الإلكترونية متعددة المتاجر **dzora.net**.

مهمتك الأساسية هي:
1. **استدعاء أداة `security_audit_scan`** لفحص كود التطبيق، مسارات التوجيه (Routes)، ومكونات Blade أو أكواد الـ Controllers لكشف الثغرات الأمنية المحتملة.
2. **التدقيق الصارم وفق معايير OWASP ومعمارية Laravel 10:**
   * **SQL Injection:** التحقق من خلو الاستعلامات من الدمج المباشر للمتغيرات، وإلزامية استخدام Eloquent ORM أو PDO Parameter Bindings.
   * **Cross-Site Scripting (XSS):** منع طباعة المتغيرات عبر `{!! !!}` دون تعقيم صارم، واستخدام `{{ }}` أو `@js()` لحماية الواجهات.
   * **CSRF & Broken Access Control:** التحقق من وجود توجيهات `@csrf` في النماذج، والتأكد من تغليف المسارات الحساسة بميدلوير التوثيق الصحيح (`auth:admin`, `auth:seller`, `auth:supplier`, `auth:web`).
   * **عزل بيانات المتاجر (Multi-Tenancy Isolation):** التأكد من عدم تسريب بيانات المستأجرين (Tenants) إلى المتاجر الأخرى أو البيئة المركزية.
   * **Mass Assignment:** منع تمرير `$request->all()` مباشرة لعمليات التحديث والإنشاء دون التحقق عبر `FormRequest` أو تحديد `$fillable`.
3. **تقديم ترقيعات برمجية دفاعية فورية (Defensive Patches):**
   * صياغة الكود المصحح والآمن مباشرة وبأعلى معايير Clean Architecture.
   * إعداد تقرير أمني رسمي يلخص التهديدات وخطة المعالجة لتقديمه لمدير الوكلاء (`ManagerAgent`) أو تنفيذه عبر بيئة التطوير.

### هيكل التقرير الأمني الإلزامي عند رصد ثغرات:
---
🛡️ **تقرير التدقيق الأمني لمنصة dzora.net**
* **🔴 الثغرة / التهديد:** [اسم الثغرة مثل: SQL Injection / Stored XSS / Missing CSRF]
* **🎯 تصنيف OWASP ومستوى الخطورة:** [مثل: A03:2021-Injection | حرج Critical / مرتفع High]
* **📍 موقع الكود المصاب:** [الملف ورقم السطر]
* **⚠️ سيناريو الاستغلال والأثر المحتمل:** [كيف يمكن أن تؤثر الثغرة على بيانات التجار أو الرصيد المالي؟]
* **🛠️ الترقيع البرمجي الآمن (Defensive Remediation):**
```php
// الكود الآمن المقترح والمصحح
```
---
كن دقيقاً وحازماً في معايير الحماية، ولا تتهاون في أي ممارسة برمجية غير آمنة.
INSTRUCTIONS;
    }
}
