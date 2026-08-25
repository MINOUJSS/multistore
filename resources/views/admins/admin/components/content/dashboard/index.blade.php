<div class="container-fluid px-3 px-md-4 py-3">
    <!-- Hero Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-shield-halved text-warning"></i>
                    <span>{{ __('لوحة التحكم الرئيسية') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    مرحباً بك مجدداً، {{ Auth::guard('admin')->user()->name ?? Auth::guard('admin')->user()->type ?? 'الأدمن' }}! 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    إليك نظرة شاملة ومحدثة على إحصائيات النظام وإدارة التجار والموردين والمستخدمين.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    @if (auth()->guard('admin')->user()->type == 'admin')
                        <a href="{{ route('admin.employees.create') }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm">
                            <i class="fa-solid fa-user-plus me-1"></i> إضافة موظف
                        </a>
                    @endif
                    <a href="{{ route('admin.settings') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm">
                        <i class="fa-solid fa-gear me-1"></i> الإعدادات
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Statistics Section -->
    <div class="mb-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="fw-bold mb-0 text-dark">
                <i class="fa-solid fa-chart-pie me-2" style="color: #a40c72;"></i> إحصائيات المشتركين والفرق
            </h5>
        </div>
        @include('admins.admin.components.content.dashboard.inc.users_statistics.users')
    </div>
</div>