<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
         style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #2563eb 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-truck-ramp-box text-warning"></i>
                    <span class="fw-semibold">{{ __('إدارة طلبات المورد') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    إدارة وتتبع طلبات التوريد 🚚
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    متابعة طلبات الجملة، معالجة وتأكيد الشحنات، وإحصائيات المبيعات بطريقة عصرية وسلسة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <button type="button" class="btn btn-warning text-dark fw-bold px-3 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2" onclick="location.reload();">
                        <i class="fa-solid fa-rotate-right"></i>
                        <span>تحديث البيانات</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Decorative Glow Background Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10" style="width: 250px; height: 250px; top: -60px; left: -60px; pointer-events: none; filter: blur(40px);"></div>
        <div class="position-absolute rounded-circle bg-primary opacity-10" style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);"></div>
    </div>

    <!-- Indicators / Stat Cards Grid -->
    <div class="row g-3 mb-4">
        <!-- Total Orders -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="stat-icon-wrapper bg-navy-subtle text-navy">
                            <i class="fa-solid fa-boxes-stacked fa-lg"></i>
                        </span>
                        <span class="badge bg-navy-subtle text-navy px-2 py-1 rounded-pill fw-semibold small">الكل</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">كل الطلبات</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $orderStats['total'] ?? $orders->total() }}</h3>
                </div>
            </div>
        </div>

        <!-- Today's Orders -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="stat-icon-wrapper bg-warning-subtle text-warning">
                            <i class="fa-solid fa-calendar-day fa-lg"></i>
                        </span>
                        <span class="badge bg-warning-subtle text-warning px-2 py-1 rounded-pill fw-semibold small">اليوم</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">طلبات اليوم</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $orderStats['today'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- This Week's Orders -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="stat-icon-wrapper bg-info-subtle text-info">
                            <i class="fa-solid fa-calendar-week fa-lg"></i>
                        </span>
                        <span class="badge bg-info-subtle text-info px-2 py-1 rounded-pill fw-semibold small">الأسبوع</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">طلبات الأسبوع</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $orderStats['this_week'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- This Month's Orders -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="stat-icon-wrapper bg-indigo-subtle text-indigo">
                            <i class="fa-solid fa-calendar-alt fa-lg"></i>
                        </span>
                        <span class="badge bg-indigo-subtle text-indigo px-2 py-1 rounded-pill fw-semibold small">الشهر</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">طلبات الشهر</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $orderStats['this_month'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Pending Orders -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="stat-icon-wrapper bg-amber-subtle text-amber">
                            <i class="fa-solid fa-clock fa-lg"></i>
                        </span>
                        <span class="badge bg-amber-subtle text-amber px-2 py-1 rounded-pill fw-semibold small">معلق</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">قيد الانتظار</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $orderStats['pending'] ?? 0 }}</h3>
                </div>
            </div>
        </div>

        <!-- Delivered Orders -->
        <div class="col-xl-2 col-md-4 col-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="stat-icon-wrapper bg-emerald-subtle text-emerald">
                            <i class="fa-solid fa-circle-check fa-lg"></i>
                        </span>
                        <span class="badge bg-emerald-subtle text-emerald px-2 py-1 rounded-pill fw-semibold small">مكتمل</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">طلبات مكتملة</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $orderStats['delivered'] ?? 0 }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Section -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="filter-icon-box bg-navy-subtle text-navy rounded-3 p-2">
                    <i class="fa-solid fa-filter fs-6"></i>
                </div>
                <h5 class="fw-bold mb-0 text-dark fs-6">تصفية وتخصيص البحث</h5>
            </div>
        </div>
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary small">
                        <i class="fa-solid fa-truck me-1 text-navy"></i> حالة الشحن
                    </label>
                    <select id="orderStatusFilter" class="form-select rounded-3 border-light-subtle shadow-none custom-select-styled">
                        <option value="all">جميع الحالات</option>
                        <option value="pending">جديد / معلق</option>
                        <option value="processing">قيد المعالجة</option>
                        <option value="shipped">تم الشحن</option>
                        <option value="delivered">مكتمل</option>
                        <option value="canceled">ملغي</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary small">
                        <i class="fa-solid fa-calendar me-1 text-navy"></i> تاريخ الطلب
                    </label>
                    <input id="orderDateFilter" type="date" class="form-control rounded-3 border-light-subtle shadow-none">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-secondary small">
                        <i class="fa-solid fa-magnifying-glass me-1 text-navy"></i> البحث المباشر
                    </label>
                    <input id="searchFilter" type="text" class="form-control rounded-3 border-light-subtle shadow-none" placeholder="رقم الطلب، اسم العميل، الهاتف...">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button id="searchBtn" class="btn btn-supplier-primary w-100 rounded-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 py-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>بحث</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table Container -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
        <div class="card-header bg-white border-0 py-3.5 px-4 d-flex align-items-center justify-content-between border-bottom border-light">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-list-check text-navy fs-5"></i>
                <h5 class="fw-bold mb-0 text-dark fs-6">قائمة طلبات التوريد</h5>
            </div>
            <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill small fw-semibold">
                إجمالي المعروض: {{ $orders->count() }} طلب
            </span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover orders-table align-middle mb-0">
                    <thead class="bg-light-subtle text-secondary small text-uppercase fw-bold border-bottom">
                        <tr>
                            <th class="py-3 px-4">رقم الطلب</th>
                            <th class="py-3">العميل</th>
                            <th class="py-3">رقم الهاتف</th>
                            <th class="py-3">الإجمالي</th>
                            <th class="py-3">تأكيد الطلب</th>
                            <th class="py-3">تاريخ الطلب</th>
                            <th class="py-3">حالة الشحن</th>
                            <th class="py-3 px-4 text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('users.suppliers.components.content.orders.partials.orders_table')
                    </tbody>
                </table>
            </div>

            <div class="p-3 text-center bg-light-subtle border-top">
                {!! $orders->links('vendor.pagination.dashboard-pagination') !!}
            </div>
        </div>
    </div>

</div>

<!-- Modals Modernized -->
<!-- View Order Details Modal -->
<div class="modal fade" id="viewOrderModal" aria-labelledby="viewOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-navy text-white px-4 py-3 border-0">
                <h5 class="modal-title fw-bold fs-6 d-flex align-items-center gap-2">
                    <i class="fa-solid fa-receipt"></i>
                    <span>تفاصيل الطلب</span>
                    <span id="order-number" class="badge bg-white text-navy rounded-pill px-2.5 py-1 ms-1"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white opacity-100" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4 mb-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100 border border-light-subtle">
                            <h6 class="fw-bold text-navy mb-3 border-bottom pb-2">
                                <i class="fa-solid fa-user me-1"></i> معلومات العميل
                            </h6>
                            <p class="mb-2 text-dark"><strong>الاسم:</strong> <span id="customer-name" class="text-secondary"></span></p>
                            <p class="mb-2 text-dark"><strong>الهاتف:</strong> <span id="customer-phone" class="text-secondary"></span></p>
                            <p class="mb-0 text-dark"><strong>البريد الإلكتروني:</strong> <span id="customer-email" class="text-secondary"></span></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 h-100 border border-light-subtle">
                            <h6 class="fw-bold text-navy mb-3 border-bottom pb-2">
                                <i class="fa-solid fa-location-dot me-1"></i> معلومات الشحن
                            </h6>
                            <p class="mb-2 text-dark"><strong>العنوان:</strong> <span id="shipping-address" class="text-secondary"></span></p>
                            <p class="mb-2 text-dark"><strong>الولاية:</strong> <span id="shipping-city" class="text-secondary"></span></p>
                            <p class="mb-0 text-dark"><strong>الرمز البريدي:</strong> <span id="shipping-zipcode" class="text-secondary"></span></p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="p-3 bg-light rounded-3 border border-light-subtle">
                            <h6 class="fw-bold text-navy mb-2">
                                <i class="fa-solid fa-note-sticky me-1"></i> ملاحظة الزبون
                            </h6>
                            <p class="mb-0 text-secondary" id="customer-note">-</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border border-light-subtle h-100">
                            <h6 class="fw-bold text-navy mb-2">
                                <i class="fa-solid fa-credit-card me-1"></i> حالة الدفع
                            </h6>
                            <div id="payment-status"></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border border-light-subtle">
                            <h6 class="fw-bold text-navy mb-2">
                                <i class="fa-solid fa-wallet me-1"></i> طريقة الدفع
                            </h6>
                            <span id="payment-method" class="fw-semibold text-dark"></span>
                            <div id="payment_proof" class="mt-2"></div>
                        </div>
                    </div>
                </div>

                <h6 class="fw-bold text-dark mb-3 mt-4">
                    <i class="fa-solid fa-cart-flatbed me-1 text-navy"></i> قائمة المنتجات
                </h6>
                <div class="table-responsive rounded-3 border">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light small">
                            <tr>
                                <th>المنتج</th>
                                <th>الكمية</th>
                                <th>السعر</th>
                                <th>العمليات</th>
                                <th>الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody id="order-items">
                            <!-- سيتم ملء البيانات هنا عبر AJAX -->
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="4" class="text-start">المجموع</td>
                                <td id="subtotal-price"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-start">الشحن</td>
                                <td id="shipping-cost"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-start">التخفيض</td>
                                <td id="discount"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-start text-navy">الإجمالي الكلي</td>
                                <td><strong id="total-price" class="text-navy fs-6"></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light px-4 py-3 border-top-0">
                <button type="button" class="btn btn-secondary rounded-3 px-4 fw-semibold" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm d-flex align-items-center gap-2" onclick="printInvoice()">
                    <i class="fa-solid fa-print"></i>
                    <span>طباعة الفاتورة</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Shipping Company Selection Modal -->
<div class="modal fade" id="viewShippingModal" tabindex="-1" aria-labelledby="viewShippingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-navy text-white px-4 py-3 border-0">
                <h5 class="modal-title fw-bold fs-6" id="viewShippingModalLabel">
                    <i class="fa-solid fa-truck-fast me-2"></i> رفع الطلب لشركة التوصيل
                </h5>
                <button type="button" class="btn-close btn-close-white opacity-100" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="d-flex flex-column gap-3">
                    @foreach ($companies as $company)
                        <div class="p-3 border rounded-3 bg-light d-flex align-items-center justify-content-between shadow-sm hover-shadow transition-all">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ json_decode($company->data)->logo ?? '' }}" class="img-fluid rounded" alt="{{ $company->name }}" style="max-height: 45px; max-width: 90px; object-fit: contain;">
                                <span class="fw-bold text-dark">{{ $company->name }}</span>
                            </div>
                            <button class="btn btn-supplier-primary btn-sm px-3 rounded-2 fw-semibold create_company_parcel"
                                    data-order-id="100" data-company-name="{{ $company->name }}">
                                <i class="fa-solid fa-truck me-1"></i> رفع الطلب
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tracking Modal -->
<div class="modal fade" id="viewTrackingModal" tabindex="-1" aria-labelledby="viewTrackingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-navy text-white px-4 py-3 border-0">
                <h5 class="modal-title fw-bold fs-6" id="viewTrackingModalLabel">
                    <i class="fa-solid fa-location-dot me-2"></i> تتبع وحالة الشحنة
                </h5>
                <button type="button" class="btn-close btn-close-white opacity-100" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-3">
                    <p class="text-muted small mb-0">إلغاء أومسح الطلب المرفوع لشركة التوصيل</p>
                </div>
                <button id="order_id_to_delete_btn"
                        class="btn btn-danger w-100 rounded-3 py-2 fw-bold shadow-sm delete_order_from_shipping_company"
                        data-order-id-to-delete="null">
                    <i class="fa-solid fa-trash me-2"></i> حذف الطلب من شركة التوصيل
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modern CSS Styles -->
<style>
/* Modern Color Tokens for Supplier Panel */
:root {
    --supplier-navy: #1e293b;
    --supplier-navy-dark: #0f172a;
    --supplier-accent: #2563eb;
}

