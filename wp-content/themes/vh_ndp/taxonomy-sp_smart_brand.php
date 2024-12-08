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

$vendorObject = get_queried_object();
$current_lang = apply_filters( 'wpml_current_language', 'uk');
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


<div class="brand-container">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="brand-container-left">
                    <div class="brand-container-left-image">
                        <?php
                            $termMeta = get_term_meta( $vendorObject->term_id , 'sp_smart_brand_taxonomy_meta', true );
                            $logo = '';
                            if ($termMeta) {
                                $logo = $termMeta['smart_brand_term_logo']['url'];
                            }
                        ?>
                        <img src="<?php echo $logo; ?>" alt="<?php echo $vendorObject->name; ?>">
                    </div>
                    <div class="brand-container-left-list">
                        <div class="brand-container-left-list-item">
                            <?php
                            $name = __('Name', 'ndp');
                            if ($current_lang == 'uk') {
                                $name = 'Назва';
                            }
                            ?>
                            <span><?php echo $name; ?>:</span>
                            <strong><?php echo $vendorObject->name; ?></strong>
                        </div>
                        <?php $country = get_field('vendor_country', $vendorObject); ?>
                        <?php $website = get_field('vendor_website', $vendorObject); ?>
                        <?php if ($country): ?>
                            <div class="brand-container-left-list-item">
                                <span><?php _e('Country','ndp'); ?>:</span>
                                <strong><?=$country?></strong>
                            </div>
                        <?php endif; ?>
                        <?php if ($website): ?>
                            <?php
                            function addScheme($url, $scheme = 'https://') {
                                return parse_url($url, PHP_URL_SCHEME) === null ?
                                    $scheme . $url : $url;
                            }
                            $websiteLink = addScheme($website);
                            ?>
                            <div class="brand-container-left-list-item">
                                <span><?php _e('Website','ndp'); ?>:</span>
                                <?php echo '<a href="'.$websiteLink.'" target="_blank"><strong>'.$website.'</strong></a>'; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php
                        $categoriesArray = get_woocommerce_categories_by_vendors($vendorObject->term_id);
                        $categories = [];
                        foreach ($categoriesArray as $category) {
                            $categories[$category['slug']] = $category;
                        }
                    ?>
                    <?php if (!empty($categories)): ?>
                        <div class="company__categories">
                            <h2 class="company__categories__title"><?php _e('Categories','ndp'); ?></h2>
                            <div class="company__categories-block">
                                <?php foreach ($categories as $category): ?>
                                <?php $link = get_term_link((int)$category['term_id'], 'product_cat'); ?>
                                <div class="company__categories__item"><a href="<?php echo $link; ?>"><span><?php echo $category['name']; ?></span></a></div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                
            </div>
            <div class="col-md-6">
                <div class="brand-container-right">
                    <?php $description = get_field('vendor_description', $vendorObject); ?>
                    <?php echo $description; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="category">
    <div class="container">
        <div class="category-block">
            <?php
            foreach ($categories as $category) {
                $category = (array)$category;
                $link = get_term_link( (int)$category['term_id'], 'product_cat' );
                $link = $link .= '?'.http_build_query(['sp_smart_brand' => [$vendorObject->slug]]);
                $thumbnail_id = get_term_meta( (int)$category['term_id'], 'thumbnail_id', true );
                $image_url = wp_get_attachment_url( $thumbnail_id );
                ?>
                <div class="category-block__item" data-taxonomy="product_cat" data-slug="<?php echo $category['slug']; ?>">
                    <div class="category-block__image">
                        <img src="<?php echo $image_url; ?>" alt="category-photo">
                    </div>
                    <h3 class="category-block__title"><?php echo $category['name'] ?></h3>
                    <a href="<?php echo $link; ?>" class="category-block__link">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/categories/arrow-link.svg" alt="arrow">
                    </a>
                </div>
            <?php } ?>
        </div>
    </div>
</section>

<?php
$showCount = SHOWCOUNT;
if (!empty($_SESSION['showCount']) && $_SESSION['showCount'] > 0) {
    $showCount = (int)$_SESSION['showCount'];
}
$sortCount = $showCount;
?>

