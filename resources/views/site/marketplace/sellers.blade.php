@extends('site.layouts.app')

@section('google_analitics')
    @if(
        get_platform_data('google_analitics') &&
        get_platform_data('google_analitics')->status == 'active' &&
        !empty(get_platform_data('google_analitics')->value)
    )
        @php
            $measurementId = get_platform_data('google_analitics')->value;
        @endphp
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $measurementId }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', '{{ $measurementId }}');
        </script>
    @endif
@endsection

@section('hero')
<!-- ======= Sellers Marketplace Hero Header ======= -->
<section id="hero" class="d-flex align-items-center position-relative overflow-hidden py-5" style="min-height: 38vh;">
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>

    <div class="container position-relative z-index-2 py-4 text-center">
        <!-- Badge Pill -->
        <div class="d-inline-flex align-items-center gap-2 mb-3 hero-badge-pill">
            <span class="badge-icon">🛍️</span>
            <span class="badge-text fw-bold">{{ __('site.sellers_marketplace') }}</span>
        </div>

        <!-- Main Title -->
        <h1 class="hero-main-title fw-bold text-white mb-3 fs-1">
            {{ __('site.marketplace_sellers_title') }}
        </h1>

        <!-- Subtitle -->
        <p class="hero-sub-title mb-4 fs-6 mx-auto text-white-80" style="max-width: 740px;">
            {{ __('site.marketplace_sellers_subtitle') }}
        </p>

        <!-- Quick Switch & Breadcrumb -->
        <div class="d-flex flex-wrap align-items-center justify-content-center gap-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 m-0 text-white-50">
                    <li class="breadcrumb-item"><a href="{{ route('site.index') }}" class="text-white text-decoration-none fw-semibold">{{ __('site.home') }}</a></li>
                    <li class="breadcrumb-item active text-pink-accent fw-bold" aria-current="page">{{ __('site.sellers_marketplace') }}</li>
                </ol>
            </nav>
            <span class="text-white-50 d-none d-md-inline">|</span>
            <a href="{{ route('site.marketplace.suppliers') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center gap-2">
                <i class="bi bi-box-seam"></i>
                <span>{{ __('site.suppliers_marketplace') }}</span>
                <i class="bi bi-arrow-left-short"></i>
            </a>
        </div>
    </div>

    <style>
        #hero {
            background: linear-gradient(135deg, #180413 0%, #350c27 45%, #5d1743 85%, #B03882 100%);
        }
        .hero-glow-1 {
            position: absolute;
            width: 420px;
            height: 420px;
            background: radial-gradient(circle, rgba(176, 56, 130, 0.45) 0%, rgba(176, 56, 130, 0) 70%);
            top: -10%;
            left: -5%;
            filter: blur(50px);
            pointer-events: none;
        }
        .hero-glow-2 {
            position: absolute;
            width: 380px;
            height: 380px;
            background: radial-gradient(circle, rgba(255, 133, 198, 0.3) 0%, rgba(255, 133, 198, 0) 70%);
            bottom: -10%;
            right: -5%;
            filter: blur(40px);
            pointer-events: none;
        }
        .hero-badge-pill {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            padding: 6px 18px;
            border-radius: 50px;
            color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .text-pink-accent {
            color: #ff9ed2 !important;
        }
        .text-white-80 {
            color: rgba(255, 255, 255, 0.88) !important;
        }
    </style>
</section>
@endsection

@section('content')
<!-- ======= Sellers Marketplace Section ======= -->
<section class="marketplace-section py-5" style="background: #f8f9fc; min-height: 60vh;">
    <div class="container" data-aos="fade-up">

        <!-- Top Stats & Filter Toolbar -->
        <div class="card border-0 shadow-sm rounded-4 mb-4 filter-card p-4">
            <form action="{{ route('site.marketplace.sellers') }}" method="GET" class="row g-3 align-items-end">
                
                <!-- Search Input -->
                <div class="col-lg-4 col-md-6">
                    <label class="form-label fw-bold text-dark small mb-1">
                        <i class="bi bi-search text-pink me-1"></i> {{ __('site.filter_search_placeholder') }}
                    </label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0 text-muted rounded-start-3"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 rounded-end-3" 
                               value="{{ request('search') }}" placeholder="{{ __('site.filter_search_placeholder') }}">
                    </div>
                </div>

                <!-- Category Filter -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold text-dark small mb-1">
                        <i class="bi bi-grid text-pink me-1"></i> {{ __('site.filter_category') }}
                    </label>
                    <select name="category_id" class="form-select rounded-3">
                        <option value="">{{ __('site.filter_all_categories') }}</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Product Type Filter -->
                <div class="col-lg-3 col-md-6">
                    <label class="form-label fw-bold text-dark small mb-1">
                        <i class="bi bi-layers text-pink me-1"></i> {{ __('site.filter_product_type') }}
                    </label>
                    <select name="product_type" class="form-select rounded-3">
                        <option value="">{{ __('site.filter_all_types') }}</option>
                        <option value="physical" {{ request('product_type') == 'physical' ? 'selected' : '' }}>{{ __('site.product_type_physical') }}</option>
                        <option value="digital" {{ request('product_type') == 'digital' ? 'selected' : '' }}>{{ __('site.product_type_digital') }}</option>
                    </select>
                </div>

                <!-- Free Shipping Filter -->
                <div class="col-lg-2 col-md-6 col-6">
                    <label class="form-label fw-bold text-dark small mb-1">
                        <i class="bi bi-truck text-pink me-1"></i> {{ __('site.filter_free_shipping') }}
                    </label>
                    <select name="free_shipping" class="form-select rounded-3">
                        <option value="">{{ __('site.filter_all') }}</option>
                        <option value="yes" {{ request('free_shipping') == 'yes' ? 'selected' : '' }}>نعم (مجاني)</option>
                        <option value="no" {{ request('free_shipping') == 'no' ? 'selected' : '' }}>لا</option>
                    </select>
                </div>

                <!-- Sort Filter -->
                <div class="col-lg-3 col-md-4 col-6">
                    <label class="form-label fw-bold text-dark small mb-1">
                        <i class="bi bi-sort-down text-pink me-1"></i> {{ __('site.filter_sort') }}
                    </label>
                    <select name="sort" class="form-select rounded-3">
                        <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>{{ __('site.sort_latest') }}</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>{{ __('site.sort_price_low_high') }}</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>{{ __('site.sort_price_high_low') }}</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>{{ __('site.sort_popular') }}</option>
                    </select>
                </div>

                <!-- Price Range & Action Buttons -->
                <div class="col-lg-2 col-md-4 col-6">
                    <label class="form-label fw-bold text-dark small mb-1">{{ __('site.filter_min_price') }}</label>
                    <input type="number" name="min_price" class="form-control rounded-3" 
                           placeholder="0" value="{{ request('min_price') }}" min="0" step="50">
                </div>

                <div class="col-lg-2 col-md-4 col-6">
                    <label class="form-label fw-bold text-dark small mb-1">{{ __('site.filter_max_price') }}</label>
                    <input type="number" name="max_price" class="form-control rounded-3" 
                           placeholder="50000" value="{{ request('max_price') }}" min="0" step="50">
                </div>

                <div class="col-lg-5 col-md-12 d-flex gap-2">
                    <button type="submit" class="btn btn-primary-pink flex-grow-1 rounded-3 py-2 fw-semibold d-inline-flex align-items-center justify-content-center gap-2">
                        <i class="bi bi-funnel"></i>
                        <span>{{ __('site.apply_filters') }}</span>
                    </button>
                    <a href="{{ route('site.marketplace.sellers') }}" class="btn btn-outline-secondary rounded-3 py-2 px-3 fw-semibold" title="{{ __('site.reset_filters') }}">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>

            </form>
        </div>

        <!-- Counter & Results Info Bar -->
        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4 px-2">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-pink-light text-pink fs-6 px-3 py-2 rounded-pill fw-bold">
                    <i class="bi bi-bag-check me-1"></i> {{ $products->total() }} {{ __('site.piece') }}
                </span>
                <span class="text-muted small">{{ __('site.total_products_available') }} {{ $totalProductsCount }}</span>
            </div>
            @if(request()->hasAny(['search', 'category_id', 'product_type', 'min_price', 'max_price', 'free_shipping', 'sort']))
                <div class="text-muted small">
                    <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-3 py-1">
                        <i class="bi bi-filter"></i> فلاتر مفعّلة
                    </span>
                </div>
            @endif
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="row g-4">
                @foreach($products as $product)
                    @php
                        // Store domain resolution
                        $tenantDomain = optional(optional(optional($product->seller)->tenant)->domains)->first();
                        $domainHost = $tenantDomain ? $tenantDomain->domain : null;
                        $storeScheme = request()->getScheme() ?: 'http';
                        $productUrl = $domainHost ? "{$storeScheme}://{$domainHost}/product/{$product->id}" : '#';
                        $storeUrl = $domainHost ? "{$storeScheme}://{$domainHost}" : '#';

                        // Price and Discount
                        $hasDiscount = $product->activeDiscount && $product->activeDiscount->discount_value > 0;
                        $finalPrice = $product->price;
                        $oldPrice = null;
                        if ($hasDiscount) {
                            if ($product->activeDiscount->discount_type == 'percentage') {
                                $oldPrice = $product->price;
                                $finalPrice = $product->price - ($product->price * ($product->activeDiscount->discount_value / 100));
                            } elseif ($product->activeDiscount->discount_type == 'fixed') {
                                $oldPrice = $product->price;
                                $finalPrice = max(0, $product->price - $product->activeDiscount->discount_value);
                            }
                        }

                        // Product Image
                        $productImage = $product->image ?: asset('asset/v1/site/defaulte/img/portfolio/portfolio-1.jpg');
                        if (!str_starts_with($productImage, 'http') && !str_starts_with($productImage, '/')) {
                            $productImage = asset($productImage);
                        }
                    @endphp

                    <div class="col-12 col-sm-6 col-lg-4 col-xl-3" data-aos="fade-up" data-aos-delay="{{ 50 * ($loop->index % 4) }}">
                        <div class="card h-100 product-market-card border-0 rounded-4 shadow-sm overflow-hidden bg-white position-relative">
                            
                            <!-- Badges Overlay -->
                            <div class="position-absolute top-0 end-0 p-3 d-flex flex-column gap-1 z-3">
                                @if($hasDiscount)
                                    <span class="badge bg-danger shadow-sm rounded-pill px-2.5 py-1.5 fw-bold">
                                        خصم {{ $product->activeDiscount->discount_type == 'percentage' ? round($product->activeDiscount->discount_value).'%' : round($product->activeDiscount->discount_value).' د.ج' }}
                                    </span>
                                @endif
                                @if($product->free_shipping == 'yes')
                                    <span class="badge bg-success shadow-sm rounded-pill px-2.5 py-1.5 fw-semibold">
                                        <i class="bi bi-truck me-1"></i> {{ __('site.free_shipping_badge') }}
                                    </span>
                                @endif
                            </div>

                            <!-- Product Image -->
                            <div class="product-img-wrapper position-relative overflow-hidden bg-light text-center">
                                <a href="{{ $productUrl }}" target="_blank" rel="noopener noreferrer">
                                    <img src="{{ $productImage }}" alt="{{ $product->name }}" 
                                         class="img-fluid w-100 product-img object-fit-cover"
                                         onerror="this.src='{{ asset('asset/v1/site/defaulte/img/portfolio/portfolio-1.jpg') }}'"
                                         style="height: 220px; object-fit: cover;">
                                </a>
                                @if($product->category)
                                    <span class="position-absolute bottom-0 start-0 m-2 badge bg-dark bg-opacity-75 text-white rounded-pill px-2.5 py-1 small">
                                        {{ $product->category->name }}
                                    </span>
                                @endif
                            </div>

                            <!-- Card Body -->
                            <div class="card-body p-3.5 d-flex flex-column justify-content-between">
                                <div>
                                    <!-- Store Badge & Badges -->
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <a href="{{ $storeUrl }}" target="_blank" rel="noopener noreferrer" 
                                           class="store-badge text-decoration-none d-inline-flex align-items-center gap-1.5 small fw-semibold text-truncate"
                                           style="max-width: 60%;">
                                            <i class="bi bi-shop text-pink"></i>
                                            <span class="text-truncate">{{ optional($product->seller)->store_name ?? 'متجر معتمد' }}</span>
                                        </a>
                                        <div class="d-flex align-items-center gap-1">
                                            @if($product->product_type == 'digital')
                                                <span class="badge bg-purple-subtle text-purple rounded-pill small px-2 py-0.5" title="{{ __('site.product_type_digital') }}">
                                                    <i class="bi bi-cpu me-0.5"></i> {{ __('site.product_type_digital') }}
                                                </span>
                                            @endif
                                            @if($product->condition)
                                                <span class="badge bg-secondary-subtle text-secondary rounded-pill small px-2 py-0.5">
                                                    {{ $product->condition == 'new' ? 'جديد' : 'مستعمل' }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Product Title -->
                                    <h5 class="card-title fs-6 fw-bold text-dark mb-2 text-truncate-2" title="{{ $product->name }}">
                                        <a href="{{ $productUrl }}" target="_blank" rel="noopener noreferrer" class="text-dark text-decoration-none hover-pink">
                                            {{ $product->name }}
                                        </a>
                                    </h5>

                                    <!-- Short description -->
                                    @if($product->short_description)
                                        <p class="card-text text-muted small text-truncate-2 mb-3" style="min-height: 38px;">
                                            {{ Str::limit(strip_tags($product->short_description), 75) }}
                                        </p>
                                    @else
                                        <div style="min-height: 38px;"></div>
                                    @endif
                                </div>

                                <!-- Price & Action -->
                                <div class="pt-2 border-top border-light-subtle mt-2">
                                    <div class="d-flex align-items-baseline justify-content-between mb-2">
                                        <div class="price-box">
                                            <span class="fw-bolder text-pink fs-5">{{ number_format($finalPrice, 2) }}</span>
                                            <span class="small fw-semibold text-muted">{{ __('site.currency') }}</span>
                                            @if($oldPrice)
                                                <span class="text-muted text-decoration-line-through small ms-1">{{ number_format($oldPrice, 2) }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <a href="{{ $productUrl }}" target="_blank" rel="noopener noreferrer" 
                                       class="btn btn-primary-pink w-100 rounded-3 py-2 fw-semibold d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
                                        <span>{{ __('site.visit_store_product') }}</span>
                                        <i class="bi bi-box-arrow-up-left small"></i>
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5">
                {{ $products->links('pagination::bootstrap-5') }}
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-5 my-4 bg-white rounded-4 shadow-sm p-5">
                <div class="empty-icon-box rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center"
                     style="width: 80px; height: 80px; background: rgba(176, 56, 130, 0.1); color: #B03882;">
                    <i class="bi bi-box-seam fs-1"></i>
                </div>
                <h4 class="fw-bold text-dark mb-2">{{ __('site.no_products_found') }}</h4>
                <p class="text-muted fs-6 mx-auto mb-4" style="max-width: 500px;">
                    {{ __('site.no_products_desc') }}
                </p>
                <a href="{{ route('site.marketplace.sellers') }}" class="btn btn-primary-pink rounded-pill px-4 py-2 fw-semibold">
                    <i class="bi bi-arrow-counterclockwise me-1"></i> {{ __('site.reset_filters') }}
                </a>
            </div>
        @endif

    </div>
</section>

<!-- Scoped Styling -->
<style>
    :root {
        --color-primary-pink: #B03882;
        --color-primary-pink-hover: #912969;
        --color-primary-pink-light: rgba(176, 56, 130, 0.1);
    }
    .text-pink {
        color: var(--color-primary-pink) !important;
    }
    .bg-pink-light {
        background-color: var(--color-primary-pink-light) !important;
    }
    .bg-purple-subtle {
        background-color: #f3e8ff !important;
    }
    .text-purple {
        color: #7e22ce !important;
    }
    .btn-primary-pink {
        background-color: var(--color-primary-pink);
        color: #fff;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary-pink:hover {
        background-color: var(--color-primary-pink-hover);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(176, 56, 130, 0.35);
    }
    .hover-pink:hover {
        color: var(--color-primary-pink) !important;
    }
    .store-badge {
        color: #4a5568;
        background: #f1f5f9;
        padding: 4px 10px;
        border-radius: 20px;
        transition: all 0.2s ease;
    }
    .store-badge:hover {
        background: rgba(176, 56, 130, 0.12);
        color: var(--color-primary-pink);
    }
    .product-market-card {
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
    }
    .product-market-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 32px rgba(176, 56, 130, 0.12) !important;
        border-color: rgba(176, 56, 130, 0.3) !important;
    }
    .product-img {
        transition: transform 0.5s ease;
    }
    .product-market-card:hover .product-img {
        transform: scale(1.05);
    }
    .text-truncate-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .filter-card {
        background: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.04) !important;
    }
    .page-item.active .page-link {
        background-color: var(--color-primary-pink) !important;
        border-color: var(--color-primary-pink) !important;
        color: #fff !important;
    }
    .page-link {
        color: var(--color-primary-pink);
        border-radius: 8px !important;
        margin: 0 3px;
    }
</style>
@endsection
