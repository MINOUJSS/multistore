<script>
    // حذف الإعدادات
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("delete-btn")) {
            let sheetId = event.target.getAttribute("data-id");
            let row = document.getElementById(`row-${sheetId}`);

            Swal.fire({
                title: "هل أنت متأكد؟",
                text: "لن تتمكن من استعادة هذا السجل بعد الحذف!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "نعم، احذفه!",
                cancelButtonText: "إلغاء"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`{{ url('seller-panel/apps/google-sheet/delete') }}/${sheetId}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            "X-Requested-With": "XMLHttpRequest"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            row.remove();
                            Swal.fire("تم الحذف!", "تم حذف الإعداد بنجاح.", "success");
                        
                             //تحديث الصفحة
                            location.reload();

                        } else {
                            Swal.fire("خطأ!", "حدثت مشكلة أثناء الحذف، حاول مرة أخرى.", "error");
                        }
                    })
                    .catch(error => Swal.fire("خطأ!", "تعذر الاتصال بالخادم.", "error"));
                }
            });
        }
    });
</script>  