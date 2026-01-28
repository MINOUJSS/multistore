@extends('layouts.users.dashboard.app')

@section('google_analitics')
  {!!get_platform_data('google_analitics')->value!!}    
@endsection

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
  tiktok pixel 
@endsection

@section('navbar')
    @include('users.sellers.components.navbar.navbar')
@endsection

@section('sidbar')
    @include('users.sellers.components.sidbar.sidbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
  @include('users.sellers.components.content.apps.tiktok_pixel.index')
@endsection

@section('footer_js')
@include('users.sellers.components.content.apps.tiktok_pixel.js.store_pixel_js')
@include('users.sellers.components.content.apps.tiktok_pixel.js.update_pixel_js')
@include('users.sellers.components.content.apps.tiktok_pixel.js.delete_pixel_js')
@endsection