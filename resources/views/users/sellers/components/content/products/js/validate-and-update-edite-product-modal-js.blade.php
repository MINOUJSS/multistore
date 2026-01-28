<script>
    //on click on save btn
    $('#save').on('click', function(e){
            e.preventDefault();
            //get product description from editor
            var content = quill.root.innerHTML;
            //set content empty
            if ($.trim(content) === "<p><br></p>") {
            content = "";
            }
            document.getElementById('product_description').value=content;
            // Clear previous errors
            $('.error-validation').text('');
            // Validate variations
            var isValid = true;
            $(".variation-required").each(function () {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).next(".text-danger").text("هذا الحقل مطلوب.");
                }
            });

            // Validate discounts
            $(".discount-required").each(function () {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).next(".text-danger").text("هذا الحقل مطلوب.");
                }
            });
            // Get form data
            var product_id=document.getElementById('product_id').value;
            //get form data
            var formData = new FormData($('#editForm')[0]); // يشمل الحقول والملفات
            // Show loader and disable save button
        $('#save').prop('disabled', true).text('جاري الحفظ...');
            // Send AJAX request
            // if (isValid) {
            $.ajax({
                url: '/seller-panel/product/update/'+product_id,
                type: 'POST',
                data: formData,
                processData: false, // تعطيل معالجة البيانات
                contentType: false, // تعطيل تعيين Content-Type للسماح برفع الملفات
                success: function (response) {
                    console.log(response);
                    $('#editModal').modal('hide');
                    //refresh page
                    location.reload(true);
                    //alert success message
                    Swal.fire({
                            icon: 'success', // Type of alert (success, error, info, warning)
                            title: 'تم التعديل بنجاح !', // Title of the alert
                            // text: 'تم تعديل المنتج بنجاح، يمكنك الآن العودة إلى الصفحة الرئيسية.', // Text under the title
                            showConfirmButton: true, // Whether to show the confirm button
                            confirmButtonText: 'حسناً', // Text of the confirm button
                            confirmButtonColor: '#a40c72', // Color of the confirm button
                        });

                    //end alert success
                },
                error: function (xhr) {
                    $('#save').prop('disabled', false).text('حفظ');
                    console.log(xhr.responseText);
                    // var errorsDiv = document.getElementById('editFormErrors');
                            if (xhr.status === 422) {
                            // Display validation errors
                            var errors = xhr.responseJSON.errors;
                            console.log(errors);
                            $.each(errors, function (key, value) {
                                // errorsDiv.append(value[0]);
                                $('.error-' + key).text(value[0]);
                            });

                        } else {
                            $('#editModal').modal('hide');
                            Swal.fire({
                                    icon: 'error', // Type of alert (error, success, warning, info)
                                    title: 'حدث خطأ !', // Title of the alert
                                    text: 'تعذر تعديل المنتج، يرجى المحاولة مرة أخرى.', // Additional text
                                    showConfirmButton: true, // Whether to show the confirm button
                                    confirmButtonText: 'موافق', // Text of the confirm button
                                    confirmButtonColor: '#a40c72', // Color of the confirm button
                                });
                                //refresh page
                                // location.reload(true);
                        }
                }
            });

        });
</script>