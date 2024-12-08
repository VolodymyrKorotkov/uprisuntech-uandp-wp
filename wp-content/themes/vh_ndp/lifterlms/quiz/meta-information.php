<?php
/**
 * Single Quiz: Meta Information
 *
 * @package LifterLMS/Templates
 *
 * @since 3.9.0
 * @since 4.0.0 Unknown.
 * @since 4.17.0 Return early if accessed without a logged in user or the quiz can't be loaded from the `$post` global.
 * @version 4.17.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$student = llms_get_student();
if ( ! $student ) {
	return;
}

$quiz = llms_get_post( $post );
if ( ! $quiz ) {
	return;
}
$passing_percent = $quiz->get( 'passing_percent' );
?>

<div class="course__quiz-item course__quiz-start">
    <h2 class="course__quiz-start__title"><?php the_title(); ?></h2>
    <p class="course__quiz-start__subtitle"><?php _e( 'Information', 'ndp' ); ?></p>
    <div class="course__quiz-start__block">
        <?php if ( $passing_percent ) : ?>
        <div class="course__quiz-start__block-item">
            <?php printf( '<span>' . __( 'Minimum Passing Grade', 'ndp' ).'</span><strong>%s</strong>', '<span class="llms-pass-perc">' . $passing_percent . '%</span>' ); ?>
        </div>
        <?php endif; ?>

        <div class="course__quiz-start__block-item">
            <?php printf( '<span>'. __( 'Remaining Attempts', 'ndp' ).'</span><strong>%s</strong>', '<span class="llms-attempts">' . $student->quizzes()->get_attempts_remaining_for_quiz( $quiz->get( 'id' ) ) . '</span>' ); ?>
        </div>
        <div class="course__quiz-start__block-item">
            <?php printf( '<span>'. __( 'Questions', 'ndp' ).'</span><strong>%s</strong>', '<span class="llms-question-count">' . count( $quiz->get_questions( 'ids' ) ) . '</span>' ); ?>
        </div>
        <?php if ( $quiz->has_time_limit() ) : ?>
        <div class="course__quiz-start__block-item">
            <?php printf( '<span>'. __( 'Time Limit', 'ndp' ).'</span><strong>%s</strong>', '<span class="llms-time-limit">' . $quiz->get_time_limit_string() . '</span>' ); ?>
        </div>
        <?php endif; ?>
    </div>

    <?php
    lifterlms_template_quiz_results_list();

    lifterlms_template_start_button();
    ?>
</div>