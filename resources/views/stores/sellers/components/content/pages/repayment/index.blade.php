<div class="container d-flex justify-content-center align-items-center">
        <div class="card mt-4 mb-4 col-md-6 thank-you-card">
            <div class="card-header">فشل عملية الدفع</div>
            <div class="card-body">يرجى المحاولة مرة أخرى</div>
            <a class="btn btn-primary m-5" href="{{route('tenant.payments.show_chargily_pay',session()->get('order_id'))}}">إعادة المحاولة للدفع </a>
        </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('payment_error'))
<script>
    Swal.fire({
        title: "فشل عملية الدفع!",
        text: "{{ session('success') }}",
        icon: "error",
        confirmButtonText: "حسنًا"
    });
</script>
@endif