<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $landingPage->title ?? $product->name }} | {{ tenant('id') }}</title>
    <meta name="description" content="{{ $landingPage->hero_subheadline ?? $product->short_description }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: {{ $landingPage->theme_settings['primary_color'] ?? '#B03882' }};
            --primary-hover: #8f2868;
            --primary-light: rgba(176, 56, 130, 0.08);
            --dark-color: #1a1a2e;
            --accent-gold: #f59e0b;
        }

        body {
            font-family: 'Cairo', sans-serif;
            background-color: #fbfbfd;
            color: #2d3748;
            overflow-x: hidden;
        }

        .announcement-bar {
            background: linear-gradient(135deg, #1f0717 0%, var(--primary-color) 100%);
            color: #fff;
            font-weight: 700;
            font-size: 0.92rem;
            padding: 9px 0;
            text-align: center;
        }

        .hero-section {
            background: radial-gradient(circle at 10% 20%, rgba(176, 56, 130, 0.04) 0%, rgba(255, 255, 255, 0) 90%);
            padding: 40px 0 60px 0;
        }

        .badge-offer {
            background: var(--primary-light);
            color: var(--primary-color);
            border: 1px solid rgba(176, 56, 130, 0.25);
            font-weight: 800;
            padding: 6px 14px;
            border-radius: 50px;
            display: inline-block;
        }

        .hero-title {
            font-size: 2.3rem;
            font-weight: 900;
            line-height: 1.35;
            color: var(--dark-color);
            margin-top: 15px;
        }

        .hero-subtitle {
            font-size: 1.15rem;
            line-height: 1.8;
            color: #4b5563;
            margin-top: 15px;
        }

        .price-tag {
            background: #fff;
            border: 2px dashed var(--primary-color);
            border-radius: 16px;
            padding: 14px 20px;
            display: inline-flex;
            align-items: center;
            gap: 15px;
        }

        .current-price {
            font-size: 2.1rem;
            font-weight: 900;
            color: var(--primary-color);
        }

        .old-price {
            text-decoration: line-through;
            color: #9ca3af;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .btn-order-now {
            background: linear-gradient(135deg, var(--primary-color) 0%, #d6479f 100%);
            color: #fff !important;
            font-size: 1.25rem;
            font-weight: 800;
            padding: 16px 36px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(176, 56, 130, 0.35);
            transition: all 0.3s ease;
            border: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
        }

        .btn-order-now:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(176, 56, 130, 0.45);
        }

        .pulse-animation {
            animation: pulse-glow 2s infinite;
        }

        @keyframes pulse-glow {
            0% {
                box-shadow: 0 0 0 0 rgba(176, 56, 130, 0.6);
            }

            70% {
                box-shadow: 0 0 0 16px rgba(176, 56, 130, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(176, 56, 130, 0);
            }
        }

        .product-img-box {
            background: #fff;
            border-radius: 24px;
            padding: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.06);
            border: 1px solid rgba(0, 0, 0, 0.04);
            position: relative;
        }

        .product-main-img {
            width: 100%;
            height: auto;
            max-height: 480px;
            object-fit: cover;
            border-radius: 18px;
            transition: opacity 0.3s ease;
        }

        /* 3D Realistic Hardcover Book Showcase for Digital Products */
        .digital-book-showcase {
            perspective: 1200px;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px 15px 35px;
        }

        .book-3d-wrapper {
            position: relative;
            transform-style: preserve-3d;
            transform: rotateY(-22deg) rotateX(6deg);
            transition: transform 0.5s cubic-bezier(0.2, 0.8, 0.2, 1);
            cursor: pointer;
            display: inline-block;
        }

        .book-3d-wrapper:hover {
            transform: rotateY(-8deg) rotateX(2deg) scale(1.03);
        }

        .book-cover {
            position: relative;
            border-radius: 4px 12px 12px 4px;
            overflow: hidden;
            box-shadow: -15px 22px 35px rgba(0, 0, 0, 0.25), -2px 6px 12px rgba(0, 0, 0, 0.12);
            background: #ffffff;
            display: inline-block;
        }

        .book-cover img {
            display: block;
            max-height: 420px;
            width: auto;
            max-width: 100%;
            object-fit: cover;
            border-radius: 4px 12px 12px 4px;
            transition: opacity 0.3s ease;
        }

        .book-cover::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            width: 32px;
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.35) 0%, rgba(255, 255, 255, 0.06) 60%, rgba(0, 0, 0, 0.12) 100%);
            box-shadow: inset 1px 0 2px rgba(0, 0, 0, 0.2);
            pointer-events: none;
        }

        .book-spine-side {
            position: absolute;
            top: 0;
            bottom: 0;
            right: 100%;
            width: 26px;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.35) 0%, rgba(255, 255, 255, 0.2) 50%, rgba(0, 0, 0, 0.4) 100%), var(--primary-color);
            transform-origin: right;
            transform: rotateY(-90deg);
            border-radius: 4px 0 0 4px;
        }

        .book-pages-side {
            position: absolute;
            top: 3px;
            bottom: 3px;
            left: 100%;
            width: 26px;
            background: repeating-linear-gradient(to right, #faf8f5, #faf8f5 2px, #e7e2d4 3px, #e7e2d4 4px);
            transform-origin: left;
            transform: rotateY(90deg);
            box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.18);
            border-radius: 0 3px 3px 0;
        }

        .gallery-thumb {
            width: 62px;
            height: 62px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
        }

        .gallery-thumb:hover,
        .gallery-thumb.active-thumb {
            border-color: var(--primary-color) !important;
            transform: scale(1.08);
            box-shadow: 0 4px 12px rgba(176, 56, 130, 0.3);
        }

        .feature-card {
            background: #fff;
            border-radius: 18px;
            padding: 24px;
            height: 100%;
            border: 1px solid #f0f0f5;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.02);
            transition: all 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 30px rgba(176, 56, 130, 0.08);
            border-color: rgba(176, 56, 130, 0.2);
        }

        .feature-icon {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            background: var(--primary-light);
            color: var(--primary-color);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 16px;
        }

        .pain-box {
            background: #fff5f5;
            border-right: 4px solid #ef4444;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 12px;
            font-weight: 600;
            color: #991b1b;
        }

        .guarantee-badge {
            background: #fff;
            border-radius: 16px;
            padding: 18px;
            text-align: center;
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.04);
            border: 1px solid #eef2f6;
        }

        .order-container {
            background: #fff;
            border-radius: 28px;
            padding: 40px;
            box-shadow: 0 25px 60px rgba(176, 56, 130, 0.12);
            border: 2px solid rgba(176, 56, 130, 0.18);
        }

        .sticky-mobile-cta {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 12px 16px;
            box-shadow: 0 -8px 25px rgba(0, 0, 0, 0.1);
            z-index: 999;
            display: none;
        }

        /* ================================
           PRICING BUNDLES & OFFERS
           ================================ */
        .bundle-card {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 18px;
            padding: 16px 18px;
            cursor: pointer;
            transition: all 0.25s ease;
            position: relative;
            margin-bottom: 12px;
        }
        .bundle-card:hover {
            border-color: rgba(176, 56, 130, 0.45);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.04);
        }
        .bundle-card.active-bundle {
            border-color: var(--primary-color) !important;
            background: linear-gradient(180deg, #ffffff 0%, rgba(176, 56, 130, 0.04) 100%);
            box-shadow: 0 10px 25px rgba(176, 56, 130, 0.12);
        }
        .bundle-badge {
            position: absolute;
            top: -12px;
            left: 18px;
            background: linear-gradient(135deg, #f59e0b 0%, #ef4444 100%);
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 50px;
            box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3);
        }
        .bundle-radio-check {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            border: 2px solid #cbd5e1;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 0.75rem;
            transition: all 0.2s ease;
        }
        .bundle-card.active-bundle .bundle-radio-check {
            background: var(--primary-color);
            border-color: var(--primary-color);
        }

        /* ================================
           DIGITAL PAYMENT OPTIONS CARDS
           ================================ */
        .digital-payment-card {
            border: 2px solid #e2e8f0;
            border-radius: 16px;
            padding: 16px;
            cursor: pointer;
            transition: all 0.25s ease;
            background: #ffffff;
            position: relative;
        }
        .digital-payment-card:hover {
            border-color: rgba(176, 56, 130, 0.4);
            background: #faf7fa;
        }
        .digital-payment-card.selected {
            border-color: var(--primary-color) !important;
            background: rgba(176, 56, 130, 0.03);
            box-shadow: 0 8px 20px rgba(176, 56, 130, 0.12);
        }

        /* ================================
           URGENCY COUNTDOWN & STOCK PROGRESS
           ================================ */
        .urgency-banner {
            background: linear-gradient(135deg, #fff1f2 0%, #ffe4e6 100%);
            border: 1px solid #fecdd3;
            border-radius: 16px;
            padding: 14px 18px;
            margin-bottom: 20px;
        }
        .countdown-digits {
            font-family: monospace;
            font-size: 1.15rem;
            font-weight: 800;
            color: #e11d48;
            background: #ffffff;
            padding: 3px 8px;
            border-radius: 8px;
            border: 1px solid #fecdd3;
            display: inline-block;
        }
        .stock-progress-bar {
            height: 9px;
            border-radius: 10px;
            background: #e2e8f0;
            overflow: hidden;
            position: relative;
            margin-top: 6px;
        }
        .stock-progress-fill {
            height: 100%;
            width: 86%;
            background: linear-gradient(90deg, #f59e0b 0%, #ef4444 100%);
            border-radius: 10px;
            animation: pulseGlow 2s infinite ease-in-out;
        }
        @keyframes pulseGlow {
            0%, 100% { opacity: 0.9; }
            50% { opacity: 1; }
        }

        /* ================================
           LIVE SOCIAL PROOF TOAST
           ================================ */
        .social-proof-toast {
            position: fixed;
            bottom: 25px;
            right: 25px;
            max-width: 340px;
            background: rgba(255, 255, 255, 0.97);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(176, 56, 130, 0.2);
            border-radius: 18px;
            padding: 12px 14px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
            z-index: 1040;
            display: flex;
            align-items: center;
            gap: 12px;
            transform: translateY(140px);
            opacity: 0;
            pointer-events: none;
            transition: all 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .social-proof-toast.show-toast {
            transform: translateY(0);
            opacity: 1;
            pointer-events: auto;
        }
        @media (max-width: 768px) {
            .social-proof-toast {
                bottom: 82px;
                right: 12px;
                left: 12px;
                max-width: calc(100% - 24px);
            }
        }

        /* ================================
           MOBILE LONG INFOGRAPHIC STRIP
           STRICTLY VISIBLE ONLY ON MOBILE (<768px)
           ================================ */
        .mobile-long-infographic {
            display: none;
        }

        @media (min-width: 769px) {
            .mobile-long-infographic {
                display: none !important;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 1.7rem;
            }

            .order-container {
                padding: 24px 18px;
            }

            .sticky-mobile-cta {
                display: block;
            }

            body {
                padding-bottom: 75px;
            }

            .mobile-long-infographic {
                display: block !important;
                background: linear-gradient(180deg, #ffffff 0%, #faf7fa 50%, #f4eaf2 100%);
                border-top: 2px dashed rgba(176, 56, 130, 0.25);
                border-bottom: 2px dashed rgba(176, 56, 130, 0.25);
                padding: 30px 12px;
                margin: 25px 0;
            }

            .mobile-infographic-poster {
                background: #ffffff;
                border-radius: 24px;
                padding: 20px 14px;
                box-shadow: 0 15px 35px rgba(176, 56, 130, 0.08);
                border: 1px solid rgba(176, 56, 130, 0.15);
            }

            .infographic-banner-header {
                background: linear-gradient(135deg, #1f0717 0%, var(--primary-color) 100%);
                color: #ffffff;
                border-radius: 18px;
                padding: 16px;
                text-align: center;
                margin-bottom: 20px;
                box-shadow: 0 8px 20px rgba(176, 56, 130, 0.25);
            }

            .infographic-hotspot {
                background: #ffffff;
                border: 1px solid #f0edf2;
                border-right: 4px solid var(--primary-color);
                border-radius: 14px;
                padding: 12px 14px;
                margin-bottom: 12px;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
            }

            .compare-box-positive {
                background: #f0fdf4;
                border: 1px solid #bbf7d0;
                border-radius: 16px;
                padding: 16px;
            }

            .compare-box-negative {
                background: #fef2f2;
                border: 1px solid #fecaca;
                border-radius: 16px;
                padding: 16px;
            }
        }
    </style>
</head>

<body>

    @php
        $is_digital = ($product->product_type === 'digital');
        $pmSetting =
            (is_array($store_settings) ? collect($store_settings) : $store_settings)->firstWhere(
                'key',
                'store_payment_methods',
            ) ??
            ($store_settings[17] ?? null);
        $pmVal = is_array($pmSetting) ? $pmSetting['value'] ?? null : $pmSetting?->value ?? null;
        $pmObj = $pmVal ? json_decode($pmVal) : null;
        $cash_status = $pmObj?->Cash?->status ?? 'inactive';
        $chargily_status = $pmObj?->Chargily_Pay?->status ?? 'inactive';
        $ccp_status = $pmObj?->Ccp?->status ?? 'inactive';
        $baridimob_status = $pmObj?->BaridiMob?->status ?? 'inactive';
        $is_digital_file_available = is_digital_product_file_available($product);

        $is_chargily_ready = is_seller_aproved(tenant('id')) && is_chargily_settings_exists(tenant('id')) && $chargily_status == 'active' && is_seller_chargily_authorized(tenant('id'));
        $is_bank_transfer_ready = is_seller_aproved(tenant('id')) && is_seller_bank_account_exists(tenant('id')) && ($ccp_status == 'active' || $baridimob_status == 'active') && is_seller_bank_transfer_authorized(tenant('id'));
        $has_digital_payment_methods = $is_chargily_ready || $is_bank_transfer_ready;

        $is_cod_ready = ($cash_status == 'active');
        $has_physical_payment_methods = $is_cod_ready || $is_chargily_ready || $is_bank_transfer_ready;

        $is_order_possible = $is_digital
            ? ($is_digital_file_available && $has_digital_payment_methods)
            : $has_physical_payment_methods;

        $bundles = $content['bundles'] ?? (new \App\Services\AI\GeminiLandingPageService())->getDefaultBundles($product);
        $faqsList = !empty($content['faqs']) ? $content['faqs'] : (new \App\Services\AI\GeminiLandingPageService())->getDefaultFaqs($product);
    @endphp

    {{-- Top Announcement Bar --}}
    <div class="announcement-bar">
        @if ($is_digital)
            <i class="fa-solid fa-bolt me-1"></i> تحميل رقمي فوري ⚡ بعد الدفع الإلكتروني الآمن عبر البطاقة الذهبية أو CIB!
        @else
            <i class="fa-solid fa-truck-fast me-1"></i> تخفيض استثنائي لفترة محدودة + الدفع عند الاستلام بعد المعاينة!
        @endif
    </div>

    {{-- Hero Section --}}
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <span class="badge-offer">
                        @if ($is_digital)
                            <i class="fa-solid fa-file-arrow-down me-1"></i> منتج رقمي أصلي معتمد
                        @else
                            <i class="fa-solid fa-fire me-1"></i> {{ $landingPage->marketing_angle_name }}
                        @endif
                    </span>
                    <h1 class="hero-title">
                        {{ $landingPage->hero_headline ?? $product->name }}
                    </h1>
                    <p class="hero-subtitle">
                        {{ $landingPage->hero_subheadline ?? $product->short_description }}
                    </p>

                    <div class="d-flex align-items-center gap-2 mb-4">
                        <div class="text-warning fs-5">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </div>
                        <span class="fw-bold text-dark fs-6">(4.9/5) تقييم ممتاز من المشترين</span>
                    </div>

                    <div class="mb-4">
                        <div class="price-tag">
                            <div>
                                <span class="d-block small text-muted fw-bold">السعر الترويجي الخاص:</span>
                                <span class="current-price">{{ number_format($product->price, 0) }} د.ج</span>
                            </div>
                            <div>
                                <span class="d-block small text-muted fw-bold">السعر السابق:</span>
                                <span class="old-price">{{ number_format($product->price * 1.35, 0) }} د.ج</span>
                            </div>
                        </div>
                    </div>

                    {{-- Urgency & Stock Counter Banner in Hero --}}
                    <div class="urgency-banner mb-4">
                        <div class="d-flex align-items-center justify-content-between mb-1.5 flex-wrap gap-2">
                            <span class="small fw-bold text-danger">
                                <i class="fa-solid fa-stopwatch me-1"></i> ينتهي العرض الترويجي الخاص خلال:
                            </span>
                            <span class="countdown-digits" id="heroCountdown">02:44:18</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between small text-muted mt-2">
                            <span><i class="fa-solid fa-fire text-danger me-1"></i> 
                                @if ($is_digital)
                                    تبقت <strong>6 تراخيص</strong> فقط بهذا السعر المخفض!
                                @else
                                    تبقت <strong>6 قطع</strong> فقط في المخزن!
                                @endif
                            </span>
                            <span class="fw-bold text-dark">86% تم حجزها اليوم</span>
                        </div>
                        <div class="stock-progress-bar">
                            <div class="stock-progress-fill"></div>
                        </div>
                    </div>

                    <div class="d-flex flex-wrap gap-3">
                        <a href="#order-section" class="btn-order-now pulse-animation">
                            @if ($is_digital)
                                <i class="fa-solid fa-bolt me-1"></i> احصل على نسختك الرقمية الآن ⚡
                            @else
                                <i class="fa-solid fa-cart-shopping me-1"></i> اطلب الآن والدفع عند الاستلام 🚚
                            @endif
                        </a>
                    </div>
                </div>

                @php
                    $gallery = $content['gallery_images'] ?? [];
                    if (empty($gallery) && $product->image) {
                        $gallery = [asset($product->image)];
                    }
                    $mainImg = !empty($gallery) ? $gallery[0] : ($product->image ? asset($product->image) : null);
                @endphp

                <div class="col-lg-6 text-center">
                    <div class="product-img-box">
                        @if ($mainImg)
                            @if ($is_digital)
                                <div class="digital-book-showcase">
                                    <div class="book-3d-wrapper" id="book3dWrapper">
                                        <div class="book-spine-side"></div>
                                        <div class="book-cover">
                                            <img src="{{ $mainImg }}" alt="{{ $product->name }}" id="mainProductImg"
                                                class="img-fluid">
                                        </div>
                                        <div class="book-pages-side"></div>
                                    </div>
                                </div>
                                <div class="digital-badge-row mt-2">
                                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 rounded-pill fw-bold">
                                        <i class="fa-solid fa-file-pdf text-danger me-1"></i> نسخة إلكترونية فائقة الدقة (PDF) جاهزة للتحميل الفوري
                                    </span>
                                </div>
                                <div class="text-muted small mt-2">
                                    <i class="fa-solid fa-mobile-screen me-1"></i> قراءة مريحة على الهاتف • 
                                    <i class="fa-solid fa-tablet-screen-button me-1"></i> التابلت • 
                                    <i class="fa-solid fa-laptop me-1"></i> الكمبيوتر
                                </div>
                            @else
                                <img src="{{ $mainImg }}" alt="{{ $product->name }}" id="mainProductImg"
                                    class="product-main-img">
                            @endif

                            {{-- Interactive Image Gallery Thumbnails --}}
                            @if (count($gallery) > 1)
                                <div
                                    class="d-flex align-items-center justify-content-center gap-2 mt-3 overflow-auto py-1">
                                    @foreach ($gallery as $gIndex => $gImg)
                                        <img src="{{ $gImg }}" alt="Product Thumb"
                                            class="gallery-thumb {{ $gIndex === 0 ? 'active-thumb' : '' }}"
                                            onclick="setMainImg('{{ $gImg }}', this)">
                                    @endforeach
                                </div>
                            @endif
                        @else
                            <div class="p-5 bg-light rounded-4 text-muted">
                                <i class="fa-solid fa-box-open fa-4x mb-3 text-secondary"></i>
                                <h5>{{ $product->name }}</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ============================================================== --}}
    {{-- MOBILE LONG INFOGRAPHIC STRIP (EXCLUSIVELY SHOWN ON MOBILE PHONES) --}}
    {{-- ============================================================== --}}
    @php
        $infoData = $content['infographic'] ?? [];
    @endphp
    <section class="mobile-long-infographic d-block d-md-none">
        <div class="mobile-infographic-poster">
            {{-- Header Poster Banner --}}
            <div class="infographic-banner-header">
                <span class="badge bg-white text-plum px-3 py-1 rounded-pill small fw-bold mb-2">
                    <i class="fa-solid fa-mobile-screen-button me-1"></i> {{ $infoData['badge'] ?? 'دليل ومواصفات المنتج المفصلة' }}
                </span>
                <h4 class="fw-bold mb-1 text-white">
                    {{ $infoData['headline'] ?? 'نظرة مقربة وشاملة على تفاصيل المنتج' }}
                </h4>
                <p class="small text-white-50 mb-0">تم إعداد هذا الدليل التفصيلي ليساعدك في اتخاذ قرار الشراء بثقة تامة</p>
            </div>

            {{-- Big Product Showcase in Mobile Infographic --}}
            @if ($mainImg)
                <div class="text-center my-3 p-3 bg-light rounded-4 position-relative overflow-hidden">
                    @if ($is_digital)
                        <div class="digital-book-showcase p-2">
                            <div class="book-3d-wrapper" style="transform: rotateY(-18deg) rotateX(5deg);">
                                <div class="book-spine-side"></div>
                                <div class="book-cover">
                                    <img src="{{ $mainImg }}" alt="{{ $product->name }}" class="img-fluid" style="max-height: 290px; object-fit: contain;">
                                </div>
                                <div class="book-pages-side"></div>
                            </div>
                        </div>
                    @else
                        <img src="{{ $mainImg }}" alt="{{ $product->name }}" class="img-fluid rounded-3" style="max-height: 340px; object-fit: contain;">
                    @endif
                    <div class="mt-2 text-center">
                        <span class="badge bg-success text-white shadow-sm px-3 py-1.5 rounded-pill">
                            <i class="fa-solid fa-circle-check me-1"></i> 
                            {{ $is_digital ? 'نسخة رقمية أصلية جاهزة للتحميل المباشر' : 'منتج أصلي ومطابق للمواصفات 100%' }}
                        </span>
                    </div>
                </div>
            @endif

            {{-- Hotspot Visual Points --}}
            <div class="my-4">
                <h6 class="fw-bold text-dark mb-3">
                    <i class="fa-solid fa-magnifying-glass-arrow-right me-1 text-plum"></i> أدق تفاصيل وجودة المنتج:
                </h6>
                @if (!empty($infoData['hotspots']))
                    @foreach ($infoData['hotspots'] as $spot)
                        <div class="infographic-hotspot">
                            <h6 class="fw-bold text-plum mb-1">
                                <i class="fa-solid fa-circle-dot text-plum me-1"></i> {{ $spot['label'] ?? '' }}
                            </h6>
                            <p class="small text-muted mb-0 lh-base">{{ $spot['detail'] ?? '' }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="infographic-hotspot">
                        <h6 class="fw-bold text-plum mb-1"><i class="fa-solid fa-shield-halved text-plum me-1"></i> محتوى حصري واحترافي</h6>
                        <p class="small text-muted mb-0">تم إعداده وتدقيقه بأعلى معايير الجودة لضمان أقصى فائدة.</p>
                    </div>
                    <div class="infographic-hotspot">
                        <h6 class="fw-bold text-plum mb-1"><i class="fa-solid fa-bolt text-plum me-1"></i> وصول وتنزيل مباشر</h6>
                        <p class="small text-muted mb-0">وصول فوري بعد الدفع دون أي انتظار أو تعقيد.</p>
                    </div>
                @endif
            </div>

            {{-- Comparison Section on Mobile --}}
            <div class="my-4">
                <h6 class="fw-bold text-dark mb-3">
                    <i class="fa-solid fa-scale-balanced me-1 text-plum"></i> مقارنة: ما نقدمه لك vs الخيارات الأخرى:
                </h6>
                <div class="row g-2">
                    <div class="col-6">
                        <div class="compare-box-positive h-100">
                            <div class="text-success fw-bold small mb-2">
                                <i class="fa-solid fa-check-double me-1"></i> ما ستحصل عليه:
                            </div>
                            <ul class="list-unstyled small mb-0 lh-base text-dark" style="font-size: 0.78rem;">
                                @if (!empty($infoData['comparison']['our_product']))
                                    @foreach ($infoData['comparison']['our_product'] as $ourItem)
                                        <li class="mb-1.5"><i class="fa-solid fa-check text-success me-1"></i> {{ $ourItem }}</li>
                                    @endforeach
                                @else
                                    <li class="mb-1.5"><i class="fa-solid fa-check text-success me-1"></i> نسخة أصلية كاملة</li>
                                    <li class="mb-1.5"><i class="fa-solid fa-check text-success me-1"></i> دعم فني ومساعدة</li>
                                    <li><i class="fa-solid fa-check text-success me-1"></i> تحديثات مستمرة</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="compare-box-negative h-100">
                            <div class="text-danger fw-bold small mb-2">
                                <i class="fa-solid fa-xmark me-1"></i> مصادر أخرى:
                            </div>
                            <ul class="list-unstyled small mb-0 lh-base text-muted" style="font-size: 0.78rem;">
                                @if (!empty($infoData['comparison']['other_products']))
                                    @foreach ($infoData['comparison']['other_products'] as $otherItem)
                                        <li class="mb-1.5"><i class="fa-solid fa-xmark text-danger me-1"></i> {{ $otherItem }}</li>
                                    @endforeach
                                @else
                                    <li class="mb-1.5"><i class="fa-solid fa-xmark text-danger me-1"></i> ملفات ناقصة أو تالفة</li>
                                    <li class="mb-1.5"><i class="fa-solid fa-xmark text-danger me-1"></i> بدون أي دعم</li>
                                    <li><i class="fa-solid fa-xmark text-danger me-1"></i> روابط غير موثوقة</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Fast Call to Action in Infographic --}}
            <div class="text-center mt-3">
                <a href="#order-section" class="btn btn-order-now w-100 py-3 rounded-4 shadow-sm">
                    @if ($is_digital)
                        <i class="fa-solid fa-bolt me-1"></i> احجز نسختك الرقمية الآن
                    @else
                        <i class="fa-solid fa-arrow-down me-1"></i> احجز طلبك الآن والدفع عند الاستلام
                    @endif
                </a>
                <span class="d-block small text-muted mt-2">
                    <i class="fa-solid fa-lock text-success me-1"></i> دفع ومعلومات مشفرة ومحمية 100%
                </span>
            </div>
        </div>
    </section>

    {{-- Pain Points / The Problem Section --}}
    @if (!empty($content['pain_points']))
        <section class="py-5 bg-white">
            <div class="container">
                <div class="text-center max-w-700 mx-auto mb-5">
                    <span class="badge bg-danger-subtle text-danger px-3 py-1.5 rounded-pill fw-bold fs-6">
                        <i class="fa-solid fa-triangle-exclamation me-1"></i> هل تواجه هذه الصعوبات؟
                    </span>
                    <h2 class="fw-bold text-dark mt-3">لماذا تحتاج إلى هذا الحل الآن؟</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        @foreach ($content['pain_points'] as $pain)
                            <div class="pain-box">
                                <i class="fa-solid fa-circle-xmark me-2 text-danger"></i> {{ $pain }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Features & Benefits Section --}}
    @if (!empty($content['benefits']))
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="badge-offer mb-2">مميزات حصرية</span>
                    <h2 class="fw-bold text-dark">ماذا ستحصل عند اقتنائك هذا المنتج؟</h2>
                </div>
                <div class="row g-4">
                    @foreach ($content['benefits'] as $benefit)
                        <div class="col-md-6 col-lg-3">
                            <div class="feature-card">
                                <div class="feature-icon">
                                    <i class="fa-solid fa-check"></i>
                                </div>
                                <h5 class="fw-bold text-dark mb-2">{{ $benefit['title'] ?? '' }}</h5>
                                <p class="text-muted small mb-0 lh-base">{{ $benefit['description'] ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Guarantees Section --}}
    <section class="py-5 bg-white border-top border-bottom">
        <div class="container">
            <div class="row g-4 justify-content-center">
                <div class="col-md-4">
                    <div class="guarantee-badge">
                        @if ($is_digital)
                            <i class="fa-solid fa-bolt fa-2x text-warning mb-3"></i>
                            <h6 class="fw-bold">تسليم وتنزيل فوري</h6>
                            <p class="text-muted small mb-0">يصلك رابط التحميل مباشرة بعد الدفع الإلكتروني الآمن.</p>
                        @else
                            <i class="fa-solid fa-shield-check fa-2x text-success mb-3"></i>
                            <h6 class="fw-bold">الدفع عند الاستلام</h6>
                            <p class="text-muted small mb-0">افحص طردك وعاينه أمام الموزع قبل دفع أي دينار.</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="guarantee-badge">
                        @if ($is_digital)
                            <i class="fa-solid fa-credit-card fa-2x text-primary mb-3"></i>
                            <h6 class="fw-bold">دفع آمن 100%</h6>
                            <p class="text-muted small mb-0">معتمد ومحمي عبر البطاقة الذهبية، CIB، أو بريدي موب.</p>
                        @else
                            <i class="fa-solid fa-truck-fast fa-2x text-primary mb-3"></i>
                            <h6 class="fw-bold">توصيل سريع وموثوق</h6>
                            <p class="text-muted small mb-0">شحن آمن ومباشر حتى باب منزلك في كافة الولايات.</p>
                        @endif
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="guarantee-badge">
                        <i class="fa-solid fa-medal fa-2x text-warning mb-3"></i>
                        <h6 class="fw-bold">ضمان الجودة والأصالة</h6>
                        <p class="text-muted small mb-0">محتوى أصلي كامل مطابق تماماً للمواصفات المعلنة.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Testimonials Section --}}
    @if (!empty($content['testimonials']))
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold text-dark">تجارب وآراء عملائنا</h2>
                    <p class="text-muted">انظر ماذا يقول المشترون بعد تجربة المنتج</p>
                </div>
                <div class="row g-4">
                    @foreach ($content['testimonials'] as $testimonial)
                        <div class="col-md-4">
                            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                                <div class="text-warning mb-2">
                                    @for ($i = 0; $i < ($testimonial['rating'] ?? 5); $i++)
                                        <i class="fa-solid fa-star"></i>
                                    @endfor
                                </div>
                                <p class="text-dark fw-semibold mb-3">"{{ $testimonial['comment'] ?? '' }}"</p>
                                <div class="mt-auto d-flex align-items-center gap-2">
                                    <div class="avatar bg-primary-subtle text-plum rounded-circle d-flex align-items-center justify-content-center fw-bold"
                                        style="width: 38px; height: 38px;">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold">{{ $testimonial['name'] ?? '' }}</h6>
                                        <small class="text-muted">{{ $testimonial['city'] ?? '' }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- ============================================================== --}}
    {{-- ORDER CHECKOUT SECTION (ADAPTIVE: DIGITAL VS PHYSICAL) --}}
    {{-- ============================================================== --}}
    <section id="order-section" class="py-5 bg-white">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="order-container">
                        <div class="text-center mb-4">
                            <span class="badge bg-success-subtle text-success px-3 py-1.5 rounded-pill fw-bold fs-6 mb-2">
                                @if ($is_digital)
                                    <i class="fa-solid fa-download me-1"></i> استمارة الشراء والتحميل الفوري
                                @else
                                    <i class="fa-solid fa-bag-shopping me-1"></i> استمارة الطلب المباشر
                                @endif
                            </span>
                            <h2 class="fw-bold text-dark">
                                @if ($is_digital)
                                    أدخل معلوماتك للحصول على ملفك فوراً
                                @else
                                    املأ معلوماتك وسنتكفل بالباقي
                                @endif
                            </h2>
                            <p class="text-muted small">
                                @if ($is_digital)
                                    يصلك رابط التحميل مباشرة على بريدك الإلكتروني بعد إتمام الدفع الآمن
                                @else
                                    الدفع يكون نقداً عند الاستلام بعد معاينة وفحص المنتج
                                @endif
                            </p>
                        </div>

                        {{-- Order Form (Action /order handled by TenantsController::order) --}}
                        <form action="/order" method="POST" id="landingOrderForm">
                            @csrf
                            <input type="hidden" name="device_fingerprint" id="device_fingerprint">
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            @if ($is_digital)
                                {{-- ============================================================== --}}
                                {{-- DIGITAL PRODUCT FORM FIELDS --}}
                                {{-- ============================================================== --}}
                                <input type="hidden" name="qty" id="orderQty" value="1">
                                <input type="hidden" name="shipping_and_point" value="home">

                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">الاسم واللقب بالكامل <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user text-muted"></i></span>
                                            <input type="text" name="name" class="form-control form-control-lg border-0 bg-light"
                                                placeholder="أدخل اسمك الكامل" value="{{ old('name') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">رقم الهاتف <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-phone text-muted"></i></span>
                                            <input type="tel" name="phone" class="form-control form-control-lg border-0 bg-light"
                                                placeholder="مثال: 0555123456" pattern="^0[5-7][0-9]{8}$" value="{{ old('phone') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">البريد الإلكتروني (لاستلام الملف ورابط التحميل) <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-envelope text-plum"></i></span>
                                            <input type="email" name="email" class="form-control form-control-lg border-0 bg-light"
                                                placeholder="مثال: yourname@email.com" value="{{ old('email') }}" required>
                                        </div>
                                        <small class="text-muted"><i class="fa-solid fa-circle-info text-plum me-1"></i> سيتم إرسال الملف أو كود الوصول فوراً إلى هذا البريد بعد نجاح الدفع.</small>
                                    </div>

                                    {{-- Digital Product Pricing Summary Box --}}
                                    <div class="col-12 mt-3">
                                        <div class="p-3 bg-light rounded-4 border d-flex align-items-center justify-content-between">
                                            <div>
                                                <span class="text-muted small d-block">قيمة النسخة الرقمية:</span>
                                                <strong class="text-dark">{{ $product->name }}</strong>
                                            </div>
                                            <div class="text-end">
                                                <span class="fs-4 fw-bold text-plum" id="totalPriceDisplay">{{ number_format($product->price, 0) }} د.ج</span>
                                                <span class="badge bg-success-subtle text-success d-block" style="font-size: 0.72rem;">تسليم رقمي فوري ⚡</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Digital Payment Options --}}
                                    <div class="col-12 mt-4">
                                        <h6 class="fw-bold text-dark mb-3">
                                            <i class="fa-solid fa-credit-card text-plum me-1"></i> طريقة الدفع الإلكتروني المعتمدة:
                                        </h6>

                                        @if (!$is_digital_file_available)
                                            <div class="alert alert-warning border border-warning-subtle shadow-sm rounded-4 p-3 text-center mb-0">
                                                <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                                    <i class="fa-solid fa-triangle-exclamation text-warning fs-4"></i>
                                                    <strong class="text-dark">هذا المنتج غير متاح للشراء حالياً</strong>
                                                </div>
                                                <p class="small text-muted mb-0">
                                                    الملف الرقمي الخاص بهذا المنتج قيد التجهيز من قبل إدارة المتجر. ستظهر خيارات الدفع تلقائياً فور توفر الملف.
                                                </p>
                                            </div>
                                        @elseif (!$has_digital_payment_methods)
                                            <div class="alert alert-warning border border-warning-subtle shadow-sm rounded-4 p-3 text-center mb-0">
                                                <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                                    <i class="fa-solid fa-credit-card text-warning fs-4"></i>
                                                    <strong class="text-dark">وسائل الدفع غير متوفرة حالياً</strong>
                                                </div>
                                                <p class="small text-muted mb-0">
                                                    نعتذر منكم، وسائل الدفع الإلكترونية قيد التهيئة من قِبل إدارة المتجر. يرجى المحاولة لاحقاً.
                                                </p>
                                            </div>
                                        @else
                                            <div class="row g-2">
                                                @if ($is_chargily_ready)
                                                    <div class="col-md-6">
                                                        <label class="digital-payment-card d-block h-100 selected" id="chargilyLabel" for="payChargily">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <input type="radio" name="payment_method" id="payChargily" value="chargily"
                                                                    class="form-check-input mt-0" checked onchange="togglePaymentSelection('chargily')">
                                                                <div>
                                                                    <div class="fw-bold text-dark">
                                                                        <i class="fa-solid fa-credit-card text-success me-1"></i> Chargily Pay
                                                                    </div>
                                                                    <small class="text-muted d-block" style="font-size: 0.78rem;">البطاقة الذهبية / CIB (تحميل فوري ⚡)</small>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endif

                                                @if ($is_bank_transfer_ready)
                                                    <div class="col-md-6">
                                                        <label class="digital-payment-card d-block h-100 {{ !$is_chargily_ready ? 'selected' : '' }}" id="vermentsLabel" for="payVerments">
                                                            <div class="d-flex align-items-center gap-3">
                                                                <input type="radio" name="payment_method" id="payVerments" value="verments"
                                                                    class="form-check-input mt-0" {{ !$is_chargily_ready ? 'checked' : '' }} onchange="togglePaymentSelection('verments')">
                                                                <div>
                                                                    <div class="fw-bold text-dark">
                                                                        <i class="fa-solid fa-building-columns text-primary me-1"></i> تحويل بنكي / CCP
                                                                    </div>
                                                                    <small class="text-muted d-block" style="font-size: 0.78rem;">بريدي موب / CCP (تأكيد يدوي)</small>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Submit Button for Digital --}}
                                    <div class="col-12 mt-4">
                                        @if ($is_order_possible)
                                            <button type="submit" class="btn w-100 py-3.5 text-white fw-bold fs-5 rounded-4 shadow-sm"
                                                style="background: linear-gradient(135deg, var(--primary-color) 0%, #d6479f 100%);">
                                                <i class="fa-solid fa-bolt me-1"></i> إتمام الدفع وتحميل الملف فوراً
                                            </button>
                                        @else
                                            <button type="button" disabled class="btn w-100 py-3.5 btn-secondary opacity-50 fw-bold fs-5 rounded-4" style="cursor: not-allowed;">
                                                <i class="fa-solid fa-lock me-1"></i> الشراء غير متاح حالياً
                                            </button>
                                        @endif
                                    </div>

                                    {{-- Digital Trust Badges --}}
                                    <div class="col-12 text-center mt-3 pt-2">
                                        <div class="d-flex align-items-center justify-content-center gap-4 flex-wrap text-muted small">
                                            <span><i class="fa-solid fa-bolt text-warning me-1"></i> تسليم رقمي فوري</span>
                                            <span><i class="fa-solid fa-shield-check text-success me-1"></i> دفع إلكتروني آمن 100%</span>
                                            <span><i class="fa-solid fa-envelope-circle-check text-primary me-1"></i> وصول مباشر لبريدك</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                {{-- ============================================================== --}}
                                {{-- PHYSICAL PRODUCT FORM FIELDS --}}
                                {{-- ============================================================== --}}
                                <input type="hidden" name="payment_method" value="cod">
                                <input type="hidden" name="shipping_and_point" value="home">

                                {{-- Packages / Bundles Cards Selector --}}
                                <div class="mb-4">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <label class="form-label fw-bold text-dark mb-0">
                                            <i class="fa-solid fa-gift text-plum me-1"></i> اختر العرض الأنسب لك:
                                        </label>
                                        <span class="badge bg-danger-subtle text-danger px-2.5 py-1 rounded-pill small fw-bold">
                                            <i class="fa-solid fa-fire me-1"></i> وفّر أكثر عند طلب قطعتين فما فوق
                                        </span>
                                    </div>
                                    <div class="row g-2">
                                        @foreach ($bundles as $bIndex => $bundle)
                                            <div class="col-12">
                                                <div class="bundle-card {{ $bIndex === 1 ? 'active-bundle' : '' }}"
                                                    onclick="selectBundle({{ $bIndex }}, {{ $bundle['qty'] }}, {{ $bundle['total_price'] }}, {{ $bundle['save_amount'] ?? 0 }})"
                                                    id="bundleCard_{{ $bIndex }}">
                                                    @if (!empty($bundle['badge']))
                                                        <span class="bundle-badge">{{ $bundle['badge'] }}</span>
                                                    @endif
                                                    <div class="d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center gap-3">
                                                            <div class="bundle-radio-check" id="bundleRadio_{{ $bIndex }}">
                                                                <i class="fa-solid fa-check {{ $bIndex === 1 ? '' : 'd-none' }}"></i>
                                                            </div>
                                                            <div>
                                                                <h6 class="fw-bold mb-0 text-dark">{{ $bundle['title'] }}</h6>
                                                                <small class="text-muted d-block">{{ $bundle['shipping_note'] ?? ($bundle['subtitle'] ?? '') }}</small>
                                                            </div>
                                                        </div>
                                                        <div class="text-end">
                                                            <span class="fw-bold fs-5 text-plum d-block">{{ number_format($bundle['total_price'], 0) }} د.ج</span>
                                                            @if (!empty($bundle['save_amount']) && $bundle['save_amount'] > 0)
                                                                <span class="badge bg-success-subtle text-success px-2 py-0.5 rounded-pill" style="font-size: 0.72rem;">
                                                                    وفّرت {{ number_format($bundle['save_amount'], 0) }} د.ج
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="row g-3">
                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">الاسم واللقب بالكامل <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-user text-muted"></i></span>
                                            <input type="text" name="name" class="form-control form-control-lg border-0 bg-light"
                                                placeholder="أدخل اسمك الكامل" value="{{ old('name') }}" required>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">رقم الهاتف <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="fa-solid fa-phone text-muted"></i></span>
                                            <input type="tel" name="phone" class="form-control form-control-lg border-0 bg-light"
                                                placeholder="مثال: 0555123456" pattern="^0[5-7][0-9]{8}$" value="{{ old('phone') }}" required>
                                        </div>
                                        <small class="text-muted">سيتصل بك فريقنا لتأكيد الطلب وعنوان التوصيل.</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">الولاية <span class="text-danger">*</span></label>
                                        <select name="wilaya" class="form-select form-select-lg border-0 bg-light" required>
                                            <option value="">اختر ولايتك...</option>
                                            @foreach ($wilayas as $wilaya)
                                                <option value="{{ $wilaya->id }}">{{ $wilaya->zip_code }} -
                                                    {{ $wilaya->ar_name ?? $wilaya->en_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold">البلدية أو العنوان <span class="text-danger">*</span></label>
                                        <input type="text" name="address" class="form-control form-control-lg border-0 bg-light"
                                            placeholder="اسم البلدية والحي" value="{{ old('address') }}" required>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label fw-bold">الكمية الإجمالية المحددة:</label>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="input-group" style="width: 140px;">
                                                <button type="button" class="btn btn-outline-secondary" onclick="changeQty(-1)"><i class="fa-solid fa-minus"></i></button>
                                                <input type="number" id="orderQty" name="qty" class="form-control text-center fw-bold"
                                                    value="{{ $bundles[1]['qty'] ?? 1 }}" min="1" readonly>
                                                <button type="button" class="btn btn-outline-secondary" onclick="changeQty(1)"><i class="fa-solid fa-plus"></i></button>
                                            </div>
                                            <div class="ms-auto text-end">
                                                <span class="text-muted small d-block">المجموع الإجمالي:</span>
                                                <span class="fw-bold fs-4 text-plum" id="totalPriceDisplay">{{ number_format($bundles[1]['total_price'] ?? $product->price, 0) }} د.ج</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn w-100 py-3.5 text-white fw-bold fs-5 rounded-4 shadow-sm"
                                            style="background: linear-gradient(135deg, var(--primary-color) 0%, #d6479f 100%);">
                                            <i class="fa-solid fa-truck-ramp-box me-1"></i>
                                            {{ $content['cta_button_text'] ?? 'تأكيد الطلب الآن (الدفع عند الاستلام)' }}
                                        </button>
                                    </div>

                                    {{-- Trust Badges Under Submit Button --}}
                                    <div class="col-12 text-center mt-3 pt-2">
                                        <div class="d-flex align-items-center justify-content-center gap-4 flex-wrap text-muted small">
                                            <span><i class="fa-solid fa-shield-halved text-success me-1"></i> الدفع عند الاستلام</span>
                                            <span><i class="fa-solid fa-truck-fast text-plum me-1"></i> توصيل سريع 58 ولاية</span>
                                            <span><i class="fa-solid fa-rotate-left text-warning me-1"></i> ضمان المعاينة قبل الدفع</span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FAQs Section --}}
    @if (!empty($faqsList))
        <section class="py-5 bg-light">
            <div class="container">
                <div class="text-center mb-5">
                    <span class="badge bg-primary-subtle text-plum px-3 py-1.5 rounded-pill fw-bold fs-6 mb-2">
                        <i class="fa-solid fa-circle-question me-1"></i> إجابات شافية
                    </span>
                    <h2 class="fw-bold text-dark">الأسئلة الشائعة حول الطلب والاستلام</h2>
                    <p class="text-muted small">كل ما تحتاج لمعرفته قبل تأكيد طلبك بكل راحة بال</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="accordion" id="faqAccordion">
                            @foreach ($faqsList as $index => $faq)
                                <div class="accordion-item border-0 mb-3 rounded-4 shadow-sm overflow-hidden">
                                    <h2 class="accordion-header">
                                        <button class="accordion-button fw-bold {{ $index === 0 ? '' : 'collapsed' }}"
                                            type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq-{{ $index }}">
                                            <i class="fa-solid fa-circle-question text-plum me-2"></i> {{ $faq['question'] ?? '' }}
                                        </button>
                                    </h2>
                                    <div id="faq-{{ $index }}"
                                        class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body text-muted lh-base bg-white">
                                            {{ $faq['answer'] ?? '' }}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Footer --}}
    <footer class="py-4 text-center bg-white border-top text-muted small">
        <p class="mb-0">جميع الحقوق محفوظة &copy; {{ date('Y') }} - {{ tenant('id') }}</p>
    </footer>

    {{-- Sticky Mobile CTA Bar --}}
    <div class="sticky-mobile-cta">
        <div class="d-flex align-items-center justify-content-between gap-3">
            <div>
                <span class="d-block small text-muted">السعر:</span>
                <span class="fw-bold text-plum fs-5" id="stickyMobilePrice">{{ number_format($is_digital ? $product->price : ($bundles[1]['total_price'] ?? $product->price), 0) }} د.ج</span>
            </div>
            <a href="#order-section" class="btn text-white fw-bold px-4 py-2.5 rounded-pill shadow-sm"
                style="background: var(--primary-color);">
                @if ($is_digital)
                    تحميل الآن <i class="fa-solid fa-bolt me-1"></i>
                @else
                    اطلب الآن <i class="fa-solid fa-arrow-left me-1"></i>
                @endif
            </a>
        </div>
    </div>

    {{-- Live Social Proof Toast Notification (Algerian Buyers) --}}
    <div class="social-proof-toast" id="socialProofToast">
        <div class="position-relative">
            <img src="{{ $mainImg ?? asset('asset/v1/users/store/img/logo/store.png') }}" 
                 alt="{{ $product->name }}" 
                 class="rounded-3 object-fit-cover shadow-sm" 
                 style="width: 48px; height: 48px; border: 1px solid #f1e4ef;">
            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-success border border-light rounded-circle"></span>
        </div>
        <div class="flex-grow-1 overflow-hidden" style="line-height: 1.25;">
            <div class="d-flex align-items-center justify-content-between gap-1 mb-1">
                <strong class="text-dark small text-truncate" id="spCustomerName">أمين .ب (الجزائر العاصمة)</strong>
                <span class="badge bg-success-subtle text-success p-1 px-1.5 rounded-pill" style="font-size: 0.65rem;">
                    <i class="fa-solid fa-check-double"></i> طلب مؤكد
                </span>
            </div>
            <p class="mb-0 text-muted" style="font-size: 0.76rem;" id="spMessage">
                {{ $is_digital ? 'قام بشراء وتحميل نسخته الرقمية للتو' : 'قام بطلب قطعتين من هذا المنتج' }}
            </p>
            <span class="text-secondary" style="font-size: 0.68rem;" id="spTime"><i class="fa-regular fa-clock me-1"></i> منذ دقيقتين</span>
        </div>
        <button type="button" class="btn-close ms-1 align-self-start" style="font-size: 0.6rem;" onclick="closeSocialProof()" aria-label="Close"></button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const isDigital = {{ $is_digital ? 'true' : 'false' }};
        const unitPrice = {{ (float) $product->price }};
        const bundleList = @json($bundles);

        // Digital Payment Option Selector
        function togglePaymentSelection(method) {
            const chargilyCard = document.getElementById('chargilyLabel');
            const vermentsCard = document.getElementById('vermentsLabel');
            if (chargilyCard) chargilyCard.classList.toggle('selected', method === 'chargily');
            if (vermentsCard) vermentsCard.classList.toggle('selected', method === 'verments');
        }

        // Bundle Card Selection (for Physical Products)
        function selectBundle(index, qty, totalPrice, saveAmount) {
            document.querySelectorAll('.bundle-card').forEach((card, idx) => {
                card.classList.toggle('active-bundle', idx === index);
            });
            document.querySelectorAll('.bundle-radio-check').forEach((radio, idx) => {
                const icon = radio.querySelector('i');
                if (icon) {
                    if (idx === index) {
                        icon.classList.remove('d-none');
                    } else {
                        icon.classList.add('d-none');
                    }
                }
            });

            const qtyInput = document.getElementById('orderQty');
            if (qtyInput) qtyInput.value = qty;

            const formattedPrice = Number(totalPrice).toLocaleString() + ' د.ج';
            const totalDisplay = document.getElementById('totalPriceDisplay');
            if (totalDisplay) totalDisplay.innerText = formattedPrice;

            const stickyPrice = document.getElementById('stickyMobilePrice');
            if (stickyPrice) stickyPrice.innerText = formattedPrice;
        }

        // Manual Quantity Buttons (+ / -)
        function changeQty(diff) {
            const input = document.getElementById('orderQty');
            if (!input) return;
            let val = parseInt(input.value) + diff;
            if (val < 1) val = 1;
            input.value = val;

            let matchedBundle = null;
            let matchedIndex = -1;
            bundleList.forEach((b, idx) => {
                if (parseInt(b.qty) === val) {
                    matchedBundle = b;
                    matchedIndex = idx;
                }
            });

            if (matchedBundle) {
                selectBundle(matchedIndex, matchedBundle.qty, matchedBundle.total_price, matchedBundle.save_amount || 0);
            } else {
                document.querySelectorAll('.bundle-card').forEach(card => card.classList.remove('active-bundle'));
                document.querySelectorAll('.bundle-radio-check i').forEach(icon => icon.classList.add('d-none'));

                const total = val * unitPrice;
                const formattedPrice = total.toLocaleString() + ' د.ج';
                document.getElementById('totalPriceDisplay').innerText = formattedPrice;
                const stickyPrice = document.getElementById('stickyMobilePrice');
                if (stickyPrice) stickyPrice.innerText = formattedPrice;
            }
        }

        // Image Gallery Thumbnails
        function setMainImg(src, el) {
            const mainImg = document.getElementById('mainProductImg');
            if (mainImg) {
                mainImg.style.opacity = '0.3';
                setTimeout(() => {
                    mainImg.src = src;
                    mainImg.style.opacity = '1';
                }, 150);
            }
            document.querySelectorAll('.gallery-thumb').forEach(thumb => {
                thumb.classList.remove('active-thumb');
            });
            if (el) {
                el.classList.add('active-thumb');
            }
        }

        // Dynamic Countdown Timer
        let totalSeconds = 2 * 3600 + 44 * 60 + 18;
        function updateCountdown() {
            const hours = Math.floor(totalSeconds / 3600);
            const minutes = Math.floor((totalSeconds % 3600) / 60);
            const seconds = totalSeconds % 60;
            const formatted = 
                String(hours).padStart(2, '0') + ':' + 
                String(minutes).padStart(2, '0') + ':' + 
                String(seconds).padStart(2, '0');
            
            const timerEl = document.getElementById('heroCountdown');
            if (timerEl) timerEl.innerText = formatted;

            if (totalSeconds > 0) {
                totalSeconds--;
            }
        }
        setInterval(updateCountdown, 1000);
        updateCountdown();

        // Algerian Real Social Proof Popups Rotation
        const algerianBuyers = [
            { name: "أمين .ب", city: "الجزائر العاصمة", text: isDigital ? "قام بتحميل نسخته الرقمية للتو" : "قام بطلب قطعتين من هذا المنتج", time: "منذ دقيقتين" },
            { name: "سفيان .م", city: "وهران", text: isDigital ? "قام بشراء نسخته الرقمية بنجاح" : "قام بطلب العرض الأكثر طلباً (قطعتين)", time: "منذ 4 دقائق" },
            { name: "فاطمة الزهراء .ق", city: "سطيف", text: isDigital ? "قامت بتحميل الملف للتو" : "قامت بطلب هذا المنتج للتو", time: "الآن" },
            { name: "كريم .ح", city: "قسنطينة", text: isDigital ? "قام باقتناء النسخة الرقمية" : "قام بطلب حزمة التوفير (3 قطع)", time: "منذ 7 دقائق" },
            { name: "ياسمين .د", city: "البليدة", text: isDigital ? "قامت بالتحميل الفوري للملف" : "قامت بطلب قطعة واحدة", time: "منذ 9 دقائق" },
            { name: "عبد الرزاق .ع", city: "عنابة", text: isDigital ? "قام بشراء النسخة الرقمية" : "قام بطلب قطعتين مع شحن سريع", time: "منذ 3 دقائق" }
        ];

        let spIndex = 0;
        let spDismissed = false;

        function showNextSocialProof() {
            if (spDismissed) return;
            const toast = document.getElementById('socialProofToast');
            if (!toast) return;

            const buyer = algerianBuyers[spIndex];
            document.getElementById('spCustomerName').innerText = `${buyer.name} (${buyer.city})`;
            document.getElementById('spMessage').innerText = buyer.text;
            document.getElementById('spTime').innerHTML = `<i class="fa-regular fa-clock me-1"></i> ${buyer.time}`;

            toast.classList.add('show-toast');

            setTimeout(() => {
                toast.classList.remove('show-toast');
            }, 6000);

            spIndex = (spIndex + 1) % algerianBuyers.length;
        }

        function closeSocialProof() {
            spDismissed = true;
            const toast = document.getElementById('socialProofToast');
            if (toast) toast.classList.remove('show-toast');
        }

        setTimeout(() => {
            showNextSocialProof();
            setInterval(showNextSocialProof, 14000);
        }, 3500);
    </script>
</body>

</html>
