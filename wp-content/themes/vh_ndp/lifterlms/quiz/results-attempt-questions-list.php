<?php
/**
 * List of attempt questions/answers for a single attempt
 *
 * @since 3.16.0
 * @since 3.17.8 Unknown.
 * @since 5.3.0 Display removed questions too.
 * @since 7.3.0 Script moved into the main llms.js.
 * @version 7.3.0
 *
 * @param LLMS_Quiz_Attempt $attempt LLMS_Quiz_Attempt instance.
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="course__quiz-result__block">
<?php
foreach ( $attempt->get_question_objects() as $attempt_question ) :
	$quiz_question = $attempt_question->get_question();

	if ( ! $quiz_question ) { // Question missing/deleted.
		?>
        <div class="course__quiz-result__block-item llms-quiz-attempt-question type--removed status--<?php echo $attempt_question->get_status(); ?> <?php echo $attempt_question->is_correct() ? 'correct' : 'incorrect'; ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.6 7.6L18 9L10 17L6 13L7.4 11.6L10 14.2L16.6 7.6Z" fill="#008678"/>
            </svg>
            <div class="course__quiz-result__block-item__text">
                <h3 class="course__quiz-result__block-item__title"><?php esc_html_e( 'This question has been deleted', 'ndp' ); ?></h3>
                <span class="course__quiz-result__block-item__points">
                    <?php printf( __( '%1$d / %2$d points', 'ndp' ), $attempt_question->get( 'earned' ), $attempt_question->get( 'points' ) ); ?>
                </span>
            </div>
        </div>
		<?php
		continue;
	}
	?>
<?php
    $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="quiz-icon">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.6 7.6L18 9L10 17L6 13L7.4 11.6L10 14.2L16.6 7.6Z" fill="#008678"/>
        </svg>';
    $incorrect = '';
    if (!$attempt_question->is_correct()) {
        $incorrect = 'course__quiz-result__block-item__incorrect';
        $icon = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" class="quiz-icon">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 21C16.9706 21 21 16.9706 21 12C21 7.02944 16.9706 3 12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21ZM16.59 6L18 7.41L13.41 12L18 16.59L16.59 18L12 13.41L7.41 18L6 16.59L10.59 12L6 7.41L7.41 6L12 10.59L16.59 6Z" fill="#BA1A1A"/>
              </svg>';
    }
?>
    <div class="course__quiz-result__block-item <?php echo $incorrect; ?> llms-quiz-attempt-question type--<?php echo $quiz_question->get( 'question_type' ); ?> status--<?php echo $attempt_question->get_status(); ?> <?php echo $attempt_question->is_correct() ? 'correct' : 'incorrect'; ?>"
         data-question-id="<?php echo $quiz_question->get( 'id' ); ?>"
         data-grading-manual="<?php echo $attempt_question->can_be_manually_graded() ? 'yes' : 'no'; ?>"
         data-points="<?php echo $attempt_question->get( 'points' ); ?>"
         data-points-curr="<?php echo $attempt_question->get( 'earned' ); ?>">
        <?php echo $icon; ?>
        <div class="course__quiz-result__block-item__text">
            <h3 class="course__quiz-result__block-item__title"><?php echo $quiz_question->get_question( 'plain' ); ?></h3>
            <?php if ( $quiz_question->get( 'points' ) ) : ?>
                <span class="course__quiz-result__block-item__points">
                    <?php printf( __( '%1$d / %2$d points', 'ndp' ), $attempt_question->get( 'earned' ), $attempt_question->get( 'points' ) ); ?>
                </span>
            <?php endif; ?>

            <div class="course__quiz-result__block-item__details">
                <?php if ( apply_filters( 'llms_quiz_show_question_description', true, $attempt, $attempt_question, $quiz_question ) && $quiz_question->has_description() ) : ?>
                    <div class="llms-quiz-attempt-answer-section llms-question-description">
                        <?php echo $quiz_question->get_description(); ?>
                    </div>
                <?php endif; ?>

                <?php if ( $attempt_question->get( 'answer' ) ) : ?>
                    <div class="course__quiz-result__block-item__details-selected llms-student-answer">
                        <span><?php _e( 'Selected answer: ', 'ndp' ); ?></span>
                        <strong><?php echo $attempt_question->get_answer(); ?></strong>
                    </div>
                <?php endif; ?>

                <?php if ( ! $attempt_question->is_correct() ) : ?>
                    <?php if ( llms_parse_bool( $quiz_question->get_quiz()->get( 'show_correct_answer' ) ) ) : ?>
                        <?php if ( in_array( $quiz_question->get_auto_grade_type(), array( 'choices', 'conditional' ) ) ) : ?>
                            <div class="course__quiz-result__block-item__details-correct">
                                <span><?php _e( 'Correct answer: ', 'ndp' ); ?></span>
                                <strong><?php echo $attempt_question->get_correct_answer(); ?></strong>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ( llms_parse_bool( $quiz_question->get( 'clarifications_enabled' ) ) ) : ?>
                        <div class="course__quiz-result__block-item__details-correct llms-quiz-attempt-answer-section llms-clarifications">
                            <p class="llms-quiz-results-label clarification"><?php _e( 'Clarification: ', 'lifterlms' ); ?></p>
                            <?php echo $quiz_question->get( 'clarifications' ); ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ( $attempt_question->has_remarks() ) : ?>
                    <div class="course__quiz-result__block-item__details-correct llms-quiz-attempt-answer-section llms-remarks">
                        <p class="llms-quiz-results-label remarks"><?php _e( 'Instructor remarks: ', 'lifterlms' ); ?></p>
                        <div class="llms-remarks"><?php echo wpautop( $attempt_question->get( 'remarks' ) ); ?></div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

<?php endforeach; ?>
</div>

