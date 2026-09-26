<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm"
        style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-fire text-warning"></i>
                    <span>{{ __('استخبارات وتحليل المنتجات الرابحة') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    📦 منتجات المشتركين والمنتج الرابح 🚀
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    مراقبة منتجات البائعين والموردين، تحليل مؤشرات المبيعات، ومعدلات التحويل، واكتشاف المنتجات الأكثر تحقيقاً للأرباح بالمنصة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.dashboard') }}"
                        class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm text-nowrap">
                        <i class="fa-solid fa-house me-1"></i> الرئيسية
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards Row -->
    <div class="row mb-4 g-3">
        <!-- 1. Total Products -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="d-flex align-items-center justify-content-center rounded-3 text-white shadow-sm"
                            style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 100%); width: 46px; height: 46px;">
                            <i class="fa-solid fa-boxes-stacked fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold d-block">إجمالي المنتجات المعروضة</small>
                            <h4 class="fw-bold mb-0 text-dark">{{ number_format($summary['total_products'] ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-1.5 pt-2 border-top border-light-subtle">
                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-layer-group me-1"></i> عبر المتاجر النشطة
                    </span>
                </div>
            </div>
        </div>

        <!-- 2. Winning Products Identified -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="d-flex align-items-center justify-content-center rounded-3 text-white shadow-sm"
                            style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); width: 46px; height: 46px;">
                            <i class="fa-solid fa-trophy fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold d-block">المنتجات الرابحة (Top Winners)</small>
                            <h4 class="fw-bold mb-0 text-dark">{{ number_format($summary['total_winners'] ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-1.5 pt-2 border-top border-light-subtle">
                    <span class="badge bg-warning-subtle text-warning px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-fire me-1"></i> نقاط تفوق ≥ 50/100
                    </span>
                </div>
            </div>
        </div>

        <!-- 3. Total Sold Units -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="d-flex align-items-center justify-content-center rounded-3 text-white shadow-sm"
                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); width: 46px; height: 46px;">
                            <i class="fa-solid fa-cart-shopping fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold d-block">إجمالي المبيعات المنفذة</small>
                            <h4 class="fw-bold mb-0 text-dark">{{ number_format($summary['total_sales_units'] ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-1.5 pt-2 border-top border-light-subtle">
                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-money-bill-trend-up me-1"></i> إيراد: {{ number_format($summary['total_revenue'] ?? 0, 2) }} د.ج
                    </span>
                </div>
            </div>
        </div>

        <!-- 4. Platform Conversion Rate -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="d-flex align-items-center justify-content-center rounded-3 text-white shadow-sm"
                            style="background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%); width: 46px; height: 46px;">
                            <i class="fa-solid fa-chart-line fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold d-block">متوسط معدل التحويل (CR)</small>
                            <h4 class="fw-bold mb-0 text-dark">{{ $summary['avg_conversion'] ?? 0 }}%</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-1.5 pt-2 border-top border-light-subtle">
                    <span class="badge bg-primary-subtle text-primary px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-arrow-up-right-dots me-1"></i> إجمالي ربح تقديري: {{ number_format($summary['total_profit'] ?? 0, 2) }} د.ج
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Subscriber Type Selector Tabs -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white p-3">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="btn-group p-1 bg-light rounded-pill border" role="group">
                <a href="{{ route('admin.products.index', array_merge(request()->query(), ['type' => 'all'])) }}"
                    class="btn rounded-pill px-4 fw-bold {{ ($filters['type'] ?? 'all') === 'all' ? 'btn-primary text-white shadow-sm' : 'text-secondary btn-light border-0' }}"
                    style="{{ ($filters['type'] ?? 'all') === 'all' ? 'background: #5c0649; border-color: #5c0649;' : '' }}">
                    <i class="fa-solid fa-globe me-1"></i> كافة المنتجات
                </a>
                <a href="{{ route('admin.products.index', array_merge(request()->query(), ['type' => 'seller'])) }}"
                    class="btn rounded-pill px-4 fw-bold {{ ($filters['type'] ?? '') === 'seller' ? 'btn-primary text-white shadow-sm' : 'text-secondary btn-light border-0' }}"
                    style="{{ ($filters['type'] ?? '') === 'seller' ? 'background: #5c0649; border-color: #5c0649;' : '' }}">
                    <i class="fa-solid fa-store me-1"></i> منتجات البائعين (تجزئة)
                </a>
                <a href="{{ route('admin.products.index', array_merge(request()->query(), ['type' => 'supplier'])) }}"
                    class="btn rounded-pill px-4 fw-bold {{ ($filters['type'] ?? '') === 'supplier' ? 'btn-primary text-white shadow-sm' : 'text-secondary btn-light border-0' }}"
                    style="{{ ($filters['type'] ?? '') === 'supplier' ? 'background: #5c0649; border-color: #5c0649;' : '' }}">
                    <i class="fa-solid fa-boxes-packing me-1"></i> منتجات الموردين (جملة)
                </a>
            </div>

            <div class="d-flex align-items-center gap-2">
                <span class="text-muted small">عرض: <strong>{{ $products->total() }}</strong> منتج</span>
            </div>
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white p-3">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row g-2 align-items-center">
            <input type="hidden" name="type" value="{{ $filters['type'] ?? 'all' }}">

            <!-- Search Field -->
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" class="form-control bg-light border-start-0 ps-0"
                        placeholder="ابحث بالاسم، السلغ، أو اسم المشترك والمتجر..."
                        value="{{ request('search') }}">
                </div>
            </div>

            <!-- Category Filter -->
            <div class="col-12 col-sm-6 col-md-3">
                <select name="category_id" class="form-select bg-light">
                    <option value="">-- تصنيف المنتجات (الكل) --</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Sort By Selector -->
            <div class="col-12 col-sm-6 col-md-3">
                <select name="sort_by" class="form-select bg-light">
                    <option value="winning_score" {{ request('sort_by', 'winning_score') == 'winning_score' ? 'selected' : '' }}>🔥 مؤشر المنتج الرابح (Winning Score)</option>
                    <option value="sales" {{ request('sort_by') == 'sales' ? 'selected' : '' }}>🛒 الأكثر مبيعاً (Units Sold)</option>
                    <option value="revenue" {{ request('sort_by') == 'revenue' ? 'selected' : '' }}>💰 الأعلى إيراداً (Revenue)</option>
                    <option value="profit" {{ request('sort_by') == 'profit' ? 'selected' : '' }}>📈 الأعلى هامش ربح (Profit)</option>
                    <option value="conversion" {{ request('sort_by') == 'conversion' ? 'selected' : '' }}>🎯 الأعلى معدل تحويل (Conversion Rate)</option>
                    <option value="visits" {{ request('sort_by') == 'visits' ? 'selected' : '' }}>👁️ الأكثر زيارة ومشاهدة</option>
                    <option value="newest" {{ request('sort_by') == 'newest' ? 'selected' : '' }}>🕒 الأحدث إضافة</option>
                </select>
            </div>

            <!-- Submit & Reset Buttons -->
            <div class="col-12 col-md-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary text-white w-100 fw-bold rounded-3" style="background: #a40c72; border-color: #a40c72;">
                    <i class="fa-solid fa-filter me-1"></i> تصفية
                </button>
                @if (request()->hasAny(['search', 'category_id', 'sort_by', 'status']))
                    <a href="{{ route('admin.products.index', ['type' => $filters['type'] ?? 'all']) }}" class="btn btn-outline-secondary rounded-3" title="إعادة ضبط">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Products Analytics Table -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-start">
                <thead class="bg-light text-secondary small text-uppercase fw-bold border-bottom">
                    <tr>
                        <th class="ps-3 py-3" style="width: 50px;">#</th>
                        <th class="py-3" style="min-width: 250px;">المنتج والتصنيف</th>
                        <th class="py-3" style="min-width: 180px;">نوع وصاحب المتجر</th>
                        <th class="py-3 text-center" style="min-width: 140px;">السعر والتكلفة</th>
                        <th class="py-3 text-center" style="min-width: 120px;">المبيعات المنفذة</th>
                        <th class="py-3 text-center" style="min-width: 130px;">الزيارات والتحويل</th>
                        <th class="py-3 text-center" style="min-width: 160px;">مؤشر المنتج الرابح</th>
                        <th class="pe-3 py-3 text-center" style="width: 100px;">إجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse ($products as $index => $item)
                        <tr>
                            <!-- Index -->
                            <td class="ps-3 fw-semibold text-muted">
                                {{ ($products->currentPage() - 1) * $products->perPage() + $loop->iteration }}
                            </td>

                            <!-- Product Info -->
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-3 border overflow-hidden bg-light d-flex align-items-center justify-content-center"
                                        style="width: 54px; height: 54px; min-width: 54px;">
                                        @if (!empty($item->image))
                                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}"
                                                class="w-100 h-100 object-fit-cover"
                                                onerror="this.onerror=null; this.src='https://placehold.co/100x100?text=No+Img';">
                                        @else
                                            <i class="fa-solid fa-box text-muted fs-4"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.products.show', ['type' => $item->subscriber_type, 'id' => $item->id]) }}"
                                            class="fw-bold text-dark text-decoration-none d-block text-truncate" style="max-width: 260px;">
                                            {{ $item->name }}
                                        </a>
                                        <div class="d-flex align-items-center gap-2 small text-muted mt-1">
                                            <span class="badge bg-light text-secondary border px-2 py-0.5 rounded-pill">
                                                <i class="fa-solid fa-tag me-1"></i> {{ $item->category->name ?? 'غير مصنف' }}
                                            </span>
                                            <span title="متوسط التقييمات">
                                                <i class="fa-solid fa-star text-warning"></i> {{ $item->analytics->avg_rating > 0 ? $item->analytics->avg_rating : '5.0' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Subscriber Info -->
                            <td>
                                <div>
                                    <span class="fw-bold text-dark d-block">
                                        {{ $item->store_name }}
                                    </span>
                                    <div class="d-flex align-items-center gap-1.5 mt-1">
                                        @if ($item->subscriber_type === 'seller')
                                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-0.5 rounded-pill small">
                                                <i class="fa-solid fa-store me-1"></i> بائع تجزئة
                                            </span>
                                        @else
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5 rounded-pill small">
                                                <i class="fa-solid fa-boxes-packing me-1"></i> مورد جملة
                                            </span>
                                        @endif
                                        <small class="text-muted text-truncate" style="max-width: 120px;">({{ $item->subscriber_name }})</small>
                                    </div>
                                </div>
                            </td>

                            <!-- Price & Cost & Margin -->
                            <td class="text-center">
                                <div class="fw-bold text-dark">{{ number_format($item->price, 2) }} د.ج</div>
                                <div class="small text-muted">التكلفة: {{ number_format($item->cost, 2) }} د.ج</div>
                                <span class="badge bg-success-subtle text-success px-2 py-0.5 rounded-pill small mt-1">
                                    هامش: {{ $item->analytics->profit_margin_pct }}%
                                </span>
                            </td>

                            <!-- Sales & Revenue -->
                            <td class="text-center">
                                <span class="badge bg-dark px-2.5 py-1 rounded-pill fw-bold fs-6">
                                    {{ number_format($item->analytics->units_sold) }}
                                </span>
                                <small class="text-muted d-block mt-1">
                                    {{ number_format($item->analytics->total_revenue, 2) }} د.ج
                                </small>
                            </td>

                            <!-- Visits & Conversion -->
                            <td class="text-center">
                                <div class="fw-semibold text-secondary">
                                    <i class="fa-regular fa-eye me-1"></i> {{ number_format($item->analytics->visits) }}
                                </div>
                                <div class="mt-1">
                                    <span class="badge {{ $item->analytics->conversion_rate >= 3 ? 'bg-success text-white' : 'bg-light text-dark border' }} px-2 py-1 rounded-pill small">
                                        CR: {{ $item->analytics->conversion_rate }}%
                                    </span>
                                </div>
                            </td>

                            <!-- Winning Score Badge & Progress -->
                            <td class="text-center">
                                <div class="mb-1">
                                    <span class="badge {{ $item->analytics->tier_badge }} px-2.5 py-1.5 rounded-pill fw-bold shadow-sm">
                                        {{ $item->analytics->tier_label }}
                                    </span>
                                </div>
                                <div class="d-flex align-items-center justify-content-center gap-2 mt-1">
                                    <div class="progress flex-grow-1" style="height: 6px; max-width: 90px; background-color: #f1f5f9;">
                                        <div class="progress-bar {{ $item->analytics->winning_score >= 70 ? 'bg-danger' : ($item->analytics->winning_score >= 40 ? 'bg-warning' : 'bg-info') }}"
                                            role="progressbar" style="width: {{ $item->analytics->winning_score }}%;"
                                            aria-valuenow="{{ $item->analytics->winning_score }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small class="fw-bold text-dark">{{ $item->analytics->winning_score }}/100</small>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="pe-3 text-center">
                                <a href="{{ route('admin.products.show', ['type' => $item->subscriber_type, 'id' => $item->id]) }}"
                                    class="btn btn-sm btn-outline-primary rounded-3 px-2 py-1" title="عرض تفاصيل الأداء">
                                    <i class="fa-solid fa-chart-pie me-1"></i> تفاصيل
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5">
                                <div class="py-4">
                                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle bg-light text-muted mb-3"
                                        style="width: 72px; height: 72px;">
                                        <i class="fa-solid fa-box-open fs-2"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark">لا توجد منتجات مطابقة لخيارات البحث الحالية</h5>
                                    <p class="text-muted mb-3">حاول تعديل شروط التصفية أو مسح عبارة البحث لرؤية المنتجات.</p>
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary rounded-3 text-white px-4"
                                        style="background: #5c0649; border-color: #5c0649;">
                                        عرض كافة المنتجات
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($products->hasPages())
            <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

</div>
