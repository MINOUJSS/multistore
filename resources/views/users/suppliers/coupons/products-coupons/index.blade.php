@extends('layouts.users.dashboard.app')

@section('google_analitics')
  {!!get_platform_data('google_analitics')->value!!}    
@endsection
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
<!-- Modal css -->
<link rel="stylesheet" href="{{ asset('asset/v1/users/dashboard/css/modal.css') }}" />
<!-- Include stylesheet -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
@endsection
@section('title')
  الصفحة ربط الكوبونات بالمنتجات
@endsection

@section('style')
    <style>
      #logoPreview
      {
        height: 100px !important;
        width:100px !important;
      }
      #add_logoPreview
      {
        height: 100px !important;
        width:100px !important;
      }
      #dropzone {
        height: 100px;
        width:100px;
        cursor: pointer;
        border: 2px dashed #706c6cfd;
        border-radius: 5px;
        align-content: center;
        text-align: center;
      }
      #add_dropzone {
        height: 100px;
        width:100px;
        cursor: pointer;
        border: 2px dashed #706c6cfd;
        border-radius: 5px;
        align-content: center;
        text-align: center;
      }
      .dropzone {
        height: 100px;
        width:100%;
        cursor: pointer;
        border: 2px dashed #706c6cfd;
        border-radius: 5px;
        align-content: center;
        text-align: center;
      }
      .add_dropzone {
        height: 100px;
        width:100%;
        cursor: pointer;
        border: 2px dashed #706c6cfd;
        border-radius: 5px;
        align-content: center;
        text-align: center;
      }
    </style>
@endsection

@section('navbar')
    @include('users.suppliers.components.navbar.navbar')
@endsection

@section('sidbar')
    @include('users.suppliers.components.sidbar.sidbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
  @include('users.suppliers.components.content.coupons.products-coupons.index')
@endsection

@section('footer_js')
    @include('users.suppliers.components.content.coupons.js.coupon_js')
@endsection