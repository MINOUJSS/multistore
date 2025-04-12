@extends('layouts.users.dashboard.app')

@section('google_analitics')
  {!!get_platform_data('google_analitics')->value!!}    
@endsection

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
  الصفحة التطبيقات
@endsection

@section('navbar')
    @include('users.suppliers.components.navbar.navbar')
@endsection

@section('sidbar')
    @include('users.suppliers.components.sidbar.sidbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
  @include('users.suppliers.components.content.apps.index')
@endsection

@section('footer_js')
    {{-- @include('users.suppliers.components.content.apps.js.google_analytics_js')
    @include('users.suppliers.components.content.apps.js.facebook_pixel_js') --}}
@endsection