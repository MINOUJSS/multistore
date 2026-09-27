<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm"
        style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-shapes text-warning"></i>
                    <span>{{ __('تحليل التطبيقات والخدمات الخارجية') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    📱 إحصائيات التطبيقات المستعملة ⚡
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    مراقبة وتتبع التطبيقات والخدمات المربوطة من طرف البائعين والموردين (Pixel، Analytics، Sheets، Telegram، وClarity) لتحسين وتوجيه أداء المتاجر.
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
        <!-- 1. Total Apps Installed -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="d-flex align-items-center justify-content-center rounded-3 text-white shadow-sm"
                            style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 100%); width: 46px; height: 46px;">
                            <i class="fa-solid fa-cubes fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold d-block">إجمالي التطبيقات المربوطة</small>
                            <h4 class="fw-bold mb-0 text-dark">{{ number_format($summary['total_apps'] ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-1.5 pt-2 border-top border-light-subtle">
                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-users me-1"></i> لدى {{ number_format($summary['unique_users'] ?? 0) }} مشترك فريد
                    </span>
                </div>
            </div>
        </div>

        <!-- 2. Active Apps -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="d-flex align-items-center justify-content-center rounded-3 text-white shadow-sm"
                            style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); width: 46px; height: 46px;">
                            <i class="fa-solid fa-circle-check fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold d-block">التطبيقات النشطة</small>
                            <h4 class="fw-bold mb-0 text-success">{{ number_format($summary['active_apps'] ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-1.5 pt-2 border-top border-light-subtle">
                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                        @php
                            $activeRate = ($summary['total_apps'] > 0) ? round(($summary['active_apps'] / $summary['total_apps']) * 100) : 0;
                        @endphp
                        <i class="fa-solid fa-chart-pie me-1"></i> {{ $activeRate }}% نسبة التفعيل
                    </span>
                    @if(($summary['inactive_apps'] ?? 0) > 0)
                        <span class="badge bg-danger-subtle text-danger px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                            {{ $summary['inactive_apps'] }} معطل
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- 3. Seller Apps -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="d-flex align-items-center justify-content-center rounded-3 text-white shadow-sm"
                            style="background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%); width: 46px; height: 46px;">
                            <i class="fa-solid fa-store fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold d-block">تطبيقات البائعين</small>
                            <h4 class="fw-bold mb-0 text-primary">{{ number_format($summary['seller_apps'] ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-1.5 pt-2 border-top border-light-subtle">
                    <span class="badge bg-primary-subtle text-primary px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-user-tag me-1"></i> تجار التجزئة
                    </span>
                </div>
            </div>
        </div>

        <!-- 4. Supplier Apps -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-3 h-100 position-relative overflow-hidden">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-2.5">
                        <div class="d-flex align-items-center justify-content-center rounded-3 text-white shadow-sm"
                            style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); width: 46px; height: 46px;">
                            <i class="fa-solid fa-truck-ramp-box fs-5"></i>
                        </div>
                        <div>
                            <small class="text-muted fw-semibold d-block">تطبيقات الموردين</small>
                            <h4 class="fw-bold mb-0 text-warning">{{ number_format($summary['supplier_apps'] ?? 0) }}</h4>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap gap-1.5 pt-2 border-top border-light-subtle">
                    <span class="badge bg-warning-subtle text-warning px-2 py-1 rounded-pill fw-semibold" style="font-size: 0.75rem;">
                        <i class="fa-solid fa-boxes-packing me-1"></i> تجار الجملة
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- App Usage Breakdown Grid -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 p-4 bg-white">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <h5 class="fw-bold text-dark mb-0 d-flex align-items-center gap-2">
                <i class="fa-solid fa-chart-simple text-primary"></i>
                <span>توزيع استخدام التطبيقات حسب الخدمة</span>
            </h5>
            <span class="badge bg-light text-muted border px-2.5 py-1.5 rounded-pill small">
                {{ count($appsDistribution) }} خدمات مدعومة
            </span>
        </div>

        <div class="row g-3">
            @foreach ($appsDistribution as $app)
                <div class="col-12 col-sm-6 col-md-4 col-xl-2">
                    <a href="{{ route('admin.apps.index', array_merge(request()->query(), ['app_name' => $app['key']])) }}"
                       class="text-decoration-none d-block h-100">
                        <div class="p-3 rounded-4 border transition-all h-100 d-flex flex-column justify-content-between {{ ($filters['app_name'] ?? '') === $app['key'] ? 'border-primary bg-primary bg-opacity-10 shadow-sm' : 'border-light-subtle bg-light-subtle hover-shadow' }}"
                             style="transition: all 0.2s ease-in-out;">
                            <div>
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <div class="rounded-3 d-flex align-items-center justify-content-center text-white"
                                         style="width: 36px; height: 36px; background-color: {{ $app['color'] }};">
                                        <i class="{{ $app['icon'] }} fs-6"></i>
                                    </div>
                                    <span class="badge {{ $app['bg_class'] }} rounded-pill px-2 py-1 fw-bold fs-7">
                                        {{ $app['total'] }}
                                    </span>
                                </div>
                                <h6 class="fw-bold text-dark mb-0 fs-7 text-truncate" title="{{ $app['name'] }}">{{ $app['name'] }}</h6>
                                <small class="text-muted d-block text-truncate fs-8">{{ $app['english_name'] }}</small>
                            </div>
                            <div class="mt-2.5 pt-2 border-top border-light-subtle">
                                <div class="d-flex justify-content-between align-items-center small text-muted fs-8 mb-1">
                                    <span>النسبة:</span>
                                    <span class="fw-bold text-dark">{{ $app['percentage'] }}%</span>
                                </div>
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar" role="progressbar" 
                                         style="width: {{ $app['percentage'] }}%; background-color: {{ $app['color'] }};" 
                                         aria-valuenow="{{ $app['percentage'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <div class="d-flex justify-content-between mt-1.5 fs-8 text-muted">
                                    <span>بائع: <strong class="text-primary">{{ $app['sellers'] }}</strong></span>
                                    <span>مورد: <strong class="text-warning">{{ $app['suppliers'] }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white p-3.5">
        <form method="GET" action="{{ route('admin.apps.index') }}" class="row g-2.5 align-items-center">
            <!-- Search Keyword -->
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="ابحث باسم المشترك، المتجر، أو البريد..."
                           value="{{ $filters['search'] ?? '' }}">
                </div>
            </div>

            <!-- Filter User Type -->
            <div class="col-6 col-md-2">
                <select name="type" class="form-select">
                    <option value="all" {{ ($filters['type'] ?? 'all') === 'all' ? 'selected' : '' }}>جميع المشتركين</option>
                    <option value="seller" {{ ($filters['type'] ?? '') === 'seller' ? 'selected' : '' }}>بائعين فقط</option>
                    <option value="supplier" {{ ($filters['type'] ?? '') === 'supplier' ? 'selected' : '' }}>موردين فقط</option>
                </select>
            </div>

            <!-- Filter App Name -->
            <div class="col-6 col-md-3">
                <select name="app_name" class="form-select">
                    <option value="all" {{ ($filters['app_name'] ?? 'all') === 'all' ? 'selected' : '' }}>جميع التطبيقات</option>
                    @foreach ($supportedApps as $key => $meta)
                        <option value="{{ $key }}" {{ ($filters['app_name'] ?? '') === $key ? 'selected' : '' }}>
                            {{ $meta['name'] }} ({{ $meta['english_name'] }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status -->
            <div class="col-6 col-md-2">
                <select name="status" class="form-select">
                    <option value="all" {{ ($filters['status'] ?? 'all') === 'all' ? 'selected' : '' }}>جميع الحالات</option>
                    <option value="active" {{ ($filters['status'] ?? '') === 'active' ? 'selected' : '' }}>نشط (Active)</option>
                    <option value="inactive" {{ ($filters['status'] ?? '') === 'inactive' ? 'selected' : '' }}>معطل (Inactive)</option>
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="col-6 col-md-1 d-flex gap-1.5">
                <button type="submit" class="btn btn-primary w-100 rounded-3 text-white fw-bold shadow-sm" title="تصفية">
                    <i class="fa-solid fa-filter"></i>
                </button>
                @if (!empty($filters['search']) || ($filters['type'] ?? 'all') !== 'all' || ($filters['app_name'] ?? 'all') !== 'all' || ($filters['status'] ?? 'all') !== 'all')
                    <a href="{{ route('admin.apps.index') }}" class="btn btn-outline-secondary rounded-3" title="إلغاء الفلترة">
                        <i class="fa-solid fa-rotate-left"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Data Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-bottom border-light-subtle d-flex align-items-center justify-content-between flex-wrap gap-2">
            <h5 class="fw-bold mb-0 text-dark d-flex align-items-center gap-2">
                <i class="fa-solid fa-table-list text-muted"></i>
                <span>قائمة التطبيقات المربوطة</span>
                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-2.5 py-1 fs-7">
                    {{ $appsList->total() }} تطبيق
                </span>
            </h5>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 text-nowrap">
                <thead class="table-light text-muted small">
                    <tr>
                        <th class="ps-4" style="width: 70px;">#</th>
                        <th>المشترك / المتجر</th>
                        <th>نوع الحساب</th>
                        <th>التطبيق</th>
                        <th>معلومات وبيانات الربط</th>
                        <th>الحالة</th>
                        <th>تاريخ الإضافة</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($appsList as $item)
                        @php
                            $user = $item->user;
                            $appMeta = $supportedApps[$item->app_name] ?? [
                                'name' => ucfirst(str_replace('_', ' ', $item->app_name)),
                                'english_name' => $item->app_name,
                                'icon' => 'fa-solid fa-cube',
                                'color' => '#6b7280',
                                'bg_class' => 'bg-secondary-subtle text-secondary',
                            ];
                            $dataArr = is_string($item->data) ? json_decode($item->data, true) : (is_array($item->data) ? $item->data : []);
                        @endphp
                        <tr>
                            <!-- ID -->
                            <td class="ps-4 text-muted fw-bold small">
                                #{{ $item->id }}
                            </td>

                            <!-- User / Store -->
                            <td>
                                @if ($user)
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm"
                                             style="width: 38px; height: 38px; background: linear-gradient(135deg, #a40c72 0%, #5c0649 100%); font-size: 0.9rem;">
                                            {{ mb_substr($user->name ?? 'م', 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark fs-7">
                                                @if ($user->type === 'seller')
                                                    <a href="{{ route('admin.seller.show', $user->id) }}" class="text-decoration-none text-dark hover-primary">
                                                        {{ $user->name }}
                                                    </a>
                                                @elseif ($user->type === 'supplier')
                                                    <a href="{{ route('admin.supplier.show', $user->id) }}" class="text-decoration-none text-dark hover-primary">
                                                        {{ $user->name }}
                                                    </a>
                                                @else
                                                    {{ $user->name }}
                                                @endif
                                            </div>
                                            <small class="text-muted d-block fs-8">
                                                <i class="fa-solid fa-shop me-1 text-muted"></i>{{ $user->store_name ?? 'متجر بدون اسم' }}
                                                @if($user->email)
                                                    <span class="mx-1">|</span>{{ $user->email }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted fst-italic small">مستخدم محذوف (ID: {{ $item->user_id }})</span>
                                @endif
                            </td>

                            <!-- User Type -->
                            <td>
                                @if ($user && $user->type === 'seller')
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2.5 py-1 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-store me-1"></i> بائع (Seller)
                                    </span>
                                @elseif ($user && $user->type === 'supplier')
                                    <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2.5 py-1 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-truck-ramp-box me-1"></i> مورد (Supplier)
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-secondary px-2 py-1 rounded-pill">
                                        {{ $user->type ?? 'غير محدد' }}
                                    </span>
                                @endif
                            </td>

                            <!-- App -->
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-2 d-flex align-items-center justify-content-center text-white"
                                         style="width: 32px; height: 32px; background-color: {{ $appMeta['color'] }};">
                                        <i class="{{ $appMeta['icon'] }} fs-7"></i>
                                    </div>
                                    <div>
                                        <span class="fw-bold text-dark d-block fs-7">{{ $appMeta['name'] }}</span>
                                        <small class="text-muted fs-8 font-monospace">{{ $item->app_name }}</small>
                                    </div>
                                </div>
                            </td>

                            <!-- Data Summary -->
                            <td>
                                @if (!empty($dataArr))
                                    <div class="d-flex flex-wrap gap-1" style="max-width: 320px;">
                                        @foreach ($dataArr as $key => $val)
                                            @if (is_scalar($val) && !empty($val))
                                                <span class="badge bg-light text-dark border font-monospace px-2 py-1 rounded-2 fs-8" title="{{ $key }}: {{ $val }}">
                                                    <span class="text-muted">{{ $key }}:</span> 
                                                    <strong>{{ Str::limit((string) $val, 25) }}</strong>
                                                </span>
                                            @endif
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted fs-8 fst-italic">لا توجد تفاصيل إضافية</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td>
                                @if ($item->status === 'active')
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-circle-check me-1"></i> نشط
                                    </span>
                                @else
                                    <span class="badge bg-secondary-subtle text-muted border border-secondary-subtle px-2.5 py-1 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-circle-xmark me-1"></i> معطل
                                    </span>
                                @endif
                            </td>

                            <!-- Date Created -->
                            <td>
                                <span class="d-block small text-dark fw-semibold">{{ $item->created_at ? $item->created_at->format('Y-m-d') : '—' }}</span>
                                <small class="text-muted fs-8">{{ $item->created_at ? $item->created_at->diffForHumans() : '' }}</small>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                                        <i class="fa-solid fa-cube text-muted fs-2"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-1">لا توجد تطبيقات مربوطة مطابقة للبحث</h6>
                                    <p class="text-muted small mb-3">حاول تعديل شروط البحث أو الفلاتر المحددة بالأعلى.</p>
                                    <a href="{{ route('admin.apps.index') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                        <i class="fa-solid fa-rotate-left me-1"></i> إعادة ضبط الفلاتر
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($appsList->hasPages())
            <div class="card-footer bg-white py-3 px-4 border-top border-light-subtle d-flex justify-content-center">
                {{ $appsList->links() }}
            </div>
        @endif
    </div>

</div>
