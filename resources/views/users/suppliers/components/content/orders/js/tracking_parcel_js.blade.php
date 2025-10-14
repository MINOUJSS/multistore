<script>
    $(document).ready(function() {
        $(document).on('click', '.tracking_parcel', function(e) {
            //get data-order-id
            let order_id = $(this).data('order-id');
            //
            $('#order_id_to_delete_btn').attr('data-order-id-to-delete', order_id);
            $.ajax({
                url: '/supplier-panel/order/tracking/' + order_id,
                method: 'GET',
                success: function(response) {
                    console.log(response);
                }
            })
        })
    })
</script>
