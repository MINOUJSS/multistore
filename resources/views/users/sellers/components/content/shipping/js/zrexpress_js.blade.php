<script>
    $(document).ready(function () {
        //--------
            $(".toggle-shipping").change(function () {
                let checkbox = $(this); // عنصر checkbox المضغوط
                let companyId = checkbox.data("company-id"); // ID الشركة
                let status = checkbox.prop("checked") ? "active" : "inactive"; // الحالة الجديدة

                $.ajax({
                    url: "/seller-panel/update-shipping-status", // تأكد من تعديل الرابط حسب مسارك الفعلي
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
        $("#ZrexpressModal").on("show.bs.modal", function () {
        // إزالة الخطأ من جميع الحقول
        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").text("");

        // تفريغ الحقول إذا لزم الأمر
        // $("#wilaya, #api_id, #api_token").val("");
    });
        //------------
    $("#zrexpressForm").submit(function (event) {
        event.preventDefault(); // منع إعادة تحميل الصفحة
       
        let form = $(this);
        let formData = form.serialize();

        // مسح الأخطاء السابقة
        $(".form-control").removeClass("is-invalid");
        $(".invalid-feedback").text("");

        $.ajax({
            url: "{{ route('seller.shipping-company.create') }}", // رابط المسار
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

                    if (errors.token) {
                        $("#zr-token").addClass("is-invalid");
                        $("#error-zr-token").text(errors.token[0]);
                    }
                    if (errors.cle) {
                        $("#zr-cle").addClass("is-invalid");
                        $("#error-zr-cle").text(errors.cle[0]);
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