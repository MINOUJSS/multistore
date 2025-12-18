<div class="container mt-5 mb-5">
    <div class="row">
                <form id="disputeForm" action="{{route('site.dispute.store')}}" method="POST" enctype="multipart/form-data" class="border rounded p-3 bg-light shadow-sm">
                    @csrf
                    <h5 class="text-center mb-3">📨 تقديم شكوى أو نزاع</h5>

                    <!-- رقم الطلب -->
                    <div class="mb-3">
                        <label class="form-label">🔢 رقم الطلب *</label>
                        <input type="text" name="order_number" placeholder="أدخل رقم الطلب" required
                            class="form-control">
                    </div>

                    <!-- بيانات الزبون -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">👤 اسمك الكامل</label>
                            <input type="text" name="customer_name" placeholder="اسم الزبون" class="form-control" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">📞 رقم الهاتف</label>
                            <input type="text" name="customer_phone" placeholder="مثال: 0555xxxxxx"
                                class="form-control" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">✉️ البريد الإلكتروني</label>
                        <input type="email" name="customer_email" placeholder="example@email.com"
                            class="form-control">
                    </div>

                    <!-- البائع أو المورد المعني -->
                    <div class="mb-3">
                        <label class="form-label">🏪 معرف البائع</label>
                        <input type="text" name="seller_id" placeholder="أدخل معرف البائع أو اسمه (اختياري)"
                            class="form-control" required>
                    </div>

                    <!-- تفاصيل النزاع -->
                    <div class="mb-3">
                        <label class="form-label">📝 موضوع النزاع *</label>
                        <input type="text" name="subject" placeholder="مثال: تأخر في تسليم الطلب" required
                            class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">📄 شرح المشكلة بالتفصيل *</label>
                        <textarea name="description" rows="4" placeholder="اشرح طبيعة النزاع بالتفصيل..." required class="form-control"></textarea>
                    </div>

                    <!-- المرفقات -->
                    <div class="mb-3">
                        <label class="form-label">📎 أدلة أو صور داعمة (اختياري)</label>
                        <input type="file" name="attachments[]" multiple class="form-control">
                        <small class="text-muted">يمكنك رفع صور، فواتير، أو أي مستندات تؤكد مشكلتك (الحد الأقصى 2MB لكل
                            ملف).</small>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        🚀 إرسال الشكوى
                    </button>
                </form>

    </div>
</div>
{{-- //sweet alert --}}
@if(session()->has('success'))
    <script>
        Swal.fire({
            position: 'center',
            icon: 'success',
            title: '{{session()->get('success')}}',
            showConfirmButton: false,
            timer: 1500
        })
    </script>
@endif

