<?php

namespace App\AgentTools;

use LarAgent\Core\Contracts\DataModel;
use LarAgent\Tool;
use Illuminate\Support\Facades\Http;

class CompetitorMarketResearchTool extends Tool
{
    protected string $name = 'competitor_market_research';

    protected string $description = 'أداة استخبارات السوق والبحث التنافسي: فحص ميزات المنافسين في التجارة الإلكترونية الجزائرية والمغاربية والعالمية (مثل YouCan, Dropify, Shopify, Salla, Zid)، تتبع حلول الشحن (Yalidine, ZrExpress, Mayastro) وبوابات الدفع (Chargily Pay, COD)، واستكشاف التريندات التسويقية والتقنية.';

    protected array $properties = [
        'research_topic' => [
            'type' => 'string',
            'description' => 'موضوع البحث أو الاستفسار التنافسي (مثال: ميزات الدروبشيبينغ في Dropify و YouCan، أتمتة تأكيد الطلبات عبر واتساب، تقليل نسبة الروتور في الجزائر، حلول الدفع بالبطاقة الذهبية).',
        ],
        'research_type' => [
            'type' => 'string',
            'description' => 'نوع الاستعلام الاستخباراتي: general_market_search (بحث عام في الويب), competitor_comparison (مقارنة مباشرة بين المنصات), shipping_logistics_intel (استخبارات شركات الشحن والروتور), payment_gateway_intel (استخبارات بوابات الدفع والـ COD), algerian_market_trends (تريندات السوق الجزائري الحالية)',
            'enum' => ['general_market_search', 'competitor_comparison', 'shipping_logistics_intel', 'payment_gateway_intel', 'algerian_market_trends'],
        ],
        'competitor_name' => [
            'type' => 'string',
            'description' => 'اسم المنافس المستهدف إن وجد (مثال: YouCan, Dropify DZ, Shopify, Salla, Yalidine, Mayastro).',
        ],
    ];

    protected array $required = ['research_topic'];

    protected array $metaData = [];

