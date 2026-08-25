<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-bell text-warning"></i>
                    <span>{{ __('مركز الإشعارات والتنبيهات العامة') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    🔔 سجل الإشعارات والتنبيهات 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    متابعة كافة التنبيهات، الإخطارات، والتحديثات المستلمة بالنظام لحظة بلحظة.
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

    <!-- Notifications Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-bell" style="color: #a40c72;"></i>
                <span>قائمة التنبيهات المستلمة</span>
            </div>
            <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-semibold">
                إجمالي التنبيهات: {{ count($notifications) }}
            </span>
        </div>

        <div class="card-body p-3 p-md-4">
            <div class="list-group list-group-flush gap-3">
                @forelse ($notifications as $notification)
                    <div class="list-group-item p-3.5 border rounded-4 bg-light bg-opacity-50 transition-all hover-shadow">
                        <div class="d-flex align-items-start gap-3">
                            <div class="d-flex align-items-center justify-content-center rounded-circle p-3 text-white shadow-sm flex-shrink-0" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 100%); width: 44px; height: 44px;">
                                <i class="fa-solid fa-bell small"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-1 mb-2">
                                    <h6 class="fw-bold text-dark mb-0 fs-6">{{ $notification->data['title'] ?? 'تنبيه جديد' }}</h6>
                                    <span class="badge bg-white text-muted border px-2.5 py-1 rounded-pill small">
                                        <i class="fa-regular fa-clock me-1"></i>
                                        {{ $notification->created_at->diffForHumans() }}
                                    </span>
                                </div>
                                <div class="text-secondary leading-relaxed small">
                                    {!! $notification->data['message'] !!}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="fa-regular fa-bell-slash fs-1 mb-3 d-block opacity-50"></i>
                        <h6 class="fw-bold text-dark mb-1">لا يوجد إشعارات حالياً</h6>
                        <p class="small text-muted mb-0">جميع التنبيهات والإخطارات ستقوم بالظهور هنا فور ورودها.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</div>