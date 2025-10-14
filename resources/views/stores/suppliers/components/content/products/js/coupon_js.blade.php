<script>
    $(document).ready(function() {
        // Attach a keyup event to the coupon input element
        $('#coupon').on('keyup', function() {
            // Get the coupon value
            var coupon = $(this).val();
            var product_id = $(this).attr('data-product-id');
            var totalPrice = $('#total_price').attr('data-totalprice')
                .trim(); // Using jQuery to get value

            // Only make the request if coupon has value
            if (coupon.trim() !== '') {
                productFetchCoupon(coupon, totalPrice, product_id);
            } else {
                $('#discount').text('00');
                countTotalPrice1();
            }
        });

        // Helper function to fetch coupon
        function productFetchCoupon(coupon, totalPrice, product_id) {
            $.ajax({
                url: '{{ route('tenant.coupons.product.fetchCoupon') }}',
                type: 'GET',
                data: {
                    coupon: coupon,
                    totalPrice: totalPrice,
                    product_id: product_id
                },
                success: function(response) {
                    console.log(response);
                    $('#discount').text(response.couponAmount);
                    // Update total price
                    countTotalPrice1();
                },
                error: function(error) {
                    // console.log(error);
                    $('#discount').text('00');
                    // Update total price
                    countTotalPrice1();
                }
            });
        }
    });

    //

    function countTotalPrice1() {
        // var sub_price = parseFloat(document.getElementById('sub_total').textContent) || 0;
        // var shipping_price = parseFloat(document.getElementById('shipping_price').textContent) || 0;
        // var discount=parseFloat(document.getElementById('discount').textContent) || 0;
        // var total = ((sub_price + shipping_price)-discount).toFixed(2);
        // document.getElementById('total').textContent = total;
        // Get the elements
        const subTotalElement = document.getElementById('sub_total');
        const shippingPriceElement = document.getElementById('shipping_price');
        const discountElement = document.getElementById('discount');

        // Extract the numeric values
        const subTotal = extractNumber1(subTotalElement.textContent);
        const shippingPrice = extractNumber1(shippingPriceElement.textContent);
        const discount = extractNumber1(discountElement.textContent);

        

        // Calculate the total (assuming discount is already negative if it's a deduction)
        const calculatedTotal = (subTotal + shippingPrice) - discount;

        // Format the total as currency (optional)
        const formattedTotal = calculatedTotal.toFixed(2);

        // Update the total element if needed
        // document.getElementById('total_price').textContent = formattedTotal+' <sup>د.ج</sup>';
        document.getElementById('total_price').innerHTML = formattedTotal+' <sup>د.ج</sup>';
        document.getElementById('total_price').setAttribute('data-totalprice', formattedTotal);

        // console.log('Calculated Total:', calculatedTotal);
    }

    //
    function extractNumber1(currencyString) {
        // Remove all non-numeric characters except digits, dots, and minus signs
        const numberString = currencyString.replace(/[^\d.-]/g, '');
        // Parse as float
        return parseFloat(numberString) || 0;
    }
</script>