<main class="main" style="display:none;">
    <div class="section container settings">
        <div class="row align-items-center">
            <div class="col settings__col categories-info settings__col--first">
                <h3 class="section__title settings__title"></h3>
            </div>

            <div class="col settings__col settings__col--right">
                <div class="options">
                    <span class="options__text">Show items:</span>
                    <div class="options__select">
                        <span class="options__current me-3"><?php echo $sortCount ?></span>
                        <i class="arrow-down"></i>
                        <div class="options__wrapper">
                            <form method="post">
                                <ul class="options__list">
                                    <li <?php if ($sortCount == 6): ?> class="options__list--checked" <?php endif; ?>>1</li>
                                    <li <?php if ($sortCount == 6): ?> class="options__list--checked" <?php endif; ?>>2</li>
                                    <li <?php if ($sortCount == 6): ?> class="options__list--checked" <?php endif; ?>>6</li>
                                    <li <?php if ($sortCount == 12): ?> class="options__list--checked" <?php endif; ?>>12</li>
                                    <li <?php if ($sortCount == 15): ?> class="options__list--checked" <?php endif; ?>>15</li>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="filter">
                    <button type="button" class="filter__button modal-btn" data-modal="filter"><?php _e('Filters &amp; sort', 'ndp'); ?></button>
                </div>
            </div>

            <div class="filter filter--mob">
                <button type="button" class="filter__button modal-btn" data-modal="filter"><?php _e('Filters &amp; sort', 'ndp'); ?></button>
            </div>
        </div>
        <div class="row">
            <div class="col settings__col categories-info settings__col--first">
                <div class="categories-info__block"></div>
            </div>
        </div>
    </div>
    <div class="top-block section">
        <div class="container">
            <div class="checkboxes">
                <div class="checkboxes__subcategories checkboxes__wrap" data-taxonomy="product_cat">
                    <div class="checkboxes__title">Sub-Category:</div>
                    <div class="checkboxes__tags"></div>
                </div>
                <div class="checkboxes__attributes checkboxes__wrap" data-taxonomy="pa_color">
                    <div class="checkboxes__title">Attributes:</div>
                    <div class="checkboxes__tags"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="main__content container">
        <div class="row">

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
<!--                <p class="interpretation-block__description">Shenzhen MUST ENERGY Power Co., Ltd established in 1998, with the headquarter in Hongkong, which is a professional hi-tech enterprise.</p>-->
                <p class="interpretation-block__description"><?php _e('This section contains information about manufacturers and solutions presented on the platform.', 'ndp'); ?></p>
<!--                <p class="interpretation-block__description">Our comprehensive product lines include: Power inverter, Solar inverter, Solar charge controller, Solar battery and some other related Solar products.</p>-->
                <p class="interpretation-block__description"><?php _e('Having selected several solutions, it is possible to compare them with each other or add them to the funding application.', 'ndp'); ?></p>
            </div>
            <div class="interpretation-block__image col-12 col-md-6">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/vendors-solutions/interpretation.jpg" alt="howitworks-photo">
            </div>
        </div>
    </div>
</section>

<div class="modal">

    <div class="modal__block modal__block--right modal__filter filter-block" data-category="" data-paged="1" data-sortcount="<?php echo $sortCount; ?>">
        <div class="modal__header">
            <div class="modal__title"><?php _e('Filters','ndp'); ?></div>
            <span class="modal__close"></span>
        </div>
        <div class="modal__body"> 
            <?php if (!empty($categories)): ?>
                <div class="modal-section filter-block__section">
                    <div class="modal-section__title"><?php _e('Category','ndp'); ?></div>
                    <div class="modal-section__content">
                        <ul>
                            <?php foreach ($categories as $category) { ?>
                                <?php
                                $checked = '';
                                if (!empty($_GET['product_cat']) && array_search($category['slug'], $_GET['product_cat']) !== false) {
                                    $checked = 'checked';
                                }
                                ?>
                                <li><label><input type="checkbox" data-taxonomy="product_cat" name="category_slug" value="<?php echo $category['slug']; ?>" <?php echo $checked; ?>><span><?php echo $category['name'] ?></span></label></li>
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
            <div class="modal-section filter-block__section">
                <div class="modal-section__title"><?php _e('Vendors','ndp'); ?></div>
                <div class="modal-section__content">
                    <ul>
                        <li><label><input type="checkbox" data-taxonomy="sp_smart_brand" name="vendor_slug" value="<?php echo $vendorObject->slug; ?>" checked disabled><span><?php echo $vendorObject->name; ?></span></label></li>
                    </ul>
                </div>
            </div>
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

<?php
$taxonomy_id = $vendorObject->term_taxonomy_id;
$taxonomy_type = $vendorObject->taxonomy;
?>
<?php if ($taxonomy_id): ?>
    <script>
        (function($) {
            $(function() {

                let data = {
                    action: 'updateNumberOfViews',
                    id: '<?php echo $taxonomy_id; ?>',
                    type: '<?php echo $taxonomy_type; ?>',
                }
                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: data,
                    success: function (response) {
                        console.log(response)
                    }
                })

            });//document ready
        })(jQuery);

    </script>
<?php endif; ?>
<?php require "template-parts/content-cart.php"?>
<?php
get_footer( 'shop' );
