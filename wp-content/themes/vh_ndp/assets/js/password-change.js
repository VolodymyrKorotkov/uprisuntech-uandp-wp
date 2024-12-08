jQuery(document).ready(function ($) {


  document.querySelectorAll('.mdc-text-field').forEach((node) => {
      mdc.textField.MDCTextField.attachTo(node);
  });

  $(document).on('click', '.toggle-password', function(event) {
      let $target = $(event.target);
      let $passwordField = $target.closest('.mdc-text-field').find('.password-input-field');
      if ($passwordField[0].type === 'password') {
          $passwordField[0].type = 'text';
          this.textContent = 'visibility_off';
      } else {
          $passwordField[0].type = 'password';
          this.textContent = 'visibility';
      }
  });
  mdc.autoInit()

  const textFields = [].map.call(document.querySelectorAll('.mdc-text-field'), function (el) {
    return new mdc.textField.MDCTextField(el);
  })
  // const errorIcons = document.querySelectorAll('.error-icon');
  // const inputs = document.querySelectorAll('.password-input-field');
  // const newPassword = document.getElementById('new-password');
  // const errorMessages = document.querySelectorAll('.error-message');
  // const condition = document.querySelector('.password-change__form-condition');

  // inputs.forEach((input, index) => {
  //   const textField = textFields[index];
  //   const errorIcon = errorIcons[index];
  //   const errorMessage = errorMessages[index];
  //   input.addEventListener('input', function () {
  //     if (input.validity.valid) {
  //       textField.valid = true;
  //       errorIcon.style.display = 'none';
  //       errorMessage.style.display = 'none';
  //     } else {
  //       textField.valid = false;
  //       errorIcon.style.display = 'block';
  //       errorMessage.style.display = 'block';
  //     }
  //   });
  // });

  // newPassword.addEventListener('input', function () {
  //   if (newPassword.validity.valid) {
  //     condition.style.display = 'block';
  //   } else {
  //     condition.style.display = 'none';
  //   }
  // });

    mdc.autoInit();

    var errorCharacters = true;
    var errorSmall = true;
    var errorCapital = true;
    var errorSpecial = true;
    const passwordInput = $('#password');

    passwordInput.on('input', function () {
        let password = $(this).val();
        let $charactersMessage = $('.registration__condition-characters');
        let $smallMessage = $('.registration__condition-small');
        let $capitalMessage = $('.registration__condition-capital');
        let $specialMessage = $('.registration__condition-special');

        if (password && password.length >= 8 && /[0-9]/.test(password)) {
            $charactersMessage.find('.svg-ok').show();
            $charactersMessage.find('.svg-error').hide();
            errorCharacters = false;
        } else {
            $charactersMessage.find('.svg-ok').hide();
            $charactersMessage.find('.svg-error').show();
            errorCharacters = true;
        }

        if (password && /[a-z]/.test(password)) {
            $smallMessage.find('.svg-ok').show();
            $smallMessage.find('.svg-error').hide();
            errorSmall = false;
        } else {
            $smallMessage.find('.svg-ok').hide();
            $smallMessage.find('.svg-error').show();
            errorSmall = true;
        }

        if (password && /[A-Z]/.test(password)) {
            $capitalMessage.find('.svg-ok').show();
            $capitalMessage.find('.svg-error').hide();
            errorCapital = false;
        } else {
            $capitalMessage.find('.svg-ok').hide();
            $capitalMessage.find('.svg-error').show();
            errorCapital = true;
        }

        if (password && /[!@#$%^&*_]/.test(password)) {
            $specialMessage.find('.svg-ok').show();
            $specialMessage.find('.svg-error').hide();
            errorSpecial = false;
        } else {
            $specialMessage.find('.svg-ok').hide();
            $specialMessage.find('.svg-error').show();
            errorSpecial = true;
        }
    });

    $('.password-change__form').submit(function (e) {
        e.preventDefault();

        var oldPassword = $('#old_password').val().trim();
        var password = $('#password').val().trim();
        var confirmPassword = $('#confirm_password').val().trim();
        var nonce = $('#password_change_nonce').val();

        // Проверка совпадения паролей перед отправкой
        if (password !== confirmPassword) {
            return;
        }

        if (!password || errorCharacters || errorSmall || errorCapital || errorSpecial || !nonce) {
            return;
        }

        // Отправка запроса на обновление пароля
        let data = {
            action: 'profile_settings_password_change',
            oldPassword: oldPassword,
            password: password,
            confirmPassword: confirmPassword,
            password_change_nonce: nonce,
        };

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                // console.log(response);
                if (response && response.hasOwnProperty('message') && response['message']) {
                    productAddedMessage(response['message']);
                    $('.password-change__form-cancel').removeAttr( 'href' );
                }
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        })
    });

})




