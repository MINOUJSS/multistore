<div class="container-fluid py-4 overflow-hidden" style="max-width: 100%;">
    <!-- Header -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">رسائل الاتصال</h1>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label fw-semibold">حالة الرسالة</label>
                    <select id="messageStatusFilter" class="form-select">
                        <option value="all">جميع الحالات</option>
                        <option value="1">مقروءة</option>
                        <option value="0">غير مقروءة</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label fw-semibold">تاريخ الرسالة</label>
                    <input id="messageDateFilter" type="date" class="form-control">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold">بحث</label>
                    <input id="searchFilter" type="text" class="form-control" placeholder="عنوان الرسالة،كلمة من نص الرسالة...">
                </div>
                <div class="col-12 col-md-2">
                    <button id="searchBtn" class="btn btn-primary w-100">بحث</button>
                </div>
            </div>
        </div>
    </div>

    <!-- messages Table -->
    <div class="card shadow-sm border-0 w-100 overflow-hidden" style="max-width: 100%;">
        <div class="card-body p-0">
            <div class="table-responsive p-0">
                <table class="table table-hover align-middle mb-0 messages-table">
                    <thead class="table-light text-center">
                        <tr>
                            <th>رقم الرسالة</th>
                            <th>إسم المرسل</th>
                            <th>البريد الألكتروني</th>
                            <th>عنوان الرسالة</th>
                            <th>نص الرسالة</th>
                            <th>تاريخ الرسالة</th>
                            <th>حالة الرسالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @include('admins.admin.components.content.contact_us_messages.partials.messages_table')
                    </tbody>
                </table>
            </div>

            <div class="p-3 text-center">
                {!! $messages->links('vendor.pagination.dashboard-pagination') !!}
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

<style>
/* Pure CSS Responsive Table for .messages-table */
@media (max-width: 991.98px) {
    .messages-table, 
    .messages-table tbody, 
    .messages-table tr, 
    .messages-table td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }
    
    .messages-table thead {
        display: none !important;
    }
    
    .messages-table tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    
    .messages-table tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }
    
    .messages-table tbody td:last-child {
        border-bottom: none !important;
    }
    
    .messages-table tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
}
</style>