<?php

namespace WPML\Import\Commands\Base;

use WPML\Collect\Support\Collection;

interface Command {

	/**
	 * @return string
	 */
	public static function getTitle();

	/**
	 * @return string
	 */
	public static function getDescription();

	/**
	 * @return int
	 */
	public function countPendingItems();

	/**
	 * @param Collection|null $args
	 *
	 * @return int Number of processed items.
	 */
	public function run( Collection $args = null );
}
