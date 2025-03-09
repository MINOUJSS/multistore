<script>
        document.addEventListener("DOMContentLoaded", function () {
        document.querySelectorAll(".delete-product").forEach(button => {
            button.addEventListener("click", function () {
                let productId = this.getAttribute("data-id");

                Swal.fire({
                    title: "هل أنت متأكد؟",
                    text: "لن تتمكن من التراجع عن هذا!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "نعم، احذف!",
                    cancelButtonText: "إلغاء"
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch(`/supplier-panel/product/delete/${productId}`, {
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                                "Content-Type": "application/json"
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            if (data.success) {
                                Swal.fire("تم الحذف!", "تم حذف المنتج بنجاح.", "success");
                                location.reload();
                            } else {
                                console.log(data);
                                Swal.fire("خطأ!", "حدثت مشكلة أثناء الحذف.", "error");
                            }
                        });
                    }
                });
            });
        });
    });
</script>