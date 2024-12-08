<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NDP
 */

get_header();

if (!empty($_GET)) {
    foreach ($_GET as $key => $value) {
        $_GET[$key] = (array)$value;
    }
}
$post_type = get_post_type();
if (!$post_type) {
    $queriedObject = get_queried_object();
    if ($queriedObject) {
        if (is_a($queriedObject, 'WP_Term') && !empty($queriedObject->taxonomy)) {
            $taxObject = get_taxonomy($queriedObject->taxonomy);
            $postTypeArray = $taxObject->object_type;
            if (!empty($postTypeArray) && is_array($postTypeArray)) {
                $post_type = $postTypeArray[0];
            }
        }
        if (is_a($queriedObject, 'WP_Post_Type') && !empty($queriedObject->name)) {
            $post_type = $queriedObject->name;
        }
    }
}
?>

<main id="primary" class="site-main news-main">
    <div class="breadcrumb breadcrumb-block">
        <div class="wrap">
            <div class='fn_breadcrumbs'>
                <?php yoast_breadcrumb(); ?>
            </div>
        </div>
    </div>
    <?php if ($post_type === 'post' || $post_type === 'news' || $post_type === 'knowledge-base' || $post_type === 'cases'): ?>

    <?php
    $tag_slug = ''; /* Tags */
    $category_slug = ''; /* Categories */
    $sticky_posts_count = 0; /* Sticky posts count */

    if ($post_type === 'news') {
        $tag_slug = 'news_tag';
        $category_slug = 'news_category';
        $sticky_posts_count = 4;
        $title= __('News','ndp');
    } elseif ($post_type === 'knowledge-base') {
        $tag_slug = 'knowledge-base_tag';
        $category_slug = 'knowledge-base_category';
        $sticky_posts_count = 3;
        $title= __('Knowledge Base','ndp');
    } elseif ($post_type === 'cases') {
        $tag_slug = 'cases_tag';
        $category_slug = 'cases_category';
        $sticky_posts_count = 3;
        $title= __('Cases','ndp');
    }else{
        $title =__('Cases','ndp');;
    }

    $news_tags = get_terms(array(
        'taxonomy' => $tag_slug,
        'hide_empty' => true,
    ));

    // Получаем список категорий
    $categories = get_terms([
        'taxonomy' => $category_slug,
        'hide_empty' => true,
    ]);
    /* --- */

    $current_lang = apply_filters( 'wpml_current_language', 'uk');
    ?>
    <div class="title-filter">
        <div class="wrap">
            <div class="title-filter-bl">
                <h1 class="title-page s">
                    <?php echo $title;?>
                </h1>

                <div class="filter">
                    <?php
                    if (isset($news_tags) && !empty($news_tags)) {
                        ?>
                        <div class="input-container tag-search-container c-select c-multiselect">
                            <label class="sort-label"><?php _e('All tags','ndp'); ?></label>
                            <input value="" type="hidden" name="text-services" class="styled-select">
                            <div class="select__btn" data-post-custom-tag="<?php echo $tag_slug; ?>">
                                <?php
                                $tags = _e('Select tags');
                                echo $tags; ?>
                            </div>
                            <div class="select__list" style="display: none;">

                                <?php
                                // Перебираем теги
                                foreach ($news_tags as $tag) {
                                    $tagID = apply_filters( 'wpml_object_id', $tag->term_id, $tag_slug, false, $current_lang );
                                    if ($tagID) {
                                        echo '<div class="select__item" data-sort-by="' . esc_html($tag->slug) . '">' . esc_html($tag->name) . '</div>';
                                    }
                                }
                                ?>
                                <!--                                            <span class="remove-all-tags bt-close"></span>-->
                            </div>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="input-container sort-input-container c-select">
                        <label class="sort-label">    <?php _e('Sort by','ndp'); ?></label>
                        <input value="" type="hidden" name="text-services"
                               class="input-container__input styled-select">
                        <div class="select__btn" data-post-type="<?php echo $post_type; ?>">
                            <?php _e('Data (descending)','ndp'); ?>
                        </div>
                        <div class="select__list" style="display: none;">
                            <div class="select__item" data-sort-by="date-desc">
                                <?php _e('Data (descending)','ndp'); ?>
                            </div>
                            <div class="select__item" data-sort-by="date-asc">
                                <?php _e('Data (ascending)','ndp'); ?>
                            </div>
                            <div class="select__item" data-sort-by="views">
                                <?php _e('Popular','ndp'); ?>
                            </div>
                            <!--
                            <div class="select__item">
                                Relevant
                            </div>
                            -->
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php
    function checkIfIsCategory():bool {
        if (!empty($_GET)) {
            foreach ($_GET as $key => $get) {
                if (preg_match('/category/',$key) !== false) {
                    return true;
                }
            }
        }
        return false;
    }
    ?>

    <div class="articles-filter">
        <div class="wrap">
            <?php if (isset($categories) && !empty($categories)) { ?>
                <div class="selected-categories" data-taxonomy="<?php echo $category_slug; ?>">
                    <ul class="selected-categories-list">
                        <li class="selected-categories__item">
                            <?php
                            $httpGetFilterParams = http_build_query($_GET);
                            $link = home_url() . '/' . $post_type;
                            if (!empty($httpGetFilterParams)) {
                                $link = $link . '?' . $httpGetFilterParams;
                            }

                            $class = 'btn_bg_primary';
                            if ((get_queried_object_id() !== NULL && !empty(get_queried_object_id())) || checkIfIsCategory()) {
                                $class = 'btn_bg_primary-default';
                            }
                            ?>
                            <a href="<?php echo $link; ?>"
                               class="selected-categories__link btn <?php echo $class; ?>"><?php _e('All categories','ndp'); ?></a>
                        </li>
                        <?php
                        // Получаем ID текущей категории
                        $current_category_id = get_queried_object_id();

                        // Перебираем категории
                        foreach ($categories as $category) {

                            // Проверяем, есть ли посты в данной категории
                            if ($category->count > 0) {
                                $class = 'btn_bg_primary-default';
                            } else {
                                $class = 'btn_bg_primary-default empty-cat';
                            }

                            // Добавляем класс, если категория активная
                            $class = ($current_category_id == $category->term_id) ? 'btn_bg_primary' : $class;
                            if (!empty($_GET)) {
                                foreach ($_GET as $key => $get) {
                                    if (preg_match('/category/',$key) !== false && is_array($_GET[$key]) && in_array($category->slug, $_GET[$key])) {
                                        $class = 'btn_bg_primary';
                                    }
                                }
                            }

                            $catID = apply_filters( 'wpml_object_id', $category->term_id, $category_slug, false, $current_lang );
                            if ($catID):
                            $link = get_category_link($category->term_id);
                            if (!empty($httpGetFilterParams)) {
                                $link = $link . '?' . $httpGetFilterParams;
                            }
                            ?>
                            <li class="selected-categories__item selected-categories__item-none">
                                <a href="<?php echo $link; ?>"
                                   class="selected-categories__link btn <?php echo $class; ?>"
                                   data-term-slug="<?php echo $category->slug; ?>"
                                   data-term-id="<?php echo $category->term_id; ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            </li>
                            <?php
                            endif;
                            // Сбрасываем данные запроса
                            wp_reset_postdata();
                        } ?>
                        <div class="selected-categories__burger-menu">
                            <img src="<?php echo get_template_directory_uri() ?>/assets/img/icon/Icon-selected-categories__burger-menu.svg" alt="">
                            <span class="bt-close"></span>
                        </div>
                    </ul>
                </div>
            <?php } ?>
        </div>
    </div>

    <?php include(get_template_directory() . '/templates/archive-custom-post.php'); ?>

    <div class="for-newsletter">
        <div class="container">
            <div class='row'>
                <div class='col-md-12'>
                    <?php get_template_part('templates/join', 'community'); ?>
                </div>
            </div>
        </div>
    </div>

    <?php elseif (have_posts()) : ?>
            <header class="page-header">
                <?php
                the_archive_title('<h1 class="page-title">', '</h1>');
                the_archive_description('<div class="archive-description">', '</div>');
                ?>
            </header><!-- .page-header -->
            <?php

            /* Start the Loop */

            while (have_posts()) :
                the_post();

                /*
                 * Include the Post-Type-specific template for the content.
                 * If you want to override this in a child theme, then include a file
                 * called content-___.php (where ___ is the Post Type name) and that will be used instead.
                 */
                get_template_part('template-parts/content', get_post_type());

            endwhile;

            the_posts_navigation();
        ?>
    <?php
    else :

        get_template_part('template-parts/content', 'none', ['post_type' => $post_type]);

    endif;
    ?>

</main><!-- #main -->

<?php
//get_sidebar();
get_footer();
