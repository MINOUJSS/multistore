<script>
    let currentLandingPagesProductId = null;
    let tenantBaseStoreUrl = '';

    // Show custom prompt if custom angle is selected
    $(document).on('change', '#lpMarketingAngle', function() {
        if ($(this).val() === 'custom') {
            $('#customPromptContainer').slideDown(200);
        } else {
            $('#customPromptContainer').slideUp(200);
        }
    });

    // Open landing pages modal
    $(document).on('click', '.manage-landing-pages', function(e) {
        e.preventDefault();
        const productId = $(this).data('product-id');
        const productName = $(this).data('product-name');

        currentLandingPagesProductId = productId;
        $('#lpTargetProductId').val(productId);
        $('#landingProductSubtitle').text('إدارة صفحات الهبوط لمنتج: ' + productName);

        $('#landingPagesTableBody').html(`
            <tr>
                <td colspan="5" class="text-center py-4 text-muted">
                    <div class="spinner-border spinner-border-sm text-plum me-2" role="status"></div>
                    جاري جلب صفحات الهبوط والرصيد...
                </td>
            </tr>
        `);

        $('#landingPagesModal').modal('show');
        loadProductLandingPages(productId);
    });

    // Fetch landing pages & credits
    function loadProductLandingPages(productId) {
        $.ajax({
            url: `/seller-panel/product/${productId}/landing-pages`,
            type: 'GET',
            dataType: 'json',
            success: function(res) {
                if (res.success) {
                    $('#sellerAiCreditsBadge').text(res.remaining_credits);
                    $('#generationCostBadge').text(res.cost_per_generation);
                    tenantBaseStoreUrl = res.tenant_url || '';

                    renderLandingPagesTable(res.landing_pages);
                }
            },
            error: function(xhr) {
                $('#landingPagesTableBody').html(`
                    <tr>
                        <td colspan="5" class="text-center py-4 text-danger">
                            <i class="fa-solid fa-triangle-exclamation me-1"></i> تعذر تحميل بيانات صفحات الهبوط، يرجى المحاولة لاحقاً.
                        </td>
                    </tr>
                `);
            }
        });
    }

    // Render table rows
    function renderLandingPagesTable(pages) {
        $('#lpCountBadge').text(pages.length + ' صفحة');

        if (!pages || pages.length === 0) {
            $('#landingPagesTableBody').html(`
                <tr>
                    <td colspan="5" class="text-center py-4 text-muted">
                        <i class="fa-solid fa-layer-group fa-2x mb-2 text-secondary d-block"></i>
                        لا توجد أي صفحات هبوط منشأة لهذا المنتج بعد.<br>
                        <small class="text-muted">اختر الزاوية التسويقية بالأعلى واضغط على "توليد صفحة الهبوط الآن".</small>
                    </td>
                </tr>
            `);
            return;
        }

        let html = '';
        pages.forEach(function(page) {
            const publicUrl = page.public_url || `${tenantBaseStoreUrl}/lp/${page.slug}`;
            const displayUrl = publicUrl.replace(/^https?:\/\//, '');
            const angleName = getMarketingAngleTitle(page.marketing_angle);
            const isPublished = page.status === 'published';

            html += `
                <tr id="lp-row-${page.id}">
                    <td class="ps-3">
                        <div class="fw-bold text-dark fs-6">${escapeHtml(page.title)}</div>
                        <span class="badge bg-light text-secondary border rounded-pill small mt-1">
                            <i class="fa-solid fa-bullseye me-1 text-plum"></i> ${angleName}
                        </span>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-1">
                            <a href="${publicUrl}" target="_blank" class="text-plum fw-semibold text-truncate small d-inline-block" style="max-width: 250px;" title="${publicUrl}" dir="ltr">
                                ${escapeHtml(displayUrl)}
                            </a>
                            <button type="button" class="btn btn-sm btn-light border p-1 rounded-2 copy-lp-link" data-url="${publicUrl}" title="نسخ الرابط">
                                <i class="fa-regular fa-copy"></i>
                            </button>
                            <a href="${publicUrl}" target="_blank" class="btn btn-sm btn-light border p-1 rounded-2 text-primary" title="معاينة الصفحة">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                        </div>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-light text-dark border px-2 py-1 rounded-pill fw-semibold">
                            <i class="fa-regular fa-eye me-1 text-muted"></i> ${page.views_count}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge ${isPublished ? 'bg-success-subtle text-success border border-success' : 'bg-warning-subtle text-warning border border-warning'} px-2.5 py-1 rounded-pill fw-bold">
                            ${isPublished ? 'منشورة' : 'معطلة'}
                        </span>
                    </td>
                    <td class="pe-3 text-end">
                        <button type="button" class="btn btn-sm btn-outline-secondary rounded-2 px-2 py-1 toggle-lp-status" data-id="${page.id}" title="${isPublished ? 'إيقاف مؤقت' : 'تفعيل النشر'}">
                            <i class="fa-solid ${isPublished ? 'fa-pause' : 'fa-play'}"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-plum rounded-2 px-2 py-1 edit-lp-btn" data-id="${page.id}" title="تعديل المحتوى">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                        <button type="button" class="btn btn-sm btn-outline-danger rounded-2 px-2 py-1 delete-lp-btn" data-id="${page.id}" title="حذف">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });

        $('#landingPagesTableBody').html(html);
    }

    function getMarketingAngleTitle(angle) {
        switch(angle) {
            case 'pain_relief': return 'حل المشكلة وتخفيف الألم';
            case 'gift': return 'الهدية المثالية';
            case 'luxury': return 'الفخامة والمكانة';
            case 'savings': return 'التوفير وأفضل قيمة';
            case 'speed': return 'السرعة والسهولة';
            case 'custom': return 'زاوية مخصصة';
            default: return 'عامة وشاملة';
        }
    }

    function escapeHtml(text) {
        if (!text) return '';
        return text.replace(/[&<>"']/g, function(m) {
            return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
        });
    }

    // Copy URL to clipboard
    $(document).on('click', '.copy-lp-link', function() {
        const url = $(this).data('url');
        navigator.clipboard.writeText(url).then(() => {
            const btn = $(this);
            btn.html('<i class="fa-solid fa-check text-success"></i>');
            setTimeout(() => { btn.html('<i class="fa-regular fa-copy"></i>'); }, 2000);
        });
    });

    // Generate Form Submit
    $('#generateLandingPageForm').on('submit', function(e) {
        e.preventDefault();
        const productId = $('#lpTargetProductId').val();
        const btn = $('#btnSubmitGenerateLp');
        const originalHtml = btn.html();

        btn.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
            جاري كتابة وتوليد الصفحة بالذكاء الاصطناعي...
        `);

        $.ajax({
            url: `/seller-panel/product/${productId}/landing-pages/generate`,
            type: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                btn.prop('disabled', false).html(originalHtml);
                if (res.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'تم التوليد بنجاح! 🚀',
                        text: res.message,
                        confirmButtonText: 'ممتاز',
                        confirmButtonColor: '#B03882'
                    });

                    $('#lpCustomTitle').val('');
                    $('#lpCustomPrompt').val('');
                    $('#customPromptContainer').hide();
                    $('#lpMarketingAngle').val('pain_relief');

                    // Reload
                    loadProductLandingPages(productId);
                }
            },
            error: function(xhr) {
                btn.prop('disabled', false).html(originalHtml);
                let msg = 'حدث خطأ أثناء محاولة التوليد.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'warning',
                    title: 'تنبيه',
                    text: msg,
                    confirmButtonText: 'حسناً',
                    confirmButtonColor: '#B03882'
                });
            }
        });
    });

    // Toggle Status
    $(document).on('click', '.toggle-lp-status', function() {
        const id = $(this).data('id');
        $.ajax({
            url: `/seller-panel/landing-pages/${id}/toggle-status`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                if (res.success) {
                    loadProductLandingPages(currentLandingPagesProductId);
                }
            }
        });
    });

    // Delete Landing Page
    $(document).on('click', '.delete-lp-btn', function() {
        const id = $(this).data('id');
        Swal.fire({
            title: 'هل أنت متأكد من الحذف؟',
            text: 'لن تتمكن من استرجاع صفحة الهبوط بعد حذفها.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'نعم، احذف الصفحة',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/seller-panel/landing-pages/${id}/delete`,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(res) {
                        if (res.success) {
                            $(`#lp-row-${id}`).fadeOut(300, function() { $(this).remove(); });
                            Swal.fire({
                                icon: 'success',
                                title: 'تم الحذف بنجاح',
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    }
                });
            }
        });
    });

    // Open Edit Modal
    $(document).on('click', '.edit-lp-btn', function() {
        const id = $(this).data('id');
        $.ajax({
            url: `/seller-panel/landing-pages/${id}/edit`,
            type: 'GET',
            success: function(res) {
                if (res.success && res.landing_page) {
                    const lp = res.landing_page;
                    $('#editLpId').val(lp.id);
                    $('#editLpTitle').val(lp.title);
                    $('#editLpHeroHeadline').val(lp.hero_headline);
                    $('#editLpHeroSubheadline').val(lp.hero_subheadline);
                    $('#editLpStatus').val(lp.status);

                    $('#editLandingPageModal').modal('show');
                }
            }
        });
    });

    // Submit Edit Form
    $('#updateLandingPageForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editLpId').val();
        const btn = $('#btnSaveEditLp');
        btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> جاري الحفظ...');

        $.ajax({
            url: `/seller-panel/landing-pages/${id}/update`,
            type: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(res) {
                btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-1"></i> حفظ التعديلات');
                if (res.success) {
                    $('#editLandingPageModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'تم التحديث بنجاح',
                        timer: 1500,
                        showConfirmButton: false
                    });
                    loadProductLandingPages(currentLandingPagesProductId);
                }
            },
            error: function() {
                btn.prop('disabled', false).html('<i class="fa-solid fa-floppy-disk me-1"></i> حفظ التعديلات');
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: 'حدث خطأ أثناء حفظ التعديلات.'
                });
            }
        });
    });
</script>
