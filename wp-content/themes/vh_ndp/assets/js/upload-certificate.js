jQuery(document).ready(function ($) {
  document.querySelectorAll('.mdc-text-field').forEach((node) => {
    mdc.textField.MDCTextField.attachTo(node);
  });

  Dropzone.autoDiscover = false;
  let fileUploaded = false;
  const $form = $('.upload-certificate__form');


  let myDropzone = new Dropzone(".upload-certificate__form-upload__block", {
  // clickable:".upload-certificate__form-upload__text strong",
  clickable:".upload-certificate__form-upload__block, .upload-certificate__form-upload__main",
  paramName: "fileToUpload",
  url: 'redirectAfterSubmitCertificate',
  method: "POST",
  autoProcessQueue: false,
  addRemoveLinks: true,
  acceptedFiles: ".pdf",
  maxFilesize: 25,
  init: function () {
    this.on("addedfile", function (file) {
      if (file.size > 25000000) {
        let file_is_too_big = 'This file is too big';
        if (typeof translatesArray !== 'undefined' && translatesArray.hasOwnProperty('file_is_too_big')) {
          file_is_too_big = translatesArray['file_is_too_big'];
        }
        $('.upload-certificate__form-upload__error').text(file_is_too_big);
        $('.upload-certificate__form-upload__error').show();
        $('.upload-certificate__form-upload__main').show();
        $(".upload-certificate__form-upload__block").removeClass('full');
        this.removeFile(file);
        return;
      }
      if (!file.type.match(/.pdf/)) {
        this.removeFile(file);
        let incorrect_format = 'This file is too big';
        if (typeof translatesArray !== 'undefined' && translatesArray.hasOwnProperty('incorrect_format')) {
          incorrect_format = translatesArray['incorrect_format'];
        }
        $('.upload-certificate__form-upload__error').text(incorrect_format);
        $('.upload-certificate__form-upload__error').show();
        $('.upload-certificate__form-upload__main').show();
        $(".upload-certificate__form-upload__block").removeClass('full');
      } else {
        if (fileUploaded) {
          this.removeFile(file);
          $('.upload-certificate__form-upload__error').show();
          $('.upload-certificate__form-upload__main').show();
          $(".upload-certificate__form-upload__block").removeClass('full');
        } else {
          $('.upload-certificate__form-upload__error').hide();
          $('.upload-certificate__form-upload__main').hide();
          $(".upload-certificate__form-upload__block").addClass('full');
          fileUploaded = true;
        }
      }

      let $dzPreview = $('.dz-file-preview');
      if ($(".upload-certificate__form-upload").find('.upload-progress-wrapper').length) {
        $('.upload-progress-wrapper').remove()
      }
      $dzPreview.after('<div class="upload-progress-wrapper"><span class="upload-progress-bar"></span></div>')
      var $progress = $(".upload-progress-bar");
      var width = 0;
      var id = setInterval(frame, 20);
      function frame() {
        if (width >= 100) {
          clearInterval(id);
          $progress.parent().remove();

          let replaceText = 'Replace';
          if (typeof translatesArray !== 'undefined' && translatesArray.hasOwnProperty('Replace')) {
            replaceText = translatesArray['Replace']
          }
          if ($(".upload-certificate__form-upload").find('.replace-button').length) {
            $('.replace-button').remove()
          }
          $dzPreview.after('<button class="replace-button">'+replaceText+'</button>')

        } else {
          width++;
          $progress[0].style.width = width + '%';
          // var num = width * 1 / 10;
          // num = num.toFixed(0);
        }
      }
    });

    this.on("removedfile", function (file) {
      $('.upload-certificate__form-upload__main').show();
      $(".upload-certificate__form-upload__block").removeClass('full');
      fileUploaded = false;
    });
  },
});

  if (typeof certData !== 'undefined' && certData.hasOwnProperty('pdf_url') && certData['pdf_url'] !== '' && certData.hasOwnProperty('pdf_size') && certData['pdf_size'] !== '') {
    let filename = certData['pdf_url'].split('/').pop();
    let file = { name: filename, type: 'application/pdf', size: certData['pdf_size'] };
    myDropzone.emit("addedfile", file);
    myDropzone.files.push( file );
  }

  let dropzoneElement = $(".upload-certificate__form-upload__block");

  $(document).on('click', '.replace-button', function(event) {
    myDropzone.removeAllFiles( true );
    $('.replace-button').remove()
    $(".upload-certificate__form-upload__block").click();
  });

  dropzoneElement.on('dragenter', function () {
    $(this).addClass('dragging');
  });

  dropzoneElement.on('dragleave drop', function () {
    $(this).removeClass('dragging');
  });

  $(document).on('click', '.upload-certificate__form-upload__block .dz-remove', function(event) {
    $('.upload-certificate__form-upload__main').show();
    $('.replace-button').remove()
  });

  let textFields = [].map.call(document.querySelectorAll('.custom-input__field'), function (el) {
    return new mdc.textField.MDCTextField(el);
  })

  $('#indefinite').change(function(event){
    event.preventDefault();

    inputs = document.querySelectorAll('.required__field');

    if($(this).is(":checked")) {
      $(this).closest('.upload-certificate__form-date').find('.error-icon').hide();
      $('#upload-certificate__form-dateObtaining').addClass('mdc-text-field--disabled').removeClass('custom-input__field');
      $('#upload-certificate__form-dateObtaining svg').css('opacity', '0.5');
      $('#upload-certificate__form-validityDate').addClass('mdc-text-field--disabled').removeClass('custom-input__field');
      $('#upload-certificate__form-validityDate svg').css('opacity', '0.5');
      $('#dateObtaining').removeClass('required__field')
          .prop('disabled', true).prop('required', false);
      $('#validityDate').removeClass('required__field')
          .prop('disabled', true).prop('required', false);
      $('.error-message-date').hide()
    } else {
      $(this).closest('.upload-certificate__form-date').find('.error-icon').hide();
      $('#upload-certificate__form-validityDate').removeClass('mdc-text-field--disabled').addClass('custom-input__field');
      $('#upload-certificate__form-validityDate svg').css('opacity', '1');
      $('#dateObtaining').addClass('required__field')
          .prop('disabled', false).prop('required', true);
      $('#upload-certificate__form-dateObtaining').removeClass('mdc-text-field--disabled').addClass('custom-input__field');
      $('#upload-certificate__form-dateObtaining svg').css('opacity', '1');
      $('#validityDate').addClass('required__field')
          .prop('disabled', false).prop('required', true);
    }
    setTimeout(function() {
      textFields = [].map.call(document.querySelectorAll('.custom-input__field'), function (el) {
        return new mdc.textField.MDCTextField(el);
      })
    }, 50)

    let $emptyInputs = $('.required__field').filter(function(i, input) {
      return $(input).val().trim() === '';
    })
    if ($emptyInputs.length) {
      $('.upload-certificate__buttons-add').addClass('upload-certificate__buttons-disabled')
    } else {
      $('.upload-certificate__buttons-add').removeClass('upload-certificate__buttons-disabled')
    }
  });


    const errorIcons = document.querySelectorAll('.error-icon');
    let inputs = document.querySelectorAll('.required__field');
    const errorMessages = document.querySelectorAll('.error-message');


    $form.on('submit', function(event) {
      event.preventDefault();

      if ($('.upload-certificate__buttons-add').is('.upload-certificate__buttons-disabled')) return;

      const formData = new FormData(this);

      const formType = $(this).attr('data-form') || '';
      const certID = $(this).attr('data-id') || '';
      formData.append('formType', formType);
      if (certID) {
        formData.append('certID', certID);
      }

      const files = myDropzone.getAcceptedFiles();
      if (files && files.length) {
        formData.append('fileToUpload', files[0]);
      }
      // for(let [name, value] of formData) {
      //   console.log(`${name} = ${value}`); // key1=value1, потом key2=value2
      // }

      formData.append('action', 'redirectAfterSubmitCertificate');

      $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
          // console.log(response);
          if (response && response.hasOwnProperty('message') && response['message'] == 'ok') {
            let link = $('.js-cert-link').attr('href')
            if (link) {
              document.location.href = link + '?uploaded'
            }
          }
        },
        error: function (jqXHR, exception) {
          // console.log('error');
          // console.log(jqXHR);
          // console.log(exception);
        },
      });

    });


    inputs.forEach((input, index) => {
      const textField = textFields[index];
      const errorIcon = errorIcons[index];
      const errorMessage = errorMessages[index];
      input.addEventListener('input', function () {
        if (input.validity.valid) {
          textField.valid = true;
          errorIcon.style.display = 'none';
          errorMessage.style.display = 'none';
        } else {
          textField.valid = false;
          errorIcon.style.display = 'block';
          errorMessage.style.display = 'block';
        }
      });
    });

    $(document).on('blur', '.required__field', function(event) {
      inputs = document.querySelectorAll('.required__field');
      let $target = $(event.target);
      let $emptyInputs = $('.required__field').filter(function(i, input) {
        return $(input).val().trim() === '';
      })
      if (!$emptyInputs.length) {
        $('.upload-certificate__buttons-add').removeClass('upload-certificate__buttons-disabled')
      } else {
        $('.upload-certificate__buttons-add').addClass('upload-certificate__buttons-disabled')
      }

      inputs.forEach((input, index) => {
        const textField = textFields[index];
        const errorIcon = errorIcons[index];
        const errorMessage = errorMessages[index];
        const $input = $(input);
        if ($target.is($input) && $input.prop('disabled') === false) {
          if (input.validity.valid) {
            textField.valid = true;
            errorIcon.style.display = 'none';
            errorMessage.style.display = 'none';
          } else {
            textField.valid = false;
            errorIcon.style.display = 'block';
            errorMessage.style.display = 'block';
          }
        }
      });
    })

    $('.modal__upload-certificate button').click(function(){
      $('.modal__upload-certificate').hide();
    });

    const lang = $('.upload-certificate').attr('data-lang') || 'uk';
    const elem = document.querySelector('#dateObtaining');
    const datepicker = new Datepicker(elem, {
      format: 'dd.mm.yyyy',
      language: lang,
      nextArrow: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"><path d="M10.2049 6L8.79492 7.41L13.3749 12L8.79492 16.59L10.2049 18L16.2049 12L10.2049 6Z" fill="#45464F"/></svg>',
      prevArrow: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"><path d="M16.2049 7.41L14.7949 6L8.79492 12L14.7949 18L16.2049 16.59L11.6249 12L16.2049 7.41Z" fill="#45464F"/></svg>',
    });

    $('#upload-certificate__form-dateObtaining svg').click(function(){
      datepicker.show();
      $('#upload-certificate__form-dateObtaining svg path').css('fill', '#45464F')
    });

    $(document).click(function(e) {
      if (!$(e.target).closest('#upload-certificate__form-dateObtaining').length) {
        $('#upload-certificate__form-dateObtaining svg path').css('fill', '#919094');
      }
    });

    const elem2 = document.querySelector('#validityDate');
    const datepicker2 = new Datepicker(elem2, {
      format: 'dd.mm.yyyy',
      language: lang,
      nextArrow: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"><path d="M10.2049 6L8.79492 7.41L13.3749 12L8.79492 16.59L10.2049 18L16.2049 12L10.2049 6Z" fill="#45464F"/></svg>',
      prevArrow: '<svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"><path d="M16.2049 7.41L14.7949 6L8.79492 12L14.7949 18L16.2049 16.59L11.6249 12L16.2049 7.41Z" fill="#45464F"/></svg>',
    });

    $('#upload-certificate__form-validityDate svg').click(function(){
      datepicker2.show();
      $('#upload-certificate__form-validityDate svg path').css('fill', '#45464F')
    });

    $('.datepicker .datepicker-main').click(function(){
      datepicker.hide();
      datepicker2.hide();
    });

    $(document).click(function(e) {
      if (!$(e.target).closest('#upload-certificate__form-validityDate').length) {
        $('#upload-certificate__form-validityDate svg path').css('fill', '#919094');
      }
    });
})