<script>
    function returnToForm(id)
    {
        // document.addEventListener("DOMContentLoaded", function () {
        let form = id; // تأكد من تعريف المتغير قبل استخدامه
        let buttonHtml = "";

        if (form === "editForm") {
            buttonHtml = `<button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#editModal" aria-label="Close"></button>`;
        } else {
            buttonHtml = `<button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#addModal" aria-label="Close"></button>`;
        }

        document.getElementById("modalButtonContainer").innerHTML = buttonHtml;
        // });
    }
    //clear validation errors
    function ClearValidationErrors()
    {
        // Clear previous errors
        $('.error-validation').text('');
        //clear images container
        // add_container=document.querySelector('.images_container'),
        // add_container.innerHTML='';
    }

    //on click on save btn
    $('#save_product').on('click', function(e){
            e.preventDefault();
            //clear validation errors
            ClearValidationErrors()
            //get product description from editor
            var add_content = add_quill.root.innerHTML;
            //set content empty
            if ($.trim(add_content) === "<p><br></p>") {
            add_content = "";
            }
            document.getElementById('add_product_description').value=add_content;
            // Validate variations
            var isValid = true;
            $(".variation-required").each(function () {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).next(".text-danger").text("هذا الحقل مطلوب.");
                }
            });

            // Validate discounts
            $(".discount-required").each(function () {
                if (!$(this).val()) {
                    isValid = false;
                    $(this).next(".text-danger").text("هذا الحقل مطلوب.");
                }
            });
            // Get form data
            // var product_id=document.getElementById('product_id').value;
            //get form data
            var formData = new FormData($('#addForm')[0]); // يشمل الحقول والملفات
            // Show loader and disable save button
        $('#save_product').prop('disabled', true).text('جاري الحفظ...');
            // Send AJAX request
            // if (isValid) {
            $.ajax({
                url: '/supplier-panel/product/create',
                type: 'POST',
                data: formData,
                processData: false, // تعطيل معالجة البيانات
                contentType: false, // تعطيل تعيين Content-Type للسماح برفع الملفات
                success: function (response) {
                    console.log(response);
                    $('#addModal').modal('hide');
                    //refresh page
                    location.reload(true);
                    //alert success message
                    Swal.fire({
                            icon: 'success', // Type of alert (success, error, info, warning)
                            title: 'تم إضافة المنتج بنجاح !', // Title of the alert
                            // text: 'تم تعديل المنتج بنجاح، يمكنك الآن العودة إلى الصفحة الرئيسية.', // Text under the title
                            showConfirmButton: true, // Whether to show the confirm button
                            confirmButtonText: 'حسناً', // Text of the confirm button
                            confirmButtonColor: '#a40c72', // Color of the confirm button
                        });

                    //end alert success
                },
                error: function (xhr) {
                    $('#save_product').prop('disabled', false).text('حفظ');
                    //console.log(xhr.responseText);
                    // var errorsDiv = document.getElementById('editFormErrors');
                            if (xhr.status === 422) {
                            // Display validation errors
                            var errors = xhr.responseJSON.errors;
                            console.log(errors);
                            $.each(errors, function (key, value) {
                                // errorsDiv.append(value[0]);
                                $('.error-' + key).text(value[0]);
                            });

                        } else {
                            console.log(xhr);
                            $('#addModal').modal('hide');
                            Swal.fire({
                                    icon: 'error', // Type of alert (error, success, warning, info)
                                    title: 'حدث خطأ !', // Title of the alert
                                    text: 'تعذر إضافة المنتج، يرجى المحاولة مرة أخرى.', // Additional text
                                    showConfirmButton: true, // Whether to show the confirm button
                                    confirmButtonText: 'موافق', // Text of the confirm button
                                    confirmButtonColor: '#a40c72', // Color of the confirm button
                                });
                                //refresh page
                                // location.reload(true);
                        }
                }
            });

        });
