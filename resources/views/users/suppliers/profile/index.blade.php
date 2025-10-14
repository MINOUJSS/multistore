@extends('layouts.users.dashboard.app')

@section('google_analitics')
  {!!get_platform_data('google_analitics')->value!!}  
@endsection

@section('meta')
  <meta name="csrf-token" content="{{ csrf_token() }}">  
@endsection

@section('title')
  الصفحة الشخصية 
@endsection

@section('navbar')
    @include('users.suppliers.components.navbar.navbar')
@endsection

@section('sidbar')
    @include('users.suppliers.components.sidbar.sidbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
  @include('users.suppliers.components.content.profile.index')
@endsection

@section('footer_js')
@include('users.suppliers.components.content.profile.js.progress_bar_js')
@include('users.suppliers.components.content.profile.js.index_js');
@endsection