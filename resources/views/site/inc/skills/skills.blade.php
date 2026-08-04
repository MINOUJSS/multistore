<!-- ======= Payments / Skills Section ======= -->
<section id="skills" class="skills py-5 position-relative overflow-hidden">
    <div class="container" data-aos="fade-up">

      <div class="row align-items-center g-5">
        <!-- Floating Interactive Image Column -->
        <div class="col-lg-6 position-relative text-center" data-aos="fade-right" data-aos-delay="100">
          <div class="payments-img-wrapper d-inline-block position-relative">
            <!-- Ambient Glow Effect -->
            <div class="payments-ambient-glow"></div>
            
            <!-- Main Payments Image -->
            <img src="{{asset('asset/v1/site/defaulte')}}/img/payments.jpeg" class="img-fluid rounded-4 shadow-lg payments-main-img border border-white-20 position-relative z-index-2" alt="{{ __('site.payments_img_alt') }}">

            <!-- Orbiting Badge 1: CIB / EDAHABIA -->
            <div class="orbiting-badge badge-cib shadow-lg d-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-white position-absolute">
              <div class="badge-icon rounded-circle d-flex align-items-center justify-content-center" style="background: rgba(176, 56, 130, 0.15); color: #B03882; width: 32px; height: 32px;">
                <i class="bi bi-credit-card-2-front-fill fs-6"></i>
              </div>
              <div class="text-start">
                <span class="d-block fw-bold text-dark fs-7">{{ __('site.badge_cib_title') }}</span>
                <small class="text-muted" style="font-size: 10px;">{{ __('site.badge_cib_sub') }}</small>
              </div>
            </div>

            <!-- Orbiting Badge 2: BaridiMob / CCP -->
            <div class="orbiting-badge badge-ccp shadow-lg d-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-white position-absolute">
              <div class="badge-icon rounded-circle d-flex align-items-center justify-content-center" style="background: rgba(176, 56, 130, 0.15); color: #B03882; width: 32px; height: 32px;">
                <i class="bi bi-bank2 fs-6"></i>
              </div>
              <div class="text-start">
                <span class="d-block fw-bold text-dark fs-7">{{ __('site.badge_ccp_title') }}</span>
                <small class="text-muted" style="font-size: 10px;">{{ __('site.badge_ccp_sub') }}</small>
              </div>
            </div>

            <!-- Orbiting Badge 3: Cash on Delivery -->
            <div class="orbiting-badge badge-cod shadow-lg d-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-white position-absolute">
              <div class="badge-icon rounded-circle d-flex align-items-center justify-content-center" style="background: rgba(176, 56, 130, 0.15); color: #B03882; width: 32px; height: 32px;">
                <i class="bi bi-box-seam-fill fs-6"></i>
              </div>
              <div class="text-start">
                <span class="d-block fw-bold text-dark fs-7">{{ __('site.badge_cod_title') }}</span>
                <small class="text-muted" style="font-size: 10px;">{{ __('site.badge_cod_sub') }}</small>
              </div>
            </div>

            <!-- Orbiting Badge 4: Instant Settlement -->
            <div class="orbiting-badge badge-secure shadow-lg d-flex align-items-center gap-2 px-3 py-2 rounded-pill bg-white position-absolute">
              <div class="badge-icon rounded-circle d-flex align-items-center justify-content-center" style="background: rgba(24, 210, 110, 0.15); color: #18d26e; width: 32px; height: 32px;">
                <i class="bi bi-shield-check-fill fs-6"></i>
              </div>
              <div class="text-start">
                <span class="d-block fw-bold text-dark fs-7">{{ __('site.badge_secure_title') }}</span>
                <small class="text-muted" style="font-size: 10px;">{{ __('site.badge_secure_sub') }}</small>
              </div>
            </div>

          </div>
        </div>

        <!-- Content Column -->
        <div class="col-lg-6 content" data-aos="fade-left" data-aos-delay="100">
          <div class="d-inline-flex align-items-center gap-2 mb-3 px-3 py-2 rounded-pill payments-badge">
            <i class="bi bi-shield-lock-fill text-pink-accent"></i>
            <span class="fw-bold small">{{ __('site.skills_badge') }}</span>
          </div>

          <h3 class="fw-bold text-dark fs-2 mb-3 lh-sm payments-h3">
            {{ __('site.skills_title') }}
          </h3>

          <p class="text-muted lead fs-6 mb-4 lh-base payments-lead">
            {{ __('site.skills_lead') }}
          </p>

          <div class="payment-features-list d-flex flex-column gap-3 mb-4">
            
            <div class="feature-item p-3 rounded-3 bg-white border border-light-subtle shadow-sm d-flex align-items-start gap-3">
              <div class="feature-icon rounded-circle p-2 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #B03882 0%, #d6479f 100%); width: 42px; height: 42px; flex-shrink: 0;">
                <i class="bi bi-credit-card-fill fs-5"></i>
              </div>
              <div>
                <h5 class="fw-bold fs-6 text-dark mb-1 feat-h5">{{ __('site.feat_chargily_title') }}</h5>
                <p class="text-muted small mb-0 feat-p">{{ __('site.feat_chargily_desc') }}</p>
              </div>
            </div>

            <div class="feature-item p-3 rounded-3 bg-white border border-light-subtle shadow-sm d-flex align-items-start gap-3">
              <div class="feature-icon rounded-circle p-2 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #B03882 0%, #d6479f 100%); width: 42px; height: 42px; flex-shrink: 0;">
                <i class="bi bi-phone-vibrate-fill fs-5"></i>
              </div>
              <div>
                <h5 class="fw-bold fs-6 text-dark mb-1 feat-h5">{{ __('site.feat_ccp_title') }}</h5>
                <p class="text-muted small mb-0 feat-p">{{ __('site.feat_ccp_desc') }}</p>
              </div>
            </div>

            <div class="feature-item p-3 rounded-3 bg-white border border-light-subtle shadow-sm d-flex align-items-start gap-3">
              <div class="feature-icon rounded-circle p-2 d-flex align-items-center justify-content-center text-white" style="background: linear-gradient(135deg, #B03882 0%, #d6479f 100%); width: 42px; height: 42px; flex-shrink: 0;">
                <i class="bi bi-cash-stack fs-5"></i>
              </div>
              <div>
                <h5 class="fw-bold fs-6 text-dark mb-1 feat-h5">{{ __('site.feat_cod_title') }}</h5>
                <p class="text-muted small mb-0 feat-p">{{ __('site.feat_cod_desc') }}</p>
              </div>
            </div>

          </div>

        </div>
      </div>

    </div>
