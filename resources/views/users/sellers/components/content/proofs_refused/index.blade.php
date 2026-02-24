
<style>
/* ================= MOBILE TABLE TO CARD (CSS ONLY) ================= */
@media (max-width: 768px) {

    /* Remove Bootstrap table behavior */
    .table-responsive {
        overflow-x: visible !important;
    }

    table,
    thead,
    tbody,
    th,
    td,
    tr {
        display: block !important;
        width: 100% !important;
    }

    thead {
        display: none !important;
    }

    tr {
        margin-bottom: 15px !important;
        background: #fff !important;
        border-radius: 8px !important;
        box-shadow: 0 2px 6px rgba(0,0,0,.08) !important;
        padding: 10px !important;
    }

    td {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        padding: 8px 10px !important;
        border: none !important;
        border-bottom: 1px solid #eee !important;
        font-size: 0.85rem !important;
    }

    td:last-child {
        border-bottom: none !important;
    }

    /* Labels using nth-child (matches your table order) */
    td:nth-child(1)::before { content: "المستخدم"; }
    td:nth-child(2)::before { content: "المسؤول"; }
    td:nth-child(3)::before { content: "تاريخ الإرسال"; }
    td:nth-child(4)::before { content: "سبب الرفض"; }
    td:nth-child(5)::before { content: "الإجراءات"; }

    td::before {
        font-weight: bold !important;
        color: #555 !important;
        margin-left: 10px !important;
        white-space: nowrap !important;
    }

    /* Buttons */
    td .btn {
        font-size: 0.75rem !important;
        padding: 4px 10px !important;
    }

    /* Page padding */
    .container-fluid {
        padding: 10px !important;
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
