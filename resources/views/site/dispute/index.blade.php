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

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}"> 
@endsection

@section('hero')
<!-- ======= Dispute Hero Section ======= -->
<section id="hero" class="d-flex align-items-center position-relative overflow-hidden py-5" style="min-height: 38vh;">
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>

    <div class="container position-relative z-index-2 py-4 text-center">
        <!-- Badge Pill -->
        <div class="d-inline-flex align-items-center gap-2 mb-3 hero-badge-pill">
            <span class="badge-icon">🛡️</span>
            <span class="badge-text fw-bold">{{ __('site.dispute_center_badge') }}</span>
        </div>

        <!-- Main Title -->
        <h1 class="hero-main-title fw-bold text-white mb-3 fs-2 fs-md-1">
            {{ __('site.dispute_create_title') }}
        </h1>

        <!-- Subtitle -->
        <p class="hero-sub-title mb-4 fs-6 mx-auto text-white-80" style="max-width: 740px;">
            {{ __('site.dispute_create_subtitle') }}
        </p>

        <!-- Breadcrumb -->
        <div class="d-flex flex-wrap align-items-center justify-content-center gap-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb bg-transparent p-0 m-0 text-white-50">
                    <li class="breadcrumb-item"><a href="{{ route('site.index') }}" class="text-white text-decoration-none fw-semibold">{{ __('site.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('site.marketplace.sellers') }}" class="text-white text-decoration-none fw-semibold">{{ __('site.marketplace') }}</a></li>
                    <li class="breadcrumb-item active text-pink-accent fw-bold" aria-current="page">{{ __('site.dispute_create_breadcrumb') }}</li>
                </ol>
            </nav>
        </div>
    </div>

    <style>
        #hero {
            background: linear-gradient(135deg, #180413 0%, #2e0822 40%, #510f39 80%, #7e1d5c 100%);
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
            padding: 7px 20px;
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
@include('site.pages.dispute.create')
@endsection

@section('pricing')
{{-- Kept for full backward compatibility if layout yields pricing --}}
@endsection

@section('footer_js')
@endsection