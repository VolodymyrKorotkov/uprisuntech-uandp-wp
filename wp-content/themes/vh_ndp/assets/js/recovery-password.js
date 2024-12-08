const foos = [].map.call(document.querySelectorAll('.mdc-text-field'), function (el) {
  return new mdc.textField.MDCTextField(el);
});
const textField = new mdc.textField.MDCTextField(document.querySelector('.mdc-text-field'));
const input = document.getElementById('email');
const errorIcon = document.querySelector('.error-icon'); 
const errorMessage = document.querySelector('.recovery-password__error-message');


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