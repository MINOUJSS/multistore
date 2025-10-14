<script>
    // on click on add_varition_product
    $("#add_variation").click(function(){
        var product_variation = document.getElementById("product_variation");
        var filesHtml = '<div class="variation_container border position-relative p-3 mt-3 mb-3 row">' +
            '<div class="col-6">' +
            '<label for="inputSku" class="form-label">اسم المنتج مع اللون</label>' +
            '<input type="text" class="form-control variation-required" name="product_sku[]" placeholder="مثال:T-Shirt-Red">' +
            '<span class="text-danger error-product_sku error-validation"></span>' +
            '</div>' +
            '<div class="col-3">' +
            '<label for="inputColor" class="form-label">لون المنتج</label>' +
            '<input type="color" class="form-control form-control-color variation-required" name="product_color[]">' +
            '<span class="text-danger error-product_color error-validation"></span>' +
            '</div>' +
            // '<div class="col-3">' +
            // '<label for="inputSize" class="form-label">المقاس المنتج</label>' +
            // '<input type="text" name="product_size[]" class="form-control variation-required">' +
            // '<span class="text-danger error-product_size error-validation"></span>' +
            // '</div>' +
            // '<div class="col-3">' +
            // '<label for="inputWeight" class="form-label">وزن المنتج</label>' +
            // '<input type="text" name="product_weight[]" class="form-control variation-required">' +
            // '<span class="text-danger error-product_weight error-validation"></span>' +
            // '</div>' +
            // '<div class="col-3">' +
            // '<label for="inputAddPrice" class="form-label">السعر الإضافي</label>' +
            // '<input type="number" name="product_variation_add_price[]" class="form-control variation-required">' +
            // '<span class="text-danger error-product_variation_add_price error-validation"></span>' +
            // '</div>' +
            '<div class="col-3">' +
            '<label for="inputStock" class="form-label">الكمية في المخزن</label>' +
            '<input type="number" name="product_variation_stock[]" class="form-control variation-required">' +
            '<span class="text-danger error-product_variation_stock error-validation"></span>' +
            '</div>' +
            '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2 remove_variation" style="width:30px;cursor:pointer">X</span>' +
            '</div>';
            $(product_variation).append(filesHtml);
            });
         // On click remove_variation
         $(product_variation).on('click', '.remove_variation', function (e) {
          e.preventDefault();
          $(this).closest('.variation_container').remove();
          });
          // On click remove_recorded_variation
          function remove_recorded_variation(id)
          {
            var product_variation = document.getElementById("variation_container_"+id);
            product_variation.remove();
            $.ajax({
               type:'DELETE',
               url:'/supplier-panel/product/variant/delete/'+id,
               success:function(response){
                //get product variations
         response.product_variations.forEach(e => {
            var filesHtml = '<div id="variation_container_'+e.id+'" class="variation_container border position-relative p-3 mt-3 mb-3 row">' +
            '<div class="col-6">' +
            '<label for="inputSku" class="form-label">اسم المنتج مع اللون</label>' +
            '<input type="text" class="form-control variation-required" name="product_sku_'+e.id+'" placeholder="مثال:T-Shirt-Red" value="'+e.sku+'">' +
            '<span class="text-danger error-product_sku_'+e.id+' error-validation"></span>' +
            '</div>' +
            '<div class="col-3">' +
            '<label for="inputColor" class="form-label">لون المنتج</label>' +
            '<input type="color" class="form-control form-control-color variation-required" name="product_color'+e.id+'" value="'+e.color+'">' +
            '<span class="text-danger error-product_color_'+e.id+' error-validation"></span>' +
            '</div>' +
            // '<div class="col-3">' +
            // '<label for="inputSize" class="form-label">المقاس المنتج</label>' +
            // '<input type="text" name="product_size_'+e.id+'" class="form-control variation-required" value="'+e.size+'">' +
            // '<span class="text-danger error-product_size_'+e.id+' error-validation"></span>' +
            // '</div>' +
            // '<div class="col-3">' +
            // '<label for="inputWeight" class="form-label">وزن المنتج</label>' +
            // '<input type="text" name="product_weight_'+e.id+'" class="form-control variation-required" value="'+e.weight+'">' +
            // '<span class="text-danger error-product_weight_'+e.id+' error-validation"></span>' +
            // '</div>' +
            // '<div class="col-3">' +
            // '<label for="inputAddPrice" class="form-label">السعر الإضافي</label>' +
            // '<input type="number" name="product_variation_add_price_'+e.id+'" class="form-control variation-required" value="'+e.additional_price+'">' +
            // '<span class="text-danger error-product_variation_add_price_'+e.id+' error-validation"></span>' +
            // '</div>' +
            '<div class="col-3">' +
            '<label for="inputStock" class="form-label">الكمية في المخزن</label>' +
            '<input type="number" name="product_variation_stock_'+e.id+'" class="form-control variation-required" value="'+e.stock_quantity+'">' +
            '<span class="text-danger error-product_variation_stock_'+e.id+' error-validation"></span>' +
            '</div>' +
            '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2" style="width:30px;cursor:pointer" onclick="remove_recorded_variation('+e.id+')">X</span>' +
            '</div>';
         $(product_variation).append(filesHtml);
               });
            },
               error : function(xhr)
               {
                console.log(xhr.responseText);
               } 
            });
          }
</script>