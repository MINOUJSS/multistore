<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-shop text-warning"></i>
                    <span>{{ __('إدارة اشتراكات المنصة') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    🏪 خطط اشتراك تجار التجزئة (Seller Plans)
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    التحكم الشامل في خطط البائعين، مدد التسعير والخصومات (30، 90، 180، 365 يوماً)، وضبط الصلاحيات والمميزات الخاصة بكل خطة بدقة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.seller_plans.create') }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm">
                        <i class="fa-solid fa-plus me-1"></i> إضافة خطة بائع جديدة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-circle-check fs-5 me-2 text-success"></i>
                <div class="fw-semibold">{{ session('success') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-center">
                <i class="fa-solid fa-triangle-exclamation fs-5 me-2 text-danger"></i>
                <div class="fw-semibold">{{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Statistics Overview Cards -->
    <div class="row g-3 mb-4">
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-icon-wrapper rounded-3" style="background-color: rgba(164, 12, 114, 0.1); color: #a40c72; width: 44px; height: 44px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-store fa-lg"></i>
                        </span>
                        <span class="badge px-2.5 py-1 rounded-pill fw-semibold small text-white" style="background-color: #a40c72;">الخطط</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">إجمالي خطط البائعين</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalPlans }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-icon-wrapper rounded-3 bg-success bg-opacity-10 text-success" style="width: 44px; height: 44px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-gift fa-lg"></i>
                        </span>
                        <span class="badge bg-success-subtle text-success px-2.5 py-1 rounded-pill fw-semibold small">مجانية</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">الخطط المجانية</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $freePlansCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-icon-wrapper rounded-3 bg-primary bg-opacity-10 text-primary" style="width: 44px; height: 44px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-tags fa-lg"></i>
                        </span>
                        <span class="badge bg-primary-subtle text-primary px-2.5 py-1 rounded-pill fw-semibold small">مدفوعة</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">الخطط المدفوعة</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $paidPlansCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <span class="stat-icon-wrapper rounded-3 bg-warning bg-opacity-10 text-warning" style="width: 44px; height: 44px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-users fa-lg"></i>
                        </span>
                        <span class="badge bg-warning-subtle text-warning px-2.5 py-1 rounded-pill fw-semibold small">مشتركين</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">إجمالي اشتراكات التجار</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $totalSubscriptions }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Plans Table Card -->
    <div class="card border-0 shadow-sm rounded-4 w-100 overflow-hidden" style="max-width: 100%;">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-list-check" style="color: #a40c72;"></i>
                <span class="fs-6">قائمة خطط تجار التجزئة المتوفرة</span>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill">
                    {{ $plans->count() }} خطة
                </span>
                <a href="{{ route('admin.seller_plans.create') }}" class="btn btn-sm btn-primary rounded-3 px-3 shadow-sm" style="background-color: #a40c72; border-color: #a40c72;">
                    <i class="fa-solid fa-plus me-1"></i> إضافة خطة جديدة
                </a>
            </div>
        </div>

        <div class="table-responsive p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-center">
                    <tr>
                        <th class="py-3">#</th>
                        <th class="py-3 text-start ps-4">اسم الخطة</th>
                        <th class="py-3">السعر الافتراضي</th>
                        <th class="py-3">فترات التسعير</th>
                        <th class="py-3">الصلاحيات والمميزات</th>
                        <th class="py-3">المشتركين</th>
                        <th class="py-3">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse ($plans as $plan)
                        <tr>
                            <td>
                                <span class="fw-bold text-muted dir-ltr">#{{ $plan->id }}</span>
                            </td>
                            <td class="text-start ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-sm rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="background: linear-gradient(135deg, rgba(164,12,114,0.15), rgba(190,6,129,0.25)); color: #a40c72; width: 40px; height: 40px; min-width: 40px;">
                                        <i class="fa-solid fa-shop"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark">
                                            <a href="{{ route('admin.seller_plans.show', $plan->id) }}" class="text-dark text-decoration-none hover-primary">
                                                {{ $plan->name }}
                                            </a>
                                        </h6>
                                        <small class="text-muted d-block text-truncate" style="max-width: 250px;">
                                            {{ $plan->description ?? 'لا يوجد وصف محدد للخطة' }}
                                        </small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($plan->price == 0)
                                    <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold fs-7">
                                        <i class="fa-solid fa-check me-1"></i> مجانية (0 د.ج)
                                    </span>
                                @else
                                    <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold fs-7">
                                        {{ number_format($plan->price, 2) }} د.ج
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.seller_plans.show', $plan->id) }}" class="text-decoration-none">
                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 py-1.5 rounded-pill fw-semibold">
                                        <i class="fa-solid fa-calendar-days me-1"></i> {{ $plan->pricing_count }} فترات
                                    </span>
                                </a>
                            </td>
                            <td>
                                <a href="{{ route('admin.seller_plans.show', $plan->id) }}" class="text-decoration-none">
                                    <span class="badge px-3 py-1.5 rounded-pill fw-semibold" style="background-color: rgba(164,12,114,0.1); color: #a40c72; border: 1px solid rgba(164,12,114,0.2);">
                                        <i class="fa-solid fa-shield-halved me-1"></i> {{ $plan->authorizations_count }} ميزة/صلاحية
                                    </span>
                                </a>
                            </td>
                            <td>
                                <span class="badge bg-secondary-subtle text-secondary px-3 py-1.5 rounded-pill fw-bold">
                                    <i class="fa-solid fa-user-check me-1"></i> {{ $plan->subscriptions_count }} تاجر
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                    <a href="{{ route('admin.seller_plans.show', $plan->id) }}"
                                       class="btn btn-sm btn-outline-primary rounded-3 px-2.5 py-1"
                                       title="إدارة فترات التسعير والصلاحيات">
                                        <i class="fa-solid fa-gear me-1"></i> تفاصيل وإدارة
                                    </a>

                                    <a href="{{ route('admin.seller_plans.edit', $plan->id) }}"
                                       class="btn btn-sm btn-outline-secondary rounded-3 px-2 py-1"
                                       title="تعديل الخطة">
                                        <i class="fa fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.seller_plans.destroy', $plan->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('هل أنت متأكد من حذف خطة البائع ({{ $plan->name }})؟ سيتم حذف جميع فترات التسعير والصلاحيات المرتبطة بها.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1" title="حذف الخطة">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted py-5 text-center">
                                <div class="py-4">
                                    <i class="fa-solid fa-store-slash fs-1 mb-3 d-block text-muted opacity-50"></i>
                                    <h5 class="fw-bold">لا توجد أي خطط لبائعي التجزئة مسجلة حتى الآن</h5>
                                    <p class="text-muted small">يمكنك البدء بإضافة أول خطة لتجار التجزئة للمنصة عبر الزر أدناه</p>
                                    <a href="{{ route('admin.seller_plans.create') }}" class="btn btn-primary rounded-3 px-4 py-2 mt-2 shadow-sm" style="background-color: #a40c72; border-color: #a40c72;">
                                        <i class="fa-solid fa-plus me-1"></i> إضافة خطة جديدة الآن
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<style>
.dashboard-stat-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.dashboard-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.07) !important;
}
.hover-primary:hover {
    color: #a40c72 !important;
}
</style>
