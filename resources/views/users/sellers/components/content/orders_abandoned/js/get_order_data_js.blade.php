<script>
let currentActiveOrder = null;

document.addEventListener("DOMContentLoaded", function () {
    // التنسيق والتنفيذ باستخدام Event Delegation لدعم الأزرار الأصلية والمحدثة عبر AJAX
    document.addEventListener("click", function (e) {
        const button = e.target.closest(".view-order");
        if (!button) return;

        let orderId = button.getAttribute("data-order-id");
        if (!orderId) return;

        fetch(`/seller-panel/order-abandoned/${orderId}`)
            .then(response => response.json())
            .then(order => {
                currentActiveOrder = order;

                // تحديث معلومات الطلب
                const orderNumElem = document.getElementById("order-number");
                if (orderNumElem) orderNumElem.textContent = `#${order.order_number}`;

                const customerNameElem = document.getElementById("customer-name");
                if (customerNameElem) customerNameElem.textContent = order.customer_name;

                const phoneElem = document.getElementById("customer-phone");
                if (phoneElem) {
                    if (order.phone_visiblity) {
                        phoneElem.textContent = order.phone;
                    } else {
                        phoneElem.innerHTML = '<img src="/asset/v1/users/dashboard/img/other/lock.png" alt="phone" style="cursor: pointer;" />';
                    }
                }

                const emailElem = document.getElementById("customer-email");
                if (emailElem) emailElem.textContent = order.email ?? "غير متوفر";

                const addressElem = document.getElementById("shipping-address");
                if (addressElem) addressElem.textContent = order.shipping_address;

                const cityElem = document.getElementById("shipping-city");
                if (cityElem) cityElem.textContent = order.city ?? "غير متوفر";

                const zipcodeElem = document.getElementById("shipping-zipcode");
                if (zipcodeElem) zipcodeElem.textContent = order.zipcode ?? "غير متوفر";

                const noteElem = document.getElementById("customer-note");
                if (noteElem) noteElem.textContent = order.note ?? "-";

                const subtotalElem = document.getElementById("subtotal-price");
                if (subtotalElem) subtotalElem.textContent = `${order.total_price} د.ج`;

                const shippingCostElem = document.getElementById("shipping-cost");
                if (shippingCostElem) shippingCostElem.textContent = `${order.shipping_cost} د.ج`;

                const totalPriceElem = document.getElementById("total-price");
                if (totalPriceElem) totalPriceElem.textContent = `${order.total_price} د.ج`;

                // تحديث قائمة المنتجات داخل الطلب
                let orderItemsTable = document.getElementById("order-items");
                if (orderItemsTable) {
                    orderItemsTable.innerHTML = ""; // تفريغ الجدول قبل الإضافة

                    if (order.items && order.items.length > 0) {
                        order.items.forEach(item => {
                            let productName = item.product ? item.product.name : "غير متوفر";
                            let variationColor = item.variation ? item.variation.color : "بدون لون";
                            let variationSize = item.variation ? item.variation.size : "بدون مقاس";
                            let variationWeight = item.variation ? item.variation.weight : "بدون وزن";
                            let attributeDetails = item.attribute 
                                ? `${item.attribute.attribute ? item.attribute.attribute.name : "بدون اسم خاصية"}: ${item.attribute.value}` 
                                : "بدون خصائص";

                            orderItemsTable.innerHTML += `
                                <tr>
                                    <td>
                                        ${productName} 
                                        <br>   
                                        <small class="text-muted">اللون : <div style="border:1px solid #ccc;width:14px;height:14px;background-color:${variationColor};display:inline-block;vertical-align:middle;border-radius:3px;"></div> - المقاس : ${variationSize} - الوزن : ${variationWeight} - ${attributeDetails}</small>
                                    </td> 
                                    <td class="text-center">${item.quantity}</td>
                                    <td class="text-end">${item.unit_price} د.ج</td>
                                    <td class="text-end fw-bold">${item.total_price} د.ج</td>
                                </tr>
                            `;
                        });
                    }
                }

                // فتح المودال
                const modalElem = document.getElementById("viewOrderModal");
                if (modalElem) {
                    const modal = new bootstrap.Modal(modalElem);
                    modal.show();
                }
            })
            .catch(error => console.error("Error fetching order details:", error));
    });
});

