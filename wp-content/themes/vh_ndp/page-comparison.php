<?php
/*
Template Name: Comparison
*/

get_header();

//Данные всех сравниваемых товаров
$comparisons = [];
//Список уникальных атрибутов товаров
$comparisonsUniqueGroups = [];

$productAttributesByProductId = [];
$current_lang = apply_filters( 'wpml_current_language', 'uk');

if (!empty($_SESSION['comparisonArray']) && !empty($_SESSION['comparisonArray'][$current_lang])) {
    $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'post__in' => $_SESSION['comparisonArray'][$current_lang],
    ];
    $query = new WP_Query($args);

    foreach ($query->posts as $product) {
        $postID = $product->ID;
        $categories =  get_the_terms($postID, 'product_cat');
        $categoryName = '';
        $categorySlug = '';
        if ($categories && ! is_wp_error($categories)) {
            $categoryName = $categories[0]->name;
            $categorySlug = $categories[0]->slug;
        }

        $thumbnail_id = get_post_thumbnail_id($postID);
        $image_url = '';
        if (!$thumbnail_id) {
            $image_url = get_template_directory_uri() . '/assets/img/img/noimage.png';
        } else {
            $image_url = wp_get_attachment_image_src($thumbnail_id)[0];
        }

        $link = get_permalink($postID);

//        $attributes = getAcfProductAttributes($postID);
        $productAttributesByProductId[$postID] = getMainProductAttributes($postID);

        $comparisons[$postID]['title'] = $product->post_title;
        $comparisons[$postID]['image_url'] = $image_url;
        $comparisons[$postID]['link'] = $link;
        $comparisons[$postID]['categoryName'] = $categoryName;
        $comparisons[$postID]['categorySlug'] = $categorySlug;
//        $comparisons[$postID]['attributeGroups'] = $attributes;
    }

    //группы атрибутов acf
//    $uniqueGroups = [];
//    foreach ($comparisons as $postID => $comparison) {
//        $groups = $comparison['attributeGroups'];
//        foreach ($groups as $group) {
//            if (!in_array($group['label'], $uniqueGroups)) {
//                $uniqueGroups[] = $group['label'];
//            }
//        }
//    }

//    foreach ($uniqueGroups as $k => $uniqueGroup) {
//        $comparisonsUniqueGroups[$k]['group'] = $uniqueGroup;
//        $rowAttributes = [];
//        $ids = [];
//        foreach ($comparisons as $postID => $comparison) {
//            $ids[] = $postID;
//            $productValue = '';
//            $comparisonsUniqueGroups[$k]['ids'][] = $postID;
//            foreach ($comparison['attributeGroups'] as $group) {
//                if ($uniqueGroup === $group['label']) {
//                    $attributeName = '';
//                    foreach ($group['attributes'] as $key => $attribute) {
//                        $attributeName = $attribute['label'];
//                        $productValue = $attribute['value'];
//                        $rowAttributes[$key]['name'] = $attributeName;
//                        $rowAttributes[$key]['productValues'][$postID] = $productValue;
//                    }
//                }
//            }
//        }
//
//        foreach ($rowAttributes as $key => $values) {
//            if ($difference = array_diff($comparisonsUniqueGroups[$k]['ids'], array_keys($values['productValues']))) {
//                foreach ($difference as $diff) {
//                    $rowAttributes[$key]['productValues'][$diff] = '';
//                }
//            }
//        }
//        $comparisonsUniqueGroups[$k]['attributes'] = $rowAttributes;
//    }

    //добавление встроенных в вукомерс атрибутов
    $uniqueGroups = [];
    foreach ($productAttributesByProductId as $postID => $productAttributes) {
        $groups = $productAttributes;
        foreach ($groups as $groupName => $group) {
            if (!in_array($groupName, $uniqueGroups)) {
                $uniqueGroups[] = $groupName;
            }
        }
    }
    $k = count($comparisonsUniqueGroups);
    foreach ($uniqueGroups as $i => $uniqueGroup) {
        $comparisonsUniqueGroups[$k]['group'] = $uniqueGroup;
        $rowAttributes = [];
        $ids = [];
        foreach ($comparisons as $postID => $comparison) {
            $ids[] = $postID;
            $productValue = '';
            $comparisonsUniqueGroups[$k]['ids'][] = $postID;
            foreach ($productAttributesByProductId[$postID] as $groupName => $group) {
                if ($uniqueGroup === $groupName) {
                    $attributeName = '';
                    foreach ($group as $key => $attribute) {
                        $attributeName = $attribute[0];
                        $productValue = $attribute[1];
                        $rowAttributes[$key]['name'] = $attributeName;
                        $rowAttributes[$key]['productValues'][$postID] = $productValue;
                    }
                }
            }
        }

        foreach ($rowAttributes as $key => $values) {
            if ($difference = array_diff($comparisonsUniqueGroups[$k]['ids'], array_keys($values['productValues']))) {
                foreach ($difference as $diff) {
                    $rowAttributes[$key]['productValues'][$diff] = '';
                }
            }
        }
        $comparisonsUniqueGroups[$k]['attributes'] = $rowAttributes;
        $k++;
    }
}

