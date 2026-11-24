<div class="container d-flex justify-content-center align-items-center">
    <div class="card mt-4 mb-4 col-md-6 thank-you-card">
        <div class="card-header">{{ __("store.order_success_title") }}</div>
        <div class="card-body">{{ __("store.order_success_desc") }}</div>
        <a class="btn btn-primary m-5" href="{{route('tenant.products')}}">{{ __("store.continue_shopping") }}</a>
    </div>
</div>
@if(session('success'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: "{{ __('store.order_submitted') }}",
        text: "{{ session('success') }}",
        icon: "success",
        confirmButtonText: "{{ __('store.ok') }}"
    });
</script>
@endif