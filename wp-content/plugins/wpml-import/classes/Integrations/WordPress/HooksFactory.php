<?php

namespace WPML\Import\Integrations\WordPress;

use WPML\FP\Str;
use function WPML\Container\make;

class HooksFactory implements \IWPML_Backend_Action_Loader, \IWPML_CLI_Action_Loader {

	/**
	 * @return \IWPML_Action[]|null
	 */
	public function create() {
		$hooks = [];

		if ( self::isExportingWithCli() || self::isExportingWithGui() ) {
			$hooks[] = make( ExportPostsHooks::class );
			$hooks[] = make( ExportTermsHooks::class );
		}

		return $hooks;
	}

	/**
	 * @return bool
	 */
	private static function isExportingWithCli() {
		if ( defined( 'WP_CLI' ) && isset( $_SERVER['argv'] ) ) {
			/** @var \Closure(string):bool $isCommandParam */
			$isCommandParam = Str::startsWith( '-' );

			$cliCommand = wpml_collect( (array) $_SERVER['argv'] )
				->forget( [ 0 ] ) // CLI process path.
				->reject( $isCommandParam )
				->first();

			return 'export' === $cliCommand;
		}

		return false;
	}

	/**
	 * @return bool
	 */
	private static function isExportingWithGui() {
		if ( ! isset( $_SERVER['QUERY_STRING'] ) ) {
			return false;
		}

		if ( ! isset( $_SERVER['HTTP_REFERER'] ) ) {
			return false;
		}

		$queryArgs = [];
		wp_parse_str( $_SERVER['QUERY_STRING'], $queryArgs );
		if ( ! array_key_exists( 'download', $queryArgs ) ) {
			return false;
		}

		if ( admin_url( 'export.php' ) !== $_SERVER['HTTP_REFERER'] ) {
			return false;
		}

		return true;
	}
}
