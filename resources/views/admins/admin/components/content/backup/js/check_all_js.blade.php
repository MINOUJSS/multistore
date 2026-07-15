<script>

        document.getElementById('checkAll').addEventListener('change', function () {

            document.querySelectorAll('.file-checkbox').forEach(function (checkbox) {

                checkbox.checked = document.getElementById('checkAll').checked;

            });

        });

</script>
