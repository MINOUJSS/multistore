<div class="container">
    <h1 class="h3 mb-0 text-gray-800">إدارة كوبونات الخصم</h1>
    
    <!-- Add Coupon Modal Button -->
    <button type="button" class="btn btn-primary m-2" data-bs-toggle="modal" data-bs-target="#addCouponModal">
        <i class="fas fa-ticket-alt me-2"></i> إضافة كوبون جديد
    </button>

    {{-- Filter Section --}}
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label class="form-label">نوع الكوبون</label>
                    <select id="typeFilter" class="form-select">
                        <option value="all">جميع الأنواع</option>
                        <option value="percent">نسبة مئوية</option>
                        <option value="fixed">مبلغ ثابت</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">الحالة</label>
                    <select id="statusFilter" class="form-select">
                        <option value="all">جميع الحالات</option>
                        <option value="active">نشط</option>
                        <option value="expired">منتهي</option>
                        <option value="scheduled">مجدول</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">بحث</label>
                    <input id="searchFilter" type="text" class="form-control" placeholder="ابحث عن كوبون...">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="form-label">&nbsp;</label>
                    <button id="searchBtn" class="btn btn-primary w-100">بحث</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Coupons Table --}}
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>الكود</th>
                            <th>الوصف</th>
                            <th>النوع</th>
                            <th>القيمة</th>
                            <th>يبدأ من</th>
                            <th>ينتهي في</th>
                            <th>الحد الأدنى</th>
                            <th>الاستخدامات</th>
                            <th>الحالة</th>
                            <th>التفعيل</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="couponList">
                        @foreach ($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ $coupon->description }}</td>
                            <td>
                                @if($coupon->type == 'percent')
                                    <span class="badge bg-info">نسبة مئوية</span>
                                @else
                                    <span class="badge bg-primary">مبلغ ثابت</span>
                                @endif
                            </td>
                            <td>
                                @if($coupon->type == 'percent')
                                    {{ $coupon->value }}%
                                @else
                                    {{ number_format($coupon->value, 2) }} د.ج
                                @endif
                            </td>
                            <td>{{ \Carbon\Carbon::parse($coupon->start_date)->format('Y-m-d') }}</td>
                            <td>{{ \Carbon\Carbon::parse($coupon->end_date)->format('Y-m-d') }}</td>
                            <td>{{ number_format($coupon->min_order_amount, 2) }} د.ج</td>
                            <td>{{ $coupon->usage_per_user }} / {!! $coupon->usage_limit == 0 ? '<span><b>∞</b></span>' : $coupon->usage_limit !!}</td>
                            <td>
                                @if($coupon->isExpired())
                                    <span class="badge bg-danger">منتهي</span>
                                @elseif($coupon->isScheduled())
                                    <span class="badge bg-warning text-dark">مجدول</span>
                                @else
                                    <span class="badge bg-success">نشط</span>
                                @endif
                            </td>
                            <td>
                                @if($coupon->isActive())
                                    <span class="badge bg-success">مفعل</span>
                                @else
                                    <span class="badge bg-danger">غير مفعل</span>
                                @endif
                            </td>
                            <td>
                                <button value="{{ $coupon->id }}" class="btn btn-sm btn-info edit-coupon" data-bs-toggle="modal" data-bs-target="#editCouponModal">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete-coupon" value="{{ $coupon->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $coupons->links('vendor.pagination.dashboard-pagination') }}
        </div>
    </div>
</div>

