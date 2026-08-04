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

      function gtag() {
          dataLayer.push(arguments);
      }

      gtag('js', new Date());
      gtag('config', '{{ $measurementId }}');
      </script>

      @endif 
@endsection

@section('hero')
@include('site.inc.header.supplier_plan_header')
@endsection

@section('pricing')
<!-- ======= Pricing Section ======= -->
<section id="pricing" class="pricing py-5 position-relative overflow-hidden">
    <div class="container" data-aos="fade-up">

      <div class="section-title text-center mb-5">
        <span class="badge px-4 py-2 rounded-pill mb-3 pricing-badge">
            {{ __('site.suppliers_pricing_badge') }}
        </span>
        <h2 class="fw-bold text-dark fs-2 mb-3">{{ __('site.suppliers_pricing_title') }}</h2>
        <p class="text-muted lead fs-6 mx-auto mt-2" style="max-width: 780px;">
            {{ __('site.suppliers_pricing_desc') }}
        </p>
      </div>

      <div class="row g-4 align-items-center justify-content-center">
        @foreach ($plans as $plan)
        @php
            $authorizations = $plan->Authorizations;
            $pricing = $plan->pricing;
            // Identify middle plan as Most Popular for high conversion rate
            $isPopular = ($loop->index == 1) || ($loop->count > 1 && $loop->index == (int)floor($loop->count / 2));
        @endphp

        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ 100 * ($loop->index + 1) }}">
          <div class="pricing-card rounded-4 p-4 position-relative bg-white shadow-sm transition-card {{ $isPopular ? 'popular-card border-popular' : 'border border-light-subtle' }}">

            @if($isPopular)
                <div class="popular-ribbon px-3 py-1 rounded-pill text-white fw-bold small text-center shadow">
                    {{ __('site.most_popular_badge') }}
                </div>
            @endif

            <form action="{{ url(request()->server('REQUEST_SCHEME').'://supplier.'.request()->server('HTTP_HOST').'/supplier-panel/register') }}" method="GET">
              
              <div class="card-header-box text-center pb-3 mb-3 border-bottom border-light">
                  <h3 class="fw-bold text-dark fs-4 mb-2">{{ __('site.plan_prefix') }} {{ $plan->name }}</h3>
                  
                  @if ($pricing->count() > 0)
                      <div class="price-box my-3">
                          <span class="fs-1 fw-bold text-pink-accent">{{ $plan->price }}</span>
                          <span class="fs-6 text-muted me-1">د.ج</span>
                          <span class="d-block text-muted small mt-1">{{ __('site.per_month') }}</span>
                      </div>
                  @else
                      <div class="price-box my-3">
                          <span class="fs-1 fw-bold text-pink-accent">{{ $plan->price }}</span>
                          <span class="fs-6 text-muted me-1">د.ج</span>
                          @if ($plan->id == 1)
                              <span class="d-block text-muted small mt-1">{{ __('site.lifetime') }}</span>
                          @else
                              <span class="d-block text-muted small mt-1">{{ __('site.per_month') }}</span>
                          @endif
                      </div>
                  @endif
              </div>

              @if ($pricing->count() > 0)
                  <div class="duration-offers-box mb-4 p-3 rounded-3 bg-light-subtle">
                      <h6 class="fw-bold text-dark fs-7 mb-2 text-center">{{ __('site.plan_offers_title') }}</h6>
                      <div class="d-flex flex-column gap-2">
                          <label class="duration-option-item p-2 rounded-3 border bg-white d-flex align-items-center justify-content-between cursor-pointer transition-item">
                              <div class="d-flex align-items-center gap-2">
                                  <input type="radio" name="sub_plan_id" value="0" checked class="form-check-input me-1">
                                  <span class="fw-semibold small text-dark">30 {{ __('site.day_period') }}</span>
                              </div>
                              <span class="fw-bold text-pink-accent small">{{ $plan->price }} د.ج</span>
                          </label>

                          @foreach ($pricing as $price)
                              <label class="duration-option-item p-2 rounded-3 border bg-white d-flex align-items-center justify-content-between cursor-pointer transition-item">
                                  <div class="d-flex align-items-center gap-2">
                                      <input type="radio" name="sub_plan_id" value="{{ $price->id }}" class="form-check-input me-1">
                                      <span class="fw-semibold small text-dark">{{ $price->duration }} {{ __('site.day_period') }}</span>
                                  </div>
                                  <span class="fw-bold text-pink-accent small">{{ $price->price }} د.ج</span>
                              </label>
                          @endforeach
                      </div>
                  </div>
              @endif

              <div class="features-list-wrapper mb-4">
                  <ul class="list-unstyled d-flex flex-column gap-2.5 mb-0">
                      @foreach ($authorizations as $authorization)
                          @if($authorization['is_enabled'])
                              <li class="d-flex align-items-start gap-2 text-dark fs-7">
                                  <i class="bi bi-check-circle-fill text-success fs-6 flex-shrink-0 mt-0.5"></i>
                                  <span>{{ $authorization['description'] }}</span>
                              </li>
                          @else
                              <li class="d-flex align-items-start gap-2 text-muted text-decoration-line-through fs-7 opacity-75">
                                  <i class="bi bi-x-circle-fill text-secondary fs-6 flex-shrink-0 mt-0.5"></i>
                                  <span>{{ $authorization['description'] }}</span>
                              </li>
                          @endif 
                      @endforeach
                  </ul>
              </div>

              <input type="hidden" name="plan" value="{{ $plan->name }}">
              <button type="submit" class="btn w-100 py-3 rounded-pill fw-bold text-white shadow transition-btn {{ $isPopular ? 'btn-popular-cta' : 'btn-regular-cta' }}">
                  <span>{{ __('site.start_now_plan') }}</span>
                  <i class="bi bi-arrow-{{ app()->getLocale() == 'ar' ? 'left' : 'right' }}-short fs-5 me-1 ms-1"></i>
              </button>

            </form>
          </div>
        </div>
        @endforeach
      </div>

    </div>
