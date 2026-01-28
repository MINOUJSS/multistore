@if (session('success'))
    <script>
        Swal.fire({
            title: 'نجاح!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'حسنًا'
        });
    </script>
@endif

<div class="container-fluid">
    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4 mobile-header-stack">
        <h2>إدارة الشحن</h2>
        <div class="d-flex flex-wrap gap-2">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ShippingCompaniesModal">
                <i class="fas fa-plus me-2"></i>إضافة شركة شحن
            </button>
            <a class="btn btn-success" href="{{ route('seller.shipping.edit') }}">
                <i class="fas fa-plus me-2"></i>تسعير الشحن
            </a>
        </div>
    </div>


    <!-- Start Shipping companies -->
    <div class="modal fade" id="ShippingCompaniesModal" tabindex="-1" aria-labelledby="ShippingCompaniesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ربط شركات الشحن</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group text-center">
                        <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#YALIDINEModal"
                            style="cursor: pointer;"><img src="https://i.imgur.com/LNDFb1h.png" alt="YALIDINE"
                                height="50px" /> </li>
                        <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#ZrexpressModal"
                            style="cursor: pointer;"><img src="https://i.imgur.com/eL1fmUM.jpeg" alt="Zrexpress"
                                height="50px" /> </li>
                        <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#EcotrackModal"
                            style="cursor: pointer;"><img src="https://i.imgur.com/aNXHaac.png" alt="Ecotrack"
                                height="50px" /> </li>
                        <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#YalitecModal"
                            style="cursor: pointer;"><img src="https://i.imgur.com/IsBfZGd.png" alt="Yalitec"
                                height="50px" /> </li>
                        <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#MAYSTRO_DELIVERYModal"
                            style="cursor: pointer;"><img src="https://i.imgur.com/Pjv1wp2.png" alt="MAYSTRO_DELIVERY"
                                height="50px" /> </li>
                        <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#ProColisModal"
                            style="cursor: pointer;"><img src="https://i.imgur.com/DJqdUc3.png" alt="Procolis"
                                height="50px" /> </li>
                        <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#NoestModal"
                            style="cursor: pointer;"><img src="https://noest-dz.com/assets/img/logo_colors_new.png"
                                alt="Noest" height="50px" /> </li>
                        <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#ExpedigoModal"
                            style="cursor: pointer;"><img src="https://i.imgur.com/P7Yma2X.png" alt="Expedigo"
                                height="50px" /> </li>
                        <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#ElogistiaModal"
                            style="cursor: pointer;"><img src="https://i.imgur.com/aHASodC.png" alt="Elogistia"
                                height="50px" /> </li>
                        <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#GuepexModal"
                            style="cursor: pointer;"><img src="https://imgur.com/JkV2HXl.png"
                                alt="Guepex" height="50px" /> </li>
                        <li class="list-group-item" data-bs-toggle="modal" data-bs-target="#DHDModal"
                            style="cursor: pointer;"><img src="https://i.imgur.com/PrM01pT.png" alt="DHD"
                                height="50px" /> </li>
                    </ul>
                </div>

            </div>
        </div>
    </div>
    <!-- End Shipping companies -->

    <!---->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">شركات الشحن المدمجة</h5>
        </div>
        <div class="card-body">
            <div class="row">

                @if ($companies->count() > 0)
                    @foreach ($companies as $company)
                        @php
                            $companyData = json_decode($company->data);
                        @endphp

                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card integration-card h-100 shadow-sm rounded-4 position-relative border">
                                {{-- حالة التفعيل --}}
                                <span
                                    class="badge bg-success position-absolute top-0 end-0 m-2 px-3 py-2 rounded-pill small">مفعل</span>

                                <div class="card-body text-center">
                                    {{-- شعار الشركة --}}
                                    <div class="integration-icon text-primary mb-3">
                                        <img src="{{ $companyData->logo ?? asset('default-logo.png') }}"
                                            alt="{{ $company->name }}" height="50" class="img-fluid">
                                    </div>

                                    {{-- اسم الشركة --}}
                                    <h5 class="card-title fw-bold mb-2">{{ $company->name }}</h5>

                                    {{-- وصف --}}
                                    <p class="card-text text-muted small mb-3">
                                        رفع طلبات العملاء إلى شركة الشحن <strong>{{ $company->name }}</strong> بضغطة زر
                                        واحدة
                                    </p>

                                    {{-- أدوات التحكم --}}
                                    <div class="d-flex justify-content-center align-items-center flex-wrap gap-2 mt-3">
                                        {{-- مفتاح التفعيل --}}
                                        <div class="form-check form-switch">
                                            <input class="form-check-input toggle-shipping" type="checkbox"
                                                data-company-id="{{ $company->id }}"
                                                {{ $company->status == 'active' ? 'checked' : '' }}>
                                            <label class="form-check-label small">تفعيل الشحن</label>
                                        </div>

                                        {{-- زر الإعدادات --}}
                                        <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal"
                                            data-bs-target="#{{ $company->name }}Modal">
                                            <i class="fa-solid fa-gear me-1"></i> إعدادات
                                        </button>

                                        {{-- زر الحذف --}}
                                        <form action="{{ route('seller.shipping-company.delete', $company->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('هل أنت متأكد من حذف شركة الشحن؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger delete-shipping-btn">
                                                <i class="fa-solid fa-trash me-1"></i> حذف
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12 mb-4">
                        <div class="card h-100 text-center p-4 shadow-sm border border-dashed rounded-4">
                            <div class="card-body">
                                <div class="integration-icon text-primary mb-3">
                                    <img src="{{ asset('asset/v1/users/dashboard/img/other/Delivery-1.png') }}"
                                        alt="delivery" height="60">
                                </div>

                                <h5 class="card-title mb-3">لا توجد شركات شحن مرتبطة بالمنصة</h5>
                                <p class="text-muted mb-4">قم بإضافة شركة شحن لتمكين خيارات الشحن لعملائك.</p>

                                <div class="d-flex justify-content-center">
                                    <button class="btn btn-outline-primary" data-bs-toggle="modal"
                                        data-bs-target="#ShippingCompaniesModal">
                                        <i class="fa-solid fa-plus me-1"></i> إضافة شركة شحن
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- @if ($companies->count() > 0)
                        @foreach ($companies as $company)
                        <div class="col-md-4 mb-4">
                            <div class="card integration-card h-100 position-relative">
                                <span class="badge bg-success status-badge">مفعل</span>
                                <div class="card-body text-center">
                                    <div class="integration-icon text-primary">
                                        @php
                                            $companyData = json_decode($company->data);
                                        @endphp
                                        <img src="{{ $companyData->logo ?? asset('default-logo.png') }}" alt="{{ $company->name }}" height="50px"/>
                                    </div>
                                    <h5 class="card-title">{{ $company->name }}</h5>
                                    <p class="card-text">رفع طلبات العملاء إلى شركة الشحن {{ $company->name }} بضغطة زر واحدة</p>
                    
                                    <div class="form-check form-switch mb-3 d-flex justify-content-center">
                                        <input class="form-check-input ms-2 toggle-shipping" type="checkbox" 
                                            data-company-id="{{ $company->id }}" 
                                            {{ $company->status == 'active' ? 'checked' : '' }}>
                                        <label class="form-check-label">تفعيل الشحن</label>
                                        <button class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#{{$company->name}}Modal">
                                            <i class="fa-solid fa-gear"></i> إعدادات
                                        </button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                <!---->
                <div class="col-12 mb-4" bis_skin_checked="1">
                    <div class="card h-100 text-center p-4 shadow-sm border-dashed" bis_skin_checked="1">
                        <div class="card-body" bis_skin_checked="1">
                            <div class="integration-icon text-primary mb" bis_skin_checked="1">
                                                                <img src="{{asset('asset/v1/users/dashboard/img/other/Delivery-1.png')}}" alt="Yalidin" height="60px">
                            </div>
                            <h5 class="card-title mb-3">لا توجد شركات شحن مرتبطة بالمنصة</h5>
                            <p class="text-muted mb-4">قم بإضافة شركة شحن لتمكين خيارات الشحن لعملائك.</p>
            
                            <div class="form-check form-switch mb-3 d-flex justify-content-center" bis_skin_checked="1">
                                <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ShippingCompaniesModal">
                                    <i class="fa-solid fa-gear"></i> إضافة شركة شحن
                                </button>
                            </div>
                            
                        </div>
                    </div>
                </div>
                <!---->
                @endif --}}

            </div>
        </div>
    </div>
    <!--/-->

    <!-- Start Yalidin Modal -->
    <div class="modal fade" id="YALIDINEModal" tabindex="-1" aria-labelledby="YALIDINEModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="YALIDINEForm">
                    @csrf
                    <input type="hidden" name="name" value="YALIDINE">

                    <div class="modal-header">
                        <h5 class="modal-title">ربط شركات Yalidine</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3 text-center">
                            <img src="https://i.imgur.com/LNDFb1h.png" alt="yalidine" height="50px" />
                        </div>

                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">ولاية الشحن :</label>
                            <input type="text" class="form-control" id="yl-wilaya" name="wilaya"
                                value="{{ old('wilaya', isset($yalidin) && $yalidin->count() ? json_decode($yalidin->data)->wilaya : '') }}">
                            <div class="invalid-feedback" id="error-yl-wilaya"></div>
                        </div>

                        <div class="mb-3">
                            <label for="api_id" class="col-form-label">API ID:</label>
                            <input type="text" class="form-control" id="yl-api_id" name="api_id"
                                value="{{ old('api_id', isset($yalidin) && $yalidin->count() ? json_decode($yalidin->data)->api_id : '') }}">
                            <div class="invalid-feedback" id="error-yl-api_id"></div>
                        </div>

                        <div class="mb-3">
                            <label for="api_token" class="col-form-label">API TOKEN:</label>
                            <input type="text" class="form-control" id="yl-api_token" name="api_token"
                                value="{{ old('api_token', isset($yalidin) && $yalidin->count() ? json_decode($yalidin->data)->api_token : '') }}">
                            <div class="invalid-feedback" id="error-yl-api_token"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="testYalidineConnection">إختبار الإتصال</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End Yalidin Modal -->

    <!-- Start ZRexpress Modal -->
    <div class="modal fade" id="ZrexpressModal" tabindex="-1" aria-labelledby="ZrexpressModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="zrexpressForm">
                    @csrf
                    <input type="hidden" name="name" value="Zrexpress">

                    <div class="modal-header">
                        <h5 class="modal-title">ربط شركات zrexpress</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3 text-center">
                            <img src="https://i.imgur.com/eL1fmUM.jpeg" alt="zrexpress" height="50px" />
                        </div>

                        <div class="mb-3">
                            <label for="api_id" class="col-form-label">Token:</label>
                            <input type="text" class="form-control" id="zr-token" name="token"
                                value="{{ old('token', isset($zrexpress) && $zrexpress->count() ? json_decode($zrexpress->data)->token : '') }}">
                            <div class="invalid-feedback" id="error-zr-token"></div>
                        </div>

                        <div class="mb-3">
                            <label for="api_token" class="col-form-label">Cle:</label>
                            <input type="text" class="form-control" id="zr-cle" name="cle"
                                value="{{ old('cle', isset($zrexpress) && $zrexpress->count() ? json_decode($zrexpress->data)->cle : '') }}">
                            <div class="invalid-feedback" id="error-zr-cle"></div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End ZRexpress Modal -->

    <!-- Start Ecotrack Modal -->
    <div class="modal fade" id="EcotrackModal" tabindex="-1" aria-labelledby="EcotrackModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ربط شركات Ecotrack</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3 text-center">
                            <img src="https://i.imgur.com/aNXHaac.png" alt="Ecotrack" height="50px" />
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">ولاية الشحن :</label>
                            <input type="text" class="form-control" id="wilaya" name="wilaya">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API ID:</label>
                            <input type="text" class="form-control" id="api_id" name="api_id">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API TOKEN:</label>
                            <input type="text" class="form-control" id="api_token" name="api_token">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Ecotrack Modal -->

    <!-- Start Yalitec Modal -->
    <div class="modal fade" id="YalitecModal" tabindex="-1" aria-labelledby="YalitecModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ربط شركات Yalitec</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3 text-center">
                            <img src="https://i.imgur.com/IsBfZGd.png" alt="Yalitec" height="50px" />
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">ولاية الشحن :</label>
                            <input type="text" class="form-control" id="wilaya" name="wilaya">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API ID:</label>
                            <input type="text" class="form-control" id="api_id" name="api_id">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API TOKEN:</label>
                            <input type="text" class="form-control" id="api_token" name="api_token">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Yalitec Modal -->
    <!-- Start MAYSTRO_DELIVERY Modal -->
    <div class="modal fade" id="MAYSTRO_DELIVERYModal" tabindex="-1" aria-labelledby="MAYSTRO_DELIVERYModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ربط شركات MAYSTRO_DELIVERY</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="MAYSTRO_DELIVERYForm">
                    @csrf
                    <input type="hidden" name="name" value="MAYSTRO_DELIVERY">
                        <div class="mb-3 text-center">
                            <img src="https://i.imgur.com/Pjv1wp2.pngs" alt="MAYSTRO_DELIVERY" height="50px" />
                        </div>
                        {{-- <div class="mb-3">
                            <label for="wilaya" class="col-form-label">ولاية الشحن :</label>
                            <input type="text" class="form-control" id="wilaya" name="wilaya">
                        </div> --}}
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API ID:</label>
                            <input type="text" class="form-control" id="api_id" name="id" value="{{ old('id', isset($maystro) && $maystro->count() ? json_decode($maystro->data)->id : '') }}">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API KEY:</label>
                            <input type="text" class="form-control" id="api_token" name="key" value="{{ old('key', isset($maystro) && $maystro->count() ? json_decode($maystro->data)->key : '') }}">
                        </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="testMAYSTRO_DELIVERYConnection">إختبار الإتصال</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End MAYSTRO_DELIVERY Modal -->
    <!-- Start ProColis Modal -->
    <div class="modal fade" id="ProColisModal" tabindex="-1" aria-labelledby="ProColisModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ربط شركات ProColis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3 text-center">
                            <img src="https://i.imgur.com/DJqdUc3.png" alt="ProColis" height="50px" />
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">ولاية الشحن :</label>
                            <input type="text" class="form-control" id="wilaya" name="wilaya">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API ID:</label>
                            <input type="text" class="form-control" id="api_id" name="api_id">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API TOKEN:</label>
                            <input type="text" class="form-control" id="api_token" name="api_token">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End ProColis Modal -->
    <!-- Start Noest Modal -->
    <div class="modal fade" id="NoestModal" tabindex="-1" aria-labelledby="NoestModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ربط شركات Noest</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3 text-center">
                            <img src="https://noest-dz.com/assets/img/logo_colors_new.png" alt="Noest"
                                height="50px" />
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">ولاية الشحن :</label>
                            <input type="text" class="form-control" id="wilaya" name="wilaya">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API ID:</label>
                            <input type="text" class="form-control" id="api_id" name="api_id">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API TOKEN:</label>
                            <input type="text" class="form-control" id="api_token" name="api_token">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Noest Modal -->
    <!-- Start Expedigo Modal -->
    <div class="modal fade" id="ExpedigoModal" tabindex="-1" aria-labelledby="ExpedigoModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ربط شركات Expedigo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3 text-center">
                            <img src="https://i.imgur.com/P7Yma2X.png" alt="Expedigo" height="50px" />
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">ولاية الشحن :</label>
                            <input type="text" class="form-control" id="wilaya" name="wilaya">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API ID:</label>
                            <input type="text" class="form-control" id="api_id" name="api_id">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API TOKEN:</label>
                            <input type="text" class="form-control" id="api_token" name="api_token">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Expedigo Modal -->
    <!-- Start Elogistia Modal -->
    <div class="modal fade" id="ElogistiaModal" tabindex="-1" aria-labelledby="ElogistiaModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ربط شركات Elogistia</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3 text-center">
                            <img src="https://i.imgur.com/aHASodC.png" alt="Elogistia" height="50px" />
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">ولاية الشحن :</label>
                            <input type="text" class="form-control" id="wilaya" name="wilaya">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API ID:</label>
                            <input type="text" class="form-control" id="api_id" name="api_id">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API TOKEN:</label>
                            <input type="text" class="form-control" id="api_token" name="api_token">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Elogistia Modal -->
    <!-- Start Guepex Modal -->
    <div class="modal fade" id="GuepexModal" tabindex="-1" aria-labelledby="GuepexModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ربط شركات Guepex</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="post">
                        <div class="mb-3 text-center">
                            <img src="https://www.guepex.com/assets/images/logo/logo-dark.webp" alt="Guepex"
                                height="50px" />
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">ولاية الشحن :</label>
                            <input type="text" class="form-control" id="wilaya" name="wilaya">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API ID:</label>
                            <input type="text" class="form-control" id="api_id" name="api_id">
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API TOKEN:</label>
                            <input type="text" class="form-control" id="api_token" name="api_token">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                    <button type="button" class="btn btn-primary">حفظ</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Guepex Modal -->
    <!-- Start DHD Modal -->
    <div class="modal fade" id="DHDModal" tabindex="-1" aria-labelledby="DHDModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">ربط شركات DHD</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="dhdForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="name" value="DHD">
                        <div class="mb-3 text-center">
                            <img src="https://i.imgur.com/PrM01pT.png" alt="DHD" height="50px" />
                        </div>
                        <div class="mb-3">
                            <label for="wilaya" class="col-form-label">API TOKEN:</label>
                            <input type="text" class="form-control" name="token"
                                value="{{ old('token', isset($dhd) && $dhd->count() ? json_decode($dhd->data)->token : '') }}">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" id="testDHDConnection">إختبار الإتصال</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        <button type="submit" class="btn btn-primary">حفظ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- End DHD Modal -->


    {{-- <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">الشحنات النشطة</h5>
                    <h3 class="card-text">24</h3>
                    <p class="card-text"><small>قيد التوصيل</small></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">تم التسليم</h5>
                    <h3 class="card-text">156</h3>
                    <p class="card-text"><small>هذا الشهر</small></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h5 class="card-title">قيد المعالجة</h5>
                    <h3 class="card-text">18</h3>
                    <p class="card-text"><small>في المستودع</small></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h5 class="card-title">متوسط وقت التوصيل</h5>
                    <h3 class="card-text">2.5</h3>
                    <p class="card-text"><small>يوم</small></p>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Shipping Table -->
    {{-- <div class="card">
        <div class="card-body">
            <!-- Filters -->
            <div class="row mb-3">
                <div class="col-md-3">
                    <input type="text" class="form-control" placeholder="بحث برقم الشحنة...">
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected="">حالة الشحنة</option>
                        <option>قيد المعالجة</option>
                        <option>تم الشحن</option>
                        <option>قيد التوصيل</option>
                        <option>تم التسليم</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select">
                        <option selected="">شركة الشحن</option>
                        <option>أرامكس</option>
                        <option>فيديكس</option>
                        <option>DHL</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="date" class="form-control">
                </div>
            </div>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>رقم الشحنة</th>
                            <th>رقم الطلب</th>
                            <th>العميل</th>
                            <th>العنوان</th>
                            <th>شركة الشحن</th>
                            <th>تاريخ الشحن</th>
                            <th>تاريخ التسليم المتوقع</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#SHP-001</td>
                            <td>#ORD-123</td>
                            <td>أحمد محمد</td>
                            <td>الرياض، حي النزهة</td>
                            <td>أرامكس</td>
                            <td>2024-12-23</td>
                            <td>2024-12-25</td>
                            <td><span class="badge bg-warning">قيد التوصيل</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" title="تتبع الشحنة">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-primary" title="تحديث الحالة">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-success" title="طباعة بوليصة الشحن">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>#SHP-002</td>
                            <td>#ORD-124</td>
                            <td>سارة أحمد</td>
                            <td>جدة، حي الصفا</td>
                            <td>DHL</td>
                            <td>2024-12-23</td>
                            <td>2024-12-26</td>
                            <td><span class="badge bg-info">تم الشحن</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" title="تتبع الشحنة">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-primary" title="تحديث الحالة">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-success" title="طباعة بوليصة الشحن">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>#SHP-003</td>
                            <td>#ORD-125</td>
                            <td>محمد علي</td>
                            <td>الدمام، حي الشاطئ</td>
                            <td>فيديكس</td>
                            <td>2024-12-22</td>
                            <td>2024-12-24</td>
                            <td><span class="badge bg-success">تم التسليم</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" title="تتبع الشحنة">
                                    <i class="fas fa-map-marker-alt"></i>
                                </button>
                                <button class="btn btn-sm btn-primary" title="تحديث الحالة">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-success" title="طباعة بوليصة الشحن">
                                    <i class="fas fa-print"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">السابق</a>
                    </li>
                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                    <li class="page-item">
                        <a class="page-link" href="#">التالي</a>
                    </li>
                </ul>
            </nav>
        </div>
    </div> --}}
</div>
