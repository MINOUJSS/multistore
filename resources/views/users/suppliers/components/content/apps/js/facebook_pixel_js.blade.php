<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("FacebookPixelForm").addEventListener("submit", async function (e) {
            e.preventDefault();
    
            let form = this;
            let formData = new FormData(form);
    
            // تنظيف الأخطاء السابقة
            document.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
            document.querySelectorAll('.invalid-feedback').forEach(el => el.textContent = '');
    
            try {
                let response = await fetch("{{ route('supplier.app.store-facebook-pixel') }}", {
                    method: "POST",
                    body: formData,
                    headers: {
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                        "X-Requested-With": "XMLHttpRequest"
                    }
                });
    
                let data = await response.json();
    
                if (!response.ok) {
                    throw { status: response.status, data };
                }
    
                if (data.success) {
                    // ✅ تحديث معرف التتبع (pixel ID)
                    document.getElementById("fp_pixel_id").value = formData.get("fp_pixel_id");
                    
                    // ✅ تحديث حالة التفعيل
                    let statusCheckbox = document.getElementById("fp_status");
                    let isActive = formData.get("fp_status") ? true : false;
                    statusCheckbox.checked = isActive;
    
                    // ✅ تحديث شارة الحالة (Badge)
                    let badge = document.querySelector(".facebook-pixel-badge");
                    if (isActive) {
                        badge.classList.remove("bg-secondary");
                        badge.classList.add("bg-success");
                        badge.textContent = "مفعل";
                    } else {
                        badge.classList.remove("bg-success");
                        badge.classList.add("bg-secondary");
                        badge.textContent = "غير مفعل";
                    }
    
                    Swal.fire({
                        icon: "success",
                        title: "تم الحفظ!",
                        text: data.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
    
                }
            } catch (error) {
                if (error.status === 422 && error.data.errors) {
                    console.log(error.data.errors);
                    // ❌ عرض أخطاء التحقق (Validation)
                    Object.keys(error.data.errors).forEach(field => {
                        let input = document.querySelector(`[name="${field}"]`);
                        let errorDiv = document.getElementById(`error-${field}`);
                        if (input && errorDiv) {
                            input.classList.add("is-invalid");
                            errorDiv.textContent = error.data.errors[field][0];
                        }
                    });
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "خطأ!",
                        text: "حدث خطأ أثناء الحفظ، حاول مرة أخرى.",
                        timer: 2000,
                        showConfirmButton: false
                    });
                    console.error("خطأ أثناء إرسال البيانات:", error);
                }
            }
        });
    });
    
    </script>
        