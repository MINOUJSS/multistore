<div class="container">
    <div class="page-title">
        <h2><i class="fa-regular fa-address-card"></i> تأكيد الإشتراك</h2>
        <p>إدارة المنتجات المتوفرة في المتجر</p>
    </div>
  
    <div class="card">
        {{-- <div class="card-header text-center">
            الخطة : {{get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->name }}
        </div> --}}
      <div class="card-body">
        {{-- <h5>الخصائص</h5> --}}
        <form id="regForm" action="{{route('seller.payment.redirect')}}" method="POST">
          @csrf  
          <h1 class="text-center">تأكيد الإشتراك</h1>         
            <!-- One "tab" for each step in the form: -->
            <div class="tab" style="display:block">إختر الخطة المناسبة لك:
              {{-- <p><input class="form-control" placeholder="First name..." oninput="this.className = ''"></p> --}}
              <div class="mt-3"></div>  
              @foreach ($plans as $plan)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="plan" id="flexRadioDefault1" value="{{$plan->id}}" @if($plan->name == get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->name) checked @endif onclick="get_selected_plan();remiz_a_zero_sub_plan_id();get_plan_authorizations({{$plan->id}})">
                    <label class="form-check-label" for="flexRadioDefault1">
                      الخطة {{ $plan->name }} -> السعر: ({{ $plan->price}}<sup>د.ج</sup>/{{$plan->price==0? 'مدى الحياة ' : '30 يوم'}})
                    </label>
                  </div>
                @endforeach
            </div>
            <div id="plan_pricing">
              <div id="plan-pricing-step" class="tab">نوع الإشتراك:
                <div class="mt-3" id ="pricing-details">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="plan_price" id="flexRadioDefault1" data-sub-plan-id="0" value="{{get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->price}}<sup>د.ج</sup>/شهر" checked onclick="print_plan_price();">
                    <input type="hidden" name="pre_sub_plan_id" value="0">
                    {{-- <input class="form-check-input" type="radio" name="sub_plan_id" id="flexRadioDefault1" value="{{get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->id}}<sup>د.ج</sup>/شهر" checked onclick="print_plan_price();"> --}}                    <label class="form-check-label" for="flexRadioDefault1">
                      <label class="form-check-label" for="flexRadioDefault1">
                      {{ get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->price}}<sup>د.ج</sup>/30 يوم
                    </label>
                  </div>
                  @foreach (get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->pricing as $index => $price)
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="plan_price" id="flexRadioDefault1" data-sub-plan-id="{{$price->id}}" value="{{$price->price}}<sup>د.ج</sup>/{{ $price->duration}} يوم" @if($price->duration == get_seller_data(Auth::user()->tenant->id)->plan_subscription->duration) checked @endif onclick="print_plan_price();">
                      <input type="hidden" name="pre_sub_plan_id" value="{{$price->id}}">
                      {{-- <input type="hidden" name="sub_plan_id" value="{{get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->id}}"> --}}
                      <label class="form-check-label" for="flexRadioDefault1">
                        {{ $price->price}}<sup>د.ج</sup>/{{ $price->duration}} يوم
                      </label>
                    </div>  
                  @endforeach
                </div>
             </div>
            </div>
            
            <div id="payment-method-step" class="tab">طريقة الدفع:
              <div id="non_methode" style="display:none">
                <p>لقد إخترت الخطة المجانية لذالك لا يمكنك إختيار طريقة للدفع.</p>
              </div>
              <div id="the_methods" style="display:block">
                <div class="form-check mt-3">
                  <input class="form-check-input" type="radio" name="pay_method" id="pay_method" value="algerian_credit_card" checked onclick="print_payment_method();">
                  <label class="form-check-label" for="pay_method">
                    الدفع عن طريق البطاقة الذهبية أو CIB
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="pay_method" id="pay_method" value="baridimob" onclick="print_payment_method();">
                  <label class="form-check-label" for="pay_method">
                    الدفع عن طريق تطبيق بريدي موب
                  </label>
                </div> 
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="pay_method" id="pay_method" value="ccp" onclick="print_payment_method();">
                  <label class="form-check-label" for="pay_method">
                    الدفع عن طريق بريد الجزائر CCP
                  </label>
                </div> 
              </div>
            </div>
            
            <div id="subscription_info" class="tab">معلومات الإشتراك:
            <div class="mt-3" id="plan-name"><b>الخطة:{{get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->name}}</b></div>
            <div id="plan-price">{{get_seller_plan_data(get_seller_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->price}}<sup>د.ج</sup>/{{get_seller_data(Auth::user()->tenant->id)->plan_subscription->duration}} يوم</div>
            <div id="plan-authorizations"></div>
            <div id="plan-duration"></div>
            <div id="plan-pay-method"> الدفع عن طريق البطاقة الذهبية أو CIB</div>
            <div id="plan-expiration-date"></div>
            </div>
            
            <div class="m-4" style="overflow:auto;">
              <div style="float:right;">
                <button class="btn btn-primary mb-3" type="button" id="prevBtn" onclick="nextPrev(-1)" style="display:none">السابق</button>
                <button class="btn btn-primary mb-3" type="button" id="nextBtn" onclick="nextPrev(1)">التالي</button>
              </div>
            </div>
            
            <!-- Circles which indicates the steps of the form: -->
            <div id="steps_indicator" style="text-align:center;margin-top:40px;">
              <span class="step active"></span>
              <span class="step"></span>
              <span class="step"></span>
              <span class="step"></span>
            </div>  
            <input id="sub_plan_id" type="hidden" name="sub_plan_id" value="0"/>        
            </form>
      </div>
    </div>
</div>
