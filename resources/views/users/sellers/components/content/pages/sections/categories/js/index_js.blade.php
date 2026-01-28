<script>
    $(document).ready(function() {
        // Initialize modals
        const addGlobalModal = new bootstrap.Modal('#addGlobalCategoryModal');
        const editGlobalModal = new bootstrap.Modal('#editGlobalCategoryModal');
        const addStoreModal = new bootstrap.Modal('#addStoreCategoryModal');
        const editStoreModal = new bootstrap.Modal('#editStoreCategoryModal');

        // Global Categories Handlers
        $('#addGlobalCategoryBtn').click(() => {
            $('#addGlobalCategoryForm')[0].reset();
            clearErrors('#addGlobalCategoryForm');
            addGlobalModal.show();
        });

        $(document).on('click', '.edit-global-category', function() {
            const id = $(this).data('id');
            $.get(`/seller-panel/page/section/global/categories/${id}/edit`, (data) => {
                $('#edit_global_category_id').val(data.id);
                $('#edit_global_name').val(data.name);
                $('#edit_global_slug').val(data.slug);
                $('#edit_global_description').val(data.description);
                $('#edit_global_parent_id').val(data.parent_id);
                clearErrors('#editGlobalCategoryForm');
                editGlobalModal.show();
            }).fail(handleError);
        });

        // Store Categories Handlers
        $('#addStoreCategoryBtn').click(() => {
            $('#addStoreCategoryForm')[0].reset();
            clearErrors('#addStoreCategoryForm');
            $('#current_store_image_container').hide();
            addStoreModal.show();
        });

        $(document).on('click', '.edit-store-category', function() {
            const id = $(this).data('id');
            $.get(`/seller-panel/page/section/store/categories/${id}/edit`, (data) => {
                $('#edit_store_category_id').val(data.id);
                $('#edit_store_category_id_select').val(data.category_id);
                $('#edit_store_icon').val(data.icon);
                $('#edit_store_order').val(data.order);

                if (data.image) {
                    $('#current_store_image_preview').attr('src', data.image);
                    $('#current_store_image_container').show();
                } else {
                    $('#current_store_image_container').hide();
                }

                clearErrors('#editStoreCategoryForm');
                editStoreModal.show();
            }).fail(handleError);
        });

        // Form Submissions
        $('#addGlobalCategoryForm').submit(handleSubmit('POST',
            '/seller-panel/page/section/global/categories'));
        $('#editGlobalCategoryForm').submit(handleSubmit('PUT', (form) => {
            const id = $('#edit_global_category_id').val();
            return `/seller-panel/page/section/global/categories/${id}/update`;
        }));

        $('#addStoreCategoryForm').submit(handleSubmit('POST', '/seller-panel/page/section/store/categories',
            true));
        $('#editStoreCategoryForm').submit(handleSubmit('PUT', (form) => {
            const id = $('#edit_store_category_id').val();
            return `/seller-panel/page/section/store/categories/${id}/update`;
        }, true));

        // Delete Handlers
        $(document).on('click', '.delete-global-category', handleDelete('global'));
        $(document).on('click', '.delete-store-category', handleDelete('store'));

        // Helper Functions
        function handleSubmit(method, url, hasFiles = false) {
            return function(e) {
                e.preventDefault();
                const form = $(this);
                const formData = hasFiles ? new FormData(this) : form.serialize();
                const actualUrl = typeof url === 'function' ? url() : url;
                const isPut = method === 'PUT';

                $.ajax({
                    url: actualUrl,
                    type: isPut ? 'POST' : method,
                    data: formData,
                    processData: !hasFiles,
                    contentType: hasFiles ? false : 'application/x-www-form-urlencoded',
                    success: function(response) {
                        Swal.fire('نجاح!', response.message, 'success').then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            showErrors(form, xhr.responseJSON.errors);
                        } else {
                            handleError(xhr);
                        }
                    }
                });
            };
        }

        function handleDelete(type) {
            return function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: "لن تتمكن من استعادة هذا القسم!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'نعم، احذفه!',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/seller-panel/page/section/${type}/categories/${id}/delete`,
                            type: 'DELETE',
                            data: {
                                '_token': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire('تم الحذف!', response.message, 'success')
                                    .then(() => window.location.reload());
                            },
                            error: handleError
                        });
                    }
                });
            };
        }

        function clearErrors(formSelector) {
            $(`${formSelector} .is-invalid`).removeClass('is-invalid');
            $(`${formSelector} .invalid-feedback`).text('');
        }

        function showErrors(form, errors) {
            clearErrors(form);
            $.each(errors, function(field, messages) {
                const input = form.find(`[name="${field}"]`);
                input.addClass('is-invalid');
                input.next('.invalid-feedback').text(messages[0]);
            });
        }

        function handleError(xhr) {
            let message = 'حدث خطأ غير متوقع';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                message = xhr.responseJSON.message;
            }
            Swal.fire('خطأ!', message, 'error');
        }
    });
</script>
