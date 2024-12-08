<?php
/**
 * Course & Membership Instructors Block
 *
 * @package LifterLMS/Templates/Shared
 *
 * @since 4.11.0
 * @version 4.11.0
 *
 * @param LLMS_Post_Model $llms_post   Instance of the LLMS_Post_Model for the current screen.
 * @param array[]         $instructors Array of instructor data from the post's `get_instructors()` method.
 * @param int             $count       Number of instructors found in the `$instructors` array.
 */

defined( 'ABSPATH' ) || exit;

echo '';

//global $post;
//
//$course = new LLMS_Course( $post );
//$instructors = $course->get_instructors();
//if (empty($instructors)) return;
//if (get_field('type')) return;
//
//$current_lang = apply_filters( 'wpml_current_language', 'uk' );
//$instructor = llms_get_instructor($instructors[0]['id']);
//$id = $instructor->get('id');
//$name = get_the_author_meta( 'display_name', $id );
//$img = get_avatar( $id, 100, apply_filters( 'lifterlms_author_avatar_placeholder', '' ), $name );
//$desc = get_the_author_meta( 'description', $id ) ?? '';
//$courses = $instructor->get_courses();
//
//global $sitepress;
//$courseUrl = '/courses/';
//if ($sitepress) {
//    $courseUrl = $sitepress->convert_url( $sitepress->get_wp_api()->get_post_type_archive_link( 'course' ), $current_lang );
//}
//$url = $courseUrl.'?'.http_build_query(['author' => [$id]]);
//?>
<!--<h2 class="course__instructor">--><?php //_e('Instructor', 'ndp'); ?><!--</h2>-->
<!--<div class="course__instructor-block">-->
<!--    <div class="course__instructor-image">--><?php //echo $img; ?><!--</div>-->
<!--    <div class="course__instructor-text">-->
<!--        <h3 class="course__instructor-title">--><?php //echo $name; ?><!--</h3>-->
<!--        <p class="course__instructor-subtitle">--><?php //echo $desc; ?><!--</p>-->
<!--        <div class="course__instructor-info">-->
<!--            <span class="course__instructor-amount">--><?php //echo sprintf( _n( '%s course', '%s courses', count($courses), 'ndp' ), count($courses) ); ?><!--</span>-->
<!--            <a href="--><?php //echo $url; ?><!--" class="course__instructor-link">--><?php //_e('See all courses', 'ndp'); ?><!--</a>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->

