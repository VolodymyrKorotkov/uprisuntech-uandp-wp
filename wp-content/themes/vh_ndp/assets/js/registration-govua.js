jQuery(document).ready(function ($) {
  document.querySelectorAll('.mdc-text-field').forEach((node) => {
    mdc.textField.MDCTextField.attachTo(node);
  });

  // розкоментувати 7 і 8 для роботи з #registration__type
  const MDCSelect = mdc.select.MDCSelect;
  if(window.location.pathname !=="/register-step-2/"){
    // const select = new MDCSelect(document.querySelector('.mdc-select'));
  }


  // для #registration__type
  $('input[name="account-type"]').change(function () {
    if ($('#personalAccount:checked').length) {
        $('.registration__button').removeClass('disabled__button');
        $('.registration__button').attr('type', 'submit');
        $('.mdc-select').hide();
        $('#hidden__field').hide();
        $('.registration__selected-item').remove();
        $('.mdc-list-item').css('background-color', '');
        $('#TIN-organization').val('');
        $('.mdc-floating-label').removeClass('mdc-floating-label--float-above');
        $('.mdc-notched-outline').removeClass('mdc-notched-outline--notched');
        $('.mdc-notched-outline__notch').css('width', 'fit-content');
    } else if ($('#representativeAccount:checked').length) {
        $('.mdc-select').css('display', 'inline-flex');
        $('.registration__button').addClass('disabled__button');
        $('.registration__button').attr('type', 'button');
    }
  });

  $('.mdc-list-item').on('click', function() {
    var selectedValue = $(this).text();
    $('.registration__selected-item').remove();
    $('.mdc-list-item').css('background-color', 'white');

    var newItem = $('<span class="registration__selected-item">' + selectedValue + '</span>');
    $('.registration__selected').append(newItem);
    $(this).css('background-color', '#E4E2E6');
    if ($('#hidden__field').is(':hidden')) {
      $('#hidden__field').css('display', 'inline-flex');
    }
  });

  function checkHiddenField() {
    let tin = $(this).val().trim();
    if (!/[0-9]+$/.test(tin) || tin.length > 8) {
      $(this).closest('label').addClass('mdc-text-field--invalid');
      tin = tin.slice(0, -1);
      $(this).val(tin);
    }
    if (tin.length === 8) {
      $('.registration__button').removeClass('disabled__button');
      $('.registration__button').attr('type', 'submit');
    } else {
      $('.registration__button').addClass('disabled__button');
      $('.registration__button').attr('type', 'button');
    }
  }

  $('#TIN-organization').on('input', checkHiddenField);


  // для #create__password
  $('.toggle-password').on('click', function() {
    var passwordField = $('#password');
    if (passwordField.attr('type') === 'password') {
      passwordField.attr('type', 'text');
      $(this).text('visibility_off');
    } else {
      passwordField.attr('type', 'password');
      $(this).text('visibility');
    }
  });
  
  $('.toggle-password-confirm').on('click', function() {
    var passwordField = $('#password-confirm');
    if (passwordField.attr('type') === 'password') {
      passwordField.attr('type', 'text');
      $(this).text('visibility_off');
    } else {
      passwordField.attr('type', 'password');
      $(this).text('visibility');
    }
  });
  
  mdc.autoInit();

  
  const form = $('#form__create-password');
  const passwordInput = $('#password');
  const confirmPasswordInput = $('#password-confirm');
  const textField = $('.custom-input__field');
  const errorMessage = $('#registration__error-message');
  const errorMessageDoNotMatch = $('#registration__error-message__doNotMatch');
  const conditionMessage = $('.registration__condition');
  const errorIcon = $('.error-icon');
  
  form.on('submit', function (event) {
    event.preventDefault(); 
  
    const passwordValue = passwordInput.val().trim();
    const confirmPasswordValue = confirmPasswordInput.val().trim();
  
    if (passwordValue.length < 8) {
      // Пароль не відповідає умові
      textField.addClass('mdc-text-field--invalid');
      // errorMessage.css('display', 'block');
      // conditionMessage.css('display', 'none');
      // errorIcon.css('display', 'block');
      // errorMessageDoNotMatch.css('display', 'none');
    } else if (passwordValue !== confirmPasswordValue) {
      // Паролі не співпадають
      textField.addClass('mdc-text-field--invalid');
      // errorMessage.css('display', 'none');
      // conditionMessage.css('display', 'block');
      // errorIcon.css('display', 'block');
      // errorMessageDoNotMatch.css('display', 'block');
    } else {
      // Пароль відповідає умові і співпадає з підтвердженням
      textField.removeClass('mdc-text-field--invalid');
      // errorMessage.css('display', 'none');
      // conditionMessage.css('display', 'block');
      // errorIcon.css('display', 'none');
      // errorMessageDoNotMatch.css('display', 'none');
    }
  });

  passwordInput.on('input', function () {
    var currentTextField = $(this).closest(textField);
    var currentErrorIcon = currentTextField.find(errorIcon);


    if ($(passwordInput).valid) {
      currentTextField.addClass('mdc-text-field--invalid');
      currentErrorIcon.css('display', 'block');
    } else {
      currentTextField.removeClass('mdc-text-field--invalid');
      currentErrorIcon.css('display', 'none');
    }
  });

  confirmPasswordInput.on('input', function () {
    var currentTextField = $(this).closest(textField);
    var currentErrorIcon = currentTextField.find(errorIcon);
  
    if ($(confirmPasswordInput).valid) {
      currentTextField.addClass('mdc-text-field--invalid');
      currentErrorIcon.css('display', 'block');
    } else {
      currentTextField.removeClass('mdc-text-field--invalid');
      currentErrorIcon.css('display', 'none');
    }
  });


  // для .gender__modal
  $('.gender__modal-wrapper').click(function (event) {
    event.stopPropagation();
    $(this).find('.gender__modal-list').slideToggle(200);
  });

    $(document).click(function () {
      $('.gender__modal-list').slideUp(200);
    });

  $('.gender__modal-list__item').on('click', function () {
    var selectedValue = $(this).text();
    $('#gender').val(selectedValue);
    $('.gender__modal-buttons__confirm').removeClass('disabled__button');
    $('.gender__modal-buttons__confirm').attr('type', 'submit');
  });

  // відкриття модалки
  // замість element своє значення підставити
  $('.element').click(function() {
    $('.gender__modal').css('display', 'flex');
  });

  // закриття модалки
  $('.gender__modal-close').click(function() {
    $('.gender__modal').hide();
  });

  // закриття модалки
  $('.gender__modal-buttons__cancel').click(function() {
    $('.gender__modal').hide();
  });

  // відкриття повідомлення
  // замість element своє значення підставити
  $('.element').click(function(){
    $('.registration__message').css('display', 'flex');
  });

  // закриття повідомлення
  $('.registration__message button').click(function(){
    $('.registration__message').hide();
  });
})
