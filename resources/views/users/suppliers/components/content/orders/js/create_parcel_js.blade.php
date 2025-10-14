<script>
    $(document).ready(function() {
        //when click on select_company btn
        $(document).on('click', '.select_company', function(e) {
            //get data-order-id
            let order_id = $(this).data('order-id');
            //set input_order_id = order_id
            $('#input_order_id').val(order_id);
        });
        //when click on create_company_parcel btn
        $(document).on('click', '.create_company_parcel', function(e) {
            //get data-company-name
            let company_name = $(this).data('company-name');
            //set input_shipping_company = company_name
            $('#input_shipping_company').val(company_name);
            //create parcel
            createParcel();
        })

    });

    function createParcel() {
        // مثال Ajax
        //$("#shippingForm").serialize(),
        $.ajax({
            url: "/supplier-panel/courier-dz/createOrder",
            type: "POST",
            data: $("#shippingForm").serialize(),
            success: function(response) {
                console.log(response);
                if (response.success) {
                    Swal.fire({
                        toast: true,
                        position: 'top-start',
                        icon: 'success',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    console.log(response);
                    Swal.fire({
                        toast: true,
                        position: 'top-start',
                        icon: 'error',
                        title: response.message,
                        showConfirmButton: false,
                        timer: 4000
                    });
                }
                 location.reload();
            },
            error: function(xhr) {
                console.log(xhr);
                let msg = "فشل الاتصال بالسيرفر";

                if (xhr.responseText) {
                    try {
                        let res = JSON.parse(xhr.responseText);
                        msg = res.message;
                    } catch (e) {}
                }
                Swal.fire({
                    toast: true,
                    position: 'top-start',
                    icon: 'error',
                    title: msg,
                    showConfirmButton: false,
                    timer: 4000
                });
            }
        });

    }
</script>
