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
          <img src="{{asset('asset/site/defaulte')}}/img/hero-img.png" class="img-fluid animated" alt="">
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
        <h2>الخطط والتسعير للموردين وتجار الجملة</h2>
        <p>ابدأ رحلتك معنا كمورد أو تاجر جملة واستفد من خططنا المرنة التي تناسب احتياجات عملك. سواء كنت تبدأ بخطة مجانية أو تحتاج إلى ميزات متقدمة، نوفر لك الأدوات والدعم اللازمين لتوسيع نطاق تجارتك وزيادة مبيعاتك. اشترك اليوم واكتشف كيف يمكن لمنصتنا أن تأخذ عملك إلى المستوى التالي!</p>
      </div>

      <div class="row">
        @foreach ($plans as $plan)
        @php
        // مميزات الخطة مع حالة التوافر
        $authorizations = $plan->Authorizations;
        $pricing=$plan->pricing;
        @endphp
        <div class="col-lg-4 " data-aos="fade-up" data-aos-delay="100">
          <div class="box p-2">
            <form action="{{url(request()->server('REQUEST_SCHEME').'://supplier.'.request()->server('HTTP_HOST').'/supplier-panel/register')}}" method="GET">
            @if ($pricing->count() > 0)
            <h3>الخطة {{$plan->name}}</h3>
            <h4>{{$plan->price}}<sup>د.ج</sup><span>في الشهر</span></h4>
            <hr>
            <h5 class="text-center">عروض الخطة</h5>
            <ul class="list-group">
                <li class="list-group-item d-flex align-items-center justify-content-between subscription-option">
                    <label class="mb-0 w-100 cursor-pointer">
                        <input type="radio" name="sub_plan_id" value="0" checked class="form-check-input me-2">
                        <span>{{ $plan->price }}<sup> د.ج</sup> / 30 يوم</span>
                    </label>
                </li>
                @foreach ($pricing as $price)
                    <li class="list-group-item d-flex align-items-center justify-content-between subscription-option">
                        <label class="mb-0 w-100 cursor-pointer">
                            <input type="radio" name="sub_plan_id" value="{{ $price->id }}" class="form-check-input me-2">
                            <span>{{ $price->price }}<sup> د.ج</sup> / {{ $price->duration }} يوم</span>
                        </label>
                    </li>
                @endforeach
            </ul>
            <hr>
            @else
            <h3>الخطة {{$plan->name}}</h3>
                @if ($plan->id==1)
                <h4>{{$plan->price}}<sup>د.ج</sup><span>مدى الحياة </span></h4>
                @else
                <h4>{{$plan->price}}<sup>د.ج</sup><span>في الشهر</span></h4>
                @endif
                <hr>
            @endif            
            <ul>
              @foreach ($authorizations as $authorization)
                @if($authorization['is_enabled'])
                <li><i class="bx bx-check"></i> {{$authorization['description']}}</li>
                @else
                <li class="na"><i class="bx bx-x"></i> <span> {{$authorization['description']}}</span></li>
                @endif 
              @endforeach

            </ul>
            {{-- <a href="#" class="buy-btn">إبدأ الآن</a> --}}
            {{-- <form action="{{url(request()->server('REQUEST_SCHEME').'://supplier.'.request()->server('HTTP_HOST').'/supplier-panel/register')}}" method="GET"> --}}
              {{-- @csrf --}}
              <input type="hidden" name="plan" value="{{$plan->name}}">
              <input type="submit" value="إبداء الآن" class="buy-btn">
            </form>
          </div>
        </div>
        @endforeach
        

        {{-- <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="200">
          <div class="box featured">
            <h3>الخطة المتقدمة</h3>
            <h4>2500<sup>د.ج</sup><span>في الشهر</span></h4>
            <ul>
                <li><i class="bx bx-check"></i> متجر إلكتروني إحترافي</li>
                <li><i class="bx bx-check"></i> إضافة حتى 200 منتج</li>
                <li><i class="bx bx-check"></i> إدارة الطلبات والمخزون</li>
                <li><i class="bx bx-check"></i>طلبات غير محدودة</li>
                <li><i class="bx bx-check"></i> خيار الدفع عن الإستلام فقط</li>
                <li class="na"><i class="bx bx-x"></i> <span>الدفع بالبطاقة الذهبية و CIB</span></li>
                <li class="na"><i class="bx bx-x"></i> <span> دومين خاص</span></li>
                <li class="na"><i class="bx bx-x"></i> <span>حقوق النشر</span></li>
            </ul>
            <a href="#" class="buy-btn">إبدأ الآن</a>
          </div>
        </div>

        <div class="col-lg-4 mt-4 mt-lg-0" data-aos="fade-up" data-aos-delay="300">
          <div class="box">
            <h3>الخطة الاحترافية</h3>
            <h4>5000<sup>د.ج</sup><span>في الشهر</span></h4>
            <ul>
                <li><i class="bx bx-check"></i> متجر إلكتروني إحترافي</li>
                <li><i class="bx bx-check"></i> إضافة مالانهاية من المنتجات</li>
                <li><i class="bx bx-check"></i> إدارة الطلبات والمخزون</li>
                <li><i class="bx bx-check"></i>طلبات غير محدودة</li>
                <li><i class="bx bx-check"></i> خيارات دفع متعددة وآمنة</li>
                <li><i class="bx bx-check"></i> <span>الدفع بالبطاقة الذهبية و CIB</span></li>
                <li><i class="bx bx-check"></i> <span> دومين خاص</span></li>
                <li><i class="bx bx-check"></i> <span>حقوق النشر</span></li>
            </ul>
            <a href="#" class="buy-btn">إبدأ الآن</a>
          </div>
        </div> --}}

      </div>

    </div>
  </section><!-- End Pricing Section -->
@endsection