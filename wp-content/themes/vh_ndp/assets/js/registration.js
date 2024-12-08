const foos = [].map.call(document.querySelectorAll('.mdc-text-field'), function (el) {
  return new mdc.textField.MDCTextField(el);
})
document.querySelector('.toggle-password').addEventListener('click', function() {
  var passwordField = document.getElementById('password');
  if (passwordField.type === 'password') {
      passwordField.type = 'text';
      this.textContent = 'visibility_off';
  } else {
      passwordField.type = 'password';
      this.textContent = 'visibility';
  }
});
document.querySelector('.toggle-password-confirm').addEventListener('click', function() {
  var passwordField = document.getElementById('password-confirm');
  if (passwordField.type === 'password') {
      passwordField.type = 'text';
      this.textContent = 'visibility_off';
  } else {
      passwordField.type = 'password';
      this.textContent = 'visibility';
  }
});
mdc.autoInit()
const textField = new mdc.textField.MDCTextField(document.querySelector('.mdc-text-field'));
const input = document.getElementById('email');
const errorIcon = document.querySelector('.error-icon'); 
const errorMessage = document.querySelector('.registration__error-message');


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


