<style>
    .dashboard-stat-card {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }
    .dashboard-stat-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.08) !important;
    }
    .stat-icon-wrapper {
        width: 46px;
        height: 46px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .bg-indigo-subtle { background-color: rgba(79, 70, 229, 0.1); color: #4f46e5; }
    .bg-emerald-subtle { background-color: rgba(16, 185, 129, 0.1); color: #10b981; }
    .bg-rose-subtle { background-color: rgba(244, 63, 94, 0.1); color: #f43f5e; }
    .bg-amber-subtle { background-color: rgba(245, 158, 11, 0.1); color: #f59e0b; }
</style>

<div class="row g-3">
    <!-- Total Subscribers -->
    <div class="col-sm-12 col-md-6 col-lg-3">
        <a href="#" class="text-decoration-none">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-icon-wrapper bg-indigo-subtle">
                            <i class="fa-solid fa-users fa-lg"></i>
                        </span>
                        <span class="badge bg-indigo-subtle px-2.5 py-1 rounded-pill fw-semibold small">الإجمالي</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">كل المشتركين</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $users->count() }}</h3>
                </div>
            </div>
        </a>
    </div>

    <!-- Suppliers -->
    <div class="col-sm-12 col-md-6 col-lg-3">
        <a href="{{ route('admin.suppliers') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-icon-wrapper bg-emerald-subtle">
                            <i class="fa-solid fa-truck-ramp-box fa-lg"></i>
                        </span>
                        <span class="badge bg-emerald-subtle px-2.5 py-1 rounded-pill fw-semibold small">موردون</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">الموردين</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $suppliers->count() }}</h3>
                </div>
            </div>
        </a>
    </div>

    <!-- Retail Sellers -->
    <div class="col-sm-12 col-md-6 col-lg-3">
        <a href="{{ route('admin.sellers') }}" class="text-decoration-none">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-icon-wrapper bg-rose-subtle">
                            <i class="fa-solid fa-store fa-lg"></i>
                        </span>
                        <span class="badge bg-rose-subtle px-2.5 py-1 rounded-pill fw-semibold small">تجارة</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">تجار التجزئة</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $sellers->count() }}</h3>
                </div>
            </div>
        </a>
    </div>

    <!-- Marketers / Affiliate Sellers -->
    <div class="col-sm-12 col-md-6 col-lg-3">
        <a href="#" class="text-decoration-none">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-icon-wrapper bg-amber-subtle">
                            <i class="fa-solid fa-bullhorn fa-lg"></i>
                        </span>
                        <span class="badge bg-amber-subtle px-2.5 py-1 rounded-pill fw-semibold small">تسويق</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">البائعين بالعمولة</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $marketers->count() }}</h3>
                </div>
            </div>
        </a>
    </div>
</div>