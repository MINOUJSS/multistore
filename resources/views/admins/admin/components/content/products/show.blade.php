<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Header Navigation -->
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
        <div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-1 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted">الرئيسية</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}" class="text-decoration-none text-muted">المنتجات</a></li>
                    <li class="breadcrumb-item active text-dark fw-bold" aria-current="page">{{ $product->name }}</li>
                </ol>
            </nav>
            <h2 class="h4 fw-bold text-dark mb-0">📊 بطاقة استخبارات وتحليل أداء المنتج</h2>
        </div>
        <div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary rounded-3 px-3 py-2 fw-semibold">
                <i class="fa-solid fa-arrow-right me-1"></i> العودة لقائمة المنتجات
            </a>
        </div>
    </div>

    <!-- Hero Card for Winning Intelligence -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden text-white"
        style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 60%, #be0681 100%);">
        <div class="card-body p-4 p-md-5 position-relative">
            <div class="row align-items-center g-4">
                <div class="col-auto">
                    <div class="rounded-4 border border-white border-opacity-25 overflow-hidden bg-white d-flex align-items-center justify-content-center shadow-lg"
                        style="width: 120px; height: 120px;">
                        @if (!empty($product->image))
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                class="w-100 h-100 object-fit-cover"
                                onerror="this.onerror=null; this.src='https://placehold.co/200x200?text=No+Img';">
                        @else
                            <i class="fa-solid fa-box-open text-muted fs-1"></i>
                        @endif
                    </div>
                </div>
                <div class="col">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <span class="badge {{ $product->analytics->tier_badge }} px-3 py-1.5 rounded-pill fs-6 fw-bold shadow-sm">
                            {{ $product->analytics->tier_label }}
                        </span>
                        <span class="badge bg-white bg-opacity-20 text-white border border-white border-opacity-25 px-2.5 py-1 rounded-pill">
                            مؤشر النجاح: {{ $product->analytics->winning_score }} / 100
                        </span>
                        @if ($product->subscriber_type === 'seller')
                            <span class="badge bg-white text-dark px-2.5 py-1 rounded-pill fw-semibold">
                                <i class="fa-solid fa-store text-primary me-1"></i> متجر بائع تجزئة
                            </span>
                        @else
                            <span class="badge bg-white text-dark px-2.5 py-1 rounded-pill fw-semibold">
                                <i class="fa-solid fa-boxes-packing text-success me-1"></i> مورد جملة
                            </span>
                        @endif
                    </div>
                    <h1 class="h3 fw-bold text-white mb-2">{{ $product->name }}</h1>
                    <p class="text-white-50 mb-0 small">
                        السلغ: <code>{{ $product->slug }}</code> | التصنيف: <strong>{{ $product->category->name ?? 'غير مصنف' }}</strong> | تاريخ الإضافة: {{ $product->created_at->format('Y-m-d') }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- 4 Main Performance Stat Cards -->
    <div class="row g-3 mb-4">
        <!-- Units Sold -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 text-white d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 48px; height: 48px; background: #10b981;">
                        <i class="fa-solid fa-bag-shopping fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-semibold">الوحدات المباعة</small>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($product->analytics->units_sold) }}</h4>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top small text-muted">
                    إجمالي طلبات المنتج الناجحة
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 text-white d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 48px; height: 48px; background: #059669;">
                        <i class="fa-solid fa-money-bill-wave fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-semibold">إجمالي المبيعات (GMV)</small>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($product->analytics->total_revenue, 2) }} <small class="fs-6 text-muted">د.ج</small></h4>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top small text-muted">
                    ربح تقديري: <strong class="text-success">{{ number_format($product->analytics->estimated_profit, 2) }} د.ج</strong>
                </div>
            </div>
        </div>

        <!-- Conversion Rate -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 text-white d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 48px; height: 48px; background: #6366f1;">
                        <i class="fa-solid fa-bullseye fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-semibold">معدل التحويل (CR)</small>
                        <h4 class="fw-bold mb-0 text-dark">{{ $product->analytics->conversion_rate }}%</h4>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top small text-muted">
                    من إجمالي <strong class="text-dark">{{ number_format($product->analytics->visits) }}</strong> زيارة مسجلة
                </div>
            </div>
        </div>

        <!-- Margin & Pricing -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 text-white d-flex align-items-center justify-content-center shadow-sm"
                        style="width: 48px; height: 48px; background: #f59e0b;">
                        <i class="fa-solid fa-percent fs-5"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block fw-semibold">هامش الربح الصافي</small>
                        <h4 class="fw-bold mb-0 text-dark">{{ $product->analytics->profit_margin_pct }}%</h4>
                    </div>
                </div>
                <div class="mt-3 pt-2 border-top small text-muted">
                    سعر البيع: {{ number_format($product->price, 2) }} | التكلفة: {{ number_format($product->cost, 2) }}
                </div>
            </div>
        </div>
    </div>

    <!-- Store & Financial Breakdown Row -->
    <div class="row g-4 mb-4">
        <!-- Subscriber & Store Profile -->
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                    <i class="fa-solid fa-id-card text-primary me-2"></i> بيانات المتجر والمشترك
                </h5>
                <ul class="list-unstyled mb-0">
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">اسم المتجر:</span>
                        <strong class="text-dark">{{ $product->store_name }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">صاحب الحساب:</span>
                        <strong class="text-dark">{{ $product->subscriber_name }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">نوع الحساب:</span>
                        <span>
                            @if ($product->subscriber_type === 'seller')
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-2 py-1">بائع تجزئة (Seller)</span>
                            @else
                                <span class="badge bg-success-subtle text-success rounded-pill px-2 py-1">مورد جملة (Supplier)</span>
                            @endif
                        </span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">الكمية بالمخزن:</span>
                        <span class="badge {{ $product->qty > 0 ? 'bg-success' : 'bg-danger' }} rounded-pill px-2 py-1">
                            {{ $product->qty }} وحدة
                        </span>
                    </li>
                    <li class="d-flex justify-content-between py-2 border-bottom">
                        <span class="text-muted">أقل كمية للطلب:</span>
                        <strong>{{ $product->minimum_order_qty ?? 1 }}</strong>
                    </li>
                    <li class="d-flex justify-content-between py-2">
                        <span class="text-muted">شحن مجاني:</span>
                        <strong>{{ ($product->free_shipping ?? 'no') === 'yes' ? 'نعم ✅' : 'لا ❌' }}</strong>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Profit Analysis Breakdown -->
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4">
                <h5 class="fw-bold text-dark mb-3 border-bottom pb-2">
                    <i class="fa-solid fa-calculator text-success me-2"></i> تحليل الجدوى المالية للقطعة
                </h5>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-start mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th>البند</th>
                                <th>القيمة المالية</th>
                                <th>الملاحظات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="fw-semibold">سعر بيع التجزئة المعروض</td>
                                <td class="fw-bold text-dark">{{ number_format($product->price, 2) }} د.ج</td>
                                <td class="small text-muted">السعر الظاهر للعملاء</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">تكلفة الشراء / الاستيراد</td>
                                <td class="fw-bold text-danger">{{ number_format($product->cost, 2) }} د.ج</td>
                                <td class="small text-muted">تكلفة اقتناء المنتج للوحدة</td>
                            </tr>
                            <tr>
                                <td class="fw-semibold">صافي الربح التقديري للقطعة</td>
                                <td class="fw-bold text-success">{{ number_format($product->analytics->profit_per_unit, 2) }} د.ج</td>
                                <td class="small text-muted">سعر البيع - تكلفة الاقتناء</td>
                            </tr>
                            <tr class="table-light">
                                <td class="fw-bold">إجمالي الأرباح المحققة حتى الآن</td>
                                <td class="fw-bold fs-5 text-success">{{ number_format($product->analytics->estimated_profit, 2) }} د.ج</td>
                                <td class="small text-muted">{{ $product->analytics->units_sold }} قطعة مباعة</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Order History -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h5 class="fw-bold text-dark mb-0">
                <i class="fa-solid fa-receipt text-warning me-2"></i> سجل طلبات هذا المنتج
            </h5>
            <span class="badge bg-light text-secondary border px-2 py-1">
                إجمالي العناصر المطلوبة: {{ $product->orderItems->count() }}
            </span>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-start">
                <thead class="bg-light text-secondary small text-uppercase fw-bold">
                    <tr>
                        <th class="ps-3 py-3">#</th>
                        <th>رقم الطلب</th>
                        <th>اسم العميل</th>
                        <th>الكمية</th>
                        <th>سعر الوحدة</th>
                        <th>الإجمالي</th>
                        <th>تاريخ الطلب</th>
                        <th class="pe-3">حالة الطلب</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($product->orderItems as $item)
                        <tr>
                            <td class="ps-3 fw-semibold text-muted">{{ $loop->iteration }}</td>
                            <td>
                                <strong class="text-primary">
                                    {{ $item->order->order_number ?? ('#ORD-' . $item->order_id) }}
                                </strong>
                            </td>
                            <td>{{ $item->order->customer_name ?? 'عميل غير مسجل' }}</td>
                            <td><span class="badge bg-dark px-2 py-1 rounded-pill">{{ $item->quantity }}</span></td>
                            <td>{{ number_format($item->unit_price, 2) }} د.ج</td>
                            <td class="fw-bold text-success">{{ number_format($item->total_price, 2) }} د.ج</td>
                            <td class="small text-muted">{{ $item->created_at->format('Y-m-d H:i') }}</td>
                            <td class="pe-3">
                                @php
                                    $orderStatus = $item->order->status ?? 'pending';
                                @endphp
                                <span class="badge {{ $orderStatus === 'delivered' || $orderStatus === 'completed' ? 'bg-success' : ($orderStatus === 'cancelled' ? 'bg-danger' : 'bg-warning text-dark') }} px-2 py-1 rounded-pill">
                                    {{ $orderStatus }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">
                                لا توجد طلبات مسجلة لهذا المنتج حتى الآن.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
