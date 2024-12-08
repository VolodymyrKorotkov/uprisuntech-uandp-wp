jQuery(document).ready(function ($) {

  document.querySelectorAll('.mdc-text-field').forEach((node) => {
    mdc.textField.MDCTextField.attachTo(node);
  });
  var scrollContainer = $('.table-overlay');
  var isMouseDown = false;
  var startX, scrollLeft;

  scrollContainer.on('mousedown', function(e) {
    isMouseDown = true;
    startX = e.pageX - scrollContainer.offset().left;
    scrollLeft = scrollContainer.scrollLeft();
  });

  scrollContainer.on('mouseleave', function() {
    isMouseDown = false;
  });

  scrollContainer.on('mouseup', function() {
    isMouseDown = false;
  });

  scrollContainer.on('mousemove', function(e) {
    if (!isMouseDown) return;
    e.preventDefault();
    var x = e.pageX - scrollContainer.offset().left;
    var walk = (x - startX);
    scrollContainer.scrollLeft(scrollLeft - walk);
  });

  $('.municipalityProfile__title-button').click(function(){
    $('#modal__send-message').css('display', 'flex');
    $('body').css('overflow', 'hidden');
  });

  $('.municipalityProfile__title-button__mobile').click(function(){
    $('#modal__send-message').css('display', 'flex');
    $('body').css('overflow', 'hidden');
  });

  $('.municipalityProfile__representatives span').click(function(){
    $('#modal__invite').css('display', 'flex');
    $('body').css('overflow', 'hidden');
  });

  $('.municipalityProfile__modal-close').click(function(){
    $('.municipalityProfile__modal').hide();
    $('body').css('overflow', '');
  });

  $('.municipalityProfile__modal-buttons__cancel').click(function(){
    $('.municipalityProfile__modal').hide();
    $('body').css('overflow', '');
  });

  $('.municipalityProfile__message button').click(function(){
    $('.municipalityProfile__message').hide();
  });

  $('.municipalityProfile__modal').each(function() {
    var $modal = $(this);
  
    $modal.find('.mdc-text-field__input').on('input', function() {
      var allInputsFilled = $modal.find('.mdc-text-field__input').filter(function() {
        return $(this).val() !== "";
      }).length === $modal.find('.mdc-text-field__input').length;
  
      if (allInputsFilled) {
        $modal.find('.modal__button').removeClass('disabled__button');
        $modal.find('.modal__button').attr('type', 'submit');
      } else {
        $modal.find('.modal__button').addClass('disabled__button');
        $modal.find('.modal__button').attr('type', 'button');
      }
    });
  });

    const form = $('#modal__invite-form');
    const input = $('#email');
    const textField = $('.custom-input__field');
    const errorMessage = $('.error-message');
    const errorIcon = $('.error-icon');
    const mailIcon = $('.mail-icon');

    form.on('submit', function() {
      var inputValue = $(input).val().trim();

      if (inputValue !== '123') { // ВАЛІДАЦІЯ ДЛЯ ПРИКЛАДУ
        $(textField).addClass('mdc-text-field--invalid');
        $(errorMessage).css('display', 'block');
        $(errorIcon).css('display', 'block');
        $(mailIcon).css('display', 'none');
      } else {
        $(textField).removeClass('mdc-text-field--invalid');
        $(errorMessage).css('display', 'none');
        $(errorIcon).css('display', 'none');
        $(mailIcon).css('display', 'block');
      }
    });

    input.on('input', function() {
      if ($(input).valid) {
        $(textField).addClass('mdc-text-field--invalid');
        $(errorMessage).css('display', 'block');
        $(errorIcon).css('display', 'block');
        $(mailIcon).css('display', 'none');
      } else {
        $(textField).removeClass('mdc-text-field--invalid');
        $(errorMessage).css('display', 'none');
        $(errorIcon).css('display', 'none');
        $(mailIcon).css('display', 'block');
      }
    });
  
})