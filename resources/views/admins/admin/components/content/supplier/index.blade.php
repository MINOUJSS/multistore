<div class="container-fluid py-4">

    <!-- ===== Page Header ===== -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0">
            <i class="fa-solid fa-store text-primary me-2"></i>
            إدارة الموردين
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
        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa-solid fa-users fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted">إجمالي الموردين</h6>
                    <h4 class="fw-bold">{{ $suppliers->count() }}</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa-solid fa-circle-check fa-2x text-success mb-2"></i>
                    <h6 class="text-muted">موردون نشطون</h6>
                    <h4 class="fw-bold">—</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa-solid fa-box fa-2x text-info mb-2"></i>
                    <h6 class="text-muted">المنتجات</h6>
                    <h4 class="fw-bold">—</h4>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="card shadow-sm border-0 text-center">
                <div class="card-body">
                    <i class="fa-solid fa-cart-shopping fa-2x text-dark mb-2"></i>
                    <h6 class="text-muted">الطلبات</h6>
                    <h4 class="fw-bold">—</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Filters ===== -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row g-3">
                <div class="col-md-6">
                    <input type="text" id="searchInput" class="form-control"
                           placeholder="🔍 البحث بالاسم أو البريد أو الهاتف">
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option value="">كل الحالات</option>
                        <option value="active">نشط</option>
                        <option value="inactive">غير نشط</option>
                        <option value="blocked">محظور</option>
                    </select>
                </div>
                <div class="col-md-3 text-end">
                    <span class="badge bg-secondary p-2">
                        {{ $suppliers->count() }} مورد
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Table ===== -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white fw-bold">
            <i class="fa-solid fa-table me-1"></i>
            قائمة الموردين
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered align-middle mb-0" id="suppliersTable">
                <thead class="table-light text-center">
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        <th>البريد</th>
                        <th>الهاتف</th>
                        <th>المتجر</th>
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
                    @forelse ($suppliers as $index => $supplier)
                        <tr>
                            <td>{{ $index + 1 }}</td>

                            <td class="fw-semibold">
                                {{ $supplier->full_name }}
                            </td>

                            <td>{{ get_user_data($supplier->tenant_id)->email }}</td>
                            <td>{{ get_user_data($supplier->tenant_id)->phone }}</td>

                            <td>
                                <span class="badge bg-info">
                                    {{ get_supplier_store_name($supplier->tenant->id) }}
                                </span>
                            </td>

                            <td>{!! get_supplier_status($supplier->tenant->id) !!}</td>

                            <td>{{get_supplier_plan_data($supplier->plan_subscription->plan_id)->name}}</td>

                            <td><span class="badge bg-primary">{{$supplier->products->count()}}</span></td>

                            <td>{{ $supplier->created_at->format('d-m-Y') }}</td>

                            <td><span class="badge bg-dark">{{$supplier->orders->count()}}</span></td>

                            <td><span class="text-muted">
                              @if ($supplier->plan_subscription->plan_id!=1)
                              {{-- {{dd($supplier->plan_subscription)}} --}}
                                  {{ $supplier->plan_subscription->subscription_end_date }}
                              @else
                              مدى الحياة
                              @endif
                            </span></td>

                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                        العمليات
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fa-solid fa-eye me-1"></i> عرض
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="#">
                                                <i class="fa-solid fa-circle-check me-1 text-success"></i> تفعيل
                                            </a>
                                        </li>
                                        <li>
                                            <form method="POST"
                                                  action="{{ route('admin.supplier.destroy', $supplier->id) }}"
                                                  onsubmit="return confirm('هل أنت متأكد من الحذف؟')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="dropdown-item text-danger">
                                                    <i class="fa-solid fa-trash me-1"></i> حذف
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="py-4 text-muted">
                                <i class="fa-solid fa-circle-info me-1"></i>
                                لا يوجد موردين
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- ===== Pagination ===== -->
        <div class="card-footer bg-white">
            {{ $suppliers->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- ===== Simple Search Script ===== -->
<script>
    document.getElementById('searchInput').addEventListener('keyup', function () {
        let value = this.value.toLowerCase();
        document.querySelectorAll('#suppliersTable tbody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(value) ? '' : 'none';
        });
    });
</script>
