<?php
/**
 * Long Answer Question Template
 *
 * @package LifterLMS_Advanced_Quizzes/Templates
 *
 * @since 1.0.0
 * @version 1.1.1
 *
 * @property LLMS_Quiz_Attempt $attempt  Attempt object.
 * @property LLMS_Question     $question Question object.
 */

defined( 'ABSPATH' ) || exit;

$min = llms_parse_bool( $question->get( 'word_count_min' ) ) ? $question->get( 'words_min' ) : false;
$max = llms_parse_bool( $question->get( 'word_count_max' ) ) ? $question->get( 'words_max' ) : false;
?>

<div class="llms-aq-long-answer">
	<textarea class="llms-aq-long-answer-field notranslate" data-words-max="<?php echo $max; ?>" data-words-min="<?php echo $min; ?>" id="llms-question-answer-<?php echo $question->get( 'id' ); ?>" required="required"></textarea>
</div>
