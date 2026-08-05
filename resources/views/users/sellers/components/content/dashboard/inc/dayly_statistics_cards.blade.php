<div class="row g-3">
    <div class="col-sm-12 col-md-6 col-lg-3">
        <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
            <div class="card-body p-3">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <span class="stat-icon-wrapper bg-indigo-subtle text-indigo">
                        <i class="fa-solid fa-cart-arrow-down fa-lg"></i>
                    </span>
                    <span class="badge bg-indigo-subtle text-indigo px-2.5 py-1 rounded-pill fw-semibold small">اليوم</span>
                </div>
                <h6 class="text-muted fw-semibold small mb-1">طلبات اليوم</h6>
                <h3 class="fw-bold mb-0 text-dark">{{ $seller->orderToDay->count() }}</h3>
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
                    <span class="badge bg-emerald-subtle text-emerald px-2.5 py-1 rounded-pill fw-semibold small">اليوم</span>
                </div>
                <h6 class="text-muted fw-semibold small mb-1">المؤكدة اليوم</h6>
                <h3 class="fw-bold mb-0 text-dark">{{ $seller->orderConfirmedToDay->count() }}</h3>
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
                    <span class="badge bg-rose-subtle text-rose px-2.5 py-1 rounded-pill fw-semibold small">اليوم</span>
                </div>
                <h6 class="text-muted fw-semibold small mb-1">الملغاة اليوم</h6>
                <h3 class="fw-bold mb-0 text-dark">{{ $seller->orderCanceledToDay->count() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-md-6 col-lg-3">
        <a class="text-decoration-none" href="{{ route('seller.orders-abandoned') }}">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-icon-wrapper bg-amber-subtle text-amber">
                            <i class="fa-solid fa-dolly fa-lg"></i>
                        </span>
                        <span class="badge bg-amber-subtle text-amber px-2.5 py-1 rounded-pill fw-semibold small">اليوم</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">المتروكة اليوم</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $seller->orderAbandonedToDay->count() }}</h3>
                </div>
            </div>
        </a>
    </div>
</div>