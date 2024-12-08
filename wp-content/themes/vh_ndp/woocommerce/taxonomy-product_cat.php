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

get_header();

$curentCategory = get_queried_object();
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
<?php
$description = get_field('single_category_description', $curentCategory);
?>
    <section class="categories-info">
        <div class="container">
            <h1 class="categories-info__title"><?php echo $curentCategory->name; ?></h1>
<?php if ($description): ?>
            <div class="categories-info__block">
                <?php echo $description; ?>
            </div>
<?php endif; ?>
        </div>
    </section>

<?php
$showCount = SHOWCOUNT;
if (!empty($_SESSION['showCount']) && $_SESSION['showCount'] > 0) {
    $showCount = (int)$_SESSION['showCount'];
}
$sortCount = $showCount;
?>
<main class="main">
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
    <div class="top-block section">
        <div class="container">
            <div class="row top-categories justify-content-center justify-content-sm-start">
                <?php

                $args = array(
                    'taxonomy'     => 'product_cat',
                    'orderby'      => 'name',
                    'hide_empty'   => false,
                    'parent' => $curentCategory->term_id,
                    'show_count'   => false,
                );

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
        <?php
        //attributes for filter
        $category_slug = $curentCategory->slug ?? '';

        $attributesByCategory = wp_cache_get('attributesByCategory');
        $attributes = [];

        if ($category_slug && !empty($attributesByCategory[$category_slug])) {
            $attributes = $attributesByCategory[$category_slug];
        }
        if (false === $attributesByCategory || empty($attributes)){
            $attributesByCategory = [];
            $query_args = array(
                'status'    => 'publish',
                'limit'     => 1,
                'category'  => array( $category_slug ),
            );

            foreach( wc_get_products($query_args) as $product ){
                foreach( $product->get_attributes() as $taxonomy => $attribute ){
                    $attribute_name = wc_attribute_label( $taxonomy ); // Attribute name
                    $terms = $attribute->get_terms();
                    foreach ((object)$terms as $term){
                        if (!isset($attributes[$taxonomy])){
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
            wp_cache_set('attributesByCategory', $attributesByCategory);
        }
        ?>
        <div class="container">
            <div class="checkboxes">
                <div class="checkboxes__subcategories checkboxes__wrap" data-taxonomy="product_cat">
                    <div class="checkboxes__title"><?php _e('Sub-Category') ?>:</div>
                    <div class="checkboxes__tags"></div>
                </div>
                <?php
                $dataAttributes = 'data-taxonomy="';
                foreach (array_keys($attributes) as $attribute) {
                    $dataAttributes .= $attribute.';';
                }
                $dataAttributes .= '"';
                ?>
                <div class="checkboxes__attributes checkboxes__wrap" <?php echo $dataAttributes; ?>>
                    <div class="checkboxes__title"><?php _e('Attributes') ?>:</div>
                    <div class="checkboxes__tags"></div>
                </div>
                <div class="checkboxes__vendors checkboxes__wrap" data-taxonomy="sp_smart_brand">
                    <div class="checkboxes__title"><?php _e('Vendors') ?>:</div>
                    <div class="checkboxes__tags"></div>
                </div>
                <div class="checkboxes__wrap clear-filter">
                    <button class="js-clear-filter btn btn-primary"><?php _e('Clear all filters') ?></button>
                </div>
            </div>
        </div>
    </div>

    <div class="main__content container"
         data-comparison-text="<?php _e('Item added to comparison', 'ndp'); ?>"
         data-alreadyadded-text="<?php _e('Item already added', 'ndp'); ?>"
         data-outofstock-text="<?php _e('The product is out of stock', 'ndp'); ?>">
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
<?php
global $wpdb;
//просмотры вендоров
//$views = getNumbersOfViewsByType('sp_smart_brand');
//$idsVendors = array_column($views, 'type_id');


$vendors = wp_cache_get('allVendors');
if (false === $vendors){
    global $wpdb;

    $sql = "
    SELECT 
        t.term_id, 
        t.name as brand_name, 
        t.slug as brand_slug, 
        tt.taxonomy, 
        tm.meta_key, 
        tm.meta_value,
        i.element_id,
        i.language_code
    FROM 
        `{$wpdb->term_taxonomy}` tt 
    INNER JOIN 
        `{$wpdb->terms}` t 
    ON 
        tt.term_id = t.term_id 
    INNER JOIN 
        `{$wpdb->termmeta}` tm 
    ON 
        tm.term_id = t.term_id 
    LEFT JOIN 
        `{$wpdb->prefix}icl_translations` i 
    ON 
        t.term_id = i.element_id 
    AND 
        i.element_type = CONCAT('tax_', tt.taxonomy)
    WHERE 
        tt.taxonomy = 'sp_smart_brand' 
    AND 
        tm.meta_key = 'sp_smart_brand_taxonomy_meta'
    AND 
        i.language_code = '{$sitepress->get_current_language()}';
";


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


foreach ($vendors as $key => $vendor) {
    $img = unserialize($vendor['meta_value']);
    $meta = unserialize($vendor['meta_value']);
    if (!empty($meta['smart_brand_term_logo']) && !empty($meta['smart_brand_term_logo']['url'])) {
        $vendors[$key]['logo'] = preg_replace('/^https?:\/\/[^\/]+/','', $meta['smart_brand_term_logo']);
    }
}

foreach ($vendors as $key => $vendor) {
    $vendors[$key]['link'] = get_term_link((int)$vendor['term_id'], 'sp_smart_brand');
    $vendors[$key]['categories'] = [];

    $categories = get_woocommerce_categories_by_vendors((int)$vendor['term_id']);
    foreach ($categories as $category) {
        $category = (array)$category;
        if ($category && array_search($category['name'], array_column($vendors[$key]['categories'], 'name')) === false) {
            $categoryArray = [
                'name' => $category['name'],
                'link' => get_term_link((int)$category['term_id'], 'product_cat'),
            ];
            $vendors[$key]['categories'][] = $categoryArray;
        }
    }
}
?>
<?php if ($vendors): ?>
<section class="vendors">
    <div class="container">
        <div class="vendors__header">
            <h2 class="vendors__title"><?php _e('Vendors','ndp'); ?></h2>
            <div class="vendors__link">
                <a href="/vendors-list/"><?php _e('See all solutions','ndp'); ?></a>
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/categories/arrow-link.svg" alt="arrow">
            </div>
        </div>
        <div class="vendors__slider">
            <div class="vendors__slider-block owl-carousel" id="carousel">
                <?php $key = 0; ?>
                <?php foreach ($vendors as $vendor): ?>
                    <?php if (empty($vendor['categories'])) continue; ?>
                    <?php $logo = !empty($vendor['logo'])? $vendor['logo']['url'] : ''; ?>
                    <div class="vendors__slider__item" data-slide-index="<?php echo $key; ?>">
                        <div class="vendors__slider__item__header">
                            <h3 class="vendors__slider__item__title"><a href="<?php echo $vendor['link'] ?>"><?php echo $vendor['brand_name'] ?></a></h3>
                            <?php if ($logo): ?>
                                <div class="vendors__slider__item__image"><img src="<?php echo $logo; ?>" alt="<?php echo $vendor['brand_name'] ?>"></div>
                            <?php endif; ?>
                        </div>
                        <div class="vendors__slider__item__category">
                            <?php if (!empty($vendor['categories'])): ?>
                                <?php
                                $countNameSimbols = 0;
                                $hover = '<div class="wrapper-hover-block tooltip-bottom"><div class="wrapper-hover-block__container">';
                                $more = '';
                                $countCurrentCategory = 0;
                                ?>
                                <?php foreach ($vendor['categories'] as $k => $category): ?>
                                    <?php
                                    $countCurrentCategory = mb_strlen($category['name']);
                                    $countNameSimbols += mb_strlen($category['name']);
                                    $classBreakWord = '';
                                    if ($countCurrentCategory > 15 && $countNameSimbols > 30) {
                                        $classBreakWord = 'break-word-split';
                                    }
                                    ?>
                                    <?php if ($countNameSimbols < 90): ?>
                                        <div class="vendors__slider__item__text">
                                            <a href="<?php echo $category['link']; ?>" title="<?php echo $category['name']; ?>" class="<?php echo $classBreakWord; ?>"><span><?php echo $category['name']; ?></a>
                                        </div>
                                    <?php else: ?>
                                        <?php
                                        $hover .= '<a href="'. $category['link'] .'" class="tag-inner block-post-item-label '. $classBreakWord .'" title="'. $category['name'] .'">'. $category['name'] .'</a>';
                                        $count = count($vendor['categories']) - $k;
                                        if (empty($more) && $count > 0) {
                                            $more .= '<div class="vendors__slider__item__text more-hover"><span>+'.$count;
                                        } ?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                                <?php
                                $hover .= '</div></div>';
                                if (!empty($more)) {
                                    $more .= '</span>' . $hover . '</div>';
                                }
                                echo $more;
                                ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php $key++; ?>
                <?php endforeach; ?>
            </div>
            <div class="vendors__slider__navigation">
                <div class="vendors__slider__navigation__dots">
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>

<div class='ticker-block'>
  <div class='ticker-bg hide-mobile'>
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

//vendors for filter
$vendorsByCategory = wp_cache_get('vendorsByCategory');
$vendors = [];

if ($category_slug && !empty($vendorsByCategory[$category_slug])) {
    $vendors = $vendorsByCategory[$category_slug];
}

if (false === $vendorsByCategory || empty($vendors)){
    $vendorsByCategory = [];
    $terms = get_woocommerce_additional_data($category_slug, 'sp_smart_brand');
    foreach ($all_categories as $category) {
        $termsSubCategories = get_woocommerce_additional_data($category->slug, 'sp_smart_brand');
        foreach ($termsSubCategories as $term) {
            $terms[] = $term;
        }
    }

    if (!empty($terms)) {
        foreach ($terms as $term){
            $vendor = [];
            $vendor['taxonomy'] = $term->taxonomy;
            $vendor['brand_name'] = $term->name;
            $vendor['brand_slug'] = $term->slug;
            if (array_search($term->slug, array_column($vendors, 'brand_slug')) === false) {
                $vendors[] = $vendor;
            }
        }
        $vendorsByCategory[$category_slug] = $vendors;
    }
    wp_cache_set('vendorsByCategory', $vendorsByCategory);
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
                                <?php
                                $checked = '';
                                if (!empty($_GET['product_cat']) && array_search($category->slug, $_GET['product_cat']) !== false) {
                                    $checked = 'checked';
                                }
                                ?>
                                <li><label><input type="checkbox" data-taxonomy="product_cat" name="category_slug" value="<?php echo $category->slug; ?>" <?php echo $checked; ?>><span><?php echo $category->name ?></span></label></li>
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
                                    <?php
                                    $checked = '';
                                    if (!empty($_GET[$taxonomy]) && array_search($attribute['slug'], $_GET[$taxonomy]) !== false) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                    <li><label><input type="checkbox" data-taxonomy="<?php echo $taxonomy; ?>" name="attribute" value="<?php echo $attribute['slug']; ?>" <?php echo $checked; ?>><span><?php echo $attribute['name'] ?></span></label></li>
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
                                    <?php
                                    $checked = '';
                                    if (!empty($_GET['sp_smart_brand']) && array_search($vendor['brand_slug'], $_GET['sp_smart_brand']) !== false) {
                                        $checked = 'checked';
                                    }
                                    ?>
                                    <li><label><input type="checkbox" data-taxonomy="sp_smart_brand" name="vendor_slug" value="<?php echo $vendor['brand_slug']; ?>" <?php echo $checked; ?>><span><?php echo $vendor['brand_name'] ?></span></label></li>
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
                        <div class="col col-sm-6 position-relative">
                            <a href="" class="btn btn_bg_primary js-btn-filter"><?php _e('Show','ndp'); ?> <span class="js-filter-count"></span></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        var comparisonText = "<?php _e('Item added to comparison', 'ndp'); ?>";
        var alreadyaddedText="<?php _e('Item already added', 'ndp'); ?>";
    </script>

<?php require get_template_directory()."/template-parts/content-cart.php"?>
<?php
get_footer( 'shop' );