<!-- Add Coupon Modal -->
<div class="modal fade" id="addCouponModal" tabindex="-1" aria-labelledby="addCouponModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCouponModalLabel">إضافة كوبون جديد</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCouponForm" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="add_code" class="form-label">كود الكوبون</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="add_code" name="code" required>
                            <button class="btn btn-outline-secondary" type="button" id="generateCode">
                                <i class="fas fa-sync-alt"></i> توليد
                            </button>
                        </div>
                        <small class="text-muted">يجب أن يكون الكود فريداً وحروف كبيرة</small>
                        <span class="text-danger error-add_code"></span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="add_description" class="form-label">وصف الكوبون</label>
                        <textarea class="form-control" id="add_description" name="description" rows="2"></textarea>
                        <span class="text-danger error-add_description"></span>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="add_type" class="form-label">نوع الخصم</label>
                            <select class="form-select" id="add_type" name="type" required>
                                <option value="percent">نسبة مئوية</option>
                                <option value="fixed">مبلغ ثابت</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="add_value" class="form-label">قيمة الخصم</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="add_value" name="value" min="0" step="0.01" required>
                                <span class="input-group-text" id="valueSuffix">%</span>
                            </div>
                            <span class="text-danger error-add_value"></span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="add_start_date" class="form-label">يبدأ من</label>
                            <input type="datetime-local" class="form-control" id="add_start_date" name="start_date" required>
                            <span class="text-danger error-add_start_date"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="add_end_date" class="form-label">ينتهي في</label>
                            <input type="datetime-local" class="form-control" id="add_end_date" name="end_date" required>
                            <span class="text-danger error-add_end_date"></span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="add_min_order_amount" class="form-label">الحد الأدنى للطلب</label>
                            <input type="number" class="form-control" id="add_min_order_amount" name="min_order_amount" min="0" step="0.01" value="0">
                            <small class="text-muted">المبلغ الأدنى لتفعيل الكوبون (0 يعني لا يوجد حد)</small>
                            <span class="text-danger error-add_min_order_amount"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="add_max_uses" class="form-label">الحد الأقصى للاستخدام</label>
                            <input type="number" class="form-control" id="add_max_uses" name="max_uses" min="0" value="0">
                            <small class="text-muted">0 يعني لا يوجد حد</small>
                            <span class="text-danger error-add_max_uses"></span>
                        </div>
                    </div>
                    
                    {{-- <div class="mb-3">
                        <label for="add_user_restriction" class="form-label">تقييد بالمستخدمين</label>
                        <select class="form-select" id="add_user_restriction" name="user_restriction">
                            <option value="all">جميع المستخدمين</option>
                            <option value="new">المستخدمين الجدد فقط</option>
                            <option value="existing">المستخدمين الحاليين فقط</option>
                            <option value="specific">مستخدمين محددين</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="add_specific_users_container" style="display: none;">
                        <label for="add_specific_users" class="form-label">اختيار المستخدمين</label>
                        <select class="form-select select2" id="add_specific_users" name="specific_users[]" multiple>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="add_product_restriction" class="form-label">تقييد بالمنتجات</label>
                        <select class="form-select" id="add_product_restriction" name="product_restriction">
                            <option value="all">جميع المنتجات</option>
                            <option value="categories">فئات محددة</option>
                            <option value="products">منتجات محددة</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="add_categories_container" style="display: none;">
                        <label for="add_categories" class="form-label">اختيار الفئات</label>
                        <select class="form-select select2" id="add_categories" name="categories[]" multiple>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3" id="add_products_container" style="display: none;">
                        <label for="add_products" class="form-label">اختيار المنتجات</label>
                        <select class="form-select select2" id="add_products" name="products[]" multiple>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="add_is_active" name="is_active" checked>
                        <label class="form-check-label" for="add_is_active">الكوبون نشط</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="saveCoupon">حفظ</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Coupon Modal -->
<div class="modal fade" id="editCouponModal" tabindex="-1" aria-labelledby="editCouponModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCouponModalLabel">تعديل الكوبون</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCouponForm">
                    @csrf
                    <input type="hidden" id="edit_id" name="id">
                    
                    <div class="mb-3">
                        <label for="edit_code" class="form-label">كود الكوبون</label>
                        <input type="text" class="form-control" id="edit_code" name="code" readonly>
                        <span class="text-danger error-edit_code"></span>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">وصف الكوبون</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="2"></textarea>
                        <span class="text-danger error-edit_description"></span>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_type" class="form-label">نوع الخصم</label>
                            <select class="form-select" id="edit_type" name="type" required>
                                <option value="percent">نسبة مئوية</option>
                                <option value="fixed">مبلغ ثابت</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_value" class="form-label">قيمة الخصم</label>
                            <div class="input-group">
                                <input type="number" class="form-control" id="edit_value" name="value" min="0" step="0.01" required>
                                <span class="input-group-text" id="editValueSuffix">%</span>
                            </div>
                            <span class="text-danger error-edit_value"></span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_start_date" class="form-label">يبدأ من</label>
                            <input type="datetime-local" class="form-control" id="edit_start_date" name="start_date" required>
                            <span class="text-danger error-edit_start_date"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_end_date" class="form-label">ينتهي في</label>
                            <input type="datetime-local" class="form-control" id="edit_end_date" name="end_date" required>
                            <span class="text-danger error-edit_end_date"></span>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="edit_min_order_amount" class="form-label">الحد الأدنى للطلب</label>
                            <input type="number" class="form-control" id="edit_min_order_amount" name="min_order_amount" min="0" step="0.01">
                            <span class="text-danger error-edit_min_order_amount"></span>
                        </div>
                        <div class="col-md-6">
                            <label for="edit_max_uses" class="form-label">الحد الأقصى للاستخدام</label>
                            <input type="number" class="form-control" id="edit_max_uses" name="max_uses" min="0">
                            <span class="text-danger error-edit_max_uses"></span>
                        </div>
                    </div>
                    
                    {{-- <div class="mb-3">
                        <label for="edit_user_restriction" class="form-label">تقييد بالمستخدمين</label>
                        <select class="form-select" id="edit_user_restriction" name="user_restriction">
                            <option value="all">جميع المستخدمين</option>
                            <option value="new">المستخدمين الجدد فقط</option>
                            <option value="existing">المستخدمين الحاليين فقط</option>
                            <option value="specific">مستخدمين محددين</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="edit_specific_users_container" style="display: none;">
                        <label for="edit_specific_users" class="form-label">اختيار المستخدمين</label>
                        <select class="form-select select2" id="edit_specific_users" name="specific_users[]" multiple>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="edit_product_restriction" class="form-label">تقييد بالمنتجات</label>
                        <select class="form-select" id="edit_product_restriction" name="product_restriction">
                            <option value="all">جميع المنتجات</option>
                            <option value="categories">فئات محددة</option>
                            <option value="products">منتجات محددة</option>
                        </select>
                    </div>
                    
                    <div class="mb-3" id="edit_categories_container" style="display: none;">
                        <label for="edit_categories" class="form-label">اختيار الفئات</label>
                        <select class="form-select select2" id="edit_categories" name="categories[]" multiple>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="mb-3" id="edit_products_container" style="display: none;">
                        <label for="edit_products" class="form-label">اختيار المنتجات</label>
                        <select class="form-select select2" id="edit_products" name="products[]" multiple>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                    </div> --}}
                    
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="edit_is_active" name="is_active">
                        <label class="form-check-label" for="edit_is_active">الكوبون نشط</label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="updateCoupon">تحديث</button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteCouponModal" tabindex="-1" aria-labelledby="deleteCouponModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCouponModalLabel">تأكيد الحذف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد أنك تريد حذف هذا الكوبون؟</p>
                <p class="text-danger">هذا الإجراء لا يمكن التراجع عنه.</p>
                <input type="hidden" id="delete_coupon_id">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
            </div>
        </div>
    </div>
</div>