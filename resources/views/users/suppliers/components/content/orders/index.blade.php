

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

    <!--start modal -->
{{-- order details --}}
            <div class="modal fade" id="viewOrderModal" aria-labelledby="viewOrderModal" tabindex="-1"
                aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">تفاصيل الطلب <span id="order-number"></span></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>معلومات العميل</h6>
                                    <p>
                                        الاسم: <span id="customer-name"></span><br>
                                        الهاتف: <span id="customer-phone"></span><br>
                                        البريد الإلكتروني: <span id="customer-email"></span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6>معلومات الشحن</h6>
                                    <p>
                                        العنوان: <span id="shipping-address"></span><br>
                                        الولاية: <span id="shipping-city"></span><br>
                                        الرمز البريدي: <span id="shipping-zipcode"></span>
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <h6>ملاحظة الزبون</h6>
                                    <p>
                                        <span id="customer-note"></span>
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <h6>حالة الدفع</h6>
                                    <p>
                                        <span id="payment-status"></span>
                                    </p>
                                </div>
                                <div class="col-md-12">
                                    <h6>طريقة الدفع</h6>
                                    <p>
                                        <span id="payment-method"></span>
                                    </p>
                                    <span id="payment_proof"></span>
                                </div>
                            </div>
                            <hr>
                            <h6>المنتجات</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>المنتج</th>
                                            <th>الكمية</th>
                                            <th>السعر</th>
                                            <th>العمليات</th>
                                            <th>الإجمالي</th>
                                        </tr>
                                    </thead>
                                    <tbody id="order-items">
                                        <!-- سيتم ملء البيانات هنا عبر AJAX -->
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="4" class="text-start">المجموع</td>
                                            <td id="subtotal-price"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-start">الشحن</td>
                                            <td id="shipping-cost"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-start">التخفيض</td>
                                            <td id="discount"></td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="text-start">الإجمالي</td>
                                            <td><strong id="total-price"></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            <button type="button" class="btn btn-primary" onclick="printInvoice()">طباعة
                                الفاتورة</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- shipping Modal -->
            <div class="modal fade" id="viewShippingModal" tabindex="-1" aria-labelledby="viewShippingModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewShippingModalLabel">رفع الطلب</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @foreach ($companies as $company)
                                <div class="row border">
                                    <div class="col-6">
                                        <img src="{{ json_decode($company->data)->logo }}" class="img-fluid"
                                            alt="Image">
                                    </div>
                                    <div class="col-6 d-flex align-items-center text-center">
                                        <button class="btn btn-sm btn-primary w-100 create_company_parcel"
                                            data-order-id="100" data-company-name="{{ $company->name }}"><i
                                                class="fa-solid fa-truck"></i> رفع الطلب</button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tracking Modal -->
            <div class="modal fade" id="viewTrackingModal" tabindex="-1" aria-labelledby="viewTrackingModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="viewTrackingModalLabel">تتبع الطلب</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <button id="order_id_to_delete_btn"
                                class="btn btn-sm btn-danger w-100 delete_order_from_shipping_company"
                                data-order-id-to-delete="null">حذف الطلب من شركة التوصيل</button>
                        </div>
                    </div>
                </div>
            </div>

    <!--end modal -->

{{-- Responsive CSS for Mobile/Tablet --}}
<style>
/* =========================================
   Orders Table Responsive
   ========================================= */

.orders-table {
    width: 100%;
}

/* الشاشات الصغيرة */
@media (max-width: 768px) {

    .orders-table thead {
        display: none;
    }

    .orders-table,
    .orders-table tbody,
    .orders-table tr,
    .orders-table td {
        display: block;
        width: 100%;
    }

    .orders-table tr {
        margin-bottom: 20px;
        padding: 12px;
        border: 1px solid #dee2e6;
        border-radius: 10px;
        background: #fff;
    }

    .orders-table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 10px 5px;
        border: none;
        border-bottom: 1px solid #f1f1f1;
        text-align: right;
    }

    .orders-table td:last-child {
        border-bottom: none;
    }

    .orders-table td::before {
        font-weight: bold;
        flex-shrink: 0;
    }

    .orders-table td:nth-child(1)::before {
        content: "رقم الطلب";
    }

    .orders-table td:nth-child(2)::before {
        content: "العميل";
    }

    .orders-table td:nth-child(3)::before {
        content: "رقم الهاتف";
    }

    .orders-table td:nth-child(4)::before {
        content: "الإجمالي";
    }

    .orders-table td:nth-child(5)::before {
        content: "تأكيد الطلب";
    }

    .orders-table td:nth-child(6)::before {
        content: "تاريخ الطلب";
    }

    .orders-table td:nth-child(7)::before {
        content: "حالة الشحن";
    }

    .orders-table td:nth-child(8)::before {
        content: "الإجراءات";
    }

    /* منع الأزرار من الخروج خارج البطاقة */
    .orders-table td:last-child {
        flex-wrap: wrap;
    }

    .orders-table td:last-child > * {
        max-width: 100%;
    }
}
</style>
