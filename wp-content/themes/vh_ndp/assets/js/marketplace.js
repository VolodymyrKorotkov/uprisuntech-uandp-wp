jQuery(document).ready(function ($) {

    $('.modal-btn').on('click', function(event) {

        $('.modal, .modal__block').removeClass('active')
        $('body').css({'overflow': 'hidden', 'padding-right': '17px'});

        let modal = $(this).data('modal');
        let $modal = $('.modal__'+modal);

        if ($modal.length) {
            $('.modal').addClass('active');
            $($modal).addClass('active');
        }
    })

    $('.modal').on('click', function(event) {
        let $target = $(event.target);
        if ($target.is('.modal__close') || $target.is('.modal')) {
            $('.modal, .modal__block').removeClass('active')
            $('body').css({'overflow': '', 'padding-right': ''});
        }
    })

    const swiper = new Swiper('.swiper', {
        // Optional parameters
        mode: 'horizontal',
        loop: true,

        // If we need pagination
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        },

        // // Navigation arrows
        navigation: {
            nextEl: '.swiper-next-btn',
            prevEl: '.swiper-prev-btn',
        },

    });

    function swiperPagination() {
        let $swiperPagination = $('.swiper-pagination');
        if ($swiperPagination.length) {
            let prevPosition = $swiperPagination.find('span:first').position();
            let nextPosition = $swiperPagination.find('span:last').position();
            $('.swiper-prev-btn').css({left: prevPosition.left - 14 - 40, opacity: 1})
            $('.swiper-next-btn').css({left: nextPosition.left + 24 - 40, opacity: 1})
        }
    }
    swiperPagination()

    $(window).on('resize', function(){
        swiperPagination()
    });


    //Подготовка value выбранных чекбоксов для ajax
    function getCheckedFilterInputValues(filterBlock=null) {
        let filters = {};

        let $filterBlock = filterBlock || $('.filter-block');
        $filterBlock.find('input:checkbox:checked').each(function(i, input) {
            let $input = $(input);
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

    //Подготовка value и name выбранных чекбоксов для ajax
    function getCheckedFilterInputNames(filterBlock=null) {
        let filters = {};

        let $filterBlock = filterBlock || $('.filter-block');
        $filterBlock.find('input:checkbox:checked').each(function(i, input) {
            let $input = $(input);
            let taxonomy = $input.attr('data-taxonomy');
            let value = $input.val() || '';
            let name = $input.next('span').text() || '';
            if (!taxonomy || !value) return false;

            if (!filters.hasOwnProperty(taxonomy)) {
                filters[taxonomy] = {};
            }
            filters[taxonomy][value] = name;
        });

        return filters;
    }

    //Получение отфильтрованных товаров
    function getFilteredProducts(dataOptions={}, action = 'filterAction') {
        return new Promise(resolve => {

            let data = {
                action: action,
            };
            if (dataOptions) {
                data = {...data, ...dataOptions};
            }

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: data,
                success: function(response) {
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

    //Количество товаров в выпадающем списке
    $('.options__list').on('click', function(event) {
        event.preventDefault();

        let $target = $(event.target);
        let sortCount = $target.text();
        if (!sortCount) return;

        let $filterBlock = $('.filter-block');

        let category = $filterBlock.attr('data-category') || '';
        let pathname = window.location.pathname;
        let filters = getCheckedFilterInputValues();
        let data = {
            sortCount: sortCount,
            template: true,
            pathname: pathname,
        };

        //if product-category page
        if (category) {
            if (!filters.hasOwnProperty('product_cat')) {
                filters['product_cat'] = [category]
            } else if (typeof filters['product_cat'] !== 'undefined' && filters['product_cat'].length > 0) {
                filters['product_cat'].push(category);
            }
        }
        if (Object.keys(filters).length) {
            data['filters'] = filters;
        }

        if ($target.is('li')) {
            $filterBlock.attr('data-sortcount', sortCount);
            $target.closest('.options').find('.options__current').text(sortCount);

            getFilteredProducts(data).then((response) => {
                // console.log(response);
                if (!response) return;

                updateProductsWithPagination(response);
            });
        }
    });

    //Показ количества товаров в фильре при клике на чекбокс
    $('.filter-block').find('input:checkbox').on('change', function (event) {
        event.preventDefault();

        let $target = $(event.target);
        let $input = $target.closest('li').find('input');
        let taxonomy = $input.attr('data-taxonomy');
        let slug = $input.val() || '';
        if (!taxonomy && !slug) return;

        if (!$input.prop('checked')) {
            let $tag = $('.checkboxes__item[data-taxonomy="' + taxonomy + '"][data-term-slug="' + slug + '"]');
            if ($tag.length) {
                $tag.remove();
            }
        }

        let $filterCount = $('.js-filter-count');
        $filterCount.addClass('visible');

        let filters = getCheckedFilterInputValues();
        if (!Object.keys(filters).length) {
            $('.js-filter-count').removeClass('visible')
                .text('');
            return false;
        }

        let data = {
            filters: filters,
        }
        getFilteredProducts(data).then((response) => {
            // console.log(response);
            if (!response) return;

            let count = response.length;

            count = count >=0? count : 0;
            $filterCount.text('('+count+')')
        });
    });

    function addSpinner($target, parent='.col') {
        if (!$target.length) return;

        $target.closest(parent)
            .addClass('position-relative')
            .append('<span class="spinner"></span>');
        setTimeout(function() {
            $target.closest(parent).find('.spinner').remove();
        },5000);
    }

    function removeSpinner($target, parent='.col') {
        if (!$target.length) return;

        $target.closest(parent)
            .removeClass('position-relative')
            .find('.spinner').remove();
    }

    //Показ выбранных товаров в фильтре (ajax)
    $('.js-btn-filter').on('click', function(event) {
        event.preventDefault();

        let $target = $(event.target);
        let filters = getCheckedFilterInputValues();
        let $filterBlock = $('.filter-block');
        let sortCount = +$filterBlock.attr('data-sortcount') || 15;
        let pathname = window.location.pathname;
        let category = $filterBlock.attr('data-category') || '';
        let data = {
            template: true,
            pathname: pathname,
            sortCount: sortCount,
        }
        if (Object.keys(filters).length) {
            data['filters'] = filters;
        }
        if (category) {
            data['category'] = category;
        }

        addSpinner($target);

        getFilteredProducts(data).then((response) => {
            // console.log(response);
            if (!response || !response.hasOwnProperty('products')) return;

            removeSpinner($target);

            updateProductsWithPagination(response);

            if (response.hasOwnProperty('httpGetFilterParams')) {
                let urlParamsPathname = location.pathname;
                let httpGetFilterParams = response['httpGetFilterParams'];
                let url = httpGetFilterParams? urlParamsPathname + "?" + httpGetFilterParams : urlParamsPathname;
                history.replaceState({}, document.title, url);

                updateCheckboxesTags(response['httpGetFilterParams']);
            }
        });

    });


    //Сброс фильтра
    $('.js-filter-reset').on('click', function(event) {
        event.preventDefault();

        let $target = $(event.target);
        let $filterBlock = $('.filter-block');

        $target.closest('.modal__block').find('input:checkbox:not(:disabled)').prop('checked',false);
        // $('.modal-section').find('input:checkbox').prop('checked',false);
        $('.js-filter-count').removeClass('visible')
            .text('');

        let urlPath = location.pathname.replace(/page\/[0-9]+\/\??/,'')
        history.replaceState({}, document.title, urlPath);

        let sortCount = +$filterBlock.attr('data-sortcount') || 15;

        let data = {
            template: true,
            sortCount: sortCount,
            pathname: window.location.pathname,
        }
        let category = $filterBlock.attr('data-category') || '';
        if (category) {
            data['category'] = category;
        }

        let filters = getCheckedFilterInputValues();
        if (Object.keys(filters).length) {
            data['filters'] = filters;
        }

        addSpinner($target);

        getFilteredProducts(data).then((response) => {
            // console.log(response);
            if (!response) return;

            removeSpinner($target);

            $('.checkboxes__wrap').removeClass('active');
            $('.checkboxes__tags').empty();

            updateProductsWithPagination(response);
            $('.modal__filter.active').find('.modal__close').trigger('click');
        });
    });

    $('.js-clear-filter').on('click', function(event) {
        let $target = $(event.target);
        addSpinner($target, '.clear-filter');
        $('.js-filter-reset').click()
    });

    //Обновление товаров, полученных по ajax
    function updateProductsWithPagination(data, $wrapper = $('.main__content.container')) {
        let $main = $wrapper.length? $wrapper : $('.main__content.container');

        if (data.hasOwnProperty('products')) {
            $main.find('.row').html(data['products']);
        }

        if (data.hasOwnProperty('pagination')) {
            $main.find('.pagination').remove();
            $main.append(data['pagination'])
        }

        if (data.hasOwnProperty('category_description')) {
            let $info = $('.categories-info');
            if ($info.length) {
                $info.find('.categories-info__block').html(data['category_description'])
            }
        }

        $('.modal__filter.active').find('.modal__close').trigger('click');
    }

    function updateCheckboxesTags(filter) {

        let urlParams = new URLSearchParams(filter);
        let httpGetParams = Object.fromEntries(urlParams);

        if (Object.keys(httpGetParams).length) {

            let filters = getCheckedFilterInputNames();
            let $checkboxesWrap = $('.checkboxes__wrap');
            $checkboxesWrap.removeClass('active');
            $checkboxesWrap.find('.checkboxes__tags').empty();
            Object.keys(filters).forEach(function(taxonomy) {

                let $tagsWrap = $('.checkboxes__wrap[data-taxonomy*="'+taxonomy+'"]');

                Object.keys(filters[taxonomy]).forEach(function(tagSlug) {
                    let name = filters[taxonomy][tagSlug];
                    let $tag = $('<div class="checkboxes__item" data-taxonomy="'+taxonomy+'" data-term-slug="'+tagSlug+'"><span>'+name+'</span><i class="bt-close"></i></div>');

                    if ($tagsWrap.length) {
                        $tagsWrap.addClass('active');
                        $tagsWrap.find('.checkboxes__tags').append($tag);
                    }
                })

            });

            $('.checkboxes__wrap:not(.active)').find('.checkboxes__tags').empty()
        }
    }

    //Удаление выбранных тегов
    $(document).on('click', '.bt-close', function (event) {
        let $target = $(event.target);
        let $tag = $target.closest('.checkboxes__item');

        if ($tag.is('.checkboxes__item')) {
            let taxonomy = $tag.attr('data-taxonomy') || '';
            let slug = $tag.attr('data-term-slug') || '';
            if (taxonomy && slug) {
                $tag.remove();
                let $input = $('.filter-block').find('input[data-taxonomy="' + taxonomy + '"][value="' + slug + '"]');
                if ($input.length) {
                    $input.prop('checked', false);
                    $('.js-btn-filter').click();
                }
            }
        }
    });


    $('.category-block__link').on('click', function(event) {
        let $target = $(event.target).closest('.category-block__item');
        let title = $target.find('.category-block__title').text() || '';
        let slug = $target.attr('data-slug') || '';

        if (title) {
            $('.categories-info').find('.section__title').text(title);
            $('.categories-info__block').empty();
        }

        $('main.main:hidden').show();

        let $filterBlock = $('.filter-block');
        $filterBlock.attr('data-category', slug);
        let $input = $filterBlock.find('input[data-taxonomy="product_cat"][value="' + slug + '"]');
        if ($input.length) {
            $input.prop('checked', true);
            $('.js-btn-filter').click();
        }
    });

    //Применение html get-параметров
    if ($('body').is('.tax-sp_smart_brand')) {

        let urlParams = new URLSearchParams(location.search);
        let httpGetParams = Object.fromEntries(urlParams);

        if (Object.keys(httpGetParams).length) {
            $('main.main:hidden').show();
            $('.js-btn-filter').click();
        }
    }


    let urlParams = new URLSearchParams(location.search);
    let httpGetParams = Object.fromEntries(urlParams);
    if (Object.keys(httpGetParams).length) {
        updateCheckboxesTags(httpGetParams);
    }
    if(!$('.top-categories').text().trim().length){
        $('.top-categories').remove();
    }

    // $('.options__list--checked').click();

    $('.product-item__title').each(function(i,title) {
        if ($(title).height() > 24) {
            $(title).addClass('long-title')
        }
    })
})
