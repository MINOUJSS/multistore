<script>
document.addEventListener('DOMContentLoaded', function() {
    const formController = document.getElementById('form_controller');
    const saveOrderFormBtn = document.getElementById('saveOrderForm');
    
    // Add CSRF token to form if not already present
    if (!formController.querySelector('input[name="_token"]')) {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        formController.appendChild(csrfInput);
    }
    
    // Add form submission handler
    saveOrderFormBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        if (validateForm()) {
            // Show loading state
            saveOrderFormBtn.disabled = true;
            saveOrderFormBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> جاري الحفظ...';
            
            // Submit form via AJAX
            submitForm();
        }
    });
    
    // Form validation function
    function validateForm() {
        let isValid = true;
        const requiredFields = formController.querySelectorAll('[data-required]');
        
        // Clear previous errors
        clearErrors();
        
        // Validate required fields
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                showError(field, 'هذا الحقل مطلوب');
                isValid = false;
            }
        });
        
        return isValid;
    }
    
    // Show error message
    function showError(field, message) {
        // Add error class to field
        field.classList.add('is-invalid');
        
        // Create error message element
        const errorDiv = document.createElement('div');
        errorDiv.className = 'invalid-feedback d-block';
        errorDiv.textContent = message;
        
        // Insert error message after field
        field.parentNode.appendChild(errorDiv);
    }
    
    // Clear all error messages
    function clearErrors() {
        // Remove error classes
        const errorFields = formController.querySelectorAll('.is-invalid');
        errorFields.forEach(field => {
            field.classList.remove('is-invalid');
        });
        
        // Remove error messages
        const errorMessages = formController.querySelectorAll('.invalid-feedback');
        errorMessages.forEach(msg => {
            msg.remove();
        });
    }
    
    // Submit form via AJAX
    function submitForm() {
        const formData = new FormData(formController);
        
        fetch(formController.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Show success message
                showSuccessMessage('تم حفظ الإعدادات بنجاح');
                // Reload page to see changes
                window.location.reload();
            } else if (data.errors) {
                // Show validation errors from server
                showServerErrors(data.errors);
            } else {
                // Show generic error
                showErrorMessage('حدث خطأ أثناء الحفظ');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorMessage('حدث خطأ أثناء الاتصال بالخادم');
        })
        .finally(() => {
            // Reset button state
            saveOrderFormBtn.disabled = false;
            saveOrderFormBtn.innerHTML = '<i class="fas fa-save me-2"></i> حفظ';
        });
    }
    
    // Show server validation errors
    function showServerErrors(errors) {
        for (const field in errors) {
            if (errors.hasOwnProperty(field)) {
                const input = formController.querySelector(`[name="${field}"]`);
                if (input) {
                    showError(input, errors[field][0]);
                }
            }
        }
    }
    
    // Show success message
    function showSuccessMessage(message) {
        Swal.fire({
            icon: 'success',
            title: 'نجح',
            text: message,
            timer: 3000,
            showConfirmButton: false
        });
    }
    
    // Show error message
    function showErrorMessage(message) {
        Swal.fire({
            icon: 'error',
            title: 'خطأ',
            text: message,
            timer: 3000,
            showConfirmButton: false
        });
    }
    
    // Add required attribute to critical fields
    const criticalFields = [
        // 'form_title_controller',
        // 'submit_btn',
        // 'form_lable_customer_name_controller',
        // 'form_lable_customer_phone_controller'
    ];
    
    criticalFields.forEach(fieldName => {
        const field = document.getElementById(fieldName);
        if (field) {
            field.setAttribute('data-required', 'true');
        }
    });
});
</script>