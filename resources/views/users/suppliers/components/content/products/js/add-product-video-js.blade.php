<script>
    // عند الضغط على زر إضافة فيديو
    $("#add_video").on("click", function (e) {
        e.preventDefault();

        let videoContainer = document.getElementById("product_video");

        // إنشاء عنصر الفيديو الجديد
        let videoHtml = `
        <div class="video_container border position-relative p-3 mt-3 mb-3 row bg-light rounded shadow-sm">
            <div class="col-md-4">
                <label class="form-label">عنوان الفيديو</label>
                <input type="text" name="videos[title][]" class="form-control" placeholder="مثلاً: إعلان المنتج">
            </div>

            <div class="col-md-4">
                <label class="form-label">نوع الفيديو</label>
                <select name="videos[type][]" class="form-select video-type-select">
                    <option value="youtube">YouTube</option>
                    <option value="vimeo">Vimeo</option>
                    <option value="local">محلي (رفع ملف)</option>
                </select>
            </div>

            <div class="col-md-4 youtube-input">
                <label class="form-label">رابط فيديو YouTube || Vimeo</label>
                <input type="url" name="videos[youtube_url][]" class="form-control" placeholder="https://youtube.com/watch?v=xxxx || https://vimeo.com/xxxx">
            </div>

            <div class="col-md-4 local-input d-none">
                <label class="form-label">ملف الفيديو</label>
                <input type="file" name="videos[file][]" accept="video/*" class="form-control">
            </div>

            <div class="col-md-8">
                <label class="form-label">الوصف</label>
                <textarea name="videos[description][]" class="form-control" rows="2" placeholder="وصف مختصر..."></textarea>
            </div>

            <div class="col-md-4 d-flex align-items-center">
                <div class="form-check form-switch mt-4">
                    <input class="form-check-input" name="videos[is_active][]" type="checkbox" checked>
                    <label class="form-check-label">مفعل</label>
                </div>
            </div>

            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2 remove_video"
                style="width:30px;cursor:pointer">X</span>
        </div>`;

        $(videoContainer).append(videoHtml);
    });

    // تغيير نوع الفيديو (يوتيوب / محلي)
    $(document).on("change", ".video-type-select", function () {
        let container = $(this).closest(".video_container");
        let type = $(this).val();

        if (type === "youtube" || type === "vimeo") {
            container.find(".youtube-input").removeClass("d-none");
            container.find(".local-input").addClass("d-none");
            container.find('input[name="videos[file][]"]').val('');
        } else {
            container.find(".youtube-input").addClass("d-none");
            container.find(".local-input").removeClass("d-none");
            container.find('input[name="videos[youtube_url][]"]').val('');
        }
    });

    // حذف الفيديو من الصفحة فقط (قبل الحفظ)
    $(document).on("click", ".remove_video", function () {
        $(this).closest(".video_container").remove();
    });

    // حذف فيديو من قاعدة البيانات بعد الحفظ (بـ Ajax)
    function remove_video_form_data(videoId) {
        if (!videoId) return;

        Swal.fire({
            title: 'هل أنت متأكد؟',
            text: "سيتم حذف الفيديو نهائيًا!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'نعم، احذف',
            cancelButtonText: 'إلغاء'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: `/supplier-panel/product/video/delete/${videoId}`,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (response) {
                        Swal.fire('تم الحذف!', response.message || 'تم حذف الفيديو بنجاح.', 'success');
                        $(`#video-${videoId}`).remove();
                    },
                    error: function (xhr) {
                        console.error("خطاء في حذف الفيديو:", xhr.responseText);
                        Swal.fire('خطأ', 'حدث خطأ أثناء حذف الفيديو.', 'error');
                    }
                });
            }
        });
    }
</script>
{{-- <script>
    // عند الضغط على زر إضافة فيديو
    $("#add_video").click(function(e){
        e.preventDefault();
        add_video();
    });

    // دالة إضافة فيديو جديد
    function add_video() {
        var container = $("#add_product_video");

        var videoHtml = `
        <div class="video_container border position-relative p-3 mt-3 mb-3 row rounded">
            <div class="col-md-8">
                <label for="video_url" class="form-label">رابط الفيديو (YouTube أو ملف محلي)</label>
                <input type="text" name="video_url[]" class="form-control video-required" placeholder="https://www.youtube.com/watch?v=xxxx" onchange="preview_video(this)">
                <span class="text-danger error-video_url error-validation"></span>
            </div>

            <div class="col-md-4 text-center">
                <label class="form-label">معاينة الفيديو</label>
                <div class="video_preview" style="border:1px solid #ccc; border-radius:8px; overflow:hidden;">
                    <iframe width="100%" height="200" src="" allowfullscreen></iframe>
                </div>
            </div>

            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger p-2 remove_video" style="width:30px;cursor:pointer">X</span>
        </div>`;

        container.append(videoHtml);
    }

    // عند الضغط على زر حذف الفيديو
    $("#add_product_video").on("click", ".remove_video", function (e) {
        e.preventDefault();
        $(this).closest(".video_container").remove();
    });

    // حذف الفيديو من قاعدة البيانات
    function remove_video_form_data(id) {
        if (!id) {
            console.error("خطأ: لم يتم توفير معرف الفيديو.");
            return;
        }

        $.ajax({
            url: '/supplier-panel/product/video/delete/' + id,
            type: 'DELETE',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response.message);
                $(".video_container[data-id='" + id + "']").remove();
            },
            error: function(xhr) {
                console.error("خطأ أثناء حذف الفيديو:", xhr.responseText);
            }
        });
    }

    // عرض المعاينة في حال كان الرابط من YouTube
    function preview_video(input) {
        let url = $(input).val().trim();
        let iframe = $(input).closest(".video_container").find("iframe");

        if (url.includes("youtube.com/watch?v=")) {
            let videoId = url.split("v=")[1].split("&")[0];
            iframe.attr("src", "https://www.youtube.com/embed/" + videoId);
        } else if (url.includes("youtu.be/")) {
            let videoId = url.split("youtu.be/")[1];
            iframe.attr("src", "https://www.youtube.com/embed/" + videoId);
        } else {
            iframe.attr("src", "");
        }
    }
</script> --}}
