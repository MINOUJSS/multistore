<div class="container mt-4">
    <h2 class="text-center mb-4">الدفع عبر رصيد المحفظة</h2>

    <!-- معلومات المحفظة -->
    <div class="card mb-4">
        <div class="card-header bg-light">
            <strong>رصيدك الحالي</strong>
        </div>
        <div class="card-body">
            <p><strong>الخطة:</strong> {{ get_seller_plan_data($order->plan_id)->name }}</p>
            <p><strong>رصيد المحفظة:</strong> {{ number_format(auth()->user()->balance->balance, 2) }} د.ج</p>
            <p><strong>المدة:</strong> {{ $order->duration }} يوم</p>
            @php
            if($old_subscription->plan_id == 1 && in_array($order->plan_id, [2, 3]))
            {
                $price=$order->price;
            }else
            {
                $price=get_rest_off_current_seller_plan($order->seller_id, $old_subscription->plan_id, $order->plan_id, $rest_days);
            }
            @endphp
            @if ($old_subscription->plan_id == 1 && in_array($order->plan_id, [2, 3]))
            <p><strong>المبلغ:</strong> {{ number_format($order->price, 2) }} د.ج</p>
            @else
            <p><strong>المبلغ:</strong> {{ get_rest_off_current_seller_plan($order->seller_id, $old_subscription->plan_id, $order->plan_id, $rest_days) }} د.ج</p>
            @endif

            @if(auth()->user()->balance->balance >= $price)
                <div class="alert alert-success mt-3">
                    يمكنك تأكيد الدفع مباشرة من رصيد محفظتك.
                </div>
            @else
                <div class="alert alert-danger mt-3">
                    رصيدك غير كافٍ لإتمام هذه العملية. يرجى شحن المحفظة أولاً <a href="{{ route('seller.wallet') }}">هنا</a>.
                </div>
            @endif
        </div>
    </div>
    @if($order->payment_status === 'paid')
        <!---->
    @else
        <!-- نموذج تأكيد الدفع -->
            @if(auth()->user()->balance->balance >= $price)
            <div class="card">
                <div class="card-body">
                    <form action="{{route('seller.subscription.payment.wallet')}}" method="POST">
                        @csrf
                        <input type="hidden" name="payment_method" value="wallet">
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <input type="hidden" name="plan_id" value="{{ $order->plan_id }}">
                        <input type="hidden" name="duration" value="{{ $order->duration }}">
                        <input type="hidden" name="old_subscription_plan_id" value="{{$old_subscription->plan_id}}">
                        <input type="hidden" name="seller_id" value="{{$order->seller_id}}">
                        <input type="hidden" name="rest_days" value="{{$rest_days}}">
                        {{-- <input type="hidden" name="amount" value="{{ $order->price }}"> --}}

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-wallet2"></i> تأكيد الدفع من المحفظة
                        </button>
                    </form>
                </div>
            </div>
            @endif
    @endif
</div>

<!-- إشعار نجاح -->
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
