<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-credit-card text-warning"></i>
                    <span class="fw-semibold">{{ __('الدفع الإلكتروني عبر ChargilyPay (اشتراك جديد)') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    الدفع عبر بوابة ChargilyPay 💳
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    سيتم توجيهك إلى بوابة الدفع الإلكتروني لإتمام عملية تسديد اشتراكك الجديد عبر البطاقة الذهبية أو CIB.
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

    <!-- Main Payment Container Grid -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white text-center p-4 p-md-5 mb-4">
                <div class="p-3 bg-light rounded-4 mb-4 d-inline-block">
                    <img src="{{ asset('asset/v1/users/dashboard/img/payments/eldhahabia.png') }}" alt="ChargilyPay"
                        class="img-fluid" style="max-height: 100px; object-fit: contain;">
                </div>
                <h4 class="fw-bold text-dark mb-2">الدفع الإلكتروني (EDAHABIA / CIB)</h4>
                <p class="text-muted small mb-4">
                    اضغط على زر التوجيه والدفع أدناه للتسديد المباشر وتفعيل الخطة الجديدة فورًا.
                </p>

                <!-- معلومات الاشتراك والخصائص -->
                <div class="text-start bg-light-subtle rounded-4 p-4 border mb-4">
                    <h6 class="fw-bold text-plum mb-3 border-bottom pb-2">
                        <i class="fa-solid fa-receipt me-1"></i> معلومات الخطة الجديدة:
                    </h6>
                    <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                        <span class="text-muted small">اسم الخطة:</span>
                        <span class="fw-bold text-dark fs-6">{{ $plan->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                        <span class="text-muted small">مدة الاشتراك:</span>
                        <span class="fw-bold text-dark">{{ $duration }} يوم</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-3 pb-2 border-bottom">
                        <span class="text-muted small">المبلغ المستحق:</span>
                        <span class="fw-bold text-success fs-5">{{ number_format($price, 2) }} د.ج</span>
                    </div>

                    <div class="mt-3">
                        <span class="fw-bold text-dark d-block mb-2.5 small">مميزات وصلاحيات الخطة:</span>
                        <ul class="list-group list-group-flush border-0 p-0" style="list-style: none;">
                            @foreach($plan->authorizations as $auth)
                                <li class="py-1.5 border-0 d-flex align-items-center gap-2 small">
                                    @if($auth->is_enabled !== 0)
                                        <i class="fas fa-check-circle text-success fs-6"></i>
                                        <span class="text-dark fw-semibold">{{ $auth->description }}</span>
                                    @else
                                        <i class="fas fa-times-circle text-danger fs-6"></i>
                                        <span class="text-muted text-decoration-line-through">{{ $auth->description }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- نموذج الدفع والتوجيه -->
                <form action="{{ route('seller.chargilypay.redirect') }}" method="POST" class="text-start">
                    @csrf
                    <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                    <input type="hidden" name="sub_plan_id" value="{{ $sub_plan_id }}">
                    <input type="hidden" name="payment_type" value="new_seller_subscription">
                    <input type="hidden" name="reference_id" value="{{ get_seller_data(auth()->user()->tenant_id)->id }}">

                    <button type="submit"
                        class="btn btn-seller-primary w-100 rounded-3 py-3 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2 fs-6">
                        <i class="fa-solid fa-lock"></i>
                        <span>الانتقال لبوابة الدفع عبر Chargily</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- إشعار النجاح -->
@if(session('success'))
    <script>
        Swal.fire({
            title: 'نجاح!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'حسنًا'
        });
    </script>
@endif

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
</style>
