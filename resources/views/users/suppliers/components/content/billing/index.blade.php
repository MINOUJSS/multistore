<div class="container mt-5">
    <h2 class="text-center mb-4">فواتير تاجر الجملة</h2>

    <!-- جدول عرض الفواتير -->
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>رقم الفاتورة</th>
                        <th>التاريخ</th>
                        <th>المبلغ الإجمالي</th>
                        <th>الحالة</th>
                        <th>الإجراء</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- بيانات الفواتير -->
                    <tr>
                        <td>1</td>
                        <td>INV-001</td>
                        <td>2025-04-03</td>
                        <td>15,000 د.ج</td>
                        <td><span class="badge bg-warning">غير مدفوعة</span></td>
                        <td><button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#invoiceDetailsModal" onclick="loadInvoiceDetails(1)">عرض التفاصيل</button></td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>INV-002</td>
                        <td>2025-03-28</td>
                        <td>20,000 د.ج</td>
                        <td><span class="badge bg-success">مدفوعة</span></td>
                        <td><button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#invoiceDetailsModal" onclick="loadInvoiceDetails(2)">عرض التفاصيل</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- مودال تفاصيل الفاتورة -->
<div class="modal fade" id="invoiceDetailsModal" tabindex="-1" aria-labelledby="invoiceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="invoiceDetailsModalLabel">تفاصيل الفاتورة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
            </div>
            <div class="modal-body">
                <h5>رقم الفاتورة: <span id="invoice-number">INV-001</span></h5>
                <p><strong>التاريخ:</strong> <span id="invoice-date">2025-04-03</span></p>
                <p><strong>المبلغ الإجمالي:</strong> <span id="invoice-amount">15,000 د.ج</span></p>
                <p><strong>الحالة:</strong> <span class="badge bg-warning" id="invoice-status">غير مدفوعة</span></p>

                <hr>
                <h5>اختر طريقة الدفع</h5>
                <select class="form-select mb-3" id="payment-method">
                    <option value="credit-card">بطاقة ائتمان</option>
                    <option value="paypal">باي بال</option>
                    <option value="bank-transfer">تحويل بنكي</option>
                </select>
                <button class="btn btn-success w-100">إتمام الدفع</button>
            </div>
        </div>
    </div>
</div>

<script>
    function loadInvoiceDetails(invoiceId) {
        // بيانات الفواتير التجريبية (في التطبيق الفعلي، يجب جلبها من API أو قاعدة البيانات)
        const invoices = {
            1: { number: 'INV-001', date: '2025-04-03', amount: '15,000 د.ج', status: 'غير مدفوعة', statusClass: 'bg-warning' },
            2: { number: 'INV-002', date: '2025-03-28', amount: '20,000 د.ج', status: 'مدفوعة', statusClass: 'bg-success' }
        };

        const invoice = invoices[invoiceId];

        document.getElementById('invoice-number').innerText = invoice.number;
        document.getElementById('invoice-date').innerText = invoice.date;
        document.getElementById('invoice-amount').innerText = invoice.amount;

        let statusElement = document.getElementById('invoice-status');
        statusElement.innerText = invoice.status;
        statusElement.className = `badge ${invoice.statusClass}`;
    }
</script>

