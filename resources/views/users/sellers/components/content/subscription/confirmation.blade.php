<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-address-card text-warning"></i>
                    <span class="fw-semibold">{{ __('تأكيد وتفعيل خطة الاشتراك') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    تأكيد الإشتراك 💳
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    اختر الخطة ومدة الاشتراك المناسبة ووسيلة الدفع المفضلة لتأكيد وتجديد حساب متجرك.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('seller.subscription') }}"
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
        <div class="position-absolute rounded-circle bg-warning opacity-10"
            style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);">
        </div>
    </div>

    <!-- Main Wizard Card Container -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white p-4 p-md-5 mb-4">
                <!-- Wizard Steps Indicator -->
                <div id="steps_indicator" class="d-flex justify-content-center align-items-center gap-3 mb-4 pb-3 border-bottom">
                    <span class="step active">1</span>
                    <span class="step-line"></span>
                    <span class="step">2</span>
                    <span class="step-line"></span>
                    <span class="step">3</span>
                    <span class="step-line"></span>
                    <span class="step">4</span>
                </div>

                <form id="regForm" action="{{ route('seller.payment.redirect') }}" method="POST">
                    @csrf

                    <!-- STEP 1: Select Plan -->
                    <div class="tab" style="display:block">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="avatar avatar-sm rounded-circle bg-plum-subtle text-plum fw-bold me-1"
                                style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-layer-group fs-6"></i>
                            </span>
                            <h5 class="fw-bold mb-0 text-dark">اختر الخطة المناسبة لك:</h5>
                        </div>

                        <div class="row g-3">
                            @foreach ($plans as $plan)
                                <div class="col-12 col-md-6">
                                    <div class="option-card p-3.5 rounded-3 border bg-light-subtle transition-all h-100 position-relative">
                                        <div class="form-check d-flex align-items-center gap-3">
                                            <input class="form-check-input flex-shrink-0 fs-5 mt-0" type="radio" name="plan" id="plan_radio_{{ $plan->id }}"
                                                value="{{ $plan->id }}"
                                                @if($plan->name == get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->name) checked @endif
                                                onclick="get_selected_plan();remiz_a_zero_sub_plan_id();get_plan_authorizations({{ $plan->id }})">
                                            <label class="form-check-label w-100 cursor-pointer text-start" for="plan_radio_{{ $plan->id }}">
                                                <span class="fw-bold text-dark d-block fs-6 mb-1">الخطة {{ $plan->name }}</span>
                                                <span class="text-plum fw-bold fs-5">
                                                    {{ number_format($plan->price, 2) }} <sup>د.ج</sup>
                                                </span>
                                                <span class="text-muted small"> / {{ $plan->price == 0 ? 'مدى الحياة' : '30 يوم' }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- STEP 2: Plan Pricing & Duration -->
                    <div id="plan_pricing">
                        <div id="plan-pricing-step" class="tab" style="display:none">
                            <div class="d-flex align-items-center gap-2 mb-3">
                                <span class="avatar avatar-sm rounded-circle bg-plum-subtle text-plum fw-bold me-1"
                                    style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fa-solid fa-clock-rotate-left fs-6"></i>
                                </span>
                                <h5 class="fw-bold mb-0 text-dark">حدد مدة ونوع الاشتراك:</h5>
                            </div>

                            <div class="row g-3" id="pricing-details">
                                <div class="col-12 col-md-6">
                                    <div class="option-card p-3.5 rounded-3 border bg-light-subtle transition-all h-100">
                                        <div class="form-check d-flex align-items-center gap-3">
                                            <input class="form-check-input flex-shrink-0 fs-5 mt-0" type="radio" name="plan_price" id="pricing_default"
                                                data-sub-plan-id="0"
                                                value="{{ get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->price }}<sup>د.ج</sup>/شهر"
                                                checked onclick="print_plan_price();">
                                            <input type="hidden" name="pre_sub_plan_id" value="0">
                                            <label class="form-check-label w-100 cursor-pointer text-start" for="pricing_default">
                                                <span class="fw-bold text-dark d-block mb-1">الخيار الأساسي (30 يوم)</span>
                                                <span class="text-plum fw-bold fs-5">
                                                    {{ number_format(get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->price, 2) }} <sup>د.ج</sup>
                                                </span>
                                                <span class="text-muted small"> / 30 يوم</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                @foreach (get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->pricing as $index => $price)
                                    <div class="col-12 col-md-6">
                                        <div class="option-card p-3.5 rounded-3 border bg-light-subtle transition-all h-100">
                                            <div class="form-check d-flex align-items-center gap-3">
                                                <input class="form-check-input flex-shrink-0 fs-5 mt-0" type="radio" name="plan_price" id="pricing_opt_{{ $price->id }}"
                                                    data-sub-plan-id="{{ $price->id }}"
                                                    value="{{ $price->price }}<sup>د.ج</sup>/{{ $price->duration }} يوم"
                                                    @if($price->duration == get_seller_data(Auth::user()->tenant->id)->plan_subscription->duration) checked @endif
                                                    onclick="print_plan_price();">
                                                <input type="hidden" name="pre_sub_plan_id" value="{{ $price->id }}">
                                                <label class="form-check-label w-100 cursor-pointer text-start" for="pricing_opt_{{ $price->id }}">
                                                    <span class="fw-bold text-dark d-block mb-1">خطة المدى Extended ({{ $price->duration }} يوم)</span>
                                                    <span class="text-plum fw-bold fs-5">
                                                        {{ number_format($price->price, 2) }} <sup>د.ج</sup>
                                                    </span>
                                                    <span class="text-muted small"> / {{ $price->duration }} يوم</span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- STEP 3: Payment Method -->
                    <div id="payment-method-step" class="tab" style="display:none">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="avatar avatar-sm rounded-circle bg-plum-subtle text-plum fw-bold me-1"
                                style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-credit-card fs-6"></i>
                            </span>
                            <h5 class="fw-bold mb-0 text-dark">وسيلة الدفع المفضلة:</h5>
                        </div>

                        <div id="non_methode" style="display:none" class="alert alert-info border-0 bg-info-subtle text-info-emphasis rounded-3 p-3 mb-0">
                            <i class="fa-solid fa-circle-info me-1"></i> لقد اخترت الخطة المجانية، لذلك لا تتطلب هذه العملية اختيار وسيلة دفع.
                        </div>

                        <div id="the_methods" style="display:block" class="row g-3">
                            <div class="col-12">
                                <div class="option-card p-3.5 rounded-3 border bg-light-subtle transition-all">
                                    <div class="form-check d-flex align-items-center gap-3">
                                        <input class="form-check-input flex-shrink-0 fs-5 mt-0" type="radio" name="pay_method" id="pay_method_cib"
                                            value="algerian_credit_card" checked onclick="print_payment_method();">
                                        <label class="form-check-label w-100 cursor-pointer text-start" for="pay_method_cib">
                                            <span class="fw-bold text-dark d-block">الدفع الإلكتروني السريع عبر البطاقة الذهبية أو CIB</span>
                                            <span class="text-muted small">تسديد فوري وتفعيل تلقائي لحساب متجرك عبر بوابة ChargilyPay</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="option-card p-3.5 rounded-3 border bg-light-subtle transition-all">
                                    <div class="form-check d-flex align-items-center gap-3">
                                        <input class="form-check-input flex-shrink-0 fs-5 mt-0" type="radio" name="pay_method" id="pay_method_baridi"
                                            value="baridimob" onclick="print_payment_method();">
                                        <label class="form-check-label w-100 cursor-pointer text-start" for="pay_method_baridi">
                                            <span class="fw-bold text-dark d-block">الدفع عبر تطبيق بريدي موب (BaridiMob)</span>
                                            <span class="text-muted small">إمكانية تحويل المبلغ وإرفاق إيصال السداد لتأكيد الخطة</span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="option-card p-3.5 rounded-3 border bg-light-subtle transition-all">
                                    <div class="form-check d-flex align-items-center gap-3">
                                        <input class="form-check-input flex-shrink-0 fs-5 mt-0" type="radio" name="pay_method" id="pay_method_ccp"
                                            value="ccp" onclick="print_payment_method();">
                                        <label class="form-check-label w-100 cursor-pointer text-start" for="pay_method_ccp">
                                            <span class="fw-bold text-dark d-block">الدفع عبر الحساب البريدي الجاري CCP / بريد الجزائر</span>
                                            <span class="text-muted small">تحويل بريدي تقليدي عبر مكاتب بريد الجزائر مع إرفاق الإثبات</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- STEP 4: Subscription Info Summary -->
                    <div id="subscription_info" class="tab" style="display:none">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <span class="avatar avatar-sm rounded-circle bg-plum-subtle text-plum fw-bold me-1"
                                style="width: 32px; height: 32px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-clipboard-check fs-6"></i>
                            </span>
                            <h5 class="fw-bold mb-0 text-dark">معلومات ومراجعة الاشتراك:</h5>
                        </div>

                        <div class="bg-light-subtle rounded-4 p-4 border text-start">
                            <div class="mb-3 border-bottom pb-2" id="plan-name">
                                <b>الخطة: {{ get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->name }}</b>
                            </div>
                            <div class="mb-2 text-plum fs-5 fw-bold border-bottom pb-2" id="plan-price">
                                {{ get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->price }}<sup>د.ج</sup>/{{ get_seller_data(Auth::user()->tenant->id)->plan_subscription->duration }} يوم
                            </div>
                            <div class="mb-2" id="plan-authorizations"></div>
                            <div class="mb-2" id="plan-duration"></div>
                            <div class="mb-2 text-muted fw-semibold" id="plan-pay-method">الدفع عن طريق البطاقة الذهبية أو CIB</div>
                            <div class="text-success font-monospace fw-bold" id="plan-expiration-date"></div>
                        </div>
                    </div>

                    <!-- Wizard Navigation Control Buttons -->
                    <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                        <button class="btn btn-light text-dark fw-bold px-4 py-2.5 rounded-3 border" type="button" id="prevBtn" onclick="nextPrev(-1)" style="display:none">
                            <i class="fa-solid fa-arrow-right me-1"></i> السابق
                        </button>
                        <button class="btn btn-seller-primary fw-bold px-4 py-2.5 rounded-3 ms-auto" type="button" id="nextBtn" onclick="nextPrev(1)">
                            التالي <i class="fa-solid fa-arrow-left ms-1"></i>
                        </button>
                    </div>

                    <input id="sub_plan_id" type="hidden" name="sub_plan_id" value="0"/>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-plum-subtle {
        background-color: rgba(164, 12, 114, 0.1);
    }

    .border-plum-subtle {
        border-color: rgba(164, 12, 114, 0.25) !important;
    }

    .text-plum {
        color: #a40c72 !important;
    }

    .btn-seller-primary {
        background: linear-gradient(135deg, #a40c72 0%, #790b54 100%) !important;
        color: #ffffff !important;
        border: none !important;
    }

    .btn-seller-primary:hover {
        background: linear-gradient(135deg, #790b54 0%, #5b073e 100%) !important;
        color: #ffffff !important;
    }

    /* Wizard Step Indicators Styling */
    .step {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #e2e8f0;
        color: #64748b;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .step.active {
        background-color: #a40c72;
        color: #ffffff;
        box-shadow: 0 0 12px rgba(164, 12, 114, 0.4);
    }

    .step.finish {
        background-color: #10b981;
        color: #ffffff;
    }

    .step-line {
        height: 3px;
        width: 40px;
        background-color: #e2e8f0;
        border-radius: 2px;
    }

    .option-card {
        cursor: pointer;
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .option-card:hover {
        border-color: #a40c72 !important;
        box-shadow: 0 4px 12px rgba(164, 12, 114, 0.1);
    }

    .cursor-pointer {
        cursor: pointer;
    }
</style>
