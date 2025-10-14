<div class="container py-4">
    <h4 class="mb-4"><i class="fa fa-tags me-2"></i> ربط الكوبونات بالمنتجات</h4>

    <!-- 🔹 اختيار الكوبون -->
    <div class="card mb-4">
        <div class="card-header">اختيار كوبون</div>
        <div class="card-body">
            <form id="couponProductForm" action="{{ route('supplier.products-coupons.store') }}" method="POST">
                @csrf
                <div class="row g-3 align-items-center">
                    <div class="col-md-6">
                        <label class="form-label">الكوبون</label>
                        <select name="coupon_id" id="coupon_id" class="form-select" required>
                            <option value="">-- اختر الكوبون --</option>
                            @foreach($coupons as $coupon)
                                <option value="{{ $coupon->id }}">{{ $coupon->code }} - {{ $coupon->description }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">المنتجات</label>
                        <select name="product_ids[]" id="product_ids" class="form-select select2" multiple required>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}">{{ $product->name }}</option>
                            @endforeach
                        </select>
                        <small class="text-muted d-block mt-1">يمكنك اختيار أكثر من منتج.</small>
                    </div>

                    <div class="col-12 mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa fa-link"></i> ربط الكوبون بالمنتجات المحددة
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- 🔹 جدول العلاقات الحالية -->
    <div class="card">
        <div class="card-header">العلاقات الحالية</div>
        <div class="card-body table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>الكوبون</th>
                        <th>المنتج</th>
                        <th>الخصم</th>
                        <th>تاريخ الإنشاء</th>
                        <th class="text-center">إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($relations as $relation)
                        <tr>
                            <td>{{ $relation->coupon->code }}</td>
                            <td>{{ $relation->product->name }}</td>
                            <td>
                                @if($relation->coupon->type == 'fixed')
                                    {{ number_format($relation->coupon->value, 2) }} دج
                                @else
                                    {{ $relation->coupon->value }}%
                                @endif
                            </td>
                            <td>{{ $relation->created_at->format('Y-m-d H:i') }}</td>
                            <td class="text-center">
                                <form action="{{ route('supplier.products-coupons.destroy', $relation->id) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i> حذف
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">لا توجد علاقات بعد</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>


@push('scripts')
<script>
$(document).ready(function () {
    // تفعيل select2
    $('.select2').select2({ dir: "rtl", width: '100%' });

    // SweetAlert للحذف
    $('.delete-form').on('submit', function (e) {
        e.preventDefault();
        let form = this;
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "سيتم حذف هذا الربط نهائيًا.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء',
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
