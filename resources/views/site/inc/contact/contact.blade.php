<!-- ======= Contact Section ======= -->
<section id="contact" class="contact py-5">
    <div class="container" data-aos="fade-up">

        <div class="section-title text-center mb-5">
            <span class="badge px-3 py-2 rounded-pill mb-2 contact-badge">{{ __('site.contact_badge') }}</span>
            <h2 class="fw-bold text-dark position-relative d-inline-block pb-2 contact-title">{{ __('site.contact_title') }}</h2>
            <p class="text-muted lead fs-6 mx-auto mt-2 contact-desc" style="max-width: 750px;">{{ __('site.contact_desc') }}</p>
        </div>

        <div class="row g-4 align-items-stretch">

            <!-- Info & Map Card Column -->
            <div class="col-lg-5 d-flex align-items-stretch" data-aos="fade-right" data-aos-delay="100">
                <div
                    class="info w-100 p-4 rounded-4 bg-white shadow-sm border border-light-subtle d-flex flex-column justify-content-between">
                    <div>
                        <div
                            class="contact-item d-flex align-items-center gap-3 mb-4 p-3 rounded-3 bg-light-subtle transition-item">
                            <div class="icon-box d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-geo-alt-fill fs-5"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold fs-6 text-dark mb-1">{{ __('site.address_label') }}</h4>
                                <p class="text-muted small mb-0">{{ __('site.address_value') }}</p>
                            </div>
                        </div>

                        <div
                            class="contact-item d-flex align-items-center gap-3 mb-4 p-3 rounded-3 bg-light-subtle transition-item">
                            <div class="icon-box d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-envelope-fill fs-5"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold fs-6 text-dark mb-1">{{ __('site.email_label') }}</h4>
                                <p class="text-muted small mb-0">dzora.net@gmail.com</p>
                            </div>
                        </div>

                        <div
                            class="contact-item d-flex align-items-center gap-3 mb-4 p-3 rounded-3 bg-light-subtle transition-item">
                            <div class="icon-box d-inline-flex align-items-center justify-content-center">
                                <i class="bi bi-telephone-fill fs-5"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold fs-6 text-dark mb-1">{{ __('site.phone_label') }}</h4>
                                <p class="text-muted small mb-0">0672816709</p>
                            </div>
                        </div>
                    </div>

                    <!-- Embedded Map -->
                    <div class="map-wrapper rounded-3 overflow-hidden shadow-sm mt-3 border border-light"
                        style="height: 250px;">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d102286.38396938733!2d3.0541521472319664!3d36.75978277379741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x128fad6795639515%3A0x4ba4b4c9d0a7e602!2sAlgiers!5e0!3m2!1sen!2sdz!4v1719439133741!5m2!1sen!2sdz"
                            width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>

                </div>
            </div>

            <!-- Contact Form Column -->
            <div class="col-lg-7 d-flex align-items-stretch" data-aos="fade-left" data-aos-delay="200">
                <form action="{{ route('site.contact.store') }}" method="post" role="form"
                    class="php-email-form w-100 p-4 p-lg-5 rounded-4 bg-white shadow-sm border border-light-subtle d-flex flex-column justify-content-between">
                    @csrf
                    <input type="text" name="website" style="display:none">

                    <div>
                        <div class="row g-3 mb-3">
                            <div class="form-group col-md-6">
                                <label for="name" class="form-label fw-semibold text-dark small">{{ __('site.full_name_label') }}</label>
                                <input type="text" name="name" class="form-control rounded-3 p-3" id="name"
                                    placeholder="{{ __('site.full_name_placeholder') }}" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="email" class="form-label fw-semibold text-dark small">{{ __('site.email_field_label') }}</label>
                                <input type="email" class="form-control rounded-3 p-3" name="email" id="email"
                                    placeholder="example@domain.com" required>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="subject" class="form-label fw-semibold text-dark small">{{ __('site.subject_label') }}</label>
                            <input type="text" class="form-control rounded-3 p-3" name="subject" id="subject"
                                placeholder="{{ __('site.subject_placeholder') }}" required>
                        </div>

                        <div class="form-group mb-3">
                            <label for="message" class="form-label fw-semibold text-dark small">{{ __('site.message_label') }}</label>
                            <textarea class="form-control rounded-3 p-3" name="message" id="message" rows="6"
                                placeholder="{{ __('site.message_placeholder') }}" required></textarea>
                        </div>
                    </div>

                    <div class="form-footer mt-4">
                        <div class="my-3">
                            <div class="loading rounded-3 p-2 text-center">{{ __('site.sending_loading') }}</div>
                            <div class="error-message rounded-3 p-2 text-center"></div>
                            <div class="sent-message rounded-3 p-2 text-center">{{ __('site.sent_success') }}</div>
                        </div>

                        <div class="text-start btn-submit-wrap">
                            <button type="submit"
                                class="btn btn-contact-submit px-4 py-3 rounded-pill fw-bold text-white shadow d-inline-flex align-items-center gap-2">
                                <span>{{ __('site.send_message_btn') }}</span>
                                <i class="bi bi-send-fill fs-6"></i>
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>

    </div>
