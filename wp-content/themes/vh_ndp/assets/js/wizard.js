jQuery(document).ready(function ($) {

    let $wrapper = $('.wizard-wrapper');
    let $wizard = $('.wizard');
    let $table = $('.wizard-table');

    function activateDraggable(parent='') {
        let item = '.filter-item';
        item = parent? parent+' '+item : item;
        $(item).draggable({
            helper: "clone",
            appendTo: 'body',
            stop: function(event, ui){
                let $target = $(event.target);
                let $matchBlocks = $('.js-match-block');
                let $matched = null;
                let clientX = event.clientX;
                let clientY = event.clientY;

                $matchBlocks.each(function(i,element) {
                    let bound = element.getBoundingClientRect();
                    let top = bound['top'];
                    let height = bound['height'];
                    let left = bound['left'];
                    let width = bound['width'];

                    if (clientX > left && clientX < (left + width) && clientY > top && clientY < (top + height)) {
                        $matched = $(element);
                    }
                });
                if (!$matched) return;

                let $clonedFilter = $target.clone();
                let filterType = $clonedFilter.attr('data-input-type') || '';
                let value = $clonedFilter.attr('data-value') || '';
                let $childElements = $matched.find('.filter-item[data-input-type="'+filterType+'"][data-value="'+value+'"]');

                if (!$childElements.length) {
                    $clonedFilter.attr('style','');
                    $clonedFilter.appendTo($matched);
                    activateDraggable('.js-match-block');
                }
            }
        });
    }
    activateDraggable();

    $('.js-add-filter').on('click', function(event) {
        let $tr = $table.find('tbody tr:first').clone();
        $tr.attr('data-id','');
        $tr.find('.question').val('');
        $tr.find('.js-match-block').empty();
        $table.append($tr);
    })

    //Сохранение вопросов Wizard в базе данных
    $('.js-save-wizard').on('click', function(event) {
        let wizardData = [];//ajax data
        let lang = $table.attr('data-lang') || '';

        let flag = false;
        $table.find('.tr-wizard').each(function(i, tr) {
            //question data
            let $tr = $(tr);
            let questionID = $tr.attr('data-id') || '';
            let $question = $tr.find('input.question');
            let question_uk = $tr.find('input.question_uk').val() || '';
            let question_en = $tr.find('input.question_en').val() || '';
            let question_de = $tr.find('input.question_de').val() || '';
            let category = $tr.find('select').val() || '';
            let $wizardMatchBlock = $tr.find('.js-match-block');
            let $questionsFilled = $question.filter(function(index, el) {
                return $(el).val() !== '';
            });
            // checkQuestionDuplicateLang()
            if (!$questionsFilled.length || !category || !$wizardMatchBlock.length || !$wizardMatchBlock.find('.filter-item').length) {
                flag = true;
                return false;
            }

            //filters data
            let filtersObject = {};
            $wizardMatchBlock.find('.filter-item').each(function(index, filter) {
                let $filter = $(filter);
                let filterType = $filter.attr('data-input-type') || '';
                let value = $filter.attr('data-value') || '';
                let name = $filter.text() || '';
                if (!filterType || !value || !name) return;
                
                if (!filtersObject.hasOwnProperty(filterType)) {
                    filtersObject[filterType] = [];
                }
                
                filtersObject[filterType].push({
                    value: value,
                    name: name,
                });
                if (questionID) {
                    filtersObject['id'] = questionID;
                }
            });

            let questionData = {
                question_uk: question_uk,
                question_en: question_en,
                question_de: question_de,
                category: category,
                filters: filtersObject,
                lang: lang,
            }
            if (questionID) {
                questionData['id'] = questionID
            }
            wizardData.push(questionData);
        });
        if (!wizardData.length) return;

        let data = {
            action: 'saveWizardAction',
            data: wizardData,
        };
        // console.log('data', data);

        $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: data,
            success: function(response) {
                // console.log('response', response);

                if (response && response.hasOwnProperty('questions') && response['questions'].length) {
                    for (let i=0; i < response['questions'].length; i++) {
                        let id = response['questions'][i]['id'] || '';
                        let question_uk = response['questions'][i]['question_uk'] || '';
                        let question_en = response['questions'][i]['question_en'] || '';
                        let question_de = response['questions'][i]['question_de'] || '';
                        let questionsArray = [];
                        if (question_uk) {
                            questionsArray.push(question_uk);
                        }
                        if (question_en) {
                            questionsArray.push(question_en);
                        }
                        if (question_de) {
                            questionsArray.push(question_de);
                        }
                        let category = response['questions'][i]['category'] || '';
                        if (!id || !questionsArray.length || !category) continue;

                        // let $questions = questionsArray.map(function(question, index) {
                        //     return checkQuestionDuplicate(question, category);
                        // });
                        let $questions = questionsArray;
                        if (!$questions || !$questions.length) continue;

                        let $tr = $($questions[0]).closest('tr');
                        if (!$tr.attr('data-id')) {
                            $tr.attr('data-id', id)
                        }

                    }
                }
                alert('Saved!')
            },
            error: function (jqXHR, exception) {
                // console.log('error');
                // console.log(jqXHR);
                // console.log(exception);
            },
        });
    });

    //Проверка если не дублируется вопрос
    function checkQuestionDuplicate(question, category) {
        if (!question || !category) return false;

        let $question = $('input.question').filter(function(index, el) {
            let $el = $(el);
            return $el.val() === question && $el.closest('td').find('.category').val() === category
        });
        if (!$question.length || $question.length > 1) return false;

        return $question;
    }

    function checkQuestionDuplicateLang($questions, category) {
        if (!$questions.length || !category) return false;

        let $question = $questions.filter(function(index, el) {
            let $el = $(el);
            let questionValue = $el.val();
            return !checkQuestionDuplicate(questionValue, category, el)
        });
        if (!$question.length || $question.length === 1) return false;

        return true;//существует дубликат вопроса
    }


    $(document).on('click', '.js-remove-question', function (event) {
        let $target = $(event.target);
        let $tr = $target.closest('tr');
        if (!$tr.length) return;

        let id = $tr.attr('data-id');
        $tr.remove();

        if (id) {
            let data = {
                action: 'deleteWizardQuestion',
                id: id,
            };
            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: data,
                success: function(response) {
                    console.log('response', response);
                },
                error: function (jqXHR, exception) {
                    // console.log('error');
                    // console.log(jqXHR);
                    // console.log(exception);
                },
            });
        }
    });

    $(document).on('click', '.js-remove-matches', function (event) {
        let $target = $(event.target);
        let $tr = $target.closest('tr');
        if (!$tr.length) return;

        $tr.find('.js-match-block').empty()
    });


    //обновление высоты, смещения от начала экрана
    function widgetFix(scroll) {
        //обновление высоты, смещения от начала экрана
        let wrapperTopPos = $wrapper.offset().top - 90;
        let wrapperHeight = $wrapper.height();
        let wizardHeight = $wizard.outerHeight(true);

        //Фиксация виджета при скроллинге, в зависимости от значения скролла
        if (scroll >= wrapperTopPos) {
            !$wizard.hasClass('fixed') && $wizard.addClass('fixed');
        } else if (scroll >= parseInt(wrapperTopPos + wrapperHeight, 10) - parseInt(wizardHeight, 10) - 15) {
            $wizard.removeClass('fixed');
        } else {
            $wizard.removeClass('fixed');
        }
    }

    // let windowWidth = $(window).width();

    $(window).on('scroll', function () {
        let $this = $(this);
        let scroll = $this.scrollTop();

        widgetFix(scroll);
    });

    // new StickySidebar('.wizard', {
    //     containerSelector: '.wizard-wrapper',
    //     innerWrapperSelector: '.wizard__inner'
    // });

})
