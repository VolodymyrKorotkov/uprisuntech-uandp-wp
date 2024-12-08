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
$isFree = true;
$img = '';
$description = get_field('course_short_description');
$totalLength = prepareCourseTime(calculateTimeOfCourse($course));
$student = llms_get_student();
$user = $student->get('user');
$user_id = $user->ID;
$courseProgress = (int)$student->get_progress(get_the_ID());
?>

<div class="acc-box">
  <div class="acc-user">
    <div class="acc-user__header mb-2">
      <div class="c-label">
        <?php if (!empty($categories)): ?>
          <div class="c-label__item c-label__item--lightblue"><?php echo $categories[0]->name; ?></div>
        <?php endif; ?>
        <?php if (!empty($tags) && !empty($tags[0])): ?>
          <div class="c-label__item c-label__item--gray c-label__item--transparent"><?php echo $tags[0]->name; ?></div>
        <?php endif; ?>
        <?php if (!empty($tags) && !empty($tags[1])): ?>
          <div class="c-label__item c-label__item--gray c-label__item--transparent"><?php echo $tags[1]->name; ?></div>
        <?php endif; ?>
        <?php if (!empty($tags) && count($tags) > 2): ?>
            <?php
            $titleTags = array_slice($tags, 2);
            $titleTags = implode(',', array_column($titleTags, 'name'));
            ?>
            <div class="c-label__item c-label__item--gray c-label__item--transparent" title="<?php if ($titleTags && is_string($titleTags)) echo $titleTags; ?>">+<?php echo count($tags)-2; ?></div>
        <?php endif; ?>
      </div>
      <?php if ($courseProgress == 0): ?>
        <div class="c-label d-none d-md-inline-flex">
          <div class="c-label__item c-label__item--gold"><?php _e('Available', 'ndp'); ?></div>
        </div>
      <?php elseif ($courseProgress > 0 && $courseProgress < 100): ?>
        <div class="c-label d-none d-md-inline-flex">
          <div class="c-label__item c-label__item--lightblue">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M6.375 6.48L10.3275 9L6.375 11.52V6.48ZM4.875 3.75V14.25L13.125 9L4.875 3.75Z" fill="#151B2C" />
            </svg>
            <?php _e('In progress', 'ndp'); ?>
          </div>
        </div>
      <?php elseif ($courseProgress == 100): ?>
        <div class="c-label d-none d-md-inline-flex">
          <div class="c-label__item c-label__item--green">
              <?php
              $date = $student->get_completion_date($course->get('id'), 'd.m.Y');
              ?>
            <?php _e('Passed', 'ndp') ?>: <?php echo $date; ?>
          </div>
        </div>
      <?php endif; ?>
    </div>
    <div class="acc-user__body">
      <div class="acc-user__head mb-2"><a href="<?php echo get_the_permalink(); ?>" target="_blank" class="llms-loop-link"><?php the_title(); ?></a></div>
      <div class="acc-user__text mb-2">
          <?php echo $description; ?>
      </div>
      <div class="acc-user__info mb-2 mb-md-0">
        <div class="acc-user__info-item">
          <div class="acc-user__info-label"><?php _e('Provider', 'ndp'); ?>:</div>
          <div class="acc-user__info-val"><?php echo get_the_author_meta( 'display_name', $user_id ) ?></div>
        </div>
        <div class="acc-user__info-item">
          <div class="acc-user__info-label"><?php _e('Duration', 'ndp'); ?>:</div>
          <div class="acc-user__info-val">~<?php echo $totalLength; ?></div>
        </div>
        <?php
        $startDate = get_field('survey_start_date');
        $finishDate = get_field('survey_finish_date');

//        $courses_start_date = get_user_meta($user_id, 'courses_start_date', true);
//        $startDate = '';
//        if (!empty($courses_start_date) && is_array($courses_start_date) && !empty($courses_start_date[$course->get('id')])) {
//            $startDate = $courses_start_date[$course->get('id')];
//        }
//        $finishDate = $student->get_completion_date($course->get('id'), 'd.m.Y');
        ?>
        <div class="acc-user__info-item">
          <div class="acc-user__info-label"><?php _e('Start', 'ndp'); ?>:</div>
          <div class="acc-user__info-val"><?php echo $startDate; ?></div>
        </div>
        <div class="acc-user__info-item">
          <div class="acc-user__info-label"><?php _e('Ends', 'ndp'); ?>:</div>
          <div class="acc-user__info-val"><?php echo $finishDate; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>