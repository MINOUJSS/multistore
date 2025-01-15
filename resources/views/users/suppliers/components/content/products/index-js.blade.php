<!-- Include the Quill library -->
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
<script>
    //--------start Quill editor --------
    const toolbarOptions = [
  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
  [{ 'direction': 'rtl' }],                         // text direction
  ['blockquote'],
  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
  [{'align':[]}],
  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
  ['link', 'image', 'video'],
  ['clean'],                                         // remove formatting button

  [{ 'color': [] }, { 'background': [] }]          // dropdown with defaults from theme

];

const quill = new Quill('#editor', {
  modules: {
    toolbar: toolbarOptions
  },
  theme: 'snow'
});
  //-------end Quill editor -----
    $(document).ready(function() {
        //
        const dropzone = document.getElementById('dropzone');
        dropzone.addEventListener('dragover', (e) => {
          e.preventDefault();
        });
        //
        dropzone.addEventListener('drop', (e) => {
          e.preventDefault();
          const file = e.dataTransfer.files[0];
          const reader = new FileReader();
          reader.onload = function (e) {
            const logoPreview = document.getElementById('logoPreview');
            logoPreview.style.backgroundImage = `url(${e.target.result})`;
            logoPreview.style.backgroundSize = 'contain';
            logoPreview.style.backgroundRepeat = 'no-repeat';
          };
          reader.readAsDataURL(file);
          //
        });
        //on click on edit button
       $('.editproduct').click(function(){
        //get product id
        var p_id= $(this).val();
        //get product data
        // Set CSRF token for Laravel
    $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        $.ajax({
            type:'GET',
            url:'/supplier-panel/product/edit/' + p_id,
            success: function(response) {
                // console.log(response);
                $('#product_name').val(response.product.name);
                $("#p_cat_"+response.product.category_id).prop('selected',true);
                $("#inputCost").val(response.product.cost);
                $("#inputPrice").val(response.product.price);
                $("#inputQty").val(response.product.qty);
                $("#inputMinQty").val(response.product.minimum_order_qty);
                var image_url =response.product.image;
                var protocol = window.location.protocol; // تحديد البروتوكول (http أو https)
               $("#logoPreview").css('background-image', 'url("' + protocol + '//' + window.location.hostname + '/' + image_url + '")');
               var newRoute = '/supplier-panel/product/update/'+p_id; // Define your new route
               $('#editForm').attr('action', newRoute);
            
            }
        });
        
       });
       // on click on add_varition_product
       $("#add_variation").click(function(){
        var product_variation = document.getElementById("product_variation");
        var filesHtml = '<div class="variation_container border position-relative p-3 mt-3 mb-3 row"><div class="col-6"><label for="inputSku" class="form-label">اسم المنتج مع اللون و المقاس..</label><input type="text" class="form-control" id="inputSku" name="product_sku[]" placeholder="مثال:T-Shirt-Red-Siz-XXL"></div><div class="col-3"><label for="inputColor" class="form-label">لون المنتج</label><input type="color" class="form-control form-control-color" id="inputColor" name="product_color[]"></div><div class="col-3"><label for="inputSize" class="form-label">المقاس المنتج</label><input type="text" name="product_size[]" class="form-control" id="inputSize"></div><div class="col-3"><label for="inputWeight" class="form-label">وزن المنتج</label><input type="text" name="product_weight[]" class="form-control" id="inputWeight"></div><div class="col-3"><label for="inputAddPrice" class="form-label">السعر الإضافي</label><input type="number" name="product_variation_add_price[]" class="form-control" id="inputAddPrice"></div><div class="col-3"><label for="inputStock" class="form-label">الكمية  في المخزن</label><input type="number" name="product_variation_stock[]" class="form-control" id="inputStock"></div><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2 remove_variation" style="width:30px;cursor:pointer">X</span></div>';
        $(product_variation).append(filesHtml);
       });
      // On click remove_variation
        $(product_variation).on('click', '.remove_variation', function (e) {
            e.preventDefault();
            $(this).closest('.variation_container').remove();
        });
        // on click on add_discount_product
       $("#add_discount").click(function(){
        var product_discount = document.getElementById("product_discount");
        var filesHtml = '<div class="discount_container border position-relative p-3 mt-3 mb-3 row"><div class="col-3"><label for="discount_amount" class="form-label">سعر البيع بالتخفيض</label><input name="discount_amount[]" type="number" class="form-control"></div><div class="col-3"><label for="discount_percentage" class="form-label">النسبة المئوية للتخفيض</label><input name="discount_percentage[]" type="number" class="form-control"></div><div class="col-3"><label for="discount_start_date" class="form-label">تاريخ بداية التخفيض</label><input name="discount_start_date[]" type="date" class="form-control"></div><div class="col-3"><label for="discount_end_date" class="form-label">تاريخ نهاية التخفيض</label><input name="discount_end_date[]" type="date" class="form-control"></div><div class="form-check form-switch"><input class="form-check-input" name="discount_status[]" type="checkbox" checked><label class="form-check-label" for="flexSwitchCheckChecked">مفعل</label></div><span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2 remove_discount" style="width:30px;cursor:pointer">X</span></div>';
        $(product_discount).append(filesHtml);
       });
        // On click remove_discount
        $(product_discount).on('click', '.remove_discount', function (e) {
            e.preventDefault();
            $(this).closest('.discount_container').remove();
        });
        //on change editor 
        $('#editForm').on('submit', function () {
            // e.preventDefault();
            var content = quill.root.innerHTML;
            document.getElementById('product_description').value=content;
        });

    });

//functions
function browsdialog()
    {
        document.getElementById('storeLogo').click();
    }
    // معاينة الشعار
    function previewLogo(event) {
      const logoPreview = document.getElementById('logoPreview');
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
          logoPreview.style.backgroundImage = `url(${e.target.result})`;
          logoPreview.style.backgroundSize = 'contain';
          logoPreview.style.backgroundRepeat = 'no-repeat';
        };
        reader.readAsDataURL(file);
      }
    }
</script>