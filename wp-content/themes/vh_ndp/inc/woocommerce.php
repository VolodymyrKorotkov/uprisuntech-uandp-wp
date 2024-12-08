<?php
/**
 * WooCommerce Compatibility File
 *
 * @link https://woocommerce.com/
 *
 * @package NDP
 */

/**
 * WooCommerce setup function.
 *
 * @link https://docs.woocommerce.com/document/third-party-custom-theme-compatibility/
 * @link https://github.com/woocommerce/woocommerce/wiki/Enabling-product-gallery-features-(zoom,-swipe,-lightbox)
 * @link https://github.com/woocommerce/woocommerce/wiki/Declaring-WooCommerce-support-in-themes
 *
 * @return void
 */
function vh_ndp_woocommerce_setup() {
	add_theme_support(
		'woocommerce',
		array(
			'thumbnail_image_width' => 150,
			'single_image_width'    => 300,
			'product_grid'          => array(
				'default_rows'    => 3,
				'min_rows'        => 1,
				'default_columns' => 4,
				'min_columns'     => 1,
				'max_columns'     => 6,
			),
		)
	);
	add_theme_support( 'wc-product-gallery-zoom' );
	add_theme_support( 'wc-product-gallery-lightbox' );
	add_theme_support( 'wc-product-gallery-slider' );
}
add_action( 'after_setup_theme', 'vh_ndp_woocommerce_setup' );

/**
 * WooCommerce specific scripts & stylesheets.
 *
 * @return void
 */
function vh_ndp_woocommerce_scripts() {
	wp_enqueue_style( 'vh_ndp-woocommerce-style', get_template_directory_uri() . '/woocommerce.css', array(), _S_VERSION );

	$font_path   = WC()->plugin_url() . '/assets/fonts/';
	$inline_font = '@font-face {
			font-family: "star";
			src: url("' . $font_path . 'star.eot");
			src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
				url("' . $font_path . 'star.woff") format("woff"),
				url("' . $font_path . 'star.ttf") format("truetype"),
				url("' . $font_path . 'star.svg#star") format("svg");
			font-weight: normal;
			font-style: normal;
		}';

	wp_add_inline_style( 'vh_ndp-woocommerce-style', $inline_font );
}
add_action( 'wp_enqueue_scripts', 'vh_ndp_woocommerce_scripts' );

/**
 * Disable the default WooCommerce stylesheet.
 *
 * Removing the default WooCommerce stylesheet and enqueing your own will
 * protect you during WooCommerce core updates.
 *
 * @link https://docs.woocommerce.com/document/disable-the-default-stylesheet/
 */
add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

/**
 * Add 'woocommerce-active' class to the body tag.
 *
 * @param  array $classes CSS classes applied to the body tag.
 * @return array $classes modified to include 'woocommerce-active' class.
 */
function vh_ndp_woocommerce_active_body_class( $classes ) {
	$classes[] = 'woocommerce-active';

	return $classes;
}
add_filter( 'body_class', 'vh_ndp_woocommerce_active_body_class' );

/**
 * Related Products Args.
 *
 * @param array $args related products args.
 * @return array $args related products args.
 */
function vh_ndp_woocommerce_related_products_args( $args ) {
	$defaults = array(
		'posts_per_page' => 3,
		'columns'        => 3,
	);

	$args = wp_parse_args( $defaults, $args );

	return $args;
}
add_filter( 'woocommerce_output_related_products_args', 'vh_ndp_woocommerce_related_products_args' );

/**
 * Remove default WooCommerce wrapper.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

if ( ! function_exists( 'vh_ndp_woocommerce_wrapper_before' ) ) {
	/**
	 * Before Content.
	 *
	 * Wraps all WooCommerce content in wrappers which match the theme markup.
	 *
	 * @return void
	 */
	function vh_ndp_woocommerce_wrapper_before() {
		?>
			<main id="primary" class="site-main">
		<?php
	}
}
add_action( 'woocommerce_before_main_content', 'vh_ndp_woocommerce_wrapper_before' );

