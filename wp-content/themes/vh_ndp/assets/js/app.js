jQuery(document).ready(function ($) {





    /**
     * Swiper
     */
    if ($('.swiper.swiper-threeItem').length) {
        const swiper = new Swiper('.swiper.swiper-threeItem', {
            slidesPerView: 1,
            spaceBetween: 24,
            // freeMode: true,
            pagination: {
                el: '.swiper-pagination',
                dynamicBullets: true,
                clickable: true,
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 0,
                },
                650: {
                    slidesPerView: 2,
                    spaceBetween: 24,
                },
                1199: {
                    slidesPerView: 3,
                    spaceBetween: 24,
                },
            },
        })
    }

    /**
     * Menu
     */
    $('.burger-menu').on('click', function () {
        $(this).parent().find('.main-menu-container').toggleClass('active')
        $(this).parent().find('.menu').toggleClass('active')
        $(this).parent().find('.menu__btn-show').toggleClass('active')
        $(this).toggleClass('active')
        $('body').toggleClass('body-mobile-menu-active');
    })

    $('.menu-item-has-children').on('click', function () {
        $(this).toggleClass('active')
    })

    /**
     * Categories burger
     */
    $('.selected-categories__burger-menu').on('click', function () {
        $(this).parent().find('.selected-categories__item').removeClass('selected-categories__item-none')
        $(this).toggleClass('selected-categories__burger-menu-open');
    });
    $(document).on('click', '.selected-categories__burger-menu .bt-close', function (e) {
        $(this).closest('.wrap').find('.selected-categories__item:not(:first)').addClass('selected-categories__item-none')
        $('.selected-categories__burger-menu').removeClass('selected-categories__burger-menu-open');
    });

    /**
     * Select
     */
    $('.select__btn').on('click', function () {
        let selectWrap = $('.c-select')
        let parent = $(this).closest('.c-select')

        if (parent.hasClass('active') === false) {
            selectWrap.removeClass('active')
            selectWrap.find('.select__list').fadeOut()

            parent.addClass('active')
            parent.find('.select__list').fadeIn()
        } else {
            parent.removeClass('active')
            parent.find('.select__list').fadeOut()
        }
    })

    $(document).mouseup(function (e) {
        let div = $('.c-select')
        if (!div.is(e.target)
            && div.has(e.target).length === 0) {
            div.removeClass('active')
            $('.select__list').fadeOut()
        }
    })

    /** Marquee **/

    $('.marquee').marquee({
        //speed in milliseconds of the marquee
        duration: 20000,
        //gap in pixels between the tickers
        gap: 0,
        //time in milliseconds before the marquee will start animating
        delayBeforeStart: 0,
        //'left' or 'right'
        direction: 'left',
        //true or false - should the marquee be duplicated to show an effect of continues flow
        duplicated: true,
        startVisible: true,

    })

    /** Vendors **/

    $('.owl_carousel_vendors').owlCarousel({
        loop: false,
        margin: 0,
        nav: true,
        dots: true,
        navText: ['<svg enable-background="new 0 0 492 492" version="1.1" viewBox="0 0 492 492" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m198.61 246.1 184.06-184.06c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12c-5.06-5.072-11.824-7.864-19.032-7.864s-13.964 2.792-19.028 7.864l-219.15 219.14c-5.084 5.08-7.868 11.868-7.848 19.084-0.02 7.248 2.76 14.028 7.848 19.112l218.94 218.93c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06l-183.85-183.85z"/></svg>', '<svg enable-background="new 0 0 492 492" version="1.1" viewBox="0 0 492 492" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><path d="m198.61 246.1 184.06-184.06c5.068-5.056 7.856-11.816 7.856-19.024 0-7.212-2.788-13.968-7.856-19.032l-16.128-16.12c-5.06-5.072-11.824-7.864-19.032-7.864s-13.964 2.792-19.028 7.864l-219.15 219.14c-5.084 5.08-7.868 11.868-7.848 19.084-0.02 7.248 2.76 14.028 7.848 19.112l218.94 218.93c5.064 5.072 11.82 7.864 19.032 7.864 7.208 0 13.964-2.792 19.032-7.864l16.124-16.12c10.492-10.492 10.492-27.572 0-38.06l-183.85-183.85z"/></svg>'],
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 5
            },
            1000: {
                items: 6,
                slideBy: 6
            }
        }
    })

    /**
     * Ajax
     */
    function sendAjaxRequest (action, data) {
        // Отправляем AJAX-запрос на сервер
        data.is_have_sticky = $('.list-card-sticky').attr('data-is-have-sticky') || '';

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            beforeSend: function () {
                // console.log('Before AJAX request...')
                $('.wp-pagination').hide()
                $('.list-card:not(.list-card-sticky) .list-three-card').html(`
                    <div class="skeleton">
                        <div class="wrap">
                            ${data.post_type == 'news' ? `<div class="skeleton__card skeleton__card_full-width">
                                <div class="skeleton__img"></div>
                                <div class="skeleton__info">
                                    <div class="skeleton__title-list">
                                        <p class="skeleton__title"></p>
                                    </div>
                                    <div class="skeleton__teg-list">
                                        <p class="skeleton__teg"></p>
                                        <p class="skeleton__teg"></p>
                                    </div>
                                    <div class="skeleton__text-list">
                                        <p class="skeleton__text"></p>
                                        <p class="skeleton__text"></p>
                                        <p class="skeleton__text"></p>
                                    </div>
                                    <div class="skeleton__date-list">
                                        <p class="skeleton__date"></p>
                                        <p class="skeleton__date"></p>
                                    </div>
                                </div>
                            </div>` : ''}
                            <div class="skeleton__list">
                                <div class="skeleton__card">
                                    <div class="skeleton__img"></div>
                                    <div class="skeleton__info">
                                        <div class="skeleton__title-list">
                                            <p class="skeleton__title"></p>
                                            <p class="skeleton__title"></p>
                                        </div>
                                        <div class="skeleton__teg-list">
                                            <p class="skeleton__teg"></p>
                                            <p class="skeleton__teg"></p>
                                        </div>
                                        <div class="skeleton__text-list">
                                            <p class="skeleton__text"></p>
                                            <p class="skeleton__text"></p>
                                            <p class="skeleton__text"></p>
                                        </div>
                                        <div class="skeleton__date-list">
                                            <p class="skeleton__date"></p>
                                            <p class="skeleton__date"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="skeleton__card">
                                    <div class="skeleton__img"></div>
                                    <div class="skeleton__info">
                                        <div class="skeleton__title-list">
                                            <p class="skeleton__title"></p>
                                            <p class="skeleton__title"></p>
                                        </div>
                                        <div class="skeleton__teg-list">
                                            <p class="skeleton__teg"></p>
                                            <p class="skeleton__teg"></p>
                                        </div>
                                        <div class="skeleton__text-list">
                                            <p class="skeleton__text"></p>
                                            <p class="skeleton__text"></p>
                                            <p class="skeleton__text"></p>
                                        </div>
                                        <div class="skeleton__date-list">
                                            <p class="skeleton__date"></p>
                                            <p class="skeleton__date"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="skeleton__card">
                                    <div class="skeleton__img"></div>
                                    <div class="skeleton__info">
                                        <div class="skeleton__title-list">
                                            <p class="skeleton__title"></p>
                                            <p class="skeleton__title"></p>
                                        </div>
                                        <div class="skeleton__teg-list">
                                            <p class="skeleton__teg"></p>
                                            <p class="skeleton__teg"></p>
                                        </div>
                                        <div class="skeleton__text-list">
                                            <p class="skeleton__text"></p>
                                            <p class="skeleton__text"></p>
                                            <p class="skeleton__text"></p>
                                        </div>
                                        <div class="skeleton__date-list">
                                            <p class="skeleton__date"></p>
                                            <p class="skeleton__date"></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `)
            },
            success: function (response) {
                // console.log(response);
                updateCustomPostsWithPagination(response);
                updateUrlHistory(response);
            },
            error: function (error) {
                // console.log(error)
            }
        })
    }

    //Обновление товаров, полученных по ajax
    function updateCustomPostsWithPagination(data, $wrapper = $('.list-card .list-three-card')) {
        if (!data) return;

        let $main = $wrapper.length? $wrapper : $('.list-card .list-three-card');

        if (data.hasOwnProperty('data')) {
            $main.html(data['data']);
            labelsGroup();
        }

        if (data.hasOwnProperty('pagination')) {
            let $pagination = $('.wp-pagination');
            $pagination.html(data['pagination']);
            $pagination.show();
        }
    }

    /**
     * All tags
     */
    let selectedTagsBtns = ''
    let selectedTags = ''

    $('.select__item').on('click', function () {
        const parent = $(this).closest('.c-select')
        const multiselect = $(this).closest('.c-multiselect')
        const input = parent.find('input')
        const dataAttr = $(this).attr('data-sort-by')
        const selectedTagBtn = $(this).text()
        const selectedTag = dataAttr;

        let tagArrayBtn = selectedTagsBtns.split(',').filter(tag => tag !== '')
        let tagArray = selectedTags.split(',').filter(tag => tag !== '')

        if (multiselect.length > 0) {

            if (tagArrayBtn.includes(selectedTagBtn)) {
                tagArrayBtn = tagArrayBtn.filter(tag => tag !== selectedTagBtn)
            } else {
                tagArrayBtn.push(selectedTagBtn)
            }

            if (tagArray.includes(selectedTag)) {
                tagArray = tagArray.filter(tag => tag !== selectedTag)
            } else {
                tagArray.push(selectedTag)
            }

            selectedTagsBtns = tagArrayBtn.join(',')
            selectedTags = tagArray.join(',')

            input.val(selectedTags)
            input.attr('value', selectedTags)

            parent.find('.select__btn span').remove()

            parent.find('.select__item').removeClass('active')
            tagArray.forEach(tag => {
                let selectItem = parent.find('.select__item[data-sort-by="' + tag + '"]')
                selectItem.addClass('active')
            })

            if (tagArrayBtn.length > 0) {
                let tagCounter = 0
                parent.find('.select__btn').empty();
                let width = parseInt($(window).width(), 10);
                let tooltip = width > 600? 'tooltip-bottom-left' : 'tooltip-bottom-center';

                let btn = parent.find('.select__btn');
                let wraperHoverBlock = '<div class="wrapper-hover-block tooltip-bottom ' + tooltip + '"><div class="wrapper-hover-block__container">';

                tagArrayBtn.forEach(tag => {
                    tagCounter++
                    let currentTag = '<span class="tag-inner">' + tag + '<a href="" class="remove-tag"><img src="/wp-content/themes/vh_ndp/assets/img/icon/close.svg" alt="Remove Tag"></a></span>';

                    if (tagCounter < 2) {
                        btn.append(currentTag)
                    } else {
                        wraperHoverBlock += currentTag
                    }
                });
                wraperHoverBlock += '</div></div>';
                if (tagCounter > 1) {
                    if (btn.find('.count').length < 1) {
                        btn.append('<div class="count more-hover"><span class="count-text">+' + (tagCounter - 1) + '</span>' + wraperHoverBlock + '</div>')
                    } else {
                        btn.find('.wrapper-hover-block').remove()
                        btn.find('.count-text').text('+' + (tagCounter - 1));
                        btn.find('.count-text').after(wraperHoverBlock)
                    }
                }
            } else {
                parent.find('.select__btn').text(lang_tags)
            }

        } else {
            input.val(dataAttr)
            input.attr('value', dataAttr)
            parent.find('.select__btn').text($(this).text())
        }

        parent.removeClass('active')
        $('.select__list').fadeOut()
    });

    $(document).on('mouseenter', '.count.more-hover', function (e) {
        $('header.header').css('z-index', 0)
    })
    $(document).on('mouseleave', '.count.more-hover', function (e) {
        $('header.header').css('z-index', 992)
    })

    //установка http get-параметров в фильтр
    let urlParams = new URLSearchParams(location.search.substring(1));
    let httpGetParams = Object.fromEntries(urlParams);
    if (Object.keys(httpGetParams).length) {
        let tagsArray = {};

        $('.tag-search-container .select__list').find('.select__item').each(function(i,el) {
            let sortKey = $(el).attr('data-sort-by') || '';
            let sortValue = $(el).text() || '';
            if (sortKey && sortValue) {
                tagsArray[sortKey] = sortValue
            }
        });

        if (Object.keys(tagsArray).length) {
            Object.keys(httpGetParams).forEach(function(key) {

                let $select = $('.select__item[data-sort-by="'+httpGetParams[key]+'"]');
                if ($select.length) {
                    $select.click()
                }

            });
        }
    }


    $(document).on('click', '.remove-tag', function (e) {
        e.preventDefault();

        const parent = $(this).closest('.c-select');
        const tagToRemove = $(this).closest('span').text().trim();
        let tagArrayBtn = selectedTagsBtns.split(',').filter(tag => tag !== '');
        let tagArray = selectedTags.split(',').filter(tag => tag !== '')
        let tagCounter = 0;

        tagArrayBtn = tagArrayBtn.filter(tag => tag !== tagToRemove);

        parent.find('.select__btn').empty();
        $('header.header').css('z-index', 992)

        if (tagArrayBtn.length > 0) {

            let width = parseInt($(window).width(), 10);
            let tooltip = width > 600? 'tooltip-bottom-left' : 'tooltip-bottom-center';
            let btn = parent.find('.select__btn');
            let wraperHoverBlock = '<div class="wrapper-hover-block tooltip-bottom ' + tooltip + '"><div class="wrapper-hover-block__container">';

            tagArrayBtn.forEach(tag => {
                tagCounter++;
                let currentTag = '<span class="tag-inner">' + tag + '<a href="" class="remove-tag"><img src="/wp-content/themes/vh_ndp/assets/img/icon/close.svg" alt="Remove Tag"></a></span>';
                if (tagCounter < 2) {
                    // btn.attr('title', '');
                    btn.append(currentTag);
                } else {
                    wraperHoverBlock += currentTag
                }
            });

            wraperHoverBlock += '</div></div>';
            if (tagCounter > 1) {
                if (btn.find('.count').length < 1) {
                    btn.append('<div class="count more-hover"><span class="count-text">+' + (tagCounter - 1) + '</span>' + wraperHoverBlock + '</div>')
                } else {
                    btn.find('.wrapper-hover-block').remove()
                    btn.find('.count-text').text('+' + (tagCounter - 1));
                    btn.find('.count-text').after(wraperHoverBlock)
                }
            }

        } else {
            parent.find('.select__btn').text(lang_tags);
        }

        selectedTagsBtns = tagArrayBtn.join(',');
        $(this).closest('span').remove();

        parent.find('.select__item').filter(function () {
            return $(this).text().trim() === tagToRemove;
        }).removeClass('active');

        let activeTagIds = [];

        $('.tag-search-container').length && $('.tag-search-container .select__item.active').each(function () {
            activeTagIds.push($(this).attr('data-sort-by'));
        });
        $('.types-search-container').length && $('.types-search-container .select__item.active').each(function () {
            activeTagIds.push($(this).attr('data-sort-by'));
        });
        selectedTags = activeTagIds.join(',');

        $('.tag-search-container input').val(activeTagIds.join(','));
        $('.tag-search-container input').attr('value', activeTagIds.join(','));

        let postType = $('.sort-input-container .select__btn').attr('data-post-type');
        let selectedValue = $('.sort-input-container input').attr('value');
        let catTaxonomy = $('.selected-categories').attr('data-taxonomy');
        let categorySlug = $('.selected-categories__link.btn_bg_primary').attr('data-term-slug')
        let categoryId = $('.selected-categories__link.btn_bg_primary').attr('data-term-id');
        let tagTaxonomy = $('.tag-search-container .select__btn').attr('data-post-custom-tag');
        let tagIds = '';
        let pathname = window.location.pathname;

        if ($(this).attr('data-term-slug') !== undefined) {
            tagIds = $(this).attr('data-term-slug');
        } else {
            tagIds = $('.tag-search-container input').attr('value');
        }

        let data = prepareDataForAjax({
            action: 'filter_posts_by_category',
            post_type: postType,
            sort_by: selectedValue,
            taxonomy: catTaxonomy, // cat
            category_id: categoryId,
            categorySlug: categorySlug,
            tagTaxonomy: tagTaxonomy,
            tagIds: tagIds,
            pathname: pathname,
        });
        if (!$('body').is('.page-template-documets')) {
            sendAjaxRequest('filter_posts_by_tag', data);
        }
    });

    /**
     * Sort by
     */
    $(document).on('click', 'body.archive .sort-input-container .select__item', function () {
        let parent = $(this).closest('.c-select')
        let selectedValue = parent.find('input').val()
        let btn = parent.find('.select__btn')
        let postType = btn.attr('data-post-type')

        let selectedCategory = $('.selected-categories-list a.btn_bg_primary')
        let categoryId = selectedCategory.attr('data-term-id')
        let catTaxonomy = $('.selected-categories').attr('data-taxonomy')
        let categorySlug = $('.selected-categories__link.btn_bg_primary').attr('data-term-slug')
        let tagTaxonomy = $('.tag-search-container .select__btn').attr('data-post-custom-tag')
        let tagIds = $('.tag-search-container input').attr('value')
        let pathname = window.location.pathname;

        let data = prepareDataForAjax({
            action: 'filter_posts_by_category',
            post_type: postType,
            sort_by: selectedValue,
            taxonomy: catTaxonomy, // cat
            category_id: categoryId,
            categorySlug: categorySlug,
            tagTaxonomy: tagTaxonomy,
            tagIds: tagIds,
            pathname: pathname,
        });
        sendAjaxRequest('filter_posts_by_tag', data);
    })


    //category, кнопка в отдельной записи
    $(document).on('click', 'body.archive:not(.post-type-archive-knowledge-base) .category-tags .category-tags__category', function (event) {
        event.preventDefault()

        let categorySlug = $(this).attr('data-term-slug');
        let $categoryBtn = $('.selected-categories__link[data-term-slug="'+categorySlug+'"]');
        if ($categoryBtn.length) {
            $categoryBtn.click()
        }
    })

    /**
     * Tag
     */
    $(document).on('click', 'body.archive .tag-search-container .select__item, body.archive:not(.post-type-archive-knowledge-base) .category-tags__tags-list a', function (event) {
        event.preventDefault();

        let $target = $(event.target);
        let postType = $('.sort-input-container .select__btn').attr('data-post-type')
        let selectedValue = $('.sort-input-container input').attr('value')
        let catTaxonomy = $('.selected-categories').attr('data-taxonomy')
        let categoryId = $('.selected-categories__link.btn_bg_primary').attr('data-term-id')
        let tagTaxonomy = $('.tag-search-container .select__btn').attr('data-post-custom-tag')
        let tagIds = '';
        let pathname = window.location.pathname;

        let categorySlug = $('.selected-categories__link.btn_bg_primary').attr('data-term-slug')
        let tag = $target.attr('data-term-slug');
        if (tag && $('.select__item[data-sort-by="'+tag+'"]').length) {
            $('.select__item[data-sort-by="'+tag+'"]').click();
            return;
        }

        if ($(this).attr('data-term-slug') !== undefined) {
            tagIds = $(this).attr('data-term-slug')
        } else {
            tagIds = $('.tag-search-container input').attr('value')
        }

        let data = prepareDataForAjax({
            action: 'filter_posts_by_category',
            post_type: postType,
            sort_by: selectedValue,
            taxonomy: catTaxonomy, // cat
            category_id: categoryId,
            categorySlug: categorySlug,
            tagTaxonomy: tagTaxonomy,
            tagIds: tagIds,
            pathname: pathname,
        });

        //Обновление ссылок для категорий с выбранными тегами
        if (Object.keys(data['filters']).length) {
            let filters = {};
            Object.keys(data['filters']).forEach(function(taxonomy) {
                if (!taxonomy.includes('category')) {
                    filters[taxonomy] = data['filters'][taxonomy]
                }
            });

            let httpGetParams = http_build_query(filters);
            if (httpGetParams) {
                $('.articles-filter').find('a.selected-categories__link').each(function(i, link) {
                    let $link = $(link);
                    let categoryHref = $link.attr('href');
                    categoryHref = categoryHref.split('?')[0];
                    if (categoryHref) {
                        categoryHref = categoryHref + '?' + httpGetParams;
                        $link.attr('href', categoryHref)
                    }
                })
            }
        }

        sendAjaxRequest('', data)
    });


    $(document).on('click', 'body.archive .js-clear-filter', function (event) {
        let $selectItem = $('body.archive .tag-search-container .select__item.active');
        if ($selectItem.length) {
            clearUrlHistory();
            clearTags();
            if ($('.remove-tag').length) {
                $('.remove-tag').click()
            }
        }
    });

    $(document).on('click','.archive #resetFilter',function(){
        $('.tag-search-container .select__btn').empty();
    });


    function prepareDataForAjax(data) {
        clearUrlHistory();

        let filters = {};

        if (typeof data['taxonomy'] !== 'undefined' && typeof data['categorySlug'] !== 'undefined') {
            filters[data['taxonomy']] = [data['categorySlug']];
        }
        if (data['tagIds']) {
            filters[data['tagTaxonomy']] = data['tagIds'].split(',');
        }
        data['filters'] = filters;

        return data;
    }


    function clearUrlHistory() {
        let urlPath = location.pathname.replace(/page\/[0-9]+\//,'');
        history.replaceState({}, document.title, urlPath);
    }

    function clearTags() {
        selectedTagsBtns = ''
        selectedTags = ''
        let $select__list = $('.select__list');
        if ($select__list.length) {
            $select__list.find('.select__item.active').removeClass('active')
        }
        if ($('.articles-filter').length) {
            $('.articles-filter').find('a.selected-categories__link').each(function(i, link) {
                let $link = $(link);
                let categoryHref = $link.attr('href');
                categoryHref = categoryHref.split('?')[0];
                if (categoryHref) {
                    $link.attr('href', categoryHref)
                }
            })
        }
    }

    function updateUrlHistory(data) {
        if (data && data.hasOwnProperty('httpGetParams')) {
            let urlParamsPathname = location.pathname;
            let httpGetParams = data['httpGetParams'];
            let url = urlParamsPathname;
            if (httpGetParams) {
                url += "?" + httpGetParams;
            }
            history.replaceState({}, document.title, url);
        }
    }

    //Показ только length строк
    function customPostTitle($el=$('.card-nw__block .title-mob'), length=2) {
        $el.each(function(i, title) {
            let $title = $(title);
            let lineHeight = parseInt(window.getComputedStyle($title[0], null).getPropertyValue("line-height"), 10);
            let titleHeight = $title[0].offsetHeight;

            if (lineHeight && titleHeight && titleHeight > (lineHeight*length)) {
                $title.closest('.block-title').height((lineHeight*length)).css('overflow', 'hidden');
                let title = $title.text().trim();
                let titleSubtitle = title.match(/(.{1,56})(.+)/);
                if (titleSubtitle) {
                    title = '<span class="title-shorted">'+titleSubtitle[1]+'...</span>';
                    title += '<span style="display:none">'+titleSubtitle[2]+'</span>';
                }
                $title.html('');
                $title.append(title);
            }
        })

    }
    customPostTitle();


    //button add to cart or comparison
    $('.add-to-list,.add-to.add_to_comparison').on('click', function(event) {
        event.preventDefault();

        let $btn = $(event.target).closest('.add-to');
        let text = '';
        let id = $(this).data('item-id');
        if (id && $btn.is('.add_to_comparison')) {
            text = 'Item added to comparison';
            if (typeof comparisonText !== 'undefined' && comparisonText) {
                text = comparisonText;
            } else {
                let $mainContent = $('.main__content');
                if ($mainContent.length && $mainContent.attr('data-comparison-text') !=='') {
                    text = $mainContent.attr('data-comparison-text');
                }
            }

            //save for comparison page
            if (!$btn.is('.added')) {
                let data = {
                    action: 'addToComparison',
                    productId: id,
                };

                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: data,
                    success: function(response) {
                        if (response || response.hasOwnProperty('message')) {
                            $('.btn-comparison .btn-count__number').text(response['message']);
                            $btn.addClass('added');
                        }
                    },
                    error: function (jqXHR, exception) {
                        // console.log('error');
                        // console.log(jqXHR);
                        // console.log(exception);
                    },
                });
            } else {
                text = 'Item already added';
                if (typeof alreadyaddedText !== 'undefined' && alreadyaddedText) {
                    text = alreadyaddedText;
                } else {
                    let $mainContent = $('.main__content');
                    if ($mainContent.length && $mainContent.attr('data-alreadyadded-text') !=='') {
                        text = $mainContent.attr('data-alreadyadded-text');
                    }
                }
            }
        }

        productAddedMessage(text);
    });


    //Show added message
    function productAddedMessage(text='') {
        if (!text) return;

        const added = '<div class="added-block"><span></span> <i class="bt-close"></i></div>';

        let $added = $(added);
        $added.addClass('visible');
        $added.find('span').text(text);
        let bottom = 20;
        let height = parseInt($(window).height());

        if ($('.added-block').length) {
            let $last = $('.added-block:last');
            bottom = parseInt($last.css('bottom'),10) + 64;
            if (bottom > height) {
                bottom = 20;
            }
        }
        $added.css('bottom', bottom);
        $('body').append($added);

        setTimeout(function() {
            $added.remove()
        }, 3000)

        $('.bt-close').one('click', function(event) {
            $(event.target).closest('.added-block').remove();
        });

    }
    window.productAddedMessage = productAddedMessage;

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

    $('.profile-settings__out, .account__nav-mobile__logout').click(function() {
        $('#modal__logout').addClass('active-modal');
        $('body').css({'overflow': 'hidden'});
    });
    $('.profile-settings__modal-close, .profile-settings__modal-cancel').click(function(){
        $('.profile-settings__modal.active-modal').removeClass('active-modal');
        $('body').css({'overflow': ''});
    });


    //проверка наличия перевода
    $('.link-to-another-lang').on('click', function(event) {
        event.preventDefault();

        let currentLang = $('.language')?.find('a.current').attr('data-lang-current') || '';
        let otherLang = $(this).attr('data-lang') || '';
        let href = $(this).attr('href') || '';
        if (href) {
            let hasTranslate = href.match(/https?:\/\/[^\/]+(\/\w{2})?(\/[^\/]{3,})/);
            if (!$('body').is('.home') && !hasTranslate && currentLang && typeof translatesArray !== 'undefined' && typeof translatesArray['title_'+currentLang] !== 'undefined' && typeof translatesArray['subtitle_'+currentLang] !== 'undefined') {
                let title = translatesArray['title_'+currentLang];
                let subtitle = translatesArray['subtitle_'+currentLang];
                let $modal = $('#modal__language');
                if ($modal.length) {
                    $modal.find('.profile-settings__modal-title').text(title);
                    $modal.find('.profile-settings__modal-subtitle').text(subtitle);
                    let mainPageLink = (currentLang === 'uk')? '/'+otherLang : '/';
                    $modal.find('.profile-settings__modal-confirm').attr('href', mainPageLink);
                    $modal.addClass('active-modal');
                    // $('body').css({'overflow': 'hidden'});
                }
            } else if ((hasTranslate && hasTranslate.length > 2) || $('body').is('.home')) {
                document.location.href = href
            }
        }
    });

    $('.wp-block-video video').on('play pause', function(event) {
        $(this).parent().toggleClass('play')
    })
})

// Получаем ссылки на кнопку минуса и поле ввода количества
const minusButton = document.getElementById('minusButton');
const quantityInput = document.getElementById('quantityInput');

// Добавляем слушатель события на изменение значения поля ввода
quantityInput && quantityInput.addEventListener('change', function() {
    // Получаем текущее значение количества
    const currentQuantity = parseInt(quantityInput.value);

    // Если количество больше 2, меняем цвет кнопки на синий
    if (currentQuantity > 2) {
        minusButton.style.backgroundColor = 'blue';
    } else {
        // В противном случае, используем заданный черный цвет
        minusButton.style.backgroundColor = 'black';
    }
});