//--- دالة طباعة الفاتورة الشاملة للطلبات المتروكة ---
function printInvoice() {
    const order = currentActiveOrder;
    const orderNumber = order ? order.order_number : (document.getElementById("order-number")?.textContent.replace('#', '') || '---');
    const customerName = order ? order.customer_name : (document.getElementById("customer-name")?.textContent || '---');
    const customerPhone = order ? (order.phone_visiblity ? order.phone : 'رقم محجوب') : (document.getElementById("customer-phone")?.textContent || '---');
    const customerEmail = order ? (order.email ?? 'غير متوفر') : (document.getElementById("customer-email")?.textContent || 'غير متوفر');
    const shippingAddress = order ? order.shipping_address : (document.getElementById("shipping-address")?.textContent || '---');
    const shippingCity = (document.getElementById("shipping-city")?.textContent || (order ? order.city : '---'));
    const customerNote = order ? (order.note ?? '-') : (document.getElementById("customer-note")?.textContent || '-');

    const subtotal = document.getElementById("subtotal-price")?.textContent || '0.00 د.ج';
    const shippingCost = document.getElementById("shipping-cost")?.textContent || '0.00 د.ج';
    const totalPrice = document.getElementById("total-price")?.textContent || '0.00 د.ج';

    let orderItemsRows = document.getElementById("order-items") ? document.getElementById("order-items").innerHTML : '';

    const printWindow = window.open('', '_blank', 'width=900,height=800');
    if (!printWindow) {
        alert('يرجى السماح بالنوافذ المنبثقة لطباعة الفاتورة.');
        return;
    }

    const invoiceHtml = `
        <!DOCTYPE html>
        <html lang="ar" dir="rtl">
        <head>
            <meta charset="UTF-8">
            <title>فاتورة طلب متروك #${orderNumber}</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.rtl.min.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;800&display=swap');
                body {
                    font-family: 'Cairo', sans-serif;
                    color: #0f172a;
                    background-color: #f8fafc;
                    padding: 30px 15px;
                    font-size: 14px;
                }
                .invoice-card {
                    background: #ffffff;
                    border: 1px solid #e2e8f0;
                    border-radius: 16px;
                    padding: 35px;
                    max-width: 850px;
                    margin: 0 auto;
                    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
                }
                .invoice-header {
                    border-bottom: 2px dashed #e2e8f0;
                    padding-bottom: 25px;
                    margin-bottom: 25px;
                }
                .invoice-title {
                    font-weight: 800;
                    color: #1e293b;
                }
                .info-box {
                    background-color: #f8fafc;
                    border: 1px solid #f1f5f9;
                    border-radius: 10px;
                    padding: 18px;
                }
                .info-box h6 {
                    font-weight: 700;
                    color: #1e293b;
                    border-bottom: 1px solid #e2e8f0;
                    padding-bottom: 8px;
                    margin-bottom: 12px;
                }
                .table-invoice {
                    width: 100%;
                    border-collapse: collapse;
                    margin-top: 15px;
                }
                .table-invoice th {
                    background-color: #f1f5f9;
                    color: #334155;
                    font-weight: 700;
                    padding: 12px 15px;
                    border: 1px solid #e2e8f0;
                }
                .table-invoice td {
                    padding: 12px 15px;
                    border: 1px solid #e2e8f0;
                }
                .table-invoice tfoot td {
                    font-weight: 700;
                    background-color: #f8fafc;
                }
                .badge-abandoned { background-color: #fef3c7; color: #b45309; border: 1px solid #fde68a; padding: 6px 16px; border-radius: 20px; font-size: 0.9rem; }
                @media print {
                    body { padding: 0; background: #fff; }
                    .invoice-card { border: none; padding: 0; box-shadow: none; }
                    .no-print { display: none !important; }
                }
            </style>
        </head>
        <body>
            <div class="no-print text-center mb-4">
                <button onclick="window.print()" class="btn btn-primary btn-lg fw-bold px-4 me-2 shadow-sm">
                    <i class="fa-solid fa-print me-2"></i> طباعة الآن
                </button>
                <button onclick="window.close()" class="btn btn-outline-secondary btn-lg px-4">
                    إغلاق Window
                </button>
            </div>

            <div class="invoice-card">
                <!-- Header -->
                <div class="invoice-header d-flex justify-content-between align-items-center">
                    <div>
                        <h2 class="invoice-title mb-1">فاتورة طلب متروك <span style="color:#a40c72;">#${orderNumber}</span></h2>
                        <span class="text-muted small">تاريخ الاصدار: ${new Date().toLocaleDateString('ar-DZ')}</span>
                    </div>
                    <div class="text-end">
                        <span class="badge-abandoned fw-bold">
                            حالة الطلب: سلة غير مكتملة
                        </span>
                    </div>
                </div>

                <!-- Customer & Shipping Info -->
                <div class="row g-3 mb-4">
                    <div class="col-6">
                        <div class="info-box h-100">
                            <h6><i class="fa-solid fa-user me-1 text-primary"></i> معلومات العميل</h6>
                            <p class="mb-1"><strong>الاسم:</strong> ${customerName}</p>
                            <p class="mb-1"><strong>الهاتف:</strong> ${customerPhone}</p>
                            <p class="mb-0"><strong>البريد الإلكتروني:</strong> ${customerEmail}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="info-box h-100">
                            <h6><i class="fa-solid fa-location-dot me-1 text-primary"></i> معلومات الشحن</h6>
                            <p class="mb-1"><strong>العنوان:</strong> ${shippingAddress}</p>
                            <p class="mb-0"><strong>المدينة/الولاية:</strong> ${shippingCity}</p>
                        </div>
                    </div>
                    ${customerNote && customerNote !== '-' ? `
                    <div class="col-12">
                        <div class="info-box">
                            <h6><i class="fa-solid fa-note-sticky me-1 text-primary"></i> ملاحظة الزبون</h6>
                            <p class="mb-0 text-muted">${customerNote}</p>
                        </div>
                    </div>` : ''}
                </div>

                <!-- Products Table -->
                <h5 class="fw-bold mb-2"><i class="fa-solid fa-cart-flatbed me-2 text-primary"></i> تفاصيل محتويات السلة</h5>
                <table class="table-invoice">
                    <thead>
                        <tr>
                            <th>المنتج والتفاصيل</th>
                            <th class="text-center">الكمية</th>
                            <th class="text-end">سعر الوحدة</th>
                            <th class="text-end">الإجمالي</th>
                        </tr>
                    </thead>
                    <tbody>
                        ${orderItemsRows}
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" class="text-start">المجموع الفرعي</td>
                            <td class="text-end">${subtotal}</td>
                        </tr>
                        <tr>
                            <td colspan="3" class="text-start">تكلفة الشحن</td>
                            <td class="text-end">${shippingCost}</td>
                        </tr>
                        <tr style="font-size:1.1rem; color:#0f172a;">
                            <td colspan="3" class="text-start fw-bold">الإجمالي الكلي</td>
                            <td class="text-end fw-bold" style="color:#a40c72;">${totalPrice}</td>
                        </tr>
                    </tfoot>
                </table>

                <!-- Footer Note -->
                <div class="text-center mt-5 pt-3 border-top text-muted small">
                    <p class="mb-0 fw-semibold">شكراً لثقتكم بنا ✨</p>
                </div>
            </div>

            <script>
                window.onload = function() {
                    setTimeout(function() {
                        window.print();
                    }, 400);
                }
            <\/script>
        </body>
        </html>
    `;

    printWindow.document.write(invoiceHtml);
    printWindow.document.close();
}
</script>