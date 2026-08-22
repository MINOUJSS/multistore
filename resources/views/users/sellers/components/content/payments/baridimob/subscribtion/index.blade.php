<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-mobile-screen-button text-warning"></i>
                    <span class="fw-semibold">{{ __('الدفع الإلكتروني السريع عبر BaridiMob') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    الدفع عبر بريدي موب BaridiMob 📱
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    قم بتحويل مبلغ الاشتراك عبر تطبيق بريدي موب وارفع إيصال التحويل أدناه لتأكيد وتفعيل خطتك مباشرة.
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
    <div class="row justify-content-center g-4">
        <!-- Left / Top Column: BaridiMob Brand & Details -->
        <div class="col-12 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden bg-white text-center p-4">
                <div class="p-3 bg-light rounded-4 mb-3 d-inline-block">
                    <img src="{{ asset('asset/v1/users/dashboard/img/payments/baridimaobe.png') }}" alt="بريدي موب"
                        class="img-fluid" style="max-height: 90px; object-fit: contain;">
                </div>
                <h5 class="fw-bold text-dark mb-2">تعليمات الدفع عبر بريدي موب</h5>
                <p class="text-muted small mb-4">
                    يرجى الدفع عبر تطبيق BaridiMob ورفع صورة الإيصال أو ملف PDF أدناه لتثبيت الترقية.
                </p>

                <div class="text-start bg-light-subtle rounded-3 p-3.5 border">
                    <h6 class="fw-bold text-plum mb-3 border-bottom pb-2">
                        <i class="fa-solid fa-receipt me-1"></i> معلومات طلب الاشتراك:
                    </h6>
                    <div class="d-flex justify-content-between align-items-center mb-2 small">
                        <span class="text-muted">الخطة المطلوبة:</span>
                        <span class="fw-bold text-dark fs-6">{{ get_seller_plan_data($order->plan_id)->name }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 small">
                        <span class="text-muted">المدة:</span>
                        <span class="fw-bold text-dark">{{ $order->duration }} يوم</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2 small">
                        <span class="text-muted">المبلغ الواجب دفعه:</span>
                        <span class="fw-bold text-success fs-6">
                            @if ($old_subscription->plan_id == 1 && in_array($order->plan_id, [2, 3]))
                                {{ number_format($order->price, 2) }} د.ج
                            @else
                                {{ get_rest_off_current_seller_plan($order->seller_id, $old_subscription->plan_id, $order->plan_id, $rest_days) }} د.ج
                            @endif
                        </span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-2 border-top small">
                        <span class="text-muted">حالة العملية:</span>
                        @if($order->payment_status === 'paid')
                            <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-1 fw-bold">
                                <i class="fa-solid fa-circle-check me-1"></i> مدفوع
                            </span>
                        @else
                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning rounded-pill px-3 py-1 fw-bold">
                                <i class="fa-solid fa-clock me-1"></i> قيد الانتظار
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Right / Bottom Column: File Upload Form -->
        <div class="col-12 col-lg-7">
            @if($order->payment_status === 'paid')
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100">
                    <div class="card-body p-4 text-center d-flex flex-column align-items-center justify-content-center">
                        <div class="avatar avatar-xl rounded-circle bg-success-subtle text-success mb-3" style="width: 72px; height: 72px; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="fa-solid fa-circle-check fs-1"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">تم تأكيد عملية الدفع بنجاح</h4>
                        <p class="text-muted mb-0">تم استلام الإيصال وتفعيل الاشتراك في الخطة المحددة. شكراً لك!</p>
                    </div>
                </div>
            @else
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white h-100">
                    <div class="card-header bg-white border-0 py-3.5 px-4 border-bottom border-light">
                        <div class="d-flex align-items-center gap-2">
                            <span class="avatar avatar-md rounded-3 bg-plum-subtle text-plum fw-bold"
                                style="width: 38px; height: 38px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-upload fs-6"></i>
                            </span>
                            <h5 class="fw-bold mb-0 text-dark fs-6">رفع إيصال الدفع</h5>
                        </div>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form action="{{ route('seller.subscription.payment.baridimob') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <input type="hidden" name="payment_method" value="baridimob">

                            <div class="mb-4">
                                <label for="payment_proof" class="form-label fw-bold text-dark small">إرفاق إيصال الدفع <span class="text-danger">*</span></label>
                                <div class="p-4 rounded-4 border-2 border-dashed bg-light text-center cursor-pointer hover-border-plum transition-all position-relative">
                                    <i class="fa-solid fa-cloud-arrow-up display-5 text-plum mb-2"></i>
                                    <h6 class="fw-bold text-dark mb-1">اختر ملف الإيصال أو اسحبه هنا</h6>
                                    <p class="text-muted small mb-3">الملفات المسموح بها: (PDF, PNG, JPG, JPEG)</p>
                                    <input type="file" name="payment_proof" id="payment_proof" class="form-control rounded-3 shadow-none" accept="application/pdf, image/jpeg, image/png" required>
                                </div>
                            </div>

                            <button type="submit"
                                class="btn btn-seller-primary w-100 rounded-3 py-3 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2 fs-6">
                                <i class="fa-solid fa-paper-plane"></i>
                                <span>إرسال وتأكيد الدفع</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- إشعار النجاح -->
@if(session()->has('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'تم إرسال الدفع بنجاح',
        text: '{{ session('success') }}',
        confirmButtonText: 'حسناً',
        timer: 3000
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

    .border-dashed {
        border-style: dashed !important;
    }

    .hover-border-plum:hover {
        border-color: #a40c72 !important;
        background-color: rgba(164, 12, 114, 0.02) !important;
    }

    .avatar-md {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
