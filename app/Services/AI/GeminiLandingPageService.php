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
     * Generate structured landing page content using Gemini API (with smart fallback & extra images)
     */
    public function generate(SellerProducts $product, string $marketingAngle = 'general', ?string $customPrompt = null, bool $generateExtraImages = true): array
    {
        $angleLabel = match ($marketingAngle) {
            'pain_relief' => 'حل المشكلة وتخفيف الألم والراحة القصوى',
            'gift' => 'الهدية المثالية والفاخرة لشخص عزيز',
            'luxury' => 'الفخامة، الأناقة العصرية والمكانة الاجتماعية',
            'savings' => 'التوفير الاقتصادي وأعلى قيمة بأفضل سعر',
            'speed' => 'السرعة الفائقة وتوفير الوقت والسهولة',
            default => 'التسويق الشامل المقنع وإبراز القيمة العالية للمنتج',
        };

        $content = null;

        if (!empty($this->apiKey)) {
            try {
                $response = $this->callGeminiApi($product, $angleLabel, $customPrompt);
                if (!empty($response)) {
                    $content = $response;
                }
            } catch (\Throwable $e) {
                Log::error('Gemini API call failed, using intelligent template fallback: ' . $e->getMessage());
            }
        }

        if (!$content) {
            $content = $this->generateIntelligentFallback($product, $angleLabel);
        }

        // Build Product Image Gallery (Main + Existing Gallery + AI Generated)
        $galleryImages = [];
        if ($product->image) {
            $galleryImages[] = asset($product->image);
        }
        if ($product->relationLoaded('images') || $product->images()->exists()) {
            foreach ($product->images as $img) {
                if (!empty($img->image_path)) {
                    $galleryImages[] = asset($img->image_path);
                }
            }
        }

        if ($generateExtraImages) {
            $aiImages = $this->generateAiImages($product, $angleLabel, $content['ai_image_prompts'] ?? null);
            $content['ai_generated_images'] = $aiImages;
            $galleryImages = array_merge($galleryImages, $aiImages);
        }

        $content['gallery_images'] = array_values(array_unique($galleryImages));

        // Ensure infographic structure is present
        if (empty($content['infographic'])) {
            $content['infographic'] = $this->getInfographicDefault($product, $angleLabel);
        }

        return $content;
    }

    /**
     * Generate complementary AI images for the product using English photorealistic prompts
     */
    protected function generateAiImages(SellerProducts $product, string $angleLabel, ?array $customPrompts = null): array
    {
        $prompts = $customPrompts;
        if (empty($prompts['studio']) || empty($prompts['lifestyle'])) {
            $prompts = $this->buildFallbackEnglishPrompts($product);
        }

        $studio = trim(preg_replace('/[^\w\s,\-]/', '', $prompts['studio'] ?? ''));
        $lifestyle = trim(preg_replace('/[^\w\s,\-]/', '', $prompts['lifestyle'] ?? ''));

        if (empty($studio)) {
            $studio = 'Professional commercial studio product photography on clean modern podium, soft studio lighting, 8k, photorealistic';
        }
        if (empty($lifestyle)) {
            $lifestyle = 'Authentic aesthetic commercial lifestyle photography in contemporary setting, natural warm ambient lighting, 8k';
        }

        $promptStudio = urlencode("{$studio}, crisp focus, 8k resolution, photorealistic commercial shot, no text, no letters, no watermark");
        $promptLifestyle = urlencode("{$lifestyle}, cinematic composition, 8k resolution, photorealistic commercial ad, no text, no letters, no watermark");

        return [
            "https://image.pollinations.ai/prompt/{$promptStudio}?width=800&height=800&nologo=true&seed=" . rand(1000, 9999),
            "https://image.pollinations.ai/prompt/{$promptLifestyle}?width=800&height=800&nologo=true&seed=" . rand(1000, 9999),
        ];
    }

    /**
     * Build category-aware English photography prompts to avoid non-English diffusion hallucinations
     */
    protected function buildFallbackEnglishPrompts(SellerProducts $product): array
    {
        $searchSpace = mb_strtolower($product->name . ' ' . ($product->description ?? ''));
        $isDigital = ($product->product_type === 'digital');

        if ($isDigital || str_contains($searchSpace, 'كتاب') || str_contains($searchSpace, 'رواية') || str_contains($searchSpace, 'pdf') || str_contains($searchSpace, 'book') || str_contains($searchSpace, 'دليل')) {
            return [
                'studio' => 'Professional commercial photograph of an elegant hardcover book with embossed finish on clean minimalist wooden desk, soft studio rim lighting, 8k, photorealistic, sharp focus',
                'lifestyle' => 'Cozy aesthetic lifestyle photography of a hardcover book beside a warm ceramic coffee cup and reading glasses in a sunlit modern interior, warm ambient light, 8k'
            ];
        }

        if (str_contains($searchSpace, 'عطر') || str_contains($searchSpace, 'مسك') || str_contains($searchSpace, 'عود') || str_contains($searchSpace, 'parfum') || str_contains($searchSpace, 'perfume')) {
            return [
                'studio' => 'Luxury glass perfume bottle on black reflective marble podium, water droplets, dramatic studio spotlight, golden bokeh, 8k commercial cosmetic photography',
                'lifestyle' => 'High-end aesthetic lifestyle shot of a premium perfume bottle on a luxury dressing table with soft silk fabric, elegant morning sunbeam, 8k'
            ];
        }

        if (str_contains($searchSpace, 'ساعة') || str_contains($searchSpace, 'watch') || str_contains($searchSpace, 'montre')) {
            return [
                'studio' => 'Luxury chronograph wristwatch on dark slate background, professional macro product photography, crisp metallic reflections, 8k',
                'lifestyle' => 'Lifestyle advertisement of a modern sleek wristwatch worn on wrist, elegant casual attire, blurred city background, warm sunset light, 8k'
            ];
        }

        if (str_contains($searchSpace, 'حذاء') || str_contains($searchSpace, 'سنيكرز') || str_contains($searchSpace, 'shoes') || str_contains($searchSpace, 'sneaker') || str_contains($searchSpace, 'سبادري')) {
            return [
                'studio' => 'Premium athletic sneaker floating dynamically in air, studio lighting, clean pastel background, high detail texture, 8k commercial footwear photography',
                'lifestyle' => 'Urban street style lifestyle shot of stylish footwear on urban asphalt pavement, cinematic natural daylight, 8k'
            ];
        }

        if (str_contains($searchSpace, 'زيت') || str_contains($searchSpace, 'كريم') || str_contains($searchSpace, 'سيروم') || str_contains($searchSpace, 'بشرة') || str_contains($searchSpace, 'شعر') || str_contains($searchSpace, 'cream') || str_contains($searchSpace, 'serum') || str_contains($searchSpace, 'oil')) {
            return [
                'studio' => 'Organic cosmetic skincare bottle with glass dropper on smooth stone pedestal, fresh green eucalyptus leaves, soft daylight, commercial beauty photography, 8k',
                'lifestyle' => 'Spa ambiance lifestyle photograph of luxury skincare serum bottle with soft white towels and water ripples, serene aesthetic, 8k'
            ];
        }

        if (str_contains($searchSpace, 'حقيبة') || str_contains($searchSpace, 'محفظة') || str_contains($searchSpace, 'sac') || str_contains($searchSpace, 'bag') || str_contains($searchSpace, 'leather')) {
            return [
                'studio' => 'Luxury genuine leather handbag on polished wooden stand, elegant studio rim lighting, rich texture details, 8k',
                'lifestyle' => 'Fashion lifestyle photography of an elegant handbag held by a chic person walking in an upscale boulevard, golden hour light, 8k'
            ];
        }

        if (str_contains($searchSpace, 'سماعة') || str_contains($searchSpace, 'هاتف') || str_contains($searchSpace, 'شاحن') || str_contains($searchSpace, 'سماعات') || str_contains($searchSpace, 'airpod') || str_contains($searchSpace, 'phone') || str_contains($searchSpace, 'tech')) {
            return [
                'studio' => 'High-tech wireless gadget on matte black minimalist surface, subtle blue neon rim illumination, sleek industrial product photography, 8k',
                'lifestyle' => 'Modern lifestyle shot of tech accessories neatly arranged on a clean workspace desk beside a laptop, clean bright ambient lighting, 8k'
            ];
        }

        if (str_contains($searchSpace, 'قميص') || str_contains($searchSpace, 'فستان') || str_contains($searchSpace, 'عباية') || str_contains($searchSpace, 'سترة') || str_contains($searchSpace, 'shirt') || str_contains($searchSpace, 'dress')) {
            return [
                'studio' => 'Premium apparel elegantly displayed on a minimalist studio mannequin, soft directional lighting, neutral background, 8k',
                'lifestyle' => 'Fashion editorial photography of modern stylish outfit outdoors, soft cinematic sunlight, high-end commercial ad, 8k'
            ];
        }

        if (str_contains($searchSpace, 'مطبخ') || str_contains($searchSpace, 'طاحونة') || str_contains($searchSpace, 'خلاط') || str_contains($searchSpace, 'kitchen')) {
            return [
                'studio' => 'Modern culinary kitchen appliance on pristine white quartz countertop, professional product illumination, 8k',
                'lifestyle' => 'Cozy bright modern kitchen scene with the appliance on counter, fresh culinary ingredients nearby, warm morning light, 8k'
            ];
        }

        return [
            'studio' => 'High-end commercial studio product photography on elegant minimalist podium, soft directional light, neutral modern backdrop, 8k, photorealistic, sharp focus',
            'lifestyle' => 'Aesthetic commercial lifestyle photography in a modern bright contemporary setting, natural warm ambient lighting, 8k, photorealistic'
        ];
    }

    /**
     * Call Google Gemini API
     */
    protected function callGeminiApi(SellerProducts $product, string $angleLabel, ?string $customPrompt = null): ?array
    {
        $systemInstruction = "أنت خبير محترف ومستشار عالمي في كتابة نصوص صفحات الهبوط الإعلانية والتسويقية فائقة التحويل (CRO Landing Page Copywriter).
مهمتك هي كتابة محتوى تسويقي إقناعي لصفحة هبوط منتج باللغة العربية بناءً على البيانات المقدمة، والتركيز بدقة على الزاوية التسويقية المطلوبة مع توفير بيانات إنفوجرافيك مخصص للهواتف الذكية وبرومبتات إنجليزية احترافية لتوليد صور ترويجية واقعية بدون نصوص.
يجب أن ترجع المخرجات حصراً بتنسيق JSON نظيف وبدون أي وسوم markdown إضافية.";

        $prompt = "بيانات المنتج:
- اسم المنتج: {$product->name}
- نوع المنتج: " . ($product->product_type === 'digital' ? 'رقمي (كتاب إلكتروني/ملف PDF/دورة)' : 'ملموس فيزيائي') . "
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
  \"ai_image_prompts\": {
    \"studio\": \"English commercial studio photography prompt describing this exact product without any text/letters: e.g. Professional commercial studio photography of [translated English product subject], elegant studio lighting, neutral clean background, 8k resolution, crisp focus, photorealistic, no text, no watermark\",
    \"lifestyle\": \"English lifestyle photography prompt showing this product in realistic scene without any text/letters: e.g. Aesthetic commercial lifestyle photography of [product in realistic context], natural ambient lighting, cinematic, 8k, photorealistic, no text, no watermark\"
  },
  \"infographic\": {
    \"badge\": \"دليل ومواصفات المنتج المفصلة للهواتف\",
    \"headline\": \"نظرة مقربة وشاملة على أدق تفاصيل المنتج\",
    \"hotspots\": [
      {\"label\": \"خامة أصلية متينة\", \"detail\": \"مصنوع بأعلى معايير الجودة ليدوم معك طويلاً\"},
      {\"label\": \"تصميم مريح وعصري\", \"detail\": \"يلائم الاستخدام اليومي ويمنحك الراحة القصوى\"},
      {\"label\": \"أداء فائق ونتائج مضمونة\", \"detail\": \"نتائج واضحة وملحوظة من أول تجربة استخدام\"}
    ],
    \"comparison\": {
      \"our_product\": [\"منتج أصلي مضمون 100% مع فحص قبل الدفع\", \"خامات فاخرة غير مقلدة\", \"خدمة عملاء وتوصيل سريع وموثوق\"],
      \"other_products\": [\"منتجات مقلدة سريعة التلف\", \"خامات رديئة تسبب الإحباط\", \"بدون ضمان ولا إمكانية معاينة\"]
    },
    \"specs\": [
      {\"label\": \"النوع\", \"value\": \"أصلي معتمد\"},
      {\"label\": \"التوافق\", \"value\": \"متعدد الاستخدامات ومناسب للجميع\"},
      {\"label\": \"الضمان\", \"value\": \"ضمان المعاينة قبل الاستلام\"},
      {\"label\": \"التوصيل\", \"value\": \"سريع ومباشر حتى باب منزلك\"}
    ]
  },
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
     * Get default infographic structure
     */
    protected function getInfographicDefault(SellerProducts $product, string $angleLabel): array
    {
        return [
            'badge' => 'تفاصيل ومواصفات المنتج بدقة | دليل الموبايل',
            'headline' => 'نظرة مقربة وشاملة على جودة وتفاصيل ' . $product->name,
            'hotspots' => [
                ['label' => 'خامة أصلية متينة', 'detail' => 'مصنوع بأعلى معايير الجودة ليدوم معك طويلاً'],
                ['label' => 'تصميم مريح وعصري', 'detail' => 'يلائم الاستخدام اليومي ويمنحك الراحة القصوى'],
                ['label' => 'أداء فائق ونتائج مضمونة', 'detail' => 'نتائج واضحة وملحوظة من أول تجربة استخدام']
            ],
            'comparison' => [
                'our_product' => ['منتج أصلي مضمون 100% مع فحص قبل الدفع', 'خامات فاخرة تدوم طويلاً', 'خدمة عملاء وتوصيل سريع وموثوق'],
                'other_products' => ['منتجات مقلدة سريعة التلف', 'خامات رديئة تسبب الإحباط', 'بدون أي ضمانات ولا إمكانية معاينة']
            ],
            'specs' => [
                ['label' => 'النوع', 'value' => 'أصلي معتمد'],
                ['label' => 'التوافق', 'value' => 'متعدد الاستخدامات ومناسب للجميع'],
                ['label' => 'الضمان', 'value' => 'ضمان المعاينة قبل الاستلام'],
                ['label' => 'التوصيل', 'value' => 'سريع ومباشر حتى باب منزلك']
            ]
        ];
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
            'ai_image_prompts' => $this->buildFallbackEnglishPrompts($product),
            'infographic' => $this->getInfographicDefault($product, $angleLabel),
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

    /**
     * Get high-converting COD pricing bundles
     */
    public function getDefaultBundles(SellerProducts $product): array
    {
        $price = (float) $product->price;

        return [
            [
                'qty' => 1,
                'title' => 'قطعة واحدة',
                'subtitle' => 'الخيار الأساسي',
                'badge' => '',
                'unit_price' => $price,
                'total_price' => $price,
                'save_amount' => 0,
                'shipping_note' => 'توصيل سريع لـ 58 ولاية',
                'is_popular' => false,
            ],
            [
                'qty' => 2,
                'title' => 'قطعتين',
                'subtitle' => 'الخيار الأكثر طلباً وراحة',
                'badge' => 'الأكثر طلباً 🔥',
                'unit_price' => round($price * 0.85),
                'total_price' => round($price * 2 * 0.85),
                'save_amount' => round($price * 2 * 0.15),
                'shipping_note' => 'تخفيض 15% + أولوية تجهيز الطرد',
                'is_popular' => true,
            ],
            [
                'qty' => 3,
                'title' => '3 قطع',
                'subtitle' => 'حزمة التوفير القصوى',
                'badge' => 'أعلى توفير 🎁',
                'unit_price' => round($price * 0.75),
                'total_price' => round($price * 3 * 0.75),
                'save_amount' => round($price * 3 * 0.25),
                'shipping_note' => 'تخفيض 25% + توصيل مخفض/مجاني',
                'is_popular' => false,
            ]
        ];
    }

    /**
     * Get default frequently asked questions
     */
    public function getDefaultFaqs(SellerProducts $product): array
    {
        return [
            [
                'question' => 'كيف تتم عملية الطلب والاستلام؟',
                'answer' => 'الأمر في غاية السهولة: املأ الاستمارة أسفل الصفحة، ثم يتم تجهيز طلبك فوراً واستلامه بكل أمان.'
            ],
            [
                'question' => 'كم تستغرق مدة الاستلام والتسليم؟',
                'answer' => $product->product_type === 'digital'
                    ? 'المنتجات الرقمية تصلك فوراً وبشكل آلي ومباشر على بريدك الإلكتروني بعد إتمام الدفع بنجاح.'
                    : 'التوصيل للمنتجات الملموسة يتم خلال 24 إلى 48 ساعة لمعظم ولايات الوطن مع متابعة دقيقة للشحنة.'
            ],
            [
                'question' => $product->product_type === 'digital' ? 'كيف أستلم الملف بعد الدفع؟' : 'هل يمكنني معاينة وفحص المنتج قبل الدفع؟',
                'answer' => $product->product_type === 'digital'
                    ? 'بمجرد تأكيد الدفع عبر البطاقة الذهبية/CIB أو التحويل البنكي، يظهر لك زر التحميل الفوري وتصلك نسخة برابط مباشر على بريدك.'
                    : 'نعم بالتأكيد وبكل شفافية! يمكنك فحص الطرد عند استلامه للتأكد التام من مطابقته ومحتواه وجودته قبل دفع المبلغ للموزع.'
            ],
            [
                'question' => 'ماذا لو واجهت أي مشكلة؟',
                'answer' => 'خدمة العملاء متوفرة دائماً لخدمتك مع ضمان الدعم الفني والاستبدال أو الاسترجاع وفق سياسة المتجر.'
            ]
        ];
    }
}
