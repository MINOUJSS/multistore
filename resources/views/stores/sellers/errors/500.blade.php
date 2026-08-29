@extends('layouts.users.store.app')

@section('title')
    {{ tenant('domain') }} | 500 - خطأ في المتجر
@endsection

@section('style')
    @if (function_exists('tenant') && tenant() && function_exists('has_seller_settings') && has_seller_settings(tenant('id')))
        @include('stores.sellers.theme.all')
    @endif
    <style>
        .store-error-box {
            border: 1px solid rgba(0, 0, 0, 0.07) !important;
            border-radius: 1.25rem !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04) !important;
            background: #ffffff;
        }
        .store-error-icon-wrapper {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: rgba(220, 53, 69, 0.08);
        }
    </style>
@endsection

@section('navbar')
    @include('stores.sellers.components.navbar.navbar')
@endsection

@section('cart')
    @include('stores.sellers.components.cart.v1.cart')
@endsection

@section('content')
<div class="col-12 py-5 my-md-4">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-12 col-md-9 col-lg-7">
                <div class="card p-4 p-md-5 store-error-box">
                    <div class="mb-4">
                        <div class="store-error-icon-wrapper shadow-xs">
                            <i class="fa-solid fa-triangle-exclamation fs-1 text-danger"></i>
                        </div>
                    </div>

                    <div class="d-inline-block mx-auto mb-3">
                        <span class="badge bg-danger text-white px-3 py-1.5 rounded-pill fw-bold" style="font-size: 0.85rem;">
                            خطأ 500
                        </span>
                    </div>

                    <h2 class="fw-bold mb-3 title fs-3">عذراً، حدث خطأ غير متوقع!</h2>
                    <p class="text-muted mb-4 fs-6 leading-relaxed">
                        نواجه صعوبة مؤقتة في معالجة طلبك داخل المتجر. يرجى إعادة المحاولة بعد قليل أو العودة للصفحة الرئيسية.
                    </p>

                    <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center">
                        <button onclick="window.location.reload()" class="btn btn-primary fw-bold px-4 py-2.5 rounded-pill shadow-sm">
                            <i class="fa-solid fa-rotate-right me-1"></i> إعادة المحاولة
                        </button>
                        <a href="{{ route('tenant.store') }}" class="btn btn-outline-primary px-4 py-2.5 rounded-pill">
                            <i class="fa-solid fa-house me-1"></i> الرئيسية
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_js')
    @include('stores.sellers.components.navbar.js.navbar_js');
@endsection
