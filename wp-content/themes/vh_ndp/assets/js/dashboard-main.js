$(function() {
    mobMenu();

    function mobMenu() {
        let width = $(window).width();
        let $nav = $('.account__block-nav');
        if (width <= 768) {
            const modal = '<div class="modal"><div class="modal__block modal__block--left modal__sidebar"></div></div>';
            if (!$('.modal__block').length) {
                $('.account__block').append(modal);
            }
            let $modal = $('.modal__block');
            if (!$modal.find('.account__block-nav').length) {
                $modal.append($nav.clone())
            }
        }
    }

    $('.modal-btn').on('click', function(event) {
        let $target = $(event.target).closest('.modal-btn');
        let modal = $target.data('modal');
        let $modal = $('.modal__'+modal);

        // $target.is('.add-close-on-click') && $target.toggleClass('modal__close');

        if ($modal.length) {
            // if ($modal.is('.active') && !$modal.is('.modal__sidebar')) {
            //     console.log('if');
            //     $modal.removeClass('active');
            // }

            $modal.closest('.modal').toggleClass('active-modal');
            $modal.toggleClass('active');
            $modal.toggleClass('active-modal');
        }
    })

    $(document).on('click', '.modal, .modal__close', function (event) {
        let $target = $(event.target);
        if ($target.is('.modal__close') || $target.is('.modal')) {
            $('.modal, .modal__block').removeClass('active')
            $('body').css({'overflow': '', 'padding-right': ''});
        }
    })
    $(window).resize(function() {
        mobMenu();
    });

    $('.profile-settings__out, .account__nav-mobile__logout').click(function() {
        $('#modal__logout').addClass('active-modal');
        $('body').css({'overflow': 'hidden'});
    });
    $('#edit-email').click(function(){
        $('#modal__emailChange').addClass('active-modal');
        $('body').css({'overflow': 'hidden'});
    });
    $('.profile-settings__modal-close, .profile-settings__modal-cancel').click(function(){
        $('.profile-settings__modal.active-modal').removeClass('active-modal');
        $('body').css({'overflow': ''});
    });
    // $('.profile-settings__modal-cancel').click(function(){
    //     $('#modal__logout').removeClass('active-modal');
    //     $('#modal__emailChange').removeClass('active-modal');
    //     $('body').css({'overflow': ''});
    // });

});