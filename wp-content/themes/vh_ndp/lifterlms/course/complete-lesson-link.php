<?php
/**
 * Lesson Progression actions
 * Mark Complete & Mark Incomplete buttons
 * Take Quiz Button when quiz attached
 *
 * @since 1.0.0
 * @since 3.33.0 Only render on lesson post types.
 * @version 3.33.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$lesson = llms_get_post( $post );
if ( ! $lesson || ! is_a( $lesson, 'LLMS_Lesson' ) ) {
	return;
}

if ( ! llms_is_user_enrolled( get_current_user_id(), $lesson->get( 'parent_course' ) ) && ! current_user_can( 'edit_post', $lesson->get( 'id' ) ) ) {
	return;
}

$student = llms_get_student( get_current_user_id() );
?>
<div class="clear"></div>
<div class="llms-lesson-button-wrapper course__quiz-start__buttons">

	<?php do_action( 'llms_before_lesson_buttons', $lesson, $student ); ?>

    <?php
    $course = $lesson->get_course();
    $is_complete = false;
    if (!empty($course)) {
        $is_complete = $student->is_complete( $course->get('id'), 'course' );
    }
    if ($is_complete):
        ?>
        <div class='course-training-page-left-box-completed'>
            <div class='course-training-page-left-box-completed-img'>
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                    <path d="M12.5002 20L17.5002 25L27.5002 15M36.6668 20C36.6668 29.2048 29.2049 36.6667 20.0002 36.6667C10.7954 36.6667 3.3335 29.2048 3.3335 20C3.3335 10.7953 10.7954 3.33337 20.0002 3.33337C29.2049 3.33337 36.6668 10.7953 36.6668 20Z" stroke="#2A59BD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class='course-training-page-left-box-completed-text'><?php _e('You have completed this course', 'ndp'); ?></div>
        </div>

        <?php
        $certificates = $student->get_certificates();
        $certificates = !empty($certificates)? $certificates : [];
        $courseCertificate = '';
        foreach ($certificates as $certificate) {
            $certificate = (array)$certificate;
            if (!empty($certificate['post_id']) && $certificate['post_id'] == $course->get('id')) {
                $courseCertificate = new LLMS_User_Certificate( $certificate['certificate_id'] );
                break;
            }
        }
        ?>
        <?php if (!empty($courseCertificate)): ?>
            <?php
            $template_id = $courseCertificate->post->post_parent;
            $certTitle = $courseCertificate->get('title');
            if (empty($certTitle)) {
                $certTitle = get_the_title($courseCertificate->post->post_parent);
            }
            $current_lang = apply_filters( 'wpml_current_language', 'uk');
            $companyFieldTitle = $current_lang == 'uk'? 'lms_certificate_company' : 'lms_certificate_company_'.$current_lang;
            $company_name = get_field($companyFieldTitle, $template_id);
            $description = get_field('lms_certificate_description', $template_id);
            $source = get_field('lms_certificate_source', $template_id);
            ?>
        <div class="course-training-page-certificate">
            <h2 class="course-training-page-certificate-title"><?php _e('Certificate received', 'ndp'); ?></h2>
            <div class="course-training-page-certificate-item">
                <div class="course-training-page-certificate-header">
                    <h2><?php echo $certTitle; ?></h2>
                    <div class="course-training-page-certificate-header-buttons">
                        <a href="<?php echo get_the_permalink($courseCertificate->get('id')) ?>" target="_blank" class="course-training-page-certificate-header-buttons__item">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/visibility.svg" alt="visibility-icon">
                        </a>
                    </div>
                </div>
                <?php
                $days = '';
                $granted = '';
                $certificate = getUserCertificate($student->get('id'), $course->get('id'));
                if ($certificate && is_a($certificate, 'LLMS_User_Certificate')) {
                    $expireDate = getCertificateExpiredDate($certificate);
                    $dueTo = sprintf( __( 'due to %s', 'ndp' ), $expireDate );
                    $expired = checkCertificateIsExpired($certificate);
                    $expireDays = getCertificateExpiredDays($certificate);
                    $granted = sprintf( __( 'Granted %s', 'ndp' ), $certificate->get_date( 'date', 'd.m.Y' ) );

                    $expireDate = date("d.m.y", strtotime($expireDate));
                    $tagClass = 'course-training-page-certificate-item-tag';
                    $expireStatus = '';
                    if (!$expired) {
                        $expireStatus = __('Valid', 'ndp');
                    } else {
                        $tagClass .= ' course-training-page-certificate-item-tag__expires';
                        $expireStatus = __('Expired', 'ndp');
                    }
                    if ($expireDays) {
                        $expireDays = (int)$expireDays;
                        if ($current_lang == 'uk') {
                            $days = declOfNum($expireDays, ['день', 'дні', 'днів']);
                        } else {
                            $days = sprintf( _n( '%s day', '%s days', $expireDays, 'ndp' ), $expireDays );
                        }
                    }
                }
                ?>
                <div class="course-training-page-certificate-item-status">
                    <span class="<?php echo $tagClass; ?>"><?php echo $expireStatus; ?></span>
                    <span class="course-training-page-certificate-item-date"><?php echo $dueTo; ?>,</span>
                    <span class="course-training-page-certificate-item-date"><?php echo $days; ?></span>
                    <div class="course-training-page-certificate-item-granted">
                        <span><?php echo $granted; ?>:</span>
                        <strong><?php echo $company_name; ?></strong>
                    </div>
                </div>
                <div class="course-training-page-certificate-item-description">
                    <p><?php echo $description; ?></p>
                </div>
                <div class="course-training-page-certificate-item-sourse">
                    <span><?php _e('Sourse', 'ndp'); ?>:</span>
                    <strong><?php echo $source; ?></strong>
                </div>
                <div class="course-training-page-certificate-item-footer">
                    <a href="<?php echo get_the_permalink($course->get('id')); ?>" class="cert-link"><?php echo $course->get('title'); ?></a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    <?php endif;//course complete ?>


	<?php if ( $student->is_complete( $lesson->get( 'id' ), 'lesson' ) ) : ?>

		<?php if ( llms_show_mark_complete_button( $lesson ) ) : ?>
            <?php do_action( 'llms_after_lesson_complete_text', $lesson ); ?>


			<?php if ( 'yes' === get_option( 'lifterlms_retake_lessons', 'no' ) || apply_filters( 'lifterlms_retake_lesson_' . $lesson->get( 'parent_course' ), false ) ) : ?>

				<form action="" class="llms-incomplete-lesson-form" method="POST" name="mark_incomplete">

					<?php do_action( 'lifterlms_before_mark_incomplete_lesson' ); ?>

					<input type="hidden" name="mark-incomplete" value="<?php echo esc_attr( $lesson->get( 'id' ) ); ?>" />
					<input type="hidden" name="action" value="mark_incomplete" />
					<?php wp_nonce_field( 'mark_incomplete' ); ?>

					<?php
					llms_form_field(
						array(
							'columns'     => 12,
							'classes'     => 'llms-button-secondary auto button',
							'id'          => 'llms_mark_incomplete',
							'value'       => apply_filters( 'lifterlms_mark_lesson_incomplete_button_text', __( 'Mark Incomplete', 'lifterlms' ), $lesson ),
							'last_column' => true,
							'name'        => 'mark_incomplete',
							'required'    => false,
							'type'        => 'submit',
						)
					);
					?>

					<?php do_action( 'lifterlms_after_mark_incomplete_lesson' ); ?>

				</form>

			<?php endif; ?>

		<?php endif; ?>

	<?php else : ?>

		<?php if ( llms_show_mark_complete_button( $lesson ) ) : ?>

			<form action="" class="llms-complete-lesson-form" method="POST" name="mark_complete">

				<?php do_action( 'lifterlms_before_mark_complete_lesson' ); ?>

				<input type="hidden" name="mark-complete" value="<?php echo esc_attr( $lesson->get( 'id' ) ); ?>" />
				<input type="hidden" name="action" value="mark_complete" />
				<?php wp_nonce_field( 'mark_complete' ); ?>

				<?php
				llms_form_field(
					array(
						'columns'     => 12,
						'classes'     => 'llms-button-primary auto button',
						'id'          => 'llms_mark_complete',
						'value'       => apply_filters( 'lifterlms_mark_lesson_complete_button_text', __( 'Mark Complete', 'lifterlms' ), $lesson ),
						'last_column' => true,
						'name'        => 'mark_complete',
						'required'    => false,
						'type'        => 'submit',
					)
				);
				?>

				<?php do_action( 'lifterlms_after_mark_complete_lesson' ); ?>

			</form>

		<?php endif; ?>

	<?php endif; ?>

	<?php if ( llms_show_take_quiz_button( $lesson ) ) : ?>

		<?php do_action( 'llms_before_start_quiz_button' ); ?>

		<a class="llms-button-action auto button course__quiz-start__buttons-action" id="llms_start_quiz" href="<?php echo get_permalink( $lesson->get( 'quiz' ) ); ?>">
			<?php echo apply_filters( 'lifterlms_start_quiz_button_text', __( 'Take Quiz', 'lifterlms' ), $lesson->get( 'quiz' ), $lesson ); ?>
		</a>

		<?php do_action( 'llms_after_start_quiz_button' ); ?>

	<?php endif; ?>

	<?php do_action( 'llms_after_lesson_buttons', $lesson, $student ); ?>

</div>
