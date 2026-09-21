<div class="row g-3">
    <!-- All Active Subscribers -->
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
            <div class="card-body p-3.5">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="stat-icon-wrapper bg-indigo-subtle">
                        <i class="fa-solid fa-user-check fa-lg"></i>
                    </span>
                    <span class="badge {{ $activityStats['all']['percentage'] >= 70 ? 'bg-success' : ($activityStats['all']['percentage'] >= 40 ? 'bg-warning text-dark' : 'bg-secondary') }} px-2.5 py-1 rounded-pill fw-bold small">
                        {{ $activityStats['all']['percentage'] }}% نشط
                    </span>
                </div>
                <h6 class="text-muted fw-semibold small mb-1">إجمالي المشتركين النشطين</h6>
                <div class="d-flex align-items-baseline gap-2 mb-2">
                    <h3 class="fw-bold mb-0 text-dark">{{ $activityStats['all']['active'] }}</h3>
                    <span class="text-muted small">من أصل {{ $activityStats['all']['total'] }}</span>
                </div>
                <!-- Progress Bar -->
                <div class="progress rounded-pill mb-2" style="height: 6px; background-color: rgba(79, 70, 229, 0.1);">
                    <div class="progress-bar rounded-pill" role="progressbar" 
                         style="width: {{ $activityStats['all']['percentage'] }}%; background-color: #4f46e5;" 
                         aria-valuenow="{{ $activityStats['all']['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex align-items-center justify-content-between text-muted" style="font-size: 0.75rem;">
                    <span><i class="fa-regular fa-clock me-1"></i>آخر {{ $activityStats['period_days'] }} يوماً</span>
                    <span>غير نشط: <strong>{{ $activityStats['all']['inactive'] }}</strong></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Suppliers -->
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
            <div class="card-body p-3.5">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="stat-icon-wrapper bg-emerald-subtle">
                        <i class="fa-solid fa-truck-fast fa-lg"></i>
                    </span>
                    <span class="badge {{ $activityStats['suppliers']['percentage'] >= 70 ? 'bg-success' : ($activityStats['suppliers']['percentage'] >= 40 ? 'bg-warning text-dark' : 'bg-secondary') }} px-2.5 py-1 rounded-pill fw-bold small">
                        {{ $activityStats['suppliers']['percentage'] }}% نشط
                    </span>
                </div>
                <h6 class="text-muted fw-semibold small mb-1">الموردين النشطين</h6>
                <div class="d-flex align-items-baseline gap-2 mb-2">
                    <h3 class="fw-bold mb-0 text-dark">{{ $activityStats['suppliers']['active'] }}</h3>
                    <span class="text-muted small">من أصل {{ $activityStats['suppliers']['total'] }}</span>
                </div>
                <!-- Progress Bar -->
                <div class="progress rounded-pill mb-2" style="height: 6px; background-color: rgba(16, 185, 129, 0.1);">
                    <div class="progress-bar rounded-pill" role="progressbar" 
                         style="width: {{ $activityStats['suppliers']['percentage'] }}%; background-color: #10b981;" 
                         aria-valuenow="{{ $activityStats['suppliers']['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex align-items-center justify-content-between text-muted" style="font-size: 0.75rem;">
                    <span><i class="fa-regular fa-clock me-1"></i>آخر {{ $activityStats['period_days'] }} يوماً</span>
                    <span>غير نشط: <strong>{{ $activityStats['suppliers']['inactive'] }}</strong></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Retail Sellers -->
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
            <div class="card-body p-3.5">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="stat-icon-wrapper bg-rose-subtle">
                        <i class="fa-solid fa-shop-lock fa-lg"></i>
                    </span>
                    <span class="badge {{ $activityStats['sellers']['percentage'] >= 70 ? 'bg-success' : ($activityStats['sellers']['percentage'] >= 40 ? 'bg-warning text-dark' : 'bg-secondary') }} px-2.5 py-1 rounded-pill fw-bold small">
                        {{ $activityStats['sellers']['percentage'] }}% نشط
                    </span>
                </div>
                <h6 class="text-muted fw-semibold small mb-1">تجار التجزئة النشطين</h6>
                <div class="d-flex align-items-baseline gap-2 mb-2">
                    <h3 class="fw-bold mb-0 text-dark">{{ $activityStats['sellers']['active'] }}</h3>
                    <span class="text-muted small">من أصل {{ $activityStats['sellers']['total'] }}</span>
                </div>
                <!-- Progress Bar -->
                <div class="progress rounded-pill mb-2" style="height: 6px; background-color: rgba(244, 63, 94, 0.1);">
                    <div class="progress-bar rounded-pill" role="progressbar" 
                         style="width: {{ $activityStats['sellers']['percentage'] }}%; background-color: #f43f5e;" 
                         aria-valuenow="{{ $activityStats['sellers']['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex align-items-center justify-content-between text-muted" style="font-size: 0.75rem;">
                    <span><i class="fa-regular fa-clock me-1"></i>آخر {{ $activityStats['period_days'] }} يوماً</span>
                    <span>غير نشط: <strong>{{ $activityStats['sellers']['inactive'] }}</strong></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Marketers -->
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
            <div class="card-body p-3.5">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="stat-icon-wrapper bg-amber-subtle">
                        <i class="fa-solid fa-square-poll-vertical fa-lg"></i>
                    </span>
                    <span class="badge {{ $activityStats['marketers']['percentage'] >= 70 ? 'bg-success' : ($activityStats['marketers']['percentage'] >= 40 ? 'bg-warning text-dark' : 'bg-secondary') }} px-2.5 py-1 rounded-pill fw-bold small">
                        {{ $activityStats['marketers']['percentage'] }}% نشط
                    </span>
                </div>
                <h6 class="text-muted fw-semibold small mb-1">المسوقين النشطين</h6>
                <div class="d-flex align-items-baseline gap-2 mb-2">
                    <h3 class="fw-bold mb-0 text-dark">{{ $activityStats['marketers']['active'] }}</h3>
                    <span class="text-muted small">من أصل {{ $activityStats['marketers']['total'] }}</span>
                </div>
                <!-- Progress Bar -->
                <div class="progress rounded-pill mb-2" style="height: 6px; background-color: rgba(245, 158, 11, 0.1);">
                    <div class="progress-bar rounded-pill" role="progressbar" 
                         style="width: {{ $activityStats['marketers']['percentage'] }}%; background-color: #f59e0b;" 
                         aria-valuenow="{{ $activityStats['marketers']['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="d-flex align-items-center justify-content-between text-muted" style="font-size: 0.75rem;">
                    <span><i class="fa-regular fa-clock me-1"></i>آخر {{ $activityStats['period_days'] }} يوماً</span>
                    <span>غير نشط: <strong>{{ $activityStats['marketers']['inactive'] }}</strong></span>
                </div>
            </div>
        </div>
    </div>
</div>
