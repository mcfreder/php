import ValidationService from './ValidationService.js';

const ClientValidation = {
  /**
   * Init application
   */
  init: () => {
    ClientValidation.validateForm();
  },

  /**
   * Validate a form and post data to server-side.
   * @param {String} page 
   */
  validateForm: () => {
    const formRef = document.getElementById('formRef');
    const errorMessage = 'Minst 6 tecken, enligt formatet aA-öÖ/0-9_';

    formRef.onsubmit = (e) => {
      e.preventDefault();

      /* Init validation + setup */
      const validate = new ValidationService({
        form: formRef,
        borderCSS: '0.5px solid #d93025',
        spanColor: '#d93025',
        initBorderCSS: '0.5px solid #dadce0'
      });

      /* Validate inputs */
      validate.username(errorMessage);
      validate.password(errorMessage);

      /* If status is true send data to php post page to handle login */
      if (validate.status) {
        let formData = new FormData(formRef);

        fetch(formRef.action, {
          method: "POST",
          body: formData
        })
          .then(response => response.text())
          .then(status => {
            const span = document.getElementById('status');
            const input = document.getElementById('username');

            /* Output status if exist */
            if (status) {
              span.innerHTML = status;
              input.style.borderColor = '#d93025';
            } else {
              location.reload();
            }
          })
      }
    }
  },
}

ClientValidation.init();