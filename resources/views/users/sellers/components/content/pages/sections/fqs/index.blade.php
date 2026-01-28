<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800">إدارة الأسئلة الشائعة</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">قائمة الأسئلة</h6>
                    <button id="addFaqBtn" class="btn btn-primary">
                        <i class="fas fa-plus"></i> إضافة سؤال جديد
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="faqsTable">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="25%">السؤال</th>
                                    <th width="40%">الإجابة</th>
                                    <th width="10%">الترتيب</th>
                                    <th width="10%">الحالة</th>
                                    <th width="10%">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faqs as $index => $faq)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ Str::limit($faq->question, 50) }}</td>
                                        <td>{{ Str::limit($faq->answer, 70) }}</td>
                                        <td>{{ $faq->order }}</td>
                                        <td>
                                            @if ($faq->status == 'active')
                                                <span class="badge bg-success">نشط</span>
                                            @else
                                                <span class="badge bg-danger">غير نشط</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-circle btn-primary edit-faq"
                                                data-id="{{ $faq->id }}">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-circle btn-danger delete-faq"
                                                data-id="{{ $faq->id }}">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
                        <!---->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="{{route('seller.faqs.updateStatus')}}" method="POST" class="row">
                        @csrf
                        <!-- التشيك بوكس على اليسار -->
                        <div class="col-md-6">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="faqs_status" name="faqs_status"
                                    @if ($faqs_status->value == 'true') checked @endif>
                                <label class="form-check-label" for="faqs_status">تفعيل قسم الأسئلة الشائعة</label>
                            </div>
                        </div>

                        <!-- الزر على اليمين -->
                        <div class="col-md-6 text-end">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                        </div>
                    </form>
                </div>
            </div>
            <!---->
        </div>
    </div>
</div>

{{-- //modals --}}

<!-- Add FAQ Modal -->
<div class="modal fade" id="addFaqModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">إضافة سؤال جديد</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="addFaqForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="question">السؤال</label>
                        <input type="text" class="form-control" id="question" name="question" required>
                        <div class="invalid-feedback error-question"></div>
                    </div>

                    <div class="form-group">
                        <label for="answer">الإجابة</label>
                        <textarea class="form-control" id="answer" name="answer" rows="5" required></textarea>
                        <div class="invalid-feedback error-answer"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="order">ترتيب العرض</label>
                                <input type="number" class="form-control" id="order" name="order" value="0"
                                    min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="status">الحالة</label>
                                <select class="form-control" id="status" name="status">
                                    <option value="active" selected>نشط</option>
                                    <option value="inactive">غير نشط</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit FAQ Modal -->
<div class="modal fade" id="editFaqModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">تعديل السؤال</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <form id="editFaqForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_faq_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_question">السؤال</label>
                        <input type="text" class="form-control" id="edit_question" name="question" required>
                        <div class="invalid-feedback error-question"></div>
                    </div>

                    <div class="form-group">
                        <label for="edit_answer">الإجابة</label>
                        <textarea class="form-control" id="edit_answer" name="answer" rows="5" required></textarea>
                        <div class="invalid-feedback error-answer"></div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_order">ترتيب العرض</label>
                                <input type="number" class="form-control" id="edit_order" name="order"
                                    min="0">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_status">الحالة</label>
                                <select class="form-control" id="edit_status" name="status">
                                    <option value="active">نشط</option>
                                    <option value="inactive">غير نشط</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>
{{-- sweet alert  --}}
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
