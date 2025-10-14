<div class="row justify-content-center my-5">
    <div class="col-lg-10">
        <div class="card shadow-lg border-0 rounded-lg">
            <div class="card-header bg-primary text-white py-3">
                <h3 class="mb-0 text-center"><i class="fas fa-store-alt me-2"></i>{{ __('إعدادات المتجر') }}</h3>
            </div>

            <div class="card-body p-4">
                {{-- @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif --}}

                <form method="POST" action="{{ route('supplier.settings.update') }}" enctype="multipart/form-data" class="needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <!-- قسم المعلومات الأساسية -->
                    <div class="mb-5 p-4 bg-light rounded-3">
                        <h5 class="mb-4 text-primary border-bottom pb-2">
                            <i class="fas fa-info-circle me-2"></i>{{ __('المعلومات الأساسية') }}
                        </h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="store_name" class="form-label fw-bold">{{$settings[0]['description']}}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                    <input type="text" class="form-control rounded-end" id="store_name" name="store_name" 
                                           value="{{ old('store_name', $settings[0]['value'] ?? '') }}" required>
                                </div>
                                @error('store_name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="store_email" class="form-label fw-bold">{{$settings[2]['description']}}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    <input type="email" class="form-control rounded-end" id="store_email" name="store_email" 
                                           value="{{ old('store_email', $settings[2]['value'] ?? '') }}">
                                </div>
                                @error('store_email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="store_welcome_message" class="form-label fw-bold">{{$settings[18]['description']}}</label>
                                <input type="text" class="form-control" id="store_welcome_message" name="store_welcome_message" 
                                          value="{{ old('store_welcome_message', $settings[18]['value'] ?? '') }}"/>
                                @error('store_welcome_message')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12">
                                <label for="store_description" class="form-label fw-bold">{{$settings[1]['description']}}</label>
                                <textarea class="form-control" id="store_description" name="store_description" 
                                          rows="3" style="min-height: 100px;">{{ old('store_description', $settings[1]['value'] ?? '') }}</textarea>
                                @error('store_description')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- قسم معلومات الاتصال -->
                    <div class="mb-5 p-4 bg-light rounded-3">
                        <h5 class="mb-4 text-primary border-bottom pb-2">
                            <i class="fas fa-address-book me-2"></i>{{ __('معلومات الاتصال') }}
                        </h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="store_address" class="form-label fw-bold">{{ $settings[3]['description'] }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                    <textarea class="form-control rounded-end" id="store_address" name="store_address" 
                                              rows="2" style="min-height: 80px;">{{ old('store_address', $settings[3]['value'] ?? '') }}</textarea>
                                </div>
                                @error('store_address')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="store_phone" class="form-label fw-bold">{{ $settings[4]['description'] }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                    <input type="text" class="form-control rounded-end" id="store_phone" name="store_phone" 
                                           value="{{ old('store_phone', $settings[4]['value'] ?? '') }}">
                                </div>
                                @error('store_phone')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

<!-- قسم طرق الدفع -->
<div class="mb-5 p-4 bg-light rounded-3">
    <h5 class="mb-4 text-primary border-bottom pb-2">
        <i class="fas fa-credit-card me-2"></i>طرق الدفع المتاحة
    </h5>
    
    <div class="row g-3">
        @php
            // تحليل بيانات طرق الدفع من الإعدادات
            $paymentMethods = json_decode($settings[17]['value'] ?? '{}', true);
            // dd($settings[17]['value']);
            // الطرق الافتراضية في حالة عدم وجود بيانات
            $defaultMethods = [
                'Chargily_Pay' => ['name' => 'ChargilyPay', 'status' => 'active'],
                'Ccp' => ['name' => 'Ccp', 'status' => 'active'],
                'Edahabia' => ['name' => 'Edahabia', 'status' => 'active'],
                'CIB' => ['name' => 'CIB', 'status' => 'active'],
                'BaridiMob' => ['name' => 'BaridiMob', 'status' => 'active'],
                'Mastercard' => ['name' => 'Mastercard', 'status' => 'active'],
                'Visa' => ['name' => 'Visa', 'status' => 'active'],
                'Paypal' => ['name' => 'Paypal', 'status' => 'active'],
                'Cash' => ['name' => 'Cash', 'status' => 'active'],
                'Bank_Transfer' => ['name' => 'BankTransfer', 'status' => 'active']
            ];
            
            $methods = !empty($paymentMethods) ? $paymentMethods : $defaultMethods;
        @endphp

        @foreach($methods as $key => $method)
        <div class="col-md-6">
            <label class="form-label fw-bold d-block">
                @switch($key)
                    @case('Chargily_Pay') شارجيلي باي @break
                    @case('Ccp') الدفع عبر CCP @break
                    @case('Edahabia') الدفع عبر EDAHABIA @break
                    @case('CIB') الدفع عبر CIB @break
                    @case('BaridiMob') بريدي موب @break
                    @case('Mastercard') ماستركارد @break
                    @case('Visa') فيزا @break
                    @case('Paypal') باي بال @break
                    @case('Cash') الدفع عند الإستلام @break
                    @case('Bank_Transfer') حوالة بنكية @break
                    @default {{ $key }}
                @endswitch
            </label>
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" role="switch" 
                       id="payment_{{ Str::slug($key) }}" 
                       name="store_payment_methods[{{ $key }}][status]" 
                       value="active" 
                       {{ ($method['status'] ?? 'active') == 'active' ? 'checked' : '' }}>
                <label class="form-check-label" for="payment_{{ Str::slug($key) }}">تفعيل</label>
                <input type="hidden" name="store_payment_methods[{{ $key }}][name]" value="{{ $method['name'] ?? $key }}">
            </div>
        </div>
        @endforeach
    </div>
    
    @error('store_payment_methods')
        <div class="alert alert-danger mt-3">خطأ: {{ $message }}</div>
    @enderror
</div>

                    <!-- قسم وسائل التواصل الاجتماعي -->
                    <div class="mb-5 p-4 bg-light rounded-3">
                        <h5 class="mb-4 text-primary border-bottom pb-2">
                            <i class="fas fa-share-alt me-2"></i>{{ __('وسائل التواصل الاجتماعي') }}
                        </h5>
                        
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="store_facebook" class="form-label fw-bold">{{ $settings[10]['description'] }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-facebook text-white"><i class="fab fa-facebook-f"></i></span>
                                    <input type="text" class="form-control rounded-end" id="store_facebook" name="store_facebook" 
                                           value="{{ old('store_facebook', $settings[10]['value'] ?? '') }}" placeholder="https://facebook.com/username">
                                </div>
                                @error('store_facebook')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="store_telegram" class="form-label fw-bold">{{ $settings[11]['description'] }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-telegram text-white"><i class="fab fa-telegram"></i></span>
                                    <input type="text" class="form-control rounded-end" id="store_telegram" name="store_telegram" 
                                           value="{{ old('store_telegram', $settings[11]['value'] ?? '') }}" placeholder="https://t.me/username">
                                </div>
                                @error('store_telegram')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="store_tiktok" class="form-label fw-bold">{{ $settings[12]['description'] }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-dark text-white"><i class="fab fa-tiktok"></i></span>
                                    <input type="text" class="form-control rounded-end" id="store_tiktok" name="store_tiktok" 
                                           value="{{ old('store_tiktok', $settings[12]['value'] ?? '') }}" placeholder="https://tiktok.com/@username">
                                </div>
                                @error('store_tiktok')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="store_twitter" class="form-label fw-bold">{{ $settings[13]['description'] }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-twitter text-white"><i class="fab fa-twitter"></i></span>
                                    <input type="text" class="form-control rounded-end" id="store_twitter" name="store_twitter" 
                                           value="{{ old('store_twitter', $settings[13]['value'] ?? '') }}" placeholder="https://twitter.com/username">
                                </div>
                                @error('store_twitter')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="store_instagram" class="form-label fw-bold">{{ $settings[14]['description'] }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-instagram text-white"><i class="fab fa-instagram"></i></span>
                                    <input type="text" class="form-control rounded-end" id="store_instagram" name="store_instagram" 
                                           value="{{ old('store_instagram', $settings[14]['value'] ?? '') }}" placeholder="https://instagram.com/username">
                                </div>
                                @error('store_instagram')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="store_youtube" class="form-label fw-bold">{{ $settings[15]['description'] }}</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-youtube text-white"><i class="fab fa-youtube"></i></span>
                                    <input type="text" class="form-control rounded-end" id="store_youtube" name="store_youtube" 
                                           value="{{ old('store_youtube', $settings[15]['value'] ?? '') }}" placeholder="https://youtube.com/c/username">
                                </div>
                                @error('store_youtube')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- قسم حقوق النشر -->
                    <div class="mb-4 p-4 bg-light rounded-3">
                        <h5 class="mb-4 text-primary border-bottom pb-2">
                            <i class="fas fa-copyright me-2"></i>{{ __('حقوق النشر') }}
                        </h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="copyright" class="form-label fw-bold">{{ $settings[16]['description'] }}</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-balance-scale"></i></span>
                                    <input type="text" class="form-control rounded-end" id="copyright" name="copyright" 
                                           value="{{ old('copyright', $settings[16]['value'] ?? '') }}">
                                </div>
                                @error('copyright')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill">
                            <i class="fas fa-save me-2"></i>{{ __('حفظ الإعدادات') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-facebook { background-color: #3b5998 !important; }
    .bg-twitter { background-color: #1da1f2 !important; }
    .bg-instagram { background: linear-gradient(45deg, #405de6, #5851db, #833ab4, #c13584, #e1306c, #fd1d1d) !important; }
    .bg-youtube { background-color: #ff0000 !important; }
    .bg-telegram { background-color: #0088cc !important; }
    .rounded-3 { border-radius: 0.5rem !important; }
    .form-control:focus, .form-select:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
</style>