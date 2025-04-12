<script>
    $(document).ready(function () {
    // $(".order-status").change(function () {
        $(document).on("change", ".order-status", function () {
        let orderId = $(this).data("order-id");
        let newStatus = $(this).val();
        let selectElement = $(this); // حفظ العنصر المحدد
        let row = selectElement.closest("tr"); // العثور على الصف الخاص بالطلب

        $.ajax({
            url: "/supplier-panel/update-order-abandoned-status",
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                order_id: orderId,
                status: newStatus
            },
            beforeSend: function () {
                selectElement.prop("disabled", true); // تعطيل القائمة أثناء الطلب
            },
            success: function (response) {
                if (response.success) {
                    // تحديث حالة الطلب في الصف
                    row.find(".order-status").val(newStatus);

                    // تحديث لون الصف بناءً على الحالة
                    row.removeClass("table-success table-warning table-danger table-primary");
                    switch (newStatus) {
                        case "pending":
                            row.addClass("table-warning");
                            break;
                        case "processing":
                            row.addClass("table-primary");
                            break;
                        case "shipped":
                            row.addClass("table-info");
                            break;
                        case "delivered":
                            row.addClass("table-success");
                            break;
                        case "canceled":
                            row.addClass("table-danger");
                            break;
                    }

                    Swal.fire({
                        icon: "success",
                        title: "تم التحديث!",
                        text: "تم تحديث حالة الطلب بنجاح.",
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function (xhr) {
                console.log("حدث خطأ:", xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: "خطأ!",
                    text: "لم يتم تحديث الحالة، حاول مرة أخرى.",
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            complete: function () {
                selectElement.prop("disabled", false); // إعادة تفعيل القائمة بعد انتهاء الطلب
            }
        });
    });
});

</script>