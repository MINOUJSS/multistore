<script>
        //drop zone functions
    
    
    function add_previewDigitalFile(event) {
        let file = event.target.files[0];

        if (file) {
            let preview = document.getElementById('add_digitalPreview');
            preview.innerHTML = `
                <div class="text-center">
                    <i class="fa fa-file fa-2x"></i>
                    <p>${file.name}</p>
                    <small>${(file.size / 1024 / 1024).toFixed(2)} MB</small>
                </div>
            `;
        }
    }
    function add_browsDigitalFile() {
        document.getElementById('add_digital_file').click();
    }

    $(document).ready(function () {
    
    // مهم: ربط onchange
    document.getElementById('add_digital_file').addEventListener('change', add_previewDigitalFile);

        // تغيير نوع المنتج
        function toggleProductType(value) {

            if (value === 'digital') {

                // إخفاء العناصر الخاصة بالمنتجات الفيزيائية
                $('#add_inputQty').closest('.col-md-6').hide();
                $('#add_free_shipping').closest('.col-md-3').hide();
                $('#add_inputCost').closest('.col-md-6').hide();
                $('#add_attribute_color_section').hide();
                $('#add_inputCondition').closest('.col-md-6').hide();

                // إخفاء حقل الحالة (اختياري)
                $('#add_inputProductType').closest('.col-md-6').show(); // نتركه ظاهر لأنه يحتوي digital
                $('#digital_file_section').show();

                // تعيين القيم تلقائياً
                $('#add_inputQty').val(0);
                $('#add_free_shipping').prop('checked', false);

            } else {

                // إظهار العناصر الخاصة بالمنتجات الفيزيائية
                $('#add_inputQty').closest('.col-md-6').show();
                $('#add_inputCost').closest('.col-md-6').show();
                $('#add_free_shipping').closest('.col-md-3').show();
                $('#add_attribute_color_section').show();
                $('#add_inputCondition').closest('.col-md-6').show();

                //
                $('#digital_file_section').hide();

                // إعادة القيم الافتراضية (اختياري)
                $('#add_inputQty').val('');
                $('#add_free_shipping').prop('checked', true);
            }
        }

        // عند التغيير
        $('#add_inputProductType').on('change', function () {
            let value = $(this).val();
            toggleProductType(value);
        });

        // عند تحميل الصفحة (في حال القيمة كانت محفوظة)
        toggleProductType($('#add_inputProductType').val());

    });
</script>