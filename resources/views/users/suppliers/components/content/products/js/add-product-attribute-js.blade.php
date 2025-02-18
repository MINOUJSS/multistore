<script>
   //on click add attributes btn   
    $('#add_attribute').on('click', function(){
        //hide add attribute btn
        //$('#add_attribute').hide();
        // variables
        var product_attribute = document.getElementById("product_attribute");
         var filesHtml = '<div class="attribute_container border position-relative p-3 mt-3 mb-3 row">'
                          +'<div class="col-6">'
                          +'<label for="inputSku" class="form-label">إختر الخاصية</label>'
                          +'<select class="form-select porduct_attribute" name="porduct_attribute[]" id="porduct_attribute"></select>'
                          +'</div>'
                          +'<div class="col-3">'
                          +'<label for="inputColor" class="form-label">قيمة الخاصية</label>'
                          +'<input class="form-control" type="text" name="attribute_value[]" id="attribute_value" required>'
                          +'</div>'
                          +'<div class="col-3">'
                          +'<label for="inputSize" class="form-label">السعر الإضافي</label>'
                          +'<input class="form-control" type="number" class="form-control" min="0" name="atrribute_add_price[]" id="atrribute_add_price" value="0">'
                          +'</div>'
                          +'<div class="col-3">'
                          +'<label for="inputAddPrice" class="form-label">الكمية  في المخزن</label>'
                          +'<input type="number" class="form-control" min="0" name="attribute_stock_qty[]" id="attribute_stock_qty" value="0">'
                          +'</div>'
                          +'<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2 remove_attribute" style="width:30px;cursor:pointer">X</span>'
                          +'</div>';
        // print the html code
          $(product_attribute).append(filesHtml)
        //send ajax request to get product attribute       
        get_product_attribute({{auth()->user()->id}})
    });

    // On click remove_atrribute
    $(product_attribute).on('click', '.remove_attribute', function (e) {
            e.preventDefault();
            // $("#add_attribute").show();
            $(this).closest('.attribute_container').remove();
        });

    //functions
    function get_product_attribute(user_id)
    {
        $.ajax({
            url:'/supplier-panel/attributes/user/'+user_id,
            type:'POST',
            success: function(response)
            {
                console.log(response.attributes);
                var product_attribute = document.getElementsByClassName("product_attribute");
                response.attributes.forEach(e => {
                    var filesHtml ='<option value="'+e.id+'">'+e.name+'</option>';
                    $(porduct_attribute).append(filesHtml);
                });
            },
            error:function(xhr)
            {
                console.log(xhr);
            }
        });
    }
    // حذف الخاصية من قاعدة البيانات
    function remove_attribute_form_data(id) {
            if (!id) {
                console.error("خطأ: لم يتم توفير معرف الخاصية.");
                return;
            }

            // حذف العنصر من الصفحة
            $("#attribute_container_"+id).remove();
            
            // إرسال طلب Ajax لحذف الخاصية من قاعدة البيانات
            $.ajax({
                url: '/supplier-panel/product/attributes/delete/' + id, // تعديل الرابط حسب مسارك الفعلي
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content') // إضافة CSRF Token
                },
                success: function(response) {
                    console.log(response.message);
                },
                error: function(xhr) {
                    console.error("خطأ أثناء حذف الخاصية:", xhr.responseText);
                }
            });
        }

</script>