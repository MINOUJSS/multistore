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
            //    console.log(response);
               $('#inputDayra').html(response);
               $('#inputBaladia').html('<option value="0" selected>إختر البلدية...</option value="0"><option>...</option>');
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
    var wilaya_id=document.getElementById('inputWilaya').value;
    var dayra_id=document.getElementById('inputDayra').value;
    var baladia_id=document.getElementById('inputBaladia').value;
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
                        // console.log(response);
                        $('#inputBaladia').html(response);
                        get_additional_price(wilaya_id,dayra_id,baladia_id)
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
    var unit_price = parseFloat(document.getElementById('unit_price').innerHTML);
   var qty = parseInt (document.getElementById('livewier_qty').innerHTML);
   if (qty < max_qty)
   {
    qty++;
   }
   document.getElementById('livewier_qty').innerHTML=qty;
   document.getElementById('cart_qty').value=qty;
   document.getElementById('sub_total').innerHTML=qty*unit_price;
}
function decrement_qty(min_qty)  
{
     var unit_price = parseFloat(document.getElementById('unit_price').innerHTML);
   var qty = parseInt (document.getElementById('livewier_qty').innerHTML);
   if (qty > min_qty)
   {
    qty--;
   }
   document.getElementById('livewier_qty').innerHTML=qty;
   document.getElementById('cart_qty').value=qty;
   document.getElementById('sub_total').innerHTML=qty*unit_price;
}
function countTotalPrice()
{
    //get variables data
    var totalPriceVlue =0;
    var totalPrice =document.getElementById('total_price');
    // var formtotalamount=document.getElementById('form_total_amount');
    var b_qty =document.getElementById('qty');
    var hidden_qty=document.getElementById('hidden_qty');
    //var qty=parseFloat(document.getElementById('hidden_qty').value);
    var sub_total=document.getElementById('sub_total');
    qty=parseInt(document.getElementById('livewier_qty').innerHTML);
    b_qty.innerHTML=qty;
    hidden_qty.value=qty;
    var product_price=parseFloat(document.getElementById('product_price').innerHTML).toFixed(2);
    var shipping=parseFloat(document.getElementById('shipping_price').innerHTML).toFixed(2);
    var discount=parseFloat(document.getElementById('discount').innerHTML).toFixed(2);
    // console.log(parseFloat((qty * parseFloat(product_price)) + parseFloat(shipping)).toFixed(2));
    // alert(shipping);
    //calculate total price
    sub_total.innerHTML=parseFloat(qty * parseFloat(product_price)).toFixed(2);
    totalPriceVlue =parseFloat(((qty * parseFloat(product_price)) + parseFloat(shipping))-parseFloat(discount)).toFixed(2);
    //print total price
    totalPrice.innerHTML = totalPriceVlue+' <sup>د.ج</sup>';
    totalPrice.setAttribute('data-totalprice', totalPriceVlue);
    // formtotalamount.value = totalPriceVlue;
}
//
function selectOption(option) {
        // إزالة التمييز من جميع البطاقات
        document.querySelectorAll('.option-card').forEach(card => {
            card.classList.remove('border-primary', 'shadow-sm');
        });

        // إضافة التمييز للعنصر المختار
        document.getElementById(`card_${option}`).classList.add('border-primary', 'shadow-sm');

        // تحديد الراديو المختار
        document.getElementById(`to_${option}`).checked = true;
    }

    // تعيين التمييز عند تحميل الصفحة بناءً على القيمة المحفوظة
    document.addEventListener("DOMContentLoaded", function() {
        let selected = document.querySelector('input[name="shipping_and_point"]:checked').value;
        selectOption(selected);
    });
    //
    @if($product->free_shipping==='no')
    async function show_shipping_prices(wilaya_id) {
    try {
        // إرسال الطلب وجلب بيانات الأسعار
        let response = await $.post('/get-shipping-prices/' + wilaya_id, {
            _token: $('meta[name="csrf-token"]').attr('content') // تضمين CSRF
        });

        // التحقق من أن البيانات المسترجعة صحيحة
        if (!response || !response.prices) {
            console.error("لم يتم العثور على بيانات الأسعار.");
            return;
        }

        let { to_home_price, stop_desck_price, additional_price } = response.prices;


        // تحديث أسعار التوصيل
        $('#to_home_price, #shipping_price').html(`${to_home_price} `);
        $('#show_shipping_price').html(`${to_home_price} <sup>د.ج</sup>`)
        $('#to_desck_price').html(`${stop_desck_price} `);

        // تحديث السعر الإجمالي
        countTotalPrice();

        // تحديد التوصيل للمنزل تلقائيًا
        selectOption('home');

        // عرض محتوى التوصيل
        let shipping_box = document.getElementById('shipping_method');
        if (shipping_box) {
            shipping_box.style.display = 'block';
        }

    } catch (error) {
        console.error("حدث خطأ أثناء جلب بيانات الشحن:", error);
    }
}
@endif
    // function show_shipping_prices(wilaya_id) {
    //     //الإستعلام عن أسعار التوصيل في هذه الولاية
    //     // Set CSRF token for Laravel
    //                 $.ajaxSetup({
    //                             headers: {
    //                                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                             }
    //                         });
    //                 //
    //                 $.ajax({
    //                 url: '/get-shipping-prices/'+wilaya_id,
    //                 method: 'POST',
    //                 success: function (response) {
    //                     var prices=response.prices;
    //                     var to_home=prices.to_home_price;
    //                     var to_desck=prices.stop_desck_price;
    //                     var additionel_price=prices.additional_price;
    //                     // var to_home_html = (Number(to_home) + Number(additionel_price));
    //                     var to_home_html = to_home;
    //                     var to_desck_html=to_desck;
    //                     // console.log(prices);
    //                     $('#to_home_price').html(to_home_html);
    //                     $('#show_shipping_price').html(to_home_html+' <sup>د.ج</sup>');
    //                     $('#shipping_price').html(to_home_html);
    //                     $('#to_desck_price').html(to_desck_html);
 
    //                     countTotalPrice();
    //                     //select to_home automatiquely
    //                     selectOption('home');
    //                     // $('#inputBaladia').html('<option selected>إختر البلدية...</option><option>...</option>');
    //                 },
    //                 error: function (xhr) {
    //                     console.log(xhr);
    //                 //     var errors = xhr.responseJSON.errors;
    //                 //     var errorMessage = '';
    //                 //     for (var key in errors) {
    //                 //         errorMessage += errors[key][0] + '<br>';
    //                 //     }
    //                 //    console.log(errorMessage);
    //                 }
    //             });
    //     //عرض محتوى التوصيل
    // let shipping_box = document.getElementById('shipping_method');
    // if (shipping_box) {
    //     shipping_box.style.display = 'block'; // إظهار العنصر
    // }
    // }
    //get additional price
    // function get_additional_price(wilaya_id,dayra_id,baladia_id)
    // {
    //     //الإستعلام عن أسعار التوصيل في هذه الولاية
    //     // Set CSRF token for Laravel
    //     $.ajaxSetup({
    //                             headers: {
    //                                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                             }
    //                         });
    //                 //
    //                 $.ajax({
    //                 url: '/get-shipping-prices/'+wilaya_id,
    //                 method: 'POST',
    //                 success: function (response) {
    //                     var prices=response.prices;
    //                     var to_home=prices.to_home_price;
    //                     var to_desck=prices.stop_desck_price;
    //                     var additionel_price=prices.additional_price;
    //                     if(dayra_id==0 && baladia_id==0)
    //                     {
    //                         var to_home_html =parseFloat(to_home).toFixed(2);
    //                     }else
    //                     {
    //                         // var  to_home_html = (Number(to_home) + Number(additionel_price));
    //                         //------start-----------
    //                         get_wilaya_data(wilaya_id).then(function(wilaya_data) {
    //                         get_dayra_data(dayra_id).then(function(dayra_data) {
    //                         let dayra_name = dayra_data.dayra.ar_name;
    //                         let wilaya_name = wilaya_data.wilaya.ar_name; 
    //                         // console.log(wilaya_name,dayra_name);
    //                         if(wilaya_name === dayra_name)
    //                         {
    //                             var to_home_html = parseFloat(to_home).toFixed(2);
    //                             $('#to_home_price').html(to_home_html);
    //                             $('#show_shipping_price').html(to_home_html+' <sup>د.ج</sup>');
    //                             $('#shipping_price').html(to_home_html);
    //                             countTotalPrice();
    //                         }
    //                         else
    //                         {
    //                            var  to_home_html = parseFloat(parseFloat(to_home)+parseFloat(additionel_price)).toFixed(2);
    //                             $('#to_home_price').html(to_home_html);
    //                             $('#show_shipping_price').html(to_home_html+' <sup>د.ج</sup>');
    //                             $('#shipping_price').html(to_home_html); 
    //                             countTotalPrice();
    //                         }                  
    //                         }).catch(function(error) {
    //                             console.log("حدث خطأ:", error);
    //                         });
                                                    
    //                         }).catch(function(error) {
    //                             console.log("حدث خطأ:", error);
    //                         });
    //                         //--------end-----------
                           
    //                     }
    //                     var to_desck_html=to_desck;
    //                     // console.log(prices);
    //                     $('#to_home_price').html(to_home_html);
    //                     $('#show_shipping_price').html(to_home_html+' <sup>د.ج</sup>');
    //                     $('#shipping_price').html(to_home_html);
    //                     $('#to_desck_price').html(to_desck_html);
 
    //                     countTotalPrice();
    //                     //select to_home automatiquely
    //                     selectOption('home');
    //                     // $('#inputBaladia').html('<option selected>إختر البلدية...</option><option>...</option>');
    //                 },
    //                 error: function (xhr) {
    //                     console.log(xhr);
    //                 //     var errors = xhr.responseJSON.errors;
    //                 //     var errorMessage = '';
    //                 //     for (var key in errors) {
    //                 //         errorMessage += errors[key][0] + '<br>';
    //                 //     }
    //                 //    console.log(errorMessage);
    //                 }
    //             });
    // }
    @if($product->free_shipping==='no')
    async function get_additional_price(wilaya_id, dayra_id, baladia_id) {
    try {
        // إعداد التوكن لـ Laravel CSRF
        $.ajaxSetup({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
        });

        // جلب بيانات أسعار الشحن
        const response = await $.ajax({
            url: `/get-shipping-prices/${wilaya_id}`,
            method: 'POST'
        });

        let prices = response.prices;
        let to_home = parseFloat(prices.to_home_price);
        let to_desck = parseFloat(prices.stop_desck_price);
        let additionel_price = parseFloat(prices.additional_price);

        let to_home_html;

        if (dayra_id == 0 && baladia_id == 0) {
            to_home_html = to_home.toFixed(2);
        } else {
            try {
                let wilaya_data = await get_wilaya_data(wilaya_id);
                let dayra_data = await get_dayra_data(dayra_id);

                let wilaya_name = wilaya_data.wilaya.ar_name;
                let dayra_name = dayra_data.dayra.ar_name;

                // إذا كانت الولاية هي نفسها الدائرة، لا يتم إضافة سعر إضافي
                to_home_html = (wilaya_name === dayra_name) ? to_home.toFixed(2) :
                    (to_home + additionel_price).toFixed(2);
            } catch (error) {
                console.log("حدث خطأ أثناء جلب بيانات الولاية أو الدائرة:", error);
                to_home_html = (to_home + additionel_price).toFixed(2);
            }
        }

        // تحديث أسعار الشحن في الواجهة
        updatePrices(to_home_html, to_desck);

    } catch (error) {
        console.log("حدث خطأ أثناء جلب أسعار الشحن:", error);
    }
}
@endif

