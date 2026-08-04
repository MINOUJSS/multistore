@extends('site.layouts.app')

@section('google_analitics')
      @if(
          get_platform_data('google_analitics') &&
          get_platform_data('google_analitics')->status == 'active' &&
          !empty(get_platform_data('google_analitics')->value)
      )

      @php
          $measurementId = get_platform_data('google_analitics')->value;
      @endphp

      <script async src="https://www.googletagmanager.com/gtag/js?id={{ $measurementId }}"></script>

      <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
          dataLayer.push(arguments);
      }

      gtag('js', new Date());
      gtag('config', '{{ $measurementId }}');
      </script>

      @endif 
@endsection

@section('hero')
<!-- ======= Privacy Page Hero Header Section ======= -->
<section id="hero" class="d-flex align-items-center position-relative overflow-hidden py-5" style="min-height: 40vh;">
    <!-- Subtle Ambient Background Glows -->
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>

    <div class="container position-relative z-index-2 py-4 text-center">
        <!-- Badge Pill -->
        <div class="d-inline-flex align-items-center gap-2 mb-3 hero-badge-pill">
            <span class="badge-icon">⚖️</span>
            <span class="badge-text fw-bold">{{ __('site.privacy_policy_badge') }}</span>
        </div>

        <!-- Main Title -->
        <h1 class="hero-main-title fw-bold text-white mb-3 fs-1">
            {{ __('site.privacy_policy_page_title') }}
        </h1>

        <!-- Subtitle -->
        <p class="hero-sub-title mb-4 fs-6 mx-auto text-white-80" style="max-width: 720px;">
            {{ __('site.privacy_policy_header_subtitle') }}
        </p>

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="d-flex justify-content-center">
            <ol class="breadcrumb bg-transparent p-0 m-0 text-white-50">
                <li class="breadcrumb-item"><a href="{{ route('site.index') }}" class="text-white text-decoration-none fw-semibold">{{ __('site.home') }}</a></li>
                <li class="breadcrumb-item active text-pink-accent fw-bold" aria-current="page">{{ __('site.privacy_policy') }}</li>
            </ol>
        </nav>
    </div>

    <style>
        #hero {
            background: linear-gradient(135deg, #1f0717 0%, #3b102c 45%, #681d4b 85%, #B03882 100%);
        }

        .hero-glow-1 {
            position: absolute;
            top: -10%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(176, 56, 130, 0.35) 0%, rgba(31, 7, 23, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-glow-2 {
            position: absolute;
            bottom: -15%;
            left: -10%;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(228, 93, 164, 0.25) 0%, rgba(31, 7, 23, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-badge-pill {
            background: rgba(176, 56, 130, 0.2);
            border: 1px solid rgba(228, 93, 164, 0.4);
            color: #ffa1d8;
            padding: 6px 18px;
            border-radius: 30px;
            backdrop-filter: blur(8px);
        }

        .text-pink-accent {
            color: #ff85c6 !important;
        }
    </style>
</section>
@endsection

@section('pricing')
<!-- ======= Main Privacy & Terms Content ======= -->
<section id="privacy-content" class="py-5" style="background: #faf7f9;">
    <div class="container py-3" data-aos="fade-up">

        <!-- Nav Tabs -->
        <div class="d-flex justify-content-center mb-5">
            <ul class="nav nav-pills custom-legal-pills p-1 rounded-pill bg-white shadow-sm border border-light-subtle flex-wrap justify-content-center" id="legalTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active rounded-pill px-4 py-2.5 fw-bold" id="privacy-tab" data-bs-toggle="tab" data-bs-target="#privacy-pane" type="button" role="tab">
                        <i class="bi bi-shield-lock-fill me-1 ms-1"></i> {{ __('site.tab_privacy') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 py-2.5 fw-bold" id="terms-tab" data-bs-toggle="tab" data-bs-target="#terms-pane" type="button" role="tab">
                        <i class="bi bi-file-earmark-text-fill me-1 ms-1"></i> {{ __('site.tab_terms') }}
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link rounded-pill px-4 py-2.5 fw-bold" id="tenancy-tab" data-bs-toggle="tab" data-bs-target="#tenancy-pane" type="button" role="tab">
                        <i class="bi bi-shop me-1 ms-1"></i> {{ __('site.tab_tenancy') }}
                    </button>
                </li>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="tab-content" id="legalTabsContent">

            <!-- 1. Privacy Policy Tab -->
            <div class="tab-pane fade show active" id="privacy-pane" role="tabpanel" tabindex="0">
                <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-light">
                        <h2 class="fw-bold text-dark fs-3 mb-0">
                            <i class="bi bi-shield-check text-pink-accent me-2 ms-2"></i> سياسة الخصوصية وحماية البيانات
                        </h2>
                        <span class="badge bg-light text-muted fw-semibold fs-7 py-2 px-3 rounded-pill">{{ __('site.last_updated') }} 2026</span>
                    </div>

                    <div class="legal-text-body text-secondary lh-lg">
                        <div class="policy-section mb-4">
                            <h4 class="fw-bold text-dark fs-5 mb-2">1. المقدمة ونطاق التطبيق</h4>
                            <p>
                                نلتزم في منصة <strong>{{ config('app.name', 'Multi-Store AI') }}</strong> بحماية خصوصيتك ومعلوماتك التجارية الشاملة. تنطبق هذه السياسة على جميع مستخدمي المنصة بجميع فئاتهم (تجار التجزئة، الموردين وتجار الجملة، المسوقين بالعمولة، وشركات التوصيل والشحن).
                            </p>
                        </div>

                        <div class="policy-section mb-4">
                            <h4 class="fw-bold text-dark fs-5 mb-2">2. البيانات والمعلومات التي نقوم بجمعها</h4>
                            <ul class="styled-legal-list">
                                <li><strong>معلومات الحساب والتسجيل:</strong> الاسم الكامل، البريد الإلكتروني، رقم الهاتف، اسم المتجر أو العلامة التجارية، والعنوان.</li>
                                <li><strong>بيانات المتاجر والمنتجات:</strong> قوائم المنتجات الرقمية والفيزيائية، المخزون، وتفاصيل الأسعار والعروض.</li>
                                <li><strong>البيانات المالية والدفع:</strong> سجلات المعاملات اليومية، تفاصيل سحوبات الحسابات، ومعلومات التأكيد الإلكتروني المعالجة بأمان عبر <strong>Chargily Pay v2</strong> لبطاقات CIB والذهبية، وبريدي موب CCP.</li>
                                <li><strong>بيانات العملاء والشحنات:</strong> أسماء زبائن المتاجر، عناوين التوصيل، وأرقام تتبع الطلبات مع شركات الشحن الشريكة (Yalidine, ZrExpress, Mayastro).</li>
                            </ul>
                        </div>

                        <div class="policy-section mb-4">
                            <h4 class="fw-bold text-dark fs-5 mb-2">3. كيفية استخدام البيانات والمعلومات</h4>
                            <ul class="styled-legal-list">
                                <li>إدارة وتفعيل المتاجر المستقلة على النطاقات الفرعية (Subdomains) بكفاءة وأمان.</li>
                                <li>معالجة وتأكيد المبيعات الإلكترونية وحساب عمولات التسويق وتحديث المحافظ المالية تلقائياً.</li>
                                <li>مشاركة بيانات الشحن والتوصيل الضرورية فقط مع شركات الشحن المعتمدة لضمان وصول الطلبات للعملاء.</li>
                                <li>حماية وتأمين العمليات التجارية ومنع الأنشطة والاحتيال الإلكتروني.</li>
                            </ul>
                        </div>

                        <div class="policy-section mb-4">
                            <h4 class="fw-bold text-dark fs-5 mb-2">4. حماية وتشفير المعاملات المالية (CIB / EDAHABIA)</h4>
                            <p>
                                لا نقوم بتخزين تفاصيل بطاقات الدفع البنكية (CIB والذهبية) على خوادمنا الخاصة. يتم معالجة وتشفير كل المعاملات مباشرة عبر بوابة <strong>Chargily Pay v2</strong> الرسمية والمطابقة لمعايير الأمان المصرفي الدولية.
                            </p>
                        </div>

                        <div class="policy-section mb-4">
                            <h4 class="fw-bold text-dark fs-5 mb-2">5. مشاركة وحظر بيع البيانات</h4>
                            <p>
                                نلتزم بعدم بيع أو تأجير أو مشاركة أي بيانات شخصية أو تجارية لأي طرف ثالث لأغراض تسويقية. تقتصر مشاركة البيانات على الشركاء التقنيين وشركات الشحن المعتمدة في إطار تنفيذ الخدمات فقط أو بطلب رسمي من السلطات القضائية والقانونية.
                            </p>
                        </div>

                        <div class="policy-section mb-2">
                            <h4 class="fw-bold text-dark fs-5 mb-2">6. حقوق المستخدم والتواصل</h4>
                            <p>
                                يحق لجميع المستخدمين الاطلاع على بياناتهم المحفوظة، طلب تحديثها، أو تقديم طلب حذف الحساب نهائياً عبر التواصل مع فريق الدعم الفني على البريد الإلكتروني: <strong class="text-pink-accent">support@dzora.net</strong>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Terms of Use Tab -->
            <div class="tab-pane fade" id="terms-pane" role="tabpanel" tabindex="0">
                <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-light">
                        <h2 class="fw-bold text-dark fs-3 mb-0">
                            <i class="bi bi-file-earmark-lock text-pink-accent me-2 ms-2"></i> شروط وأحكام الاستخدام
                        </h2>
                        <span class="badge bg-light text-muted fw-semibold fs-7 py-2 px-3 rounded-pill">{{ __('site.last_updated') }} 2026</span>
                    </div>

                    <div class="legal-text-body text-secondary lh-lg">
                        <div class="policy-section mb-4">
                            <h4 class="fw-bold text-dark fs-5 mb-2">1. موافقة المستخدم</h4>
                            <p>
                                يُعد استخدامك لمنصة <strong>Multi-Store AI</strong> أو إنشاء حساب عليها بمثابة موافقة قانونية كاملة وغير مشروطة على الالتزام بهذه الشروط والأحكام.
                            </p>
                        </div>

                        <div class="policy-section mb-4">
                            <h4 class="fw-bold text-dark fs-5 mb-2">2. شروط العضوية والتسجيل</h4>
                            <ul class="styled-legal-list">
                                <li>أن يكون عمر المستخدم 18 عاماً فأكثر أو يحمل الصلاحية القانونية للتجارة.</li>
                                <li>تقديم معلومات هويّة ونشاط تجاري صحيحة ودقيقة عند التسجيل.</li>
                                <li>تحمّل المسؤولية الكاملة عن جميع الأنشطة والمعاملات التي تتم من خلال بيانات حسابه.</li>
                            </ul>
                        </div>

                        <div class="policy-section mb-4">
                            <h4 class="fw-bold text-dark fs-5 mb-2">3. التزامات ومسؤوليات أطراف التجارة</h4>
                            <div class="row g-3 my-2">
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border border-light-subtle h-100">
                                        <h6 class="fw-bold text-dark mb-2"><i class="bi bi-shop text-pink-accent me-1"></i> التجار والموردين</h6>
                                        <p class="small text-muted mb-0">الالتزام بمصداقية مواصفات الأسعار والمنتجات، وتقديم الدعم للزبائن والتأكد من مطابقة البضائع للضوابط القانونية.</p>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="p-3 rounded-3 bg-light border border-light-subtle h-100">
                                        <h6 class="fw-bold text-dark mb-2"><i class="bi bi-megaphone text-pink-accent me-1"></i> المسوقون بالعمولة</h6>
                                        <p class="small text-muted mb-0">حظر استخدام السبام (Spam) أو الإعلانات المضللة، والالتزام بالقنوات الإعلانية المعتمدة والمشروعة.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="policy-section mb-4">
                            <h4 class="fw-bold text-dark fs-5 mb-2">4. الاشتراكات والرسوم المالية</h4>
                            <p>
                                يتم سداد رسوم خطط الاشتراك (للتجار والموردين) بحسب الدورة المختارة (شهرياً أو سنوياً). لا تُرد الرسوم بعد تفعيل الخدمات واستهلاك خطة الاشتراك إلا في الحالات المحددة صراحة في سياسة الإلغاء.
                            </p>
                        </div>

                        <div class="policy-section mb-4">
                            <h4 class="fw-bold text-dark fs-5 mb-2">5. حقوق الملكية الفكرية</h4>
                            <p>
                                جميع حقوق الملكية الفكرية والبرمجية والأكواد الخاصة بمنصة Multi-Store AI هي ملك حصري للمنصة. يُحظر نسخ، تعديل، أو إعادة هندسة أي جزء منها بدون موافقة كتابية مسبقة.
                            </p>
                        </div>

                        <div class="policy-section mb-2">
                            <h4 class="fw-bold text-dark fs-5 mb-2">6. إنهاء أو تعليق الحساب</h4>
                            <p>
                                تحتفظ المنصة بالحق في تعليق أو إلغاء أي حساب يخالف شروط الاستخدام أو يقوم بنشر منتجات حظرتها الأنظمة أو يمارس احتيالاً تجارياً دون إشعار مسبق.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Tenancy & Digital Products Rules Tab -->
            <div class="tab-pane fade" id="tenancy-pane" role="tabpanel" tabindex="0">
                <div class="card border-0 rounded-4 shadow-sm p-4 p-md-5 bg-white">
                    <div class="d-flex align-items-center justify-content-between mb-4 pb-3 border-bottom border-light">
                        <h2 class="fw-bold text-dark fs-3 mb-0">
                            <i class="bi bi-box-seam text-pink-accent me-2 ms-2"></i> ضوابط المتاجر والمنتجات الرقمية والشحن
                        </h2>
                        <span class="badge bg-light text-muted fw-semibold fs-7 py-2 px-3 rounded-pill">{{ __('site.last_updated') }} 2026</span>
                    </div>

                    <div class="legal-text-body text-secondary lh-lg">
                        <div class="policy-section mb-4">
                            <h4 class="fw-bold text-dark fs-5 mb-2">1. استقلالية المتاجر السحابية (Subdomains Isolation)</h4>
                            <p>
                                تعمل المتاجر المنشأة عبر منصتنا بنظام العزل التجاري والتنظيمي عبر تقنية <strong>Multi-Tenancy</strong>. يتحمل صاحب المتجر كافة التبعات القانونية والتجارية للمنتجات المعروضة داخل متجره المستقل.
                            </p>
                        </div>

                        <div class="policy-section mb-4">
                            <h4 class="fw-bold text-dark fs-5 mb-2">2. شروط وضوابط بيع المنتجات الرقمية (Digital Products)</h4>
                            <ul class="styled-legal-list">
                                <li>يُسمح ببيع الكورسات التعليمية، الكتب الإلكترونية، التصاميم، والملفات الرقمية ذات الحقوق المشروعة.</li>
                                <li>يتم التسليم الفوري والتلقائي للملفات والأكواد الرقمية فور تأكيد عملية الدفع الإلكتروني عبر البوابة.</li>
                                <li>يُمنع منعاً باتاً بيع أي ملفات أو برمجيات مقرصنة أو تنتهك حقوق النشر والملكية الفكرية للغير.</li>
                            </ul>
                        </div>

                        <div class="policy-section mb-4">
                            <h4 class="fw-bold text-dark fs-5 mb-2">3. الشحن والتوصيل المتكامل (Courierdz System)</h4>
                            <p>
                                يتم توجيه ومعالجة طلبات التوصيل تلقائياً عبر نظام الربط المدمج مع شركاء التوصيل (Yalidine, ZrExpress, Mayastro). يتحمل التجر وشركة التوصيل مسؤولية السلامة وتحديث حالة الشحنة حتى استلام الزبون.
                            </p>
                        </div>

                        <div class="policy-section mb-2">
                            <h4 class="fw-bold text-dark fs-5 mb-2">4. تسوية الأرصدة والمحفظة المالية (Financial Ledger)</h4>
                            <p>
                                تُسجل جميع المستحقات المالية والعمولات داخل سجل المحفظة الإلكترونية الخاصة بكل مستخدم. يتم قفل وتسوية السحوبات وفق الجداول الزمنية والحدود الدنيا المحددة في لوحة التحكم.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
</section>

<style>
.custom-legal-pills .nav-link {
    color: #495057;
    transition: all 0.3s ease;
}

.custom-legal-pills .nav-link.active {
    background: linear-gradient(135deg, #B03882 0%, #d6479f 100%) !important;
    color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(176, 56, 130, 0.35);
}

.custom-legal-pills .nav-link:hover:not(.active) {
    background: rgba(176, 56, 130, 0.08);
    color: #B03882;
}

.styled-legal-list {
    padding-right: 1.25rem;
    margin-bottom: 1rem;
}

.styled-legal-list li {
    margin-bottom: 0.75rem;
}

.text-pink-accent {
    color: #B03882 !important;
}

.fs-7 {
    font-size: 0.875rem !important;
}
</style>
@endsection