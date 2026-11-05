<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use App\AiAgents\DocumentationAgent;

class DelegateToDocumentationAgentTool extends Tool
{
    protected string $name = 'delegate_to_documentation_agent';

    protected string $description = 'تفويض مهمة صياغة أدلة الاستخدام (User Guides)، كتابة التوثيق الرسمي للميزات، وتبسيط التقارير الفنية إلى خطوات واضحة للتجار والمستخدمين إلى وكيل التوثيق ودعم المستخدمين (DocumentationAgent).';

    protected array $properties = [
        'documentation_goal' => [
            'type' => 'string',
            'description' => 'الهدف من التوثيق أو الدعم (مثال: كتابة دليل استخدام ميزة الدومين المخصص، شرح طريقة ربط بوابة الدفع Chargily، أو تحويل مخرجات الباك إند إلى دليل مستخدم مبسط).',
        ],
        'technical_details_or_feature' => [
            'type' => 'string',
            'description' => 'الميزة المشروحة أو ملخص التقرير التقني المراد تبسيطه وصياغته.',
        ],
        'target_audience' => [
            'type' => 'string',
            'description' => 'الجمهور المستهدف (تجار المنصة sellers، موردو الجملة suppliers، إدارة المنصة admins، أو المطورون developers).',
        ],
        'save_to_file' => [
            'type' => 'boolean',
            'description' => 'ما إذا كان يجب حفظ الدليل في مجلد docs/ كملف Markdown (.md) دائم.',
        ],
    ];

    protected array $required = ['documentation_goal', 'technical_details_or_feature'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $goal = is_array($input) ? ($input['documentation_goal'] ?? '') : ($input->documentation_goal ?? '');
        $details = is_array($input) ? ($input['technical_details_or_feature'] ?? '') : ($input->technical_details_or_feature ?? '');
        $audience = is_array($input) ? ($input['target_audience'] ?? 'sellers') : ($input->target_audience ?? 'sellers');
        $saveToFile = is_array($input) ? ($input['save_to_file'] ?? false) : ($input->save_to_file ?? false);

        $prompt = "الهدف من التوثيق / الدعم:\n{$goal}\n\n";
        $prompt .= "الميزة أو التفاصيل التقنية المطلوب توثيقها:\n{$details}\n\n";
        $prompt .= "الجمهور المستهدف:\n{$audience}\n\n";
        if ($saveToFile) {
            $prompt .= "المطلوب: قم بصياغة دليل مستخدم كامل ومنظم بصيغة Markdown، واستخدم أداة save_documentation_file لحفظه في مجلد docs/ المناسب.\n";
        } else {
            $prompt .= "المطلوب: قم بصياغة شرح ودليل مستخدم واضح ومبسط خطوة بخطوة موجه للجمهور المستهدف دون تعقيدات برمجية.\n";
        }

        $agent = new DocumentationAgent('sub_doc_agent_' . uniqid());
        $response = $agent->respond($prompt);

        return [
            'status' => 'success',
            'agent' => 'DocumentationAgent',
            'documentation' => (string) $response,
        ];
    }
}

