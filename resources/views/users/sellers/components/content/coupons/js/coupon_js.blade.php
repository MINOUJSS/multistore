<script>
$(document).ready(function() {
    // Initialize Select2
    // $('.select2').select2({
    //     placeholder: "اختر...",
    //     allowClear: true,
    //     width: '100%'
    // });
    // Toggle value suffix based on coupon type
    $('#add_type, #edit_type').change(function() {
        const suffix = $(this).val() === 'percent' ? '%' : 'د.ج';
        $(this).closest('.row').find('.input-group-text').text(suffix);
    });

    // Show/hide specific users field based on user restriction
    $('#add_user_restriction, #edit_user_restriction').change(function() {
        const container = $(this).attr('id').includes('add') ? 
            $('#add_specific_users_container') : $('#edit_specific_users_container');
        container.toggle($(this).val() === 'specific');
    });
  
    // Show/hide products/categories fields based on product restriction
    $('#add_product_restriction, #edit_product_restriction').change(function() {
        const isAdd = $(this).attr('id').includes('add');
        const value = $(this).val();
        
        if (isAdd) {
            $('#add_categories_container').toggle(value === 'categories');
            $('#add_products_container').toggle(value === 'products');
        } else {
            $('#edit_categories_container').toggle(value === 'categories');
            $('#edit_products_container').toggle(value === 'products');
        }
    });
  
    // Generate random coupon code
    $('#generateCode').click(function() {
        const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let result = '';
        for (let i = 0; i < 8; i++) {
            result += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        $('#add_code').val(result);
    });

    // Filter coupons
    $('#searchBtn').click(function() {
        filterCoupons();
    });

    $('#typeFilter, #statusFilter').change(function() {
        filterCoupons();
    });

    $('#searchFilter').keyup(function() {
        filterCoupons();
    })

    // Add new coupon
    $('#saveCoupon').click(function() {
        const formData = $('#addCouponForm').serialize();
        
        $.ajax({
            url: '{{ route("seller.coupons.store") }}',
            type: 'POST',
            data: formData,
            success: function(response) {
                // toastr.success('تم إضافة الكوبون بنجاح');
                    Swal.fire({
                    icon: 'success',
                    title: 'تم بنجاح',
                    text: 'تم إضافة الكوبون بنجاح',
                    confirmButtonText: 'حسناً',
                    timer: 3000, // Auto-close after 3 seconds (optional)
                });
                $('#addCouponModal').modal('hide');
                //refresh the page
                window.location.reload();
               // refreshCouponList();
            },
            error: function(xhr) {
                console.log(xhr);
                displayErrors(xhr.responseJSON.errors, 'add');
            }
        });
    });

    // Edit coupon - fill form
    $(document).on('click', '.edit-coupon', function() {
        const couponId = $(this).val();
        
        $.ajax({
            url: 'coupons/' + couponId + '/edit',
            type: 'GET',
            success: function(response) {
                fillEditForm(response);
                $('#editCouponModal').modal('show');
            }
        });
    });

    // Update coupon
    $('#updateCoupon').click(function() {
        const couponId = $('#edit_id').val();
        const formData = $('#editCouponForm').serialize();
        
        $.ajax({
            url: 'coupons/' + couponId + '/update',
            type: 'PUT',
            data: formData,
            success: function(response) {
                // toastr.success('تم تحديث الكوبون بنجاح');
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'تم تحديث الكوبون بنجاح',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    });
                $('#editCouponModal').modal('hide');
                //refresh the page
                window.location.reload();
                //refreshCouponList();
            },
            error: function(xhr) {
                displayErrors(xhr.responseJSON.errors, 'edit');
            }
        });
    });

    // Delete coupon confirmation
    $(document).on('click', '.delete-coupon', function() {
        const couponId = $(this).val();
        $('#delete_coupon_id').val(couponId);
        $('#deleteCouponModal').modal('show');
    });

    // Confirm delete
    $('#confirmDelete').click(function() {
        const couponId = $('#delete_coupon_id').val();
        
        $.ajax({
            url: 'coupons/destroy/' + couponId,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // toastr.success('تم حذف الكوبون بنجاح');
                    Swal.fire({
                        icon: 'success',
                        title: 'تم بنجاح',
                        text: 'تم حذف الكوبون بنجاح',
                        confirmButtonText: 'حسناً',
                        timer: 3000,  // Auto-close after 3 seconds (optional)
                        toast: true,  // Display as toast notification
                        position: 'top-end'
                    });
                $('#deleteCouponModal').modal('hide');
                //refresh the page
                window.location.reload();
                //refreshCouponList();
            }
        });
    });

    // Helper function to filter coupons
    function filterCoupons() {
        const type = $('#typeFilter').val();
        const status = $('#statusFilter').val();
        const search = $('#searchFilter').val();
        
        $.ajax({
            url: '{{ route("seller.coupons.filter") }}',
            type: 'GET',
            data: {
                type: type,
                status: status,
                search: search
            },
            success: function(response) {
                $('#couponList').html(response.html);
            }
        });
    }

    // Helper function to refresh coupon list
    function refreshCouponList() {
        $.ajax({
            url: '{{ route("seller.coupons") }}',
            type: 'GET',
            success: function(response) {
                $('#couponList').html(response.html);
            }
        });
    }

    // Helper function to fill edit form
    function fillEditForm(coupon) {
        $('#edit_id').val(coupon.id);
        $('#edit_code').val(coupon.code);
        $('#edit_description').val(coupon.description);
        $('#edit_type').val(coupon.type).trigger('change');
        $('#edit_value').val(coupon.value);
        $('#edit_start_date').val(coupon.start_date.replace(' ', 'T'));
        $('#edit_end_date').val(coupon.end_date.replace(' ', 'T'));
        $('#edit_min_order_amount').val(coupon.min_order_amount);
        $('#edit_max_uses').val(coupon.usage_limit);
        $('#edit_is_active').prop('checked', coupon.is_active);
        
        // // User restrictions
        // $('#edit_user_restriction').val(coupon.user_restriction).trigger('change');
        // if (coupon.user_restriction === 'specific' && coupon.users) {
        //     const userIds = coupon.users.map(user => user.id);
        //     $('#edit_specific_users').val(userIds).trigger('change');
        // }
       
        // // Product restrictions
        // $('#edit_product_restriction').val(coupon.product_restriction).trigger('change');
        // if (coupon.product_restriction === 'categories' && coupon.categories) {
        //     const categoryIds = coupon.categories.map(category => category.id);
        //     $('#edit_categories').val(categoryIds).trigger('change');
        // } else if (coupon.product_restriction === 'products' && coupon.products) {
        //     const productIds = coupon.products.map(product => product.id);
        //     $('#edit_products').val(productIds).trigger('change');
        // }
    }

    // Helper function to display validation errors
    function displayErrors(errors, prefix) {
        // Clear previous errors
        $(`.error-${prefix}_`).text('');
        
        // Display new errors
        for (const field in errors) {
            const errorMessage = errors[field][0];
            $(`.error-${prefix}_${field}`).text(errorMessage);
        }
    }

});
</script>