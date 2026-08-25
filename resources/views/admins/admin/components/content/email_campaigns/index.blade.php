<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-paper-plane text-warning"></i>
                    <span>{{ __('التسويق بالبريد الإلكتروني') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    📧 حملات البريد الإلكتروني (Email Marketing) 👋
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    إرسال رسائل ترويجية وتذكيرية لإعادة تنشيط البائعين والموردين غير النشطين وتتبع نسبة الوصول.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.email_campaigns.create') }}" class="btn btn-warning text-dark fw-bold px-4 py-2.5 rounded-3 border-0 shadow-sm text-nowrap">
                        <i class="fa-solid fa-plus me-1"></i> إنشاء حملة جديدة
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4 g-3">
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100 bg-white stat-card">
                <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon rounded-circle mb-3 d-flex align-items-center justify-content-center"
                        style="width: 52px; height: 52px; background-color: rgba(164, 12, 114, 0.1); color: #a40c72;">
                        <i class="fa-solid fa-bullhorn fs-4"></i>
                    </div>
                    <h6 class="text-muted mb-1 small fw-semibold">إجمالي الحملات</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalCampaigns) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100 bg-white stat-card">
                <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon bg-info bg-opacity-10 text-info rounded-circle mb-3 d-flex align-items-center justify-content-center"
                        style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-users-viewfinder fs-4"></i>
                    </div>
                    <h6 class="text-muted mb-1 small fw-semibold">إجمالي المستهدفين</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalRecipientsCount) }}</h3>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 text-center h-100 bg-white stat-card">
                <div class="card-body p-4 d-flex flex-column justify-content-center align-items-center">
                    <div class="stat-icon bg-success bg-opacity-10 text-success rounded-circle mb-3 d-flex align-items-center justify-content-center"
                        style="width: 52px; height: 52px;">
                        <i class="fa-solid fa-circle-check fs-4"></i>
                    </div>
                    <h6 class="text-muted mb-1 small fw-semibold">الرسائل المرسلة بنجاح</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ number_format($totalSentCount) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm rounded-4 bg-white w-100 overflow-hidden mb-4" style="max-width: 100%;">
        <div class="card-header bg-white border-0 fw-bold py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <i class="fa-solid fa-list-ul" style="color: #a40c72;"></i>
                <span>سجل الحملات البريدية</span>
            </div>
            <span class="badge bg-light text-dark border px-3 py-1.5 rounded-pill">{{ $campaigns->total() }} حملة</span>
        </div>

        <!-- Desktop & Tablet Table View -->
        <div class="card-body p-0 d-none d-md-block">
            <div class="table-responsive p-0">
                <table class="table table-hover align-middle mb-0 text-center text-nowrap" id="emailCampaignsTable">
                    <thead class="bg-light text-muted small">
                        <tr>
                            <th scope="col" style="width: 60px;" class="py-3">#</th>
                            <th scope="col" class="py-3">عنوان الحملة</th>
                            <th scope="col" class="py-3">موضوع الرسالة</th>
                            <th scope="col" class="py-3">الجمهور المستهدف</th>
                            <th scope="col" class="py-3">عدد المستهدفين</th>
                            <th scope="col" class="py-3">الناجحة / الفاشلة</th>
                            <th scope="col" class="py-3">الحالة</th>
                            <th scope="col" class="py-3">التاريخ</th>
                            <th scope="col" style="width: 120px;" class="py-3">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($campaigns as $campaign)
                            <tr>
                                <td data-label="#" class="fw-bold text-secondary">{{ $campaign->id }}</td>
                                <td data-label="عنوان الحملة" class="fw-bold text-dark text-start px-3">{{ $campaign->title }}</td>
                                <td data-label="موضوع الرسالة" class="text-start px-3 text-truncate" style="max-width: 220px;"
                                    title="{{ $campaign->subject }}">
                                    {{ $campaign->subject }}
                                </td>
                                <td data-label="الجمهور المستهدف">
                                    <span
                                        class="badge px-3 py-1.5 rounded-pill fw-semibold" style="background-color: rgba(164, 12, 114, 0.1); color: #a40c72;">
                                        {{ $campaign->target_audience_label }}
                                    </span>
                                </td>
                                <td data-label="عدد المستهدفين" class="fw-bold">{{ number_format($campaign->total_recipients) }}</td>
                                <td data-label="الناجحة / الفاشلة">
                                    <span class="text-success fw-bold">{{ number_format($campaign->sent_count) }}</span>
                                    /
                                    <span class="text-danger fw-bold">{{ number_format($campaign->failed_count) }}</span>
                                </td>
                                <td data-label="الحالة">
                                    @if ($campaign->status === 'completed')
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1 rounded-3"><i class="fa-solid fa-check-circle me-1"></i> مكتملة</span>
                                    @elseif ($campaign->status === 'sending')
                                        <span class="badge bg-warning bg-opacity-10 text-dark border border-warning px-2.5 py-1 rounded-3"><i class="fa-solid fa-spinner fa-spin me-1"></i> جارٍ الإرسال</span>
                                    @elseif ($campaign->status === 'queued')
                                        <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2.5 py-1 rounded-3"><i class="fa-solid fa-clock me-1"></i> في الانتظار</span>
                                    @elseif ($campaign->status === 'failed')
                                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2.5 py-1 rounded-3"><i class="fa-solid fa-xmark-circle me-1"></i> فشلت</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border px-2.5 py-1 rounded-3">مسودة</span>
                                    @endif
                                </td>
                                <td data-label="التاريخ" class="text-muted small">{{ $campaign->created_at->format('Y-m-d H:i') }}</td>
                                <td data-label="الإجراءات">
                                    <div class="d-flex justify-content-center gap-1">
                                        <a href="{{ route('admin.email_campaigns.show', $campaign->id) }}"
                                            class="btn btn-sm btn-outline-info rounded-3 px-2" title="عرض التفاصيل والسجلات">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        @if ($campaign->failed_count > 0)
                                            <form action="{{ route('admin.email_campaigns.resend_failed', $campaign->id) }}"
                                                method="POST" onsubmit="return confirm('هل أنت متأكد من إعادة إرسال الرسائل الفاشلة فقط (عدد: {{ $campaign->failed_count }})؟');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-outline-warning rounded-3 px-2"
                                                    title="إعادة إرسال الرسائل الفاشلة فقط ({{ $campaign->failed_count }})">
                                                    <i class="fa-solid fa-rotate-right"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.email_campaigns.destroy', $campaign->id) }}"
                                            method="POST" onsubmit="return confirm('هل أنت تأكد من حذف هذه الحملة؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2" title="حذف">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="py-5 text-muted">
                                    <i class="fa-solid fa-inbox fa-3x mb-3 text-secondary d-block opacity-50"></i>
                                    لا توجد أي حملات بريدية حالياً. اضغط على <strong>"إنشاء حملة جديدة"</strong> للبدء.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Mobile Card View (< 768px) -->
        <div class="d-block d-md-none p-3">
            @forelse ($campaigns as $campaign)
                <div class="card border border-light-subtle mb-3 shadow-sm rounded-4 bg-white">
                    <div class="card-body p-3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold text-dark mb-0 text-break pe-2">{{ $campaign->title }}</h6>
                            <span class="badge bg-light text-secondary border">#{{ $campaign->id }}</span>
                        </div>
                        <p class="small text-muted mb-2 text-break"><i class="fa-solid fa-envelope me-1"></i>
                            {{ $campaign->subject }}</p>

                        <div class="d-flex flex-wrap gap-2 mb-3">
                            <span
                                class="badge px-3 py-1.5 rounded-pill fw-semibold" style="background-color: rgba(164, 12, 114, 0.1); color: #a40c72;">
                                {{ $campaign->target_audience_label }}
                            </span>
                            @if ($campaign->status === 'completed')
                                <span class="badge bg-success"><i class="fa-solid fa-check-circle me-1"></i> مكتملة</span>
                            @elseif ($campaign->status === 'sending')
                                <span class="badge bg-warning text-dark"><i class="fa-solid fa-spinner fa-spin me-1"></i> جارٍ الإرسال</span>
                            @elseif ($campaign->status === 'queued')
                                <span class="badge bg-info"><i class="fa-solid fa-clock me-1"></i> في الانتظار</span>
                            @elseif ($campaign->status === 'failed')
                                <span class="badge bg-danger"><i class="fa-solid fa-xmark-circle me-1"></i> فشلت</span>
                            @else
                                <span class="badge bg-secondary">مسودة</span>
                            @endif
                        </div>

                        <div class="bg-light p-2.5 rounded-3 mb-3 small d-flex justify-content-between text-center">
                            <div>
                                <span class="text-muted d-block small">المستهدفين</span>
                                <strong class="text-dark">{{ number_format($campaign->total_recipients) }}</strong>
                            </div>
                            <div>
                                <span class="text-muted d-block small">ناجحة</span>
                                <strong class="text-success">{{ number_format($campaign->sent_count) }}</strong>
                            </div>
                            <div>
                                <span class="text-muted d-block small">فاشلة</span>
                                <strong class="text-danger">{{ number_format($campaign->failed_count) }}</strong>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center pt-2 border-top">
                            <span class="text-muted small"><i class="fa-regular fa-clock me-1"></i>
                                {{ $campaign->created_at->format('Y-m-d H:i') }}</span>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.email_campaigns.show', $campaign->id) }}"
                                    class="btn btn-sm btn-outline-info rounded-3 px-2">
                                    <i class="fa-solid fa-eye me-1"></i> عرض
                                </a>
                                @if ($campaign->failed_count > 0)
                                    <form action="{{ route('admin.email_campaigns.resend_failed', $campaign->id) }}"
                                        method="POST" onsubmit="return confirm('هل أنت متأكد من إعادة إرسال الرسائل الفاشلة فقط (عدد: {{ $campaign->failed_count }})؟');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-warning rounded-3 px-2"
                                            title="إعادة إرسال الرسائل الفاشلة فقط ({{ $campaign->failed_count }})">
                                            <i class="fa-solid fa-rotate-right me-1"></i> إعادة الفاشلة
                                        </button>
                                    </form>
                                @endif
                                <form action="{{ route('admin.email_campaigns.destroy', $campaign->id) }}"
                                    method="POST" onsubmit="return confirm('هل أنت تأكد من حذف هذه الحملة؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger rounded-3 px-2">
                                        <i class="fa-solid fa-trash me-1"></i> حذف
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-5 text-muted">
                    <i class="fa-solid fa-inbox fa-3x mb-3 text-secondary d-block opacity-50"></i>
                    لا توجد أي حملات بريدية حالياً. اضغط على <strong>"إنشاء حملة جديدة"</strong> للبدء.
                </div>
            @endforelse
        </div>

        @if ($campaigns->hasPages())
            <div class="card-footer bg-light py-3 px-3 px-md-4 text-center border-top">
                {{ $campaigns->links('vendor.pagination.dashboard-pagination') }}
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
