<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #2563eb 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-boxes-packing text-warning"></i>
                    <span class="fw-semibold">{{ __('إدارة عروض التوريد والجملة') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    إدارة وتتبع كوبونات خصم التوريد 🎟️
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    إضافة وتعديل وتنظيم كوبونات التوريد، متابعة نسب التخفيض وتواريخ الصلاحية وحالات الفاعلية بطريقة عصرية وذكية.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <button type="button"
                        class="btn btn-warning text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#addCouponModal">
                        <i class="fas fa-ticket-alt"></i>
                        <span>إضافة كوبون جديد</span>
                    </button>
                </div>
            </div>
        </div>
        <!-- Decorative Glow Background Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10"
            style="width: 250px; height: 250px; top: -60px; left: -60px; pointer-events: none; filter: blur(40px);">
        </div>
        <div class="position-absolute rounded-circle bg-primary opacity-10"
            style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);">
        </div>
    </div>

    <!-- Statistical Indicator Cards Grid -->
    <div class="row g-3 mb-4">
        <!-- 1. Total Coupons -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-navy-subtle text-navy fw-bold">
                            <i class="fa-solid fa-ticket fs-5"></i>
                        </span>
                        <span class="badge bg-light text-secondary rounded-pill small">الكل</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ method_exists($coupons, 'total') ? $coupons->total() : count($coupons) }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">إجمالي كوبونات التوريد</p>
                </div>
            </div>
        </div>

        <!-- 2. Active Coupons -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-success-subtle text-success fw-bold">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                        </span>
                        <span class="badge bg-success-subtle text-success rounded-pill small">نشط</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $coupons->filter(fn($c) => method_exists($c, 'isActive') ? $c->isActive() : ($c->is_active ?? true))->count() }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">كوبونات نشطة</p>
                </div>
            </div>
        </div>

        <!-- 3. Expired Coupons -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-danger-subtle text-danger fw-bold">
                            <i class="fa-solid fa-clock-rotate-left fs-5"></i>
                        </span>
                        <span class="badge bg-danger-subtle text-danger rounded-pill small">منتهي</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $coupons->filter(fn($c) => method_exists($c, 'isExpired') ? $c->isExpired() : false)->count() }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">كوبونات منتهية</p>
                </div>
            </div>
        </div>

        <!-- 4. Scheduled Coupons -->
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white hover-lift transition-all">
                <div class="card-body p-3.5">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="avatar avatar-md rounded-3 bg-warning-subtle text-warning fw-bold">
                            <i class="fa-solid fa-calendar-days fs-5"></i>
                        </span>
                        <span class="badge bg-warning-subtle text-warning rounded-pill small">مجدول</span>
                    </div>
                    <h3 class="fw-bold mb-1 text-dark fs-4">{{ $coupons->filter(fn($c) => method_exists($c, 'isScheduled') ? $c->isScheduled() : false)->count() }}</h3>
                    <p class="text-muted small mb-0 fw-semibold">كوبونات مجدولة</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Control Panel -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-body p-3.5 p-md-4">
            <div class="row g-2 g-md-3">
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label fw-semibold text-secondary small">
                        <i class="fa-solid fa-tags me-1 text-navy"></i> نوع الكوبون
                    </label>
                    <select id="typeFilter" class="form-select rounded-3 border-light-subtle shadow-none">
                        <option value="all">جميع الأنواع</option>
                        <option value="percent">نسبة مئوية</option>
                        <option value="fixed">مبلغ ثابت</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label fw-semibold text-secondary small">
                        <i class="fa-solid fa-filter me-1 text-navy"></i> الحالة
                    </label>
                    <select id="statusFilter" class="form-select rounded-3 border-light-subtle shadow-none">
                        <option value="all">جميع الحالات</option>
                        <option value="active">نشط</option>
                        <option value="expired">منتهي</option>
                        <option value="scheduled">مجدول</option>
                    </select>
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold text-secondary small">
                        <i class="fa-solid fa-magnifying-glass me-1 text-navy"></i> البحث المباشر
                    </label>
                    <input id="searchFilter" type="text" class="form-control rounded-3 border-light-subtle shadow-none"
                        placeholder="ابحث بكود الكوبون، الوصف...">
                </div>
                <div class="col-12 col-md-2 d-flex align-items-end mt-2 mt-md-0">
                    <button id="searchBtn" class="btn btn-supplier-primary w-100 rounded-3 fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2 py-2">
                        <i class="fa-solid fa-magnifying-glass"></i>
                        <span>بحث</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Coupons Table Container -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
        <div class="card-header bg-white border-0 py-3.5 px-3 px-md-4 d-flex flex-wrap align-items-center justify-content-between gap-2 border-bottom border-light">
            <div class="d-flex flex-wrap align-items-center gap-2">
                <span class="avatar avatar-md rounded-3 bg-navy-subtle text-navy fw-bold me-1" style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-ticket-alt fs-6"></i>
                </span>
                <h5 class="fw-bold mb-0 text-dark fs-6">قائمة كوبونات التوريد</h5>
            </div>
            <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill small fw-semibold">
                <i class="fa-solid fa-layer-group me-1 text-navy"></i> إجمالي المعروض: {{ method_exists($coupons, 'count') ? $coupons->count() : count($coupons) }} كوبون
            </span>
        </div>
        <div class="card-body p-0 p-md-3">
            <div class="table-responsive coupons-table-responsive custom-table-scroll">
                <table class="table table-hover align-middle mb-0 coupons-table">
                    <thead class="bg-light-subtle text-secondary small text-uppercase fw-bold border-bottom">
                        <tr>
                            <th class="ps-4 text-nowrap">الكود</th>
                            <th class="text-nowrap">الوصف</th>
                            <th class="text-nowrap">النوع</th>
                            <th class="text-nowrap">القيمة</th>
                            <th class="text-nowrap">يبدأ من</th>
                            <th class="text-nowrap">ينتهي في</th>
                            <th class="text-nowrap">الحد الأدنى</th>
                            <th class="text-nowrap">الاستخدامات</th>
                            <th class="text-nowrap">الحالة</th>
                            <th class="text-nowrap">التفعيل</th>
                            <th class="pe-4 text-end text-nowrap">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="couponList">
                        @foreach ($coupons as $coupon)
                            <tr>
                                <td data-label="الكود" class="ps-md-4">
                                    <span class="badge bg-navy-subtle text-navy fw-bold font-monospace px-3 py-1.5 fs-6 rounded-3 border border-navy-subtle">
                                        <i class="fa-solid fa-ticket me-1"></i>{{ $coupon->code }}
                                    </span>
                                </td>
                                <td data-label="الوصف" style="max-width: 220px;">
                                    <span class="fw-semibold text-dark d-inline-block text-truncate align-middle small" style="max-width: 200px;" title="{{ $coupon->description }}">
                                        {{ \Illuminate\Support\Str::limit($coupon->description, 35, '...') }}
                                    </span>
                                </td>
                                <td data-label="النوع">
                                    @if ($coupon->type == 'percent')
                                        <span class="badge bg-info-subtle text-info border border-info px-2.5 py-1.5 rounded-3 fw-semibold"><i class="fa-solid fa-percent me-1"></i>نسبة مئوية</span>
                                    @else
                                        <span class="badge bg-primary-subtle text-primary border border-primary px-2.5 py-1.5 rounded-3 fw-semibold"><i class="fa-solid fa-money-bill me-1"></i>مبلغ ثابت</span>
                                    @endif
                                </td>
                                <td data-label="القيمة">
                                    <span class="fw-bold text-navy fs-6">
                                        @if ($coupon->type == 'percent')
                                            {{ $coupon->value }}%
                                        @else
                                            {{ number_format($coupon->value, 2) }} د.ج
                                        @endif
                                    </span>
                                </td>
                                <td data-label="يبدأ من">
                                    <span class="text-secondary small fw-medium"><i class="fa-regular fa-calendar me-1 text-muted"></i>{{ \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d') }}</span>
                                </td>
                                <td data-label="ينتهي في">
                                    <span class="text-secondary small fw-medium"><i class="fa-regular fa-calendar-xmark me-1 text-muted"></i>{{ \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d') }}</span>
                                </td>
                                <td data-label="الحد الأدنى">
                                    <span class="badge bg-light text-dark border px-2.5 py-1 rounded-3 fw-semibold">{{ number_format($coupon->min_order_amount, 2) }} د.ج</span>
                                </td>
                                <td data-label="الاستخدامات">
                                    <span class="badge bg-secondary-subtle text-secondary border px-2.5 py-1 rounded-pill fw-bold">
                                        {{ $coupon->usage_per_user }} / {!! $coupon->usage_limit == 0 ? '<span class="fs-6"><b>∞</b></span>' : $coupon->usage_limit !!}
                                    </span>
                                </td>
                                <td data-label="الحالة">
                                    @if ($coupon->isExpired())
                                        <span class="badge bg-danger-subtle text-danger border border-danger px-3 py-1.5 rounded-pill fw-bold"><i class="fa-solid fa-circle-xmark me-1"></i>منتهي</span>
                                    @elseif($coupon->isScheduled())
                                        <span class="badge bg-warning-subtle text-warning border border-warning px-3 py-1.5 rounded-pill fw-bold"><i class="fa-solid fa-clock me-1"></i>مجدول</span>
                                    @else
                                        <span class="badge bg-success-subtle text-success border border-success px-3 py-1.5 rounded-pill fw-bold"><i class="fa-solid fa-circle-check me-1"></i>نشط</span>
                                    @endif
                                </td>
                                <td data-label="التفعيل">
                                    @if ($coupon->isActive())
                                        <span class="badge bg-success-subtle text-success border border-success px-2.5 py-1 rounded-pill fw-bold">مفعل</span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger px-2.5 py-1 rounded-pill fw-bold">غير مفعل</span>
                                    @endif
                                </td>
                                <td data-label="الإجراءات" class="pe-md-4 text-end">
                                    <button value="{{ $coupon->id }}" class="btn btn-sm btn-outline-primary rounded-3 edit-coupon px-2.5 py-1 me-1 shadow-2xs fw-semibold" data-bs-toggle="modal" data-bs-target="#editCouponModal">
                                        <i class="fas fa-edit me-1"></i> تعديل
                                    </button>
                                    <button class="btn btn-sm btn-outline-danger rounded-3 delete-coupon px-2.5 py-1 shadow-2xs fw-semibold" value="{{ $coupon->id }}">
                                        <i class="fas fa-trash me-1"></i> حذف
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if (method_exists($coupons, 'hasPages') && $coupons->hasPages())
                <div class="p-4 border-top border-light d-flex justify-content-center">
                    {{ $coupons->links('vendor.pagination.dashboard-pagination') }}
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Add Coupon Modal -->
<div class="modal fade" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-supplier-header py-3 px-4">
                <h5 class="modal-title fw-bold text-white fs-6" id="addCouponModalLabel">
                    <i class="fas fa-ticket-alt me-2"></i>إضافة كوبون جديد
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="addCouponForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="add_code" class="form-label fw-semibold text-secondary small">كود الكوبون</label>
                        <div class="input-group">
                            <input type="text" class="form-control rounded-start-3 shadow-none text-uppercase fw-bold font-monospace" id="add_code" name="code" placeholder="مثال: SUPPLY2026" required>
                            <button class="btn btn-supplier-primary px-3 fw-bold rounded-end-3" type="button" id="generateCode">
                                <i class="fas fa-sync-alt me-1"></i> توليد
                            </button>
                        </div>
                        <small class="text-muted d-block mt-1">يجب أن يكون الكود فريداً وحروف كبيرة</small>
                        <span class="text-danger error-add_code small"></span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="add_description" class="form-label fw-semibold text-secondary small">وصف الكوبون</label>
                        <textarea class="form-control rounded-3 shadow-none" id="add_description" name="description" rows="2" placeholder="اكتب وصفاً قصيراً للكوبون..."></textarea>
                        <span class="text-danger error-add_description small"></span>
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="add_type" class="form-label fw-semibold text-secondary small">نوع الخصم</label>
                            <select class="form-select rounded-3 shadow-none" id="add_type" name="type" required>
                                <option value="percent">نسبة مئوية</option>
                                <option value="fixed">مبلغ ثابت</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="add_value" class="form-label fw-semibold text-secondary small">قيمة الخصم</label>
                            <div class="input-group">
                                <input type="number" class="form-control rounded-start-3 shadow-none" id="add_value" name="value" min="0" step="0.01" required>
                                <span class="input-group-text rounded-end-3 bg-light fw-bold text-navy" id="valueSuffix">%</span>
                            </div>
                            <span class="text-danger error-add_value small"></span>
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="add_start_date" class="form-label fw-semibold text-secondary small">يبدأ من</label>
                            <input type="datetime-local" class="form-control rounded-3 shadow-none" id="add_start_date" name="start_date" required>
                            <span class="text-danger error-add_start_date small"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="add_end_date" class="form-label fw-semibold text-secondary small">ينتهي في</label>
                            <input type="datetime-local" class="form-control rounded-3 shadow-none" id="add_end_date" name="end_date" required>
                            <span class="text-danger error-add_end_date small"></span>
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="add_min_order_amount" class="form-label fw-semibold text-secondary small">الحد الأدنى للطلب (د.ج)</label>
                            <input type="number" class="form-control rounded-3 shadow-none" id="add_min_order_amount" name="min_order_amount" min="0" step="0.01" value="0">
                            <small class="text-muted d-block mt-1">المبلغ الأدنى لتفعيل الكوبون (0 يعني لا يوجد حد)</small>
                            <span class="text-danger error-add_min_order_amount small"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="add_max_uses" class="form-label fw-semibold text-secondary small">الحد الأقصى للاستخدام</label>
                            <input type="number" class="form-control rounded-3 shadow-none" id="add_max_uses" name="max_uses" min="0" value="0">
                            <small class="text-muted d-block mt-1">0 يعني لا يوجد حد</small>
                            <span class="text-danger error-add_max_uses small"></span>
                        </div>
                    </div>
                    
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="add_is_active" name="is_active" checked>
                        <label class="form-check-label fw-semibold text-dark small" for="add_is_active">الكوبون نشط وجاهز للاستخدام</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-0 py-3 px-4">
                <button type="button" class="btn btn-light rounded-3 px-4 fw-semibold" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm" id="saveCoupon">
                    <i class="fas fa-check me-1"></i> حفظ الكوبون
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Coupon Modal -->
<div class="modal fade" id="editCouponModal" tabindex="-1" aria-labelledby="editCouponModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-supplier-header py-3 px-4">
                <h5 class="modal-title fw-bold text-white fs-6" id="editCouponModalLabel">
                    <i class="fas fa-edit me-2"></i>تعديل الكوبون
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="editCouponForm">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="mb-3">
                        <label for="edit_code" class="form-label fw-semibold text-secondary small">كود الكوبون</label>
                        <input type="text" class="form-control rounded-3 shadow-none bg-light font-monospace fw-bold text-navy" id="edit_code" name="code" readonly>
                        <span class="text-danger error-edit_code small"></span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_description" class="form-label fw-semibold text-secondary small">وصف الكوبون</label>
                        <textarea class="form-control rounded-3 shadow-none" id="edit_description" name="description" rows="2"></textarea>
                        <span class="text-danger error-edit_description small"></span>
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="edit_type" class="form-label fw-semibold text-secondary small">نوع الخصم</label>
                            <select class="form-select rounded-3 shadow-none" id="edit_type" name="type" required>
                                <option value="percent">نسبة مئوية</option>
                                <option value="fixed">مبلغ ثابت</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_value" class="form-label fw-semibold text-secondary small">قيمة الخصم</label>
                            <div class="input-group">
                                <input type="number" class="form-control rounded-start-3 shadow-none" id="edit_value" name="value" min="0" step="0.01" required>
                                <span class="input-group-text rounded-end-3 bg-light fw-bold text-navy" id="editValueSuffix">%</span>
                            </div>
                            <span class="text-danger error-edit_value small"></span>
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="edit_start_date" class="form-label fw-semibold text-secondary small">يبدأ من</label>
                            <input type="datetime-local" class="form-control rounded-3 shadow-none" id="edit_start_date" name="start_date" required>
                            <span class="text-danger error-edit_start_date small"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_end_date" class="form-label fw-semibold text-secondary small">ينتهي في</label>
                            <input type="datetime-local" class="form-control rounded-3 shadow-none" id="edit_end_date" name="end_date" required>
                            <span class="text-danger error-edit_end_date small"></span>
                        </div>
                    </div>
                    
                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="edit_min_order_amount" class="form-label fw-semibold text-secondary small">الحد الأدنى للطلب (د.ج)</label>
                            <input type="number" class="form-control rounded-3 shadow-none" id="edit_min_order_amount" name="min_order_amount" min="0" step="0.01">
                            <span class="text-danger error-edit_min_order_amount small"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_max_uses" class="form-label fw-semibold text-secondary small">الحد الأقصى للاستخدام</label>
                            <input type="number" class="form-control rounded-3 shadow-none" id="edit_max_uses" name="max_uses" min="0">
                            <span class="text-danger error-edit_max_uses small"></span>
                        </div>
                    </div>
                    
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active">
                        <label class="form-check-label fw-semibold text-dark small" for="edit_is_active">الكوبون نشط</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer bg-light border-0 py-3 px-4">
                <button type="button" class="btn btn-light rounded-3 px-4 fw-semibold" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-supplier-primary rounded-3 px-4 fw-bold shadow-sm" id="updateCoupon">
                    <i class="fas fa-save me-1"></i> تحديث الكوبون
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCouponModal" tabindex="-1" aria-labelledby="deleteCouponModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-danger text-white py-3 px-4">
                <h5 class="modal-title fw-bold fs-6" id="deleteCouponModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>تأكيد الحذف
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="avatar avatar-xl rounded-circle bg-danger-subtle text-danger mx-auto mb-3" style="width:64px; height:64px; display:inline-flex; align-items:center; justify-content:center;">
                    <i class="fas fa-trash-alt fs-3"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2">هل أنت متأكد من حذف هذا الكوبون؟</h5>
                <p class="text-muted mb-0 small">سيؤدي هذا الإجراء إلى حذف الكوبون بشكل نهائي ولا يمكن التراجع عنه.</p>
                <input type="hidden" id="delete_coupon_id">
            </div>
            <div class="modal-footer bg-light border-0 py-3 px-4 justify-content-center">
                <button type="button" class="btn btn-light rounded-3 px-4 fw-semibold me-2" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-danger rounded-3 px-4 fw-bold shadow-sm" id="confirmDelete">
                    <i class="fas fa-trash me-1"></i> حذف الكوبون
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* ================================
       PURE CSS RESPONSIVE TABLE PROTOCOL (SAFE-UI-STYLING SKILL)
       Targeting screens up to 1024.98px (Tablets / iPad / 1024px displays)
       ================================ */
    @media (max-width: 1024.98px) {
        .coupons-table-responsive table.coupons-table,
        .coupons-table-responsive table.coupons-table tbody,
        .coupons-table-responsive table.coupons-table tr,
        .coupons-table-responsive table.coupons-table td {
            display: block !important;
            width: 100% !important;
            box-sizing: border-box !important;
        }

        .coupons-table-responsive table.coupons-table thead {
            display: none !important;
        }

        .coupons-table-responsive table.coupons-table tbody tr {
            background: #ffffff !important;
            border: 1px solid #e2e8f0 !important;
            border-radius: 16px !important;
            margin-bottom: 1.25rem !important;
            padding: 0.85rem 1.15rem !important;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.04) !important;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .coupons-table-responsive table.coupons-table tbody tr:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08) !important;
        }

        .coupons-table-responsive table.coupons-table tbody td {
            display: flex !important;
            justify-content: space-between !important;
            align-items: center !important;
            padding: 0.75rem 0.5rem !important;
            border: none !important;
            border-bottom: 1px dashed #e2e8f0 !important;
            white-space: normal !important;
            text-align: right !important;
            font-size: 0.9rem;
        }

        .coupons-table-responsive table.coupons-table tbody td:last-child {
            border-bottom: none !important;
            justify-content: flex-end !important;
            gap: 0.5rem;
            padding-top: 1rem !important;
        }

        .coupons-table-responsive table.coupons-table tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            color: #64748b;
            font-size: 0.85rem;
            margin-left: 1rem;
            flex-shrink: 0;
        }
    }

    /* Responsive adjustments specifically for 768px - 1024px tablet landscape screens */
    @media (min-width: 768px) and (max-width: 1024.98px) {
        .coupons-table-responsive table.coupons-table tbody tr {
            display: grid !important;
            grid-template-columns: repeat(2, 1fr) !important;
            gap: 0.5rem 1.5rem !important;
            padding: 1.25rem !important;
        }

        .coupons-table-responsive table.coupons-table tbody td {
            border-bottom: 1px dashed #f1f5f9 !important;
        }

        .coupons-table-responsive table.coupons-table tbody td[data-label="الكود"] {
            grid-column: 1 / -1;
            border-bottom: 1px solid #e2e8f0 !important;
            padding-bottom: 0.5rem !important;
        }

        .coupons-table-responsive table.coupons-table tbody td[data-label="الإجراءات"] {
            grid-column: 1 / -1;
            border-bottom: none !important;
            justify-content: flex-end !important;
        }
    }

    /* Optimization for Desktop Screens > 1024px */
    @media (min-width: 1025px) {
        .coupons-table th {
            font-size: 0.82rem;
            letter-spacing: 0.3px;
            padding: 0.9rem 0.75rem;
        }

        .coupons-table td {
            padding: 0.85rem 0.75rem;
            font-size: 0.875rem;
        }
    }

    .card,
    .card-body {
        min-width: 0 !important;
        max-width: 100% !important;
    }

    .table-responsive {
        width: 100% !important;
        max-width: 100% !important;
        min-width: 0 !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
        display: block;
    }

    .custom-table-scroll {
        -webkit-overflow-scrolling: touch;
        overflow-x: auto !important;
        scrollbar-width: thin;
        scrollbar-color: #cbd5e1 #f8fafc;
    }

    .custom-table-scroll::-webkit-scrollbar {
        height: 6px;
    }

    .custom-table-scroll::-webkit-scrollbar-track {
        background: #f8fafc;
        border-radius: 4px;
    }

    .custom-table-scroll::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }

    .custom-table-scroll::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    .bg-navy-subtle {
        background-color: rgba(15, 23, 42, 0.1);
    }

    .border-navy-subtle {
        border-color: rgba(15, 23, 42, 0.25) !important;
    }

    .text-navy {
        color: #0f172a !important;
    }

    .bg-supplier-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        color: #ffffff !important;
    }

    .btn-supplier-primary {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        color: #ffffff !important;
        border: none !important;
    }

    .btn-supplier-primary:hover {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%) !important;
        color: #ffffff !important;
    }

    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .avatar-md {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>