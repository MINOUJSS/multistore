<script>
    $(document).ready(function () {
    function filtermessages() {
        let status = $("#messageStatusFilter").val();
        let date = $("#messageDateFilter").val();
        let search = $("#searchFilter").val();

        $.ajax({
            url: "/ah-admin/contact-us-message/filter-messages", // تأكد من أن هذا المسار صحيح في Laravel
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
                console.log(response);
                $("tbody").html(response);
            },
            error: function (xhr) {
                console.log("حدث خطأ:", xhr.responseText);
            }
        });
    }

    // تشغيل الفلتر عند تغيير القيم
    $("#messageStatusFilter, #messageDateFilter, #searchFilter").on("change keyup", function () {
        filtermessages();
    });

    // تشغيل الفلتر عند الضغط على زر البحث
    $("#searchBtn").on("click", function () {
        filtermessages();
    });
});

</script>