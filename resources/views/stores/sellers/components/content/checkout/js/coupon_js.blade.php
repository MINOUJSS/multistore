<script>
    $(document).ready(function() {
        // Attach a change event to the select element
        $('#coupon').on('keyup', function() {
            // Get the selected value
            var coupon = $(this).val();

            // Call your custom function
            fetchCoupon(coupon);
        });

        //helper function to fetch coupon
        function fetchCoupon(coupon) {
            $.ajax({
                url: "{{ route('tenant.coupons.fetchCoupon') }}",
                type: 'GET',
                data: {
                    coupon: coupon
                },
                success: function(response) {
                    console.log(response);
                    $('#discount').text(response.couponAmount);
                    // تحديث السعر الإجمالي
                    countTotalPrice();
                },
                error: function(error) {
                    // console.log(error);
                    $('#discount').text('00');
                    // تحديث السعر الإجمالي
                    countTotalPrice();
                }
            });
        }
    })
</script>
