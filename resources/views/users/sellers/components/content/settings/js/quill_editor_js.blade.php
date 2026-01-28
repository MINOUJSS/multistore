<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.min.js"></script>

{{-- @php
$pages = [
    ['id' => 1, 'title' => 'من نحن', 'description' => 'صفحة تعريفية عن الشركة'],
    ['id' => 2, 'title' => 'سياسة الخصوصية', 'description' => 'شرح كيفية استخدام بيانات المستخدم'],
    ['id' => 3, 'title' => 'شروط الاستخدام', 'description' => 'قواعد استخدام المنصة والخدمات'],
    ['id' => 4, 'title' => 'اتصل بنا', 'description' => 'وسائل التواصل مع فريق الدعم'],
    ['id' => 5, 'title' => 'الأسئلة الشائعة', 'description' => 'إجابات على أهم استفسارات العملاء'],
    ['id' => 6, 'title' => 'طرق الدفع', 'description' => 'شرح طرق الدفع المتاحة على الموقع'],
    ['id' => 7, 'title' => 'سياسة الإرجاع', 'description' => 'تفاصيل سياسة استرجاع المنتجات'],
    ['id' => 8, 'title' => 'التوصيل والشحن', 'description' => 'معلومات حول التوصيل والشحن']
];
@endphp --}}

<script>
    const editors = {};
    document.addEventListener('DOMContentLoaded', function () {
        @foreach($pages as $page)
            const editor{{ $page['id'] }} = new Quill("#editor{{ $page['id'] }}", {
                theme: 'snow',
                textAlign : 'right',
                placeholder: 'اكتب محتوى الصفحة هنا...',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                        // [{ 'direction': 'rtl' }],                         // text direction
                        ['blockquote'],
                        ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
                        [{'align':[]}],
                        [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        ['link', 'image', 'video'],
                        ['clean'],                                         // remove formatting button

                        [{ 'color': [] }, { 'background': [] }]          // dropdown with defaults from theme
                    ]
                }
            });

            // ضبط الاتجاه RTL بعد التهيئة
            editor{{ $page['id'] }}.root.setAttribute('dir', 'rtl');
            editor{{ $page['id'] }}.root.style.textAlign = 'right';

            // تأكيد الاتجاه عند التركيز
            editor{{ $page['id'] }}.root.addEventListener('focus', function () {
                this.setAttribute('dir', 'rtl');
                this.style.textAlign = 'right';
            });

            editors[{{ $page['id'] }}] = editor{{ $page['id'] }};
        @endforeach
    });

    function saveEditorContent(id) {
        const editor = editors[id];
        const content = editor.root.innerHTML;
        document.getElementById("contentInput" + id).value = content;
    }
</script>