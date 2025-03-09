@extends('layouts.users.dashboard.app')

@section('google_analitics')
  {!!get_platform_data('google_analitics')->value!!}    
@endsection
@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('css')
<!-- Modal css -->
<link rel="stylesheet" href="{{ asset('asset/users/dashboard/css/modal.css') }}" />
<!-- Include stylesheet -->
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
@endsection
@section('title')
  الصفحة المنتجات
@endsection

@section('style')
    <style>
      #logoPreview
      {
        height: 100px;
        width:100px;
      }
      #add_logoPreview
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
  @include('users.suppliers.components.content.products.index')
@endsection

@section('footer_js')
@include('users.suppliers.components.content.products.js.multi-upload-image-js')
@include('users.suppliers.components.content.products.js.quill-editor-js')
@include('users.suppliers.components.content.products.js.edit-product-btn-action-js')
@include('users.suppliers.components.content.products.js.add-product-variation-js')
@include('users.suppliers.components.content.products.js.add-product-discount-js')
@include('users.suppliers.components.content.products.js.validate-and-update-edite-product-modal-js')
@include('users.suppliers.components.content.products.js.single-upload-image-js')
@include('users.suppliers.components.content.products.js.show-product-attribute-js')
@include('users.suppliers.components.content.products.js.add-product-attribute-js')
@include('users.suppliers.components.content.products.js.delete-product-js')
@include('users.suppliers.components.content.products.js.save-product-js')
@endsection