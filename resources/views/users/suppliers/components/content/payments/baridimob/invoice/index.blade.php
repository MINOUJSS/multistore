<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
        style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #2563eb 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-mobile-screen-button text-warning"></i>
                    <span class="fw-semibold">{{ __('الدفع عبر تطبيق بريدي موب BaridiMob للتوريد') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    تسديد الفاتورة عبر بريدي موب للتوريد 📱
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    يرجى إجراء التحويل عبر تطبيق بريدي موب BaridiMob ورفع إيصال السداد أدناه لتأكيد فاتورة التوريد.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="javascript:history.back()"
                    class="btn btn-light text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
                    <i class="fas fa-arrow-right"></i>
                    <span>الرجوع</span>
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

    <!-- Main Payment Container Grid -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-7">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white text-center p-4 p-md-5 mb-4">
                <div class="p-3 bg-light rounded-4 mb-4 d-inline-block">
                    <img src="{{ asset('asset/v1/users/dashboard/img/payments/baridimaobe.png') }}" alt="تطبيق بريدي موب"
                        class="img-fluid" style="max-height: 100px; object-fit: contain;">
                </div>
                <h4 class="fw-bold text-dark mb-2">تسديد الفاتورة عبر تطبيق BaridiMob</h4>
                <p class="text-muted small mb-4">
                    قم بإدخال بيانات التحويل في تطبيق بريدي موب ثم أرفق إيصال الدفع أدناه.
                </p>

                <!-- معلومات الفاتورة -->
                <div class="text-start bg-light-subtle rounded-4 p-4 border mb-4">
                    <h6 class="fw-bold text-navy mb-3 border-bottom pb-2">
                        <i class="fa-solid fa-receipt me-1"></i> معلومات الفاتورة:
                    </h6>
                    <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                        <span class="text-muted small">رقم الفاتورة:</span>
                        <span class="fw-bold text-dark font-monospace">{{ $invoice->invoice_number ?? 'غير متوفر' }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                        <span class="text-muted small">تاريخ الإصدار:</span>
                        <span class="fw-bold text-dark">{{ $invoice->created_at }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2.5 pb-2 border-bottom">
                        <span class="text-muted small">المبلغ المستحق:</span>
                        <span class="fw-bold text-success fs-5">{{ number_format($invoice->amount, 2) }} د.ج</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center pt-1 small">
                        <span class="text-muted">الحالة:</span>
                        @if($invoice->status === 'paid')
                            <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-1 fw-bold">
                                <i class="fa-solid fa-circle-check me-1"></i> مدفوعة
                            </span>
                        @else
                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning rounded-pill px-3 py-1 fw-bold">
                                <i class="fa-solid fa-clock me-1"></i> غير مدفوعة
                            </span>
                        @endif
                    </div>
                </div>

                <!-- نموذج الدفع ورفع الإثبات -->
                @if($invoice->status === 'paid')
                    <div class="alert alert-success border-0 bg-success-subtle text-success-emphasis rounded-3 p-3 mb-0">
                        <i class="fa-solid fa-circle-check me-1"></i> تم تسديد هذه الفاتورة وتأكيدها بنجاح.
                    </div>
                @else
                    <form action="{{ route('supplier.billing.invoice.pay') }}" method="POST" enctype="multipart/form-data" class="text-start">
                        @csrf
                        <input type="hidden" name="payment_method" value="baridi-mob">
                        <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                        <input type="hidden" name="amount" value="{{ $invoice->amount }}">

                        <div class="mb-4">
                            <label for="payment_proof" class="form-label fw-bold text-dark small">
                                <i class="fa-solid fa-cloud-arrow-up text-navy me-1"></i> رفع إيصال الدفع <span class="text-danger">*</span>
                            </label>
                            <input type="file" name="payment_proof" id="payment_proof"
                                class="form-control rounded-3 p-2.5 shadow-none" accept="application/pdf, image/jpeg, image/png" required>
                            <small class="text-muted d-block mt-2 fs-7">
                                الصيغ المقبولة: صورة (JPG, PNG) أو ملف PDF
                            </small>
                        </div>

                        <button type="submit"
                            class="btn btn-success w-100 rounded-3 py-3 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center gap-2 fs-6">
                            <i class="fa-solid fa-paper-plane"></i>
                            <span>إرسال إيصال الدفع</span>
                        </button>
                    </form>
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
        confirmButtonText: 'حسناً',
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
</style>
