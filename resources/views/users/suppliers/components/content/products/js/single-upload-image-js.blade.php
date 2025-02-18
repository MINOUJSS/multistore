<script>
    // $(document).ready(function() {
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
       
       
    // });

//functions

function browsdialog()
    {
        document.getElementById('product_image').click();
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