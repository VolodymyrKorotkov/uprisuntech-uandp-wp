<?php
/*
Template Name: Cart
*/

get_header();
$total_items = WC()->cart->get_cart_contents_count();

global $woocommerce;
$items = $woocommerce->cart->get_cart();


?>
    <nav class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-block">
                 <div class='fn_breadcrumbs'>
                <?php yoast_breadcrumb(); ?>
            </div>
            </div>
        </div>
    </nav>
    <section class="cart">
        <div class="container">
            <div class="cart__header">
                <h1 class="cart__title"><?php _e('Approve solutions','ndp'); ?></h1>
                <?php
                $current_lang = apply_filters( 'wpml_current_language', 'uk');
                $total_items_text = '';
                if ($current_lang == 'uk') {
                    $total_items_text = declOfNum($total_items, ['рішення', 'рішення', 'рішень']);
                } else {
                    $total_items_text = sprintf( _n( '%s item', '%s items', $total_items, 'ndp' ), $total_items );
                }
                ?>
                <span class="cart__item__amount">(<?php echo $total_items_text;?>)</span>
            </div>

            <table class="cart-table">
<?php if($items){ ?>
                <tbody>
                <tr class="cart-table__header">
                    <td class="cart-table__title"><?php _e('Solution','ndp'); ?></td>
                    <td class="cart-table__title"><?php _e('Category','ndp'); ?></td>
                    <td class="cart-table__title"><?php _e('Vendor','ndp'); ?></td>
                    <td class="cart-table__title"><?php _e('Number','ndp'); ?></td>
                    <td class="cart-table__title"></td>
                </tr>




                <?php  foreach($items as $item => $values) { ?>
                        <?php $_product =  wc_get_product( $values['data']->get_id());?>
                    <?php $post_thumbnail_id = $_product->get_image_id(); ?>
                        <?php $term_id = $_product->get_category_ids()[0];; // Замените на ваш ID категории
                    $category = get_term_by( 'id', $term_id, 'product_cat' );
                    $product = wc_get_product( $_product->get_id() );
                    $permalink = $product->get_permalink();
                    $brands = get_the_terms($_product->get_id(), 'sp_smart_brand' );
                    $brand_url = '';
                    $brand_name = '';
                    if ($brands && ! is_wp_error($brands)) {
                        $brand_name = $brands[0]->name;
                        $term_all_meta = get_term_meta($brands[0]->term_id, 'sp_smart_brand_taxonomy_meta', true);
                        $brand_url = isset($term_all_meta['smart_brand_term_logo']['url']) ? $term_all_meta['smart_brand_term_logo']['url'] : '';
                    }
                    $cart_item_key = $item;
                    $remove_link = wc_get_cart_remove_url( $cart_item_key );
                    if (isset(WC()->cart->get_cart()[$cart_item_key])) {
                        $current_quantity = WC()->cart->get_cart()[$cart_item_key]['quantity'];

                    }

                    ?>
                    <tr class="cart-table__item">
                        <td class="cart-table__solution">
                            <div class="cart-table__solution-block">
                                <a class="cart-table__solution__image image" href="<?php echo $permalink;?>"> <img src="<?php echo wp_get_attachment_url( $post_thumbnail_id ); ?>" alt="solution-photo"></a>
                                <h2 class="cart-table__solution__title"><?php echo $_product->get_name(); ?></h2>
                            </div>
                        </td>
                        <td class="cart-table__category"><?php echo $category->name; ?></td>
                        <td class="cart-table__vendor"><img src="<?php echo $brand_url; ?>" alt="<?php echo $brand_name;?>"></td>
                        <td class="cart-table__amount">
                            <div class="cart-table__amount-block">
                                <button class="cart-table__amount__minus cart-table__amount__button <?php if ($current_quantity<2) echo 'btn-disabled'; ?>"></button>
                                <input type="text" data-cart-item-key="<?php echo $cart_item_key;?>" class="cart-table__amount__value" value="<?php echo $current_quantity; ?>">
                                <button class="cart-table__amount__plus cart-table__amount__button"></button>
                            </div>
                        </td>
                        <td class="cart-table__delete">
                            <button data-remove="<?php echo $remove_link;?>" class="cart-table__delete__button"></button>
                        </td>
                    </tr>
        <?php } ?>

                </tbody>
    <?php } else{  ?>
    <tbody class="empty">
    <tr class="cart-table__header">
        <td class="cart-table__title"><?php _e('Solution','ndp'); ?></td>
        <td class="cart-table__title"><?php _e('Category','ndp'); ?></td>
        <td class="cart-table__title"><?php _e('Vendor','ndp'); ?></td>
        <td class="cart-table__title"><?php _e('Amount','ndp'); ?></td>
        <td class="cart-table__title"></td>
    </tr>

    <tr class="application__empty-content">
        <td colspan="5" class="application__empty-cell">
            <div class="application__empty-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/comparison/empty-img.svg" alt="empty-img">
            </div>
            <div class="application__empty-text"><?php _e('No solutions added','ndp'); ?></div>
        </td>
    </tr>
    </tbody>
        <?php } ?>

            </table>

            <?php    $lng_url = '';
            $language_code = '';
            $languages = icl_get_languages('skip_missing=0&orderby=code');
            if(!empty($languages)){
                foreach($languages as $l){
                    if($l['active']){
                        $lng_url = $l['url'];
                        $language_code = $l['language_code'];
                    }
                }
            }    $lng_url = strpos($lng_url, '/'.$language_code. '/') !== false  ? '/'.$language_code : ''; ?>
            <a href="<?php echo $lng_url; ?>/create-application/?selectedCart=true" class="cart__button"><?php _e('Create application','ndp'); ?></a>
        </div>
    </section>
    <section class="ticker">
        <div class="ticker-block">
            <div class="ticker__item">
                <div class="ticker__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/cart/trident.png" alt="trident"></div>
                <h3 class="ticker__title">National Decarbonization Platform</h3>
            </div>
            <div class="ticker__item">
                <div class="ticker__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/cart/trident.png" alt="trident"></div>
                <h3 class="ticker__title">National Decarbonization Platform</h3>
            </div>
            <div class="ticker__item">
                <div class="ticker__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/cart/trident.png" alt="trident"></div>
                <h3 class="ticker__title">National Decarbonization Platform</h3>
            </div>
            <div class="ticker__item">
                <div class="ticker__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/cart/trident.png" alt="trident"></div>
                <h3 class="ticker__title">National Decarbonization Platform</h3>
            </div>
            <div class="ticker__item">
                <div class="ticker__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/cart/trident.png" alt="trident"></div>
                <h3 class="ticker__title">National Decarbonization Platform</h3>
            </div>
            <div class="ticker__item">
                <div class="ticker__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/cart/trident.png" alt="trident"></div>
                <h3 class="ticker__title">National Decarbonization Platform</h3>
            </div>
            <div class="ticker__item">
                <div class="ticker__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/cart/trident.png" alt="trident"></div>
                <h3 class="ticker__title">National Decarbonization Platform</h3>
            </div>
            <div class="ticker__item">
                <div class="ticker__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/cart/trident.png" alt="trident"></div>
                <h3 class="ticker__title">National Decarbonization Platform</h3>
            </div>
            <div class="ticker__item">
                <div class="ticker__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/cart/trident.png" alt="trident"></div>
                <h3 class="ticker__title">National Decarbonization Platform</h3>
            </div>
            <div class="ticker__item">
                <div class="ticker__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/cart/trident.png" alt="trident"></div>
                <h3 class="ticker__title">National Decarbonization Platform</h3>
            </div>
        </div>
    </section>

<?php require "template-parts/content-cart.php"?>

<?php

get_footer();
