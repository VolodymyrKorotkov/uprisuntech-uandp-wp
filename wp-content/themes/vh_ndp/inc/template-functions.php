<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package NDP
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function vh_ndp_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'vh_ndp_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function vh_ndp_pingback_header() {
	if ( is_singular() && pings_open() ) {
		printf( '<link rel="pingback" href="%s">', esc_url( get_bloginfo( 'pingback_url' ) ) );
	}
}
add_action( 'wp_head', 'vh_ndp_pingback_header' );


/**
 * Example [my_extended_gallery gallery_title="Gallery example (dots)" gallery_id="174" gallery="field_64ef6e3effe22"]
 * Example [my_extended_gallery gallery_title="Gallery example (dots)" images="174,175,176"]
 * gallery_id - custom post type
 * gallery - acf field
 * images - image id
 * @param $atts
 * @return false|string
 */
function my_extended_gallery_shortcode($atts) {
    // Атрибуты по умолчанию
    $atts = shortcode_atts(
        array(
            'gallery_title' => '',
            'images' => '',
            'gallery_id'     => null,
            'gallery' => null,
        ), $atts, 'my_extended_gallery'
    );

    $gallery_title = $atts['gallery_title'] ?? null;

    $image_ids = [];

    // Здесь приоритет отдается 'images'
    if (!empty($atts['images'])) {
        $image_ids = explode(',', $atts['images']);
    } elseif ($atts['gallery_id']) {
        $images = get_field($atts['gallery'], $atts['gallery_id']);
        if ($images) {
            foreach ($images as $image) {
                $image_ids[] = $image['ID'];
            }
        }
    }

    if (empty($image_ids)) {
        return 'Изображения не указаны или не найдены';
    }

    // Начало буферизации вывода
    ob_start();

    // Включение файла шаблона
    include(get_template_directory() . '/template-parts/gallery_shortcode_template.php');

    // Получение содержимого буфера и его очистка
    $output = ob_get_clean();

    return $output;
}

add_shortcode('my_extended_gallery', 'my_extended_gallery_shortcode');


