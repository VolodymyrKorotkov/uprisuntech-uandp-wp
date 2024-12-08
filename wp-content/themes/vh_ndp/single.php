<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package NDP
 */

get_header();
?>

    <main id="primary" class="site-main">

        <?php if (get_post_type() === 'post' || get_post_type() === 'news' || get_post_type() === 'knowledge-base' || get_post_type() === 'cases') { ?>

            <div class="article">
                <div class="wrap">

                     <div class='fn_breadcrumbs'>
                <?php yoast_breadcrumb(); ?>
            </div>

                    <h1><?php echo get_the_title(); ?></h1>

                    <?php
                    /* Tags */
                    $tag_slug = '';

                    if (get_post_type() === 'news') {
                        $tag_slug = 'news_tag';
                    } elseif (get_post_type() === 'knowledge-base') {
                        $tag_slug = 'knowledge-base_tag';
                    } elseif (get_post_type() === 'cases') {
                        $tag_slug = 'cases_tag';
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
                    ?>

                    <div class="category-tags">
                        <?php
                        $categories = wp_get_post_terms(get_the_ID(), $category_slug);
                        ?>

                        <?php
                        // Получаем массив объектов тегов текущего поста
                        // $post_tags = get_the_tags();

                        $post_tags = wp_get_post_terms(get_the_ID(), $tag_slug);

                        $counterTags = 0;
                        $tagsListFirst = '';
                        $tagsList = '';

                        // Проверяем, есть ли теги для текущего поста
                        if ($post_tags) {
                            foreach ($post_tags as $tag) {
                                $counterTags++;
                                $tag_name = $tag->name;
                                $tag_url = get_tag_link($tag->term_id);

                                $tagsListFirst .= '<li><a href="' . esc_url($tag_url) . '" class="btn__accessory btn_bg_no-selected" data-term-id="' . $tag->term_id . '">' . esc_html($tag_name) . '</a></li>';
//                                if ($counterTags <= 1) {
//                                    $tagsListFirst .= '<li><a href="' . esc_url($tag_url) . '" class="btn__accessory btn_bg_no-selected" data-term-id="' . $tag->term_id . '">' . esc_html($tag_name) . '</a></li>';
//                                } else {
//                                    $tagsList .= '<li><a href="' . esc_url($tag_url) . '" class="btn__accessory btn_bg_no-selected" data-term-id="' . $tag->term_id . '">' . esc_html($tag_name) . '</a></li>';
//                                }
                            }
                        }

                        echo '<ul class="category-tags__tags-list">';
                        if (isset($categories) && !empty($categories)) {
                            $counterCat = 0;
                            foreach ($categories as $category) {
                                $counterCat++;
                                if ($counterCat < 2) {
                                    ?>
                                    <li><a href="<?php echo get_category_link($category->term_id); ?>"
                                                   class="btn__accessory btn_bg_complementary category-tags__category"
                                                   data-term-id="<?php echo $category->term_id; ?>">
                                                    <?php echo esc_html($category->name); ?>
                                        </a></li>
                                    <?php
                                }
                            }
                        }
                        echo $tagsListFirst;
//                        echo !empty($tagsList) ? '<li class="tooltip"><span class="category-tags__count-element btn__accessory btn_bg_no-selected">+' . ($counterTags - 1) . '</span><ul class="tooltiptext">' . $tagsList . '</ul>' : '';
                        echo '</ul>';
                        ?>

                    </div>

                    <p><?php echo custom_get_the_excerpt(get_post(), 500, '...'); ?></p>

                    <div class="card-nw__info">
                        <div class="card-nw__date text-sm-scnd">
                            <?php
                            $post_time = get_the_time('U');
//                            $post_time = get_the_modified_time('U');
                            echo custom_time_ago($post_time);
                            ?>
                        </div>
                        <span></span>
                        <div class="card-nw__vol text-sm-scnd">
                            <?php
                            $post_content = get_the_content();
                            $reading_time = approximate_reading_time($post_content);
                            $current_language = apply_filters('wpml_current_language', NULL);
                            if($current_language=="en"){
                                $text_min = ' minute(s) read';
                            }else{
                                $text_min = ' хв. читати';
                            }
                            echo $reading_time . $text_min; //  5 min read

                            ?>
                        </div>
                    </div>

                    <?php if (get_the_post_thumbnail_url()) {
                        echo '<img src="' . get_the_post_thumbnail_url() . '" alt="' . get_the_title() . '"
                         class="post-thumbnail">';
                    } ?>

                    <?php echo get_the_content(); ?>

                    <?php get_template_part('templates/documets', 'post', array('post_id' => get_the_ID())); ?>
                </div>
            </div>
            <div class="more-cards">
                <?php
                    $post_type_obj = get_post_type_object(get_post_type());
                    $postLabel = $post_type_obj->label;
                    get_template_part('templates/more', 'posts', array(
                        'post_type' => get_post_type(),
                        'posts_per_page' => 12,
                        'title' => __('More ','ndp') . ' ' . __("${postLabel}",'ndp'),
                        'post_id' => get_the_ID(),
                    ));

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

            </div>

        <?php } ?>

    </main><!-- #main -->

<?php
//get_sidebar();
get_footer();

