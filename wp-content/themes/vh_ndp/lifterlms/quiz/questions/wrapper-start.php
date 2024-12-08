<?php
/**
 * Single Question: Wrapper Start
 *
 * @package LifterLMS/Templates
 *
 * @since    1.0.0
 * @version  3.16.0
 *
 * @arg  $attempt  (obj)  LLMS_Quiz_Attempt instance
 * @arg  $question (obj)  LLMS_Question instance
 */

defined( 'ABSPATH' ) || exit;

$classType = 'course__quiz-oneSelect';
$input_type = ( 'yes' === $question->get( 'multi_choices' ) ) ? 'checkbox' : 'radio';
if ($input_type == 'checkbox') {
    $classType = 'course__quiz-multiSelect';
}
$quiz = $question->get_quiz();
$lesson = $quiz->get_lesson();
$course = $lesson->get_course();
$isSurvey = false;
if ($course) {
    $isSurvey = get_post_meta($course->get('id'), 'type', true);
}
$isSurveyClass = '';
if ($isSurvey) {
  $isSurveyClass = ' survey-item';
}
?>
<div class="course__quiz-item <?php echo $classType; ?><?php echo $isSurveyClass; ?> llms-question-wrapper type--<?php echo $question->get( 'question_type' ); ?>" data-id="<?php echo $question->get( 'id' ); ?>" data-type="<?php echo $question->get( 'question_type' ); ?>" id="llms-question-<?php echo $question->get( 'id' ); ?>">
