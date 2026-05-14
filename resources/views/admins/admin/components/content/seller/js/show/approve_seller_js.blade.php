{{-- Sweet Alert --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    function approveSeller(sellerId) {

        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "سيتم الموافقة على البائع",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'نعم',
            cancelButtonText: 'إلغاء'
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({

                    url: '/ah-admin/seller/' + sellerId + '/approve',

                    method: 'POST',

                    data: {
                        _token: "{{ csrf_token() }}"
                    },

                    success: function(response) {

                        Swal.fire({
                            icon: 'success',
                            title: 'تم بنجاح',
                            text: 'تمت الموافقة على البائع',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    },

                    error: function(xhr) {

                        console.log(xhr);

                        Swal.fire({
                            icon: 'error',
                            title: 'خطأ',
                            text: 'حدث خطأ أثناء العملية'
                        });
                    }
                });
            }

        });
    }

</script>