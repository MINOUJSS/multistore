<div class="container mt-4">
    <h2 class="text-center mb-4">الدفع عبر ChargilyPay</h2>

    <!-- شعار Chargily -->
    <div class="text-center mb-4">
        <img src="{{ asset('asset/users/dashboard/img/payments/eldhahabia.png') }}" alt="ChargilyPay" class="img-fluid" style="max-width: 200px;">
        <p class="text-muted mt-2">سيتم توجيهك إلى بوابة الدفع لإتمام العملية عبر Chargily</p>
    </div>

    <!-- معلومات الاشتراك -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <strong>معلومات الاشتراك</strong>
        </div>
        <div class="card-body">
            <p><strong>الخطة:</strong> {{ get_seller_plan_data($order->plan_id)->name }}</p>
            <p><strong>المدة:</strong> {{ $order->duration }} يوم</p>
            <p><strong>المبلغ:</strong> {{ number_format($order->price, 2) }} د.ج</p>
            <p><strong>الحالة:</strong> 
                @if($order->payment_status === 'paid')
                    <span class="badge bg-success">مدفوع</span>
                @else
                    <span class="badge bg-warning">في الانتظار</span>
                @endif
            </p>
        </div>
    </div>

    <!-- زر الدفع -->
    <div class="text-center">
        <form action="{{ route('seller.chargilypay.redirect') }}" method="POST">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="sub_plan_id" value="{{ $sub_plan_id }}">
            <input type="hidden" name="payment_type" value="seller_subscription">
            <input type="hidden" name="reference_id" value="{{get_seller_data(auth()->user()->tenant_id)->id}}">

            <button type="submit" class="btn btn-primary btn-lg">
                <i class="bi bi-wallet2"></i> الدفع عبر Chargily
            </button>
        </form>
    </div>
</div>

<!-- إشعار نجاح -->
@if(session()->has('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'تم إرسال الطلب إلى Chargily',
        text: '{{ session('success') }}',
        confirmButtonText: 'حسناً',
        timer: 3000
    });
</script>
@endif
