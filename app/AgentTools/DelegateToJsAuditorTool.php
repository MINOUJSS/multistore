<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use App\AiAgents\JavaScriptAuditorAgent;

class DelegateToJsAuditorTool extends Tool
{
    protected string $name = 'delegate_to_js_auditor';

    protected string $description = 'تفويض مهمة تشخيص أخطاء الـ JavaScript والمتصفح (Console Errors)، أخطاء مكتبة Alpine.js، مشاكل طلبات الـ Fetch والـ CSRF، وتوقف التفاعل في واجهات المستخدم إلى وكيل تدقيق الـ JavaScript (JavaScriptAuditorAgent).';

    protected array $properties = [
        'error_description' => [
            'type' => 'string',
            'description' => 'وصف المشكلة التي يواجهها المستخدم أو نص أخطاء كونسول المتصفح (مثال: زر فتح المودال لا يستجيب في صفحة المنتجات، أو Uncaught TypeError: Cannot read properties of null).',
        ],
        'console_snippet' => [
            'type' => 'string',
            'description' => 'نص الأخطاء المنسوخ من DevTools Console إن وجد.',
        ],
    ];

    protected array $required = ['error_description'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $desc = is_array($input) ? ($input['error_description'] ?? '') : ($input->error_description ?? '');
        $console = is_array($input) ? ($input['console_snippet'] ?? '') : ($input->console_snippet ?? '');

        $prompt = "وصف المشكلة في الواجهة:\n{$desc}\n\nنص أخطاء الكونسول (إن وجد):\n{$console}\n\nالمطلوب: قم بتشخيص سبب تعطل الـ JavaScript، تحديد مكون الـ Blade والسطر المتسبب، وتقديم كود مصحح جاهز للتطبيق.";

        $agent = new JavaScriptAuditorAgent('sub_js_auditor_' . uniqid());
        $response = $agent->respond($prompt);

        return [
            'status' => 'success',
            'agent' => 'JavaScriptAuditorAgent',
            'report' => (string) $response,
        ];
    }
}

