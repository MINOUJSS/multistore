<div class="container-fluid">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>إدارة الشحن</h2>
        <button class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            إضافة شحنة جديدة
        </button>
    </div>

    <!-- Shipping Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">الشحنات النشطة</h5>
                    <h3 class="card-text">24</h3>
                    <p class="card-text"><small>قيد التوصيل</small></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">تم التسليم</h5>
                    <h3 class="card-text">156</h3>
                    <p class="card-text"><small>هذا الشهر</small></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">قيد المعالجة</h5>
                    <h3 class="card-text">18</h3>
                    <p class="card-text"><small>في المستودع</small></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">متوسط وقت التوصيل</h5>
                    <h3 class="card-text">2.5</h3>
                    <p class="card-text"><small>يوم</small></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Shipping Table -->
    <div class="card">
        <div class="card-body">
            <!-- Filters -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="بحث برقم الشحنة...">
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected="">حالة الشحنة</option>
                        <option>قيد المعالجة</option>
                        <option>تم الشحن</option>
                        <option>قيد التوصيل</option>
                        <option>تم التسليم</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected="">شركة الشحن</option>
                        <option>أرامكس</option>
                        <option>فيديكس</option>
                        <option>DHL</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control">
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>رقم الشحنة</th>
                            <th>رقم الطلب</th>
                            <th>العميل</th>
                            <th>العنوان</th>
                            <th>شركة الشحن</th>
                            <th>تاريخ الشحن</th>
                            <th>تاريخ التسليم المتوقع</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#SHP-001</td>
                            <td>#ORD-123</td>
                            <td>أحمد محمد</td>
                            <td>الرياض، حي النزهة</td>
                            <td>أرامكس</td>
                            <td>2024-12-23</td>
                            <td>2024-12-25</td>
                            <td><span class="badge bg-warning">قيد التوصيل</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" title="تتبع الشحنة">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-primary" title="تحديث الحالة">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-success" title="طباعة بوليصة الشحن">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>#SHP-002</td>
                            <td>#ORD-124</td>
                            <td>سارة أحمد</td>
                            <td>جدة، حي الصفا</td>
                            <td>DHL</td>
                            <td>2024-12-23</td>
                            <td>2024-12-26</td>
                            <td><span class="badge bg-info">تم الشحن</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" title="تتبع الشحنة">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-primary" title="تحديث الحالة">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-success" title="طباعة بوليصة الشحن">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>#SHP-003</td>
                            <td>#ORD-125</td>
                            <td>محمد علي</td>
                            <td>الدمام، حي الشاطئ</td>
                            <td>فيديكس</td>
                            <td>2024-12-22</td>
                            <td>2024-12-24</td>
                            <td><span class="badge bg-success">تم التسليم</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" title="تتبع الشحنة">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-primary" title="تحديث الحالة">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-success" title="طباعة بوليصة الشحن">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
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
</div>