if ( ! function_exists( 'vh_ndp_woocommerce_wrapper_after' ) ) {
	/**
	 * After Content.
	 *
	 * Closes the wrapping divs.
	 *
	 * @return void
	 */
	function vh_ndp_woocommerce_wrapper_after() {
		?>
			</main><!-- #main -->
		<?php
	}
}
add_action( 'woocommerce_after_main_content', 'vh_ndp_woocommerce_wrapper_after' );

/**
 * Sample implementation of the WooCommerce Mini Cart.
 *
 * You can add the WooCommerce Mini Cart to header.php like so ...
 *
	<?php
		if ( function_exists( 'vh_ndp_woocommerce_header_cart' ) ) {
			vh_ndp_woocommerce_header_cart();
		}
	?>
 */

if ( ! function_exists( 'vh_ndp_woocommerce_cart_link_fragment' ) ) {
	/**
	 * Cart Fragments.
	 *
	 * Ensure cart contents update when products are added to the cart via AJAX.
	 *
	 * @param array $fragments Fragments to refresh via AJAX.
	 * @return array Fragments to refresh via AJAX.
	 */
	function vh_ndp_woocommerce_cart_link_fragment( $fragments ) {
		ob_start();
		vh_ndp_woocommerce_cart_link();
		$fragments['a.cart-contents'] = ob_get_clean();

		return $fragments;
	}
}
add_filter( 'woocommerce_add_to_cart_fragments', 'vh_ndp_woocommerce_cart_link_fragment' );

if ( ! function_exists( 'vh_ndp_woocommerce_cart_link' ) ) {
	/**
	 * Cart Link.
	 *
	 * Displayed a link to the cart including the number of items present and the cart total.
	 *
	 * @return void
	 */
	function vh_ndp_woocommerce_cart_link() {
		?>
		<a class="cart-contents" href="<?php echo esc_url( wc_get_cart_url() ); ?>" title="<?php esc_attr_e( 'View your shopping cart', 'vh_ndp' ); ?>">
			<?php
			$item_count_text = sprintf(
				/* translators: number of items in the mini cart. */
				_n( '%d item', '%d items', WC()->cart->get_cart_contents_count(), 'vh_ndp' ),
				WC()->cart->get_cart_contents_count()
			);
			?>
			<span class="amount"><?php echo wp_kses_data( WC()->cart->get_cart_subtotal() ); ?></span> <span class="count"><?php echo esc_html( $item_count_text ); ?></span>
		</a>
		<?php
	}
}

if ( ! function_exists( 'vh_ndp_woocommerce_header_cart' ) ) {
	/**
	 * Display Header Cart.
	 *
	 * @return void
	 */
	function vh_ndp_woocommerce_header_cart() {
		if ( is_cart() ) {
			$class = 'current-menu-item';
		} else {
			$class = '';
		}
		?>
		<ul id="site-header-cart" class="site-header-cart">
			<li class="<?php echo esc_attr( $class ); ?>">
				<?php vh_ndp_woocommerce_cart_link(); ?>
			</li>
			<li>
				<?php
				$instance = array(
					'title' => '',
				);

				the_widget( 'WC_Widget_Cart', $instance );
				?>
			</li>
		</ul>
		<?php
	}
}


function vh_ndp_paginate_links($r, $args) {

    if (isset($args['custom_pagination']) && $args['custom_pagination']) {
        $r = preg_replace("/(<[^>]+>)([0-9]+)(<[^>]+>)/", "$1<span>$2</span>$3", $r);
        $r = preg_replace("/prev page-numbers/", "pagination__prev", $r);
        $r = preg_replace("/next page-numbers/", "pagination__next", $r);
    }

    return $r;
};
add_filter('paginate_links_output', 'vh_ndp_paginate_links', 10, 2);


add_filter( 'woocommerce_pagination_args', 'vh_ndp_woocommerce_pagination_args_filter' );
/**
 * Function for `woocommerce_pagination_args` filter-hook.
 *
 * @param  $array
 *
 * @return
 */
function vh_ndp_woocommerce_pagination_args_filter( $array ){
    if (is_product_category()) {
        $array['prev_text'] = '<span><i class="arrow arrow-left"></i></span>';
        $array['next_text'] = '<span><i class="arrow arrow-right"></i></span>';
        $array['type'] = 'plain';
        $array['custom_pagination'] = true;
    }
    return $array;
}


