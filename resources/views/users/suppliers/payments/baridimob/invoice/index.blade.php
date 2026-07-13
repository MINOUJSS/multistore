@extends('layouts.users.dashboard.app')

{{-- @section('css')
    <link rel="stylesheet" href="{{asset('asset/users/dashboard')}}/css/order-plan-step.css">
@endsection --}}

{{-- @section('header_js')
    <script type="text/javascript" src="{{asset('asset/users/dashboard')}}/js/order-plan-step.js"></script>
@endsection --}}
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

@section('title')
    الدفع عن طريق البطاقة الذهبية أو CIB
@endsection

@section('sidbar')
    @include('users.suppliers.components.sidbar.sidbar')
@endsection

@section('navbar')
    @include('users.suppliers.components.navbar.navbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
 @include('users.suppliers.components.content.payments.baridimob.invoice.index')
@endsection