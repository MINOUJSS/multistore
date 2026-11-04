<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use App\AiAgents\FrontendAgent;

class DelegateToFrontendAgentTool extends Tool
{
    protected string $name = 'delegate_to_frontend_agent';

    protected string $description = 'تفويض مهمة تصميم واجهة مستخدم (UI/UX)، أو صياغة مكونات Blade قابلة لإعادة الاستخدام، أو تحسين التجاوب والتفاعلية باستخدام Tailwind CSS و Alpine.js إلى وكيل الفرونت إند (FrontendAgent).';

    protected array $properties = [
        'ui_task' => [
            'type' => 'string',
            'description' => 'وصف تفصيلي للواجهة أو المكون المطلوب تصميمه (مثل: بطاقة إحصائيات زجاجية متجاوبة، نافذة منبثقة Modal للتأكيد، أو نموذج إدخال بتنسيق Tailwind).',
        ],
        'target_domain' => [
            'type' => 'string',
            'description' => 'مكان الواجهة المستهدفة في المنصة: admin, seller, supplier, tenant, landing_page',
            'enum' => ['admin', 'seller', 'supplier', 'tenant', 'landing_page'],
        ],
        'style_framework' => [
            'type' => 'string',
            'description' => 'النمط التصميمي المطلوب: tailwind (موصى به للمكونات الحديثة), bootstrap_glassmorphic (للوحات التحكم الحالية), alpine_interactive (للتفاعلات الحركية)',
            'enum' => ['tailwind', 'bootstrap_glassmorphic', 'alpine_interactive'],
        ],
    ];

    protected array $required = ['ui_task'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $task = is_array($input) ? ($input['ui_task'] ?? '') : ($input->ui_task ?? '');
        $domain = is_array($input) ? ($input['target_domain'] ?? 'general') : ($input->target_domain ?? 'general');
        $framework = is_array($input) ? ($input['style_framework'] ?? 'tailwind') : ($input->style_framework ?? 'tailwind');

        if (empty(trim($task))) {
            return json_encode([
                'status' => 'error',
                'message' => 'لم يتم تحديد تفاصيل مهمة الفرونت إند وتصميم الواجهة.',
            ], JSON_UNESCAPED_UNICODE);
        }

        try {
            $promptForFrontend = "طلب تصميم فرونت إند من مدير الوكلاء (ManagerAgent):\n";
            $promptForFrontend .= "المهمة: {$task}\n";
            $promptForFrontend .= "النطاق المستهدف: {$domain}\n";
            $promptForFrontend .= "إطار التنسيق والنمط: {$framework}\n";
            $promptForFrontend .= "المطلوب: قم بفحص إرشادات الواجهات للمنصة وصمم كود Blade نظيف، متجاوب (Mobile-first)، يدعم اللغة العربية RTL، ومتوافق مع قواعد Clean UI.";

            $frontendAgent = new FrontendAgent('frontend_session_' . uniqid());
            $frontendResponse = $frontendAgent->respond($promptForFrontend);

            $content = is_object($frontendResponse) && method_exists($frontendResponse, 'getContent')
                ? $frontendResponse->getContent()
                : (string)$frontendResponse;

            return json_encode([
                'status' => 'success',
                'agent' => 'FrontendAgent',
                'domain' => $domain,
                'framework' => $framework,
                'ui_specification' => $content,
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        } catch (\Throwable $e) {
            return json_encode([
                'status' => 'error',
                'agent' => 'FrontendAgent',
                'message' => 'تعذر إتمام مهمة الفرونت إند: ' . $e->getMessage(),
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}

