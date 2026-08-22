<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-cubes text-warning"></i>
                    <span class="fw-semibold">{{ __('متجر التطبيقات والتكاملات') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    متجر التطبيقات والتكاملات الذكية 🧩
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    ربط متجرك بأدوات التحليل، البيكسل للإعلانات (Facebook, TikTok, Google)، المزامنة مع Google Sheets، وإشعارات Telegram.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <span class="badge bg-white bg-opacity-15 text-white px-3.5 py-2.5 rounded-3 border border-white border-opacity-20 d-inline-flex align-items-center gap-2 fs-6 fw-semibold">
                        <i class="fa-solid fa-puzzle-piece text-warning"></i>
                        <span>6 تطبيقات مدمجة</span>
                    </span>
                </div>
            </div>
        </div>
        <!-- Decorative Glow Background Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10"
            style="width: 250px; height: 250px; top: -60px; left: -60px; pointer-events: none; filter: blur(40px);">
        </div>
        <div class="position-absolute rounded-circle bg-warning opacity-10"
            style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);">
        </div>
    </div>

    <!-- Statistical Indicator Cards Grid -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Apps -->
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-plum-subtle text-plum fw-bold">
                            <i class="fa-solid fa-cubes-stacked fs-5"></i>
                        </span>
                        <span class="badge bg-light text-secondary rounded-pill small">الكل</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">6</h3>
                    <p class="text-muted small mb-0 fw-semibold">إجمالي التطبيقات المتاحة</p>
                </div>
            </div>
        </div>

        <!-- 2. Tracking & Analytics -->
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-info-subtle text-info fw-bold">
                            <i class="fa-solid fa-chart-line fs-5"></i>
                        </span>
                        <span class="badge bg-info-subtle text-info rounded-pill small">تحليل وبيكسل</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">4</h3>
                    <p class="text-muted small mb-0 fw-semibold">أدوات التتبع والتحليل الرقمي</p>
                </div>
            </div>
        </div>

        <!-- 3. Automation & Notifications -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-success-subtle text-success fw-bold">
                            <i class="fa-solid fa-bolt fs-5"></i>
                        </span>
                        <span class="badge bg-success-subtle text-success rounded-pill small">أتمتة وتنبيهات</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">2</h3>
                    <p class="text-muted small mb-0 fw-semibold">أدوات المزامنة والتنبيهات المباشرة</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Apps Container Section -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
        <div class="card-header bg-white border-0 py-3.5 px-3 px-md-4 d-flex align-items-center gap-2 border-bottom border-light">
            <span class="avatar avatar-md rounded-3 bg-plum-subtle text-plum fw-bold me-1" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                <i class="fa-solid fa-grip fs-6"></i>
            </span>
            <h5 class="fw-bold mb-0 text-dark fs-6">قائمة التطبيقات والتكاملات المتاحة</h5>
        </div>
        <div class="card-body p-3.5 p-md-4">
            @php
                $plan_id = get_seller_data(auth()->user()->tenant_id)->plan_subscription->plan_id;
            @endphp
            
            <div class="row g-4">
                <!-- 1. Google Analytics -->
                <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">
                    <div class="card border border-light-subtle shadow-sm rounded-4 h-100 w-100 overflow-hidden bg-white hover-lift transition-all d-flex flex-column">
                        <div class="app-card-img-wrapper p-4 bg-light text-center border-bottom d-flex align-items-center justify-content-center position-relative" style="height: 170px;">
                            @if($plan_id != 1)
                                <span class="badge bg-success-subtle text-success border border-success position-absolute top-0 end-0 m-3 px-2.5 py-1 rounded-pill small fw-bold">
                                    <i class="fa-solid fa-unlock me-1"></i>متاح
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning position-absolute top-0 end-0 m-3 px-2.5 py-1 rounded-pill small fw-bold">
                                    <i class="fa-solid fa-lock me-1"></i>ترقية الخطة
                                </span>
                            @endif
                            <img src="{{ asset('asset/v1/users/dashboard/img/apps/google_analytics.png') }}" class="img-fluid object-fit-contain" alt="Google Analytics" style="max-height: 100px;">
                        </div>
                        <div class="card-body p-4 d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <h5 class="card-title fw-bold text-dark mb-0 fs-5">Google Analytics</h5>
                                </div>
                                <p class="card-text text-muted small leading-relaxed mb-4">
                                    تتبع حركة الزوار وتحليل سلوك المستخدمين على موقعك لفهم أداء المحتوى وتحسين التجربة الرقمية.
                                </p>
                            </div>
                            <div>
                                @if($plan_id != 1)
                                    <a href="{{ route('seller.app.google-analytics') }}" class="btn btn-seller-primary w-100 rounded-3 shadow-sm py-2.5 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                                        <i class="fa-solid fa-sliders"></i>
                                        <span>إدارة الإعدادات</span>
                                    </a>
                                @else
                                    <span class="btn btn-secondary w-100 rounded-3 py-2.5 disabled opacity-75 fw-semibold d-inline-flex align-items-center justify-content-center gap-2">
                                        <i class="fa-solid fa-lock"></i>
                                        <span>يتطلب ترقية الخطة</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. Facebook Pixel -->
                <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">
                    <div class="card border border-light-subtle shadow-sm rounded-4 h-100 w-100 overflow-hidden bg-white hover-lift transition-all d-flex flex-column">
                        <div class="app-card-img-wrapper p-4 bg-light text-center border-bottom d-flex align-items-center justify-content-center position-relative" style="height: 170px;">
                            <span class="badge bg-success-subtle text-success border border-success position-absolute top-0 end-0 m-3 px-2.5 py-1 rounded-pill small fw-bold">
                                <i class="fa-solid fa-unlock me-1"></i>متاح
                            </span>
                            <img src="{{ asset('asset/v1/users/dashboard/img/apps/facebook_pixel.jpg') }}" class="img-fluid rounded-3 object-fit-cover" alt="Facebook Pixel" style="max-height: 110px; max-width: 100%;">
                        </div>
                        <div class="card-body p-4 d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <h5 class="card-title fw-bold text-dark mb-0 fs-5">Facebook Pixel</h5>
                                </div>
                                <p class="card-text text-muted small leading-relaxed mb-4">
                                    تتبع تفاعل الزوار مع موقعك وتحسين استهداف الإعلانات لتحقيق أقصى استفادة من حملاتك الإعلانية على فيسبوك.
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('seller.app.facebook-pixel') }}" class="btn btn-seller-primary w-100 rounded-3 shadow-sm py-2.5 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                                    <i class="fa-solid fa-sliders"></i>
                                    <span>إدارة الإعدادات</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. TikTok Pixel -->
                <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">
                    <div class="card border border-light-subtle shadow-sm rounded-4 h-100 w-100 overflow-hidden bg-white hover-lift transition-all d-flex flex-column">
                        <div class="app-card-img-wrapper p-4 bg-light text-center border-bottom d-flex align-items-center justify-content-center position-relative" style="height: 170px;">
                            @if($plan_id != 1)
                                <span class="badge bg-success-subtle text-success border border-success position-absolute top-0 end-0 m-3 px-2.5 py-1 rounded-pill small fw-bold">
                                    <i class="fa-solid fa-unlock me-1"></i>متاح
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning position-absolute top-0 end-0 m-3 px-2.5 py-1 rounded-pill small fw-bold">
                                    <i class="fa-solid fa-lock me-1"></i>ترقية الخطة
                                </span>
                            @endif
                            <img src="{{ asset('asset/v1/users/dashboard/img/apps/tiktok_pixel.png') }}" class="img-fluid object-fit-contain" alt="TikTok Pixel" style="max-height: 100px;">
                        </div>
                        <div class="card-body p-4 d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <h5 class="card-title fw-bold text-dark mb-0 fs-5">TikTok Pixel</h5>
                                </div>
                                <p class="card-text text-muted small leading-relaxed mb-4">
                                    تتبع نشاط الزوار على موقعك وتحسين استهداف الإعلانات لتحقيق نتائج أفضل على منصة تيك توك.
                                </p>
                            </div>
                            <div>
                                @if($plan_id != 1)
                                    <a href="{{ route('seller.app.tiktok-pixel') }}" class="btn btn-seller-primary w-100 rounded-3 shadow-sm py-2.5 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                                        <i class="fa-solid fa-sliders"></i>
                                        <span>إدارة الإعدادات</span>
                                    </a>
                                @else
                                    <span class="btn btn-secondary w-100 rounded-3 py-2.5 disabled opacity-75 fw-semibold d-inline-flex align-items-center justify-content-center gap-2">
                                        <i class="fa-solid fa-lock"></i>
                                        <span>يتطلب ترقية الخطة</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. Google Sheets -->
                <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">
                    <div class="card border border-light-subtle shadow-sm rounded-4 h-100 w-100 overflow-hidden bg-white hover-lift transition-all d-flex flex-column">
                        <div class="app-card-img-wrapper p-4 bg-light text-center border-bottom d-flex align-items-center justify-content-center position-relative" style="height: 170px;">
                            @if($plan_id != 1)
                                <span class="badge bg-success-subtle text-success border border-success position-absolute top-0 end-0 m-3 px-2.5 py-1 rounded-pill small fw-bold">
                                    <i class="fa-solid fa-unlock me-1"></i>متاح
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning position-absolute top-0 end-0 m-3 px-2.5 py-1 rounded-pill small fw-bold">
                                    <i class="fa-solid fa-lock me-1"></i>ترقية الخطة
                                </span>
                            @endif
                            <img src="{{ asset('asset/v1/users/dashboard/img/apps/google_sheet.jpg') }}" class="img-fluid rounded-3 object-fit-cover" alt="Google Sheets" style="max-height: 110px; max-width: 100%;">
                        </div>
                        <div class="card-body p-4 d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <h5 class="card-title fw-bold text-dark mb-0 fs-5">Google Sheets</h5>
                                </div>
                                <p class="card-text text-muted small leading-relaxed mb-4">
                                    مزامنة البيانات تلقائيًا مع Google Sheets لتنظيم المعلومات وتحليلها بسهولة في الوقت الفعلي.
                                </p>
                            </div>
                            <div>
                                @if($plan_id != 1)
                                    <a href="{{ route('seller.app.google-sheet') }}" class="btn btn-seller-primary w-100 rounded-3 shadow-sm py-2.5 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                                        <i class="fa-solid fa-sliders"></i>
                                        <span>إدارة الإعدادات</span>
                                    </a>
                                @else
                                    <span class="btn btn-secondary w-100 rounded-3 py-2.5 disabled opacity-75 fw-semibold d-inline-flex align-items-center justify-content-center gap-2">
                                        <i class="fa-solid fa-lock"></i>
                                        <span>يتطلب ترقية الخطة</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. Telegram Notifications -->
                <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">
                    <div class="card border border-light-subtle shadow-sm rounded-4 h-100 w-100 overflow-hidden bg-white hover-lift transition-all d-flex flex-column">
                        <div class="app-card-img-wrapper p-4 bg-light text-center border-bottom d-flex align-items-center justify-content-center position-relative" style="height: 170px;">
                            <span class="badge bg-success-subtle text-success border border-success position-absolute top-0 end-0 m-3 px-2.5 py-1 rounded-pill small fw-bold">
                                <i class="fa-solid fa-unlock me-1"></i>متاح
                            </span>
                            <img src="{{ asset('asset/v1/users/dashboard/img/apps/telegram.png') }}" class="img-fluid object-fit-contain" alt="Telegram Notifications" style="max-height: 100px;">
                        </div>
                        <div class="card-body p-4 d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <h5 class="card-title fw-bold text-dark mb-0 fs-5">Telegram Notifications</h5>
                                </div>
                                <p class="card-text text-muted small leading-relaxed mb-4">
                                    استلم إشعارات فورية عبر Telegram حول حالة الطلبات، مما يساعدك على متابعة عمليات الشراء والتحديثات بسهولة وفي أي وقت.
                                </p>
                            </div>
                            <div>
                                <a href="{{ route('seller.app.telegram-notifications') }}" class="btn btn-seller-primary w-100 rounded-3 shadow-sm py-2.5 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                                    <i class="fa-solid fa-sliders"></i>
                                    <span>إدارة الإعدادات</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. Microsoft Clarity -->
                <div class="col-12 col-sm-6 col-lg-4 d-flex align-items-stretch">
                    <div class="card border border-light-subtle shadow-sm rounded-4 h-100 w-100 overflow-hidden bg-white hover-lift transition-all d-flex flex-column">
                        <div class="app-card-img-wrapper p-4 bg-light text-center border-bottom d-flex align-items-center justify-content-center position-relative" style="height: 170px;">
                            @if($plan_id != 1)
                                <span class="badge bg-success-subtle text-success border border-success position-absolute top-0 end-0 m-3 px-2.5 py-1 rounded-pill small fw-bold">
                                    <i class="fa-solid fa-unlock me-1"></i>متاح
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning border border-warning position-absolute top-0 end-0 m-3 px-2.5 py-1 rounded-pill small fw-bold">
                                    <i class="fa-solid fa-lock me-1"></i>ترقية الخطة
                                </span>
                            @endif
                            <img src="{{ asset('asset/v1/users/dashboard/img/apps/clarity.png') }}" class="img-fluid object-fit-contain" alt="Microsoft Clarity" style="max-height: 100px;">
                        </div>
                        <div class="card-body p-4 d-flex flex-column flex-grow-1 justify-content-between">
                            <div>
                                <div class="d-flex align-items-center gap-2 mb-2">
                                    <h5 class="card-title fw-bold text-dark mb-0 fs-5">Microsoft Clarity</h5>
                                </div>
                                <p class="card-text text-muted small leading-relaxed mb-4">
                                    فعّل Microsoft Clarity لتحليل سلوك الزوار عبر تسجيلات الجلسات وخرائط التفاعل، مما يساعدك على تحسين تجربة المستخدم وزيادة التحويلات.
                                </p>
                            </div>
                            <div>
                                @if($plan_id != 1)
                                    <a href="{{ route('seller.app.clarity') }}" class="btn btn-seller-primary w-100 rounded-3 shadow-sm py-2.5 fw-bold d-inline-flex align-items-center justify-content-center gap-2">
                                        <i class="fa-solid fa-sliders"></i>
                                        <span>إدارة الإعدادات</span>
                                    </a>
                                @else
                                    <span class="btn btn-secondary w-100 rounded-3 py-2.5 disabled opacity-75 fw-semibold d-inline-flex align-items-center justify-content-center gap-2">
                                        <i class="fa-solid fa-lock"></i>
                                        <span>يتطلب ترقية الخطة</span>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-plum-subtle {
        background-color: rgba(164, 12, 114, 0.1);
    }

    .border-plum-subtle {
        border-color: rgba(164, 12, 114, 0.25) !important;
    }

    .text-plum {
        color: #a40c72 !important;
    }

    .btn-seller-primary {
        background: linear-gradient(135deg, #a40c72 0%, #790b54 100%) !important;
        color: #ffffff !important;
        border: none !important;
    }

    .btn-seller-primary:hover {
        background: linear-gradient(135deg, #790b54 0%, #5b073e 100%) !important;
        color: #ffffff !important;
    }

    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .avatar-md {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>