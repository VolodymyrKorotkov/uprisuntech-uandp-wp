<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

get_header();
?>

<?php
if ( have_posts() ) {

    // Load posts loop.
    while ( have_posts() ) {
        the_post();

        get_template_part( 'template-parts/content-course');
    }

} else {

    // If no content, include the "No posts found" template.
//    get_template_part( 'template-parts/content/content-none' );

}

get_footer();
