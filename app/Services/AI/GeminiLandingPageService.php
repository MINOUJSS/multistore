<?php

namespace App\Services\AI;

use App\Models\Seller\SellerProducts;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class GeminiLandingPageService
{
    protected string $apiKey;
    protected string $model;
    protected int $creditsCost = 10;

    public function __construct()
    {
        $this->apiKey = (string) (config('services.gemini.api_key') ?: env('GEMINI_API_KEY', ''));
        $this->model = (string) env('GEMINI_MODEL', 'gemini-1.5-flash');
    }

    /**
     * Get remaining AI credits for a user
     */
    public function getUserRemainingCredits(User $user): int
    {
        return (int) $user->servicePurchases()
            ->where('status', 'active')
            ->whereHas('service', fn($q) => $q->where('category', 'ai_tools'))
            ->sum('credits_remaining');
    }

    /**
     * Cost in credits per generation
     */
    public function getCreditsCost(): int
    {
        return $this->creditsCost;
    }

    /**
     * Deduct credits from user's active purchases
     */
    public function deductCredits(User $user, int $amount): bool
    {
        $purchases = $user->servicePurchases()
            ->where('status', 'active')
            ->where('credits_remaining', '>', 0)
            ->whereHas('service', fn($q) => $q->where('category', 'ai_tools'))
            ->orderBy('id', 'asc')
            ->get();

        $needed = $amount;
        foreach ($purchases as $purchase) {
            if ($needed <= 0) {
                break;
            }
            $take = min($purchase->credits_remaining, $needed);
            $purchase->consumeCredits($take);
            $needed -= $take;
        }

        return $needed === 0;
    }

    /**
     * Generate structured landing page content using Gemini API (with smart fallback)
     */
    public function generate(SellerProducts $product, string $marketingAngle = 'general', ?string $customPrompt = null): array
    {
        $angleLabel = match ($marketingAngle) {
            'pain_relief' => 'حل المشكلة وتخفيف الألم والراحة القصوى',
            'gift' => 'الهدية المثالية والفاخرة لشخص عزيز',
            'luxury' => 'الفخامة، الأناقة العصرية والمكانة الاجتماعية',
            'savings' => 'التوفير الاقتصادي وأعلى قيمة بأفضل سعر',
            'speed' => 'السرعة الفائقة وتوفير الوقت والسهولة',
            default => 'التسويق الشامل المقنع وإبراز القيمة العالية للمنتج',
        };

        if (!empty($this->apiKey)) {
            try {
                $response = $this->callGeminiApi($product, $angleLabel, $customPrompt);
                if (!empty($response)) {
                    return $response;
                }
            } catch (\Throwable $e) {
                Log::error('Gemini API call failed, using intelligent template fallback: ' . $e->getMessage());
            }
        }

        // High-converting fallback if API key is not configured or temporary error occurs
        return $this->generateIntelligentFallback($product, $angleLabel);
    }

    /**
     * Call Google Gemini API
     */
    protected function callGeminiApi(SellerProducts $product, string $angleLabel, ?string $customPrompt = null): ?array
    {
        $systemInstruction = "أنت خبير محترف ومستشار عالمي في كتابة نصوص صفحات الهبوط الإعلانية والتسويقية فائقة التحويل (CRO Landing Page Copywriter).
مهمتك هي كتابة محتوى تسويقي إقناعي لصفحة هبوط منتج باللغة العربية بناءً على البيانات المقدمة، والتركيز بدقة على الزاوية التسويقية المطلوبة.
يجب أن ترجع المخرجات حصراً بتنسيق JSON نظيف وبدون أي وسوم markdown إضافية.";

        $prompt = "بيانات المنتج:
- اسم المنتج: {$product->name}
- الوصف الأساسي: {$product->description}
- السعر: {$product->price} د.ج
- الزاوية التسويقية المطلوبة: {$angleLabel}
" . ($customPrompt ? "- تعليمات إضافية من البائع: {$customPrompt}\n" : "") . "
المطلوب صياغة محتوى صفحة هبوط بالتنسيق التالي في JSON:
{
  \"hero_headline\": \"عنوان رئيسي إعلاني جذاب وفائق الإقناع يخاطب الزاوية المطلوبة مباشرة\",
  \"hero_subheadline\": \"عنوان فرعي يشرح الفائدة المباشرة للزبون وكيف يحل المنتج مشكلته باحتراف\",
  \"pain_points\": [
    \"نقطة ألم أو مشكلة يعاني منها الزبون بدون هذا المنتج 1\",
    \"نقطة ألم أو مشكلة 2\",
    \"نقطة ألم أو مشكلة 3\"
  ],
  \"benefits\": [
    {\"title\": \"الميزة الأولى\", \"description\": \"شرح كيف تحقق هذه الميزة الراحة والنتيجة الفورية للمشتري\"},
    {\"title\": \"الميزة الثانية\", \"description\": \"شرح فائدة الميزة الثانية\"},
    {\"title\": \"الميزة الثالثة\", \"description\": \"شرح فائدة الميزة الثالثة\"},
    {\"title\": \"الميزة الرابعة\", \"description\": \"شرح فائدة الميزة الرابعة\"}
  ],
  \"guarantees\": [
    \"الدفع عند الاستلام بعد معاينة المنتج وفحصه بكل أمان\",
    \"توصيل سريع وموثوق إلى باب منزلك\",
    \"ضمان الجودة وخدمة ما بعد البيع\"
  ],
  \"testimonials\": [
    {\"name\": \"محمد .ع\", \"city\": \"الجزائر العاصمة\", \"comment\": \"منتج فاق توقعاتي من حيث الجودة وسرعة التوصيل، أنصح به بشدة!\", \"rating\": 5},
    {\"name\": \"سارة .ب\", \"city\": \"وهران\", \"comment\": \"حل لي مشكلة كنت أعاني منها منذ فترة طويلة، تجربة ممتازة وتعامل محترم.\", \"rating\": 5},
    {\"name\": \"كريم .م\", \"city\": \"قسنطينة\", \"comment\": \"جودة عالية وسعر مناسب جداً، استلمت طلبي في وقت قياسي.\", \"rating\": 5}
  ],
  \"faqs\": [
    {\"question\": \"كيف يتم استلام المنتج والدفع؟\", \"answer\": \"التوصيل متاح حتى باب منزلك، والدفع يكون نقداً بعد استلامك للمنتج ومعاينته شخصياً.\"},
    {\"question\": \"ما هي مدة التوصيل المتوقعة؟\", \"answer\": \"يتم تجهيز وشحن طلبك فوراً وتصل الشحنة خلال 24 إلى 48 ساعة حسب ولايتك.\"},
    {\"question\": \"ماذا لو وجدت أي مشكلة في المنتج؟\", \"answer\": \"فريق خدمة العملاء لدينا مستعد لخدمتك في أي وقت مع إمكانية الاستبدال الفوري في حالة وجود أي عيب مصنعي.\"}
  ],
  \"cta_title\": \"سارع بالطلب الآن واستفد من العرض الحصري قبل نفاد المخزون\",
  \"cta_button_text\": \"اطلب الآن والدفع عند الاستلام\"
}";

        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}";

        $payload = [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $systemInstruction . "\n\n" . $prompt]
                    ]
                ]
            ],
            'generationConfig' => [
                'responseMimeType' => 'application/json',
                'temperature' => 0.7,
            ]
        ];

        $res = Http::timeout(30)->post($endpoint, $payload);

        if ($res->successful()) {
            $json = $res->json();
            $text = $json['candidates'][0]['content']['parts'][0]['text'] ?? null;
            if ($text) {
                $decoded = json_decode($text, true);
                if (is_array($decoded) && isset($decoded['hero_headline'])) {
                    return $decoded;
                }
            }
        }

        return null;
    }

    /**
     * Generate high-quality marketing copy fallback based on proven CRO frameworks
     */
    protected function generateIntelligentFallback(SellerProducts $product, string $angleLabel): array
    {
        $name = $product->name;
        $price = number_format($product->price, 0) . ' د.ج';

        return [
            'hero_headline' => "اكتشف القوة الحقيقية لـ {$name} - الحل الأمثل المصمم لراحتك وتميزك اليومي",
            'hero_subheadline' => "انضم إلى مئات العملاء السعداء الذين غيروا روتينهم اليومي بفضل الجودة الاستثنائية والنتائج المضمونة لـ {$name}.",
            'pain_points' => [
                "تعب وإحباط من المنتجات المقلدة وضعيفة الجودة التي لا تدوم طويلاً",
                "الحاجة إلى حل عملي، مريح وسريع يوفر عليك الوقت والجهد كل يوم",
                "البحث عن صفقة تجمع بين الجودة الفائقة والسعر العادل مع راحة بال تامة"
            ],
            'benefits' => [
                [
                    'title' => 'جودة أصلية ومتانة تدوم',
                    'description' => "تم تصنيع {$name} بأعلى معايير الدقة لضمان أداء مثالي واستخدام موثوق يدوم طويلاً دون أي تراجع."
                ],
                [
                    'title' => 'تصميم عصري ومريح',
                    'description' => 'مظهر أنيق يلائم نمط حياتك ويوفر لك أقصى درجات الراحة والعملية في كل لحظة استخدام.'
                ],
                [
                    'title' => 'نتائج ملحوظة من أول استخدام',
                    'description' => 'ستشعر بالفرق الإيجابي فور تجربتك الأولى دون أي تعقيدات أو انتظار.'
                ],
                [
                    'title' => 'أفضل قيمة مقابل السعر',
                    'description' => "احصل على كامل المميزات بسعر استثنائي يبلغ {$price} فقط مع خدمة دعم متميزة."
                ],
            ],
            'guarantees' => [
                'الدفع عند الاستلام: لا تدفع أي دينار حتى تعاين وتفحص طلبك أمام الموزع',
                'توصيل سريع ومضمون إلى 58 ولاية حتى باب منزلك أو مكتبك',
                'ضمان الجودة وخدمة ما بعد البيع للإجابة عن كل استفساراتكم'
            ],
            'testimonials' => [
                ['name' => 'أمين .ب', 'city' => 'الجزائر العاصمة', 'comment' => "صراحة المنتج رائع جداً وفاقت جودته توقعاتي، التوصيل كان سريعاً والتعامل قمة في الاحترافية.", 'rating' => 5],
                ['name' => 'ياسمين .ق', 'city' => 'سطيف', 'comment' => "حل ممتاز وعملي جداً، أنصح الجميع بتجربته دون تردد، شكراً جزيلاً لكم!", 'rating' => 5],
                ['name' => 'رضا .م', 'city' => 'وهران', 'comment' => "أفضل استثمار قمت به هذا الشهر، القيمة مقابل السعر ممتازة جداً.", 'rating' => 5],
            ],
            'faqs' => [
                [
                    'question' => 'كيف تتم عملية الطلب والاستلام؟',
                    'answer' => 'الأمر في غاية السهولة: املأ الاستمارة أسفل الصفحة، سيتصل بك فريقنا لتأكيد طلبك، ثم يصلك الطرد حتى باب منزلك وتدفع عند الاستلام.'
                ],
                [
                    'question' => 'كم تستغرق مدة التوصيل؟',
                    'answer' => 'التوصيل يتم خلال 24 إلى 48 ساعة لمعظم الولايات، مع متابعة دقيقة للشحنة حتى وصولها إليك.'
                ],
                [
                    'question' => 'هل يمكنني معاينة المنتج قبل الدفع؟',
                    'answer' => 'نعم بالتأكيد! يمكنك فحص الطرد عند استلامه للتأكد التام من مطابقته ومحتواه قبل دفع المبلغ للموزع.'
                ]
            ],
            'cta_title' => 'لا تدع العرض يفوتك - اطلب الآن واستفد من التخفيض الحصري قبل نفاد الكمية!',
            'cta_button_text' => 'اضغط هنا للطلب والدفع عند الاستلام'
        ];
    }
}
