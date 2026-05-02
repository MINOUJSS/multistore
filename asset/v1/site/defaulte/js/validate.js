// /**
// * PHP Email Form Validation - v3.6
// * URL: https://bootstrapmade.com/php-email-form/
// * Author: BootstrapMade.com
// */
// (function () {
//   "use strict";

//   let forms = document.querySelectorAll('.php-email-form');

//   forms.forEach( function(e) {
//     e.addEventListener('submit', function(event) {
//       event.preventDefault();

//       let thisForm = this;

//       let action = thisForm.getAttribute('action');
//       let recaptcha =thisForm.getAttribute('data-recaptcha-site-key');
      
//       if( ! action ) {
//         displayError(thisForm, 'The form action property is not set!');
//         return;
//       }
//       thisForm.querySelector('.loading').classList.add('d-block');
//       thisForm.querySelector('.error-message').classList.remove('d-block');
//       thisForm.querySelector('.sent-message').classList.remove('d-block');

//       let formData = new FormData( thisForm );

//       if ( recaptcha ) {
//         if(typeof grecaptcha !== "undefined" ) {
//           grecaptcha.ready(function() {
//             try {
//               grecaptcha.execute(recaptcha, {action: 'php_email_form_submit'})
//               .then(token => {
//                 formData.set('recaptcha-response', token);
//                 php_email_form_submit(thisForm, action, formData);
//               })
//             } catch(error) {
//               displayError(thisForm, error);
//             }
//           });
//         } else {
//           displayError(thisForm, 'The reCaptcha javascript API url is not loaded!')
//         }
//       } else {
//         php_email_form_submit(thisForm, action, formData);
//       }
//     });
//   });

//   function php_email_form_submit(thisForm, action, formData) {
//     fetch(action, {
//       method: 'POST',
//       body: formData,
//       headers: {'X-Requested-With': 'XMLHttpRequest'}
//     })
//     .then(response => {
//       if( response.ok ) {
//         return response.text();
//       } else {
//         throw new Error(`${response.status} ${response.statusText} ${response.url}`); 
//       }
//     })
//     .then(data => {
//       thisForm.querySelector('.loading').classList.remove('d-block');
//       if (data.trim() == 'OK') {
//         thisForm.querySelector('.sent-message').classList.add('d-block');
//         thisForm.reset(); 
//       } else {
//         throw new Error(data ? data : 'Form submission failed and no error message returned from: ' + action); 
//       }
//     })
//     .catch((error) => {
//       displayError(thisForm, error);
//     });
//   }

//   function displayError(thisForm, error) {
//     thisForm.querySelector('.loading').classList.remove('d-block');
//     thisForm.querySelector('.error-message').innerHTML = error;
//     thisForm.querySelector('.error-message').classList.add('d-block');
//   }

// })();
(function () {
  "use strict";

  const forms = document.querySelectorAll('.php-email-form');

  forms.forEach(function (form) {
    form.addEventListener('submit', function (event) {
      event.preventDefault();

      const action = form.getAttribute('action');
      if (!action) {
        displayError(form, 'Form action غير محدد!');
        return;
      }

      // UI states
      form.querySelector('.loading')?.classList.add('d-block');
      form.querySelector('.error-message')?.classList.remove('d-block');
      form.querySelector('.sent-message')?.classList.remove('d-block');

      const formData = new FormData(form);

      fetch(action, {
        method: 'POST',
        body: formData,
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
          'Accept': 'application/json'
        }
      })
      .then(async (response) => {
        const contentType = response.headers.get('content-type') || '';

        // لو JSON
        if (contentType.includes('application/json')) {
          const data = await response.json();

          if (!response.ok) {
            // Laravel validation errors
            if (data.errors) {
              throw new Error(formatErrors(data.errors));
            }
            throw new Error(data.message || 'حدث خطأ أثناء الإرسال');
          }

          return data;
        }

        // fallback لو رجع HTML
        if (!response.ok) {
          throw new Error(response.status + ' ' + response.statusText);
        }

        return { success: true };
      })
      .then((data) => {
        form.querySelector('.loading')?.classList.remove('d-block');

        form.querySelector('.sent-message')?.classList.add('d-block');
        form.reset();
      })
      .catch((error) => {
        displayError(form, error.message || error);
      });
    });
  });

  function displayError(form, message) {
    form.querySelector('.loading')?.classList.remove('d-block');

    const errorBox = form.querySelector('.error-message');
    if (errorBox) {
      errorBox.innerHTML = message;
      errorBox.classList.add('d-block');
    }
  }

  function formatErrors(errors) {
    let msg = '';
    Object.keys(errors).forEach(function (key) {
      msg += errors[key].join('<br>') + '<br>';
    });
    return msg;
  }

})();
