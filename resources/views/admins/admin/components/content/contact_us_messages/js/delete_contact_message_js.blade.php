<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function deleteContactMessage(id) {

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({

                    url: '/ah-admin/contact-us-message/' + id + '/destroy',

                    type: 'DELETE',

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    success: function(response) {

                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted!',
                            text: 'تم حذف الرسالة بنجاح',
                            timer: 2000,
                            showConfirmButton: false
                        });
                        
                        window.location.reload();
                        console.log(response);

                        // حذف الرسالة من الصفحة
                        $('#message-' + id).fadeOut(300, function () {
                            $(this).remove();
                        });
                    },

                    error: function(xhr) {

                        console.log(xhr);

                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'حدث خطأ أثناء حذف الرسالة'
                        });
                    }
                });

            }
        });
    }
</script>