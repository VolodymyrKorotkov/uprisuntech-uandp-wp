<?php
/**
 * Product Single Page tab.
 *
 * @since      1.0.0
 *
 * @package    smart_brands_for_wc
 * @subpackage smart_brands_for_wc/Admin/Settings
 * @author     ShapedPlugin<support@shapedplugin.com>
 */

namespace ShapedPlugin\SmartBrands\Admin\Settings;

use ShapedPlugin\SmartBrands\Admin\Framework\Classes\SPF_SMART_BRANDS;

// Cannot access directly.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * This class is responsible for product single page tab in settings page.
 *
 * @since      1.0.0
 */
class ProductPage {

	/**
	 * Product page settings.
	 *
	 * @since 1.0.0
	 * @param string $prefix sp_smart_brand_settings.
	 */
	public static function section( $prefix ) {
		SPF_SMART_BRANDS::createSection(
			$prefix,
			array(
				'title'  => __( 'Product Page Settings', 'smart-brands-for-woocommerce' ),
				'icon'   => 'icon-product-page',
				'fields' => array(

					array(
						'id'         => 'enable_brand_in_single_page',
						'type'       => 'switcher',
						'title'      => __( 'Brand in Product Page', 'smart-brands-for-woocommerce' ),
						'subtitle'   => __( 'Show/hide brand in the product single page.', 'smart-brands-for-woocommerce' ),
						'text_on'    => __( 'show', 'smart-brands-for-woocommerce' ),
						'text_off'   => __( 'hide', 'smart-brands-for-woocommerce' ),
						'default'    => true,
						'text_width' => 77,
					),

				),
			)
		);

	}
}
