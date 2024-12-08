<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 3.4.0
 */

defined( 'ABSPATH' ) || exit;




        $original_post_id = 182; // ID оригинальной записи
        $current_language = ICL_LANGUAGE_CODE; // Текущий язык пользователя

        // Получаем ID переведенной записи
        $translated_post_id = apply_filters('wpml_object_id', $original_post_id, 'post', TRUE, $current_language);


            wp_redirect(get_permalink($translated_post_id));
            exit;




get_header();
?>
    <div class="top-block section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumb-block">
                        <nav class="breadcrumb">
                             <div class='fn_breadcrumbs'>
                <?php yoast_breadcrumb(); ?>
            </div>
                        </nav>
                    </div>
                    <h1 class="section__title"><?php _e('Solutions','ndp') ?></h1>
                </div>
                <div class="col-lg-6 pt-3 pt-lg-0">
                    <div class="howitworks">
                        <p class="howitworks__title d-flex align-items-center mb-2">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM9 15V13H11V15H9ZM9 5V11H11V5H9Z" fill="#2A59BD"></path>
                            </svg>
                            <span class="ms-2"><?php _e('How it works','ndp'); ?></span></p>
                        <p class="howitworks__content">

                            <?php _e('This section contains information about the vendors and solutions presented on the platform. Once you have selected several solutions, you can compare them with each other or add them to your funding application.','ndp'); ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="row top-categories justify-content-center justify-content-sm-start">
                <?php
                $curentCategory = get_queried_object();

                $args = array(
                    'taxonomy'     => 'product_cat',
                    'orderby'      => 'name',
                    'hide_empty'   => false,
                    'show_count'   => false,
                );
                if ($curentCategory instanceof WP_Term) {
                    $args['parent'] = $curentCategory->term_id;
                }

                $all_categories = get_categories($args);

                foreach ($all_categories as $category) {
                    $link = get_term_link( $category->term_taxonomy_id, 'product_cat' );
                    $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
                    $image_url = wp_get_attachment_url( $thumbnail_id );
                    ?>
                    <div class="col category-item">
                        <a href="<?php echo $link; ?>">
                            <span class="category-item__img"><img src="<?php echo $image_url; ?>" alt=""></span>
                            <span class="category-item__title"><?php echo $category->name ?></span>
                        </a>
                    </div>
                <?php } ?>
            </div>
        </div>

    </div>

<?php
$vendors = wp_cache_get('allVendors');
if (false === $vendors){
    global $wpdb;

    $sql = "SELECT t.term_id, t.name as brand_name, t.slug as brand_slug, tt.taxonomy, tm.meta_key, tm.meta_value FROM `{$wpdb->term_taxonomy}` tt 
INNER JOIN `{$wpdb->terms}` t ON tt.term_id = t.term_id 
INNER JOIN `{$wpdb->termmeta}` tm ON tm.term_id = t.term_id 
WHERE tt.taxonomy = 'sp_smart_brand'";

    $vendors = $wpdb->get_results($sql, ARRAY_A);

    foreach ($vendors as $key => $vendor) {
        $img = unserialize($vendor['meta_value']);
        $meta = unserialize($vendor['meta_value']);
        if (!empty($meta['smart_brand_term_logo']) && !empty($meta['smart_brand_term_logo']['url'])) {
            $vendors[$key]['logo'] = $meta['smart_brand_term_logo'];
        }
    }
    wp_cache_set('allVendors', $vendors);
}


