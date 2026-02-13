<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">إدارة الطلبات</h1>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row g-2">
                <div class="col-md-3">
                    <label class="form-label">حالة الشحن</label>
                    <select id="orderStatusFilter" class="form-select">
                        <option value="all">جميع الحالات</option>
                        <option value="pending">جديد</option>
                        <option value="processing">قيد المعالجة</option>
                        <option value="shipped">تم الشحن</option>
                        <option value="delivered">مكتمل</option>
                        <option value="canceled">ملغي</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">تاريخ الطلب</label>
                    <input id="orderDateFilter" type="date" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="form-label">بحث</label>
                    <input id="searchFilter" type="text" class="form-control" placeholder="رقم الطلب، اسم العميل...">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button id="searchBtn" class="btn btn-primary w-100">بحث</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive ">
                <table class="table table-hover orders-table">
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>العميل</th>
                            <th>رقم الهاتف</th>
                            <th>الإجمالي</th>
                            <th>تأكيد الطلب</th>
                            <th>تاريخ الطلب</th>
                            <th>حالة الشحن</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @include('users.suppliers.components.content.orders.partials.orders_table')
                    </tbody>
                </table>
            </div>

            <div class="mt-4 text-center">
                {!! $orders->links('vendor.pagination.dashboard-pagination') !!}
            </div>
        </div>
    </div>
</div>

{{-- Responsive CSS for Mobile/Tablet --}}
<style>
/* Make container and cards full width on mobile/tablet */
@media (max-width: 991.98px) {
    .container-fluid {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    .card,
    .card-body {
        padding-left: 0.5rem;
        padding-right: 0.5rem;
    }

    /* Header stacked */
    .d-flex.justify-content-between.align-items-center {
        flex-direction: column;
        align-items: flex-start;
    }

    .d-flex.justify-content-between.align-items-center h1 {
        text-align: center;
        width: 100%;
        margin-bottom: 1rem;
    }

    /* Filters full width */
    .card .row > div {
        flex: 0 0 100%;
        max-width: 100%;
        margin-bottom: 0.5rem;
    }

    /* Table full width */
    .table-responsive {
        padding: 0;
        margin: 0;
        overflow-x: visible;
    }

    .orders-table {
        width: 100% !important;
        min-width: 100%;
        table-layout: fixed; /* make columns adjust nicely */
    }

    .orders-table td,
    .orders-table th {
        padding: 0.5rem 0.75rem;
        vertical-align: middle;
    }

    /* Hide thead and transform rows into card-like blocks */
    .orders-table thead {
        display: none;
    }

    .orders-table tbody tr {
        display: block;
        margin-bottom: 1rem;
        border: 1px solid #dee2e6;
        border-radius: 5px;
        padding: 0.5rem;
        width: 100%;
        box-sizing: border-box;
        background: #fff;
    }

    .orders-table tbody tr td {
        display: flex;
        justify-content: space-between;
        padding: 0.25rem 0.5rem;
        border: 0;
        white-space: normal;
        width: 100%;
        flex-wrap: wrap;
    }

    .orders-table tbody tr td::before {
        content: attr(data-label);
        font-weight: bold;
        flex: 1 1 50%;
        text-align: left;
    }

    .orders-table tbody tr td:last-child {
        justify-content: flex-end;
    }
}
</style>