function get_woocommerce_additional_data($category_slug = '', $taxonomy = 'pa_%') {
    global $wpdb;

    $andSlug = $category_slug? "AND t.slug = '{$category_slug}'" : "";

    $sql = "SELECT t.name, tr.object_id, tt.taxonomy, tt.term_id, t.name, t.slug
    FROM {$wpdb->prefix}term_relationships AS tr
    JOIN {$wpdb->prefix}term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
    JOIN {$wpdb->prefix}terms AS t ON tt.term_id = t.term_id
    WHERE tr.object_id IN (
        SELECT p.ID
        FROM {$wpdb->prefix}posts AS p
        JOIN {$wpdb->prefix}term_relationships AS tr ON p.ID = tr.object_id
        JOIN {$wpdb->prefix}term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        JOIN {$wpdb->prefix}terms AS t ON tt.term_id = t.term_id
        WHERE p.post_type = 'product'
        AND p.post_status = 'publish'
        AND tt.taxonomy = 'product_cat'
        {$andSlug}
    )
    AND tt.taxonomy LIKE %s";

    $attributes_query = $wpdb->prepare($sql, $taxonomy);

    return $wpdb->get_results($attributes_query);
}

/**
 * Категории связанные с вендорами
 * @param string $category_slug
 * @param string $taxonomy
 * @param null $term_id
 * @return array|object|stdClass[]|null
 */
function get_woocommerce_categories_by_vendors(int $term_id) {
    global $wpdb;

    $sql = "SELECT distinct tt.term_id, t.name, tr.object_id, tt.taxonomy, t.name, t.slug
    FROM {$wpdb->prefix}term_relationships AS tr
    JOIN {$wpdb->prefix}term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
    JOIN {$wpdb->prefix}terms AS t ON tt.term_id = t.term_id
    WHERE tr.object_id IN (
        SELECT p.ID
        FROM {$wpdb->prefix}posts AS p
        JOIN {$wpdb->prefix}term_relationships AS tr ON p.ID = tr.object_id
        JOIN {$wpdb->prefix}term_taxonomy AS tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
        JOIN {$wpdb->prefix}terms AS t ON tt.term_id = t.term_id
        WHERE p.post_type = 'product'
        AND p.post_status = 'publish'
        AND tt.taxonomy = 'sp_smart_brand'
        AND tt.term_id = %s
    )
    AND tt.taxonomy = 'product_cat'";

    $attributes_query = $wpdb->prepare($sql, $term_id);

    return $wpdb->get_results($attributes_query, ARRAY_A);
}


define('SHOWCOUNT', 15);

/**
 * Change number of products that are displayed per page (shop page)
 */
//add_filter( 'loop_shop_per_page', 'new_loop_shop_per_page', 20 );
//function new_loop_shop_per_page( $cols ) {
//    return 1;
//}


add_action( 'pre_get_posts', 'woocommerceCategoryHandler', 1 );
function woocommerceCategoryHandler($query) {

    // Выходим, если это админ-панель или не основной запрос.
    if( is_admin() || !$query->is_main_query() || !is_product_category() )
        return;

    $showCount = $_SESSION['showCount'] ?? SHOWCOUNT;
    if ($showCount !== SHOWCOUNT) {
        $query->set('posts_per_page', $showCount);
    }

    if (!empty($_GET)) {
        foreach ($_GET as $key => $value) {
            $_GET[$key] = (array)$value;
        }
        $tax_queries = prepareTaxQueriesArray($_GET);

        if (!empty($tax_queries)) {
            $query->set('tax_query', $tax_queries);
        }
    }
}


