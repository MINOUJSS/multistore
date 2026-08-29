@extends('layouts.users.dashboard.app')

@section('title')
    404 - الصفحة غير موجودة | لوحة تحكم المورد
@endsection

@if (auth()->check())
    @section('navbar')
        @include('users.suppliers.components.navbar.navbar')
    @endsection

    @section('sidbar')
        @include('users.suppliers.components.sidbar.sidbar')
    @endsection
@endif

@section('content')
<div class="container-fluid px-3 px-md-4 py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-8 col-lg-6 text-center">
            <div class="card border-0 shadow-sm rounded-4 bg-white p-4 p-md-5 position-relative overflow-hidden">
                <div style="position: absolute; width: 220px; height: 220px; background: radial-gradient(circle, rgba(37, 99, 235, 0.12) 0%, rgba(255,255,255,0) 70%); top: -40px; right: -40px; border-radius: 50%; pointer-events: none;"></div>
                
                <div class="mb-4">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle shadow-sm"
                        style="width: 100px; height: 100px; background: linear-gradient(135deg, rgba(15, 23, 42, 0.08) 0%, rgba(37, 99, 235, 0.15) 100%);">
                        <i class="fa-solid fa-boxes-packing fs-1 text-primary"></i>
                    </div>
                </div>

                <div class="d-inline-block mx-auto mb-3">
                    <span class="badge px-3 py-1.5 rounded-pill text-white fw-bold shadow-sm"
                        style="background: linear-gradient(135deg, #0f172a 0%, #2563eb 100%); font-size: 0.9rem;">
                        رمز الخطأ 404
                    </span>
                </div>

                <h2 class="fw-bold text-dark mb-3 fs-3">عذراً، الصفحة المطلوبة غير متوفرة!</h2>
                
                <p class="text-muted mb-4 fs-6 leading-relaxed">
                    الصفحة أو المنتج أو الرابط الذي تبحث عنه في لوحة التوريد لم يعد موجوداً أو تم تغييره.
                </p>

                <div class="d-flex flex-wrap gap-2 justify-content-center align-items-center">
                    <a href="{{ route('supplier.dashboard') }}" class="btn text-white fw-bold px-4 py-2.5 rounded-3 shadow-sm border-0"
                        style="background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);">
                        <i class="fa-solid fa-house me-1"></i> لوحة المورد
                    </a>
                    <button onclick="window.history.back()" class="btn btn-light border fw-semibold px-4 py-2.5 rounded-3">
                        <i class="fa-solid fa-arrow-right me-1"></i> العودة للخلف
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
