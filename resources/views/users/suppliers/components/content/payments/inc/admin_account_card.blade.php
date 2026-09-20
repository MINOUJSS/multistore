@php
    $acc = $account ?? (isset($type) ? get_default_admin_bank_account($type) : null);
@endphp

@if(!$acc)
    <div class="alert alert-warning border-0 rounded-4 p-3 mb-3 d-flex align-items-center gap-3 bg-warning-subtle text-warning-emphasis">
        <span class="avatar avatar-md rounded-circle bg-warning text-dark flex-shrink-0 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
            <i class="fa-solid fa-triangle-exclamation fs-6"></i>
        </span>
        <div class="small">
            <strong class="d-block mb-0.5">بيانات الحساب غير متوفرة حالياً</strong>
            <span>يرجى التواصل مع إدارة المنصة لتزويدك ببيانات التحويل المعتمدة.</span>
        </div>
    </div>
@else
    @php
        $isBaridi = $acc->account_type === 'baridimob';
        $isCcp = $acc->account_type === 'ccp';
        $isBank = $acc->account_type === 'bank';

        $headerBg = $isBaridi 
            ? 'linear-gradient(135deg, #0d5f3a 0%, #10b981 100%)' 
            : ($isCcp 
                ? 'linear-gradient(135deg, #926400 0%, #f59e0b 100%)' 
                : 'linear-gradient(135deg, #0f172a 0%, #2563eb 100%)');

        $iconClass = $isBaridi 
            ? 'fa-solid fa-mobile-screen-button' 
            : ($isCcp 
                ? 'fa-solid fa-building-columns' 
                : 'fa-solid fa-landmark');
    @endphp

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-3 text-start admin-bank-card-container position-relative"
        style="border: 1px solid rgba(0,0,0,0.08) !important;">
        <!-- Card Header Banner -->
        <div class="py-2.5 px-3.5 text-white d-flex align-items-center justify-content-between"
            style="background: {{ $headerBg }};">
            <div class="d-flex align-items-center gap-2">
                <i class="{{ $iconClass }} fs-6"></i>
                <span class="fw-bold fs-7">{{ $acc->type_label }}</span>
                @if($acc->bank_name && $acc->bank_name !== 'بريد الجزائر')
                    <span class="badge bg-white bg-opacity-25 rounded-pill px-2 py-0.5 small">{{ $acc->bank_name }}</span>
                @endif
            </div>
            @if($acc->is_default)
                <span class="badge bg-white text-dark rounded-pill px-2.5 py-0.5 small fw-bold">
                    <i class="fa-solid fa-star text-warning me-1"></i> الحساب الرسمي
                </span>
            @endif
        </div>

        <!-- Card Body -->
        <div class="card-body p-3 bg-white">
            <!-- Account Holder Name -->
            <div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom">
                <span class="text-muted small">
                    <i class="fa-solid fa-user text-navy me-1"></i> اسم صاحب الحساب:
                </span>
                <span class="fw-bold text-dark fs-7">{{ $acc->account_name }}</span>
            </div>

            <!-- CCP Specific Fields -->
            @if($isCcp && $acc->account_number)
                <div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom">
                    <span class="text-muted small">
                        <i class="fa-solid fa-hashtag text-navy me-1"></i> رقم الحساب البريدي (CCP):
                    </span>
                    <div class="d-flex align-items-center gap-2" dir="ltr" style="direction: ltr !important; unicode-bidi: isolate;">
                        <span class="fw-bold text-dark font-monospace fs-6 px-2 py-0.5 bg-light rounded-2 border">
                            {{ $acc->account_number }}
                        </span>
                        @if($acc->ccp_key)
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 fw-bold font-monospace fs-7">
                                Clé: {{ $acc->ccp_key }}
                            </span>
                        @endif
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-2 px-2 py-1 copy-btn"
                            data-copy-target="{{ $acc->account_number }}{{ $acc->ccp_key ? ' ' . $acc->ccp_key : '' }}"
                            title="نسخ رقم الحساب">
                            <i class="fa-regular fa-copy"></i>
                        </button>
                    </div>
                </div>
            @endif

            <!-- RIP Field (Crucial for BaridiMob & Transfers) -->
            @if($acc->rip)
                <div class="p-2.5 rounded-3 bg-light border mb-2">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <span class="text-muted small fw-bold">
                            <i class="fa-solid fa-fingerprint text-success me-1"></i> رقم الـ RIP (للتحويل المالي السريع):
                        </span>
                        <button type="button" class="btn btn-sm btn-success rounded-2 px-2 py-1 copy-btn d-inline-flex align-items-center gap-1 shadow-none"
                            data-copy-target="{{ $acc->rip }}"
                            title="نسخ رقم RIP">
                            <i class="fa-regular fa-copy fs-7"></i>
                            <span class="fs-8 fw-bold">نسخ الـ RIP</span>
                        </button>
                    </div>
                    <div class="font-monospace fw-bold text-dark text-center fs-6 py-1.5 bg-white rounded-2 border border-success-subtle letter-spacing-1 user-select-all"
                        dir="ltr" style="direction: ltr !important; unicode-bidi: isolate;">
                        {{ wordwrap($acc->rip, 4, ' ', true) }}
                    </div>
                </div>
            @endif

            <!-- Commercial Bank Account Specifics -->
            @if($isBank)
                @if($acc->account_number && !$acc->rip)
                    <div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom">
                        <span class="text-muted small">رقم الحساب البنكي:</span>
                        <div class="d-flex align-items-center gap-2" dir="ltr" style="direction: ltr !important; unicode-bidi: isolate;">
                            <span class="fw-bold text-dark font-monospace px-2 py-0.5 bg-light rounded border">{{ $acc->account_number }}</span>
                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-2 px-2 py-1 copy-btn" data-copy-target="{{ $acc->account_number }}">
                                <i class="fa-regular fa-copy"></i>
                            </button>
                        </div>
                    </div>
                @endif
                @if($acc->iban)
                    <div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom">
                        <span class="text-muted small">رقم IBAN:</span>
                        <span class="fw-bold font-monospace small text-dark" dir="ltr" style="direction: ltr !important; unicode-bidi: isolate;">{{ $acc->iban }}</span>
                    </div>
                @endif
                @if($acc->swift_code)
                    <div class="d-flex justify-content-between align-items-center pb-2 mb-2 border-bottom">
                        <span class="text-muted small">رمز SWIFT/BIC:</span>
                        <span class="fw-bold font-monospace small text-dark" dir="ltr" style="direction: ltr !important; unicode-bidi: isolate;">{{ $acc->swift_code }}</span>
                    </div>
                @endif
            @endif

            <!-- Admin Notes / Instructions -->
            @if($acc->notes)
                <div class="mt-2 text-start p-2 rounded-2 bg-info-subtle text-info-emphasis small border border-info border-opacity-25 d-flex align-items-start gap-2">
                    <i class="fa-solid fa-circle-info mt-1 flex-shrink-0"></i>
                    <span>{{ $acc->notes }}</span>
                </div>
            @endif
        </div>
    </div>