function rclr_query_string($query)
{
    //url error: parameter 1 to be string, array given
    foreach (get_taxonomies(array(), 'objects') as $taxonomy => $t) {
        if ('post_tag' == $taxonomy) {
            continue;   // Handled further down in the $query['tag'] block
        }
        if ($t->query_var && !empty($query[$t->query_var])) {
            if (is_array($query[$t->query_var])) {
                $query[$t->query_var] = implode(',', $query[$t->query_var]);
            }
        }
    }

    if (!is_admin()) {
//    $isProductCategory = is_product_category();
        $isProductCategory = preg_match('/product-category/', $_SERVER['REQUEST_URI']);

        if ($isProductCategory) {
            //product-category/solar-power-systems/?sp_smart_brand%5B0%5D=tesla error
            //taxonomy-product_cat.php меняется на taxonomy-sp_smart_brand.php
            if (array_key_exists('product_cat', $query)) {
                if (array_key_exists('sp_smart_brand', $query)) {
                    unset($query['sp_smart_brand']);
                }

                //если в $_GET-параметрах другие категории, кроме основной
                $product_catArray = explode(',', $query['product_cat']);
                if (count($product_catArray) > 1 && !empty($_GET)) {
                    preg_match('/product-category\/([^\/]+)/', $_SERVER['REQUEST_URI'], $category);
                    if (count($category) && !empty($category[1])) {
                        $query['product_cat'] = $category[1];
                    }
                }
            }
        }
    }
    return $query;
}
add_filter('request', 'rclr_query_string', 1);


add_filter('woocommerce_breadcrumb_defaults', 'product_breadcrumb');

function product_breadcrumb($args) {
    if (is_product()) {
        $args['delimiter'] = '<span class="delimiter">  </span>';
        $args['wrap_before'] = '<div class="breadcrumb-block"><nav class="breadcrumb">';
        $args['wrap_after'] = '</div></div>';
    }
    return $args;
}


add_filter( 'woocommerce_before_single_product', 'single_product_settings');
function single_product_settings() {
    if(is_product()) {
        remove_action( 'woocommerce_before_main_content','woocommerce_breadcrumb', 20);
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
        remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
        remove_filter( 'woocommerce_product_tabs', 'woocommerce_default_product_tabs' );

        add_action( 'woocommerce_single_product_summary', 'custom_single_product_summary_category', 9 );
    }
}

function custom_single_product_summary_category() {
    wc_get_template( 'single-product/categories-brands.php' );
}

/**
 * @param $id
 * @return bool
 */
function checkIfProductAddedToComparison(int $id):bool {
    $current_lang = apply_filters( 'wpml_current_language', 'uk');
    if ($id && isset($_SESSION['comparisonArray']) && !empty($_SESSION['comparisonArray'][$current_lang]) && in_array((int)$id, $_SESSION['comparisonArray'][$current_lang])) {
        return true;
    }
    return false;
}

/**
 * Атрибуты из acf
 * @param int $postID
 * @param string $group attributes group (acf)
 * @return array
 */
function getAcfProductAttributes(int $postID, $group='group_64feabfd747d4'):array {
    if (!$postID) return [];

    $attributesGroup = acf_get_fields($group);
    $attributes = [];
    $num = 0;
    foreach ($attributesGroup as $attribute) {
        if (is_array($attribute) && !empty($attribute['name'])) {
            $slug = $attribute['name'];
            if ($attributeValues = get_field($attribute['name'], $postID)) {
                $n = 0;
                $label = false;
                foreach ($attributeValues as $k => $value) {
                    if ($value) {
                        $label = true;
                        $attributes[$num]['attributes'][$n]['term_id'] = $value->term_id;
                        $attributes[$num]['attributes'][$n]['value'] = $value->name;
                        $attributes[$num]['attributes'][$n]['label'] = $attribute['sub_fields'][$n]['label'];
                        $attributes[$num]['attributes'][$n]['taxonomy'] = $value->taxonomy;
                        $n++;
                    }
                }
                if ($label) {
                    $attributes[$num]['slug'] = $slug;
                    $attributes[$num++]['label'] = $attribute['label'];
                }
            }
        }
    }
    return $attributes;
}


add_filter('woocommerce_product_single_add_to_cart_text','custom_cart_text');
function custom_cart_text(){
    return _e('Add to application','ndp');
}

