<script>
    function loadAdditionDetails(additionId) {
    const content = document.getElementById('invoice-details-content');
    content.innerHTML = `<div class="text-center">جاري التحميل...</div>`;

    fetch(`/supplier-panel/wallet/addition/${additionId}`)
        .then(response => {
            if (!response.ok) throw new Error('حدث خطأ أثناء جلب البيانات');
            return response.json();
        })
        .then(data => {
            content.innerHTML = `
                <table class="table table-bordered text-center">
                    <tr><th>رقم العملية</th><td>${data.id}</td></tr>
                    <tr><th>المبلغ</th><td>${data.amount} د.ج</td></tr>
                    <tr><th>طريقة الدفع</th><td>${data.payment_method}</td></tr>
                    <tr><th>الوصف</th><td>${data.description}</td></tr>
                    <tr><th>التاريخ</th><td>${data.created_at}</td></tr>
                </table>
            `;
        })
        .catch(error => {
            content.innerHTML = `<div class="alert alert-danger text-center">${error.message}</div>`;
        });
}

</script>