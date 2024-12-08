<?php
/**
 * Single Product title
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/title.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see        https://docs.woocommerce.com/document/template-structure/
 * @package    WooCommerce\Templates
 * @version    1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

$productID = $product->get_id();
$categories =  get_the_terms($productID, 'product_cat');
$categoryName = '';
if ($categories && ! is_wp_error($categories)) {
    $categoryName = $categories[0]->name;
    set_query_var('current_category_id',$categories[0]);
}

$brands = get_the_terms($productID, 'sp_smart_brand' );
$brand_url = '';
$brand_name = '';
if ($brands && ! is_wp_error($brands)) {
    $brand_name = $brands[0]->name;
    $term_all_meta = get_term_meta($brands[0]->term_id, 'sp_smart_brand_taxonomy_meta', true);
    $brand_url = isset($term_all_meta['smart_brand_term_logo']['url']) ? $term_all_meta['smart_brand_term_logo']['url'] : '';
}
if (!$categoryName && !$brand_url) return;
?>
<div class="product__subtitle"><span><?php echo $categoryName; ?></span><img src="<?php echo $brand_url; ?>" alt="<?php echo $brand_name; ?>"></div>
