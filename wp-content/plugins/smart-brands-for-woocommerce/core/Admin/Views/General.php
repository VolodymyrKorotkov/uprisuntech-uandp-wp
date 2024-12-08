<?php
/**
 * General tab.
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
 * This class is responsible for General tab in Smart Brand Views page.
 *
 * @since      1.0.0
 */
class General {

	/**
	 * General settings.
	 *
	 * @since 1.0.0
	 * @param string $prefix sp_smart_brand_metaboxes.
	 */
	public static function section( $prefix ) {
		SPF_SMART_BRANDS::createSection(
			$prefix,
			array(
				'title'  => __( 'General Options', 'smart-brands-for-woocommerce' ),
				'icon'   => 'fa fa-gear',
				'fields' => array(
					array(
						'id'       => 'brand_layout_preset',
						'type'     => 'layout_preset',
						'class'    => 'sbfw_img_custom_width-3',
						'title'    => __( 'Layout', 'smart-brands-for-woocommerce' ),
						'subtitle' => __( 'Choose a layout', 'smart-brands-for-woocommerce' ),
						'options'  => array(
							'carousel_layout' => array(
								'image' => SMART_BRANDS_URL . '/core/Admin/assets/img/carousel.svg',
								'text'  => __( 'Carousel', 'smart-brands-for-woocommerce' ),
							),
						),
						'default'  => 'carousel_layout',
					),
					array(
						'id'         => 'show_brand_product_count',
						'type'       => 'switcher',
						'title'      => __( 'Product Count', 'smart-brands-for-woocommerce' ),
						'subtitle'   => __( 'It shows the number of products associated with each brand.', 'smart-brands-for-woocommerce' ),
						'text_on'    => __( 'Enabled', 'smart-brands-for-woocommerce' ),
						'text_off'   => __( 'Disabled', 'smart-brands-for-woocommerce' ),
						'default'    => false,
						'text_width' => 96,
					),
					array(
						'id'       => 'number_of_column',
						'type'     => 'column',
						'title'    => __( 'Column(s)', 'smart-brands-for-woocommerce' ),
						'subtitle' => __( 'Set number of row in different devices for responsive view.', 'smart-brands-for-woocommerce' ),
						'default'  => array(
							'large_desktop'    => '4',
							'desktop'          => '4',
							'tablet'           => '3',
							'mobile_landscape' => '2',
							'mobile'           => '1',
						),
						'min'      => '1',
					),
					array(
						'id'       => 'order_by',
						'type'     => 'select',
						'title'    => __( 'Order By', 'smart-brands-for-woocommerce' ),
						'subtitle' => __( 'Select an order by option.', 'smart-brands-for-woocommerce' ),
						'options'  => array(
							'rand' => __( 'Random', 'smart-brands-for-woocommerce' ),
							'date' => __( 'Date', 'smart-brands-for-woocommerce' ),
							'name' => __( 'Name', 'smart-brands-for-woocommerce' ),
						),
						'default'  => 'menu_order',
					),
					array(
						'id'       => 'order',
						'type'     => 'select',
						'title'    => __( 'Order', 'smart-brands-for-woocommerce' ),
						'options'  => array(
							'ASC'  => __( 'Ascending', 'smart-brands-for-woocommerce' ),
							'DESC' => __( 'Descending', 'smart-brands-for-woocommerce' ),
						),
						'default'  => 'DESC',
						'subtitle' => __( 'Select an order option.', 'smart-brands-for-woocommerce' ),
					),
					array(
						'id'         => 'enable_preloader',
						'type'       => 'switcher',
						'title'      => __( 'Preloader', 'smart-brands-for-woocommerce' ),
						'subtitle'   => __( 'Smart brands will be hidden until page load completed and ajax pagination.', 'smart-brands-for-woocommerce' ),
						'text_on'    => __( 'Enabled', 'smart-brands-for-woocommerce' ),
						'text_off'   => __( 'Disabled', 'smart-brands-for-woocommerce' ),
						'text_width' => 96,
						'default'    => true,
					),
				),
			)
		);

	}
}
