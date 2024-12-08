(function($) {

    $(function() {
        $('.other__link a').attr('href',$('.breadcrumb_last').prev().prev().find('a').attr('href'));
        if ($('.dots-wrapper .dot').length === 1) {
            $('.gallery__arrow').hide();
        }

        //zoom
        function activateZoom() {
            let $slide = $('.slider__slide.active');
            if (!$slide.length && $('.photo__main').length) {
                $slide = $('.photo__main');
            }
            let $img = $slide.find('img');
            $img.ezPlus({
                // easing: true,
                containLensZoom: true,
                showLens: true,
                scrollZoom: false,
                zoomType: 'window',
                zoomWindowOffsetX: 73,
                zoomWindowWidth: $('.product__main').width(),
                zoomWindowHeight: 472,
                borderSize: 0,
                tint: true,
                tintColour: '#00000033',
                tintOpacity: 0.5,

            });
        }
        activateZoom();

        $('.gallery__arrow, .pagination-links').on('click', function(event) {
            setTimeout(function() {
                activateZoom();
            }, 500)
        });

    });//document ready

})(jQuery);
