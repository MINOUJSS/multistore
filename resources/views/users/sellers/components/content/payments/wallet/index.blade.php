<div class="container mt-4">
    <h2 class="text-center mb-4">بيانات الدفع</h2>

    <div class="card mb-4 shadow-sm border-0">
        <div class="card-body">
            <h3 class="text-primary mb-4">
                <i class="bi bi-wallet2"></i> المحفظة
            </h3>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="wallet-box bg-light p-4 rounded text-center">
                        <h5 class="text-muted">مبلغ المحفظة</h5>
                        <div class="amount text-success fw-bold display-6">
                            {{ number_format(auth()->user()->balance->balance, 2) }} <small class="fs-5">د.ج</small>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-6 mb-3">
                    <div class="wallet-box bg-light p-4 rounded text-center">
                        <h5 class="text-muted">مبلغ المستحقات</h5>
                        <div class="amount text-danger fw-bold display-6">
                            {{ number_format(auth()->user()->balance->outstanding_amount, 2) }} <small class="fs-5">د.ج</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <!-- معلومات الفاتورة -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <strong>معلومات الفاتورة</strong>
        </div>
        <div class="card-body">
            <p><strong>رقم الفاتورة:</strong> {{ $invoice->invoice_number ?? 'غير متوفر' }}</p>
            <p><strong>تاريخ الإصدار:</strong> {{ $invoice->created_at }}</p>
            <p><strong>المبلغ:</strong> {{ number_format($invoice->amount, 2) }} د.ج</p>
            <p><strong>الحالة:</strong> 
                @if($invoice->status === 'paid')
                    <span class="badge bg-success">مدفوعة</span>
                @else
                    <span class="badge bg-warning">غير مدفوعة</span>
                @endif
            </p>
        </div>
    </div>

    <!-- نموذج الدفع -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('seller.billing.invoice.pay') }}" method="POST">
                @csrf
                <input type="hidden" name="payment_method" value="wallet">
                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                <input type="hidden" name="amount" value="{{ $invoice->amount }}">
                <button type="submit" class="btn btn-primary w-100">دفع الفاتورة</button>
            </form>
        </div>
    </div>
</div>


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