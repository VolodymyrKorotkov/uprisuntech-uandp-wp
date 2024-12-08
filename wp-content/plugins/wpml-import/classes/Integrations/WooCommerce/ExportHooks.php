<?php

namespace WPML\Import\Integrations\WooCommerce;

use WPML\Import\Fields;
use WPML\LIB\WP\Hooks;
use function WPML\FP\spreadArgs;

class ExportHooks implements \IWPML_Action {

	/**
	 * This is a reserved prefix that will automatically
	 *  map to a post meta field when re-importing.
	 */
	const META_KEY_PREFIX = 'meta:';

	/**
	 * @var \SitePress $sitepress
	 */
	private $sitepress;

	/**
	 * @param \SitePress $sitepress
	 */
	public function __construct( \SitePress $sitepress ) {
		$this->sitepress = $sitepress;
	}

	public function add_hooks() {
		Hooks::onFilter( 'woocommerce_product_export_column_names' )
			->then( spreadArgs( [ $this, 'addLanguageColumnsToExport' ] ) );

		Hooks::onFilter( 'woocommerce_product_export_row_data', 10, 2 )
			->then( spreadArgs( [ $this, 'addLanguageInfoToExport' ] ) );
	}

	/**
	 * @param array $columnNames
	 *
	 * @return array
	 */
	public function addLanguageColumnsToExport( $columnNames ) {
		return array_merge(
			$columnNames,
			[
				self::getFieldId( Fields::TRANSLATION_GROUP )    => self::getFieldLabel( Fields::TRANSLATION_GROUP ),
				self::getFieldId( Fields::LANGUAGE_CODE )        => self::getFieldLabel( Fields::LANGUAGE_CODE ),
				self::getFieldId( Fields::SOURCE_LANGUAGE_CODE ) => self::getFieldLabel( Fields::SOURCE_LANGUAGE_CODE ),
			]
		);
	}

	/**
	 *
	 * @param array       $row     An associative array with the data of a single row in the CSV file.
	 * @param \WC_Product $product The product object corresponding to the current row.
	 *
	 * @return array
	 */
	public function addLanguageInfoToExport( $row, $product ) {
		$element = $this->sitepress->get_element_language_details( $product->get_id(), 'post_' . $product->post_type );

		if ( $element ) {
			$row = array_merge(
				$row,
				[
					self::getFieldId( Fields::TRANSLATION_GROUP )    => $element->trid,
					self::getFieldId( Fields::LANGUAGE_CODE )        => $element->language_code,
					self::getFieldId( Fields::SOURCE_LANGUAGE_CODE ) => $element->source_language_code,
				]
			);
		}

		return $row;
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	private static function getFieldLabel( $field ) {
		/** @see \WC_Product_CSV_Exporter::prepare_meta_for_export */
		return sprintf( __( 'Meta: %s', 'woocommerce' ), $field ); // phpcs:ignore WordPress.WP.I18n.MissingTranslatorsComment
	}

	/**
	 * @param string $field
	 *
	 * @return string
	 */
	private static function getFieldId( $field ) {
		return self::META_KEY_PREFIX . $field;
	}
}