//----------------------------------------------------------------
         // on click on add_varition_product
    $("#add_add_variation").click(function(){
        var add_product_variation = document.getElementById("add_product_variation");
        var filesHtml = '<div class="add_variation_container border position-relative p-3 mt-3 mb-3 row">' +
            '<div class="col-6">' +
            '<label for="inputSku" class="form-label">اسم المنتج مع اللون و المقاس..</label>' +
            '<input type="text" class="form-control variation-required" name="add_product_sku[]" placeholder="مثال:T-Shirt-Red-Siz-XXL">' +
            '<span class="text-danger error-add_product_sku error-validation"></span>' +
            '</div>' +
            '<div class="col-3">' +
            '<label for="inputColor" class="form-label">لون المنتج</label>' +
            '<input type="color" class="form-control form-control-color variation-required" name="add_product_color[]">' +
            '<span class="text-danger error-add_product_color error-validation"></span>' +
            '</div>' +
            '<div class="col-3">' +
            '<label for="inputSize" class="form-label">المقاس المنتج</label>' +
            '<input type="text" name="add_product_size[]" class="form-control variation-required">' +
            '<span class="text-danger error-product_size error-add_validation"></span>' +
            '</div>' +
            '<div class="col-3">' +
            '<label for="inputWeight" class="form-label">وزن المنتج</label>' +
            '<input type="text" name="add_product_weight[]" class="form-control variation-required">' +
            '<span class="text-danger error-add_product_weight error-validation"></span>' +
            '</div>' +
            '<div class="col-3">' +
            '<label for="inputAddPrice" class="form-label">السعر الإضافي</label>' +
            '<input type="number" name="add_product_variation_add_price[]" class="form-control variation-required">' +
            '<span class="text-danger error-add_product_variation_add_price error-validation"></span>' +
            '</div>' +
            '<div class="col-3">' +
            '<label for="inputStock" class="form-label">الكمية في المخزن</label>' +
            '<input type="number" name="add_product_variation_stock[]" class="form-control variation-required">' +
            '<span class="text-danger error-add_product_variation_stock error-validation"></span>' +
            '</div>' +
            '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2 add_remove_variation" style="width:30px;cursor:pointer">X</span>' +
            '</div>';
            $(add_product_variation).append(filesHtml);
            });
         // On click remove_variation
         $(add_product_variation).on('click', '.add_remove_variation', function (e) {
          e.preventDefault();
          $(this).closest('.add_variation_container').remove();
          });
//----------------------------------------------------------------
          //on click add attributes btn   
    $('#add_add_attribute').on('click', function(){
        //hide add attribute btn
        //$('#add_attribute').hide();
        // variables
        var add_product_attribute = document.getElementById("add_product_attribute");
         var filesHtml = '<div class="add_attribute_container border position-relative p-3 mt-3 mb-3 row">'
                          +'<div class="col-6">'
                          +'<label for="inputSku" class="form-label">إختر الخاصية</label>'
                          +'<select class="form-select add_porduct_attribute" name="add_porduct_attribute[]" id="add_porduct_attribute"></select>'
                          +'</div>'
                          +'<div class="col-3">'
                          +'<label for="inputColor" class="form-label">قيمة الخاصية</label>'
                          +'<input class="form-control" type="text" name="add_attribute_value[]" id="add_attribute_value" required>'
                          +'</div>'
                          +'<div class="col-3">'
                          +'<label for="inputSize" class="form-label">السعر الإضافي</label>'
                          +'<input class="form-control" type="number" class="form-control" min="0" name="add_atrribute_add_price[]" id="add_atrribute_add_price" value="0">'
                          +'</div>'
                          +'<div class="col-3">'
                          +'<label for="inputAddPrice" class="form-label">الكمية  في المخزن</label>'
                          +'<input type="number" class="form-control" min="0" name="add_attribute_stock_qty[]" id="add_attribute_stock_qty" value="0">'
                          +'</div>'
                          +'<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2 add_remove_attribute" style="width:30px;cursor:pointer">X</span>'
                          +'</div>';
        // print the html code
          $(add_product_attribute).append(filesHtml)
        //send ajax request to get product attribute       
        get_product_attribute({{auth()->user()->id}})
    });

    // On click remove_atrribute
    $(add_product_attribute).on('click', '.add_remove_attribute', function (e) {
            e.preventDefault();
            // $("#add_attribute").show();
            $(this).closest('.add_attribute_container').remove();
        });

    //functions
    function get_product_attribute(user_id)
    {
         // Set CSRF token for Laravel
            $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
        $.ajax({
            url:'/supplier-panel/attributes/user/'+user_id,
            type:'POST',
            success: function(response)
            {
                console.log(response.attributes);
                var add_product_attribute = document.getElementsByClassName("add_product_attribute");
                response.attributes.forEach(e => {
                    var filesHtml ='<option value="'+e.id+'">'+e.name+'</option>';
                    $(add_porduct_attribute).append(filesHtml);
                });
            },
            error:function(xhr)
            {
                console.log(xhr);
            }
        });
    }
