<?php
/*
Template Name: Categories
*/

get_header();
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/buttons.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/cart.css">

<nav class="breadcrumb">
    <div class="container">
        <div class="breadcrumb-block">
             <div class='fn_breadcrumbs'>
                <?php yoast_breadcrumb(); ?>
            </div>
        </div>
    </div>
</nav>

 <section class="categories-info">
  <div class="container">
    <h1 class="categories-info__title"><?php the_title(); ?></h1>

  </div>
 </section>

 <section class="category">
  <div class="container">
    <div class="category-block">

    <?php
    global $sitepress;

    if( isset($sitepress) ){
        $current_language = $sitepress->get_current_language();
    } else {
        $current_language = 'uk'; // или установите значение по умолчанию, например 'en'
    }
    $args = array(
        'taxonomy'     => 'product_cat',
        'orderby'      => 'name',
        'child_of'     => 0,
        'hide_empty'   => true,
        'hierarchical' => false,
        'show_count'   => false,
        'parent'       => 0,  // Добавлено для выбора только категорий первого уровня
        'lang'         => $current_language,
    );
    $all_categories = get_categories( $args );

    foreach ($all_categories as $category) {
        $catID = apply_filters( 'wpml_object_id', $category->term_id, 'product_cat', false, $current_language );
        if ($catID):
        $link = get_term_link( $category->term_taxonomy_id, 'product_cat' );
        $thumbnail_id = get_term_meta( $category->term_id, 'thumbnail_id', true );
        $image_url = wp_get_attachment_url( $thumbnail_id );
        ?>
        <div class="category-block__item">
            <div class="category-block__image">
                <a href="<?php echo $link; ?>"><img src="<?php echo $image_url; ?>" alt="category-photo"></a>
            </div>
            <h3 class="category-block__title"><?php echo $category->name ?></h3>
            <a href="<?php echo $link; ?>" class="category-block__link"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/categories/arrow-link.svg" alt="arrow"></a>
        </div>
        <?php endif; ?>
    <?php } ?>
    </div>
  </div>
 </section>
<?php
global $wpdb;
//просмотры вендоров
$views = getNumbersOfViewsByType('sp_smart_brand');
$idsVendors = array_column($views, 'type_id');


//gets all vendors
$orderBy = !empty($idsVendors)? 'ORDER BY FIELD(tt.term_id, '.implode(',', $idsVendors).') DESC' : '';
$orderBy = '';

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
                <?php
                $linkLang = '/vendors-list/';
                if (!empty($current_language) && $current_language != 'uk') {
                    $linkLang = '/'.$current_language.'/vendors-list/';
                }
                ?>
                <a href="<?php echo $linkLang; ?>"><?php _e('All vendors','ndp'); ?></a>
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

 <section class="interpretation">
  <div class="container">
  <div class="interpretation-block d-flex justify-content-between flex-column flex-md-row">
    <div class="interpretation-block__text col-12 col-md-6">
      <div class="interpretation-block__title d-flex align-items-center">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM9 15V13H11V15H9ZM9 5V11H11V5H9Z" fill="#2A59BD"></path>
            </svg>
            <h2 class="ms-2"><?php _e('How it works','ndp'); ?></h2>
          </div>
          <?php
          $description = get_field('categories_description');
          echo $description;
          ?>
        </div>
    <div class="interpretation-block__image col-12 col-md-6">
     <img src="<?php echo get_template_directory_uri(); ?>/assets/img/categories/interpretation.jpg" alt="howitworks-photo">
    </div>
    </div>
      </div>
  </div>
 </section>

<?php require "template-parts/content-cart.php"?>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/cart.js"></script>
<?php

get_footer();
