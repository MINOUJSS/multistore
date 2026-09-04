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
<!-- ======= Suppliers Gate Hero Header ======= -->
<section id="hero" class="d-flex align-items-center position-relative overflow-hidden py-5" style="min-height: 42vh;">
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>

    <div class="container position-relative z-index-2 py-4 text-center">
        <!-- Badge Pill -->
        <div class="d-inline-flex align-items-center gap-2 mb-3 hero-badge-pill">
            <span class="badge-icon">🔒</span>
            <span class="badge-text fw-bold">{{ __('site.suppliers_gate_badge') }}</span>
        </div>

        <!-- Main Title -->
        <h1 class="hero-main-title fw-bold text-white mb-3 fs-2 fs-md-1">
            {{ __('site.suppliers_gate_title') }}
        </h1>

        <!-- Subtitle -->
        <p class="hero-sub-title mb-4 fs-6 mx-auto text-white-80" style="max-width: 780px;">
            {{ __('site.suppliers_gate_subtitle') }}
        </p>

        <!-- Quick Switch & Breadcrumb -->
        <div class="d-flex flex-wrap align-items-center justify-content-center gap-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 m-0 text-white-50">
                    <li class="breadcrumb-item"><a href="{{ route('site.index') }}" class="text-white text-decoration-none fw-semibold">{{ __('site.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('site.marketplace.sellers') }}" class="text-white text-decoration-none fw-semibold">{{ __('site.sellers_marketplace') }}</a></li>
                    <li class="breadcrumb-item active text-pink-accent fw-bold" aria-current="page">{{ __('site.suppliers_marketplace') }}</li>
                </ol>
            </nav>
            <span class="text-white-50 d-none d-md-inline">|</span>
            <a href="{{ route('site.marketplace.sellers') }}" class="btn btn-sm btn-outline-light rounded-pill px-3 py-1 fw-semibold d-inline-flex align-items-center gap-2">
                <i class="bi bi-shop"></i>
                <span>{{ __('site.sellers_marketplace') }}</span>
                <i class="bi bi-arrow-left-short"></i>
            </a>
        </div>
    </div>

    <style>
        #hero {
            background: linear-gradient(135deg, #180413 0%, #2f0823 40%, #520f3a 80%, #7e1d5c 100%);
        }
        .hero-glow-1 {
            position: absolute;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(176, 56, 130, 0.45) 0%, rgba(176, 56, 130, 0) 70%);
            top: -10%;
            left: -5%;
            filter: blur(50px);
            pointer-events: none;
        }
        .hero-glow-2 {
            position: absolute;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(142, 68, 173, 0.35) 0%, rgba(142, 68, 173, 0) 70%);
            bottom: -10%;
            right: -5%;
            filter: blur(45px);
            pointer-events: none;
        }
        .hero-badge-pill {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            padding: 7px 20px;
            border-radius: 50px;
            color: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
        }
        .text-pink-accent {
            color: #ff9ed2 !important;
        }
        .text-white-80 {
            color: rgba(255, 255, 255, 0.9) !important;
        }
    </style>
</section>
@endsection

@section('content')
<!-- ======= Wholesale Gate Section ======= -->
<section class="wholesale-gate-section py-5" style="background: #f8f9fc; min-height: 65vh;">
    <div class="container" data-aos="fade-up">

        <!-- Why Restricted Alert Banner -->
        <div class="card border-0 shadow-sm rounded-4 mb-5 p-4 why-box position-relative overflow-hidden">
            <div class="d-flex flex-column flex-md-row align-items-center gap-4">
                <div class="icon-circle flex-shrink-0 d-flex align-items-center justify-content-center text-white rounded-circle shadow-sm"
                     style="width: 72px; height: 72px; background: linear-gradient(135deg, #B03882 0%, #6f1d53 100%);">
                    <i class="bi bi-shield-lock fs-2"></i>
                </div>
                <div>
                    <h4 class="fw-bold text-dark mb-2 fs-5">
                        {{ __('site.suppliers_gate_why_title') }}
                    </h4>
                    <p class="text-muted mb-0 fs-6 lh-base">
                        {{ __('site.suppliers_gate_why_desc') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Registration & Role Choice Cards -->
        <div class="row g-4 justify-content-center mb-5">
            
            <!-- 1. Seller / Merchant Card -->
            <div class="col-lg-6 col-md-12" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 rounded-4 shadow-sm role-card p-4 p-xl-5 bg-white position-relative d-flex flex-column justify-content-between">
                    <div class="role-badge-pill role-badge-pink position-absolute top-0 end-0 m-4">
                        <span>🛍️ تاجر / بائع</span>
                    </div>

                    <div>
                        <!-- Icon & Heading -->
                        <div class="role-icon-box mb-4 rounded-4 d-inline-flex align-items-center justify-content-center text-pink shadow-sm"
                             style="width: 64px; height: 64px; background: rgba(176, 56, 130, 0.1);">
                            <i class="bi bi-shop fs-2"></i>
                        </div>

                        <h3 class="fw-bold text-dark mb-3 fs-4">
                            {{ __('site.join_as_seller_title') }}
                        </h3>

                        <p class="text-muted mb-4 fs-6">
                            {{ __('site.join_as_seller_desc') }}
                        </p>

                        <!-- Benefits List -->
                        <ul class="list-unstyled mb-4 d-flex flex-column gap-2.5">
                            <li class="d-flex align-items-start gap-2.5 text-secondary">
                                <i class="bi bi-check-circle-fill text-pink flex-shrink-0 mt-1"></i>
                                <span>{{ __('site.seller_benefit_1') }}</span>
                            </li>
                            <li class="d-flex align-items-start gap-2.5 text-secondary">
                                <i class="bi bi-check-circle-fill text-pink flex-shrink-0 mt-1"></i>
                                <span>{{ __('site.seller_benefit_2') }}</span>
                            </li>
                            <li class="d-flex align-items-start gap-2.5 text-secondary">
                                <i class="bi bi-check-circle-fill text-pink flex-shrink-0 mt-1"></i>
                                <span>{{ __('site.seller_benefit_3') }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- CTA Actions -->
                    <div class="pt-3 border-top border-light-subtle">
                        <a href="{{ route('seller.register') }}" class="btn btn-primary-pink w-100 rounded-3 py-3 fw-bold fs-6 d-inline-flex align-items-center justify-content-center gap-2 shadow-sm mb-2">
                            <span>{{ __('site.create_seller_account') }}</span>
                            <i class="bi bi-arrow-left-short fs-4"></i>
                        </a>
                        <div class="text-center mt-2">
                            <span class="text-muted small">{{ __('site.already_have_account') }}</span>
                            <a href="{{ route('seller.login') }}" class="text-pink fw-semibold small text-decoration-none ms-1 hover-underline">
                                {{ __('site.seller_login') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Supplier / Wholesaler Card -->
            <div class="col-lg-6 col-md-12" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 rounded-4 shadow-sm role-card p-4 p-xl-5 bg-white position-relative d-flex flex-column justify-content-between">
                    <div class="role-badge-pill role-badge-purple position-absolute top-0 end-0 m-4">
                        <span>📦 مورد / تاجر جملة</span>
                    </div>

                    <div>
                        <!-- Icon & Heading -->
                        <div class="role-icon-box mb-4 rounded-4 d-inline-flex align-items-center justify-content-center text-purple shadow-sm"
                             style="width: 64px; height: 64px; background: rgba(110, 44, 137, 0.1);">
                            <i class="bi bi-boxes fs-2"></i>
                        </div>

                        <h3 class="fw-bold text-dark mb-3 fs-4">
                            {{ __('site.join_as_supplier_title') }}
                        </h3>

                        <p class="text-muted mb-4 fs-6">
                            {{ __('site.join_as_supplier_desc') }}
                        </p>

                        <!-- Benefits List -->
                        <ul class="list-unstyled mb-4 d-flex flex-column gap-2.5">
                            <li class="d-flex align-items-start gap-2.5 text-secondary">
                                <i class="bi bi-check-circle-fill text-purple flex-shrink-0 mt-1"></i>
                                <span>{{ __('site.supplier_benefit_1') }}</span>
                            </li>
                            <li class="d-flex align-items-start gap-2.5 text-purple-subtle text-secondary">
                                <i class="bi bi-check-circle-fill text-purple flex-shrink-0 mt-1"></i>
                                <span>{{ __('site.supplier_benefit_2') }}</span>
                            </li>
                            <li class="d-flex align-items-start gap-2.5 text-secondary">
                                <i class="bi bi-check-circle-fill text-purple flex-shrink-0 mt-1"></i>
                                <span>{{ __('site.supplier_benefit_3') }}</span>
                            </li>
                        </ul>
                    </div>

                    <!-- CTA Actions -->
                    <div class="pt-3 border-top border-light-subtle">
                        <a href="{{ (request()->getScheme() ?: 'http') . '://supplier.' . preg_replace('/^www\./', '', request()->getHttpHost()) . '/supplier-panel/register' }}" class="btn btn-primary-purple w-100 rounded-3 py-3 fw-bold fs-6 d-inline-flex align-items-center justify-content-center gap-2 shadow-sm mb-2">
                            <span>{{ __('site.create_supplier_account') }}</span>
                            <i class="bi bi-arrow-left-short fs-4"></i>
                        </a>
                        <div class="text-center mt-2">
                            <span class="text-muted small">{{ __('site.already_have_account') }}</span>
                            <a href="{{ (request()->getScheme() ?: 'http') . '://supplier.' . preg_replace('/^www\./', '', request()->getHttpHost()) . '/supplier-panel/login' }}" class="text-purple fw-semibold small text-decoration-none ms-1 hover-underline">
                                {{ __('site.supplier_login') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- 3 Simple Steps to Access -->
        <div class="steps-container py-4 text-center">
            <h4 class="fw-bold text-dark mb-4 fs-5">⚡ خطوات بسيطة للوصول واستكشاف سوق الجملة</h4>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="p-3 bg-white rounded-4 shadow-sm h-100 border border-light-subtle">
                        <div class="step-num text-pink fw-bold fs-3 mb-2">01</div>
                        <h6 class="fw-bold text-dark mb-2">{{ __('site.how_to_access_step_1_title') }}</h6>
                        <p class="text-muted small mb-0">{{ __('site.how_to_access_step_1_desc') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-white rounded-4 shadow-sm h-100 border border-light-subtle">
                        <div class="step-num text-purple fw-bold fs-3 mb-2">02</div>
                        <h6 class="fw-bold text-dark mb-2">{{ __('site.how_to_access_step_2_title') }}</h6>
                        <p class="text-muted small mb-0">{{ __('site.how_to_access_step_2_desc') }}</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-3 bg-white rounded-4 shadow-sm h-100 border border-light-subtle">
                        <div class="step-num text-success fw-bold fs-3 mb-2">03</div>
                        <h6 class="fw-bold text-dark mb-2">{{ __('site.how_to_access_step_3_title') }}</h6>
                        <p class="text-muted small mb-0">{{ __('site.how_to_access_step_3_desc') }}</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>

<!-- Scoped Styling -->
<style>
    :root {
        --color-primary-pink: #B03882;
        --color-primary-pink-hover: #912969;
        --color-primary-purple: #6e2c89;
        --color-primary-purple-hover: #56216d;
    }
    .text-pink {
        color: var(--color-primary-pink) !important;
    }
    .text-purple {
        color: var(--color-primary-purple) !important;
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
        box-shadow: 0 8px 20px rgba(176, 56, 130, 0.35) !important;
    }
    .btn-primary-purple {
        background-color: var(--color-primary-purple);
        color: #fff;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary-purple:hover {
        background-color: var(--color-primary-purple-hover);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(110, 44, 137, 0.35) !important;
    }
    .role-card {
        border: 1px solid rgba(0, 0, 0, 0.06) !important;
        transition: all 0.3s cubic-bezier(0.165, 0.84, 0.44, 1);
    }
    .role-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 16px 36px rgba(0, 0, 0, 0.08) !important;
        border-color: rgba(176, 56, 130, 0.3) !important;
    }
    .role-badge-pill {
        padding: 5px 14px;
        border-radius: 50px;
        font-size: 0.82rem;
        font-weight: 700;
    }
    .role-badge-pink {
        background: rgba(176, 56, 130, 0.1);
        color: var(--color-primary-pink);
    }
    .role-badge-purple {
        background: rgba(110, 44, 137, 0.1);
        color: var(--color-primary-purple);
    }
    .why-box {
        background: linear-gradient(135deg, #ffffff 0%, #fffbfd 100%);
        border: 1px solid rgba(176, 56, 130, 0.15) !important;
    }
    .hover-underline:hover {
        text-decoration: underline !important;
    }
</style>
@endsection
