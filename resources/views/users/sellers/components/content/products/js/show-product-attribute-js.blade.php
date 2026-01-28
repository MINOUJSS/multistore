<script>
    $('#save_atrribute').on('click', function(e) {
        var attribute = document.getElementById('attribute_name').value;
        var formData = new FormData($('#attributeForm')[0]);
        if(attribute!='')
        {
            //send the attribute to save with ajax request
            $.ajax({
                url:'/seller-panel/attributes/create',
                type: "POST",
                data: formData,
                processData: false, // تعطيل معالجة البيانات
                contentType: false,
                success: function(response) {
                    console.log(response);
                    //alert success message
                    Swal.fire({
                            icon: 'success', // Type of alert (success, error, info, warning)
                            title: 'تم إضافة الخاصية بنجاح !', // Title of the alert
                            // text: 'تم تعديل المنتج بنجاح، يمكنك الآن العودة إلى الصفحة الرئيسية.', // Text under the title
                            showConfirmButton: true, // Whether to show the confirm button
                            confirmButtonText: 'حسناً', // Text of the confirm button
                            confirmButtonColor: '#a40c72', // Color of the confirm button
                        });
                    //العودة إلى فورم التعديل
                },
                error: function(xhr) {
                    console.log(xhr.responseJSON);
                },
            });
        }else
        {
            alert('يجب أن تدخل إسم الخاصية')
        }
    });
    //functions

</script>