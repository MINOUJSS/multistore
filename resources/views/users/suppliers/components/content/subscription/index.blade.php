@if (session('success'))
    <script>
        Swal.fire({
            title: 'نجاح!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'حسنًا'
        });
    </script>
@endif

<div class="container-fluid py-3 px-3 px-md-4">
    @php
        $supplierData = get_supplier_data(auth()->user()->tenant_id);
        $currentPlanId = $supplierData->plan_subscription->plan_id ?? null;
        $currentPlan = get_supplier_plan_data($currentPlanId);
    @endphp

    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #2563eb 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-gem text-warning"></i>
                    <span class="fw-semibold">{{ __('خطط الاشتراكات والترقية للتوريد') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    اشتراك الباقة والترقية للتوريد 💳
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    اختر الباقة المناسبة لتجارتك الجملة والتوريد واستمتع بجميع المميزات المتقدمة لزيادة مبيعاتك وتوسيع شبكة عملائك.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                @if($currentPlan)
                    <div class="d-inline-flex flex-column align-items-lg-end bg-white bg-opacity-10 p-3 rounded-4 border border-white border-opacity-15 backdrop-blur">
                        <span class="text-white-50 small mb-1">الخطة الحالية لحسابك</span>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-warning text-dark fw-bold px-3 py-1.5 fs-6 rounded-pill">
                                {{ $currentPlan->name }}
                            </span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!-- Decorative Glow Background Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10"
            style="width: 250px; height: 250px; top: -60px; left: -60px; pointer-events: none; filter: blur(40px);">
        </div>
        <div class="position-absolute rounded-circle bg-primary opacity-10"
            style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);">
        </div>
    </div>

    @if (is_supplier_has_plan_order(get_supplier_data(auth()->user()->tenant_id)->id) &&
            get_supplier_data(auth()->user()->tenant_id)->orderPlan[0]->payment_method != null)
        <!-- Pending Plan Order Alert Card -->
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
            <div class="card-body p-4 text-center">
                <div class="d-inline-flex align-items-center justify-content-center avatar avatar-xl rounded-circle bg-success-subtle text-success mb-3" style="width: 64px; height: 64px;">
                    <i class="fa-solid fa-clock-rotate-left fs-2"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">طلب الاشتراك قيد المعالجة</h4>
                <div class="alert alert-success border-0 bg-success-subtle text-success-emphasis rounded-3 p-3 mb-0 d-inline-block text-start" style="max-width: 650px;">
                    <div class="d-flex align-items-center gap-2">
                        <i class="fa-solid fa-circle-check fs-5 flex-shrink-0"></i>
                        <span class="fw-semibold">
                            تم إستلام طلب إشتراككم في الخطة <b>{{ get_supplier_plan_data(get_supplier_data(auth()->user()->tenant_id)->orderPlan[0]->plan_id)->name }}</b>. سيتم تفعيل إشتراككم في أقرب وقت ممكن . شكراً لكم.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    @else
        <!-- Available Plans Grid -->
        <div class="mb-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="avatar avatar-md rounded-3 bg-navy-subtle text-navy fw-bold me-1"
                        style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-layer-group fs-6"></i>
                    </span>
                    <h4 class="fw-bold mb-0 text-dark fs-5">الخطط المتاحة للاشتراك والترقية</h4>
                </div>
            </div>

            <div class="row g-4">
                @foreach ($plans as $plan)
                    @php
                        $isActive =
                            $plan->id ==
                            get_supplier_subscription_data(get_supplier_data(auth()->user()->tenant_id)->id)->plan_id;
                        $authorizations = $plan->Authorizations;
                        $pricing = $plan->pricing;
                    @endphp
                    <div class="col-12 col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden bg-white hover-lift transition-all position-relative {{ $isActive ? 'border border-2 border-navy-subtle' : '' }}">
                            @if($isActive)
                                <div class="position-absolute top-0 end-0 m-3 z-2">
                                    <span class="badge bg-navy-subtle text-navy border border-navy-subtle rounded-pill px-3 py-1.5 fw-bold">
                                        <i class="fa-solid fa-circle-check me-1"></i> الخطة الحالية
                                    </span>
                                </div>
                            @endif

                            <div class="card-header bg-white border-0 pt-4 px-4 pb-3 text-center">
                                <span class="avatar avatar-lg rounded-4 bg-navy-subtle text-navy mb-3"
                                    style="width: 54px; height: 54px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fa-solid {{ $plan->id == 1 ? 'fa-rocket' : ($plan->id == 2 ? 'fa-bolt' : 'fa-crown') }} fs-3"></i>
                                </span>
                                <h4 class="fw-bold text-dark mb-2">الخطة {{ $plan->name }}</h4>
                                
                                <form action="{{ route('supplier.subscription.order.plan', $plan->id) }}" method="POST" class="text-center">
                                    @csrf
                                    <div class="d-flex align-items-baseline justify-content-center gap-1 mb-3">
                                        <span class="display-6 fw-bold text-dark">{{ $plan->price }}</span>
                                        <span class="fw-bold text-secondary">د.ج</span>
                                        <span class="text-muted small">/ الشهر</span>
                                    </div>

                                    @if ($pricing->count() > 0)
                                        <div class="p-3 bg-light rounded-3 text-start mb-3" style="{{ $plan->id == get_supplier_data(auth()->user()->tenant_id)->plan_subscription->plan_id || get_supplier_data(auth()->user()->tenant_id)->plan_subscription->plan_id == 3 ? 'display:none;' : '' }}">
                                            <h6 class="fw-bold text-dark mb-2 small"><i class="fa-solid fa-tags me-1 text-navy"></i> عروض ومدد الاشتراك:</h6>
                                            <div class="d-flex flex-column gap-2">
                                                <label class="p-2 bg-white rounded-3 border d-flex align-items-center justify-content-between cursor-pointer mb-0">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <input type="radio" name="sub_plan_id" value="0" checked class="form-check-input shadow-none">
                                                        <span class="fw-semibold small text-dark">30 يوم</span>
                                                    </div>
                                                    <span class="badge bg-light text-dark fw-bold">{{ $plan->price }} د.ج</span>
                                                </label>
                                                @foreach ($pricing as $price)
                                                    <label class="p-2 bg-white rounded-3 border d-flex align-items-center justify-content-between cursor-pointer mb-0">
                                                        <div class="d-flex align-items-center gap-2">
                                                            <input type="radio" name="sub_plan_id" value="{{ $price->id }}" class="form-check-input shadow-none">
                                                            <span class="fw-semibold small text-dark">{{ $price->duration }} يوم</span>
                                                        </div>
                                                        <span class="badge bg-navy-subtle text-navy fw-bold">{{ $price->price }} د.ج</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                            </div>

                            <div class="card-body p-4 pt-0 d-flex flex-column justify-content-between">
                                <div>
                                    <h6 class="fw-bold text-secondary small mb-3 border-bottom pb-2">مميزات الخطة:</h6>
                                    <ul class="list-unstyled mb-4 d-flex flex-column gap-2">
                                        @foreach ($authorizations as $authorization)
                                            <li class="d-flex align-items-start gap-2.5 small">
                                                @if ($authorization['is_enabled'])
                                                    <i class="fa-solid fa-circle-check text-success fs-6 mt-0.5 flex-shrink-0"></i>
                                                    <span class="text-dark fw-medium">{{ $authorization['description'] }}</span>
                                                @else
                                                    <i class="fa-solid fa-circle-xmark text-danger opacity-50 fs-6 mt-0.5 flex-shrink-0"></i>
                                                    <span class="text-muted text-decoration-line-through">{{ $authorization['description'] }}</span>
                                                    <span class="badge bg-light text-muted ms-auto small">(غير متاح)</span>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <button type="submit"
                                    class="btn btn-supplier-primary w-100 rounded-3 py-2.5 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2 mt-3"
                                    {{ $isActive ? 'disabled' : '' }}
                                    {{ $plan->id == 1 || $plan->id == get_supplier_data(auth()->user()->tenant_id)->plan_subscription->plan_id || get_supplier_data(auth()->user()->tenant_id)->plan_subscription->plan_id == 3 ? 'hidden' : '' }}>
                                    <i class="fa-solid fa-bolt"></i>
                                    <span>قم بالترقية الآن</span>
                                </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>

<style>
    .bg-navy-subtle {
        background-color: rgba(15, 23, 42, 0.1);
    }

    .border-navy-subtle {
        border-color: rgba(15, 23, 42, 0.25) !important;
    }

    .text-navy {
        color: #0f172a !important;
    }

    .bg-supplier-header {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        color: #ffffff !important;
    }

    .btn-supplier-primary {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%) !important;
        color: #ffffff !important;
        border: none !important;
    }

    .btn-supplier-primary:hover {
        background: linear-gradient(135deg, #1e293b 0%, #334155 100%) !important;
        color: #ffffff !important;
    }

    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-4px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08) !important;
    }

    .avatar-md {
        width: 48px;
        height: 48px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-lg {
        width: 54px;
        height: 54px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .avatar-xl {
        width: 64px;
        height: 64px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>
