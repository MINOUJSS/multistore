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
            <p><strong>الخطة:</strong> {{ $plan->name }}</p>
            <p><strong>المدة:</strong> {{ $duration }} يوم</p>
            <p><strong>المبلغ:</strong> {{ number_format($price, 2) }} د.ج</p>
            <p><strong>مميزات الخطة:</strong>
            <ul class="list-group list-group-flush mb-3" style="list-style: none">
            @foreach($plan->authorizations as $auth)
            @if($auth->is_enabled !==0)

                <li><i class="fas fa-check-circle text-success"></i> {{$auth->description}}</li>
            @else
       
                <li><i class="fas fa-times-circle text-danger"></i> {{$auth->description}}</li>
            @endif
            @endforeach
            </ul>
        </div>
    </div>

    <!-- زر الدفع -->
    <div class="text-center">
        <form action="{{ route('seller.chargilypay.redirect') }}" method="POST">
            @csrf
            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
            <input type="hidden" name="sub_plan_id" value="{{ $sub_plan_id }}">
            <input type="hidden" name="payment_type" value="new_seller_subscription">
            <input type="hidden" name="reference_id" value="{{get_seller_data(auth()->user()->tenant_id)->id}}">

            <button type="submit" class="btn btn-primary btn-lg mb-3">
                <i class="bi bi-credit-card"></i> الدفع عبر Chargily
            </button>
        </form>
    </div>
</div>
<!-- إشعار نجاح -->
@if(session('success'))
    <script>
        Swal.fire({
            title: 'نجاح!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'حسنًا'
        });
    </script>
@endif
