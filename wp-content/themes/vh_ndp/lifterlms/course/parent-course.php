<?php
/**
 * Back to Course Template
 *
 * @package LifterLMS/Templates
 *
 * @since  1.0.0
 * @since 5.7.0 Replaced the call to the deprecated `LLMS_Lesson::get_parent_course()` method with `LLMS_Lesson::get( 'parent_course' )`.
 * @version 5.7.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$lesson = new LLMS_Lesson( $post );

?>

<div class='course-training-page-left-box-description-text-actions'>
    <div class='btn btn-outline-link'>
        <?php
        printf( __( '<a class="llms-lesson-link" href="%1$s">%2$s</a></p>', 'lifterlms' ), get_permalink( $lesson->get( 'parent_course' ) ), __('View course page', 'ndp') );
        ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
            <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#2A59BD"/>
        </svg>
    </div>
</div>