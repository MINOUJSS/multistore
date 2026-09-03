<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-layer-group text-warning"></i>
                    <span>{{ __('لوحة التحكم المركزية للخطة') }}</span>
                    <span class="opacity-50">|</span>
                    <span>#{{ $plan->id }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    ⚙️ إعدادات خطة: {{ $plan->name }}
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    إدارة فترات التسعير المتعددة (أيام الاشتراك)، وتعيين صلاحيات ومميزات المتجر للموردين المنضمين لهذه الخطة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.supplier_plans.edit', $plan->id) }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm">
                        <i class="fa-solid fa-pen-to-square me-1"></i> تعديل بيانات الخطة
                    </a>
                    <a href="{{ route('admin.supplier_plans.index') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm">
                        <i class="fa-solid fa-arrow-right me-1"></i> العودة للقائمة
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

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm border-0 mb-4" role="alert">
            <div class="d-flex align-items-start">
                <i class="fa-solid fa-triangle-exclamation fs-5 me-2 mt-1 text-danger"></i>
                <div>
                    <strong class="d-block mb-1">يرجى تصحيح الأخطاء التالية:</strong>
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Plan Summary Stats Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white overflow-hidden">
        <div class="card-body p-4">
            <div class="row g-4 align-items-center">
                <div class="col-md-3 border-start-md">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-4 d-flex align-items-center justify-content-center fw-bold shadow-sm" style="background: linear-gradient(135deg, rgba(164,12,114,0.15), rgba(190,6,129,0.25)); color: #a40c72; width: 56px; height: 56px; min-width: 56px;">
                            <i class="fa-solid fa-box-archive fs-4"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block">اسم الخطة</span>
                            <h5 class="fw-bold mb-0 text-dark">{{ $plan->name }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 border-start-md">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-4 d-flex align-items-center justify-content-center fw-bold shadow-sm bg-primary bg-opacity-10 text-primary" style="width: 56px; height: 56px; min-width: 56px;">
                            <i class="fa-solid fa-tag fs-4"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block">السعر الأساسي</span>
                            <h5 class="fw-bold mb-0 text-dark">
                                @if($plan->price == 0)
                                    <span class="text-success">مجانية (0 د.ج)</span>
                                @else
                                    {{ number_format($plan->price, 2) }} <small class="fs-7 text-muted">د.ج</small>
                                @endif
                            </h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 border-start-md">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-4 d-flex align-items-center justify-content-center fw-bold shadow-sm bg-warning bg-opacity-10 text-warning" style="width: 56px; height: 56px; min-width: 56px;">
                            <i class="fa-solid fa-users-line fs-4"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block">المشتركين الحاليين</span>
                            <h5 class="fw-bold mb-0 text-dark">{{ $plan->subscriptions->count() }} <small class="fs-7 text-muted">مورد</small></h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="d-flex align-items-center gap-3">
                        <div class="rounded-4 d-flex align-items-center justify-content-center fw-bold shadow-sm bg-success bg-opacity-10 text-success" style="width: 56px; height: 56px; min-width: 56px;">
                            <i class="fa-solid fa-shield-check fs-4"></i>
                        </div>
                        <div>
                            <span class="text-muted small d-block">الصلاحيات النشطة</span>
                            <h5 class="fw-bold mb-0 text-dark">
                                {{ $plan->Authorizations->where('is_enabled', true)->count() }} / {{ $plan->Authorizations->count() }}
                            </h5>
                        </div>
                    </div>
                </div>
            </div>

            @if($plan->description)
                <div class="mt-3 pt-3 border-top">
                    <span class="text-muted small fw-semibold">الوصف:</span>
                    <p class="text-dark mb-0 small mt-1">{{ $plan->description }}</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Pricing Tiers Section (جدول فترات وأسعار الخطة) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <div class="stat-icon-wrapper rounded-3" style="background-color: rgba(79, 70, 229, 0.1); color: #4f46e5; width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-dark">فترات التسعير المتاحة (Pricing Tiers)</h6>
                    <small class="text-muted">التحكم في مدد الاشتراك (أيام) والأسعار ونسب الخصم الترويجية</small>
                </div>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-primary rounded-3 px-3 shadow-sm" style="background-color: #a40c72; border-color: #a40c72;" data-bs-toggle="modal" data-bs-target="#addPriceModal">
                    <i class="fa-solid fa-plus me-1"></i> إضافة مدة / سعر جديد
                </button>
            </div>
        </div>

        <div class="table-responsive p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-center">
                    <tr>
                        <th class="py-3">#</th>
                        <th class="py-3">المدة (بالأيام)</th>
                        <th class="py-3">التسمية التقديرية</th>
                        <th class="py-3">السعر (د.ج)</th>
                        <th class="py-3">الخصم (Discount)</th>
                        <th class="py-3">السعر النهائي</th>
                        <th class="py-3">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($plan->pricing as $priceTier)
                        @php
                            $discountVal = $priceTier->discount ?? 0;
                            $finalPrice = $priceTier->price - ($priceTier->price * ($discountVal / 100));
                        @endphp
                        <tr>
                            <td>
                                <span class="fw-bold text-muted dir-ltr">#{{ $priceTier->id }}</span>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 py-2 rounded-pill fw-bold fs-7">
                                    <i class="fa-regular fa-clock me-1 text-primary"></i> {{ $priceTier->duration }} يوم
                                </span>
                            </td>
                            <td>
                                @if($priceTier->duration == 30)
                                    <span class="text-muted small fw-semibold">اشتراك شهري (1 شهر)</span>
                                @elseif($priceTier->duration == 90)
                                    <span class="text-muted small fw-semibold">اشتراك فصلي (3 أشهر)</span>
                                @elseif($priceTier->duration == 180)
                                    <span class="text-muted small fw-semibold">اشتراك نصف سنوي (6 أشهر)</span>
                                @elseif($priceTier->duration == 365)
                                    <span class="text-muted small fw-semibold">اشتراك سنوي (1 سنة)</span>
                                @else
                                    <span class="text-muted small fw-semibold">{{ round($priceTier->duration / 30, 1) }} شهر تقريباً</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold text-dark">{{ number_format($priceTier->price, 2) }} د.ج</span>
                            </td>
                            <td>
                                @if($discountVal > 0)
                                    <span class="badge bg-danger-subtle text-danger px-2.5 py-1 rounded-pill fw-semibold">
                                        {{ $discountVal }}% خصم
                                    </span>
                                @else
                                    <span class="text-muted small">بدون خصم</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold text-success">{{ number_format($finalPrice, 2) }} د.ج</span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    <button type="button"
                                            class="btn btn-sm btn-outline-secondary rounded-3 px-2 py-1 edit-price-btn"
                                            data-id="{{ $priceTier->id }}"
                                            data-duration="{{ $priceTier->duration }}"
                                            data-price="{{ $priceTier->price }}"
                                            data-discount="{{ $priceTier->discount ?? 0 }}"
                                            data-action="{{ route('admin.supplier_plans.prices.update', $priceTier->id) }}"
                                            title="تعديل المدة أو السعر">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <form action="{{ route('admin.supplier_plans.prices.destroy', $priceTier->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('هل أنت متأكد من حذف فترة التسعير ({{ $priceTier->duration }} يوم)؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1" title="حذف فترة التسعير">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-muted py-4 text-center">
                                <i class="fa-solid fa-calendar-xmark fs-2 mb-2 d-block text-muted opacity-50"></i>
                                <span class="fw-semibold">لا توجد فترات تسعير مخصصة لهذه الخطة حتى الآن.</span>
                                <p class="text-muted small mb-2">يمكنك إضافة خيارات تسعير كالاشتراك الشهري (30 يوماً)، الفصلي (90 يوماً) أو السنوي (365 يوماً).</p>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#addPriceModal">
                                    <i class="fa-solid fa-plus me-1"></i> إضافة أول فترة تسعير
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Plan Authorizations & Features Section (جدول صلاحيات ومميزات الخطة) -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <div class="stat-icon-wrapper rounded-3" style="background-color: rgba(16, 185, 129, 0.1); color: #10b981; width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center;">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-dark">صلاحيات ومميزات الخطة (Plan Authorizations)</h6>
                    <small class="text-muted">التحكم في الميزات البرمجية (البيكسل، عدد المنتجات، بوابات الدفع، الدومين) لكل خطة</small>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <button type="button" class="btn btn-sm btn-primary rounded-3 px-3 shadow-sm" style="background-color: #a40c72; border-color: #a40c72;" data-bs-toggle="modal" data-bs-target="#addAuthModal">
                    <i class="fa-solid fa-plus me-1"></i> إضافة صلاحية جديدة
                </button>
            </div>
        </div>

        <div class="table-responsive p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-muted small text-center">
                    <tr>
                        <th class="py-3">#</th>
                        <th class="py-3 text-start ps-4">الميزة / الوصف المعروض للمورد</th>
                        <th class="py-3">مفتاح الصلاحية (Key)</th>
                        <th class="py-3">القيمة (Value)</th>
                        <th class="py-3">الحالة (مفعلة / معطلة)</th>
                        <th class="py-3">الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="text-center">
                    @forelse($plan->Authorizations as $auth)
                        <tr>
                            <td>
                                <span class="fw-bold text-muted dir-ltr">#{{ $auth->id }}</span>
                            </td>
                            <td class="text-start ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    @if($auth->is_enabled)
                                        <i class="fa-solid fa-circle-check text-success fs-5"></i>
                                    @else
                                        <i class="fa-solid fa-circle-xmark text-danger fs-5"></i>
                                    @endif
                                    <div>
                                        <span class="fw-bold text-dark d-block">{{ $auth->description }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <code class="bg-light px-2 py-1 rounded text-primary fw-semibold border dir-ltr">{{ $auth->permission_key }}</code>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill fw-bold">
                                    {{ $auth->permission_value ?? '1' }}
                                </span>
                            </td>
                            <td>
                                <form action="{{ route('admin.supplier_plans.authorizations.toggle', $auth->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm {{ $auth->is_enabled ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-3 py-1 shadow-none" title="اضغط للتبديل بين التفعيل والتعطيل">
                                        @if($auth->is_enabled)
                                            <i class="fa-solid fa-check me-1"></i> مفعلة
                                        @else
                                            <i class="fa-solid fa-ban me-1"></i> معطلة
                                        @endif
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center align-items-center gap-1">
                                    <button type="button"
                                            class="btn btn-sm btn-outline-secondary rounded-3 px-2 py-1 edit-auth-btn"
                                            data-id="{{ $auth->id }}"
                                            data-key="{{ $auth->permission_key }}"
                                            data-value="{{ $auth->permission_value }}"
                                            data-description="{{ $auth->description }}"
                                            data-enabled="{{ $auth->is_enabled ? 1 : 0 }}"
                                            data-action="{{ route('admin.supplier_plans.authorizations.update', $auth->id) }}"
                                            title="تعديل الصلاحية">
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <form action="{{ route('admin.supplier_plans.authorizations.destroy', $auth->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('هل أنت متأكد من حذف الصلاحية ({{ $auth->permission_key }}) من هذه الخطة؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2 py-1" title="حذف الصلاحية">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-muted py-4 text-center">
                                <i class="fa-solid fa-shield-slash fs-2 mb-2 d-block text-muted opacity-50"></i>
                                <span class="fw-semibold">لا توجد صلاحيات أو مميزات محددة لهذه الخطة حتى الآن.</span>
                                <p class="text-muted small mb-2">يمكنك إضافة صلاحيات ومميزات مخصصة للموردين من خلال الزر أدناه.</p>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-3 px-3" data-bs-toggle="modal" data-bs-target="#addAuthModal">
                                    <i class="fa-solid fa-plus me-1"></i> إضافة أول صلاحية
                                </button>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- ======================================================== -->
<!-- MODAL: ADD PRICING TIER -->
<!-- ======================================================== -->
<div class="modal fade" id="addPriceModal" tabindex="-1" aria-labelledby="addPriceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-dark" id="addPriceModalLabel">
                    <i class="fa-solid fa-calendar-plus text-primary me-2"></i> إضافة فترة تسعير جديدة
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.supplier_plans.prices.store', $plan->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="duration" class="form-label fw-semibold text-dark">
                            المدة بالأيام <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number"
                                   name="duration"
                                   id="duration"
                                   class="form-control rounded-start-3"
                                   placeholder="مثال: 30 أو 90 أو 180 أو 365"
                                   min="1"
                                   required>
                            <span class="input-group-text bg-light text-muted">يوم</span>
                        </div>
                        <div class="d-flex gap-2 mt-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill duration-quick-set" data-days="30">30 يوم (شهر)</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill duration-quick-set" data-days="90">90 يوم (3 أشهر)</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill duration-quick-set" data-days="180">180 يوم (6 أشهر)</button>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill duration-quick-set" data-days="365">365 يوم (سنة)</button>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="price" class="form-label fw-semibold text-dark">
                            السعر لهذه المدة (د.ج) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number"
                                   name="price"
                                   id="price"
                                   class="form-control rounded-start-3"
                                   step="0.01"
                                   min="0"
                                   placeholder="0.00"
                                   required>
                            <span class="input-group-text bg-light text-muted">د.ج (DZD)</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="discount" class="form-label fw-semibold text-dark">
                            نسبة الخصم المئوية (%) (اختياري)
                        </label>
                        <div class="input-group">
                            <input type="number"
                                   name="discount"
                                   id="discount"
                                   class="form-control rounded-start-3"
                                   step="0.01"
                                   min="0"
                                   max="100"
                                   placeholder="0"
                                   value="0">
                            <span class="input-group-text bg-light text-muted">%</span>
                        </div>
                        <small class="text-muted">أدخل 0 إذا لم يكن هناك خصم مطبق.</small>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3 px-4">
                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm" style="background-color: #a40c72; border-color: #a40c72;">
                        <i class="fa-solid fa-check me-1"></i> حفظ فترة التسعير
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: EDIT PRICING TIER -->
<!-- ======================================================== -->
<div class="modal fade" id="editPriceModal" tabindex="-1" aria-labelledby="editPriceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-dark" id="editPriceModalLabel">
                    <i class="fa-solid fa-pen-to-square text-secondary me-2"></i> تعديل فترة التسعير
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editPriceForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="edit_duration" class="form-label fw-semibold text-dark">
                            المدة بالأيام <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number"
                                   name="duration"
                                   id="edit_duration"
                                   class="form-control rounded-start-3"
                                   min="1"
                                   required>
                            <span class="input-group-text bg-light text-muted">يوم</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_price" class="form-label fw-semibold text-dark">
                            السعر لهذه المدة (د.ج) <span class="text-danger">*</span>
                        </label>
                        <div class="input-group">
                            <input type="number"
                                   name="price"
                                   id="edit_price"
                                   class="form-control rounded-start-3"
                                   step="0.01"
                                   min="0"
                                   required>
                            <span class="input-group-text bg-light text-muted">د.ج (DZD)</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="edit_discount" class="form-label fw-semibold text-dark">
                            نسبة الخصم المئوية (%)
                        </label>
                        <div class="input-group">
                            <input type="number"
                                   name="discount"
                                   id="edit_discount"
                                   class="form-control rounded-start-3"
                                   step="0.01"
                                   min="0"
                                   max="100">
                            <span class="input-group-text bg-light text-muted">%</span>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3 px-4">
                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm" style="background-color: #a40c72; border-color: #a40c72;">
                        <i class="fa-solid fa-save me-1"></i> حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: ADD AUTHORIZATION / PERMISSION -->
<!-- ======================================================== -->
<div class="modal fade" id="addAuthModal" tabindex="-1" aria-labelledby="addAuthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-dark" id="addAuthModalLabel">
                    <i class="fa-solid fa-shield-plus text-success me-2"></i> إضافة صلاحية / ميزة للخطة
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.supplier_plans.authorizations.store', $plan->id) }}" method="POST">
                @csrf
                <div class="modal-body p-4">

                    <!-- Quick Preset Selector -->
                    <div class="mb-4 p-3 rounded-3" style="background-color: rgba(164,12,114,0.06); border: 1px dashed rgba(164,12,114,0.3);">
                        <label class="form-label fw-bold text-dark d-flex align-items-center gap-2 mb-1">
                            <i class="fa-solid fa-wand-magic-sparkles text-primary"></i>
                            <span>اختيار مسبق من ميزات النظام الشائعة (Presets)</span>
                        </label>
                        <small class="text-muted d-block mb-2">يمكنك اختيار ميزة جاهزة لملء الحقول تلقائياً، أو تركها فارغة وكتابة صلاحية مخصصة.</small>
                        <select id="preset_selector" class="form-select rounded-3">
                            <option value="">-- اختر ميزة شائعة لتعبئتها تلقائياً --</option>
                            @foreach($presets as $preset)
                                <option value="{{ $preset['key'] }}"
                                        data-description="{{ $preset['label'] }}"
                                        data-value="{{ $preset['default_value'] }}">
                                    {{ $preset['label'] }} ({{ $preset['key'] }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="permission_key" class="form-label fw-semibold text-dark">
                                مفتاح الصلاحية (Permission Key) <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="permission_key"
                                   id="permission_key"
                                   class="form-control rounded-3 dir-ltr"
                                   placeholder="مثال: max_products أو chargily_pay"
                                   required>
                            <small class="text-muted">المفتاح البرمجي المستخدم لفحص الصلاحية في الكود.</small>
                        </div>

                        <div class="col-md-6">
                            <label for="permission_value" class="form-label fw-semibold text-dark">
                                قيمة الصلاحية (Permission Value)
                            </label>
                            <input type="text"
                                   name="permission_value"
                                   id="permission_value"
                                   class="form-control rounded-3"
                                   placeholder="مثال: 100 أو 1 أو 0"
                                   value="1">
                            <small class="text-muted">الحد الأقصى أو القيمة العددية للصلاحية (1 للميزات المفعلة).</small>
                        </div>

                        <div class="col-12">
                            <label for="description" class="form-label fw-semibold text-dark">
                                وصف الميزة الظاهر للمورد <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="description"
                                   id="description"
                                   class="form-control rounded-3"
                                   placeholder="مثال: أقصى عدد منتجات مسموح به (50 منتج)"
                                   required>
                            <small class="text-muted">النص الذي يراه المورد في جدول مقارنة الخطط وفي لوحة تحكمه.</small>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch p-0 mt-2">
                                <label class="form-check-label fw-semibold text-dark ms-2" for="is_enabled">
                                    تفعيل هذه الصلاحية فوراً في هذه الخطة
                                </label>
                                <input class="form-check-input float-end"
                                       type="checkbox"
                                       role="switch"
                                       name="is_enabled"
                                       id="is_enabled"
                                       value="1"
                                       checked>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3 px-4">
                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm" style="background-color: #a40c72; border-color: #a40c72;">
                        <i class="fa-solid fa-check me-1"></i> إضافة الصلاحية
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ======================================================== -->
<!-- MODAL: EDIT AUTHORIZATION / PERMISSION -->
<!-- ======================================================== -->
<div class="modal fade" id="editAuthModal" tabindex="-1" aria-labelledby="editAuthModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-light border-0 py-3 px-4">
                <h5 class="modal-title fw-bold text-dark" id="editAuthModalLabel">
                    <i class="fa-solid fa-pen-to-square text-secondary me-2"></i> تعديل الصلاحية / الميزة
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editAuthForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="edit_permission_key" class="form-label fw-semibold text-dark">
                                مفتاح الصلاحية (Permission Key) <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="permission_key"
                                   id="edit_permission_key"
                                   class="form-control rounded-3 dir-ltr"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label for="edit_permission_value" class="form-label fw-semibold text-dark">
                                قيمة الصلاحية (Permission Value)
                            </label>
                            <input type="text"
                                   name="permission_value"
                                   id="edit_permission_value"
                                   class="form-control rounded-3">
                        </div>

                        <div class="col-12">
                            <label for="edit_description" class="form-label fw-semibold text-dark">
                                وصف الميزة الظاهر للمورد <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="description"
                                   id="edit_description"
                                   class="form-control rounded-3"
                                   required>
                        </div>

                        <div class="col-12">
                            <div class="form-check form-switch p-0 mt-2">
                                <label class="form-check-label fw-semibold text-dark ms-2" for="edit_is_enabled">
                                    تفعيل هذه الصلاحية
                                </label>
                                <input class="form-check-input float-end"
                                       type="checkbox"
                                       role="switch"
                                       name="is_enabled"
                                       id="edit_is_enabled"
                                       value="1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-light border-0 py-3 px-4">
                    <button type="button" class="btn btn-light rounded-3 px-3" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary rounded-3 px-4 fw-bold shadow-sm" style="background-color: #a40c72; border-color: #a40c72;">
                        <i class="fa-solid fa-save me-1"></i> حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Quick duration button clicks in Add Price modal
    document.querySelectorAll('.duration-quick-set').forEach(function (btn) {
        btn.addEventListener('click', function () {
            document.getElementById('duration').value = this.getAttribute('data-days');
        });
    });

    // Populate Edit Price modal
    document.querySelectorAll('.edit-price-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var action = this.getAttribute('data-action');
            var duration = this.getAttribute('data-duration');
            var price = this.getAttribute('data-price');
            var discount = this.getAttribute('data-discount');

            document.getElementById('editPriceForm').action = action;
            document.getElementById('edit_duration').value = duration;
            document.getElementById('edit_price').value = price;
            document.getElementById('edit_discount').value = discount;

            var modal = new bootstrap.Modal(document.getElementById('editPriceModal'));
            modal.show();
        });
    });

    // Preset selector in Add Auth modal
    var presetSelector = document.getElementById('preset_selector');
    if (presetSelector) {
        presetSelector.addEventListener('change', function () {
            var selectedOpt = this.options[this.selectedIndex];
            if (this.value) {
                document.getElementById('permission_key').value = this.value;
                document.getElementById('description').value = selectedOpt.getAttribute('data-description') || '';
                document.getElementById('permission_value').value = selectedOpt.getAttribute('data-value') || '1';
            }
        });
    }

    // Populate Edit Auth modal
    document.querySelectorAll('.edit-auth-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var action = this.getAttribute('data-action');
            var key = this.getAttribute('data-key');
            var value = this.getAttribute('data-value');
            var desc = this.getAttribute('data-description');
            var isEnabled = this.getAttribute('data-enabled') === '1';

            document.getElementById('editAuthForm').action = action;
            document.getElementById('edit_permission_key').value = key;
            document.getElementById('edit_permission_value').value = value;
            document.getElementById('edit_description').value = desc;
            document.getElementById('edit_is_enabled').checked = isEnabled;

            var modal = new bootstrap.Modal(document.getElementById('editAuthModal'));
            modal.show();
        });
    });
});
</script>

<style>
@media (min-width: 768px) {
    .border-start-md {
        border-left: 1px solid rgba(0, 0, 0, 0.08) !important;
    }
}
</style>
