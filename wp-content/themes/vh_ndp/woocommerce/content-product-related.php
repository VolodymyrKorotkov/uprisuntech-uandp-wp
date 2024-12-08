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
global $product;
if (empty($args)) return;

$postID = $args->ID;


if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$productID = $product->get_id();
$categories =  get_the_terms($postID, 'product_cat');

$categoryName = '';
if ($categories && ! is_wp_error($categories)) {
    $categoryName = $categories[0]->name;
}

$brands = get_the_terms($postID, 'sp_smart_brand' );
$brand_url = '';
if ($brands && ! is_wp_error($brands)) {
    $brand_name = $brands[0]->name;
    $term_all_meta = get_term_meta($brands[0]->term_id, 'sp_smart_brand_taxonomy_meta', true);
    $brand_url = isset($term_all_meta['smart_brand_term_logo']['url']) ? $term_all_meta['smart_brand_term_logo']['url'] : '';
}


$thumbnail_id = get_post_thumbnail_id( $postID );
$image_url = '';
if (!$thumbnail_id) {
    $image_url = get_template_directory_uri() . '/assets/img/img/noimage.png';
} else {
    $image_url =wp_get_attachment_url($product->get_image_id());
}
$link = get_permalink($product->get_id());
$_product = $product->post;
$added = checkIfProductAddedToComparison((int)$product->get_id())? 'added' : '';
?>
<div class="other__slider__item" data-item-id="<?php echo $postID; ?>">
    <div class="other__slider__image"><a href="<?php echo $link; ?>"><img src="<?php echo $image_url; ?>" alt=""></a></div>
    <div class="other__slider__text">
        <div class="other__slider__type">
            <span><?php echo $categoryName; ?></span><img src="<?php echo $brand_url; ?>" alt="">
        </div>
        <h4 class="other__slider__title"><a href="<?php echo $link; ?>"><?php echo $_product->post_title; ?></a></h4>
        <p class="other__slider__description"><?php echo strip_tags($_product->post_excerpt ? $_product->post_excerpt : $_product->post_content); ?></p>
        <div class="other__slider__buttons"><a href="<?php echo $link; ?>" class="other__slider__buttons__more"><?php _e('Read more','ndp'); ?> <a href="" data-item-id="<?php echo $productID; ?>" class="btn product__buttons__balance add-to  add_to_comparison"></a>      <a href="/?add-to-cart=<?php echo $productID; ?>" data-quantity="1" data-product_id="<?php echo $productID; ?>" class="btn btn_bg_primary add_to_cart_button ajax_add_to_cart other__slider__buttons__add"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></a></div>


    </div>
</div>