// تحديث الأسعار في واجهة المستخدم
function updatePrices(to_home_price, to_desck_price) {
    $('#to_home_price').html(to_home_price);
    $('#show_shipping_price').html(`${to_home_price} <sup>د.ج</sup>`);
    $('#shipping_price').html(to_home_price);
    $('#to_desck_price').html(to_desck_price.toFixed(2));

    countTotalPrice();
    selectOption('home'); // تحديد خيار التوصيل للمنزل تلقائيًا
}

    //show to desck price
    function show_to_desck_price()
    {
        var to_desck_price=document.getElementById('to_desck_price').innerHTML;
        $('#show_shipping_price').html('');
        $('#show_shipping_price').html(to_desck_price+' <sup>د.ج</sup>');
        $('#shipping_price').html(to_desck_price);
    }
    //show to home price
    function show_to_home_price()
    {
        var to_home_price=document.getElementById('to_home_price').innerHTML;
        $('#show_shipping_price').html('');
        $('#show_shipping_price').html(to_home_price+' <sup>د.ج</sup>');
        $('#shipping_price').html(to_home_price);
    } 
    
    //get wilaya data
        function get_wilaya_data(wilaya_id) {
        return new Promise((resolve, reject) => {
            // Set CSRF token for Laravel
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/get-wilaya-data/' + wilaya_id,
                method: 'POST',
                success: function(response) {
                    resolve(response); // إرجاع البيانات عند نجاح الطلب
                },
                error: function(xhr) {
                    reject(xhr); // إرجاع الخطأ عند فشل الطلب
                }
            });
        });
    }
    // function get_wilaya_data(wilaya_id)
    // {
    //     // Set CSRF token for Laravel
    //     $.ajaxSetup({
    //                 headers: {
    //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                 }
    //             });
    //     //
    //     $.ajax({
    //     url: '/get-wilaya-data/'+wilaya_id,
    //     method: 'POST',
    //     success: function (response) {
    //     //    console.log(response);
          
    //     },
    //     error: function (xhr) {
    //         console.log(xhr);

    //     }
    //    });
    // }

    //get dayra data
    function get_dayra_data(dayra_id) {
        return new Promise((resolve, reject) => {
            // Set CSRF token for Laravel
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/get-dayra-data/' + dayra_id,
                method: 'POST',
                success: function(response) {
                    resolve(response); // إرجاع البيانات عند نجاح الطلب
                },
                error: function(xhr) {
                    reject(xhr); // إرجاع الخطأ عند فشل الطلب
                }
            });
        });
    }
    // function get_dayra_data(dayra_id)
    // {
    //     // Set CSRF token for Laravel
    //     $.ajaxSetup({
    //                 headers: {
    //                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //                 }
    //             });
    //     //
    //     $.ajax({
    //     url: '/get-dayra-data/'+dayra_id,
    //     method: 'POST',
    //     success: function (response) {
    //         console.log(response);
    //         // return response;
            
    //     },
    //     error: function (xhr) {
    //         console.log(xhr);

    //     }
    //    });
    // }
    function create_abandoned_order() {
    // الحصول على بيانات الفورم
    let formData = new FormData(document.getElementById("orderForm"));

    // إعداد `CSRF Token` لـ Laravel
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
        }
    });

    // إرسال الطلب عبر `AJAX`
    $.ajax({
        url: "/order-abandoned", // تعديل الرابط حسب `Route` المناسب
        method: "POST",
        data: formData,
        processData: false, // عدم معالجة البيانات تلقائيًا
        contentType: false, // عدم تعيين نوع `Content-Type` تلقائيًا
        success: function (response) {
            console.log("تم تسجيل الطلب المتروك بنجاح", response);
        },
        error: function (xhr) {
            console.error("خطأ أثناء إنشاء الطلب المتروك:", xhr.responseText);
        }
    });
}
//
function get_varition_id($element)
{
    var varition_id = $($element).val();
    document.getElementById('variation_id').value=varition_id;
}
//
function get_attribute_id($element)
{
    var attribute_id = $($element).val();
    document.getElementById('attribute_id').value=attribute_id;
}

// Add additional price to product price
function add_additional_price_to_product_price(element) {
    // Get additional price (parse as float for arithmetic)
    var additionalPrice = parseFloat(element.getAttribute('data-aditional-price')) || 0;
    //get unit price
    var unit_price = parseFloat(element.getAttribute('data-unit-price')) || 0;
    
    // Get current product price (parse as float)
    var productPriceElement = document.getElementById('product_price');
    var bottomProductPriceElement = document.getElementById('unit_price');
    // var productPrice = parseFloat(productPriceElement.textContent) || 0;

    // Calculate new price (addition)
    var newPrice = unit_price + additionalPrice;

    // Update the displayed price (format if needed)
    productPriceElement.textContent = newPrice.toFixed(2); // Shows 2 decimal places
    bottomProductPriceElement.textContent = newPrice.toFixed(2);
    //
    countTotalPrice()
}

</script>