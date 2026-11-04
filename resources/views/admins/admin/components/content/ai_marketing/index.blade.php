<div class="container-fluid px-3 px-md-4 py-4 overflow-hidden" style="max-width: 100%;">

    <!-- Dynamic Hero Welcome Banner -->
    <div class="dashboard-hero p-4 p-md-5 mb-4 shadow-sm" style="background: linear-gradient(135deg, #5c0649 0%, #a40c72 50%, #be0681 100%); border-radius: 1.25rem; color: #ffffff; position: relative; overflow: hidden;">
        <div class="row align-items-center position-relative z-1">
            <div class="col-lg-8 mb-3 mb-lg-0">
                <div class="d-inline-flex align-items-center gap-2 px-3 py-1 bg-white bg-opacity-10 rounded-pill text-white small mb-3 border border-white border-opacity-10">
                    <i class="fa-solid fa-robot text-warning"></i>
                    <span>{{ __('وكيل التسويق الذكي للنمو') }}</span>
                    <span class="opacity-50">|</span>
                    <span>{{ now()->locale('ar')->translatedFormat('l، j F Y') }}</span>
                </div>
                <h1 class="display-6 fw-bold mb-2 text-white text-start">
                    🤖 وكيل التسويق بالذكاء الاصطناعي (AI Marketing Agent)
                </h1>
                <p class="text-white-50 mb-0 leading-relaxed text-start">
                    يقوم الوكيل باستخراج مؤشرات المبيعات ونشاط المتاجر من قاعدة البيانات، واستطلاع اتجاهات السوق، ثم صياغة محتوى تسويقي احترافي للسوشيال ميديا لجذب تجار جدد لمنصة dzora.net.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <div class="d-flex flex-wrap gap-2 justify-content-lg-end">
                    <a href="{{ route('admin.ai_marketing.index') }}" class="btn btn-warning text-dark fw-bold px-3 py-2 rounded-3 border-0 shadow-sm">
                        <i class="fa-solid fa-rotate me-1"></i> تحديث السجل
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Stat Cards Overview -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">إجمالي المنشورات</span>
                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 text-primary">
                        <i class="fa-solid fa-file-pen"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-dark">{{ $stats['total'] }}</h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">المعتمدة للترويج</span>
                    <div class="rounded-circle bg-success bg-opacity-10 p-2 text-success">
                        <i class="fa-solid fa-circle-check"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-success">{{ $stats['approved'] }}</h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">المسودات والمقترحات</span>
                    <div class="rounded-circle bg-warning bg-opacity-10 p-2 text-warning">
                        <i class="fa-solid fa-lightbulb"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-warning">{{ $stats['draft'] }}</h3>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 h-100 bg-white">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="text-muted small fw-medium">المنشورة فعلياً</span>
                    <div class="rounded-circle bg-info bg-opacity-10 p-2 text-info">
                        <i class="fa-solid fa-share-nodes"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-0 text-info">{{ $stats['published'] }}</h3>
            </div>
        </div>
    </div>

    <!-- AI Generation Form Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
            <div class="d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle p-2" style="background: rgba(186, 6, 129, 0.1); color: #be0681;">
                        <i class="fa-solid fa-wand-magic-sparkles fs-5"></i>
                    </div>
                    <div>
                        <h5 class="fw-bold mb-0 text-dark">توليد حملة تسويقية جديدة عبر الوكيل</h5>
                        <small class="text-muted">الوكيل سيقرأ مؤشرات المنصة ويوظفها لإقناع التجار بالانضمام</small>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-4">
            <form action="{{ route('admin.ai_marketing.generate') }}" method="POST" id="generateForm">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">منصة النشر المستهدفة</label>
                        <select name="platform" class="form-select rounded-3 shadow-none border-secondary-subtle py-2">
                            <option value="facebook" selected>📱 فيسبوك (Facebook Post)</option>
                            <option value="instagram">📸 إنستغرام (Instagram Caption)</option>
                            <option value="linkedin">💼 لينكد إن (LinkedIn Professional)</option>
                            <option value="blog">📝 مقال تسويقي للمدونة (SEO Blog Article)</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">نبرة الخطاب (Tone of Voice)</label>
                        <select name="tone" class="form-select rounded-3 shadow-none border-secondary-subtle py-2">
                            <option value="inspiring" selected>🚀 ملهمة ومحفزة للنجاح التجاري</option>
                            <option value="algerian_dialect">🇩🇿 دارجة جزائرية قريبة وشعبية للتجار</option>
                            <option value="professional">💼 رسمية واحترافية B2B</option>
                            <option value="informative">💡 تعليمية تشرح مزايا التوصيل والدفع</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold small text-muted">الهدف الخاص بالحملة (اختياري)</label>
                        <input type="text" name="goal" class="form-control rounded-3 shadow-none border-secondary-subtle py-2" placeholder="مثلاً: التركيز على ميزة التوصيل لـ 58 ولاية أو الدروبشيبينغ">
                    </div>

                    <div class="col-12 text-end mt-3">
                        <button type="submit" class="btn text-white fw-bold px-4 py-2 rounded-3 shadow-sm" style="background: linear-gradient(135deg, #a40c72 0%, #be0681 100%);" id="btnSubmit">
                            <i class="fa-solid fa-sparkles me-1"></i> توليد المحتوى الآن بواسطة الوكيل
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Posts History & Management -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 pt-4 px-4 pb-2">
            <h5 class="fw-bold mb-1 text-dark">سجل المقالات والمنشورات المولدة</h5>
            <small class="text-muted">مراجعة المحتوى، نسخه بضغطة زر، واعتماده للنشر على السوشيال ميديا</small>
        </div>
        <div class="card-body p-4">
            @if($posts->isEmpty())
                <div class="text-center py-5">
                    <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="fa-solid fa-feather fs-3 text-muted"></i>
                    </div>
                    <h6 class="fw-bold text-dark">لا توجد منشورات مولدة حتى الآن</h6>
                    <p class="text-muted small">استخدم النموذج أعلاه لتوليد أول منشور تسويقي مبني على بيانات متجرك.</p>
                </div>
            @else
                <div class="row g-4">
                    @foreach($posts as $post)
                        <div class="col-lg-6">
                            <div class="card h-100 border rounded-4 p-3 shadow-sm bg-white position-relative">
                                <div class="d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                                    <div class="d-flex align-items-center gap-2">
                                        @if($post->platform === 'facebook')
                                            <span class="badge bg-primary rounded-pill px-3 py-1"><i class="fa-brands fa-facebook me-1"></i> Facebook</span>
                                        @elseif($post->platform === 'instagram')
                                            <span class="badge bg-danger rounded-pill px-3 py-1"><i class="fa-brands fa-instagram me-1"></i> Instagram</span>
                                        @elseif($post->platform === 'linkedin')
                                            <span class="badge bg-info text-dark rounded-pill px-3 py-1"><i class="fa-brands fa-linkedin me-1"></i> LinkedIn</span>
                                        @else
                                            <span class="badge bg-dark rounded-pill px-3 py-1"><i class="fa-solid fa-newspaper me-1"></i> Blog</span>
                                        @endif

                                        <span class="badge rounded-pill px-3 py-1
                                            @if($post->status === 'approved') bg-success
                                            @elseif($post->status === 'published') bg-info text-dark
                                            @elseif($post->status === 'rejected') bg-danger
                                            @else bg-warning text-dark @endif">
                                            {{ $post->status === 'draft' ? 'مسودة' : ($post->status === 'approved' ? 'معتمد' : ($post->status === 'published' ? 'منشور' : 'مرفوض')) }}
                                        </span>
                                    </div>
                                    <small class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                </div>

                                <h6 class="fw-bold text-dark mb-2">{{ $post->title }}</h6>
                                
                                <div class="p-3 bg-light rounded-3 mb-3 small" style="white-space: pre-wrap; max-height: 250px; overflow-y: auto; line-height: 1.7;" id="post-content-{{ $post->id }}">{{ $post->content }}</div>

                                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2 mt-auto pt-2 border-top">
                                    <button class="btn btn-outline-secondary btn-sm rounded-pill px-3 copy-btn" data-target="post-content-{{ $post->id }}">
                                        <i class="fa-solid fa-copy me-1"></i> نسخ النص
                                    </button>

                                    <div class="d-flex align-items-center gap-2">
                                        <!-- تغيير الحالة -->
                                        <form action="{{ route('admin.ai_marketing.status', $post->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            @if($post->status !== 'approved')
                                                <input type="hidden" name="status" value="approved">
                                                <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-2" title="اعتماد">
                                                    <i class="fa-solid fa-check"></i> اعتماد
                                                </button>
                                            @else
                                                <input type="hidden" name="status" value="published">
                                                <button type="submit" class="btn btn-sm btn-outline-info rounded-pill px-2" title="تم النشر">
                                                    <i class="fa-solid fa-paper-plane"></i> تم النشر
                                                </button>
                                            @endif
                                        </form>

                                        <!-- الحذف -->
                                        <form action="{{ route('admin.ai_marketing.destroy', $post->id) }}" method="POST" class="d-inline" onsubmit="return confirm('هل أنت متأكد من حذف هذا المنشور؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle" style="width: 32px; height: 32px;" title="حذف">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // زر النسخ السريع إلى الحافظة
        document.querySelectorAll('.copy-btn').forEach(button => {
            button.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const text = document.getElementById(targetId).innerText;
                navigator.clipboard.writeText(text).then(() => {
                    const originalHtml = this.innerHTML;
                    this.innerHTML = '<i class="fa-solid fa-check text-success me-1"></i> تم النسخ!';
                    this.classList.add('border-success');
                    setTimeout(() => {
                        this.innerHTML = originalHtml;
                        this.classList.remove('border-success');
                    }, 2000);
                });
            });
        });

        // تأثير أثناء توليد المنشور
        const form = document.getElementById('generateForm');
        const submitBtn = document.getElementById('btnSubmit');
        if (form && submitBtn) {
            form.addEventListener('submit', function () {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> جاري استخراج البيانات وصياغة المنشور بالذكاء الاصطناعي...';
            });
        }
    });
</script>

