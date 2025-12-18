<script>
    //on click on edit button
    $('.editproduct').click(function() {

        //clear varitions from

        //clear discount from

        //get product id
        var p_id = $(this).val();
        // Clear previous errors
        $('.error-validation').text('');
        //get product data
        // Set CSRF token for Laravel
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type: 'GET',
            url: '/supplier-panel/product/edit/' + p_id,
            success: function(response) {

                //product variation variables
                var product_variation = document.getElementById("product_variation");
                //end product variation variables
                // console.log(response);
                $('#product_id').val(response.product.id);
                $('#product_name').val(response.product.name);
                $("#p_cat_" + response.product.category_id).prop('selected', true);
                $("#inputCost").val(response.product.cost);
                $("#inputPrice").val(response.product.price);
                $("#inputQty").val(response.product.qty);
                $("#inputMinQty").val(response.product.minimum_order_qty);
                //  console.log(response);
                if (response.product_review != null) {
                    $("#inputReview").val(response.product_review.rating);
                } else {
                    $("#inputReview").val(0);
                }

                $("#product_status_" + response.product.condition).prop('selected', true);

                if (response.product.free_shipping == "yes") {
                    $("#free_shipping").prop('checked', true);
                } else {
                    $("#free_shipping").prop('checked', false);
                }

                if (response.product.status == "active") {
                    $("#product_status").prop('checked', true);
                } else {
                    $("#product_status").prop('checked', false);
                }

                $("#inputShortDescription").val(response.product.short_description);
                // $("#editor").val(response.product.short_description);
                quill.clipboard.dangerouslyPasteHTML(response.product.description);
                $("#product_description").val(response.product.description);
                var image_url = response.product.image;
                var protocol = window.location.protocol; // تحديد البروتوكول (http أو https)
                var hostname = window.location.hostname;
                // التحقق مما إذا كان الرابط يحتوي على البروتوكول بالفعل
                if (!image_url.startsWith('http://') && !image_url.startsWith('https://')) {
                    image_url = protocol + '//' + hostname + '/' + image_url;
                }
                $("#logoPreview").css('background-image', 'url("' + image_url + '")');
                //afficher les images de produit
                let image_html = '';
                response.product_images.forEach(e => {
                    image_html +=
                        `<div class="image"><img src="${e.image_path}" alt="image"><span onclick="delImageData(${e.id})">&times</span></div>`;
                });
                $("#images_container").html(image_html);
                //get product videos
                // ✅ الحصول على فيديوهات المنتج
                var product_videos = document.getElementById("product_video");
                $(product_videos).html(''); // مسح محتوى الفيديوهات الحالية

                response.product_videos.forEach(v => {
                    var youtubeClass = v.type === 'youtube' || v.type === 'vimeo' ? '' : 'd-none';
                    var localClass = v.type === 'local' ? '' : 'd-none';
                    var checked = v.is_active ? 'checked' : '';

                    var videoHtml = `
        <div class="video_container border position-relative p-3 mt-3 mb-3 row bg-light rounded shadow-sm">
            <input type="hidden" name="update_videos_id[]" value="${v.id}">
            
            <div class="col-md-4">
                <label class="form-label">عنوان الفيديو</label>
                <input type="text" name="update_videos[title][]" class="form-control" value="${v.title ?? ''}" placeholder="مثلاً: إعلان المنتج">
            </div>

            <div class="col-md-4">
                <label class="form-label">نوع الفيديو</label>
                <select name="update_videos[type][]" class="form-select video-type-select">
                    <option value="youtube" ${v.type === 'youtube' ? 'selected' : ''}>YouTube</option>
                    <option value="vimeo" ${v.type === 'vimeo' ? 'selected' : ''}>Vimeo</option>
                    <option value="local" ${v.type === 'local' ? 'selected' : ''}>محلي (رفع ملف)</option>
                </select>
            </div>

            <div class="col-md-4 youtube-input ${youtubeClass}">
                <label class="form-label">رابط فيديو YouTube || Vimeo</label>
                <input type="url" name="update_videos[youtube_url][]" class="form-control" value="${v.youtube_url ?? ''}" placeholder="https://youtube.com/watch?v=xxxx || https://vimeo.com/xxxx">
            </div>

            <div class="col-md-4 local-input ${localClass}">
                <label class="form-label">ملف الفيديو</label>
                <input type="file" name="update_videos[file][]" accept="video/*" class="form-control">
                ${v.file_path ? `<small class="text-muted mt-1 d-block">ملف حالي: <a href="/storage/${v.file_path}" target="_blank">${v.file_path.split('/').pop()}</a></small>` : ''}
            </div>

            <div class="col-md-8">
                <label class="form-label">الوصف</label>
                <textarea name="update_videos[description][]" class="form-control" rows="2" placeholder="وصف مختصر...">${v.description ?? ''}</textarea>
            </div>

            <div class="col-md-4 d-flex align-items-center">
                <div class="form-check form-switch mt-4">
                    <input class="form-check-input" name="update_videos[is_active][]" type="checkbox" ${checked}>
                    <label class="form-check-label">مفعل</label>
                </div>
            </div>

            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2 remove_video" 
                  style="width:30px;cursor:pointer" onclick="remove_video_form_data(${v.id})">X</span>
        </div>`;

                    $(product_videos).append(videoHtml);
                });
                //get product attributes
                // الحصول على خصائص المنتج
                var product_attribute = document.getElementById("product_attribute");
                $(product_attribute).html(''); // مسح محتوى العنصر
                response.product_attributes.forEach(e => {
                    var optionsHtml = response.supplier_attributes.map(i =>
                        `<option value="${i.id}" ${i.id == e.attribute_id ? 'selected' : ''}>${i.name}</option>`
                    ).join(''); // استخدام map بدلاً من foreach وتجنب التكرار الخاطئ
                    var filesHtml = `
                <div id="attribute_container_${e.id}" class="attribute_container border position-relative p-3 mt-3 mb-3 row">
                    <input type="hidden" name="update_attribute_id[]" value="${e.id}">
                    <div class="col-6">
                        <label class="form-label">إختر الخاصية</label>
                        <select class="form-select select_attribute" name="update_product_attribute[]">
                            ${optionsHtml}
                        </select>
                    </div>
                    <div class="col-3">
                        <label class="form-label">قيمة الخاصية</label>
                        <input value="${e.value}" class="form-control" type="text" name="update_attribute_value[]" required>
                    </div>
                    <div class="col-3">
                        <label class="form-label">السعر الإضافي</label>
                        <input value="${e.additional_price}" class="form-control" type="number" min="0" name="update_attribute_add_price[]">
                    </div>
                    <div class="col-3">
                        <label class="form-label">الكمية في المخزن</label>
                        <input value="${e.stock_quantity}" class="form-control" type="number" min="0" name="update_attribute_stock_qty[]">
                    </div>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2" 
                        style="width:30px;cursor:pointer" onclick="remove_attribute_form_data(${e.id})">X</span>
                </div>`;
                    $(product_attribute).append(filesHtml);
                });
                //get product variations
                $(product_variation).html(''); // مسح محتوى العنصر
                response.product_variations.forEach(e => {
                    var filesHtml = '<div id="variation_container_' + e.id +
                        '" class="variation_container border position-relative p-3 mt-3 mb-3 row">' +
                        '<div class="col-6">' +
                        '<input type="hidden" name="update_varition_id[]" value="' + e.id +
                        '">' +
                        '<label for="inputSku" class="form-label">اسم المنتج مع اللون  ..</label>' +
                        '<input type="text" class="form-control variation-required" name="update_product_sku[]" placeholder="مثال:T-Shirt-Red-Siz-XXL" value="' +
                        e.sku + '">' +
                        '<span class="text-danger error-product_sku_' + e.id +
                        ' error-validation"></span>' +
                        '</div>' +
                        '<div class="col-3">' +
                        '<label for="inputColor" class="form-label">لون المنتج</label>' +
                        '<input type="color" class="form-control form-control-color variation-required" name="update_product_color[]" value="' +
                        e.color + '">' +
                        '<span class="text-danger error-product_color_' + e.id +
                        ' error-validation"></span>' +
                        '</div>' +
                        // '<div class="col-3">' +
                        // '<label for="inputSize" class="form-label">المقاس المنتج</label>' +
                        // '<input type="text" name="update_product_size[]" class="form-control variation-required" value="'+e.size+'">' +
                        // '<span class="text-danger error-product_size_'+e.id+' error-validation"></span>' +
                        // '</div>' +
                        // '<div class="col-3">' +
                        // '<label for="inputWeight" class="form-label">وزن المنتج</label>' +
                        // '<input type="text" name="update_product_weight[]" class="form-control variation-required" value="'+e.weight+'">' +
                        // '<span class="text-danger error-product_weight_'+e.id+' error-validation"></span>' +
                        // '</div>' +
                        // '<div class="col-3">' +
                        // '<label for="inputAddPrice" class="form-label">السعر الإضافي</label>' +
                        // '<input type="number" min="0" name="update_product_variation_add_price[]" class="form-control variation-required" value="'+e.additional_price+'">' +
                        // '<span class="text-danger error-product_variation_add_price_'+e.id+' error-validation"></span>' +
                        // '</div>' +
                        '<div class="col-3">' +
                        '<label for="inputStock" class="form-label">الكمية في المخزن</label>' +
                        '<input type="number" min="0" name="update_product_variation_stock[]" class="form-control variation-required" value="' +
                        e.stock_quantity + '">' +
                        '<span class="text-danger error-product_variation_stock_' + e.id +
                        ' error-validation"></span>' +
                        '</div>' +
                        '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2" style="width:30px;cursor:pointer" onclick="remove_recorded_variation(' +
                        e.id + ')">X</span>' +
                        '</div>';
                    $(product_variation).append(filesHtml);
                });
                //get product discount
                var product_discount = document.getElementById("product_discount");

                if (!product_discount) {
                    console.error("العنصر product_discount غير موجود في الصفحة.");
                    return;
                }

                var discount = response.product_discount ||
                {}; // التأكد من وجود البيانات أو تعيين كائن فارغ لتجنب الأخطاء
                if (Object.keys(discount).length > 0) { // التحقق مما إذا كان هناك بيانات خصم

                    var discountHtml = `
                <div class="d-flex justify-content-center m-3">

                </div>
                <div id="discount_container" class="discount_container border position-relative p-3 mt-3 mb-3 row">
                    <div class="col-3">
                        <label for="discount_amount" class="form-label">السعر الجديد</label>
                        <input value="${discount.discount_amount || ''}" id="discount_amount" 
                            name="discount_amount" type="number" class="form-control discount-required" 
                            onchange="calc_discount_percentage();" min="0">
                        <span class="text-danger error-discount_amount error-validation"></span>
                    </div>
                    <div class="col-3">
                        <label for="discount_percentage" class="form-label">نسبة التخفيض</label>
                        <input value="${discount.discount_percentage || ''}" id="discount_percentage" 
                            name="discount_percentage" type="text" class="form-control discount-required" 
                            onchange="calc_discount_amount();" max="100">
                        <span class="text-danger error-discount_percentage error-validation"></span>
                    </div>
                    <div class="col-3">
                        <label for="discount_start_date" class="form-label">تاريخ بداية التخفيض</label>
                        <input name="discount_start_date" type="date" class="form-control discount-required" 
                            value="${discount.start_date || ''}">
                        <span class="text-danger error-discount_start_date error-validation"></span>
                    </div>
                    <div class="col-3">
                        <label for="discount_end_date" class="form-label">تاريخ نهاية التخفيض</label>
                        <input name="discount_end_date" type="date" class="form-control discount-required" 
                            value="${discount.end_date || ''}">
                        <span class="text-danger error-discount_end_date error-validation"></span>
                    </div>
                    <div class="form-check form-switch mt-3">
                        <input class="form-check-input" name="discount_status" type="checkbox" 
                            ${discount.status === 'active' ? 'checked' : ''}>
                        <label class="form-check-label">مفعل</label>
                    </div>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2" 
                        style="width:30px;cursor:pointer" onclick="remove_discount_form_data(${discount.id || 0});">X</span>
                </div>`;

                    console.log("تم العثور على بيانات الخصم:", discount);
                    $(product_discount).html(discountHtml);
                    $("#add_discount").hide();
                } else {
                    console.warn("لم يتم العثور على بيانات الخصم.");
                    $(product_discount).html('');
                    $("#add_discount").show();
                }
                //define action route to submit the edit form
                var newRoute = '/supplier-panel/product/update/' + p_id; // Define your new route
                $('#editForm').attr('action', newRoute);

            }
        });

    });
</script>
