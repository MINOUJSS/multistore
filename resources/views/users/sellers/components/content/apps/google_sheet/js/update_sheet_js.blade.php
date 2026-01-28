<script>
    // تعديل الإعدادات
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("edit-btn")) {
            let id = event.target.getAttribute("data-id");
            let sheetID = document.querySelector(`#row-${id} td:nth-child(2)`).textContent;
            let status = document.querySelector(`#row-${id} td:nth-child(3) span`).textContent.trim() === "مفعل";
            document.getElementById("edit_id").value = id;
            document.getElementById("edit_sheet_id").value = sheetID;
            document.getElementById("edit_status").checked = status;
            new bootstrap.Modal(document.getElementById("editSheetModal")).show();
        }
    });

    document.getElementById("EditGoogleSheetForm").addEventListener("submit", function (e) {
        e.preventDefault();
        let id = document.getElementById("edit_id").value;
        let formData = new FormData(this);

        fetch(`{{ url('seller-panel/apps/google-sheet/update') }}/${id}`, {
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
                document.querySelector(`#row-${id} td:nth-child(2)`).textContent = JSON.parse(data.data.data).sheet_id;
                let statusBadge = document.querySelector(`#row-${id} td:nth-child(3) span`);
                statusBadge.textContent = data.data.status === "active" ? "مفعل" : "غير مفعل";
                statusBadge.className = data.data.status === "active" ? "badge bg-success" : "badge bg-secondary";
                Swal.fire({ icon: "success", title: "تم التعديل!", text: data.message, timer: 2000, showConfirmButton: false });
                bootstrap.Modal.getInstance(document.getElementById('editSheetModal')).hide();
            }
        })
        .catch(error => console.error("خطأ أثناء التعديل:", error));
    });
</script>
    