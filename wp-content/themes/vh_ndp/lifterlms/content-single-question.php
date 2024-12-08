<?php
/**
 * Single Question Template
 *
 * @since    1.0.0
 * @version 3.16.0
 *
 * @arg  $attempt  (obj)  LLMS_Quiz_Attempt instance
 * @arg  $question (obj)  LLMS_Question instance
 */

defined( 'ABSPATH' ) || exit;

/**
 * lifterlms_single_question_before_summary
 *
 * @hooked lifterlms_template_question_wrapper_start - 10
 */
do_action( 'lifterlms_single_question_before_summary', $args ); ?>

    <h2 class="course__quiz-oneSelect__title"><?php echo $question->get_question(); ?></h2>

	<?php
		/**
		 * lifterlms_single_question_content
		 *
		 * @hooked lifterlms_template_question_description - 10
		 * @hooked lifterlms_template_question_image - 20
		 * @hooked lifterlms_template_question_video - 30
		 * @hooked lifterlms_template_question_content - 40
		 */
		do_action( 'lifterlms_single_question_content', $args );
	?>

    <?php
    $translatesArray = [
        'must_answer' => __('You must provide an answer to continue', 'lifterlms-advanced-quizzes'),
        'fill_in' => __('Fill in the blank to continue.', 'lifterlms-advanced-quizzes'),
        'fill_in_all' => __('Fill in all the blanks to continue.', 'lifterlms-advanced-quizzes'),
        'upload_file' => __('You must upload a file to proceed', 'lifterlms-advanced-quizzes'),
    ];
    ?>
    <script>
        var translatesArray = JSON.parse( '<?php echo wp_json_encode( $translatesArray ); ?>' );
    </script>

<?php
/**
 * lifterlms_single_question_after_summary
 *
 * @hooked lifterlms_template_question_wrapper_end - 10
 */
do_action( 'lifterlms_single_question_after_summary', $args );
