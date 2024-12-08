<?php
if( ! wp_style_is( 'vh_ndp-gallery' ) ){
    wp_enqueue_style('vh_ndp-gallery', get_template_directory_uri() . '/assets/css/gallery.css');
}
if ( ! wp_script_is( 'vh_ndp-gallery', 'enqueued' ) ) {
    wp_enqueue_script('vh_ndp-gallery', get_template_directory_uri() . '/assets/js/gallery.js', array(), _S_VERSION, true);
}
?>
<div class="gallery">
    <div class="gallery__title"></div>

    <div class="gallery__wrap">
        <div class="gallery__container">
            <?php foreach ($image_ids as $image_id): ?>
                <?php $image_url = wp_get_attachment_url($image_id); ?>
                <?php if ($image_url): ?>
                    <div class="slider__slide modal-btn" data-modal="gallery">
                        <img id="responsive_img" data-zoom-image="<?php echo esc_url($image_url); ?>" src="<?php echo esc_url($image_url); ?>" alt="">
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div class="pagination gallery__pagination">
            <div class="gallery__prev gallery__arrow"><span><i class="arrow arrow-left"></i></span></div>
            <div class="dots-wrapper"><div class="dots"></div></div>
            <div class="gallery__next gallery__arrow"><span><i class="arrow arrow-right"></i></span></div>
        </div>

    </div>
</div>

<script>
    var pageOfTranslate = '<?php echo __('Page <span class="active_slide">%p</span> of %s', 'ndp'); ?>';
</script>
