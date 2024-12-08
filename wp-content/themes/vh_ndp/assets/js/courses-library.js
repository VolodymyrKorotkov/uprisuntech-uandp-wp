jQuery(document).ready(function ($) {

  let $filterBlock = $('.library__filter');

  $('.library__sort-block').click(function(){
    $('.library__sort-list').toggle(300);
    $('.library__sort-button').toggleClass('rotate180');
    $(this).toggleClass('active');
    $('.library__sort-text').toggleClass('active');
  });

  $(document).click(function(e) {
    if (!$(e.target).closest('.library__sort-block').length) {
      $('.library__sort-block').removeClass('active');
      $('.library__sort-text').removeClass('active');
      if ($('.library__sort-list').is(':visible')) {
        $('.library__sort-list').toggle(300);
      }
    }
  });

  //Сортировка курсов
  $('.library__sort-list__item').on('click', function(event) {
    let $target = $(event.target);
    let sort = $target.attr('data-sort');

    if (!sort) return;

    $('.library__sort-list__item-current').removeClass('library__sort-list__item-current');
    $target.addClass('library__sort-list__item-current');
    $('.library__sort-current').text(courseSortArray[sort]);

    let pathname = window.location.pathname;

    let data = {};

    let filtersTax = getCheckedFilterInputValuesByTaxonomy();
    let filtersMeta = getCheckedFilterInputValuesMetaValues();
    let filtersPost = getCheckedFilterInputPostValues();

    if (Object.keys(filtersTax).length) {
      data['filtersTax'] = filtersTax;
    }
    if (Object.keys(filtersMeta).length) {
      data['filtersMeta'] = filtersMeta;
    }
    if (Object.keys(filtersPost).length) {
      data['filtersPost'] = filtersPost;
    }
    if (!Object.keys(data).length) {
      $('.js-filter-count').removeClass('visible')
          .text('');
    }

    data['sort'] = sort;
    data['template'] = true;
    data['pathname'] = pathname;
    data['courseType'] = getCourseType();
    data['user_role'] = getUserRole();

    addSpinner($target, $target);

    getFilteredCourses(data, 'sortCoursesAction').then((response) => {
      // console.log(response);
      if (!response || !response.hasOwnProperty('courses')) return;

      removeSpinner($target, $target);

      clearUrlHistory();
      updateCoursesWithPagination(response);

      if (response.hasOwnProperty('httpGetFilterParams')) {
        let urlParamsPathname = location.pathname;
        let httpGetFilterParams = response['httpGetFilterParams'];
        let url = httpGetFilterParams? urlParamsPathname + "?" + httpGetFilterParams : urlParamsPathname;
        history.replaceState({}, document.title, url);

        updateCheckboxesTags(response['httpGetFilterParams']);
      }

      if (response.hasOwnProperty('coursesCount')) {
        updatePostsCount(response['coursesCount']);
      }

    });

  })

  $(".library__filter-add__button").click(function (event) {
    let $target = $(event.target);
    $target.removeClass('active')
        .closest('.library__filter-section__list').find('.hidden').removeClass('hidden')
  });
  $('.library__navigation-mobile__filter').click(function(){
    $filterBlock.addClass('filter-active');
    $('.library__filter-overlay').addClass('overlay-active');
    $('body').css({'overflow': 'hidden', 'padding-right': '17px'});
  });
  $('.library__filter-close').click(function(){
    $filterBlock.removeClass('filter-active');
    $('.library__filter-overlay').removeClass('overlay-active');
    $('body').css({'overflow': '', 'padding-right': ''});
  });
  $('.library__filter-show').click(function(){
    $filterBlock.removeClass('filter-active');
    $('.library__filter-overlay').removeClass('overlay-active');
    $('body').css({'overflow': '', 'padding-right': ''});
  });


  //Подготовка value выбранных чекбоксов в фильтре для ajax
  //tax_query
  function getCheckedFilterInputValuesByTaxonomy(filterBlock=null) {
    let filters = {};

    $filterBlock = filterBlock || $filterBlock;
    $filterBlock.find('input:checkbox:checked').each(function(i, input) {
      let $input = $(input);
      let type = $input.closest('.library__filter-section').attr('data-type') || '';
      if (!type || type !== 'taxonomy') return;

      let taxonomy = $input.attr('data-taxonomy');
      let value = $input.val() || '';
      if (!taxonomy || !value) return false;

      if (!filters.hasOwnProperty(taxonomy)) {
        filters[taxonomy] = [];
      }
      filters[taxonomy].push(value);
    });

    return filters;
  }

  //meta_query
  function getCheckedFilterInputValuesMetaValues(filterBlock=null) {
    let filters = {};

    $filterBlock = filterBlock || $filterBlock;
    $filterBlock.find('input:checkbox:checked').each(function(i, input) {
      let $input = $(input);
      let $parent = $input.closest('.library__filter-section');
      let type = $parent.attr('data-type') || '';
      let meta_key = $input.attr('data-meta_key') || '';
      if (!type || !type === 'meta' || !meta_key) return;

      let value = $input.val() || '';
      if (!value) return false;

      if (!filters.hasOwnProperty(meta_key)) {
        filters[meta_key] = [];
      }
      filters[meta_key].push(value);
    });

    return filters;
  }

  //post data (post_author, post_type)
  function getCheckedFilterInputPostValues(filterBlock=null) {
    let filters = {};

    $filterBlock = filterBlock || $filterBlock;
    $filterBlock.find('input:checkbox:checked').each(function(i, input) {
      let $input = $(input);
      let $parent = $input.closest('.library__filter-section');
      let type = $parent.attr('data-type') || '';
      let inputType = $input.attr('data-input-type') || '';
      let value = $input.val() || '';
      if (!type || type !== 'postType' || !inputType || !value) return;

      if (!filters.hasOwnProperty(inputType)) {
        filters[inputType] = [];
      }
      filters[inputType].push(value);
    });

    return filters;
  }

//ajax, Получение отфильтрованных курсов
  function getFilteredCourses(dataOptions={}, action = 'filterCoursesAction') {
    return new Promise(resolve => {

      let data = {
        action: action,
      };
      if (dataOptions) {
        data = {...data, ...dataOptions};
      }
      // console.log('data', data);

      $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: data,

        success: function(response) {
          // console.log('response', response);
          if (response && typeof response === 'object') {
            resolve(response);
          }
        },
        error: function (jqXHR, exception) {
          // console.log('error');
          // console.log(jqXHR);
          // console.log(exception);
        },
      });

    });
  }

  //Показ количества курсов в фильре при клике на чекбокс
  $filterBlock.find('input:checkbox').on('change', function (event) {
    event.preventDefault();

    let $target = $(event.target);
    let type = $target.closest('.library__filter-section').attr('data-type') || '';
    let $input = $target.closest('li').find('input');
    let slug = $input.val() || '';
    if (!type && !slug) return;

    let $filterCount = $('.js-filter-count');
    $filterCount.addClass('visible');

    let filtersTax = getCheckedFilterInputValuesByTaxonomy();
    let filtersMeta = getCheckedFilterInputValuesMetaValues();
    let filtersPost = getCheckedFilterInputPostValues();

    let data = {};
    if (Object.keys(filtersTax).length) {
      data['filtersTax'] = filtersTax;
    }
    if (Object.keys(filtersMeta).length) {
      data['filtersMeta'] = filtersMeta;
    }
    if (Object.keys(filtersPost).length) {
      data['filtersPost'] = filtersPost;
    }

    if (!Object.keys(data).length) {
      $('.js-filter-count').removeClass('visible')
          .text('');
      return false;
    }
    data['pathname'] = window.location.pathname;
    data['courseType'] = getCourseType();
    data['user_role'] = getUserRole();

    addSpinner('.js-btn-filter', '.js-btn-filter');

    getFilteredCourses(data).then((response) => {
      if (!response) return;

      removeSpinner('.js-btn-filter', '.js-btn-filter');

      updatePostsCount(response);
    });
  });

  //Показ выбранных курсов в фильтре (ajax)
  $('.js-btn-filter').on('click', function(event) {
    event.preventDefault();

    let $target = $(event.target);
    let pathname = window.location.pathname;

    let filtersTax = getCheckedFilterInputValuesByTaxonomy();
    let filtersMeta = getCheckedFilterInputValuesMetaValues();
    let filtersPost = getCheckedFilterInputPostValues();

    let data = {};

    if (Object.keys(filtersTax).length) {
      data['filtersTax'] = filtersTax;
    }
    if (Object.keys(filtersMeta).length) {
      data['filtersMeta'] = filtersMeta;
    }
    if (Object.keys(filtersPost).length) {
      data['filtersPost'] = filtersPost;
    }
    if (!Object.keys(data).length) {
      $('.js-filter-count').removeClass('visible')
          .text('');
      // return false;
    }

    data['template'] = true;
    data['pathname'] = pathname;
    data['courseType'] = getCourseType();
    data['user_role'] = getUserRole();

    addSpinner($target, $target);

    getFilteredCourses(data).then((response) => {
      if (!response || !response.hasOwnProperty('courses')) return;

      removeSpinner($target, $target);

      updateCoursesWithPagination(response);

      if (response.hasOwnProperty('httpGetFilterParams')) {
        clearUrlHistory();

        let urlParamsPathname = location.pathname;
        let httpGetFilterParams = response['httpGetFilterParams'];
        let url = httpGetFilterParams? urlParamsPathname + "?" + httpGetFilterParams : urlParamsPathname;
        history.replaceState({}, document.title, url);

        updateCheckboxesTags(response['httpGetFilterParams']);
      }

      if (response.hasOwnProperty('coursesCount')) {
        updatePostsCount(response['coursesCount']);
      }
    });

  });

  //Сброс фильтра
  $('.js-filter-reset').on('click', function(event) {
    event.preventDefault();

    let $target = $(event.target);
    $filterBlock.find('input:checkbox:not(:disabled)').prop('checked',false);
    $('.js-filter-count').removeClass('visible')
        .text('');

    let urlPath = location.pathname.replace(/page\/[0-9]+\/\??/,'')
    history.replaceState({}, document.title, urlPath);

    let data = {
      template: true,
      pathname: window.location.pathname,
    }

    data['courseType'] = getCourseType();
    data['user_role'] = getUserRole();

    addSpinner($target, $target);

    getFilteredCourses(data).then((response) => {
      // console.log(response);
      if (!response) return;

      removeSpinner($target, $target);

      let $tagsWrapper = $('.library__tags');
      $tagsWrapper.find('.library__tags-item').not('.library__tags-item__clear').remove();

      updateCoursesWithPagination(response);
    });
  });


  //Обновление курсов, полученных по ajax
  function updateCoursesWithPagination(data, $wrapper = $('.library__course')) {
    let $main = $wrapper.length? $wrapper : $('.library__course');

    if (data.hasOwnProperty('courses')) {
      $main.html(data['courses']);
    }

    if (data.hasOwnProperty('pagination')) {
      let $parent = $main.closest('.library__content');
      $parent.find('.pagination').remove();
      $parent.append(data['pagination'])
    }
  }

  function updateCheckboxesTags(filter) {
    let urlParams = new URLSearchParams(filter);
    let httpGetParams = Object.fromEntries(urlParams);
    let $tagsWrapper = $('.library__tags');
    $tagsWrapper.find('.library__tags-item').not('.library__tags-item__clear').remove();

    $filterBlock.find('.library__filter-section').each(function(i,el) {
      let $el = $(el);
      let title = $el.find('.library__filter-section__title').text() || '';
      let inputType = $el.find('input:first').attr('data-input-type') || '';
      if (inputType && !$tagsWrapper.find('[data-input-type="'+inputType+'"]').length) {

        let $tagsItem = $('<div class="library__tags-item" data-input-type="'+inputType+'"><h3 class="library__tags-title">'+title+':</h3><div class="library__tags-block"></div></div>');
        $tagsWrapper.prepend($tagsItem)
      }
    });

    if (Object.keys(httpGetParams).length) {

      let filtersTax = getCheckedFilterInputValuesByTaxonomy();
      let filtersMeta = getCheckedFilterInputValuesMetaValues();
      let filtersPost = getCheckedFilterInputPostValues();
      let filters = {...filtersTax, ...filtersMeta, ...filtersPost};

      Object.keys(filters).forEach(function(item) {
        let $tagsItem = $tagsWrapper.find('.library__tags-item[data-input-type="'+item+'"]');
        if ($tagsItem.length) {
          Object.keys(filters[item]).forEach(function(tagSlug) {
            let value = filters[item][tagSlug];
            let $input = $filterBlock.find('input[data-input-type="'+item+'"][value="'+value+'"');
            let name = value;
            if ($input.length && $input.next('span').length) {
              name = $input.next('span').text() || value;
            }
            let $tag = $('<div class="library__tags-block__item" data-input="'+item+'" data-value="'+value+'"><span class="library__tags-block__name">'+name+'</span><button class="library__tags-block__button"></button></div>')

            $tagsItem.addClass('active');
            $tagsItem.find('.library__tags-block').append($tag);
          })

        }
      });

    }
  }

  function updatePostsCount(response) {
    if (!response || !Array.isArray(response)) return 0;

    let $filterCount = $('.js-filter-count');
    if (!$filterCount.length) return;

    let count = response.length;
    count = count >=0? count : 0;
    $filterCount.text('('+count+')')
  }

  let urlParams = new URLSearchParams(location.search);
  let httpGetParams = Object.fromEntries(urlParams);
  if (Object.keys(httpGetParams).length) {
    updateCheckboxesTags(httpGetParams);
  }

  //Удаление выбранных тегов
  $(document).on('click', '.library__tags-block__button', function (event) {
    let $target = $(event.target);
    let $tag = $target.closest('.library__tags-block__item');

    if ($tag.is('.library__tags-block__item')) {
      let input = $tag.attr('data-input') || '';
      let value = $tag.attr('data-value') || '';
      if (input && value) {
        $tag.remove();
        let $input = $filterBlock.find('input[data-input-type="' + input + '"][value="' + value + '"]');
        if ($input.length) {
          $input.prop('checked', false);
          $('.js-btn-filter').click();
        }
      }
    }
  });


  //очистка выбранных тегов и чекбоксов в фильтре
  $(document).on('click', '.js-clear-filter', function (event) {
    let $target = $(event.target);
    addSpinner($target, '.js-clear-filter');
    $('.js-filter-reset').click()
  });


  function addSpinner($target, parent='.col') {
    $target = $($target);
    if (!$target.length) return;
    //removeSpinner($target,parent);

    $target.closest(parent)
        .addClass('position-relative')
        .append('<span class="spinner"></span>');
    setTimeout(function() {
      $target.closest(parent).find('.spinner').remove();
    },5000);
  }

  function removeSpinner($target, parent='.col') {
    $target = $($target);
    if (!$target.length) return;

    $target.closest(parent)
        .removeClass('position-relative')
        .find('.spinner').remove();
  }

  function clearUrlHistory() {
    let urlPath = location.pathname.replace(/page\/[0-9]+\//,'');
    history.replaceState({}, document.title, urlPath);
  }

  //Course or Survey?
  function getCourseType() {
    let type = 'course';
    if (typeof courseType !== 'undefined' && courseType) {
      type = courseType
    }
    return type;
  }
  function getUserRole() {
    let userRole = '';
    if (typeof user_role !== 'undefined' && user_role) {
      userRole = user_role
    }
    return userRole;
  }

})