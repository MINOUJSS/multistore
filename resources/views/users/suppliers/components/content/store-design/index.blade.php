<div class="container">
    <h1 class="h3 mb-0 text-gray-800"><i class="fa-solid fa-palette me-2"></i>تصميم المتجر</h1>
    @if (session()->has('success'))
    <div class="alert alert-success">
        {{ session()->get('success') }}
        <button type="button" class="btn-close left" data-bs-dismiss="alert" aria-label="Close" style="float: left;"></button>
    </div>     
    @endif
    <div class="card">
       {{-- start tab  --}}
       <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
          <button class="nav-link active" id="theme-tab" data-bs-toggle="tab" data-bs-target="#theme" type="button" role="tab" aria-controls="theme" aria-selected="true"><i class="fa-solid fa-palette me-2"></i>الثيم</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
        </li>
        <li class="nav-item" role="presentation">
          <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
        </li>
      </ul>
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
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
      </div>
       {{-- end tab  --}}
    
  </div>
</div>
  