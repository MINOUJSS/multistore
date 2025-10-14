<script>
    document.addEventListener("DOMContentLoaded", function () {
        // استهداف جميع أزرار الحذف
        document.querySelectorAll(".delete-btn").forEach(button => {
            button.addEventListener("click", function () {
                let clarityId = this.getAttribute("data-id"); // جلب ID السجل
                let row = document.getElementById(`row-${clarityId}`); // استهداف الصف في الجدول
                
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
                        fetch(`{{ url('supplier-panel/apps/clarity/delete') }}/${clarityId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                                "X-Requested-With": "XMLHttpRequest"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                row.remove(); // حذف الصف من الجدول
                                Swal.fire("تم الحذف!", "تم حذف الإعداد بنجاح.", "success");
                            
                                //تحديث الصفحة
                                location.reload();
                            
                            } else {
                                Swal.fire("خطأ!", "حدثت مشكلة أثناء الحذف، حاول مرة أخرى.", "error");
                            }
                        })
                        .catch(error => {
                            Swal.fire("خطأ!", "تعذر الاتصال بالخادم.", "error");
                            console.error("خطأ أثناء الحذف:", error);
                        });
                    }
                });
            });
        });
    });
</script>

    