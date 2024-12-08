<?php
/**
 * Plugin Name:       NDP Projects Plugin
 * Description:       Projects list, single project page for NDP.
 * Requires at least: 6.1
 * Requires PHP:      7.4
 * Version:           0.1.1
 * Author:            uprisun.tech
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       ndp-projects-plugin
 * Domain Path:       /languages
 *
 * @package           NDP_Projects
 */

add_action('init', 'ndp_projects_load_textdomain');

function ndp_projects_load_textdomain()
{
    load_plugin_textdomain('ndp_projects_textdomain', false, dirname(plugin_basename(__FILE__)) . '/languages');
}


$dir = plugin_dir_path(__FILE__);

add_action('init', function () {
    register_post_type('project', [
        'label' => __('Projects', 'ndp-projects-plugin'),
        'public' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-book',
        //'supports' => ['title', 'editor', 'thumbnail', 'author', 'revisions', 'comments'],
        'supports' => ['title', 'editor', 'thumbnail'],
        'show_in_rest' => true,
        'rewrite' => ['slug' => 'project'],
        'taxonomies' => ['project_category', 'project_status', 'project_tag'],
        'labels' => [
            'singular_name' => __('Project', 'ndp-projects-plugin'),
            'add_new_item' => __('Add new Project', 'ndp-projects-plugin'),
            'new_item' => __('New Project', 'ndp-projects-plugin'),
            'view_item' => __('View Project', 'ndp-projects-plugin'),
            'not_found' => __('No Projects found', 'ndp-projects-plugin'),
            'not_found_in_trash' => __('No Projects found in trash', 'ndp-projects-plugin'),
            'all_items' => __('All Projects', 'ndp-projects-plugin'),
            'insert_into_item' => __('Insert into Project', 'ndp-projects-plugin')
        ],
    ]);

    register_taxonomy('project_category', ['project'], [
        'label' => __('Categories', 'ndp-projects-plugin'),
        'hierarchical' => true,
        'rewrite' => ['slug' => 'project-category'],
        'show_admin_column' => true,
        'show_in_rest' => true,
        'labels' => [
            'singular_name' => __('Category', 'ndp-projects-plugin'),
            'all_items' => __('All Categories', 'ndp-projects-plugin'),
            'edit_item' => __('Edit Category', 'ndp-projects-plugin'),
            'view_item' => __('View Category', 'ndp-projects-plugin'),
            'update_item' => __('Update Category', 'ndp-projects-plugin'),
            'add_new_item' => __('Add New Category', 'ndp-projects-plugin'),
            'new_item_name' => __('New Category Name', 'ndp-projects-plugin'),
            'search_items' => __('Search Categories', 'ndp-projects-plugin'),
            'parent_item' => __('Parent Category', 'ndp-projects-plugin'),
            'parent_item_colon' => __('Parent Category:', 'ndp-projects-plugin'),
            'not_found' => __('No Categories found', 'ndp-projects-plugin'),
        ]
    ]);
    register_taxonomy_for_object_type('project_category', 'project');


    register_taxonomy('project_status', ['project'], [
        'label' => __('Statuses', 'ndp-projects'),
        'hierarchical' => true,
        'rewrite' => ['slug' => 'project-status'],
        'show_admin_column' => true,
        'show_in_rest' => true,
        'labels' => [
            'singular_name' => __('Status', 'ndp-projects'),
            'all_items' => __('All Statuses', 'ndp-projects'),
            'edit_item' => __('Edit Status', 'ndp-projects'),
            'view_item' => __('View Status', 'ndp-projects'),
            'update_item' => __('Update Status', 'ndp-projects'),
            'add_new_item' => __('Add New Status', 'ndp-projects'),
            'new_item_name' => __('New Status Name', 'ndp-projects'),
            'search_items' => __('Search Statuses', 'ndp-projects'),
            'parent_item' => __('Parent Status', 'ndp-projects'),
            'parent_item_colon' => __('Parent Status:', 'ndp-projects'),
            'not_found' => __('No Statuses found', 'ndp-projects'),
        ]
    ]);
    register_taxonomy_for_object_type('project_status', 'project');

    register_taxonomy('project_tag', ['project'], [
        'label' => __('Tags', 'ndp-projects'),
        'hierarchical' => false,
        'rewrite' => ['slug' => 'project-tag'],
        'show_admin_column' => true,
        'show_in_rest' => true,
        'labels' => [
            'singular_name' => __('Tags', 'ndp-projects'),
            'all_items' => __('All Tags', 'ndp-projects'),
            'edit_item' => __('Edit Tag', 'ndp-projects'),
            'view_item' => __('View Tag', 'ndp-projects'),
            'update_item' => __('Update Tag', 'ndp-projects'),
            'add_new_item' => __('Add New Tag', 'ndp-projects'),
            'new_item_name' => __('New Tag Name', 'ndp-projects'),
            'search_items' => __('Search Tags', 'ndp-projects'),
            'parent_item' => __('Parent Tag', 'ndp-projects'),
            'parent_item_colon' => __('Parent Tag:', 'ndp-projects'),
            'not_found' => __('No Tags found', 'ndp-projects'),
        ]
    ]);
    register_taxonomy_for_object_type('project_tag', 'project');

});


