<!-- سكريبت جلب تفاصيل الفاتورة -->
<script>
    function loadInvoiceDetails(invoiceId) {
        const container = document.getElementById('invoice-details-content');
        container.innerHTML = `<div class="text-center">جاري التحميل...</div>`;

        fetch(`/seller-panel/billing/invoice/${invoiceId}`)
            .then(response => response.json())
            .then(data => {
                let statusBadge = data.status === 'paid' ? 'bg-success' : 'bg-warning';

                let html = `
                    <h5>رقم الفاتورة: <span>${data.invoice_number}</span></h5>
                    <p><strong>التاريخ:</strong> <span>${data.invoice_date}</span></p>
                    <p><strong>المبلغ الإجمالي:</strong> <span>${Number(data.total_amount).toLocaleString()} د.ج</span></p>
                    <p><strong>طريقة الدفع:</strong> <span>${data.payment_method==null?'غير متوفر':data.payment_method}</span></p>
                    <p><strong>الحالة:</strong> <span class="badge ${statusBadge}">${data.status === 'paid' ? 'مدفوعة' : 'غير مدفوعة'}</span></p>
                    <hr>
                    <h5>تفاصيل البنود:</h5>
                    <ul class="list-group mb-3">
                `;

                data.details.forEach((item, index) => {
                    html += `
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            ${index + 1}. ${item.item_name}
                            <span>${item.quantity} × ${Number(item.unit_price).toLocaleString()} د.ج</span>
                        </li>
                    `;
                });

                html += `</ul>`;

                if (data.status !== 'paid') {
                    html += `
                        <form action="/seller-panel/billing/pay/invoice/${invoiceId}/redirect" method="POST">
                            <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                            <input type="hidden" name="invoice_id" value="${invoiceId}">

                            <h5>اختر طريقة الدفع</h5>
                            <select class="form-select mb-3" name="payment_method" required>
                                <option value="">-- اختر طريقة --</option>
                                <option value="wallet">رصيدي على المنصة</option>
                                <option value="credit-card">بطاقة ائتمان</option>
                                <option value="baridi-mob">بريدي موب</option>
                                <option value="ccp">بريد الجزائر</option>
                            </select>

                            <button type="submit" class="btn btn-success w-100">إتمام الدفع</button>
                        </form>
                    `;
                }

                container.innerHTML = html;
            })
            .catch(err => {
                console.error(err);
                container.innerHTML = `<div class="text-danger text-center">حدث خطأ أثناء تحميل التفاصيل.</div>`;
            });
    }
</script>