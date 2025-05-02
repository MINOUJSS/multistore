<script>
    document.addEventListener('DOMContentLoaded', function () {
        // ربط جميع أزرار الحذف
        const deleteButtons = document.querySelectorAll('.delete-shipping-btn');
    
        deleteButtons.forEach(button => {
            button.addEventListener('click', function (e) {
                e.preventDefault(); // منع الإرسال التلقائي
                const form = this.closest('form');
    
                Swal.fire({
                    title: 'هل أنت متأكد؟',
                    text: "لن تتمكن من التراجع بعد الحذف!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'نعم، احذفها',
                    cancelButtonText: 'إلغاء'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
    </script>
    