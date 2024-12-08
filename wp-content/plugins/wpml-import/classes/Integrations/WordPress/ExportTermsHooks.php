<?php

namespace WPML\Import\Integrations\WordPress;

use WPML\LIB\WP\Hooks;
use WPML\FP\Str;
use function WPML\FP\spreadArgs;
use WPML\Import\Helper\Taxonomies;
use WPML\Import\Integrations\Base\Fields;

class ExportTermsHooks implements \IWPML_Backend_Action, \IWPML_DIC_Action {
	use Fields;

	const META_FIELDS_DOING = 'doing';
	const META_FIELDS_DONE  = 'done';

	/**
	 * @var \wpdb $wpdb
	 */
	protected $wpdb;

	/**
	 * @var \SitePress $sitepress
	 */
	private $sitepress;

	/**
	 * @var Taxonomies
	 */
	private $taxonomies;

	/**
	 * @var string|null
	 */
	private $metaFieldsStatus;

	/**
	 * @var bool
	 */
	private $skipNextQueryFilterCallback = false;

	public function __construct(
		\wpdb $wpdb,
		\SitePress $sitepress,
		Taxonomies $taxonomies
	) {
		$this->wpdb       = $wpdb;
		$this->sitepress  = $sitepress;
		$this->taxonomies = $taxonomies;
	}

	public function add_hooks() {
		Hooks::onFilter( 'get_terms_args' )
			->then( spreadArgs( [ $this, 'skipWpmlFiltersInGetTerms' ] ) );
		Hooks::onFilter( 'query' )
			->then( spreadArgs( [ $this, 'setTermMetaFields' ] ) );
	}

	/**
	 * @param  array $args
	 *
	 * @return array
	 */
	public function skipWpmlFiltersInGetTerms( $args ) {
		$args['wpml_skip_filters'] = true;
		return $args;
	}

	private function areMetaFieldsDone() {
		return self::META_FIELDS_DONE === $this->metaFieldsStatus;
	}

	private function setDoingMetaFields() {
		$this->metaFieldsStatus = self::META_FIELDS_DOING;
	}

	private function setMetaFieldsMaybeDone() {
		if ( self::META_FIELDS_DOING === $this->metaFieldsStatus ) {
			$this->metaFieldsStatus = self::META_FIELDS_DONE;
			$this->cleanMetaFields();
		}
	}

	/**
	 * @return bool
	 */
	private function shouldApplyQueryFilter() {
		if ( $this->skipNextQueryFilterCallback ) {
			return false;
		}
		if ( $this->areMetaFieldsDone() ) {
			return false;
		}
		return true;
	}

	/**
	 * All terms are processed one after the other so we should be able to detect when we are done
	 *
	 * @param  string $query
	 *
	 * @return string
	 */
	public function setTermMetaFields( $query ) {
		if ( ! $this->shouldApplyQueryFilter() ) {
			return $query;
		}
		if ( $this->isTermMetaQuery( $query ) ) {
			$this->skipNextQueryFilterCallback = true;
			$this->setMetaFields( $this->getQueriedTerm( $query ) );
			$this->skipNextQueryFilterCallback = false;
		} else {
			$this->setMetaFieldsMaybeDone();
		}
		return $query;
	}

	/**
	 * @return string
	 */
	private function getQuerySignature() {
		return "SELECT * FROM {$this->wpdb->termmeta} WHERE term_id = ";
	}

	/**
	 * @param  string $query
	 *
	 * @return bool
	 */
	private function isTermMetaQuery( $query ) {
		return (bool) Str::startsWith( $this->getQuerySignature(), $query );
	}

	/**
	 * @param  string $query
	 *
	 * @return \WP_Term|null
	 */
	private function getQueriedTerm( $query ) {
		$termId = (int) trim( Str::replace( $this->getQuerySignature(), '', $query ) );
		return get_term( $termId );
	}

	/**
	 * @param \WP_Term|null $term
	 */
	private function setMetaFields( $term ) {
		if ( ! $term ) {
			return;
		}
		if ( ! $this->taxonomies->isTranslatable( $term->taxonomy ) ) {
			return;
		}

		$this->setDoingMetaFields();

		$exportFields = $this->getImportFields();

		// phpcs:disable WordPress.WP.PreparedSQL.NotPrepared
		// phpcs:disable Squiz.Strings.DoubleQuoteUsage.NotRequired
		$existingKeys = $this->wpdb->get_col(
			$this->wpdb->prepare(
				"SELECT DISTINCT meta_key 
				FROM {$this->wpdb->termmeta} 
				WHERE term_id = %d 
				AND meta_key IN (" . wpml_prepare_in( $exportFields ) . ") 
				LIMIT 4",
				$term->term_id
			)
		);
		// phpcs:enable WordPress.WP.PreparedSQL.NotPrepared
		// phpcs:enable Squiz.Strings.DoubleQuoteUsage.NotRequired

		$missingKeys = array_diff(
			$exportFields,
			$existingKeys
		);

		if ( empty( $missingKeys ) ) {
			return;
		}

		$element = $this->sitepress->get_element_language_details( $term->term_id, 'tax_' . $term->taxonomy );
		if ( ! $element ) {
			return;
		}

		array_walk(
			$missingKeys,
			function( $key, $index, $args ) {
				$value = $this->getFieldValue( $key, $args['element'] );
				$term  = $args['term'];
				add_term_meta( $term->term_id, $key, $value, true );
			},
			[
				'element' => $element,
				'term'    => $term,
			]
		);
	}

	private function cleanMetaFields() {
		$exportFields = $this->getImportFields();
		// phpcs:disable WordPress.WP.PreparedSQL.NotPrepared
		// phpcs:disable Squiz.Strings.DoubleQuoteUsage.NotRequired
		$this->wpdb->query(
			"DELETE FROM {$this->wpdb->termmeta} WHERE meta_key IN (" . wpml_prepare_in( $exportFields ) . ")"
		);
		// phpcs:enable Squiz.Strings.DoubleQuoteUsage.NotRequired
		// phpcs:enable WordPress.WP.PreparedSQL.NotPrepared
	}

}
