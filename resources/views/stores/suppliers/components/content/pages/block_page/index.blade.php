<div class="container d-flex justify-content-center align-items-center">
    <div class="card mt-4 mb-4 col-md-6 thank-you-card">
        <div class="card-header">لا يمكنك تقديم طلبات على هذا المتجر 😞</div>
        <div class="card-body">{{$message}}</div>
        <a class="btn btn-primary m-5" href="{{route('tenant.products')}}">العودة للتسوق</a>
    </div>
</div>
@if(session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: "لا يمكنك تقديم طلبات على هذا المتجر 😞",
        text: "{{ session('error') }}",
        icon: "error",
        confirmButtonText: "حسنًا"
    });
</script>
@endif