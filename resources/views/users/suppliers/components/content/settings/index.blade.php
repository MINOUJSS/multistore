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

        <!--start store pages-->
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="about-store-tab" data-bs-toggle="tab" data-bs-target="#about-store" type="button" role="tab" aria-controls="about-store" aria-selected="false">صفحات المتجر</button>
        </li>
        <!--end store pages-->

        {{-- <!--start about store-->
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
        <!--end faq--> --}}


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
        <div class="tab-pane fade" id="store-setting" role="tabpanel" aria-labelledby="store-setting-tab">
          {{-- Form لإضافة إعداد جديد --}}
    <div class="card mb-4">
      <div class="card-body">
          <form action="{{-- route('user-settings.store') --}}" method="POST">
              @csrf
              <div class="row g-3">
                  <div class="col-md-4">
                      <label for="key" class="form-label">مفتاح الإعداد</label>
                      <input type="text" class="form-control" id="key" name="key" required>
                  </div>

                  <div class="col-md-4">
                      <label for="value" class="form-label">القيمة</label>
                      <input type="text" class="form-control" id="value" name="value" required>
                  </div>

                  <div class="col-md-2">
                      <label for="type" class="form-label">النوع</label>
                      <select class="form-select" id="type" name="type">
                          <option value="string">نص</option>
                          <option value="integer">عدد صحيح</option>
                          <option value="boolean">قيمة منطقية</option>
                          <option value="json">JSON</option>
                      </select>
                  </div>

                  <div class="col-md-2">
                      <label for="status" class="form-label">الحالة</label>
                      <select class="form-select" id="status" name="status">
                          <option value="active">مفعل</option>
                          <option value="inactive">غير مفعل</option>
                      </select>
                  </div>

                  <div class="col-12">
                      <label for="description" class="form-label">الوصف</label>
                      <textarea class="form-control" id="description" name="description" rows="2"></textarea>
                  </div>

                  <div class="col-12 text-end">
                      <button type="submit" class="btn btn-primary">حفظ الإعداد</button>
                  </div>
              </div>
          </form>
      </div>
  </div>
        </div>
        <!--end store setting-->

        <!--start store pages-->
        <div class="tab-pane fade" id="about-store" role="tabpanel" aria-labelledby="about-store-tab">
          <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 mb-4 p-4">
            {{-- @php
                $pages = [
                    ['id' => 1, 'title' => 'من نحن', 'description' => 'صفحة تعريفية عن الشركة'],
                    ['id' => 2, 'title' => 'سياسة الخصوصية', 'description' => 'شرح كيفية استخدام بيانات المستخدم'],
                    ['id' => 3, 'title' => 'شروط الاستخدام', 'description' => 'قواعد استخدام المنصة والخدمات'],
                    ['id' => 4, 'title' => 'اتصل بنا', 'description' => 'وسائل التواصل مع فريق الدعم'],
                    ['id' => 5, 'title' => 'الأسئلة الشائعة', 'description' => 'إجابات على أهم استفسارات العملاء'],
                    ['id' => 6, 'title' => 'طرق الدفع', 'description' => 'شرح طرق الدفع المتاحة على الموقع'],
                    ['id' => 7, 'title' => 'سياسة الإرجاع', 'description' => 'تفاصيل سياسة استرجاع المنتجات'],
                    ['id' => 8, 'title' => 'التوصيل والشحن', 'description' => 'معلومات حول التوصيل والشحن']
                ];
            @endphp --}}
            @foreach($pages as $page)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="card-title">{{ $page['title'] }}</h5>
                            <p class="card-text text-muted">{{ $page['meta_description'] }}</p>
                        </div>
                        <button class="btn btn-primary mt-3" data-bs-toggle="modal" data-bs-target="#editModal{{ $page['id'] }}">
                            تعديل المحتوى
                        </button>
                    </div>
                </div>
            </div>
        
            <!-- Modal -->
            <div class="modal fade" id="editModal{{ $page['id'] }}" tabindex="-1" aria-labelledby="editModalLabel{{ $page['id'] }}" aria-hidden="true">
                <div class="modal-dialog modal-lg ">
                  {{-- modal-dialog-scrollable --}}
                    <div class="modal-content">

                      
                      <form method="POST" action="{{ route('supplier.page.update', $page->id) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $page->id }}">تعديل: {{ $page->title }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                        </div>
                    
                        <div class="modal-body">
                            <!-- العنوان -->
                            <div class="mb-3">
                                <label class="form-label">عنوان الصفحة</label>
                                <input type="text" class="form-control" name="title" value="{{ $page->title }}" required>
                            </div>
                    
                            {{-- <!-- الرابط (Slug) -->
                            <div class="mb-3">
                                <label class="form-label">الرابط (Slug)</label>
                                <input type="text" class="form-control" name="slug" value="{{ $page->slug }}" required>
                            </div> --}}
                    
                            <!-- المحتوى -->
                            <div class="mb-3">
                                <label class="form-label">المحتوى</label>
                                <div id="editor{{ $page->id }}" class="quill-editor" style="height: 300px;">{!! $page->content !!}</div>
                                <input type="hidden" name="content" id="contentInput{{ $page->id }}">
                            </div>
                    
                            <!-- ميتا تايتل -->
                            <div class="mb-3">
                                <label class="form-label">Meta Title</label>
                                <input type="text" class="form-control" name="meta_title" value="{{ $page->meta_title }}">
                            </div>
                    
                            <!-- ميتا وصف -->
                            <div class="mb-3">
                                <label class="form-label">Meta Description</label>
                                <textarea class="form-control" name="meta_description">{{ $page->meta_description }}</textarea>
                            </div>
                    
                            <!-- كلمات مفتاحية -->
                            <div class="mb-3">
                                <label class="form-label">Meta Keywords</label>
                                <input type="text" class="form-control" name="meta_keywords" value="{{ $page->meta_keywords }}">
                            </div>
                    
                            <!-- الحالة -->
                            <div class="mb-3">
                                <label class="form-label">الحالة</label>
                                <select class="form-select" name="status">
                                    <option value="published" {{ $page->status == 'published' ? 'selected' : '' }}>منشورة</option>
                                    <option value="draft" {{ $page->status == 'draft' ? 'selected' : '' }}>مسودة</option>
                                </select>
                            </div>
                    
                        </div>
                    
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success" onclick="saveEditorContent({{ $page->id }})">حفظ</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                        </div>
                      </form>
                    
                        {{-- <form method="POST" action="{{ route('supplier.page.update', $page['id']) }}">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalLabel{{ $page['id'] }}">تعديل: {{ $page['title'] }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                            </div>
                            <div class="modal-body">
                                <div id="editor{{ $page['id'] }}" class="quill-editor" style="height: 300px;">{!!$page['content']!!}</div>
                                <input type="hidden" name="content" id="contentInput{{ $page['id'] }}">
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" onclick="saveEditorContent({{ $page['id'] }})">حفظ</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                            </div>
                        </form> --}}


                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        </div>
        <!--end store pages-->

        {{-- <!--start about store-->
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
        <!--end faq--> --}}

      </div>
       {{-- end tab  --}}
    
  </div>
</div>
  