    protected function handle(array|DataModel $input): mixed
    {
        $topic = is_array($input) ? ($input['research_topic'] ?? '') : ($input->research_topic ?? '');
        $type = is_array($input) ? ($input['research_type'] ?? 'general_market_search') : ($input->research_type ?? 'general_market_search');
        $competitor = is_array($input) ? ($input['competitor_name'] ?? null) : ($input->competitor_name ?? null);

        // 1. محاولة إجراء بحث مباشر عبر SERP إن توفر مفتاح في .env
        $liveSearchResults = $this->queryLiveSearch($topic, $competitor);

        // 2. تجميع البيانات مع المعرفة المدمجة بالسوق الجزائري
        $marketIntelligence = $this->getMarketKnowledgeBase($type, $competitor, $topic);

        return json_encode([
            'status' => 'success',
            'query_topic' => $topic,
            'research_type' => $type,
            'target_competitor' => $competitor ?? 'All Major Competitors',
            'live_search_data' => $liveSearchResults,
            'market_knowledge' => $marketIntelligence,
        ], JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    protected function queryLiveSearch(string $topic, ?string $competitor): ?array
    {
        $serperKey = env('SERPER_API_KEY');
        $tavilyKey = env('TAVILY_API_KEY');

        $query = $topic;
        if (!empty($competitor)) {
            $query .= ' ' . $competitor;
        }

        if (!empty($serperKey)) {
            try {
                $response = Http::timeout(6)->withHeaders([
                    'X-API-KEY' => $serperKey,
                    'Content-Type' => 'application/json',
                ])->post('https://google.serper.dev/search', [
                    'q' => $query . ' الجزائر التجارة الالكترونية',
                    'gl' => 'dz',
                    'hl' => 'ar',
                    'num' => 4,
                ]);

                if ($response->successful() && !empty($response->json('organic'))) {
                    return array_map(function ($item) {
                        return [
                            'title' => $item['title'] ?? '',
                            'snippet' => $item['snippet'] ?? '',
                            'link' => $item['link'] ?? '',
                        ];
                    }, $response->json('organic'));
                }
            } catch (\Throwable $e) {
                // تجاوز الفشل بهدوء
            }
        }

        if (!empty($tavilyKey)) {
            try {
                $response = Http::timeout(6)->post('https://api.tavily.com/search', [
                    'api_key' => $tavilyKey,
                    'query' => $query . ' التجارة الالكترونية الجزائر',
                    'search_depth' => 'basic',
                    'max_results' => 4,
                ]);

                if ($response->successful() && !empty($response->json('results'))) {
                    return array_map(function ($item) {
                        return [
                            'title' => $item['title'] ?? '',
                            'snippet' => $item['content'] ?? '',
                            'link' => $item['url'] ?? '',
                        ];
                    }, $response->json('results'));
                }
            } catch (\Throwable $e) {
                // تجاوز الفشل بهدوء
            }
        }

        return null;
    }

    protected function getMarketKnowledgeBase(string $type, ?string $competitor, string $topic): array
    {
        return [
            'algerian_market_ecosystem' => [
                'dominant_payment_mode' => 'الدفع عند الاستلام (COD - Cash On Delivery) يمثل قرابة 85% إلى 90% من إجمالي المبيعات، مع نمو ملحوظ للدفع المسبق بالبطاقة الذهبية و CIB عبر Chargily Pay بنسبة تتجاوز 10-15%.',
                'primary_logistics' => [
                    'Yalidine Express' => 'الشبكة الأوسع انتشاراً عبر 58 ولاية، توفر تسليم للمنزل ومراكز استلام (Stop Desk)، مع لوحة تحكم تتبع وربط برمجي API لتوليد البوليصات (Tracking Slips).',
                    'ZrExpress' => 'قوية جداً في وسط وشرق البلاد، وتتميز بسرعة تحصيل وإرجاع أموال الدفع عند الاستلام (COD Remittance).',
                    'Mayastro Delivery' => 'منصة لوجستية وتوصيل سريعة النمو موجهة لأصحاب المتاجر والمتاجر الإلكترونية مع تكامل API حديث.',
                ],
                'merchant_critical_challenges' => [
                    'معدل المرتجعات (Retour Rate):' => 'العائق الأكبر أمام التجار (يتراوح بين 15% و 35%)، وأفضل ممارسات تقليله تشمل: تأكيد الطلبات عبر واتساب فور الشراء، فرض التحقق من رقم الهاتف عبر OTP، ومنح خصومات الدفع المسبق بالبطاقة الذهبية.',
                    'تأكيد الطلبات (Order Confirmation):' => 'ضرورة وجود واجهة تأكيد هاتفية للمتجر (Confirmation Call Center interface) قبل إرسال الشحنة لشركة التوصيل.',
                ],
            ],
            'major_competitors_benchmarks' => [
                'Dropify DZ' => [
                    'positioning' => 'منصة تجارة إلكترونية ودروبشيبينغ محلية في الجزائر.',
                    'strengths' => 'ربط مدمج مع شركات الشحن الجزائرية، منتجات جملة جاهزة للشحن (Local Sourcing)، ودعم تحصيل الـ COD.',
                    'gaps' => 'مرونة أقل في التخصيص، قيود على النطاقات الخاصة، واعتماد نموذج رسوم عمولة على المبيعات.',
                ],
                'YouCan Shop' => [
                    'positioning' => 'منصة سحابية مغاربية شهيرة بدون اشتراك شهري (تعتمد على عمولة 0.5% عند المبيعات).',
                    'strengths' => 'صفحات هبوط عالية التحويل (One-Page Funnels)، دعم COD مبسط، وتكاملات خارجية واسعة.',
                    'gaps' => 'عدم وجود نظام Multi-Vendor متكامل يربط الموردين بالتجار في منصة موحدة كما تقدم معمارية dzora.net.',
                ],
                'Shopify' => [
                    'positioning' => 'المنصة العالمية الرائدة.',
                    'strengths' => 'متجر تطبيقات ضخم وتصاميم عالمية.',
                    'gaps' => 'اشتراك شهري مرتفع بالعملة الصعبة (USD)، غياب الدعم المحلي للشركات الجزائرية و Chargily Pay دون تطبيقات مخصصة.',
                ],
            ],
            'strategic_opportunities_for_dzora' => [
                '1. المنظومة الثلاثية المتكاملة (SaaS + Wholesale + Affiliates):' => 'الجمع بين إدارة المتاجر المستأجرة (Tenants)، وسوق الموردين بالجملة (Suppliers)، وشبكة المسوقين بالعمولة (Marketers) في منصة مركزية واحدة.',
                '2. الأتمتة المباشرة مع شركات التوصيل الجزائرية:' => 'استخدام حزمة CourierdzService لتمكين التاجر من إصدار بوليصة الشحن بنقرة زر واحدة ومزامنة حالات الطرد لحظياً.',
                '3. التحفيز على الدفع الإلكتروني بالذهبية (Chargily Pay v2):' => 'منح خصومات على سعر التوصيل عند الدفع المسبق لتقليل نسبة المرتجعات للصفر.',
            ],
        ];
    }
}