</section><!-- End Contact Section -->

<style>
    .contact {
        background: linear-gradient(180deg, #fdfbfe 0%, #f5e9f2 100%);
        position: relative;
    }

    .contact-badge {
        background: rgba(176, 56, 130, 0.12);
        color: #B03882;
        border: 1px solid rgba(176, 56, 130, 0.25);
        font-weight: 600;
    }

    .contact .section-title h2::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 3px;
        background: linear-gradient(90deg, #B03882 0%, #d6479f 100%);
        border-radius: 3px;
    }

    .contact .info {
        border-color: rgba(176, 56, 130, 0.15) !important;
        transition: all 0.3s ease;
    }

    .contact .info:hover {
        box-shadow: 0 15px 35px rgba(176, 56, 130, 0.12) !important;
    }

    .contact .icon-box {
        width: 48px !important;
        height: 48px !important;
        min-width: 48px !important;
        min-height: 48px !important;
        max-width: 48px !important;
        max-height: 48px !important;
        aspect-ratio: 1 / 1 !important;
        border-radius: 50% !important;
        background: linear-gradient(135deg, #B03882 0%, #d6479f 100%);
        color: #ffffff;
        box-shadow: 0 6px 15px rgba(176, 56, 130, 0.3);
        transition: all 0.3s ease;
        flex-shrink: 0 !important;
        padding: 30px 30px !important;
    }

    .contact-item:hover .icon-box {
        transform: scale(1.1);
        box-shadow: 0 8px 20px rgba(176, 56, 130, 0.45);
    }

    .contact-item {
        border: 1px solid rgba(176, 56, 130, 0.08);
        transition: all 0.3s ease;
    }

    .contact-item:hover {
        background: #ffffff !important;
        border-color: rgba(176, 56, 130, 0.25) !important;
        box-shadow: 0 8px 20px rgba(176, 56, 130, 0.08);
    }

    .php-email-form {
        border-color: rgba(176, 56, 130, 0.15) !important;
        transition: all 0.3s ease;
    }

    .php-email-form:hover {
        box-shadow: 0 15px 35px rgba(176, 56, 130, 0.12) !important;
    }

    .php-email-form input,
    .php-email-form textarea {
        border: 1px solid rgba(176, 56, 130, 0.2);
        background: #fdfbfe;
        transition: all 0.3s ease;
    }

    .php-email-form input:focus,
    .php-email-form textarea:focus {
        border-color: #B03882 !important;
        background: #ffffff !important;
        box-shadow: 0 0 0 0.25rem rgba(176, 56, 130, 0.15) !important;
        outline: none;
    }

    .btn-contact-submit {
        background: linear-gradient(135deg, #B03882 0%, #d6479f 100%);
        border: none;
        transition: all 0.3s ease;
    }

    .btn-contact-submit:hover {
        background: linear-gradient(135deg, #c74395 0%, #f05cb6 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(176, 56, 130, 0.4) !important;
        color: #ffffff !important;
    }

    .php-email-form .error-message {
        display: none;
        color: #fff;
        background: #ed3c0d;
        font-weight: 600;
    }

    .php-email-form .sent-message {
        display: none;
        color: #fff;
        background: #18d26e;
        font-weight: 600;
    }

    .php-email-form .loading {
        display: none;
        background: #fff;
        color: #B03882;
        font-weight: 600;
    }

    /* Tablet & Mobile Responsive Typography & Layout */
    @media (max-width: 991px) {
        .contact-title {
            font-size: 1.6rem !important;
        }

        .contact-desc {
            font-size: 0.92rem !important;
            line-height: 1.6 !important;
        }

        .php-email-form {
            padding: 25px 20px !important;
        }

        .contact .info {
            padding: 20px 15px !important;
        }
    }

    @media (max-width: 575px) {
        .contact-title {
            font-size: 1.4rem !important;
        }

        .btn-submit-wrap {
            text-align: center !important;
        }

        .btn-contact-submit {
            width: 100% !important;
            justify-content: center;
            padding: 12px 20px !important;
            font-size: 0.95rem !important;
        }

        .php-email-form input,
        .php-email-form textarea {
            padding: 10px 14px !important;
            font-size: 0.9rem !important;
        }
    }
</style>
