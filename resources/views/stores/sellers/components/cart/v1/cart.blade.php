<!-- start cart main -->
<div class="offcanvas offcanvas-end" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling"
    aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header bg-light border-bottom">
        <a class="navbar-brand" href="{{ route('tenant.cart') }}">
            <h5 class="offcanvas-title" id="offcanvasScrollingLabel">سلة مشترياتي</h5>
        </a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>

    <div class="offcanvas-body d-flex flex-column justify-content-between p-0">
        <main class="cart-body p-3" style="overflow-y: auto; max-height: 70vh;">
            <form action="/">
                <ul class="list-unstyled">

                    <!-- عنصر السلة -->
                    @if (session()->has('cart') && session()->get('cart')->totalQty > 0)
                        @foreach (session()->get('cart')->items as $item)
                            <li class="cart-item mb-3 p-2 border rounded d-flex align-items-center gap-3 flex-wrap">
                                <img src="{{ $item['image'] }}" alt="إسم المنتج" class="rounded" width="60"
                                    height="60">
                                <div class="flex-grow-1">
                                    <h6 class="mb-1"><a href="{{ route('tenant.product', $item['id']) }}"
                                            class="text-decoration-none text-dark">{{ $item['title'] }}</a></h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="small text-muted">الكمية:
                                            <strong>{{ $item['qty'] }}</strong></span>
                                        <span class="text-primary fw-bold">{{ $item['price'] }} د.ج</span>
                                    </div>
                                </div>
                                <div class="d-flex flex-column gap-1">
                                    {{-- <button type="button" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-pen"></i></button> --}}
                                    <a href="{{ route('tenant.remove-from-cart', $item['id']) }}"
                                        class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash-can"></i></a>
                                </div>
                            </li>
                        @endforeach
                    @else
                        لا توجد منتجات في سلة التسوق
                    @endif

                    <!-- عنصر ثاني -->
                    {{-- <li class="cart-item mb-3 p-2 border rounded d-flex align-items-center gap-3 flex-wrap">
            <img src="{{asset('asset/v1/users/store')}}/img/logo/store.png" alt="إسم المنتج" class="rounded" width="60" height="60">
            <div class="flex-grow-1">
              <h6 class="mb-1"><a href="#" class="text-decoration-none text-dark">ماكنة حلاقة من النوع الرفيع</a></h6>
              <div class="d-flex justify-content-between align-items-center">
                <span class="small text-muted">الكمية: <strong>1</strong></span>
                <span class="text-primary fw-bold">199 د.ج</span>
              </div>
            </div>
            <div class="d-flex flex-column gap-1">
              <button type="button" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-pen"></i></button>
              <button type="button" class="btn btn-outline-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
            </div>
          </li> --}}

                </ul>
            </form>
        </main>

        <!-- Footer -->
        <footer class="cart-footer bg-light border-top p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">مجموع سلة التسوق:</h6>
                @if (session()->has('cart'))
                    <span class="text-success fw-bold fs-6">{{ number_format(session()->get('cart')->totalPrice, 2) }}
                        د.ج</span>
                @else
                    <span class="text-success fw-bold fs-6">0.00 د.ج</span>
                @endif
            </div>
            <div class="d-grid gap-2">
                <a href="{{ route('tenant.checkout') }}" class="btn btn-primary w-100">شراء الآن</a>
                <a href="{{ route('tenant.products') }}" class="btn btn-outline-secondary w-100">استمر في التسوق</a>
            </div>
        </footer>
    </div>
</div>
<!-- end cart main -->
