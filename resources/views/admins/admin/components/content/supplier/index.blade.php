<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-store text-warning"></i>
                    <span>{{ __('إدارة شركاء الموردين والمتاجر الجملة') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    🏬 إدارة وحصر الموردين 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    متابعة حسابات الموردين، الباقات المفعلة، المتاجر التابعة، وإحصائيات المنتجات والطلبات بالمنصة.
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

    <!-- Alerts -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-sm border-0 mb-4">
            <i class="fa-solid fa-circle-check me-2"></i>
            {{ session()->get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Stats Cards Row -->
    <div class="row mb-4 g-3">
        <!-- 1. Total & Account Status -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="d-flex align-items-center justify-content-center rounded-3 text-white shadow-sm"
                            style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 100%); width: 46px; height: 46px;">
                            <i class="fa-solid fa-users fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold d-block">إجمالي الموردين</small>
                            <h4 class="fw-bold mb-0 text-dark">{{ $supplierStats['total'] ?? $suppliers->total() }}</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-1.5 pt-2 border-top border-light-subtle">
                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-circle-check me-1"></i>{{ $supplierStats['approved'] ?? 0 }} معتمد
                    </span>
                    <span class="badge bg-warning-subtle text-dark px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-clock me-1"></i>{{ $supplierStats['pending'] ?? 0 }} مراجعة
                    </span>
                    @if (($supplierStats['inactive'] ?? 0) > 0)
                        <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                            <i class="fa-solid fa-ban me-1"></i>{{ $supplierStats['inactive'] }} معطل
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- 2. Active Suppliers via last_seens -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-3 shadow-sm"
                            style="width: 46px; height: 46px;">
                            <i class="fa-solid fa-user-check fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold d-block">موردون نشطون</small>
                            <div class="d-flex align-items-baseline gap-1">
                                <h4 class="fw-bold mb-0 text-dark">{{ $supplierStats['active'] ?? 0 }}</h4>
                                <small class="text-muted fw-normal" style="font-size: 0.8rem;">/ {{ $supplierStats['total'] ?? 0 }}</small>
                            </div>
                        </div>
                    </div>
                    <span class="badge {{ ($supplierStats['activity_percentage'] ?? 0) >= 70 ? 'bg-success' : (($supplierStats['activity_percentage'] ?? 0) >= 40 ? 'bg-warning text-dark' : 'bg-secondary') }} px-2 py-1 rounded-pill fw-bold" style="font-size: 0.75rem;">
                        {{ $supplierStats['activity_percentage'] ?? 0 }}%
                    </span>
                </div>
                <div class="pt-2 border-top border-light-subtle">
                    <div class="progress rounded-pill mb-1.5" style="height: 5px; background-color: rgba(16, 185, 129, 0.1);">
                        <div class="progress-bar bg-success rounded-pill" role="progressbar"
                            style="width: {{ $supplierStats['activity_percentage'] ?? 0 }}%;"
                            aria-valuenow="{{ $supplierStats['activity_percentage'] ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between text-muted" style="font-size: 0.72rem;">
                        <span><i class="fa-regular fa-clock me-1"></i>آخر {{ $supplierStats['period_days'] ?? 30 }} يوم</span>
                        <span>خامل: <strong>{{ $supplierStats['inactive_activity'] ?? 0 }}</strong></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- 3. Real Products (Excluding Dummy) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="d-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info rounded-3 shadow-sm"
                            style="width: 46px; height: 46px;">
                            <i class="fa-solid fa-boxes-stacked fs-5"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-1.5">
                                <small class="text-muted fw-semibold">المنتجات الفعلية</small>
                                <span class="badge bg-light text-muted border px-1.5 py-0.5 rounded" style="font-size: 0.62rem;" title="بدون المنتجات الافتراضية التجريبية">حقيقية</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-dark">{{ $supplierStats['total_products'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1.5 pt-2 border-top border-light-subtle">
                    <span class="badge bg-info-subtle text-info px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-circle-dot me-1"></i>{{ $supplierStats['active_products'] ?? 0 }} نشطة
                    </span>
                    <span class="badge bg-light text-dark border px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                        معدل: {{ $supplierStats['avg_products'] ?? 0 }} / مورد
                    </span>
                </div>
            </div>
        </div>

        <!-- 4. Orders Performance -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="d-flex align-items-center justify-content-center bg-dark bg-opacity-10 text-dark rounded-3 shadow-sm"
                            style="width: 46px; height: 46px;">
                            <i class="fa-solid fa-dolly fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold d-block">طلبات التوريد</small>
                            <h4 class="fw-bold mb-0 text-dark">{{ $supplierStats['total_orders'] ?? 0 }}</h4>
                        </div>
                    </div>
                    @if (($supplierStats['total_orders'] ?? 0) > 0)
                        <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-bold" style="font-size: 0.75rem;">
                            {{ $supplierStats['delivery_rate'] ?? 0 }}% تسليم
                        </span>
                    @endif
                </div>
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1.5 pt-2 border-top border-light-subtle">
                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-truck-fast me-1"></i>{{ $supplierStats['delivered_orders'] ?? 0 }} مسلّم
                    </span>
                    <span class="badge bg-warning-subtle text-dark px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-hourglass-half me-1"></i>{{ $supplierStats['pending_orders'] ?? 0 }} قيد التنفيذ
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3.5">
            <form action="{{ route('admin.suppliers') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-12 col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" name="search" id="searchInput" class="form-control bg-light border-0"
                            value="{{ request('search') }}"
                            placeholder="البحث بالاسم، الهاتف، اسم المتجر، أو البريد...">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <select class="form-select bg-light border-0" name="status" id="statusFilter">
                        <option value="">كل الحالات</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>نشط</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>غير نشط</option>
                        <option value="blocked" {{ request('status') == 'blocked' ? 'selected' : '' }}>محظور</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-4 d-flex align-items-center justify-content-between justify-content-md-end gap-2 flex-wrap">
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn text-white fw-bold px-3 py-2 rounded-3 shadow-sm"
                            style="background: linear-gradient(135deg, #a40c72 0%, #be0681 100%);">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> بحث
                        </button>
                        @if(request()->filled('search') || request()->filled('status'))
                            <a href="{{ route('admin.suppliers') }}" class="btn btn-light border px-3 py-2 rounded-3 shadow-sm text-muted"
                                title="إلغاء الفلترة وإعادة التعيين">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                        @endif
                    </div>
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-semibold">
                        النتائج: {{ $suppliers->total() }} مورد
                    </span>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white w-100 overflow-hidden mb-4" style="max-width: 100%;">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-table" style="color: #a40c72;"></i>
                <span>قائمة الموردين المسجلين</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm text-white fw-bold px-3 py-1.5 rounded-3 shadow-sm"
                    style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);"
                    data-bs-toggle="modal" data-bs-target="#bulkUpgradeSupplierPlanModal">
                    <i class="fa-solid fa-gem me-1"></i> ترقية جماعية للاشتراكات
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive p-0">
                <table class="table table-hover align-middle text-center mb-0" id="suppliersTable">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="py-3 text-center" style="width: 40px;">
                                <input type="checkbox" id="selectAllSuppliersCheckbox" class="form-check-input cursor-pointer" title="تحديد الكل">
                            </th>
                            <th class="py-3">#</th>
                            <th class="py-3">الاسم</th>
                            <th class="py-3">البريد</th>
                            <th class="py-3">الهاتف</th>
                            <th class="py-3">المتجر</th>
                            <th class="py-3">تاريخ آخر نشاط</th>
                            <th class="py-3">الحالة</th>
                            <th class="py-3">الباقة</th>
                            <th class="py-3">المنتجات</th>
                            <th class="py-3">التسجيل</th>
                            <th class="py-3">الطلبات</th>
                            <th class="py-3">الاشتراك</th>
                            <th class="py-3">الرصيد / المستحقات</th>
                            <th class="py-3">العمليات</th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        @forelse ($suppliers as $index => $supplier)
                            @php
                                $userData = $supplier->user ?? get_user_data($supplier->tenant_id);
                                $planData = $supplier->plan_subscription ? get_supplier_plan_data($supplier->plan_subscription->plan_id) : null;
                                $tenantId = $supplier->tenant?->id ?? $supplier->tenant_id;
                            @endphp
                            <tr>
                                <td data-label="تحديد" class="text-center">
                                    <input type="checkbox" name="selected_supplier_ids[]" value="{{ $supplier->id }}" class="form-check-input supplier-row-checkbox cursor-pointer">
                                </td>
                                <td data-label="#" class="fw-bold text-secondary">{{ $index + 1 }}</td>

                                <td data-label="الاسم" class="fw-bold text-dark text-start px-3">
                                    {{ $supplier->full_name }}
                                </td>

                                <td data-label="البريد">
                                    <span class="text-muted small dir-ltr d-inline-block">{{ $userData?->email ?? '—' }}</span>
                                </td>
                                <td data-label="الهاتف">
                                    <span class="text-muted small dir-ltr d-inline-block">{{ $userData?->phone ?? '—' }}</span>
                                </td>

                                <td data-label="المتجر">
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2.5 py-1 rounded-pill">
                                        <a href="{{ supplier_store_url($tenantId) }}" target="_blank"
                                            class="text-info text-decoration-none fw-bold">{{ get_supplier_store_name($tenantId) }}</a>
                                    </span>
                                </td>

                                <td data-label="تاريخ آخر نشاط" class="text-muted small">
                                    {{ $userData?->last_seen?->first()?->created_at?->diffForHumans() ?? 'لا يوجد نشاط' }}
                                </td>

                                <td data-label="الحالة">{!! get_supplier_status($tenantId) !!}</td>

                                <td data-label="الباقة">
                                    <span class="badge bg-light text-dark border px-2.5 py-1 rounded-3">
                                        {{ $planData?->name ?? '—' }}
                                    </span>
                                </td>

                                <td data-label="المنتجات">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1 rounded-pill fw-bold">
                                        {{ $supplier->products?->count() ?? 0 }}
                                    </span>
                                </td>

                                <td data-label="التسجيل" class="text-muted small">{{ $supplier->created_at?->format('d-m-Y') ?? '—' }}</td>

                                <td data-label="الطلبات">
                                    <span class="badge bg-dark px-2.5 py-1 rounded-pill fw-bold">
                                        {{ $supplier->orders?->count() ?? 0 }}
                                    </span>
                                </td>

                                <td data-label="الاشتراك"><span class="text-muted small">
                                        @if (($supplier->plan_subscription?->plan_id ?? 1) != 1)
                                            {{ $supplier->plan_subscription?->subscription_end_date ?? '—' }}
                                        @else
                                            مدى الحياة
                                        @endif
                                    </span></td>

                                <td data-label="الرصيد / المستحقات">
                                    <div class="d-flex flex-column gap-1 text-center">
                                        <!-- رصيد المورد -->
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill"
                                            title="رصيد المورد">
                                            <i class="fa-solid fa-wallet me-1"></i>
                                            <span class="dir-ltr d-inline-block fw-bold">{{ number_format($userData?->balance?->balance ?? 0, 2) }}</span> د.ج
                                        </span>
                                        <!-- مستحقات المنصة -->
                                        @php
                                            $outstanding = (float) ($userData?->balance?->outstanding_amount ?? 0);
                                        @endphp
                                        <span class="badge {{ $outstanding > 0 ? 'bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25' : 'bg-light text-muted border' }} px-2 py-1 rounded-pill"
                                            title="مستحقات المنصة">
                                            <i class="fa-solid fa-file-invoice-dollar me-1"></i>
                                            <span class="dir-ltr d-inline-block fw-bold">{{ number_format($outstanding, 2) }}</span> د.ج
                                        </span>
                                    </div>
                                </td>

                                <td data-label="العمليات">
                                    <div class="d-flex justify-content-center align-items-center gap-1 action-buttons flex-wrap">

                                        <!-- View -->
                                        <a href="{{ route('admin.supplier.show', $supplier->id) }}"
                                            class="btn btn-sm btn-light border action-btn view-btn rounded-3" data-bs-toggle="tooltip"
                                            title="عرض التفاصيل">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <!-- Activate -->
                                        <a href="#" class="btn btn-sm btn-light border action-btn active-btn rounded-3"
                                            data-bs-toggle="tooltip" title="تفعيل المورد">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </a>

                                        <!-- Delete -->
                                        <form method="POST"
                                            action="{{ route('admin.supplier.destroy', $userData?->id ?? $supplier->id) }}"
                                            onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-light border action-btn delete-btn rounded-3"
                                                data-bs-toggle="tooltip" title="حذف المورد">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="15" class="py-5 text-muted empty-cell text-center">
                                    <i class="fa-solid fa-store fs-2 mb-2 d-block opacity-50"></i>
                                    <span>لا يوجد موردين حالياً.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- ===== Pagination ===== -->
            <div class="card-footer bg-light py-3">
                <div class="d-flex justify-content-center justify-content-md-end overflow-auto">
                    {{ $suppliers->links('vendor.pagination.dashboard-pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Upgrade Supplier Plan Modal -->
<div class="modal fade" id="bulkUpgradeSupplierPlanModal" tabindex="-1" aria-labelledby="bulkUpgradeSupplierPlanModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0 px-4 pt-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3 text-white shadow-sm"
                        style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%); width: 48px; height: 48px;">
                        <i class="fa-solid fa-gem fs-4"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-1" id="bulkUpgradeSupplierPlanModalLabel">ترقية اشتراكات الموردين (جماعي / حسب تاريخ التسجيل)</h5>
                        <p class="text-muted small mb-0">ترقية باقات اشتراك متعددة للموردين حسب تاريخ التسجيل أو التحديد اليدوي</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="bulkUpgradeSupplierPlanForm" action="{{ route('admin.suppliers.bulk_upgrade_plan') }}" method="POST">
                @csrf
                <div class="modal-body px-4 py-3">
                    <div class="row g-3">
                        <!-- 1. Selection Mode -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-2 d-flex align-items-center gap-1.5">
                                <i class="fa-solid fa-filter text-primary"></i>
                                <span>نطاق وتحديد الموردين المستهدفين للترقية: <span class="text-danger">*</span></span>
                            </label>
                            <div class="row g-2">
                                <div class="col-md-6">
                                    <div class="form-check p-2.5 border rounded-3 bg-light d-flex align-items-center gap-2 cursor-pointer h-100">
                                        <input class="form-check-input ms-0 me-2" type="radio" name="selection_mode" id="supplierModeBefore" value="registered_before" checked onchange="toggleSupplierDateInputs()">
                                        <label class="form-check-label small fw-bold text-dark mb-0 cursor-pointer" for="supplierModeBefore">
                                            📅 سجلوا قبل تاريخ معين
                                            <span class="d-block text-muted fw-normal" style="font-size: 0.72rem;">(مثال: لتعويض المسجلين قبل الخلل التقني الأخير)</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check p-2.5 border rounded-3 bg-light d-flex align-items-center gap-2 cursor-pointer h-100">
                                        <input class="form-check-input ms-0 me-2" type="radio" name="selection_mode" id="supplierModeBetween" value="registered_between" onchange="toggleSupplierDateInputs()">
                                        <label class="form-check-label small fw-bold text-dark mb-0 cursor-pointer" for="supplierModeBetween">
                                            📅 سجلوا بين تاريخين محددين
                                            <span class="d-block text-muted fw-normal" style="font-size: 0.72rem;">(تحديد نطاق زمني من وإلى)</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check p-2.5 border rounded-3 bg-light d-flex align-items-center gap-2 cursor-pointer h-100">
                                        <input class="form-check-input ms-0 me-2" type="radio" name="selection_mode" id="supplierModeAfter" value="registered_after" onchange="toggleSupplierDateInputs()">
                                        <label class="form-check-label small fw-bold text-dark mb-0 cursor-pointer" for="supplierModeAfter">
                                            📅 سجلوا بعد تاريخ معين
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check p-2.5 border rounded-3 bg-light d-flex align-items-center gap-2 cursor-pointer h-100">
                                        <input class="form-check-input ms-0 me-2" type="radio" name="selection_mode" id="supplierModeSelected" value="selected_ids" onchange="toggleSupplierDateInputs()">
                                        <label class="form-check-label small fw-bold text-dark mb-0 cursor-pointer" for="supplierModeSelected">
                                            ☑️ المحددين في الجدول (<span id="selectedSuppliersCountBadge" class="text-primary fw-bold">0</span>)
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check p-2.5 border rounded-3 bg-light d-flex align-items-center gap-2 cursor-pointer h-100">
                                        <input class="form-check-input ms-0 me-2" type="radio" name="selection_mode" id="supplierModeAll" value="all" onchange="toggleSupplierDateInputs()">
                                        <label class="form-check-label small fw-bold text-dark mb-0 cursor-pointer" for="supplierModeAll">
                                            👥 جميع الموردين المسجلين
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- 2. Dynamic Date Filters -->
                        <div class="col-12" id="supplierDateContainer">
                            <!-- Before Date Input -->
                            <div id="supplierBeforeDateBox">
                                <label for="supplierBeforeDateInput" class="form-label fw-bold text-dark small mb-1">
                                    <i class="fa-solid fa-calendar-day text-danger me-1"></i> ترقية كل من سجل قبل تاريخ:
                                </label>
                                <input type="date" name="before_date" id="supplierBeforeDateInput" class="form-control rounded-3 py-2" value="{{ date('Y-m-d') }}">
                            </div>

                            <!-- After Date Input -->
                            <div id="supplierAfterDateBox" class="d-none">
                                <label for="supplierAfterDateInput" class="form-label fw-bold text-dark small mb-1">
                                    <i class="fa-solid fa-calendar-day text-success me-1"></i> ترقية كل من سجل بعد تاريخ:
                                </label>
                                <input type="date" name="after_date" id="supplierAfterDateInput" class="form-control rounded-3 py-2" value="{{ date('Y-m-d') }}">
                            </div>

                            <!-- Between Dates Inputs -->
                            <div id="supplierBetweenDatesBox" class="d-none">
                                <div class="row g-2">
                                    <div class="col-md-6">
                                        <label for="supplierFromDateInput" class="form-label fw-bold text-dark small mb-1">من تاريخ:</label>
                                        <input type="date" name="from_date" id="supplierFromDateInput" class="form-control rounded-3 py-2" value="{{ date('Y-m-d', strtotime('-30 days')) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label for="supplierToDateInput" class="form-label fw-bold text-dark small mb-1">إلى تاريخ:</label>
                                        <input type="date" name="to_date" id="supplierToDateInput" class="form-control rounded-3 py-2" value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Hidden Container for checked supplier IDs -->
                        <div id="supplierSelectedIdsContainer"></div>

                        <!-- 3. Target Status Filter -->
                        <div class="col-md-4">
                            <label for="supplierTargetStatus" class="form-label fw-bold text-dark small mb-1">
                                <i class="fa-solid fa-user-check text-muted me-1"></i> حالة المورد:
                            </label>
                            <select name="target_status" id="supplierTargetStatus" class="form-select rounded-3 py-2">
                                <option value="all" selected>جميع الحسابات (الكل)</option>
                                <option value="approved">الموثقون فقط (Approved)</option>
                                <option value="pending">قيد المراجعة فقط (Pending)</option>
                            </select>
                        </div>

                        <!-- 4. Target Plan -->
                        <div class="col-md-4">
                            <label for="bulkSupplierPlanSelect" class="form-label fw-bold text-dark small mb-1">
                                <i class="fa-solid fa-layer-group text-primary me-1"></i> الخطة المستهدفة: <span class="text-danger">*</span>
                            </label>
                            <select name="plan_id" id="bulkSupplierPlanSelect" class="form-select rounded-3 py-2" required>
                                @foreach($availablePlans as $plan)
                                    <option value="{{ $plan->id }}">{{ $plan->name }} ({{ number_format($plan->price, 2) }} د.ج)</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- 5. Duration Days -->
                        <div class="col-md-4">
                            <label for="bulkSupplierDurationDays" class="form-label fw-bold text-dark small mb-1">
                                <i class="fa-solid fa-clock text-primary me-1"></i> مدة الترقية (بالأيام): <span class="text-danger">*</span>
                            </label>
                            <input type="number" min="1" max="3650" name="duration_days" id="bulkSupplierDurationDays" class="form-control rounded-3 py-2" value="30" required>
                            <div class="d-flex gap-1 flex-wrap mt-1">
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-1.5 rounded-pill small" onclick="document.getElementById('bulkSupplierDurationDays').value = 30;">30 يوم</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-1.5 rounded-pill small" onclick="document.getElementById('bulkSupplierDurationDays').value = 90;">3 أشهر</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-1.5 rounded-pill small" onclick="document.getElementById('bulkSupplierDurationDays').value = 180;">6 أشهر</button>
                                <button type="button" class="btn btn-xs btn-outline-secondary py-0 px-1.5 rounded-pill small" onclick="document.getElementById('bulkSupplierDurationDays').value = 365;">سنة</button>
                            </div>
                        </div>

                        <!-- 6. Options: Extend Existing & Notify -->
                        <div class="col-12">
                            <div class="border rounded-3 p-3 bg-light">
                                <div class="form-check form-switch p-0 d-flex align-items-center gap-2 mb-2">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="extend_existing" id="bulkSupplierExtend" value="1" checked>
                                    <label class="form-check-label small fw-semibold text-dark cursor-pointer" for="bulkSupplierExtend">
                                        تمديد الاشتراكات النشطة (إضافة الأيام الجديدة بعد تاريخ الانتهاء الحالي للمشتركين الفعليين)
                                    </label>
                                </div>
                                <div class="form-check form-switch p-0 d-flex align-items-center gap-2">
                                    <input class="form-check-input ms-0 me-2" type="checkbox" name="notify_suppliers" id="bulkSupplierNotify" value="1" checked>
                                    <label class="form-check-label small fw-semibold text-dark cursor-pointer" for="bulkSupplierNotify">
                                        إرسال إشعار فوري لجميع الموردين المشمولين في لوحات تحكمهم
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- 7. Notes -->
                        <div class="col-12">
                            <label for="bulkSupplierUpgradeNotes" class="form-label fw-bold text-dark small mb-1">
                                سبب / ملاحظات الترقية (تظهر للمورد في الإشعار):
                            </label>
                            <textarea name="notes" id="bulkSupplierUpgradeNotes" class="form-control rounded-3" rows="2" placeholder="مثال: ترقية استثنائية لجميع الموردين المسجلين / تعويض عن أعمال صيانة وتطوير سحابي..."></textarea>
                        </div>

                        <!-- Confirmation Checkbox -->
                        <div class="col-12">
                            <div class="form-check p-3 bg-warning bg-opacity-10 rounded-3 border border-warning-subtle d-flex align-items-center gap-2">
                                <input class="form-check-input ms-0 me-2 mt-0" type="checkbox" id="bulkSupplierConfirmCheckbox" required>
                                <label class="form-check-label small fw-bold text-dark mb-0 cursor-pointer" for="bulkSupplierConfirmCheckbox">
                                    أؤكد رغبتي في تنفيذ هذه الترقية الجماعية لجميع الموردين المحددين بالمعايير أعلاه.
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light border-0 px-4 py-3 d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary rounded-3 px-4 fw-semibold" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" id="submitBulkSupplierUpgradeBtn" class="btn text-white fw-bold rounded-3 px-4 shadow-sm" style="background: linear-gradient(135deg, #7c3aed 0%, #6d28d9 100%);">
                        <i class="fa-solid fa-gem me-1"></i> تنفيذ الترقية الجماعية الآن
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(
        tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl)
    );

    // Toggle date input fields based on bulk selection mode for suppliers
    function toggleSupplierDateInputs() {
        const mode = document.querySelector('input[name="selection_mode"]:checked')?.value || 'registered_before';
        const beforeBox = document.getElementById('supplierBeforeDateBox');
        const afterBox = document.getElementById('supplierAfterDateBox');
        const betweenBox = document.getElementById('supplierBetweenDatesBox');

        if (beforeBox) beforeBox.classList.toggle('d-none', mode !== 'registered_before');
        if (afterBox) afterBox.classList.toggle('d-none', mode !== 'registered_after');
        if (betweenBox) betweenBox.classList.toggle('d-none', mode !== 'registered_between');
    }

    // Checkbox and Selection Management for suppliers
    document.addEventListener('DOMContentLoaded', function () {
        const selectAllCb = document.getElementById('selectAllSuppliersCheckbox');
        const rowCheckboxes = document.querySelectorAll('.supplier-row-checkbox');
        const countBadge = document.getElementById('selectedSuppliersCountBadge');
        const bulkForm = document.getElementById('bulkUpgradeSupplierPlanForm');

        function updateSelectedCount() {
            const checkedBoxes = document.querySelectorAll('.supplier-row-checkbox:checked');
            if (countBadge) {
                countBadge.textContent = checkedBoxes.length;
            }
            if (selectAllCb) {
                selectAllCb.checked = rowCheckboxes.length > 0 && checkedBoxes.length === rowCheckboxes.length;
                selectAllCb.indeterminate = checkedBoxes.length > 0 && checkedBoxes.length < rowCheckboxes.length;
            }
        }

        if (selectAllCb) {
            selectAllCb.addEventListener('change', function () {
                rowCheckboxes.forEach(cb => cb.checked = selectAllCb.checked);
                updateSelectedCount();
            });
        }

        rowCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateSelectedCount);
        });

        if (bulkForm) {
            bulkForm.addEventListener('submit', function (e) {
                const mode = document.querySelector('input[name="selection_mode"]:checked')?.value;
                const container = document.getElementById('supplierSelectedIdsContainer');
                if (container) container.innerHTML = '';

                if (mode === 'selected_ids') {
                    const checkedBoxes = document.querySelectorAll('.supplier-row-checkbox:checked');
                    if (checkedBoxes.length === 0) {
                        e.preventDefault();
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'تنبيه',
                                text: 'يرجى تحديد مورد واحد على الأقل من الجدول قبل المتابعة.',
                                confirmButtonColor: '#7c3aed',
                                confirmButtonText: 'حسناً'
                            });
                        } else {
                            alert('يرجى تحديد مورد واحد على الأقل من الجدول قبل المتابعة.');
                        }
                        return false;
                    }

                    checkedBoxes.forEach(cb => {
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'selected_ids[]';
                        input.value = cb.value;
                        container.appendChild(input);
                    });
                }

                const submitBtn = document.getElementById('submitBulkSupplierUpgradeBtn');
                if (submitBtn) {
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> جاري تنفيذ الترقية...';
                }
            });
        }
    });
