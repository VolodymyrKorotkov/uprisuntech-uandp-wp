<?php
/**
 * Single Product Image
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/product-image.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.8.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

$attachment_ids = $product->get_gallery_image_ids();
if ($product->get_image_id()) {
    array_unshift($attachment_ids, $product->get_image_id());
}

if ($attachment_ids) {
    echo do_shortcode( '[my_extended_gallery gallery_title="" images="'. implode(',', $attachment_ids) .'"]' );
}
//elseif ($product->get_image_id()) { ?>
<!--    <div class="photo__main">--><?php //echo $product->get_image('full') ?><!--</div>-->
<!--    --><?php
//}
