<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #2563eb 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-credit-card text-warning"></i>
                    <span class="fw-semibold">{{ __('تأكيد الاشتراك والدفع النهائي للتوريد') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    تأكيد ودفع قيمة الاشتراك للتوريد 💳
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    راجع تفاصيل خطة التوريد المحددة ومعادلة التكلفة الصافية، ثم اختر طريقة الدفع المناسبة لإكمال عملية الترقية بنجاح.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('supplier.subscription') }}"
                    class="btn btn-light text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
                    <i class="fas fa-arrow-right"></i>
                    <span>الرجوع للخطط</span>
                </a>
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

    <!-- Checkout Main Content Card -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-9 col-xl-8">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white mb-4">
                <div class="card-header bg-white border-0 py-3.5 px-4 border-bottom border-light">
                    <div class="d-flex align-items-center gap-2">
                        <span class="avatar avatar-md rounded-3 bg-navy-subtle text-navy fw-bold"
                            style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-file-invoice-dollar fs-6"></i>
                        </span>
                        <h5 class="fw-bold mb-0 text-dark fs-6">تفاصيل طلب ترقية باقة التوريد</h5>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    @php
                        $planData = get_supplier_plan_data($order->plan_id);
                    @endphp

                    <!-- معلومات الخطة المختارة -->
                    <div class="p-4 rounded-4 bg-light-subtle border mb-4">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-3">
                            <div>
                                <span class="badge bg-navy-subtle text-navy fw-bold px-3 py-1.5 rounded-pill mb-2">
                                    الخطة المختارة
                                </span>
                                <h3 class="fw-bold text-dark mb-1">الخطة: {{ $planData->name }}</h3>
                                <p class="text-muted small mb-0">{{ $planData->description }}</p>
                            </div>
                            <div class="text-lg-end">
                                <span class="fs-3 fw-bold text-success">{{ $plan_price }}</span>
                                <span class="fw-bold text-success fs-6">د.ج</span>
                                <div class="text-muted small">/ {{ $subscriptionDuration }} يوم</div>
                            </div>
                        </div>

                        <h6 class="fw-bold text-secondary small border-top pt-3 mb-2">المميزات المضمنة:</h6>
                        <ul class="list-unstyled mb-0 d-grid gap-2" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));">
                            @foreach ($planData->authorizations as $item)
                                <li class="d-flex align-items-center gap-2 small">
                                    @if($item->is_enabled)
                                        <i class="fa-solid fa-circle-check text-success fs-6"></i>
                                        <span class="text-dark fw-medium">{{ $item->description }}</span>
                                    @else
                                        <i class="fa-solid fa-circle-xmark text-danger opacity-50 fs-6"></i>
                                        <span class="text-muted text-decoration-line-through">{{ $item->description }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- ملخص الاشتراك والعملية الحسابية -->
                    @php
                        $rest_days = $old_subscription->duration - appDiffInDays(now(), $old_subscription->subscription_start_date);
                        $subscription_rest = get_rest_off_current_supplier_plan(
                            $old_subscription->supplier_id,
                            $old_subscription->plan_id,
                            $order->plan_id,
                            $rest_days
                        );
                        $total = $order->price;
                    @endphp

                    @if ($old_subscription->plan_id == 1 && in_array($order->plan_id, [2, 3]))
                        <div class="p-3.5 rounded-3 bg-navy-subtle border border-navy-subtle mb-4">
                            <h6 class="fw-bold text-navy mb-3"><i class="fa-solid fa-calculator me-1"></i> ملخص الاشتراك الجديد:</h6>
                            <div class="row g-2">
                                <div class="col-6">
                                    <div class="p-2.5 bg-white rounded-3 border">
                                        <span class="text-muted small d-block mb-1">المدة المتبقية بالخطة السابقة</span>
                                        <span class="fw-bold text-dark">مدى الحياة</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-2.5 bg-white rounded-3 border">
                                        <span class="text-muted small d-block mb-1">المبلغ الصافي المطلوب للدفع</span>
                                        <span class="fw-bold text-navy fs-5">{{ $total }} د.ج</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @elseif ($old_subscription->plan_id == 2 && $order->plan_id == 3)
                        <div class="p-3.5 rounded-3 bg-navy-subtle border border-navy-subtle mb-4">
                            <h6 class="fw-bold text-navy mb-3"><i class="fa-solid fa-calculator me-1"></i> ملخص تصفية الرصيد والاشتراك:</h6>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <div class="p-2.5 bg-white rounded-3 border">
                                        <span class="text-muted small d-block mb-1">المدة المتبقية</span>
                                        <span class="fw-bold text-dark">{{ $rest_days }} يوم</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-2.5 bg-white rounded-3 border">
                                        <span class="text-muted small d-block mb-1">القيمة المتبقية المحتسبة</span>
                                        <span class="fw-bold text-success">{{ $subscription_rest }} د.ج</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-2.5 bg-white rounded-3 border">
                                        <span class="text-muted small d-block mb-1">المبلغ المطلوب للدفع</span>
                                        <span class="fw-bold text-navy fs-5">{{ $total < 0 ? 0 : $total }} د.ج</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- نموذج الدفع -->
                    <form action="{{ route('supplier.subscription.paymethod.redirect') }}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="hidden" name="plan_id" value="{{ $order->plan_id }}">
                        <input type="hidden" name="old_plan_id" value="{{ $old_subscription->plan_id }}">
                        <input type="hidden" name="sub_plan_id" value="{{ $sub_plan !== null ? $sub_plan->id : '0' }}">

                        <div class="mb-4">
                            @if ($order->price <= 0)
                                <div class="alert alert-success border-0 bg-success-subtle text-success-emphasis rounded-3 p-3 mb-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fa-solid fa-circle-check fs-5 flex-shrink-0"></i>
                                        <span class="fw-semibold">
                                            بالضغط على زر تأكيد الطلب يتم الإنتقال إلى الخطة <b>{{ $planData->name }}</b> و شحن الرصيد بـ: <b>{{ abs(get_plan_price_from_id_and_duration($order->plan_id, $order->duration) - $old_subscription->price) }} د.ج</b>
                                        </span>
                                    </div>
                                </div>
                                <input type="hidden" name="paymentMethod" value="system">
                            @else
                                <label for="paymentMethod" class="form-label fw-bold text-dark small">اختر طريقة الدفع المناسبة <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 rounded-start-3 text-muted"><i class="fa-solid fa-wallet"></i></span>
                                    <select class="form-select rounded-end-3 shadow-none border-start-0 py-2.5" id="paymentMethod" name="paymentMethod" required>
                                        <option value="">-- اختر طريقة الدفع --</option>
                                        <option value="Chargily">💳 Chargily (البطاقة الذهبية / CIB)</option>
                                        <option value="baridimob">📱 بريدي موب BaridiMob</option>
                                        <option value="ccp">🏦 الحساب البريدي CCP</option>
                                        <option value="wallet">👛 المحفظة الإلكترونية Wallet</option>
                                    </select>
                                </div>
                            @endif
                        </div>

                        <button type="submit"
                            class="btn btn-supplier-primary w-100 rounded-3 py-3 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2 fs-6">
                            <i class="fa-solid fa-shield-halved"></i>
                            <span>تأكيد الطلب والمتابعة للدفع</span>
                        </button>
                    </form>

                    <!-- ملاحظة التفعيل -->
                    <div class="text-center mt-4">
                        <span class="badge bg-light text-muted fw-normal px-3 py-2 rounded-pill border">
                            <i class="fa-solid fa-lock text-success me-1"></i> سيتم تفعيل الخطة مباشرة بعد تأكيد عملية الدفع.
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

    .avatar-md {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
