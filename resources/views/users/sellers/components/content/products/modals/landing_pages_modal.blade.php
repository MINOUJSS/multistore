{{-- Landing Pages Management Modal --}}
<div class="modal fade" id="landingPagesModal" tabindex="-1" aria-labelledby="landingPagesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <div class="d-flex align-items-center gap-3">
                    <div class="avatar avatar-md rounded-3 text-white d-flex align-items-center justify-content-center shadow-sm"
                        style="background: linear-gradient(135deg, #B03882 0%, #7928ca 100%); width: 48px; height: 48px;">
                        <i class="fa-solid fa-wand-magic-sparkles fs-5"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-dark mb-1" id="landingPagesModalLabel">
                            صفحات الهبوط بالذكاء الاصطناعي
                        </h5>
                        <p class="text-muted small mb-0" id="landingProductSubtitle">
                            إدارة وتوليد صفحات هبوط احترافية من عدة زوايا تسويقية
                        </p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4">
                {{-- AI Credits Status Banner --}}
                <div class="card border-0 rounded-4 p-3 mb-4 shadow-2xs"
                    style="background: linear-gradient(135deg, rgba(176, 56, 130, 0.08) 0%, rgba(121, 40, 202, 0.08) 100%); border: 1px solid rgba(176, 56, 130, 0.2) !important;">
                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-white text-plum d-flex align-items-center justify-content-center shadow-xs"
                                style="width: 42px; height: 42px;">
                                <i class="fa-solid fa-coins fs-5"></i>
                            </div>
                            <div>
                                <span class="d-block text-muted small fw-bold">رصيدك الحالي من نقاط الذكاء الاصطناعي:</span>
                                <h4 class="mb-0 fw-bold text-plum">
                                    <span id="sellerAiCreditsBadge">0</span> <small class="fs-6 text-muted">نقطة</small>
                                </h4>
                            </div>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-white text-dark border px-3 py-2 rounded-pill fw-bold">
                                <i class="fa-solid fa-bolt text-warning me-1"></i> تكلفة التوليد: <span id="generationCostBadge">10</span> نقاط / صفحة
                            </span>
                            <a href="{{ route('seller.services.index') }}" class="btn btn-sm btn-plum rounded-pill px-3 py-1.5 fw-bold shadow-2xs">
                                <i class="fa-solid fa-plus me-1"></i> شحن رصيد نقاط
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Accordion: Generate New Landing Page --}}
                <div class="card border rounded-4 mb-4 shadow-2xs overflow-hidden">
                    <div class="card-header bg-white py-3 px-4 border-bottom-0 d-flex align-items-center justify-content-between cursor-pointer"
                        data-bs-toggle="collapse" data-bs-target="#generateFormCollapse" aria-expanded="true">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fa-solid fa-sparkles text-plum"></i>
                            <h6 class="mb-0 fw-bold text-dark">توليد صفحة هبوط جديدة لهذا المنتج</h6>
                        </div>
                        <span class="badge bg-light text-secondary rounded-pill"><i class="fa-solid fa-chevron-down"></i></span>
                    </div>

                    <div class="collapse show" id="generateFormCollapse">
                        <div class="card-body px-4 pt-0 pb-4">
                            <form id="generateLandingPageForm">
                                <input type="hidden" id="lpTargetProductId" name="product_id" value="">
                                
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-dark">
                                            الزاوية التسويقية / الجمهور المستهدف <span class="text-danger">*</span>
                                        </label>
                                        <select class="form-select rounded-3" name="marketing_angle" id="lpMarketingAngle" required>
                                            <option value="pain_relief" selected>🎯 زاوية حل المشكلة / تخفيف الألم والراحة القصوى</option>
                                            <option value="gift">🎁 زاوية الهدية المثالية لشخص عزيز</option>
                                            <option value="luxury">✨ زاوية الفخامة والأناقة والمكانة الاجتماعية</option>
                                            <option value="savings">💰 زاوية التوفير وأفضل قيمة مقابل السعر</option>
                                            <option value="speed">⚡ زاوية توفير الوقت والسهولة والسرعة</option>
                                            <option value="general">📢 زاوية التسويق الشامل وإبراز القيمة</option>
                                            <option value="custom">✍️ زاوية مخصصة (كتابة تعليمات حرة)</option>
                                        </select>
                                        <div class="form-text small text-muted">
                                            سيكتب الذكاء الاصطناعي محتوى الصفحة ليتناسب 100% مع هذه الزاوية والجمهور.
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-bold small text-dark">
                                            عنوان الحملة / الصفحة (اختياري)
                                        </label>
                                        <input type="text" class="form-control rounded-3" name="title" id="lpCustomTitle"
                                            placeholder="اتركه فارغاً ليقوم الذكاء الاصطناعي باقتراح عنوان مميز...">
                                    </div>

                                    <div class="col-12" id="customPromptContainer" style="display: none;">
                                        <label class="form-label fw-bold small text-dark">
                                            تعليمات أو نقاط إضافية تريد التركيز عليها
                                        </label>
                                        <textarea class="form-control rounded-3" name="custom_prompt" id="lpCustomPrompt" rows="2"
                                            placeholder="مثال: ركّز على أن المنتج مناسب للرياضيين، أو قدم عرض اشتري 1 واحصل على الثاني بنصف السعر..."></textarea>
                                    </div>

                                    <div class="col-12 text-end pt-2">
                                        <button type="submit" class="btn btn-plum px-4 py-2 rounded-3 fw-bold shadow-sm" id="btnSubmitGenerateLp">
                                            <i class="fa-solid fa-wand-magic-sparkles me-1"></i> توليد صفحة الهبوط الآن (خصم 10 نقاط)
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Existing Landing Pages Section --}}
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <h6 class="fw-bold text-dark mb-0">
                        <i class="fa-solid fa-layer-group me-1 text-plum"></i> صفحات الهبوط المنشأة لهذا المنتج
                    </h6>
                    <span class="badge bg-light text-dark border px-2.5 py-1 rounded-pill fw-bold" id="lpCountBadge">0 صفحة</span>
                </div>

                <div class="table-responsive border rounded-4 bg-white shadow-2xs">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">عنوان الصفحة / الزاوية</th>
                                <th>رابط صفحة الهبوط</th>
                                <th class="text-center">الزيارات</th>
                                <th class="text-center">الحالة</th>
                                <th class="pe-3 text-end">الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody id="landingPagesTableBody">
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <div class="spinner-border spinner-border-sm text-plum me-2" role="status"></div>
                                    جاري جلب صفحات الهبوط...
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal-footer border-0 pt-0 px-4 pb-4">
                <button type="button" class="btn btn-light rounded-3 px-4 fw-bold" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit Landing Page Modal --}}
