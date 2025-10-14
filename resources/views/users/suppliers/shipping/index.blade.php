@extends('layouts.users.dashboard.app')

@section('google_analitics')
  {!!get_platform_data('google_analitics')->value!!}    
@endsection

@section('style')
@include('users.suppliers.components.content.shipping.css.style')
@endsection

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
  الصفحة الشحن
@endsection

@section('navbar')
    @include('users.suppliers.components.navbar.navbar')
@endsection

@section('sidbar')
    @include('users.suppliers.components.sidbar.sidbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
  @include('users.suppliers.components.content.shipping.index')
@endsection

@section('footer_js')
    @include('users.suppliers.components.content.shipping.js.yalidin_js')
    @include('users.suppliers.components.content.shipping.js.zrexpress_js')
    @include('users.suppliers.components.content.shipping.js.dhd_js')
    @include('users.suppliers.components.content.shipping.js.maystro_js')
    @include('users.suppliers.components.content.shipping.js.delete_company_js')
@endsection