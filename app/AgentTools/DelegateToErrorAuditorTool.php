<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use App\AiAgents\ErrorAuditorAgent;

class DelegateToErrorAuditorTool extends Tool
{
    protected string $name = 'delegate_to_error_auditor';

    protected string $description = 'تفويض مهمة فحص وتدقيق أخطاء الباك إند، قراءة سجلات لارافيل (laravel.log)، تشخيص الاستثناءات الحرجة (SQL, cURL, APIs, Multi-tenancy)، وإعداد تقرير الأثر الفني أو جدول أعمال الأعطال إلى وكيل تدقيق الأخطاء (ErrorAuditorAgent).';

    protected array $properties = [
        'audit_scope' => [
            'type' => 'string',
            'description' => 'نطاق التدقيق المطلوب: recent_errors (أحدث الأخطاء المسجلة في النظام), critical_system_faults (الأخطاء الحرجة جداً فقط), database_issues (أعطال وقضايا قواعد البيانات), gateway_failures (مشاكل الاتصال بالدفع والشحن والـ API), specific_keyword (البحث عن عطل محدد)',
            'enum' => ['recent_errors', 'critical_system_faults', 'database_issues', 'gateway_failures', 'specific_keyword'],
        ],
        'details_or_query' => [
            'type' => 'string',
            'description' => 'توجيهات إضافية أو كلمة مفتاحية للبحث داخل السجلات (مثال: cURL timeout, SQLSTATE, Chargily, Tenancy).',
        ],
    ];

    protected array $required = ['audit_scope'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $scope = is_array($input) ? ($input['audit_scope'] ?? 'recent_errors') : ($input->audit_scope ?? 'recent_errors');
        $query = is_array($input) ? ($input['details_or_query'] ?? '') : ($input->details_or_query ?? '');

        $prompt = "نطاق الفحص المطلوب: {$scope}\nتوجيهات أو استعلام إضافي: {$query}\nالمطلوب: قم بفحص سجلات لارافيل الحديثة، استخراج الأخطاء الحرجة المؤثرة، وتشخيص السبب الجذري مع تقديم خطة المعالجة وجدول أعمال للأعطال المكتشفة.";

        $agent = new ErrorAuditorAgent('sub_error_auditor_' . uniqid());
        $response = $agent->respond($prompt);

        return [
            'status' => 'success',
            'agent' => 'ErrorAuditorAgent',
            'audit_scope' => $scope,
            'report' => (string) $response,
        ];
    }
}

