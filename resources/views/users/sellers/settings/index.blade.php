@extends('layouts.users.dashboard.app')

@section('google_analitics')
  {!!get_platform_data('google_analitics')->value!!}    
@endsection

@section('title')
  الصفحة الإعدادات
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
    @include('users.sellers.components.navbar.navbar')
@endsection

@section('sidbar')
    @include('users.sellers.components.sidbar.sidbar')
@endsection

@section('content')
{{-- Your Content Here   --}}
  @include('users.sellers.components.content.settings.index')
@endsection

@section('footer_js')
    @include('users.sellers.components.content.settings.js.store_design_js')
    @include('users.sellers.components.content.settings.js.quill_editor_js')
@endsection