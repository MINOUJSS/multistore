
    @if($product_type== "physical") 
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card mt-4 mb-4 col-md-6 thank-you-card">
            <div class="card-header">شكراً</div>
            <div class="card-body">شكراً لطلبك!❤️ سيتم التواصل معك قريبًا.</div>
            <a class="btn btn-primary m-5" href="{{route('tenant.products')}}">العودة للتسوق</a>
        </div>
    </div>
    @else 
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card mt-4 mb-4 col-md-6 thank-you-card">
            <div class="card-header">شكراً</div>
            <div class="card-body">
                شكراً لشرائك منتجنا!❤️ قم بتحميله من هنا
            </div>
            <a class="btn btn-primary m-5" href="{{$download_link}}" target="_blank">تحميل المنتج الرقمي</a>
        </div>
    </div>
    @endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success') && $product_type== "physical")
<script>
    Swal.fire({
        title: "تم إرسال الطلب!",
        text: "{{ session('success') }}",
        icon: "success",
        confirmButtonText: "حسنًا"
    });
</script>
@else 
<script>
    Swal.fire({
        title: "تمت علملية الدفع بنجاح",
        text: "قم بتحميل منتجك الرقمي من خلال الرابط الظاهر في الصفحة",
        icon: "success",
        confirmButtonText: "حسنًا"
    });
</script>
@endif