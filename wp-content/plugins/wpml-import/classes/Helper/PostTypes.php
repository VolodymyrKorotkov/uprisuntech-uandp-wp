<?php

namespace WPML\Import\Helper;

class PostTypes {

	/**
	 * @return string[]
	 */
	public static function getTranslatable() {
		/** @var \SitePress $sitepress */
		global $sitepress;

		return wpml_collect( $sitepress->get_translatable_documents() )
			->keys()
			->toArray();
	}

	/**
	 * @param  string $postType
	 *
	 * @return bool
	 */
	public static function isTranslatable( $postType ) {
		return in_array( $postType, self::getTranslatable(), true );
	}
}