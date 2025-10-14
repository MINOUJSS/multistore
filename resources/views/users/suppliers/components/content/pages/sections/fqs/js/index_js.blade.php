<script>
$(document).ready(function() {
    // Initialize modals
    const addFaqModal = new bootstrap.Modal(document.getElementById('addFaqModal'));
    const editFaqModal = new bootstrap.Modal(document.getElementById('editFaqModal'));

    // Handle add button click
    $('#addFaqBtn').click(function() {
        $('#addFaqForm')[0].reset();
        $('.invalid-feedback').text('');
        $('.is-invalid').removeClass('is-invalid');
        addFaqModal.show();
    });

    // Handle edit button click
    $(document).on('click', '.edit-faq', function() {
        const faqId = $(this).data('id');
  
        $.ajax({
            url: `/supplier-panel/page/faqs/${faqId}/edit`,
            type: 'GET',
            success: function(response) {
                $('#edit_faq_id').val(response.id);
                $('#edit_question').val(response.question);
                $('#edit_answer').val(response.answer);
                $('#edit_order').val(response.order);
                $('#edit_status').val(response.status);
                
                $('.invalid-feedback').text('');
                $('.is-invalid').removeClass('is-invalid');
                editFaqModal.show();
            },
            error: function() {

                Swal.fire({
                    icon: 'error',
                    title: 'خطأ!',
                    text: 'فشل في تحميل بيانات السؤال',
                    confirmButtonText: 'حسناً'
                });
            }
        });
    });

    // Handle form submissions
    $('#addFaqForm').submit(function(e) {
        e.preventDefault();
        submitForm($(this), 'POST', '/supplier-panel/page/faqs');
    });

    $('#editFaqForm').submit(function(e) {
        e.preventDefault();
        const faqId = $('#edit_faq_id').val();
        submitForm($(this), 'PUT', `/supplier-panel/page/faqs/${faqId}/update`);
    });

    // Handle delete button click
    $(document).on('click', '.delete-faq', function() {
        const faqId = $(this).data('id');
        
        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "لن تتمكن من استعادة هذا السؤال!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم، احذفه!',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/supplier-panel/page/faqs/${faqId}/delete`,
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
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ!',
                            text: 'حدث خطأ أثناء الحذف',
                            confirmButtonText: 'حسناً'
                        });
                    }
                });
            }
        });
    });

    // Generic form submission function
    function submitForm(form, method, url) {
        $.ajax({
            url: url,
            type: method,
            data: form.serialize(),
            success: function(response) {
                form[0].reset();
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').text('');
                
                if (form.attr('id') === 'addFaqForm') {
                    addFaqModal.hide();
                } else {
                    editFaqModal.hide();
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
                    Swal.fire({
                        icon: 'error',
                        title: 'خطأ!',
                        text: 'حدث خطأ غير متوقع',
                        confirmButtonText: 'حسناً'
                    });
                }
            }
        });
    }
});
</script>