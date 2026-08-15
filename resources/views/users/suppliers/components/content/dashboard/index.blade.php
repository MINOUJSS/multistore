<style>
    /* ===============================
   Modern Supplier Dashboard Styles
=============================== */

    /* CSS Palette Variables */
    :root {
        --indigo-primary: #4f46e5;
        --indigo-subtle: rgba(79, 70, 229, 0.08);
        --emerald-primary: #10b981;
        --emerald-subtle: rgba(16, 185, 129, 0.08);
        --rose-primary: #f43f5e;
        --rose-subtle: rgba(244, 63, 94, 0.08);
        --amber-primary: #f59e0b;
        --amber-subtle: rgba(245, 158, 11, 0.08);
    }

    .dashboard-hero {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 40%, #334155 100%);
        border-radius: 1.25rem;
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .dashboard-hero::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -20%;
        width: 350px;
        height: 350px;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.25) 0%, rgba(255, 255, 255, 0) 70%);
        border-radius: 50%;
        pointer-events: none;
    }

    .dashboard-stat-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .dashboard-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.07) !important;
    }

    .stat-icon-wrapper {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .bg-indigo-subtle {
        background-color: var(--indigo-subtle) !important;
    }

    .text-indigo {
        color: var(--indigo-primary) !important;
    }

    .bg-emerald-subtle {
        background-color: var(--emerald-subtle) !important;
    }

    .text-emerald {
        color: var(--emerald-primary) !important;
    }

    .bg-rose-subtle {
        background-color: var(--rose-subtle) !important;
    }

    .text-rose {
        color: var(--rose-primary) !important;
    }

    .bg-amber-subtle {
        background-color: var(--amber-subtle) !important;
    }

    .text-amber {
        color: var(--amber-primary) !important;
    }

    .rank-badge {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 700;
    }

    .rank-1 {
        background-color: #fef3c7;
        color: #d97706;
    }

    .rank-2 {
        background-color: #f1f5f9;
        color: #64748b;
    }

    .rank-3 {
        background-color: #ffedd5;
        color: #c2410c;
    }

    canvas {
        max-width: 100% !important;
        height: auto !important;
    }
</style>

<div class="container-fluid px-3 py-2">

    <!-- Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-truck-ramp-box text-warning"></i>
                    <span>لوحة تحكم المورد</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    مرحباً بك مجدداً، {{ auth()->user()->name }}! 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed">
                    إليك نظرة شاملة ومحدثة على أداء حساب المورد، مبيعات الجملة، وحالة الطلبات.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('supplier.products') }}"
                        class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm">
                        <i class="fa-solid fa-plus me-1"></i> إضافة منتج بالجملة
                    </a>
                    <a href="{{ route('supplier.settings') }}"
                        class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm">
                        <i class="fa-solid fa-gear me-1"></i> الإعدادات
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Dedicated Call Center & Technical Support Hub for Supplier -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden"
        style="background: linear-gradient(135deg, #ffffff 0%, #f4f6ff 100%); border-right: 5px solid #4f46e5 !important;">
        <div class="card-header bg-white border-0 py-3.5 px-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <div class="stat-icon-wrapper text-white"
                    style="background-color: #4f46e5; width: 44px; height: 44px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-headset fs-5"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-1 text-dark">مركز الكول سنتر والدعم الفني المباشر للموردين</h5>
                    <p class="text-muted small mb-0">نحن هنا لمساعدتك في توريد المنتجات، إدارة مخزونك، وحل أي استفسار
                        تقني أو مالي بكل احترافية.</p>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span
                    class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-3 py-2 rounded-pill fw-semibold small d-none d-sm-inline-flex align-items-center gap-1">
                    <span class="spinner-grow spinner-grow-sm me-1" role="status"
                        style="width: 8px; height: 8px;"></span>
                    الكول سنتر متاح الآن (24/7)
                </span>
                <button class="btn btn-sm btn-light border-0 shadow-sm rounded-circle p-2" type="button"
                    data-bs-toggle="collapse" data-bs-target="#supplierSupportPanel" aria-expanded="true">
                    <i class="fas fa-chevron-down"></i>
                </button>
            </div>
        </div>

        <div class="collapse show" id="supplierSupportPanel">
            <div class="card-body p-4 pt-1">
                <div class="row g-3">
                    <!-- 1. Direct Call Center Line -->
                    <div class="col-lg-3 col-md-6">
                        <div
                            class="border border-light-subtle rounded-3 p-3 h-100 bg-white shadow-xs text-center position-relative transition-all hover-lift">
                            <div class="stat-icon-wrapper bg-primary bg-opacity-10 text-primary mx-auto mb-2"
                                style="width: 46px; height: 46px; border-radius: 12px;">
                                <i class="fa-solid fa-phone-volume fs-5"></i>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark">خط الكول سنتر المباشر</h6>
                            <small class="text-muted d-block mb-2">تحدث فوراً مع مشرف الدعم</small>
                            <div class="fw-bold text-dark fs-6 mb-3 dir-ltr" style="direction: ltr !important;">0672 81
                                67 09</div>
                            <a href="tel:0672816709"
                                class="btn btn-primary btn-sm w-100 rounded-2 fw-semibold shadow-sm">
                                <i class="fa-solid fa-phone me-1"></i> اتصال مباشر
                            </a>
                        </div>
                    </div>

                    <!-- 2. WhatsApp Instant Support -->
                    <div class="col-lg-3 col-md-6">
                        <div
                            class="border border-light-subtle rounded-3 p-3 h-100 bg-white shadow-xs text-center position-relative transition-all hover-lift">
                            <div class="stat-icon-wrapper bg-success bg-opacity-10 text-success mx-auto mb-2"
                                style="width: 46px; height: 46px; border-radius: 12px;">
                                <i class="fa-brands fa-whatsapp fs-4"></i>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark">محادثة الواتساب السريعة</h6>
                            <small class="text-muted d-block mb-2">استجابة مخصصة للموردين</small>
                            <div class="fw-bold text-dark fs-6 mb-3 dir-ltr" style="direction: ltr !important;">+213 672
                                81 67 09</div>
                            <a href="https://wa.me/213672816709?text=مرحباً%20فريق%20الدعم،%20أنا%20مورد%20في%20منصة%20Dzora%20وأحتاج%20إلى%20مساعدة"
                                target="_blank" class="btn btn-success btn-sm w-100 rounded-2 fw-semibold shadow-sm">
                                <i class="fa-brands fa-whatsapp me-1"></i> مراسلة واتساب
                            </a>
                        </div>
                    </div>

                    <!-- 3. Telegram Group Subscription Card -->
                    <div class="col-lg-3 col-md-6">
                        <div class="border border-light-subtle rounded-3 p-3 h-100 bg-white shadow-xs text-center position-relative transition-all hover-lift"
                            style="border-top: 3px solid #0088cc !important;">
                            <div class="stat-icon-wrapper text-white mx-auto mb-2"
                                style="background-color: #0088cc; width: 46px; height: 46px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                                <i class="fa-brands fa-telegram fs-4"></i>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark">مجتمع الموردين والتجار</h6>
                            <small class="text-muted d-block mb-2">انضم لمجموعتنا على التيليغرام</small>
                            <div class="small text-info fw-semibold mb-3">
                                <i class="fa-solid fa-users me-1"></i> نصائح وتحديثات الجملة
                            </div>
                            <a href="https://t.me/+5Kees9W3WgJlZjE0" target="_blank"
                                class="btn text-white btn-sm w-100 rounded-2 fw-semibold shadow-sm"
                                style="background-color: #0088cc;">
                                <i class="fa-brands fa-telegram me-1"></i> الانضمام للمجموعة
                            </a>
                        </div>
                    </div>

                    <!-- 4. FAQ & Knowledge Base -->
                    <div class="col-lg-3 col-md-6">
                        <div
                            class="border border-light-subtle rounded-3 p-3 h-100 bg-white shadow-xs text-center position-relative transition-all hover-lift">
                            <div class="stat-icon-wrapper bg-warning bg-opacity-10 text-warning mx-auto mb-2"
                                style="width: 46px; height: 46px; border-radius: 12px;">
                                <i class="fa-solid fa-circle-question fs-5"></i>
                            </div>
                            <h6 class="fw-bold mb-1 text-dark">دليل وإرشادات الموردين</h6>
                            <small class="text-muted d-block mb-2">شروحات الجملة وتوزيع المنتجات</small>
                            <div class="small text-muted mb-3">حلول سريعة وتوعية الموردين</div>
                            <a href="{{ route('site.index') }}#faq" target="_blank"
                                class="btn btn-outline-dark btn-sm w-100 rounded-2 fw-semibold">
                                <i class="fa-solid fa-book-open me-1"></i> دليل الاستخدام
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-3 alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-circle-check me-2"></i> {{ session()->get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-warning border-0 shadow-sm rounded-3 alert-dismissible fade show" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i> {{ session()->get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Start Dashboard Statistics & Charts -->

    <!-- Daily Statistics Cards -->
    @include('users.suppliers.components.content.dashboard.inc.dayly_statistics_cards')

    <!-- Orders Charts Row -->
    <div class="row g-3 mt-1 mb-3">
        <div class="col-md-8" dir="rtl">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">تحليل الطلبات</h5>
                            <p class="text-muted small mb-0">مراقبة نمو طلبات الجملة حسب الفترة الزمانية</p>
                        </div>
                        <select id="timeRange"
                            class="form-select form-select-sm border-0 bg-light rounded-3 px-3 py-2 font-semibold"
                            style="width: auto;">
                            <option value="daily">يومي</option>
                            <option value="weekly">أسبوعي</option>
                            <option value="monthly">شهري</option>
                        </select>
                    </div>
                    <div style="position: relative; width: 100%; min-height: 260px;">
                        <canvas id="ordersChart" class="w-full h-64"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4" dir="rtl">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark mb-1 text-center">توزيع حالة الطلبات</h5>
                        <p class="text-muted small mb-0 text-center">نسب الحالات المختلفة لطلبات المورد</p>
                    </div>
                    <div style="position: relative; width: 100%; min-height: 260px;"
                        class="d-flex align-items-center justify-content-center">
                        <canvas id="statusChart" class="w-full h-64"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Weekly Statistics Cards -->
    @include('users.suppliers.components.content.dashboard.inc.weekly_statistics_cards')

    <!-- Visitors & Top Products Row -->
    <div class="row g-3 mt-1 mb-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <!-- Top Ordered Products -->
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold text-dark mb-0">المنتجات الأكثر طلباً</h6>
                        <span class="stat-icon-wrapper bg-amber-subtle text-amber" style="width: 32px; height: 32px;">
                            <i class="fa-solid fa-crown small"></i>
                        </span>
                    </div>

                    <div class="mb-4">
                        @if ($topProducts->count() > 0)
                            @foreach ($topProducts as $index => $product)
                                <div
                                    class="d-flex align-items-center justify-content-between py-2 border-bottom border-light">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rank-badge rank-{{ $index + 1 }}">{{ $index + 1 }}</span>
                                        <img src="{{ asset($product->image) }}"
                                            class="rounded-3 border object-fit-cover" width="38" height="38"
                                            alt="{{ $product->name }}">
                                        <span class="fw-semibold text-dark small text-truncate"
                                            style="max-width: 140px;">{{ $product->name }}</span>
                                    </div>
                                    <span
                                        class="badge bg-indigo-subtle text-indigo rounded-pill px-2 py-1 fw-bold small">{{ $product->orders_count }}
                                        طلب</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-muted py-3 small">لا توجد منتجات مطلوبة حالياً</div>
                        @endif
                    </div>

                    <!-- Top Viewed Products -->
                    <div class="d-flex justify-content-between align-items-center mb-3 pt-2">
                        <h6 class="fw-bold text-dark mb-0">المنتجات الأكثر مشاهدة</h6>
                        <span class="stat-icon-wrapper bg-indigo-subtle text-indigo"
                            style="width: 32px; height: 32px;">
                            <i class="fa-solid fa-eye small"></i>
                        </span>
                    </div>

                    <div>
                        @if ($topViewed->count() > 0)
                            @foreach ($topViewed as $index => $product)
                                <div
                                    class="d-flex align-items-center justify-content-between py-2 border-bottom border-light">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="rank-badge rank-{{ $index + 1 }}">{{ $index + 1 }}</span>
                                        <img src="{{ asset($product->image) }}"
                                            class="rounded-3 border object-fit-cover" width="38" height="38"
                                            alt="{{ $product->name }}">
                                        <span class="fw-semibold text-dark small text-truncate"
                                            style="max-width: 140px;">{{ $product->name }}</span>
                                    </div>
                                    <span
                                        class="badge bg-emerald-subtle text-emerald rounded-pill px-2 py-1 fw-bold small">{{ $product->views_count }}
                                        مشاهدة</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center text-muted py-3 small">لا توجد مشاهدات حالياً</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold text-dark mb-1">تحليل الزوار</h5>
                            <p class="text-muted small mb-0">متابعة إحصائيات وعدد زوار متجر المورد</p>
                        </div>
                        <select id="visitorsTimeRange"
                            class="form-select form-select-sm border-0 bg-light rounded-3 px-3 py-2 font-semibold"
                            style="width: auto;">
                            <option value="daily">يومي</option>
                            <option value="weekly">أسبوعي</option>
                            <option value="monthly">شهري</option>
                        </select>
                    </div>
                    <div style="position: relative; width: 100%; min-height: 260px;">
                        <canvas id="visitorsChart" class="w-full h-64"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Statistics Cards -->
    @include('users.suppliers.components.content.dashboard.inc.monthly_statistics_cards')

</div>

<!-- SweetAlerts Notification Redirect -->
@if (session('redicect_subscriber'))
    <script>
        Swal.fire({
            title: 'نجاح!',
            text: "{{ session('redicect_subscriber') }}",
            icon: 'success',
            confirmButtonText: 'حسنًا'
        });
    </script>
@endif