</script>

<style>
    /* Table-responsive containment */
    .card-body .table-responsive {
        width: 100% !important;
        max-width: 100% !important;
        overflow-x: auto !important;
        -webkit-overflow-scrolling: touch;
    }

    /* Pagination wrap for all screen sizes */
    .pagination {
        flex-wrap: wrap !important;
        justify-content: center !important;
        margin-bottom: 0 !important;
        gap: 4px;
    }
    .pagination .page-item .page-link {
        font-size: 0.85rem;
        padding: 0.35rem 0.65rem;
        border-radius: 6px !important;
    }

    /* Table general styles for desktop (>= 992px) */
    @media (min-width: 992px) {
        #suppliersTable th,
        #suppliersTable td {
            white-space: nowrap;
            vertical-align: middle;
        }
    }

    /* Pure CSS Responsive Table for #suppliersTable */
    @media (max-width: 991.98px) {

        #suppliersTable,
        #suppliersTable tbody,
        #suppliersTable tr,
        #suppliersTable td {
            display: block;
            width: 100% !important;
            box-sizing: border-box;
        }

        #suppliersTable thead {
            display: none !important;
        }

        #suppliersTable tbody tr {
            background: #ffffff;
            border: 1px solid #e9ecef !important;
            border-radius: 14px;
            margin-bottom: 1.25rem;
            padding: 0.5rem 0.75rem;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
        }

        #suppliersTable tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.65rem 0.75rem;
            border: none !important;
            border-bottom: 1px dashed #e9ecef !important;
            white-space: normal !important;
            text-align: left;
        }

        #suppliersTable tbody td:last-child {
            border-bottom: none !important;
        }

        #suppliersTable tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            color: #495057;
            font-size: 0.85rem;
            margin-left: 1rem;
            flex-shrink: 0;
            text-align: right;
        }

        /* Empty state row on mobile */
        #suppliersTable tbody td.empty-cell,
        #suppliersTable tbody td[colspan] {
            display: block !important;
            text-align: center !important;
            border: none !important;
            padding: 2.5rem 1rem !important;
        }

        #suppliersTable tbody td.empty-cell::before,
        #suppliersTable tbody td[colspan]::before {
            display: none !important;
        }
    }

    .action-buttons .action-btn {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .25s ease;
        font-size: 13px;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
    }

    .action-buttons .action-btn i {
        transition: all .25s ease;
    }

    /* View */
    .view-btn {
        color: #0d6efd;
    }

    .view-btn:hover {
        background: #0d6efd;
        color: #fff;
        transform: translateY(-2px);
    }

    /* Activate */
    .active-btn {
        color: #198754;
    }

    .active-btn:hover {
        background: #198754;
        color: #fff;
        transform: translateY(-2px);
    }

    /* Delete */
    .delete-btn {
        color: #dc3545;
    }

    .delete-btn:hover {
        background: #dc3545;
        color: #fff;
        transform: translateY(-2px);
    }
</style>