//Текст для категорий товара
if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_650c85a378b50',
        'title' => 'Single category description',
        'fields' => array(
            array(
                'key' => 'field_650c85a5b98ad',
                'label' => 'Single category description',
                'name' => 'single_category_description',
                'aria-label' => '',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'product_cat',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

endif;


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_solutions_section',
        'title' => 'Настройки секции Solutions',
        'fields' => array(
            array(
                'key' => 'field_solutions_title',
                'label' => 'Заголовок секции',
                'name' => 'solutions_title',
                'type' => 'text',
                'default_value' => 'Solutions',
            ),
            array(
                'key' => 'field_solutions_blocks',
                'label' => 'Блоки',
                'name' => 'solutions_blocks',
                'type' => 'repeater',
                'min' => 2,
                'max' => 2,
                'sub_fields' => array(
                    array(
                        'key' => 'field_block_title',
                        'label' => 'Заголовок блока',
                        'name' => 'block_title',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_block_link',
                        'label' => 'Ссылка блока',
                        'name' => 'block_link',
                        'type' => 'text',
                    ),
                    array(
                        'key' => 'field_block_image',
                        'label' => 'Изображение блока',
                        'name' => 'block_image',
                        'type' => 'image',
                        'return_format' => 'url',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'page-solutions.php', // укажите правильный путь к вашему файлу шаблона
                ),
            ),
        ),
    ));

endif;


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_650dbbc737f2d',
        'title' => 'Vendor country',
        'fields' => array(
            array(
                'key' => 'field_650dbbc9f3512',
                'label' => 'Vendor country',
                'name' => 'vendor_country',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'sp_smart_brand',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

endif;


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_650dbc42bd655',
        'title' => 'Vendor website',
        'fields' => array(
            array(
                'key' => 'field_650dbc44199f5',
                'label' => 'Vendor website',
                'name' => 'vendor_website',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'sp_smart_brand',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

endif;


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_650dc51d04440',
        'title' => 'Vendor description',
        'fields' => array(
            array(
                'key' => 'field_650dc51f5916f',
                'label' => 'Vendor description',
                'name' => 'vendor_description',
                'aria-label' => '',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'taxonomy',
                    'operator' => '==',
                    'value' => 'sp_smart_brand',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
    ));

endif;


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_6519b75722f17',
        'title' => 'Course short description',
        'fields' => array(
            array(
                'key' => 'field_6519b7595c816',
                'label' => 'Course short description',
                'name' => 'course_short_description',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'wpml_cf_preferences' => 2,
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'course',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_65192a7840588',
        'title' => 'Video course duration',
        'fields' => array(
            array(
                'key' => 'field_65192a9539bb0',
                'label' => 'Video course duration',
                'name' => 'video_course_duration',
                'aria-label' => '',
                'type' => 'radio',
                'instructions' => __('Set automatically after saving lectures', 'ndp'),
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'wpml_cf_preferences' => 1,
                'choices' => array(
                    '0-1' => '0–1 Hour',
                    '1-3' => '1–3 Hours',
                    '3-6' => '3–6 Hours',
                    '6-12' => '6–12 Hours',
                    '12+' => '12+ Hours',
                ),
                'default_value' => '',
                'return_format' => 'value',
                'allow_null' => 1,
                'other_choice' => 0,
                'layout' => 'vertical',
                'save_other_choice' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'course',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_6519cd7232111',
        'title' => 'Course language',
        'fields' => array(
            array(
                'key' => 'field_6519cd7483338',
                'label' => 'Course language',
                'name' => 'course_language',
                'aria-label' => '',
                'type' => 'radio',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'wpml_cf_preferences' => 1,
                'choices' => array(
                    'english' => 'English',
                    'ukrainian' => 'Ukrainian',
                ),
                'default_value' => '',
                'return_format' => 'value',
                'allow_null' => 1,
                'other_choice' => 0,
                'layout' => 'vertical',
                'save_other_choice' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'course',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_651ba6e062cba',
        'title' => 'Course is paid/free',
        'fields' => array(
            array(
                'key' => 'field_651ba6e318eb8',
                'label' => 'Course is paid_free',
                'name' => 'course_is_paid_free',
                'aria-label' => '',
                'type' => 'radio',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'wpml_cf_preferences' => 1,
                'choices' => array(
                    'free' => 'Free',
                ),
                'default_value' => 'free : Free',
                'return_format' => 'value',
                'allow_null' => 0,
                'other_choice' => 0,
                'layout' => 'vertical',
                'save_other_choice' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'course',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;

//if( function_exists('acf_add_local_field_group') ):
//
//    acf_add_local_field_group(array(
//        'key' => 'group_65267e53de75d',
//        'title' => 'Course total time',
//        'fields' => array(
//            array(
//                'key' => 'field_65267e56f6d3e',
//                'label' => 'Course total time',
//                'name' => 'course_total_time',
//                'aria-label' => '',
//                'type' => 'time_picker',
//                'instructions' => '',
//                'required' => 1,
//                'conditional_logic' => 0,
//                'wrapper' => array(
//                    'width' => '',
//                    'class' => '',
//                    'id' => '',
//                ),
//                'wpml_cf_preferences' => 1,
//                'display_format' => 'H:i',
//                'return_format' => 'g:i a',
//            ),
//        ),
//        'location' => array(
//            array(
//                array(
//                    'param' => 'post_type',
//                    'operator' => '==',
//                    'value' => 'course',
//                ),
//            ),
//        ),
//        'menu_order' => 0,
//        'position' => 'normal',
//        'style' => 'default',
//        'label_placement' => 'top',
//        'instruction_placement' => 'label',
//        'hide_on_screen' => '',
//        'active' => true,
//        'description' => '',
//        'show_in_rest' => 0,
//        'acfml_field_group_mode' => 'translation',
//    ));
//
//endif;

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_65269318a3336',
        'title' => 'Lesson type',
        'fields' => array(
            array(
                'key' => 'field_6526931ba1151',
                'label' => 'Lesson type',
                'name' => 'lesson_type',
                'aria-label' => '',
                'type' => 'radio',
                'instructions' => 'Тип лекции (для вывода иконок на странице курса)',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'wpml_cf_preferences' => 1,
                'choices' => array(
                    'video' => 'video',
                    'audio' => 'audio',
                    'slides' => 'slides',
                    'article' => 'article',
                    'quiz' => 'quiz',
                ),
                'default_value' => '',
                'return_format' => 'value',
                'allow_null' => 0,
                'other_choice' => 0,
                'layout' => 'vertical',
                'save_other_choice' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'lesson',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_65269c325e896',
        'title' => 'Lesson total time',
        'fields' => array(
            array(
                'key' => 'field_65269c357e7ce',
                'label' => 'Lesson total time',
                'name' => 'lesson_total_time',
                'aria-label' => '',
                'type' => 'time_picker',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'default_value' => '00:00',
                'wpml_cf_preferences' => 1,
                'display_format' => 'H:i',
                'return_format' => 'H:i',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'lesson',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_653ba229d546f',
        'title' => 'LMS certificate expiration',
        'fields' => array(
            array(
                'key' => 'field_653ba22c20360',
                'label' => 'LMS certificate expiration',
                'name' => 'lms_certificate_expiration',
                'aria-label' => '',
                'type' => 'number',
                'instructions' => 'Число дней',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'wpml_cf_preferences' => 1,
                'default_value' => 0,
                'min' => '',
                'max' => '',
                'placeholder' => '',
                'step' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'llms_certificate',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_652fbc9ed446c',
        'title' => 'LMS certificate company',
        'fields' => array(
            array(
                'key' => 'field_652fbca1830e3',
                'label' => 'LMS certificate company',
                'name' => 'lms_certificate_company',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'wpml_cf_preferences' => 2,
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'llms_certificate',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_6567c33b30eec',
        'title' => 'LMS certificate company en',
        'fields' => array(
            array(
                'key' => 'field_6567c33d7596f',
                'label' => 'LMS certificate company en',
                'name' => 'lms_certificate_company_en',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'wpml_cf_preferences' => 2,
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'llms_certificate',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_652fbd576f2b7',
        'title' => 'LMS certificate source',
        'fields' => array(
            array(
                'key' => 'field_652fbd59384bb',
                'label' => 'LMS certificate source',
                'name' => 'lms_certificate_source',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'wpml_cf_preferences' => 2,
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'llms_certificate',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_6532b608a6e59',
        'title' => 'LMS certificate description',
        'fields' => array(
            array(
                'key' => 'field_6532b60cbd4d2',
                'label' => 'LMS certificate description',
                'name' => 'lms_certificate_description',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 1,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'wpml_cf_preferences' => 2,
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'llms_certificate',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_6532bd8844d60',
        'title' => 'LMS certificate footer text',
        'fields' => array(
            array(
                'key' => 'field_6532bd8bff41e',
                'label' => 'LMS certificate footer text',
                'name' => 'lms_certificate_footer_text',
                'aria-label' => '',
                'type' => 'text',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'wpml_cf_preferences' => 2,
                'default_value' => '',
                'maxlength' => '',
                'placeholder' => '',
                'prepend' => '',
                'append' => '',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'llms_certificate',
                ),
            ),
        ),
        'menu_order' => 2,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_6538f66b768b3',
        'title' => 'Course training page description',
        'fields' => array(
            array(
                'key' => 'field_6538f66e16f27',
                'label' => 'Course training page description',
                'name' => 'course_training_page_description',
                'aria-label' => '',
                'type' => 'wysiwyg',
                'instructions' => 'Отображается на странице лекции',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'wpml_cf_preferences' => 2,
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'course',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;


if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_6596eebb8b7bb',
        'title' => 'Lessons files',
        'fields' => array(
            array(
                'key' => 'field_6596eebba836d',
                'label' => 'Files group',
                'name' => 'files_group',
                'aria-label' => '',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'layout' => 'table',
                'pagination' => 0,
                'min' => 0,
                'max' => 0,
                'collapsed' => '',
                'button_label' => 'Add Row',
                'rows_per_page' => 20,
                'wpml_cf_preferences' => 1,
                'sub_fields' => array(
                    array(
                        'key' => 'field_6596eebbad74f',
                        'label' => 'File',
                        'name' => 'file',
                        'aria-label' => '',
                        'type' => 'file',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'return_format' => 'array',
                        'library' => 'all',
                        'min_size' => '',
                        'max_size' => '',
                        'mime_types' => 'pdf',
                        'parent_repeater' => 'field_6596eebba836d',
                        'wpml_cf_preferences' => 1,
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'lesson',
                ),
            ),
        ),
        'menu_order' => 2,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_656faf776eefa',
        'title' => 'Survey',
        'fields' => array(
            array(
                'key' => 'field_656faf7ad6022',
                'label' => 'Survay?',
                'name' => 'type',
                'aria-label' => '',
                'type' => 'true_false',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => 'survey_checkbox',
                ),
                'wpml_cf_preferences' => 0,
                'message' => '',
                'default_value' => 0,
                'ui' => 0,
                'ui_on_text' => '',
                'ui_off_text' => '',
            ),
            array(
                'key' => 'field_656fd72033653',
                'label' => 'Survey опис перед кнопкою',
                'name' => 'survey_opis_pered_knopkoyu',
                'aria-label' => '',
                'type' => 'wysiwyg',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_656faf7ad6022',
                            'operator' => '==',
                            'value' => '1',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'wpml_cf_preferences' => 0,
                'default_value' => '',
                'tabs' => 'all',
                'toolbar' => 'full',
                'media_upload' => 1,
                'delay' => 0,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'course',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'advanced',
    ));

endif;

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_65a928d0733a1',
        'title' => 'Survey start date',
        'fields' => array(
            array(
                'key' => 'field_65a928d26b494',
                'label' => 'Survey start date',
                'name' => 'survey_start_date',
                'aria-label' => '',
                'type' => 'date_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => 'survey_start_date',
                ),
                'wpml_cf_preferences' => 1,
                'display_format' => 'd.m.Y',
                'return_format' => 'd.m.Y',
                'first_day' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'course',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

    acf_add_local_field_group(array(
        'key' => 'group_65a92a7d0d69d',
        'title' => 'Survey finish date',
        'fields' => array(
            array(
                'key' => 'field_65a92a7d67460',
                'label' => 'Survey finish date',
                'name' => 'survey_finish_date',
                'aria-label' => '',
                'type' => 'date_picker',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => 'survey_finish_date',
                ),
                'wpml_cf_preferences' => 1,
                'display_format' => 'd.m.Y',
                'return_format' => 'd.m.Y',
                'first_day' => 1,
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'course',
                ),
            ),
        ),
        'menu_order' => 1,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;

if( function_exists('acf_add_local_field_group') ):

    acf_add_local_field_group(array(
        'key' => 'group_65aaa057ecd55',
        'title' => 'News, Knowledge, Cases files',
        'fields' => array(
            array(
                'key' => 'field_65aaa059a23a2',
                'label' => 'Custom type files group',
                'name' => 'custom_type_files_group',
                'aria-label' => '',
                'type' => 'repeater',
                'instructions' => '',
                'required' => 0,
                'conditional_logic' => 0,
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'wpml_cf_preferences' => 1,
                'layout' => 'table',
                'pagination' => 0,
                'min' => 0,
                'max' => 0,
                'collapsed' => '',
                'button_label' => 'Add Row',
                'rows_per_page' => 20,
                'sub_fields' => array(
                    array(
                        'key' => 'field_65aaa4d23b6f3',
                        'label' => 'Posts files group',
                        'name' => 'posts_files_group',
                        'aria-label' => '',
                        'type' => 'file',
                        'instructions' => '',
                        'required' => 0,
                        'conditional_logic' => 0,
                        'wrapper' => array(
                            'width' => '',
                            'class' => '',
                            'id' => '',
                        ),
                        'wpml_cf_preferences' => 1,
                        'return_format' => 'array',
                        'library' => 'all',
                        'min_size' => '',
                        'max_size' => '',
                        'mime_types' => 'pdf,docx,txt,zip',
                        'parent_repeater' => 'field_65aaa059a23a2',
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'news',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'knowledge-base',
                ),
            ),
            array(
                array(
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'cases',
                ),
            ),
        ),
        'menu_order' => 0,
        'position' => 'normal',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => '',
        'active' => true,
        'description' => '',
        'show_in_rest' => 0,
        'acfml_field_group_mode' => 'translation',
    ));

endif;

if(function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(array(
        'key' => 'group_1',
        'title' => 'Our Team',
        'fields' => array(
            array(
                'key' => 'field_1',
                'label' => 'Team Members',
                'name' => 'team_members',
                'type' => 'repeater',
                'sub_fields' => array(
                    array(
                        'key' => 'field_2',
                        'label' => 'Avatar',
                        'name' => 'avatar',
                        'type' => 'image',
                        'required' => 1, // makes the field required
                    ),
                    array(
                        'key' => 'field_3',
                        'label' => 'Name',
                        'name' => 'name',
                        'type' => 'text',
                        'required' => 1, // makes the field required
                    ),
                    array(
                        'key' => 'field_4',
                        'label' => 'Position',
                        'name' => 'position',
                        'type' => 'text',
                        'required' => 1, // makes the field required
                    ),
                    array(
                        'key' => 'field_5',
                        'label' => 'Social Links',
                        'name' => 'social_links',
                        'type' => 'repeater',
                        'sub_fields' => array(
                            array(
                                'key' => 'field_6',
                                'label' => 'Social Network',
                                'name' => 'network',
                                'type' => 'select',
                                'choices' => array(
                                    'linkedin' => 'LinkedIn',
                                    'twitter' => 'Twitter',
                                    'facebook' => 'Facebook',
                                    // ... Add other networks as needed
                                ),
                            ),
                            array(
                                'key' => 'field_7',
                                'label' => 'Profile URL',
                                'name' => 'profile_url',
                                'type' => 'url',
                            ),
                        ),
                    ),
                ),
            ),
        ),
        'location' => array(
            array(
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'about.php', // adjust to your template name
                ),
                array(
                    'param' => 'page_template',
                    'operator' => '==',
                    'value' => 'about_ua.php', // adjust to your template name
                ),
            ),
        ),
    ));

endif;



if (!function_exists('mb_ucfirst'))
{
    /**
     * mb_ucfirst - Make a string's first character uppercase
     * @param string $str - The input string.
     * @param string $encoding - string $encoding [optional] &mbstring.encoding.parameter; default UTF-8
     * @return string str with first alphabetic character converted to uppercase.
     */
    function mb_ucfirst($str, $encoding='UTF-8')
    {
        $str = trim($str);
        $str = mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding).
            mb_substr($str, 1, mb_strlen($str), $encoding);
        return $str;
    }
}

//склонение слов
function declOfNum($num, $titles) {
    $cases = array(2, 0, 1, 1, 1, 2);

    return $num . " " . $titles[($num % 100 > 4 && $num % 100 < 20) ? 2 : $cases[min($num % 10, 5)]];
}