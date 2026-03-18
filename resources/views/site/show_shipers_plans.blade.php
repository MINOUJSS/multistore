@extends('site.layouts.app')

@section('google_analitics')
{!!get_platform_data('google_analitics')->value!!}
@endsection

@section('hero')
    <!-- ======= Hero Section ======= -->
<section id="hero" class="d-flex align-items-center">

    <div class="container">
      <div class="row">
        <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="200">
          <h1>منصة متاجر ديزاد وجهتك الموثوقة للتجارة الإلكترونية</h1>
          <h2>تحّول من التجارة الكلاسيكية إلى التجارة الإلكترونية بسهولة و سرعة و أمتلك متجر إلكتروني خاص بك بجميع مزايا التجارة الإلكترونية مع توفير الخدمات المساندة له</h2>
          <div class="d-flex justify-content-center justify-content-lg-start">
            <a href="#about" class="btn-get-started scrollto">إبدأ الآن</a>
            <a href="https://www.youtube.com/watch?v=cZRpUCWb_A4" class="glightbox btn-watch-video"><i class="bi bi-play-circle"></i><span>فيديو تعريفي بالمنصة</span></a>
          </div>
        </div>
        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
          <img src="{{asset('asset/v1/site/defaulte')}}/img/hero-img.png" class="img-fluid animated" alt="">
        </div>
      </div>
    </div>

  </section><!-- End Hero -->
@endsection
@section('pricing')
    <!-- ======= Pricing Section ======= -->
<section id="pricing" class="pricing">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>الخطط والتسعير لشركات الشحن</h2>
        <p>ابدأ رحلتك معنا كشركة شحن واستفد من خططنا المرنة التي تناسب احتياجات عملك. سواء كنت تبدأ بخطة مجانية أو تحتاج إلى ميزات متقدمة، نوفر لك الأدوات والدعم اللازمين لتوسيع نطاق تجارتك وزيادة مبيعاتك. اشترك اليوم واكتشف كيف يمكن لمنصتنا أن تأخذ عملك إلى المستوى التالي!</p>
      </div>

      <div class="row">

        <div class="col-lg-12 mt-12 mt-lg-0" data-aos="fade-up" data-aos-delay="200">
          <div class="box featured text-center">
            <h1>قريباً</h1>      
          </div>
        </div>

      </div>

    </div>
  </section><!-- End Pricing Section -->
@endsection