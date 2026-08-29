@extends('layouts.users.store.app')

@section('title')
    {{ tenant('domain') }} | 419 - انتهت صلاحية الجلسة
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
            background-color: rgba(13, 110, 253, 0.08);
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
                            <i class="fa-solid fa-clock-rotate-left fs-1 text-primary"></i>
                        </div>
                    </div>

                    <div class="d-inline-block mx-auto mb-3">
                        <span class="badge bg-primary text-white px-3 py-1.5 rounded-pill fw-bold" style="font-size: 0.85rem;">
                            خطأ 419
                        </span>
                    </div>

                    <h2 class="fw-bold mb-3 title fs-3">انتهت صلاحية جلسة العمل!</h2>
                    <p class="text-muted mb-4 fs-6 leading-relaxed">
                        انتهت صلاحية الجلسة أو نموذج طلب الجملة بسبب توقف النشاط. يرجى تحديث الصفحة للمتابعة.
                    </p>

                    <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center">
                        <button onclick="window.location.reload()" class="btn btn-primary fw-bold px-4 py-2.5 rounded-pill shadow-sm">
                            <i class="fa-solid fa-rotate-right me-1"></i> تحديث الصفحة
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
    @include('stores.suppliers.components.navbar.js.navbar_js');
@endsection
