<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-id-card text-warning"></i>
                    <span>{{ __('دليل سجلات الاشتراكات') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    👥 دليل اشتراكات المشتركين 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    استعراض وإدارة طلبات وسجلات اشتراكات الموردين، البائعين، والشركاء المسجلين بالمنصة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm text-nowrap">
                        <i class="fa-solid fa-house me-1"></i> الرئيسية
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Category Cards Row -->
    <div class="row g-4">
        <!-- Suppliers Subscribes Card -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4 text-center hover-lift position-relative overflow-hidden">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 mx-auto shadow-sm" style="width: 70px; height: 70px; background: linear-gradient(135deg, #a40c72 0%, #be0681 100%); color: #ffffff;">
                    <i class="fa-solid fa-truck-field fs-3"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">الموردين</h4>
                <p class="text-muted small mb-4">عرض وتدقيق كافة طلبات وسجلات اشتراك الموردين بالمنصة.</p>
                <div class="mt-auto">
                    <a href="{{ route('admin.payments.suppliers.subscribes_payments') }}" class="btn text-white w-100 rounded-3 py-2.5 fw-bold shadow-sm" style="background-color: #a40c72;">
                        <i class="fa-solid fa-arrow-left me-1"></i> عرض الطلبات
                    </a>
                </div>
            </div>
        </div>

        <!-- Sellers Subscribes Card -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4 text-center hover-lift position-relative overflow-hidden">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 mx-auto shadow-sm" style="width: 70px; height: 70px; background: linear-gradient(135deg, #198754 0%, #20c997 100%); color: #ffffff;">
                    <i class="fa-solid fa-store fs-3"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">البائعين</h4>
                <p class="text-muted small mb-4">عرض وتدقيق كافة طلبات وسجلات اشتراك البائعين بالمنصة.</p>
                <div class="mt-auto">
                    <a href="{{ route('admin.payments.sellers.subscribes_payments') }}" class="btn btn-success w-100 rounded-3 py-2.5 fw-bold shadow-sm">
                        <i class="fa-solid fa-arrow-left me-1"></i> عرض الطلبات
                    </a>
                </div>
            </div>
        </div>

        <!-- Partners / Affiliates Subscribes Card -->
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4 text-center hover-lift position-relative overflow-hidden">
                <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3 mx-auto shadow-sm" style="width: 70px; height: 70px; background: linear-gradient(135deg, #fd7e14 0%, #ffc107 100%); color: #ffffff;">
                    <i class="fa-solid fa-handshake fs-3"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">الشركاء</h4>
                <p class="text-muted small mb-4">عرض وتدقيق كافة طلبات وسجلات اشتراك الشركاء والمسوقين.</p>
                <div class="mt-auto">
                    <a href="{{-- route('admin.subscribes.affiliates.index') --}}" class="btn btn-warning text-dark w-100 rounded-3 py-2.5 fw-bold shadow-sm">
                        <i class="fa-solid fa-arrow-left me-1"></i> عرض الطلبات
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
