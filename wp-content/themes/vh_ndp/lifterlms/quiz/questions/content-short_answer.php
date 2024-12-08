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

<div class="llms-aq-short-answer mdc-text-field mdc-text-field--outlined">
    <input class="llms-aq-short-answer-field mdc-text-field__input" id="llms-question-answer-<?php echo $question->get( 'id' ); ?>" type="text">
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
        document.querySelectorAll('.mdc-text-field').forEach((node) => {
            mdc.textField.MDCTextField.attachTo(node);
        });

        mdc.autoInit()

        const textFields = [].map.call(document.querySelectorAll('.mdc-text-field'), function (el) {
            return new mdc.textField.MDCTextField(el);
        })
    })
</script>