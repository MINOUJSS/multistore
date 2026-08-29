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
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3 p-3 text-white shadow-sm"
                        style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 100%); width: 54px; height: 54px;">
                        <i class="fa-solid fa-users fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-semibold d-block mb-1">إجمالي البائعين</small>
                        <h4 class="fw-bold mb-0 text-dark">{{ $sellers->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center bg-success bg-opacity-10 text-success rounded-3 p-3 shadow-sm"
                        style="width: 54px; height: 54px;">
                        <i class="fa-solid fa-circle-check fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-semibold d-block mb-1">بائعون نشطون</small>
                        <h4 class="fw-bold mb-0 text-dark">—</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center bg-info bg-opacity-10 text-info rounded-3 p-3 shadow-sm"
                        style="width: 54px; height: 54px;">
                        <i class="fa-solid fa-box fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-semibold d-block mb-1">المنتجات المسجلة</small>
                        <h4 class="fw-bold mb-0 text-dark">—</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center bg-dark bg-opacity-10 text-dark rounded-3 p-3 shadow-sm"
                        style="width: 54px; height: 54px;">
                        <i class="fa-solid fa-cart-shopping fs-4"></i>
                    </div>
                    <div>
                        <small class="text-muted fw-semibold d-block mb-1">طلبات البائعين</small>
                        <h4 class="fw-bold mb-0 text-dark">—</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-body p-3.5">
            <div class="row g-3 align-items-center">
                <div class="col-12 col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0 text-muted"><i
                                class="fa-solid fa-magnifying-glass"></i></span>
                        <input type="text" id="searchInput" class="form-control bg-light border-0"
                            placeholder="البحث بالاسم أو البريد أو الهاتف...">
                    </div>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <select class="form-select bg-light border-0">
                        <option value="">كل الحالات</option>
                        <option value="active">نشط</option>
                        <option value="inactive">غير نشط</option>
                        <option value="blocked">محظور</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-3 text-sm-end">
                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-semibold">
                        إجمالي القائمة: {{ $sellers->count() }} بائع
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white w-100 overflow-hidden mb-4" style="max-width: 100%;">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-table" style="color: #a40c72;"></i>
                <span>قائمة البائعين المسجلين</span>
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
                            <th class="py-3">العمليات</th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        @forelse ($sellers as $index => $seller)
                            <tr>
                                <td data-label="#" class="fw-bold text-secondary">{{ $index + 1 }}</td>

                                <td data-label="الاسم" class="fw-bold text-dark text-start px-3">
                                    {{ $seller->full_name }}
                                </td>

                                <td data-label="البريد" class="dir-ltr text-muted small">
                                    {{ get_user_data($seller->tenant_id)->email }}</td>
                                <td data-label="الهاتف" class="dir-ltr text-muted small">
                                    {{ get_user_data($seller->tenant_id)->phone }}</td>

                                <td data-label="المتجر">
                                    <span
                                        class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2.5 py-1 rounded-pill">
                                        <a href="{{ seller_store_url($seller->tenant->id) }}" target="_blank"
                                            class="text-info text-decoration-none fw-bold">{{ get_seller_store_name($seller->tenant->id) }}</a>
                                    </span>
                                </td>

                                <td data-label="تاريخ آخر نشاط" class="text-muted small">
                                    {{ get_user_data($seller->tenant_id)->last_seen[0]->created_at->diffForHumans() }}
                                </td>

                                <td data-label="الحالة">{!! get_seller_status($seller->tenant->id) !!}</td>

                                <td data-label="الباقة">
                                    <span class="badge bg-light text-dark border px-2.5 py-1 rounded-3">
                                        {{ get_seller_plan_data($seller->plan_subscription->plan_id)->name }}
                                    </span>
                                </td>

                                <td data-label="المنتجات">
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1 rounded-pill fw-bold">
                                        {{ $seller->products->count() }}
                                    </span>
                                </td>

                                <td data-label="التسجيل" class="text-muted small">
                                    {{ $seller->created_at->format('d-m-Y') }}</td>

                                <td data-label="الطلبات">
                                    <span class="badge bg-dark px-2.5 py-1 rounded-pill fw-bold">
                                        {{ $seller->orders->count() }}
                                    </span>
                                </td>

                                <td data-label="الاشتراك"><span class="text-muted small">
                                        @if ($seller->plan_subscription->plan_id != 1)
                                            {{ $seller->plan_subscription->subscription_end_date }}
                                        @else
                                            مدى الحياة
                                        @endif
                                    </span></td>

                                <td data-label="العمليات">
                                    <div
                                        class="d-flex justify-content-center align-items-center gap-1 action-buttons flex-wrap">

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

                                        <!-- Delete -->
                                        <form method="POST"
                                            action="{{ route('admin.seller.destroy', get_user_data($seller->tenant->id)->id) }}"
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
                                <td colspan="13" class="py-5 text-muted">
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
</div>

<!-- ===== Simple Search Script ===== -->
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let value = this.value.toLowerCase();
        document.querySelectorAll('#sellersTable tbody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>

<script>
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(
        tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl)
    );
</script>

<style>
    /* Pure CSS Responsive Table for #sellersTable */
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
