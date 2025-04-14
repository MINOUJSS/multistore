<div class="container">
    <div class="page-title">
        <h2><i class="fa-regular fa-address-card"></i> تأكيد الإشتراك</h2>
        <p>إدارة المنتجات المتوفرة في المتجر</p>
    </div>
  
    <div class="card">
        {{-- <div class="card-header text-center">
            الخطة : {{get_supplier_plan_data(get_supplier_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->name }}
        </div> --}}
      <div class="card-body">
        {{-- <h5>الخصائص</h5> --}}
        <form id="regForm" action="{{route('supplier.payment.redirect')}}" method="POST">
          @csrf  
          <input type="hidden" name="payment_type" value="supplier_subscription">
          <input type="hidden" name="reference_id" value="{{get_supplier_data(auth()->user()->tenant_id)->id}}">
          <h1 class="text-center">تأكيد الإشتراك</h1>         
            <!-- One "tab" for each step in the form: -->
            <div class="tab" style="display:block">إختر الخطة المناسبة لك:
              {{-- <p><input class="form-control" placeholder="First name..." oninput="this.className = ''"></p> --}}
                @foreach ($plans as $plan)
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="plan" id="flexRadioDefault1" value="{{$plan->id}}" @if($plan->name == get_supplier_plan_data(get_supplier_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->name) checked @endif onclick="get_selected_plan();">
                    <label class="form-check-label" for="flexRadioDefault1">
                      الخطة {{ $plan->name }} -> السعر: ({{ $plan->price}}<sup>د.ج</sup>/الشهر)
                    </label>
                  </div>
                @endforeach
            </div>

            <div id="plan_pricing">
              <div id="plan-pricing-step" class="tab">نوع الإشتراك:
                <div id ="pricing-details">
                  <div class="form-check">
                    <input class="form-check-input" type="radio" name="plan_price" id="flexRadioDefault1" value="{{get_supplier_plan_data(get_supplier_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->price}}<sup>د.ج</sup>/شهر" checked onclick="print_plan_price();">
                    <label class="form-check-label" for="flexRadioDefault1">
                      {{ get_supplier_plan_data(get_supplier_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->price}}<sup>د.ج</sup>/شهر
                    </label>
                  </div>
                  @foreach (get_supplier_plan_data(get_supplier_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->pricing as $price)
                    <div class="form-check">
                      <input class="form-check-input" type="radio" name="plan_price" id="flexRadioDefault1" value="{{$price->price}}<sup>د.ج</sup>/{{ $price->duration}}" onclick="print_plan_price();">
                      <label class="form-check-label" for="flexRadioDefault1">
                        {{ $price->price}}<sup>د.ج</sup>/{{ $price->duration}}
                      </label>
                    </div>  
                  @endforeach
                </div>
             </div>
            </div>
            
            <div class="tab">طريقة الدفع:
              <div class="form-check">
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
            
            <div class="tab">معلومات الإشتراك:
            <div id="plan-name"><b>الخطة:{{get_supplier_plan_data(get_supplier_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->name}}</b></div>
            <div id="plan-price">{{get_supplier_plan_data(get_supplier_data(Auth::user()->tenant->id)->plan_subscription->plan_id)->price}}<sup>د.ج</sup>/الشهر</div>
            <div id="plan-fetures"></div>
            <div id="plan-duration"></div>
            <div id="plan-pay-method"> الدفع عن طريق البطاقة الذهبية أو CIB</div>
            <div id="plan-expiration-date"></div>
            </div>
            
            <div style="overflow:auto;">
              <div style="float:right;">
                <button class="btn btn-primary mb-3" type="button" id="prevBtn" onclick="nextPrev(-1)" style="display:none">السابق</button>
                <button class="btn btn-primary mb-3" type="button" id="nextBtn" onclick="nextPrev(1)">التالي</button>
              </div>
            </div>
            
            <!-- Circles which indicates the steps of the form: -->
            <div id="steps_indicator" style="text-align:center;margin-top:40px;">
              <span class="step"></span>
              <span class="step"></span>
              <span class="step"></span>
              <span class="step"></span>
            </div>
            
            </form>
      </div>
    </div>
</div>
