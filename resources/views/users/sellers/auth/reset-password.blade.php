@extends('layouts.users.guest')
@section('title')
    {{ __('auth.reset_password_title') }}
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
          <h5 class="text-center p-4">{{ __('auth.reset_password_heading') }}</h5>
          <form action="{{ route('seller.password.store') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">
            <div class="mb-3">
              <label for="exampleInputEmail1" class="form-label">{{ __('auth.email_address') }}</label>
              <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $request->email) }}" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="{{ __('auth.email_placeholder') }}" required autofocus>
              @error('email')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
              @enderror
            </div>
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
            <button type="submit" class="btn dz-btn-primary mb-3">{{ __('auth.reset_password_button') }}</button>
            <div class="text-center mt-3">
              <a href="{{ route('seller.login') }}" class="text-decoration-none fw-semibold small" style="color: #c10792;">
                <i class="fa fa-arrow-{{ app()->getLocale() == 'ar' ? 'right' : 'left' }}"></i>
                <span>{{ __('auth.sign_in') }}</span>
              </a>
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