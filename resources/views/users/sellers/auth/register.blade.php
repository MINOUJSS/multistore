@extends('layouts.users.guest')
@section('google_analitics')
@if(
          get_platform_data('google_analitics') &&
          get_platform_data('google_analitics')->status == 'active' &&
          !empty(get_platform_data('google_analitics')->value)
      )

      @php
          $measurementId = get_platform_data('google_analitics')->value;
      @endphp

      <script async src="https://www.googletagmanager.com/gtag/js?id={{ $measurementId }}"></script>

      <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
          dataLayer.push(arguments);
      }

      gtag('js', new Date());
      gtag('config', '{{ $measurementId }}');
      </script>

      @endif
@endsection
@section('clarity')
@if(
          get_platform_data('clarity') &&
          get_platform_data('clarity')->status == 'active' &&
          !empty(get_platform_data('clarity')->value)
      )

      @php
          $measurementId = get_platform_data('clarity')->value;
      @endphp
<script type="text/javascript">
    (function(c,l,a,r,i,t,y){
        c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
        t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
        y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "{{ $measurementId }}");
</script>
      @endif
@endsection
@section('title')
    {{ __('auth.seller_register_title') }}
@endsection
@section('content')
    <!--start sid-->
    <div class="col-md-6">
        <div class="dz-auth-box">
          <!-- Top Bar: Back Link & Language Switcher -->
          <div class="d-flex justify-content-between align-items-center mb-4">
            <a href="{{ route('site.index') }}" class="text-decoration-none text-muted small d-inline-flex align-items-center gap-1">
              <i class="fa fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
              <span>{{ __('auth.back_to_home') }}</span>
            </a>

            <!-- Language Switcher Dropdown -->
            <div class="dropdown">
              <button class="btn btn-sm lang-dropdown-btn rounded-pill px-3 py-1 d-inline-flex align-items-center gap-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa fa-globe text-secondary"></i>
                <span class="d-inline-flex align-items-center gap-1">
                  @if(app()->getLocale() == 'ar')
                    <span>🇩🇿</span> العربية
                  @elseif(app()->getLocale() == 'fr')
                    <span>🇫🇷</span> Français
                  @else
                    <span>🇬🇧</span> English
                  @endif
                </span>
                <i class="fa fa-chevron-down ms-1 text-muted" style="font-size: 0.65rem;"></i>
              </button>
              <ul class="dropdown-menu dropdown-menu-end lang-dropdown-menu shadow-sm">
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2 {{ app()->getLocale() == 'ar' ? 'active' : '' }}" href="{{ url('setlang/ar') }}">
                    <span>🇩🇿</span> العربية
                  </a>
                </li>
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2 {{ app()->getLocale() == 'fr' ? 'active' : '' }}" href="{{ url('setlang/fr') }}">
                    <span>🇫🇷</span> Français
                  </a>
                </li>
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2 {{ app()->getLocale() == 'en' ? 'active' : '' }}" href="{{ url('setlang/en') }}">
                    <span>🇬🇧</span> English
                  </a>
                </li>
              </ul>
            </div>
          </div>

          <div class="logo-box text-center">
            <img src="{{asset('asset/v1/site/defaulte')}}/img/logo.png" width="50" height="50" alt="logo">
          </div>
          <h5 class="text-center p-4">{{ __('auth.create_seller_account') }}</h5>
          <form method="POST" action="{{ route('seller.register') }}">
            @csrf
            <input type="hidden" name="type" value="seller">
            <input type="hidden" name="plan" value="{{$plan}}">
            @if ($sub_plan_data)
            <input type="hidden" name="sub_plan_id" value="{{$sub_plan_data->id}}"> 
            @endif

            <div class="mb-3">
                <label for="full_name" class="form-label">{{ __('auth.full_name') }}</label>
                <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" value="{{old('full_name')}}" placeholder="{{ __('auth.full_name_placeholder') }}" required >
                @error('full_name')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">{{ __('auth.email_address') }}</label>
              <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" aria-describedby="emailHelp" placeholder="{{ __('auth.email_placeholder') }}" required>
              @error('email')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">{{ __('auth.phone_number') }}</label>
                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{old('phone')}}" placeholder="{{ __('auth.phone_placeholder') }}" required onkeypress="return event.charCode>=48 && event.charCode<=57" maxlength="10">
                @error('phone')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            @livewire('seller-store-validator')
            <div class="mb-3">
              <label for="password" class="form-label">{{ __('auth.password_label') }}</label>
              <div class="input-group mb-3">
              <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="{{ __('auth.password_placeholder') }}" required>
              <button class="btn btn-outline-secondary" type="button" id="togglePassword"><i class="fa fa-eye-slash"></i></button>
              </div>
              @error('password')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <div class="mb-3">
                <label for="password_confirmation" class="form-label">{{ __('auth.password_confirmation_label') }}</label>
                <div class="input-group mb-3">
                <input type="password" id="confirmPassword" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="{{ __('auth.password_confirmation_placeholder') }}" required>
                <button class="btn btn-outline-secondary" type="button" id="toggleconfirmPassword"><i class="fa fa-eye-slash"></i></button>
                </div>
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" name="terms" class="form-check-input" style="border:1px solid #8f036c;" id="terms">
              <label class="form-check-label" for="terms">{{ __('auth.agree_to') }} <a href="{{route('site.privacy_policy')}}" class="text-decoration-none fw-semibold" style="color: #c10792;">{{ __('auth.privacy_policy') }}</a></label>
              @error('terms')
              <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
            <button type="submit" class="btn dz-btn-primary mb-3">{{ __('auth.continue') }}</button>
            <div class="text-center mt-2">
                <span class="text-muted small">{{ __('auth.already_have_account') }}</span>
                <a href="{{route('seller.login')}}" class="text-decoration-none fw-semibold small ms-1" style="color: #c10792;">{{ __('auth.sign_in') }}</a>
            </div>
          </form>
        </div>
      </div>
      <!--end rigth sid-->
      <!--start left sid-->
      <div class="col-md-6 dz-auth-bg d-none d-sm-block d-sm-none d-md-block">
        <div class="dz-center-box">
          <div class="logo-box">
            <img src="{{asset('asset/v1/site/defaulte')}}/img/logo.png" width="50" height="50" alt="logo">
            {{config('app.name')}}
          </div>
          <!---->
          <div class="" bis_skin_checked="1">
            <h3 class="text-white text-3xl font-bold">{{ __('auth.hero_title') }}</h3>
            <p class="dz-text-sm dz-text-color-gris">{{ __('auth.hero_description') }}</p>
            {{-- <div class="flex items-center -space-x-2 overflow-hidden" bis_skin_checked="1">
              <img src="https://randomuser.me/api/portraits/women/79.jpg" class="rounded-full">
              <img src="https://api.uifaces.co/our-content/donated/xZ4wg2Xj.jpg" class="rounded-full">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=faces&amp;fit=crop&amp;h=200&amp;w=200&amp;s=a72ca28288878f8404a795f39642a46f" class="rounded-full">
              <img src="https://randomuser.me/api/portraits/men/86.jpg" class="rounded-full">
              <img src="https://images.unsplash.com/photo-1510227272981-87123e259b17?ixlib=rb-0.3.5&amp;q=80&amp;fm=jpg&amp;crop=faces&amp;fit=crop&amp;h=200&amp;w=200&amp;s=3759e09a5b9fbe53088b23c615b6312e" class="rounded-full">
              <p class="dz-text-sm dz-float-right dz-text-color-gris">انضم إلى19181+ تاجر</p>
            </div> --}}
          </div>
          <!---->
        </div>
      </div>
      <!--end left side-->
@endsection

@section('footer_js')
    @include('users.sellers.auth.js.show_password_js')
     @include('users.sellers.auth.js.show_confirm_password_js')
@endsection