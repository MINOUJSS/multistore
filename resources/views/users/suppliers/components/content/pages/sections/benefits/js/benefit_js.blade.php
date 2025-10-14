<script>
$(document).ready(function() {
    // Initialize modal
    const editBenefitModal = new bootstrap.Modal(document.getElementById('editBenefitModal'));

    // Assuming you have an edit button with class 'edit-benefit' in your table
    $(document).on('click', '.edit-benefit', function() {
        const benefitId = $(this).data('id');
        
        // Clear previous errors
        $('#editBenefitForm .invalid-feedback').text('');
        $('#editBenefitForm .is-invalid').removeClass('is-invalid');
        
        // Fetch benefit data
        $.ajax({
            url: `/supplier-panel/page/section/benefits/${benefitId}/edit`, // Update this URL to match your route
            type: 'GET',
            success: function(response) {
                // Populate the form fields
                $('#edit_benefit_id').val(response.id);
                $('#edit_benefit_title').val(response.title);
                $('#edit_benefit_description').val(response.description);
                
                // Show the modal
                editBenefitModal.show();
            },
            error: function(xhr) {
                let errorMsg = 'Failed to load benefit data';
                if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: errorMsg,
                    confirmButtonText: 'OK'
                });
            }
        });
    });

    // Handle form submission
    $('#editBenefitForm').submit(function(e) {
        e.preventDefault();
        
        const benefitId = $('#edit_benefit_id').val();
        const formData = new FormData(this);
        formData.append('_method', 'PUT'); // For PUT method
        
        $.ajax({
            url: `/supplier-panel/page/section/benefits/${benefitId}/update`, // Update this URL to match your route
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                // Hide modal and show success message
                editBenefitModal.hide();
                Swal.fire({
                    icon: 'success',
                    title: 'نجاح!',
                    text: response.message || 'Benefit updated successfully',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.reload(); // Reload page to see changes
                });
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    // Validation errors
                    const errors = xhr.responseJSON.errors;
                    $.each(errors, function(key, value) {
                        const input = $(`#editBenefitForm [name="${key}"]`);
                        input.addClass('is-invalid');
                        input.next('.invalid-feedback').text(value[0]);
                    });
                } else {
                    // Other errors
                    let errorMsg = 'An error occurred while updating the benefit';
                    if(xhr.responseJSON && xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: errorMsg,
                        confirmButtonText: 'OK'
                    });
                }
            }
        });
    });
});
</script>