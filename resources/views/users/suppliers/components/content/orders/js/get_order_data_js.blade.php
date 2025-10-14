<script>
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
    // تحديث معلومات العميل
    document.getElementById("order-number").textContent = `#${order.order_number}`;
    document.getElementById("customer-name").textContent = order.customer_name;
    
    const phoneElement = document.getElementById("customer-phone");
    phoneElement.innerHTML = order.phone_visiblity 
        ? order.phone 
        : '<img src="/asset/v1/users/dashboard/img/other/lock.png" alt="phone" style="cursor: pointer;" />';
    
    document.getElementById("customer-email").textContent = order.email ?? "غير متوفر";
    document.getElementById("shipping-address").textContent = order.shipping_address;
    document.getElementById("shipping-zipcode").textContent = order.wilaya_id ?? "غير متوفر";
    document.getElementById("customer-note").textContent = order.note ?? "غير متوفر";
    
    // تحديث المعلومات المالية
    document.getElementById("shipping-cost").textContent =parseFloat(order.shipping_cost).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ` د.ج`;
    document.getElementById("discount").textContent =parseFloat(order.discount).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ` د.ج`;
    document.getElementById("total-price").textContent =parseFloat(order.total_price).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ` د.ج`;
    
    return order; // لإمكانية استخدامها في سلسلة promises
}

// دالة مساعدة لتحديث جدول العناصر
function updateOrderItemsTable(order) {
    const orderItemsTable = document.getElementById("order-items");
    orderItemsTable.innerHTML = "";
    
    let subTotal = order.items.reduce((total, item) => {
        const price = item.product.activediscount 
            ? item.product.activediscount.discount_amount 
            : item.unit_price;
        return total + (item.quantity * price);
    }, 0);
    
    document.getElementById("subtotal-price").textContent =parseFloat(subTotal).toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",") + ` د.ج`;
    
    order.items.forEach(item => {
        const productName = item.product?.name ?? "غير متوفر";
        const variationColor = item.variation?.color ?? "غير محدد";
        const attributeDetails = item.attribute 
            ? `${item.attribute.attribute?.name ?? "بدون اسم خاصية"}: ${item.attribute.value}`
            : "بدون خصائص";
        
        const currentPrice = item.product.activediscount 
            ? item.product.activediscount.discount_amount + ' د.ج' 
            : item.unit_price + ' د.ج';
        
        const totalPrice = item.product.activediscount 
            ? item.quantity * item.product.activediscount.discount_amount 
            : item.quantity * item.unit_price;
        
        const deleteButton = order.items.length <= 1 
            ? '' 
            : `<span class="badge rounded-pill bg-danger cursor-pointer" onclick="deleteOrderItem(${order.id}, ${item.id})">حذف</span>`;
        
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
</script>