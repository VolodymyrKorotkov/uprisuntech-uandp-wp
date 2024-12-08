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
$totalLength = prepareCourseTime(calculateTimeOfCourse($course));

$student = llms_get_student();
$courseProgress = (int)$student->get_progress(get_the_ID());
?>
<div class="dashboard__inProgress-item">
    <div class="dashboard__inProgress-item__about">
        <?php if (!empty($categories)): ?>
            <span class="my-courses__item-category"><?php echo $categories[0]->name; ?></span>
        <?php endif; ?>
        <?php if (!empty($tags)): ?>
            <span class="my-courses__item-level"><?php echo $tags[0]->name; ?></span>
            <?php if (count($tags) > 1): ?>
                <span class="my-courses__item-more">+<?php echo count($tags)-1; ?></span>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($course->get_difficulty()): ?>
            <span class="my-courses__item-complexity"><?php echo $course->get_difficulty(); ?></span>
        <?php endif; ?>
    </div>
    <div class="dashboard__inProgress-item__header">
        <h2><a href="<?php echo get_the_permalink(); ?>" target="_blank" class="llms-loop-link"><?php the_title(); ?></a>
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <mask id="mask0_3519_14015" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                    <rect width="24" height="24" fill="#D9D9D9"/>
                </mask>
                <g mask="url(#mask0_3519_14015)">
                    <path d="M5.4001 20.4001C4.9051 20.4001 4.48135 20.2238 4.12885 19.8713C3.77635 19.5188 3.6001 19.0951 3.6001 18.6001V5.4001C3.6001 4.9051 3.77635 4.48135 4.12885 4.12885C4.48135 3.77635 4.9051 3.6001 5.4001 3.6001H12.0001V5.4001H5.4001V18.6001H18.6001V12.0001H20.4001V18.6001C20.4001 19.0951 20.2238 19.5188 19.8713 19.8713C19.5188 20.2238 19.0951 20.4001 18.6001 20.4001H5.4001ZM9.6751 15.6001L8.4001 14.3251L17.3251 5.4001H14.4001V3.6001H20.4001V9.6001H18.6001V6.6751L9.6751 15.6001Z" fill="#131316"/>
                </g>
            </svg>
        </h2>
        <?php
        $lesson = apply_filters( 'llms_course_continue_button_next_lesson', $student->get_next_lesson( $course->get( 'id' ) ), $course, $student );
        if ( $lesson ) {
            $link = get_permalink( $lesson );
        } elseif ($lesson = $course->get_lessons()) {
            $lesson = $lesson[0]->id;
        }
        $bntText = __('Start course', 'ndp');
        if ($courseProgress > 0 && $courseProgress < 100) {
            $bntText = __('Continue learning', 'ndp');
        } elseif ($courseProgress == 100) {
            $bntText = __('To training page', 'ndp');
        }
        ?>
        <a class="my-courses__start-course" href="<?php echo get_permalink( $lesson ); ?>"><?php _e($bntText, 'ndp'); ?></a>
    </div>
    <div class="dashboard__inProgress-item__info">
        <div class="dashboard__inProgress-item__provider">
            <span><?php _e('Provider', 'ndp'); ?>:</span><strong><?php echo llms_get_author(
                    array(
                        'avatar' => false,
                    )
                ); ?></strong>
        </div>
        <div class="dashboard__inProgress-item__time">
            <span><?php _e('Total time', 'ndp'); ?>:</span><strong><?php echo $totalLength; ?></strong>
        </div>
    </div>
    <?php if ($courseProgress > 0 && $courseProgress < 100): ?>
    <div class="dashboard__inProgress-item__status">
      <span class="dashboard__inProgress-item__value">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
        <path d="M6.375 6.48L10.3275 9L6.375 11.52V6.48ZM4.875 3.75V14.25L13.125 9L4.875 3.75Z" fill="#151B2C"/>
        </svg>
        <?php _e('In progress', 'ndp'); ?>
      </span>
        <div class="dashboard__inProgress-item__progress">
            <span class="dashboard__inProgress-item__progress-current" style="width: <?php echo $courseProgress.'%';?>"></span>
        </div>
        <span class="dashboard__inProgress-item__percent"><?php echo $courseProgress; ?>%</span>
    </div>
    <?php elseif ($courseProgress == 100): ?>
    <div class="dashboard__inProgress-item__status">
        <span class="dashboard__inProgress-item__value">
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
          <path d="M15 5.25L7.41819 12.75L3 9" stroke="#151B2C" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <?php _e('Finished', 'ndp'); ?></span>
    </div>
    <?php endif; ?>
</div>
