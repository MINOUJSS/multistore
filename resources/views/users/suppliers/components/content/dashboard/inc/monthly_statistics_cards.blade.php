<div class="row g-3 mt-2 mb-2">
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="stat-icon-wrapper bg-indigo-subtle text-indigo">
                        <i class="fa-solid fa-cart-arrow-down fa-lg"></i>
                    </span>
                    <span class="badge bg-indigo-subtle text-indigo px-2.5 py-1 rounded-pill fw-semibold small">الشهر</span>
                </div>
                <h6 class="text-muted fw-semibold small mb-1">طلبات هذا الشهر</h6>
                <h3 class="fw-bold mb-2 text-dark">{{ $supplier->ordersThisMonth->count() }}</h3>
                <div class="d-flex align-items-center gap-1 small">
                    @if ($isAllIncrease)
                        <span class="badge bg-emerald-subtle text-emerald border-0 rounded-pill"><i class="fa-solid fa-arrow-up me-1"></i>{{ $percentageAllChange }}%</span>
                    @else
                        <span class="badge bg-rose-subtle text-rose border-0 rounded-pill"><i class="fa-solid fa-arrow-down me-1"></i>{{ $percentageAllChange }}%</span>
                    @endif
                    <span class="text-muted small ms-1">عن الشهر الماضي</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="stat-icon-wrapper bg-emerald-subtle text-emerald">
                        <i class="fa-solid fa-cart-plus fa-lg"></i>
                    </span>
                    <span class="badge bg-emerald-subtle text-emerald px-2.5 py-1 rounded-pill fw-semibold small">الشهر</span>
                </div>
                <h6 class="text-muted fw-semibold small mb-1">المؤكدة هذا الشهر</h6>
                <h3 class="fw-bold mb-2 text-dark">{{ $supplier->ordersConfirmedThisMonth->count() }}</h3>
                <div class="d-flex align-items-center gap-1 small">
                    @if ($isDeliveredIncrease)
                        <span class="badge bg-emerald-subtle text-emerald border-0 rounded-pill"><i class="fa-solid fa-arrow-up me-1"></i>{{ $percentageDeliveredChange }}%</span>
                    @else
                        <span class="badge bg-rose-subtle text-rose border-0 rounded-pill"><i class="fa-solid fa-arrow-down me-1"></i>{{ $percentageDeliveredChange }}%</span>
                    @endif
                    <span class="text-muted small ms-1">عن الشهر الماضي</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="stat-icon-wrapper bg-rose-subtle text-rose">
                        <i class="fa-solid fa-cart-shopping fa-lg"></i>
                    </span>
                    <span class="badge bg-rose-subtle text-rose px-2.5 py-1 rounded-pill fw-semibold small">الشهر</span>
                </div>
                <h6 class="text-muted fw-semibold small mb-1">الملغاة هذا الشهر</h6>
                <h3 class="fw-bold mb-2 text-dark">{{ $supplier->ordersCanceledThisMonth->count() }}</h3>
                <div class="d-flex align-items-center gap-1 small">
                    @if ($isCanceledIncrease)
                        <span class="badge bg-rose-subtle text-rose border-0 rounded-pill"><i class="fa-solid fa-arrow-up me-1"></i>{{ $percentageCanceledChange }}%</span>
                    @else
                        <span class="badge bg-emerald-subtle text-emerald border-0 rounded-pill"><i class="fa-solid fa-arrow-down me-1"></i>{{ $percentageCanceledChange }}%</span>
                    @endif
                    <span class="text-muted small ms-1">عن الشهر الماضي</span>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="stat-icon-wrapper bg-indigo-subtle text-indigo">
                        <i class="fa-solid fa-dolly fa-lg"></i>
                    </span>
                    <span class="badge bg-indigo-subtle text-indigo px-2.5 py-1 rounded-pill fw-semibold small">الشهر</span>
                </div>
                <h6 class="text-muted fw-semibold small mb-1">المكتملة هذا الشهر</h6>
                <h3 class="fw-bold mb-2 text-dark">{{ $supplier->ordersDeliveredThisMonth->count() }}</h3>
                <div class="d-flex align-items-center gap-1 small">
                    @if ($isDeliveredIncrease)
                        <span class="badge bg-emerald-subtle text-emerald border-0 rounded-pill"><i class="fa-solid fa-arrow-up me-1"></i>{{ $percentageDeliveredChange }}%</span>
                    @else
                        <span class="badge bg-rose-subtle text-rose border-0 rounded-pill"><i class="fa-solid fa-arrow-down me-1"></i>{{ $percentageDeliveredChange }}%</span>
                    @endif
                    <span class="text-muted small ms-1">عن الشهر الماضي</span>
                </div>
            </div>
        </div>
    </div>
</div>