<?php
/**
 * Choice Question Template
 *
 * @package LifterLMS/Templates
 *
 * @since    3.16.0
 * @version  3.16.0
 *
 * @arg  $attempt  (obj)  LLMS_Quiz_Attempt instance
 * @arg  $question (obj)  LLMS_Question instance
 */

defined( 'ABSPATH' ) || exit;

$questionType = $question->get( 'question_type' );
$blockType = 'course__quiz-oneSelect';
$input_type = ( 'yes' === $question->get( 'multi_choices' ) ) ? 'checkbox' : 'radio';
if ($input_type == 'checkbox') {
    $blockType = 'course__quiz-multiSelect';
}
?>

<div class="<?php echo $blockType;?>__block llms-question-choices">
    <?php foreach ( $question->get_choices() as $choice ) : ?>

        <div class="<?php echo $blockType;?>__block-item llms-choice type--text" id="choice-wrapper-<?php echo $choice->get( 'id' ); ?>">
            <div class="mdc-form-field">
                <div class="mdc-<?php echo $input_type; ?>">
                    <input class="mdc-<?php echo $input_type; ?>__native-control" id="choice-<?php echo $choice->get( 'id' ); ?>" name="question_<?php echo $question->get( 'id' ); ?>[]" type="<?php echo $input_type; ?>" value="<?php echo $choice->get( 'id' ); ?>">
                    <div class="mdc-<?php echo $input_type; ?>__background">
                        <?php if ($input_type == 'radio'): ?>
                        <div class="mdc-<?php echo $input_type; ?>__outer-circle"></div>
                        <div class="mdc-<?php echo $input_type; ?>__inner-circle"></div>
                        <?php elseif ($input_type == 'checkbox'): ?>
                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                            <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                        </svg>
                        <div class="mdc-checkbox__mixedmark"></div>
                        <?php endif; ?>
                    </div>
                </div>
                <label for="choice-<?php echo $choice->get( 'id' ); ?>"><?php echo $choice->get( 'choice' ); ?></label>
            </div>
        </div>

    <?php endforeach; ?>

    <div class="course__quiz-message course__quiz-message__true">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM11 17V15H13V17H11ZM11 7V13H13V7H11Z" fill="#008678"/>
        </svg>
        <p><?php _e('Good job! Keep it up', 'ndp'); ?></p>
    </div>
    <div class="course__quiz-message course__quiz-message__error">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 2C6.48 2 2 6.48 2 12C2 17.52 6.48 22 12 22C17.52 22 22 17.52 22 12C22 6.48 17.52 2 12 2ZM11 17V15H13V17H11ZM11 7V13H13V7H11Z" fill="#BA1A1A"/>
        </svg>
        <p><?php _e('Incorrect answer. Please try again.', 'ndp'); ?></p>
    </div>
</div>

<div class="<?php echo $blockType;?>__action">
    <div class="<?php echo $blockType;?>__buttons">
        <button class="quiz__buttons-check course__quiz--check__disable"><?php _e('Check Answer', 'ndp'); ?></button>
    </div>
</div>