<div class="container d-flex justify-content-center align-items-center">
    <div class="card mt-4 mb-4 col-md-6 thank-you-card">
        <div class="card-header">{{ __("store.blocked_store_title") }}</div>
        <div class="card-body">{{$message}}</div>
        <a class="btn btn-primary m-5" href="{{route('tenant.products')}}">{{ __("store.continue_shopping") }}</a>
    </div>
</div>
@if(session('error'))
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    Swal.fire({
        title: "{{ __('store.blocked_store_title') }}",
        text: "{{ session('error') }}",
        icon: "error",
        confirmButtonText: "{{ __('store.ok') }}"
    });
</script>
@endif