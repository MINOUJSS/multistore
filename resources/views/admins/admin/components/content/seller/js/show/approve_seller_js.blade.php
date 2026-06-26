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

    // print profile
    function printSellerInfo() {
    const content = document.getElementById("printableArea").innerHTML;

    const printWindow = window.open('', '', 'width=900,height=700');

    printWindow.document.write(`
        <html dir="rtl">
        <head>
            <title>طباعة معلومات المستخدم</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
            <style>
                body {
                    padding: 20px;
                    direction: rtl;
                    font-family: Arial, sans-serif;
                }
                .card {
                    border: 1px solid #ddd;
                    margin-bottom: 20px;
                }
                .badge {
                    padding: 6px 10px;
                }
            </style>
        </head>
        <body>
            ${content}
        </body>
        </html>
    `);

    printWindow.document.close();
    printWindow.focus();

    

    setTimeout(() => {
        printWindow.print();
        printWindow.close();
    }, 500);
}

</script>
