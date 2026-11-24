        <style>
            .product-img {
                width: 80px;
                height: 80px;
                object-fit: cover;
            }

            .color-swatch {
                width: 20px;
                height: 20px;
                display: inline-block;
                border: 1px solid #dee2e6;
            }

            .quantity-input {
                width: 60px;
                text-align: center;
            }

            body {
                /* font-family: 'Tahoma', Arial, sans-serif; */
            }
        </style>
        <div class="container py-5">
            <div class="row mb-4">
                <div class="col">
                    <h1 class="fw-bold">{{ __("store.cart_title") }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">{{ __("store.home") }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __("store.cart") }}</li>
                        </ol>
                    </nav>
                </div>
            </div>

            <!-- Cart Items Section -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm mb-4">
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table align-middle">
                                    <thead class="table-light">
                                        <tr>
                                            <th scope="col" style="width: 45%">{{ __("store.products") }}</th>
                                            <th scope="col">{{ __("store.price") }}</th>
                                            <th scope="col">{{ __("store.quantity") }}</th>
                                            <th scope="col">{{ __("store.total") }}</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    @include('stores.suppliers.components.content.cart.inc.t_body')
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        @if(session()->has('cart') && count(session()->get('cart')->items) > 0)
                        <a href="{{ route('tenant.remove-all-from-cart') }}" class="btn btn-outline-danger">
                            <i class="bi bi-trash me-2"></i>{{ __("store.empty_cart") }}
                        </a>
                        @endif
                        <a href="{{ route('tenant.products') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-arrow-right me-2"></i>{{ __("store.continue_shopping") }}
                        </a>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="col-lg-4 mt-4 mt-lg-0">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="card-title mb-4">{{ __("store.cart_title") }}</h5>

                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">{{ __("store.subtotal") }}</span>
                                @if (session()->has('cart') && session()->get('cart')->totalPrice != null)
                                    <span
                                        class="cart-total-price">{{ number_format(session()->get('cart')->totalPrice, 2) }}
                                        {{ __("store.currency") }}</span>
                                @else
                                    <span class="cart-total-price">0.00 {{ __("store.currency") }}</span>
                                @endif
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="text-muted">{{ __("store.shipping_cost") }}</span>
                                <span>0.00 {{ __("store.currency") }}</span>
                            </div>
                            {{-- <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">الضريبة</span>
                            <span>4.20 ر.س</span>
                        </div> --}}

                            <hr>
                            {{-- {{dd(session('cart'))}} --}}
                            <div class="d-flex justify-content-between fw-bold mb-4">
                                <span>{{ __("store.total") }}</span>
                                @if (session()->has('cart') && session()->get('cart')->totalPrice != null)
                                    <span
                                        class="cart-total-price">{{ number_format(session()->get('cart')->totalPrice, 2) }}
                                        {{ __("store.currency") }}</span>
                                @else
                                    <span class="cart-total-price">0.00 {{ __("store.currency") }}</span>
                                @endif
                            </div>
                            @if (session()->has('cart') && session()->get('cart')->totalPrice != 0)
                                <a href="{{ route('tenant.checkout') }}" class="btn btn-primary w-100 py-2 mb-3">
                                    {{ __("store.checkout") }}
                                </a>
                            @endif

                            {{-- <div class="text-center">
                            <img src="https://via.placeholder.com/200x30?text=طرق+الدفع" alt="طرق الدفع" class="img-fluid">
                        </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- {{dd(session('cart'))}} --}}
        {{-- sweet alert --}}
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if (session('success'))
            <script>
                Swal.fire({
                    title: 'نجاح!',
                    text: "{{ session('success') }}",
                    icon: 'success',
                    confirmButtonText: 'حسنًا'
                });
            </script>
        @endif
