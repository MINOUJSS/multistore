@extends('site.layouts.app')

@section('title')
    419 | انتهت صلاحية الجلسة - {{ config('app.name') }}
@endsection

@section('content')
<section class="d-flex align-items-center justify-content-center min-vh-100 position-relative overflow-hidden"
    style="background: linear-gradient(180deg, #180512 0%, #29081e 50%, #150410 100%); padding: 120px 0 80px 0;">
    <div style="position: absolute; width: 450px; height: 450px; background: radial-gradient(circle, rgba(13, 110, 253, 0.2) 0%, rgba(0,0,0,0) 70%); top: 10%; left: 50%; transform: translateX(-50%); border-radius: 50%; filter: blur(40px); pointer-events: none;"></div>

    <div class="container text-center position-relative z-1" data-aos="fade-up">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6">
                <h1 class="display-1 fw-extrabold mb-2"
                    style="font-size: clamp(5rem, 15vw, 9rem); font-weight: 900; background: linear-gradient(135deg, #70a6ff 0%, #0d6efd 50%, #084298 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; text-shadow: 0 10px 30px rgba(13, 110, 253, 0.3);">
                    419
                </h1>

                <div class="d-inline-flex align-items-center gap-2 px-3 py-1.5 rounded-pill mb-4"
                    style="background: rgba(13, 110, 253, 0.15); border: 1px solid rgba(13, 110, 253, 0.3); color: #70a6ff; font-size: 0.9rem;">
                    <i class="bi bi-clock-history"></i>
                    <span>انتهت صلاحية الجلسة أو نموذج الأمان!</span>
                </div>

                <p class="text-white-50 fs-5 mb-5 leading-relaxed">
                    انتهت صلاحية الجلسة بسبب عدم النشاط لفترة. يرجى إعادة تحديث الصفحة للمتابعة.
                </p>

                <div class="d-flex flex-wrap gap-3 justify-content-center align-items-center">
                    <button onclick="window.location.reload()" class="btn text-white fw-bold px-4 py-3 rounded-pill shadow-lg border-0"
                        style="background: linear-gradient(135deg, #B03882 0%, #d6479f 100%); box-shadow: 0 8px 25px rgba(176, 56, 130, 0.45);">
                        <i class="bi bi-arrow-clockwise me-2"></i> تحديث الصفحة
                    </button>
                    <a href="{{ route('site.index') }}" class="btn btn-outline-light px-4 py-3 rounded-pill"
                        style="border-color: rgba(255, 255, 255, 0.25); color: rgba(255, 255, 255, 0.85);">
                        <i class="bi bi-house-door me-2"></i> الرئيسية
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
