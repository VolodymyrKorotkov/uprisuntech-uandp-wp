<?php
/**
 * Picture choice question template.
 *
 * @package LifterLMS/Templates
 *
 * @since 3.16.0
 * @since 5.9.0 Use `llms-flex-cols` in favor of `llms-cols` for arranging choices in columns.
 * @version 3.16.0
 *
 * @var LLMS_Quiz_Attempt $attempt  Current quiz attempt object.
 * @var LLMS_Question     $question Question object.
 */

defined( 'ABSPATH' ) || exit;

$questionType = $question->get( 'question_type' );
$blockType = 'course__quiz-oneSelect';
$input_type = ( 'yes' === $question->get( 'multi_choices' ) ) ? 'checkbox' : 'radio';
if ($input_type == 'checkbox') {
    $blockType = 'course__quiz-multiSelect';
}
$choices    = $question->get_choices();
$cols       = llms_get_picture_choice_question_cols( count( $choices ) );
?>

<div class="<?php echo $blockType;?>__block llms-question-choices">
	<?php foreach ( $choices as $choice ) : ?>

        <div class="<?php echo $blockType;?>__block-item llms-choice type--picture" id="choice-wrapper-<?php echo $choice->get( 'id' ); ?>">
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
                <label for="choice-<?php echo $choice->get( 'id' ); ?>" class="label-picture"><?php echo $choice->get_image(); ?></label>
            </div>
        </div>

	<?php endforeach; ?>
</div>