@endif

@once
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.copy-btn');
            if (!btn) return;

            e.preventDefault();
            const textToCopy = btn.getAttribute('data-copy-target');
            if (!textToCopy) return;

            navigator.clipboard.writeText(textToCopy).then(function() {
                const originalHtml = btn.innerHTML;
                btn.classList.remove('btn-outline-secondary', 'btn-success');
                btn.classList.add('btn-dark');
                btn.innerHTML = '<i class="fa-solid fa-check text-success"></i> <span class="fs-8 fw-bold">تم النسخ!</span>';

                setTimeout(function() {
                    btn.classList.remove('btn-dark');
                    if (btn.getAttribute('data-copy-target').length >= 15) {
                        btn.classList.add('btn-success');
                    } else {
                        btn.classList.add('btn-outline-secondary');
                    }
                    btn.innerHTML = originalHtml;
                }, 2000);
            }).catch(function(err) {
                const textarea = document.createElement('textarea');
                textarea.value = textToCopy;
                document.body.appendChild(textarea);
                textarea.select();
                document.execCommand('copy');
                document.body.removeChild(textarea);

                const originalHtml = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-check"></i> <span class="fs-8">تم!</span>';
                setTimeout(() => { btn.innerHTML = originalHtml; }, 2000);
            });
        });
    });
</script>
<style>
    .letter-spacing-1 {
        letter-spacing: 1.5px;
    }
    .fs-7 {
        font-size: 0.875rem !important;
    }
    .fs-8 {
        font-size: 0.775rem !important;
    }
</style>
@endonce
