@extends('layouts.users.dashboard.app')

@section('google_analitics')
  {!!get_platform_data('google_analitics')->value!!}    
@endsection

@section('title')
  الصفحة تصميم المتجر
@endsection

@section('style')
    <style>
      #logoPreview
      {
        height: 100px;
        width:100px;
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
  @include('users.suppliers.components.content.store-design.index')
@endsection

@section('footer_js')
    @include('users.suppliers.components.content.store-design.index_js')
@endsection