<!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center position-relative overflow-hidden">
    <!-- Subtle Ambient Background Glows tailored to primary color #B03882 -->
    <div class="hero-glow-1"></div>
    <div class="hero-glow-2"></div>

    <div class="container position-relative z-index-2 py-5">
        <div class="row align-items-center">
            <!-- Text Column -->
            <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                data-aos="fade-up" data-aos-delay="200">

                <!-- Conversion Trust Pill / Badge -->
                <div class="d-inline-flex align-items-center gap-2 mb-3 hero-badge-pill">
                    <span class="badge-icon">🔥</span>
                    <span class="badge-text fw-bold">{{ __('site.header_badge_pill') }}</span>
                </div>

                <!-- Main Title -->
                <h1 class="hero-main-title fw-bold text-white mb-3">
                    {{ __('site.header_title') }}
                </h1>

                <!-- Subtitle / Description -->
                <h2 class="hero-sub-title mb-4 fs-5">
                    {{ __('site.header_description') }}
                </h2>

                <!-- Action Buttons (CTA) -->
                <div
                    class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start gap-3 mb-4">
                    <a href="#services"
                        class="btn-get-started scrollto shadow-lg d-inline-flex align-items-center gap-2 px-4 py-3 fw-bold">
                        <span>{{ __('site.get_started') }}</span>
                        <i class="bi bi-arrow-left-short fs-4"></i>
                    </a>

                    <a href="https://youtu.be/AfA5J1Y9HCs"
                        class="glightbox btn-watch-video d-inline-flex align-items-center gap-2 text-white-50 text-decoration-none px-3 py-2">
                        <i class="bi bi-play-circle-fill fs-3 text-pink-accent"></i>
                        <span class="fw-semibold text-white">{{ __('site.watch_how_it_works') }}</span>
                    </a>
                </div>

                <!-- Social Proof & Trust Badges -->
                <div class="hero-trust-bar pt-3 border-top border-white-10 d-flex flex-wrap align-items-center gap-4">
                    <div class="d-flex align-items-center gap-2">
                        <div class="stars text-warning fs-6">★★★★★</div>
                        <span class="text-white-50 small fw-semibold">{{ __('site.active_stores_count') }}</span>
                    </div>
                    <div class="d-flex align-items-center gap-3 text-white-50 small">
                        <span><i class="bi bi-shield-check text-pink-accent me-1"></i>
                            {{ __('site.electronic_payments') }}</span>
                        <span><i class="bi bi-truck text-pink-accent me-1"></i>
                            {{ __('site.integrated_shipping') }}</span>
                    </div>
                </div>

            </div>

            <!-- Image Column with Glassmorphic Floating Cards -->
            <div class="col-lg-6 order-1 order-lg-2 hero-img text-center position-relative" data-aos="zoom-in"
                data-aos-delay="200">
                <div class="hero-img-wrapper position-relative d-inline-block">
                    <img src="{{ asset('asset/v1/site/defaulte') }}/img/hero.jpeg"
                        class="img-fluid animated rounded-4 shadow-lg border border-white-20" alt="Multi-Store AI Hero">

                    <!-- Floating Badge 1: Sales Growth -->
                    <div
                        class="hero-floating-card card-sales shadow-lg d-flex align-items-center gap-3 p-3 rounded-3 bg-white text-dark text-start">
                        <div class="card-icon-box rounded-circle p-2"
                            style="background: rgba(176, 56, 130, 0.12); color: #B03882;">
                            <i class="bi bi-graph-up-arrow fs-4"></i>
                        </div>
                        <div>
                            <span class="d-block fw-bold text-dark fs-6">+150%</span>
                            <span class="text-muted small">{{ __('site.sales_growth') }}</span>
                        </div>
                    </div>

                    <!-- Floating Badge 2: Fast Setup -->
                    <div
                        class="hero-floating-card card-setup shadow-lg d-flex align-items-center gap-3 p-3 rounded-3 bg-white text-dark text-start">
                        <div class="card-icon-box rounded-circle p-2"
                            style="background: rgba(176, 56, 130, 0.12); color: #B03882;">
                            <i class="bi bi-lightning-charge-fill fs-4"></i>
                        </div>
                        <div>
                            <span class="d-block fw-bold text-dark fs-6">{{ __('site.ready_in_minutes') }}</span>
                            <span class="text-muted small">{{ __('site.no_coding_required') }}</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Scoped Custom Styling built around Primary Color #B03882 -->
    <style>
        #hero {
            background: linear-gradient(135deg, #1f0717 0%, #3b102c 45%, #681d4b 85%, #B03882 100%);
            min-height: 85vh;
            padding: 60px 0;
        }

        .hero-glow-1 {
            position: absolute;
            top: -10%;
            right: -10%;
            width: 450px;
            height: 450px;
            background: radial-gradient(circle, rgba(176, 56, 130, 0.35) 0%, rgba(31, 7, 23, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-glow-2 {
            position: absolute;
            bottom: -15%;
            left: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(228, 93, 164, 0.25) 0%, rgba(31, 7, 23, 0) 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .hero-badge-pill {
            background: rgba(176, 56, 130, 0.2);
            border: 1px solid rgba(228, 93, 164, 0.4);
            color: #ffa1d8;
            padding: 6px 18px;
            border-radius: 30px;
            backdrop-filter: blur(8px);
        }

        .hero-main-title {
            font-size: 2.75rem;
            line-height: 1.25;
            letter-spacing: -0.5px;
        }

        .hero-sub-title {
            color: rgba(255, 255, 255, 0.85) !important;
            line-height: 1.6;
        }

        .text-pink-accent {
            color: #ff85c6 !important;
        }

        #hero .btn-get-started {
            background: linear-gradient(135deg, #B03882 0%, #d6479f 100%);
            color: #ffffff !important;
            border: none;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        #hero .btn-get-started:hover {
            background: linear-gradient(135deg, #c74395 0%, #f05cb6 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(176, 56, 130, 0.45) !important;
            color: #ffffff !important;
        }

        .btn-watch-video:hover {
            color: #ff85c6 !important;
        }

        .border-white-10 {
            border-color: rgba(255, 255, 255, 0.12) !important;
        }

        .border-white-20 {
            border-color: rgba(255, 255, 255, 0.25) !important;
        }

        .hero-img-wrapper {
            perspective: 1000px;
        }

        .hero-floating-card {
            position: absolute;
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            z-index: 10;
            animation: floatCard 4s ease-in-out infinite alternate;
        }

        .card-sales {
            top: 15%;
            right: -25px;
        }

        .card-setup {
            bottom: 12%;
            left: -25px;
            animation-delay: 2s;
        }

        @keyframes floatCard {
            0% {
                transform: translateY(0px);
            }

            100% {
                transform: translateY(-10px);
            }
        }

        @media (max-width: 991px) {
            .hero-floating-card {
                display: none !important;
            }

            .hero-main-title {
                font-size: 2rem;
            }
        }
    </style>

</section><!-- End Hero -->
