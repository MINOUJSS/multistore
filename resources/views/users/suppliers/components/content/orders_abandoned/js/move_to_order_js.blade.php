<script>
    $(document).ready(function () {
        $(document).on('click', '.move_to_order', function (e) {
            //get data-order-id
            let order_id = $(this).data('order-id');
            //
            $('#order_id_to_delete_btn').attr('data-order-id-to-delete', order_id);
            $.ajax({
                url: '/supplier-panel/order-abandoned/move-to-order',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    order_id: order_id
                },
                success: function (response) {
                     Swal.fire({
                        title: "تم التحويل!",
                        text: "تم تحويل الطلب بنجاح.",
                        icon: "success",
                        confirmButtonText: "حسنًا"
                    }).then(() => {
                        location.reload(); // Reload page after successful deletion
                    });
                }
            })
        })
    })
</script>