    @if($product_type == "physical") 
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card mt-4 mb-4 col-md-6 thank-you-card text-center p-3 shadow-sm border-0 rounded-4">
            <div class="card-header bg-transparent border-0 fs-4 fw-bold text-success">
                <i class="fas fa-check-circle me-1"></i> {{ __('store.order_success_title') }}
            </div>
            <div class="card-body fs-6 text-muted">{{ __('store.order_success_desc') }}</div>
            <div class="d-flex justify-content-center">
                <a class="btn btn-primary m-3 px-4 py-2 rounded-pill fw-bold" href="{{ route('tenant.products') }}">
                    <i class="fas fa-shopping-bag me-1"></i> {{ __('store.continue_shopping') }}
                </a>
            </div>
        </div>
    </div>
    @else 
    <div class="container d-flex justify-content-center align-items-center">
        <div class="card mt-4 mb-4 col-md-6 thank-you-card text-center p-3 shadow-sm border-0 rounded-4">
            <div class="card-header bg-transparent border-0 fs-4 fw-bold text-success">
                <i class="fas fa-check-circle me-1"></i> {{ __('store.order_success_title') }}
            </div>
            <div class="card-body fs-6 text-muted">
                {{ __('store.order_success_desc') }}
            </div>
            <div class="d-flex justify-content-center">
                <a class="btn btn-primary m-3 px-4 py-2 rounded-pill fw-bold" href="{{ $download_link }}" target="_blank">
                    <i class="fas fa-download me-1"></i> {{ __('store.download_digital_product') }}
                </a>
            </div>
        </div>
    </div>
    @endif

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@if(session('success') && $product_type == "physical")
<script>
    Swal.fire({
        title: "{{ __('store.order_success_title') }}",
        text: "{{ session('success') }}",
        icon: "success",
        confirmButtonText: "{{ __('store.ok') }}"
    });
</script>
@else 
<script>
    Swal.fire({
        title: "{{ __('store.order_success_title') }}",
        text: "{{ __('store.digital_product_download_desc') }}",
        icon: "success",
        confirmButtonText: "{{ __('store.ok') }}"
    });
</script>
@endif
