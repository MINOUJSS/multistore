<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("AddClarityForm").addEventListener("submit", function (e) {
            e.preventDefault();

            let form = this;
            let formData = new FormData(form);

            // تنظيف الأخطاء السابقة
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');

            fetch("{{ route('supplier.app.store-clarity') }}", {
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
                    // 🔹 تحديد رقم السطر الجديد
                    let table = document.querySelector("tbody");
                    let lastIndex = table.querySelectorAll("tr").length;
                    let newIndex = lastIndex + 1;

                    // ✅ إضافة صف جديد للجدول
                    let newRow = `
                        <tr id="row-${data.data.id}">
                            <td>${newIndex}</td>
                            <td>${JSON.parse(data.data.data).clarity_id}</td>
                            <td>
                                <span class="badge ${data.data.status === 'active' ? 'bg-success' : 'bg-secondary'}">
                                    ${data.data.status === 'active' ? 'مفعل' : 'غير مفعل'}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn" 
                                        data-id="${data.data.id}"
                                        data-clarity_id="${JSON.parse(data.data.data).clarity_id}"
                                        data-status="${data.data.status}">
                                    <i class="fas fa-edit"></i> تعديل
                                </button>
                                <button class="btn btn-danger btn-sm delete-btn" data-id="${data.data.id}">
                                    <i class="fas fa-trash"></i> حذف
                                </button>
                            </td>
                        </tr>
                    `;
                    table.insertAdjacentHTML("beforeend", newRow);

                    Swal.fire({
                        icon: "success",
                        title: "تم الحفظ!",
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    form.reset();
                    bootstrap.Modal.getInstance(document.getElementById('addClarityModal')).hide();
                
                    //تحديث الصفحة
                    location.reload();
                
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "خطأ!",
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: true
                    });

                    form.reset();
                    bootstrap.Modal.getInstance(document.getElementById('addClarityModal')).hide();
                }
            })
            .catch(error => {
                console.error("خطأ أثناء الحفظ:", error);
            });
        });
    });
</script>
