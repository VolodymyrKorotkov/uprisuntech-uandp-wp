jQuery(document).ready(function ($) {
  var inputElement = $('#filterTypes');
  // var isDocument = $('body').is('.page-template-documets');

  function onChangeTypes(newValue) {
    const tmp = window.location.href.split('?');
    let url = tmp[0];
    const params = (tmp[1] ? tmp[1].split('&') : []).filter(_i => _i.indexOf('types') < 0);
    // console.log("🚀 ~ file: documets.js:9 ~ onChangeTypes ~ params:", params)
    // console.log("🚀 ~ file: documets.js:11 ~ onChangeTypes ~ newValue:", newValue)

    if(newValue){
      url = url + '?types=' + encodeURIComponent(newValue);
    }
    if(params.length){
      params.forEach(_i => {
        url = url + ( url.indexOf('?') > -1 ? '&' : '?') + _i;
      });
    }
    setTimeout(function() {
      history.replaceState({}, document.title, url);
    },500)

    $('.documents-items .container').load(url +' .documents_list+.row',function (){
      if($('.select__btn span').length){
        // $('.select__btn').append(`<span id="resetFilter"><img src="/wp-content/themes/vh_ndp/assets/img/icon/close.svg" alt="Remove Tag"></span>`);
      }else{
        $('#resetFilter').remove();
      }
    });

  }



  $(document).on('click', '.types-search-container .select__item', function () {
    var newValue = inputElement.val();
    onChangeTypes(newValue);
  })
  $(document).on('click', '.types-search-container .remove-tag', function (e) {
    e.preventDefault();
    let $removeTag = $(this);
    let text= $removeTag.parent().text();

    let $hoverContainer = $removeTag.closest('.wrapper-hover-block__container');
    if ($hoverContainer.length) {
      if ($hoverContainer.find('.tag-inner').length === 1) {
        $('.select__btn').find('.more-hover').remove()
      }
    } else {
      $removeTag.parent().remove();
    }
    //remove more wrapper
    if (!$('.tag-inner').parent('.select__btn').length && $('.select__btn').find('.more-hover').length) {
      $('.select__btn').find('.more-hover').find('.tag-inner').appendTo('.select__btn');
      $('.select__btn').find('.more-hover').remove()
    }

    var newValue = inputElement.val();

    newValue = newValue.split(',');
    let index = newValue.indexOf(text);
    newValue.splice(index, 1);
    inputElement.val(newValue.join(','))

    if($('.remove-tag').length==0 && $('.count').length==0){
      newValue="";
      $('#resetFilter').remove()
      onChangeTypes(newValue);
      $('.select__item').removeClass('active');
    }else{
      $(`.select__item[data-sort-by="${text}"]`).removeClass('active');
      onChangeTypes(newValue.join(','));
    }
  })



  $(document).on('click','#resetFilter',function (){
    onChangeTypes("");
    $('.select__item').removeClass('active');
    $('.select__btn').empty();
    $('.select__list').hide();
  });
})
$ = jQuery;
$(function (){
  setTimeout(function (){$('.page-template-documets .select__btn').click();

    },1000);

  $(document).on('click','.archive #resetFilter',function(){
    window.location.href=window.location.origin + window.location.pathname;
  });
// Функция для создания или удаления span в зависимости от его наличия
  function updateSpanElement() {
    const selectBtn = document.querySelector('.select__btn');
    const existingSpan = selectBtn.querySelector('span');

    if (existingSpan) {
      const resetFilter = document.getElementById('resetFilter');
      if (!resetFilter) {
        const span = document.createElement('span');
        span.id = 'resetFilter';

        const img = document.createElement('img');
        img.src = '/wp-content/themes/vh_ndp/assets/img/icon/close.svg';
        img.alt = 'Remove Tag';

        span.appendChild(img);
        selectBtn.appendChild(span);
      }
    } else {
      const resetFilter = document.getElementById('resetFilter');
      if (resetFilter) {
        resetFilter.remove();
      }
    }
  }

// Инициализация MutationObserver
  const observer = new MutationObserver(function (mutations) {
    mutations.forEach(function (mutation) {
      if (mutation.type === 'childList') {
        updateSpanElement();
      }
    });
  });

// Выбор элемента для отслеживания изменений
  const targetNode = document.querySelector('.select__btn');

// Определение конфигурации observer (что именно следим)
  const config = {
    childList: true
  };

// Начало отслеживания изменений в заданном элементе или узле
  targetNode && observer.observe(targetNode, config);

});
