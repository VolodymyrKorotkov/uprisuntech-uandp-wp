<?php
/**
 * Quiz Start & Next lesson buttons
 *
 * @since 1.0.0
 * @since 3.25.0 Unknown.
 * @since 4.17.0 Early bail on orphan quiz.
 */

defined( 'ABSPATH' ) || exit;

global $post;
$quiz   = llms_get_post( $post );
$lesson = $quiz->get_lesson();
$course = $lesson->get_course();
$isSurvey = false;
if ($course) {
    $isSurvey = get_post_meta($course->get('id'), 'type', true);
}

if ( ! $lesson || ! is_a( $lesson, 'LLMS_Lesson' ) ) {
	return;
}
?>

<div class="course__quiz-start__buttons llms-quiz-buttons llms-button-wrapper course__quiz-start__buttons" id="quiz-start-button">

	<?php
		/**
		 * Fired before the start quiz button
		 *
		 * @since Unknown
		 */
		do_action( 'lifterlms_before_start_quiz' );
	?>

	<?php if ( $quiz ) : ?>

		<form method="POST" action="" name="llms_start_quiz" enctype="multipart/form-data">

			<?php if ( $quiz->is_open() ) : ?>

				<input id="llms-lesson-id" name="llms_lesson_id" type="hidden" value="<?php echo $lesson->get( 'id' ); ?>"/>
				<input id="llms-quiz-id" name="llms_quiz_id" type="hidden" value="<?php echo $quiz->get( 'id' ); ?>"/>

				<input type="hidden" name="action" value="llms_start_quiz" />

				<?php wp_nonce_field( 'llms_start_quiz' ); ?>

				<button class="llms-start-quiz-button llms-button-action button course__quiz-start__buttons-action" id="llms_start_quiz" name="llms_start_quiz" type="submit">
					<?php
						/**
						 * Filters the quiz button text
						 *
						 * @since Unknown
						 *
						 * @param string      $button_text The start quiz button text.
						 * @param LLMS_Quiz   $quiz        The current quiz instance.
						 * @param LLMS_Lesson $lesson      The parent lesson instance.
						 */
                    if (!$isSurvey) {
                        echo apply_filters( 'lifterlms_begin_quiz_button_text', __( 'Start Quiz', 'lifterlms' ), $quiz, $lesson );
                    } else {
                        echo __('Start', 'ndp');
                    }
					?>
				</button>

			<?php else : ?>
				<p><?php _e( 'You are not able to take this quiz', 'lifterlms' ); ?></p>
			<?php endif; ?>

      <?php
      $lessons = $course->get_lessons();
      foreach ($lessons as $k => $_lesson) {
          if ($lesson->get('id') == $_lesson->get('id')) {
              break;
          }
      }
      if ($lessons && !empty($lessons[$k+1])) {
          $nextLesson = $lessons[$k+1];
      }
      ?>
          <?php if (!$isSurvey): ?>
            <?php if ( $lesson->get_next_lesson() && llms_is_complete( get_current_user_id(), $lesson->get( 'id' ), 'lesson' ) ) : ?>
              <a href="<?php echo get_permalink( $lesson->get_next_lesson() ); ?>" class="course__quiz-start__buttons-skip llms-next-lesson"><?php _e( 'Next', 'ndp' ); ?></a>
            <?php endif; ?>
          <?php else: ?>
            <?php
            if (!empty($nextLesson) && $k < count($lessons)) { ?>
                <a href="<?php echo get_permalink( $nextLesson->get('id')); ?>" class="course__quiz-start__buttons-skip llms-next-lesson"><?php _e( 'Next', 'ndp' ); ?></a>
            <?php }
            ?>
              <a href="<?php echo get_permalink( $course->get('id')); ?>" class="button button-finish-survey"><?php _e( 'Finish survey', 'ndp' ); ?></a>
          <?php endif; ?>
		</form>

	<?php else : ?>

		<p><?php _e( 'You are not able to take this quiz', 'lifterlms' ); ?></p>

	<?php endif; ?>

	<?php
		/**
		 * Fired after the start quiz button
		 *
		 * @since Unknown
		 */
		do_action( 'lifterlms_after_start_quiz' );
	?>

</div>
