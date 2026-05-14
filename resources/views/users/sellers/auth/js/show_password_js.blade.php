<script>
    const passwordInput = document.getElementById('password');

    const togglePassword = document.getElementById('togglePassword');

    const icon = togglePassword.querySelector('i');
    

    togglePassword.addEventListener('click', function () {

        // toggle input type
        const type = passwordInput.getAttribute('type') === 'password'
            ? 'text'
            : 'password';

        passwordInput.setAttribute('type', type);

        // toggle icon
        icon.classList.toggle('fa-eye');

        icon.classList.toggle('fa-eye-slash');

    });
</script>