<?php

namespace WPML\Import\Integrations\WooCommerce;

use function WPML\Container\make;

class HooksFactory implements \IWPML_Backend_Action_Loader, \IWPML_CLI_Action_Loader {

	/**
	 * @return \IWPML_Action[]
	 */
	public function create() {
		return [
			make( CommandHooks::class ),
			make( ExportHooks::class ),
		];
	}
}
