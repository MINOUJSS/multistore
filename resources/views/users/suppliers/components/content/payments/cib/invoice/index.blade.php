<div class="container mt-4">
    <h2 class="text-center mb-4">بيانات الدفع عبر البطاقة البنكية</h2>

    <!-- صورة البطاقة البنكية -->
    <div class="text-center mb-4">
        <img src="{{ asset('asset/users/dashboard/img/payments/eldhahabia.png') }}" alt="الدفع بالبطاقة البنكية" class="img-fluid" style="max-width: 200px;">
        <p class="text-muted mt-2">يرجى الدفع عبر البطاقة الذهبية أو بطاقة CIB</p>
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

    <!-- نموذج رفع إيصال الدفع -->
    <div class="card">
        <div class="card-body">
            <form action="{{ route('supplier.billing.invoice.pay') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="payment_method" value="credit-card">
                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                <input type="hidden" name="amount" value="{{ $invoice->amount }}">

                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-credit-card"></i> الدفع
                </button>
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
