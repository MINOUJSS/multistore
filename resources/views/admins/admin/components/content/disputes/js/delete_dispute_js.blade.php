<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.getElementById("deleteDisputeForm").addEventListener("submit", function(e) {
    e.preventDefault();
    Swal.fire({
        title: 'تأكيد الحذف',
        text: 'هل تريد توليد نسخة PDF من المحادثة قبل الحذف؟',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'نعم، توليد PDF ثم الحذف',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            e.target.submit();
        }
    });
});
</script>