@php
    $sellerTenantId = auth()->user()->tenant_id ?? null;
    $digitalPaymentStatus = get_seller_digital_payment_status($sellerTenantId);

    // سكريبت التحقق من وجود حساب شارجيلي في قاعدة البيانات (chargily_setting_for_tenants)
    $sellerUserId = auth()->id();
    $chargilySetting = \App\Models\ChargilySettingForTenants::where('user_id', $sellerUserId)->first();
    $hasChargilyDbAccount = !empty($chargilySetting?->public_key) && !empty($chargilySetting?->secret_key);

    // تحديث حالة بيانات الربط من قاعدة البيانات مباشرة
    $digitalPaymentStatus['chargily']['credentials'] = $hasChargilyDbAccount;
    $digitalPaymentStatus['chargily']['mode'] = $chargilySetting?->mode ?? null;

    // سكريبت للتحكم في شارة وجاهزية شارجيلي (مطابق لشروط صفحة تفاصيل المنتج product-details.blade.php)
    $isChargilyReady = $digitalPaymentStatus['is_approved']
        && $digitalPaymentStatus['chargily']['auth']
        && $digitalPaymentStatus['chargily']['credentials']
        && $digitalPaymentStatus['chargily']['active'];
    $digitalPaymentStatus['chargily']['ready'] = $isChargilyReady;

    // سكريبت للتحكم في شارة وجاهزية التحويل البنكي (مطابق لشروط صفحة تفاصيل المنتج product-details.blade.php)
    $isBankReady = $digitalPaymentStatus['is_approved']
        && $digitalPaymentStatus['bank']['auth']
        && $digitalPaymentStatus['bank']['credentials']
        && $digitalPaymentStatus['bank']['active'];
    $digitalPaymentStatus['bank']['ready'] = $isBankReady;

    // تحديث شرط ظهور الصندوق بناءً على الجاهزية الدقيقة
    $digitalPaymentStatus['should_alert'] = $digitalPaymentStatus['has_digital_products'] && !($isChargilyReady || $isBankReady);
@endphp

