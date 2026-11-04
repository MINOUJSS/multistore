<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use App\AiAgents\PlatformMarketingAgent;

class DelegateToMarketingAgentTool extends Tool
{
    protected string $name = 'delegate_to_marketing_agent';

    protected string $description = 'تفويض مهمة تسويقية أو كتابة محتوى إلى وكيل التسويق المعتمد (PlatformMarketingAgent). يتولى وكيل التسويق فحص أرقام قاعدة البيانات واستطلاع تريندات السوق وصياغة المحتوى المتوافق مع المنصة.';

    protected array $properties = [
        'task_brief' => [
            'type' => 'string',
            'description' => 'وصف تفصيلي ودقيق للمهمة المطلوب إسنادها لوكيل التسويق (مثل: كتابة منشور فيسبوك لجذب موردين جدد، أو مقال عن ميزة الشحن ל-58 ولاية).',
        ],
        'target_platform' => [
            'type' => 'string',
            'description' => 'المنصة المستهدفة للنشر: facebook, instagram, linkedin, blog',
            'enum' => ['facebook', 'instagram', 'linkedin', 'blog'],
        ],
    ];

    protected array $required = ['task_brief'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $taskBrief = is_array($input) ? ($input['task_brief'] ?? '') : ($input->task_brief ?? '');
        $platform = is_array($input) ? ($input['target_platform'] ?? 'facebook') : ($input->target_platform ?? 'facebook');

        if (empty(trim($taskBrief))) {
            return json_encode([
                'status' => 'error',
                'message' => 'لم يتم تحديد تفاصيل المهمة التسويقية.',
            ], JSON_UNESCAPED_UNICODE);
        }

        try {
            // صياغة توجيه مخصص ومحدد لوكيل التسويق
            $promptForMarketing = "مهمة إدارية مفوضة من مدير الوكلاء (ManagerAgent):\n";
            $promptForMarketing .= "المهمة: {$taskBrief}\n";
            $promptForMarketing .= "المنصة المستهدفة: {$platform}\n";
            $promptForMarketing .= "المطلوب: قم باستدعاء أدواتك لفحص إحصائيات المنصة وتريندات السوق وتقديم مسودة تسويقية متكاملة مع الهاشتاغات ودعوة التسجيل.";

            // استدعاء وكيل التسويق في جلسة مستقلة
            $marketingAgent = new PlatformMarketingAgent('delegated_session_' . uniqid());
            $marketingResponse = $marketingAgent->respond($promptForMarketing);

            $content = is_object($marketingResponse) && method_exists($marketingResponse, 'getContent')
                ? $marketingResponse->getContent()
                : (string)$marketingResponse;

            return json_encode([
                'status' => 'success',
                'agent' => 'PlatformMarketingAgent',
                'platform' => $platform,
                'output' => $content,
            ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        } catch (\Throwable $e) {
            return json_encode([
                'status' => 'error',
                'agent' => 'PlatformMarketingAgent',
                'message' => 'تعذر إتمام تفويض المهمة: ' . $e->getMessage(),
            ], JSON_UNESCAPED_UNICODE);
        }
    }
}

