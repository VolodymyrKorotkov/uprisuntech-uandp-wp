<?php
/**
 * Short Answer Question Template
 *
 * @package LifterLMS_Advanced_Quizzes/Templates
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 * @property LLMS_Quiz_Attempt $attempt  Attempt object.
 * @property LLMS_Question     $question Question object.
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="llms-aq-short-answer">
	<input class="llms-aq-short-answer-field" id="llms-question-answer-<?php echo $question->get( 'id' ); ?>" type="text" required="required">
</div>
