<script>
    $(document).ready(function () {
        //--------
            $(".toggle-shipping").change(function () {
                let checkbox = $(this); // عنصر checkbox المضغوط
                let companyId = checkbox.data("company-id"); // ID الشركة
                let status = checkbox.prop("checked") ? "active" : "inactive"; // الحالة الجديدة

                $.ajax({
                    url: "/supplier-panel/update-shipping-status", // تأكد من تعديل الرابط حسب مسارك الفعلي
                    method: "POST",
                    data: {
                        _token: $('meta[name="csrf-token"]').attr("content"),
                        company_id: companyId,
                        status: status
                    },
                    beforeSend: function () {
                        checkbox.prop("disabled", true); // تعطيل الـ checkbox أثناء التحديث
                    },
                    success: function (response) {
                        if (response.success) {
                            // تحديث الشارة بناءً على الحالة الجديدة
                            let badge = checkbox.closest(".integration-card").find(".status-badge");
                            if (status === "active") {
                                badge.text("مفعل").removeClass("bg-danger").addClass("bg-success");
                            } else {
                                badge.text("غير مفعل").removeClass("bg-success").addClass("bg-danger");
                            }

                            Swal.fire({
                                icon: "success",
                                title: "تم التحديث!",
                                text: "تم تحديث حالة شركة الشحن بنجاح.",
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            throw new Error("فشل التحديث");
                        }
                    },
                    error: function (xhr) {
                        console.error("خطأ:", xhr.responseText);
                        Swal.fire({
                            icon: "error",
                            title: "خطأ!",
                            text: "حدث خطأ أثناء تحديث الحالة. حاول مرة أخرى.",
                            timer: 2000,
                            showConfirmButton: false
                        });
                        checkbox.prop("checked", !checkbox.prop("checked")); // إعادة الحالة الأصلية في حال فشل الطلب
                    },
                    complete: function () {
                        checkbox.prop("disabled", false); // إعادة تفعيل الـ checkbox بعد انتهاء الطلب
                    }
                });
            });

        //--------
        $("#YalidinModal").on("show.bs.modal", function () {
        // إزالة الخطأ من جميع الحقول
        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").text("");

        // تفريغ الحقول إذا لزم الأمر
        // $("#wilaya, #api_id, #api_token").val("");
    });
        //------------
    $("#yalidinForm").submit(function (event) {
        event.preventDefault(); // منع إعادة تحميل الصفحة
        
        let form = $(this);
        let formData = form.serialize();

        // مسح الأخطاء السابقة
        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").text("");

        $.ajax({
            url: "{{ route('supplier.shipping-company.create') }}", // رابط المسار
            method: "POST",
            data: formData,
            success: function (response) {
                if (response.success) {
                    Swal.fire({
                        icon: "success",
                        title: "تم الحفظ!",
                        text: "تم ربط الشركة بنجاح.",
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        location.reload(); // تحديث الصفحة بعد نجاح الحفظ
                    });
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    if (errors.wilaya) {
                        $("#yl-wilaya").addClass("is-invalid");
                        $("#error-yl-wilaya").text(errors.wilaya[0]);
                    }
                    if (errors.api_id) {
                        $("#yl-api_id").addClass("is-invalid");
                        $("#error-yl-api_id").text(errors.api_id[0]);
                    }
                    if (errors.api_token) {
                        $("#yl-api_token").addClass("is-invalid");
                        $("#error-yl-api_token").text(errors.api_token[0]);
                    }
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "خطأ!",
                        text: "حدث خطأ غير متوقع، حاول مرة أخرى.",
                    });
                }
            }
        });
    });
});
</script>