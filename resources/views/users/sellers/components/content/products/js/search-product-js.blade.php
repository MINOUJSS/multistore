<script>
    $(document).ready(function() {
    function filterProducts() {
        let category = $("#categoryFilter").val();
        let status = $("#statusFilter").val();
        let search = $("#searchFilter").val();

        $.ajax({
            url: "/seller-panel/filter-products", // يجب أن تقوم بإعداد هذا المسار في Laravel
            method: "GET",
            data: {
                category: category,
                status: status,
                search: search
            },
            beforeSend: function() {
                $("#productList").html('<tr><td colspan="10" class="text-center">جارٍ تحميل البيانات...</td></tr>');
            },
            success: function(response) {
                $("#productList").html(response);
            },
            error: function(xhr) {
                console.log("حدث خطأ:", xhr.responseText);
            }
        });
    }

    // تشغيل الفلتر عند تغيير القيم في `select` أو `input`
    $("#categoryFilter, #statusFilter, #searchFilter").on("change keyup", function() {
        filterProducts();
    });

    // تشغيل الفلتر عند الضغط على زر البحث
    $("#searchBtn").on("click", function() {
        filterProducts();
    });
});

</script>