//Встроенные атрибуты woocommerce
function getMainProductAttributes($product_id=null) {
    global $wpdb, $product;



   // will return the post ID in the current language for post ID 1
    // $product_id = apply_filters( 'wpml_object_id', $product->get_id(), 'post', FALSE, 'uk');
    // $product = wc_get_product( $product_id );


    if ($product && !method_exists($product, 'get_id') && $product_id) {
        $product = wc_get_product( $product_id );
    }

    if (!$product || ($product && !method_exists($product, 'get_id'))) return [];

    // Предположим, что у нас есть объект продукта $product
    $attributes = $product->get_attributes();
    $groups = array();

    foreach ($attributes as $attribute_name => $attribute):

        // Check if attributes exists in groups and prepare all necessary data
        $attributes_keys = array_keys($attributes);
        $attributes_singles = $attributes;
        foreach ($attributes_keys as $index=>$attribute_key) {
            if (substr($attribute_key, 0, 3) !== 'pa_') {
                unset($attributes_keys[$index]);
            }
        }

        if (!empty($attributes_keys)) {
            $attributes_name = implode(',|', $attributes_keys);
            $attributes_name = $attributes_name.',';
        } else {
            $attributes_name = '';
        }
        $query = $wpdb->prepare("SELECT term_id, children FROM $wpdb->term_taxonomy WHERE taxonomy = %s AND children rlike %s", array('wugrat_group', $attributes_name));
        $attribute_groups = $wpdb->get_results($query);

        // Organize groups and get attributes
        if (!empty($attribute_groups)) {
            foreach ($attribute_groups as $attribute_group) {
                $groupifier = rand(0, 9999);
                $attribute_group_term = get_term($attribute_group->term_id);

                $product_attribute_group = array();
                $child_attribute_names = explode(',', $attribute_group->children);
                foreach ($child_attribute_names as $child_attribute_name) {
                    if (array_key_exists($child_attribute_name, $attributes)) {
                        $product_attribute_group[$child_attribute_name] = $attributes[$child_attribute_name];
                        unset($attributes_singles[$child_attribute_name]);
                    }
                }

                foreach ($product_attribute_group as $attribute) {
                    $values = array();

                    if ($attribute->is_taxonomy()) {
                        $attribute_taxonomy = $attribute->get_taxonomy_object();
                        $attribute_values = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'all'));

                        foreach ($attribute_values as $attribute_value) {
                            $value_name = esc_html($attribute_value->name);

                            if ($attribute_taxonomy->attribute_public) {
                                $values[] = '<a href="' . esc_url(get_term_link($attribute_value->term_id, $attribute->get_name())) . '" rel="tag">' . $value_name . '</a>';
                            } else {
                                $values[] = $value_name;
                            }
                        }
                    } else {
                        $values = $attribute->get_options();

                        foreach ($values as &$value) {
                            $value = make_clickable(esc_html($value));
                        }
                    }

                    $product_attributes['attribute_'.$groupifier.'_' . sanitize_title_with_dashes($attribute->get_name())] = array(
                        'label' => $attribute_group_term->name." - ".wc_attribute_label($attribute->get_name()),
                        'value' => apply_filters('woocommerce_attribute', wpautop(wptexturize(implode(', ', $values))), $attribute, $values),
                    );
                }
            }

        }

        foreach ($product_attributes as $attribute => $value):
            $attr=array();
            $attr['group']= explode('-',$value['label'])[0];
            $attr['name']= explode('-',$value['label'])[1];
            $attr['value']=$value['value'];
            $groups[$attr['group']][$attr['name']] =array($attr['name'],$attr['value']);
        endforeach;

    endforeach;

    return $groups;
}