//----------------------------------------------------------------
function add_add_discount(){
        $("#add_add_discount").hide();
        var add_product_discount = document.getElementById("add_product_discount");
        var filesHtml = '<div id="add_discount_container" class="add_discount_container border position-relative p-3 mt-3 mb-3 row">' +
            '<div class="col-3">' +
            '<label for="add_discount_amount" class="form-label">السعر الجديد</label>' +
            '<input value="0" id="add_discount_amount" name="add_discount_amount" type="number" class="form-control discount-required" onchange="add_calc_discount_percentage();" min="0">' +
            '<span class="text-danger error-add_discount_amount error-validation"></span>' +
            '</div>' +
            '<div class="col-3">' +
            '<label for="add_discount_percentage" class="form-label">نسبة التخفيض</label>' +
            '<input value="100" id="add_discount_percentage" name="add_discount_percentage" type="text" class="form-control discount-required" onchange="add_calc_discount_amount();" max="100">' +
            '<span class="text-danger error-add_discount_percentage error-validation"></span>' +
            '</div>' +
            '<div class="col-3">' +
            '<label for="add_discount_start_date" class="form-label">تاريخ بداية التخفيض</label>' +
            '<input name="add_discount_start_date" type="date" class="form-control discount-required" value="'+new Date().toISOString().split('T')[0]+'">' +
            '<span class="text-danger error-add_discount_start_date error-validation"></span>' +
            '</div>' +
            '<div class="col-3">' +
            '<label for="add_discount_end_date" class="form-label">تاريخ نهاية التخفيض</label>' +
            '<input name="add_discount_end_date" type="date" class="form-control discount-required" value="'+new Date().toISOString().split('T')[0]+'">' +
            '<span class="text-danger error-add_discount_end_date error-validation"></span>' +
            '</div>' +
            '<div class="form-check form-switch">' +
            '<input class="form-check-input" name="add_discount_status" type="checkbox" checked>' +
            '<label class="form-check-label" for="flexSwitchCheckChecked">مفعل</label>' +
            '</div>' +
            '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2 add_remove_discount" style="width:30px;cursor:pointer">X</span>' +
            '</div>';
        $(add_product_discount).append(filesHtml);
    };
    //});
        // On click remove_discount
        $(add_product_discount).on('click', '.add_remove_discount', function (e) {
            e.preventDefault();
            $("#add_add_discount").show();
            $(this).closest('.add_discount_container').remove();
        });
        
        // calc_discount_percentage
        function add_calc_discount_percentage()
        {
            var oldPrice = parseFloat($("#add_inputPrice").val());
            var newPrice = parseFloat($("#add_discount_amount").val());

        if (!isNaN(oldPrice) && !isNaN(newPrice) && oldPrice > 0 && newPrice >= 0) {
            var discount = ((oldPrice - newPrice) / oldPrice) * 100;
            $("#add_discount_percentage").val(discount.toFixed(2)); // عرض النسبة بصيغة 0.00%
        } else {
            $("#add_discount_percentage").val(""); // مسح الحقل إذا كانت القيم غير صالحة
        }
        }
        //calc_discount_amount
        function add_calc_discount_amount()
        {
            var oldPrice = parseFloat($("#add_inputPrice").val());
            var discount = parseFloat($("#add_discount_percentage").val());

        if (!isNaN(oldPrice) && !isNaN(discount) && oldPrice > 0 && discount >= 0 && discount <= 100) {
            var newPrice = oldPrice * (1 - (discount / 100));
            $("#add_discount_amount").val(newPrice.toFixed(2)); // عرض السعر الجديد بصيغة 0.00
        } else {
            $("#add_discount_amount").val(""); // مسح الحقل إذا كانت القيم غير صالحة
        }
        }
