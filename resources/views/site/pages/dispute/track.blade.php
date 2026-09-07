<section class="dispute-track-section py-5" style="background: #f8f9fc; min-height: 75vh;">
    <div class="container" data-aos="fade-up">

        <div class="row g-4 justify-content-center">

            <!-- Sidebar Column: Dispute Details & Summary (4 Cols) -->
            <div class="col-12 col-lg-4 order-2 order-lg-1" data-aos="fade-up" data-aos-delay="100">
                <div class="d-flex flex-column gap-4">

                    <!-- Main Info Card -->
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white dispute-side-card">
                        
                        <!-- Order & Status Header -->
                        <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                            <div>
                                <span class="text-muted small d-block">{{ __('site.dispute_order_number') }}</span>
                                <span class="fw-bold text-dark fs-6">#{{ $dispute->order_number }}</span>
                            </div>

                            @php
                                $statusBadges = [
                                    'open' => ['text' => __('site.dispute_status_open'), 'class' => 'bg-success-subtle text-success border-success-subtle', 'icon' => 'bi-record-circle-fill text-success'],
                                    'in_review' => ['text' => __('site.dispute_status_in_review'), 'class' => 'bg-warning-subtle text-warning-emphasis border-warning-subtle', 'icon' => 'bi-hourglass-split text-warning'],
                                    'resolved' => ['text' => __('site.dispute_status_resolved'), 'class' => 'bg-info-subtle text-info-emphasis border-info-subtle', 'icon' => 'bi-check-circle-fill text-info'],
                                    'escalated' => ['text' => __('site.dispute_status_escalated'), 'class' => 'bg-primary-subtle text-primary border-primary-subtle', 'icon' => 'bi-shield-fill-exclamation text-primary'],
                                    'rejected' => ['text' => __('site.dispute_status_rejected'), 'class' => 'bg-danger-subtle text-danger border-danger-subtle', 'icon' => 'bi-x-circle-fill text-danger'],
                                    'closed' => ['text' => __('site.dispute_status_closed'), 'class' => 'bg-secondary-subtle text-secondary border-secondary-subtle', 'icon' => 'bi-lock-fill text-secondary'],
                                ];
                                $curStatus = $statusBadges[$dispute->status] ?? ['text' => __('site.dispute_status_unknown'), 'class' => 'bg-light text-dark', 'icon' => 'bi-info-circle'];
                            @endphp

                            <span class="badge {{ $curStatus['class'] }} border rounded-pill px-3 py-1.5 fw-bold d-inline-flex align-items-center gap-1.5">
                                <i class="bi {{ $curStatus['icon'] }}"></i>
                                <span>{{ $curStatus['text'] }}</span>
                            </span>
                        </div>

                        <!-- Info List -->
                        <div class="dispute-info-list d-flex flex-column gap-3 mb-4">
                            <div>
                                <label class="text-muted small fw-semibold d-block mb-1">
                                    <i class="bi bi-person text-pink me-1"></i> {{ __('site.dispute_buyer_name') }}
                                </label>
                                <span class="text-dark fw-bold">{{ $dispute->customer_name ?? __('site.dispute_not_specified') }}</span>
                            </div>

                            @if($dispute->customer_phone)
                                <div>
                                    <label class="text-muted small fw-semibold d-block mb-1">
                                        <i class="bi bi-telephone text-pink me-1"></i> {{ __('site.dispute_customer_phone') }}:
                                    </label>
                                    <span class="text-dark fw-semibold" dir="ltr">{{ $dispute->customer_phone }}</span>
                                </div>
                            @endif

                            @if($dispute->customer_email)
                                <div>
                                    <label class="text-muted small fw-semibold d-block mb-1">
                                        <i class="bi bi-envelope text-pink me-1"></i> {{ __('site.dispute_customer_email') }}:
                                    </label>
                                    <span class="text-dark">{{ $dispute->customer_email }}</span>
                                </div>
                            @endif

                            <div>
                                <label class="text-muted small fw-semibold d-block mb-1">
                                    <i class="bi bi-chat-left-text text-pink me-1"></i> {{ __('site.dispute_subject') }}:
                                </label>
                                <span class="text-dark fw-semibold">{{ $dispute->subject }}</span>
                            </div>

                            <div>
                                <label class="text-muted small fw-semibold d-block mb-1">
                                    <i class="bi bi-card-text text-pink me-1"></i> {{ __('site.dispute_description') }}:
                                </label>
                                <div class="p-2.5 rounded-3 bg-light text-muted small lh-base">
                                    {{ $dispute->description }}
                                </div>
                            </div>
                        </div>

                        <!-- Initial Attachments -->
                        @if (!empty($dispute->attachments))
                            <div class="pt-3 border-top">
                                <label class="text-muted small fw-bold d-block mb-2">
                                    <i class="bi bi-paperclip text-pink me-1"></i> {{ __('site.dispute_initial_attachments') }}
                                </label>
                                <div class="d-flex flex-wrap gap-2">
                                    @foreach (json_decode($dispute->attachments, true) as $file)
                                        @php
                                            $isImg = in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                            $fileUrl = asset('storage/' . $file);
                                        @endphp
                                        @if($isImg)
                                            <a href="{{ $fileUrl }}" target="_blank" class="attachment-thumb rounded-3 overflow-hidden border shadow-xs d-inline-block position-relative">
                                                <img src="{{ $fileUrl }}" alt="{{ __('site.dispute_attachment') }} {{ $loop->iteration }}" style="width: 58px; height: 58px; object-fit: cover;">
                                            </a>
                                        @else
                                            <a href="{{ $fileUrl }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1.5">
                                                <i class="bi bi-file-earmark-arrow-down"></i>
                                                <span>{{ __('site.dispute_attachment') }} {{ $loop->iteration }}</span>
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endif

                    </div>

                    <!-- Tracking Link Copy Box -->
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="text-dark small fw-bold"><i class="bi bi-link-45deg text-pink me-1"></i> {{ __('site.dispute_permanent_link') }}</span>
                            <button type="button" class="btn btn-link btn-sm text-pink p-0 text-decoration-none fw-semibold" onclick="copyTrackingUrl()">
                                <i class="bi bi-clipboard me-1"></i> {{ __('site.dispute_copy_link') }}
                            </button>
                        </div>
                        <input type="text" id="trackingUrlInput" readonly value="{{ url()->current() }}" class="form-control form-control-sm bg-light text-muted small" onclick="this.select();">
                        <small class="text-muted mt-1" style="font-size: 0.76rem;">{{ __('site.dispute_copy_link_hint') }}</small>
                    </div>

                </div>
            </div>

            <!-- Main Column: Interactive Chat & Replies (8 Cols) -->
            <div class="col-12 col-lg-8 order-1 order-lg-2" data-aos="fade-up" data-aos-delay="150">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white dispute-chat-card">

                    <!-- Chat Header -->
                    <div class="d-flex align-items-center justify-content-between mb-3 pb-3 border-bottom">
                        <div class="d-flex align-items-center gap-2.5">
                            <div class="chat-icon-avatar rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm"
                                 style="width: 44px; height: 44px; background: linear-gradient(135deg, #B03882 0%, #6f1d53 100%);">
                                <i class="bi bi-chat-dots fs-5"></i>
                            </div>
                            <div>
                                <h5 class="fw-bold text-dark mb-0 fs-6">{{ __('site.dispute_chat_title') }}</h5>
                                <span class="text-muted small">{{ __('site.dispute_chat_subtitle') }}</span>
                            </div>
                        </div>

                        <!-- Live Refresh Badge Indicator -->
                        <div class="d-flex align-items-center gap-2 text-muted small">
                            <span class="live-dot"></span>
                            <span class="d-none d-sm-inline">{{ __('site.dispute_live_indicator') }}</span>
                        </div>
                    </div>

                    <!-- Messages Box -->
                    <div class="position-relative mb-4">
                        <!-- Unread Count Badge Alert -->
                        <div id="unreadBadge" class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-danger shadow-sm d-none"
                             style="z-index: 10; padding: 6px 14px; font-size: 0.85rem;">
                            🔔 <span id="unreadCount">0</span> {{ __('site.dispute_unread_messages') }}
                        </div>

                        <!-- Chat Messages Container -->
                        <div id="messages-container" class="messages-container rounded-4 p-3.5 bg-light-subtle"
                             style="max-height: 440px; min-height: 240px; overflow-y: auto; scroll-behavior: smooth; border: 1px solid rgba(0,0,0,0.06);">
                            
                            @forelse ($dispute->messages as $message)
                                <div class="mb-3 {{ $message->sender_type == 'customer' ? 'text-end' : 'text-start' }}">
                                    <div class="d-inline-block p-3 rounded-4 shadow-xs msg-bubble
                                        {{ $message->sender_type == 'customer' ? 'msg-customer' : 'msg-admin' }}"
                                         style="max-width: 85%;">
                                        <p class="mb-1 text-break">{{ $message->message }}</p>
                                        
                                        @if (!empty($message->attachments))
                                            <div class="mt-2 pt-2 border-top border-white-20 d-flex flex-wrap gap-2">
                                                @foreach (json_decode($message->attachments, true) as $index => $file)
                                                    @php
                                                        $isImage = in_array(strtolower(pathinfo($file, PATHINFO_EXTENSION)), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
                                                        $fileUrl = asset('storage/' . $file);
                                                    @endphp

                                                    @if ($isImage)
                                                        <a href="{{ $fileUrl }}" target="_blank" class="d-inline-block rounded-3 overflow-hidden border">
                                                            <img src="{{ $fileUrl }}" alt="{{ __('site.dispute_attachment') }}" style="max-width: 130px; max-height: 130px; object-fit: cover;">
                                                        </a>
                                                    @else
                                                        <a href="{{ $fileUrl }}" target="_blank" class="btn btn-sm btn-outline-light rounded-pill px-2.5 py-1 small">
                                                            📎 {{ __('site.dispute_attachment') }} {{ $index + 1 }}
                                                        </a>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                    <div class="small text-muted mt-1 px-1">
                                        {{ $message->created_at->diffForHumans() }}
                                        <span class="fw-semibold">({{ $message->sender_type == 'customer' ? __('site.dispute_you') : __('site.dispute_admin_team') }})</span>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-5 text-muted">
                                    <div class="mb-2 fs-2 opacity-50">💬</div>
                                    <h6 class="fw-semibold">{{ __('site.dispute_no_messages') }}</h6>
                                    <p class="small mb-0">{{ __('site.dispute_no_messages_hint') }}</p>
                                </div>
                            @endforelse

                        </div>
                    </div>

                    <!-- Reply Form or Closed Notification -->
                    @if (in_array($dispute->status, ['open', 'in_review']))
                        <div class="reply-card p-3.5 rounded-4 bg-light border">
                            <form id="replyForm" method="POST" action="{{ route('site.dispute.reply', $dispute->access_token) }}" enctype="multipart/form-data">
                                @csrf
                                
                                <div class="mb-3">
                                    <label for="message" class="form-label fw-bold text-dark small mb-1">
                                        <i class="bi bi-pencil-square text-pink me-1"></i> {{ __('site.dispute_write_reply') }}
                                    </label>
                                    <textarea name="message" id="message" class="form-control rounded-3 p-3 bg-white" rows="3" 
                                              placeholder="{{ __('site.dispute_write_reply_placeholder') }}" required></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="attachments" class="form-label fw-bold text-dark small mb-1">
                                        <i class="bi bi-paperclip text-pink me-1"></i> {{ __('site.dispute_add_attachments') }}
                                    </label>
                                    <input type="file" name="attachments[]" id="attachments" class="form-control rounded-3 bg-white" multiple
                                           accept=".jpg,.jpeg,.png,.pdf,.zip,.rar,.doc,.docx">
                                    <small class="text-muted mt-1 d-block" style="font-size: 0.78rem;">{{ __('site.dispute_add_attachments_hint') }}</small>
                                </div>

                                <button type="submit" class="btn btn-primary-pink w-100 rounded-3 py-2.5 fw-bold d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
                                    <i class="bi bi-send-fill"></i>
                                    <span>{{ __('site.dispute_send_reply_btn') }}</span>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="alert alert-secondary rounded-4 p-4 text-center mb-0 border-0 shadow-xs">
                            <i class="bi bi-lock-fill fs-3 text-muted d-block mb-1"></i>
                            <h6 class="fw-bold text-dark mb-1">{{ __('site.dispute_closed_notice_title') }}</h6>
                            <p class="text-muted small mb-0">{{ __('site.dispute_closed_notice_desc') }}</p>
                        </div>
                    @endif

                </div>
            </div>

        </div>

    </div>
</section>

<!-- Scoped Styling -->
<style>
    :root {
        --color-primary-pink: #B03882;
        --color-primary-pink-hover: #912969;
        --color-primary-pink-light: rgba(176, 56, 130, 0.1);
    }
    .text-pink {
        color: var(--color-primary-pink) !important;
    }
    .bg-pink-light {
        background-color: var(--color-primary-pink-light) !important;
    }
    .btn-primary-pink {
        background-color: var(--color-primary-pink);
        color: #fff;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-primary-pink:hover {
        background-color: var(--color-primary-pink-hover);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(176, 56, 130, 0.35) !important;
    }
    .dispute-side-card, .dispute-chat-card {
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
    }
    .msg-bubble {
        text-align: inherit;
    }
    .msg-customer {
        background: linear-gradient(135deg, #B03882 0%, #872661 100%) !important;
        color: #ffffff !important;
    }
    .msg-admin {
        background: #2d0b20 !important;
        color: #ffffff !important;
    }
    .border-white-20 {
        border-color: rgba(255, 255, 255, 0.2) !important;
    }
    .live-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #22c55e;
        display: inline-block;
        box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
        animation: pulse-green 2s infinite;
    }
    @keyframes pulse-green {
        0% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.7);
        }
        70% {
            transform: scale(1);
            box-shadow: 0 0 0 6px rgba(34, 197, 94, 0);
        }
        100% {
            transform: scale(0.95);
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0);
        }
    }
    .form-control:focus {
        border-color: var(--color-primary-pink) !important;
        box-shadow: 0 0 0 0.25rem rgba(176, 56, 130, 0.15) !important;
    }
</style>

<script>
    function copyTrackingUrl() {
        var copyText = document.getElementById("trackingUrlInput");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        navigator.clipboard.writeText(copyText.value).then(function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: '{{ __('site.dispute_link_copied') }}',
                    showConfirmButton: false,
                    timer: 2000
                });
            } else {
                alert("{{ __('site.dispute_link_copied') }}");
            }
        });
    }
</script>
