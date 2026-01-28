<script>
    $(document).ready(function () {
    function filterOrders() {
        let status = $("#orderStatusFilter").val();
        let date = $("#orderDateFilter").val();
        let search = $("#searchFilter").val();

        $.ajax({
            url: "/seller-panel/filter-orders-abandoned", // تأكد من أن هذا المسار صحيح في Laravel
            method: "GET",
            data: {
                status: status,
                date: date,
                search: search
            },
            beforeSend: function () {
                $("tbody").html('<tr><td colspan="8" class="text-center">جارٍ تحميل البيانات...</td></tr>');
            },
            success: function (response) {
                $("tbody").html(response);
            },
            error: function (xhr) {
                console.log("حدث خطأ:", xhr.responseText);
            }
        });
    }

    // تشغيل الفلتر عند تغيير القيم
    $("#orderStatusFilter, #orderDateFilter, #searchFilter").on("change keyup", function () {
        filterOrders();
    });

    // تشغيل الفلتر عند الضغط على زر البحث
    $("#searchBtn").on("click", function () {
        filterOrders();
    });
});

</script>