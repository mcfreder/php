/**
 * Editor handles the content, image uploads and deletions.
 */
const Editor = {
  /**
   * Init the editor 
   */
  init: function () {
    /* Create the editor and config settings */
    ClassicEditor
      .create(document.querySelector('#editor'), {
        toolbar: ['heading', 'bold', 'italic', 'link', 'blockQuote', 'bulletedList', 'imageUpload', 'undo', 'redo'],
        extraPlugins: [Editor.customUploadAdapterPlugin],
        removePlugins: ['ImageCaption'],
      })
      .then(() => {
        Editor.handleNodeRemoval();
      })
      .catch(error => {
        console.log(error);
      });
  },

  /**
   * Handle a image removal from content textarea. 
   * Send a POST request to PHP server to delete image.
   */
  handleNodeRemoval: function () {
    const editor = document.getElementsByClassName("ck-content")[0];

    editor.addEventListener('DOMNodeRemoved', function (e) {
      /* Check if target has a classlist. */
      if (e.target.classList) {

        /* Check if target contains a image class. */
        if (e.target.classList.contains('image')) {
          const filename = e.target.firstChild.src.split('/').pop(); /* Get filename */
          let formData = new FormData();

          formData.append('image', filename);

          /* POST data */
          fetch(`http://www.student.ltu.se/~erimam-9/projekt/image-delete`, {
            method: "POST",
            body: formData
          })
            .catch(error => {
              console.log(error);
            })
        }
      }
    })
  },

  /**
   * Custom upload adaptor to use as plugin for file upload 
   * @param {Object} editor 
   */
  customUploadAdapterPlugin: function (editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = (loader) => {
      return new UploadAdapter(loader);
    };
  }
}

/**
 * Upload Adaptor
 */
class UploadAdapter {
  /**
   * Constructor
   * @param {Object} loader 
   */
  constructor(loader) {
    /* The file loader instance to use during the upload. */
    this.loader = loader;
  }

  /**
   * Starts the upload process.
   * @returns promise
   */
  upload() {
    return this.loader.file
      .then(file => new Promise((resolve, reject) => {
        this._initRequest();
        this._initListeners(resolve, reject, file);
        this._sendRequest(file);
      }));
  }

  /**
   * Aborts the upload process.
   */
  abort() {
    if (this.xhr) {
      this.xhr.abort();
    }
  }

  /**
   * Initializes the XMLHttpRequest object using the URL passed to the constructor.
   */
  _initRequest() {
    const xhr = this.xhr = new XMLHttpRequest();

    /* Note that your request may look different. It is up to you and your editor
    integration to choose the right communication channel. This example uses
    a POST request with JSON as a data structure but your configuration
    could be different. */
    xhr.open('POST', 'http://www.student.ltu.se/~erimam-9/projekt/upload', true);
    xhr.responseType = 'json';
  }

  /**
   * Initializes XMLHttpRequest listeners.
   * @param {Function} resolve 
   * @param {Function} reject 
   * @param {Object} file 
   */
  _initListeners(resolve, reject, file) {
    const xhr = this.xhr;
    const loader = this.loader;
    const genericErrorText = `Couldn't upload file: ${file.name}.`;

    xhr.addEventListener('error', () => reject(genericErrorText));
    xhr.addEventListener('abort', () => reject());
    xhr.addEventListener('load', () => {
      const response = xhr.response;

      /* This example assumes the XHR server's "response" object will come with
      an "error" which has its own "message" that can be passed to reject()
      in the upload promise.

      Your integration may handle upload errors in a different way so make sure
      it is done properly. The reject() function must be called when the upload fails. */
      if (!response || response.error) {
        return reject(response && response.error ? response.error.message : genericErrorText);
      }

      /* If the upload is successful, resolve the upload promise with an object containing
      at least the "default" URL, pointing to the image on the server. */
      resolve({
        default: response.path
      });
    });

    /* Upload progress when it is supported. The file loader has the #uploadTotal and #uploaded
    properties which are used e.g. to display the upload progress bar in the editor
    user interface. */
    if (xhr.upload) {
      xhr.upload.addEventListener('progress', evt => {
        if (evt.lengthComputable) {
          loader.uploadTotal = evt.total;
          loader.uploaded = evt.loaded;
        }
      });
    }
  }

  /**
   * Prepares the data and sends the request.
   * @param {Object} file 
   */
  _sendRequest(file) {
    /* Prepare the form data. */
    const data = new FormData();

    data.append('upload', file);

    /* Important note: This is the right place to implement security mechanisms
    like authentication and CSRF protection. */

    /* Send the request. */
    this.xhr.send(data);
  }
}

/* Run script */
Editor.init();








