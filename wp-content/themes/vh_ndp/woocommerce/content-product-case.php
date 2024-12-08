<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.6.0
 */

defined( 'ABSPATH' ) || exit;
if (empty($args)) return;

$postID = $args->ID;
$thumbnail_id = get_post_thumbnail_id($postID);
$image_url = '';
if (!$thumbnail_id) {
    $image_url = get_template_directory_uri() . '/assets/img/img/noimage.png';
} else {
    $image_url = wp_get_attachment_image_src($thumbnail_id)[0];
}
$link = get_permalink($postID);
?>
<div class="related__slider__item" data-item-id="<?php echo $postID; ?>">
    <div class="related__slider__image"><a href="<?php echo $link; ?>"><img src="<?php echo $image_url; ?>" alt=""></a></div>
    <div class="related__slider__text">
        <h4 class="related__slider__title"><a href="<?php echo $link; ?>"><?php echo $args->post_title; ?></a></h4>
        <div class="related__slider__type">
            <div class="related__slider__type__item related__slider__type__item__current"><span>Global</span></div>
            <div class="related__slider__type__item"><span>Storage</span></div>
            <div class="related__slider__type__item"><span>+2</span></div>
        </div>
        <p class="related__slider__description">CleanCapital secures $500M funding commitment to expand distributed solar and storage platform.</p>
        <div class="related__slider__date">
            <span>31.07.23, </span><span>13:53</span>
        </div>
    </div>
</div>
