@extends('layouts.users.dashboard.app')

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

@section('meta')
  <meta name="csrf-token" content="{{ csrf_token() }}">  
@endsection

@section('title')
  الصفحة الشخصية 
@endsection

@section('navbar')
    @include('users.sellers.components.navbar.navbar')
@endsection

@section('sidbar')
    @include('users.sellers.components.sidbar.sidbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
  @include('users.sellers.components.content.profile.index')
@endsection

@section('footer_js')
@include('users.sellers.components.content.profile.js.progress_bar_js')
@include('users.sellers.components.content.profile.js.index_js');
@endsection