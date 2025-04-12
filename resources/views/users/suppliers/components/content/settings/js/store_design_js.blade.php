<script>
    $(document).ready(function() {
         //constents variables
          const dropzone = document.getElementById('dropzone');
          const primaryColor = document.getElementById('primaryColor');
          const hiddenPrimaryColler= document.getElementById('hiddenPrimaryCollor');
          const bodytextcolor = document.getElementById('bodytextcolor');
          const hiddenbodytextcolorr= document.getElementById('hiddenbodytextcolor');
          const footertextcolor = document.getElementById('footertextcolor');
          const hiddenfootertextcolor = document.getElementById('hiddenfootertextcolor');
          //on chouse coller in primarycoller color picker
          primaryColor.addEventListener('input', function (e) {
            const selectedColor = primaryColor.value;
            hiddenPrimaryCollor.value=selectedColor;
          });
          //on chouse coller in primaryFontcoller color picker
          footertextcolor.addEventListener('input', function (e) {
            const selectedColor = footertextcolor.value;
            hiddenfootertextcolor.value=selectedColor;
          });
          //on chouse coller in secondarycoller color picker
          bodytextcolor.addEventListener('input', function (e) {
            const selectedColor = bodytextcolor.value;
            hiddenbodytextcolor.value=selectedColor;
          });
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
    });
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