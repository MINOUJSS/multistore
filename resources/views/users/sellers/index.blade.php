@extends('layouts.users.dashboard.app')

@section('google_analitics')
  {!!get_platform_data('google_analitics')->value!!}  
@endsection

@section('title')
  الصفحة الرئيسية
@endsection

@section('navbar')
    @include('users.sellers.components.navbar.navbar')
@endsection

@section('sidbar')
    @include('users.sellers.components.sidbar.sidbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
  @include('users.sellers.components.content.dashboard.index')
@endsection

@section('footer_js')
    @include('users.sellers.components.content.dashboard.js.chart_js')
    @include('users.sellers.components.content.dashboard.js.visitors_chart_js')
@endsection