<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use App\AiAgents\BackendArchitectAgent;

class DelegateToBackendArchitectTool extends Tool
{
    protected string $name = 'delegate_to_backend_architect';

    protected string $description = 'تفويض مهمة استشارية أو معمارية برمجية إلى وكيل مهندس الباك إند (BackendArchitectAgent) لمراجعة الكود، تصميم الموديلات والمتحكمات، وتأكيد مطابقتها لقواعد المنصة الصارمة (GEMINI.md) وعزل المتاجر (Multi-Tenancy).';

    protected array $properties = [
        'consultation_topic' => [
            'type' => 'string',
            'description' => 'الموضوع التقني أو الميزة المطلوب من مهندس الباك إند تخطيطها معمارياً أو فحص مدى توافقها مع كود المشروع.',
        ],
        'domain' => [
            'type' => 'string',
            'description' => 'النطاق المعني في المشروع: admin, seller, supplier, tenant, marketer, general',
            'enum' => ['admin', 'seller', 'supplier', 'tenant', 'marketer', 'general'],
        ],
    ];

    protected array $required = ['consultation_topic'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $topic = is_array($input) ? ($input['consultation_topic'] ?? '') : ($input->consultation_topic ?? '');
        $domain = is_array($input) ? ($input['domain'] ?? 'general') : ($input->domain ?? 'general');

        if (empty(trim($topic))) {
            return json_encode([
                'status' => 'error',
                'message' => 'لم يتم تحديد موضوع الاستشارة الهندسية.',
            ], JSON_UNESCAPED_UNICODE);
        }

        try {
            $promptForArchitect = "طلب استشارة معمارية من مدير الوكلاء (ManagerAgent):\n";
            $promptForArchitect .= "الموضوع التقني: {$topic}\n";
            $promptForArchitect .= "النطاق البرمجي المستهدف: {$domain}\n";
            $promptForArchitect .= "المطلوب: قم بفحص القواعد والمهارات المعمارية للمنصة عبر أدواتك، وقدم مقترحاً معمارياً دقيقاً وخطة ملفات مطابقة لمعايير Laravel 10 والـ Multi-Tenancy.";

            $architectAgent = new BackendArchitectAgent('architect_session_' . uniqid());
            $architectResponse = $architectAgent->respond($promptForArchitect);

            $content = is_object($architectResponse) && method_exists($architectResponse, 'getContent')
                ? $architectResponse->getContent()
                : (string)$architectResponse;

            return json_encode([
                'status' => 'success',
                'agent' => 'BackendArchitectAgent',
                'domain' => $domain,
                'architectural_guidance' => $content,
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        } catch (\Throwable $e) {
            return json_encode([
                'status' => 'error',
                'agent' => 'BackendArchitectAgent',
                'message' => 'تعذر إتمام الاستشارة الهندسية: ' . $e->getMessage(),
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}

