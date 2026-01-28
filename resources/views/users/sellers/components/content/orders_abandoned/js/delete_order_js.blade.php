<script>
function delete_seller_order(order_id) {
    Swal.fire({
        title: "هل أنت متأكد؟",
        text: "لن تتمكن من استعادة هذا الطلب بعد الحذف!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "نعم، احذف الطلب",
        cancelButtonText: "إلغاء"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/seller-panel/order-abadoned/delete/${order_id}`, // Adjust the route as needed
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function (response) {
                    Swal.fire({
                        title: "تم الحذف!",
                        text: "تم حذف الطلب بنجاح.",
                        icon: "success",
                        confirmButtonText: "حسنًا"
                    }).then(() => {
                        location.reload(); // Reload page after successful deletion
                    });
                },
                error: function (xhr) {
                    Swal.fire({
                        title: "خطأ!",
                        text: "حدث خطأ أثناء حذف الطلب: " + xhr.responseText,
                        icon: "error",
                        confirmButtonText: "حسنًا"
                    });
                }
            });
        }
    });
}

</script>