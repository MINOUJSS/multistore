<div class="container-fluid py-3 px-3 px-md-4">
    <!-- Hero Welcome Banner -->
    <div class="proofs-hero p-4 p-md-5 mb-4 shadow-sm text-white position-relative overflow-hidden"
         style="background: linear-gradient(135deg, #5b073e 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-15 backdrop-blur">
                    <i class="fa-solid fa-file-circle-xmark text-warning"></i>
                    <span class="fw-semibold">{{ __('إثباتات الدفع المرفوضة') }}</span>
                    <span class="opacity-50">|</span>
                    <span class="opacity-90">{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    إثباتات الدفع المرفوضة ⚠️
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed fs-6">
                    متابعة ومعالجة إثباتات الدفع التي تم رفضها من قِبل الإدارة، ومعرفة أسباب الرفض للتصحيح وإعادة الإرسال بكل سهولة.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <button type="button" class="btn btn-warning text-dark fw-bold px-3 py-2.5 rounded-3 border-0 shadow-sm d-inline-flex align-items-center gap-2" onclick="location.reload();">
                        <i class="fa-solid fa-rotate-right"></i>
                        <span>تحديث البيانات</span>
                    </button>
                    @if(Route::has('seller.billing.invoice.create'))
                        <a href="{{ route('seller.billing.invoice.create') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2.5 rounded-3 border-2 shadow-sm d-inline-flex align-items-center gap-2">
                            <i class="fa-solid fa-file-invoice"></i>
                            <span>إرسال إثبات جديد</span>
                        </a>
                    @elseif(Route::has('seller.billing'))
                        <a href="{{ route('seller.billing') }}" class="btn btn-outline-light text-white fw-bold px-3 py-2.5 rounded-3 border-2 shadow-sm d-inline-flex align-items-center gap-2">
                            <i class="fa-solid fa-file-invoice"></i>
                            <span>الفواتير</span>
                        </a>
                    @endif
                </div>
            </div>
        </div>
        <!-- Decorative Glow Background Effects -->
        <div class="position-absolute rounded-circle bg-white opacity-10" style="width: 250px; height: 250px; top: -60px; left: -60px; pointer-events: none; filter: blur(40px);"></div>
        <div class="position-absolute rounded-circle bg-warning opacity-10" style="width: 180px; height: 180px; bottom: -40px; right: 10%; pointer-events: none; filter: blur(30px);"></div>
    </div>

    <!-- Indicators / Stat Cards Grid -->
    <div class="row g-3 mb-4">
        <!-- Total Refused Proofs -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="stat-icon-wrapper bg-plum-subtle text-plum">
                            <i class="fa-solid fa-file-circle-xmark fa-lg"></i>
                        </span>
                        <span class="badge bg-plum-subtle text-plum px-2.5 py-1 rounded-pill fw-semibold small">الإجمالي</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">إجمالي المرفوضات</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $proofs->total() }}</h3>
                </div>
            </div>
        </div>

        <!-- Current Page Items -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="stat-icon-wrapper bg-rose-subtle text-rose">
                            <i class="fa-solid fa-list-check fa-lg"></i>
                        </span>
                        <span class="badge bg-rose-subtle text-rose px-2.5 py-1 rounded-pill fw-semibold small">في الصفحة</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">المعروض حالياً</h6>
                    <h3 class="fw-bold mb-0 text-dark">{{ $proofs->count() }}</h3>
                </div>
            </div>
        </div>

        <!-- Latest Refusal -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="stat-icon-wrapper bg-amber-subtle text-amber">
                            <i class="fa-solid fa-clock-rotate-left fa-lg"></i>
                        </span>
                        <span class="badge bg-amber-subtle text-amber px-2.5 py-1 rounded-pill fw-semibold small">النشاط</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">آخر عملية رفض</h6>
                    <div class="fw-bold text-dark fs-6 mt-1 text-truncate" title="{{ $proofs->first()?->created_at?->format('Y-m-d H:i') ?? 'لا يوجد' }}">
                        {{ $proofs->first() ? $proofs->first()->created_at->diffForHumans() : 'لا يوجد' }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Status -->
        <div class="col-xl-3 col-sm-6">
            <div class="card border-0 shadow-sm rounded-4 h-100 bg-white dashboard-stat-card">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="stat-icon-wrapper bg-warning-subtle text-warning">
                            <i class="fa-solid fa-triangle-exclamation fa-lg"></i>
                        </span>
                        <span class="badge bg-danger-subtle text-danger px-2.5 py-1 rounded-pill fw-semibold small">تنبيه هام</span>
                    </div>
                    <h6 class="text-muted fw-semibold small mb-1">الإجراء المطلوب</h6>
                    <div class="fw-bold text-danger fs-6 mt-1">
                        مراجعة سبب الرفض
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 bg-white">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center gap-2">
                <div class="filter-icon-box bg-plum-subtle text-plum rounded-3 p-2">
                    <i class="fa-solid fa-filter fs-6"></i>
                </div>
                <h5 class="fw-bold mb-0 text-dark fs-6">تصفية وبحث الإثباتات</h5>
            </div>
            @if(request()->hasAny(['search', 'admin', 'date', 'user']))
                <a href="{{ Route::has('seller.payments_proofs_refuseds') ? route('seller.payments_proofs_refuseds') : url()->current() }}" class="btn btn-sm btn-light text-muted rounded-pill px-3 border-0">
                    <i class="fa-solid fa-xmark me-1"></i> إلغاء التصفية
                </a>
            @endif
        </div>
        <div class="card-body p-4">
            <form action="{{ Route::has('seller.payments_proofs_refuseds') ? route('seller.payments_proofs_refuseds') : url()->current() }}" method="GET">
                <div class="row g-3">
                    <!-- Live Search / General Search -->
                    <div class="col-lg-5 col-md-6">
                        <label for="liveSearchInput" class="form-label fw-semibold text-secondary small">
                            <i class="fa-solid fa-magnifying-glass me-1 text-plum"></i> بحث سريع (السبب / رقم الإثبات / المستخدم)
                        </label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-light-subtle text-muted">
                                <i class="fa-solid fa-search"></i>
                            </span>
                            <input type="text" class="form-control rounded-start-0 border-light-subtle shadow-none" id="liveSearchInput" name="search" placeholder="اكتب للبحث الفوري أو اضغط بحث..." value="{{ request('search', request('user')) }}">
                        </div>
                    </div>

                    <!-- Admin Search -->
                    <div class="col-lg-3 col-md-6">
                        <label for="search_admin" class="form-label fw-semibold text-secondary small">
                            <i class="fa-solid fa-user-shield me-1 text-plum"></i> المسؤول المراجع
                        </label>
                        <input type="text" class="form-control rounded-3 border-light-subtle shadow-none" id="search_admin" name="admin" placeholder="اسم المسؤول..." value="{{ request('admin') }}">
                    </div>

                    <!-- Date Search -->
                    <div class="col-lg-2 col-md-6">
                        <label for="search_date" class="form-label fw-semibold text-secondary small">
                            <i class="fa-solid fa-calendar me-1 text-plum"></i> تاريخ الإرسال
                        </label>
                        <input type="date" class="form-control rounded-3 border-light-subtle shadow-none" id="search_date" name="date" value="{{ request('date') }}">
                    </div>

                    <!-- Submit Button -->
                    <div class="col-lg-2 col-md-6 d-flex align-items-end">
                        <button type="submit" class="btn btn-plum w-100 py-2 rounded-3 fw-semibold shadow-sm d-flex align-items-center justify-content-center gap-2">
                            <i class="fa-solid fa-filter"></i>
                            <span>تطبيق البحث</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Table Section -->
    <div class="card border-0 shadow-sm rounded-4 bg-white overflow-hidden mb-4">
        <div class="card-header bg-white border-0 py-3 px-4 d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="d-flex align-items-center gap-2">
                <span class="badge bg-plum-subtle text-plum p-2 rounded-circle">
                    <i class="fa-solid fa-table-list"></i>
                </span>
                <h5 class="fw-bold mb-0 text-dark fs-6">سجل الإثباتات المرفوضة</h5>
            </div>
            <div class="small text-muted">
                إجمالي النتائج: <span class="fw-bold text-plum">{{ $proofs->total() }}</span> إثبات
            </div>
        </div>

        <div class="table-responsive">
            <table class="table proofs-refused-table align-middle mb-0" id="proofsRefusedTable">
                <thead>
                    <tr>
                        <th class="text-center" style="width: 80px;"># المعرف</th>
                        <th>المستخدم</th>
                        <th>المسؤول المراجع</th>
                        <th>تاريخ الإرسال</th>
                        <th>سبب الرفض</th>
                        <th>المرفق</th>
                        <th class="text-center" style="width: 170px;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody id="proofsTableBody">
                    @forelse ($proofs as $proof)
                        <tr class="proof-row">
                            <!-- ID -->
                            <td class="text-center" data-label="# المعرف">
                                <span class="badge bg-light text-dark font-monospace px-2 py-1 rounded-2 border">
                                    #{{ $proof->id }}
                                </span>
                            </td>

                            <!-- User -->
                            <td data-label="المستخدم">
                                <div class="d-flex align-items-center gap-2">
                                    <div class="user-avatar-placeholder bg-light rounded-circle text-muted d-flex align-items-center justify-content-center border" style="width: 34px; height: 34px;">
                                        <i class="fa-solid fa-user small"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark small">{{ $proof->user->name ?? 'غير معروف' }}</div>
                                        @if(!empty($proof->user?->email))
                                            <div class="text-muted smaller text-truncate" style="max-width: 160px;">{{ $proof->user->email }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Admin -->
                            <td data-label="المسؤول المراجع">
                                <span class="badge bg-light text-secondary border px-2.5 py-1 rounded-pill fw-medium small">
                                    <i class="fa-solid fa-user-shield me-1 text-plum"></i>
                                    {{ $proof->admin->name ?? 'الإدارة' }}
                                </span>
                            </td>

                            <!-- Created Date -->
                            <td data-label="تاريخ الإرسال">
                                <div class="text-secondary small">
                                    <i class="fa-regular fa-calendar me-1 text-muted"></i>
                                    {{ $proof->created_at ? $proof->created_at->format('Y-m-d') : '-' }}
                                </div>
                                <div class="text-muted smaller font-monospace">
                                    <i class="fa-regular fa-clock me-1"></i>
                                    {{ $proof->created_at ? $proof->created_at->format('H:i') : '' }}
                                </div>
                            </td>

                            <!-- Refuse Reason -->
                            <td data-label="سبب الرفض">
                                <div class="p-2 rounded-3 bg-danger bg-opacity-10 border border-danger border-opacity-10 text-danger small text-start" style="max-width: 320px; line-height: 1.5;">
                                    <i class="fa-solid fa-circle-exclamation me-1"></i>
                                    <span class="proof-reason-text">{{ $proof->refuse_reason ?? 'لا يوجد سبب محدد مسجل' }}</span>
                                </div>
                            </td>

                            <!-- Attachment -->
                            <td data-label="المرفق">
                                @if(!empty($proof->proof_path))
                                    @php
                                        $ext = pathinfo($proof->proof_path, PATHINFO_EXTENSION);
                                        $isImg = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'webp', 'gif']);
                                    @endphp
                                    <a href="{{ asset($proof->proof_path) }}" target="_blank" class="btn btn-sm btn-light border rounded-pill px-2.5 py-1 text-dark small d-inline-flex align-items-center gap-1 shadow-none" title="معاينة الملف المرفق">
                                        <i class="fa-solid {{ $isImg ? 'fa-image text-plum' : 'fa-paperclip text-secondary' }}"></i>
                                        <span>عرض</span>
                                    </a>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="text-center" data-label="الإجراءات">
                                <div class="d-flex align-items-center gap-1.5 justify-content-center flex-wrap">
                                    @if (Route::has('seller.payments_proofs_refused.show'))
                                        <a href="{{ route('seller.payments_proofs_refused.show', $proof->id) }}" class="btn btn-sm btn-plum text-white rounded-3 shadow-sm px-3 fw-semibold d-inline-flex align-items-center gap-1.5">
                                            <i class="fa-solid fa-eye"></i>
                                            <span>التفاصيل</span>
                                        </a>
                                    @endif

                                    @if (Route::has('seller.proofs.refused.chat.index'))
                                        <a href="{{ route('seller.proofs.refused.chat.index', $proof->id) }}" class="btn btn-sm btn-outline-plum rounded-3 shadow-sm px-2.5" title="محادثة الإدارة حول الرفض">
                                            <i class="fa-solid fa-comments"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="py-4">
                                    <div class="d-inline-flex p-3 rounded-circle bg-success bg-opacity-10 text-success mb-3">
                                        <i class="fa-solid fa-circle-check fa-3x"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-1">سجل نظيف! لا توجد إثباتات دفع مرفوضة</h5>
                                    <p class="text-muted small mb-0">جميع مدفوعاتك وإثباتاتك تمت مراجعتها بنجاح أو لا توجد أي عمليات مرفوضة حالياً.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($proofs->hasPages())
            <div class="card-footer bg-white border-0 py-3 d-flex justify-content-center">
                {{ $proofs->appends(request()->except('page'))->links() }}
            </div>
        @endif
    </div>
</div>

<style>
/* ================= THEME COLOR TOKENS ================= */
.text-plum { color: #a40c72 !important; }
.bg-plum { background-color: #a40c72 !important; }

.btn-plum {
    background: linear-gradient(135deg, #a40c72 0%, #be0681 100%) !important;
    color: #ffffff !important;
    border: none !important;
    transition: all 0.2s ease-in-out;
}
.btn-plum:hover {
    background: linear-gradient(135deg, #8a0a60 0%, #a40c72 100%) !important;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(164, 12, 114, 0.25) !important;
}

.btn-outline-plum {
    color: #a40c72 !important;
    border: 1.5px solid #a40c72 !important;
    background-color: transparent !important;
    transition: all 0.2s ease-in-out;
}
.btn-outline-plum:hover {
    background-color: #a40c72 !important;
    color: #ffffff !important;
}

.bg-plum-subtle { background-color: rgba(164, 12, 114, 0.08) !important; }
.bg-rose-subtle { background-color: rgba(244, 63, 94, 0.08) !important; }
.text-rose { color: #f43f5e !important; }
.bg-amber-subtle { background-color: rgba(245, 158, 11, 0.08) !important; }
.text-amber { color: #f59e0b !important; }
.bg-emerald-subtle { background-color: rgba(16, 185, 129, 0.08) !important; }
.text-emerald { color: #10b981 !important; }
.smaller { font-size: 0.75rem !important; }

/* Stat Cards */
.dashboard-stat-card {
    transition: transform 0.25s ease, box-shadow 0.25s ease;
}
.dashboard-stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.06) !important;
}
.stat-icon-wrapper {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

/* Table Design */
.proofs-refused-table thead th {
    background-color: #f8fafc;
    color: #475569;
    font-weight: 700;
    font-size: 0.85rem;
    padding: 14px 16px;
    border-bottom: 2px solid #edf2f7;
    white-space: nowrap;
}
.proofs-refused-table tbody tr {
    transition: background-color 0.15s ease;
}
.proofs-refused-table tbody tr:hover {
    background-color: rgba(164, 12, 114, 0.02) !important;
}
.proofs-refused-table tbody td {
    padding: 14px 16px;
    border-bottom: 1px solid #f1f5f9;
}

/* ================= PURE CSS RESPONSIVE TABLE (MOBILE CARDS) ================= */
@media (max-width: 768px) {
    .proofs-refused-table thead {
        display: none !important;
    }

    .proofs-refused-table,
    .proofs-refused-table tbody,
    .proofs-refused-table tr,
    .proofs-refused-table td {
        display: block !important;
        width: 100% !important;
    }

    .proofs-refused-table tr.proof-row {
        margin-bottom: 16px !important;
        padding: 14px 16px !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 14px !important;
        background: #ffffff !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03) !important;
    }

    .proofs-refused-table td {
        display: flex !important;
        justify-content: space-between !important;
        align-items: center !important;
        gap: 12px !important;
        padding: 10px 0 !important;
        border: none !important;
        border-bottom: 1px solid #f1f5f9 !important;
        text-align: right !important;
    }

    .proofs-refused-table td:last-child {
        border-bottom: none !important;
        justify-content: flex-end !important;
        padding-top: 14px !important;
    }

    .proofs-refused-table td::before {
        content: attr(data-label) !important;
        font-weight: 700 !important;
        color: #64748b !important;
        font-size: 0.85rem !important;
        flex-shrink: 0 !important;
    }

    .proofs-refused-table td[data-label="سبب الرفض"] {
        flex-direction: column !important;
        align-items: flex-start !important;
    }

    .proofs-refused-table td[data-label="سبب الرفض"] .p-2 {
        width: 100% !important;
        max-width: 100% !important;
        margin-top: 6px !important;
    }
}
</style>

<script>
// ================= CLIENT-SIDE LIVE INSTANT SEARCH FILTER =================
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('liveSearchInput');
    const tableBody = document.getElementById('proofsTableBody');

    if (searchInput && tableBody) {
        searchInput.addEventListener('input', function() {
            const query = this.value.trim().toLowerCase();
            const rows = tableBody.querySelectorAll('tr.proof-row');

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                if (text.includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    }
});
</script>
