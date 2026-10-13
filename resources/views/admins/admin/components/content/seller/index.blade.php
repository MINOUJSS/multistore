<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm"
        style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-store text-warning"></i>
                    <span>{{ __('إدارة التجار والمتاجر الإلكترونية') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    🏪 إدارة وحصر البائعين 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    متابعة حسابات البائعين، الباقات المفعلة، المتاجر الفرعية، وإحصائيات المنتجات والطلبات بالمنصة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.dashboard') }}"
                        class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm text-nowrap">
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
                            <small class="text-muted fw-semibold d-block">إجمالي البائعين</small>
                            <h4 class="fw-bold mb-0 text-dark">{{ $sellerStats['total'] ?? $sellers->total() }}</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-1.5 pt-2 border-top border-light-subtle">
                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-circle-check me-1"></i>{{ $sellerStats['approved'] ?? 0 }} معتمد
                    </span>
                    <span class="badge bg-warning-subtle text-dark px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-clock me-1"></i>{{ $sellerStats['pending'] ?? 0 }} مراجعة
                    </span>
                    @if (($sellerStats['inactive'] ?? 0) > 0)
                        <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                            <i class="fa-solid fa-ban me-1"></i>{{ $sellerStats['inactive'] }} معطل
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- 2. Active Sellers via last_seens -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-3 shadow-sm"
                            style="width: 46px; height: 46px;">
                            <i class="fa-solid fa-user-check fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold d-block">بائعون نشطون</small>
                            <div class="d-flex align-items-baseline gap-1">
                                <h4 class="fw-bold mb-0 text-dark">{{ $sellerStats['active'] ?? 0 }}</h4>
                                <small class="text-muted fw-normal" style="font-size: 0.8rem;">/ {{ $sellerStats['total'] ?? 0 }}</small>
                            </div>
                        </div>
                    </div>
                    <span class="badge {{ ($sellerStats['activity_percentage'] ?? 0) >= 70 ? 'bg-success' : (($sellerStats['activity_percentage'] ?? 0) >= 40 ? 'bg-warning text-dark' : 'bg-secondary') }} px-2 py-1 rounded-pill fw-bold" style="font-size: 0.75rem;">
                        {{ $sellerStats['activity_percentage'] ?? 0 }}%
                    </span>
                </div>
                <div class="pt-2 border-top border-light-subtle">
                    <div class="progress rounded-pill mb-1.5" style="height: 5px; background-color: rgba(16, 185, 129, 0.1);">
                        <div class="progress-bar bg-success rounded-pill" role="progressbar"
                            style="width: {{ $sellerStats['activity_percentage'] ?? 0 }}%;"
                            aria-valuenow="{{ $sellerStats['activity_percentage'] ?? 0 }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <div class="d-flex justify-content-between text-muted" style="font-size: 0.72rem;">
                        <span><i class="fa-regular fa-clock me-1"></i>آخر {{ $sellerStats['period_days'] ?? 30 }} يوم</span>
                        <span>خامل: <strong>{{ $sellerStats['inactive_activity'] ?? 0 }}</strong></span>
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
                            <i class="fa-solid fa-box-open fs-5"></i>
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-1.5">
                                <small class="text-muted fw-semibold">المنتجات الفعلية</small>
                                <span class="badge bg-light text-muted border px-1.5 py-0.5 rounded" style="font-size: 0.62rem;" title="بدون المنتجات الافتراضية التجريبية">حقيقية</span>
                            </div>
                            <h4 class="fw-bold mb-0 text-dark">{{ $sellerStats['total_products'] ?? 0 }}</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1.5 pt-2 border-top border-light-subtle">
                    <span class="badge bg-info-subtle text-info px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-circle-dot me-1"></i>{{ $sellerStats['active_products'] ?? 0 }} نشطة
                    </span>
                    <span class="badge bg-light text-dark border px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                        معدل: {{ $sellerStats['avg_products'] ?? 0 }} / بائع
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
                            <i class="fa-solid fa-cart-shopping fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold d-block">طلبات البائعين</small>
                            <h4 class="fw-bold mb-0 text-dark">{{ $sellerStats['total_orders'] ?? 0 }}</h4>
                        </div>
                    </div>
                    @if (($sellerStats['total_orders'] ?? 0) > 0)
                        <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-bold" style="font-size: 0.75rem;">
                            {{ $sellerStats['delivery_rate'] ?? 0 }}% تسليم
                        </span>
                    @endif
                </div>
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-1.5 pt-2 border-top border-light-subtle">
                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-truck-fast me-1"></i>{{ $sellerStats['delivered_orders'] ?? 0 }} مسلّم
                    </span>
                    <span class="badge bg-warning-subtle text-dark px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-hourglass-half me-1"></i>{{ $sellerStats['pending_orders'] ?? 0 }} قيد التنفيذ
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3.5">
            <form action="{{ route('admin.sellers') }}" method="GET" class="row g-3 align-items-center">
                <div class="col-12 col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted"><i
                                class="fa-solid fa-magnifying-glass"></i></span>
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
                            <a href="{{ route('admin.sellers') }}" class="btn btn-light border px-3 py-2 rounded-3 shadow-sm text-muted"
                                title="إلغاء الفلترة وإعادة التعيين">
                                <i class="fa-solid fa-rotate-left"></i>
                            </a>
                        @endif
                    </div>
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-semibold">
                        النتائج: {{ $sellers->total() }} بائع
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
                <span>قائمة البائعين المسجلين</span>
            </div>
            <div class="d-flex align-items-center gap-2 flex-wrap">
                <button type="button" class="btn text-white btn-sm fw-bold px-3 py-1.5 rounded-3 shadow-sm d-flex align-items-center gap-2"
                    style="background: linear-gradient(135deg, #a40c72 0%, #be0681 100%);"
                    data-bs-toggle="modal" data-bs-target="#bulkAddServicesModal"
                    title="إضافة رصيد شارجلي، التحويل البنكي، والطلبات المجانية لجميع البائعين دفعة واحدة">
                    <i class="fa-solid fa-gift"></i>
                    <span>شحن خدمات وطلبات لجميع البائعين</span>
                </button>

                <button type="button" class="btn btn-outline-danger btn-sm fw-bold px-3 py-1.5 rounded-3 shadow-sm d-flex align-items-center gap-2"
                    data-bs-toggle="modal" data-bs-target="#cleanOfflineTempModal"
                    title="حذف الملفات المؤقتة للبائعين غير المتصلين (منذ أكثر من ساعة)">
                    <i class="fa-solid fa-broom text-danger"></i>
                    <span>تنظيف مؤقتات الغائبين (> ساعة)</span>
                    <span class="badge {{ ($offlineTempStats['total_files'] ?? 0) > 0 ? 'bg-danger text-white' : 'bg-secondary bg-opacity-25 text-muted' }} rounded-pill px-2 py-0.5 fw-bold ms-1" style="font-size: 0.72rem;">
                        <i class="fa-solid fa-file-circle-xmark me-1"></i>{{ $offlineTempStats['total_files'] ?? 0 }} ملف ({{ $offlineTempStats['formatted_size'] ?? '0 B' }})
                    </span>
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive p-0">
                <table class="table table-hover align-middle text-center mb-0" id="sellersTable">
                    <thead class="bg-light text-muted small">
                        <tr>
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
                        @forelse ($sellers as $index => $seller)
                            @php
                                $userData = $seller->user ?? get_user_data($seller->tenant_id);
                                $planData = $seller->plan_subscription ? get_seller_plan_data($seller->plan_subscription->plan_id) : null;
                                $tenantId = $seller->tenant?->id ?? $seller->tenant_id;
                            @endphp
                            <tr>
                                <td data-label="#" class="fw-bold text-secondary">{{ $index + 1 }}</td>

                                <td data-label="الاسم" class="fw-bold text-dark text-start px-3">
                                    {{ $seller->full_name }}
                                </td>

                                <td data-label="البريد">
                                    <span class="text-muted small dir-ltr d-inline-block">{{ $userData?->email ?? '—' }}</span>
                                </td>
                                <td data-label="الهاتف">
                                    <span class="text-muted small dir-ltr d-inline-block">{{ $userData?->phone ?? '—' }}</span>
                                </td>

                                <td data-label="المتجر">
                                    <span
                                        class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2.5 py-1 rounded-pill">
                                        <a href="{{ seller_store_url($tenantId) }}" target="_blank"
                                            class="text-info text-decoration-none fw-bold">{{ get_seller_store_name($tenantId) }}</a>
                                    </span>
                                </td>

                                <td data-label="تاريخ آخر نشاط" class="text-muted small">
                                    {{ $userData?->last_seen?->first()?->created_at?->diffForHumans() ?? 'لا يوجد نشاط' }}
                                </td>

                                <td data-label="الحالة">{!! get_seller_status($tenantId) !!}</td>

                                <td data-label="الباقة">
                                    <span class="badge bg-light text-dark border px-2.5 py-1 rounded-3">
                                        {{ $planData?->name ?? '—' }}
                                    </span>
                                </td>

                                <td data-label="المنتجات">
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1 rounded-pill fw-bold">
                                        {{ $seller->products?->count() ?? 0 }}
                                    </span>
                                </td>

                                <td data-label="التسجيل" class="text-muted small">
                                    {{ $seller->created_at?->format('d-m-Y') ?? '—' }}</td>

                                <td data-label="الطلبات">
                                    <span class="badge bg-dark px-2.5 py-1 rounded-pill fw-bold">
                                        {{ $seller->orders?->count() ?? 0 }}
                                    </span>
                                </td>

                                <td data-label="الاشتراك"><span class="text-muted small">
                                        @if (($seller->plan_subscription?->plan_id ?? 1) != 1)
                                            {{ $seller->plan_subscription?->subscription_end_date ?? '—' }}
                                        @else
                                            مدى الحياة
                                        @endif
                                    </span></td>

                                <td data-label="الرصيد / المستحقات">
                                    <div class="d-flex flex-column gap-1 text-center">
                                        <!-- رصيد البائع -->
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-1 rounded-pill"
                                            title="رصيد البائع">
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
                                    <div
                                        class="d-flex justify-content-center align-items-center gap-1 action-buttons">

                                        <!-- View -->
                                        <a href="{{ route('admin.seller.show', $seller->id) }}"
                                            class="btn btn-sm btn-light border action-btn view-btn rounded-3"
                                            data-bs-toggle="tooltip" title="عرض التفاصيل">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>

                                        <!-- Activate -->
                                        <a href="#"
                                            class="btn btn-sm btn-light border action-btn active-btn rounded-3"
                                            data-bs-toggle="tooltip" title="تفعيل البائع">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </a>

                                        <!-- Clean Temp (if offline > 1 hour) -->
                                        @php
                                            $lastSeenRec = $userData?->last_seen?->first();
                                            $isSellerOffline = !$lastSeenRec || $lastSeenRec->last_seen_at < now()->subHour();
                                        @endphp
                                        @if($isSellerOffline)
                                            <form method="POST"
                                                action="{{ route('admin.seller.clean_temp', $seller->id) }}"
                                                onsubmit="return confirm('تأكيد تنظيف مجلد الملفات المؤقتة (temp) لمتجر {{ $seller->store_name }}؟ (البائع غير متصل)')">
                                                @csrf
                                                <button type="submit"
                                                    class="btn btn-sm btn-light border text-warning action-btn clean-temp-btn rounded-3"
                                                    data-bs-toggle="tooltip" title="تنظيف مجلد temp (البائع غير متصل)">
                                                    <i class="fa-solid fa-broom"></i>
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Delete -->
                                        <form method="POST"
                                            action="{{ route('admin.seller.destroy', $userData?->id ?? $seller->id) }}"
                                            onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-light border action-btn delete-btn rounded-3"
                                                data-bs-toggle="tooltip" title="حذف البائع">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="14" class="py-5 text-muted empty-cell text-center">
                                    <i class="fa-solid fa-store fs-2 mb-2 d-block opacity-50"></i>
                                    <span>لا يوجد بائعين حالياً.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- ===== Pagination ===== -->
            <div class="card-footer bg-light py-3">
                <div class="d-flex justify-content-center justify-content-md-end overflow-auto">
                    {{ $sellers->links('vendor.pagination.dashboard-pagination') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Clean Offline Temp Modal -->
    <div class="modal fade" id="cleanOfflineTempModal" tabindex="-1" aria-labelledby="cleanOfflineTempModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 shadow">
                <div class="modal-header border-0 pb-0">
                    <h5 class="modal-title fw-bold text-dark d-flex align-items-center gap-2" id="cleanOfflineTempModalLabel">
                        <span class="d-inline-flex align-items-center justify-content-center bg-danger-subtle text-danger rounded-circle" style="width: 38px; height: 38px;">
                            <i class="fa-solid fa-broom"></i>
                        </span>
                        <span>تنظيف الملفات المؤقتة للبائعين غير المتصلين</span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.sellers.clean_offline_temp') }}" method="POST">
                    @csrf
                    <div class="modal-body py-3">
                        <div class="alert alert-warning border-0 rounded-3 mb-3 small d-flex align-items-start gap-2">
                            <i class="fa-solid fa-triangle-exclamation text-warning fs-5 mt-0.5"></i>
                            <div>
                                <strong>معيار التنظيف:</strong> سيتم فحص مجلدات <code>/temp</code> لكافة البائعين الذين لم يسجلوا أي نشاط منذ <strong>أكثر من ساعة</strong> وحذف محتوياتها المؤقتة وتفريغ المساحة بأمان.
                            </div>
                        </div>

                        <!-- Statistics Box for Offline Temp Files -->
                        <div class="row g-2 mb-3 text-center">
                            <div class="col-4">
                                <div class="p-2 rounded-3 border bg-light">
                                    <div class="text-muted small mb-1" style="font-size: 0.75rem;">الملفات القابلة للحذف</div>
                                    <div class="fw-bold fs-6 text-danger">
                                        <i class="fa-solid fa-file-excel me-1"></i>{{ $offlineTempStats['total_files'] ?? 0 }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 rounded-3 border bg-light">
                                    <div class="text-muted small mb-1" style="font-size: 0.75rem;">المساحة المسترجعة</div>
                                    <div class="fw-bold fs-6 text-success">
                                        <i class="fa-solid fa-hard-drive me-1"></i>{{ $offlineTempStats['formatted_size'] ?? '0 B' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="p-2 rounded-3 border bg-light">
                                    <div class="text-muted small mb-1" style="font-size: 0.75rem;">المتاجر المعنية</div>
                                    <div class="fw-bold fs-6 text-primary">
                                        <i class="fa-solid fa-store me-1"></i>{{ $offlineTempStats['offline_sellers_with_temp_count'] ?? 0 }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <ul class="text-muted small ps-3 mb-0">
                            <li>يستهدف هذا الإجراء فقط الملفات غير المكتملة داخل مجلدات <code>storage/app/public/seller/*/temp</code>.</li>
                            <li>لا يؤثر إطلاقاً على المنتجات المنشورة أو الصور الأساسية أو إثباتات الدفع.</li>
                            <li>يتم استثناء أي بائع متصل أو كان نشطاً خلال الساعة الأخيرة لحماية عملياته الجارية.</li>
                        </ul>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="button" class="btn btn-light rounded-3 px-3 fw-semibold" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-danger rounded-3 px-4 fw-bold shadow-sm">
                            <i class="fa-solid fa-trash-can me-1"></i> تأكيد تنظيف الملفات المؤقتة
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bulk Add Services and Free Orders Modal -->
    <div class="modal fade" id="bulkAddServicesModal" tabindex="-1" aria-labelledby="bulkAddServicesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                <!-- Header -->
                <div class="modal-header text-white border-0 py-3 px-4 position-relative"
                    style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 100%);">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="p-2 bg-white bg-opacity-20 rounded-3 text-white">
                            <i class="fa-solid fa-gift fs-5"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-bold mb-0" id="bulkAddServicesModalLabel">شحن خدمات ورصيد جماعي للبائعين</h5>
                            <small class="text-white-50">إضافة طلبات شارجلي، التحويل البنكي، والطلبات المجانية دفعة واحدة بضغطة زر</small>
                        </div>
                    </div>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form id="bulkAddServicesForm" onsubmit="event.preventDefault(); executeBulkAddServicesAndOrders();">
                    @csrf
                    <div class="modal-body p-4 bg-light bg-opacity-50">
                        <!-- Target Audience Card -->
                        <div class="card border-0 shadow-sm rounded-3 mb-3 bg-white">
                            <div class="card-body p-3">
                                <label for="bulkTargetAudience" class="form-label fw-bold text-dark small mb-1.5 d-flex align-items-center gap-1.5">
                                    <i class="fa-solid fa-users text-primary"></i>
                                    <span>فئة البائعين المستهدفين للشحن:</span>
                                </label>
                                <select name="target_audience" id="bulkTargetAudience" class="form-select rounded-3 border-light-subtle bg-light">
                                    <option value="all" selected>
                                        جميع البائعين المسجلين في المنصة ({{ $sellerStats['total'] ?? $sellers->total() }} بائع)
                                    </option>
                                    <option value="approved">
                                        البائعين المعتمدين فقط ({{ $sellerStats['approved'] ?? 0 }} بائع)
                                    </option>
                                    <option value="active">
                                        البائعين النشطين فقط
                                    </option>
                                </select>
                                <small class="text-muted d-block mt-1" style="font-size: 0.76rem;">
                                    <i class="fa-solid fa-circle-info me-1"></i> سيتم تطبيق الإضافة تلقائياً على كل بائع يندرج تحت الفئة المحددة أعلاه.
                                </small>
                            </div>
                        </div>

                        <!-- 3 Quota Input Cards -->
                        <div class="row g-3">
                            <!-- 1. Chargily Pay Orders Quota -->
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100 bg-white shadow-sm">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <label for="bulkInputChargilyOrders" class="form-label fw-bold text-dark small mb-0 d-flex align-items-center gap-1.5">
                                            <i class="fa-solid fa-credit-card text-info"></i>
                                            <span>طلبات دفع شارجلي (CIB / الذهبية)</span>
                                        </label>
                                        <span class="badge bg-info-subtle text-info border border-info-subtle rounded-pill px-2 py-0.5 small">
                                            + شحن رصيد
                                        </span>
                                    </div>
                                    <div class="input-group mb-2">
                                        <input type="number" min="0" step="1" name="chargily_orders" id="bulkInputChargilyOrders"
                                            class="form-control rounded-start-3" value="0" placeholder="عدد الطلبات...">
                                        <span class="input-group-text bg-light text-muted small rounded-end-3">طلب</span>
                                    </div>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <span class="text-muted small me-1" style="font-size: 0.75rem;">إضافة سريعة:</span>
                                        <button type="button" class="btn btn-xs btn-outline-info py-0 px-2 rounded-pill small" onclick="setBulkQuotaValue('bulkInputChargilyOrders', 5)">+5</button>
                                        <button type="button" class="btn btn-xs btn-outline-info py-0 px-2 rounded-pill small" onclick="setBulkQuotaValue('bulkInputChargilyOrders', 10)">+10</button>
                                        <button type="button" class="btn btn-xs btn-outline-info py-0 px-2 rounded-pill small" onclick="setBulkQuotaValue('bulkInputChargilyOrders', 25)">+25</button>
                                        <button type="button" class="btn btn-xs btn-outline-info py-0 px-2 rounded-pill small" onclick="setBulkQuotaValue('bulkInputChargilyOrders', 50)">+50</button>
                                    </div>
                                </div>
                            </div>

                            <!-- 2. Bank Transfer Orders Quota -->
                            <div class="col-md-6">
                                <div class="border rounded-3 p-3 h-100 bg-white shadow-sm">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <label for="bulkInputBankOrders" class="form-label fw-bold text-dark small mb-0 d-flex align-items-center gap-1.5">
                                            <i class="fa-solid fa-building-columns text-primary"></i>
                                            <span>طلبات التحويل البنكي (CCP / بريدي موب)</span>
                                        </label>
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-2 py-0.5 small">
                                            + شحن رصيد
                                        </span>
                                    </div>
                                    <div class="input-group mb-2">
                                        <input type="number" min="0" step="1" name="bank_transfer_orders" id="bulkInputBankOrders"
                                            class="form-control rounded-start-3" value="0" placeholder="عدد الطلبات...">
                                        <span class="input-group-text bg-light text-muted small rounded-end-3">طلب</span>
                                    </div>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <span class="text-muted small me-1" style="font-size: 0.75rem;">إضافة سريعة:</span>
                                        <button type="button" class="btn btn-xs btn-outline-primary py-0 px-2 rounded-pill small" onclick="setBulkQuotaValue('bulkInputBankOrders', 3)">+3</button>
                                        <button type="button" class="btn btn-xs btn-outline-primary py-0 px-2 rounded-pill small" onclick="setBulkQuotaValue('bulkInputBankOrders', 6)">+6</button>
                                        <button type="button" class="btn btn-xs btn-outline-primary py-0 px-2 rounded-pill small" onclick="setBulkQuotaValue('bulkInputBankOrders', 15)">+15</button>
                                        <button type="button" class="btn btn-xs btn-outline-primary py-0 px-2 rounded-pill small" onclick="setBulkQuotaValue('bulkInputBankOrders', 30)">+30</button>
                                    </div>
                                </div>
                            </div>

                            <!-- 3. Free Store Orders -->
                            <div class="col-12">
                                <div class="border rounded-3 p-3 bg-white shadow-sm">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <label for="bulkInputFreeOrders" class="form-label fw-bold text-dark small mb-0 d-flex align-items-center gap-1.5">
                                            <i class="fa-solid fa-box-open text-success"></i>
                                            <span>طلبات المتجر المجانية (User Free Orders)</span>
                                        </label>
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2 py-0.5 small">
                                            + زيادة الرصيد
                                        </span>
                                    </div>
                                    <div class="input-group mb-2">
                                        <input type="number" min="0" step="1" name="free_orders" id="bulkInputFreeOrders"
                                            class="form-control rounded-start-3" value="0" placeholder="عدد الطلبات المجانية...">
                                        <span class="input-group-text bg-light text-muted small rounded-end-3">طلب متجر</span>
                                    </div>
                                    <div class="d-flex gap-1 flex-wrap">
                                        <span class="text-muted small me-1" style="font-size: 0.75rem;">إضافة سريعة:</span>
                                        <button type="button" class="btn btn-xs btn-outline-success py-0 px-2 rounded-pill small" onclick="setBulkQuotaValue('bulkInputFreeOrders', 10)">+10</button>
                                        <button type="button" class="btn btn-xs btn-outline-success py-0 px-2 rounded-pill small" onclick="setBulkQuotaValue('bulkInputFreeOrders', 50)">+50</button>
                                        <button type="button" class="btn btn-xs btn-outline-success py-0 px-2 rounded-pill small" onclick="setBulkQuotaValue('bulkInputFreeOrders', 100)">+100</button>
                                        <button type="button" class="btn btn-xs btn-outline-success py-0 px-2 rounded-pill small" onclick="setBulkQuotaValue('bulkInputFreeOrders', 200)">+200</button>
                                    </div>
                                </div>
                            </div>

                            <!-- 4. Administrative Notes -->
                            <div class="col-12">
                                <div class="bg-white p-3 rounded-3 border shadow-sm">
                                    <label for="bulkInputQuotaNotes" class="form-label fw-bold text-dark small mb-1">
                                        ملاحظات / سبب الشحن الجماعي <span class="text-muted fw-normal">(اختياري للتوثيق الإداري)</span>
                                    </label>
                                    <textarea name="notes" id="bulkInputQuotaNotes" class="form-control rounded-3" rows="2"
                                        placeholder="اكتب ملاحظة أو مناسبة الشحن (مثال: هدية افتتاحية، ترقية ترويجية لجميع البائعين...)..."></textarea>
                                </div>
                            </div>

                            <!-- Confirmation Checkbox -->
                            <div class="col-12">
                                <div class="form-check p-3 bg-warning bg-opacity-10 rounded-3 border border-warning-subtle d-flex align-items-center gap-2">
                                    <input class="form-check-input ms-0 me-2 mt-0" type="checkbox" id="bulkConfirmCheckbox" required>
                                    <label class="form-check-label small fw-bold text-dark mb-0 cursor-pointer" for="bulkConfirmCheckbox">
                                        أؤكد رغبتي في شحن الرصيد والخدمات المحددة أعلاه لجميع البائعين المستهدفين بضغطة زر واحدة.
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div id="bulkAddServicesErrorAlert" class="alert alert-danger d-none mt-3 mb-0 py-2 small"></div>
                    </div>

                    <div class="modal-footer bg-light border-0 px-4 py-3 d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary rounded-3 px-4 fw-semibold" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" id="submitBulkAddServicesBtn" class="btn text-white fw-bold rounded-3 px-4 shadow-sm"
                            style="background: linear-gradient(135deg, #a40c72 0%, #be0681 100%);">
                            <i class="fa-solid fa-bolt me-1"></i> تنفيذ الشحن الجماعي الآن
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(
        tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl)
    );

    function setBulkQuotaValue(elementId, value) {
        const input = document.getElementById(elementId);
        if (input) {
            const current = parseInt(input.value) || 0;
            input.value = current + value;
        }
    }

    function executeBulkAddServicesAndOrders() {
        const btn = document.getElementById('submitBulkAddServicesBtn');
        const errorAlert = document.getElementById('bulkAddServicesErrorAlert');
        const chargilyOrders = parseInt(document.getElementById('bulkInputChargilyOrders').value) || 0;
        const bankOrders = parseInt(document.getElementById('bulkInputBankOrders').value) || 0;
        const freeOrders = parseInt(document.getElementById('bulkInputFreeOrders').value) || 0;
        const targetAudience = document.getElementById('bulkTargetAudience').value;
        const notes = document.getElementById('bulkInputQuotaNotes').value.trim();
        const confirmCheck = document.getElementById('bulkConfirmCheckbox');

        if (errorAlert) {
            errorAlert.classList.add('d-none');
            errorAlert.innerText = '';
        }

        if (!confirmCheck.checked) {
            if (errorAlert) {
                errorAlert.innerText = 'يرجى وضع علامة التأكيد في المربع للمتابعة.';
                errorAlert.classList.remove('d-none');
            }
            return;
        }

        if (chargilyOrders <= 0 && bankOrders <= 0 && freeOrders <= 0) {
            if (errorAlert) {
                errorAlert.innerText = 'يرجى إدخال كمية أكبر من 0 لخدمة واحدة على الأقل قبل المتابعة.';
                errorAlert.classList.remove('d-none');
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'تنبيه',
                    text: 'يرجى إدخال كمية أكبر من 0 لخدمة واحدة على الأقل.',
                    confirmButtonColor: '#a40c72',
                    confirmButtonText: 'حسناً'
                });
            }
            return;
        }

        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> جاري الشحن والمعالجة الجماعية...';

        fetch('{{ route('admin.sellers.bulk_add_services_orders') }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                chargily_orders: chargilyOrders,
                bank_transfer_orders: bankOrders,
                free_orders: freeOrders,
                target_audience: targetAudience,
                notes: notes
            })
        })
        .then(response => response.json().then(data => ({
            status: response.status,
            body: data
        })))
        .then(res => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-bolt me-1"></i> تنفيذ الشحن الجماعي الآن';

            if (res.body.success) {
                const modalEl = document.getElementById('bulkAddServicesModal');
                const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                modal.hide();

                Swal.fire({
                    icon: 'success',
                    title: 'تم الشحن الجماعي بنجاح',
                    text: res.body.message || 'تم شحن الخدمات والطلبات لجميع البائعين بنجاح.',
                    confirmButtonColor: '#a40c72',
                    confirmButtonText: 'ممتاز'
                }).then(() => {
                    window.location.reload();
                });
            } else {
                if (errorAlert) {
                    errorAlert.innerText = res.body.message || 'حدث خطأ أثناء الشحن الجماعي.';
                    errorAlert.classList.remove('d-none');
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ',
                        text: res.body.message || 'حدث خطأ أثناء الشحن الجماعي.',
                        confirmButtonColor: '#dc3545',
                        confirmButtonText: 'حسناً'
                    });
                }
            }
        })
        .catch(err => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-bolt me-1"></i> تنفيذ الشحن الجماعي الآن';
            if (errorAlert) {
                errorAlert.innerText = 'حدث خطأ في الاتصال بالسيرفر أثناء الشحن الجماعي.';
                errorAlert.classList.remove('d-none');
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ في الاتصال',
                    text: 'حدث خطأ في الاتصال بالسيرفر، يرجى إعادة المحاولة.',
                    confirmButtonColor: '#dc3545',
                    confirmButtonText: 'حسناً'
                });
            }
        });
    }
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
        #sellersTable th,
        #sellersTable td {
            white-space: nowrap;
            vertical-align: middle;
        }
    }

    /* Pure CSS Responsive Table for #sellersTable (< 992px) */
    @media (max-width: 991.98px) {

        #sellersTable,
        #sellersTable tbody,
        #sellersTable tr,
        #sellersTable td {
            display: block;
            width: 100% !important;
            box-sizing: border-box;
        }

        #sellersTable thead {
            display: none !important;
        }

        #sellersTable tbody tr {
            background: #ffffff;
            border: 1px solid #e9ecef !important;
            border-radius: 14px;
            margin-bottom: 1.25rem;
            padding: 0.5rem 0.75rem;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        #sellersTable tbody tr:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.06);
        }

        #sellersTable tbody td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.65rem 0.75rem;
            border: none !important;
            border-bottom: 1px dashed #e9ecef !important;
            white-space: normal !important;
            text-align: left;
        }

        #sellersTable tbody td:last-child {
            border-bottom: none !important;
        }

        #sellersTable tbody td::before {
            content: attr(data-label);
            font-weight: 700;
            color: #495057;
            font-size: 0.85rem;
            margin-left: 1rem;
            flex-shrink: 0;
            text-align: right;
        }

        /* Empty state row on mobile */
        #sellersTable tbody td.empty-cell,
        #sellersTable tbody td[colspan] {
            display: block !important;
            text-align: center !important;
            border: none !important;
            padding: 2.5rem 1rem !important;
        }

        #sellersTable tbody td.empty-cell::before,
        #sellersTable tbody td[colspan]::before {
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

    /* Clean Temp */
    .clean-temp-btn {
        color: #ffc107;
    }

    .clean-temp-btn:hover {
        background: #dc3545;
        color: #fff !important;
        border-color: #dc3545 !important;
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
