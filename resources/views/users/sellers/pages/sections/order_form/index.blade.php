@extends('layouts.users.dashboard.app')

@section('google_analitics')
    {!! get_platform_data('google_analitics')->value !!}
@endsection

@section('meta')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('title')
    قسم فورم الطلب
@endsection

@section('style')
    <style>
        #logoPreview {
            height: 100px;
            width: 100px;
        }

        #dropzone {
            height: 100px;
            width: 100px;
            cursor: pointer;
            border: 2px dashed #706c6cfd;
            border-radius: 5px;
            align-content: center;
            text-align: center;
        }

        /*----------*/
        .order-form {
            border: 1px solid {{ get_store_parimary_color(auth()->user()->tenant_id) }} !important;
            box-shadow: 0 0 5px {{ get_store_parimary_color(auth()->user()->tenant_id) }} !important;
        }

        .form-btn-primary {
            border: 1px solid {{ get_store_parimary_color(auth()->user()->tenant_id) }} !important;
            background-color: {{ get_store_parimary_color(auth()->user()->tenant_id) }} !important;
            color: {{ get_store_footer_text_color(auth()->user()->tenant_id) }} !important;
        }

        .form-btn-primary:hover {
            box-shadow: 0 0 5px {{ get_store_parimary_color(auth()->user()->tenant_id) }} !important;
            background-color: {{ get_store_parimary_color(auth()->user()->tenant_id) }} !important;
        }

        .form-select {
            border: 1px solid {{ get_store_parimary_color(auth()->user()->tenant_id) }} !important;
        }

        .form-select:focus {
            box-shadow: 0 0 5px {{ get_store_parimary_color(auth()->user()->tenant_id) }} !important;
        }

        .form-input,
        .form-textarea {
            border: 1px solid {{ get_store_parimary_color(auth()->user()->tenant_id) }} !important;
        }

        .form-input.form-control:focus,
        .form-textarea:focus {
            box-shadow: 0 0 5px {{ get_store_parimary_color(auth()->user()->tenant_id) }} !important;
        }

        .form-btn {
            border: 1px solid {{ get_store_parimary_color(auth()->user()->tenant_id) }} !important;
        }

        /*----------*/
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
    @include('users.sellers.components.content.pages.sections.order_form.index')
@endsection

@section('footer_js')
    @include('users.sellers.components.content.pages.sections.order_form.js.index_js')
    @include('users.sellers.components.content.pages.sections.order_form.js.controller_js')
    @include('users.sellers.components.content.pages.sections.order_form.js.submitform_js')
@endsection
