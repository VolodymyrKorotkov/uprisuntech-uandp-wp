<?php
/**
 * Certificates Loop
 *
 * @package LifterLMS/Templates/Certificates
 *
 * @since 3.14.0
 * @since 6.0.0 Add pagination.
 * @version 3.14.0
 *
 * @param LLMS_User_Certificate[] $certificates Array of certificates to display.
 * @param int                     $cols         Number of columns.
 * @param false|array             $pagination   Pagination arguments to pass to {@see llms_paginate_links()} or `false`
 *                                              when pagination is disabled.
 */

defined( 'ABSPATH' ) || exit;
?>

<?php
	/**
	 * Action run prior to the certificate loop template.
	 *
	 * @since 3.14.0
	 */
	do_action( 'llms_before_certificate_loop' );
?>

<?php if ( $certificates ) : ?>

		<?php foreach ( $certificates as $certificate ) : ?>

        <?php
        $post = $certificate->get('post');
        if ($post->post_type == 'llms_my_certificate') {
            require get_template_directory() . '/lifterlms/certificates/loop-certificate.php';
        } elseif ($post->post_type == 'custom_certificate') {
            require get_template_directory() . '/lifterlms/certificates/loop-custom-certificate.php';
        }
        ?>

		<?php endforeach; ?>

    <div class="profile-settings__modal modal__delete-cert" id="modal__delete-cert">
        <div class="profile-settings__modal-item">
            <button class="profile-settings__modal-close"></button>
            <h2 class="profile-settings__modal-title"><?php _e('Delete certificates', 'ndp'); ?></h2>
            <span class="profile-settings__modal-subtitle"><?php _e('Are you sure you want to delete the certificate?', 'ndp'); ?></span>

            <div class="profile-settings__modal-buttons">
                <button class="profile-settings__modal-cancel"><?php _e('Cancel', 'ndp'); ?></button>
                <button class="profile-settings__modal-confirm btn-delete-cert"><?php _e('Yes, delete', 'ndp'); ?></button>
            </div>
        </div>
    </div>

<?php else : ?>

	<p>
	<?php
		/**
		 * Filters the message displayed when the student hasn't earned any certificates.
		 *
		 * @since 3.14.0
		 *
		 * @param string $message The message text.
		 */
		echo apply_filters( 'lifterlms_no_certificates_text', __( 'You do not have any certificates yet.', 'lifterlms' ) );
	?>
	</p>

<?php endif; ?>

<?php if ( $pagination ) : ?>
	<?php echo llms_paginate_links( $pagination ); ?>
<?php endif; ?>

<?php
	/**
	 * Action run after to the certificate loop template.
	 *
	 * @since 3.14.0
	 */
	do_action( 'llms_after_certificate_loop' );
?>