</section><!-- End Skills Section -->

<style>
.skills {
  background: #faf7f9;
}

.payments-badge {
  background: rgba(176, 56, 130, 0.12);
  color: #B03882;
  border: 1px solid rgba(176, 56, 130, 0.25);
}

.payments-img-wrapper {
  perspective: 1000px;
  padding: 20px;
}

.payments-ambient-glow {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 90%;
  height: 90%;
  background: radial-gradient(circle, rgba(176, 56, 130, 0.35) 0%, rgba(250, 247, 249, 0) 70%);
  border-radius: 50%;
  filter: blur(20px);
  z-index: 1;
}

.payments-main-img {
  animation: floatShake 5s ease-in-out infinite alternate;
  max-width: 100%;
  transition: transform 0.4s ease;
}

.payments-main-img:hover {
  transform: scale(1.03) rotate(1deg);
}

@keyframes floatShake {
  0% {
    transform: translateY(0px) rotate(0deg);
  }
  25% {
    transform: translateY(-8px) rotate(-1deg);
  }
  50% {
    transform: translateY(-12px) rotate(0.5deg);
  }
  75% {
    transform: translateY(-5px) rotate(1deg);
  }
  100% {
    transform: translateY(0px) rotate(0deg);
  }
}

/* Orbiting Badges Styling & Animations */
.orbiting-badge {
  z-index: 10;
  border: 1px solid rgba(176, 56, 130, 0.25);
  backdrop-filter: blur(8px);
  transition: all 0.3s ease;
}

.orbiting-badge:hover {
  transform: scale(1.1) !important;
  box-shadow: 0 10px 25px rgba(176, 56, 130, 0.3) !important;
}

.badge-cib {
  top: 5%;
  right: -10px;
  animation: orbit1 6s ease-in-out infinite alternate;
}

.badge-ccp {
  bottom: 8%;
  right: -15px;
  animation: orbit2 7s ease-in-out infinite alternate;
}

.badge-cod {
  top: 15%;
  left: -15px;
  animation: orbit3 6.5s ease-in-out infinite alternate;
}

.badge-secure {
  bottom: 12%;
  left: -10px;
  animation: orbit4 7.5s ease-in-out infinite alternate;
}

@keyframes orbit1 {
  0% { transform: translateY(0px) translateX(0px); }
  100% { transform: translateY(-10px) translateX(-6px); }
}

@keyframes orbit2 {
  0% { transform: translateY(0px) translateX(0px); }
  100% { transform: translateY(8px) translateX(-8px); }
}

@keyframes orbit3 {
  0% { transform: translateY(0px) translateX(0px); }
  100% { transform: translateY(-12px) translateX(6px); }
}

@keyframes orbit4 {
  0% { transform: translateY(0px) translateX(0px); }
  100% { transform: translateY(10px) translateX(6px); }
}

.payment-features-list .feature-item {
  transition: all 0.3s ease;
}

.payment-features-list .feature-item:hover {
  transform: translateX(-5px);
  border-color: rgba(176, 56, 130, 0.35) !important;
  box-shadow: 0 10px 25px rgba(176, 56, 130, 0.12) !important;
}

/* Tablet & Mobile Responsive Typography & Badges */
@media (max-width: 991px) {
  .payments-h3 {
    font-size: 1.5rem !important;
    line-height: 1.35 !important;
  }
  .payments-lead {
    font-size: 0.92rem !important;
    line-height: 1.6 !important;
  }
  .feat-h5 {
    font-size: 0.98rem !important;
  }
  .feat-p {
    font-size: 0.88rem !important;
    line-height: 1.5 !important;
  }
  .orbiting-badge {
    position: relative !important;
    top: auto !important;
    left: auto !important;
    right: auto !important;
    bottom: auto !important;
    display: inline-flex !important;
    margin: 5px;
    animation: none !important;
  }
}

@media (max-width: 575px) {
  .payments-h3 {
    font-size: 1.3rem !important;
  }
  .payments-img-wrapper {
    padding: 10px !important;
  }
}
</style>