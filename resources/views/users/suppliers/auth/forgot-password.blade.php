@extends('layouts.users.guest')
@section('title')
إستعادة كلمة المرور
@endsection
@section('content')
    <!--start sid-->
    <div class="col-md-6">
        <div class="dz-auth-box">
          <div class="logo-box text-center">
            <img src="{{asset('asset/v1/users/auth')}}/img/logo/store.png" width="50" height="50" alt="logo">
          </div>
          <h5 class="text-center p-4">إستعادة كلمة المرور</h5>
          <div>
            @if (session('status'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>{{ session('status') }}</strong>.
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>  
            @endif
          </div>
          <form action="{{ route('supplier.password.email') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="email" class="form-label">البريد الإكتروني</label>
                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" aria-describedby="emailHelp" placeholder="email@example.com" required autofocus>
                <!-- <div id="emailHelp" class="form-text">لن ن.</div> -->
                @error('email')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            <button type="submit" class="btn dz-btn-primary">متابعة</button>
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