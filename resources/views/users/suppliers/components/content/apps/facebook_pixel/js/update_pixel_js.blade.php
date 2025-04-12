<script>
    document.addEventListener("click", function (event) {
        if (event.target.classList.contains("edit-btn")) {
            let id = event.target.getAttribute("data-id");
    
            // جلب بيانات الإعدادات من الجدول
            let pixelID = document.querySelector(`#row-${id} td:nth-child(2)`).textContent;
            let status = document.querySelector(`#row-${id} td:nth-child(3) span`).textContent.trim() === "مفعل";
    
            // إدراج البيانات في النموذج
            document.getElementById("edit_id").value = id; // ✅ حفظ id في input hidden
            document.getElementById("edit_pixel_id").value = pixelID;
            document.getElementById("edit_status").checked = status;
    
            // فتح المودال
            new bootstrap.Modal(document.getElementById("editPixelModal")).show();
        }
    });
    
    // عند حفظ التعديلات
    document.getElementById("EditFacebookPixelForm").addEventListener("submit", function (e) {
        e.preventDefault();
    
        let id = document.getElementById("edit_id").value; // ✅ جلب id الصحيح
        let formData = new FormData(this);
    
        fetch(`{{ url('supplier-panel/apps/facebook-pixel/update') }}/${id}`, {
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
                // ✅ تحديث البيانات في الجدول
                document.querySelector(`#row-${id} td:nth-child(2)`).textContent = JSON.parse(data.data.data).pixel_id;
                
                let statusBadge = document.querySelector(`#row-${id} td:nth-child(3) span`);
                statusBadge.textContent = data.data.status === "active" ? "مفعل" : "غير مفعل";
                statusBadge.className = data.data.status === "active" ? "badge bg-success" : "badge bg-secondary";
    
                Swal.fire({
                    icon: "success",
                    title: "تم التعديل!",
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                });
    
                bootstrap.Modal.getInstance(document.getElementById('editPixelModal')).hide();
            }
        })
        .catch(error => {
            console.error("خطأ أثناء التعديل:", error);
        });
    });
    </script>
    