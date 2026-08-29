@extends('layouts.users.dashboard.app')

@section('title')
    419 - انتهت صلاحية الجلسة | لوحة تحكم البائع
@endsection

@if (auth()->check())
    @section('navbar')
        @include('users.sellers.components.navbar.navbar')
    @endsection

    @section('sidbar')
        @include('users.sellers.components.sidbar.sidbar')
    @endsection
@endif

@section('content')
<div class="container-fluid px-3 px-md-4 py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 text-center">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5 position-relative overflow-hidden">
                <div style="position: absolute; width: 220px; height: 220px; background: radial-gradient(circle, rgba(13, 110, 253, 0.1) 0%, rgba(255,255,255,0) 70%); top: -40px; right: -40px; border-radius: 50%; pointer-events: none;"></div>
                
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm"
                        style="width: 100px; height: 100px; background: rgba(13, 110, 253, 0.1);">
                        <i class="fa-solid fa-clock-rotate-left fs-1 text-primary"></i>
                    </div>
                </div>

                <div class="d-inline-block mx-auto mb-3">
                    <span class="badge bg-primary px-3 py-1.5 rounded-pill text-white fw-bold shadow-sm" style="font-size: 0.9rem;">
                        رمز الخطأ 419
                    </span>
                </div>

                <h2 class="fw-bold text-dark mb-3 fs-3">انتهت صلاحية جلسة العمل!</h2>
                
                <p class="text-muted mb-4 fs-6 leading-relaxed">
                    انتهت صلاحية رمز الأمان أو جلستك بسبب بقاء الصفحة مفتوحة لفترة طويلة دون نشاط. يرجى تحديث الصفحة.
                </p>

                <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center">
                    <button onclick="window.location.reload()" class="btn text-white fw-bold px-4 py-2.5 rounded-3 shadow-sm border-0"
                        style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 100%);">
                        <i class="fa-solid fa-rotate-right me-1"></i> تحديث الصفحة
                    </button>
                    <a href="{{ route('seller.dashboard') }}" class="btn btn-light border fw-semibold px-4 py-2.5 rounded-3">
                        <i class="fa-solid fa-house me-1"></i> لوحة التحكم
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
