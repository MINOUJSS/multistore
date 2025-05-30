<div class="container mt-4">
    <h2 class="text-center mb-4">بيانات الدفع عبر CCP</h2>

    <!-- صورة CCP -->
    <div class="text-center mb-4">
        <img src="{{ asset('asset/users/dashboard/img/payments/algerie post.png') }}" alt="CCP" class="img-fluid" style="max-width: 200px;">
        <p class="text-muted mt-2">يرجى إرسال الحوالة البريدية إلى الحساب الموضح أدناه ورفع إيصال الدفع</p>
    </div>

    <!-- معلومات الدفع -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <strong>معلومات الحساب</strong>
        </div>
        <div class="card-body">
            <p><strong>رقم الحساب:</strong> 12345.67.89</p>
            <p><strong>الاسم:</strong> الشركة الرقمية</p>
            @if ($old_subscription->plan_id == 1 && in_array($order->plan_id, [2, 3]))
            <p><strong>المبلغ:</strong> {{ number_format($order->price, 2) }} د.ج</p>
            @else
            <p><strong>المبلغ:</strong> {{ get_rest_off_current_supplier_plan($order->supplier_id, $old_subscription->plan_id, $order->plan_id, $rest_days) }} د.ج</p>
            @endif
            <p><strong>الحالة:</strong> 
                @if($order->payment_status === 'paid')
                    <span class="badge bg-success">مدفوع</span>
                @else
                    <span class="badge bg-warning">في الانتظار</span>
                @endif
            </p>
        </div>
    </div>
    @if($order->payment_status === 'paid')
        <!---->
    @else
    <!-- نموذج رفع الإيصال -->
    <div class="card">
        <div class="card-body">
            <form action="{{route('supplier.subscription.payment.ccp')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="payment_method" value="ccp">
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                {{-- <input type="hidden" name="amount" value="{{ $order->price }}"> --}}

                <div class="mb-3">
                    <label for="payment_proof" class="form-label">رفع إيصال الدفع (صورة أو PDF)</label>
                    <input type="file" name="payment_proof" id="payment_proof" class="form-control" accept="image/jpeg,image/png,application/pdf" required>
                </div>

                <button type="submit" class="btn btn-success w-100">
                    <i class="bi bi-upload"></i> تأكيد الدفع
                </button>
            </form>
        </div>
    </div>
    @endif
</div>

<!-- إشعار نجاح -->
@if(session()->has('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'تم إرسال الإيصال بنجاح',
        text: '{{ session('success') }}',
        confirmButtonText: 'موافق',
        timer: 3000
    });
</script>
@endif
