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

<?php

if (!empty($_GET)) {
    foreach ($_GET as $key => $value) {
        $_GET[$key] = (array) $value;
    }
}

$post_type = 'project';
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

<main id="primary" class="site-main news-main ndp-projects-list">
    <div class="breadcrumb breadcrumb-block">
        <div class="wrap">
            <div class='fn_breadcrumbs'>
                <?php yoast_breadcrumb(); ?>
            </div>
        </div>
    </div>
    <?php
    //if ($post_type === 'post' || $post_type === 'news' || $post_type === 'knowledge-base' || $post_type === 'cases'):
    
    ?>

    <?php

    $tag_slug = 'project_tag';
    $category_slug = 'project_category';
    $status_slug = 'project_status';
    $sticky_posts_count = 0;

    $news_tags = get_terms(
        array(
            'taxonomy' => $tag_slug,
            'hide_empty' => true,
        )
    );


    // Получаем список категорий
    $project_categories = get_terms([
        'taxonomy' => $category_slug,
        'hide_empty' => true,
    ]);

    $project_statuses = get_terms([
        'taxonomy' => $status_slug,
        'hide_empty' => true,
    ]);


    $current_lang = apply_filters('wpml_current_language', 'uk');
    ?>
    <div class="title-filter">
        <div class="wrap">
            <div class="title-filter-bl">
                <h1 class="title-page s">
                    <?php echo get_the_title(); ?>
                </h1>

                <div class="filter">


                    <div class="input-container sort-input-container c-select">
                        <label class="sort-label">
                            <?php _e('Sort by', 'ndp-projects-plugin'); ?>
                        </label>
                        <input value="" type="hidden" name="text-services" class="input-container__input styled-select">
                        <div class="select__btn" data-post-type="<?php echo $post_type; ?>">
                            <?php _e('Data (descending)', 'ndp-projects-plugin'); ?>
                        </div>
                        <div class="select__list" style="display: none;">
                            <div class="select__item" data-sort-by="date-desc">
                                <?php _e('Data (descending)', 'ndp-projects-plugin'); ?>
                            </div>
                            <div class="select__item" data-sort-by="date-asc">
                                <?php _e('Data (ascending)', 'ndp-projects-plugin'); ?>
                            </div>
                            <!--  -->
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
    function checkIfIsCategory(): bool
    {
        if (!empty($_GET)) {
            foreach ($_GET as $key => $get) {
                if (preg_match('/project_category/', $key) !== false) {
                    return true;
                }
            }
        }
        return false;
    }
    ?>

    <?php /*
<div class="articles-filter">
<div class="filter">
<?php
if (isset($news_tags) && !empty($news_tags)) {
?>
<div class="input-container tag-search-container c-select c-multiselect">
<label class="sort-label">
<?php _e('All tags', 'ndp'); ?>
</label>
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
   $tagID = apply_filters('wpml_object_id', $tag->term_id, $tag_slug, false, $current_lang);
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

</div>
</div>
*/ ?>

    <div class="articles-filter">
        <div class="wrap">

            <?php
            if (isset($project_categories) && !empty($project_categories)) {
                ?>
                <div class="input-container tag-search-container c-select c-multiselect">
                    <label class="sort-label">
                        <?php _e('All Categories', 'ndp-projects-plugin'); ?>
                    </label>
                    <input value="" type="hidden" name="text-services" class="styled-select">
                    <div class="select__btn" data-post-custom-tag="<?php echo $tag_slug; ?>">
                        <?php
                        $tags = _e('Select category', 'ndp-projects-plugin');
                        echo $tags; ?>
                    </div>
                    <div class="select__list" style="display: none;">

                        <?php
                        // Перебираем теги
                        foreach ($project_categories as $tag) {
                            $tagID = apply_filters('wpml_object_id', $tag->term_id, $tag_slug, false, $current_lang);
                            if ($tagID) {
                                echo '<div class="select__item" data-sort-by="' . esc_html($tag->slug) . '">' . esc_html($tag->name) . '</div>';
                            }
                        }
                        ?>

                    </div>
                </div>
                <?php
            }
            ?>


            <?php
            if (isset($news_tags) && !empty($news_tags)) {
                ?>
                <div class="input-container tag-search-container c-select c-multiselect">
                    <label class="sort-label">
                        <?php _e('All tags', 'ndp-projects-plugin'); ?>
                    </label>
                    <input value="" type="hidden" name="text-services" class="styled-select">
                    <div class="select__btn" data-post-custom-tag="<?php echo $tag_slug; ?>">
                        <?php
                        $tags = _e('Select tags', 'ndp-projects-plugin');
                        echo $tags; ?>
                    </div>
                    <div class="select__list" style="display: none;">

                        <?php
                        // Перебираем теги
                        foreach ($news_tags as $tag) {
                            $tagID = apply_filters('wpml_object_id', $tag->term_id, $tag_slug, false, $current_lang);
                            if ($tagID) {
                                echo '<div class="select__item" data-sort-by="' . esc_html($tag->slug) . '">' . esc_html($tag->name) . '</div>';
                            }
                        }
                        ?>

                    </div>
                </div>
                <?php
            }
            ?>

            <?php
            if (isset($project_statuses) && !empty($project_statuses)) {
                ?>
                <div class="input-container tag-search-container c-select c-multiselect">
                    <label class="sort-label">
                        <?php _e('All status', 'ndp-projects-plugin'); ?>
                    </label>
                    <input value="" type="hidden" name="text-services" class="styled-select">
                    <div class="select__btn" data-post-custom-tag="<?php echo $tag_slug; ?>">
                        <?php
                        $tags = _e('Select status', 'ndp-projects-plugin');
                        echo $tags; ?>
                    </div>
                    <div class="select__list" style="display: none;">

                        <?php
                        // Перебираем теги
                        foreach ($project_statuses as $tag) {
                            $tagID = apply_filters('wpml_object_id', $tag->term_id, $tag_slug, false, $current_lang);
                            if ($tagID) {
                                echo '<div class="select__item" data-sort-by="' . esc_html($tag->slug) . '">' . esc_html($tag->name) . '</div>';
                            }
                        }
                        ?>

                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>



    <?php //include(get_template_directory() . '/templates/archive-custom-post.php');                                      ?>

    <?php

    $args = array(
        'post_type' => 'project',
        'posts_per_page' => 10
    );
    $the_query = new WP_Query($args);
    ?>
    <div class="list-card" data-is-have-sticky="">
        <div class="container">
            <div class="row list-three-card list-three-card-first-full">
                <?php
                $counterPost = 0;

                if (have_posts()) {
                    while ($the_query->have_posts()) {
                        $the_query->the_post();
                        $counterPost++;
                        $custom_sticky = get_post_meta(get_the_ID(), 'custom_sticky', true);
                        //get_template_part('template-parts/content-custom', null, compact('post_type', 'counterPost', 'category_slug', 'tag_slug', 'custom_sticky'));
                
                        include(plugin_dir_path(__FILE__) . 'content-custom.php');
                    }
                    wp_reset_postdata(); // Сбрасываем глобальную переменную $post после цикла
                } else {
                    get_template_part('template-parts/content', 'none', ['post_type' => $post_type]);
                }

                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>

    <div class="wp-pagination">
        <nav class="pagination">
            <?php
            if (have_posts()) {
                global $wp_query;

                $big = 999999999;
                echo paginate_links(
                    array(
                        'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                        'format' => '?paged=%#%',
                        'current' => max(1, get_query_var('paged')),
                        'total' => $wp_query->max_num_pages,
                        'prev_text' => '<img src="' . get_template_directory_uri() . '/assets/img/icon/icon-pagination.svg" alt="prev">',
                        'next_text' => '<img src="' . get_template_directory_uri() . '/assets/img/icon/icon-pagination.svg" alt="next">',
                    )
                );
            }
            ?>
        </nav>
    </div>

    <div class="for-newsletter">
        <div class="container">
            <div class='row'>
                <div class='col-md-12'>
                    <?php get_template_part('templates/join', 'community'); ?>
                </div>
            </div>
        </div>
    </div>


</main><!-- #main -->


<?php
//get_sidebar();
get_footer();
