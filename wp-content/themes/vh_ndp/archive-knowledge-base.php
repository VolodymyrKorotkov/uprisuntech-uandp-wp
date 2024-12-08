<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NDP
 */

get_header();
?>

    <main id="primary" class="site-main">
        <div class="breadcrumb breadcrumb-block">
            <div class="wrap">
                <div class='fn_breadcrumbs'>
                    <?php yoast_breadcrumb(); ?>
                </div>
            </div>
        </div>
        <?php if (have_posts()) : ?>
            <?php
            /* Tags */
            $tag_slug = '';
            $post_type = get_post_type();

            if ($post_type === 'news') {
                $tag_slug = 'news_tag';
                $title= __('News','ndp');
            } elseif ($post_type === 'knowledge-base') {
                $tag_slug = 'knowledge-base_tag';
                $title= __('Knowledge Base','ndp');
            } elseif ($post_type === 'cases') {
                $tag_slug = 'cases_tag';
                $title= __('Cases','ndp');
            }

            $news_tags = get_terms(array(
                'taxonomy' => $tag_slug,
                'hide_empty' => true,
            ));
            /* --- */


            /* Categories */
            $category_slug = '';

            if (get_post_type() === 'news') {
                $category_slug = 'news_category';
            } elseif (get_post_type() === 'knowledge-base') {
                $category_slug = 'knowledge-base_category';
            } elseif (get_post_type() === 'cases') {
                $category_slug = 'cases_category';
            }

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
                        <h1 class="title-page">
                            <?php echo $title; ?>
                        </h1>

                        <?php if (!empty($_GET)): ?>
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
                                            echo '<div class="select__item" data-sort-by="' . esc_html($tag->slug) . '">' . esc_html($tag->name) . '</div>';
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
                                <div class="select__btn" data-post-type="<?php echo get_post_type(); ?>">
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
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="articles-filter">
                <div class="wrap">
                    <?php if (isset($categories) && !empty($categories)) { ?>
                        <div class="selected-categories">
                            <ul class="selected-categories-list">
                                <li class="selected-categories__item">
                                    <?php
                                    $httpGetFilterParams = http_build_query($_GET);
                                    $link = home_url() . '/' . get_post_type();
                                    if (!empty($httpGetFilterParams)) {
                                        $link = $link . '?' . $httpGetFilterParams;
                                    }
                                    ?>
                                    <a href="<?php echo $link; ?>"
                                       class="selected-categories__link btn <?php echo (get_queried_object_id() !== NULL && !empty(get_queried_object_id())) ? 'btn_bg_primary-default' : 'btn_bg_primary'; ?>">
                                        <?php _e('All categories','ndp'); ?>    </a>
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

                                    $catID = apply_filters( 'wpml_object_id', $category->term_id, $category_slug, false, $current_lang );
                                    if ($catID):
                                    ?>
                                    <li class="selected-categories__item selected-categories__item-none">
                                        <a href="<?php echo get_category_link($category->term_id); ?>"
                                           class="selected-categories__link btn <?php echo $class; ?>"
                                           data-term-id="<?php echo $category->term_id; ?>">
                                            <?php echo esc_html($category->name); ?>
                                        </a>
                                    </li>
                                    <?php
                                    endif;
                                    // Сбрасываем данные запроса
                                    wp_reset_postdata();
                                }
                                ?>

                                <div class="selected-categories__burger-menu">
                                    <img src="<?php echo get_template_directory_uri() ?>/assets/img/icon/Icon-selected-categories__burger-menu.svg" alt="">
                                    <span class="bt-close"></span>
                                </div>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <?php

            // Получаем список всех категорий кастомного типа постов "knowledge-base"
            $knowledge_base_categories = get_terms(array(
                'taxonomy' => 'knowledge-base_category', // Замените на вашу таксономию
                'hide_empty' => false,
            ));

            //если выбраны теги, поиск по всем категориям
            if (!empty($_GET)) {
                foreach ($_GET as $key => $value) {
                    $_GET[$key] = (array)$value;
                }
                include(get_template_directory() . '/templates/archive-custom-post.php');

            } elseif (!empty($knowledge_base_categories)) {
                foreach ($knowledge_base_categories as $category) {
                    $category_id = $category->term_id;
                    $category_name = $category->name;
                    $category_link = get_term_link($category);
                    $catID = apply_filters( 'wpml_object_id', $category->term_id, $category_slug, false, $current_lang );
                    if ($catID): ?>
                    <div class="more-cards">
                        <div class="row wrap">
                            <div class="col-12 col-sm-12 col-lg-12 more-cards__top">
                                <h3 class="title-section"><?php echo esc_html($category_name); ?></h3>
                                <a href="<?php echo esc_url($category_link); ?>" class="btn-link btn-link-hover hide-mobile">
                                    <?php _e('See all articles','ndp'); ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                        <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#2A59BD"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>

                            <?php
                            // Создаем аргументы для запроса WP_Query для текущей категории
                            $args = array(
                                'post_type' => 'knowledge-base',
                                'posts_per_page' => 3,
                                'orderby' => 'date',
                                'order' => 'DESC',
                                'tax_query' => array(
                                    array(
                                        'taxonomy' => 'knowledge-base_category', // Замените на вашу таксономию
                                        'field' => 'id',
                                        'terms' => $category_id,
                                    ),
                                ),
                            );

                            // Создаем запрос WP_Query
                            $query = new WP_Query($args);

                            if ($query->have_posts()) {
                                ?>
                              <div class="container">
                                <div class="row list-three-card">
                                    <?php
                                    $counterPost = 0;
                                    $custom_sticky = get_post_meta(get_the_ID(), 'custom_sticky', true);
                                    $hide_col = false;
                                    while ($query->have_posts()) {
                                        $query->the_post();
                                        $counterPost++;
                                        $category_slug='knowledge-base_category';
                                        $tag_slug='knowledge-base_tag';
                                        $post_type='knowledge-base';
                                        get_template_part( 'template-parts/content-custom',null, compact('post_type','counterPost','category_slug','tag_slug','custom_sticky', 'hide_col'));
                                    }
                                    wp_reset_postdata(); // Сбрасываем данные запроса
                                    ?>
                                  </div>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="mobile-link">
                                <a href="<?php echo esc_url($category_link); ?>" class="btn-link btn-link-hover">
                                    <?php _e('See all articles','ndp'); ?>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                        <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#2A59BD"></path>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        
                    <?php endif;
                }
            }
            ?>
            <div class="for-newsletter">
                <div class="container">
                    <div class='row'>
                        <div class='col-md-12'>
                            <?php get_template_part('templates/join', 'community'); ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php
        else :

            get_template_part('template-parts/content', 'none');

        endif;
        ?>

    </main><!-- #main -->

<?php
//get_sidebar();
get_footer();
