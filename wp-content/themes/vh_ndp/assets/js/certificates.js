(function($) {
    $(function() {

        //Show added message
        function showAddedMessage(text='') {
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

        let message = 'Certificate uploaded successfully. Information sent for review';
        if (typeof translatesArray !== 'undefined' && translatesArray.hasOwnProperty('messageUploaded')) {
            message = translatesArray['messageUploaded'];
            showAddedMessage(message);
        }


        $('.modal-btn.btn-delete').on('click', function(event) {
            let $target = $(event.target).closest('.modal-btn');
            let modal = $target.data('modal');
            let $modal = $('.modal__'+modal);
            let id = $target.closest('.certificates__item').attr('data-id') || '';

            if ($modal.length && id) {
                $modal.attr('data-id', id)
            }
        })

        $('.btn-delete-cert').on('click', function(event) {
            let $target = $(event.target);
            let post_id = '';
            let $modal = $target.closest('.profile-settings__modal');
            let id = $modal.attr('data-id');
            if (id) {
                id = id.replace(/[\[\]]*/g,'');
            }
            if (!id) return;

            post_id = id;

            $.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'customCertificateDeleteHandler',
                    post_id: post_id,
                },
                success: function (response) {
                    // console.log('response', response);
                    if (response && response.hasOwnProperty('message') && response['message'] === 'ok') {
                        $modal.find('.profile-settings__modal-close').click();
                        $('.certificates__block').find('.certificates__item[data-id='+post_id+']').remove();
                    }
                }
            })
        })

    });//document ready
})(jQuery);