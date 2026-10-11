<?php

namespace Database\Seeders;

use App\Models\PlatformService;
use Illuminate\Database\Seeder;

class PlatformServicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            // ==========================================
            // 1. CHARGILY PAY - PER ORDER QUOTA TIERS
            // ==========================================
            [
                'slug' => 'chargily_pay_5_orders',
                'name_ar' => 'باقة 5 طلبات دفع شارجلي (Chargily Pay)',
                'name_en' => 'Chargily Pay - 5 Orders Pack',
                'description_ar' => 'باقة تجريبية تتيح قبول الدفع الإلكتروني بالبطاقة الذهبية و CIB لـ 5 طلبات متجر بنجاح دون أي التزام طويل الأمد.',
                'description_en' => 'Trial pack to accept Chargily electronic payments for 5 orders.',
                'icon' => 'fa-solid fa-credit-card',
                'category' => 'payment',
                'price' => 250.00,
                'billing_type' => 'order_quota',
                'orders_limit' => 5,
                'validity_days' => null,
                'credits_amount' => null,
                'badge_text' => 'تجريبية',
                'badge_color' => 'secondary',
                'features' => [
                    'قبول الدفع بالبطاقة الذهبية وبطاقات CIB لـ 5 طلبات',
                    'تكلفة 50 د.ج فقط لكل طلب دفع إلكتروني ناجح',
                    'تأكيد الطلبات تلقائياً فور نجاح عملية الدفع',
                    'الرصيد دائم ومحفوظ حتى استهلاك كامل الطلبات',
                ],
                'is_active' => true,
                'sort_order' => 1,
            ],
            [
                'slug' => 'chargily_pay_25_orders',
                'name_ar' => 'باقة 25 طلباً شارجلي (باقة الانطلاق)',
                'name_en' => 'Chargily Pay - 25 Orders Pack',
                'description_ar' => 'باقة متوازنة توفر لك 25 عملية دفع إلكتروني عبر شارجلي مع توفير 20% على تكلفة كل طلب دفع في متجرك.',
                'description_en' => 'Starter pack for 25 orders with 20% savings per order.',
                'icon' => 'fa-solid fa-credit-card',
                'category' => 'payment',
                'price' => 1000.00,
                'billing_type' => 'order_quota',
                'orders_limit' => 25,
                'validity_days' => null,
                'credits_amount' => null,
                'badge_text' => 'الأكثر طلباً',
                'badge_color' => 'success',
                'features' => [
                    'قبول الدفع بالبطاقة لـ 25 طلباً ناجحاً',
                    'تكلفة مخفضة (40 د.ج للطلب) مع توفير 20%',
                    'تأكيد الطلبات وتحويل حالتها تلقائياً إلى مدفوعة',
                    'رصيد تراكمي يضاف مباشرة إلى رصيدك المتبقي',
                ],
                'is_active' => true,
                'sort_order' => 2,
            ],
            [
                'slug' => 'chargily_pay_60_orders',
                'name_ar' => 'باقة 60 طلباً شارجلي (باقة النمو)',
                'name_en' => 'Chargily Pay - 60 Orders Pack',
                'description_ar' => 'باقة مخصصة للمتاجر سريعة النمو تمنحك 60 طلب دفع إلكتروني بتكلفة 35 د.ج فقط لكل طلب مع توفير 30%.',
                'description_en' => 'Growth pack for 60 orders with 30% savings per order.',
                'icon' => 'fa-solid fa-credit-card',
                'category' => 'payment',
                'price' => 2100.00,
                'billing_type' => 'order_quota',
                'orders_limit' => 60,
                'validity_days' => null,
                'credits_amount' => null,
                'badge_text' => 'قيمة ممتازة',
                'badge_color' => 'warning',
                'features' => [
                    'قبول الدفع الإلكتروني شارجلي لـ 60 طلباً متكاملاً',
                    'سعر مميز (35 د.ج فقط للطلب) وتوفير 30%',
                    'إحصائيات مالية دقيقة لكل المبيعات الإلكترونية',
                    'صلاحية مفتوحة ومستمرة دون أي موعد انتهاء',
                ],
                'is_active' => true,
                'sort_order' => 3,
            ],
            [
                'slug' => 'chargily_pay_150_orders',
                'name_ar' => 'باقة 150 طلباً شارجلي (الباقة الاحترافية)',
                'name_en' => 'Chargily Pay - 150 Orders Pack',
                'description_ar' => 'الباقة الأكبر والأوفر للمتاجر الكبرى وحملات الإعلانات المكثفة بتكلفة 30 د.ج فقط للطلب وتوفير هائل 40%.',
                'description_en' => 'Pro pack for 150 orders with maximum savings of 40%.',
                'icon' => 'fa-solid fa-credit-card',
                'category' => 'payment',
                'price' => 4500.00,
                'billing_type' => 'order_quota',
                'orders_limit' => 150,
                'validity_days' => null,
                'credits_amount' => null,
                'badge_text' => 'أعلى توفير',
                'badge_color' => 'primary',
                'features' => [
                    'قبول الدفع الإلكتروني لـ 150 طلباً كاملاً',
                    'أقصى توفير ممكن (30 د.ج فقط لكل طلب - وفر 40%)',
                    'مثالية للحملات الإعلانية ومواسم الذروة والمبيعات العالية',
                    'رصيد دائم يضاف فوراً لمحفظة طلبات متجرك',
                ],
                'is_active' => true,
                'sort_order' => 4,
            ],

            // ==========================================
            // 2. BANK TRANSFER - PER ORDER QUOTA TIERS
            // ==========================================
            [
                'slug' => 'bank_transfer_10_orders',
                'name_ar' => 'باقة 10 طلبات دفع بالتحويل البنكي',
                'name_en' => 'Bank Transfer - 10 Orders Pack',
                'description_ar' => 'تفعيل خيار الدفع عبر التحويل البنكي و CCP وبريدي موب لـ 10 طلبات في متجرك على الخطة المجانية دون ترقية الخطة.',
                'description_en' => 'Accept bank transfer and BaridiMob payments for 10 orders on Free plan.',
                'icon' => 'fa-solid fa-building-columns',
                'category' => 'store_features',
                'price' => 500.00,
                'billing_type' => 'order_quota',
                'orders_limit' => 10,
                'validity_days' => null,
                'credits_amount' => null,
                'badge_text' => 'باقة البداية',
                'badge_color' => 'secondary',
                'features' => [
                    'إمكانية رفع إيصال الدفع البنكي لـ 10 طلبات',
                    'دعم الدفع عبر CCP وبريدي موب والتحويلات البنكية',
                    'تكلفة 50 د.ج فقط لكل طلب تحويل بنكي',
                    'صلاحية دائمة حتى استهلاك جميع الطلبات الـ 10',
                ],
                'is_active' => true,
                'sort_order' => 5,
            ],
            [
                'slug' => 'bank_transfer_30_orders',
                'name_ar' => 'باقة 30 طلباً بالتحويل البنكي (المتاجر النشطة)',
                'name_en' => 'Bank Transfer - 30 Orders Pack',
                'description_ar' => 'باقة متقدمة لاستقبال 30 طلب تحويل بنكي مع رفع الإيصالات وتأكيدها بسهولة بتكلفة 40 د.ج للطلب مع توفير 20%.',
                'description_en' => 'Accept bank transfer payments for 30 orders with 20% savings.',
                'icon' => 'fa-solid fa-building-columns',
                'category' => 'store_features',
                'price' => 1200.00,
                'billing_type' => 'order_quota',
                'orders_limit' => 30,
                'validity_days' => null,
                'credits_amount' => null,
                'badge_text' => 'الأكثر طلباً',
                'badge_color' => 'warning',
                'features' => [
                    'استقبال وتأكيد 30 طلب دفع بالتحويل البنكي',
                    'تكلفة مخفضة (40 د.ج للطلب) مع توفير 20%',
                    'معاينة وتأكيد إيصالات الدفع مباشرة من لوحة التحكم',
                    'رصيد تراكمي يضاف فوراً إلى رصيد طلباتك السابقة',
                ],
                'is_active' => true,
                'sort_order' => 6,
            ],
            [
                'slug' => 'bank_transfer_100_orders',
                'name_ar' => 'باقة 100 طلب بالتحويل البنكي (التوفير الأقصى)',
                'name_en' => 'Bank Transfer - 100 Orders Pack',
                'description_ar' => 'الباقة الكبرى للتوفير: استقبل حتى 100 طلب دفع بالتحويل البنكي بتكلفة 30 د.ج فقط للطلب وخصم هائل 40%.',
                'description_en' => 'Mega savings pack for 100 bank transfer orders.',
                'icon' => 'fa-solid fa-building-columns',
                'category' => 'store_features',
                'price' => 3000.00,
                'billing_type' => 'order_quota',
                'orders_limit' => 100,
                'validity_days' => null,
                'credits_amount' => null,
                'badge_text' => 'أفضل قيمة',
                'badge_color' => 'danger',
                'features' => [
                    'استقبال وتأكيد حتى 100 طلب دفع بنكي و CCP',
                    'أعلى نسبة توفير (30 د.ج فقط للطلب - وفر 40%)',
                    'راحة تامة لزبائنك دون الحاجة لترقية خطة المتجر',
                    'رصيد دائم ومحفوظ في حسابك حتى استهلاك كامل الطلبات',
                ],
                'is_active' => true,
                'sort_order' => 7,
            ],

            // ==========================================
            // 3. AI TOOLS - LANDING PAGES CREDIT PACKS
            // ==========================================
            [
                'slug' => 'ai_landing_page_credits_50',
                'name_ar' => 'باقة 50 نقطة ذكاء اصطناعي (صفحات الهبوط)',
                'name_en' => '50 AI Landing Page Credits',
                'description_ar' => 'رصيد نقاط مخصص لإنشاء وتوليد نصوص وتصميم صفحات هبوط تسويقية متكاملة فائقة التحويل بنقرة زر واحدة عبر الذكاء الاصطناعي.',
                'description_en' => 'Credits package to generate high-converting landing pages using AI.',
                'icon' => 'fa-solid fa-wand-magic-sparkles',
                'category' => 'ai_tools',
                'price' => 1200.00,
                'billing_type' => 'credit_pack',
                'orders_limit' => null,
                'validity_days' => null,
                'credits_amount' => 50,
                'badge_text' => 'جديد ومبتكر',
                'badge_color' => 'info',
                'features' => [
                    'توليد حتى 5 صفحات هبوط متكاملة بضغطة زر',
                    'صياغة نصوص إعلانية مقنعة وفق استراتيجيات التسويق',
                    'النقاط صالحة مدى الحياة وتبقى حتى استهلاكها بالكامل',
                    'جاهز للاستخدام مع نظام منشئ صفحات الهبوط بالـ AI',
                ],
                'is_active' => true,
                'sort_order' => 8,
            ],
            [
                'slug' => 'ai_landing_page_credits_120',
                'name_ar' => 'باقة 120 نقطة ذكاء اصطناعي (الباقة التوفيرية)',
                'name_en' => '120 AI Landing Page Credits (Pro Pack)',
                'description_ar' => 'باقة متقدمة من نقاط الذكاء الاصطناعي لتوليد وتخصيص صفحات هبوط احترافية ومحتوى متقدم لحملاتك الإعلانية مع توفير اقتصادي.',
                'description_en' => 'Pro AI credits package for power sellers generating high-converting pages.',
                'icon' => 'fa-solid fa-brain',
                'category' => 'ai_tools',
                'price' => 2400.00,
                'billing_type' => 'credit_pack',
                'orders_limit' => null,
                'validity_days' => null,
                'credits_amount' => 120,
                'badge_text' => 'أفضل قيمة',
                'badge_color' => 'danger',
                'features' => [
                    'توليد حتى 12 صفحة هبوط احترافية متكاملة',
                    'أولوية معالجة وسرعة فائقة في التوليد',
                    'توفير 20% مقارنة بالباقة العادية',
                    'النقاط دائمة ومحفوظة في حسابك دون انتهاء صلاحية',
                ],
                'is_active' => true,
                'sort_order' => 9,
            ],
        ];

        // Clean up old static slugs if existed to refresh cleanly
        PlatformService::whereIn('slug', ['chargily_license', 'bank_transfer_addon'])->delete();

        foreach ($services as $data) {
            PlatformService::updateOrCreate(
                ['slug' => $data['slug']],
                $data
            );
        }
    }
}
