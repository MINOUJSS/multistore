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
            <form action="{{url(request()->server('REQUEST_SCHEME').'://'.request()->server('HTTP_HOST').'/seller-panel/register')}}" method="GET">
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
            {{-- <form action="{{url(request()->server('REQUEST_SCHEME').'://'.request()->server('HTTP_HOST').'/seller-panel/register')}}" method="GET"> --}}
              {{-- @csrf --}}
              <input type="hidden" name="plan" value="{{$plan->name}}">
              <input type="submit" value="إبداء الآن" class="buy-btn">
            </form>
          </div>
        </div>
        @endforeach
@endsection