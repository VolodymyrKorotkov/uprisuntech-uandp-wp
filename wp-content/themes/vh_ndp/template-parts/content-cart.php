<?php
$total_items = WC()->cart->get_cart_contents_count();
$comparisonCount = 0;
$current_lang = apply_filters( 'wpml_current_language', 'uk');
if (isset($_SESSION['comparisonArray']) && !empty($_SESSION['comparisonArray'][$current_lang]) && is_array($_SESSION['comparisonArray'][$current_lang])) {
    $comparisonCount = count($_SESSION['comparisonArray'][$current_lang]);
}

?>
<?php
global $woocommerce;
$items = $woocommerce->cart->get_cart();

?>


<div class="cart-dropdown__overlay">
    <div class="cart-dropdown <?php if (!$items) { ?>empty<?php }?> ">
        <div class="cart-dropdown__header">
            <div class="cart-dropdown__header__text">
                <h2 class="cart-dropdown__title"><?php _e('Application','ndp'); ?></h2>
                <?php
                $total_items_text = '';
                if ($current_lang == 'uk') {
                    $total_items_text = declOfNum($total_items, ['рішення', 'рішення', 'рішень']);
                } else {
                    $total_items_text = sprintf( _n( '%s item', '%s items', $total_items, 'ndp' ), $total_items );
                }
                ?>
                <span class="cart-dropdown__item__amount">(<?php echo $total_items_text; ?>)</span>
            </div>
            <button class="cart-dropdown__close"></button>
        </div>
        <div class="cart-dropdown-block s" data-item-added="<?php _e('Item added to the solution', 'ndp'); ?>">


<?php if ($items) { ?>
            <?php foreach($items as $item => $values) { ?>
                <?php $_product =  wc_get_product( $values['data']->get_id());?>
                <?php $post_thumbnail_id = $_product->get_image_id(); ?>
                <?php $term_id = $_product->get_category_ids()[0];; // Замените на ваш ID категории
                $category = get_term_by( 'id', $term_id, 'product_cat' );
                $_product = wc_get_product( $_product->get_id() );
                $permalink = $_product->get_permalink();

                $cart_item_key = $item;
                $remove_link = wc_get_cart_remove_url( $cart_item_key );
                if (isset(WC()->cart->get_cart()[$cart_item_key])) {
                    $current_quantity = WC()->cart->get_cart()[$cart_item_key]['quantity'];
                }

                ?>
            <div class="cart-dropdown__item">
            <a class="cart-dropdown__item__image" href="<?php echo $permalink;?>"><img src="<?php echo wp_get_attachment_url( $post_thumbnail_id ); ?>" alt="solution-photo"></a>
            <h3 class="cart-dropdown__item__title"><?php echo $_product->get_name(); ?></h3>
            <div class="cart-dropdown__item__buttons">
                <div class="cart-dropdown__item__count">
                    <button class="cart-dropdown__item__button cart-dropdown__item__minus <?php if ($current_quantity<2) echo 'btn-disabled'; ?>" id="minusButton"></button>
                    <input data-cart-item-key="<?php echo $cart_item_key;?>" type="text" value="<?php echo $current_quantity; ?>" class="cart-dropdown__item__value">
                    <button class="cart-dropdown__item__button cart-dropdown__item__plus" id="plusButton"></button>
                </div>
                <button data-remove="<?php echo $remove_link;?>" class="cart-dropdown__item__delete"></button>
            </div>
            </div>

            <?php } ?>

<?php
$cartLink = '/cart';
if ($current_lang != 'uk') {
    $cartLink = '/'.$current_lang . $cartLink;
}
?>

        <a class="cart-dropdown__button" href="<?php echo $cartLink; ?>"><?php _e('Create application','ndp'); ?></a>
        <?php } else{ ?>

    <div class="application__empty-content">
        <div class="application__empty-image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/comparison/empty-img.svg" alt="empty-img"></div>
        <span class="application__empty-text"><?php _e('No solutions added','ndp'); ?></span>
    </div>
    <div class="application__empty-footer">
        <a href="#" class="application__empty-button"><?php _e('Create application','ndp'); ?></a>
    </div>


    <script>
        $('.cart-dropdown__overlay').removeClass('cart-dropdown__overlay__active');
    </script>

        <?php } ?>
        </div>
    </div>
</div>
<div class="static-nav">
    <div class="static-nav-block">
        <div class="static-nav__item">
        <?php
        $comparisonLink = '/comparison/';
        if ($current_lang != 'uk') {
            $comparisonLink = '/'.$current_lang . $comparisonLink;
        }
        ?>
        <a class="btn-count1 btn-comparison static-nav__button static-nav__button__comprasion" href="<?php echo $comparisonLink; ?>">
<!--            <div class="static-nav__button static-nav__button__comprasion">-->
                <button></button>
                <span class="btn-count__number"><?php echo $comparisonCount; ?></span>
<!--            </div>-->
        </a>
            <h4 class="static-nav__title"><?php _e('Comprasion','ndp'); ?></h4>
        </div>
        <div class="static-nav__item static-nav__item__application">
            <div class="static-nav__button static-nav__button__application"><button></button><span><p class="cart-total_items"><?php echo $total_items; ?></p></span></div>
            <h4 class="static-nav__title"><?php _e('Application','ndp'); ?></h4>
        </div>
    </div>
</div>
<script>
       
    $ = jQuery;

    const toggle = function() {

        $(document).on('click','.static-nav__item__application',function() {
            $('.cart-dropdown').addClass('cart-dropdown__active');
            $('.cart-dropdown__overlay').addClass('cart-dropdown__overlay__active');
            $('body').css({'overflow': 'hidden', 'padding-right': '17px'});
        })
        $(document).on('click','.cart-dropdown__close, .cart-dropdown__overlay',function(event) {
            let $target = $(event.target);
            if ($target.is('.cart-dropdown__close') || $target.is('.cart-dropdown__overlay')) {
                $('.cart-dropdown').removeClass('cart-dropdown__active');
                $('.cart-dropdown__overlay').removeClass('cart-dropdown__overlay__active');
                $('body').css({'overflow': '', 'padding-right': ''});
            }
        })

    };
    $(document).ready(toggle);
</script>
