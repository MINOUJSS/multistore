<script>
    document.addEventListener("DOMContentLoaded", function() {
        // get_wilaya_data(8);
        // document.querySelectorAll(".view-order").forEach(button => {
        //     button.addEventListener("click", function () {
        //         let orderId = this.getAttribute("data-order-id");

        //         fetch(`/seller-panel/order/${orderId}`)
        //             .then(response => response.json())
        //             .then(order => {
        //                 // تحديث معلومات الطلب
        //                 document.getElementById("order-number").textContent = `#${order.order_number}`;
        //                 document.getElementById("customer-name").textContent = order.customer_name;
        //                 if (order.phone_visiblity) {
        //                     document.getElementById("customer-phone").textContent = order.phone;
        //                 } else {
        //                     document.getElementById("customer-phone").innerHTML = '<img src="/asset/v1/users/dashboard/img/other/lock.png" alt="phone" style="cursor: pointer;" />';
        //                 }
        //                 // document.getElementById("customer-phone").textContent = order.phone;
        //                 document.getElementById("customer-email").textContent = order.email ?? "غير متوفر";
        //                 document.getElementById("shipping-address").textContent = order.shipping_address;
        //                 document.getElementById("shipping-city").textContent = order.city;
        //                 document.getElementById("shipping-zipcode").textContent = order.zipcode ?? "غير متوفر";
        //                 // document.getElementById("subtotal-price").textContent = `${order.total_price} د.ج`;
        //                 document.getElementById("shipping-cost").textContent = `${order.shipping_cost} د.ج`;
        //                 document.getElementById("discount").textContent = `${order.discount} د.ج`;
        //                 document.getElementById("total-price").textContent = `${order.total_price} د.ج`;

        //                 // تحديث قائمة المنتجات داخل الطلب
        //                 let orderItemsTable = document.getElementById("order-items");
        //                 orderItemsTable.innerHTML = ""; // تفريغ الجدول قبل الإضافة
        //                 let sub_totle=0;
        //                 order.items.forEach(item => {
        //                     if(item.product.activediscount==null)
        //                     {
        //                         sub_totle+=item.quantity * item.unit_price;
        //                     }
        //                     else
        //                     {
        //                         sub_totle+=item.quantity * item.product.activediscount.discount_amount;
        //                     }
        //                 // let activeDiscount=item.product.activediscount ? item.product.activediscount.discount_amount : '0';
        //                 let productName = item.product ? item.product.name : "غير متوفر";
        //                 let variationColor = item.variation ? item.variation.color : "غير محدد";
        //                 let variationSize = item.variation ? item.variation.size : "بدون مقاس";
        //                 let variationWeight = item.variation ? item.variation.weight : "بدون وزن";
        //                 let attributeDetails = item.attribute 
        //                     ? `${item.attribute.attribute ? item.attribute.attribute.name : "بدون اسم خاصية"}: ${item.attribute.value}` 
        //                     : "بدون خصائص";

        //                 document.getElementById("subtotal-price").textContent = `${sub_totle} د.ج`;
        //                 orderItemsTable.innerHTML += `
        //                     <tr>
        //                         <td>
        //                             ${productName} 
        //                             <br>  
        //                             <small>اللون : ${item.variation ? `<div style="border:1px solid #000;width:20px;height:20px;background-color:${variationColor};display:inline-block;"></div>` : variationColor} - المقاس : ${variationSize} - الوزن : ${variationWeight}  - ${attributeDetails}</small>
        //                         </td> 
        //                         <td>${item.quantity}</td>
        //                         <td>${item.product.activediscount ? item.product.activediscount.discount_amount + ' د.ج' : item.unit_price + ' د.ج'}</td>
        //                         <td>${item.product.activediscount ? item.quantity * item.product.activediscount.discount_amount : item.quantity * item.unit_price} د.ج</td>
        //                     </tr>
        //                 `;
        //             });


        //                 // فتح المودال
        //                 let modal = new bootstrap.Modal(document.getElementById("viewOrderModal"));
        //                 modal.show();
        //             })
        //             .catch(error => console.error("Error fetching order details:", error));
        //     });
        // });
    });
    //delete order item
    function deleteOrderItem(order_id, item_id) {
        //delete form data base
        fetch('/seller-panel/delete-order-item/' + item_id)
            .then(response => response.json())
            .then(data => {

            })
        //
        setTimeout(() => {
            //-----------
            // تعديل السعر الإجالي للطلب
            let orderId = order_id;

            fetch(`/seller-panel/order/${orderId}`)
                .then(response => response.json())
                .then(order => {
                    document.getElementById("shipping-cost").textContent = `${order.shipping_cost} د.ج`;
                    document.getElementById("discount").textContent = `${order.discount} د.ج`;
                    document.getElementById("total-price").textContent = `${order.total_price} د.ج`;

                    // تحديث قائمة المنتجات داخل الطلب
                    let orderItemsTable = document.getElementById("order-items");
                    orderItemsTable.innerHTML = ""; // تفريغ الجدول قبل الإضافة
                    let sub_totle = 0;
                    order.items.forEach(item => {
                        if (item.product.activediscount == null) {
                            sub_totle += item.quantity * item.unit_price;
                        } else {
                            sub_totle += item.quantity * item.product.activediscount
                                .discount_amount;
                        }
                        // let activeDiscount=item.product.activediscount ? item.product.activediscount.discount_amount : '0';
                        let productName = item.product ? item.product.name : "غير متوفر";
                        let variationColor = item.variation ? item.variation.color : "غير محدد";
                        let variationSize = item.variation ? item.variation.size : "بدون مقاس";
                        let variationWeight = item.variation ? item.variation.weight : "بدون وزن";
                        let attributeDetails = item.attribute ?
                            `${item.attribute.attribute ? item.attribute.attribute.name : "بدون اسم خاصية"}: ${item.attribute.value}` :
                            "بدون خصائص";

                        document.getElementById("subtotal-price").textContent = `${sub_totle} د.ج`;
                        orderItemsTable.innerHTML += `
                        <tr id="order-item-${item.id}">
                            <td>
                                ${productName} 
                                <br>  
                                <small>اللون : ${item.variation ? `<div style="border:1px solid #000;width:20px;height:20px;background-color:${variationColor};display:inline-block;"></div>` : variationColor} - ${attributeDetails}</small>
                            </td> 
                            <td>${item.quantity}</td>
                            <td>${item.product.activediscount ? item.product.activediscount.discount_amount + ' د.ج' : item.unit_price + ' د.ج'}</td>
                            <td class="text-center">
  ${order.items.length <= 1 ? '' : `<span class="badge rounded-pill bg-danger cursor-pointer" onclick="deleteOrderItem(${orderId}, ${item.id})">حذف</span>`}
</td>
                            <td>${item.product.activediscount ? item.quantity * item.product.activediscount.discount_amount : item.quantity * item.unit_price} د.ج</td>                            
                        </tr>
                    `;
                    });

                })
                .catch(error => console.error("Error fetching order details:", error));
            // احذف المنتج من قائمة المنتجات
            document.getElementById("order-item-" + item_id).remove();

            //----------
        }, 2000);
    }
    //get wilaya data
    function print_wilaya_name(id) {
        fetch('/seller-panel/get-wilaya-data/' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById("shipping-city").textContent = data.ar_name;
            })
            .catch(error => console.error('Error fetching wilaya data:', error));


    }

    //function to get order details
    function view_order(order_id) {
        let orderId = order_id;

        fetch(`/seller-panel/order/${orderId}`)
            .then(response => response.json())
            .then(order => {
                // تحديث معلومات الطلب
                document.getElementById("order-number").textContent = `#${order.order_number}`;
                document.getElementById("customer-name").textContent = order.customer_name;
                if (order.phone_visiblity) {
                    document.getElementById("customer-phone").textContent = order.phone;
                } else {
                    document.getElementById("customer-phone").innerHTML =
                        '<img src="/asset/v1/users/dashboard/img/other/lock.png" alt="phone" style="cursor: pointer;" />';
                }
                // document.getElementById("customer-phone").textContent = order.phone;
                document.getElementById("customer-email").textContent = order.email ?? "غير متوفر";
                document.getElementById("shipping-address").textContent = order.shipping_address;
                // document.getElementById("shipping-city").textContent = order.wilaya_id;
                print_wilaya_name(order.wilaya_id);
                document.getElementById("shipping-zipcode").textContent = order.wilaya_id ?? "غير متوفر";
                document.getElementById("customer-note").textContent = order.note ?? "غير متوفر";
                // document.getElementById("subtotal-price").textContent = `${order.total_price} د.ج`;
                document.getElementById("shipping-cost").textContent = `${order.shipping_cost} د.ج`;
                document.getElementById("discount").textContent = `${order.discount} د.ج`;
                document.getElementById("total-price").textContent = `${order.total_price} د.ج`;

                // تحديث قائمة المنتجات داخل الطلب
                let orderItemsTable = document.getElementById("order-items");
                orderItemsTable.innerHTML = ""; // تفريغ الجدول قبل الإضافة
                let sub_totle = 0;
                order.items.forEach(item => {
                    if (item.product.activediscount == null) {
                        sub_totle += item.quantity * item.unit_price;
                    } else {
                        sub_totle += item.quantity * item.product.activediscount.discount_amount;
                    }
                    // let activeDiscount=item.product.activediscount ? item.product.activediscount.discount_amount : '0';
                    let productName = item.product ? item.product.name : "غير متوفر";
                    let variationColor = item.variation ? item.variation.color : "غير محدد";
                    let variationSize = item.variation ? item.variation.size : "بدون مقاس";
                    let variationWeight = item.variation ? item.variation.weight : "بدون وزن";
                    let attributeDetails = item.attribute ?
                        `${item.attribute.attribute ? item.attribute.attribute.name : "بدون اسم خاصية"}: ${item.attribute.value}` :
                        "بدون خصائص";

                    document.getElementById("subtotal-price").textContent = `${sub_totle} د.ج`;
                    orderItemsTable.innerHTML += `
                        <tr id="order-item-${item.id}">
                            <td>
                                ${productName} 
                                <br>  
                                <small>اللون : ${item.variation ? `<div style="border:1px solid #000;width:20px;height:20px;background-color:${variationColor};display:inline-block;"></div>` : variationColor} - ${attributeDetails}</small>
                            </td> 
                            <td>${item.quantity}</td>
                            <td>${item.product.activediscount ? item.product.activediscount.discount_amount + ' د.ج' : item.unit_price + ' د.ج'}</td>
                            <td class="text-center">
  ${order.items.length <= 1 ? '' : `<span class="badge rounded-pill bg-danger cursor-pointer" onclick="deleteOrderItem(${orderId}, ${item.id})">حذف</span>`}
</td>
                            <td>${item.product.activediscount ? item.quantity * item.product.activediscount.discount_amount : item.quantity * item.unit_price} د.ج</td>                            
                        </tr>
                    `;
                });


                // فتح المودال
                let modal = new bootstrap.Modal(document.getElementById("viewOrderModal"));
                modal.show();
            })
            .catch(error => console.error("Error fetching order details:", error));
    }
</script>
