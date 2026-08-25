<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <a href="{{ route('admin.email_campaigns.index') }}" class="btn btn-sm btn-light text-dark rounded-circle border-0 shadow-sm" title="العودة للقائمة">
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small border border-white border-opacity-10">
                        <i class="fa-solid fa-chart-line text-warning"></i>
                        <span>{{ __('تقرير وسجلات الحملة') }}</span>
                    </div>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start text-break">
                    تفاصيل الحملة: {{ $campaign->title }}
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    عرض تقرير الإرسال ومعدل النجاح وسجلات الوصول الفردية لكل مستلم.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    @if ($campaign->failed_count > 0)
                        <form action="{{ route('admin.email_campaigns.resend_failed', $campaign->id) }}" method="POST"
                            onsubmit="return confirm('هل أنت متأكد من إعادة إرسال الرسائل الفاشلة فقط (عدد: {{ $campaign->failed_count }})؟');">
                            @csrf
                            <button type="submit" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm text-nowrap">
                                <i class="fa-solid fa-rotate-right me-1"></i> إعادة الفاشلة ({{ $campaign->failed_count }})
                            </button>
                        </form>
                    @endif
                    <a href="{{ route('admin.email_campaigns.index') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2 rounded-3 border-2 shadow-sm text-nowrap">
                        <i class="fa-solid fa-list me-1"></i> العودة للحملات
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="row mb-4 g-3">
        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100 bg-white stat-card">
                <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon bg-primary bg-opacity-10 text-primary rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-users fs-4"></i>
                    </div>
                    <h6 class="text-muted mb-1 small fw-semibold">المستهدفين</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($campaign->total_recipients) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100 bg-white stat-card">
                <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-circle-check fs-4"></i>
                    </div>
                    <h6 class="text-muted mb-1 small fw-semibold">تم الإرسال بنجاح</h6>
                    <h3 class="fw-bold text-success mb-0">{{ number_format($campaign->sent_count) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100 bg-white stat-card">
                <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon bg-danger bg-opacity-10 text-danger rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-circle-exclamation fs-4"></i>
                    </div>
                    <h6 class="text-muted mb-1 small fw-semibold">فشل الإرسال</h6>
                    <h3 class="fw-bold text-danger mb-0">{{ number_format($campaign->failed_count) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100 bg-white stat-card">
                <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon bg-info bg-opacity-10 text-info rounded-circle mb-3 d-flex align-items-center justify-content-center" style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-percent fs-4"></i>
                    </div>
                    <h6 class="text-muted mb-1 small fw-semibold">نسبة الإنجاز</h6>
                    <h3 class="fw-bold text-info mb-0">{{ $campaign->success_rate }}%</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Campaign Meta Details Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white mb-4 overflow-hidden">
        <div class="card-header bg-white py-3 px-4 border-0 d-flex align-items-center gap-2">
            <i class="fa-solid fa-circle-info me-1" style="color: #a40c72;"></i>
            <h5 class="fw-bold mb-0 text-dark">معلومات الحملة والمحتوى</h5>
        </div>
        <div class="card-body p-4">
            <div class="row g-3 mb-4">
                <div class="col-12 col-md-6">
                    <div class="p-3.5 bg-light rounded-3 h-100">
                        <p class="mb-2 text-break">
                            <strong class="text-secondary d-block d-sm-inline mb-1 mb-sm-0">موضوع الرسالة (Subject):</strong> 
                            <span class="fw-bold text-dark">{{ $campaign->subject }}</span>
                        </p>
                        <p class="mb-0">
                            <strong class="text-secondary d-block d-sm-inline mb-1 mb-sm-0">الجمهور المستهدف:</strong> 
                            <span class="badge px-3 py-1.5 rounded-pill fw-semibold" style="background-color: rgba(164, 12, 114, 0.1); color: #a40c72;">
                                {{ $campaign->target_audience_label }}
                            </span>
                        </p>
                    </div>
                </div>

                <div class="col-12 col-md-6">
                    <div class="p-3.5 bg-light rounded-3 h-100">
                        <p class="mb-2">
                            <strong class="text-secondary d-block d-sm-inline mb-1 mb-sm-0">الحالة الحالية:</strong>
                            @if ($campaign->status === 'completed')
                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1 rounded-3"><i class="fa-solid fa-check-circle me-1"></i> مكتملة</span>
                            @elseif ($campaign->status === 'sending')
                                <span class="badge bg-warning bg-opacity-10 text-dark border border-warning px-2.5 py-1 rounded-3"><i class="fa-solid fa-spinner fa-spin me-1"></i> جارٍ الإرسال في الخلفية</span>
                            @elseif ($campaign->status === 'queued')
                                <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2.5 py-1 rounded-3"><i class="fa-solid fa-clock me-1"></i> في الانتظار</span>
                            @else
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2.5 py-1 rounded-3"><i class="fa-solid fa-xmark-circle me-1"></i> فشلت</span>
                            @endif
                        </p>
                        <p class="mb-0">
                            <strong class="text-secondary d-block d-sm-inline mb-1 mb-sm-0">تاريخ الإنشاء:</strong> 
                            <span class="text-dark dir-ltr">{{ $campaign->created_at->format('Y-m-d H:i') }}</span>
                        </p>
                    </div>
                </div>
            </div>

            <div>
                <h6 class="fw-bold mb-2 text-dark"><i class="fa-solid fa-file-text me-1 text-secondary"></i> محتوى الرسالة المرسلة:</h6>
                <div class="p-3.5 bg-light rounded-3 text-dark fs-6 leading-relaxed text-break border-0" style="white-space: pre-line;">
                    {{ $campaign->content }}
                </div>
            </div>
        </div>
    </div>

    <!-- Logs Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white w-100 overflow-hidden mb-4" style="max-width: 100%;">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-list-check" style="color: #a40c72;"></i>
                <span>سجل الإرسال الفردي (Recipients Logs)</span>
            </div>
            <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill">{{ $logs->total() }} سجل</span>
        </div>

        <!-- Desktop & Tablet View -->
        <div class="card-body p-0 d-none d-md-block">
            <div class="table-responsive p-0">
                <table class="table table-hover align-middle mb-0 text-center text-nowrap" id="campaignLogsTable">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th scope="col" style="width: 60px;" class="py-3">#</th>
                            <th scope="col" class="py-3">اسم المستلم</th>
                            <th scope="col" class="py-3">البريد الإلكتروني</th>
                            <th scope="col" class="py-3">النوع</th>
                            <th scope="col" class="py-3">حالة الإرسال</th>
                            <th scope="col" class="py-3">تاريخ الإرسال</th>
                            <th scope="col" class="py-3">تفاصيل الخطأ (إن وجد)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($logs as $log)
                            <tr>
                                <td data-label="#" class="fw-bold text-secondary">{{ $log->id }}</td>
                                <td data-label="اسم المستلم" class="fw-bold text-dark px-3 text-start">{{ $log->recipient_name ?: '—' }}</td>
                                <td data-label="البريد الإلكتروني" class="px-3 text-start dir-ltr">{{ $log->recipient_email }}</td>
                                <td data-label="النوع">
                                    <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2.5 py-1 text-uppercase rounded-3">{{ $log->recipient_type }}</span>
                                </td>
                                <td data-label="حالة الإرسال">
                                    @if ($log->status === 'sent')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1 rounded-3"><i class="fa-solid fa-check me-1"></i> تم الإرسال</span>
                                    @elseif ($log->status === 'failed')
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2.5 py-1 rounded-3"><i class="fa-solid fa-xmark me-1"></i> فشل</span>
                                    @else
                                        <span class="badge bg-warning bg-opacity-10 text-dark border border-warning px-2.5 py-1 rounded-3"><i class="fa-solid fa-clock me-1"></i> قيد الانتظار</span>
                                    @endif
                                </td>
                                <td data-label="تاريخ الإرسال" class="small text-muted dir-ltr">
                                    {{ $log->sent_at ? $log->sent_at->format('Y-m-d H:i:s') : '—' }}
                                </td>
                                <td data-label="تفاصيل الخطأ" class="small text-danger text-truncate" style="max-width: 250px;" title="{{ $log->error_message }}">
                                    {{ $log->error_message ?: '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-5 text-muted">
                                    <i class="fa-solid fa-inbox fa-3x mb-3 text-secondary d-block opacity-50"></i>
                                    لا توجد سجلات تفصيلية متبقية لهذه الحملة حتى الآن.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View (< 768px) -->
        <div class="d-block d-md-none p-3">
            @forelse ($logs as $log)
                <div class="card border border-light-subtle mb-3 shadow-sm rounded-4 bg-white">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold text-dark mb-0 text-break pe-2">{{ $log->recipient_name ?: 'مستلم بدون اسم' }}</h6>
                            <span class="badge bg-light text-secondary border">#{{ $log->id }}</span>
                        </div>
                        
                        <p class="small text-muted mb-2 text-break dir-ltr"><i class="fa-solid fa-envelope me-1"></i> {{ $log->recipient_email }}</p>

                        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2 py-1 text-uppercase">{{ $log->recipient_type }}</span>
                            @if ($log->status === 'sent')
                                <span class="badge bg-success"><i class="fa-solid fa-check me-1"></i> تم الإرسال</span>
                            @elseif ($log->status === 'failed')
                                <span class="badge bg-danger"><i class="fa-solid fa-xmark me-1"></i> فشل</span>
                            @else
                                <span class="badge bg-warning text-dark"><i class="fa-solid fa-clock me-1"></i> قيد الانتظار</span>
                            @endif
                        </div>

                        @if ($log->error_message)
                            <div class="p-2 bg-danger bg-opacity-10 border border-danger border-opacity-25 rounded-3 small text-danger mb-2 text-break">
                                <i class="fa-solid fa-triangle-exclamation me-1"></i> {{ $log->error_message }}
                            </div>
                        @endif

                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i> {{ $log->sent_at ? $log->sent_at->format('Y-m-d H:i:s') : '—' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="fa-solid fa-inbox fa-3x mb-3 text-secondary d-block opacity-50"></i>
                    لا توجد سجلات تفصيلية متبقية لهذه الحملة حتى الآن.
                </div>
            @endforelse
        </div>

        @if ($logs->hasPages())
            <div class="card-footer bg-light py-3 px-3 px-md-4 text-center border-top">
                {{ $logs->links('vendor.pagination.dashboard-pagination') }}
            </div>
        @endif
    </div>
</div>

<style>
.stat-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
}
</style>
