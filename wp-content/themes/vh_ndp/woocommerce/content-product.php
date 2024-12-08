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

if ( empty( $product ) || ! $product->is_visible() ) {
    return;
}

$stock_status = $product->get_stock_status();

$productID = $product->get_id();
$categories =  get_the_terms($productID, 'product_cat');
$categoryName = '';
if ($categories && ! is_wp_error($categories)) {
    $categoryName = $categories[0]->name;
}

$brands = get_the_terms($productID, 'sp_smart_brand' );
$brand_url = '';
if ($brands && ! is_wp_error($brands)) {
    $brand_name = $brands[0]->name;
    $term_all_meta = get_term_meta($brands[0]->term_id, 'sp_smart_brand_taxonomy_meta', true);
    $brand_url = isset($term_all_meta['smart_brand_term_logo']['url']) ? $term_all_meta['smart_brand_term_logo']['url'] : '';
}

$current_lang = apply_filters( 'wpml_current_language', 'uk');
$comparisonArray = [];
$added = '';
if (!empty($_SESSION['comparisonArray']) && !empty($_SESSION['comparisonArray'][$current_lang]) && in_array($productID, $_SESSION['comparisonArray'][$current_lang])) {
    $added = 'added';
}
?>
<div class="col-12 col-sm-6 col-lg-4">
    <div class="product-item" data-stock-status="<?php echo $stock_status; ?>">
        <div class="product-item__img"><a href="<?php echo $product->get_permalink() ?>"><img src="<?php echo wp_get_attachment_url($product->get_image_id()); ?>" alt=""></a></div>
        <div class="product-item__content">
            <div class="product-item__top">
                <span class="product-item__category"><?php echo $categoryName; ?></span>
                <?php if ($brand_url): ?>
                <img src="<?php echo $brand_url; ?>" alt="<?php echo $brand_name; ?>">
                <?php endif; ?>
            </div>
            <div class="product-item__text">
                <?php
                // Обрезка заголовка
                $title = $product->get_title();
                if (mb_strlen($title) > 60) {
                    $title = mb_substr($title, 0, 60) . '...';
                }

                // Удаление тегов из описания и его обрезка
                $description = $product->get_description();
                $description = strip_tags($description); // Удаление HTML-тегов
                if (mb_strlen($description) > 120) {
                    $description = mb_substr($description, 0, 120) . '...';
                }
                ?>

                <a href="<?php echo $product->get_permalink() ?>" class="product-item__title"><?php echo $title ?></a>
                <p><?php echo $description; ?></p>
            </div>
            <div class="product-item__bottom">
                <a href="<?php echo $product->get_permalink() ?>" class="readmore"><?php _e('Read more','ndp'); ?></a>
                <div class="d-flex">
                    <a href="" data-item-id="<?php echo $productID; ?>" class="add-to btn btn_compare add_to_comparison me-2 <?php echo $added; ?>"></a>
                    <a href="/?add-to-cart=<?php echo $productID; ?>" data-quantity="1" data-product_id="<?php echo $productID; ?>" class="btn btn_bg_primary add_to_cart_button ajax_add_to_cart"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></a>
                </div>
            </div>
        </div>
    </div>
</div>
