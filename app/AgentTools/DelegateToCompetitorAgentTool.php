<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use App\AiAgents\CompetitorAgent;

class DelegateToCompetitorAgentTool extends Tool
{
    protected string $name = 'delegate_to_competitor_agent';

    protected string $description = 'تفويض مهمة دراسة المنافسين (YouCan, Dropify, Shopify, Salla)، استكشاف تريندات التجارة الإلكترونية في الجزائر، واقتراح ميزات تنافسية جديدة لزيادة مبيعات التجار وتقليل المرتجعات إلى وكيل استخبارات السوق والمنافسين (CompetitorAgent).';

    protected array $properties = [
        'research_objective' => [
            'type' => 'string',
            'description' => 'الهدف من الاستفسار التنافسي (مثال: مقارنة ميزات منصتنا مع YouCan و Dropify، أو دراسة كيفية تقليل نسبة الروتور مع شركات الشحن الجزائرية، أو دراسة تقديم اشتراكات المتاجر).',
        ],
        'target_competitor_or_trend' => [
            'type' => 'string',
            'description' => 'المنافس أو التريند المستهدف (مثل: Dropify DZ, YouCan Shop, Yalidine Logistics, Chargily Pay, WhatsApp Confirmation).',
        ],
    ];

    protected array $required = ['research_objective'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $objective = is_array($input) ? ($input['research_objective'] ?? '') : ($input->research_objective ?? '');
        $target = is_array($input) ? ($input['target_competitor_or_trend'] ?? '') : ($input->target_competitor_or_trend ?? '');

        $prompt = "الهدف من الاستفسار التنافسي:\n{$objective}\n\nالمنافس أو التريند المستهدف:\n{$target}\n\nالمطلوب: قم بفحص بيانات السوق وحركات المنافسين بالأداة المخصصة، وقدم تحليلاً مقارناً مع صياغة ميزة تنافسية حاسمة تمنح منصة dzora.net التفوق على المنافسين في السوق الجزائري.";

        $agent = new CompetitorAgent('sub_comp_agent_' . uniqid());
        $response = $agent->respond($prompt);

        return [
            'status' => 'success',
            'agent' => 'CompetitorAgent',
            'report' => (string) $response,
        ];
    }
}