wp_enqueue_style('ndp-projects-styles', plugin_dir_url(__FILE__) . './assets/css/ndp-projects.css');
//wp_enqueue_script( 'ndp_projects-scripts', plugins_url('assets/js/bundle.js',__FILE__ ));


function get_page_by_template($template = '')
{
    $args = array(
        'meta_key' => '_wp_page_template',
        'meta_value' => $template
    );
    return get_pages($args);
}


function add_archive_classes_to_page_templates($classes)
{
    if (is_page_template('projects.php')) {
        $classes[] = 'archive archive-test';
    }
    return $classes;
}
add_filter('body_class', 'add_archive_classes_to_page_templates');



/**
 * By Category
 */
add_action('wp_ajax_filter_posts_by_project_category', 'filter_posts_by_project_category');
add_action('wp_ajax_nopriv_filter_posts_by_project_category', 'filter_posts_by_project_category');

function filter_posts_by_project_category()
{
    $filters = !empty($_POST['filters']) ? $_POST['filters'] : [];
    $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : '';
    $sort_by = isset($_POST['sort_by']) ? sanitize_text_field($_POST['sort_by']) : '';
    $paged = !empty($_POST['page']) ? sanitize_text_field($_POST['page']) : 1;
    $per_page = SHOW_COUNT_CUSTOM_POST_TYPE;
    if ($post_type == 'news') {
        $per_page = NEWS_COUNT_CUSTOM_POST_TYPE;
    }

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => $per_page,
        'post_status' => 'publish',
        'order' => 'DESC',
        'paged' => $paged,
        'orderby' => 'meta_value date',
    );

    $args['meta_query'][] = [
        'key' => 'custom_sticky',
    ];

    if ($sort_by === 'date-asc') {
        $args['order'] = 'ASC';
        $args['orderby'] = [
            'meta_value' => 'DESC',
            'date' => 'ASC'
        ];
    } elseif ($sort_by === 'views') {
        $args['orderby'] = 'meta_value meta_value_num';
        $args['meta_query'][] = [
            'key' => 'post_views_count',
        ];
    }

    $tax_queries = prepareTaxQueriesArray($filters, ['include_children' => false]);

    if (!empty($tax_queries)) {
        $args['tax_query'] = $tax_queries;
    }

    add_filter('posts_orderby', 'filter_case');
    $query = new WP_Query($args);
    remove_filter('posts_orderby', 'filter_case');

    $output = generate_posts_html($query, $post_type, $paged);

    $filters = array_filter($filters, function ($value, $key) {
        return !preg_match('/category/', $key);
    }, ARRAY_FILTER_USE_BOTH);
    $httpGetParams = http_build_query($filters);
    $output['httpGetParams'] = $httpGetParams;
    $output['sql'] = $query->request;

    print_r($output);

    wp_send_json($output);
}




