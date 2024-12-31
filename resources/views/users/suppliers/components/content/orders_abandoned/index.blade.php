<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">إدارة الطلبات</h1>
        <div class="btn-group">
            <button class="btn btn-primary">
                <i class="fas fa-file-export me-2"></i>تصدير التقرير
            </button>
        </div>
    </div>

    <!-- Filters -->
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">حالة الطلب</label>
                    <select class="form-select">
                        <option value="">جميع الحالات</option>
                        <option>جديد</option>
                        <option>قيد المعالجة</option>
                        <option>تم الشحن</option>
                        <option>مكتمل</option>
                        <option>ملغي</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">تاريخ الطلب</label>
                    <input type="date" class="form-control">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">بحث</label>
                    <input type="text" class="form-control" placeholder="رقم الطلب، اسم العميل...">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">&nbsp;</label>
                    <button class="btn btn-primary w-100">بحث</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>رقم الطلب</th>
                            <th>العميل</th>
                            <th>المنتجات</th>
                            <th>الإجمالي</th>
                            <th>تاريخ الطلب</th>
                            <th>حالة الطلب</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#12345</td>
                            <td>محمد أحمد</td>
                            <td>3 منتجات</td>
                            <td>750 ر.س</td>
                            <td>2024-12-23</td>
                            <td>
                                <select class="form-select form-select-sm">
                                    <option>جديد</option>
                                    <option>قيد المعالجة</option>
                                    <option>تم الشحن</option>
                                    <option>مكتمل</option>
                                    <option>ملغي</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewOrderModal">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>#12344</td>
                            <td>سارة خالد</td>
                            <td>1 منتج</td>
                            <td>250 ر.س</td>
                            <td>2024-12-23</td>
                            <td>
                                <select class="form-select form-select-sm">
                                    <option>جديد</option>
                                    <option selected="">قيد المعالجة</option>
                                    <option>تم الشحن</option>
                                    <option>مكتمل</option>
                                    <option>ملغي</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#viewOrderModal">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">السابق</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">التالي</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>

    <div class="modal fade" id="viewOrderModal" tabindex="-1" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">تفاصيل الطلب #12345</h5>
                    <button type="button" class="btn-close ms-0 me-auto" data-bs-dismiss="modal" style="
    /* direction: rtl; */
"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>معلومات العميل</h6>
                            <p>الاسم: محمد أحمد<br>
                            الهاتف: 0501234567<br>
                            البريد الإلكتروني: mohammed@example.com</p>
                        </div>
                        <div class="col-md-6">
                            <h6>معلومات الشحن</h6>
                            <p>العنوان: حي النخيل، شارع الملك فهد<br>
                            المدينة: الرياض<br>
                            الرمز البريدي: 12345</p>
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
                                    <th>الإجمالي</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>هاتف ذكي</td>
                                    <td>1</td>
                                    <td>500 ر.س</td>
                                    <td>500 ر.س</td>
                                </tr>
                                <tr>
                                    <td>سماعات لاسلكية</td>
                                    <td>2</td>
                                    <td>125 ر.س</td>
                                    <td>250 ر.س</td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-start">المجموع</td>
                                    <td>750 ر.س</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-start">الشحن</td>
                                    <td>30 ر.س</td>
                                </tr>
                                <tr>
                                    <td colspan="3" class="text-start">الإجمالي</td>
                                    <td><strong>780 ر.س</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary">طباعة الفاتورة</button>
                </div>
            </div>
        </div>
    </div>

</div>