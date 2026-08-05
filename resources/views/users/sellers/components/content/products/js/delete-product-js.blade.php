<script>
document.addEventListener("DOMContentLoaded", function () {
    const selectAllCheckbox = document.getElementById("selectAllProducts");
    const bulkDeleteBtn = document.getElementById("bulkDeleteBtn");
    const selectedCountSpan = document.getElementById("selectedCount");

    // تحديث حالة زر الحذف الجماعي
    function updateBulkDeleteState() {
        const checkedBoxes = document.querySelectorAll(".product-checkbox:checked");
        const totalBoxes = document.querySelectorAll(".product-checkbox");
        const count = checkedBoxes.length;

        if (selectedCountSpan) {
            selectedCountSpan.textContent = count;
        }

        if (count > 0) {
            bulkDeleteBtn.classList.remove("d-none");
        } else {
            bulkDeleteBtn.classList.add("d-none");
        }

        if (selectAllCheckbox && totalBoxes.length > 0) {
            selectAllCheckbox.checked = (checkedBoxes.length === totalBoxes.length);
        }
    }

    // تحديد الكل / إلغاء تحديد الكل
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener("change", function () {
            const isChecked = this.checked;
            document.querySelectorAll(".product-checkbox").forEach(checkbox => {
                checkbox.checked = isChecked;
            });
            updateBulkDeleteState();
        });
    }

    // التغيير على مستوى الكود المضاف ديناميكياً
    document.addEventListener("change", function (e) {
        if (e.target && e.target.classList.contains("product-checkbox")) {
            updateBulkDeleteState();
        }
    });

    // تنفيذ الحذف الفردي (Event Delegation)
    document.addEventListener("click", function (e) {
        const btn = e.target.closest(".delete-product");
        if (btn) {
            let productId = btn.getAttribute("data-id") || btn.value;

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
                    fetch(`/seller-panel/product/delete/${productId}`, {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire("تم الحذف!", "تم حذف المنتج بنجاح.", "success");
                            location.reload();
                        } else {
                            Swal.fire("خطأ!", "حدثت مشكلة أثناء الحذف.", "error");
                        }
                    });
                }
            });
        }
    });

    // تنفيذ الحذف الجماعي
    if (bulkDeleteBtn) {
        bulkDeleteBtn.addEventListener("click", function () {
            const checkedBoxes = document.querySelectorAll(".product-checkbox:checked");
            const selectedIds = Array.from(checkedBoxes).map(cb => cb.value);

            if (selectedIds.length === 0) return;

            Swal.fire({
                title: "تأكيد الحذف الجماعي",
                text: `هل أنت متأكد من حذف ${selectedIds.length} منتج(ات)؟ لن تتمكن من التراجع عن هذا!`,
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "نعم، احذف المحدد!",
                cancelButtonText: "إلغاء"
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch("/seller-panel/product/bulk-delete", {
                        method: "DELETE",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({ ids: selectedIds })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire("تم الحذف الجماعي!", data.message || "تم حذف المنتجات المحددة بنجاح.", "success");
                            location.reload();
                        } else {
                            Swal.fire("خطأ!", data.message || "حدثت مشكلة أثناء الحذف الجماعي.", "error");
                        }
                    })
                    .catch(err => {
                        Swal.fire("خطأ!", "حدث خطأ أثناء الاتصال بالسيرفر.", "error");
                    });
                }
            });
        });
    }
});
</script>