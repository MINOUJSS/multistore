<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
         style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #2563eb 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-boxes-packing text-warning"></i>
                    <span class="fw-semibold">{{ __('طلبات التوريد المتروكة') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    إدارة طلبيات التوريد المتروكة 🚚
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    متابعة طلبيات التوريد بالجملة غير المكتملة للتجّار والبائعين، وإعادة التواصل لتنشيط وإتمام التوريد بطريقة عصرية وسلسة.
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

    <!-- Statistical Indicator Cards -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Abandoned -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-navy-subtle text-navy fw-bold">
                            <i class="fa-solid fa-boxes-packing fs-5"></i>
                        </span>
                        <span class="badge bg-light text-secondary rounded-pill small">الكل</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $orderStats['total'] ?? 0 }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">كل طلبات التوريد</p>
                </div>
            </div>
        </div>

        <!-- 2. Today's Abandoned -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-primary-subtle text-primary fw-bold">
                            <i class="fa-solid fa-calendar-day fs-5"></i>
                        </span>
                        <span class="badge bg-primary-subtle text-primary rounded-pill small">اليوم</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $orderStats['today'] ?? 0 }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">متروكة اليوم</p>
                </div>
            </div>
        </div>

        <!-- 3. This Week -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-info-subtle text-info fw-bold">
                            <i class="fa-solid fa-calendar-week fs-5"></i>
                        </span>
                        <span class="badge bg-info-subtle text-info rounded-pill small">الأسبوع</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $orderStats['this_week'] ?? 0 }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">متروكة هذا الأسبوع</p>
                </div>
            </div>
        </div>

        <!-- 4. This Month -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-secondary-subtle text-secondary fw-bold">
                            <i class="fa-solid fa-calendar-days fs-5"></i>
                        </span>
                        <span class="badge bg-secondary-subtle text-secondary rounded-pill small">الشهر</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $orderStats['this_month'] ?? 0 }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">متروكة هذا الشهر</p>
                </div>
            </div>
        </div>

        <!-- 5. Pending / Reminder -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-warning-subtle text-warning fw-bold">
                            <i class="fa-solid fa-hourglass-half fs-5"></i>
                        </span>
                        <span class="badge bg-warning-subtle text-warning rounded-pill small">تذكير</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $orderStats['pending'] ?? 0 }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">قيد المعالجة والتذكير</p>
                </div>
            </div>
        </div>

        <!-- 6. Recovered / Delivered -->
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-success-subtle text-success fw-bold">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                        </span>
                        <span class="badge bg-success-subtle text-success rounded-pill small">مكسب</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $orderStats['delivered'] ?? 0 }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">طلبيات تم استرجاعها</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Control Panel -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary small">
                        <i class="fa-solid fa-filter me-1 text-navy"></i> حالة المعالجة
                    </label>
                    <select id="orderStatusFilter" class="form-select rounded-3 border-light-subtle shadow-none">
                        <option value="all">جميع الحالات</option>
                        <option value="pending">جديد</option>
                        <option value="processing">قيد المعالجة</option>
                        <option value="shipped">تم الشحن</option>
                        <option value="delivered">مكتمل (مسترجع)</option>
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

    <!-- Abandoned Orders Table Container -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
        <div class="card-header bg-white border-0 py-3.5 px-4 d-flex align-items-center justify-content-between border-bottom border-light">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-boxes-packing text-navy fs-5"></i>
                <h5 class="fw-bold mb-0 text-dark fs-6">قائمة طلبيات التوريد المتروكة</h5>
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
                            <th class="ps-4">رقم الطلب</th>
                            <th>العميل</th>
                            <th>رقم الهاتف</th>
                            <th>المنتجات</th>
                            <th>الإجمالي</th>
                            <th>تاريخ الطلب</th>
                            <th>الحالة</th>
                            <th class="pe-4 text-end">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('users.suppliers.components.content.orders_abandoned.partials.orders_table')
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="p-4 border-top border-light d-flex justify-content-center">
                    {!! $orders->links('vendor.pagination.dashboard-pagination') !!}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- View Order Modal -->
<div class="modal fade" id="viewOrderModal" aria-labelledby="viewOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-white border-bottom border-light py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-solid fa-receipt text-navy fs-5"></i>
                    <h5 class="modal-title fw-bold text-dark fs-6">تفاصيل طلب التوريد المتروك <span id="order-number" class="text-navy ms-1"></span></h5>
                </div>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3 mb-4">
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
                </div>

                <h6 class="fw-bold text-dark mb-3">
                    <i class="fa-solid fa-box-open text-navy me-1"></i> محتويات طلب التوريد
                </h6>
                <div class="table-responsive rounded-3 border border-light mb-0">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-secondary small fw-bold">
                            <tr>
                                <th>المنتج</th>
                                <th class="text-center">الكمية</th>
                                <th class="text-end">السعر</th>
                                <th class="text-end">الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody id="order-items">
                            <!-- سيتم ملء البيانات عبر AJAX -->
                        </tbody>
                        <tfoot class="bg-light-subtle fw-bold">
                            <tr>
                                <td colspan="3" class="text-start text-secondary">المجموع الفرعي:</td>
                                <td id="subtotal-price" class="text-end text-dark"></td>
                            </tr>
                            <tr>
                                <td colspan="3" class="text-start text-secondary">الشحن:</td>
                                <td id="shipping-cost" class="text-end text-dark"></td>
                            </tr>
                            <tr class="table-active">
                                <td colspan="3" class="text-start text-dark fs-6">الإجمالي الكلي:</td>
                                <td class="text-end text-navy fs-6"><strong id="total-price"></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light border-top border-light py-3 px-4">
                <button type="button" class="btn btn-light rounded-3 fw-semibold border px-4" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-supplier-primary rounded-3 fw-bold px-4 d-flex align-items-center gap-2" onclick="printInvoice()">
                    <i class="fa-solid fa-print"></i>
                    <span>طباعة الفاتورة</span>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
.bg-navy-subtle { background-color: rgba(15, 23, 42, 0.1); }
.text-navy { color: #0f172a !important; }
.btn-supplier-primary {
    background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
    color: #ffffff;
    border: none;
}
.btn-supplier-primary:hover {
    background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
    color: #ffffff;
}
.hover-lift {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.hover-lift:hover {
    transform: translateY(-4px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
}
.avatar-md {
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
}
</style>