.bg-navy {
    background-color: var(--supplier-navy) !important;
}

.text-navy {
    color: var(--supplier-navy) !important;
}

.bg-navy-subtle {
    background-color: rgba(30, 41, 59, 0.08) !important;
}

.btn-supplier-primary {
    background: linear-gradient(135deg, var(--supplier-navy) 0%, var(--supplier-navy-dark) 100%);
    color: #ffffff !important;
    border: none;
    transition: all 0.25s ease;
}

.btn-supplier-primary:hover {
    background: linear-gradient(135deg, var(--supplier-navy-dark) 0%, #000000 100%);
    color: #ffffff !important;
    box-shadow: 0 4px 12px rgba(15, 23, 42, 0.25) !important;
}

/* Stat Cards */
.dashboard-stat-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}

.dashboard-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06) !important;
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

/* Color Palette Utility Classes */
.bg-indigo-subtle { background-color: rgba(79, 70, 229, 0.08) !important; }
.text-indigo { color: #4f46e5 !important; }

.bg-emerald-subtle { background-color: rgba(16, 185, 129, 0.08) !important; }
.text-emerald { color: #10b981 !important; }

.bg-amber-subtle { background-color: rgba(245, 158, 11, 0.08) !important; }
.text-amber { color: #f59e0b !important; }

.bg-rose-subtle { background-color: rgba(244, 63, 94, 0.08) !important; }
.text-rose { color: #f43f5e !important; }

/* Filter & Table Enhancements */
.custom-select-styled {
    background-position: left 0.75rem center;
}

.orders-table th {
    font-weight: 700;
    letter-spacing: 0.3px;
    color: #475569;
}

.orders-table tbody tr {
    transition: background-color 0.15s ease;
}

.orders-table tbody tr:hover {
    background-color: rgba(30, 41, 59, 0.02) !important;
}

/* Responsive Table for Mobile */
@media (max-width: 768px) {
    .orders-table thead {
        display: none;
    }

    .orders-table,
    .orders-table tbody,
    .orders-table tr,
    .orders-table td {
        display: block;
        width: 100%;
    }

    .orders-table tr {
        margin-bottom: 16px;
        padding: 14px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
    }

    .orders-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border: none;
        border-bottom: 1px solid #f1f5f9;
        text-align: right;
    }

    .orders-table td:last-child {
        border-bottom: none;
        flex-wrap: wrap;
        justify-content: flex-start;
        padding-top: 12px;
    }

    .orders-table td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #64748b;
        font-size: 0.85rem;
        flex-shrink: 0;
    }

    .orders-table td:nth-child(1)::before { content: "رقم الطلب"; }
    .orders-table td:nth-child(2)::before { content: "العميل"; }
    .orders-table td:nth-child(3)::before { content: "رقم الهاتف"; }
    .orders-table td:nth-child(4)::before { content: "الإجمالي"; }
    .orders-table td:nth-child(5)::before { content: "تأكيد الطلب"; }
    .orders-table td:nth-child(6)::before { content: "تاريخ الطلب"; }
    .orders-table td:nth-child(7)::before { content: "حالة الشحن"; }
    .orders-table td:nth-child(8)::before { content: "الإجراءات"; }
}
</style>
