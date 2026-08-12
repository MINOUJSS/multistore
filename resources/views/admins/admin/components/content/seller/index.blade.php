<div class="container-fluid py-4">
    <!-- ===== Page Header ===== -->
    <div
        class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <h3 class="fw-bold mb-0">
            <i class="fa-solid fa-store text-primary me-2"></i>
            إدارة البائعين
        </h3>
    </div>

    <!-- ===== Alerts ===== -->
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="fa-solid fa-circle-check me-1"></i>
            {{ session()->get('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- ===== Stats ===== -->
    <div class="row mb-4 g-3">
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-users fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted mb-1">إجمالي البائعين</h6>
                    <h4 class="fw-bold mb-0">{{ $sellers->count() }}</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-circle-check fa-2x text-success mb-2"></i>
                    <h6 class="text-muted mb-1">بائعين نشطون</h6>
                    <h4 class="fw-bold mb-0">—</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-box fa-2x text-info mb-2"></i>
                    <h6 class="text-muted mb-1">المنتجات</h6>
                    <h4 class="fw-bold mb-0">—</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-cart-shopping fa-2x text-dark mb-2"></i>
                    <h6 class="text-muted mb-1">الطلبات</h6>
                    <h4 class="fw-bold mb-0">—</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Filters ===== -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-center">
                <div class="col-12 col-md-6">
                    <input type="text" id="searchInput" class="form-control"
                        placeholder="🔍 البحث بالاسم أو البريد أو الهاتف">
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <select class="form-select">
                        <option value="">كل الحالات</option>
                        <option value="active">نشط</option>
                        <option value="inactive">غير نشط</option>
                        <option value="blocked">محظور</option>
                    </select>
                </div>
                <div
                    class="col-12 col-sm-6 col-md-3 d-flex align-items-center justify-content-start justify-content-sm-end">
                    <span class="badge bg-secondary p-2 fs-6">
                        {{ $sellers->count() }} بائع
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Table Card ===== -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold py-3">
            <i class="fa-solid fa-table me-1"></i>
            قائمة الموردين
        </div>

        <div class="table-responsive p-0">
            <table class="table table-hover table-bordered align-middle mb-0" id="sellersTable">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد</th>
                        <th>الهاتف</th>
                        <th>المتجر</th>
                        <th>تاريخ آخر نشاط</th>
                        <th>الحالة</th>
                        <th>الباقة</th>
                        <th>المنتجات</th>
                        <th>التسجيل</th>
                        <th>الطلبات</th>
                        <th>الاشتراك</th>
                        <th>العمليات</th>
                    </tr>
                </thead>

                <tbody class="text-center">
                    @forelse ($sellers as $index => $seller)
                        <tr>
                            <td data-label="#">{{ $index + 1 }}</td>

                            <td data-label="الاسم" class="fw-semibold">
                                {{ $seller->full_name }}
                            </td>

                            <td data-label="البريد">{{ get_user_data($seller->tenant_id)->email }}</td>
                            <td data-label="الهاتف">{{ get_user_data($seller->tenant_id)->phone }}</td>

                            <td data-label="المتجر">
                                <span class="badge bg-info">
                                    <a href="{{ seller_store_url($seller->tenant->id) }}" target="_blank"
                                        class="text-white text-decoration-none">{{ get_seller_store_name($seller->tenant->id) }}</a>
                                </span>
                            </td>

                            <td data-label="تاريخ آخر نشاط">
                                {{ get_user_data($seller->tenant_id)->last_seen[0]->created_at->diffForHumans() }}</td>

                            <td data-label="الحالة">{!! get_seller_status($seller->tenant->id) !!}</td>

                            <td data-label="الباقة">
                                {{ get_seller_plan_data($seller->plan_subscription->plan_id)->name }}</td>

                            <td data-label="المنتجات"><span
                                    class="badge bg-primary">{{ $seller->products->count() }}</span></td>

                            <td data-label="التسجيل">{{ $seller->created_at->format('d-m-Y') }}</td>

                            <td data-label="الطلبات"><span class="badge bg-dark">{{ $seller->orders->count() }}</span>
                            </td>

                            <td data-label="الاشتراك"><span class="text-muted">
                                    @if ($seller->plan_subscription->plan_id != 1)
                                        {{ $seller->plan_subscription->subscription_end_date }}
                                    @else
                                        مدى الحياة
                                    @endif
                                </span></td>

                            <td data-label="العمليات">
                                <div
                                    class="d-flex justify-content-center justify-content-lg-center align-items-center gap-2 action-buttons">

                                    <!-- View -->
                                    <a href="{{ route('admin.seller.show', $seller->id) }}"
                                        class="btn btn-sm btn-light border action-btn view-btn" data-bs-toggle="tooltip"
                                        title="عرض التفاصيل">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>

                                    <!-- Activate -->
                                    <a href="#" class="btn btn-sm btn-light border action-btn active-btn"
                                        data-bs-toggle="tooltip" title="تفعيل المورد">
                                        <i class="fa-solid fa-circle-check"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form method="POST"
                                        action="{{ route('admin.seller.destroy', get_user_data($seller->tenant->id)->id) }}"
                                        onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light border action-btn delete-btn"
                                            data-bs-toggle="tooltip" title="حذف المورد">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="py-4 text-muted">
                                <i class="fa-solid fa-circle-info me-1"></i>
                                لا يوجد موردين
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ===== Pagination ===== -->
        <div class="card-footer bg-white py-3">
            <div class="d-flex justify-content-center justify-content-md-end overflow-auto">
                {{ $sellers->links('vendor.pagination.dashboard-pagination') }}
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
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all .25s ease;
        font-size: 14px;
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
