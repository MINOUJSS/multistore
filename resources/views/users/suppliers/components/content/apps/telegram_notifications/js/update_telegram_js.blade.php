<script>
// 🟠 فتح مودال التعديل وتعبئة البيانات
document.querySelectorAll(".edit-btn").forEach(button => {
        button.addEventListener("click", function () {
            let id = this.dataset.id;
            let chat_id = this.dataset.chat_id;
            let status = this.dataset.status === "active";

            document.getElementById("edit_id").value = id;
            document.getElementById("edit_chat_id").value = chat_id;
            document.getElementById("edit_status").checked = status;

            let editModal = new bootstrap.Modal(document.getElementById("editTelegramModal"));
            editModal.show();
        });
    });

    // 🟡 تحديث إعدادات Telegram
    document.getElementById("EditTelegramNotificationForm").addEventListener("submit", function (e) {
        e.preventDefault();
        let form = this;
        let formData = new FormData(form);
        let id = document.getElementById("edit_id").value;

        fetch(`{{ route('supplier.app.update-telegram-notification', '') }}/${id}`, {
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
                document.getElementById(`row-${id}`).querySelector("td:nth-child(2)").textContent = JSON.parse(data.data.data).chat_id;
                document.getElementById(`row-${id}`).querySelector("span").className = data.data.status === 'active' ? "badge bg-success" : "badge bg-secondary";
                document.getElementById(`row-${id}`).querySelector("span").textContent = data.data.status === 'active' ? "مفعل" : "غير مفعل";

                Swal.fire({ icon: "success", title: "تم التحديث!", text: data.message, timer: 2000, showConfirmButton: false });
                form.reset();
                bootstrap.Modal.getInstance(document.getElementById('editTelegramModal')).hide();
            }
        })
        .catch(error => console.error("خطأ أثناء التحديث:", error));
    });
</script>   