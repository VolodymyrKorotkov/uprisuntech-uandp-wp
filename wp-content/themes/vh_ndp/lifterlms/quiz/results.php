<?php
/**
 * Quiz Results Template
 *
 * @package LifterLMS/Templates
 *
 * @since 1.0.0
 * @since 3.35.0 Access `$_GET` data via `llms_filter_input()`.
 * @since 4.17.0 Return early if accessed without a logged in user.
 * @since 5.9.0 Stop using deprecated `FILTER_SANITIZE_STRING`.
 * @version 5.9.0
 *
 * @property LLMS_Quiz_Attempt $attempt Attempt object.
 */

defined( 'ABSPATH' ) || exit;

global $post;
$quiz = llms_get_post( $post );
if ( ! $quiz ) {
	return;
}

$student = llms_get_student();
if ( ! $student ) {
	return;
}

$attempts = $student->quizzes()->get_attempts_by_quiz(
	$quiz->get( 'id' ),
	array(
		'per_page' => 25,
		'sort'     => array(
			'attempt' => 'DESC',
		),
	)
);

$key     = llms_filter_input_sanitize_string( INPUT_GET, 'attempt_key' );
$attempt = $key ? $student->quizzes()->get_attempt_by_key( $key ) : false;

if ( ! $attempt && ! $attempts ) {
	return;
}
?>

<div class="course__quiz-item course__quiz-result llms-quiz-results">

	<?php
		/**
		 * llms_single_quiz_attempt_results
		 *
		 * @hooked lifterlms_template_quiz_attempt_results - 10
		 */

		/**
		 * Action fired prior to the output of LifterLMS Quiz Results HTML
		 *
		 * @since Unknown
		 *
		 * @param LLMS_Quiz_Attempt $attempt Attempt object.
		 */
		do_action( 'llms_single_quiz_attempt_results', $attempt );
	?>

</div>