</section><!-- End Pricing Section -->

<style>
.pricing {
    background: #faf7f9;
}

.pricing-badge {
    background: rgba(176, 56, 130, 0.12);
    color: #B03882;
    border: 1px solid rgba(176, 56, 130, 0.25);
    font-weight: 600;
    font-size: 14px;
}

.pricing-card {
    transition: all 0.35s ease;
    min-height: 100%;
}

.pricing-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08) !important;
}

.popular-card {
    border: 2px solid #B03882 !important;
    background: #ffffff !important;
    box-shadow: 0 15px 35px rgba(176, 56, 130, 0.25) !important;
    transform: scale(1.04);
}

.popular-card:hover {
    transform: scale(1.06) translateY(-6px);
}

.popular-ribbon {
    position: absolute;
    top: -16px;
    left: 50%;
    transform: translateX(-50%);
    background: linear-gradient(135deg, #B03882 0%, #d6479f 100%);
    font-size: 12px;
    white-space: nowrap;
    z-index: 4;
}

.text-pink-accent {
    color: #B03882 !important;
}

.duration-option-item:hover {
    border-color: #B03882 !important;
    background: rgba(176, 56, 130, 0.04) !important;
}

.btn-popular-cta {
    background: linear-gradient(135deg, #B03882 0%, #d6479f 100%);
    border: none;
    box-shadow: 0 8px 20px rgba(176, 56, 130, 0.4) !important;
}

.btn-popular-cta:hover {
    background: linear-gradient(135deg, #c74395 0%, #f05cb6 100%);
    color: #ffffff !important;
}

.btn-regular-cta {
    background: #1d1d1f;
    border: none;
}

.btn-regular-cta:hover {
    background: #B03882;
    color: #ffffff !important;
}

.cursor-pointer {
    cursor: pointer;
}

@media (max-width: 991px) {
    .popular-card {
        transform: none !important;
        margin-top: 20px;
    }
    
    .popular-card:hover {
        transform: translateY(-5px) !important;
    }
}
</style>
@endsection