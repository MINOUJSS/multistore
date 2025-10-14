<div class="container">
    {{-- section for welcome message --}}
    <section>
        <div class="container">
            <div class="row welcome-container mt-5">
                <h2 class="text-center title">{{ $store_settings[18]->value }}</h2>
                <p class="text-center">{{ $store_settings[1]->value }}</p>
            </div>
        </div>
    </section>

    {{-- slider section  --}}

    <style>
        .hero-slider-section .carousel-item {
            height: 60vh;
            min-height: 300px;
            background-color: #000;
            overflow: hidden;
            position: relative;
        }

        .hero-slider-section .carousel-item img {
            object-fit: cover;
            width: 100%;
            height: 100%;
            filter: brightness(0.7);
        }

        .hero-slider-section .carousel-caption {
            bottom: 20%;
            text-align: start;
            max-width: 500px;
            margin: auto;
        }

        .carousel-caption h3,
        .carousel-caption p {
            animation: fadeInUp 1s ease both;
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(30px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
    @if (!empty($sliders) && $slider_status->value == 'true')
        <section class="hero-slider-section">
            <div class="container-fluid px-0">
                <div id="mainHeroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">

                    <!-- Indicators -->
                    <div class="carousel-indicators">
                        @foreach ($sliders as $key => $slider)
                            <button type="button" data-bs-target="#mainHeroCarousel"
                                data-bs-slide-to="{{ $key }}"
                                @if ($key == 0) class="active" aria-current="true" @endif
                                aria-label="Slide {{ $key + 1 }}"></button>
                        @endforeach
                    </div>

                    <!-- Slides -->
                    <div class="carousel-inner">
                        @foreach ($sliders as $key => $slider)
                            <a href="{{ $slider->link }}">
                                <div class="carousel-item @if ($key == 0) active @endif">
                                    <img src="{{ asset($slider->image) }}" class="d-block w-100 img-fluid"
                                        alt="slider image">
                                    <div
                                        class="carousel-caption d-md-block bg-dark bg-opacity-50 p-4 rounded-4 shadow fade-in-up">
                                        <h3 class="fw-bold text-light">{{ $slider->title }}</h3>
                                        <p class="text-light">{{ $slider->description }}</p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#mainHeroCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">السابق</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#mainHeroCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">التالي</span>
                    </button>
                </div>
            </div>
        </section>
    @endif


    {{-- category section  --}}

    <style>
        .zoom-hover:hover {
            transform: scale(1.05);
            transition: 0.3s ease-in-out;
        }
    </style>

    @if (!empty($categories) && count(get_supplier_categories(tenant('id'))) > 0 && $categories_status->value == 'true')
        <section class="featured-products py-5">
            <div class="container">
                <h2 class="text-center mb-5 fade-in title">الأصناف المميزة</h2>
                <div class="row g-3 justify-content-center">

                    <!-- كارت "كل الأصناف" -->
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <div class="card text-center shadow-sm border-0 zoom-hover p-2 h-100">
                            <img src="{{ asset('asset/v1/users/store/img/categories/0.png') }}"
                                class="rounded-circle mx-auto d-block" alt="كل الأصناف" width="80" height="80">
                            <div class="card-body p-2">
                                <h6 class="card-title fw-bold mb-1 small">كل الأصناف</h6>
                                <p class="text-muted small mb-2">أحدث المنتجات</p>
                                <a href="/products" class="btn btn-sm btn-outline-primary btn-ripple w-100">عرض</a>
                            </div>
                        </div>
                    </div>

                    <!-- الكروت الديناميكية -->
                    @foreach ($categories as $key => $category)
                        <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                            <div class="card text-center shadow-sm border-0 zoom-hover p-2 h-100">
                                <img src="{{ asset($category->image) }}" class="rounded-circle mx-auto d-block"
                                    alt="{{ $category->category->name }}" width="80" height="80">
                                <div class="card-body p-2">
                                    <h6 class="card-title fw-bold mb-1 small">{{ $category->category->name }}</h6>
                                    <p class="text-muted small mb-2">
                                        {{ Str::limit($category->category->description, 30) }}</p>
                                    <a href="/products-by-category/{{ $category->category_id }}"
                                        class="btn btn-sm btn-outline-primary btn-ripple w-100">عرض</a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    @endif


    <style>
        .icon-circle {
            width: 70px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            margin: 0 auto;
            background-color: #0d6efd;
            /* Bootstrap primary */
            color: white;
        }

        .hover-shadow:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .transition-all {
            transition: all 0.3s ease-in-out;
        }

        .glass-effect {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(8px);
            border-radius: 20px;
        }
    </style>
    @if ($benefit_section->status == 'active')
        <section class="benefits-section py-5 glass-effect">
            <div class="container">
                <h2 class="text-center fw-bold fade-in title">{{ $benefit_section->title }}</h2>
                <p class="text-center mb-5 fade-in">{{ $benefit_section->description }}</p>
                <div class="row justify-content-center g-4">
                    @foreach ($benefit_elements as $element)
                        <div class="col-12 col-sm-6 col-md-4">
                            <div
                                class="benefit-card text-center p-4 shadow-sm rounded-4 h-100 bg-white hover-shadow transition-all">
                                <div class="icon-circle bg-primary text-white mb-3">
                                    {!! $element->icon !!}
                                </div>
                                <h5 class="fw-semibold">{{ $element->title }}</h5>
                                <p class="text-muted small mb-0">{{ $element->description }}</p>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>
    @endif




    <style>
        .zoom-hover img {
            transition: transform 0.3s ease-in-out;
        }

        .zoom-hover:hover img {
            transform: scale(1.05);
        }

        .quick-view-btn {
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            transition: all 0.2s ease-in-out;
        }

        .quick-view-btn:hover {
            background-color: #f8f9fa;
        }

        .product-card .price sup {
            font-size: 0.7em;
        }

        /* تأثير الزر عند الإضافة للسلة */
        .add-to-cart-btn:active {
            transform: scale(0.95);
            transition: transform 0.1s ease-in-out;
        }

        /* شارة "غير متوفر" */
        .badge.bg-danger {
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 0 0.5rem 0.5rem 0;
            font-weight: bold;
        }
    </style>

    @if (!empty($products))
        <section class="py-5">
            <div class="container">
                <h2 class="text-center mb-5 fade-in title">أحدث المنتجات</h2>
                <div class="row g-4 justify-content-center">
                    @foreach ($products as $key => $product)
                        <div class="col-12 col-sm-6 col-lg-3">
                            <div class="card h-100 shadow-sm border-0 product-card position-relative overflow-hidden">

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

                                        @if (supplier_product_has_discount($product->id))
                                            <p class="price fw-bold text-primary mb-3">
                                                {{ $product->activeDiscount->discount_amount }}
                                                <sup>د.ج</sup> <span class="text-decoration-line-through text-danger">
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

                                        @if ($product->qty > 0 && !is_cart_has_this_product($product->id))
                                            <form method="post" action="{{ route('tenant.add-to-cart') }}"
                                                class="d-inline-block">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity"
                                                    value="{{ supplier_product_min_qty($product->id) }}">
                                                <input id="variation_id" type="hidden" name="variation_id"
                                                    value="0" />

                                                <input id="attribute_id" type="hidden" name="attribute_id"
                                                    value="0" />
                                                <button type="submit" class="btn btn-primary btn-sm add-to-cart-btn">
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
        </section>
    @endif



    {{-- fqa section  --}}
    @if ($faqs_status->value == 'true')
        <section>
            <div class="container">
                <div class="row">
                    <div class="row fqa-container mb-5">
                        <h2 class="text-center mb-5 title">الاسئلة الشائعة</h2>
                        <div class="accordion" id="accordionPanelsStayOpenExample">
                            @foreach ($faqs as $key => $faq)
                                @if ($faq->status == 'active')
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="panelsStayOpen-heading{{ $key }}">
                                            <button
                                                class="accordion-button @if ($key !== 0) {{ 'collapsed' }} @endif"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#panelsStayOpen-collapse{{ $key }}"
                                                @if ($key == 0) {{ 'aria-expanded=true' }}@else{{ 'aria-expanded=false' }} @endif
                                                aria-controls="panelsStayOpen-collapse{{ $key }}">
                                                {{ $faq->question }}
                                            </button>
                                        </h2>
                                        <div id="panelsStayOpen-collapse{{ $key }}"
                                            class="accordion-collapse collapse @if ($key == 0) {{ 'show' }}@else{{ 'collapsed' }} @endif"
                                            @if ($key == 0) {{ 'aria-labelledby=panelsStayOpen-headingshow' }} @endif
                                            aria-labelledby="panelsStayOpen-heading{{ $key }}">
                                            <div class="accordion-body">
                                                {{ $faq->answer }}
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>

                    </div>
                </div>
            </div>

        </section>
    @endif
</div>
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
