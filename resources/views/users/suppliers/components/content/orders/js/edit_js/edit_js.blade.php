<script>
    document.addEventListener('DOMContentLoaded', function() {
        // العناصر الرئيسية
        const summaryItems = document.getElementById('summaryItems');
        const discountInput = document.getElementById('discount');
        const shippingInput = document.getElementById('shipping_cost');
        const orderItemsTable = document.getElementById('orderItemsTable');
        const newProductSelect = document.getElementById('new_product');
        const addItemBtn = document.getElementById('addItemBtn');
        const saveOrderBtn = document.getElementById('saveOrderBtn');

        // تهيئة أولية
        initializeBasePrices();
        // updateSummary();
        setupEventListeners();

        // ===== FUNCTIONS =====

        function initializeBasePrices() {
            document.querySelectorAll('input[name*="[unit_price]"]').forEach(input => {
                if (!input.hasAttribute('data-base-price')) {
                    input.setAttribute('data-base-price', input.value || 0);
                }
            });
            updateGrandTotal();
        }

        function setupEventListeners() {
            // أحداث الجدول
            orderItemsTable.addEventListener('change', handleTableChange);
            orderItemsTable.addEventListener('input', handleTableInput);
            
            // أحداث الحقول
            document.addEventListener('input', handleGeneralInput);
            document.addEventListener('click', handleClickEvents);
            
            // أحداث المنتج الجديد
            if (newProductSelect) {
                newProductSelect.addEventListener('change', handleProductChange);
            }
            
            // أحداث الأزرار
            if (addItemBtn) {
                addItemBtn.addEventListener('click', addNewItem);
            }
            if (saveOrderBtn) {
                saveOrderBtn.addEventListener('click', saveOrder);
            }
        }

        function handleTableChange(e) {
            if (e.target.matches('select[name*="[attribute_id]"]')) {
                handleAttributeChange(e.target);
            } else if (e.target.matches('input[name*="[quantity]"], input[name*="[unit_price]"]')) {
                updateRowTotal(e.target.closest('tr'));
            }
        }

        function handleTableInput(e) {
            if (e.target.matches('input[name*="[quantity]"], input[name*="[unit_price]"]')) {
                updateRowTotal(e.target.closest('tr'));
            }
        }

        function handleGeneralInput(e) {
            if (e.target.classList.contains('item-qty') || e.target.classList.contains('item-price')) {
                updateRowTotal(e.target.closest('tr'));
            }
            if (e.target.id === 'shipping_cost' || e.target.id === 'discount') {
                updateSummary();
            }
        }

        function handleClickEvents(e) {
            if (e.target.classList.contains('delete-item-btn')) {
                handleDeleteItem(e);
            }
        }

        // تحديث إجمالي الصف
        function updateRowTotal(row) {
            const qty = parseFloat(row.querySelector('.item-qty')?.value) || 0;
            const price = parseFloat(row.querySelector('.item-price')?.value) || 0;
            const total = qty * price;
            
            const totalCell = row.querySelector('.item-total');
            if (totalCell) {
                totalCell.textContent = total.toFixed(2);
            }
            
            updateSummary();
        }

        // معالجة تغيير السمة
        function handleAttributeChange(selectElement) {
            const row = selectElement.closest('tr');
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const additionalPrice = parseFloat(selectedOption.getAttribute('data-additional_price')) || 0;

            const unitPriceInput = row.querySelector('input[name*="[unit_price]"]');
            if (!unitPriceInput) return;

            let baseUnitPrice = parseFloat(unitPriceInput.getAttribute('data-base-price')) || 
                               parseFloat(unitPriceInput.value) || 0;

            if (!unitPriceInput.hasAttribute('data-base-price')) {
                unitPriceInput.setAttribute('data-base-price', baseUnitPrice);
            }

            const newUnitPrice = baseUnitPrice + additionalPrice;
            unitPriceInput.value = newUnitPrice.toFixed(2);
            updateRowTotal(row);
        }

        // تحديث ملخص الطلب
        function updateSummary() {
            let subTotal = 0;
            let summaryHTML = '';

            document.querySelectorAll('#orderItemsTable tr').forEach(row => {
                const name = row.querySelector('.item-name')?.textContent || '';
                const qty = parseFloat(row.querySelector('.item-qty')?.value) || 0;
                const total = parseFloat(row.querySelector('.item-total')?.textContent) || 0;
                
                subTotal += total;

                if (name) {
                    summaryHTML += `
                    <div class="d-flex justify-content-between">
                        <span>${name} × ${qty}</span>
                        <span>${total.toFixed(2)} د.ج</span>
                    </div>`;
                }
            });

            const discount = parseFloat(discountInput?.value) || 0;
            const shipping = parseFloat(shippingInput?.value) || 0;
            const totalPrice = subTotal - discount + shipping;

            updateSummaryDisplay(subTotal, discount, shipping, totalPrice, summaryHTML);
        }

        function updateSummaryDisplay(subTotal, discount, shipping, totalPrice, summaryHTML) {
            if (summaryItems) summaryItems.innerHTML = summaryHTML;
            
            setElementText('summary_sub_total', subTotal.toFixed(2) + ' د.ج');
            setElementText('summary_discount', discount.toFixed(2) + ' د.ج');
            setElementText('summary_shipping', shipping.toFixed(2) + ' د.ج');
            setElementText('summary_total', totalPrice.toFixed(2) + ' د.ج');
            
            const totalPriceInput = document.getElementById('total_price');
            if (totalPriceInput) totalPriceInput.value = totalPrice.toFixed(2);
        }

        function setElementText(id, text) {
            const element = document.getElementById(id);
            if (element) element.textContent = text;
        }

        // تحديث الإجمالي الكلي
        function updateGrandTotal() {
            let grandTotal = 0;
            document.querySelectorAll('.item-total').forEach(cell => {
                grandTotal += parseFloat(cell.textContent) || 0;
            });
            
            setElementText('grandTotal', grandTotal.toFixed(2));
        }

        // معالجة حذف العنصر
        function handleDeleteItem(e) {
            e.preventDefault();
            const row = e.target.closest('tr');
            const itemId = e.target.dataset.itemId;

            showDeleteConfirmation().then(result => {
                if (result.isConfirmed) {
                    if (!itemId) {
                        removeLocalItem(row);
                    } else {
                        deleteItemFromServer(itemId, row);
                    }
                }
            });
        }

        function showDeleteConfirmation() {
            return Swal.fire({
                title: 'هل أنت متأكد؟',
                text: "سيتم حذف هذا العنصر من الطلب",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'نعم، احذف!',
                cancelButtonText: 'إلغاء'
            });
        }

        function removeLocalItem(row) {
            row.remove();
            showSuccessMessage('تم الحذف', 'تم حذف العنصر من القائمة');
            updateSummary();
        }

        async function deleteItemFromServer(itemId, row) {
            try {
                const response = await fetch(`/supplier-panel/order-item/delete/${itemId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();
                
                if (data.success) {
                    row.remove();
                    showSuccessMessage('تم الحذف', 'تم حذف العنصر من الطلب بنجاح');
                    updateSummary();
                } else {
                    showErrorMessage('خطأ', 'تعذر حذف العنصر');
                }
            } catch (error) {
                showErrorMessage('خطأ', 'تعذر الاتصال بالخادم');
            }
        }

        function showSuccessMessage(title, text) {
            Swal.fire({
                icon: 'success',
                title: title,
                text: text,
                timer: 1500,
                showConfirmButton: false
            });
        }

        function showErrorMessage(title, text) {
            Swal.fire({
                icon: 'error',
                title: title,
                text: text
            });
        }

        // معالجة تغيير المنتج
        async function handleProductChange() {
            const productId = this.value;
            if (!productId) return;

            try {
                const response = await $.ajax({
                    url: `/supplier-panel/product/get-json-data/${productId}`,
                    type: 'GET',
                    dataType: 'json'
                });

                updateProductFields(response.data);
                populateVariationsAndAttributes();
            } catch (error) {
                console.error('Error fetching product data:', error);
            }
        }

        function updateProductFields(product) {
            document.getElementById('new_unit_price').value = product.price;
            document.getElementById('new_quantity').value = product.minimum_order_qty;
            document.getElementById('new_quantity').min = product.minimum_order_qty;
        }

        function populateVariationsAndAttributes() {
            const selected = newProductSelect.options[newProductSelect.selectedIndex];
            const variations = JSON.parse(selected.getAttribute('data-variations') || '[]');
            const attributes = JSON.parse(selected.getAttribute('data-attributes') || '[]');

            populateSelect('new_variation', variations, 'sku', 'id');
            populateSelect('new_attribute', attributes, 'value', 'id', 'additional_price');
            
            setupAttributePriceListener();
        }

        function populateSelect(selectId, items, textKey, valueKey, dataKey = null) {
            const select = document.getElementById(selectId);
            if (!select) return;

            select.innerHTML = '<option value="">بدون</option>';
            
            items.forEach(item => {
                const option = document.createElement('option');
                option.value = item[valueKey];
                option.textContent = item[textKey];
                
                if (dataKey && item[dataKey]) {
                    option.setAttribute(`data-${dataKey}`, item[dataKey]);
                }
                
                select.appendChild(option);
            });
        }

        function setupAttributePriceListener() {
            const attributeSelect = document.getElementById('new_attribute');
            if (!attributeSelect) return;

            attributeSelect.onchange = function() {
                const additionalPrice = parseFloat(this.selectedOptions[0]?.getAttribute('data-additional_price')) || 0;
                const currentPrice = parseFloat(document.getElementById('new_unit_price').value) || 0;
                document.getElementById('new_unit_price').value = (currentPrice + additionalPrice).toFixed(2);
            };
        }

        // إضافة عنصر جديد
        function addNewItem() {
            const productId = document.getElementById('new_product').value;
            if (!productId) {
                alert('يرجى اختيار منتج');
                return;
            }

            const itemData = getNewItemData();
            const newRow = createNewRowHTML(itemData);
            
            orderItemsTable.insertAdjacentHTML('beforeend', newRow);
            updateSummary();
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('addItemModal'));
            if (modal) modal.hide();
        }

        function getNewItemData() {
            return {
                productId: document.getElementById('new_product').value,
                productName: document.getElementById('new_product').selectedOptions[0]?.text || '',
                variationId: document.getElementById('new_variation').value,
                variationName: document.getElementById('new_variation').selectedOptions[0]?.text || '',
                attributeId: document.getElementById('new_attribute').value,
                attributeName: document.getElementById('new_attribute').selectedOptions[0]?.text || '',
                qty: parseFloat(document.getElementById('new_quantity').value) || 1,
                price: parseFloat(document.getElementById('new_unit_price').value) || 0
            };
        }

        function createNewRowHTML(data) {
            const total = (data.qty * data.price).toFixed(2);
            
            return `
            <tr>
                <td class="item-name">${data.productName}</td>
                <td>
                    <select name="new_items[${data.productId}][variation_id]" class="form-select">
                        <option value="">بدون</option>
                        ${data.variationId ? `<option value="${data.variationId}" selected>${data.variationName}</option>` : ''}
                    </select>
                </td>
                <td>
                    <select name="new_items[${data.productId}][attribute_id]" class="form-select">
                        <option value="">بدون</option>
                        ${data.attributeId ? `<option value="${data.attributeId}" selected>${data.attributeName}</option>` : ''}
                    </select>
                </td>
                <td><input type="number" name="new_items[${data.productId}][quantity]" value="${data.qty}" min="1" class="form-control item-qty"></td>
                <td><input type="number" name="new_items[${data.productId}][unit_price]" value="${data.price}" step="0.01" class="form-control item-price"></td>
                <td class="item-total">${total}</td>
                <td><button type="button" class="btn btn-danger btn-sm delete-item-btn"><i class="fas fa-trash"></i></button></td>
            </tr>`;
        }

        // حفظ الطلب
        async function saveOrder() {
            const form = document.getElementById('editOrderForm');
            if (!form) return;

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: new FormData(form)
                });

                const data = await response.json();
                
                if (data.success) {
                    showSuccessMessage('تم الحفظ', 'تم تحديث الطلب بنجاح');
                } else {
                    showErrorMessage('خطأ', 'حدث خطأ أثناء الحفظ');
                }
            } catch (error) {
                console.error('Save error:', error);
                showErrorMessage('خطأ', 'تعذر الاتصال بالخادم');
            }
        }
    });
    //--------------------------

    //---------------------
</script>
