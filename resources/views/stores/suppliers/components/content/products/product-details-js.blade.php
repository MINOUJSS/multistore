<script>
$(document).ready(function() {
//alert(document.getElementById('livewier_qty').innerHTML); 
// Attach a change event to the select element
$('#inputWilaya').on('change', function () {
        // Get the selected value
        var wilaya_id = $(this).val();

        // Call your custom function
        fetchDayra(wilaya_id);
    });
    $('#inputDayra').on('change', function () {
        // Get the selected value
        var dayra_id = $(this).val();

        // Call your custom function
        fetchBaladia(dayra_id);
    });
});
//fetch dayra
function fetchDayra(wilaya_id)
{
    // Set CSRF token for Laravel
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    //
    $.ajax({
                    url: '/get-dayras/'+wilaya_id,
                    method: 'POST',
                    success: function (response) {
                        $('#inputDayra').html(response);
                        $('#inputBaladia').html('<option selected>إختر البلدية...</option><option>...</option>');
                    },
                    error: function (xhr) {
                        console.log(xhr)
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        for (var key in errors) {
                            errorMessage += errors[key][0] + '<br>';
                        }
                       console.log(errorMessage);
                    }
                });
    
}
//fetch dayra
function fetchBaladia(dayra_id)
{
    // Set CSRF token for Laravel
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    //
    $.ajax({
                    url: '/get-baladias/'+dayra_id,
                    method: 'POST',
                    success: function (response) {
                        $('#inputBaladia').html(response);
                    },
                    error: function (xhr) {
                        console.log(xhr)
                        var errors = xhr.responseJSON.errors;
                        var errorMessage = '';
                        for (var key in errors) {
                            errorMessage += errors[key][0] + '<br>';
                        }
                       console.log(errorMessage);
                    }
                });
    
}
function increment_qty(max_qty)  
{
   var qty = parseInt (document.getElementById('livewier_qty').innerHTML);
   if (qty < max_qty)
   {
    qty++;
   }
   document.getElementById('livewier_qty').innerHTML=qty;
}
function decrement_qty(min_qty)  
{
   var qty = parseInt (document.getElementById('livewier_qty').innerHTML);
   if (qty > min_qty)
   {
    qty--;
   }
   document.getElementById('livewier_qty').innerHTML=qty;
}
function countTotalPrice()
{
    //get variables data
    var totalPriceVlue =0;
    var totalPrice =document.getElementById('total_price');
    var formtotalamount=document.getElementById('form_total_amount');
    var b_qty =document.getElementById('qty');
    var hidden_qty=document.getElementById('hidden_qty');
    //var qty=parseInt(document.getElementById('hidden_qty').value);
    qty=parseInt(document.getElementById('livewier_qty').innerHTML);
    b_qty.innerHTML=qty;
    hidden_qty.value=qty;
    var product_price=parseInt(document.getElementById('product_price').innerHTML)
    var shipping=parseInt(document.getElementById('shipping_price').innerHTML);
    // alert(shipping);
    //calculate total price
    totalPriceVlue =(qty * product_price) + shipping;
    //print total price
    totalPrice.innerHTML = totalPriceVlue;
    formtotalamount.value = totalPriceVlue;
}
</script>