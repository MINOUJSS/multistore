<div class="container">
    <h1 class="h3 mb-0 text-gray-800">إدارة المنتجات</h1>
    <!-- add product modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addModal">
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
                                <button class="btn btn-sm btn-danger">
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

    
  
  <!-- add Modal -->
  <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          ...
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">تعديل المنتج</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form id="editForm" method="POST" enctype="application/x-www-form-urlencoded" class="row g-3">
                @csrf
                <div class="col-12 bg-primary rounded ronded p-2 text-center">معلومات المنتج</div>
                <div class="col-md-6">
                  <label for="product_name" class="form-label">إسم المنتج</label>
                  <input type="text" class="form-control" id="product_name" name="product_name">
                </div>
                <div class="col-md-6">
                    <label for="inputCategory" class="form-label">الأصناف</label>
                    <select id="inputCategory" class="form-select" name="product_category">
                      @foreach ($categories as $category)
                      <option value="{{$category->id}}" id="p_cat_{{$category->id}}">{{$category->name}}</option>   
                      @endforeach
                    </select>
                  </div>
                  <div class="col-md-6">
                    <label for="inputCost" class="form-label">التكلفة</label>
                    <input type="text" class="form-control" id="inputCost" name="product_cost">
                  </div>
                <div class="col-md-6">
                  <label for="inputPrice" class="form-label">السعر</label>
                  <input type="text" class="form-control" id="inputPrice" name="product_price">
                </div>
                <div class="col-md-6">
                    <label for="inputQty" class="form-label">الكمية المتوفرة</label>
                    <input type="text" class="form-control" id="inputQty" name="product_qty">
                  </div>
                <div class="col-md-6">
                  <label for="inputMiniQty" class="form-label">أقل كمية ممكنة للطلب</label>
                  <input type="text" class="form-control" id="inputMinQty" name="product_min_qty">
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
                        <input type="file" name="image"class="form-control" id="storeLogo" accept="image/*" style="display: none;">
                    </div>
                </div>
                <div class=" col-md-6">
                    <div id="logoPreview" class="preview" style="background-size: contain; background-repeat: no-repeat;">
                    </div>
                  </div>
                  <hr>
                  <div class="col-12 bg-primary rounded ronded p-2 text-center">خيارات المنتج</div>
                  <div class="container" id="product_variation">
                    <div class="d-flex justify-content-center m-3"><a class="btn btn-primary" id="add_variation"><i class="fa fa-add"></i></a></div> 
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
                  
                  <div class="col-12 bg-primary rounded ronded p-2 text-center">تخفيضات للمنتج</div>
                  <div class="container" id="product_discount">
                  <div class="d-flex justify-content-center m-3"><a class="btn btn-primary" id="add_discount"><i class="fa fa-add"></i></a></div> 
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
               
                <div class="col-12 bg-primary rounded ronded p-2 text-center">وصف المنتج</div>
                <div class="col-12">
                  <label for="inputShortDescription" class="form-label">وصف قصير عن المنتج</label>
                 <textarea class="form-control" name="short_description" rows="5" id="inputShortDescription"></textarea>
                </div>
                <!--    -->
                <div class="col-12 mb-5 pb-5">
                    <label for="inputDescription" class="form-label">وصف المنتج</label>
                    <input type="hidden" name="product_description" id="product_description">
                    <!-- Create the editor container -->
                      <div class="" id="editor">
                      </div>
                        
                  </div>
                <!--    -->
                <input type="submit" value="save">
              </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
          <button type="button" class="btn btn-primary">حفظ</button>
        </div>
      </div>
    </div>
  </div>

</div>