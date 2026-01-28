<div class="container mt-4">
    <h2 class="text-center mb-4">بيانات الدفع عبر بريدي موب</h2>

    <!-- صورة بريدي موب -->
    <div class="text-center mb-4">
        <img src="{{ asset('asset/v1/users/dashboard/img/payments/baridimaobe.png') }}" alt="تطبيق بريدي موب" class="img-fluid" style="max-width: 200px;">
        <p class="text-muted mt-2">يرجى الدفع عبر تطبيق بريدي موب ورفع إيصال الدفع أدناه</p>
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
            <form action="{{ route('seller.billing.invoice.pay') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="payment_method" value="baridi-mob">
                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                <input type="hidden" name="amount" value="{{ $invoice->amount }}">

                <div class="mb-3">
                    <label for="payment_proof" class="form-label">رفع إيصال الدفع</label>
                    <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept="application/pdf, image/jpeg, image/png" required>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-upload"></i> إرسال إيصال الدفع
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
