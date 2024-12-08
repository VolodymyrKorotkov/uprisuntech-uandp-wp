<?php // phpcs:ignore

namespace WPML\Import\Integrations\WPImportExport;

use function WPML\Container\make;
use WPML\FP\Obj;

class HooksFactory implements \IWPML_Backend_Action_Loader, \IWPML_CLI_Action_Loader {

	/**
	 * @return \IWPML_Action[]|null
	 */
	public function create() {
		$hooks = [];

		if ( self::isExporting() ) {
			$hooks[] = make( \WPML\Import\Integrations\Base\ExportPostsHooks::class );
			$hooks[] = make( \WPML\Import\Integrations\Base\ExportTermsHooks::class );
		}

		$hooks[] = make( PrepareFieldsHooks::class );

		return $hooks;
	}

	/**
	 * @return bool
	 */
	private static function isExporting() {
		if (
			defined( 'DOING_AJAX' )
			&& DOING_AJAX
			&& 'wpie_export_update_data' === Obj::prop( 'action', $_GET )
		) {
			return true;
		}

		return false;
	}
}
