<div class="container">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fa-solid fa-scale-balanced text-warning me-2"></i> إدارة الشكاوى و المنازعات
            </h1>
        </div>

        <!-- Filter Section -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.payment_proof.disputes') }}">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <input type="text" name="order_number" class="form-control" placeholder="رقم الطلب">
                        </div>
                        <div class="col-md-3">
                            <select name="status" class="form-select">
                                <option value="">كل الحالات</option>
                                <option value="open">مفتوح</option>
                                <option value="in_review">قيد المراجعة</option>
                                <option value="resolved">تم حله</option>
                                <option value="escalated">مرفوع للجهات</option>
                                <option value="rejected">مرفوض</option>
                                <option value="closed">مغلق</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa-solid fa-magnifying-glass"></i> بحث
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Disputes Table -->
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
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
                                    <td>{{ $dispute->id }}</td>
                                    <td>{{ $dispute->order_number }}</td>
                                    <td>
                                        {{ $dispute->customer_name ?? 'غير معروف' }}<br>
                                        <small class="text-muted">{{ $dispute->customer_email }}</small>
                                    </td>
                                    <td>{{ Str::limit($dispute->subject, 30) }}</td>
                                    <td>
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
                                    <td>{{ $dispute->created_at->format('Y-m-d') }}</td>
                                    <td class="d-flex justify-content-end gap-2 mt-3">
                                        <a href="{{ route('admin.payment_proof.dispute.show', $dispute->id) }}"
                                            class="btn btn-sm btn-primary">
                                            <i class="fa-solid fa-eye"></i> عرض
                                        </a>
                                        <!-- 🔹 زر تحميل PDF -->
                                        <a href="{{ route('admin.payment_proof.disputes.export.pdf', $dispute->id) }}"
                                            class="btn btn-outline-primary" target="_blank">
                                            📄 تحميل نسخة PDF
                                        </a>
                                        <form id="deleteDisputeForm"
                                            action="{{ route('admin.payment_proof.dispute.destroy', $dispute->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger mt-3" id="deleteDisputeBtn">
                                                🗑️ حذف النزاع نهائياً
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-muted">لا توجد شكاوى أو منازعات حالياً</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="mt-3">
                    {{ $disputes->links('vendor.pagination.dashboard-pagination') }}
                </div>
            </div>
        </div>
    </div>
</div>
