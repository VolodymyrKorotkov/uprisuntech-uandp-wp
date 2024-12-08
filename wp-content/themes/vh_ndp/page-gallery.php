<?php
/*
Template Name: Gallery
*/

get_header();
?>

<?php

echo apply_filters( 'the_content', $post->post_content );
?>

    <div class="gallery">
        <div class="gallery__title">Gallery 1</div>

        <div class="gallery__wrap">
            <div class="gallery__container">
                <div class="slider__slide modal-btn" data-modal="gallery">
                    <img src="http://via.placeholder.com/744x418" alt="">
                </div>
                <div class="slider__slide modal-btn" data-modal="gallery">
                    <img src="http://via.placeholder.com/744x418" alt="">
                </div>
                <div class="slider__slide modal-btn" data-modal="gallery">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img/slide4.jpg" alt="">
                </div>
                <div class="slider__slide modal-btn" data-modal="gallery">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img/slide5.jpg" alt="">
                </div>
                <div class="slider__slide modal-btn" data-modal="gallery">
                    <img src="http://via.placeholder.com/744x418" alt="">
                </div>
                <div class="slider__slide modal-btn" data-modal="gallery">
                    <img src="http://via.placeholder.com/744x418" alt="">
                </div>
                <div class="slider__slide modal-btn" data-modal="gallery">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img/slide4.jpg" alt="">
                </div>
                <div class="slider__slide modal-btn" data-modal="gallery">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img/slide5.jpg" alt="">
                </div>
                <div class="slider__slide modal-btn" data-modal="gallery">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img/slide4.jpg" alt="">
                </div>
                <div class="slider__slide modal-btn" data-modal="gallery">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img/slide5.jpg" alt="">
                </div>
                <div class="slider__slide modal-btn" data-modal="gallery">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img/slide4.jpg" alt="">
                </div>
                <div class="slider__slide modal-btn" data-modal="gallery">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img/slide5.jpg" alt="">
                </div>
<!--                <div class="slider__slide modal-btn" data-modal="gallery">-->
<!--                    <img src="--><?php //echo get_template_directory_uri(); ?><!--/assets/img/img/slide7.png" alt="">-->
<!--                </div>-->
<!--                <div class="slider__slide modal-btn" data-modal="gallery">-->
<!--                    <img src="--><?php //echo get_template_directory_uri(); ?><!--/assets/img/img/slide3.jpg" alt="">-->
<!--                </div>-->
<!--                <div class="slider__slide modal-btn" data-modal="gallery">-->
<!--                    <img src="--><?php //echo get_template_directory_uri(); ?><!--/assets/img/img/slide4.jpg" alt="">-->
<!--                </div>-->
<!--                <div class="slider__slide modal-btn" data-modal="gallery">-->
<!--                    <img src="--><?php //echo get_template_directory_uri(); ?><!--/assets/img/img/slide7.png" alt="">-->
<!--                </div>-->
<!--                <div class="slider__slide modal-btn" data-modal="gallery">-->
<!--                    <img src="--><?php //echo get_template_directory_uri(); ?><!--/assets/img/img/slide5.jpg" alt="">-->
<!--                </div>-->
<!--                <div class="slider__slide modal-btn" data-modal="gallery">-->
<!--                    <img src="--><?php //echo get_template_directory_uri(); ?><!--/assets/img/img/slide4.jpg" alt="">-->
<!--                </div>-->
<!--                <div class="slider__slide modal-btn" data-modal="gallery">-->
<!--                    <img src="--><?php //echo get_template_directory_uri(); ?><!--/assets/img/img/slide7.png" alt="">-->
<!--                </div>-->
<!--                <div class="slider__slide modal-btn" data-modal="gallery">-->
<!--                    <img src="--><?php //echo get_template_directory_uri(); ?><!--/assets/img/img/slide5.jpg" alt="">-->
<!--                </div>-->
            </div>

            <div class="pagination gallery__pagination">
                <div class="gallery__prev gallery__arrow"><span><i class="arrow arrow-left"></i></span></div>
                <div class="dots-wrapper"><div class="dots"></div></div>
                <div class="gallery__next gallery__arrow"><span><i class="arrow arrow-right"></i></span></div>
            </div>
        </div>
    </div>


    <div class="gallery">
        <div class="gallery__title">Gallery 2</div>

        <div class="gallery__wrap">
            <div class="gallery__container">
                <div class="slider__slide modal-btn" data-modal="gallery">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img/slide4.jpg" alt="">
                </div>
                <div class="slider__slide modal-btn" data-modal="gallery">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img/slide7.png" alt="">
                </div>
            </div>

            <div class="pagination gallery__pagination">
                <div class="gallery__prev gallery__arrow"><span><i class="arrow arrow-left"></i></span></div>
                <div class="dots-wrapper"><div class="dots"></div></div>
                <div class="gallery__next gallery__arrow"><span><i class="arrow arrow-right"></i></span></div>
            </div>
        </div>
    </div>

<?php

get_footer();
