<?php
/**
 * Import & Export LLMS Content
 *
 * @since 3.3.0
 * @version 4.8.0
 */

defined( 'ABSPATH' ) || exit;

$courses = LLMS_Export_API::list();
?>

<div class="wrap lifterlms lifterlms-settings llms-import-export">

	<div class="llms-inside-wrap">

		<div class="llms-setting-group top">
			<div class="llms-label">
				<?php _e( 'Import Courses', 'lifterlms' ); ?>
				<button class="llms-button-primary small" role="button"><?php _e( 'Upload', 'lifterlms' ); ?></button>
			</div>

			<hr class="wp-header-end">

			<div class="llms-widget" style="display: none;" id="llms-import-uploader">

				<form action="" enctype="multipart/form-data" method="POST">

					<table class="form-table">

						<tr>
							<th><label for="llms-import-file"><?php _e( 'Import Course(s)', 'lifterlms' ); ?></label></th>
							<td>
								<p><?php _e( 'Upload export files generated by LifterLMS. Must be a ".json" file.', 'lifterlms' ); ?></p>
								<div class="llms-import-file-wrap">
									<input accept="application/json" name="llms_import" id="llms-import-file" type="file">
									<button class="button" id="llms-import-file-submit" type="submit"><?php _e( 'Import', 'lifterlms' ); ?></button>
								</div>
							</td>
						</tr>

						<?php
							/**
							 * Fires after core importer(s) on the "Import screen".
							 *
							 * Allows 3rd parties to add their own importers to the table.
							 *
							 * @since 3.3.0
							 */
							do_action( 'lifterlms_importer_tr' );
						?>

					</table>

					<?php wp_nonce_field( 'llms-importer', 'llms_importer_nonce' ); ?>

				</form>

			</div>

			<p>
				<?php
					// Translators: %s = anchor link HTML to LifterLMS.com.
					printf( __( 'Download and import courses, templates, and more from %s.', 'lifterlms' ), '<a href="https://lifterlms.com" target="_blank">LifterLMS.com</a>' );
				?>
				<button class="llms-cloud-import-help button-link" type="button" title="<?php esc_attr_e( 'Help', 'lifterlms' ); ?>">
					<span class="screen-reader-text"><?php _e( 'Help', 'lifterlms' ); ?></span>
					<span class="dashicons dashicons-editor-help"></span>
				</button>
			</p>

			<form action="" method="POST">
				<?php require LLMS_PLUGIN_DIR . 'includes/admin/views/importable-courses.php'; ?>
				<?php wp_nonce_field( 'llms-cloud-importer', 'llms_cloud_importer_nonce' ); ?>
			</form>
		</div>

	</div>

</div>

<script>
( function() {
	document.querySelector( '.llms-button-primary' ).addEventListener( 'click', function() {
		const el = document.getElementById( 'llms-import-uploader' );
		el.style.display = 'none' === el.style.display ? 'block' : 'none';
	} );
	document.querySelector( '.llms-cloud-import-help' ).addEventListener( 'click', function( e ) {
		document.getElementById( 'contextual-help-link' ).click();
	} );
} )();
</script>