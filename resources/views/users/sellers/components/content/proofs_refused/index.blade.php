<style>
/* ===============================
   Global spacing fix
================================ */
.container-fluid {
    padding-left: 0px;
    padding-right: 0px;
}

.card {
    margin-bottom: 1rem;
}

.card-body {
    padding: 1rem;
}

/* ===============================
   Table behavior
================================ */
.table-responsive {
    width: 95vw !important;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.table {
    width: 90%;
    margin-bottom: 0;
}

/* ===============================
   MOBILE & TABLET
================================ */
@media (max-width: 991.98px) {

    /* Page title */
    .page-title-box {
        text-align: center;
        margin-bottom: 1rem;
    }

    /* Filter form: stack inputs */
    form .row.g-2 > div {
        flex: 0 0 100%;
        max-width: 100%;
    }

    form .row.g-2 > div:not(:last-child) {
        margin-bottom: 0.75rem;
    }

    /* Search button */
    form button.btn {
        margin-top: 0.5rem;
    }

    /* Table font & spacing */
    table.table {
        font-size: 0.9rem;
    }

    table.table th,
    table.table td {
        white-space: nowrap;
        padding: 0.5rem;
        text-align: center;
        vertical-align: middle;
    }

    /* Action buttons full width */
    table.table td .btn {
        width: 100%;
        margin-bottom: 0.25rem;
    }

    /* Pagination spacing */
    .pagination {
        flex-wrap: wrap;
        gap: 0.25rem;
    }
}

/* ===============================
   SMALL MOBILE (phones)
================================ */
@media (max-width: 575.98px) {

    .card-body {
        padding: 0.75rem;
    }

    h4.header-title {
        font-size: 1rem;
        text-align: center;
    }

    .table {
        font-size: 0.85rem;
    }
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">إثباتات الدفع المرفوضة</h4>
            </div>
        </div>
    </div>

    {{-- Search/Filter Section --}}
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">بحث وتصفية</h4>
                    <form action="{{-- route('seller.payment_proofs.refused.index') --}}" method="GET"> {{-- Assuming a route for filtering --}}
                        <div class="row g-2">
                            <div class="col-md-4">
                                <label for="search_user" class="form-label">البحث عن مستخدم</label>
                                <input type="text" class="form-control" id="search_user" name="user" placeholder="اسم المستخدم أو البريد الإلكتروني" value="{{ request('user') }}">
                            </div>
                            <div class="col-md-4">
                                <label for="search_admin" class="form-label">البحث عن مسؤول</label>
                                <input type="text" class="form-control" id="search_admin" name="admin" placeholder="اسم المسؤول" value="{{ request('admin') }}">
                            </div>
                            <div class="col-md-2">
                                <label for="search_date" class="form-label">تاريخ الإرسال</label>
                                <input type="date" class="form-control" id="search_date" name="date" value="{{ request('date') }}">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary w-100">بحث</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Table Section --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">قائمة الإثباتات المرفوضة</h4>
                    <div class="table-responsive">
                        <table class="table table-striped table-centered mb-0">
                            <thead>
                                <tr>
                                    <th>المستخدم</th>
                                    <th>المسؤول</th>
                                    <th>تاريخ الإرسال</th>
                                    <th>سبب الرفض</th> 
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($proofs as $proof)
                                    <tr>
                                        <td>{{ $proof->user->name ?? 'غير معروف' }}</td> 
                                        <td>{{ $proof->admin->name ?? 'غير معروف' }} 
                                        <td>{{ $proof->created_at->format('Y-m-d H:i') }}</td>
                                        <td>{{ $proof->refuse_reason ?? 'لا يوجد سبب محدد' }}</td> 
                                        <td>
                                            <a href="{{ route('seller.payments_proofs_refused.show', $proof->id) }}" class="btn btn-sm btn-info">عرض التفاصيل</a>
                                            
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">لا توجد إثباتات مرفوضة لعرضها.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    {{-- Pagination --}}
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $proofs->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
