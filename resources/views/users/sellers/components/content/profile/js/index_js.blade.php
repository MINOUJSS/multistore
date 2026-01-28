<script>
    $(document).ready(function() {
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.previousElementSibling;
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                this.innerHTML = type === 'password' ? '<i class="fas fa-eye"></i>' :
                    '<i class="fas fa-eye-slash"></i>';
            });
        });

        //open avatar dialog
        document.getElementById('avataruploadbtn').addEventListener('click', function() {
            document.getElementById('avatarInput').click();
        });

        // Avatar preview
        document.getElementById('avatarInput')?.addEventListener('change', function(e) {
            const reader = new FileReader();
            reader.onload = function(event) {
                document.getElementById('avatarPreview').src = event.target.result;
            }
            reader.readAsDataURL(e.target.files[0]);
            //update avatar in db
            // Check if a file was selected
            if (!this.files || this.files.length === 0) {
                console.log('No file selected');
                return;
            }

            const file = this.files[0];
            const formData = new FormData();

            // Append the file to FormData with the correct name (matches your input name)
            formData.append('avatar_Image',
            file); // Important: use 'avatar_Image' to match your input name

            // Add CSRF token for Laravel
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            formData.append('_token', csrfToken);

            // AJAX request using fetch API
            fetch('/seller-panel/profile/update-avatar', { // Replace with your actual endpoint
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json', // If you want JSON response
                        // Don't set Content-Type - let the browser set it automatically for FormData
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success:', data);
                    // Handle success (e.g., show success message, update UI)
                    //change avatar in class of nav bar
                    // document.querySelector('.avatar').src = data.avatar;
                    document.getElementById('pc-avatar').src = data.avatar;
                    document.getElementById('mobile-avatar').src = data.avatar;
                })
                .catch(error => {
                    console.error('Error:', error);
                    // Handle error (e.g., show error message)
                });
        });
        //fetch dayra
        $('#inputWilaya').on('change', function() {
            // Get the selected value
            var wilaya_id = $(this).val();

            // Call your custom function
            fetchDayra(wilaya_id);
        });
        //fetch baladia
        $('#inputDayra').on('change', function() {
            // Get the selected value
            var dayra_id = $(this).val();

            // Call your custom function
            fetchBaladia(dayra_id);
        });
    });
    //-------- functions-------------//
    //fetch dayra
    function fetchDayra(wilaya_id) {
        // Set CSRF token for Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //
        $.ajax({
            url: '/get-dayras/' + wilaya_id,
            method: 'POST',
            success: function(response) {
                //    console.log(response);
                $('#inputDayra').html(response);
                $('#inputBaladia').html(
                    '<option value="0" selected>إختر البلدية...</option value="0"><option>...</option>');
            },
            error: function(xhr) {
                console.log(xhr)
                var errors = xhr.responseJSON.errors;
                var errorMessage = '';
                for (var key in errors) {
                    errorMessage += errors[key][0] + '<br>';
                }
                console.log(errorMessage);
            }
        });

    }
    //fetch dayra
    function fetchBaladia(dayra_id) {
        var wilaya_id = document.getElementById('inputWilaya').value;
        var dayra_id = document.getElementById('inputDayra').value;
        var baladia_id = document.getElementById('inputBaladia').value;
        // Set CSRF token for Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        //
        $.ajax({
            url: '/get-baladias/' + dayra_id,
            method: 'POST',
            success: function(response) {
                // console.log(response);
                $('#inputBaladia').html(response);
            },
            error: function(xhr) {
                console.log(xhr)
                var errors = xhr.responseJSON.errors;
                var errorMessage = '';
                for (var key in errors) {
                    errorMessage += errors[key][0] + '<br>';
                }
                console.log(errorMessage);
            }
        });

    }
</script>