$count = 0;
if (isset($_SESSION['comparisonArray']) && !empty($_SESSION['comparisonArray'][$current_lang])) {
    $count = count($_SESSION['comparisonArray'][$current_lang]);
}
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

<section class="comparison">
    <div class="container">
        <div class="comparison__header">
            <h1 class="comparison__title"><?php _e('Comparison','ndp'); ?></h1>
            <span class="comparison__item__amount">(<span><?php echo $count; ?></span> <?php _e('items','ndp'); ?>)</span>
        <?php if($count && $count > 0) { ?>
            <div class="comparison__navigation">
                <button class="comparison__navigation__button comparison__navigation__left comparison__navigation__button__disabled"></button>
                <button class="comparison__navigation__button comparison__navigation__right"></button>
            </div>
        <?php } ?>
        </div>

        <?php if($comparisons) { ?>
        <div class="table-overlay">
            <table class="comparison-table">
                <col style="width: 180px">
                <tbody>
                <tr class="comparison-table__main">
                    <td class="comparison__switch">
                        <label class="comparison__switch__item">
                            <input type="checkbox" class="comparison__switch__input">
                            <span class="comparison__switch__slider"></span>
                        </label>
                        <h2 class="comparison__switch__title"><?php _e('Show only same properties','ndp'); ?></h2>
                    </td>
                    <?php foreach ($comparisons as $postId => $comparison): ?>
                    <td class="comparison__solution" data-id="<?php echo $postId; ?>">
                        <div class="comparison__solution-block">
                            <div class="comparison__solution__image"><a href="<?php echo $comparison['link']; ?>"><img src="<?php echo $comparison['image_url']; ?>" alt="solution-photo"></a></div>
                            <div class="comparison__solution__buttons"><button class="comparison__solution__buttons__delete"></button><button class="comparison__solution__buttons__added"></button></div>
                        </div>
                        <h2 class="comparison__solution__title"><a href="<?php echo $comparison['link']; ?>"><?php echo $comparison['title']; ?></a></h2>
                    </td>
                    <?php endforeach; ?>
                </tr>
                <tr class="comparison-table__category">
                    <td class="comparison-table__title"><?php _e('Category','ndp'); ?></td>
                    <?php foreach ($comparisons as $comparison): ?>
                    <td class="comparison-table__value"><?php echo $comparison['categoryName']; ?></td>
                    <?php endforeach; ?>
                </tr>
                <?php foreach ($comparisonsUniqueGroups as $k => $comparisonsGroup): ?>
                    <tr class="comparison-table__inverter-output comparison-table__chapter">
                        <td class="comparison-table__title">
                            <?php echo $comparisonsGroup['group'] ?>
                        </td>
                        <?php foreach ($comparisonsGroup['ids'] as $key => $id): ?>
                            <td class="td-bg">&nbsp;</td>
                        <?php endforeach; ?>
<!--                        <td class="bg1">&nbsp;</td>-->
                    </tr>
                    <?php foreach ($comparisonsGroup['attributes'] as $attributes): ?>
                    <tr class="comparison-table__rated-power">
                        <td class="comparison-table__title"><?php echo $attributes['name'] ?></td>
                        <?php foreach ($comparisonsGroup['ids'] as $key => $id): ?>
                            <td class="comparison-table__value"><?php echo $attributes['productValues'][$id] ?></td>
                        <?php endforeach; ?>
                    </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php } ?>
        <div class="application__empty-content" <?php if ($comparisons) echo 'style="display:none"'; ?>>
            <div class="application__empty-image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/comparison/empty-img.svg" alt="empty-img"></div>
            <span class="application__empty-text"><?php _e('No solutions added','ndp'); ?></span>
        </div>
    </div>
</section>

<?php require "template-parts/content-cart.php"?>
<?php

get_footer();
