<script>
$(document).ready(function () {
    // عند تغيير حالة التأكيد
    $(document).on("change", ".confirmation-status", function () {
        let orderId = $(this).data("order-id");
        let newStatus = $(this).val();
        let selectElement = $(this);
        let row = selectElement.closest("tr");

        $.ajax({
            url: "/supplier-panel/update-confirmation-status", // 👈 عدّل هذا حسب المسار في routes/web.php
            method: "POST",
            data: {
                _token: $('meta[name="csrf-token"]').attr("content"),
                order_id: orderId,
                confirmation_status: newStatus
            },
            beforeSend: function () {
                selectElement.prop("disabled", true);
            },
            success: function (response) {
                if (response.success) {
                    // تحديث القيمة في القائمة
                    row.find(".confirmation-status").val(newStatus);
                    if(newStatus == 'confirmed')
                    {
                        row.find(".order-status").val('processing');
                        row.removeClass("table-success table-warning table-danger table-primary table-info");
                        row.addClass("text-warning table-primary");
                    }else if(newStatus == 'error_phone')
                    {
                        row.find(".order-status").val('canceled');
                        row.removeClass("table-success table-warning table-danger table-primary table-info");
                        row.addClass("text-danger table-danger");
                    }else
                    {
                        row.find(".order-status").val('pending');
                        row.removeClass("table-success table-warning table-danger table-primary table-info");
                        row.addClass("text-warning table-warning");
                    }
                    

                    // إزالة الألوان القديمة
                    // row.removeClass("table-success table-warning table-danger table-primary table-info");

                    // تلوين الصف حسب الحالة
                    // switch (newStatus) {
                    //     case "pending":
                    //         row.addClass("table-warning");
                    //         break;
                    //     case "call1":
                    //     case "call2":
                    //     case "call3":
                    //         row.addClass("table-info");
                    //         break;
                    //     case "confirmed":
                    //         row.addClass("table-success");
                    //         break;
                    //     case "no_answer":
                    //         row.addClass("table-primary");
                    //         break;
                    //     case "error_phone":
                    //         row.addClass("table-danger");
                    //         break;
                    // }

                    // تنبيه نجاح
                    Swal.fire({
                        icon: "success",
                        title: "تم التحديث!",
                        text: "تم تحديث حالة التأكيد بنجاح.",
                        timer: 2000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "فشل العملية!",
                        text: response.message || "تعذر تحديث حالة التأكيد.",
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function (xhr) {
                console.log("خطأ:", xhr.responseText);
                Swal.fire({
                    icon: "error",
                    title: "خطأ!",
                    text: "حدث خطأ أثناء تحديث حالة التأكيد.",
                    timer: 2000,
                    showConfirmButton: false
                });
            },
            complete: function () {
                selectElement.prop("disabled", false);
            }
        });
    });
});
</script>
