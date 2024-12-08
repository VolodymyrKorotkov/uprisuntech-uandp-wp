<?php
/**
 * Scale Question Template
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
$i   = $question->get( 'scale_min' );
$max = $question->get( 'scale_max' );
?>

<div class="llms-aq-scale">

	<div class="llms-aq-scale-range">
		<?php while ( $i <= $max ) : ?>
			<label class="llms-aq-scale-radio" for="llms-scale-step-<?php echo $i; ?>">
				<input id="llms-scale-step-<?php echo $i; ?>" name="llms_aq_scale" type="radio" value="<?php echo $i; ?>">
				<span class="llms-aq-scale-button"><?php echo $i; ?></span>
			</label>
			<?php
			$i++;
endwhile;
		?>
	</div>

	<?php if ( $question->get( 'scale_min_label' ) ) : ?>
		<label class="llms-aq-scale-label label--min" for="llms-question-answer-<?php echo $question->get( 'id' ); ?>">
			<?php echo $question->get( 'scale_min_label' ); ?>
		</label>
	<?php endif; ?>

	<?php if ( $question->get( 'scale_max_label' ) ) : ?>
		<label class="llms-aq-scale-label label--max" for="llms-question-answer-<?php echo $question->get( 'id' ); ?>">
			<?php echo $question->get( 'scale_max_label' ); ?>
		</label>
	<?php endif; ?>
</div>
