<div class="container-fluid py-4 overflow-hidden" style="max-width: 100%;">
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <h1 class="h3 mb-0 text-gray-800 fw-bold">
            <i class="fa-solid fa-scale-balanced text-warning me-2"></i> إدارة الشكاوى و المنازعات
        </h1>
    </div>

    <!-- Filter Section -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.payment_proof.disputes') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label fw-semibold">رقم الطلب</label>
                        <input type="text" name="order_number" class="form-control" placeholder="رقم الطلب" value="{{ request('order_number') }}">
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label fw-semibold">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="">كل الحالات</option>
                            <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>مفتوح</option>
                            <option value="in_review" {{ request('status') == 'in_review' ? 'selected' : '' }}>قيد المراجعة</option>
                            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>تم حله</option>
                            <option value="escalated" {{ request('status') == 'escalated' ? 'selected' : '' }}>مرفوع للجهات</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>مرفوض</option>
                            <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>مغلق</option>
                        </select>
                    </div>
                    <div class="col-12 col-md-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> بحث
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Disputes Table Card -->
    <div class="card shadow-sm border-0 w-100 overflow-hidden" style="max-width: 100%;">
        <div class="card-body p-0">
            <div class="table-responsive p-0">
                <table class="table table-hover align-middle text-center mb-0" id="disputesTable">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>رقم الطلب</th>
                            <th>الزبون</th>
                            <th>موضوع النزاع</th>
                            <th>الحالة</th>
                            <th>تاريخ الإنشاء</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($disputes as $dispute)
                            <tr>
                                <td data-label="#">{{ $dispute->id }}</td>
                                <td data-label="رقم الطلب" class="fw-semibold">{{ $dispute->order_number }}</td>
                                <td data-label="الزبون">
                                    {{ $dispute->customer_name ?? 'غير معروف' }}<br>
                                    <small class="text-muted">{{ $dispute->customer_email }}</small>
                                </td>
                                <td data-label="موضوع النزاع">{{ Str::limit($dispute->subject, 30) }}</td>
                                <td data-label="الحالة">
                                    @php
                                        $statusColors = [
                                            'open' => 'warning',
                                            'in_review' => 'info',
                                            'resolved' => 'success',
                                            'escalated' => 'dark',
                                            'rejected' => 'danger',
                                            'closed' => 'secondary',
                                        ];
                                    @endphp
                                    <span class="badge bg-{{ $statusColors[$dispute->status] ?? 'secondary' }}">
                                        {{ __("status.$dispute->status") }}
                                    </span>
                                </td>
                                <td data-label="تاريخ الإنشاء">{{ $dispute->created_at->format('Y-m-d') }}</td>
                                <td data-label="إجراءات">
                                    <div class="d-flex justify-content-center justify-content-lg-end align-items-center gap-2 flex-wrap">
                                        <a href="{{ route('admin.payment_proof.dispute.show', $dispute->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-eye me-1"></i> عرض
                                        </a>
                                        <!-- 🔹 زر تحميل PDF -->
                                        <a href="{{ route('admin.payment_proof.disputes.export.pdf', $dispute->id) }}"
                                            class="btn btn-sm btn-outline-primary" target="_blank">
                                            📄 تحميل PDF
                                        </a>
                                        <form action="{{ route('admin.payment_proof.dispute.destroy', $dispute->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا النزاع؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                🗑️ حذف
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted py-4">لا توجد شكاوى أو منازعات حالياً</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-3 text-center">
                {{ $disputes->links('vendor.pagination.dashboard-pagination') }}
            </div>
        </div>
    </div>
</div>

<style>
/* Pure CSS Responsive Table for #disputesTable */
@media (max-width: 991.98px) {
    #disputesTable, 
    #disputesTable tbody, 
    #disputesTable tr, 
    #disputesTable td {
        display: block;
        width: 100% !important;
        box-sizing: border-box;
    }
    
    #disputesTable thead {
        display: none !important;
    }
    
    #disputesTable tbody tr {
        background: #ffffff;
        border: 1px solid #e9ecef !important;
        border-radius: 14px;
        margin-bottom: 1.25rem;
        padding: 0.5rem 0.75rem;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.03);
    }
    
    #disputesTable tbody td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.65rem 0.75rem;
        border: none !important;
        border-bottom: 1px dashed #e9ecef !important;
        white-space: normal !important;
        text-align: left;
    }
    
    #disputesTable tbody td:last-child {
        border-bottom: none !important;
    }
    
    #disputesTable tbody td::before {
        content: attr(data-label);
        font-weight: 700;
        color: #495057;
        font-size: 0.85rem;
        margin-left: 1rem;
        flex-shrink: 0;
    }
}
</style>
