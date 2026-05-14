<script>
    
    const confirmPasswordInput = document.getElementById('confirmPassword');

    const toggleConfirmPassword = document.getElementById('toggleconfirmPassword');

    const confirmIcon = toggleConfirmPassword.querySelector('i');

        toggleConfirmPassword.addEventListener('click', function () {

        // toggle input type
        const type = confirmPasswordInput.getAttribute('type') === 'password'
            ? 'text'
            : 'password';

        confirmPasswordInput.setAttribute('type', type);

        // toggle icon
        confirmIcon.classList.toggle('fa-eye');

        confirmIcon.classList.toggle('fa-eye-slash');

    });
</script>