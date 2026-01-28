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
const add_quill = new Quill('#add_editor', {
  modules: {
    toolbar: toolbarOptions
  },
  theme: 'snow'
});
  //-------end Quill editor -----

          //on change editor 
          //edit form
          $('#editForm').on('submit', function () {
            e.preventDefault();
            var content = quill.root.innerHTML;
            document.getElementById('product_description').value=content;
        });
        // add form
        $('#addForm').on('submit', function () {
            e.preventDefault();
            var add_content = add_quill.root.innerHTML;
            document.getElementById('add_product_description').value=add_content;
        });
        
</script>