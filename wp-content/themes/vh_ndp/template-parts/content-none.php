<?php
/**
 * Template part for displaying a message that posts cannot be found
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NDP
 */
$post_type = get_post_type();
if (!$post_type) {
    if (!empty($args)) {
        $post_type = $args['post_type'] ?? '';
    } else {
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
}
?>

<section id="primary-none" class="site-main news-main">

    <div class="container">
        <div class="row">
            <section class="no-results not-found">

                <span><?php _e('Nothing Found'); ?></span>

                <?php
                if ( is_home() && current_user_can( 'publish_posts' ) ) :

                    printf(
                        '<p>' . wp_kses(
                        /* translators: 1: link to WP admin new post page. */
                            __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'vh_ndp' ),
                            array(
                                'a' => array(
                                    'href' => array(),
                                ),
                            )
                        ) . '</p>',
                        esc_url( admin_url( 'post-new.php' ) )
                    );

                elseif ( is_search() ) :
                    ?>

                    <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'vh_ndp' ); ?></p>
                    <?php
                    get_search_form();

                else : ?>

                    <p><?php _e('Please try selecting different filters'); ?></p>
                    <?php
                    $allowedTypes = ['news', 'knowledge-base', 'cases', 'cases_category', 'knowledge-base_category'];

                    if (in_array($post_type, $allowedTypes)) {
                        $link = home_url() . '/' . $post_type;
                        ?>
                        <button class="clear-filter js-clear-filter btn btn-primary"><?php _e('Clear filters'); ?></button>
                        <?php
                    } else {
                        get_search_form();
                    }

                endif;
                ?>

            </section><!-- .no-results -->
        </div>
    </div>
</section>
