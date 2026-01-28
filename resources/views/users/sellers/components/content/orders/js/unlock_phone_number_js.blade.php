<script>
    function unlock_phone_number(order_id) {
    Swal.fire({
        title: "هل أنت متأكد؟",
        text: "هل تريد فتح رقم الهاتف لهذا الطلب؟",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "نعم، افتح الرقم",
        cancelButtonText: "إلغاء"
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: `/seller-panel/order/unlock-phone-number/${order_id}`,
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                },
                success: function (response) {
                    console.log(response);
                    if(response.status=='error')
                        {
                            Swal.fire({
                            title: "خطأ!",
                            text: response.message,
                            icon: "error",
                            confirmButtonText: "حسنًا"
                            });
                        }else
                        {
                            Swal.fire({
                                title: "تم بنجاح!",
                                text: "تم فتح رقم الهاتف بنجاح.",
                                icon: "success",
                                confirmButtonText: "حسنًا"
                            }).then(() => {
                                location.reload(); // إعادة تحميل الصفحة بعد النجاح
                            });
                        }
                },
                error: function (xhr) {
                    Swal.fire({
                        title: "خطأ!",
                        text: "حدث خطأ أثناء فتح رقم الهاتف: " + xhr.responseText,
                        icon: "error",
                        confirmButtonText: "حسنًا"
                    });
                }
            });
        }
    });
}

        // function unlock_phone_number(order_id) {
        //     if (!confirm("هل أنت متأكد من أنك تريد فتح رقم الهاتف؟")) {
        //         return;
        //     }

        //     $.ajax({
        //         url: '/seller-panel/unlock-phone-number/' + order_id,
        //         method: 'POST',
        //         headers: {
        //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // جلب التوكن من الميتا
        //         },
        //         success: function (response) {
        //             alert('تم فتح رقم الهاتف بنجاح!');
        //             location.reload(); // إعادة تحميل الصفحة بعد النجاح
        //         },
        //         error: function (xhr, status, error) {
        //             alert('حدث خطأ أثناء فتح رقم الهاتف: ' + xhr.responseText);
        //             console.error(error);
        //         }
        //     });
        // }

</script>