<script>
    $(document).ready(function() {
        $(document).on('click', '.delete_order_from_shipping_company', function(e) {
            //get data-order-id
            let order_id = $(this).data('order-id-to-delete');
            // $.ajax({
            //     headers: {
            //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            //     }
            // })
            $.ajax({
                url: '/supplier-panel/order/tracking/delete/'+order_id,
                method: 'GET',
                success: function(response) {
                    // console.log(response);
                if (response.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-start',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                }
                 location.reload();
                },
                error: function(xhr) {
                    // console.log(xhr);
                }
            })
        })
    })
</script>