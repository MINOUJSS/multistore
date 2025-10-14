<div class="container mt-5">
    <h2 class="mb-4 text-center">إعدادات TikTok Pixel</h2>
@php
    $plan_id=get_supplier_data(auth()->user()->tenant_id)->plan_subscription->plan_id;
    $tiktok_pixle=get_user_data(auth()->user()->tenant_id)->tiktok_pixle;
    $apps_count=$tiktok_pixle->count();
@endphp
    <!-- زر فتح المودال -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addPixelModal"  @if (($plan_id==1) ||($plan_id==2 && $apps_count>=1) || ($plan_id==3 && $apps_count>=4))
      disabled  
    @endif>
        <i class="fas fa-plus"></i> إضافة 
    </button>

    <!-- جدول عرض الإعدادات -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>رقم</th>
                        <th>معرف البكسل (Pixel ID)</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pixels as $index => $pixel)
                    <tr id="row-{{ $pixel->id }}">
                        <td>{{ $index + 1 }}</td>
                        <td>{{ json_decode($pixel->data)->pixel_id }}</td>
                        <td>
                            <span class="badge {{ $pixel->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                {{ $pixel->status === 'active' ? 'مفعل' : 'غير مفعل' }}
                            </span>
                        </td>
                        <td>
                            <!-- زر التعديل -->
                            <button class="btn btn-warning btn-sm edit-btn" 
                                    data-id="{{ $pixel->id }}"
                                    data-pixel_id="{{ json_decode($pixel->data)->pixel_id }}"
                                    data-status="{{ $pixel->status }}">
                                <i class="fas fa-edit"></i> تعديل
                            </button>

                            <!-- زر الحذف -->
                            <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $pixel->id }}">
                                <i class="fas fa-trash"></i> حذف
                            </button>
                        </td>
                    </tr> 
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- مودال (نموذج إضافة الإعدادات) -->
<div class="modal fade" id="addPixelModal" tabindex="-1" aria-labelledby="addPixelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPixelModalLabel">إضافة إعدادات TikTok Pixel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="AddTikTokPixelForm">
                    <input type="hidden" name="app_name" value="tiktok_pixel">
                    
                    <div class="mb-3">
                        <label class="form-label">معرف البكسل (Pixel ID)</label>
                        <input type="text" name="pixel_id" id="pixel_id" class="form-control" placeholder="XXXXXXXXXX">
                        <div class="invalid-feedback" id="error-pixel_id"></div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" id="status" checked>
                        <label class="form-check-label" for="status">تفعيل البكسل</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100">حفظ الإعدادات</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- مودال تعديل الإعدادات -->
<div class="modal fade" id="editPixelModal" tabindex="-1" aria-labelledby="editPixelModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editPixelModalLabel">تعديل إعدادات TikTok Pixel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <form id="EditTikTokPixelForm">
                    <input type="hidden" name="id" id="edit_id"> <!-- ✅ حفظ الـ id هنا -->
                    <input type="hidden" name="app_name" value="tiktok_pixel">
                    
                    <div class="mb-3">
                        <label class="form-label">معرف البكسل (Pixel ID)</label>
                        <input type="text" name="pixel_id" id="edit_pixel_id" class="form-control" placeholder="XXXXXXXXXX">
                        <div class="invalid-feedback" id="error-pixel_id"></div>
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" name="status" id="edit_status" checked>
                        <label class="form-check-label" for="edit_status">تفعيل البكسل</label>
                    </div>

                    <button type="submit" class="btn btn-success w-100">حفظ الإعدادات</button>
                </form>
            </div>
        </div>
    </div>
</div>
