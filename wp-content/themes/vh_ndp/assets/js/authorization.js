jQuery(document).ready(function ($) {


  document.querySelectorAll('.mdc-text-field').forEach((node) => {
      mdc.textField.MDCTextField.attachTo(node);
  });


  mdc.autoInit()
  const tabs = document.querySelectorAll('.tabs-content');
  tabs.forEach(tab => {
    const textField = new mdc.textField.MDCTextField(document.querySelector('.mdc-text-field'));
    const errorIcon = tab.querySelectorAll('.error-icon');
    const input = tab.querySelectorAll('input');
    const errorMessage = tab.querySelector('.authorization__error-message');

    input.forEach((input, index) => {
      input.addEventListener('input', function () {
        if (input.validity.valid) {
          textField.valid = true;
          errorIcon[index].style.display = 'none';
          errorMessage.style.display = 'none';
        }  else {
          textField.valid = false;
          errorIcon[index].style.display = 'block';
          errorMessage.style.display = 'block';
        }
      });
    });
  });


  $('.authorization__tabs-item').on('click', function(event) {
      let $target = $(event.target);
      if ($target.is('.tabs__item-active')) return;

      $('.authorization__tabs-item').removeClass('tabs__item-active');
      $target.addClass('tabs__item-active');

      $('.tabs-content').toggleClass('tab-active')
  });

  // $('input.password-input-field').on('input', function(event) {
  //
  // })

    $(document).on('click','.toggle-password,.toggle-password-confirm',function(event){

        if($(this).prev().attr('type')=="text"){
            $(this).prev().attr('type','password');
        }else{
            $(this).prev().attr('type','text')
        }

    });

    window.setTimeout(() => {
      document
        .querySelectorAll('.mdc-text-field__input:-webkit-autofill')
        .forEach(el => {
          const textField = el.parentNode;
          const outline = textField.querySelector('.mdc-notched-outline__notch');
          const label = textField.querySelector('.mdc-floating-label');
          if (label) {
            label.classList.add('mdc-floating-label--float-above');
          }
          setTimeout(() => {
            if (outline) {
              outline.style.borderTop = 'none';
              const labelWidth = label.offsetWidth * 0.75 + 8;
              outline.style.width = `${labelWidth}px`;
              outline.style.paddingRight = '8px';
            }
          }, 100);
        });
    }, 200);


    if (typeof LLMS !== 'undefined' && typeof LLMS.PasswordStrength !== 'undefined') {
        $('.type-password').on('input', function(event) {
            let $passwordStrengthMeter = $('.password-strength-meter');
            if ($passwordStrengthMeter.length) {
                $passwordStrengthMeter.removeClass('hidden')
            }
        });
    }

    $('form.registration__form').on( 'submit', function(event) {
        let password = $('#password').val().trim();
        if (password && password.length >= 8 && /[A-Z]/.test(password) && /[0-9]/.test(password)) {
            $(this).trigger( 'submit' );
        }
        event.preventDefault();

    });

})




