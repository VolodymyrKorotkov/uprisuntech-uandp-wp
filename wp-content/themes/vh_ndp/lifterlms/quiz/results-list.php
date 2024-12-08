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


if ( ! $attempts ) {
	return;
}
?>


<?php if ( $attempts ) : ?>
    <div class="course__quiz-start__previous">
        <h3 class="course__quiz-start__previous-title"><?php _e( 'View Previous Attempts', 'ndp' ); ?></h3>
        <div class="course__quiz-start__previous-wrapper">
            <input type="text" id="attempt" class="course__quiz-start__previous-input">
            <label for="attempt" class="course__quiz-start__previous-label"><?php _e( 'Select an Attempt', 'ndp' ); ?></label>
            <div class="course__quiz-start__previous-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow-dropdown.svg" alt="arrow">
            </div>

            <ul class="course__quiz-start__previous-list" id="llms-quiz-attempt-select">
                <li class="course__quiz-start__previous-list__item course__quiz-start__previous-list__item-current"><?php _e( 'Select an Attempt', 'ndp' ); ?></li>
                <?php foreach ( $attempts as $attempt ) : ?>
                    <li data-value="<?php echo esc_url( $attempt->get_permalink() ); ?>" class="course__quiz-start__previous-list__item">
                        <?php
                        // Translators: %1$d = Attempt number; %2$s = Grade percentage; %3$s = Pass/fail text.
                        $grade = round( $attempt->get( 'grade' ), 2 );
                        $status = $attempt->l10n( 'status' );
                        if ((int)$grade === 0) {
                            $status = __('Fail', 'ndp');
                        } elseif ((int)$grade > 0 && (int)$grade < 100) {
                            $status = __('Unfinished', 'ndp');
                        }
                        ?>
                        <?php printf( __( 'Attempt #%1$d - %2$s (%3$s)', 'lifterlms' ), $attempt->get( 'attempt' ), $grade . '%', $status ); ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>

