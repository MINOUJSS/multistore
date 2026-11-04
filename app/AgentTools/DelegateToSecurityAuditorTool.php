<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use App\AiAgents\SecurityAuditorAgent;

class DelegateToSecurityAuditorTool extends Tool
{
    protected string $name = 'delegate_to_security_auditor';

    protected string $description = 'تفويض مهمة تدقيق الأمان السيبراني، فحص الثغرات (SQL Injection, XSS, CSRF, Mass Assignment, Auth Middleware)، ومراجعة سلامة الكود وحماية المتاجر متعددة المستأجرين إلى وكيل الأمن السيبراني (SecurityAuditorAgent).';

    protected array $properties = [
        'audit_task' => [
            'type' => 'string',
            'description' => 'وصف المهمة الأمنية المطلوبة (مثل: تدقيق أمان مسار حذف المنتجات، فحص كود استقبال مدفوعات Chargily، أو البحث عن ثغرات في استعلامات البحث).',
        ],
        'target_file_or_code' => [
            'type' => 'string',
            'description' => 'مسار الملف المراد تدقيقه (مثل routes/modules/v1/seller.php أو اسم Controller) أو الكود البرمجي المراد تدقيقه مباشرة.',
        ],
    ];

    protected array $required = ['audit_task'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $task = is_array($input) ? ($input['audit_task'] ?? '') : ($input->audit_task ?? '');
        $target = is_array($input) ? ($input['target_file_or_code'] ?? '') : ($input->target_file_or_code ?? '');

        $prompt = "المهمة الأمنية المطلوبة:\n{$task}\n\nالهدف أو المسار المستهدف:\n{$target}\n\nالمطلوب: قم بفحص الكود أمنياً بأداة التدقيق، وحدد أي مخاطر أو ثغرات أمنية مع بيان تصنيف OWASP ومستوى الخطورة وتقديم الترقيع البرمجي الآمن.";

        $agent = new SecurityAuditorAgent('sub_sec_auditor_' . uniqid());
        $response = $agent->respond($prompt);

        return [
            'status' => 'success',
            'agent' => 'SecurityAuditorAgent',
            'report' => (string) $response,
        ];
    }
}

