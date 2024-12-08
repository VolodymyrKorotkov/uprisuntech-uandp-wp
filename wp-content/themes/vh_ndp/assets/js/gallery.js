
document.addEventListener("DOMContentLoaded", function () {
    $ = jQuery;

    $.fn.gallerySlider = function(options={}) {

        return this.each(function(index, slider) {

            let $slider = $(slider);
            let slides = $slider.find(".slider__slide");
            if (!slides.length) return;

            $slider.attr('data-gallery', index);
            let $this = this;
            $this.modal = typeof options.modal !== 'undefined' && options.modal;
            $this.dotsWrapperOffset = getDotsWrapperOffset();

            let currentSlide = parseInt($slider.attr('data-currentSlide'), 10) || 0;
            let isAnimating = false;
            slides[currentSlide].classList.add("active");
            slides[currentSlide].classList.add("current");

            function goToSlide(slideIndex, slider) {
                let $slider = $(slider);
                let slides = $slider.find(".slider__slide");
                let currentSlide = parseInt($slider.attr('data-currentSlide'), 10) || 0;

                let $dots = $slider.find('.dots');
                let $dot = $dots.find('[data-slideindex="' + slideIndex + '"]');
                $dot.length && $dot.addClass('active');

                if ($this.modal) {
                    setVisibleDot($dot)
                }

                $slider.find('.active_slide').text(slideIndex+1);

                if (isAnimating || slideIndex === currentSlide) {
                    return;
                }

                isAnimating = true;
                slides.removeClass("active");
                let currentImage = slides[currentSlide].querySelector("img");
                let nextImage = slides[slideIndex].querySelector("img");

                let nextWidth = nextImage.offsetWidth;

                currentImage.style.transition = "width 1s";
                currentImage.style.width = `${nextWidth}px`;

                slides[slideIndex].classList.add("active");
                slides[slideIndex].classList.add("current");


                function waitAndExecute() {
                    return new Promise(resolve => {
                        setTimeout(() => {
                            currentSlide = slideIndex;
                            $slider.attr('data-currentSlide', currentSlide);

                            isAnimating = false;
                            resolve();
                        }, 300);
                    });
                }
// Использование
                waitAndExecute().then(() => {
                    setTimeout(function (){
                        $slider.find('.slider__slide img').attr('style','');
                    },250);
                });
            }

            $slider.find('.gallery__prev').on("click", function (event) {
                let $target = $(event.target);
                changeActiveDot($target);

                // let $slider = $target.closest('.gallery');
                let slides = $slider.find(".slider__slide");
                let currentSlide = parseInt($slider.attr('data-currentSlide'), 10) || 0;
                let prevSlide = (currentSlide - 1 + slides.length) % slides.length;

                $slider.find('.slider__slide.active+div').css('opacity','0.5');
                slides[currentSlide].classList.remove("active");
                // Первый этап: изменение размера

                $(slides[currentSlide].querySelector("img")).animate({
                    width: $(slides[prevSlide].querySelector("img")).width(),
                    height: $(slides[prevSlide].querySelector("img")).height(),
                    opacity:0.5,
                }, {
                    duration: 250,
                    easing: 'linear',
                    complete: function() {
                        $slider.find('.current').removeClass('current');
                        goToSlide(prevSlide, $slider);
                        $(slides).each(function (){
                            $(this).removeAttr('style');
                        });
                        // Сброс стилей
                        slides[prevSlide].classList.add("current");
                    }
                });
            });

            $slider.find('.gallery__next').on("click", function (event) {
                let $target = $(event.target);
                changeActiveDot($target);

                // let $slider = $target.closest('.gallery');
                let slides = $slider.find(".slider__slide");
                let currentSlide = parseInt($slider.attr('data-currentSlide'), 10) || 0;
                let nextSlide = (currentSlide + 1) % slides.length;

                $slider.find('.slider__slide.active+div').css('opacity','0.5');
                slides[currentSlide].classList.remove("active");


                $(slides[currentSlide].querySelector("img")).animate({
                    width: $(slides[nextSlide].querySelector("img")).width(),
                    height: $(slides[nextSlide].querySelector("img")).height(),
                    opacity:0.5,
                }, {
                    duration: 250,
                    easing: 'linear',
                    complete: function() {
                        $slider.find('.current').removeClass('current');
                        goToSlide(nextSlide, $slider);
                        // Сброс стилей
                        $(slides).each(function (){
                            $(this).removeAttr('style');
                        });
                        slides[nextSlide].classList.add("current");

                    }

                });
            });

            $(document).on('click','.pagination-links',function (event){
                let $target = $(event.target);
                changeActiveDot($target);

                let $slider = $target.closest('.gallery');
                let slides = $slider.find(".slider__slide");
                let currentSlide = parseInt($slider.attr('data-currentSlide'), 10) || 0;
                let nextSlide = parseInt($target.closest('.dot').attr('data-slideIndex'), 10);
                if (nextSlide === currentSlide) return;

                $slider.find('.slider__slide.active+div').css('opacity','0.5');
                slides.removeClass("active");
                $(slides[currentSlide].querySelector("img")).animate({
                    width: $(slides[nextSlide].querySelector("img")).width(),
                    height: $(slides[nextSlide].querySelector("img")).height(),
                    opacity:0.5,
                }, {
                    duration: 250,
                    easing: 'linear',
                    complete: function() {
                        $slider.find('.current').removeClass('current');
                        goToSlide(nextSlide, $slider);
                        // Сброс стилей
                        $(slides).each(function (){
                            $(this).removeAttr('style');
                        });
                        slides[nextSlide].classList.add("current");
                    }

                });
                event.stopImmediatePropagation();
            });

            function changeActiveDot($target, index)
            {
                let $slider = $target.closest('.gallery');
                let $dots = $target.closest('.gallery__pagination').find('.dots');
                $dots.find('.dot').removeClass('active');

                let $dot = $target.closest('.dot');
                if ($dot.length) {
                    $dot.addClass('active');
                }
            }


            function createDots()
            {
                let modal = $this.modal;
                if(!modal && $slider.find('.slider__slide').length>8){
                    let qty_slide = $slider.find('.slider__slide').length;
                    let pageOf = '';
                    if (typeof pageOfTranslate !== 'undefined' && pageOfTranslate) {
                        pageOf = pageOfTranslate.replace(/%p/,'1');
                        pageOf = pageOf.replace(/%s/,qty_slide);
                    }
                    $slider.find('.dots').append(`<span>${pageOf}</span>`);
                }else{
                    $slider.find('.slider__slide').each(function (i, slide){
                        let active = $(slide).is('.active')? 'active' : '';
                        let dot = $('<span></span>', {
                            'data-slideIndex': i,
                            class: 'pagination-links dot '+active,
                        });
                        if (modal || $('.product').length) {
                            dot.addClass('img')
                            dot.append($(slide).find('img').clone())
                        }
                        $slider.find('.dots').append(dot);
                        i++;
                    });
                }
            }
            createDots();

            function dotsModalInit()
            {
                if (!$this.modal) return;

                $slider.find('.dot').each(function (i, dot){
                    let $dot = $(dot);
                    if ($dot.is('.active')) {
                        setVisibleDot($dot)
                    }
                });
            }
            setTimeout(function() {
                dotsModalInit()
            },100);


            function getDotsWrapperOffset()
            {
                let $dotsWrapper = $slider.find('.dots-wrapper');
                let dotsWrapperOffsetLeft = $dotsWrapper.offset().left;
                let dotsWrapperOffsetRight = dotsWrapperOffsetLeft + $dotsWrapper.width();
                return {
                    left: dotsWrapperOffsetLeft,
                    right: dotsWrapperOffsetRight,
                }
            }

            function checkDotIsVisible($dot)
            {
                // let {dotsWrapperOffsetLeft,dotsWrapperOffsetRight} = getDotsWrapperOffset();
                let dotsWrapperOffset = getDotsWrapperOffset();
                let dotsWrapperOffsetLeft = dotsWrapperOffset.left;
                let dotsWrapperOffsetRight = dotsWrapperOffset.right;
                if (!$dot.length) return;

                let dotOffsetLeft = $dot.offset().left;
                if (dotOffsetLeft >= dotsWrapperOffsetLeft && (dotOffsetLeft + 100) <= dotsWrapperOffsetRight) {
                    return true;
                }
                return false;
            }

            //Вычисляет смещение и делает видимым
            function setVisibleDot($dot)
            {
                if (!checkDotIsVisible($dot)) {
                    let offsetX = getOneDotOffsetByWrapper($dot);
                    moveDots(-offsetX)
                }
            }

            //Анимация передвижения .dots-wrapper > .dots
            function moveDots(offset)
            {
                if ($this.offset) {
                    offset = offset + $this.offset;
                }
                $slider.find('.dots').css({"transform": `translate3d(${offset}px, 0px, 0px)`})
                $this.offset = offset;
            }

            //Смещение одного дота относительно dots-wrapper
            function getOneDotOffsetByWrapper($dot)
            {
                let dotsWrapperOffset = getDotsWrapperOffset();
                let dotsWrapperOffsetLeft = dotsWrapperOffset.left;
                let dotsWrapperOffsetRight = dotsWrapperOffset.right;
                let dotOffsetLeft = $dot.offset().left

                let offset = dotOffsetLeft - dotsWrapperOffsetLeft;
                if (dotOffsetLeft >= dotsWrapperOffsetRight) {
                    offset = dotOffsetLeft - dotsWrapperOffsetRight + 100;
                }
                return offset;
            }



            //Показ слайда в модальном окне
            $slider.find('.modal-btn').on("click", function (event) {
                $('.modal, .modal__block').removeClass('active')

                let modal = $(this).data('modal');
                let $modal = $('.modal__'+modal);

                if ($modal.length) {
                    $('.modal').addClass('active');
                    $($modal).addClass('active');
                }


                let $slider = $(this).closest('.gallery');
                let $modalGallery = $('.modal__gallery');
                // $slider.attr('data-currentSlide', currentSlide);
                let $clonedSlider = $slider.clone();
                // $clonedSlider.attr('data-currentSlide', currentSlide);
                $clonedSlider
                    .find('.modal-btn')
                    .removeClass('modal-btn');
                $clonedSlider.find('.dots').empty();
                $clonedSlider.find('.slider__slide img').attr('style','');
                $modalGallery.find('.modal__body').empty();
                $clonedSlider.appendTo($modalGallery.find('.modal__body'));
                $modalGallery.find('.gallery').gallerySlider({
                    modal: true,
                });
            });

            $('.modal').on('click', function(event) {
                let $target = $(event.target);
                let $clonedSlider = $('.modal__gallery').find('.gallery');

                if ($target.is('.modal__close') || $target.is('.modal')) {
                    $('.modal, .modal__block').removeClass('active')
                    $clonedSlider.remove();
                }
            })


        });


    };


    $('.gallery').gallerySlider();

    if (!$('.modal__gallery').length) {
        $('body').append('<div class="modal"><div class="modal__block modal__gallery"><span class="modal__close"></span><div class="modal__body"></div></div></div>')
    }

});
