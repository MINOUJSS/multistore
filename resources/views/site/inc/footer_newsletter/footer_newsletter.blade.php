<div class="footer-newsletter py-5">
    <div class="container" data-aos="zoom-in" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-lg-10">
          
          <div class="newsletter-card rounded-4 p-4 p-lg-5 text-center text-white position-relative overflow-hidden shadow-lg border border-white-20">
            <!-- Ambient Glow Elements -->
            <div class="newsletter-glow-1"></div>
            <div class="newsletter-glow-2"></div>

            <div class="position-relative z-index-2 max-w-750 mx-auto">
              <span class="badge px-3 py-2 rounded-pill mb-3 newsletter-pill-badge">{{ __('site.newsletter_badge') }}</span>
              
              <h3 class="fw-bold text-white fs-2 mb-3 newsletter-title">
                {{ __('site.newsletter_title') }}
              </h3>
              
              <p class="text-white-80 lead fs-6 mb-4 lh-base newsletter-desc">
                {{ __('site.newsletter_desc') }}
              </p>

              {{-- alert --}}
              <div class="subscribe-alert mb-3"></div>

              <form action="{{route('site.newsletter.subscribe')}}" method="post" class="newsletter-form mx-auto" style="max-width: 600px;">
                @csrf
                <input type="text" name="website" style="display:none">
                
                <div class="newsletter-input-box p-2 rounded-pill bg-white shadow-lg d-flex align-items-center justify-content-between gap-2">
                  <div class="d-flex align-items-center gap-2 flex-grow-1 ps-3">
                    <i class="bi bi-envelope-open-fill fs-5 text-pink-accent"></i>
                    <input type="email" name="subscriber_email" class="form-control border-0 bg-transparent text-dark px-2 shadow-none" placeholder="{{ __('site.newsletter_email_placeholder') }}" required>
                  </div>
                  <button type="submit" name="subscriber_submit" value="إشتراك" class="btn btn-newsletter-submit px-4 py-3 rounded-pill fw-bold text-white border-0 shadow d-inline-flex align-items-center gap-2">
                    <span>{{ __('site.newsletter_subscribe_btn') }}</span>
                    <i class="bi bi-arrow-left-short fs-4"></i>
                  </button>
                </div>
              </form>

              <div class="mt-3 text-white-50 small d-flex align-items-center justify-content-center gap-3 flex-wrap trust-notes">
                <span><i class="bi bi-shield-check text-pink-accent me-1"></i> {{ __('site.newsletter_no_spam') }}</span>
                <span><i class="bi bi-x-circle text-pink-accent me-1"></i> {{ __('site.newsletter_unsubscribe') }}</span>
              </div>
            </div>

          </div>

        </div>
      </div>
    </div>
</div>

<style>
.footer-newsletter {
  background: transparent;
}

.newsletter-card {
  background: linear-gradient(135deg, #1f0717 0%, #3b102c 45%, #681d4b 85%, #B03882 100%);
  box-shadow: 0 20px 40px rgba(31, 7, 23, 0.4) !important;
}

.newsletter-glow-1 {
  position: absolute;
  top: -20%;
  right: -10%;
  width: 350px;
  height: 350px;
  background: radial-gradient(circle, rgba(176, 56, 130, 0.4) 0%, rgba(31, 7, 23, 0) 70%);
  border-radius: 50%;
  pointer-events: none;
}

.newsletter-glow-2 {
  position: absolute;
  bottom: -20%;
  left: -10%;
  width: 350px;
  height: 350px;
  background: radial-gradient(circle, rgba(228, 93, 164, 0.3) 0%, rgba(31, 7, 23, 0) 70%);
  border-radius: 50%;
  pointer-events: none;
}

.newsletter-pill-badge {
  background: rgba(255, 255, 255, 0.15);
  border: 1px solid rgba(255, 255, 255, 0.3);
  color: #ffa1d8;
  backdrop-filter: blur(8px);
}

.text-white-80 {
  color: rgba(255, 255, 255, 0.85) !important;
}

.text-pink-accent {
  color: #ff85c6 !important;
}

.newsletter-input-box {
  border: 1px solid rgba(176, 56, 130, 0.25);
  transition: all 0.3s ease;
}

.newsletter-input-box:focus-within {
  box-shadow: 0 10px 30px rgba(176, 56, 130, 0.35) !important;
  border-color: #ff85c6;
}

.btn-newsletter-submit {
  background: linear-gradient(135deg, #B03882 0%, #d6479f 100%);
  transition: all 0.3s ease;
  white-space: nowrap;
}

.btn-newsletter-submit:hover {
  background: linear-gradient(135deg, #c74395 0%, #f05cb6 100%);
  transform: translateY(-2px);
  box-shadow: 0 8px 20px rgba(176, 56, 130, 0.45) !important;
  color: #ffffff !important;
}

/* Tablet & Mobile Responsive Typography & Spacing */
@media (max-width: 991px) {
  .newsletter-card {
    padding: 30px 20px !important;
  }
  .newsletter-title {
    font-size: 1.5rem !important;
    line-height: 1.35 !important;
  }
  .newsletter-desc {
    font-size: 0.92rem !important;
    line-height: 1.6 !important;
  }
  .newsletter-pill-badge {
    font-size: 0.78rem !important;
  }
  .trust-notes span {
    font-size: 0.78rem !important;
  }
}

@media (max-width: 575px) {
  .newsletter-card {
    padding: 25px 15px !important;
    border-radius: 20px !important;
  }
  .newsletter-title {
    font-size: 1.3rem !important;
  }
  .newsletter-input-box {
    flex-direction: column !important;
    border-radius: 20px !important;
    padding: 12px !important;
    gap: 10px !important;
  }
  .newsletter-input-box input {
    width: 100% !important;
    font-size: 0.9rem !important;
    text-align: center !important;
  }
  .btn-newsletter-submit {
    width: 100% !important;
    justify-content: center;
    border-radius: 50px !important;
    padding: 12px 20px !important;
    font-size: 0.95rem !important;
  }
}
</style>