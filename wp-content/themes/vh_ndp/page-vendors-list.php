<?php
/*
Template Name: Vendors list
*/

get_header();

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
    <style>
        .breadcrumb, [class$="_breadcrumbs"]{
            display: block !important;
        }
    </style>
 <nav class="breadcrumb">
  <div class="container">
    <div class="breadcrumb-block">
         <div class='fn_breadcrumbs'>
                <?php yoast_breadcrumb(); ?>
            </div>
    </div>
  </div>
 </nav>
 <section class="vendors">
    <div class="container">
        <h1 class="vendors__title"><?php _e('Vendors'); ?></h1>
    </div> 
    <div class="vendor-bg">
        <div class="container"> 
            <div class="vendors-block">
                <?php foreach ($vendors as $vendor): ?>
                <?php $logo = !empty($vendor['logo'])? $vendor['logo']['url'] : ''; ?>
                <div class="vendors-block__item">
                    <div class="vendors-block__header">
                    <h2 class="vendors-block__title"><a href="<?php echo $vendor['link'] ?>"><?php echo $vendor['brand_name'] ?></a></h2>
                        <?php if ($logo): ?>
                    <div class="vendors-block__image"><img src="<?php echo $logo; ?>" alt="benq-icon"></div>
                        <?php endif; ?>
                    </div>
                    <div class="vendors-block__category">
                        <?php
                        $countNameSimbols = 0;
                        $categoryList = [];
                        $categoryListHidden = [];
                        ?>
                        <?php foreach ($vendor['categories'] as $k => $category): ?>
                        <?php
                            $countCurrentCategory = mb_strlen($category['name']);
                            $classBreakWord = '';
                            if ($countCurrentCategory >= 20) {
                                $classBreakWord = 'break-word-split';
                                $countNameSimbols += 20;
                            } else {
                                $countNameSimbols += mb_strlen($category['name']);
                            }
                            if(count($categoryList) < 2 || $countNameSimbols < 65){
                                $categoryList[] = '<div class="vendors-block__category__item"><a href="'.$category['link'].'" class="'.$classBreakWord.'"><span>'.$category['name'].'</span></a></div>';

                            } else {
                                $categoryListHidden[] = '<a href="'. $category['link'] .'" class="tag-inner '. $classBreakWord .'">'. $category['name'] .'</a>';
                            }

            //                 $countCurrentCategory = mb_strlen($category['name']);
                            
            //                 $classBreakWord = '';
            //                 if ($countCurrentCategory >= 35) {
            //                     $classBreakWord = 'break-word-split';
            //                     $countNameSimbols += 35;
            //                 } else {
            //                     $countNameSimbols += mb_strlen($category['name']);
            //                 }
            //                 if ($countNameSimbols < 40) {
            //                     $categoryList[] = '<div class="vendors-block__category__item"><a href="'.$category['link'].'" class="'.$classBreakWord.'"><span>'.$category['name'].'</span></a></div>';
            //                 } else {
            //                     $categoryListHidden[] = '<a href="'. $category['link'] .'" class="tag-inner '. $classBreakWord .'">'. $category['name'] .'</a>';
            // //                    $categoryListHidden[] = '<li><a href="' . $category['link'] . '" class="btn__accessory btn_bg_no-selected" data-term-slug="' . $category['link'] . '">' . $category['name'] . '</a></li>';
            //                 }
                        ?>
                        <?php endforeach; ?>

                        <?php 
                            if(!count($categoryList) && isset($vendor['categories']) && count($vendor['categories'])){
                                $category = $vendor['categories'][0];
                                $countCurrentCategory = mb_strlen($category['name']);
                                $classBreakWord = '';
                                if ($countCurrentCategory >= 35) {
                                    $classBreakWord = 'break-word-split';
                                }
                                $categoryList[] = '<div class="vendors-block__category__item"><a href="'.$category['link'].'" class="'.$classBreakWord.'"><span>'.$category['name'].'</span></a></div>';
                                array_shift($categoryListHidden);
                            }


                        ?>
                        <?php
                            echo implode($categoryList);
                            if (!empty($categoryListHidden)) {
                                echo '<div class="block-post-item-label-more vendors-block__category__item more-hover"><span>+'.count($categoryListHidden).'</span>';
                                echo '<div class="wrapper-hover-block tooltip-bottom"><div class="wrapper-hover-block__container" style="width: 258px;">' . implode($categoryListHidden) . '</div></div></div>';
            //                    echo '<div class="block-post-item-label-more vendors-block__category__item tooltip"><span class="block-post-item-label">+'.count($categoryListHidden).'</span>
            //    <ul class="tooltiptext">' . implode($categoryListHidden) . '</ul></div>';
                            }
                        ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
  </div>
 </section>
<?php require "template-parts/content-cart.php"?>
<?php

get_footer();
