<?php

namespace WPML\Import\Integrations\WordPress;

use WPML\LIB\WP\Hooks;
use WPML\FP\Str;
use function WPML\FP\spreadArgs;
use WPML\Import\Helper\PostTypes;
use WPML\Import\Integrations\Base\Fields;

class ExportPostsHooks implements \IWPML_Backend_Action, \IWPML_DIC_Action {
	use Fields;

	/**
	 * @var \wpdb $wpdb
	 */
	protected $wpdb;

	/**
	 * @var \SitePress $sitepress
	 */
	private $sitepress;

	/**
	 * @var PostTypes
	 */
	private $postTypes;

	/**
	 * @var array $idsToCleanup
	 */
	private $idsToCleanup = [];

	public function __construct(
		\wpdb $wpdb,
		\SitePress $sitepress,
		PostTypes $postTypes
	) {
		$this->wpdb      = $wpdb;
		$this->sitepress = $sitepress;
		$this->postTypes = $postTypes;
	}

	public function add_hooks() {
		Hooks::onAction( 'the_post' )->then( spreadArgs( [ $this, 'setMetaFields' ] ) );
	}

	/**
	 * @param \WP_Post $post
	 */
	public function setMetaFields( $post ) {
		if ( ! $this->postTypes->isTranslatable( $post->post_type ) ) {
			return;
		}
		// phpcs:disable WordPress.WP.PreparedSQL.NotPrepared
		// phpcs:disable Squiz.Strings.DoubleQuoteUsage.NotRequired
		$exportFields = $this->getImportFields();
		$existingKeys = $this->wpdb->get_col(
			$this->wpdb->prepare(
				"SELECT DISTINCT meta_key 
				FROM {$this->wpdb->postmeta} 
				WHERE post_id = %d 
				AND meta_key IN (" . wpml_prepare_in( $exportFields ) . ") 
				LIMIT 4",
				$post->ID
			)
		);
		$missingKeys  = array_diff(
			$exportFields,
			$existingKeys
		);
		// phpcs:enable WordPress.WP.PreparedSQL.NotPrepared
		// phpcs:enable Squiz.Strings.DoubleQuoteUsage.NotRequired

		if ( empty( $missingKeys ) ) {
			return;
		}

		$element = $this->sitepress->get_element_language_details( $post->ID, 'post_' . $post->post_type );
		if ( ! $element ) {
			return;
		}

		array_walk(
			$missingKeys,
			function( $key, $index, $args ) {
				$value = $this->getFieldValue( $key, $args['element'] );
				$post  = $args['post'];
				add_post_meta( $post->ID, $key, $value, true );
			},
			[
				'element' => $element,
				'post'    => $post,
			]
		);

		$this->addToCleanup( $post->ID );
	}

	/**
	 * @param int $postId
	 *
	 * @return void
	 */
	private function addToCleanup( $postId ) {
		if ( ! $this->idsToCleanup ) {
			Hooks::onAction( 'shutdown' )->then( [ $this, 'cleanupFields' ] );
		}

		$this->idsToCleanup[] = $postId;
	}

	/**
	 * @return void
	 */
	public function cleanupFields() {
		// phpcs:disable WordPress.WP.PreparedSQL.NotPrepared
		// phpcs:disable Squiz.Strings.DoubleQuoteUsage.NotRequired
		$this->wpdb->query(
			"
			DELETE FROM {$this->wpdb->postmeta}
			WHERE post_id IN (" . wpml_prepare_in( $this->idsToCleanup, '%d' ) . ")
				AND meta_key IN (" . wpml_prepare_in( $this->getImportFields() ) . ")
			"
		);
		// phpcs:enable Squiz.Strings.DoubleQuoteUsage.NotRequired
		// phpcs:enable WordPress.WP.PreparedSQL.NotPrepared
	}
}
