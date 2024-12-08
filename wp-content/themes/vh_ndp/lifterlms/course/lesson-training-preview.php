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

global $post;

$restrictions = llms_page_restricted( $lesson->get( 'id' ), get_current_user_id() );
$data_msg     = $restrictions['is_restricted'] ? ' data-tooltip-msg="' . esc_html( strip_tags( llms_get_restriction_message( $restrictions ) ) ) . '"' : '';

$lessonType = get_field('lesson_type', $lesson->get( 'id' )) ?? '';

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

$postType = get_post_type();
$completed = $lesson->is_complete();
$postID = $post->ID;
if ($postType == 'llms_quiz') {
    $quiz = new LLMS_Quiz($post);
    $quizLesson = $quiz->get_lesson();
    $postID = $quizLesson->get('id');
}
$current = ($postID == $lesson->get('id'))? 'course__accordion-list__item-current' : '';
?>
<li class="course__accordion-list__item <?php echo $current; ?>">
    <input type="checkbox" name="" id="" class="course__accordion-list__checkbox" <?php if ($completed) echo 'checked'; ?> disabled>
    <?php if ($icon): ?>
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/<?php echo $icon.'.svg'; ?>" alt="<?php echo $icon; ?>">
    <?php endif; ?>
    <div class="course__accordion-list__info">
        <?php
        if (!empty($lessonType)) {
            $lessonType = $lessonType? __($lessonType, 'ndp') : '';
            $lessonType = mb_convert_case($lessonType, MB_CASE_TITLE, "UTF-8");
        }
        ?>
        <h4 class="course__accordion-list__title"><?php echo get_the_title( $lesson->get( 'id' ) ); ?> <?php if ($lessonType) echo '('.ucfirst($lessonType).')'; ?></h4>
        <span class="course__accordion-list__subtitle"><?php echo $totalLength; ?></span>
    </div>
</li>