function getMainProductAttributesList($product_id=null) {
    global $wpdb, $product;



   // will return the post ID in the current language for post ID 1
    $product_id = apply_filters( 'wpml_object_id', $product->get_id(), 'post', FALSE, 'uk');
    $product = wc_get_product( $product_id );


    if ($product && !method_exists($product, 'get_id') && $product_id) {
        $product = wc_get_product( $product_id );
    }

    if (!$product || ($product && !method_exists($product, 'get_id'))) return [];

    // Предположим, что у нас есть объект продукта $product
    $attributes = $product->get_attributes();
    $groups = array();

    foreach ($attributes as $attribute_name => $attribute):

        // Check if attributes exists in groups and prepare all necessary data
        $attributes_keys = array_keys($attributes);
        $attributes_singles = $attributes;
        foreach ($attributes_keys as $index=>$attribute_key) {
            if (substr($attribute_key, 0, 3) !== 'pa_') {
                unset($attributes_keys[$index]);
            }
        }

        if (!empty($attributes_keys)) {
            $attributes_name = implode(',|', $attributes_keys);
            $attributes_name = $attributes_name.',';
        } else {
            $attributes_name = '';
        }
        $query = $wpdb->prepare("SELECT term_id, children FROM $wpdb->term_taxonomy WHERE taxonomy = %s AND children rlike %s", array('wugrat_group', $attributes_name));
        $attribute_groups = $wpdb->get_results($query);

        // Organize groups and get attributes
        if (!empty($attribute_groups)) {
            foreach ($attribute_groups as $attribute_group) {
                $groupifier = rand(0, 9999);
                $attribute_group_term = get_term($attribute_group->term_id);

                $product_attribute_group = array();
                $child_attribute_names = explode(',', $attribute_group->children);
                foreach ($child_attribute_names as $child_attribute_name) {
                    if (array_key_exists($child_attribute_name, $attributes)) {
                        $product_attribute_group[$child_attribute_name] = $attributes[$child_attribute_name];
                        unset($attributes_singles[$child_attribute_name]);
                    }
                }

                foreach ($product_attribute_group as $attribute) {
                    $values = array();

                    if ($attribute->is_taxonomy()) {
                        $attribute_taxonomy = $attribute->get_taxonomy_object();
                        $attribute_values = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'all'));

                        foreach ($attribute_values as $attribute_value) {
                            $value_name = esc_html($attribute_value->name);

                            if ($attribute_taxonomy->attribute_public) {
                                $values[] = '<a href="' . esc_url(get_term_link($attribute_value->term_id, $attribute->get_name())) . '" rel="tag">' . $value_name . '</a>';
                            } else {
                                $values[] = $value_name;
                            }
                        }
                    } else {
                        $values = $attribute->get_options();

                        foreach ($values as &$value) {
                            $value = make_clickable(esc_html($value));
                        }
                    }

                    $product_attributes['attribute_'.$groupifier.'_' . sanitize_title_with_dashes($attribute->get_name())] = array(
                        'label' => $attribute_group_term->name." - ".wc_attribute_label($attribute->get_name()),
                        'value' => apply_filters('woocommerce_attribute', wpautop(wptexturize(implode(', ', $values))), $attribute, $values),
                    );
                }
            }

        }

        foreach ($product_attributes as $attribute => $value):
            $attr=array();
            $attr['group']= explode('-',$value['label'])[0];
            $attr['name']= explode('-',$value['label'])[1];
            $attr['value']=$value['value'];
            $groups[$attr['group']][$attr['name']] =array($attr['name'],$attr['value']);
        endforeach;

    endforeach;

    return $groups;
}

/**
 * Returns the translated object ID(post_type or term) or original if missing
 *
 * @param $object_id integer|string|array The ID/s of the objects to check and return
 * @param $type string the object type: post, page, {custom post type name}, nav_menu, nav_menu_item, category, tag etc.
 * @return string or array of object ids
 */
function my_translate_object_id( $object_id, $type ) {
    $current_language= apply_filters( 'wpml_current_language', 'uk' );
    // if array
    if( is_array( $object_id ) ){
        $translated_object_ids = array();
        foreach ( $object_id as $id ) {
            $translated_object_ids[] = apply_filters( 'wpml_object_id', $id, $type, true, $current_language );
        }
        return $translated_object_ids;
    }
    // if string
    elseif( is_string( $object_id ) ) {
        // check if we have a comma separated ID string
        $is_comma_separated = strpos( $object_id,"," );

        if( $is_comma_separated !== FALSE ) {
            // explode the comma to create an array of IDs
            $object_id     = explode( ',', $object_id );

            $translated_object_ids = array();
            foreach ( $object_id as $id ) {
                $translated_object_ids[] = apply_filters ( 'wpml_object_id', $id, $type, true, $current_language );
            }

            // make sure the output is a comma separated string (the same way it came in!)
            return implode ( ',', $translated_object_ids );
        }
        // if we don't find a comma in the string then this is a single ID
        else {
            return apply_filters( 'wpml_object_id', intval( $object_id ), $type, true, $current_language );
        }
    }
    // if int
    else {
        return apply_filters( 'wpml_object_id', $object_id, $type, true, $current_language );
    }
}


