<?php

namespace WPML\Import\Integrations\Base;

use WPML\LIB\WP\Hooks;
use function WPML\FP\spreadArgs;
use WPML\Import\Helper\PostTypes;
use WPML\Import\Integrations\Base\Fields;

class ExportPostsHooks extends ExportObjectsHooks {
	use Fields;

	const META_TYPE = 'post';

	/**
	 * @var \SitePress $sitepress
	 */
	private $sitepress;

	/**
	 * @var PostTypes
	 */
	private $postTypes;

	public function __construct(
		\SitePress $sitepress,
		PostTypes $postTypes
	) {
		$this->sitepress = $sitepress;
		$this->postTypes = $postTypes;
	}

	/**
	 * @return string
	 */
	protected function getMetaType() {
		return self::META_TYPE;
	}

	/**
	 * @param  int $objectId
	 *
	 * @return \stdClass|null
	 */
	protected function getElementLanguageDetails( $objectId ) {
		$postType = get_post_type( $objectId );

		if ( ! $this->postTypes->isTranslatable( $postType ) ) {
			return null;
		}

		$element = $this->sitepress->get_element_language_details( $objectId, 'post_' . $postType );
		if ( ! $element ) {
			return null;
		}

		return $element;
	}

}
