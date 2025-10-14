<script>
    $(document).ready(function() {
        //alert(document.getElementById('livewier_qty').innerHTML); 
        // Attach a change event to the select element

        $('#wilaya').on('change', function() {
            // Get the selected value
            var wilaya_id = $(this).val();

            // Call your custom function
            fetchDayra(wilaya_id);
        });
        $('#dayra').on('change', function() {
            // Get the selected value
            var dayra_id = $(this).val();

            // Call your custom function
            fetchBaladia(dayra_id);
        });
    });

    //fetch dayra
    function fetchDayra(wilaya_id) {
        // Set CSRF token for Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //
        $.ajax({
            url: '/get-dayras/' + wilaya_id,
            method: 'POST',
            success: function(response) {
                //    console.log(response);
                $('#dayra').html(response);
                $('#baladia').html(
                    '<option value="0" selected>إختر البلدية...</option value="0"><option>...</option>');
            },
            error: function(xhr) {
                console.log(xhr)
                var errors = xhr.responseJSON.errors;
                var errorMessage = '';
                for (var key in errors) {
                    errorMessage += errors[key][0] + '<br>';
                }
                console.log(errorMessage);
            }
        });

    }
    //fetch dayra
    function fetchBaladia(dayra_id) {
        var wilaya_id = document.getElementById('wilaya').value;
        var dayra_id = document.getElementById('dayra').value;
        var baladia_id = document.getElementById('baladia').value;
        // Set CSRF token for Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //
        $.ajax({
            url: '/get-baladias/' + dayra_id,
            method: 'POST',
            success: function(response) {
                // console.log(response);
                $('#baladia').html(response);
                // get_additional_price(wilaya_id, dayra_id, baladia_id)
            },
            error: function(xhr) {
                console.log(xhr)
                var errors = xhr.responseJSON.errors;
                var errorMessage = '';
                for (var key in errors) {
                    errorMessage += errors[key][0] + '<br>';
                }
                console.log(errorMessage);
            }
        });

    }
    //------Functions---------
    async function get_shipping_cost() {
        try {
            const selectWilaya = document.getElementById('wilaya');
            const selectDayra = document.getElementById('dayra');
            const selectBaladia = document.getElementById('baladia');
            const shipping_type = document.querySelector('input[name="shipping_type"]:checked');

            // التحقق من الحقول المطلوبة
            if (!selectWilaya.value || selectWilaya.value === '0') {
                alert('الرجاء اختيار الولاية');
                return;
            }

            if (!shipping_type) {
                alert('الرجاء اختيار نوع التوصيل');
                return;
            }

            // إعداد رأس CSRF token
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // إرسال طلب AJAX باستخدام async/await
            const response = await $.ajax({
                url: '/supplier-panel/shipping/get-shipping-cost',
                method: 'POST',
                data: {
                    wilaya_id: selectWilaya.value,
                    dayra_id: selectDayra.value,
                    baladia_id: selectBaladia.value,
                    shipping_type: shipping_type.value,
                }
            });

            // تحديث واجهة المستخدم بعد استلام البيانات
            $('#shipping_cost').val(response.shipping_cost);
            $('#summary_shipping').text(response.shipping_cost + ' د.ج');
            //
            //get sub_total
            $sub_total = parseFloat($('#summary_sub_total').text().match(/\d+\.?\d*/)[0]);
            //get discount
            $discount = parseFloat($('#summary_discount').text().match(/\d+\.?\d*/)[0]);
            $('#summary_total').text($sub_total + parseFloat(response.shipping_cost) + ' د.ج');



            return response.shipping_cost;

        } catch (error) {
            console.error("حدث خطأ:", error.responseText || error);
            alert('حدث خطأ في حساب تكلفة الشحن');
            throw error; // يمكن إعادة throw الخطأ للتعامل معه في مكان آخر
        }
    }
    // دالة مساعدة للاستخدام
    async function calculateShipping() {
        try {
            const cost = await get_shipping_cost();
            // console.log('تم حساب التكلفة بنجاح:', cost);
        } catch (error) {
            console.error('فشل في حساب التكلفة:', error);
        }
    }
</script>
