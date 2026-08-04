<!-- ======= كيف تعمل المنصة Section ======= -->
<section id="how-it-works" class="how-it-works py-5">
    <div class="container" data-aos="fade-up">

      <div class="section-title text-center mb-5">
        <span class="badge px-3 py-2 rounded-pill mb-2 how-it-works-badge">{{ __('site.how_it_works_badge') }}</span>
        <h2 class="fw-bold text-dark position-relative d-inline-block pb-2 how-title">{{ __('site.how_it_works') }}</h2>
        <p class="text-muted lead fs-6 mx-auto mt-2 how-desc" style="max-width: 650px;">{{ __('site.how_it_works_subtitle') }}</p>
      </div>

      <div class="row steps-container g-4">
        <!-- الخطوة 1: التسجيل والانضمام -->
        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="100">
          <div class="step-item w-100 p-4 rounded-4 bg-white shadow-sm position-relative">
            <div class="step-num"><span>1</span></div>
            <div class="icon-box mb-3 d-inline-flex align-items-center justify-content-center rounded-circle">
              <i class="ri-user-add-line fs-2"></i>
            </div>
            <h4 class="fw-bold fs-5 text-dark mb-2 step-h4">{{ __('site.how_step_1_title') }}</h4>
            <p class="text-muted small lh-lg mb-0 step-p">{{ __('site.how_step_1_desc') }}</p>
          </div>
        </div>

        <!-- الخطوة 2: عرض المنتجات وتكوين المتجر -->
        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="200">
          <div class="step-item w-100 p-4 rounded-4 bg-white shadow-sm position-relative">
            <div class="step-num"><span>2</span></div>
            <div class="icon-box mb-3 d-inline-flex align-items-center justify-content-center rounded-circle">
              <i class="ri-product-hunt-line fs-2"></i>
            </div>
            <h4 class="fw-bold fs-5 text-dark mb-2 step-h4">{{ __('site.how_step_2_title') }}</h4>
            <p class="text-muted small lh-lg mb-0 step-p">{{ __('site.how_step_2_desc') }}</p>
          </div>
        </div>

        <!-- الخطوة 3: التسويق وجذب العملاء -->
        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="300">
          <div class="step-item w-100 p-4 rounded-4 bg-white shadow-sm position-relative">
            <div class="step-num"><span>3</span></div>
            <div class="icon-box mb-3 d-inline-flex align-items-center justify-content-center rounded-circle">
              <i class="ri-search-eye-line fs-2"></i>
            </div>
            <h4 class="fw-bold fs-5 text-dark mb-2 step-h4">{{ __('site.how_step_3_title') }}</h4>
            <p class="text-muted small lh-lg mb-0 step-p">{{ __('site.how_step_3_desc') }}</p>
          </div>
        </div>

        <!-- الخطوة 4: إدارة الطلبات والشحن -->
        <div class="col-lg-3 col-md-6 d-flex align-items-stretch" data-aos="fade-up" data-aos-delay="400">
          <div class="step-item w-100 p-4 rounded-4 bg-white shadow-sm position-relative">
            <div class="step-num"><span>4</span></div>
            <div class="icon-box mb-3 d-inline-flex align-items-center justify-content-center rounded-circle">
              <i class="ri-truck-line fs-2"></i>
            </div>
            <h4 class="fw-bold fs-5 text-dark mb-2 step-h4">{{ __('site.how_step_4_title') }}</h4>
            <p class="text-muted small lh-lg mb-0 step-p">{{ __('site.how_step_4_desc') }}</p>
          </div>
        </div>

      </div>

    </div>
</section><!-- End كيف تعمل المنصة Section -->

<style>
.how-it-works {
  background: linear-gradient(180deg, #fdfbfe 0%, #f6ecf3 100%);
  position: relative;
}

.how-it-works-badge {
  background: rgba(176, 56, 130, 0.12);
  color: #B03882;
  border: 1px solid rgba(176, 56, 130, 0.25);
  font-weight: 600;
}

.how-it-works .section-title h2::after {
  content: '';
  position: absolute;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  width: 60px;
  height: 3px;
  background: linear-gradient(90deg, #B03882 0%, #d6479f 100%);
  border-radius: 3px;
}

.how-it-works .step-item {
  border: 1px solid rgba(176, 56, 130, 0.1);
  transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
  margin-top: 20px;
  overflow: visible !important;
}

.how-it-works .step-item::before {
  content: '';
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  height: 4px;
  background: linear-gradient(90deg, #B03882 0%, #d6479f 100%);
  opacity: 0;
  transition: opacity 0.3s ease;
  border-top-left-radius: 1rem;
  border-top-right-radius: 1rem;
}

.how-it-works .step-item:hover {
  transform: translateY(-8px);
  box-shadow: 0 15px 35px rgba(176, 56, 130, 0.15) !important;
  border-color: rgba(176, 56, 130, 0.3);
}

.how-it-works .step-item:hover::before {
  opacity: 1;
}

.how-it-works .step-num {
  position: absolute;
  top: -18px;
  right: 20px;
  background: linear-gradient(135deg, #B03882 0%, #d6479f 100%);
  color: #ffffff;
  width: 38px;
  height: 38px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 800;
  font-size: 16px;
  box-shadow: 0 6px 15px rgba(176, 56, 130, 0.35);
  z-index: 5;
}

.how-it-works .icon-box {
  width: 60px;
  height: 60px;
  background: rgba(176, 56, 130, 0.1);
  color: #B03882;
  transition: all 0.3s ease;
}

.how-it-works .step-item:hover .icon-box {
  background: linear-gradient(135deg, #B03882 0%, #d6479f 100%);
  color: #ffffff;
  transform: scale(1.08);
}

/* Tablet & Mobile Responsive Typography */
@media (max-width: 991px) {
  .how-title {
    font-size: 1.6rem !important;
  }
  .how-desc {
    font-size: 0.92rem !important;
    line-height: 1.6 !important;
  }
  .step-item {
    padding: 20px 16px !important;
  }
  .step-h4 {
    font-size: 1.05rem !important;
  }
  .step-p {
    font-size: 0.88rem !important;
    line-height: 1.6 !important;
  }
  .how-it-works .step-num {
    width: 34px !important;
    height: 34px !important;
    font-size: 14px !important;
    top: -17px !important;
  }
}

@media (max-width: 575px) {
  .how-title {
    font-size: 1.4rem !important;
  }
  .step-item {
    padding: 18px 14px !important;
  }
}
</style>