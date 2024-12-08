(function($) {

    $(function() {

        $(".table-overlay").on('scroll', function() {
            $val = $(this).scrollLeft();

            if($(this).scrollLeft() + $(this).innerWidth()>=$(this)[0].scrollWidth){
                $(".comparison__navigation__right").addClass('comparison__navigation__button__disabled');
            } else {
                $(".comparison__navigation__right").removeClass('comparison__navigation__button__disabled');
            }

            if($val == 0){
                $(".comparison__navigation__left").addClass('comparison__navigation__button__disabled');
            } else {
                $(".comparison__navigation__left").removeClass('comparison__navigation__button__disabled');
            }
        });
        $(".comparison__navigation__right").on("click", function(){
            $(".table-overlay").animate( { scrollLeft: '+=150' }, 300);
        });
        $(".comparison__navigation__left").on("click", function(){
            $(".table-overlay").animate( { scrollLeft: '-=150' }, 300);
        });


        $('.comparison__solution__buttons__delete').on('click', function(event) {
            let $solution = $(event.target).closest('.comparison__solution');
            let id = parseInt($solution.attr('data-id'), 10);
            if (!id) return;

            let data = {
                action: 'removeFromComparison',
                productId: id,
            };

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: data,
                success: function(response) {
                    if (response || response.hasOwnProperty('message')) {
                        let count = response['message'];
                        $('.comparison__item__amount').find('span').text(count);
                        $('.btn-count__number').text(count);

                        if (count <= 0) {
                            $('.comparison__navigation').css({
                                opacity: 0,
                                visibility: 'hidden'
                            });
                            let $tableOverlay = $('.table-overlay');
                            let $emptyContent = $('.application__empty-content');
                            if ($tableOverlay.length && $emptyContent.length) {
                                $tableOverlay.hide()
                                $emptyContent.show()
                            }
                        }

                        let index = $solution.index();
                        $('.comparison-table tr').find('td:eq('+index+')').remove();
                    }
                },
                error: function (jqXHR, exception) {
                    // console.log('error');
                    // console.log(jqXHR);
                    // console.log(exception);
                },
            });
        });

        $('.comparison__switch__slider').on('click', function(event) {
            let $target = $(event.target);
            $target.toggleClass('checked');

            if ($target.is('.checked')) {

                $('.comparison-table tr').each(function(i,el) {
                    let $tr = $(el).closest('tr');
                    let $td = $tr.find('td');
                    let notCompareFlag = false;

                    if ($td.length > 1) {
                        let values = [];
                        notCompareFlag = false;
                        $td.each(function(i,td) {
                            let value = $(td).html().trim();
                            if(values.length > 0 && value !== '' && !values.includes(value)) {
                                notCompareFlag = true;
                                return false;
                            }
                            i > 0 && values.push(value);
                        });
                        notCompareFlag && $tr.is('.comparison-table__rated-power') && $tr.hide();
                    }
                })

            }else{
                $('.comparison-table tr:hidden').show();
            }
        })

    });//document ready

})(jQuery);