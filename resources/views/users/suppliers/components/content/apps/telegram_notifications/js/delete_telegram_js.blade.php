<script>
   // 🔴 حذف إعدادات Telegram
   document.querySelectorAll(".delete-btn").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.dataset.id;

            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من استعادة هذا الإعداد!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "نعم، احذف!"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ route('supplier.app.delete-telegram-notification', '') }}/${id}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            document.getElementById(`row-${id}`).remove();
                            Swal.fire({ icon: "success", title: "تم الحذف!", text: data.message, timer: 2000, showConfirmButton: false });
                            //تحديث الصفحة
                            location.reload();
                        }
                    })
                    .catch(error => console.error("خطأ أثناء الحذف:", error));
                }
            });
        });
    });
</script>   