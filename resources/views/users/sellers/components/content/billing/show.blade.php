<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner (Hidden when printing) -->
    <div class="orders-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden d-print-none"
        style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-7 mb-3 mb-lg-0">
                <div
                    class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-file-invoice-dollar text-warning"></i>
                    <span class="fw-semibold">{{ __('تفاصيل وثيقة الفاتورة الصادرة') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90 font-monospace">#{{ $invoice->invoice_number }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    تفاصيل الفاتورة 📑
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    معاينة شاملة لبنود الفاتورة والمبالغ المستحقة وطريقة السداد المعنية.
                </p>
            </div>
            <div class="col-lg-5 text-lg-end d-flex flex-wrap align-items-center justify-content-lg-end gap-2">
                <button onclick="window.print()"
                    class="btn btn-warning text-dark fw-bold px-3.5 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2">
                    <i class="fa-solid fa-print"></i>
                    <span>طباعة الفاتورة</span>
                </button>
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
        <div class="position-absolute rounded-circle bg-warning opacity-10"
            style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);">
        </div>
    </div>

    <!-- Printable Invoice Card Container -->
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white p-4 p-md-5 mb-4 invoice-card-print">
                <!-- Header Info Section -->
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 border-bottom pb-4 mb-4">
                    <div>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="avatar avatar-md rounded-3 bg-plum-subtle text-plum fw-bold me-1"
                                style="width: 40px; height: 40px; display: inline-flex; align-items: center; justify-content: center;">
                                <i class="fa-solid fa-receipt fs-5"></i>
                            </span>
                            <h3 class="fw-bold mb-0 text-dark">فاتورة رسمية</h3>
                        </div>
                        <div class="text-secondary small mb-1">
                            <span class="fw-semibold">رقم الفاتورة:</span>
                            <span class="fw-bold text-dark font-monospace">#{{ $invoice->invoice_number }}</span>
                        </div>
                        <div class="text-secondary small">
                            <span class="fw-semibold">تاريخ الاستحقاق:</span>
                            <span class="fw-bold text-dark">{{ $invoice->due_date }}</span>
                        </div>
                    </div>

                    <div class="text-lg-end bg-light-subtle rounded-3 p-3 border">
                        <div class="mb-2">
                            <span class="text-muted small me-2">حالة الفاتورة:</span>
                            @if($invoice->status == 'paid')
                                <span class="badge bg-success-subtle text-success border border-success rounded-pill px-3 py-1.5 fw-bold">
                                    <i class="fa-solid fa-circle-check me-1"></i> مدفوعة
                                </span>
                            @else
                                <span class="badge bg-warning-subtle text-warning-emphasis border border-warning rounded-pill px-3 py-1.5 fw-bold">
                                    <i class="fa-solid fa-clock me-1"></i> في الانتظار
                                </span>
                            @endif
                        </div>
                        <div class="text-secondary small">
                            <span class="fw-semibold">طريقة الدفع:</span>
                            <span class="fw-bold text-plum">{{ $invoice->payment_method }}</span>
                        </div>
                    </div>
                </div>

                <!-- Table Breakdown Section -->
                <div class="table-responsive mb-4">
                    <table class="table table-hover align-middle mb-0 text-center border">
                        <thead class="bg-light text-dark fw-bold border-bottom">
                            <tr>
                                <th class="text-start ps-4 py-3">الوصف</th>
                                <th width="100" class="py-3">الكمية</th>
                                <th width="140" class="py-3">سعر الوحدة</th>
                                <th width="150" class="pe-4 py-3">الإجمالي</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($invoice->details as $item)
                                <tr>
                                    <td data-label="الوصف" class="text-start ps-4 fw-semibold text-dark">
                                        {{ $item['item_name'] }}
                                    </td>
                                    <td data-label="الكمية" class="fw-bold text-secondary">
                                        {{ $item['quantity'] }}
                                    </td>
                                    <td data-label="سعر الوحدة" class="fw-semibold text-dark">
                                        {{ number_format($item['unit_price'], 2) }} د.ج
                                    </td>
                                    <td data-label="الإجمالي" class="pe-4 fw-bold text-success">
                                        {{ number_format($item['quantity'] * $item['unit_price'], 2) }} د.ج
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Total Amount Summary Box -->
                <div class="row justify-content-end">
                    <div class="col-12 col-md-6 col-lg-5">
                        <div class="p-3.5 rounded-4 bg-plum-subtle border border-plum-subtle text-center">
                            <span class="text-muted d-block small mb-1 fw-bold">المبلغ الإجمالي النهائي</span>
                            <h3 class="fw-bold text-plum mb-0">
                                {{ number_format($invoice->amount, 2) }} <span class="fs-5">د.ج</span>
                            </h3>
                        </div>
                    </div>
                </div>
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

    /* Print Styles Protocol */
    @media print {
        body {
            background: #ffffff !important;
        }

        .d-print-none {
            display: none !important;
        }

        .invoice-card-print {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
        }
    }
</style>