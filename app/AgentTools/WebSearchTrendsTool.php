<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use Illuminate\Support\Facades\Http;

class WebSearchTrendsTool extends Tool
{
    protected string $name = 'web_search_trends';

    protected string $description = 'البحث في الإنترنت عن أحدث توجهات التجارة الإلكترونية، تريندات البيع أونلاين، وسلوك المتسوقين في الجزائر والعالم العربي لإثراء المحتوى التسويقي.';

    protected array $properties = [
        'search_query' => [
            'type' => 'string',
            'description' => 'موضوع البحث أو الكلمة المفتاحية، مثل: التجارة الإلكترونية في الجزائر، نصائح زيادة المبيعات، الدروبشيبينغ المحلي',
        ],
    ];

    protected array $required = ['search_query'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $query = is_array($input) ? ($input['search_query'] ?? '') : ($input->search_query ?? '');

        // 1. فحص إذا كان هناك مفتاح Tavily API أو Serper في ملف .env
        $tavilyKey = env('TAVILY_API_KEY');
        $serperKey = env('SERPER_API_KEY');

        if (!empty($tavilyKey)) {
            try {
                $response = Http::timeout(8)->post('https://api.tavily.com/search', [
                    'api_key' => $tavilyKey,
                    'query' => $query . ' الجزائر التجارة الالكترونية',
                    'search_depth' => 'basic',
                    'max_results' => 4,
                ]);

                if ($response->successful()) {
                    return json_encode($response->json('results'), JSON_UNESCAPED_UNICODE);
                }
            } catch (\Throwable $e) {
                // استمرار إلى الرد الاحتياطي
            }
        } elseif (!empty($serperKey)) {
            try {
                $response = Http::timeout(8)->withHeaders([
                    'X-API-KEY' => $serperKey,
                    'Content-Type' => 'application/json',
                ])->post('https://google.serper.dev/search', [
                    'q' => $query . ' الجزائر',
                    'gl' => 'dz',
                    'hl' => 'ar',
                    'num' => 4,
                ]);

                if ($response->successful()) {
                    return json_encode($response->json('organic'), JSON_UNESCAPED_UNICODE);
                }
            } catch (\Throwable $e) {
                // استمرار إلى الرد الاحتياطي
            }
        }

        // قاعدة معرفية واحتياطية متجددة عن السوق الجزائري في حال لم يتم إدخال مفتاح الـ API بعد
        return json_encode([
            'market_insights' => [
                'سوق التجارة الإلكترونية في الجزائر يشهد نمواً متسارعاً وتوسعاً ملحوظاً في الدفع الإلكتروني (البطاقة الذهبية/CIB) بجانب الدفع عند الاستلام (COD).',
                'التجار بحاجة ماسة إلى حلول متكاملة تدمج شركات التوصيل الوطنية (58 ولاية) مع لوحة تحكم سهلة وتحديثات لحظية للشحنات.',
                'الدروبشيبينغ المحلي يحل مشكلة رأس المال والمخزون، حيث يتيح للشباب بيع منتجات الموردين المحليين مباشرة بهامش ربح مضمون.',
                'التسويق عبر فيسبوك وتيك توك وصفحات الهبوط (Landing Pages) السريعة هو المحرك الرئيسي لأعلى نسب تحويل المبيعات حالياً في الجزائر.',
            ],
            'query_topic' => $query,
            'note' => 'تم استخدام المعرفة التسويقية المحلية المدمجة. لتفعيل البحث الحي المباشر عبر جوجل، يمكنك إضافة TAVILY_API_KEY أو SERPER_API_KEY في ملف .env.'
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }
}
