jQuery(document).ready(function ($) {
  $('.element').click(function() {
    $('.submit').css('display', 'flex');
  })

  $('.element').click(function() {
    $('.submit').hide();
  })
})