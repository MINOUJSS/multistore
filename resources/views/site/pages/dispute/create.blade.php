<section class="dispute-create-section py-5" style="background: #f8f9fc; min-height: 70vh;">
    <div class="container" data-aos="fade-up">
        
        <div class="row g-4 justify-content-center">
            
            <!-- Left/Main Column: Dispute Form -->
            <div class="col-12 col-lg-8" data-aos="fade-up" data-aos-delay="100">
                <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-white dispute-form-card">
                    
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                        <div class="icon-avatar rounded-circle d-flex align-items-center justify-content-center flex-shrink-0 text-white shadow-sm"
                             style="width: 52px; height: 52px; background: linear-gradient(135deg, #B03882 0%, #6f1d53 100%);">
                            <i class="bi bi-file-earmark-text fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold text-dark mb-1 fs-5">{{ __('site.dispute_form_title') }}</h4>
                            <p class="text-muted small mb-0">{{ __('site.dispute_form_desc') }}</p>
                        </div>
                    </div>

                    <form id="disputeForm" action="{{ route('site.dispute.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                        @csrf

                        <!-- Order Number -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">
                                <i class="bi bi-hash text-pink me-1"></i> {{ __('site.dispute_order_number') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3"><i class="bi bi-receipt"></i></span>
                                <input type="text" name="order_number" placeholder="{{ __('site.dispute_order_number_placeholder') }}" required
                                       class="form-control border-start-0 rounded-end-3 py-2.5">
                            </div>
                            <div class="form-text small text-muted">{{ __('site.dispute_order_number_help') }}</div>
                        </div>

                        <!-- Customer Details: Name & Phone -->
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">
                                <i class="bi bi-person text-pink me-1"></i> {{ __('site.dispute_customer_name') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3"><i class="bi bi-person"></i></span>
                                <input type="text" name="customer_name" placeholder="{{ __('site.dispute_customer_name_placeholder') }}" class="form-control border-start-0 rounded-end-3 py-2.5" required>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">
                                <i class="bi bi-telephone text-pink me-1"></i> {{ __('site.dispute_customer_phone') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="customer_phone" placeholder="{{ __('site.dispute_customer_phone_placeholder') }}"
                                       class="form-control border-start-0 rounded-end-3 py-2.5" required>
                            </div>
                        </div>

                        <!-- Email & Seller ID -->
                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">
                                <i class="bi bi-envelope text-pink me-1"></i> {{ __('site.dispute_customer_email') }}
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3"><i class="bi bi-envelope"></i></span>
                                <input type="email" name="customer_email" placeholder="example@email.com"
                                       class="form-control border-start-0 rounded-end-3 py-2.5">
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <label class="form-label fw-bold text-dark small mb-1">
                                <i class="bi bi-shop text-pink me-1"></i> {{ __('site.dispute_seller_id') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3"><i class="bi bi-shop"></i></span>
                                <input type="text" name="seller_id" placeholder="{{ __('site.dispute_seller_id_placeholder') }}"
                                       class="form-control border-start-0 rounded-end-3 py-2.5" required>
                            </div>
                        </div>

                        <!-- Subject -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">
                                <i class="bi bi-chat-left-text text-pink me-1"></i> {{ __('site.dispute_subject') }} <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted rounded-start-3"><i class="bi bi-chat-left-text"></i></span>
                                <input type="text" name="subject" placeholder="{{ __('site.dispute_subject_placeholder') }}" required
                                       class="form-control border-start-0 rounded-end-3 py-2.5">
                            </div>
                        </div>

                        <!-- Detailed Description -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">
                                <i class="bi bi-card-text text-pink me-1"></i> {{ __('site.dispute_description') }} <span class="text-danger">*</span>
                            </label>
                            <textarea name="description" rows="5" placeholder="{{ __('site.dispute_description_placeholder') }}" required 
                                      class="form-control rounded-3 p-3"></textarea>
                        </div>

                        <!-- Supporting Attachments -->
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small mb-1">
                                <i class="bi bi-paperclip text-pink me-1"></i> {{ __('site.dispute_attachments') }}
                            </label>
                            <div class="upload-dropzone p-3.5 text-center border-dashed rounded-3 bg-light position-relative">
                                <input type="file" name="attachments[]" id="disputeAttachmentsInput" multiple class="form-control d-none" 
                                       accept=".jpg,.jpeg,.png,.pdf,.doc,.docx"
                                       onchange="updateFileNameDisplay(this)">
                                <label for="disputeAttachmentsInput" class="mb-0 cursor-pointer d-block">
                                    <i class="bi bi-cloud-arrow-up fs-2 text-pink mb-1 d-block"></i>
                                    <span class="fw-semibold text-dark d-block">{{ __('site.dispute_attachments_dropzone') }}</span>
                                    <span class="text-muted small d-block mt-1">{{ __('site.dispute_attachments_hint') }}</span>
                                </label>
                                <div id="selectedFilesInfo" class="mt-2 text-pink small fw-bold d-none"></div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="col-12 pt-3">
                            <button type="submit" class="btn btn-primary-pink w-100 rounded-3 py-3 fw-bold fs-6 d-inline-flex align-items-center justify-content-center gap-2 shadow-sm">
                                <i class="bi bi-send-fill"></i>
                                <span>{{ __('site.dispute_submit_btn') }}</span>
                            </button>
                        </div>

                    </form>

                </div>
            </div>

            <!-- Right/Sidebar Column: Guarantees & Help -->
            <div class="col-12 col-lg-4" data-aos="fade-up" data-aos-delay="200">
                <div class="d-flex flex-column gap-4">
                    
                    <!-- Mediation Guarantee Card -->
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white side-info-card">
                        <div class="d-flex align-items-center gap-2.5 mb-3">
                            <span class="badge bg-pink-light text-pink rounded-pill p-2 fs-6">
                                <i class="bi bi-shield-check"></i>
                            </span>
                            <h5 class="fw-bold text-dark mb-0 fs-6">{{ __('site.dispute_mediation_guarantee_title') }}</h5>
                        </div>
                        <p class="text-muted small mb-0 lh-base">
                            {{ __('site.dispute_mediation_guarantee_desc') }}
                        </p>
                    </div>

                    <!-- Process Steps Card -->
                    <div class="card border-0 shadow-sm rounded-4 p-4 bg-white side-info-card">
                        <h5 class="fw-bold text-dark mb-3 fs-6 d-flex align-items-center gap-2">
                            <i class="bi bi-list-check text-pink"></i>
                            <span>{{ __('site.dispute_process_steps_title') }}</span>
                        </h5>
                        <div class="process-steps d-flex flex-column gap-3">
                            <div class="d-flex gap-2.5 align-items-start">
                                <span class="step-badge rounded-circle text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                                      style="width: 26px; height: 26px; font-size: 0.78rem; background: #B03882;">1</span>
                                <div>
                                    <div class="fw-semibold text-dark small">{{ __('site.dispute_process_step1_title') }}</div>
                                    <div class="text-muted small">{{ __('site.dispute_process_step1_desc') }}</div>
                                </div>
                            </div>
                            <div class="d-flex gap-2.5 align-items-start">
                                <span class="step-badge rounded-circle text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                                      style="width: 26px; height: 26px; font-size: 0.78rem; background: #B03882;">2</span>
                                <div>
                                    <div class="fw-semibold text-dark small">{{ __('site.dispute_process_step2_title') }}</div>
                                    <div class="text-muted small">{{ __('site.dispute_process_step2_desc') }}</div>
                                </div>
                            </div>
                            <div class="d-flex gap-2.5 align-items-start">
                                <span class="step-badge rounded-circle text-white fw-bold d-flex align-items-center justify-content-center flex-shrink-0"
                                      style="width: 26px; height: 26px; font-size: 0.78rem; background: #B03882;">3</span>
                                <div>
                                    <div class="fw-semibold text-dark small">{{ __('site.dispute_process_step3_title') }}</div>
                                    <div class="text-muted small">{{ __('site.dispute_process_step3_desc') }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Advice Card -->
                    <div class="card border-0 shadow-sm rounded-4 p-4 side-advice-card position-relative overflow-hidden"
                         style="background: linear-gradient(135deg, rgba(176, 56, 130, 0.06) 0%, rgba(255, 255, 255, 0.95) 100%); border: 1px solid rgba(176, 56, 130, 0.2) !important;">
                        <h6 class="fw-bold text-dark mb-2.5 fs-6 d-flex align-items-center gap-2">
                            <i class="bi bi-lightbulb text-pink"></i>
                            <span>{{ __('site.dispute_advice_title') }}</span>
                        </h6>
                        <ul class="list-unstyled text-muted small mb-0 d-flex flex-column gap-2">
                            <li class="d-flex align-items-start gap-1.5">
                                <i class="bi bi-check2 text-pink flex-shrink-0 mt-0.5"></i>
                                <span>{{ __('site.dispute_advice_1') }}</span>
                            </li>
                            <li class="d-flex align-items-start gap-1.5">
                                <i class="bi bi-check2 text-pink flex-shrink-0 mt-0.5"></i>
                                <span>{{ __('site.dispute_advice_2') }}</span>
                            </li>
                            <li class="d-flex align-items-start gap-1.5">
                                <i class="bi bi-check2 text-pink flex-shrink-0 mt-0.5"></i>
                                <span>{{ __('site.dispute_advice_3') }}</span>
                            </li>
                        </ul>
                    </div>

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
        box-shadow: 0 8px 20px rgba(176, 56, 130, 0.35) !important;
    }
    .dispute-form-card {
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
        transition: all 0.3s ease;
    }
    .side-info-card {
        border: 1px solid rgba(0, 0, 0, 0.05) !important;
    }
    .border-dashed {
        border: 2px dashed rgba(176, 56, 130, 0.3) !important;
        transition: all 0.2s ease;
    }
    .border-dashed:hover {
        border-color: var(--color-primary-pink) !important;
        background-color: rgba(176, 56, 130, 0.03) !important;
    }
    .cursor-pointer {
        cursor: pointer;
    }
    .form-control:focus, .form-select:focus {
        border-color: var(--color-primary-pink) !important;
        box-shadow: 0 0 0 0.25rem rgba(176, 56, 130, 0.15) !important;
    }
    .input-group:focus-within .input-group-text {
        border-color: var(--color-primary-pink) !important;
        color: var(--color-primary-pink) !important;
    }
</style>

<script>
    function updateFileNameDisplay(input) {
        var info = document.getElementById('selectedFilesInfo');
        if (input.files && input.files.length > 0) {
            info.classList.remove('d-none');
            if (input.files.length === 1) {
                info.innerHTML = '<i class="bi bi-file-earmark-check me-1"></i> ' + input.files[0].name;
            } else {
                info.innerHTML = '<i class="bi bi-file-earmark-check me-1"></i> ' + input.files.length + ' files selected';
            }
        } else {
            info.classList.add('d-none');
            info.innerHTML = '';
        }
    }
</script>

{{-- SweetAlert Success Notification --}}
@if(session()->has('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    position: 'center',
                    icon: 'success',
                    title: '{{ session()->get('success') }}',
                    showConfirmButton: false,
                    timer: 2500
                });
            }
        });
    </script>
@endif
