@extends('layouts.users.store.app')

@section('title')
    {{ tenant('domain') }} | 403 - الوصول محظور
@endsection

@section('style')
    @if (function_exists('tenant') && tenant() && function_exists('has_supplier_settings') && has_supplier_settings(tenant('id')))
        @include('stores.suppliers.theme.all')
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
            background-color: rgba(255, 193, 7, 0.12);
        }
    </style>
@endsection

@section('navbar')
    @include('stores.suppliers.components.navbar.navbar')
@endsection

@section('cart')
    @include('stores.suppliers.components.cart.v1.cart')
@endsection

@section('content')
<div class="col-12 py-5 my-md-4">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-12 col-md-9 col-lg-7">
                <div class="card p-4 p-md-5 store-error-box">
                    <div class="mb-4">
                        <div class="store-error-icon-wrapper shadow-xs">
                            <i class="fa-solid fa-lock fs-1 text-warning"></i>
                        </div>
                    </div>

                    <div class="d-inline-block mx-auto mb-3">
                        <span class="badge bg-warning text-dark px-3 py-1.5 rounded-pill fw-bold" style="font-size: 0.85rem;">
                            خطأ 403
                        </span>
                    </div>

                    <h2 class="fw-bold mb-3 title fs-3">غير مصرح بالوصول إلى هذا المحتوى!</h2>
                    <p class="text-muted mb-4 fs-6 leading-relaxed">
                        لا تملك الصلاحيات المطلوبة لعرض هذه الصفحة أو هذا القسم في متجر التوريد.
                    </p>

                    <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center">
                        <a href="{{ route('tenant.store') }}" class="btn btn-primary fw-bold px-4 py-2.5 rounded-pill shadow-sm">
                            <i class="fa-solid fa-house me-1"></i> العودة للمتجر
                        </a>
                        <a href="{{ route('tenant.products') }}" class="btn btn-outline-primary px-4 py-2.5 rounded-pill">
                            <i class="fa-solid fa-boxes-stacked me-1"></i> الكتالوج
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer_js')
    @include('stores.suppliers.components.navbar.js.navbar_js');
@endsection
