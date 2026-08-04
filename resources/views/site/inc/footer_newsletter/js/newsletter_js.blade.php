<script>
document.addEventListener("DOMContentLoaded", function () {

    const form = document.querySelector('.footer-newsletter form');
    const alert_div = document.querySelector('.subscribe-alert');

    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        const emailInput = form.querySelector('input[name="subscriber_email"]');
        const submitBtn = form.querySelector('[name="subscriber_submit"]') || form.querySelector('button[type="submit"]') || form.querySelector('input[type="submit"]');

        // إزالة رسائل قديمة
        removeMessages(alert_div);

        // تحقق بسيط
        if (!emailInput || !emailInput.value) {
            showMessage(alert_div, 'يرجى إدخال البريد الإلكتروني', 'error');
            return;
        }

        // حالة loading
        if (submitBtn) {
            submitBtn.disabled = true;
            if (submitBtn.tagName.toLowerCase() === 'button') {
                const btnSpan = submitBtn.querySelector('span');
                if (btnSpan) {
                    btnSpan.textContent = 'جاري الإرسال...';
                } else {
                    submitBtn.textContent = 'جاري الإرسال...';
                }
            } else {
                submitBtn.value = 'جاري الإرسال...';
            }
        }

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            }
        })
        .then(async response => {
            const data = await response.json();

            if (!response.ok) {
                if (data.errors) {
                    throw new Error(formatErrors(data.errors));
                }
                throw new Error(data.message || 'حدث خطأ');
            }

            return data;
        })
        .then(data => {
            if (data.error) {
                showMessage(alert_div, data.message || 'حدث خطأ', 'error');
            } else {
                showMessage(alert_div, data.message || 'تم الاشتراك بنجاح 🎉', 'success');
            }
            form.reset();
        })
        .catch(error => {
            showMessage(alert_div, error.message, 'error');
        })
        .finally(() => {
            if (submitBtn) {
                submitBtn.disabled = false;
                if (submitBtn.tagName.toLowerCase() === 'button') {
                    const btnSpan = submitBtn.querySelector('span');
                    if (btnSpan) {
                        btnSpan.textContent = 'اشتراك الآن';
                    } else {
                        submitBtn.textContent = 'اشتراك الآن';
                    }
                } else {
                    submitBtn.value = 'إشتراك';
                }
            }
        });

    });

    // 🟢 عرض الرسائل
    function showMessage(alert_div, message, type) {
        if (!alert_div) return;
        const div = document.createElement('div');
        div.className = type === 'success' ? 'alert alert-success mt-2' : 'alert alert-danger mt-2';
        div.innerHTML = message;
        alert_div.appendChild(div);
    }

    // 🔴 حذف الرسائل القديمة
    function removeMessages(alert_div) {
        if (!alert_div) return;
        alert_div.querySelectorAll('.alert').forEach(el => el.remove());
    }

    // ⚠️ تنسيق أخطاء Laravel
    function formatErrors(errors) {
        let msg = '';
        Object.keys(errors).forEach(key => {
            msg += errors[key].join('<br>') + '<br>';
        });
        return msg;
    }

});
</script>