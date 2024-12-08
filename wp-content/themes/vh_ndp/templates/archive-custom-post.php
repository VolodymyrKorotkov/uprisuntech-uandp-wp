<div class="list-card" data-is-have-sticky="">
    <div class="container">
        <div class="row list-three-card <?php echo $post_type === 'news' ? 'list-three-card-first-full' : ''; ?>">
            <?php
            $counterPost = 0;

            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    $counterPost++;
                    $custom_sticky = get_post_meta(get_the_ID(), 'custom_sticky', true);
                    get_template_part('template-parts/content-custom', null, compact('post_type', 'counterPost', 'category_slug', 'tag_slug', 'custom_sticky'));
                }
                wp_reset_postdata(); // Сбрасываем глобальную переменную $post после цикла
            } else {
                get_template_part('template-parts/content', 'none', ['post_type' => $post_type]);
            }
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
            echo paginate_links(array(
                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                'format' => '?paged=%#%',
                'current' => max(1, get_query_var('paged')),
                'total' => $wp_query->max_num_pages,
                'prev_text' => '<img src="' . get_template_directory_uri() . '/assets/img/icon/icon-pagination.svg" alt="prev">',
                'next_text' => '<img src="' . get_template_directory_uri() . '/assets/img/icon/icon-pagination.svg" alt="next">',
            ));
        }
        ?>
    </nav>
</div>