//-------------------singl upload image---------------------------------------------
const add_dropzone = document.getElementById('add_dropzone');
        add_dropzone.addEventListener('dragover', (e) => {
          e.preventDefault();
        });
        //
        add_dropzone.addEventListener('drop', (e) => {
          e.preventDefault();
          const add_file = e.dataTransfer.files[0];
          const add_reader = new FileReader();
          add_reader.onload = function (e) {
            const add_logoPreview = document.getElementById('add_logoPreview');
            add_logoPreview.style.backgroundImage = `url(${e.target.result})`;
            add_logoPreview.style.backgroundSize = 'contain';
            add_logoPreview.style.backgroundRepeat = 'no-repeat';
          };
          add_reader.readAsDataURL(add_file);
          //
        });
       
       
    // });

//functions

function add_browsdialog()
    {
        document.getElementById('add_product_image').click();
    }
    // معاينة الشعار
    function add_previewLogo(event) {
      const add_logoPreview = document.getElementById('add_logoPreview');
      const add_file = event.target.files[0];
      if (add_file) {
        const add_reader = new FileReader();
        add_reader.onload = function (e) {
          add_logoPreview.style.backgroundImage = `url(${e.target.result})`;
          add_logoPreview.style.backgroundSize = 'contain';
          add_logoPreview.style.backgroundRepeat = 'no-repeat';
        };
        add_reader.readAsDataURL(add_file);
      }
    }
//-------------------multi upload images---------------------------------------------
let add_files=[],
    add_container=document.querySelector('.images_container'),
    add_input=document.getElementById('add_product_images');
    //
    add_input.addEventListener('change', () =>{
        let selectedFiles = Array.from(add_input.files); // Convert FileList to an array
        add_files.push(...selectedFiles); // Add new files to the files array
        add_showImages();
    })
    //
    const add_showImages = () =>{
        let add_images='';
        add_files.forEach((e, i) => {
             add_images += `
            <div class="image">
                <img src="${URL.createObjectURL(e)}" alt="image">
                <span onclick="add_delImage(${i})">&times;</span>
            </div>`;
        })
        add_container.innerHTML=add_images;
    }
    //delete image from dialog
    const add_delImage = index =>{
        add_files.splice(index,1)
        add_updateInputFiles(); // Update the input.files to match the modified files array
        add_showImages()
    }

    // Update the input.files to reflect the modified files array
    const add_updateInputFiles = () => {
        const dataTransfer = new DataTransfer(); // Create a new DataTransfer object
        add_files.forEach((file) => {
            dataTransfer.items.add(file); // Add each remaining file to the DataTransfer object
        });
        add_input.files = dataTransfer.files; // Update the input's FileList
    };
//functions
function add_browsdialogmultifile()
    {
        document.getElementById('add_product_images').click();
    }

    

</script>