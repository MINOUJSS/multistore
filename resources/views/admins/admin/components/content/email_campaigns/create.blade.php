<div class="container-fluid py-4">
    <!-- ===== Page Header ===== -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
        <div>
            <h3 class="fw-bold mb-1">
                <i class="fa-solid fa-plus-circle text-primary me-2"></i>
                إنشاء حملة بريدية جديدة
            </h3>
            <p class="text-muted mb-0">قم بصياغة رسالتك وتحديد الشريحة المستهدفة من البائعين والموردين لاسترجاعهم</p>
        </div>
        <div>
            <a href="{{ route('admin.email_campaigns.index') }}" class="btn btn-outline-secondary shadow-sm px-4">
                <i class="fa-solid fa-arrow-right me-1"></i> العودة للحملات
            </a>
        </div>
    </div>

    <form action="{{ route('admin.email_campaigns.store') }}" method="POST" id="campaignForm">
        @csrf
        <div class="row g-4">
            <!-- ===== Main Form Controls ===== -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-0"><i class="fa-solid fa-pen me-2 text-primary"></i>بيانات الرسالة</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="title" class="form-label fw-bold">عنوان الحملة (داخلي للأدمن): <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="مثال: حملة استرجاع البائعين غير النشطين - أوت 2026" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="subject" class="form-label fw-bold">عنوان الرسالة (Subject للمستلم): <span class="text-danger">*</span></label>
                            <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" placeholder="مثال: ننتظرك مجدداً! اكتشف العروض والميزات الجديدة في متجرك" value="{{ old('subject') }}" required>
                            @error('subject')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Variable Placeholders Quick Buttons -->
                        <div class="mb-2">
                            <label class="form-label fw-bold text-dark d-block">إدراج متغيرات تلقائية:</label>
                            <div class="d-flex flex-wrap gap-2">
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill insert-tag" data-tag="{name}">
                                    <i class="fa-solid fa-tag me-1"></i> {name} (اسم المستخدم)
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill insert-tag" data-tag="{store_name}">
                                    <i class="fa-solid fa-tag me-1"></i> {store_name} (اسم المتجر)
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-primary rounded-pill insert-tag" data-tag="{login_url}">
                                    <i class="fa-solid fa-tag me-1"></i> {login_url} (رابط الدخول)
                                </button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label fw-bold">محتوى البريد الإلكتروني: <span class="text-danger">*</span></label>
                            <textarea name="content" id="content" rows="12" class="form-control @error('content') is-invalid @enderror" placeholder="مرحباً {name}،&#10;&#10;لاحظنا عدم زيارتك لمتجرك {store_name} مؤخراً. ننصحك بالعودة الآن للاستفادة من الأدوات والمنتجات الجديدة التي أضفناها لتطوير أعمالك!&#10;&#10;اضغط على الرابط لتسجيل الدخول مباشرة: {login_url}" required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <!-- ===== Target Audience Selection & Test Email Side Card ===== -->
            <div class="col-12 col-lg-4">
                <!-- Target Audience Selection -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-0"><i class="fa-solid fa-users text-primary me-2"></i>تحديد الشريحة المستهدفة</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="mb-3">
                            <label for="target_audience" class="form-label fw-bold">اختيار الجمهور: <span class="text-danger">*</span></label>
                            <select name="target_audience" id="target_audience" class="form-select @error('target_audience') is-invalid @enderror" required>
                                <option value="inactive_sellers" selected>البائعين غير النشطين (الذين سجلوا ولم يعودوا - {{ $inactiveSellerCount }} مستخدم)</option>
                                <option value="all_sellers">جميع البائعين ({{ $sellerCount }} مستخدم)</option>
                                <option value="inactive_suppliers">الموردين غير النشطين ({{ $inactiveSupplierCount }} مستخدم)</option>
                                <option value="all_suppliers">جميع الموردين ({{ $supplierCount }} مستخدم)</option>
                                <option value="all">جميع مستخدمي المنصة ({{ $totalUserCount }} مستخدم)</option>
                                <option value="single_email">إرسال مباشر لإيميل واحد محدد (يدوي أو من المسجلين)</option>
                            </select>
                            @error('target_audience')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Single Email Input Block -->
                        <div id="singleEmailBlock" class="d-none border p-3 rounded bg-light mb-3">
                            <div class="mb-3">
                                <label for="custom_email" class="form-label fw-bold small">البريد الإلكتروني المستهدف: <span class="text-danger">*</span></label>
                                <input type="email" name="custom_email" id="custom_email" class="form-control @error('custom_email') is-invalid @enderror" placeholder="ابحث أو أدخل البريد الإلكتروني..." list="userEmailsList" value="{{ old('custom_email') }}">
                                <datalist id="userEmailsList">
                                    @if(isset($registeredUsers))
                                        @foreach($registeredUsers as $userItem)
                                            <option value="{{ $userItem['email'] }}">{{ $userItem['name'] }} ({{ $userItem['type'] }})</option>
                                        @endforeach
                                    @endif
                                </datalist>
                                <small class="text-muted">يمكنك اختيار إيميل مسجل بالمنصة أو إدخال أي بريد آخر يدوياً.</small>
                                @error('custom_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div>
                                <label for="custom_name" class="form-label fw-bold small">اسم المستلم (اختياري):</label>
                                <input type="text" name="custom_name" id="custom_name" class="form-control @error('custom_name') is-invalid @enderror" placeholder="مثال: محمد علي" value="{{ old('custom_name') }}">
                                <small class="text-muted">يُستخدم للتعويض مكان متغير {name} بالرسالة.</small>
                                @error('custom_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="alert alert-info py-2 px-3 small">
                            <i class="fa-solid fa-circle-info me-1"></i>
                            تُنفَّذ عملية الإرسال تلقائياً في الخلفية (Background Queue) لمنع بطء النظام.
                        </div>
                    </div>
                </div>

                <!-- Test Email Preview Card -->
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3">
                        <h5 class="fw-bold mb-0"><i class="fa-solid fa-vial text-warning me-2"></i>إرسال تجريبي (معاينة)</h5>
                    </div>
                    <div class="card-body p-4">
                        <p class="small text-muted mb-3">يمكنك إرسال نسخة تجريبية لبريدك للتأكد من تنسيق الرسالة ومظهرها قبل الإرسال الفعلي للجميع.</p>
                        <div class="mb-3">
                            <input type="email" id="test_email" class="form-control" placeholder="أدخل بريدك الإلكتروني" value="{{ auth()->guard('admin')->user()->email ?? '' }}">
                        </div>
                        <button type="button" class="btn btn-outline-warning w-100" id="sendTestBtn">
                            <i class="fa-solid fa-paper-plane me-1"></i> إرسال بريد تجريبي
                        </button>
                    </div>
                </div>

                <!-- Final Actions -->
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">
                        <button type="submit" class="btn btn-primary w-100 btn-lg shadow-sm">
                            <i class="fa-solid fa-paper-plane me-2"></i> تأكيد وبدء الحملة
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@section('header_js')
<script>
    // Target Audience selector change listener
    const targetAudienceSelect = document.getElementById('target_audience');
    const singleEmailBlock = document.getElementById('singleEmailBlock');
    const customEmailInput = document.getElementById('custom_email');

    function toggleSingleEmailBlock() {
        if (targetAudienceSelect.value === 'single_email') {
            singleEmailBlock.classList.remove('d-none');
            customEmailInput.setAttribute('required', 'required');
        } else {
            singleEmailBlock.classList.add('d-none');
            customEmailInput.removeAttribute('required');
        }
    }

    targetAudienceSelect.addEventListener('change', toggleSingleEmailBlock);
    toggleSingleEmailBlock();

    // Helper tag inserter
    const contentArea = document.getElementById('content');
    document.querySelectorAll('.insert-tag').forEach(button => {
        button.addEventListener('click', function () {
            const tag = this.getAttribute('data-tag');
            const startPos = contentArea.selectionStart;
            const endPos = contentArea.selectionEnd;
            const currentValue = contentArea.value;

            contentArea.value = currentValue.substring(0, startPos) + tag + currentValue.substring(endPos, currentValue.length);
            contentArea.focus();
            contentArea.selectionStart = startPos + tag.length;
            contentArea.selectionEnd = startPos + tag.length;
        });
    });

    // Test email sender
    document.getElementById('sendTestBtn').addEventListener('click', function () {
        const testEmail = document.getElementById('test_email').value;
        const subject = document.getElementById('subject').value;
        const content = document.getElementById('content').value;

        if (!testEmail || !subject || !content) {
            Swal.fire({
                icon: 'warning',
                title: 'تنبيه',
                text: 'يرجى ملء بريد الاختبار والعنوان والمحتوى أولاً.',
                confirmButtonText: 'حسناً'
            });
            return;
        }

        const btn = this;
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-1"></i> جارٍ الإرسال...';

        fetch("{{ route('admin.email_campaigns.send_test') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                test_email: testEmail,
                subject: subject,
                content: content
            })
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-paper-plane me-1"></i> إرسال بريد تجريبي';
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'نجاح',
                    text: data.message,
                    confirmButtonText: 'ممتاز'
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ',
                    text: data.message,
                    confirmButtonText: 'حسناً'
                });
            }
        })
        .catch(error => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-paper-plane me-1"></i> إرسال بريد تجريبي';
            Swal.fire({
                icon: 'error',
                title: 'خطأ',
                text: 'حدث خطأ غير متوقع أثناء إرسال البريد التجريبي.',
                confirmButtonText: 'حسناً'
            });
        });
    });
});
</script>
@endsection
