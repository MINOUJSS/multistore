<div class="container">
    <h1>لوحة التحكم</h1>
    @if (session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session()->get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            {{ session()->get('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!---->
    <!-- Start Dashboard Content -->
    <div class="container-fluid mt-4">
        <!-- Quick Actions -->
        {{-- <div class="row mb-4">
            <div class="col-12">
                <div class="card">
                    <div class="card-body d-flex flex-wrap gap-2 justify-content-center justify-content-md-start">
                        <button class="btn btn-primary">
                            <i class="fa-solid fa-plus"></i> إضافة منتج جديد
                        </button>
                        <button class="btn btn-success">
                            <i class="fa-solid fa-tag"></i> إضافة عرض خاص
                        </button>
                        <button class="btn btn-info text-white">
                            <i class="fa-solid fa-bullhorn"></i> إنشاء حملة تسويقية
                        </button>
                        <button class="btn btn-warning text-white">
                            <i class="fa-solid fa-cube"></i> إدارة المخزون
                        </button>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Statistics Cards -->
        @include('users.suppliers.components.content.dashboard.inc.dayly_statistics_cards')
        <!--------------------------->
        <div class="row g-3 mt-2 mb-2">
            <div class="col-md-8" dir="rtl">
                <div class="card border-primary">
                    <div class="card-body">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-bold text-gray-800">تحليل الطلبات</h3>
                            <select id="timeRange" class="border border-gray-200 px-3 py-1.5 rounded-lg text-sm">
                                <option value="daily">يومي</option>
                                <option value="weekly">أسبوعي</option>
                                <option value="monthly">شهري</option>
                            </select>
                        </div>
                        <canvas id="ordersChart" class="w-full h-64"></canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-4 " dir="rtl">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <h3 class="text-lg font-bold text-gray-800 text-center mb-4">توزيع حالة الطلبات</h3>
                        <canvas id="statusChart" class="w-full h-64"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <!--------------------------->
        @include('users.suppliers.components.content.dashboard.inc.weekly_statistics_cards')
        <!---->
        <div class="row mt-2">
            <div class="col-md-4 ">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">المنتجات الأكثر طلبا</h6>
                            <i class="fa-solid fa-crown text-primary"></i>
                        </div>
                        <div class="small">
                            @if($topProducts->count() > 0)
                            @foreach ($topProducts as $product)
                                <div class="d-flex justify-content-between mb-2">
                                    <img src="{{ $product->image }}" class="img-fluid" width="40" height="40"
                                        alt="">
                                    <span>{{ $product->name }}</span>
                                    <span class="text-primary">{{ $product->orders_count }} وحدة</span>
                                </div>
                            @endforeach
                            @else 
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-center">لا يوجد منتجات مطلوبة</span>
                            </div>
                            @endif
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">المنتجات الأكثر مشاهدة</h6>
                            <i class="fa-solid fa-crown text-primary"></i>
                        </div>
                        <div class="small">
                            @foreach ($topViewed as $product)
                                <div class="d-flex justify-content-between mb-2">
                                    <img src="{{ $product->image }}" class="img-fluid" width="40" height="40"
                                        alt="">
                                    <span>{{ $product->name }}</span>
                                    <span class="text-primary">{{ $product->views_count }} مشاهدة</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8 card border-primary">
                <div class="card-body">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">تحليل الزوار</h3>
                        <select id="visitorsTimeRange" class="border border-gray-200 px-3 py-1.5 rounded-lg text-sm">
                            <option value="daily">يومي</option>
                            <option value="weekly">أسبوعي</option>
                            <option value="monthly">شهري</option>
                        </select>
                    </div>
                    <canvas id="visitorsChart" class="w-full h-64"></canvas>
                </div>
            </div>
        </div>
        @include('users.suppliers.components.content.dashboard.inc.monthly_statistics_cards')
        <!---->

        <!-- Additional Statistics -->
        {{-- <div class="row g-3 mt-2">
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card border-primary h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">المنتجات الأكثر مبيعاً</h6>
                            <i class="fa-solid fa-crown text-primary"></i>
                        </div>
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span>هاتف آيفون 13 برو</span>
                                <span class="text-primary">85 وحدة</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>ساعة سامسونج</span>
                                <span class="text-primary">64 وحدة</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>سماعات آبل</span>
                                <span class="text-primary">52 وحدة</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card border-success h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">حالة المخزون</h6>
                            <i class="fa-solid fa-boxes-stacked text-success"></i>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>متوفر</span>
                                <span class="text-success">70%</span>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-success" style="width: 70%"></div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between mb-1">
                                <span>منخفض</span>
                                <span class="text-warning">20%</span>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-warning" style="width: 20%"></div>
                            </div>
                        </div>
                        <div>
                            <div class="d-flex justify-content-between mb-1">
                                <span>نفذ</span>
                                <span class="text-danger">10%</span>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-danger" style="width: 10%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card border-info h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">تحليل المبيعات</h6>
                            <i class="fa-solid fa-chart-line text-info"></i>
                        </div>
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span>معدل التحويل</span>
                                <span class="text-info">3.5%</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>متوسط قيمة الطلب</span>
                                <span class="text-info">2,500 د.ج</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>معدل العائد</span>
                                <span class="text-info">2.1%</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-3">
                <div class="card border-warning h-100">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="card-title mb-0">حالة الطلبات</h6>
                            <i class="fa-solid fa-truck-fast text-warning"></i>
                        </div>
                        <div class="small">
                            <div class="d-flex justify-content-between mb-2">
                                <span>قيد المعالجة</span>
                                <span class="text-warning">25</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>قيد الشحن</span>
                                <span class="text-warning">38</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>تم التسليم</span>
                                <span class="text-warning">22</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <!-- Recent Activities -->
        {{-- <div class="row mt-4">
            <div class="col-12 col-lg-8 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">النشاطات الأخيرة</h5>
                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-0" type="button" data-bs-toggle="dropdown">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">تحديث</a></li>
                                    <li><a class="dropdown-item" href="#">تصفية</a></li>
                                    <li><a class="dropdown-item" href="#">تصدير</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <span class="avatar bg-primary text-white">
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">طلب جديد</h6>
                                            <small class="text-muted">منذ 3 دقائق</small>
                                        </div>
                                        <p class="text-muted small mb-0">طلب رقم #12345 - هاتف آيفون 13 برو</p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <span class="avatar bg-success text-white">
                                            <i class="fa-solid fa-box"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">تحديث مخزون</h6>
                                            <small class="text-muted">منذ ساعة</small>
                                        </div>
                                        <p class="text-muted small mb-0">ماك بوك برو - تمت إضافة 5 وحدات</p>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <span class="avatar bg-info text-white">
                                            <i class="fa-solid fa-user-plus"></i>
                                        </span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-0">مستخدم جديد</h6>
                                            <small class="text-muted">منذ ساعتين</small>
                                        </div>
                                        <p class="text-muted small mb-0">انضم أحمد محمد إلى المنصة</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-white">
                        <h5 class="card-title mb-0">التنبيهات المهمة</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-warning d-flex align-items-center mb-3" role="alert">
                            <i class="fa-solid fa-triangle-exclamation me-2"></i>
                            <div>5 منتجات وصلت لحد المخزون الأدنى</div>
                        </div>
                        <div class="alert alert-info d-flex align-items-center mb-3" role="alert">
                            <i class="fa-solid fa-circle-info me-2"></i>
                            <div>تحديث النظام متوفر</div>
                        </div>
                        <div class="alert alert-success d-flex align-items-center" role="alert">
                            <i class="fa-solid fa-circle-check me-2"></i>
                            <div>تم اكتمال النسخ الاحتياطي اليومي</div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </div>
    <!-- End Dashboard Content -->
    <!---->


</div>
<!-- sweet alerts -->
@if(session('redicect_subscriber'))
    <script>
        Swal.fire({
            title: 'نجاح!',
            text: "{{ session('redicect_subscriber') }}",
            icon: 'success',
            confirmButtonText: 'حسنًا'
        });
    </script>
@endif
