<script>
$(document).ready(function() {
    // Initialize modals
    const addElementModal = new bootstrap.Modal(document.getElementById('addElementModal'));
    const editElementModal = new bootstrap.Modal(document.getElementById('editElementModal'));

    // Handle add button click
    $('#addElementBtn').click(function() {
        $('#addElementForm')[0].reset();
        $('.invalid-feedback').text('');
        $('.is-invalid').removeClass('is-invalid');
        addElementModal.show();
    });

    // Handle edit button click
    $(document).on('click', '.edit-element', function() {
        const elementId = $(this).data('id');
  
        $.ajax({
            url: `/supplier-panel/page/section/benefits/elements/${elementId}/edit`,
            type: 'GET',
            success: function(response) {
                $('#edit_element_id').val(response.id);
                $('#edit_title').val(response.title);
                $('#edit_description').val(response.description);
                $('#edit_icon').val(response.icon);
                $('#edit_order').val(response.order);
                
                $('.invalid-feedback').text('');
                $('.is-invalid').removeClass('is-invalid');
                editElementModal.show();
            },
            error: function(xhr) {
                let errorMsg = 'فشل في تحميل بيانات العنصر';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'خطأ!',
                    text: errorMsg,
                    confirmButtonText: 'حسناً'
                });
            }
        });
    });

    // Handle form submissions
    $('#addElementForm').submit(function(e) {
        e.preventDefault();
        submitForm($(this), 'POST', '/supplier-panel/page/section/benefits');
    });

    $('#editElementForm').submit(function(e) {
        e.preventDefault();
        const elementId = $('#edit_element_id').val();
        submitForm($(this), 'POST', `/supplier-panel/page/section/benefits/elements/${elementId}/update`, 'PUT');
    });

    // Handle delete button click
    $(document).on('click', '.delete-element', function() {
        const elementId = $(this).data('id');
        
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "لن تتمكن من استعادة هذا العنصر!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم، احذفه!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/supplier-panel/page/section/benefits/elements/${elementId}/delete`,
                    type: 'POST',
                    data: {
                        '_method': 'DELETE',
                        '_token': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'تم الحذف!',
                            text: response.message,
                            confirmButtonText: 'حسناً'
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        let errorMsg = 'حدث خطأ أثناء حذف العنصر';
                        if(xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ!',
                            text: errorMsg,
                            confirmButtonText: 'حسناً'
                        });
                    }
                });
            }
        });
    });

    // Handle benefit status change
    // $('form').submit(function(e) {
    //     e.preventDefault();
    //     const form = $(this);
        
    //     // Check if this is the status form
    //     if(form.find('#sluster_status').length) {
    //         $.ajax({
    //             url: form.attr('action'),
    //             type: 'POST',
    //             data: form.serialize(),
    //             success: function(response) {
    //                 Swal.fire({
    //                     icon: 'success',
    //                     title: 'نجاح!',
    //                     text: response.message,
    //                     confirmButtonText: 'حسناً'
    //                 });
    //             },
    //             error: function(xhr) {
    //                 let errorMsg = 'حدث خطأ أثناء حفظ التغييرات';
    //                 if(xhr.responseJSON && xhr.responseJSON.message) {
    //                     errorMsg = xhr.responseJSON.message;
    //                 }
    //                 Swal.fire({
    //                     icon: 'error',
    //                     title: 'خطأ!',
    //                     text: errorMsg,
    //                     confirmButtonText: 'حسناً'
    //                 });
    //             }
    //         });
    //     }
    // });

    // Generic form submission function
    function submitForm(form, method, url, overrideMethod = null) {
        var formData = new FormData(form[0]);
        if(overrideMethod) {
            formData.append('_method', overrideMethod);
        }
        
        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                form[0].reset();
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').text('');
                
                if (form.attr('id') === 'addElementForm') {
                    addElementModal.hide();
                } else {
                    editElementModal.hide();
                }
                
                Swal.fire({
                    icon: 'success',
                    title: 'نجاح!',
                    text: response.message,
                    confirmButtonText: 'حسناً'
                }).then(() => {
                    window.location.reload();
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        const input = form.find(`[name="${key}"]`);
                        input.addClass('is-invalid');
                        input.next('.invalid-feedback').text(value[0]);
                    });
                } else {
                    let errorMsg = 'حدث خطأ غير متوقع';
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ!',
                        text: errorMsg,
                        confirmButtonText: 'حسناً'
                    });
                }
            }
        });
    }
});
</script>