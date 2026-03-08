<script>
    let baseDomain = '{{ env('APP_DOMAIN') }}'; // سيتم استبدالها عند تحميل الصفحة
    let Supplier_domain = window.location.protocol + '//' + '{{ auth()->user()->tenant_id }}.' + baseDomain;
    document.addEventListener("DOMContentLoaded", function() {
        // يمكن تفعيل الأكواد المعلقة هنا لاحقاً إذا لزم الأمر

    });

    // دالة مساعدة لإعادة استخدام كود جلب بيانات الطلب
    async function fetchOrderDetails(orderId) {
        try {
            const response = await fetch(`/supplier-panel/order/${orderId}`);
            if (!response.ok) throw new Error('Network response was not ok');
            return await response.json();
        } catch (error) {
            console.error("Error fetching order details:", error);
            throw error;
        }
    }

    // دالة مساعدة لتحديث واجهة بيانات الطلب
    function updateOrderUI(order) {
        // أولاً: جهّز رابط الدفع القادم من السيرفر
        let to_pay_links = "";
        // تحديث معلومات العميل
        document.getElementById("order-number").textContent = `#${order.order_number}`;
        document.getElementById("customer-name").textContent = order.customer_name;

        const phoneElement = document.getElementById("customer-phone");
        phoneElement.innerHTML = order.phone_visiblity ?
            order.phone :
            '<img src="/asset/v1/users/dashboard/img/other/lock.png" alt="phone" style="cursor: pointer;" />';

        document.getElementById("customer-email").textContent = order.email ?? "غير متوفر";
        document.getElementById("shipping-address").textContent = order.shipping_address;
        document.getElementById("shipping-zipcode").textContent = order.wilaya_id ?? "غير متوفر";
        document.getElementById("customer-note").textContent = order.note ?? "غير متوفر";
        if (order.payment_status == 'paid') {
            document.getElementById("payment-status").innerHTML = '<span class="text-success">مدفوع</span>' +
                to_pay_links;
        } else if (order.payment_status == 'pending') {
            chagily_pay_link = `${Supplier_domain}/payments/chargily_pay/${order.id}`;
            verments_pay_link = `${Supplier_domain}/payments/verments_pay/${order.id}`;
            to_pay_links = `<div id="api-keys" style="margin:20px;max-width:600px;">
                <small>قم بنسخ أحد الراوابط التالي و أرسلها إلى الزبون لإستكمال عملية الدفع بالطريقة التي يفضلها</small>
  <div>
    <strong style="min-width:150px;">رابط الدفع بواسطة شارجيلي</strong>
    <br>
    <span id="chargilyPayLink" style="word-break: break-all;">
      ${chagily_pay_link}
    </span>
  </div>

  <div>
    <strong style="min-width:150px;">رابط الدفع بواسطة تحويل بنكي</strong>
    <br>
    <span id="vermentsPayLink" style="word-break: break-all;">
      ${verments_pay_link}
    </span>
  </div>

  <div id="copyToast" style="display:none;color:green;font-weight:bold;margin-top:10px;">
    تم النسخ ✔
  </div>
</div>
`
            // to_pay_links = `<br><a href="${Supplier_domain}/payments/verments_pay/${order.id}" target="_blank" class="text-primary">رابط الدفع بواسطة تجويل بنكي</a>
            // <br><a href="${Supplier_domain}/payments/chargily_pay/${order.id}" target="_blank" class="text-primary">رابط الدفع بواسطة Chargily</a>`;
            document.getElementById("payment-status").innerHTML = '<span class="text-warning">قيد الانتظار</span>' +
                to_pay_links;
        } else {
            document.getElementById("payment-status").innerHTML = '<span class="text-danger">غير مدفوع</span>';
        }
        document.getElementById("payment-method").textContent = order.payment_method ?? "غير متوفر";
        if (order.payment_method == 'verments') {
            let proofHtml = `
  <div class="col-12 d-flex align-items-center flex-wrap gap-2">
    <p class="mb-0">
      🧾 <strong>معاينة إثبات الدفع:</strong>
      <a href="${order.payment_proof}" target="_blank" class="btn btn-primary btn-sm ms-2">
        👁️ عرض الإثبات
      </a>
    </p>
`;

            if (order.payment_status === 'pending') {
                proofHtml += `
    <button class="btn btn-success btn-sm ms-2" id="acceptPaymentProof">
      ✅ قبول الدفع
    </button>
    <button class="btn btn-danger btn-sm ms-2" id="rejectPaymentProof">
      🚫 رفض الدفع وإلغاء الطلب
    </button>
  `;
            }

            proofHtml += `</div>`;

            document.getElementById("payment_proof").innerHTML = proofHtml;

            //script for accept and reject payment proof
            setTimeout(() => {
                const acceptBtn = document.getElementById("acceptPaymentProof");
                const rejectBtn = document.getElementById("rejectPaymentProof");

                if (!acceptBtn || !rejectBtn) return;

                // --- زر قبول الدفع ---
                acceptBtn.addEventListener("click", async function(e) {
                    e.preventDefault();

                    const confirmResult = await Swal.fire({
                        title: "تأكيد العملية",
                        text: "هل تريد تأكيد قبول إثبات الدفع؟",
                        icon: "question",
                        showCancelButton: true,
                        confirmButtonText: "نعم، تأكيد",
                        cancelButtonText: "إلغاء",
                        reverseButtons: true
                    });

                    if (!confirmResult.isConfirmed) return;

                    try {
                        const response = await fetch(
                            `/supplier-panel/order/${order.id}/accept-payment`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    status: "accepted"
                                })
                            });

                        const result = await response.json();

                        if (response.ok) {
                            await Swal.fire({
                                icon: "success",
                                title: "تم بنجاح",
                                text: "✅ تم قبول إثبات الدفع بنجاح!",
                                confirmButtonText: "حسناً"
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "خطأ",
                                text: "❌ " + (result.message || "تعذر قبول الدفع."),
                                confirmButtonText: "موافق"
                            });
                        }
                    } catch (error) {
                        console.error(error);
                        Swal.fire({
                            icon: "warning",
                            title: "فشل الاتصال",
                            text: "⚠️ فشل الاتصال بالخادم.",
                            confirmButtonText: "حسناً"
                        });
                    }
                });

                // --- زر رفض الدفع ---
                rejectBtn.addEventListener("click", async function(e) {
                    e.preventDefault();

                    const confirmResult = await Swal.fire({
                        // title: "تأكيد الرفض",
                        // text: "هل تريد رفض إثبات الدفع؟",
                        // icon: "warning",
                        // showCancelButton: true,
                        // confirmButtonText: "نعم، رفض",
                        // cancelButtonText: "إلغاء",
                        // reverseButtons: true
                        title: 'تنبيه هام',
                        html: `
            <p class="text-start" style="direction: rtl;">
                <strong>ملاحظة قانونية:</strong><br>
                رفض إثبات الدفع قد يؤدي إلى تصعيد النزاع، وفي حال قدّم الزبون شكوى رسمية وأدلى بأدلة تثبت وجود احتيال أو خطأ، فقد تتعرّض المنشأة لإجراءات قانونية أو إدارية.<br><br>
                نرجو منك التحقق بدقّة من صحة إثبات الدفع والتواصل مع فريق الدعم إذا كان لديك أي استفسار أو مستندات إضافية.<br><br>
                هل أنت متأكّد من أنك تريد رفض إثبات الدفع الآن؟
            </p>
        `,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'نعم — أرفض الإثبات',
                        cancelButtonText: 'إلغاء — تواصل مع الدعم أولاً',
                        focusCancel: true,
                        customClass: {
                            popup: 'swal2-rtl'
                        } // إذا أردت تنسيق RTL
                    });

                    if (!confirmResult.isConfirmed) return;

                    try {
                        const response = await fetch(
                            `/supplier-panel/order/${order.id}/reject-payment`, {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    status: "rejected"
                                })
                            });

                        const result = await response.json();

                        if (response.ok) {
                            await Swal.fire({
                                // icon: "info",
                                // title: "تم الرفض",
                                // text: "🚫 تم رفض إثبات الدفع وإلغاء الطلب.",
                                // confirmButtonText: "حسناً"
                                icon: 'success',
                                title: 'تم رفض إثبات الدفع',
                                text: 'تم تحديث حالة الدفع، وسيتم إعلام الأطراف ذات الصلة.'
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                icon: "error",
                                title: "خطأ",
                                text: "❌ " + (result.message || "تعذر رفض الدفع."),
                                confirmButtonText: "موافق"
                            });
                        }
                    } catch (error) {
                        console.error(error);
                        Swal.fire({
                            icon: "warning",
                            title: "فشل الاتصال",
                            text: "⚠️ فشل الاتصال بالخادم.",
                            confirmButtonText: "حسناً"
                        });
                    }
                });
            }, 300); // نضيف تأخير بسيط لضمان أن الأزرار أضيفت فعلاً للـ DOM


            //end script for accept and reject payment proof
        }

        // تحديث المعلومات المالية
        document.getElementById("shipping-cost").textContent = parseFloat(order.shipping_cost).toFixed(2).replace(
            /\B(?=(\d{3})+(?!\d))/g, ",") + ` د.ج`;
        document.getElementById("discount").textContent = parseFloat(order.discount).toFixed(2).replace(
            /\B(?=(\d{3})+(?!\d))/g, ",") + ` د.ج`;
        document.getElementById("total-price").textContent = parseFloat(order.total_price).toFixed(2).replace(
            /\B(?=(\d{3})+(?!\d))/g, ",") + ` د.ج`;

        return order; // لإمكانية استخدامها في سلسلة promises
    }

    // دالة مساعدة لتحديث جدول العناصر
    function updateOrderItemsTable(order) {
        const orderItemsTable = document.getElementById("order-items");
        orderItemsTable.innerHTML = "";

        let subTotal = order.items.reduce((total, item) => {
            const price = item.product.activediscount ?
                item.product.activediscount.discount_amount :
                item.unit_price;
            return total + (item.quantity * price);
        }, 0);

        document.getElementById("subtotal-price").textContent = parseFloat(subTotal).toFixed(2).replace(
            /\B(?=(\d{3})+(?!\d))/g, ",") + ` د.ج`;

        order.items.forEach(item => {
            const productName = item.product?.name ?? "غير متوفر";
            const variationColor = item.variation?.color ?? "غير محدد";
            const attributeDetails = item.attribute ?
                `${item.attribute.attribute?.name ?? "بدون اسم خاصية"}: ${item.attribute.value}` :
                "بدون خصائص";

            const currentPrice = item.product.activediscount ?
                item.product.activediscount.discount_amount + ' د.ج' :
                item.unit_price + ' د.ج';

            const totalPrice = item.product.activediscount ?
                item.quantity * item.product.activediscount.discount_amount :
                item.quantity * item.unit_price;

            const deleteButton = order.items.length <= 1 ?
                '' :
                `<span class="badge rounded-pill bg-danger cursor-pointer" onclick="deleteOrderItem(${order.id}, ${item.id})">حذف</span>`;

            orderItemsTable.innerHTML += `
            <tr id="order-item-${item.id}">
                <td>
                    ${productName} 
                    <br>  
                    <small>اللون: ${item.variation 
                        ? `<div style="border:1px solid #000;width:20px;height:20px;background-color:${variationColor};display:inline-block;"></div>` 
                        : variationColor} - ${attributeDetails}</small>
                </td> 
                <td>${item.quantity}</td>
                <td>${parseFloat(currentPrice).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                <td class="text-center">${deleteButton}</td>
                <td>${parseFloat(totalPrice).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")} د.ج</td>
            </tr>
        `;
        });
    }

    // حذف عنصر من الطلب
    async function deleteOrderItem(orderId, itemId) {
        try {
            // حذف العنصر من قاعدة البيانات
            await fetch('/supplier-panel/delete-order-item/' + itemId);

            // إزالة العنصر من الواجهة فوراً
            const itemElement = document.getElementById(`order-item-${itemId}`);
            if (itemElement) itemElement.remove();

            // تحديث بيانات الطلب بعد التأخير
            setTimeout(async () => {
                try {
                    const order = await fetchOrderDetails(orderId);
                    updateOrderUI(order);
                    updateOrderItemsTable(order);
                } catch (error) {
                    console.error("Error updating order after deletion:", error);
                }
            }, 2000);
        } catch (error) {
            console.error("Error deleting order item:", error);
        }
    }

    // جلب بيانات الولاية
    async function print_wilaya_name(id) {
        try {
            const response = await fetch('/supplier-panel/get-wilaya-data/' + id);
            if (!response.ok) throw new Error('Network response was not ok');
            const data = await response.json();
            document.getElementById("shipping-city").textContent = data.ar_name;
        } catch (error) {
            console.error('Error fetching wilaya data:', error);
        }
    }

    // عرض تفاصيل الطلب
    async function view_order(orderId) {
        try {
            const order = await fetchOrderDetails(orderId);
            await updateOrderUI(order);
            updateOrderItemsTable(order);
            print_wilaya_name(order.wilaya_id);

            // فتح المودال
            const modal = new bootstrap.Modal(document.getElementById("viewOrderModal"));
            modal.show();
        } catch (error) {
            console.error("Error in view_order function:", error);
        }
    }
    //-----كود نسخ و لصق الرابط----

    //---نهاية كود نسخ و لصق الرابط----
</script>
