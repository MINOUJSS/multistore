<script>
        function unlock_phone_number(order_id) {
            if (!confirm("هل أنت متأكد من أنك تريد فتح رقم الهاتف؟")) {
                return;
            }

            $.ajax({
                url: '/supplier-panel/unlock-phone-number/' + order_id,
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // جلب التوكن من الميتا
                },
                success: function (response) {
                    alert('تم فتح رقم الهاتف بنجاح!');
                    location.reload(); // إعادة تحميل الصفحة بعد النجاح
                },
                error: function (xhr, status, error) {
                    alert('حدث خطأ أثناء فتح رقم الهاتف: ' + xhr.responseText);
                    console.error(error);
                }
            });
        }

</script>