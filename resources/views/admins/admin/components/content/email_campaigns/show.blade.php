<div class="container-fluid py-4">
    <!-- ===== Page Header ===== -->
    <div
        class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="fa-solid fa-chart-line text-primary me-2"></i>
                تفاصيل الحملة: {{ $campaign->title }}
            </h3>
            <p class="text-muted mb-0">عرض تقرير الإرسال وسجلات الوصول الفردية</p>
        </div>
        <div>
            <a href="{{ route('admin.email_campaigns.index') }}" class="btn btn-outline-secondary shadow-sm px-4">
                <i class="fa-solid fa-arrow-right me-1"></i> العودة للحملات
            </a>
        </div>
    </div>

    <!-- ===== Overview Cards ===== -->
    <div class="row mb-4 g-3">
        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-users fa-2x text-primary mb-2"></i>
                    <h6 class="text-muted mb-1">المستهدفين</h6>
                    <h4 class="fw-bold mb-0">{{ number_format($campaign->total_recipients) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-circle-check fa-2x text-success mb-2"></i>
                    <h6 class="text-muted mb-1">تم الإرسال بنجاح</h6>
                    <h4 class="fw-bold text-success mb-0">{{ number_format($campaign->sent_count) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-circle-exclamation fa-2x text-danger mb-2"></i>
                    <h6 class="text-muted mb-1">فشل الإرسال</h6>
                    <h4 class="fw-bold text-danger mb-0">{{ number_format($campaign->failed_count) }}</h4>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-3">
            <div class="card shadow-sm border-0 text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <i class="fa-solid fa-percent fa-2x text-info mb-2"></i>
                    <h6 class="text-muted mb-1">نسبة الإنجاز</h6>
                    <h4 class="fw-bold text-info mb-0">{{ $campaign->success_rate }}%</h4>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Campaign Meta Details ===== -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <div class="row g-3">
                <div class="col-12 col-md-6">
                    <p class="mb-2"><strong>موضوع الرسالة (Subject):</strong> {{ $campaign->subject }}</p>
                    <p class="mb-2"><strong>الجمهور المستهدف:</strong> <span
                            class="badge bg-primary fs-6">{{ $campaign->target_audience_label }}</span></p>
                </div>
                <div class="col-12 col-md-6">
                    <p class="mb-2"><strong>الحالة الحالية:</strong>
                        @if ($campaign->status === 'completed')
                            <span class="badge bg-success"><i class="fa-solid fa-check-circle me-1"></i> مكتملة</span>
                        @elseif ($campaign->status === 'sending')
                            <span class="badge bg-warning text-dark"><i class="fa-solid fa-spinner fa-spin me-1"></i>
                                جارٍ الإرسال في الخلفية</span>
                        @elseif ($campaign->status === 'queued')
                            <span class="badge bg-info"><i class="fa-solid fa-clock me-1"></i> في الانتظار</span>
                        @else
                            <span class="badge bg-danger">فشلت</span>
                        @endif
                    </p>
                    <p class="mb-2"><strong>تاريخ الإنشـاء:</strong> {{ $campaign->created_at->format('Y-m-d H:i') }}
                    </p>
                </div>
            </div>

            <hr class="my-3">

            <div>
                <h6 class="fw-bold mb-2">محتوى الرسالة المرسلة:</h6>
                <div class="p-3 bg-light rounded border text-dark" style="white-space: pre-line;">
                    {{ $campaign->content }}
                </div>
            </div>
        </div>
    </div>

    <!-- ===== Logs Table Card ===== -->
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="fw-bold mb-0">سجل الإرسال الفردي (Recipients Logs)</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-center">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>اسم المستلم</th>
                            <th>البريد الإلكتروني</th>
                            <th>النوع</th>
                            <th>حالة الإرسال</th>
                            <th>تاريخ الإرسال</th>
                            <th>تفاصيل الخطأ (إن وجد)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td>{{ $log->id }}</td>
                                <td class="fw-bold">{{ $log->recipient_name ?: '—' }}</td>
                                <td>{{ $log->recipient_email }}</td>
                                <td>
                                    <span class="badge bg-secondary text-uppercase">{{ $log->recipient_type }}</span>
                                </td>
                                <td>
                                    @if ($log->status === 'sent')
                                        <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> تم
                                            الإرسال</span>
                                    @elseif ($log->status === 'failed')
                                        <span class="badge bg-danger"><i class="fa-solid fa-xmark me-1"></i> فشل</span>
                                    @else
                                        <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i>
                                            قيد الانتظار</span>
                                    @endif
                                </td>
                                <td class="small text-muted">
                                    {{ $log->sent_at ? $log->sent_at->format('Y-m-d H:i:s') : '—' }}</td>
                                <td class="small text-danger text-truncate" style="max-width: 250px;">
                                    {{ $log->error_message ?: '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-muted">لا توجد سجلات تفصيلية متاحية لهذه الحملة حتى
                                    الآن.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if ($logs->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $logs->links('vendor.pagination.dashboard-pagination') }}
            </div>
        @endif
    </div>
</div>
