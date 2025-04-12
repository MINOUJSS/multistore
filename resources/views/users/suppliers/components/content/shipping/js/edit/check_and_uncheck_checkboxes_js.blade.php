<script>
    document.addEventListener("DOMContentLoaded", function() {
        // استهداف جميع مربعات الاختيار الرئيسية في رأس الجدول
        document.querySelectorAll(".check-all").forEach(function(headerCheckbox) {
            headerCheckbox.addEventListener("change", function() {
                let column = this.dataset.column; // الحصول على اسم العمود من `data-column`
                let checkboxes = document.querySelectorAll(`.check-${column}`);
                
                checkboxes.forEach(function(checkbox) {
                    checkbox.checked = headerCheckbox.checked; // تحديد أو إلغاء تحديد جميع المربعات في العمود
                });
            });
        });
    });
</script>