/*
if (function_exists('acf_add_local_field_group')):

    acf_add_local_field_group(
        array(
            'key' => 'group_65d4a3829cea7',
            'title' => 'Project settings!!!',
            'fields' => array(
                array(
                    'key' => 'field_65d4abc2f586c',
                    'label' => 'Location',
                    'name' => 'location',
                    'aria-label' => '',
                    'type' => 'text',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '50',
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
                array(
                    'key' => 'field_65d4abd8418fb',
                    'label' => 'Last updated',
                    'name' => 'last_updated',
                    'aria-label' => '',
                    'type' => 'date_picker',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'wpml_cf_preferences' => 3,
                    'display_format' => 'd.m.Y',
                    'return_format' => 'd.m.Y',
                    'first_day' => 1,
                ),
                array(
                    'key' => 'field_65d4ac3907a6b',
                    'label' => 'Required',
                    'name' => 'required',
                    'aria-label' => '',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'wpml_cf_preferences' => 3,
                    'default_value' => 0,
                    'min' => 0,
                    'max' => '',
                    'placeholder' => '',
                    'step' => '',
                    'prepend' => '',
                    'append' => '(UAH)',
                ),
                array(
                    'key' => 'field_65d4ac6307a6c',
                    'label' => 'Funded by Applicant',
                    'name' => 'funded_by_applicant',
                    'aria-label' => '',
                    'type' => 'range',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'wpml_cf_preferences' => 3,
                    'default_value' => 0,
                    'min' => '',
                    'max' => '',
                    'step' => '',
                    'prepend' => '',
                    'append' => '%',
                ),
                array(
                    'key' => 'field_65d4acf807a6d',
                    'label' => 'Payback Period',
                    'name' => 'payback_period',
                    'aria-label' => '',
                    'type' => 'number',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'wpml_cf_preferences' => 3,
                    'default_value' => 0,
                    'min' => 0,
                    'max' => '',
                    'placeholder' => '',
                    'step' => '',
                    'prepend' => '',
                    'append' => 'years',
                ),
                array(
                    'key' => 'field_65d5ef67c30fe',
                    'label' => 'IRR',
                    'name' => 'irr',
                    'aria-label' => '',
                    'type' => 'range',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'wpml_cf_preferences' => 3,
                    'default_value' => '',
                    'min' => '',
                    'max' => '',
                    'step' => '',
                    'prepend' => '',
                    'append' => '%',
                ),
                array(
                    'key' => 'field_65d4aeb407a6e',
                    'label' => 'GOV partnership',
                    'name' => 'ppp',
                    'aria-label' => '',
                    'type' => 'true_false',
                    'instructions' => 'Public-Private Partnership Format Available',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'wpml_cf_preferences' => 3,
                    'message' => '',
                    'default_value' => 1,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_65d4aed507a6f',
                    'label' => 'Funds Participation',
                    'name' => 'funds_participation',
                    'aria-label' => '',
                    'type' => 'true_false',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '25',
                        'class' => '',
                        'id' => '',
                    ),
                    'wpml_cf_preferences' => 3,
                    'message' => 'Public-Private Partnership Format Available',
                    'default_value' => 0,
                    'ui_on_text' => '',
                    'ui_off_text' => '',
                    'ui' => 1,
                ),
                array(
                    'key' => 'field_65d4aeff07a70',
                    'label' => 'CO2 Reducation Rate',
                    'name' => 'co2_reducation_rate',
                    'aria-label' => '',
                    'type' => 'range',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '25',
                        'class' => '',
                        'id' => '',
                    ),
                    'wpml_cf_preferences' => 3,
                    'default_value' => 0,
                    'min' => 0,
                    'max' => 100,
                    'step' => '',
                    'prepend' => '',
                    'append' => '%',
                ),
                array(
                    'key' => 'field_65d4af2407a71',
                    'label' => 'UN Goals',
                    'name' => 'un_goals',
                    'aria-label' => '',
                    'type' => 'range',
                    'instructions' => 'UN Sustainable Development Goals Checked',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '25',
                        'class' => '',
                        'id' => '',
                    ),
                    'wpml_cf_preferences' => 3,
                    'default_value' => 0,
                    'min' => 0,
                    'max' => 17,
                    'step' => '',
                    'prepend' => '',
                    'append' => 17,
                ),
                array(
                    'key' => 'field_65d4af3f07a72',
                    'label' => 'Rating',
                    'name' => 'rating',
                    'aria-label' => '',
                    'type' => 'range',
                    'instructions' => '',
                    'required' => 1,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'wpml_cf_preferences' => 3,
                    'default_value' => '',
                    'min' => '',
                    'max' => '',
                    'step' => '',
                    'prepend' => '',
                    'append' => '',
                ),
                array(
                    'key' => 'field_65d4af4907a73',
                    'label' => 'Project Documents',
                    'name' => 'project_documents',
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
                    'wpml_cf_preferences' => 3,
                    'layout' => 'table',
                    'pagination' => 0,
                    'min' => 0,
                    'max' => 0,
                    'collapsed' => '',
                    'button_label' => 'Add Row',
                    'rows_per_page' => 20,
                    'sub_fields' => array(
                        array(
                            'key' => 'field_65d4af6807a75',
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
                            'wpml_cf_preferences' => 3,
                            'return_format' => 'array',
                            'library' => 'uploadedTo',
                            'min_size' => '',
                            'max_size' => '',
                            'mime_types' => '',
                            'parent_repeater' => 'field_65d4af4907a73',
                        ),
                    ),
                ),
                array(
                    'key' => 'field_65d4af8307a76',
                    'label' => 'Participants',
                    'name' => 'project_participants',
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
                    'wpml_cf_preferences' => 3,
                    'layout' => 'table',
                    'pagination' => 0,
                    'min' => 0,
                    'max' => 0,
                    'collapsed' => '',
                    'button_label' => 'Add Row',
                    'rows_per_page' => 20,
                    'sub_fields' => array(
                        array(
                            'key' => 'field_65d4af8d07a77',
                            'label' => 'Logo',
                            'name' => 'logo',
                            'aria-label' => '',
                            'type' => 'image',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'wpml_cf_preferences' => 3,
                            'return_format' => 'array',
                            'library' => 'uploadedTo',
                            'min_width' => '',
                            'min_height' => '',
                            'min_size' => '',
                            'max_width' => '',
                            'max_height' => '',
                            'max_size' => '',
                            'mime_types' => '',
                            'preview_size' => 'medium',
                            'parent_repeater' => 'field_65d4af8307a76',
                        ),
                        array(
                            'key' => 'field_65d4af9907a78',
                            'label' => 'Participant',
                            'name' => 'participant',
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
                            'parent_repeater' => 'field_65d4af8307a76',
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => 'project',
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
            'acfml_field_group_mode' => 'localization',
        )
    );

endif;
*/
add_action('acf/init', 'init_my_acf');
function init_my_acf()
{
    acf_add_options_sub_page('txt Importer');
    acf_add_local_field_group('...');
}

