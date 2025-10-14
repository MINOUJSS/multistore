<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Handle quantity changes for all quantity controls
        document.querySelectorAll('.quantity-control').forEach(control => {
            const productId = control.dataset.productId;
            const variationId = control.dataset.variationId || null;
            const attributeId = control.dataset.attributeId || null;
            const input = control.querySelector('.quantity-input');
            const incrementBtn = control.querySelector('.increment-btn');
            const decrementBtn = control.querySelector('.decrement-btn');

            // Increment quantity
            incrementBtn.addEventListener('click', function() {
                updateQuantity(productId, variationId, attributeId, parseInt(input.value) + 1);
            });

            // Decrement quantity
            decrementBtn.addEventListener('click', function() {
                let minQuantity = parseInt(input.getAttribute('min')) || 1;
                if (parseInt(input.value) > minQuantity) {
                    updateQuantity(productId, variationId, attributeId, parseInt(input.value) -
                        1);
                }
            });

            // Direct input change
            input.addEventListener('change', function() {
                if (parseInt(input.value) < 1) {
                    input.value = 1;
                }
                updateQuantity(productId, variationId, attributeId, parseInt(input.value));
            });
        });

        // Function to update quantity via AJAX
        function updateQuantity(productId, variationId, attributeId, newQuantity) {
            // Show loading indicator
            const loader = document.createElement('div');
            loader.className = 'spinner-border spinner-border-sm';
            loader.setAttribute('role', 'status');

            // Prepare form data
            const formData = new FormData();
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
            formData.append('product_id', productId);
            formData.append('variation_id', variationId || 0);
            formData.append('attribute_id', attributeId || 0);
            formData.append('new_quantity', newQuantity);

            // Make AJAX request
            fetch('{{ route('tenant.update-cart-quantity') }}', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data)
                    if (data.success) {
                        // Update the quantity input
                        // document.querySelector(`.quantity-control[data-product-id="${productId}", data-variation-id="${variationId}", data-attribute-id="${attributeId}"] .quantity-input`).value = newQuantity;
                        // Update the quantity input
                        document.querySelector(
                            `.quantity-control[data-product-id="${productId}"][data-variation-id="${variationId}"][data-attribute-id="${attributeId}"] .quantity-input`
                            ).value = newQuantity;

                        // Update cart totals in the UI
                        if (data.cart) {
                            document.querySelectorAll('.cart-total-price').forEach(el => {
                                el.textContent = data.cart.totalPrice.toFixed(2) + ' د.ج';
                            });
                            document.querySelectorAll('.cart-total-qty').forEach(el => {
                                el.textContent = data.cart.totalQty;
                            });

                            // Update individual item total if exists
                            const itemTotalEl = document.querySelector(
                                `.item-total[data-product-id="${productId}"][data-variation-id="${variationId}"][data-attribute-id="${attributeId}"]`
                                );
                            if (itemTotalEl) {
                                const itemPrice = parseFloat(itemTotalEl.dataset.itemPrice);
                                itemTotalEl.textContent = (itemPrice * newQuantity).toFixed(2) + ' د.ج';
                            }
                            // Update cart total in nav bar
                            const navCartQty= document.querySelector('.nav-cart-qty');
                            if (navCartQty) {
                                document.querySelectorAll('.nav-cart-qty').forEach(el => {
                                    el.textContent = data.cart.totalQty;
                                });
                            }
                            // Update cart total in nav bar
                            const navCartTotal= document.querySelector('.nav-cart-total');
                            if (navCartTotal) {
                                document.querySelectorAll('.nav-cart-total').forEach(el => {
                                    el.textContent = data.cart.totalPrice.toFixed(2) + ' د.ج';
                                });
                            }
                        }

                        // Show success message
                        // Swal.fire({
                        //     title: 'تم التحديث!',
                        //     text: 'تم تحديث كمية المنتج في السلة',
                        //     icon: 'success',
                        //     confirmButtonText: 'حسنًا'
                        // });
                    } else {
                        console.log(data);
                        Swal.fire({
                            title: 'خطأ!',
                            text: data.message || 'حدث خطأ أثناء تحديث الكمية',
                            icon: 'error',
                            confirmButtonText: 'حسنًا'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'خطأ!',
                        text: 'حدث خطأ أثناء الاتصال بالخادم',
                        icon: 'error',
                        confirmButtonText: 'حسنًا'
                    });
                });
        }
    });
</script>
