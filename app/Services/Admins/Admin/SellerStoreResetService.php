<?php

namespace App\Services\Admins\Admin;

use App\Models\BenefitSectionElements;
use App\Models\Seller\Seller;
use App\Models\Seller\SellerFqa;
use App\Models\Seller\SellerPage;
use App\Models\ShippingPrice;
use App\Models\User;
use App\Models\UserBenefitSection;
use App\Models\UserSlider;
use App\Models\UserStoreSetting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SellerStoreResetService
{
    /**
     * Reset the seller's storefront presentation elements to initial defaults
     * while strictly preserving all products, orders, financial data, and account credentials.
     *
     * @param Seller $seller
     * @param User $user
     * @return void
     * @throws \Throwable
     */
    public function reset(Seller $seller, User $user): void
    {
        DB::transaction(function () use ($seller, $user) {
            $userId = $user->id;
            $sellerId = $seller->id;
            $tenantId = $seller->tenant_id;
            $tenantSlug = function_exists('tenant_to_slug') ? tenant_to_slug($tenantId) : $tenantId;

            // 1. Reset Sliders (UserSlider)
            UserSlider::where('user_id', $userId)->delete();
            $defaultSliders = [
                ['user_id' => $userId, 'title' => 'مرحبًا بكم في متجرك', 'description' => 'اكتشف...', 'image' => asset('asset/v1/users/store/img/slider/pc-slider1.png'), 'status' => 'active', 'order' => 1],
                ['user_id' => $userId, 'title' => 'أضف منتجاتك بسهولة', 'description' => 'ابدأ...', 'image' => asset('asset/v1/users/store/img/slider/pc-slider2.png'), 'status' => 'active', 'order' => 2],
                ['user_id' => $userId, 'title' => 'روّج لمنتجاتك الآن', 'description' => 'استخدم...', 'image' => asset('asset/v1/users/store/img/slider/pc-slider3.png'), 'status' => 'active', 'order' => 3],
            ];
            foreach ($defaultSliders as $slider) {
                UserSlider::create($slider);
            }

            // 2. Reset Benefits Section & Elements (UserBenefitSection, BenefitSectionElements)
            $existingSections = UserBenefitSection::where('user_id', $userId)->get();
            foreach ($existingSections as $sec) {
                BenefitSectionElements::where('benefit_section_id', $sec->id)->delete();
                $sec->delete();
            }

            $userBenefit = UserBenefitSection::create([
                'user_id' => $userId,
                'title' => 'لماذا تختارنا؟',
                'description' => 'لسنا الوحيدين لكننا الأفضل',
                'status' => 'active',
                'order' => 1,
            ]);

            $benefitElements = [
                ['title' => 'شحن سريع', 'description' => 'توصيل سريع لجميع أنحاء البلاد', 'icon' => '<i class="fas fa-truck fa-2x"></i>', 'order' => 1],
                ['title' => 'دفع آمن', 'description' => 'طرق دفع متعددة وآمنة', 'icon' => '<i class="fas fa-shield-alt fa-2x"></i>', 'order' => 2],
                ['title' => 'ضمان الإرجاع', 'description' => 'إرجاع مجاني خلال 14 يوم', 'icon' => '<i class="fas fa-undo fa-2x"></i>', 'order' => 3],
            ];
            foreach ($benefitElements as $elem) {
                BenefitSectionElements::create([
                    'benefit_section_id' => $userBenefit->id,
                    'title' => $elem['title'],
                    'description' => $elem['description'],
                    'icon' => $elem['icon'],
                    'order' => $elem['order'],
                ]);
            }

            // 3. Reset Store FAQs (SellerFqa)
            SellerFqa::where('seller_id', $sellerId)->delete();
            $defaultFqas = [
                [
                    'seller_id' => $sellerId,
                    'question' => 'كم يوم يستغرق وصول الطلب؟',
                    'answer' => 'الولايات الكبرى (الجزائر، وهران، قسنطينة): 1-3 أيام | الولايات الداخلية: 3-7 أيام عمل | خلال المواسم (رمضان، العيد): قد تطول المدة يومين إضافيين',
                    'order' => 1,
                    'status' => 'active',
                ],
                [
                    'seller_id' => $sellerId,
                    'question' => 'كيف يمكن إرجاع منتج غير مناسب؟',
                    'answer' => 'مهلة 14 يومًا للإرجاع | يجب أن يكون المنتج في غلافه الأصلي | اتصل بنا على الرقم 0560XXXXXX لترتيب الاسترجاع | تكلفة الشحن للإرجاع: 400 دج (تخصم من المبلغ المسترد)',
                    'order' => 2,
                    'status' => 'active',
                ],
                [
                    'seller_id' => $sellerId,
                    'question' => 'ماذا لو كان لدي مشكلة بعد استلام الطلب؟',
                    'answer' => 'خدمة العملاء متاحة: ☎️ الهاتف: 0560XXXXXX (8 صباحًا - 10 مساءً) | 📱 الواتساب: 0771XXXXXX (24/7) | 📧 البريد: contact@example.dz | متوسط وقت الرد: أقل من ساعتين',
                    'order' => 3,
                    'status' => 'active',
                ],
            ];
            foreach ($defaultFqas as $fqa) {
                SellerFqa::create($fqa);
            }

            // 4. Reset Static Pages (SellerPage)
            SellerPage::where('seller_id', $sellerId)->delete();
            $defaultPages = [
                [
                    'title' => 'عن المتجر',
                    'slug' => $tenantSlug . '-about',
                    'content' => '<h1>عن متجرنا</h1><p>مرحبًا بكم في <strong>متجرنا</strong>، حيث نقدم لكم أفضل المنتجات والخدمات التي تلبي احتياجاتكم بأعلى مستويات الجودة. نحن نسعى دائمًا لتحقيق رضاكم من خلال تجربة تسوق فريدة ومريحة.</p><h2>رؤيتنا</h2><p>أن نكون الوجهة الأولى للتسوق الإلكتروني، مع توفير منتجات متنوعة بأسعار تنافسية وجودة عالية.</p><h2>رسالتنا</h2><p>تقديم تجربة تسوق إلكتروني مميزة تلبي احتياجات العملاء مع الحرص على تقديم خدمة عملاء استثنائية وسريعة.</p><h2>قيمنا</h2><ul><li>الشفافية والمصداقية في التعامل.</li><li>الالتزام بالجودة والتميز.</li><li>الابتكار المستمر في تقديم أفضل الحلول.</li></ul><h2>لماذا نحن؟</h2><p>- نقدم مجموعة واسعة من المنتجات التي تلبي مختلف الأذواق.<br>- نسعى لتقديم أفضل الأسعار مع الحفاظ على الجودة.<br>- نحرص على توفير خدمة عملاء متوفرة على مدار الساعة.<br>- نوفر شحنًا سريعًا وآمنًا لكل الطلبات.</p><h2>تواصل معنا</h2><p>إذا كان لديك أي استفسارات أو اقتراحات، لا تتردد في التواصل معنا عبر صفحة <a href="/contact-us">اتصل بنا</a>. نحن هنا لخدمتك دائمًا.</p>',
                    'meta_title' => 'عن المتجر',
                    'meta_description' => 'صفحة تحتوي على معلومات عن المتجر.',
                    'meta_keywords' => 'معلومات, المتجر',
                    'status' => 'published',
                    'seller_id' => $sellerId,
                ],
                [
                    'title' => 'شحن و التسليم',
                    'slug' => $tenantSlug . '-shipping-policy',
                    'content' => '<h1>الشحن والتسليم</h1><p>في <strong>متجرنا</strong>، نسعى لتوفير تجربة شحن مريحة وسريعة لعملائنا الكرام. نحن نعمل مع أفضل شركات الشحن لضمان وصول طلباتكم بأسرع وقت ممكن وبأعلى مستويات الجودة.</p><h2>مدة معالجة الطلبات</h2><p>- يتم تجهيز الطلبات خلال <strong>1-3 أيام عمل</strong> من تاريخ تأكيد الطلب.<br>- قد تختلف مدة التجهيز بناءً على نوع المنتج أو فترات العروض.</p><h2>شركات الشحن</h2><p>نحن نتعاون مع شركات الشحن الرائدة لضمان تقديم خدمات موثوقة وسريعة.</p><h2>رسوم الشحن</h2><p>- تعتمد رسوم الشحن على وزن المنتج وموقع التسليم.<br>- سيتم عرض تفاصيل رسوم الشحن عند إتمام عملية الدفع.</p><h2>التواصل</h2><p>إذا كان لديك أي استفسارات تتعلق بالشحن والتسليم، لا تتردد في التواصل معنا عبر صفحة <a href="/contact-us">اتصل بنا</a>.</p>',
                    'meta_title' => 'شحن و التسليم',
                    'meta_description' => 'صفحة تحتوي على معلومات عن شحن و التسليم.',
                    'meta_keywords' => 'معلومات, شحن و التسليم',
                    'status' => 'published',
                    'seller_id' => $sellerId,
                ],
                [
                    'title' => 'طرق الدفع',
                    'slug' => $tenantSlug . '-payment-policy',
                    'content' => '<h1>طرق الدفع</h1><p>في <strong>متجرنا</strong>، نوفر لك العديد من الخيارات المريحة والآمنة لإتمام عملية الدفع.</p><h2>خيارات الدفع المتاحة</h2><ul><li><strong>الدفع عند الاستلام</strong></li><li><strong>الدفع الإلكتروني عبر البطاقة الذهبية / CIB</strong></li></ul><h2>معايير الأمان</h2><p>نحن نستخدم أحدث تقنيات التشفير لضمان حماية بياناتك أثناء عملية الدفع.</p>',
                    'meta_title' => 'طرق الدفع',
                    'meta_description' => 'صفحة تحتوي على معلومات عن طرق الدفع.',
                    'meta_keywords' => 'معلومات, طرق الدفع',
                    'status' => 'published',
                    'seller_id' => $sellerId,
                ],
                [
                    'title' => 'شروط الإستخدام',
                    'slug' => $tenantSlug . '-terms-of-use',
                    'content' => '<h1>شروط الاستخدام</h1><p>مرحبًا بك في <strong>متجرنا</strong>. باستخدامك لهذا الموقع، فإنك توافق على الالتزام بالشروط والأحكام التالية.</p><h2>1. القبول بالشروط</h2><p>باستخدامك لهذا الموقع، فإنك تقر بأنك قد قرأت وفهمت ووافقت على الالتزام بهذه الشروط والأحكام.</p><h2>2. الاستخدام المسموح</h2><p>يحق لك استخدام الموقع لأغراض شخصية وقانونية فقط.</p>',
                    'meta_title' => 'شروط الإستخدام',
                    'meta_description' => 'صفحة تحتوي على معلومات عن شروط الإستخدام.',
                    'meta_keywords' => 'معلومات, شروط الإستخدام',
                    'status' => 'published',
                    'seller_id' => $sellerId,
                ],
                [
                    'title' => 'سياسة الإستبدال و الإسترجاع',
                    'slug' => $tenantSlug . '-exchange-policy',
                    'content' => '<h1>سياسة الاستبدال والاسترجاع</h1><p>نحن نسعى دائمًا لضمان رضاكم عن منتجاتنا وخدماتنا. إذا واجهتم أي مشكلة مع أحد المنتجات، فإن سياستنا للاستبدال والاسترجاع تتيح لكم خيارات مرنة ومريحة.</p><h2>1. مدة الاستبدال والاسترجاع</h2><p>الاستبدال خلال 7 أيام، والاسترجاع خلال 14 يومًا من تاريخ الاستلام بشرط بقاء المنتج بحالته الأصلية.</p>',
                    'meta_title' => 'سياسة الإستبدال و الإسترجاع',
                    'meta_description' => 'صفحة تحتوي على معلومات عن سياسة الإستبدال و الإسترجاع.',
                    'meta_keywords' => 'معلومات, سياسة الإستبدال و الإسترجاع',
                    'status' => 'published',
                    'seller_id' => $sellerId,
                ],
                [
                    'title' => 'سياسة الخصوصية',
                    'slug' => $tenantSlug . '-privacy-policy',
                    'content' => '<h1>سياسة الخصوصية</h1><p>نحن نقدر خصوصيتك ونلتزم بحماية بياناتك الشخصية. توضح سياسة الخصوصية هذه كيفية جمع واستخدام ومشاركة معلوماتك عند استخدامك لمنصتنا.</p><h2>حماية البيانات</h2><p>نحن نتخذ التدابير الأمنية المناسبة لحماية بياناتك الشخصية من الوصول غير المصرح به.</p>',
                    'meta_title' => 'سياسة الخصوصية',
                    'meta_description' => 'صفحة تحتوي على معلومات عن سياسة الخصوصية.',
                    'meta_keywords' => 'معلومات, سياسة الخصوصية',
                    'status' => 'published',
                    'seller_id' => $sellerId,
                ],
                [
                    'title' => 'اتصل بنا',
                    'slug' => $tenantSlug . '-contact-us',
                    'content' => '<h1>اتصل بنا</h1><p>نحن هنا لمساعدتك! إذا كانت لديك أي استفسارات أو تحتاج إلى مساعدة، لا تتردد في التواصل معنا.</p>',
                    'meta_title' => 'اتصل بنا',
                    'meta_description' => 'صفحة تحتوي على معلومات عن اتصل بنا.',
                    'meta_keywords' => 'معلومات, اتصل بنا',
                    'status' => 'published',
                    'seller_id' => $sellerId,
                ],
                [
                    'title' => 'الأسئلة الشائعة',
                    'slug' => $tenantSlug . '-faq',
                    'content' => '<h1>الأسئلة الشائعة</h1><p>لقد قمنا بجمع مجموعة من الأسئلة الشائعة التي قد تساعدك في الحصول على إجابات سريعة لاستفساراتك.</p>',
                    'meta_title' => 'الأسئلة الشائعة',
                    'meta_description' => 'صفحة تحتوي على معلومات عن الأسئلة الشائعة.',
                    'meta_keywords' => 'معلومات, الأسئلة الشائعة',
                    'status' => 'published',
                    'seller_id' => $sellerId,
                ],
            ];
            foreach ($defaultPages as $page) {
                SellerPage::create($page);
            }

            // 5. Reset Shipping Prices for all 58 Algerian Wilayas (ShippingPrice)
            ShippingPrice::where('user_id', $userId)->delete();
            $defaultShippingWilayas = [
                1 => ['desk' => 500.00, 'home' => 800.00, 'add' => 200.00],
                2 => ['desk' => 600.00, 'home' => 900.00, 'add' => 250.00],
                3 => ['desk' => 700.00, 'home' => 1000.00, 'add' => 300.00],
                4 => ['desk' => 550.00, 'home' => 850.00, 'add' => 220.00],
                5 => ['desk' => 650.00, 'home' => 950.00, 'add' => 270.00],
            ];

            for ($wId = 1; $wId <= 58; $wId++) {
                $rem = ($wId - 1) % 5 + 1;
                $pattern = $defaultShippingWilayas[$rem];
                ShippingPrice::create([
                    'user_id' => $userId,
                    'wilaya_id' => $wId,
                    'shipping_available_to_wilaya' => 1,
                    'stop_desck_price' => $pattern['desk'],
                    'shipping_available_to_stop_desck' => 1,
                    'to_home_price' => $pattern['home'],
                    'shipping_available_to_home' => 1,
                    'additional_price' => $pattern['add'],
                    'additional_price_status' => 1,
                ]);
            }

            // 6. Reset Store Settings (UserStoreSetting) - Preserving store_name, store_email, store_phone
            $platformName = function_exists('get_platform_name') ? get_platform_name() : 'Multi-Store';
            $settingsToReset = [
                'store_theme' => [
                    'value' => '{"primarycolor":"#343035","bodytextcolor":"#000000", "footertextcolor":"#ffffff"}',
                    'type' => 'json',
                    'description' => 'تصميم المتجر',
                ],
                'store_logo' => [
                    'value' => '/asset/v1/users/store/img/logo/store.png',
                    'type' => 'string',
                    'description' => 'لوجو المتجر',
                ],
                'store_favicon' => [
                    'value' => '/asset/v1/users/store/img/logo/store.png',
                    'type' => 'string',
                    'description' => 'لوجو المتجر',
                ],
                'store_description' => [
                    'value' => 'تكلم عن نشاطك التجاري',
                    'type' => 'string',
                    'description' => 'وصف المتجر',
                ],
                'store_welcome_message' => [
                    'value' => 'مرحبا بكم في متجرنا',
                    'type' => 'string',
                    'description' => 'رسالة الترحيب للمتجر',
                ],
                'store_section_welcome_visibility' => [
                    'value' => 'true',
                    'type' => 'string',
                    'description' => 'اظهار رسالة الترحيب للمتجر',
                ],
                'store_section_slider_visibility' => [
                    'value' => 'true',
                    'type' => 'string',
                    'description' => 'اظهار السلايدر للمتجر',
                ],
                'store_section_categories_visibility' => [
                    'value' => 'true',
                    'type' => 'string',
                    'description' => 'اظهار الفئات للمتجر',
                ],
                'store_section_faqs_visibility' => [
                    'value' => 'true',
                    'type' => 'string',
                    'description' => 'اظهار الاسئلة الشائعة للمتجر',
                ],
                'store_order_form_settings' => [
                    'value' => '{"form_title":"إملأ الإستمارة في الأسفل لتقديم طلبك","lable_customer_name":"الإسم الكامل","input_placeholder_customer_name":"ادخل الاسم الكامل","customer_name_required":"true","lable_customer_phone":"رقم الهاتف","input_placeholder_customer_phone":"ادخل رقم الهاتف","customer_phone_required":"true","lable_customer_email":"البريد الالكتروني","input_placeholder_customer_email":"ادخل البريد الالكتروني","customer_email_required":"true","lable_customer_address":"العنوان","input_placeholder_customer_address":"الحي، الشارع، رقم المنزل","customer_address_required":"false","customer_address_visible":"true","lable_customer_notes":"ملاحظات","input_placeholder_customer_notes":"ادخل ملاحظات","customer_notes_required":"false","customer_notes_visible":"true","lable_product_coupon_code":"كود الكوبون","input_placeholder_product_coupon_code":"أدخل كود الكوبون هنا للحصول على خصم","product_copoun_code_required":"false","form_submit_button":"اشتري الآن"}',
                    'type' => 'json',
                    'description' => 'اعدادات فورم الطلب للمتجر',
                ],
                'store_payment_methods' => [
                    'value' => '{"Cash":{"name":"Cash","status":"active"},"Chargily_Pay":{"name":"ChargilyPay","status":"inactive"},"Ccp":{"name":"Ccp","status":"inactive"},"BaridiMob":{"name":"BaridiMob","status":"inactive"}}',
                    'type' => 'json',
                    'description' => 'طرق الدفع المتاحة للمتجر',
                ],
                'store_language' => [
                    'value' => 'ar',
                    'type' => 'string',
                    'description' => 'لغة المتجر',
                ],
                'store_currency' => [
                    'value' => 'DZD',
                    'type' => 'string',
                    'description' => 'عملة المتجر',
                ],
                'store_facebook' => [
                    'value' => 'https://www.facebook.com',
                    'type' => 'string',
                    'description' => 'صفحة فيسبوك المتجر',
                ],
                'store_telegram' => [
                    'value' => 'https://www.telegram.com',
                    'type' => 'string',
                    'description' => 'صفحة تيليجرام المتجر',
                ],
                'store_tiktok' => [
                    'value' => 'https://www.tiktok.com',
                    'type' => 'string',
                    'description' => 'صفحة تيك توك المتجر',
                ],
                'store_twitter' => [
                    'value' => 'https://www.twitter.com',
                    'type' => 'string',
                    'description' => 'صفحة تويتر المتجر',
                ],
                'store_instagram' => [
                    'value' => 'https://www.instagram.com',
                    'type' => 'string',
                    'description' => 'صفحة انستقرام المتجر',
                ],
                'store_youtube' => [
                    'value' => 'https://www.youtube.com',
                    'type' => 'string',
                    'description' => 'صفحة يوتيوب المتجر',
                ],
                'copyright' => [
                    'value' => $platformName,
                    'type' => 'string',
                    'description' => 'حقوق النشر',
                ],
            ];

            foreach ($settingsToReset as $key => $meta) {
                UserStoreSetting::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'key' => $key,
                    ],
                    [
                        'value' => $meta['value'],
                        'type' => $meta['type'],
                        'description' => $meta['description'],
                        'status' => 'active',
                    ]
                );
            }

            Log::info("Seller store successfully reset to defaults for seller ID: {$sellerId}, User ID: {$userId}");
        });
    }
}
