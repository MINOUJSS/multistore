@extends('layouts.users.guest')
@section('title')
    تسجيل مورد جديد
@endsection
@section('content')
    <!--start sid-->
    <div class="col-md-6">
        <div class="dz-auth-box">
          <div class="logo-box text-center">
            <img src="{{asset('asset/v1/users/auth')}}/img/logo/store.png" width="50" height="50" alt="logo">
          </div>
          <h5 class="text-center p-4">إنشاء حساب مورد جديد</h5>
          <form method="POST" action="{{ route('supplier.register') }}">
            @csrf
            <input type="hidden" name="type" value="supplier">
            <input type="hidden" name="plan" value="{{$plan}}">
            @if ($sub_plan_data)
            <input type="hidden" name="sub_plan_id" value="{{$sub_plan_data->id}}"> 
            @endif

            <div class="mb-3">
                <label for="full_name" class="form-label">الإسم الكامل</label>
                <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{old('full_name')}}" placeholder="كمل نور الدين" required >
                @error('full_name')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">البريد الإكتروني</label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" aria-describedby="emailHelp" placeholder="email@example.com" required>
              <!-- <div id="emailHelp" class="form-text">لن ن.</div> -->
              @error('email')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">رقم الهاتف</label>
                <input type="tel"  name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}" placeholder="0660000000" required onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="10">
                @error('phone')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            @livewire('supplier-store-validator')
            <div class="mb-3">
              <label for="password" class="form-label">كلمة المرور</label>
              <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="كلمة المرور" required>
              @error('password')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="تأكيد كلمة المرور" required>
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" name="terms" class="form-check-input">
              <label class="form-check-label" for="terms">أوافق على <a href="#">السياسة الخصوصية</a></label>
              @error('terms')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <button type="submit" class="btn dz-btn-primary mb-3">متابعة</button>
            <div class="mb-3 form-check">
                <label class="form-check-label" for="exampleCheck1">لديك حساب على منصتنا؟<a href="{{route('supplier.login')}}">سجل الدخول</a></label>
              </div>
          </form>
        </div>
      </div>
      <!--end rigth sid-->
      <!--start left sid-->
      <div class="col-md-6 dz-auth-bg d-none d-sm-block d-sm-none d-md-block">
        <div class="dz-center-box">
          <div class="logo-box">
            <img src="{{asset('asset/v1/users/auth')}}/img/logo/store.png" width="50" height="50" alt="logo">
            Matajer dz
          </div>
          <!---->
          <div class="" bis_skin_checked="1">
            <h3 class="text-white text-3xl font-bold">ابدأ في تنمية عملك بسرعة</h3>
            <p class="dz-text-sm dz-text-color-gris">قم بإنشاء متجر إلكتروني وتمتع بالوصول إلى جميع الميزات مدى الحياة ، لا يلزم وجود بطاقة ائتمان.</p>
            <div class="flex items-center -space-x-2 overflow-hidden" bis_skin_checked="1">
              <img src="https://randomuser.me/api/portraits/women/79.jpg" class="rounded-full">
              <img src="https://api.uifaces.co/our-content/donated/xZ4wg2Xj.jpg" class="rounded-full">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=faces&amp;fit=crop&amp;h=200&amp;w=200&amp;s=a72ca28288878f8404a795f39642a46f" class="rounded-full">
              <img src="https://randomuser.me/api/portraits/men/86.jpg" class="rounded-full">
              <img src="https://images.unsplash.com/photo-1510227272981-87123e259b17?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=faces&amp;fit=crop&amp;h=200&amp;w=200&amp;s=3759e09a5b9fbe53088b23c615b6312e" class="rounded-full">
              <p class="dz-text-sm dz-float-right dz-text-color-gris">انضم إلى19181+ تاجر</p>
            </div>
          </div>
          <!---->
        </div>
      </div>
      <!--end left side-->
@endsection