$showCount = SHOWCOUNT;
if (!empty($_SESSION['showCount']) && $_SESSION['showCount'] > 0) {
    $showCount = (int)$_SESSION['showCount'];
}
$sortCount = $showCount;
?>
    <main class="main">
        <?php if (woocommerce_product_loop()):?>
            <div class="section container settings">
                <div class="row align-items-center">
                    <div class="col settings__col settings__col--first">
                        <h3 class="section__title settings__title"><?php _e('Solutions','ndp'); ?></h3>
                    </div>

                    <div class="col settings__col settings__col--right">
                        <div class="options">
                            <span class="options__text"><?php _e('Show items:','ndp'); ?></span>
                            <div class="options__select">
                                <span class="options__current me-3"><?php echo $sortCount ?></span>
                                <i class="arrow-down"></i>
                                <div class="options__wrapper">
                                    <form method="post">
                                        <ul class="options__list">

                                            <li <?php if ($sortCount == 15): ?> class="options__list--checked" <?php endif; ?>>15</li>
                                            <li <?php if ($sortCount == 30): ?> class="options__list--checked" <?php endif; ?>>30</li>
                                            <li <?php if ($sortCount == 45): ?> class="options__list--checked" <?php endif; ?>>45</li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="filter">
                            <button type="button" class="filter__button modal-btn" data-modal="filter"><?php _e('Filters &amp; sort','ndp'); ?></button>
                        </div>
                    </div>

                    <div class="filter filter--mob">
                        <button type="button" class="filter__button modal-btn" data-modal="filter"><?php _e('Filters &amp; sort','ndp'); ?></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="main__content container">
            <div class="row">
                <?php
                if (woocommerce_product_loop()) {
                    while ( have_posts() ) {
                        the_post();
                        wc_get_template_part( 'content', 'product' );
                    }
                    woocommerce_product_loop_end();

                    /**
                     * Hook: woocommerce_after_shop_loop.
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action( 'woocommerce_after_shop_loop' );

                    do_action( 'woocommerce_after_main_content' );
                } else {
                    do_action( 'woocommerce_no_products_found' );
                }
                ?>
            </div>
        </div>

        <?php
        /**
         * Hook: woocommerce_after_main_content.
         *
         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
         */
        do_action( 'woocommerce_after_main_content' );
        ?>
    </main>

    <div class="section section-vendors">
        <div class="section__top container">
            <div class="row">
                <div class="col d-flex justify-content-between align-items-center">
                    <div class="section__title"><?php _e('Vendors','ndp'); ?></div>
                    <a href="" class="d-flex align-items-center">
                        <span class="me-2"><?php _e('See all vendors','ndp'); ?></span>
                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#6750A4"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="container section-vendors__content">
            <div class="swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($vendors as $key => $vendor): ?>
                        <?php if (($key) % 10 === 0): ?>
                            <div class="swiper-slide row row-cols-2 row-cols-lg-5 section-vendors__row">
                        <?php endif; ?>
                        <div class="col section-vendors__col">
                            <?php if (!empty($vendor['logo'])): ?>
                                <div class="section-vendors__img"><img src="<?php echo $vendor['logo']['url'] ?>" alt="benq"></div>
                            <?php endif; ?>
                            <div class="section-vendors__brand"><?php echo $vendor['brand_name'] ?></div>
                        </div>
                        <?php if ($key % 10 === 9 && $key > 0): ?>
                            </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php if ($key % 10 !== 0): ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="swiper-pagination"></div>

            <div class="swiper-prev-btn pagination mt-0 mb-0"><span><i class="arrow arrow-left"></i></span></div>
            <div class="swiper-next-btn pagination mt-0 mb-0"><span><i class="arrow arrow-right"></i></span></div>

        </div>

    </div>
    </div>

  <div class='ticker-block'>
    <div class='ticker-bg'>
      <svg width="320" height="380" viewBox="0 0 320 380" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g opacity="0.9">
          <path
                  d="M262.41 322.39C294.241 290.56 260.767 205.479 187.645 132.357C114.524 59.235 29.4427 25.7618 -2.38797 57.5924C-34.2186 89.423 -0.745347 174.504 72.3766 247.626C145.499 320.748 230.579 354.221 262.41 322.39Z"
                  stroke="#DAE2FF" stroke-miterlimit="10"/>
          <path
                  d="M245.339 339.466C277.169 307.635 243.696 222.555 170.574 149.433C97.4521 76.3106 12.3712 42.8374 -19.4594 74.668C-51.29 106.499 -17.8168 191.58 55.3051 264.701C128.427 337.823 213.508 371.297 245.339 339.466Z"
                  stroke="#DAE2FF" stroke-miterlimit="10"/>
          <path
                  d="M270.929 313.877C302.76 282.047 269.287 196.966 196.165 123.844C123.043 50.7221 37.9621 17.2488 6.13144 49.0794C-25.6992 80.9101 7.77406 165.991 80.896 239.113C154.018 312.235 239.099 345.708 270.929 313.877Z"
                  stroke="#DAE2FF" stroke-miterlimit="10"/>
          <path
                  d="M287.98 296.781C319.811 264.951 286.338 179.87 213.216 106.748C140.094 33.6258 55.013 0.15262 23.1823 31.9832C-8.64827 63.8139 24.825 148.895 97.9469 222.017C171.069 295.139 256.15 328.612 287.98 296.781Z"
                  stroke="#DAE2FF" stroke-miterlimit="10"/>
          <path
                  d="M296.541 288.268C328.372 256.438 294.898 171.357 221.776 98.2349C148.654 25.1129 63.5735 -8.36032 31.7429 23.4703C-0.0877271 55.3009 33.3855 140.382 106.507 213.504C179.629 286.626 264.71 320.099 296.541 288.268Z"
                  stroke="#DAE2FF" stroke-miterlimit="10"/>
          <path
                  d="M279.44 305.344C311.271 273.513 277.798 188.432 204.676 115.31C131.554 42.1883 46.473 8.71509 14.6424 40.5457C-17.1882 72.3763 16.285 157.457 89.4069 230.579C162.529 303.701 247.61 337.174 279.44 305.344Z"
                  stroke="#DAE2FF" stroke-miterlimit="10"/>
          <path
                  d="M253.849 330.932C285.68 299.102 252.207 214.021 179.085 140.899C105.963 67.777 20.8821 34.3037 -10.9485 66.1344C-42.7791 97.965 -9.30588 183.046 63.8161 256.168C136.938 329.29 222.019 362.763 253.849 330.932Z"
                  stroke="#DAE2FF" stroke-miterlimit="10"/>
          <path
                  d="M219.719 365.055C251.549 333.224 218.076 248.143 144.954 175.021C71.8322 101.899 -13.2488 68.4261 -45.0794 100.257C-76.91 132.087 -43.4367 217.168 29.6852 290.29C102.807 363.412 187.888 396.885 219.719 365.055Z"
                  stroke="#DAE2FF" stroke-miterlimit="10"/>
          <path
                  d="M236.819 347.979C268.65 316.148 235.177 231.068 162.055 157.946C88.9326 84.8236 3.85177 51.3504 -27.9788 83.181C-59.8095 115.012 -26.3362 200.092 46.7857 273.214C119.908 346.336 204.989 379.81 236.819 347.979Z"
                  stroke="#DAE2FF" stroke-miterlimit="10"/>
          <path
                  d="M228.259 356.521C260.089 324.69 226.616 239.61 153.494 166.488C80.3721 93.3656 -4.70877 59.8924 -36.5394 91.723C-68.37 123.554 -34.8968 208.634 38.2252 281.756C111.347 354.878 196.428 388.352 228.259 356.521Z"
                  stroke="#DAE2FF" stroke-miterlimit="10"/>
          <path
                  d="M305.06 279.755C336.891 247.925 303.418 162.844 230.296 89.7217C157.174 16.5997 72.093 -16.8735 40.2624 14.9571C8.43174 46.7877 41.905 131.869 115.027 204.991C188.149 278.112 273.23 311.586 305.06 279.755Z"
                  stroke="#DAE2FF" stroke-miterlimit="10"/>
        </g>
      </svg>
    </div>
      <?php include(get_template_directory() . '/templates/ticker_text.php'); ?>
  </div>


<?php
$current_language = ICL_LANGUAGE_CODE;  // Получение текущего языка

// Attributes for filter
$category_slug = $curentCategory->slug ?? '';

$attributesByCategory = wp_cache_get('attributesByCategory_' . $current_language);  // Учитываем язык в ключе кэша
$attributes = [];

if ($category_slug && !empty($attributesByCategory[$category_slug])) {
    $attributes = $attributesByCategory[$category_slug];
}
if (false === $attributesByCategory || empty($attributes)) {
    $attributesByCategory = [];
    $query_args = array(
        'status'    => 'publish',
        'limit'     => -1,
        'category'  => array($category_slug),
        'lang'      => $current_language,  // Добавлено для WPML
    );

    foreach (wc_get_products($query_args) as $product) {
        foreach ($product->get_attributes() as $taxonomy => $attribute) {
            $attribute_name = wc_attribute_label($taxonomy);
            $terms = $attribute->get_terms();
            foreach ((object)$terms as $term) {
                if (!isset($attributes[$taxonomy])) {
                    $attributes[$taxonomy]['attributeName'] = wc_attribute_label($term->taxonomy);
                    $attributes[$taxonomy]['values'] = [];
                }
                if (array_search($term->slug, array_column($attributes[$taxonomy]['values'], 'slug')) === false) {
                    $attributes[$term->taxonomy]['values'][] = [
                        'name' => $term->name,
                        'slug' => $term->slug,
                    ];
                }
            }
        }
    }
    $attributesByCategory[$category_slug] = $attributes;
    wp_cache_set('attributesByCategory_' . $current_language, $attributesByCategory);  // Учитываем язык в ключе кэша
}

// Vendors for filter
$vendorsByCategory = wp_cache_get('vendorsByCategory_' . $current_language);  // Учитываем язык в ключе кэша
$vendors = [];

if ($category_slug && !empty($vendorsByCategory[$category_slug])) {
    $vendors = $vendorsByCategory[$category_slug];
}
if (false === $vendorsByCategory || empty($vendors)) {
    $vendorsByCategory = [];
    $terms = get_woocommerce_additional_data($category_slug, 'sp_smart_brand', $current_language);  // Предполагаем, что функция может принимать языковой параметр

    foreach ($all_categories as $category) {
        $termsSubCategories = get_woocommerce_additional_data($category->slug, 'sp_smart_brand', $current_language);  // Предполагаем, что функция может принимать языковой параметр
        foreach ($termsSubCategories as $term) {
            $terms[] = $term;
        }
    }

    foreach ($terms as $term) {
        $vendor = [];
        $vendor['taxonomy'] = $term->taxonomy;
        $vendor['brand_name'] = $term->name;
        $vendor['brand_slug'] = $term->slug;
        if (array_search($term->slug, array_column($vendors, 'brand_slug')) === false) {
            $vendors[] = $vendor;
        }
    }
    $vendorsByCategory[$category_slug] = $vendors;
    wp_cache_set('vendorsByCategory_' . $current_language, $vendorsByCategory);  // Учитываем язык в ключе кэша
}

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>

    <div class="modal">

        <div class="modal__block modal__block--right modal__filter filter-block" data-category="<?php echo $curentCategory->slug; ?>" data-paged="<?php echo $paged; ?>" data-sortcount="<?php echo $sortCount; ?>">
            <div class="modal__header">
                <div class="modal__title"><?php _e('Filters','ndp'); ?></div>
                <span class="modal__close"></span>
            </div>
            <div class="modal__body">
                <?php if (!empty($all_categories)): ?>
                    <div class="modal-section filter-block__section">
                        <div class="modal-section__title"><?php _e('Category','ndp'); ?></div>
                        <div class="modal-section__content">
                            <ul>
                                <?php foreach ($all_categories as $category) { ?>
                                    <li><label><input type="checkbox" data-taxonomy="product_cat" name="category_slug" value="<?php echo $category->slug; ?>"><span><?php echo $category->name ?></span></label></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($attributes)): ?>
                    <div class="modal-section filter-block__section">
                        <div class="modal-section__title"><?php _e('Attributes','ndp'); ?></div>
                        <div class="modal-section__content">
                            <?php foreach ($attributes as $taxonomy => $attributeArray): ?>
                                <?php echo '<h5>'.$attributeArray['attributeName'].'</h5>'; ?>
                                <ul>
                                    <?php foreach ($attributeArray['values'] as $attribute): ?>
                                        <li><label><input type="checkbox" data-taxonomy="<?php echo $taxonomy; ?>" name="attribute" value="<?php echo $attribute['slug']; ?>"><span><?php echo $attribute['name'] ?></span></label></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (!empty($vendors)): ?>
                    <div class="modal-section filter-block__section">
                        <div class="modal-section__title"><?php _e('Vendors','ndp'); ?></div>
                        <div class="modal-section__content">
                            <ul>
                                <?php foreach ($vendors as $key => $vendor): ?>
                                    <li><label><input type="checkbox" data-taxonomy="sp_smart_brand" name="vendor_slug" value="<?php echo $vendor['brand_slug'] ?>"><span><?php echo $vendor['brand_name'] ?></span></label></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal__footer">
                <div class="container">
                    <div class="row">
                        <div class="col col-sm-6">
                            <a href="" class="btn btn_bg_primary-default js-filter-reset"><?php _e('Reset','ndp'); ?></a>
                        </div>
                        <div class="col col-sm-6">
                            <a href="" class="btn btn_bg_primary js-btn-filter"><?php _e('Show','ndp'); ?> <span class="js-filter-count"></span></a>
                            <a href="" class="btn btn_bg_primary js-btn-filter"><?php _e('Show','ndp'); ?> <span class="js-filter-count"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<?php require get_template_directory()."/template-parts/content-cart.php"?>
<?php
get_footer( 'shop' );