<div class="modal fade" id="editLandingPageModal" tabindex="-1" aria-labelledby="editLandingPageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-dark" id="editLandingPageModalLabel">
                    <i class="fa-solid fa-pen-to-square me-1 text-plum"></i> تعديل محتوى صفحة الهبوط
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateLandingPageForm">
                <div class="modal-body p-4">
                    <input type="hidden" id="editLpId" name="id">

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">عنوان صفحة الهبوط (لتمييزها في لوحة التحكم) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3" id="editLpTitle" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">العنوان الرئيسي الإعلاني (Hero Headline) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control rounded-3" id="editLpHeroHeadline" name="hero_headline" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">العنوان الفرعي الإقناعي (Hero Subheadline)</label>
                        <textarea class="form-control rounded-3" id="editLpHeroSubheadline" name="hero_subheadline" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small text-dark">حالة النشر <span class="text-danger">*</span></label>
                        <select class="form-select rounded-3" id="editLpStatus" name="status" required>
                            <option value="published">منشورة ونشطة (متاحة للزبائن)</option>
                            <option value="paused">معطلة مؤقتاً</option>
                            <option value="draft">مسودة</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-3 px-4 fw-bold" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-plum rounded-3 px-4 fw-bold" id="btnSaveEditLp">
                        <i class="fa-solid fa-floppy-disk me-1"></i> حفظ التعديلات
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
