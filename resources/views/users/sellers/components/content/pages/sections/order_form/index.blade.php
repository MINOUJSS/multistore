<style>
/* ================= ORDER FORM MODERN STYLES ================= */
.text-plum {
    color: #a40c72 !important;
}

.bg-seller-gradient {
    background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%) !important;
}

.btn-seller-primary {
    background: linear-gradient(135deg, #5b073e 0%, #a40c72 100%);
    color: #ffffff;
    border: none;
    transition: all 0.25s ease;
}

.btn-seller-primary:hover {
    background: linear-gradient(135deg, #46052f 0%, #87095d 100%);
    color: #ffffff;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(164, 12, 114, 0.25);
}

.pulsing-dot {
    width: 9px;
    height: 9px;
    background-color: #10b981;
    border-radius: 50%;
    display: inline-block;
    box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    animation: pulse-dot 1.8s infinite;
}

@keyframes pulse-dot {
    0% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7);
    }
    70% {
        transform: scale(1);
        box-shadow: 0 0 0 7px rgba(16, 185, 129, 0);
    }
    100% {
        transform: scale(0.95);
        box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
    }
}

/* ================= STICKY PREVIEW ADJUSTMENTS ================= */
@media (min-width: 992px) {
    .sticky-preview {
        position: sticky;
        top: 20px;
        z-index: 10;
    }
}

@media (max-width: 767.98px) {
    .dashboard-hero {
        padding: 1.5rem !important;
        border-radius: 1rem !important;
    }
}
</style>

<div class="container-fluid px-3 px-md-4 py-3">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden bg-seller-gradient"
        style="border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-cart-shopping text-warning"></i>
                    <span class="fw-semibold">{{ __('تجربة الشراء وإتمام الطلبات (Checkout CRO)') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    📝 تخصيص نموذج إستمارة الطلب (Checkout Form) 🛍️
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6 text-start">
                    تخصيص الحقول والنصوص التوجيهية في إستمارة الشراء المباشر بمتجرك لتبسيط عملية الطلب على الزبائن وزيادة معدل التحويل وإتمام الصفقات.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <button id="saveOrderForm" type="submit"
                        class="btn btn-warning text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="fas fa-save"></i>
                        <span>حفظ التعديلات</span>
                    </button>
                    <a href="{{ route('seller.dashboard') }}"
                        class="btn btn-light text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
                        <i class="fas fa-arrow-right"></i>
                        <span>لوحة التحكم</span>
                    </a>
                </div>
            </div>
        </div>
        <!-- Decorative Glow Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10"
            style="width: 250px; height: 250px; top: -60px; left: -60px; pointer-events: none; filter: blur(40px);">
        </div>
        <div class="position-absolute rounded-circle bg-warning opacity-10"
            style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);">
        </div>
    </div>

    <!-- Alert Notifications -->
    @if (session()->has('message'))
        <div class="alert alert-info border-0 shadow-sm rounded-3 p-3 mb-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-circle-info fs-5"></i>
                <span class="fw-semibold">{{ session()->get('message') }}</span>
            </div>
            <button type="button" class="btn-close shadow-none" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Main Content Area: Split 2-Columns (Controls & Live Preview) -->
    <div class="row g-4">
        <!-- قسم التحكم في الحقول والإعدادات -->
        <div class="col-12 col-lg-6">
            <div class="d-flex align-items-center gap-2 mb-3 px-1">
                <i class="fa-solid fa-sliders text-plum fs-5"></i>
                <h5 class="fw-bold mb-0 text-dark">إعدادات وحقول الإستمارة</h5>
            </div>
            @include('users.sellers.components.content.pages.sections.order_form.partials.order_form_control')
        </div>
        
        <!-- قسم العرض الحي والمباشر -->
        <div class="col-12 col-lg-6">
            <div class="sticky-preview">
                <div class="d-flex align-items-center justify-content-between mb-3 px-1">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-mobile-screen text-plum fs-5"></i>
                        <h5 class="fw-bold mb-0 text-dark">المعاينة الحية الفورية</h5>
                    </div>
                    <div class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 small fw-semibold d-inline-flex align-items-center gap-1.5">
                        <span class="pulsing-dot"></span>
                        <span>مباشر (Live)</span>
                    </div>
                </div>

                <div id="livePreviewContainer">
                    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
                        <div class="card-header bg-light bg-opacity-50 py-3 px-4 border-bottom border-light-subtle d-flex align-items-center justify-content-between">
                            <span class="text-muted small fw-semibold">
                                <i class="fa-solid fa-eye me-1"></i> شكل الإستمارة كما تظهر للعميل في المتجر
                            </span>
                            <span class="badge bg-light text-secondary border small">Preview</span>
                        </div>
                        <div class="card-body p-4">
                            @include('users.sellers.components.content.pages.sections.order_form.partials.order_form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>