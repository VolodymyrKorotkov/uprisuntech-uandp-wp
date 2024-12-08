<?php
/**
 * Template part for displaying custom posts (news,casts)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NDP
 */
if (empty($args)) return;

$post_type = $args['post_type'] ?? '';
$counterPost = $args['counterPost'] ?? '';
$category_slug = $args['category_slug'] ?? '';
$tag_slug = $args['tag_slug'] ?? '';
$custom_sticky = $args['custom_sticky'] ?? '';
$hide_col = $args['hide_col'] ?? false;
?>
<div <?php post_class([ $hide_col ? 'card-nw' : 'col-12 col-sm-6 col-lg-4 card-nw', ($post_type === 'news' && $counterPost < 2) ? 'card-nw-full' : '', (isset($custom_sticky) && !empty($custom_sticky) && $custom_sticky !== 'off') ? 'card-nw-fixed' : '']); ?>
        data-views="<?php echo get_post_views(get_the_ID()); ?>">
    <div class="list-item">
        <a href="<?php echo get_the_permalink(); ?>" class="card-nw__img">
            <?php if (get_the_post_thumbnail_url()) {
                echo '<img src="' . get_the_post_thumbnail_url() . '"
                                                     alt="' . get_the_title() . '">';
            } else {
                echo '<img src="' . get_template_directory_uri() . '/assets/img/img/Imagenews__img0.png"
                                                     alt="' . get_the_title() . '">';
            } ?>
        </a>
        <div class="card-nw__block">
            <?php
            $title = trim_title_length(get_the_title());
            $newTitle = '';
            $shortTitle = '';
            if ($post_type == 'news') {
                $len = 56;
                if ($counterPost >= 2) {
                    $len = 65;
                }
                if (!wp_is_mobile()) {
                    $shortTitle = mb_strlen($title) > $len ? mb_substr($title,0,$len) : $title;
                    $sub = mb_substr($title, $len);
                    $subTitle = '';
                    $class = '';
                    if ($sub) {
                        $class = 'title-shorted';
                        $subTitle = '<span style="display:none">'.$sub.'</span>';
                    }
                    $newTitle = '<span class="'.$class.'">'.$shortTitle.'</span>'.$subTitle;
                } else {
                    $newTitle = '<span class="title-mob">'.$title.'</span>';
                }
            }
            $newTitle = !empty($newTitle)? $newTitle : $title;
            $titleAttribute = ($shortTitle == $title)? '' : $title;
            ?>
            <a href="<?php echo get_the_permalink(); ?>" class="block-title" title="<?php echo $titleAttribute; ?>">
                <?php echo $newTitle; ?>
            </a>

            <div class="category-tags">
                <?php
                $categories = wp_get_post_terms(get_the_ID(), $category_slug);

                if (isset($categories) && !empty($categories)) {
                    $counterCat = 0;
                    foreach ($categories as $category) {
                        $counterCat++;
                        if ($counterCat < 2) {
                            ?>
                            <a href="<?php echo get_category_link($category->term_id); ?>"
                               class="btn__accessory btn_bg_complementary category-tags__category"
                               data-term-slug="<?php echo $category->slug; ?>"
                               data-term-id="<?php echo $category->term_id; ?>">
                                <?php echo esc_html($category->name); ?>
                            </a>
                            <?php
                        }
                    }
                }
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

                        if ($counterTags <= 1) {
                            $tagsListFirst .= '<li><a href="' . esc_url($tag_url) . '" class="btn__accessory btn_bg_no-selected" data-term-id="' . $tag->term_id . '" data-term-slug="' . $tag->slug . '">' . esc_html($tag_name) . '</a></li>';
                        } else {
                            $tagsList .= '<li><a href="' . esc_url($tag_url) . '" class="btn__accessory btn_bg_no-selected" data-term-id="' . $tag->term_id . '" data-term-slug="' . $tag->slug . '">' . esc_html($tag_name) . '</a></li>';
                        }
                    }
                }

                echo '<ul class="category-tags__tags-list">';
                echo $tagsListFirst;
                echo !empty($tagsList) ? '<li class="tooltip"><span class="category-tags__count-element btn__accessory btn_bg_no-selected">+' . ($counterTags - 1) . '</span><ul class="tooltiptext">' . $tagsList . '</ul>' : '';
                echo '</ul>';
                ?>

            </div>

            <div class="text-sm">
                <?php
                //                                            if ($counterPost < 2) {
                //                                                echo custom_get_the_excerpt(get_post(), 180, '...');
                //                                            } else {
                echo custom_get_the_excerpt(get_post(), 130, '...');
                //                                            }
                ?>
            </div>

            <div class="card-nw__info">
                <div class="card-nw__date text-sm-scnd">
                    <?php
                    $post_time = get_the_modified_time('U');
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
        </div>
    </div>
</div>
