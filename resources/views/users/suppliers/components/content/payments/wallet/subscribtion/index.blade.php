<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #2563eb 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-wallet text-warning"></i>
                    <span class="fw-semibold">{{ __('الدفع المباشر من رصيد المحفظة للتوريد') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    الدفع عبر رصيد المحفظة للتوريد 👛
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    استخدم رصيد محفظتك المتاح لتسديد اشتراك خطة التوريد فوريًا وبدون الحاجة لانتظار التحقق الحسابي.
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

    @php
        if($old_subscription->plan_id == 1 && in_array($order->plan_id, [2, 3]))
        {
            $price = $order->price;
        } else
        {
            $price = get_rest_off_current_supplier_plan($order->supplier_id, $old_subscription->plan_id, $order->plan_id, $rest_days);
        }
        $userBalance = auth()->user()->balance->balance ?? 0;
        $isBalanceSufficient = $userBalance >= $price;
    @endphp

    <!-- Main Payment Container Grid -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white text-center p-4 p-md-5 mb-4">
                <!-- Wallet Balance Display -->
                <div class="p-4 rounded-4 mb-4 text-center {{ $isBalanceSufficient ? 'bg-success-subtle border border-success' : 'bg-danger-subtle border border-danger' }}">
                    <span class="avatar avatar-lg rounded-circle mb-2 {{ $isBalanceSufficient ? 'bg-success text-white' : 'bg-danger text-white' }}"
                        style="width: 56px; height: 56px; display: inline-flex; align-items: center; justify-content: center;">
                        <i class="fa-solid fa-wallet fs-3"></i>
                    </span>
                    <span class="text-muted d-block small mb-1 fw-bold">رصيدك الحالي في المحفظة</span>
                    <h2 class="display-6 fw-bold mb-0 {{ $isBalanceSufficient ? 'text-success' : 'text-danger' }}">
                        {{ number_format($userBalance, 2) }} <span class="fs-5">د.ج</span>
                    </h2>
                </div>

                <!-- معلومات الاشتراك والخصم -->
                <div class="text-start bg-light-subtle rounded-4 p-4 border mb-4">
                    <h6 class="fw-bold text-navy mb-3 border-bottom pb-2">
                        <i class="fa-solid fa-receipt me-1"></i> تفاصيل عملية الخصم:
                    </h6>
                    <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                        <span class="text-muted small">الخطة المطلوبة:</span>
                        <span class="fw-bold text-dark fs-6">{{ get_supplier_plan_data($order->plan_id)->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                        <span class="text-muted small">مدة الاشتراك:</span>
                        <span class="fw-bold text-dark">{{ $order->duration }} يوم</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                        <span class="text-muted small">المبلغ الخاضع للخصم:</span>
                        <span class="fw-bold text-navy fs-5">
                            @if ($old_subscription->plan_id == 1 && in_array($order->plan_id, [2, 3]))
                                {{ number_format($order->price, 2) }} د.ج
                            @else
                                {{ get_rest_off_current_supplier_plan($order->supplier_id, $old_subscription->plan_id, $order->plan_id, $rest_days) }} د.ج
                            @endif
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-1 small">
                        <span class="text-muted">حالة العملية:</span>
                        @if($order->payment_status === 'paid')
                            <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-1 fw-bold">
                                <i class="fa-solid fa-circle-check me-1"></i> مدفوع
                            </span>
                        @elseif($isBalanceSufficient)
                            <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-1 fw-bold">
                                <i class="fa-solid fa-circle-check me-1"></i> رصيد كافٍ للخصم
                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger border border-danger rounded-pill px-3 py-1 fw-bold">
                                <i class="fa-solid fa-triangle-exclamation me-1"></i> رصيد غير كافٍ
                            </span>
                        @endif
                    </div>
                </div>

                <!-- التنبيهات ونموذج الخصم -->
                @if($order->payment_status === 'paid')
                    <div class="alert alert-success border-0 bg-success-subtle text-success-emphasis rounded-3 p-3 mb-0">
                        <i class="fa-solid fa-circle-check me-1"></i> تم تأكيد دفع هذا الطلب واقتطاعه من المحفظة بنجاح.
                    </div>
                @else
                    @if($isBalanceSufficient)
                        <div class="alert alert-success border-0 bg-success-subtle text-success-emphasis rounded-3 p-3 mb-4 text-start">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-circle-check fs-5 flex-shrink-0"></i>
                                <span class="fw-semibold">يمكنك تأكيد الخصم المباشر والتفعيل الفوري للخطة من رصيد محفظتك.</span>
                            </div>
                        </div>

                        <form action="{{ route('supplier.subscription.payment.wallet') }}" method="POST">
                            @csrf
                            <input type="hidden" name="payment_method" value="wallet">
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <input type="hidden" name="plan_id" value="{{ $order->plan_id }}">
                            <input type="hidden" name="duration" value="{{ $order->duration }}">
                            <input type="hidden" name="old_subscription_plan_id" value="{{ $old_subscription->plan_id }}">
                            <input type="hidden" name="supplier_id" value="{{ $order->supplier_id }}">
                            <input type="hidden" name="rest_days" value="{{ $rest_days }}">

                            <button type="submit"
                                class="btn btn-supplier-primary w-100 rounded-3 py-3 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2 fs-6">
                                <i class="fa-solid fa-bolt"></i>
                                <span>تأكيد الخصم والدفع الفوري من المحفظة</span>
                            </button>
                        </form>
                    @else
                        <div class="alert alert-danger border-0 bg-danger-subtle text-danger-emphasis rounded-3 p-3 mb-4 text-start">
                            <div class="d-flex align-items-center gap-2">
                                <i class="fa-solid fa-triangle-exclamation fs-5 flex-shrink-0"></i>
                                <span class="fw-semibold">رصيدك الحالي غير كافٍ لإتمام هذه العملية. يرجى شحن محفظتك أولاً للاستمرار.</span>
                            </div>
                        </div>

                        <a href="{{ route('supplier.wallet') }}"
                            class="btn btn-warning text-dark w-100 rounded-3 py-3 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2 fs-6">
                            <i class="fa-solid fa-plus-circle"></i>
                            <span>شحن المحفظة الآن</span>
                        </a>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<!-- إشعار النجاح -->
@if(session()->has('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'تم الدفع بنجاح',
        text: '{{ session('success') }}',
        confirmButtonText: 'موافق',
        timer: 3000
    });
</script>
@endif

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

    .avatar-lg {
        width: 56px;
        height: 56px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
