<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-envelope-open-text text-warning"></i>
                    <span>{{ __('رسائل صفحة الهبوط') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    📬 رسائل الاتصال والاستفسارات 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    متابعة ومعالجة كافة الرسائل الواردة من زوار المنصة وصفحة الهبوط الرئيسية.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 bg-white bg-opacity-15 rounded-3 border border-white border-opacity-20 text-white">
                    <i class="fa-solid fa-inbox text-warning fs-5"></i>
                    <div class="text-start">
                        <div class="small opacity-75">إجمالي الرسائل</div>
                        <div class="fw-bold fs-5">{{ number_format($messages->total()) }} رسالة</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center gap-2">
            <i class="fa-solid fa-filter" style="color: #a40c72;"></i>
            <span>خيارات التصفية والبحث في الرسائل</span>
        </div>
        <div class="card-body p-4">
            <div class="row g-3 align-items-end">
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label fw-semibold text-dark small">حالة الرسالة</label>
                    <select id="messageStatusFilter" class="form-select bg-light border-0 rounded-3">
                        <option value="all">جميع الحالات</option>
                        <option value="1">مقروءة</option>
                        <option value="0">غير مقروءة</option>
                    </select>
                </div>
                <div class="col-12 col-sm-6 col-md-3">
                    <label class="form-label fw-semibold text-dark small">تاريخ الرسالة</label>
                    <input id="messageDateFilter" type="date" class="form-control bg-light border-0 rounded-3">
                </div>
                <div class="col-12 col-md-4">
                    <label class="form-label fw-semibold text-dark small">بحث</label>
                    <input id="searchFilter" type="text" class="form-control bg-light border-0 rounded-3" placeholder="عنوان الرسالة، كلمة من نص الرسالة...">
                </div>
                <div class="col-12 col-md-2">
                    <button id="searchBtn" class="btn text-white w-100 rounded-3 fw-bold py-2" style="background-color: #a40c72;">
                        <i class="fa-solid fa-magnifying-glass me-1"></i> بحث
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white w-100 overflow-hidden" style="max-width: 100%;">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-list-ul" style="color: #a40c72;"></i>
                <span>قائمة رسائل الزوار</span>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive p-0">
                <table class="table table-hover align-middle mb-0 messages-table">
                    <thead class="bg-light text-muted small text-center">
                        <tr>
                            <th class="py-3">رقم الرسالة</th>
                            <th class="py-3">إسم المرسل</th>
                            <th class="py-3">البريد الألكتروني</th>
                            <th class="py-3">عنوان الرسالة</th>
                            <th class="py-3">نص الرسالة</th>
                            <th class="py-3">تاريخ الرسالة</th>
                            <th class="py-3">حالة الرسالة</th>
                            <th class="py-3">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        @include('admins.admin.components.content.contact_us_messages.partials.messages_table')
                    </tbody>
                </table>
            </div>

            <div class="p-3 text-center border-top bg-light">
                {!! $messages->links('vendor.pagination.dashboard-pagination') !!}
            </div>
        </div>
    </div>

</div>

<!-- Modals -->
<div class="modal fade" id="viewOrderModal" aria-labelledby="viewOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">تفاصيل الطلب <span id="order-number"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-bold mb-2">معلومات العميل</h6>
                            <p class="mb-0 small leading-relaxed">
                                الاسم: <span id="customer-name" class="fw-bold"></span><br>
                                الهاتف: <span id="customer-phone" class="fw-bold"></span><br>
                                البريد الإلكتروني: <span id="customer-email" class="fw-bold dir-ltr d-inline-block"></span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-bold mb-2">معلومات الشحن</h6>
                            <p class="mb-0 small leading-relaxed">
                                العنوان: <span id="shipping-address" class="fw-bold"></span><br>
                                الولاية: <span id="shipping-city" class="fw-bold"></span><br>
                                الرمز البريدي: <span id="shipping-zipcode" class="fw-bold"></span>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-bold mb-1">ملاحظة الزبون</h6>
                            <p class="mb-0 small"><span id="customer-note"></span></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-bold mb-1">حالة الدفع</h6>
                            <p class="mb-0 small"><span id="payment-status"></span></p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3">
                            <h6 class="fw-bold mb-1">طريقة الدفع</h6>
                            <p class="mb-0 small"><span id="payment-method"></span></p>
                            <span id="payment_proof"></span>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <h6 class="fw-bold mb-3">المنتجات</h6>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center mb-0">
                        <thead class="table-light">
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
                                <td colspan="4" class="text-start fw-bold">المجموع</td>
                                <td id="subtotal-price"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-start fw-bold">الشحن</td>
                                <td id="shipping-cost"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-start fw-bold">التخفيض</td>
                                <td id="discount"></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="text-start fw-bold fs-6">الإجمالي</td>
                                <td><strong id="total-price" class="text-success fs-6"></strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn text-white rounded-3 fw-bold" style="background-color: #a40c72;" onclick="printInvoice()">طباعة الفاتورة</button>
            </div>
        </div>
    </div>
</div>

<!-- Tracking Modal -->
<div class="modal fade" id="viewTrackingModal" tabindex="-1" aria-labelledby="viewTrackingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content rounded-4 border-0 shadow">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold" id="viewTrackingModalLabel">تتبع الطلب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <button id="order_id_to_delete_btn"
                    class="btn btn-danger w-100 rounded-3 py-2 fw-bold delete_order_from_shipping_company"
                    data-order-id-to-delete="null">حذف الطلب من شركة التوصيل</button>
            </div>
        </div>
    </div>
</div>

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