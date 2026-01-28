<script>
    function block_customer(order_id) {
        $.ajax({
            url: `/seller-panel/customer-block-list/is-blocked/${order_id}`, // Adjust the route as needed
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function(response) {
                if (response.status == 'blocked') {
                    Swal.fire({
                        title: "هل أنت متأكد من الغاء حظر العميل؟",
                        text: " سيتمكن هذا العميل من تقديم أي طلب على متجرك حتى تقوم بإضافته إلى قائمة العملاء المحظورين!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "نعم،الغي  حظر العميل",
                        cancelButtonText: "إلغاء"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/seller-panel/customer-block-list/create/${order_id}`, // Adjust the route as needed
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                        "content")
                                },
                                success: function(response) {
                                    if (response.status == 'blocked') {
                                        Swal.fire({
                                            title: "تم الحظر!",
                                            text: "تم حظر العميل بنجاح.",
                                            icon: "success",
                                            confirmButtonText: "حسنًا"
                                        }).then(() => {
                                            location
                                        .reload(); // Reload page after successful deletion
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "تم إلغاء الحظر!",
                                            text: "تم إلغاء حظر العميل بنجاح.",
                                            icon: "success",
                                            confirmButtonText: "حسنًا"
                                        }).then(() => {
                                            location
                                        .reload(); // Reload page after successful deletion
                                        });
                                    }


                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        title: "خطأ!",
                                        text: "حدث خطأ أثناء حظر العميل: " + xhr
                                            .responseText,
                                        icon: "error",
                                        confirmButtonText: "حسنًا"
                                    });
                                }
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        title: "هل أنت متأكد من حظر العميل؟",
                        text: "لن يتمكن هذا العميل من تقديم أي طلب على متجرك حتى تقوم بحذفه من قائمة العملاء المحظورين!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "نعم،  حظر العميل",
                        cancelButtonText: "إلغاء"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: `/seller-panel/customer-block-list/create/${order_id}`, // Adjust the route as needed
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                        "content")
                                },
                                success: function(response) {
                                    if (response.status == 'blocked') {
                                        Swal.fire({
                                            title: "تم الحظر!",
                                            text: "تم حظر العميل بنجاح.",
                                            icon: "success",
                                            confirmButtonText: "حسنًا"
                                        }).then(() => {
                                            location
                                        .reload(); // Reload page after successful deletion
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "تم إلغاء الحظر!",
                                            text: "تم إلغاء حظر العميل بنجاح.",
                                            icon: "success",
                                            confirmButtonText: "حسنًا"
                                        }).then(() => {
                                            location
                                        .reload(); // Reload page after successful deletion
                                        });
                                    }


                                },
                                error: function(xhr) {
                                    Swal.fire({
                                        title: "خطأ!",
                                        text: "حدث خطأ أثناء حظر العميل: " + xhr
                                            .responseText,
                                        icon: "error",
                                        confirmButtonText: "حسنًا"
                                    });
                                }
                            });
                        }
                    });
                }


            },
            error: function(xhr) {
                Swal.fire({
                    title: "خطأ!",
                    text: "حدث خطأ أثناء حظر العميل: " + xhr.responseText,
                    icon: "error",
                    confirmButtonText: "حسنًا"
                });
            }
        });
        // Swal.fire({
        //     title: "هل أنت متأكد من حظر العميل؟",
        //     text: "لن يتمكن هذا العميل من تقديم أي طلب على متجرك حتى تقوم بحذفه من قائمة العملاء المحظورين!",
        //     icon: "warning",
        //     showCancelButton: true,
        //     confirmButtonColor: "#d33",
        //     cancelButtonColor: "#3085d6",
        //     confirmButtonText: "نعم،  حظر العميل",
        //     cancelButtonText: "إلغاء"
        // }).then((result) => {
        //     if (result.isConfirmed) {
        //         $.ajax({
        //             url: `/seller-panel/customer-block-list/create/${order_id}`, // Adjust the route as needed
        //             method: "POST",
        //             headers: {
        //                 "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        //             },
        //             success: function (response) {
        //                 if(response.status =='blocked')
        //                 {
        //                                  Swal.fire({
        //                     title: "تم الحظر!",
        //                     text: "تم حظر العميل بنجاح.",
        //                     icon: "success",
        //                     confirmButtonText: "حسنًا"
        //                     }).then(() => {
        //                     location.reload(); // Reload page after successful deletion
        //                 });  
        //                 }else
        //                 {
        //                     Swal.fire({
        //                     title: "تم إلغاء الحظر!",
        //                     text: "تم إلغاء حظر العميل بنجاح.",
        //                     icon: "success",
        //                     confirmButtonText: "حسنًا"
        //                     }).then(() => {
        //                     location.reload(); // Reload page after successful deletion
        //                 }); 
        //                 }


        //             },
        //             error: function (xhr) {
        //                 Swal.fire({
        //                     title: "خطأ!",
        //                     text: "حدث خطأ أثناء حظر العميل: " + xhr.responseText,
        //                     icon: "error",
        //                     confirmButtonText: "حسنًا"
        //                 });
        //             }
        //         });
        //     }
        // });
    }
</script>
