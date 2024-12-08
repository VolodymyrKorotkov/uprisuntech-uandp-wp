<?php
/**
 * LLMS Pagination Template
 *
 * @package LifterLMS/Templates/Loop
 *
 * @since 1.0.0
 * @version 4.10.0
 */

defined( 'ABSPATH' ) || exit;

global $wp_query;
if ( $wp_query->max_num_pages < 2 ) {
	return;
}

/**
 * Filter the list of CSS classes on the pagination wrapper element.
 *
 * @since 4.10.0
 *
 * @param string[] $classes Array of CSS classes.
 */
$classes = apply_filters( 'llms_get_pagination_wrapper_classes', array( 'llms-pagination' ) );



$total   = isset( $total ) ? $total : $wp_query->max_num_pages;
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
    return;
}
$filters = [];
if (!empty($_GET)) {
    $tax_queries = [
        'relation' => 'AND',
    ];

    foreach ($_GET as $type => $filterList) {
        foreach ($filterList as $key => $filter) {
            $filter = sanitize_text_field($filter);
            $filters[$type][$key] = $filter;
        }
    }
}
?>
<div class="pagination">
    <div class="pagination__wrap">
        <?php
        echo paginate_links(
            array( // WPCS: XSS ok.
                'base'      => $base,
                'format'    => $format,
                'current'   => max( 1, get_query_var( 'paged' ) ),
                'total'     => $total,
                'prev_text' => is_rtl() ? '<span><i class="arrow arrow-right"></i></span>' : '<span><i class="arrow arrow-left"></i></span>',
                'next_text' => is_rtl() ? '<span><i class="arrow arrow-left"></i></span>' : '<span><i class="arrow arrow-right"></i></span>',
                'end_size'  => 3,
                'mid_size'  => 3,
                'add_args' => $filters,
                'custom_pagination' => true,
            )
        );
        ?>
    </div>
</div>
