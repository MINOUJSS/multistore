<div class="container d-flex justify-content-center align-items-center">
    <div class="card m-5 col-4">
        <div class="card-header">شكراً</div>
        <div class="card-body">شكراً لطلبك!❤️ سيتم التواصل معك قريبًا.</div>
        <a class="btn btn-primary m-5" href="{{route('tenant.products')}}">العودة للتسوق</a>
    </div>
</div>
@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: "تم إرسال الطلب!",
        text: "{{ session('success') }}",
        icon: "success",
        confirmButtonText: "حسنًا"
    });
</script>
@endif