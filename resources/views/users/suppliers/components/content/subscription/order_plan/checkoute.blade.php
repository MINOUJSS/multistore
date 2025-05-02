<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card shadow rounded-4 border-0">
                <div class="card-body p-4">

                    <h3 class="text-center mb-4">تأكيد الاشتراك بالخطة</h3>

                    <!-- معلومات الخطة -->
                    <div class="border rounded p-3 mb-4 bg-light">
                        <h4 class="mb-1">خطة احترافية</h4>
                        <p class="text-muted mb-2">أفضل خيار للشركات النامية</p>
                        <h5 class="text-primary">4990 د.ج / شهرياً</h5>

                        <ul class="list-unstyled mt-3 mb-0">
                            <li><i class="fa fa-check text-success me-2"></i> منتجات غير محدودة</li>
                            <li><i class="fa fa-check text-success me-2"></i> دعم فني 24/7</li>
                            <li><i class="fa fa-check text-success me-2"></i> تقارير مفصلة</li>
                        </ul>
                    </div>

                    <!-- نموذج الدفع -->
                    <form action="/checkout/submit" method="POST">
                        <!-- بيانات وهمية للتوضيح -->
                        <div class="mb-3">
                            <label for="fullName" class="form-label">الاسم الكامل</label>
                            <input type="text" class="form-control" id="fullName" name="fullName" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">البريد الإلكتروني</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>

                        <div class="mb-3">
                            <label for="paymentMethod" class="form-label">طريقة الدفع</label>
                            <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                                <option value="">اختر طريقة الدفع</option>
                                <option value="card">بطاقة بنكية</option>
                                <option value="baridimob">بريدي موب</option>
                                <option value="ccp">CCP</option>
                                <option value="chargily">ChargilyPay</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">تأكيد الطلب</button>
                    </form>

                    <!-- ملاحظة -->
                    <p class="text-muted mt-4 small text-center">
                        سيتم تفعيل الخطة مباشرة بعد تأكيد الدفع.
                    </p>
                </div>
            </div>

        </div>
    </div>
</div>
