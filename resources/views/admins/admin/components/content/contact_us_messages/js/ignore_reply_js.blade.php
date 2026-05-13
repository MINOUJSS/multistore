<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function ignoreReply(id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-primary',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'تجاهل الرد',
            text: "هل تريد تجاهل الرد؟",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، تجاهل الرد',
            cancelButtonText: 'اغلاق',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('admin.contact.message.ignore', ':id') }}".replace(':id', id),
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
                    },
                    success: function(response) {
                        if (response.status == 'success') {
                            swalWithBootstrapButtons.fire(
                                'تم التجاهل',
                                response.message,
                                'success'
                            )
                            window.location.reload();
                        } else {
                            swalWithBootstrapButtons.fire(
                                'خطأ',
                                response.message,
                                'error'
                            )
                        }
                    }
                });
                //window.location.href = "{{ route('admin.contact.message.show', ':id') }}".replace(':id', id);
            }
        });
    }
  
</script>