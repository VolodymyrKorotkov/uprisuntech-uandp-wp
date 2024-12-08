<?php
/**
 * Quiz Single Attempt Results
 *
 * @since    3.16.0
 * @version  3.27.0
 *
 * @arg  $attempt  (obj)  LLMS_Quiz_Attempt instance
 */
defined( 'ABSPATH' ) || exit;

if ( ! $attempt ) {
	return;
}
$donut_class = $attempt->get( 'status' );
if ( in_array( $donut_class, array( 'pass', 'fail' ) ) ) {
	$donut_class .= 'ing';
}

global $post;
$quiz   = llms_get_post( $post );
//$timeLimit = $quiz->has_time_limit();

$quiz = $attempt->get_quiz();
$course = $quiz->get_course();
$isSurvey = false;
if ($course) {
    $isSurvey = get_post_meta($course->get('id'), 'type', true);
}
echo '<div class="test1 session" style="display:none"><pre>';
var_export($_SESSION);
echo '</pre></div>';
?>

<div class="course__quiz-item course__quiz-result <?php if ($isSurvey) echo 'survey-result'; ?>">
    <?php
    $title = 'Survey results';
    if (!$isSurvey): ?>
    <h2 class="course__quiz-result__title"><?php printf( __( 'Attempt #%d Results', 'ndp' ), $attempt->get( 'attempt' ) ); ?></h2>
    <?php else: ?>
    <h2 class="course__quiz-result__title"><?php _e('Survey results', 'ndp'); ?></h2>
    <?php endif; ?>
    <div class="course__quiz-result__info">
        <?php if ( $attempt->get_count( 'available_points' ) ) : ?>
            <?php
            $percentage = round( $attempt->get( 'grade' ), 0 );
            $color = '#008678';
            $status = $attempt->get( 'status' ) ?? '';
            $resultClass = 'course__quiz-result__pass';
            if ($status && $status == 'fail') {
                $color = '#BA1A1A';
                $resultClass = 'course__quiz-result__fail';
            }
            ?>
            <div class="course__quiz-result__circular-progress" data-inner-circle-color="white" data-percentage="<?php echo $percentage; ?>" data-progress-color="<?php echo $color; ?>" data-bg-color="#DCE2F9">
                <div class="course__quiz-result__inner-circle"></div>
                <p class="percentage">0%</p>
                <p class="<?php echo $resultClass; ?>"><?php echo $attempt->l10n( 'status' ); ?></p>
            </div>
        <?php endif; ?>

        <div class="course__quiz-result__info-text">
            <?php
            $showTime = true;
            $test = $attempt->get_date( 'end' );
            ?>
            <?php if ( $attempt->get_count( 'gradeable_questions' ) ) : ?>
                <?php
                $correct_answers = $attempt->get_count( 'correct_answers' );
                $gradeable_questions = $attempt->get_count( 'gradeable_questions' );
                if ((int)$correct_answers != (int)$gradeable_questions) {
                    $showTime = false;
                }
                ?>
                <div class="course__quiz-result__info-text__item">
                    <?php printf( '<span>'. __( 'Correct Answers', 'lifterlms' ) . '</span><strong>%1$d / %2$d</strong>', $correct_answers, $gradeable_questions ); ?>
                </div>
            <?php endif; ?>
            <div class="course__quiz-result__info-text__item">
                <?php printf('<span>'. __( 'Completed', 'lifterlms' ) . '</span><strong>%s</strong>', $attempt->get_date( 'end' ) ); ?>
            </div>
            <?php if ($showTime): ?>
            <?php
                $time = $attempt->get_time();
                $time = preg_replace(['/година/','/хвилина/','/секунда/','/годин/','/хвилин/','/секунд/'], ['год.','хв.','сек.','год.','хв.','сек.'], $time);
            ?>
            <div class="course__quiz-result__info-text__item">
                <?php printf( __( '<span>'. 'Total time', 'lifterlms' ) . '</span><strong>%s</strong>', $time ); ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php
    /**
     * llms_single_quiz_attempt_results_main
     *
     * @hooked lifterlms_template_quiz_attempt_results_questions_list - 10
     */
    do_action( 'llms_single_quiz_attempt_results_main', $attempt );
    ?>

    <?php
    lifterlms_template_quiz_results_list();

    $lesson = $quiz->get_lesson();
    if ( $lesson && is_a( $lesson, 'LLMS_Lesson' ) ) {
        lifterlms_template_start_button();
    }
    ?>
</div>