@if ($digitalPaymentStatus['should_alert'])
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden position-relative"
        style="background: linear-gradient(135deg, #fffdf8 0%, #fff7eb 100%); border-right: 5px solid #d97706 !important;">
        
        <div class="card-body p-4 position-relative z-1">
            <!-- Header Section -->
            <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-3 border-bottom pb-3">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-3 shadow-sm text-white"
                        style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); width: 48px; height: 48px; min-width: 48px;">
                        <i class="fa-solid fa-triangle-exclamation fs-4"></i>
                    </div>
                    <div>
                        <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                            <span class="badge bg-warning bg-opacity-15 text-dark border border-warning border-opacity-30 rounded-pill px-2.5 py-1 small fw-bold">
                                <i class="fa-solid fa-bell me-1 text-warning"></i> إجراء إلزامي مطلوب
                            </span>
                            <span class="badge bg-dark bg-opacity-10 text-secondary rounded-pill px-2 py-0.5 small">
                                لديك {{ $digitalPaymentStatus['digital_products_count'] }} منتج رقمي بانتظار التفعيل
                            </span>
                        </div>
                        <h5 class="fw-bold text-dark mb-0">
                            فعّل وسائل الدفع الإلكترونية لتتمكن من بيع منتجاتك الرقمية! 🚀
                        </h5>
                    </div>
                </div>

                <!-- Quick Action Buttons -->
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('seller.profile') }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 shadow-sm d-inline-flex align-items-center gap-1.5" style="background-color: #f59e0b; border: none;">
                        <i class="fa-solid fa-user-gear"></i>
                        <span>الملف الشخصي</span>
                    </a>
                    <a href="{{ route('seller.settings') }}" class="btn btn-outline-dark fw-bold px-3 py-2 rounded-3 shadow-sm d-inline-flex align-items-center gap-1.5">
                        <i class="fa-solid fa-sliders"></i>
                        <span>إعدادات المتجر</span>
                    </a>
                    @if (Route::has('seller.services.index'))
                        <a href="{{ route('seller.services.index') }}" class="btn btn-light border text-secondary fw-semibold px-2.5 py-2 rounded-3 shadow-sm d-inline-flex align-items-center gap-1" title="ترقية الباقة أو شراء رصيد خدمات">
                            <i class="fa-solid fa-gem text-plum"></i>
                            <span class="d-none d-lg-inline">الباقات والخدمات</span>
                        </a>
                    @endif
                </div>
            </div>

            <!-- Explanatory Text -->
            <p class="text-dark small mb-3 leading-relaxed">
                لديك منتجات رقمية معروضة في متجرك، ولكن <strong>زبائنك لن يتمكنوا من إتمام عملية الشراء</strong> حالياً لأن وسائل الدفع غير مفعلة. تقتضي سياسة بيع المنتجات الرقمية الدفع المسبق المؤكد، ويجب استيفاء الشروط التالية لتفعيل عملية البيع:
            </p>

            <!-- 3 Required Conditions Grid -->
            <div class="row g-3">
                <!-- Condition 1: Account Verification Status -->
                <div class="col-md-4">
                    <div class="p-3 bg-white rounded-3 border h-100 shadow-2xs d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold text-dark small">
                                    @if ($digitalPaymentStatus['is_approved'])
                                        <i class="fa-solid fa-circle-check text-success me-1"></i>
                                    @else
                                        <i class="fa-solid fa-circle-xmark text-danger me-1"></i>
                                    @endif
                                    1. توثيق الحساب (شرط أساسي)
                                </span>
                                @if ($digitalPaymentStatus['is_approved'])
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5 small">
                                        موثق <i class="fa-solid fa-check ms-1"></i>
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill px-2 py-0.5 small">
                                        غير موثق <i class="fa-solid fa-xmark ms-1"></i>
                                    </span>
                                @endif
                            </div>
                            <p class="text-muted small mb-3" style="font-size: 0.82rem; line-height: 1.5;">
                                @if ($digitalPaymentStatus['is_approved'])
                                    تم اعتماد وتوثيق متجرك في المنصة بنجاح، ويمكنك استقبال المدفوعات فور اكتمال أي وسيلة دفع أدناه.
                                @else
                                    حساب متجرك غير موثق حالياً أو بانتظار المراجعة؛ يلزم اعتماد الحساب أولاً لتتمكن من استقبال المدفوعات الرقمية.
                                @endif
                            </p>
                        </div>
                        <div class="pt-2 border-top">
                            <span class="text-secondary small d-inline-flex align-items-center gap-1" style="font-size: 0.78rem;">
                                <i class="fa-solid fa-shield-halved text-warning"></i>
                                شرط إلزامي مشترك لكافة بوابات الدفع
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Condition 2: Chargily Payment Conditions -->
                <div class="col-md-4">
                    <div class="p-3 bg-white rounded-3 border h-100 shadow-2xs d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold text-dark small">
                                    <i class="fa-solid fa-credit-card text-info me-1"></i> 2. بوابة شارجيلي (Chargily)
                                </span>
                                <!-- سكريبت التحكم في Badge شارجيلي (السطور 106 إلى 110) -->
                                @if ($digitalPaymentStatus['chargily']['ready'])
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5 small">
                                        جاهزة <i class="fa-solid fa-check ms-1"></i>
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-0.5 small">
                                        غير مكتملة <i class="fa-solid fa-clock ms-1"></i>
                                    </span>
                                @endif
                            </div>

                            <ul class="list-unstyled d-flex flex-column gap-2 mb-2" style="font-size: 0.81rem;">
                                <!-- Sub-condition A: Authorization / Plan -->
                                <li class="d-flex align-items-center justify-content-between p-1.5 rounded-2 bg-light border border-light-subtle">
                                    <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                        @if ($digitalPaymentStatus['chargily']['auth'])
                                            <i class="fa-solid fa-circle-check text-success"></i>
                                        @else
                                            <i class="fa-solid fa-circle-xmark text-danger"></i>
                                        @endif
                                        <span>صلاحية البوابة (باقة / رصيد)</span>
                                    </span>
                                    @if ($digitalPaymentStatus['chargily']['auth'])
                                        <span class="badge bg-success-subtle text-success px-1.5 py-0.5 small">متاحة</span>
                                    @else
                                        <a href="{{ route('seller.services.index') }}" class="badge bg-danger-subtle text-danger text-decoration-none px-1.5 py-0.5 small">
                                            ترقية / شحن <i class="fa-solid fa-arrow-left ms-1"></i>
                                        </a>
                                    @endif
                                </li>

                                <!-- Sub-condition B: API Credentials (chargily_setting_for_tenants) -->
                                <li class="d-flex align-items-center justify-content-between p-1.5 rounded-2 bg-light border border-light-subtle">
                                    <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                        @if ($digitalPaymentStatus['chargily']['credentials'])
                                            <i class="fa-solid fa-circle-check text-success"></i>
                                        @else
                                            <i class="fa-solid fa-circle-xmark text-danger"></i>
                                        @endif
                                        <span>مفاتيح الربط (API Keys)</span>
                                    </span>
                                    @if ($digitalPaymentStatus['chargily']['credentials'])
                                        <span class="badge bg-success-subtle text-success px-1.5 py-0.5 small d-inline-flex align-items-center gap-1">
                                            <span>مضافة</span>
                                            @if (!empty($digitalPaymentStatus['chargily']['mode']))
                                                <span class="text-uppercase fw-normal opacity-75">({{ $digitalPaymentStatus['chargily']['mode'] }})</span>
                                            @endif
                                        </span>
                                    @else
                                        <a href="{{ route('seller.profile') }}" class="badge bg-danger-subtle text-danger text-decoration-none px-1.5 py-0.5 small">
                                            إضافة الآن <i class="fa-solid fa-arrow-left ms-1"></i>
                                        </a>
                                    @endif
                                </li>

                                <!-- Sub-condition C: Store Settings Active -->
                                <li class="d-flex align-items-center justify-content-between p-1.5 rounded-2 bg-light border border-light-subtle">
                                    <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                        @if ($digitalPaymentStatus['chargily']['active'])
                                            <i class="fa-solid fa-circle-check text-success"></i>
                                        @else
                                            <i class="fa-solid fa-circle-xmark text-danger"></i>
                                        @endif
                                        <span>تفعيل الخيار في المتجر</span>
                                    </span>
                                    @if ($digitalPaymentStatus['chargily']['active'])
                                        <span class="badge bg-success-subtle text-success px-1.5 py-0.5 small">مفعل</span>
                                    @else
                                        <a href="{{ route('seller.settings') }}" class="badge bg-warning-subtle text-warning-emphasis text-decoration-none px-1.5 py-0.5 small">
                                            تفعيل الآن <i class="fa-solid fa-arrow-left ms-1"></i>
                                        </a>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Condition 3: Bank Transfer Conditions -->
                <div class="col-md-4">
                    <div class="p-3 bg-white rounded-3 border h-100 shadow-2xs d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="fw-bold text-dark small">
                                    <i class="fa-solid fa-building-columns text-primary me-1"></i> 3. التحويل البنكي (CCP / بريدي موب)
                                </span>
                                <!-- سكريبت للتحكم في Badge التحويل البنكي (السطور 183 إلى 187) -->
                                @if ($digitalPaymentStatus['bank']['ready'])
                                    <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5 small">
                                        جاهز <i class="fa-solid fa-check ms-1"></i>
                                    </span>
                                @else
                                    <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle rounded-pill px-2 py-0.5 small">
                                        غير مكتمل <i class="fa-solid fa-clock ms-1"></i>
                                    </span>
                                @endif
                            </div>

                            <ul class="list-unstyled d-flex flex-column gap-2 mb-2" style="font-size: 0.81rem;">
                                <!-- Sub-condition A: Authorization / Plan -->
                                <li class="d-flex align-items-center justify-content-between p-1.5 rounded-2 bg-light border border-light-subtle">
                                    <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                        @if ($digitalPaymentStatus['bank']['auth'])
                                            <i class="fa-solid fa-circle-check text-success"></i>
                                        @else
                                            <i class="fa-solid fa-circle-xmark text-danger"></i>
                                        @endif
                                        <span>صلاحية التحويل (باقة / رصيد)</span>
                                    </span>
                                    @if ($digitalPaymentStatus['bank']['auth'])
                                        <span class="badge bg-success-subtle text-success px-1.5 py-0.5 small">متاحة</span>
                                    @else
                                        <a href="{{ route('seller.services.index') }}" class="badge bg-danger-subtle text-danger text-decoration-none px-1.5 py-0.5 small">
                                            ترقية / شحن <i class="fa-solid fa-arrow-left ms-1"></i>
                                        </a>
                                    @endif
                                </li>

                                <!-- Sub-condition B: Bank Account Info -->
                                <li class="d-flex align-items-center justify-content-between p-1.5 rounded-2 bg-light border border-light-subtle">
                                    <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                        @if ($digitalPaymentStatus['bank']['credentials'])
                                            <i class="fa-solid fa-circle-check text-success"></i>
                                        @else
                                            <i class="fa-solid fa-circle-xmark text-danger"></i>
                                        @endif
                                        <span>بيانات الحساب البنكي / CCP</span>
                                    </span>
                                    @if ($digitalPaymentStatus['bank']['credentials'])
                                        <span class="badge bg-success-subtle text-success px-1.5 py-0.5 small">مضافة</span>
                                    @else
                                        <a href="{{ route('seller.profile') }}" class="badge bg-danger-subtle text-danger text-decoration-none px-1.5 py-0.5 small">
                                            إضافة الآن <i class="fa-solid fa-arrow-left ms-1"></i>
                                        </a>
                                    @endif
                                </li>

                                <!-- Sub-condition C: Store Settings Active -->
                                <li class="d-flex align-items-center justify-content-between p-1.5 rounded-2 bg-light border border-light-subtle">
                                    <span class="d-inline-flex align-items-center gap-1 text-secondary">
                                        @if ($digitalPaymentStatus['bank']['active'])
                                            <i class="fa-solid fa-circle-check text-success"></i>
                                        @else
                                            <i class="fa-solid fa-circle-xmark text-danger"></i>
                                        @endif
                                        <span>تفعيل الخيار في المتجر</span>
                                    </span>
                                    @if ($digitalPaymentStatus['bank']['active'])
                                        <span class="badge bg-success-subtle text-success px-1.5 py-0.5 small">مفعل</span>
                                    @else
                                        <a href="{{ route('seller.settings') }}" class="badge bg-warning-subtle text-warning-emphasis text-decoration-none px-1.5 py-0.5 small">
                                            تفعيل الآن <i class="fa-solid fa-arrow-left ms-1"></i>
                                        </a>
                                    @endif
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="mt-3 pt-2 text-start d-flex align-items-center gap-2 text-muted small" style="font-size: 0.8rem;">
                <i class="fa-solid fa-lightbulb text-warning"></i>
                <span>يكفيك تفعيل <strong>وسيلة دفع واحدة على الأقل</strong> (شارجيلي أو التحويل البنكي) لإتاحة الشراء الفوري لمنتجاتك الرقمية واختفاء هذا التنبيه تلقائياً.</span>
            </div>
        </div>

        <!-- Background Decorative Glow -->
        <div class="position-absolute rounded-circle bg-warning opacity-10"
            style="width: 200px; height: 200px; bottom: -50px; left: -50px; pointer-events: none; filter: blur(35px);">
        </div>
    </div>
@endif
