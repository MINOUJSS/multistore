<style>
    .icon-box {
        position: relative;
        background: #fff;
        border-radius: 20px;
        padding: 30px 24px;
        transition: all .3s ease;
    }

    .icon-box:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, .08);
    }

    .service-btn {
        width: 100%;
        background: #B03882;
        color: white;
        border-radius: 12px;
        font-weight: 700;
        padding: 12px;
    }

    .service-btn:hover {
        background: #8E2D68;
        color: white;
    }

    .service-features {
        padding-right: 18px;
        margin-top: 15px;
    }

    .service-features li {
        margin-bottom: 8px;
    }

    .seller-card {
        border: 2px solid #B03882;
        transform: scale(1.03);
    }

    .new-badge {
        position: absolute;
        top: -12px;
        right: 20px;
        background: #B03882;
        color: white;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 700;
    }

    .digital-box {
        background: #F8E4F1;
        border: 1px solid #E5A6CA;
        padding: 14px;
        border-radius: 14px;
        margin-top: 15px;
    }
</style>

<!-- ======= Services Section ======= -->
<section id="services" class="services section-bg py-5">
    <div class="container" data-aos="fade-up">

        <div class="section-title text-center mb-5">
            <span class="badge rounded-pill px-4 py-2 mb-3" style="background:#F8E4F1;color:#B03882;font-size:14px;">
                {{ __('site.services_badge') }}
            </span>

            <h2 style="color:#1d1d1f;font-weight:800;">
                {{ __('site.services_title') }}
            </h2>

            <p class="mt-3" style="max-width:850px;margin:auto;">
                {{ __('site.services_desc') }}
            </p>
        </div>

        <div class="row g-4">

            <!-- تجار التجزئة -->
            <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="200">
                <div class="icon-box seller-card w-100 shadow">

                    <div class="new-badge">{{ __('site.new_feature') }}</div>

                    <div class="icon"><i class="bx bx-cart"></i></div>
                    <h4>{{ __('site.retailers_title') }}</h4>

                    <p>
                        {{ __('site.retailers_desc') }}
                    </p>

                    <div class="digital-box">
                        <strong>{{ __('site.digital_products_title') }}</strong>
                        <small class="d-block mt-2">
                            {{ __('site.digital_products_desc') }}
                        </small>
                    </div>

                    <ul class="service-features mt-3">
                        <li>{{ __('site.feat_retailer_1') }}</li>
                        <li>{{ __('site.feat_retailer_2') }}</li>
                        <li>{{ __('site.feat_retailer_3') }}</li>
                    </ul>

                    <a class="btn service-btn mt-3" href="{{ route('site.show_sellers_plans') }}">
                        {{ __('site.start_now') }}
                    </a>
                </div>
            </div>

            <!-- الموردين -->
            <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="100">
                <div class="icon-box w-100 shadow-sm">
                    <div class="icon"><i class="bx bx-store"></i></div>
                    <h4>{{ __('site.suppliers_title') }}</h4>

                    <p>
                        {{ __('site.suppliers_desc') }}
                    </p>

                    <ul class="service-features">
                        <li>{{ __('site.feat_supplier_1') }}</li>
                        <li>{{ __('site.feat_supplier_2') }}</li>
                        <li>{{ __('site.feat_supplier_3') }}</li>
                    </ul>

                    <a class="btn service-btn mt-3" href="{{ route('site.show_suppliers_plans') }}">
                        {{ __('site.start_now') }}
                    </a>
                </div>
            </div>

            <!-- المسوقين -->
            <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="300">
                <div class="icon-box w-100 shadow-sm">
                    <div class="icon"><i class="bx bx-line-chart"></i></div>
                    <h4>{{ __('site.affiliates_title') }}</h4>

                    <p>
                        {{ __('site.affiliates_desc') }}
                    </p>

                    <ul class="service-features">
                        <li>{{ __('site.feat_affiliate_1') }}</li>
                        <li>{{ __('site.feat_affiliate_2') }}</li>
                        <li>{{ __('site.feat_affiliate_3') }}</li>
                    </ul>

                    <a class="btn service-btn mt-3" href="{{ route('site.show_affiliate_marketers_plans') }}">
                        {{ __('site.start_now') }}
                    </a>
                </div>
            </div>

            <!-- الشحن -->
            <div class="col-xl-3 col-md-6 d-flex align-items-stretch" data-aos="zoom-in" data-aos-delay="400">
                <div class="icon-box w-100 shadow-sm">
                    <div class="icon"><i class="bx bx-package"></i></div>
                    <h4>{{ __('site.shippers_title') }}</h4>

                    <p>
                        {{ __('site.shippers_desc') }}
                    </p>

                    <ul class="service-features">
                        <li>{{ __('site.feat_shipper_1') }}</li>
                        <li>{{ __('site.feat_shipper_2') }}</li>
                        <li>{{ __('site.feat_shipper_3') }}</li>
                    </ul>

                    <a class="btn service-btn mt-3" href="{{ route('site.show_shipers_plans') }}">
                        {{ __('site.start_now') }}
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>
