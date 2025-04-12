<div class="container">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-gear me-2"></i>إعدادات</h1>
    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
        <button type="button" class="btn-close left" data-bs-dismiss="alert" aria-label="Close" style="float: left;"></button>
    </div>     
    @endif
    <div class="card">
       {{-- start tab  --}}
       <ul class="nav nav-tabs" id="myTab" role="tablist">
        <!--start theme-->
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="theme-tab" data-bs-toggle="tab" data-bs-target="#theme" type="button" role="tab" aria-controls="theme" aria-selected="true"><i class="fa-solid fa-palette me-2"></i>الثيم</button>
        </li>
        <!--end theme-->

        <!--start store setting -->
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="store-setting-tab" data-bs-toggle="tab" data-bs-target="#store-setting" type="button" role="tab" aria-controls="store-setting" aria-selected="false">إعدادات المتجر</button>
        </li>
        <!--end store setting-->

        <!--start about store-->
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="about-store-tab" data-bs-toggle="tab" data-bs-target="#about-store" type="button" role="tab" aria-controls="about-store" aria-selected="false">عن المتجر</button>
        </li>
        <!--end about store-->

        <!--start shipping-policy-->
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="shipping-policy-tab" data-bs-toggle="tab" data-bs-target="#shipping-policy" type="button" role="tab" aria-controls="shipping-policy" aria-selected="false">الشحن و التسليم</button>
        </li>
        <!--end shipping-policy-->

        <!--start payment-policy-->
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="payment-policy-tab" data-bs-toggle="tab" data-bs-target="#payment-policy" type="button" role="tab" aria-controls="payment-policy" aria-selected="false">طرق الدفع</button>
        </li>
        <!--end payment-policy-->

        <!--start terms-of-use-->
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="terms-of-use-tab" data-bs-toggle="tab" data-bs-target="#terms-of-use" type="button" role="tab" aria-controls="terms-of-use" aria-selected="false">شروط الإستخدام</button>
        </li>
        <!--end terms-of-use-->

        <!--start exchange-policy-->
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="exchange-policy-tab" data-bs-toggle="tab" data-bs-target="#exchange-policy" type="button" role="tab" aria-controls="exchange-policy" aria-selected="false">سياسة الإستبدال و الإسترجاع</button>
        </li>
        <!--end exchange-policy-->

        <!--start privacy-policy-->
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="privacy-policy-tab" data-bs-toggle="tab" data-bs-target="#privacy-policy" type="button" role="tab" aria-controls="privacy-policy" aria-selected="false">السياسة الخصوصية</button>
        </li>
        <!--end privacy-policy-->

        <!--start contact-us-->
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="contact-us-tab" data-bs-toggle="tab" data-bs-target="#contact-us" type="button" role="tab" aria-controls="contact-us" aria-selected="false">اتصل بنا</button>
        </li>
        <!--end contact-us-->

        <!--start faq-->
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="faq-tab" data-bs-toggle="tab" data-bs-target="#faq" type="button" role="tab" aria-controls="faq" aria-selected="false">الأسئلة الشائعة</button>
        </li>
        <!--end faq-->


      </ul>
      <!--start theme-->
      <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="theme" role="tabpanel" aria-labelledby="theme-tab">
            <form action="{{route('supplier.theme-update',Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
              @csrf  
              <!-- رفع الشعار -->
                <table>
                  <tr>
                      <td>
                          <div class="m-4">
                              <label for="storeLogo" class="form-label">شعار المتجر</label>
                              <ul>
                                  <li>الحجم المسموح: 300x300 بيكسل</li>
                                  <li>النوع المسموح: JPEG, PNG, JPG</li>
                              </ul>
                          </div>
                      </td>
                      <td>
                          <div class="m-4">
                              <div id="dropzone" onclick="browsdialog()" onchange="previewLogo(event)">
                                  <i class="fa fa-cloud-upload"></i>
                                  <input type="file" name="image"class="form-control" id="storeLogo" accept="image/*" style="display: none;">
                              </div>
                          </div>
                      </td>
                      <td>
                          <div class="m-4">
                              <div id="logoPreview" class="preview" style="background-image: url('{{get_store_logo(Auth::user()->tenant_id)}}'); background-size: contain; background-repeat: no-repeat;">
                              </div>
                            </div>
                      </td>
                  </tr>
                </table>
          
                <!-- قسم الألوان -->
                <table>
                  <tr>
                      <td>
                          <div class="m-4">
                          <label for="primaryColor" class="form-label">اللون الرئيسي</label>
                        </div>
                      </td>
                      <td>
                          <div class="m-4">
                          <input type="color" class="form-control form-control-color" id="primaryColor" value="{{get_store_parimary_color(Auth::user()->tenant_id)}}">
                          <input type="hidden" name="primarycollor" id="hiddenPrimaryCollor" value="{{get_store_parimary_color(Auth::user()->tenant_id)}}">
                        </div>
                      </td>
                      <td>
                        <div class="m-4">
                            <label for="bodytextcolor" class="form-label">لون الخط الرئيسي</label>                  </div>
                    </td>
                    <td>
                        <div class="m-4">
                            <input type="color" class="form-control form-control-color" id="bodytextcolor" value="{{get_store_body_text_color(Auth::user()->tenant_id)}}">
                            <input type="hidden" name="bodytextcolor" id="hiddenbodytextcolor" value="{{get_store_body_text_color(Auth::user()->tenant_id)}}">
                          </div>
                    </td>
                      <td>
                          <div class="m-4">
                          <label for="footertextcolor" class="form-label">لون الخط على الفوتر</label>
                        </div>
                      </td>
                      <td>
                          <div class="m-4">
                          <input type="color" class="form-control form-control-color" id="footertextcolor" value="{{get_store_footer_text_color(Auth::user()->tenant_id)}}">
                          <input type="hidden" name="footertextcolor" id="hiddenfootertextcolor" value="{{get_store_footer_text_color(Auth::user()->tenant_id)}}">
                        </div>
                      </td>
                  </tr>
                </table>
          
                <!-- زر الحفظ -->
                <button type="submit" class="btn btn-primary m-4">حفظ الإعدادات</button>
              </form>
        </div>
        <!--end theme-->

        <!--start store setting-->
        <div class="tab-pane fade" id="store-setting" role="tabpanel" aria-labelledby="store-setting-tab">...</div>
        <!--end store setting-->

        <!--start about store-->
        <div class="tab-pane fade" id="about-store" role="tabpanel" aria-labelledby="about-store-tab">...</div>
        <!--end about store-->

        <!--start shipping-policy-->
        <div class="tab-pane fade" id="shipping-policy" role="tabpanel" aria-labelledby="shipping-policy-tab">...</div>
        <!--end shipping-policy-->

        <!--start payment-policy-->
        <div class="tab-pane fade" id="payment-policy" role="tabpanel" aria-labelledby="payment-policy-tab">...</div>
        <!--end payment-policy-->

        <!--start terms-of-use-->
        <div class="tab-pane fade" id="terms-of-use" role="tabpanel" aria-labelledby="terms-of-use-tab">...</div>
        <!--end terms-of-use-->

        <!--start exchange-policy-->
        <div class="tab-pane fade" id="exchange-policy" role="tabpanel" aria-labelledby="exchange-policy-tab">...</div>
        <!--end exchange-policy-->

        <!--start privacy-policy-->
        <div class="tab-pane fade" id="privacy-policy" role="tabpanel" aria-labelledby="privacy-policy-tab">...</div>
        <!--end privacy-policy-->

        <!--start contact-us-->
        <div class="tab-pane fade" id="contact-us" role="tabpanel" aria-labelledby="contact-us-tab">...</div>
        <!--end contact-us-->

        <!--start faq-->
        <div class="tab-pane fade" id="faq" role="tabpanel" aria-labelledby="faq-tab">...</div>
        <!--end faq-->

      </div>
       {{-- end tab  --}}
    
  </div>
</div>
  