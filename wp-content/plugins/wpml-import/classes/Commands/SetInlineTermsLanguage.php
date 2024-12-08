<?php

namespace WPML\Import\Commands;

use WPML\Collect\Support\Collection;
use WPML\FP\Fns;
use WPML\FP\Just;
use WPML\Import\Commands\Base\Query;
use WPML\Import\Fields;
use WPML\Import\Helper\Taxonomies;

class SetInlineTermsLanguage implements Base\Command, Base\TemporaryTermFields {

	use Query;

	const DEFAULT_LIMIT = 100;

	const FIELD_TEMPORARY_PROCESSED_INLINE_TERM = '_wpml_import_processed_inline_term';

	/**
	 * @var \wpdb $wpdb
	 */
	protected $wpdb;

	/**
	 * @var \SitePress $sitepress
	 */
	protected $sitepress;

	public function __construct( \wpdb $wpdb, \SitePress $sitepress ) {
		$this->wpdb      = $wpdb;
		$this->sitepress = $sitepress;
	}

	/**
	 * @return string
	 */
	public static function getTitle() {
		return __( 'Identifying Inline Term Languages', 'wpml-import' );
	}

	/**
	 * @return string
	 */
	public static function getDescription() {
		return __( 'Identifying and setting the language of terms created during post imports.', 'wpml-import' );
	}

	/**
	 * @codeCoverageIgnore
	 *
	 * @return int
	 */
	public function countPendingItems() {
		return count( $this->getPendingItems() );
	}

	/**
	 * @codeCoverageIgnore
	 *
	 * @param Collection|null $args
	 *
	 * @return int
	 */
	public function run( Collection $args = null ) {
		$items = $this->getPendingItems( self::DEFAULT_LIMIT );

		foreach ( $items as $item ) {
			$hasNoTranslationInNewLang = ! wpml_collect( $this->sitepress->get_element_translations( $item['trid'], 'tax_' . $item['taxonomy'] ) )
				->first( function( $element ) use ( $item ) {
					return $element->language_code === $item['newTtidLang'];
				} );

			if ( $hasNoTranslationInNewLang ) {
				$this->sitepress->set_element_language_details( $item['ttid'], 'tax_' . $item['taxonomy'], $item['trid'], $item['newTtidLang'] );
			}

			add_term_meta( $item['term_id'], self::FIELD_TEMPORARY_PROCESSED_INLINE_TERM, 1 );
		}

		return count( $items );
	}

	/**
	 * @codeCoverageIgnore
	 *
	 * @param int $limit
	 *
	 * @return array
	 */
	private function getPendingItems( $limit = null ) {
		$translatableTaxTypes = Taxonomies::getTranslatable( true );

		$items = $this->getResultsWithLimit(
			"
			SELECT DISTINCT
				tr.term_taxonomy_id AS ttid,
				MIN(tt.term_id) AS term_id,
				MIN(iclttr.trid) AS trid,
				MIN(iclttr.language_code) AS term_language_code,
				iclptr.language_code AS post_language_code,
				MIN(tt.taxonomy) AS taxonomy
			FROM {$this->wpdb->term_relationships} AS tr
			LEFT JOIN {$this->wpdb->term_taxonomy} AS tt
				ON tt.term_taxonomy_id = tr.term_taxonomy_id
			LEFT JOIN {$this->wpdb->postmeta} AS pm
				ON pm.post_id = tr.object_id
			LEFT JOIN {$this->wpdb->termmeta} AS tm
			    ON tm.term_id = tt.term_id AND tm.meta_key = '" . self::FIELD_TEMPORARY_PROCESSED_INLINE_TERM . "'
			LEFT JOIN {$this->wpdb->prefix}icl_translations AS iclttr
				ON iclttr.element_id = tr.term_taxonomy_id AND iclttr.element_type LIKE '" . $this->wpdb->esc_like( 'tax_' ) . "%'
			LEFT JOIN {$this->wpdb->prefix}icl_translations AS iclptr
				ON iclptr.element_id = pm.post_id AND iclptr.element_type LIKE '" . $this->wpdb->esc_like( 'post_' ) . "%'
			WHERE iclttr.element_type IN(" . wpml_prepare_in( $translatableTaxTypes ) . ")
				AND pm.meta_key = '" . Fields::TRANSLATION_GROUP . "'
				AND tm.meta_value IS NULL
			GROUP BY iclptr.language_code, tr.term_taxonomy_id
			ORDER BY tr.term_taxonomy_id ASC
			",
			$limit
		);

		/**
		 * @param array  $carry
		 * @param object $item
		 *
		 * @return array
		 */
		$groupPossibleLangsForTtids = function( $carry, $item ) {
			if ( ! isset( $carry[ $item->ttid ] ) ) {
				$carry[ $item->ttid ] = [
					'ttid'        => $item->ttid,
					'term_id'     => $item->term_id,
					'trid'        => $item->trid,
					'taxonomy'    => $item->taxonomy,
					'termLang'    => $item->term_language_code,
					'targetLangs' => [ $item->post_language_code ],
				];
			}

			if ( ! in_array( $item->post_language_code, $carry[ $item->ttid ]['targetLangs'], true ) ) {
				$carry[ $item->ttid ]['targetLangs'][] = $item->post_language_code;
			}

			return $carry;
		};

		/**
		 * @param array $item
		 *
		 * @return bool
		 */
		$filterTtidsWithNoMatchingLanguage = function( $item ) {
			return ! in_array( $item['termLang'], $item['targetLangs'], true );
		};

		/**
		 * @param array $item
		 *
		 * @return array
		 */
		$mapTtidToNewLanguage = function( $item ) {
			return [
				'ttid'        => $item['ttid'],
				'term_id'     => $item['term_id'],
				'trid'        => $item['trid'],
				'taxonomy'    => $item['taxonomy'],
				'newTtidLang' => reset( $item['targetLangs'] ),
			];
		};

		return Just::of( $items )
			->map( Fns::reduce( $groupPossibleLangsForTtids, [] ) )
			->map( Fns::filter( $filterTtidsWithNoMatchingLanguage ) )
			->map( Fns::map( $mapTtidToNewLanguage ) )
			->get();
	}

	/**
	 * @return string[]
	 */
	public static function getTemporaryTermFields() {
		return [
			self::FIELD_TEMPORARY_PROCESSED_INLINE_TERM,
		];
	}
}
