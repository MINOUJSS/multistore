<div class="container">
    <h1 class="h3 mb-0 text-gray-800">إدارة المنتجات</h1>
    <!-- add product modal -->
<button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#addModal" onclick="ClearValidationErrors();">
    <i class="fas fa-plus me-2"></i> إضافة منتج جديد
  </button>
    {{-- filter  --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">التصنيف</label>
                    <select class="form-select">
                        <option value="">جميع التصنيفات</option>
                        <option>إلكترونيات</option>
                        <option>ملابس</option>
                        <option>أثاث</option>
                        <option>كتب</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">الحالة</label>
                    <select class="form-select">
                        <option value="">جميع الحالات</option>
                        <option>متوفر</option>
                        <option>غير متوفر</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">بحث</label>
                    <input type="text" class="form-control" placeholder="ابحث عن منتج...">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">&nbsp;</label>
                    <button class="btn btn-primary w-100">بحث</button>
                </div>
            </div>
        </div>
    </div>

    {{-- products table --}}

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>صورة</th>
                            <th>اسم المنتج</th>
                            <th>التصنيف</th>
                            <th>السعر</th>
                            <th>التكلفة</th>
                            <th>المخزون</th>
                            <th>أقل كمية عند الطلب</th>
                            <th>التوصيل المجاني</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $product)
                        <tr>
                            <td><img src="{{asset($product->image)}}" alt="Product" width="50"></td>
                            <td>{{$product->name}}</td>
                            <td>{{get_supplier_product_category($product->id)}}</td>
                            <td>{{get_supplier_product_price($product->id)}}</td>
                            <td>{{$product->cost}}</td>
                            <td>{{$product->qty}}</td>
                            <td>{{$product->minimum_order_qty}}</td>
                            <td>{{s_p_has_free_shipping($product->id)}}</td>
                            <td><span class="badge bg-success">{{$product->status}}</span></td>
                            <td>
                                <button value="{{$product->id}}" class="btn btn-sm btn-info editproduct" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-product" value="{{$product->id}}" data-id="{{$product->id}}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <nav aria-label="Page navigation" class="mt-4">
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
    </div>
    
    {{-- add product modela  --}}

    
    <!-- add product attribut Modal -->
    <div class="modal fade" id="addProductAttributModal" tabindex="-1" aria-labelledby="addAtrributModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">إضافة خاصية</h5>
            <div id="modalButtonContainer" style="position: absolute;left:0;margin-left:15px;"></div>
          </div>
          <div class="modal-body">
            <form id="attributeForm" method="post">
              @csrf
              <div class="col-md-12">
                <label for="attribute_name" class="form-label">إسم الخاصية</label>
                <input type="text" class="form-control" id="attribute_name" name="attribute_name" placeholder="الماركة،النوع،الحجم...إلخ">
                <span class="text-danger error-atrribute_name"></span>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancel_atrribute">إلغاء</button> --}}
            <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#editModal">إلغاء</button>
            <button type="button" class="btn btn-primary" id="save_atrribute" data-bs-toggle="modal" data-bs-target="#editModal">حفظ</button>
          </div>
        </div>
      </div>
    </div>

  <!-- add product Modal -->
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">إضافة منتج</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <!--start-->
          <div id="addFormErrors"></div>      
          <form id="addForm" method="POST" enctype="application/x-www-form-urlencoded" class="row g-3">
              @csrf
              <div class="col-12 bg-primary rounded ronded p-2 text-center">معلومات المنتج</div>
              <input type="hidden" name="add_product_id" id="add_product_id">
              <div class="col-md-6">
                <label for="add_product_name" class="form-label">إسم المنتج</label>
                <input type="text" class="form-control" id="add_product_name" name="add_product_name">
                <span class="text-danger error-add_product_name error-validation"></span>
              </div>
              <div class="col-md-6">
                  <label for="inputCategory" class="form-label">الأصناف</label>
                  <select id="add_inputCategory" class="form-select" name="add_product_category">
                    @foreach ($categories as $category)
                    <option value="{{$category->id}}" id="add_p_cat_{{$category->id}}">{{$category->name}}</option>   
                    @endforeach
                  </select>
                  <span class="text-danger error-add_product_category error-validation"></span>
                </div>
                <div class="col-md-6">
                  <label for="inputCost" class="form-label">التكلفة</label>
                  <input type="text" class="form-control" id="add_inputCost" name="add_product_cost" required>
                  <span class="text-danger error-add_product_cost error-validation"></span>
                </div>
              <div class="col-md-6">
                <label for="inputPrice" class="form-label">السعر</label>
                <input type="text" class="form-control" id="add_inputPrice" name="add_product_price" required>
                <span class="text-danger error-add_product_price error-validation"></span>
              </div>
              <div class="col-md-6">
                  <label for="inputQty" class="form-label">الكمية المتوفرة</label>
                  <input type="text" class="form-control" id="add_inputQty" name="add_product_qty" required>
                  <span class="text-danger error-add_product_qty error-validation"></span>
                </div>
              <div class="col-md-6">
                <label for="inputMiniQty" class="form-label">أقل كمية ممكنة للطلب</label>
                <input type="text" class="form-control" id="add_inputMinQty" name="add_product_min_qty" required>
                <span class="text-danger error-add_product_min_qty error-validation"></span>
              </div>
              <div class="col-md-6">
                <label for="inputCondition" class="form-label">حالة المنتج</label>
                <select id="add_inputCondition" class="form-select" name="add_product_condition">
                  <option value="new" id="add_product_status_new">جديد</option>
                  <option value="used" id="add_product_status_used">مستعمل</option> 
                  <option value="refurbished" id="add_product_status_refurbished">تم تجديده</option>   
                </select>
                <span class="text-danger error-add_product_condition error-validation"></span>
              </div>
              <div class="col-md-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input" name="add_free_shipping" id="add_free_shipping" type="checkbox" checked>
                    <label class="form-check-label" for="add_free_shipping">توصيل مجاني</label>
                  </div>
              </div>
              <div class="col-md-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" name="add_status" id="add_product_status" type="checkbox" checked>
                  <label class="form-check-label" for="status">عرض المنتج</label>
                </div>
            </div>
              <div class="col-12 bg-primary rounded ronded p-2 text-center">الصورة و المعرض</div>
              <div class="col-md-6">
                  <ul class="p-3" style="float:right;">
                      <li>
                          الصورة الرئيسية
                      </li>
                      <li>المقياس:450X450</li>
                      <li>الحجم:2MB</li>

                      </ul>
                  <div id="add_dropzone" onclick="add_browsdialog()" onchange="add_previewLogo(event)">
                      <i class="fa fa-cloud-upload"></i>
                      <input type="file" name="add_image"class="form-control" id="add_product_image" accept="image/*" style="display: none;">
                  </div>
              </div>
              {{-- <div class="col-12"> --}}
                {{-- <span class="text-danger error-add_image error-validation"></span> --}}
              {{-- </div>              --}}
              <div class=" col-md-6">
                  <div id="add_logoPreview" class="preview" style="background-size: contain; background-repeat: no-repeat;">
                  </div>
                  <span class="text-danger error-add_image error-validation"></span>
                </div>
                <hr>
                <h5 class="mb-3 text-center">صور إضافية للمنتج</h5>
                <div class="col-md-12">
                  <div id="add_multi_image" class="dropzone dragover" onclick="add_browsdialogmultifile()">
                    <i class="fa fa-cloud-upload"></i>
                    <input type="file" name="add_images[]"class="form-control" id="add_product_images" accept="image/*" multiple style="display: none;">
                </div>
                <span class="text-danger error-add_product_images error-validation"></span>
              <div class=" col-md-12">
                <div class="add_images_container" id="add_images_container">

                </div>
              </div>
                </div>
                <div class="col-12 bg-primary rounded ronded p-2 text-center">خصائص المنتج</div>
                <div class="container mb-5">
                  <div class="d-flex justify-content-center m-3"><a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductAttributModal" onclick="returnToForm('addForm')"><i class="fa fa-add"></i>إضافة خاصية جديدة</a></div>
                  <div class="d-flex justify-content-center m-3"><a class="btn btn-primary" id="add_add_attribute"><i class="fa fa-add"></i></a></div>
                  <div class="container" id="add_product_attribute"> 
                      <!---->                   

                      <!---->
                  </div>
                </div>
                <div class="col-12 bg-primary rounded ronded p-2 text-center">خيارات المنتج</div>
                <div class="container mb-5">
                <div class="d-flex justify-content-center m-3"><a class="btn btn-primary" id="add_add_variation"><i class="fa fa-add"></i></a></div> 
                <div class="container" id="add_product_variation">
                </div>
                </div>
                
                <div class="col-12 bg-primary rounded ronded p-2 text-center">تخفيضات للمنتج</div>
                <div class="container mb-5">
                <div class="d-flex justify-content-center m-3"><a class="btn btn-primary" id="add_add_discount" onclick="add_add_discount();"><i class="fa fa-add"></i></a></div> 
                <div class="container" id="add_product_discount">
                </div>
                </div>
             
              <div class="col-12 bg-primary rounded ronded p-2 text-center">وصف المنتج</div>
              <div class="col-12">
                <label for="add_inputShortDescription" class="form-label">وصف قصير عن المنتج</label>
               <textarea class="form-control" name="add_product_short_description" rows="5" id="add_inputShortDescription"></textarea>
               <span class="text-danger error-add_product_short_description error-validation"></span>
              </div>
              <!--    -->
              <div class="col-12 mb-5 pb-5">
                  <label for="add_inputDescription" class="form-label">وصف المنتج</label>
                  <input type="hidden" name="add_product_description" id="add_product_description">
                  <!-- Create the editor container -->
                    <div class="" id="add_editor">
                    </div>
                    <span class="text-danger error-add_product_description error-validation"></span>
                </div>
            </form>
          <!--end-->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
          <button type="button" class="btn btn-primary" id="save_product">حفظ</button>
        </div>
      </div>
    </div>
  </div>

  <!-- edit product Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">تعديل المنتج</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body"> 
            <div id="editFormErrors"></div>      
            <form id="editForm" method="POST" enctype="application/x-www-form-urlencoded" class="row g-3">
                @csrf
                <div class="col-12 bg-primary rounded ronded p-2 text-center">معلومات المنتج</div>
                <input type="hidden" name="product_id" id="product_id">
                <div class="col-md-6">
                  <label for="product_name" class="form-label">إسم المنتج</label>
                  <input type="text" class="form-control" id="product_name" name="product_name">
                  <span class="text-danger error-product_name"></span>
                </div>
                <div class="col-md-6">
                    <label for="inputCategory" class="form-label">الأصناف</label>
                    <select id="inputCategory" class="form-select" name="product_category">
                      @foreach ($categories as $category)
                      <option value="{{$category->id}}" id="p_cat_{{$category->id}}">{{$category->name}}</option>   
                      @endforeach
                    </select>
                    <span class="text-danger error-product_category"></span>
                  </div>
                  <div class="col-md-6">
                    <label for="inputCost" class="form-label">التكلفة</label>
                    <input type="text" class="form-control" id="inputCost" name="product_cost" required>
                    <span class="text-danger error-product_cost"></span>
                  </div>
                <div class="col-md-6">
                  <label for="inputPrice" class="form-label">السعر</label>
                  <input type="text" class="form-control" id="inputPrice" name="product_price" required>
                  <span class="text-danger error-product_price"></span>
                </div>
                <div class="col-md-6">
                    <label for="inputQty" class="form-label">الكمية المتوفرة</label>
                    <input type="text" class="form-control" id="inputQty" name="product_qty" required>
                    <span class="text-danger error-product_qty"></span>
                  </div>
                <div class="col-md-6">
                  <label for="inputMiniQty" class="form-label">أقل كمية ممكنة للطلب</label>
                  <input type="text" class="form-control" id="inputMinQty" name="product_min_qty" required>
                  <span class="text-danger error-product_min_qty"></span>
                </div>
                <div class="col-md-6">
                  <label for="inputCondition" class="form-label">حالة المنتج</label>
                  <select id="inputCondition" class="form-select" name="product_condition">
                    <option value="new" id="product_status_new">جديد</option>
                    <option value="used" id="product_status_used">مستعمل</option> 
                    <option value="refurbished" id="product_status_refurbished">تم تجديده</option>   
                  </select>
                  <span class="text-danger error-product_category"></span>
                </div>
                <div class="col-md-3">
                    <div class="form-check form-switch">
                      <input class="form-check-input" name="free_shipping" id="free_shipping" type="checkbox" checked>
                      <label class="form-check-label" for="free_shipping">توصيل مجاني</label>
                    </div>
                </div>
                <div class="col-md-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input" name="status" id="product_status" type="checkbox" checked>
                    <label class="form-check-label" for="status">عرض المنتج</label>
                  </div>
              </div>
                <div class="col-12 bg-primary rounded ronded p-2 text-center">الصورة و المعرض</div>
                <div class="col-md-6">
                    <ul class="p-3" style="float:right;">
                        <li>
                            الصورة الرئيسية
                        </li>
                        <li>المقياس:450X450</li>
                        <li>الحجم:2MB</li>

                        </ul>
                    <div id="dropzone" onclick="browsdialog()" onchange="previewLogo(event)">
                        <i class="fa fa-cloud-upload"></i>
                        <input type="file" name="image"class="form-control" id="product_image" accept="image/*" style="display: none;">
                    </div>
                    <span class="text-danger error-product_image"></span>
                </div>
                <div class=" col-md-6">
                    <div id="logoPreview" class="preview" style="background-size: contain; background-repeat: no-repeat;">
                    </div>
                  </div>
                  <hr>
                  <h5 class="mb-3 text-center">صور إضافية للمنتج</h5>
                  <div class="col-md-12">
                    <div id="multi_image" class="dropzone dragover" onclick="browsdialogmultifile()">
                      <i class="fa fa-cloud-upload"></i>
                      <input type="file" name="images[]"class="form-control" id="product_images" accept="image/*" multiple style="display: none;">
                  </div>
                  <span class="text-danger error-product_images"></span>
                <div class=" col-md-12">
                  <div class="images_container" id="images_container">
                    {{-- <div class="image">
                      <img src="{{asset('asset/site/defaulte/img/cta-bg.jpg')}}" alt="image">
                        <span>&times</span>
                    </div>
                    <div class="image">
                    <img src="{{asset('asset/site/defaulte/img/cta-bg.jpg')}}" alt="image">
                      <span>&times</span>
                    </div> --}}
                  </div>
                </div>
                  </div>
                  <div class="col-12 bg-primary rounded ronded p-2 text-center">خصائص المنتج</div>
                  <div class="container mb-5">
                    <div class="d-flex justify-content-center m-3"><a class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductAttributModal" onclick="returnToForm('editForm')"><i class="fa fa-add"></i>إضافة خاصية جديدة</a></div>
                    <div class="d-flex justify-content-center m-3"><a class="btn btn-primary" id="add_attribute"><i class="fa fa-add"></i></a></div>
                    <div class="container" id="product_attribute"> 
                        <!---->                   
                        {{-- <div class="attribute_container border position-relative p-3 mt-3 mb-3 row">
                          <div class="col-6">
                          <label for="inputSku" class="form-label">إختر الخاصية</label>
                          <select class="form-select porduct_attribute" name="porduct_attribute[]" id="porduct_attribute"></select>
                          </div>
                          <div class="col-3">
                          <label for="inputColor" class="form-label">قيمة الخاصية</label>
                          <input class="form-control" type="text" name="attribute_value[]" id="attribute_value" required>
                          </div>
                          <div class="col-3">
                          <label for="inputSize" class="form-label">السعر الإضافي</label>
                          <input class="form-control" type="number" class="form-control" min="0" name="atrribute_add_price[]" id="atrribute_add_price">
                          </div>
                          <div class="col-3">
                          <label for="inputAddPrice" class="form-label">الكمية  في المخزن</label>
                          <input type="number" class="form-control" min="0" name="attribute_stock_qty[]" id="attribute_stock_qty">
                          </div>
                          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2 remove_attribute" style="width:30px;cursor:pointer">X</span>
                          </div> --}}
                        <!---->
                    </div>
                  </div>
                  <div class="col-12 bg-primary rounded ronded p-2 text-center">خيارات المنتج</div>
                  <div class="container mb-5">
                  <div class="d-flex justify-content-center m-3"><a class="btn btn-primary" id="add_variation"><i class="fa fa-add"></i></a></div> 
                  <div class="container" id="product_variation">
                    
                    {{--<div class="variation_container border position-relative p-3 mt-3 mb-3 row">
                     <div class="col-6">
                        <label for="inputSku" class="form-label">اسم المنتج مع اللون و المقاس..</label>
                        <input type="text" class="form-control" id="inputSku" placeholder="مثال:T-Shirt-Red-Siz-XXL">
                      </div>
                      <div class="col-3">
                        <label for="inputColor" class="form-label">لون المنتج</label>
                        <input type="color" class="form-control form-control-color" id="inputColor" value="">
                        <input type="hidden" name="inputColor" id="hiddeninputColor" value="">
                      </div>
                      <div class="col-3">
                        <label for="inputSize" class="form-label">المقاس المنتج</label>
                        <input type="number" class="form-control" id="inputSize">
                      </div>
                      <div class="col-3">
                        <label for="inputWeight" class="form-label">وزن المنتج</label>
                        <input type="text" class="form-control" id="inputWeight">
                      </div>
                      <div class="col-3">
                        <label for="inputAddPrice" class="form-label">الكمية  في المخزن</label>
                        <input type="number" class="form-control" id="inputAddPrice">
                      </div>
                      <div class="col-3">
                        <label for="inputStock" class="form-label">الكمية  في المخزن</label>
                        <input type="number" class="form-control" id="inputStock">
                      </div>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2 remove_variation" style="width:30px;cursor:pointer">
                        X
                      </span>
                    </div> --}}
                  </div>
                  </div>
                  
                  <div class="col-12 bg-primary rounded ronded p-2 text-center">تخفيضات للمنتج</div>
                  <div class="container mb-5">
                  <div class="d-flex justify-content-center m-3"><a class="btn btn-primary" id="add_discount" onclick="add_discount();"><i class="fa fa-add"></i></a></div> 
                  <div class="container" id="product_discount">
                  {{-- <div class="discount_container border position-relative p-3 mt-3 mb-3 row">
                  <div class="col-3">
                    <label for="inputStock" class="form-label">سعر البيع بالتخفيض</label>
                    <input type="number" class="form-control" id="inputStock">
                  </div>
                  <div class="col-3">
                    <label for="inputStock" class="form-label">النسبة المئوية للتخفيض</label>
                    <input type="number" class="form-control" id="inputStock">
                  </div>
                  <div class="col-3">
                    <label for="inputStock" class="form-label">تاريخ بداية التخفيض</label>
                    <input type="date" class="form-control" id="inputStock">
                  </div>
                  <div class="col-3">
                    <label for="inputStock" class="form-label">تاريخ نهاية التخفيض</label>
                    <input type="date" class="form-control" id="inputStock">
                  </div>
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
                    <label class="form-check-label" for="flexSwitchCheckChecked">مفعل</label>
                  </div>
                  <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2 remove_discount" style="width:30px;cursor:pointer">X</span>
                  </div> --}}
                  </div>
                  </div>
               
                <div class="col-12 bg-primary rounded ronded p-2 text-center">وصف المنتج</div>
                <div class="col-12">
                  <label for="inputShortDescription" class="form-label">وصف قصير عن المنتج</label>
                 <textarea class="form-control" name="product_short_description" rows="5" id="inputShortDescription"></textarea>
                 <span class="text-danger error-product_short_description error-validation"></span>
                </div>
                <!--    -->
                <div class="col-12 mb-5 pb-5">
                    <label for="inputDescription" class="form-label">وصف المنتج</label>
                    <input type="hidden" name="product_description" id="product_description">
                    <!-- Create the editor container -->
                      <div class="" id="editor">
                      </div>
                      <span class="text-danger error-product_description error-validation"></span>
                  </div>
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
          <button type="button" class="btn btn-primary" id="save">حفظ</button>
        </div>
      </div>
    </div>
  </div>

</div>