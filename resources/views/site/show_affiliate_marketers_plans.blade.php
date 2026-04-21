@extends('site.layouts.app')

@section('google_analitics')
{!!get_platform_data('google_analitics')->value!!}
@endsection

@section('hero')
@include('site.inc.header.header')
@endsection
@section('pricing')
    <!-- ======= Pricing Section ======= -->
<section id="pricing" class="pricing">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>الخطط والتسعير للمسوقين بالعمولة</h2>
        <p>ابدأ رحلتك معنا كمسوق بالعمولة واستفد من خططنا المرنة التي تناسب احتياجات عملك. سواء كنت تبدأ بخطة مجانية أو تحتاج إلى ميزات متقدمة، نوفر لك الأدوات والدعم اللازمين لتوسيع نطاق تجارتك وزيادة مبيعاتك. اشترك اليوم واكتشف كيف يمكن لمنصتنا أن تأخذ عملك إلى المستوى التالي!</p>
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