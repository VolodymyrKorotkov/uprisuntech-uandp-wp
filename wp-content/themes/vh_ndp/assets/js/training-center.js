jQuery(document).ready(function ($) {
$("#partner").owlCarousel({
  items: 6,
  nav: true,
  dots: true,
  dotsEach:true,
  navText: [`<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <mask id="mask0_2461_1957" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
    <rect width="24" height="24" fill="#D9D9D9"/>
    </mask>
    <g mask="url(#mask0_2461_1957)">
    <path d="M14.4 18L8.4 12L14.4 6L15.675 7.275L10.95 12L15.675 16.725L14.4 18Z" fill="#131316"/>
    </g>
    </svg>`, `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
    <mask id="mask0_2461_1968" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
    <rect width="24" height="24" fill="#D9D9D9"/>
    </mask>
    <g mask="url(#mask0_2461_1968)">
    <path d="M13.05 12L8.325 7.275L9.6 6L15.6 12L9.6 18L8.325 16.725L13.05 12Z" fill="#131316"/>
    </g>
    </svg>`],
  responsive: {
    0: {
      items: 2,
    },
    768: {
      items: 6,
    },
  }
});

  $('.wizard__options-button__select').on('click', function(event) {
    let $target = $(event.target);
    let $wizardItem = $target.closest('.wizard__options-item');
    $wizardItem.find('.wizard__options-list').removeClass('hidden');
    $wizardItem.find('.hidden').removeClass('hidden');
    $target.addClass('hidden');
    $wizardItem.find('.wizard__options-button__save').removeClass('hidden');
    $wizardItem.find('.wizard__nothing').addClass('hidden');
  });

  $('.wizard__options-button__save').on('click', function(event) {
    let $target = $(event.target);
    let $wizardItem = $target.closest('.wizard__options-item');
    let $checked = $wizardItem.find('input:checkbox:checked');
    if ($checked.length) {
      $wizardItem.find('input:checkbox:not(:checked)').closest('label').addClass('hidden')
      $wizardItem.find('input:checkbox').addClass('hidden')
      $target.addClass('hidden');
      $wizardItem.find('.wizard__options-button__select').removeClass('hidden');
    }
  })


  let $wizardButton = $('.wizard__button');

  //checkbox click
  $(document).on('click', '.wizard__options-list__input', function (event) {
    let $target = $(event.target);
    let currentLang = $('.wizard').attr('data-lang') || 'uk';
    let $wizardItem = $target.closest('.wizard__options-item');
    if (!$target.is('.js-not-sure')) {
      if ($target.prop('checked')) {
        $wizardItem.find('.js-not-sure').prop('checked',false);
      } else {
        if (!$wizardItem.find('input:checkbox:checked').length) {
          $wizardItem.find('.js-not-sure').prop('checked',true)
        }
      }
    } else {
      $wizardItem.find('input:checkbox:checked:not(.js-not-sure)').prop('checked', false)
    }

    //Выбрано в 3х колонках
    if (checkWizardColumns() === 3) {
      let filterParams = {};
      $wizardButton.addClass('wizard__button-active');

      $('.wizard__options-item').each(function(index, item) {
        let $optionsItem = $(item);
        let $inputs = $optionsItem.find('input:checkbox:checked');
        $inputs.each(function(i, input) {
          let id = $(input).val();
          let question = getQuestion(id);
          if (question) {
            let filters = question['filters_'+currentLang];
            for (let type in filters) {
              if (!filterParams.hasOwnProperty(type)) {
                filterParams[type] = [];
              }
              for (let j=0; j < filters[type].length; j++) {
                let value = filters[type][j]['value'];
                if (!filterParams[type].includes(value)) {
                  filterParams[type].push(value)
                }
              }
            }
          }
        })
      });
      let httpGetParams = http_build_query(filterParams);
      if (httpGetParams) {
        let pathname = document.location.pathname;
        let langArray = pathname.match(/^(\/en|\/uk)\//);
        let lang = '';
        if (langArray && langArray.length > 1) {
          lang = langArray[1];
        }
        $wizardButton.attr('href', lang+'/courses/?'+httpGetParams)
      }

    } else {
      $wizardButton.removeClass('wizard__button-active')
    }
  });

  //get-параметры фильтра
  function http_build_query(obj, num_prefix, temp_key) {

    let output_string = [];

    Object.keys(obj).forEach(function (val) {

      let key = val;

      num_prefix && !isNaN(key) ? key = num_prefix + key : ''

      key = encodeURIComponent(key.replace(/[!'()*]/g, escape));
      temp_key ? key = temp_key + '[' + key + ']' : ''

      if (typeof obj[val] === 'object') {
        let query = http_build_query(obj[val], null, key)
        output_string.push(query)
      }

      else {
        let value = encodeURIComponent(obj[val].replace(/[!'()*]/g, escape));
        key = encodeURI(key);
        value = encodeURI(value);
        output_string.push(key + '=' + value)
      }

    })

    return output_string.join('&')
  }

  function checkWizardColumns() {
    let $checkedColumns = $('.wizard__options-item').filter(function(i,el) {
      let $checked = $(el).find('input:checkbox:checked');
      return $checked.length
    });

    return $checkedColumns.length
  }

  function getQuestion(id) {
    if (!id) return;

    for (let i=0; i < questionsArray.length; i++) {
      let question = questionsArray[i];
      if (question['id'] === id) {
        return question;
      }
    }
  }

})