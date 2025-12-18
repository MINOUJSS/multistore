<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">ربط كوبون بقسم</h5>
            <a href="{{ route('supplier.categories-coupons') }}" class="btn btn-light btn-sm">رجوع</a>
        </div>

        <div class="card-body">
            <form action="{{ route('supplier.categories-coupons.store') }}" method="POST">
                @csrf

                <!-- اختيار الكوبون -->
                <div class="mb-3">
                    <label for="coupon_id" class="form-label fw-bold">اختر الكوبون</label>
                    <select name="coupon_id" id="coupon_id" class="form-select" required>
                        <option value="">-- اختر الكوبون --</option>
                        @foreach($coupons as $coupon)
                            <option value="{{ $coupon->id }}">
                                {{ $coupon->code }} ({{ $coupon->description ?? 'بدون وصف' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- اختيار القسم -->
                <div class="mb-3">
                    <label for="category_id" class="form-label fw-bold">اختر القسم</label>
                    <select name="category_id" id="category_id" class="form-select" required>
                        <option value="">-- اختر القسم --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- زر الحفظ -->
                <div class="text-end">
                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-link-45deg"></i> ربط الكوبون بالقسم
                    </button>
                </div>
            </form>

            <!-- عرض الروابط الحالية -->
            <hr>
            <h6 class="mt-4 mb-3 fw-bold">الروابط الحالية</h6>
            <table class="table table-bordered table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الكوبون</th>
                        <th>القسم</th>
                        <th>تاريخ الإنشاء</th>
                        <th>إجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($linkedCategories as $link)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $link->coupon->code }}</td>
                            <td>{{ $link->category->name }}</td>
                            <td>{{ $link->created_at->format('Y-m-d H:i') }}</td>
                            <td>
                                <form action="{{ route('supplier.categories-coupons.destroy', $link->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد من حذف هذا الربط؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">لا توجد روابط بعد.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
