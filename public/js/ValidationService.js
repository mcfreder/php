/**
 * @author Marcus Eriksson
 * The MIT License (MIT)
 * Copyright (c) 2020 - 2021 Marcus Eriksson
 */

/**
 * This is a simple dynamic form validation tool for vanilla javascript & jquery.
 */
class ValidationService {
  elements = []; /* Form elements */
  targte = null; /* Target to validate */
  calls = 0; /* Number of validation calls user has made. */
  valid = 0; /* Amount of valid calls */
  status = false; /* If calls is equal to valid, status is true, form inputs are valid */

  /**
   * Constructor
   * @param {Array} form
   * @returns Proxy
   */
  constructor({ form, borderCSS, spanColor, initBorderCSS }) {
    /* Add form elements to class property elements */
    for (let i = 0; i < form.elements.length; i++) {
      this.elements = [...this.elements, form.elements[i]];
    }

    /* Default css styles or params */
    this.borderCSS = borderCSS ?? '1px solid red';
    this.initBorderCSS = initBorderCSS ?? '1px solid black';
    this.spanColor = spanColor ?? 'red';

    /* Create a handler,
    this will run a middleware function every time after a class function is called */
    const handler = {
      get: function (obj, prop) {
        return typeof obj[prop] !== "function" ?
          obj[prop] :
          function () {
            obj.before(prop);
            obj[prop].apply(obj, arguments);
            obj.after();
          };
      },
    };

    /* Return the proxy instead, with the handler */
    return new Proxy(this, handler);
  }

  /**
   * This middleware runs every time before a class function is called.
   * @param {String} prop
   */
  before(prop) {
    this.target = this.elements.find(element => element.name === prop);

    if (!this.target)
      throw new Error(`can't find attribute name ${prop}`);
  }

  /**
   * This middleware runs every time after a class function is called.
   */
  after() {
    /* Add +1 to calls, this is done every time a validation function is called */
    this.calls++;

    /* If calls is equal to valid, requested input validations are valid */
    (this.calls === this.valid) ?
      this.status = true : this.status = false
  }

  /**
   * Validate input name email.
   * @param {String} errorMessage
   */
  email(errorMessage = 'Please enter a valid email.') {
    let atPos = this.target.value.indexOf('@');
    let dotPos = this.target.value.lastIndexOf('.');

    (atPos < 1 || (dotPos - atPos < 2)) ?
      this.onError(errorMessage) :
      this.onSuccess();
  }

  /**
   * Validate input name phonenumber
   */
  phonenumber(errorMessage = 'Please enter a valid phonenumber.') {
    let chars = /^\(?([0-9]{3})\)?[-. ]?([0-9]{3})[-. ]?([0-9]{4})$/; /* Valid chars */

    /* Check if element input matches valid chars */
    (!this.target.value.match(chars)) ?
      this.onError(errorMessage) :
      this.onSuccess();
  }

  /**
   * Validate input name username.
   * @param {String} errorMessage
   */
  username(errorMessage = 'Minimum 6 characters.') {
    let chars = /\W/; /* Allow letters, numbers, and underscores */

    (this.target.value.length < 6 || chars.test(this.target.value)) ?
      this.onError(errorMessage) :
      this.onSuccess();
  }

  /**
   * Validate input name password.
   * @param {String} errorMessage
   */
  password(errorMessage = 'Minimum 6 characters.') {
    let chars = /\W/; /* Allow letters, numbers, and underscores */

    (this.target.value.length < 6 || chars.test(this.target.value)) ?
      this.onError(errorMessage) :
      this.onSuccess();
  }

  /**
   * If an input validation fails.
   * @param {String} message
   */
  onError(message) {
    /* Make sure to only create one new span element */
    if (this.target.nextSibling.tagName !== 'SPAN') {
      let span = document.createElement('span'); /* Create span element */

      span.innerHTML = message; /* Set message */
      span.style.color = this.spanColor;

      this.target.insertAdjacentElement('afterend', span); /* Insert span after input element */
      this.target.style.border = this.borderCSS;
    }
  }

  /**
   * Reset css & remove span element if input validation succeeded.
   */
  onSuccess() {
    this.valid++;

    /* Remove span if it's the sibling of the input element */
    if (this.target.nextSibling.tagName === 'SPAN')
      this.target.nextSibling.remove();

    /* Reset border color */
    this.target.style.border = this.initBorderCSS; /* !fix add dynamic border/color */
  }
}

export default ValidationService;