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
                            <th>المخزون</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><img src="assets/img/product1.jpg" alt="Product" width="50"></td>
                            <td>هاتف ذكي</td>
                            <td>إلكترونيات</td>
                            <td>2,499 ر.س</td>
                            <td>15</td>
                            <td><span class="badge bg-success">متوفر</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><img src="assets/img/product2.jpg" alt="Product" width="50"></td>
                            <td>قميص قطني</td>
                            <td>ملابس</td>
                            <td>149 ر.س</td>
                            <td>50</td>
                            <td><span class="badge bg-success">متوفر</span></td>
                            <td>
                                <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
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

</div>