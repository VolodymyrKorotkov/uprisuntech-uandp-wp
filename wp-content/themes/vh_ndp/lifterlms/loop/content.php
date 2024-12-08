<?php
/**
 * The Template for displaying all single courses.
 *
 * @package     LifterLMS/Templates
 *
 * @since       1.0.0
 * @version     3.14.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$categories = wp_get_post_terms(get_the_ID(), 'course_cat');
$tags = wp_get_post_terms(get_the_ID(), 'course_tag');

$course = new LLMS_Course( $post );
$product = new LLMS_Product( $post );
$plans = $product->get_access_plans();
$price = '';
$isFree = true;
foreach ($plans as $plan) {
    $hasPrice = $plan->get_initial_price();
    if ($hasPrice && ((int)$hasPrice) > 0) {
        $price = $hasPrice;
        $isFree = false;
        break;
    }
}
$img = '';
if ( has_post_thumbnail( $post->ID ) ) {
    $img = llms_featured_img( $post->ID, 'full' );
} elseif ( llms_placeholder_img_src() ) {
    $img = llms_placeholder_img();
}

$description = get_field('course_short_description');
$course_total_time = prepareCourseTime(calculateTimeOfCourse($course));

$isLoggedIn = is_user_logged_in();
$current_user = wp_get_current_user();
$user_is_student = false;
$current_userID = null;
$courseProgress = 0;


if ($isLoggedIn) {
    $user = get_userdata($current_user->ID);
    $user_roles = $user->roles;
    $user_is_student = in_array( 'student', $user_roles, true );
    $current_userID = $current_user->ID;
    $student = new LLMS_Student($current_userID);
    $courseProgress = $student->get_progress(get_the_ID());
}
?>
<div class="library__course-item">
    <?php
    /**
     * Hook: lifterlms_before_loop_item
     *
     * @hooked lifterlms_loop_featured_video - 8
     * @hooked lifterlms_loop_link_start - 10
     */
//    do_action( 'lifterlms_before_loop_item' );
    ?>

    <?php
    /**
     * Hook: lifterlms_before_loop_item_title
     *
     * @hooked lifterlms_template_loop_thumbnail - 10
     * @hooked lifterlms_template_loop_progress - 15
     */
//    do_action( 'lifterlms_before_loop_item_title' );
    ?>
    <div class="library__course-image">
        <?php if ($img): ?>
        <a href="<?php echo get_the_permalink(); ?>" class="llms-loop-link"><?php echo $img; ?></a>
        <?php endif; ?>
    </div>
    <div class="library__course-text">
        <div class="library__course-tags">
            <?php if (!empty($categories)): ?>
            <span class="library__course-category" title="<?php echo $categories[0]->name; ?>"><span><?php echo $categories[0]->name; ?></span></span>
            <?php endif; ?>
            <?php if (!empty($tags)): ?>
            <span class="library__course-level" title="<?php echo $tags[0]->name; ?>"><span><?php echo $tags[0]->name; ?></span></span>
            <?php endif; ?>
            <?php if ($course->get_difficulty()): ?>
            <span class="library__course-complexity" title="<?php echo $course->get_difficulty(); ?>"><span><?php echo $course->get_difficulty(); ?></span></span>
            <?php endif; ?>
            <?php if (!empty($tags) && count($tags) > 1): ?>
            <?php
                $hover = '<div class="wrapper-hover-block tooltip-bottom"><div class="wrapper-hover-block__container">';
                $more = '';
                foreach ($tags as $k => $tag) {
                  $hover .= '<span class="tag-inner tag-inner-'.$k.' block-post-item-label" title="'. $tag->name .'">'. $tag->name .'</span>';
                }
                $count = count($tags) - 1;
                $hover .= '</div></div>';
                $more .= '<div class="library__course-more more-hover">+<span class="more-hover-count" data-count="'. $count .'" data-count-mob="'. ($count+1) .'"></span>'. $hover . '</div>';
                echo $more;
            ?>
            <?php endif; ?>
        </div>
        <h2 class="library__course-title">
            <a href="<?php echo get_the_permalink(); ?>" class="llms-loop-link"><?php the_title(); ?></a>
        </h2>
        <?php
        /**
         * Hook: lifterlms_after_loop_item_title
         *
         * @hooked lifterlms_template_loop_author - 10
         * @hooked lifterlms_template_loop_length - 15
         * @hooked lifterlms_template_loop_difficulty - 20
         *
         * On Student Dashboard & "Mine" Courses Shortcode
         * @hooked lifterlms_template_loop_enroll_status - 25
         * @hooked lifterlms_template_loop_enroll_date - 30
         */
