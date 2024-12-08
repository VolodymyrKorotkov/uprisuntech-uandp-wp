jQuery(document).ready(function ($) {

  document.querySelectorAll('.mdc-text-field').forEach((node) => {
    mdc.textField.MDCTextField.attachTo(node);
  });

  const MDCSelect = mdc.select.MDCSelect;
  const select = new MDCSelect(document.querySelector('.mdc-select'));

  $('.mdc-list-item').on('click', function() {
    var selectedValue = $(this).text();
    $('.addMunicipality__selected-item').remove();
    $('.mdc-list-item').css('background-color', 'white');

    var newItem = $('<span class="addMunicipality__selected-item">' + selectedValue + '</span>');
    $('.addMunicipality__selected').append(newItem);
    $(this).css('background-color', '#E4E2E6');
    if ($('#hidden__field').is(':hidden')) {
      $('#hidden__field').css('display', 'inline-flex');
    }
  });

  $('.addMunicipality__message-button').click(function(){
    $('.addMunicipality__modal').css('display', 'flex');
    $('body').css('overflow', 'hidden');
  });

  $('.addMunicipality__modal-close').click(function(){
    $('.addMunicipality__modal').hide();
    $('body').css('overflow', '');
  });

  $('.addMunicipality__message button').click(function(){
    $('.addMunicipality__message').hide();
  });
})