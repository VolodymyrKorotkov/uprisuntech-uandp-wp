<?php
/**
 * Related Products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/related.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     3.9.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
$related_cases = get_field('related_case_studies');

if (!empty($related_cases)):
?>
    <section class="related">
        <div class="container">
            <div class="related-block">
                <h2 class="related__title"><?php _e('Related Case Studies','ndp') ?></h2>
                <div class="related__slider">
                    <div class="related__slider-block owl-carousel" id="owl1">
                        <?php foreach ($related_cases as $related_case): ?>
                            <?php
                            get_template_part('woocommerce/content-product-case', '', $related_case);
                            ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="related__slider__navigation">
                        <div class="related__slider__navigation__dots">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
endif;

function get_products_by_category_id($category_id, $number_of_products = 5) {
    // Аргументы для WP_Query
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => $number_of_products,
        'tax_query' => array(
            array(
                'taxonomy' => 'product_cat',
                'field'    => 'term_id',
                'terms'    => $category_id,
                'operator' => 'IN',
            ),
        ),
    );

    // Запрос продуктов
    $products_query = new WP_Query($args);

    // Вернуть объект WP_Query
    return $products_query;
}

$category_id =  get_query_var('current_category_id', '')->term_id; // Замените на актуальный ID категории
$number_of_products = 12; // Количество товаров, которое вы хотите получить

$related_products = get_products_by_category_id($category_id, $number_of_products);

if ( $related_products ) : ?>

  <section class="other">
    <div class="container">
      <div class="other-block">
        <div class="other__header">
          <h2 class="other__title"><?php _e('Other solutions','ndp') ?></h2>
          <div class="other__link">
            <a href="<?php echo get_permalink($category_id); ?>"><?php _e('See all solutions','ndp') ?></a>
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/arrow-link.svg" alt="arrow">
          </div>
        </div>
        <div class="other__slider">
            <div class="other__slider-block owl-carousel" id="owl2">
                <?php if ($related_products->have_posts()) : ?>
                    <?php while ($related_products->have_posts()) : $related_products->the_post(); ?>
                        <?php
                    $post_object = get_post(get_queried_object_id());
                        get_template_part('woocommerce/content-product-related',"",$post_object);
                        ?>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php else : ?>
                    <p>No related products found.</p>
                <?php endif; ?>
            </div>
          <div class="other__slider__navigation">
            <div class="other__slider__navigation__dots">
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
	<?php
endif;

wp_reset_postdata();
