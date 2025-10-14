<script>
$(document).ready(function() {
    // Initialize modals
    const addSliderModal = new bootstrap.Modal(document.getElementById('addSliderModal'));
    const editSliderModal = new bootstrap.Modal(document.getElementById('editSliderModal'));

    // Handle add button click
    $('#addSliderBtn').click(function() {
        $('#addSliderForm')[0].reset();
        $('.invalid-feedback').text('');
        $('.is-invalid').removeClass('is-invalid');
        $('#current_image_container').hide(); // Hide image preview in add modal
        addSliderModal.show();
    });

    // Handle edit button click
    $(document).on('click', '.edit-slider', function() {
        const sliderId = $(this).data('id');
  
        $.ajax({
            url: `/supplier-panel/page/section/sliders/${sliderId}/edit`,
            type: 'GET',
            success: function(response) {
                $('#edit_slider_id').val(response.id);
                $('#edit_title').val(response.title);
                $('#edit_description').val(response.description);
                $('#edit_link').val(response.link);
                $('#edit_order').val(response.order);
                $('#edit_status').val(response.status);
                
                // Show current image preview
                if(response.image) {
                    $('#current_image_preview').attr('src', response.image);
                    $('#current_image_container').show();
                } else {
                    $('#current_image_container').hide();
                }
                
                $('.invalid-feedback').text('');
                $('.is-invalid').removeClass('is-invalid');
                editSliderModal.show();
            },
            error: function(xhr) {
                let errorMsg = 'فشل في تحميل بيانات السلايدر';
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
    $('#addSliderForm').submit(function(e) {
        e.preventDefault();
        submitForm($(this), 'POST', '/supplier-panel/page/section/sliders');
    });

    $('#editSliderForm').submit(function(e) {
        e.preventDefault();
        const sliderId = $('#edit_slider_id').val();
        submitForm($(this), 'POST', `/supplier-panel/page/section/sliders/${sliderId}/update`, 'PUT');
    });

    // Handle delete button click
    $(document).on('click', '.delete-slider', function() {
        const sliderId = $(this).data('id');
        
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "لن تتمكن من استعادة هذا السلايدر!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم، احذفه!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/supplier-panel/page/section/sliders/${sliderId}/delete`,
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
                        let errorMsg = 'حدث خطأ أثناء حذف السلايدر';
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

    // Generic form submission function (handles file uploads)
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
                
                if (form.attr('id') === 'addSliderForm') {
                    addSliderModal.hide();
                } else {
                    editSliderModal.hide();
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