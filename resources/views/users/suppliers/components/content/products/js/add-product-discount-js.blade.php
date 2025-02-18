<script>
    // on click on add_discount_product
    // $("#add_discount").click(function(e){
    //     e.preventDefault();
    function add_discount(){
        $("#add_discount").hide();
        var product_discount = document.getElementById("product_discount");
        var filesHtml = '<div id="discount_container" class="discount_container border position-relative p-3 mt-3 mb-3 row">' +
            '<div class="col-3">' +
            '<label for="discount_amount" class="form-label">السعر الجديد</label>' +
            '<input value="0" id="discount_amount" name="discount_amount" type="number" class="form-control discount-required" onchange="calc_discount_percentage();" min="0">' +
            '<span class="text-danger error-discount_amount error-validation"></span>' +
            '</div>' +
            '<div class="col-3">' +
            '<label for="discount_percentage" class="form-label">نسبة التخفيض</label>' +
            '<input value="100" id="discount_percentage" name="discount_percentage" type="text" class="form-control discount-required" onchange="calc_discount_amount();" max="100">' +
            '<span class="text-danger error-discount_percentage error-validation"></span>' +
            '</div>' +
            '<div class="col-3">' +
            '<label for="discount_start_date" class="form-label">تاريخ بداية التخفيض</label>' +
            '<input name="discount_start_date" type="date" class="form-control discount-required" value="'+new Date().toISOString().split('T')[0]+'">' +
            '<span class="text-danger error-discount_start_date error-validation"></span>' +
            '</div>' +
            '<div class="col-3">' +
            '<label for="discount_end_date" class="form-label">تاريخ نهاية التخفيض</label>' +
            '<input name="discount_end_date" type="date" class="form-control discount-required" value="'+new Date().toISOString().split('T')[0]+'">' +
            '<span class="text-danger error-discount_end_date error-validation"></span>' +
            '</div>' +
            '<div class="form-check form-switch">' +
            '<input class="form-check-input" name="discount_status" type="checkbox" checked>' +
            '<label class="form-check-label" for="flexSwitchCheckChecked">مفعل</label>' +
            '</div>' +
            '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2 remove_discount" style="width:30px;cursor:pointer">X</span>' +
            '</div>';
        $(product_discount).append(filesHtml);
    };
    //});
        // On click remove_discount
        $(product_discount).on('click', '.remove_discount', function (e) {
            e.preventDefault();
            $("#add_discount").show();
            $(this).closest('.discount_container').remove();
        });
        // حذف الخصم من قاعدة البيانات
        function remove_discount_form_data(id) {
            if (!id) {
                console.error("خطأ: لم يتم توفير معرف الخصم.");
                return;
            }

            // حذف العنصر من الصفحة
            $(".discount_container").remove();
            
            // إرسال طلب Ajax لحذف الخصم من قاعدة البيانات
            $.ajax({
                url: '/supplier-panel/product/discount/delete/' + id, // تعديل الرابط حسب مسارك الفعلي
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') // إضافة CSRF Token
                },
                success: function(response) {
                    console.log(response.message);
                    $("#add_discount").show();
                },
                error: function(xhr) {
                    console.error("خطأ أثناء حذف الخصم:", xhr.responseText);
                }
            });
        }

        // calc_discount_percentage
        function calc_discount_percentage()
        {
            var oldPrice = parseFloat($("#inputPrice").val());
            var newPrice = parseFloat($("#discount_amount").val());

        if (!isNaN(oldPrice) && !isNaN(newPrice) && oldPrice > 0 && newPrice >= 0) {
            var discount = ((oldPrice - newPrice) / oldPrice) * 100;
            $("#discount_percentage").val(discount.toFixed(2)); // عرض النسبة بصيغة 0.00%
        } else {
            $("#discount_percentage").val(""); // مسح الحقل إذا كانت القيم غير صالحة
        }
        }
        //calc_discount_amount
        function calc_discount_amount()
        {
            var oldPrice = parseFloat($("#inputPrice").val());
            var discount = parseFloat($("#discount_percentage").val());

        if (!isNaN(oldPrice) && !isNaN(discount) && oldPrice > 0 && discount >= 0 && discount <= 100) {
            var newPrice = oldPrice * (1 - (discount / 100));
            $("#discount_amount").val(newPrice.toFixed(2)); // عرض السعر الجديد بصيغة 0.00
        } else {
            $("#discount_amount").val(""); // مسح الحقل إذا كانت القيم غير صالحة
        }
        }
  
</script>