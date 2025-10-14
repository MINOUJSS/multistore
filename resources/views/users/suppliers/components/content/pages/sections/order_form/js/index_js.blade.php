<script>
    // order-form-controller.js
document.addEventListener('DOMContentLoaded', function() {
    // Initialize variables
    const unitPrice = 300; // Base product price
    let currentQty = 1;
    let shippingCost = 0;
    let discountAmount = 0;
    let selectedAttributePrice = 0;
    let selectedVariationPrice = 0;
    
    // DOM Elements
    const orderForm = document.getElementById('orderForm');
    const qtyDisplay = document.getElementById('livewier_qty');
    const qtyInput = document.getElementById('hidden_qty');
    const qtyPlusBtn = document.querySelector('.form-btn:first-child');
    const qtyMinusBtn = document.querySelector('.form-btn:last-child');
    const wilayaSelect = document.getElementById('inputWilaya');
    const dayraSelect = document.getElementById('inputDayra');
    const baladiaSelect = document.getElementById('inputBaladia');
    const shippingMethodSection = document.getElementById('shipping_method');
    const showShippingPrice = document.getElementById('show_shipping_price');
    const toHomePrice = document.getElementById('to_home_price');
    const toDesckPrice = document.getElementById('to_desck_price');
    const homeShippingOption = document.getElementById('to_home');
    const deskShippingOption = document.getElementById('to_descktop');
    const homeShippingCard = document.getElementById('card_home');
    const deskShippingCard = document.getElementById('card_descktop');
    const couponInput = document.getElementById('coupon');
    const productAttributes = document.querySelectorAll('input[name="product_attribute"]');
    const productVariations = document.querySelectorAll('input[name="product_varition"]');
    const paymentMethods = document.querySelectorAll('input[name="payment_method"]');
    
    // Summary elements
    const qtySummary = document.getElementById('qty');
    const unitPriceSummary = document.getElementById('unit_price');
    const subTotalSummary = document.getElementById('sub_total');
    const shippingPriceSummary = document.getElementById('shipping_price');
    const discountSummary = document.getElementById('discount');
    const totalPriceSummary = document.getElementById('total_price');
    
    // Initialize form
    initForm();
    
    function initForm() {
        // Set up event listeners
        setupEventListeners();
        
        // Calculate initial totals
        calculateTotals();
    }
    
    function setupEventListeners() {
        // Quantity controls
        qtyPlusBtn.addEventListener('click', increaseQuantity);
        qtyMinusBtn.addEventListener('click', decreaseQuantity);
        
        // Location selection
        wilayaSelect.addEventListener('change', handleWilayaChange);
        dayraSelect.addEventListener('change', handleDayraChange);
        baladiaSelect.addEventListener('change', handleBaladiaChange);
        
        // Shipping method selection
        homeShippingCard.addEventListener('click', () => {
            homeShippingOption.checked = true;
            updateShippingSelection();
            calculateTotals();
        });
        
        deskShippingCard.addEventListener('click', () => {
            deskShippingOption.checked = true;
            updateShippingSelection();
            calculateTotals();
        });
        
        // Coupon code
        couponInput.addEventListener('blur', applyCoupon);
        
        // Product attributes and variations
        productAttributes.forEach(attr => {
            attr.addEventListener('change', handleAttributeChange);
        });
        
        productVariations.forEach(variation => {
            variation.addEventListener('change', handleVariationChange);
        });
        
        // Payment methods
        paymentMethods.forEach(method => {
            method.addEventListener('change', updatePaymentMethodSelection);
        });
    }
    
    function increaseQuantity() {
        currentQty++;
        updateQuantityDisplay();
        calculateTotals();
    }
    
    function decreaseQuantity() {
        if (currentQty > 1) {
            currentQty--;
            updateQuantityDisplay();
            calculateTotals();
        }
    }
    
    function updateQuantityDisplay() {
        qtyDisplay.textContent = currentQty;
        qtyInput.value = currentQty;
        qtySummary.textContent = currentQty;
    }
    
    function handleWilayaChange() {
        const wilayaId = wilayaSelect.value;
        
        // Reset dependent selects
        dayraSelect.innerHTML = '<option value="0" selected>إختر الدائرة...</option>';
        baladiaSelect.innerHTML = '<option value="0" selected>إختر البلدية...</option>';
        
        if (wilayaId !== "0") {
            // In a real implementation, you would fetch data based on the selected wilaya
            // For demo purposes, we'll simulate some data
            simulateWilayaData(wilayaId);
            
            // Show shipping options
            shippingMethodSection.style.display = 'flex';
            showShippingPrice.textContent = 'إختر طريقة التوصيل';
            
            // Set default shipping method
            homeShippingOption.checked = true;
            updateShippingSelection();
        } else {
            // Hide shipping options if no wilaya selected
            shippingMethodSection.style.display = 'none';
            showShippingPrice.textContent = 'إختر الولاية';
            shippingCost = 0;
        }
        
        calculateTotals();
    }
    
    function handleDayraChange() {
        const dayraId = dayraSelect.value;
        
        // Reset baladia select
        baladiaSelect.innerHTML = '<option value="0" selected>إختر البلدية...</option>';
        
        if (dayraId !== "0") {
            // In a real implementation, you would fetch data based on the selected dayra
            simulateDayraData(dayraId);
        }
        
        updateShippingCost();
        calculateTotals();
    }
    
    function handleBaladiaChange() {
        const baladiaId = baladiaSelect.value;
        
        if (baladiaId !== "0") {
            updateShippingCost();
            calculateTotals();
        }
    }
    
    function simulateWilayaData(wilayaId) {
        // Simulate fetching dayras for the selected wilaya
        // In a real implementation, you would make an AJAX request to your server
        
        // Clear previous options
        dayraSelect.innerHTML = '<option value="0" selected>إختر الدائرة...</option>';
        
        // Add sample options based on wilaya
        const dayras = [
            {id: 1, name: 'دائرة 1'},
            {id: 2, name: 'دائرة 2'},
            {id: 3, name: 'دائرة 3'}
        ];
        
        dayras.forEach(dayra => {
            const option = document.createElement('option');
            option.value = dayra.id;
            option.textContent = dayra.name;
            dayraSelect.appendChild(option);
        });
        
        // Set initial shipping cost based on wilaya
        // In a real implementation, this would come from your database
        const homeShippingPrice = wilayaId * 200 + 400; // Example calculation
        const deskShippingPrice = wilayaId * 100 + 200; // Example calculation
        
        toHomePrice.textContent = homeShippingPrice;
        toDesckPrice.textContent = deskShippingPrice;
    }
    
    function simulateDayraData(dayraId) {
        // Simulate fetching baladias for the selected dayra
        // In a real implementation, you would make an AJAX request to your server
        
        // Clear previous options
        baladiaSelect.innerHTML = '<option value="0" selected>إختر البلدية...</option>';
        
        // Add sample options based on dayra
        const baladias = [
            {id: 1, name: 'بلدية 1'},
            {id: 2, name: 'بلدية 2'},
            {id: 3, name: 'بلدية 3'}
        ];
        
        baladias.forEach(baladia => {
            const option = document.createElement('option');
            option.value = baladia.id;
            option.textContent = baladia.name;
            baladiaSelect.appendChild(option);
        });
    }
    
    function updateShippingCost() {
        // In a real implementation, you would calculate shipping cost based on
        // the selected wilaya, dayra, and baladia
        
        const wilayaId = wilayaSelect.value;
        const dayraId = dayraSelect.value;
        const baladiaId = baladiaSelect.value;
        
        if (wilayaId !== "0" && dayraId !== "0" && baladiaId !== "0") {
            // Calculate shipping cost based on location
            // This is just a sample calculation
            const baseHomeCost = parseInt(toHomePrice.textContent);
            const baseDeskCost = parseInt(toDesckPrice.textContent);
            
            // Adjust based on dayra and baladia (sample adjustment)
            const homeCost = baseHomeCost + (dayraId * 50) + (baladiaId * 25);
            const deskCost = baseDeskCost + (dayraId * 25) + (baladiaId * 10);
            
            toHomePrice.textContent = homeCost;
            toDesckPrice.textContent = deskCost;
            
            // Update current shipping cost based on selected method
            if (homeShippingOption.checked) {
                shippingCost = homeCost;
            } else {
                shippingCost = deskCost;
            }
            
            showShippingPrice.textContent = `${shippingCost} د.ج`;
        }
    }
    
    function updateShippingSelection() {
        // Update visual selection for shipping methods
        if (homeShippingOption.checked) {
            homeShippingCard.classList.add('selected-shipping');
            deskShippingCard.classList.remove('selected-shipping');
            shippingCost = parseInt(toHomePrice.textContent);
        } else {
            deskShippingCard.classList.add('selected-shipping');
            homeShippingCard.classList.remove('selected-shipping');
            shippingCost = parseInt(toDesckPrice.textContent);
        }
        
        showShippingPrice.textContent = `${shippingCost} د.ج`;
    }
    
    function applyCoupon() {
        const couponCode = couponInput.value.trim();
        
        if (couponCode) {
            // In a real implementation, you would validate the coupon with your server
            // For demo purposes, we'll simulate a 10% discount for coupon "SAVE10"
            if (couponCode === 'SAVE10') {
                discountAmount = (unitPrice + selectedAttributePrice + selectedVariationPrice) * currentQty * 0.1;
                alert('تم تطبيق كود الخصم بنجاح!');
            } else {
                discountAmount = 0;
                alert('كود الخصم غير صالح');
            }
        } else {
            discountAmount = 0;
        }
        
        calculateTotals();
    }
    
    function handleAttributeChange(event) {
        // Get additional price from data attribute
        selectedAttributePrice = parseInt(event.target.getAttribute('data-aditional-price')) || 0;
        calculateTotals();
    }
    
    function handleVariationChange(event) {
        // In a real implementation, you would fetch variation price from your data
        // For demo, we'll use a fixed value
        selectedVariationPrice = 0; // Reset first
        selectedVariationPrice = 50; // Example additional cost for variation
        calculateTotals();
    }
    
    function updatePaymentMethodSelection() {
        // Visual feedback for selected payment method
        document.querySelectorAll('.payment-option').forEach(option => {
            option.classList.remove('selected-payment');
        });
        
        document.querySelectorAll('input[name="payment_method"]:checked').forEach(checked => {
            checked.closest('.payment-option').classList.add('selected-payment');
        });
    }
    
    function calculateTotals() {
        // Calculate product total
        const productTotal = (unitPrice + selectedAttributePrice + selectedVariationPrice) * currentQty;
        
        // Calculate final total
        const finalTotal = productTotal + shippingCost - discountAmount;
        
        // Update summary display
        unitPriceSummary.textContent = (unitPrice + selectedAttributePrice + selectedVariationPrice).toFixed(2);
        subTotalSummary.textContent = productTotal.toFixed(2);
        shippingPriceSummary.textContent = shippingCost.toFixed(2);
        discountSummary.textContent = discountAmount.toFixed(2);
        totalPriceSummary.textContent = finalTotal.toFixed(2);
        totalPriceSummary.setAttribute('data-totalprice', finalTotal);
    }
    
    // Add some CSS for visual feedback
    const style = document.createElement('style');
    style.textContent = `
        .selected-shipping {
            border-color: #0d6efd !important;
            background-color: rgba(13, 110, 253, 0.1);
        }
        
        .option-card {
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .option-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        
        .selected-payment .payment-label {
            border-color: #0d6efd;
            background-color: rgba(13, 110, 253, 0.1);
        }
        
        .payment-label {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            padding: 10px;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .payment-label:hover {
            border-color: #adb5bd;
        }
    `;
    document.head.appendChild(style);
});
</script>