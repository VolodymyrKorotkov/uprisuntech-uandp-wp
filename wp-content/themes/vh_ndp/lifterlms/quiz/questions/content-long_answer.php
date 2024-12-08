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

<div class="llms-aq-long-answer mdc-text-field mdc-text-field--outlined">
    <div class="llms-aq-long-answer-field notranslate mdc-text-field__input" data-words-max="<?php echo $max; ?>" data-words-min="<?php echo $min; ?>" id="llms-question-answer-<?php echo $question->get( 'id' ); ?>" required="required"></div>

    <i class="material-icons mdc-text-field__icon" tabindex="0" role="button"></i>
    <div class="mdc-notched-outline">
        <div class="mdc-notched-outline__leading"></div>
        <div class="mdc-notched-outline__notch">
            <label for="llms-question-answer-<?php echo $question->get( 'id' ); ?>" class="mdc-floating-label"><?php _e('Your answer', 'ndp'); ?></label>
        </div>
        <div class="mdc-notched-outline__trailing">
            <i class="material-icons error-icon" aria-hidden="true"></i>
        </div>
    </div>
</div>
<script>
    jQuery(document).ready(function ($) {
        $('.llms-aq-long-answer').on('click', function(event) {
            console.log('click');
            $(this).addClass('focused')
        })
    })
</script>