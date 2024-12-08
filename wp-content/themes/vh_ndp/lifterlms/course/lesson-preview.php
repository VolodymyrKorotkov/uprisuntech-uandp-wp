<?php
/**
 * Template for a lesson preview element
 *
 * @author LifterLMS
 * @package LifterLMS/Templates
 *
 * @since 1.0.0
 * @since 3.19.2 Unknown.
 * @since 4.4.0 Use the passed `$order` param if available, in favor of retrieving the lesson's order post meta.
 * @since 5.7.0 Replaced the call to the deprecated `LLMS_Lesson::get_order()` method with `LLMS_Lesson::get( 'order' )`.
 * @version 5.7.0
 *
 * @var LLMS_Lesson $lesson        The lesson object.
 * @var string      $pre_text      The text to display before the lesson.
 * @var int         $total_lessons The number of lessons in the section.
 * @var array       $lessonTime    Time of lessons in the section.
 */
defined( 'ABSPATH' ) || exit;

$restrictions = llms_page_restricted( $lesson->get( 'id' ), get_current_user_id() );
$data_msg     = $restrictions['is_restricted'] ? ' data-tooltip-msg="' . esc_html( strip_tags( llms_get_restriction_message( $restrictions ) ) ) . '"' : '';

$lessonType = get_field('lesson_type', $lesson->get( 'id' ));

$totalLength = $lesson->lessonTime ?? '';
$totalLength = preg_replace('/^([0-9]+):([0-9]+)(:[0-9]*)?/','$1:$2', $totalLength);

$icon = '';
if ($lessonType) {
    $icon = compareValueAndReplace($lessonType);
}
$quiz = $lesson->get_quiz();
$countQuestions = 0;
if ($quiz) {
    $countQuestions = count($quiz->get_questions());
}
?>
<li class="course__accordion-list__item<?php echo $lesson->get_preview_classes(); ?>">
  <div class="course__accordion-icon">
      <?php if ($icon): ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/<?php echo $icon.'.svg'; ?>" alt="<?php echo $icon; ?>">
      <?php endif; ?>
  </div>
  <h4 class="course__accordion-list__title">
    <a class="llms-lesson-link<?php echo $restrictions['is_restricted'] ? ' llms-lesson-link-locked' : ''; ?>"
       href="<?php echo ( ! $restrictions['is_restricted'] ) ? get_permalink( $lesson->get( 'id' ) ) : '#llms-lesson-locked'; ?>"<?php echo $data_msg; ?>>
        <?php echo get_the_title( $lesson->get( 'id' ) ); ?>
    </a>
  </h4>
  <div class="course__accordion-list__info">
    <a class="course__accordion-list__preview llms-lesson-link<?php echo $restrictions['is_restricted'] ? ' llms-lesson-link-locked' : ''; ?>"
       href="<?php echo ( ! $restrictions['is_restricted'] ) ? get_permalink( $lesson->get( 'id' ) ) : '#llms-lesson-locked'; ?>"<?php echo $data_msg; ?>><?php _e('Preview','ndp'); ?></a>
    <?php if ($lesson->is_free()): ?>
    <span class="course__accordion-list__free"><?php _e('Free lesson', 'ndp'); ?></span>
    <?php endif; ?>
    <?php if ($countQuestions > 0): ?>
    <span class="course__accordion-list__time"><?php echo $countQuestions; ?> <?php _e('questions', 'ndp'); ?></span>
    <?php endif; ?>
    <?php if ($totalLength): ?>
    <span class="course__accordion-list__time"><?php echo $totalLength; ?></span>
    <?php endif; ?>
  </div>
</li>
