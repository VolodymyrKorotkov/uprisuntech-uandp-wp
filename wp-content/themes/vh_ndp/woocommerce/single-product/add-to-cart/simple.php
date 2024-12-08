<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 7.0.1
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

echo wc_get_stock_html( $product ); // WPCS: XSS ok.

$added = checkIfProductAddedToComparison((int)esc_attr( $product->get_id() ))? 'added' : '';

if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

    <div class="product__buttons">
        <?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>
        <a href="<?php echo $product->add_to_cart_url() ?>" value="<?php echo esc_attr( $product->get_id() ); ?>" class="btn btn_bg_primary product__buttons__add ajax_add_to_cart add-to add_to_cart_button" data-product_id="<?php echo get_the_ID(); ?>" aria-label="Add “<?php the_title_attribute() ?>” to your cart">
            <?php echo esc_html( $product->single_add_to_cart_text() ); ?>
        </a>
        <?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>

        <a href="" data-item-id="<?php echo esc_attr( $product->get_id() ); ?>" class="btn product__buttons__balance add-to <?php echo $added; ?> add_to_comparison"></a>
    </div>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

<?php endif; ?>