//        do_action( 'lifterlms_after_loop_item_title' );
        ?>
        <?php if (!empty($description)): ?>
        <p class="library__course-description"><?php echo $description; ?></p>
        <?php endif; ?>
        <div class="library__course-author">
            <span><?php _e('Author', 'ndp'); ?>:</span>
            <strong><?php echo llms_get_author(
                    array(
                        'avatar' => false,
                    )
                ); ?></strong>
        </div>
        <?php if ($course_total_time): ?>
        <div class="library__course-totalTime">
            <?php //echo $course->get( 'length' ); ?>
            <span><?php _e('Total time', 'ndp'); ?>:</span>
            <strong><?php echo $course_total_time; ?></strong>
        </div>
        <?php endif; ?>
        <?php if ($isLoggedIn): ?>
            <?php if ($courseProgress > 0 && $courseProgress < 100): ?>
            <div class="library__course-footer">
                <span class="library__course-inProgress"><?php _e('In progress', 'ndp') ?></span>
                <div class="library__course-progressbar"><span style="width: <?php echo $courseProgress; ?>%"></span></div>
                <span class="library__course-percent"><?php echo $courseProgress; ?>%</span>
            </div>
            <?php elseif ($courseProgress == 100): ?>
            <?php
            $certificate = getUserCertificate($student->get('id'), $course->get('id'));
            if ($certificate && is_a($certificate, 'LLMS_User_Certificate')) {
                $expireDate = getCertificateExpiredDate($certificate);
                $expired = checkCertificateIsExpired($certificate);
                $expireDays = getCertificateExpiredDays($certificate);

                if (!$expired) { ?>
                <?php $until = sprintf(__("Until %s", 'ndp' ), $expireDate); ?>
                <div class="library__course-footer">
                    <span class="library__course-finished"><?php _e('Finished', 'ndp'); ?></span>
                    <span class="library__course-certificateValid"><?php _e('Valid','ndp') ?></span>
                    <span class="library__course-date"><?php echo $until; ?></span>
                </div>
                <?php } else { ?>
                <?php $expireDate = sprintf(__("Expired %s", 'ndp' ), $expireDate); ?>
                <div class="library__course-footer">
                    <span class="library__course-finished"><?php _e('Finished', 'ndp'); ?></span>
                    <span class="library__course-certificateInvalid"><?php _e('Invalid','ndp') ?></span>
                    <span class="library__course-date"><?php echo $expireDate; ?></span>
                </div>
                <?php }
            }
            ?>
            <?php endif; ?>
        <?php else: ?>
        <div class="library__course-footer">
            <?php if ($price): ?>
                <span class="library__course-price"><span class="llms-price-currency-symbol"><?php echo get_lifterlms_currency_symbol(); ?></span><?php echo $price; ?></span>
                <div class="library__course-limit__block">
                    <span class="library__course-limit"><?php _e('For installers', 'ndp'); ?></span>
                </div>
            <?php else: ?>
                <span class="library__course-free"><?php _e('Free lesson', 'ndp') ?></span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php
    /**
     * Hook: lifterlms_after_loop_item
     *
     * @hooked lifterlms_loop_link_end - 5
     */
//    do_action( 'lifterlms_after_loop_item' );
    ?>
</div>
