<?php
/**
 * Code Question Template
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

$settings = apply_filters(
	'llms_aq_code_question_cm_settings',
	array(
		'assets_path'    => plugins_url( '/assets/vendor/codemirror/', LLMS_ADVANCED_QUIZZES_PLUGIN_FILE ),
		'mode'           => $question->get( 'code_language' ) ? $question->get( 'code_language' ) : 'javascript',
		'tabSize'        => 4,
		'lineNumbers'    => true,
		'indentWithTabs' => true,
		'autofocus'      => true,
		'theme'          => 'eclipse',
	),
	$question
);
?>

<div class="llms-aq-code">
	<textarea class="llms-aq-code-field" id="llms-question-answer-<?php echo $question->get( 'id' ); ?>" required="required"></textarea>
	<script id="llms-aq-code-settings" type="text/javascript">window.llms.advanced_quizzes.cm_settings = JSON.parse( '<?php echo wp_json_encode( $settings ); ?>' );</script>
</div>
