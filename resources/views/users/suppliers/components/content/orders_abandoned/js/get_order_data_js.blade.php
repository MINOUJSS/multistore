<script>
document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".view-order").forEach(button => {
        button.addEventListener("click", function () {
            let orderId = this.getAttribute("data-order-id");

            fetch(`/supplier-panel/order-abandoned/${orderId}`)
                .then(response => response.json())
                .then(order => {
                    // تحديث معلومات الطلب
                    document.getElementById("order-number").textContent = `#${order.order_number}`;
                    document.getElementById("customer-name").textContent = order.customer_name;
                    if (order.phone_visiblity) {
                        document.getElementById("customer-phone").textContent = order.phone;
                    } else {
                        document.getElementById("customer-phone").innerHTML = '<img src="/asset/v1/users/dashboard/img/other/lock.png" alt="phone" style="cursor: pointer;" />';
                    }
                    // document.getElementById("customer-phone").textContent = order.phone;
                    document.getElementById("customer-email").textContent = order.email ?? "غير متوفر";
                    document.getElementById("shipping-address").textContent = order.shipping_address;
                    document.getElementById("shipping-city").textContent = order.city;
                    document.getElementById("shipping-zipcode").textContent = order.zipcode ?? "غير متوفر";
                    document.getElementById("subtotal-price").textContent = `${order.total_price} د.ج`;
                    document.getElementById("shipping-cost").textContent = `${order.shipping_cost} د.ج`;
                    document.getElementById("total-price").textContent = `${order.total_price} د.ج`;

                    // تحديث قائمة المنتجات داخل الطلب
                    let orderItemsTable = document.getElementById("order-items");
                    orderItemsTable.innerHTML = ""; // تفريغ الجدول قبل الإضافة

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
                                <small>اللون : <div style="border:1px solid #000;width:20px;height:20px;background-color:${variationColor};display:inline-block;"></div> -المقاس : ${variationSize} - الوزن : ${variationWeight}  - ${attributeDetails}</small>
                            </td> 
                            <td>${item.quantity}</td>
                            <td>${item.unit_price} د.ج</td>
                            <td>${item.total_price} د.ج</td>
                        </tr>
                    `;
                });


                    // فتح المودال
                    let modal = new bootstrap.Modal(document.getElementById("viewOrderModal"));
                    modal.show();
                })
                .catch(error => console.error("Error fetching order details:", error));
        });
    });
});
</script>