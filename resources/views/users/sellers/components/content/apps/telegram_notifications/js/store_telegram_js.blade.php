<script>
document.addEventListener("DOMContentLoaded", function () {
    // 🟢 إضافة إعداد جديد
    document.getElementById("AddTelegramNotificationForm").addEventListener("submit", function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);

        fetch("{{ route('seller.app.store-telegram-notification') }}", {
            method: "POST",
            body: formData,
            headers: {
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                let table = document.querySelector("tbody");
                let lastIndex = table.querySelectorAll("tr").length;
                let newIndex = lastIndex + 1;
                let newRow = `
                    <tr id="row-${data.data.id}">
                        <td>${newIndex}</td>
                        <td>${JSON.parse(data.data.data).chat_id}</td>
                        <td>
                            <span class="badge ${data.data.status === 'active' ? 'bg-success' : 'bg-secondary'}">
                                ${data.data.status === 'active' ? 'مفعل' : 'غير مفعل'}
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-warning btn-sm edit-btn" data-id="${data.data.id}">
                                <i class="fas fa-edit"></i> تعديل
                            </button>
                            <button class="btn btn-danger btn-sm delete-btn" data-id="${data.data.id}">
                                <i class="fas fa-trash"></i> حذف
                            </button>
                        </td>
                    </tr>
                `;
                document.querySelector("tbody").insertAdjacentHTML("beforeend", newRow);
                Swal.fire({ icon: "success", title: "تم الحفظ!", text: data.message, timer: 2000, showConfirmButton: false });
                form.reset();
                bootstrap.Modal.getInstance(document.getElementById('addTelegramModal')).hide();

                //تحديث الصفحة
                location.reload();
            }else
            {
                //console.log(data);
                Swal.fire({
                    icon: "error",
                    title: "خطأ !",
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: true
                });
                form.reset();
                bootstrap.Modal.getInstance(document.getElementById('addTelegramModal')).hide();
            }
        })
        .catch(error => console.error("خطأ أثناء الحفظ:", error));
    });
});
</script>