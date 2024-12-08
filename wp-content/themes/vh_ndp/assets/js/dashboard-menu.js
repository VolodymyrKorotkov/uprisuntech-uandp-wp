jQuery(document).ready(function ($) {
  $('.profile-settings__personalData-wrapper').click(function (event) {
    event.stopPropagation();
    $(this).find('.profile-settings__personalData-list').toggle();
    });
    $(document).click(function () {
        $('.profile-settings__personalData-list').hide();
    });
  const foo = [].map.call(document.querySelectorAll('.mdc-text-field'), function (el) {
    return new mdc.textField.MDCTextField(el);
  })
  $('.profile-settings__out').click(function(){
    $('#modal__logout').addClass('active-modal');
    $('body').css({'overflow': 'hidden'});
  });
  $('#edit-email').click(function(){
    $('#modal__emailChange').addClass('active-modal');
    $('body').css({'overflow': 'hidden'});
  });
  $('.profile-settings__modal-close').click(function(){
    $('#modal__logout').removeClass('active-modal');
    $('#modal__emailChange').removeClass('active-modal');
    $('body').css({'overflow': ''});
  });
  $('.profile-settings__modal-cancel').click(function(){
    $('#modal__logout').removeClass('active-modal');
    $('#modal__emailChange').removeClass('active-modal');
    $('body').css({'overflow': ''});
  });

  // Відкривається меню по кліку
  $('.test').click(function(event){
    $('.account__nav-mobile__overlay').show();
    event.stopPropagation();
  });

  // Закривається якшо клік за межами меню
  $(document).click(function(event) {
    if (!$(event.target).closest('.account__nav-mobile').length) {
        if ($('.account__nav-mobile__overlay').is(':visible')) {
            $('.account__nav-mobile__overlay').hide();
        }
    }
  });
})