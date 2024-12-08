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

<div class="dashboard__certificates-block llms-certificates-loop listing-certificates">

    <?php foreach ( $certificates as $key => $certificate ) : ?>

        <?php
        $post = $certificate->get('post');
        if ($post->post_type == 'llms_my_certificate') {
            require get_template_directory() . '/lifterlms/certificates/loop-dashboard.php';
        } elseif ($post->post_type == 'custom_certificate') {
            require get_template_directory() . '/lifterlms/certificates/loop-dashboard-custom-certificate.php';
        }
        if ($key > 0) break;
        ?>

    <?php endforeach; ?>

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
