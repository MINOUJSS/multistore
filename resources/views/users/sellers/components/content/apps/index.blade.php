<div class="container-fluid">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>إعدادات التطبيق</h2>
        {{-- <button class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            إضافة تكامل جديد
        </button> --}}
    </div>

    <!-- Analytics Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="card-title mb-0">التطبيقات</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @php
                $plan_id=get_seller_data(auth()->user()->tenant_id)->plan_subscription->plan_id;
                @endphp
                <!-- Google Analytics -->
                <div class="card m-2 p-2" style="width: 18rem;">
                    <img src="{{asset('asset/v1/users/dashboard/img/apps/google_analytics.png')}}" class="card-img-top" alt="Google Analytics" height="160px">
                    <div class="card-body">
                        <hr>
                        <h5 class="card-title">Google Analytics</h5>
                        <p class="card-text">
                            تتبع حركة الزوار وتحليل سلوك المستخدمين على موقعك لفهم أداء المحتوى وتحسين التجربة الرقمية.
                        </p>
                        @if($plan_id != 1)
                            <a href="{{ route('seller.app.google-analytics') }}" class="btn btn-primary">
                                إدارة الإعدادات
                            </a>
                        @else
                            <span class="btn btn-primary disabled">إدارة الإعدادات</span>
                        @endif
                        {{-- <a href="{{route('seller.app.google-analytics')}}" class="btn btn-primary">إدارة الإعدادات</a> --}}
                    </div>
                </div>
                 <!-- Facebook Pixel -->
                 <div class="card m-2 p-2" style="width: 18rem;">
                    <img src="{{asset('asset/v1/users/dashboard/img/apps/facebook_pixel.jpg')}}" class="card-img-top" alt="Google Analytics" height="160px">
                    <div class="card-body">
                        <hr>
                        <h5 class="card-title">Facebook Pixel</h5>
                        <p class="card-text">
                            تتبع تفاعل الزوار مع موقعك وتحسين استهداف الإعلانات لتحقيق أقصى استفادة من حملاتك الإعلانية على فيسبوك.
                        </p>
                        <a href="{{route('seller.app.facebook-pixel')}}" class="btn btn-primary" >إدارة الإعدادات</a>
                    </div>
                </div>
                 <!-- TikTok Pixel -->
                 <div class="card m-2 p-2" style="width: 18rem;">
                    <img src="{{asset('asset/v1/users/dashboard/img/apps/tiktok_pixel.png')}}" class="card-img-top" alt="Google Analytics" height="160px">
                    <div class="card-body">
                        <hr>
                        <h5 class="card-title">TikTok Pixel</h5>
                        <p class="card-text">
                            تتبع نشاط الزوار على موقعك وتحسين استهداف الإعلانات لتحقيق نتائج أفضل على منصة تيك توك.
                        </p> 
                         @if($plan_id != 1)
                            <a href="{{ route('seller.app.tiktok-pixel') }}" class="btn btn-primary">
                                إدارة الإعدادات
                            </a>
                        @else
                            <span class="btn btn-primary disabled">إدارة الإعدادات</span>
                        @endif                       
                        {{-- <a href="{{route('seller.app.tiktok-pixel')}}" class="btn btn-primary">إدارة الإعدادات</a> --}}
                    </div>
                </div>
                 <!-- Google Sheets -->
                 <div class="card m-2 p-2" style="width: 18rem;">
                    <img src="{{asset('asset/v1/users/dashboard/img/apps/google_sheet.jpg')}}" class="card-img-top" alt="Google Analytics" height="160px">
                    <div class="card-body">
                        <hr>
                        <h5 class="card-title">Google Sheets</h5>
                        <p class="card-text">
                            مزامنة البيانات تلقائيًا مع Google Sheets لتنظيم المعلومات وتحليلها بسهولة في الوقت الفعلي.
                        </p> 
                         @if($plan_id != 1)
                            <a href="{{ route('seller.app.google-sheet') }}" class="btn btn-primary">
                                إدارة الإعدادات
                            </a>
                        @else
                            <span class="btn btn-primary disabled">إدارة الإعدادات</span>
                        @endif                        
                        {{-- <a href="{{route('seller.app.google-sheet')}}" class="btn btn-primary">إدارة الإعدادات</a> --}}
                    </div>
                </div>
                 <!-- Telegram Notifications -->
                 <div class="card m-2 p-2" style="width: 18rem;">
                    <img src="{{asset('asset/v1/users/dashboard/img/apps/telegram.png')}}" class="card-img-top" alt="Google Analytics" height="160px">
                    <div class="card-body">
                        <hr>
                        <h5 class="card-title">Telegram Notifications</h5>
                        <p class="card-text">
                            استلم إشعارات فورية عبر Telegram حول حالة الطلبات، مما يساعدك على متابعة عمليات الشراء والتحديثات بسهولة وفي أي وقت.
                        </p>                        
                        <a href="{{route('seller.app.telegram-notifications')}}" class="btn btn-primary">إدارة الإعدادات</a>
                    </div>
                </div>
                         <!-- Microsoft Clarity -->
                <div class="card m-2 p-2" style="width: 18rem;">
                    <img src="{{ asset('asset/v1/users/dashboard/img/apps/clarity.png') }}" class="card-img-top" alt="Microsoft Clarity" height="160px">
                    <div class="card-body">
                        <hr>
                        <h5 class="card-title">Microsoft Clarity</h5>
                        <p class="card-text">
                            فعّل Microsoft Clarity لتحليل سلوك الزوار عبر تسجيلات الجلسات وخرائط التفاعل، مما يساعدك على تحسين تجربة المستخدم وزيادة التحويلات.
                        </p>
                        @if($plan_id != 1)
                            <a href="{{ route('seller.app.clarity') }}" class="btn btn-primary">
                                إدارة الإعدادات
                            </a>
                        @else
                            <span class="btn btn-primary disabled">إدارة الإعدادات</span>
                        @endif 
                        {{-- <a href="{{ route('seller.app.clarity') }}" class="btn btn-primary">إدارة الإعدادات</a> --}}
                    </div>
                </div>

                {{-- <!-- Google Analytics -->
                <div class="col-md-4 mb-4">
                    <div class="card integration-card h-100 position-relative">
                        <span class="badge 
                            {{ isset($google_analytics) && $google_analytics->status == 'active' ? 'bg-success' : 'bg-secondary' }} 
                            status-badge google-analytics-badge">
                            {{ isset($google_analytics) && $google_analytics->status == 'active' ? 'مفعل' : 'غير مفعل' }}
                        </span>
                        <div class="card-body text-center">
                            <form id="GoogleAnalyticsForm">
                                @csrf
                                <input type="hidden" name="app_name" value="google_analytics">
                                
                                <div class="integration-icon text-primary">
                                    <i class="fab fa-google"></i>
                                </div>
                                <h5 class="card-title">Google Analytics</h5>
                                <p class="card-text">تتبع حركة الزوار وتحليل سلوك المستخدمين</p>
                                
                                <div class="mb-3">
                                    <label class="form-label">معرف التتبع (Tracking ID)</label>
                                    <input type="text" name="tracking_id" id="tracking_id" class="form-control" placeholder="G-XXXXXXXXXX" 
                                        value="{{ old('tracking_id') ?? ($google_analytics ? json_decode($google_analytics->data)->tracking_id ?? '' : '') }}">
                                    <div class="invalid-feedback" id="error-tracking_id"></div>
                                </div>
                            
                                <div class="form-check form-switch mb-3 d-flex justify-content-center">
                                    <input class="form-check-input ms-2" type="checkbox" name="status" id="status"
                                        {{ isset($google_analytics) && $google_analytics->status == 'active' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">تفعيل التتبع</label>
                                </div>
                            
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                            </form>                         
                        </div>
                    </div>
                </div>
                <!-- Facebook Pixel -->

                <div class="col-md-4 mb-4">
                    <div class="card integration-card h-100 position-relative">
                        <span class="badge 
                            {{ isset($facebook_pixel) && $facebook_pixel->status == 'active' ? 'bg-success' : 'bg-secondary' }} 
                            status-badge facebook-pixel-badge">
                            {{ isset($facebook_pixel) && $facebook_pixel->status == 'active' ? 'مفعل' : 'غير مفعل' }}
                        </span>
                        <div class="card-body text-center">
                            <form id="FacebookPixelForm">
                                @csrf
                                <input type="hidden" name="app_name" value="facebook_pixel">
                                
                                <div class="integration-icon text-primary">
                                    <i class="fab fa-facebook"></i>
                                </div>
                                <h5 class="card-title">Facebook Pixel</h5>
                                <p class="card-text">تتبع تحويلات الإعلانات وسلوك الزوار</p>
                                
                                <div class="mb-3">
                                    <label class="form-label">معرف Pixel</label>
                                    <input type="text" name="fp_pixel_id" id="fp_pixel_id" class="form-control" placeholder="XXXXXXXXXXXXXXXXXX" 
                                        value="{{ old('pixel_id') ?? ($facebook_pixel ? json_decode($facebook_pixel->data)->pixel_id ?? '' : '') }}">
                                    <div class="invalid-feedback" id="error-fp_pixel_id"></div>
                                </div>
                            
                                <div class="form-check form-switch mb-3 d-flex justify-content-center">
                                    <input class="form-check-input ms-2" type="checkbox" name="fp_status" id="fp_status"
                                        {{ isset($facebook_pixel) && $facebook_pixel->status == 'active' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="status">تفعيل التتبع</label>
                                </div>
                            
                                <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                            </form>                         
                        </div>
                    </div>
                </div>

                <!-- TikTok Pixel -->
                <div class="col-md-4 mb-4">
                    <div class="card integration-card h-100 position-relative">
                        <span class="badge bg-success status-badge">مفعل</span>
                        <div class="card-body text-center">
                            <div class="integration-icon text-dark">
                                <i class="fab fa-tiktok"></i>
                            </div>
                            <h5 class="card-title">TikTok Pixel</h5>
                            <p class="card-text">تتبع حملات التيكتوك الإعلانية</p>
                            <div class="mb-3">
                                <label class="form-label">معرف Pixel</label>
                                <input type="text" class="form-control" placeholder="XXXXXXXXXXXXXXXXXX">
                            </div>
                            <div class="form-check form-switch mb-3 d-flex justify-content-center">
                                <input class="form-check-input ms-2" type="checkbox">
                                <label class="form-check-label">تفعيل التتبع</label>
                            </div>
                            <button class="btn btn-primary">حفظ التغييرات</button>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>

</div>