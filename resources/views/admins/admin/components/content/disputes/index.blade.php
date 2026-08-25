<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-scale-balanced text-warning"></i>
                    <span>{{ __('إدارة المنازعات والنزاهة') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    ⚖️ إدارة الشكاوى والمنازعات 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    متابعة ومعالجة كافة الشكاوى والمنازعات المالية والتشغيلية المرفوعة من قبل العملاء والبائعين.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-2 bg-white bg-opacity-15 rounded-3 border border-white border-opacity-20 text-white">
                    <i class="fa-solid fa-shield-halved text-warning fs-5"></i>
                    <div class="text-start">
                        <div class="small opacity-75">إجمالي الشكاوى</div>
                        <div class="fw-bold fs-5">{{ number_format($disputes->total()) }} نزاع</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center gap-2">
            <i class="fa-solid fa-filter" style="color: #a40c72;"></i>
            <span>خيارات البحث والتصفية في الشكاوى</span>
        </div>
        <div class="card-body p-4">
            <form method="GET" action="{{ route('admin.payment_proof.disputes') }}">
                <div class="row g-3 align-items-end">
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label fw-semibold text-dark small">رقم الطلب</label>
                        <input type="text" name="order_number" class="form-control bg-light border-0 rounded-3" placeholder="أدخل رقم الطلب..." value="{{ request('order_number') }}">
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <label class="form-label fw-semibold text-dark small">الحالة</label>
                        <select name="status" class="form-select bg-light border-0 rounded-3">
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
                        <button type="submit" class="btn text-white w-100 rounded-3 fw-bold py-2" style="background-color: #a40c72;">
                            <i class="fa-solid fa-magnifying-glass me-1"></i> بحث
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Disputes Table Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white w-100 overflow-hidden mb-4" style="max-width: 100%;">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-list-ul" style="color: #a40c72;"></i>
                <span>قائمة سجل الشكاوى والمنازعات</span>
            </div>
            <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill">{{ $disputes->total() }} نزاع</span>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive p-0">
                <table class="table table-hover align-middle text-center mb-0" id="disputesTable">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th class="py-3">#</th>
                            <th class="py-3">رقم الطلب</th>
                            <th class="py-3">الزبون</th>
                            <th class="py-3">موضوع النزاع</th>
                            <th class="py-3">الحالة</th>
                            <th class="py-3">تاريخ الإنشاء</th>
                            <th class="py-3">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($disputes as $dispute)
                            <tr>
                                <td data-label="#" class="fw-bold text-secondary">{{ $dispute->id }}</td>
                                <td data-label="رقم الطلب" class="fw-bold text-dark">{{ $dispute->order_number }}</td>
                                <td data-label="الزبون" class="text-start px-3">
                                    <div class="fw-bold text-dark">{{ $dispute->customer_name ?? 'غير معروف' }}</div>
                                    <small class="text-muted dir-ltr d-block">{{ $dispute->customer_email }}</small>
                                </td>
                                <td data-label="موضوع النزاع" class="text-start px-3">{{ Str::limit($dispute->subject, 30) }}</td>
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
                                    <span class="badge bg-{{ $statusColors[$dispute->status] ?? 'secondary' }} px-3 py-1.5 rounded-pill fw-semibold">
                                        {{ __("status.$dispute->status") }}
                                    </span>
                                </td>
                                <td data-label="تاريخ الإنشاء" class="text-muted small">{{ $dispute->created_at->format('Y-m-d') }}</td>
                                <td data-label="إجراءات">
                                    <div class="d-flex justify-content-center align-items-center gap-1 flex-wrap">
                                        <a href="{{ route('admin.payment_proof.dispute.show', $dispute->id) }}"
                                            class="btn btn-sm btn-primary rounded-3 px-2.5">
                                            <i class="fa-solid fa-eye me-1"></i> عرض
                                        </a>
                                        <!-- 🔹 زر تحميل PDF -->
                                        <a href="{{ route('admin.payment_proof.disputes.export.pdf', $dispute->id) }}"
                                            class="btn btn-sm btn-outline-primary rounded-3 px-2.5" target="_blank">
                                            <i class="fa-solid fa-file-pdf me-1"></i> PDF
                                        </a>
                                        <form action="{{ route('admin.payment_proof.dispute.destroy', $dispute->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا النزاع؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2.5">
                                                <i class="fa-solid fa-trash me-1"></i> حذف
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted py-5">
                                    <i class="fa-solid fa-box-open fs-2 mb-2 d-block opacity-50"></i>
                                    لا توجد شكاوى أو منازعات حالياً.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="p-3 text-center border-top bg-light">
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
