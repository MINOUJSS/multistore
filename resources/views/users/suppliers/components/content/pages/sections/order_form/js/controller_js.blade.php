<script>
    $(document).ready(function() {
        //get form title element 
        const form_title = $('#form_title');
        //get form title controller element
        const form_title_controller = $('#form_title_controller');
        //set form title controller value to form title element
        form_title_controller.on('input', function() {
            form_title.text(form_title_controller.val());
            if (form_title_controller.val() == '') {
                form_title.text('{{ $order_form->form_title }}');
            }
        })
        //get form_submit_button element
        const form_submit_button = $('#form_submit_button');
        //get submit_btn element
        const submit_btn = $('#submit_btn');
        //set submit_btn value to form_submit_button element
        submit_btn.on('input', function() {
            form_submit_button.text(submit_btn.val());
            if (submit_btn.val() == '') {
                form_submit_button.text('{{ $order_form->form_submit_button }}');
            }
        })
        //get form name_lable element
        const form_name_lable = $('#form_lable_customer_name');
        //get form_name_controller element
        const form_name_controller = $('#form_lable_customer_name_controller');
        //set form_name_controller value to form_name element
        form_name_controller.on('input', function() {
            form_name_lable.text(form_name_controller.val());
            if (form_name_controller.val() == '') {
                form_name_lable.text('{{ $order_form->lable_customer_name }}');
            }
        })
        //get form name placeholder element
        const input_name = $('#name');
        //get form_name_controller element
        const input_name_controller = $('#form_placeholder_customer_name_controller');
        //set form_name_controller value to form_name element
        input_name_controller.on('input', function() {
            input_name.attr('placeholder', input_name_controller.val());
            if (input_name_controller.val() == '') {
                input_name.attr('placeholder', '{{ $order_form->input_placeholder_customer_name }}');
            }
        })
        //get form_required_customer_name_controller element
        const form_required_customer_name_controller = $('#form_required_customer_name_controller');
        //get form_required_customer_name element
        const form_required_customer_name = $('#form_required_customer_name');
        //set form_required_customer_name_controller value to form_required_customer_name element
        form_required_customer_name_controller.on('input', function() {
            if(form_required_customer_name_controller.is(':checked')) {
                form_required_customer_name.text('*');
                input_name.attr('required', 'required');
            }else
            {
                form_required_customer_name.text('');
                input_name.removeAttr('required');
            }
            // form_required_customer_name.prop('checked', form_required_customer_name_controller.is(':checked'));
        })
        //get form phone_lable element
        const form_phone_lable = $('#form_lable_customer_phone');
        //get form_phone_controller element
        const form_phone_controller = $('#form_lable_customer_phone_controller');
        //set form_phone_controller value to form_phone element
        form_phone_controller.on('input', function() {
            form_phone_lable.text(form_phone_controller.val());
            if (form_phone_controller.val() == '') {
                form_phone_lable.text('{{ $order_form->lable_customer_phone }}');
            }
        })
        //get form name placeholder element
        const input_phone = $('#phone');
        //get form_name_controller element
        const input_phone_controller = $('#form_placeholder_customer_phone_controller');
        //set form_name_controller value to form_name element
        input_phone_controller.on('input', function() {
            input_phone.attr('placeholder', input_phone_controller.val());
            if (input_phone_controller.val() == '') {
                input_phone.attr('placeholder', '{{ $order_form->input_placeholder_customer_phone }}');
            }
        })
        //get form address_lable element
        const form_address_lable = $('#form_lable_customer_address');
        //get form_address_controller element
        const form_address_controller = $('#form_lable_customer_address_controller');
        //set form_address_controller value to form_address element
        form_address_controller.on('input', function() {
            form_address_lable.text(form_address_controller.val());
            if (form_address_controller.val() == '') {
                form_address_lable.text('{{ $order_form->lable_customer_address }}');
            }
        })
        //get form name placeholder element
        const input_address = $('#address');
        //get form_name_controller element
        const input_address_controller = $('#form_placeholder_customer_address_controller');
        //set form_name_controller value to form_name element
        input_address_controller.on('input', function() {
            input_address.attr('placeholder', input_address_controller.val());
            if (input_address_controller.val() == '') {
                input_address.attr('placeholder', '{{ $order_form->input_placeholder_customer_address }}');
            }
        })
        //get form_required_customer_name_controller element
        const form_required_customer_address_controller = $('#form_required_customer_address_controller');
        //get form_required_customer_name element
        const form_required_customer_address = $('#form_required_customer_address');
        //set form_required_customer_name_controller value to form_required_customer_name element
        form_required_customer_address_controller.on('input', function() {
            if(form_required_customer_address_controller.is(':checked')) {
                form_required_customer_address.text('*');
                input_address.attr('required', 'required');
            }else
            {
                form_required_customer_address.text('');
                input_address.removeAttr('required');
            }
            // form_required_customer_name.prop('checked', form_required_customer_name_controller.is(':checked'));
        })
        //get form_required_customer_address_status_controller element
        const form_required_customer_address_status_controller = $('#form_required_customer_address_status_controller');
        //get form_required_customer_name element
        const form_address_group = $('#form_address_group');
        //set form_required_customer_name_controller value to form_required_customer_name element
        form_required_customer_address_status_controller.on('input', function() {
            if(form_required_customer_address_status_controller.is(':checked')) {
                form_address_group.show();
            }else
            {
                form_address_group.hide();
            }
            // form_required_customer_name.prop('checked', form_required_customer_name_controller.is(':checked'));
        })
        //get form_lable_customer_notes element
        const form_lable_customer_notes = $('#form_lable_customer_notes');
        //get form_lable_customer_notes_controller element
        const form_lable_customer_notes_controller = $('#form_lable_customer_notes_controller');
        //set form_lable_customer_notes_controller value to form_lable_customer_notes element
        form_lable_customer_notes_controller.on('input', function() {
            form_lable_customer_notes.text(form_lable_customer_notes_controller.val());
            if (form_lable_customer_notes_controller.val() == '') {
                form_lable_customer_notes.text('{{ $order_form->lable_customer_notes }}');
            }
        })
        //get form_placeholder_customer_notes element
        const form_placeholder_customer_notes = $('#notes');
        //get form_placeholder_customer_notes_controller element
        const form_placeholder_customer_notes_controller = $('#form_placeholder_customer_notes_controller');
        //set form_placeholder_customer_notes_controller value to form_placeholder_customer_notes element
        form_placeholder_customer_notes_controller.on('input', function() {
            form_placeholder_customer_notes.text(form_placeholder_customer_notes_controller.val());
            if (form_placeholder_customer_notes_controller.val() == '') {
                form_placeholder_customer_notes.text('{{ $order_form->input_placeholder_customer_notes }}');
            }
        })
        //get form_required_customer_notes_controller element
        const form_required_customer_notes_controller = $('#form_required_customer_notes_controller');
        //get form_required_customer_notes element
        const form_required_customer_notes = $('#form_required_customer_notes');
        //set form_required_customer_notes_controller value to form_required_customer_notes element
        form_required_customer_notes_controller.on('input', function() {
            if(form_required_customer_notes_controller.is(':checked')) {
                form_required_customer_notes.text('*');
            }else
            {
                form_required_customer_notes.text('');
            }
            // form_required_customer_notes.prop('checked', form_required_customer_notes_controller.is(':checked'));
        })
        //get form_required_customer_notes_status_controller element
        const form_required_customer_notes_status_controller = $('#form_required_customer_notes_status_controller');
        //get form_required_customer_notes element
        const form_notes_group = $('#form_notes_group');
        //set form_required_customer_notes_controller value to form_required_customer_notes element
        form_required_customer_notes_status_controller.on('input', function() {
            if(form_required_customer_notes_status_controller.is(':checked')) {
                form_notes_group.show();
            }else
            {
                form_notes_group.hide();
            }
            // form_required_customer_notes.prop('checked', form_required_customer_notes_controller.is(':checked'));
        })
        //get form_product_coupon_code_controller element
        const form_product_coupon_code_controller = $('#form_product_coupon_code_controller');
        //get form_product_coupon_code element
        const form_product_coupon_code = $('#form_product_coupon_code');
        //set form_product_coupon_code_controller value to form_product_coupon_code element
        form_product_coupon_code_controller.on('input', function() {
            form_product_coupon_code.text(form_product_coupon_code_controller.val());
            if (form_product_coupon_code_controller.val() == '') {
                form_product_coupon_code.text('{{ $order_form->lable_product_coupon_code }}');
            }
        })
        //get form_placeholder_coupon_code_controller element
        const form_placeholder_coupon_code_controller = $('#form_placeholder_coupon_code_controller');
        //get form_placeholder_coupon_code element
        const form_placeholder_coupon_code = $('#coupon');
        //set form_placeholder_coupon_code_controller value to form_placeholder_coupon_code element
        form_placeholder_coupon_code_controller.on('input', function() {
            form_placeholder_coupon_code.attr('placeholder', form_placeholder_coupon_code_controller.val())
            if (form_placeholder_coupon_code_controller.val() == '') {
                form_placeholder_coupon_code.attr('placeholder','{{ $order_form->input_placeholder_product_coupon_code }}');
            }
        })
    });
</script>
