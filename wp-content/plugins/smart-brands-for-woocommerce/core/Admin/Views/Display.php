<?php
/**
 * Display tab.
 *
 * @since      1.0.0
 *
 * @package    smart_brands_for_wc
 * @subpackage smart_brands_for_wc/Admin/Views
 * @author     ShapedPlugin<support@shapedplugin.com>
 */

namespace ShapedPlugin\SmartBrands\Admin\Views;

use ShapedPlugin\SmartBrands\Admin\Framework\Classes\SPF_SMART_BRANDS;

// Cannot access directly.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * This class is responsible for Display options tab in Smart Brand Views page.
 *
 * @since      1.0.0
 */
class Display {

	/**
	 * Display settings.
	 *
	 * @since 1.0.0
	 * @param string $prefix sp_smart_brand_metaboxes.
	 */
	public static function section( $prefix ) {
		SPF_SMART_BRANDS::createSection(
			$prefix,
			array(
				'title'  => __( 'Display Options', 'smart-brands-for-woocommerce' ),
				'icon'   => 'fa fa-th-large',
				'fields' => array(
					array(
						'id'         => 'show_brand_section_title',
						'type'       => 'switcher',
						'title'      => __( 'Brand Section Title', 'smart-brands-for-woocommerce' ),
						'subtitle'   => __( 'Show/Hide Brand section title.', 'smart-brands-for-woocommerce' ),
						'text_on'    => __( 'Show', 'smart-brands-for-woocommerce' ),
						'text_off'   => __( 'Hide', 'smart-brands-for-woocommerce' ),
						'default'    => true,
						'text_width' => 75,
					),
					array(
						'id'          => 'section_title_margin_around',
						'type'        => 'spacing',
						'title'       => __( 'Section Title Margin', 'smart-brands-for-woocommerce' ),
						'subtitle'    => __( 'Set margin for section title.', 'smart-brands-for-woocommerce' ),
						'output_mode' => 'margin',
						'units'       => array(
							esc_html__( 'px', 'smart-brands-for-woocommerce' ),
							esc_html__( 'em', 'smart-brands-for-woocommerce' ),
						),
						'default'     => array(
							'top'    => '0',
							'right'  => '0',
							'bottom' => '30',
							'left'   => '0',
							'unit'   => 'px',
						),
						'dependency'  => array(
							'show_brand_section_title',
							'==',
							'true',
						),
					),
					array(
						'id'          => 'space_between_brands',
						'type'        => 'spacing',
						'title'       => __( 'Space Between Brand', 'smart-brands-for-woocommerce' ),
						'subtitle'    => __( 'Set space in pixel between Brand.', 'smart-brands-for-woocommerce' ),
						'output_mode' => 'margin',
						'all'         => true,
						'all_text'    => false,
						'units'       => array(
							esc_html__( 'px', 'smart-brands-for-woocommerce' ),
						),
						'default'     => array(
							'all'  => '20',
							'unit' => 'px',
						),
					),
					array(
						'id'       => 'product_brand_border',
						'type'     => 'border',
						'title'    => __( 'Border', 'smart-brands-for-woocommerce' ),
						'subtitle' => __( 'Set border for Product brand.', 'smart-brands-for-woocommerce' ),
						'all'      => true,
						'default'  => array(
							'all'         => '0',
							'style'       => 'solid',
							'color'       => '#ddd',
							'hover_color' => '#ddd',
						),
					),
					array(
						'id'       => 'brand_border_radius',
						'type'     => 'spacing',
						'title'    => __( 'Radius', 'smart-brands-for-woocommerce' ),
						'subtitle' => __( 'Set border radius.', 'smart-brands-for-woocommerce' ),
						'top'      => false,
						'bottom'   => false,
						'left'     => false,
						'right'    => false,
						'all'      => true,
						'units'    => array( 'px', '%' ),
						'default'  => array(
							'all'  => '0',
							'unit' => 'px',
						),
					),
				),
			)
		);

	}
}
