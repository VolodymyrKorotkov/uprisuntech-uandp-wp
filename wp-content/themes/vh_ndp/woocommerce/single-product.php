<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     1.6.4
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'home' ); ?>

<nav class="breadcrumb">
	<div class="container">
		<?php
		yoast_breadcrumb();
		?>
	</div>
</nav>
<?php
    /**
     * woocommerce_before_main_content hook.
     *
     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
     * @hooked woocommerce_breadcrumb - 20
     */
//		do_action( 'woocommerce_before_main_content' );
/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action( 'woocommerce_before_single_product' );
?>

    <?php while ( have_posts() ) : ?>
        <?php the_post(); ?>

        <?php wc_get_template_part( 'content', 'single-product' ); ?>

    <?php endwhile; // end of the loop. ?>

<section class="info">
  <div class="container">
    <div class="info-block d-flex justify-content-between flex-column flex-md-row">
        <?php
        global $post;
        $files = get_field('files_group');

        if (!empty($post->post_content) || !empty($files)):
        ?>
      <div class="info-block__left col-12 col-md-6">
          <?php
          wc_get_template('single-product/tabs/description.php');
          ?>
        <?php
        if (!empty($files)): ?>
        <div class="files"><h2 class="files__title"><?php _e('Files','ndp') ?></h2>
          <div class="files-block">
            <?php foreach ($files as $key => $file): ?>
            <?php $file = $file['file'] ?? []; ?>
            <?php if (empty($file)) continue; ?>
            <div class="files__item">
              <div class="files__item__img">
                <a download="" href="<?php echo $file['url']; ?>"></a>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/pdf-icon.svg" alt="pdf-icon"></div>
              <div class="files__item__text">
                <a download="" href="<?php echo $file['url']; ?>"><span class="files__item__name"><?php echo $file['filename']; ?></span></a>
                <span class="files__item__size"><?php echo size_format( $file['filesize'] ); ?></span>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
      </div>
      <?php endif; ?>
        <?php
//        $attributesGroup = acf_get_fields('group_64feabfd747d4');
//        $attributes = [];
//
//        foreach ($attributesGroup as $key => $attribute) {
//            if (is_array($attribute) && !empty($attribute['name'])) {
//                $name = $attribute['name'];
//                if ($attributeValues = get_field($attribute['name'])) {
//                    $attributes[$key]['label'] = $attribute['label'];
//                    $n = 0;
//                    foreach ($attributeValues as $k => $value) {
//                        if ($value) {
//                            $attributes[$key]['attributes'][$n]['term_id'] = $value->term_id;
//                            $attributes[$key]['attributes'][$n]['value'] = $value->name;
//                            $attributes[$key]['attributes'][$n]['label'] = $attribute['sub_fields'][$n]['label'];
//                            $attributes[$key]['attributes'][$n]['taxonomy'] = $value->taxonomy;
//                        }
//                        $n++;
//                    }
//                }
//            }
//        }
        $prod = wc_get_product( get_the_ID() );
        ?>
        <?php wc_display_product_attributes($prod); ?>



    </div>
  </div>
</section>

<?php
/**
 * Hook: woocommerce_after_single_product_summary.
 *
 * @hooked woocommerce_output_product_data_tabs - 10
 * @hooked woocommerce_upsell_display - 15
 * @hooked woocommerce_output_related_products - 20
 */
do_action( 'woocommerce_after_single_product_summary' );

do_action('woocommerce_after_single_product');


?>



<?php
    /**
     * woocommerce_after_main_content hook.
     *
     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
     */
//		do_action( 'woocommerce_after_main_content' );
?>
<script>
    $ = jQuery;

    $(document).ready(function(){
        $('#owl1').owlCarousel({
            loop:false,
            margin:24,
            dotsEach:true,
            nav:true,
            dots:true,
            navContainer: ".related__slider__navigation",
            dotsContainer: ".related__slider__navigation__dots",
            navText: ['<img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/arrow-left.svg">', '<img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/arrow-right.svg">'],
            responsive:{
                0:{
                    items:1
                },
                575:{
                    items:2
                },
                1000:{
                    items:3
                }
            }
        })
        $('#owl2').owlCarousel({
            loop:false,
            margin:24,
            dotsEach:true,
            nav:true,
            dots:true,
            navContainer: ".other__slider__navigation",
            dotsContainer: ".other__slider__navigation__dots",
            navText: ['<img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/arrow-left.svg">', '<img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/arrow-right.svg">'],
            responsive:{
                0:{
                    items:1
                },
                575:{
                    items:2
                },
                1000:{
                    items:3
                }
            }
        })
    });

    var comparisonText = "<?php _e('Item added to comparison', 'ndp'); ?>";
    var alreadyaddedText="<?php _e('Item already added', 'ndp'); ?>";

</script>
<?php
get_footer( 'shop' );

/* Omit closing PHP tag at the end of PHP files to avoid "headers already sent" issues. */
