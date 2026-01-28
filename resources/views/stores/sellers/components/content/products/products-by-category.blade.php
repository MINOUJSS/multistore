<div class="container">
    @if (!empty($products))
        <section>
            <div class="container">
                <div class="row">
                    <div class="row products-container">
                        <h2 class="text-center mb-5 mt-5">منتجات التصنيف</h2>
                        <!-- Product Card Template -->
                        @foreach ($products as $key => $product)
                            <div class="col-12 col-sm-6 col-lg-3">
                                <div
                                    class="card h-100 shadow-sm border-0 product-card position-relative overflow-hidden">

                                    <!-- شارة نفاد الكمية -->
                                    @if ($product->qty == 0)
                                        <span class="badge bg-danger position-absolute top-0 start-0 m-2 z-2">غير
                                            متوفر</span>
                                    @endif

                                    <!-- صورة المنتج -->
                                    <div class="position-relative zoom-hover">
                                        <img src="{{ asset($product->image) }}" class="card-img-top rounded-top"
                                            alt="{{ $product->name }}">
                                        <button
                                            class="quick-view-btn btn btn-light btn-sm position-absolute top-0 end-0 m-2"
                                            data-product-id="{{ $key }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </div>

                                    <!-- معلومات المنتج -->
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <div>
                                            <h5 class="card-title fw-bold">{{ $product->name }}</h5>
                                            <div class="mb-2 small text-warning">
                                                {{-- @for ($i = 1; $i <= 5; $i++)
                  @if ($i <= 4)
                    <i class="fas fa-star"></i>
                  @else
                    <i class="far fa-star"></i>
                  @endif
                @endfor --}}
                                                @php
                                                    $total_stars = 0;
                                                    $reviews = $product->reviews;
                                                    foreach ($reviews as $review) {
                                                        $total_stars += $review->rating;
                                                    }
                                                    if ($reviews->count() > 0) {
                                                        $stars = $total_stars / $reviews->count();
                                                    } else {
                                                        $stars = 0;
                                                    }

                                                    $rest = 5 - round($stars);
                                                @endphp
                                                @for ($i = 0; $i < round($stars); $i++)
                                                    <i class="fas fa-star text-warning"></i>
                                                @endfor
                                                @for ($i = 0; $i < round($rest); $i++)
                                                    <i class="far fa-star text-warning"></i>
                                                @endfor
                                                <span
                                                    class="ms-1 text-muted">{{ '(' . number_format(round($stars), 1) . ')' }}</span>
                                            </div>

                                            @if (seller_product_has_discount($product->id))
                                                <p class="price fw-bold text-primary mb-3">
                                                    {{ $product->activeDiscount->discount_amount }}
                                                    <sup>د.ج</sup> <span
                                                        class="text-decoration-line-through text-danger">
                                                        {{ $product->price }}<sup>د.ج</sup></span><sup><span
                                                            class="text-success">
                                                            (-{{ $product->activeDiscount->discount_percentage }}%)
                                                        </span></sup>
                                                </p>
                                            @else
                                                <p class="price fw-bold text-primary mb-3">
                                                    {{ $product->price }} <sup>د.ج</sup>
                                                </p>
                                            @endif
                                        </div>

                                        <!-- أزرار الإجراءات -->
                                        <div class="d-flex justify-content-between align-items-center gap-2">
                                            <a href="/product/{{ $product->id }}"
                                                class="btn btn-outline-primary btn-sm w-100">عرض التفاصيل</a>

                                            @if ($product->qty > 0)
                                                <form method="post" action="{{ route('tenant.add-to-cart') }}"
                                                    class="d-inline-block">
                                                    @csrf
                                                    <input type="hidden" name="product_id"
                                                        value="{{ $product->id }}">
                                                    <input type="hidden" name="quantity" value="1">
                                                    <button type="submit"
                                                        class="btn btn-primary btn-sm add-to-cart-btn"
                                                        onclick="addToCartAnimation(this)">
                                                        <input id="variation_id" type="hidden" name="variation_id"
                                                            value="0" />

                                                        <input id="attribute_id" type="hidden" name="attribute_id"
                                                            value="0" />
                                                        <i class="fas fa-cart-plus"></i>
                                                    </button>
                                                </form>
                                                {{-- <button class="btn btn-primary btn-sm add-to-cart-btn" onclick="addToCartAnimation(this)">
                <i class="fas fa-cart-plus"></i>
              </button> --}}
                                            @else
                                                <button class="btn btn-secondary btn-sm" disabled>
                                                    <i class="fas fa-ban"></i>
                                                </button>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif
</div>