/*
function ndp_projects_assets()
{
    wp_register_style('ndp_projects_assets', plugins_url('assets/ndp-projects.css', __FILE__));
    wp_enqueue_style('ndp_projects_assets');
    wp_enqueue_script( 'ndp_projects', plugins_url('assets/js/index.js',__FILE__ ));
    wp_register_script('ndp_projects');
}

add_action('admin_init', 'ndp_projects_assets');
*/

/* Filter the single_template with our custom function*/
add_filter('single_template', 'ndp_single_project_template');
function ndp_single_project_template($single)
{

    global $post;

    /* Checks for single template by post type */

    if ($post->post_type == 'project') {
        if (file_exists(plugin_dir_path(__FILE__) . 'templates/single-project.php')) {
            return plugin_dir_path(__FILE__) . 'templates/single-project.php';
        }
    }

    return $single;

    //echo plugins_url('assets/ndp-projects.css', __FILE__);

}



function ndp_projects_template_array()
{
    $temps = [];

    $temps['projects.php'] = "NDP Projects";

    return $temps;
}

function ndp_projects_template_register($page_templates, $theme, $post)
{

    $templates = ndp_projects_template_array();

    foreach ($templates as $tk => $tv) {

        $page_templates[$tk] = $tv;

    }

    return $page_templates;

}

add_filter('theme_page_templates', 'ndp_projects_template_register', 10, 3);


function ndp_project_template_select($template)
{
    global $post, $wp_query, $wpdb;

    $page_temp_slug = get_page_template_slug($post->ID);

    //echo '<pre>' . print_r($page_temp_slug) . '</pre>';

    $templates = ndp_projects_template_array();

    if (isset($templates[$page_temp_slug])) {
        $template = plugin_dir_path(__FILE__) . 'templates/' . $page_temp_slug;
    }

    return $template;
}

add_filter('template_include', 'ndp_project_template_select', 99);