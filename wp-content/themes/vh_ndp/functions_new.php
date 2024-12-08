<?php
//require 'vendor/autoload.php';
/**
 * NDP functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package NDP
 */


if (!defined('_S_VERSION')) {
    // Replace the version number of the theme on each release.
    define('_S_VERSION', '1.0.0');
}
//file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test2.txt',print_r($_GET,true));
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function vh_ndp_setup()
{
    /*
        * Make theme available for translation.
        * Translations can be filed in the /languages/ directory.
        * If you're building a theme based on NDP, use a find and replace
        * to change 'vh_ndp' to the name of your theme in all the template files.
        */
    load_theme_textdomain('vh_ndp', get_template_directory() . '/languages');

    // Add default posts and comments RSS feed links to head.
    add_theme_support('automatic-feed-links');

    /*
        * Let WordPress manage the document title.
        * By adding theme support, we declare that this theme does not use a
        * hard-coded <title> tag in the document head, and expect WordPress to
        * provide it for us.
        */
    add_theme_support('title-tag');

    /*
        * Enable support for Post Thumbnails on posts and pages.
        *
        * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
        */
    add_theme_support('post-thumbnails');

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus(
        array(
            'menu-1' => esc_html__('Header', 'vh_ndp'),
            'menu-2' => esc_html__('Footer 1', 'vh_ndp'),
            'menu-3' => esc_html__('Footer 2', 'vh_ndp'),
            'menu-4' => esc_html__('Footer 3', 'vh_ndp'),
        )
    );

    /*
        * Switch default core markup for search form, comment form, and comments
        * to output valid HTML5.
        */
    add_theme_support(
        'html5',
        array(
            'search-form',
            'comment-form',
            'comment-list',
            'gallery',
            'caption',
            'style',
            'script',
        )
    );

    // Set up the WordPress core custom background feature.
    add_theme_support(
        'custom-background',
        apply_filters(
            'vh_ndp_custom_background_args',
            array(
                'default-color' => 'ffffff',
                'default-image' => '',
            )
        )
    );

    // Add theme support for selective refresh for widgets.
    add_theme_support('customize-selective-refresh-widgets');

    /**
     * Add support for core custom logo.
     *
     * @link https://codex.wordpress.org/Theme_Logo
     */
    add_theme_support(
        'custom-logo',
        array(
            'height' => 250,
            'width' => 250,
            'flex-width' => true,
            'flex-height' => true,
        )
    );
}

add_action('after_setup_theme', 'vh_ndp_setup');

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function vh_ndp_content_width()
{
    $GLOBALS['content_width'] = apply_filters('vh_ndp_content_width', 640);
}

add_action('after_setup_theme', 'vh_ndp_content_width', 0);

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function vh_ndp_widgets_init()
{
    register_sidebar(
        array(
            'name' => esc_html__('Sidebar', 'vh_ndp'),
            'id' => 'sidebar-1',
            'description' => esc_html__('Add widgets here.', 'vh_ndp'),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget' => '</section>',
            'before_title' => '<h2 class="widget-title">',
            'after_title' => '</h2>',
        )
    );
}

add_action('widgets_init', 'vh_ndp_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function vh_ndp_scripts()
{
    wp_enqueue_style('vh_ndp-style', get_stylesheet_uri(), array(), _S_VERSION);
    wp_style_add_data('vh_ndp-style', 'rtl', 'replace');

    // wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap');

    wp_enqueue_style('slick-theme', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css');
    wp_enqueue_style('slick-css', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css');

    wp_enqueue_style('vh_ndp-documents-css', get_template_directory_uri() . '/assets/css/documets.css');
    wp_enqueue_style('block-post-item', get_template_directory_uri() . '/assets/css/block-post-item.css');


    wp_enqueue_style('vh_ndp-bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap-grid.min.css');
    wp_enqueue_style('theme_carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css');

    wp_enqueue_style('theme_default', get_template_directory_uri() . '/assets/css/owl.theme.default.css');

    wp_enqueue_style('main-min', get_template_directory_uri() . '/assets/css/style.min.css');
    wp_enqueue_style('main-home', get_template_directory_uri() . '/assets/css/home.css');
    wp_enqueue_style('footer', get_template_directory_uri() . '/assets/css/footer.css');
    wp_enqueue_style('main-404', get_template_directory_uri() . '/assets/css/404.css');

    wp_enqueue_script('vh_ndp-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), _S_VERSION, true);
    wp_enqueue_script('vh_ndp-marqueee', get_template_directory_uri() . '/assets/js/marquee.js', array(), _S_VERSION, true);
    wp_enqueue_script('vh_ndp-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
    wp_enqueue_script('js_carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), _S_VERSION, true);
    wp_enqueue_script('slick', 'https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js',  array('jquery'), _S_VERSION, true);
    wp_enqueue_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css' );
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js');

    wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/app.js', array('jquery'), _S_VERSION, true);
    if (is_page('cart')){
        wp_enqueue_script('cart', get_template_directory_uri() . '/assets/js/cart.js', array('jquery'), _S_VERSION, true);
        wp_enqueue_style('cart', get_template_directory_uri() . '/assets/css/cart.css');
        wp_enqueue_style('empty', get_template_directory_uri() . '/assets/css/empty.css');
        wp_enqueue_style('vh_ndp-buttons', get_template_directory_uri() . '/assets/css/buttons.css');
    }

    wp_enqueue_script('main-home-script', get_template_directory_uri() . '/assets/js/home.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('block-post-item', get_template_directory_uri() . '/assets/js/block-post-item.js', array('jquery'));
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    if (is_page('marketplace') || is_product_category() || is_product_taxonomy()) {
        wp_enqueue_style( 'swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css' );
        wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js');
        wp_enqueue_style('vh_ndp-marketplace', get_template_directory_uri() . '/assets/css/marketplace.css',array(),_S_VERSION);
        wp_enqueue_script('vh_ndp-marketplace', get_template_directory_uri() . '/assets/js/marketplace.js', array(), _S_VERSION, true);
        wp_enqueue_style('vh_ndp-buttons', get_template_directory_uri() . '/assets/css/buttons.css');
        wp_enqueue_script('cart', get_template_directory_uri() . '/assets/js/cart.js', array('jquery'), '1.0.0.1', true);
        wp_enqueue_style('cart-prod', get_template_directory_uri() . '/assets/css/cart.css');
        wp_enqueue_style('empty', get_template_directory_uri() . '/assets/css/empty.css');
    }
    if(is_page_template('page-solutions.php')){
        wp_enqueue_script('solutions', get_template_directory_uri() . '/assets/js/solutions.js', array('jquery'), _S_VERSION, true);
        wp_enqueue_style('solutions', get_template_directory_uri() . '/assets/css/solutions.css');
        wp_enqueue_style('empty', get_template_directory_uri() . '/assets/css/empty.css');
        wp_enqueue_style('vh_ndp-buttons', get_template_directory_uri() . '/assets/css/buttons.css');
    }




    if(is_page_template('page-comparison.php')){
        wp_enqueue_style('empty', get_template_directory_uri() . '/assets/css/empty.css');
        wp_enqueue_style('vh_ndp-buttons', get_template_directory_uri() . '/assets/css/buttons.css');
    }
    if(is_page_template('page-training-center.php') || is_page_template('page-training-center_ua.php')){
        wp_enqueue_script('center', get_template_directory_uri() . '/assets/js/training-center.js', array('jquery'), _S_VERSION, true);
        wp_enqueue_style('center', get_template_directory_uri() . '/assets/css/training-center.css');

    }
    if(is_page_template('page-categories.php')){
        wp_enqueue_script('solutions', get_template_directory_uri() . '/assets/js/solutions.js', array('jquery'), _S_VERSION, true);
        wp_enqueue_style('solutions', get_template_directory_uri() . '/assets/css/solutions.css');
        wp_enqueue_style('cart-prod', get_template_directory_uri() . '/assets/css/cart.css');
        wp_enqueue_script('cart-prod-js', get_template_directory_uri() . '/assets/js/cart.js', array('jquery'), _S_VERSION, true);
        wp_enqueue_style('empty', get_template_directory_uri() . '/assets/css/empty.css');
        wp_enqueue_style('vh_ndp-buttons', get_template_directory_uri() . '/assets/css/buttons.css');
    }

    if(is_page('Create Application Type')){
        wp_enqueue_script('application', get_template_directory_uri() . '/react-aplication/build_application/application.js', array(), _S_VERSION, true);
        wp_enqueue_style('application', get_template_directory_uri() . '/react-aplication/build_application/application.css');
    }

    if(is_page('Application engineer')){
        wp_enqueue_script('application', get_template_directory_uri() . '/react-aplication/build_engineer/application.js', array(), _S_VERSION, true);
        wp_enqueue_style('application', get_template_directory_uri() . '/react-aplication/build_engineer/application.css');
    }

    if(is_page('Municipality')){
        wp_enqueue_script('chart', 'https://cdn.jsdelivr.net/npm/chart.js');
        wp_enqueue_script('municipality', get_template_directory_uri() . '/assets/js/municipality.js', array(), _S_VERSION, true);
        wp_enqueue_style('municipality', get_template_directory_uri() . '/assets/css/municipality.css');
    }

    if(is_page('create-application')){
        wp_enqueue_style('vh_ndp-create-application', get_template_directory_uri() . '/assets/css/create-application.css');
    }
    if(is_page_template('page-vendors-list.php')){
        wp_enqueue_script('solutions', get_template_directory_uri() . '/assets/js/solutions.js', array('jquery'), _S_VERSION, true);
        wp_enqueue_style('solutions', get_template_directory_uri() . '/assets/css/solutions.css');
        wp_enqueue_style('empty', get_template_directory_uri() . '/assets/css/empty.css');
        wp_enqueue_style('vh_ndp-buttons', get_template_directory_uri() . '/assets/css/buttons.css');
    }


    if (is_page('Course') || is_singular('course')) {
        wp_enqueue_style('lifterlms-fonts', 'https://fonts.googleapis.com/icon?family=Material+Icons');
        wp_enqueue_style('lifterlms-material', get_template_directory_uri() . '/assets/css/material-components-web.min.css');
        wp_enqueue_script('lifterlms-material', get_template_directory_uri() . '/assets/js/material-components-web.min.js', array('jquery'), _S_VERSION, true);
        wp_enqueue_style('lifterlms-authorization', get_template_directory_uri() . '/assets/css/authorization.css');
        wp_enqueue_style('lifterlms-authorization-govua', get_template_directory_uri() . '/assets/css/registration-govua.css');
        wp_enqueue_script('lifterlms-authorization', get_template_directory_uri() . '/assets/js/authorization.js', array('jquery'), _S_VERSION, true);
        wp_enqueue_style('vh_ndp-course', get_template_directory_uri() . '/assets/css/course.css');
        wp_enqueue_script('vh_ndp-course', get_template_directory_uri() . '/assets/js/course.js', array(), _S_VERSION, true);
        wp_enqueue_script('vh_ndp-authorization', get_template_directory_uri() . '/assets/js/registration-govua.js', array(), _S_VERSION, true);
    }

    function get_application_data_from_external_api( $entry_id ) {
        // Получаем имя хоста из текущего запроса.
        $host_name = $_SERVER['HTTP_HOST'];

        // Формируем URL с использованием динамического хоста.
        $request_url = 'https://' . $host_name . '/wp-json/application/v1/get_entry/' . $entry_id;

        // Отправляем GET-запрос к внешнему API.
        $response = wp_remote_get( $request_url );

        // Проверяем на наличие ошибок.
        if ( is_wp_error( $response ) ) {
            // Обработка ошибки.
            error_log( 'Ошибка при получении данных: ' . $response->get_error_message() );
            return null;
        }

        // Получаем тело ответа и декодируем его из JSON.
        $body = wp_remote_retrieve_body( $response );
        $data = json_decode( $body, true );

        if ( json_last_error() !== JSON_ERROR_NONE ) {
            // Обработка ошибки декодирования JSON.
            error_log( 'Ошибка декодирования JSON: ' . json_last_error_msg() );
            return null;
        }

        // Возвращаем данные.
        return $data;
    }

    if (is_page('green-university')) {
        wp_enqueue_style('vh_ndp-green', get_template_directory_uri() . '/assets/css/green.css');
        wp_enqueue_script('vh_ndp-green', get_template_directory_uri() . '/assets/js/green.js', array(), _S_VERSION, true);
    }
    if (is_page('contacts')) {
        wp_enqueue_style('vh_ndp-contacts', get_template_directory_uri() . '/assets/css/material-components-web.min.css');
        wp_enqueue_style('vh_ndp-contact', get_template_directory_uri() . '/assets/css/contact.css');
        wp_enqueue_script('vh_ndp-contact-mask', 'https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js', array('jquery'));
        wp_enqueue_script('map', 'https://maps.googleapis.com/maps/api/js?key=AIzaSyB9aUxEyR_wIGZSzvzFotwRZ_u5tjuTtlw');
        wp_enqueue_script('vh_ndp-contacts', get_template_directory_uri() . '/assets/js/material-components-web.min.js', array(), _S_VERSION, true);
        wp_enqueue_script('vh_ndp-contact', get_template_directory_uri() . '/assets/js/contact.js', array(), _S_VERSION, true);
    }

    if (is_page('about-us')) {
        wp_enqueue_style('vh_ndp-about', get_template_directory_uri() . '/assets/css/about.css');
    }

    if (is_page('privacy-policy')) {
        wp_enqueue_style('vh_ndp-about', get_template_directory_uri() . '/assets/css/privacy-policy.css');
    }

    if (is_page('financing')) {
        wp_enqueue_style('vh_ndp-financing', get_template_directory_uri() . '/assets/css/financing.css');
        wp_enqueue_script('vh_ndp-financing', get_template_directory_uri() . '/assets/js/financing.js', array('jquery'), _S_VERSION, true);
    }

    if (is_product()) {
        wp_enqueue_style('vh_ndp-product', get_template_directory_uri() . '/assets/css/product.css');
        wp_enqueue_script('vh_ndp-product-zoom', 'https://cdn.jsdelivr.net/gh/igorlino/elevatezoom-plus@1.2.3/src/jquery.ez-plus.js');
        wp_enqueue_script('vh_ndp-product', get_template_directory_uri() . '/assets/js/product.js', array('jquery'), _S_VERSION, true);
        wp_enqueue_script('cart-prod-js', get_template_directory_uri() . '/assets/js/cart.js', array('jquery'), _S_VERSION, true);
        wp_enqueue_style('vh_ndp-buttons', get_template_directory_uri() . '/assets/css/buttons.css');
        wp_enqueue_style('empty', get_template_directory_uri() . '/assets/css/empty.css');
        wp_enqueue_style('cart-prod', get_template_directory_uri() . '/assets/css/cart.css');
        wp_enqueue_style('empty', get_template_directory_uri() . '/assets/css/empty.css');

    }

    if (is_page('comparison')) {
        wp_enqueue_style('vh_ndp-comparison', get_template_directory_uri() . '/assets/css/comparison.css');
        wp_enqueue_style('cart-prod', get_template_directory_uri() . '/assets/css/cart.css');
        wp_enqueue_script('vh_ndp-comparison', get_template_directory_uri() . '/assets/js/comparison.js', array(), _S_VERSION, true);
        wp_enqueue_style('empty', get_template_directory_uri() . '/assets/css/empty.css');
    }

    if (is_page('vendors-list')) {
        wp_enqueue_style('vh_ndp-vendors-list', get_template_directory_uri() . '/assets/css/vendors-list.css');
        wp_enqueue_style('cart-prod', get_template_directory_uri() . '/assets/css/cart.css');
        wp_enqueue_script('vh_ndp-vendors-list', get_template_directory_uri() . '/assets/css/vendors-list.js', array(), _S_VERSION, true);
        wp_enqueue_style('empty', get_template_directory_uri() . '/assets/css/empty.css');
    }

    if (is_page('solutions')) {
        wp_enqueue_style('vh_ndp-solutions', get_template_directory_uri() . '/assets/css/solutions.css');
        wp_enqueue_style('cart-prod', get_template_directory_uri() . '/assets/css/cart.css');
        wp_enqueue_style('empty', get_template_directory_uri() . '/assets/css/empty.css');
//        wp_enqueue_script('vh_ndp-solutions', get_template_directory_uri() . '/assets/js/solutions.js', array(), _S_VERSION, true);
    }

    if (is_page('categories')) {
        wp_enqueue_style('vh_ndp-categories', get_template_directory_uri() . '/assets/css/categories.css');
        wp_enqueue_style('cart-prod', get_template_directory_uri() . '/assets/css/cart.css');
        wp_enqueue_style('empty', get_template_directory_uri() . '/assets/css/empty.css');
        wp_enqueue_script('vh_ndp-categories', get_template_directory_uri() . '/assets/js/categories.js', array(), _S_VERSION, true);
    }

    if (is_product_category()) {
        wp_enqueue_style('vh_ndp-categories', get_template_directory_uri() . '/assets/css/categories.css');
        wp_enqueue_script('vh_ndp-categories', get_template_directory_uri() . '/assets/js/categories.js', array(), _S_VERSION, true);
        wp_enqueue_style('cart-prod', get_template_directory_uri() . '/assets/css/cart.css');
        wp_enqueue_script('vh_ndp-categories', get_template_directory_uri() . '/assets/js/categories.js', array(), _S_VERSION, true);
    }

    if (is_tax('sp_smart_brand')) {
        wp_enqueue_style('cart-prod', get_template_directory_uri() . '/assets/css/cart.css');
        wp_enqueue_style('vh_ndp-categories', get_template_directory_uri() . '/assets/css/categories.css');
        wp_enqueue_style('vh_ndp-vendor', get_template_directory_uri() . '/assets/css/vendors-solutions.css');
        wp_enqueue_style('empty', get_template_directory_uri() . '/assets/css/empty.css');
    }

    if ( is_post_type_archive('course') ) {
        wp_enqueue_style('cart-prod', get_template_directory_uri() . '/assets/css/courses-library.css');
        wp_enqueue_script('vh_ndp-categories', get_template_directory_uri() . '/assets/js/courses-library.js', array('jquery'), _S_VERSION, true);
    }

    if (is_llms_account_page()) {

        wp_enqueue_style('lifterlms-fonts', 'https://fonts.googleapis.com/icon?family=Material+Icons');
        wp_enqueue_style('lifterlms-material', get_template_directory_uri() . '/assets/css/material-components-web.min.css');
        wp_enqueue_script('lifterlms-material', get_template_directory_uri() . '/assets/js/material-components-web.min.js', array('jquery'), _S_VERSION, true);
        if (!is_user_logged_in()) {
            wp_enqueue_style('lifterlms-authorization', get_template_directory_uri() . '/assets/css/authorization.css');
            wp_enqueue_style('vh_ndp-authorization', get_template_directory_uri() . '/assets/css/registration-govua.css');
            wp_enqueue_script('lifterlms-llms', get_template_directory_uri() . '/assets/js/llms.js', array('jquery'), _S_VERSION, true);
            wp_enqueue_script('lifterlms-authorization', get_template_directory_uri() . '/assets/js/authorization.js', array('jquery'), _S_VERSION, true);
            wp_enqueue_script('vh_ndp-authorization', get_template_directory_uri() . '/assets/js/registration-govua.js', array(), _S_VERSION, true);
        } else {
            $endpointSlug  = LLMS_Student_Dashboard::get_current_tab( 'slug' );
            wp_enqueue_style('lifterlms-dashboard-main', get_template_directory_uri() . '/assets/css/dashboard-main.css');
            wp_enqueue_style('lifterlms-izimodal', WP_PLUGIN_URL . '/lifterlms/assets/vendor/izimodal/iziModal.min.css?ver=1.5.1');
            wp_enqueue_script('lifterlms-izimodal', WP_PLUGIN_URL . '/lifterlms/assets/vendor/izimodal/iziModal.min.js?ver=1.5.1', array('jquery'), _S_VERSION, true);
            wp_enqueue_script('lifterlms-dashboard-main', get_template_directory_uri() . '/assets/js/dashboard-main.js', array('jquery'), _S_VERSION, true);

            if ($endpointSlug == 'dashboard') {
                wp_enqueue_style('lifterlms-dashboard', get_template_directory_uri() . '/assets/css/dashboard.css');
                wp_enqueue_script('lifterlms-dashboard', get_template_directory_uri() . '/assets/js/dashboard.js', array('jquery'), _S_VERSION, true);
            } elseif ($endpointSlug == 'applications') {
                wp_enqueue_style('lifterlms-applications', get_template_directory_uri() . '/assets/css/applications.css');
                wp_enqueue_script('lifterlms-applications', get_template_directory_uri() . '/assets/js/applications.js', array('jquery'), _S_VERSION, true);
            } elseif ($endpointSlug == 'requests') {
                wp_enqueue_style('lifterlms-main-municipality', get_template_directory_uri() . '/assets/css/main.municipality.css');
                wp_enqueue_script('lifterlms-select2', get_template_directory_uri() . '/assets/js/select2.js', array('jquery'), _S_VERSION, true);
                wp_enqueue_script('lifterlms-requests', get_template_directory_uri() . '/assets/js/common.municipality.js', array('jquery'), _S_VERSION, true);
            } elseif ($endpointSlug == 'view-courses') {
                wp_enqueue_style('lifterlms-my-courses', get_template_directory_uri() . '/assets/css/my-courses.css');
                wp_enqueue_script('lifterlms-my-courses', get_template_directory_uri() . '/assets/js/my-courses.js', array('jquery'), _S_VERSION, true);
            } elseif ($endpointSlug == 'view-certificates') {
                if (isset($_GET['upload'])) {
                    wp_enqueue_script('vh_ndp-contact-mask', 'https://unpkg.com/dropzone@5/dist/min/dropzone.min.js', array('jquery'));
                    wp_enqueue_style('upload-datepicker', get_template_directory_uri() . '/assets/css/datepicker.css');
                    wp_enqueue_script('upload-datepicker', get_template_directory_uri() . '/assets/js/datepicker-full.min.js', array('jquery'), _S_VERSION, true);
                    wp_enqueue_script('upload-datepicker-locale-uk', 'https://cdn.jsdelivr.net/npm/vanillajs-datepicker@1.3.4/dist/js/locales/uk.js', array('upload-datepicker'));
                    wp_enqueue_style('upload-bootstrap', get_template_directory_uri() . '/assets/css/bootstrap-grid.min.css');
                    wp_enqueue_script('upload-bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', array('jquery'), _S_VERSION, true);
                    wp_enqueue_style('upload-material', get_template_directory_uri() . '/assets/css/material-components-web.min.css');
                    wp_enqueue_script('upload-material', get_template_directory_uri() . '/assets/js/material-components-web.min.js', array('jquery'), _S_VERSION, true);
                    wp_enqueue_style('upload-certificate', get_template_directory_uri() . '/assets/css/upload-certificate.css');
                    wp_enqueue_script('upload-certificate', get_template_directory_uri() . '/assets/js/upload-certificate.js', array('jquery'), _S_VERSION, true);
                } else {
                    wp_enqueue_style('lifterlms-certificates', get_template_directory_uri() . '/assets/css/certificates.css');
                    wp_enqueue_script('lifterlms-certificates', get_template_directory_uri() . '/assets/js/certificates.js', array('jquery'), _S_VERSION, true);
                }
            } elseif ($endpointSlug == 'notifications') {
                wp_enqueue_style('lifterlms-notifications', get_template_directory_uri() . '/assets/css/notifications.css');
                wp_enqueue_script('lifterlms-notifications', get_template_directory_uri() . '/assets/js/notifications.js', array('jquery'), _S_VERSION, true);
            } elseif ($endpointSlug == 'municipalities') {
                wp_enqueue_script('vh_ndp-contact-mask', 'https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js', array('jquery'));
                wp_enqueue_style('lifterlms-main-municipality', get_template_directory_uri() . '/assets/css/main.municipality.css');
                wp_enqueue_script('lifterlms-select2', get_template_directory_uri() . '/assets/js/select2.js', array('jquery'), _S_VERSION, true);
                wp_enqueue_script('lifterlms-municipality', get_template_directory_uri() . '/assets/js/common.municipality.js', array('jquery'), _S_VERSION, true);
            } elseif ($endpointSlug == 'edit-account') {
                wp_enqueue_script('vh_ndp-contact-mask', 'https://cdn.jsdelivr.net/npm/jquery.maskedinput@1.4.1/src/jquery.maskedinput.min.js', array('jquery'));
                wp_enqueue_style('lifterlms-profile', get_template_directory_uri() . '/assets/css/profile-settings.css');
                wp_enqueue_script('lifterlms-llms', get_template_directory_uri() . '/assets/js/llms.js', array('jquery'), _S_VERSION, true);
                wp_enqueue_script('lifterlms-profile', get_template_directory_uri() . '/assets/js/profile-settings.js', array('jquery'), _S_VERSION, true);
            }
        }
    }

    if (is_page_template('page-confirm-email.php')) {
        wp_enqueue_style('lifterlms-material', get_template_directory_uri() . '/assets/css/material-components-web.min.css');
        wp_enqueue_script('lifterlms-material', get_template_directory_uri() . '/assets/js/material-components-web.min.js', array('jquery'), _S_VERSION, true);

        wp_enqueue_style('lifterlms-fonts', 'https://fonts.googleapis.com/icon?family=Material+Icons');
        wp_enqueue_style('vh_ndp-confirm', get_template_directory_uri() . '/assets/css/confirm-email.css');
        wp_enqueue_script('vh_ndp-confirm', get_template_directory_uri() . '/assets/js/confirm-email.js', array(), _S_VERSION, true);
        wp_localize_script('vh_ndp-confirm', 'ServerInfo', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('user_activation_nonce')
        ));
    }

    if (is_singular('lesson')) {
        wp_enqueue_style('lifterlms-notifications', get_template_directory_uri() . '/assets/css/course-training.css');
        wp_enqueue_script('lifterlms-notifications', get_template_directory_uri() . '/assets/js/course-training.js', array('jquery'), _S_VERSION, true);
    }

    elseif (is_singular('llms_quiz')) {
        wp_enqueue_style('lifterlms-material', get_template_directory_uri() . '/assets/css/material-components-web.min.css');
        wp_enqueue_script('lifterlms-material', get_template_directory_uri() . '/assets/js/material-components-web.min.js', array('jquery'), _S_VERSION, true);
        wp_enqueue_style('lifterlms-notifications', get_template_directory_uri() . '/assets/css/course-quiz.css');
        wp_enqueue_script('lifterlms-notifications', get_template_directory_uri() . '/assets/js/course-quiz.js', array('jquery'), _S_VERSION, true);
    }


    wp_enqueue_script('vh_ndp-documents-js', get_template_directory_uri() . '/assets/js/documets.js');
}

add_action('wp_enqueue_scripts', 'vh_ndp_scripts');


add_action('wp_ajax_update_cart_item_quantity', 'update_cart_item_quantity_callback');

function custom_llms_get_page_id($page_name) {
    // Получение ID страницы из LifterLMS
    $page_id = llms_get_page_id($page_name);

    // Если WPML активен, получите переведенный ID страницы
    if (function_exists('wpml_object_id_filter')) {
        $page_id = apply_filters('wpml_object_id', $page_id, 'page', true);
    }

    return $page_id;
}

// Затем обновите is_llms_account_page, чтобы использовать вашу новую функцию
function is_llms_account_page() {
    return (is_page(custom_llms_get_page_id('myaccount')) || apply_filters('lifterlms_is_account_page', false));
}



function update_cart_item_quantity_callback() {
    // Проверяем наличие необходимых данных в POST-запросе
    if (!isset($_POST['cart_item_key']) || !isset($_POST['quantity'])) {
        echo json_encode(['success' => false, 'message' => 'Missing data']);
        wp_die();
    }

    $cart_item_key = sanitize_text_field($_POST['cart_item_key']);
    $quantity = intval($_POST['quantity']);

    // Проверяем, существует ли товар с таким cart_item_key в корзине
    if (!isset(WC()->cart->get_cart()[$cart_item_key])) {
        echo json_encode(['success' => false, 'message' => 'Invalid cart item key']);
        wp_die();
    }

    // Устанавливаем новое количество для товара в корзине
    WC()->cart->set_quantity($cart_item_key, $quantity);

    echo json_encode(['success' => true, 'message' => 'Quantity updated']);
    wp_die();
}

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
if (defined('JETPACK__VERSION')) {
    require get_template_directory() . '/inc/jetpack.php';
}

/**
 * Load WooCommerce compatibility file.
 */
if (class_exists('WooCommerce')) {
    require get_template_directory() . '/inc/woocommerce.php';
}

/**
 * Implement ajax hundlers
 */
require get_template_directory() . '/inc/ajax.php';


/**
 * Custom Guttenberg Blocks
 */
function enqueue_newsletter_block_assets()
{
    wp_enqueue_script(
        'newsletter-block',
        get_template_directory_uri() . '/gutenberg/newsletter-block/newsletter-block.js', // Путь к вашему файлу index.js
        array('wp-blocks', 'wp-editor', 'wp-components'), // Зависимости, которые нужно загрузить
        filemtime(get_template_directory() . '/gutenberg/newsletter-block/newsletter-block.js') // Версия файла (чтобы избежать кеширования)
    );
    wp_enqueue_style('newsletter-block', get_template_directory_uri() . '/gutenberg/newsletter-block/style.css', array(), _S_VERSION);


    wp_enqueue_script(
        'download-block',
        get_template_directory_uri() . '/gutenberg/download-block/download-block.js', // Путь к вашему файлу download-block.js
        array('wp-blocks', 'wp-editor', 'wp-components'), // Зависимости, которые нужно загрузить
        filemtime(get_template_directory() . '/gutenberg/download-block/download-block.js') // Версия файла (чтобы избежать кеширования)
    );
    wp_enqueue_style('download-block', get_template_directory_uri() . '/gutenberg/download-block/style.css', array(), _S_VERSION);
}

add_action('enqueue_block_editor_assets', 'enqueue_newsletter_block_assets');


/**
 * Регистрация кастомного типа постов
 */
function register_custom_post_type()
{

    // "News"
    register_post_type('news',
        array(
            'labels' => array(
                'name' => 'News',
                'singular_name' => 'News',
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'capability_type' => 'post',
            'show_in_rest' => true, // Включаем поддержку Гутенберга
        )
    );

    // Создание таксономии "Category" для кастомного типа "News"
    register_taxonomy('news_category', 'news', array(
        'label' => 'News Categories',
        'hierarchical' => true,
        'rewrite' => array('slug' => 'news-category'),
        'show_in_rest' => true, // Включаем поддержку Гутенберга
    ));

    // Создание таксономии "Tag" для кастомного типа "News"
    register_taxonomy('news_tag', 'news', array(
        'label' => 'News Tags',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'news-tag'),
        'show_in_rest' => true, // Включаем поддержку Гутенберга
    ));


    // "Knowledge base"
    register_post_type('knowledge-base',
        array(
            'labels' => array(
                'name' => 'Knowledge base',
                'singular_name' => 'Knowledge base',
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'show_in_rest' => true, // Включаем поддержку Гутенберга
        )
    );

    // Создание таксономии "Category" для кастомного типа "Articles"
    register_taxonomy('knowledge-base_category', 'knowledge-base', array(
        'label' => 'Knowledge base Categories',
        'hierarchical' => true,
        'rewrite' => array('slug' => 'knowledge-base-category'),
        'show_in_rest' => true, // Включаем поддержку Гутенберга
    ));

    // Создание таксономии "Tag" для кастомного типа "Articles"
    register_taxonomy('knowledge-base_tag', 'knowledge-base', array(
        'label' => 'Knowledge base Tags',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'knowledge-base-tag'),
        'show_in_rest' => true, // Включаем поддержку Гутенберга
    ));


    // "Cases"
    register_post_type('cases',
        array(
            'labels' => array(
                'name' => 'Cases',
                'singular_name' => 'Case',
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'show_in_rest' => true, // Включаем поддержку Гутенберга
        )
    );

    // Создание таксономии "Category" для кастомного типа "Cases"
    register_taxonomy('cases_category', 'cases', array(
        'label' => 'Case Categories',
        'hierarchical' => true,
        'rewrite' => array('slug' => 'cases-category'),
        'show_in_rest' => true, // Включаем поддержку Гутенберга
    ));

    // Создание таксономии "Tag" для кастомного типа "Cases"
    register_taxonomy('cases_tag', 'cases', array(
        'label' => 'Case Tags',
        'hierarchical' => false,
        'rewrite' => array('slug' => 'cases-tag'),
        'show_in_rest' => true, // Включаем поддержку Гутенберга
    ));

}

add_action('init', 'register_custom_post_type');


/**
 * Закрепленные посты
 */
function add_custom_sticky_column($columns)
{
    $columns['custom_sticky'] = 'Make this post sticky';
    return $columns;
}

function populate_custom_sticky_column($column, $post_id)
{
    if ($column === 'custom_sticky') {
        $is_sticky = get_post_meta($post_id, 'custom_sticky', true);
        echo '<label><input type="checkbox" name="custom_sticky" value="' . $is_sticky . '" ' . checked($is_sticky, 'on', false) . '>Make this post sticky</label>';
    }
}

function add_custom_quick_edit_script()
{
    global $current_screen;
    $allowed_post_types = array('news', 'knowledge-base', 'cases');

    if (in_array($current_screen->post_type, $allowed_post_types)) {
        ?>
        <style>
            #custom_sticky {
                width: 150px;
            }
        </style>
        <script>
            jQuery(document).ready(function ($) {

                // let stickyPostCounter = 0
                // $('[name="custom_sticky"]').each(function () {
                //     stickyPostCounter++
                //     if (stickyPostCounter > 4 && $(this).attr('value') === 'on') {
                //         console.log(stickyPostCounter)
                //         $('[name="custom_sticky"]').attr('disabled', 'true')
                //         return false
                //     }
                // })

                $(document).on('change', '[name="custom_sticky"]', function () {
                    let parent = $(this).closest('tr')
                    let isChecked = $(this).prop('checked')
                    let post_id = parent.attr('id').replace('post-', '')

                    $.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            action: 'update_custom_sticky',
                            post_id: post_id,
                            is_sticky: isChecked ? 'on' : 'off',
                            post_type: '<?php echo $current_screen->post_type; ?>'
                        },
                        beforeSend: function () {
                            parent.css('opacity', '.5')
                        },
                        success: function (response) {
                            console.log(response)
                            parent.css('opacity', '1');

                            if (response && response.hasOwnProperty('switchOff')) {
                                let ids = response['switchOff'];
                                for (let id in ids) {
                                    let $tr = $('#the-list').find('#post-'+ids[id]);
                                    if ($tr.length) {
                                        $tr.find(".custom_sticky").find('input').prop('checked', false);
                                    }
                                }
                            }
                        }
                    })
                })
            })
        </script>
        <?php
    }
}

function update_custom_sticky()
{
    $post_id = $_POST['post_id'];
    $is_sticky = $_POST['is_sticky'];
    $post_type = $_POST['post_type'];

    $post_data = array(
        'ID' => $post_id,
    );
    wp_update_post($post_data);
    update_post_meta($post_id, 'custom_sticky', $is_sticky);

    $response = [];

    if ($is_sticky === 'on') {
        $args = [
            'post_type' => $post_type,
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'meta_query' => [
                [
                    'key' => 'custom_sticky',
                    'value' => 'on'
                ],
            ],
            'orderby' => 'modified',
            'order' => 'DESC'
        ];

        $newest_post = new WP_Query($args);
        $new_dates = array();
        $postsData = [];
        $countSticky = 0;


        if ($newest_post->have_posts()) {
            while ($newest_post->have_posts()) {
                $newest_post->the_post();

                $ID = get_the_ID();
                $newest_post_date = get_the_date('Y-m-d H:i:s');
                $new_dates[] = $newest_post_date;
                $custom_sticky = get_post_meta($ID, 'custom_sticky', true);
                if ($custom_sticky && $custom_sticky == 'on') {
                    $countSticky++;
                }
                $postsData[$ID] = [
                    'id' => $ID,
                    'title' => get_the_title(),
                    'date' => $newest_post_date,
                    'sticky' => $custom_sticky,
                ];
            }
        }
        wp_reset_postdata();


        if ($countSticky > 4) {

          $num = 1;
          $swithOffPosts = [];
          foreach ($postsData as $id => $data) {
              if ($num > 4) {
                  update_post_meta($id, 'custom_sticky', 'off');
                  $swithOffPosts[] = $id;
              }
              $num++;
          }
          $response['switchOff'] = $swithOffPosts;

        }
    }

    wp_send_json($response);
}

add_filter('manage_edit-news_columns', 'add_custom_sticky_column');
add_filter('manage_edit-knowledge-base_columns', 'add_custom_sticky_column');
add_filter('manage_edit-cases_columns', 'add_custom_sticky_column');

add_action('manage_news_posts_custom_column', 'populate_custom_sticky_column', 10, 2);
add_action('manage_knowledge-base_posts_custom_column', 'populate_custom_sticky_column', 10, 2);
add_action('manage_cases_posts_custom_column', 'populate_custom_sticky_column', 10, 2);

add_action('admin_footer-edit.php', 'add_custom_quick_edit_script');
add_action('wp_ajax_update_custom_sticky', 'update_custom_sticky');


/**
 * Breadcrumbs
 */
function generate_breadcrumbs()
{
    $home = __( 'Home', 'Home' );
    if (get_post_type() === 'news') {
        $home = __( 'Main Page', 'Home' );
    }
    $breadcrumbs = '<nav class="breadcrumb">';
    $breadcrumbs .= '<a href="' . esc_url(home_url('/')) . '">'.$home.'</a>';

    if (is_single()) {
        $taxonomy_cat = '';
        $taxonomy_slug = '';

        if (get_post_type() === 'news') {
            $taxonomy_cat = 'News';
            $taxonomy_slug = 'news_category';
        } elseif (get_post_type() === 'knowledge-base') {
            $taxonomy_cat = 'Knowledge Base';
            $taxonomy_slug = 'knowledge-base_category';
        } elseif (get_post_type() === 'cases') {
            $taxonomy_cat = 'Cases';
            $taxonomy_slug = 'cases_category';
        }

        if (!empty($taxonomy_cat)) {
            $breadcrumbs .= '<span class="delimiter">  </span>';
            $breadcrumbs .= '<a href="' . esc_url(get_post_type_archive_link(get_post_type())) . '">' . esc_html($taxonomy_cat) . '</a>';
            $breadcrumbs .= '<span class="delimiter">  </span>';
        }

        $terms = get_the_terms(get_the_ID(), $taxonomy_slug);

        if ($terms && !is_wp_error($terms)) {
            $term = reset($terms);
            $term_link = esc_url(get_term_link($term, $taxonomy_slug));
            $breadcrumbs .= '<a href="' . $term_link . '">' . $term->name . '</a>';
        }

        $breadcrumbs .= '<span class="delimiter">  </span>';
        $breadcrumbs .= '<span class="current" title="' . esc_html(get_the_title()) . '">' . esc_html(get_the_title()) . '</span>';
    } elseif (is_category() || is_tax() || is_post_type_archive()) {
        $post_type_label = '';

        if (is_post_type_archive('news')) {
            $post_type_label = 'News';
        } elseif (is_post_type_archive('knowledge-base')) {
            $post_type_label = 'Knowledge Base';
        } elseif (is_post_type_archive('cases')) {
            $post_type_label = 'Cases';
        }

        if (!empty($post_type_label)) {
            $breadcrumbs .= '<span class="delimiter">  </span>';
            $breadcrumbs .= '<span class="current">' . esc_html($post_type_label) . '</span>';
        }

        if (is_category() || is_tax()) {

        } elseif (is_post_type_archive()) {

        }
    } elseif (is_page()) {
        $breadcrumbs .= '<span class="delimiter">  </span>';
        $breadcrumbs .= '<span class="current">'.get_the_title().'</span>';
    } elseif (is_404()) {
        $breadcrumbs .= '<span class="delimiter">  </span>';
        $breadcrumbs .= '<span class="current">Page 404</span>';
    }

    $breadcrumbs .= '</nav>';

    return $breadcrumbs;
}


/**
 * Функция количества просмотров поста
 */
function get_post_views($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);

    if ($count === '') {
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
        return "0 Views";
    }
    return $count . ' Views';
}

function set_post_views($postID)
{
    $count_key = 'post_views_count';
    $count = get_post_meta($postID, $count_key, true);
    if ($count === '') {
        $count = 0;
        delete_post_meta($postID, $count_key);
        add_post_meta($postID, $count_key, '0');
    } else {
        $count++;
        update_post_meta($postID, $count_key, $count);
    }
}

// Запуск функции при просмотре поста
function track_post_views($post_id)
{
    if (!is_single()) return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    set_post_views($post_id);
}

add_action('wp_head', 'track_post_views');


/**
 * Функция, которая будет определять разницу между текущим временем и временем публикации поста, а затем форматировать вывод соответственно требованиям
 */
function custom_time_ago($post_time)
{
    $current_time = current_time('timestamp');
    $post_time_diff = $current_time - $post_time;

    if ($post_time_diff < 3600) {
        $minutes = ceil($post_time_diff / 60);
        if ($minutes === 1) {
            return __('1 min ago', 'ndp');
        } else {
            return "" . sprintf( __( '%d mins ago', 'ndp' ), $minutes );
        }
    } elseif ($post_time_diff < 86400) {
        $hours = floor($post_time_diff / 3600);
        if ($hours === 1) {
            return __('1 hour ago', 'ndp');
        } else {
            return "" . sprintf( __( '%d hours ago', 'ndp' ), $hours );
        }
    } else {
        return date_i18n("d.m.y", $post_time);
    }
}


/**
 * Функция для расчета примерного времени чтения поста
 */
function approximate_reading_time($post_content)
{
    // Очищаем текст от HTML-тегов, чтобы подсчитать только слова
    $cleaned_content = wp_strip_all_tags($post_content);

    // Получаем массив слов из текста поста
    $words_array = preg_split('/\s+/', $cleaned_content);

    // Подсчитываем количество слов
    $word_count = count($words_array);

    // Оцениваем среднее время чтения (приблизительно 200 слов в минуту)
    $words_per_minute = 200;
    $reading_time_minutes = ceil($word_count / $words_per_minute);

    return $reading_time_minutes;
}


/**
 * Функция замены стандартной функции get_the_excerpt()
 */
function trim_title_length($title) {
    $max_length = 65;
    if (mb_strlen($title) > $max_length) {
        $title = mb_substr($title, 0, $max_length) . '...';
    }
    return $title;
}

function custom_get_the_excerpt($post, $excerpt_length = 150, $more_text = '...')
{
    $post_excerpt = $post->post_excerpt;

    if (empty($post_excerpt)) {
        $post_content = $post->post_content;

        // Очищаем текст от HTML-тегов, чтобы подсчитать символы
        $cleaned_content = wp_strip_all_tags($post_content);

        // Обрезаем текст до заданной длины
        $post_excerpt = mb_substr($cleaned_content, 0, $excerpt_length);

        // Проверяем, есть ли необработанный текст, который следует добавить в конце
        if (mb_strlen($cleaned_content) > $excerpt_length) {
            $post_excerpt .= $more_text;
        }
    }

    return apply_filters('get_the_excerpt', $post_excerpt);
}

function register_ndp_session()
{
    if (!session_id()) {
        session_start();
    }
}
add_action('init', 'register_ndp_session');


//Wizard settings page
add_action('admin_menu', 'register_wizard_submenu_page');
function register_wizard_submenu_page() {
    add_submenu_page(
        'edit.php?post_type=course',
        __('Wizard settings'),
        __('Wizard'),
        'manage_options',
        'wizard-page',
        'wizard_custom_submenu_page_callback'
    );
}

// контент страницы wizard
function wizard_custom_submenu_page_callback() {
    wp_enqueue_style('wizard-draggable', get_template_directory_uri() . '/assets/css/jquery-ui-draggable.min.css');
    wp_enqueue_style('wizard', get_template_directory_uri() . '/assets/css/wizard.css');
    wp_enqueue_script('wizard-draggable', get_template_directory_uri() . '/assets/js/jquery-ui-draggable.min.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('wizard-punch', get_template_directory_uri() . '/assets/js/jquery.ui.touch-punch.min.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('wizard-sticky', get_template_directory_uri() . '/assets/js/sticky-sidebar.min.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_script('wizard', get_template_directory_uri() . '/assets/js/wizard.js', array('jquery'), _S_VERSION, true);

    require_once get_template_directory() . '/inc/wizard.php';
}


$perPage = get_option( 'posts_per_page' );
define('NEWS_COUNT_CUSTOM_POST_TYPE', 16);//posts_per_page
define('SHOW_COUNT_CUSTOM_POST_TYPE', $perPage ?? 9);//posts_per_page


//сортировка по прикреплённым постам и по дате изменения
add_action('pre_get_posts',  'setup_custom_post_type');
function setup_custom_post_type( $query ) {
    $queriedObject = get_queried_object();
    $allowedTypes = ['news', 'knowledge-base', 'cases', 'cases_category', 'knowledge-base_category'];

    if (!is_admin() && $query->is_main_query() && (is_archive() || $query->is_post_type_archive() || is_post_type_archive())) {

        if ((!empty($queriedObject->name) && in_array($queriedObject->name, $allowedTypes)) || (!empty($queriedObject->taxonomy) && in_array($queriedObject->taxonomy, $allowedTypes))) {
            $per_page = SHOW_COUNT_CUSTOM_POST_TYPE;
            if ($queriedObject->name=='news') {
                $per_page = NEWS_COUNT_CUSTOM_POST_TYPE;
            }

            $query->set('posts_per_page', $per_page);
            $query->set('orderby', 'meta_value date');
            $query->set('meta_key', 'custom_sticky');

            if (!empty($_GET)) {
                $tax_queries = prepareTaxQueriesArray($_GET);

                if (!empty($tax_queries)) {
                    $query->set('tax_query', $tax_queries);
                }
            }
        }
    }

    return $query;
}


/**
 * Сохранение custom_sticky для пагинации и сортировки
 */
add_action( 'save_post_news', 'update_custom_post_type', 10, 3);
add_action( 'save_post_cases', 'update_custom_post_type', 10, 3);
add_action( 'save_post_knowledge-base', 'update_custom_post_type', 10, 3);
function update_custom_post_type($post_id, $post, $update) {

    // Если это ревизия, то не отправляем письмо
    if ( wp_is_post_revision($post_id) || $update){
        return;
    }

    update_post_meta($post_id, 'custom_sticky', 'off');
}


function update_query_string_for_main_query($query)
{
    if (!is_admin()) {
        $allowedTypes = ['news', 'knowledge-base', 'cases'];

        if (preg_match('/news|knowledge-base|cases/', $_SERVER['REQUEST_URI']) != false && (array_key_exists('post_type', $query) && in_array($query['post_type'], $allowedTypes))) {
            if (array_key_exists('news_category', $query)) {
                unset($query['news_category']);
            }
            if (array_key_exists('news_tag', $query)) {
                unset($query['news_tag']);
            }
        }
    }
    return $query;
}
add_filter('request', 'update_query_string_for_main_query', 1);


/**
 * Data from number_of_views table
 * @param string $type
 */
function getNumbersOfViewsByType(string $type) {
    global $wpdb;

    $result = [];
    $type = !empty($type)? sanitize_text_field($type) : '';
    if (!$type) return;

    $tableName = $wpdb->prefix .'number_of_views';

    $sql = "SELECT * FROM `{$tableName}` WHERE entity_type='{$type}'";

    $views = $wpdb->get_results($sql, ARRAY_A);
    if (!empty($views)) {

        function sortByViews($a, $b) {
            if ($a['views'] > $b['views']) {
                return 1;
            } elseif ($a['views'] < $b['views']) {
                return -1;
            }
            return 0;
        }

        usort($views, 'sortByViews');
        $result = $views;
    }

    return $result;
}


/**
 * Подготовка tax_query для WP_Query
 * @param $filtersArray например knowledge-base_tag или knowledge-base_category
 * @return array|string[]
 */
function prepareTaxQueriesArray(array $filtersArray, array $additionalParams = null):array {

    if (empty($filtersArray)) return [];

    $tax_queries = [];

    $key = 0;
    foreach ($filtersArray as $taxonomy => $filterList) {
        $taxonomy = sanitize_text_field($taxonomy);
        if (!get_taxonomy($taxonomy) || checkIfPostTypeAttributes($taxonomy)) continue;

        $tax_query = [];
        $tax_query['taxonomy'] = $taxonomy;
        $tax_query['field'] = 'slug';

        if (is_array($filterList)) {
            foreach ($filterList as $key => $filter) {
                $filter = sanitize_text_field($filter);

                $tax_query['terms'][] = $filter;
                $and = 'AND';
                if ($taxonomy === 'product_cat') {
                    $and = 'IN';
                }
                $tax_query['operator'] = $and;
                if (!empty($additionalParams) && isset($additionalParams['include_children']) && is_bool($additionalParams['include_children'])) {
                    $tax_query['include_children'] = $additionalParams['include_children'];
                }
            }
        } elseif (is_string($filterList)) {
            $filter = sanitize_text_field($filterList);

            $tax_query['terms'][] = $filter;
            $and = 'AND';
            if ($taxonomy === 'product_cat') {
                $and = 'IN';
            }
            $tax_query['operator'] = $and;
            if (!empty($additionalParams) && isset($additionalParams['include_children']) && is_bool($additionalParams['include_children'])) {
                $tax_query['include_children'] = $additionalParams['include_children'];
            }
            $key++;
        }
        $tax_queries[] = $tax_query;
    }

    if (!empty($tax_queries)) {
        $tax_queries['relation'] = 'AND';
    }

    return $tax_queries;
}




/**
 * Подготовка meta_query для WP_Query
 * @param $filtersArray
 * @return array|string[]
 */
function prepareMetaQueriesArray(array $filtersArray):array {

    if (empty($filtersArray)) return [];

    $meta_queries = [];
    $relation = '';
    if (!empty($filtersArray['relation']) && in_array($filtersArray['relation'], ['AND','OR'])) {
        $relation = $filtersArray['relation'];
        unset($filtersArray['relation']);
    }

    foreach ($filtersArray as $key => $filterList) {
        $key = sanitize_text_field($key);
        if (get_taxonomy($key) || checkIfPostTypeAttributes($key)) continue;

        $meta_query = [];
        if (is_array($filterList)) {
            foreach ($filterList as $k => $filter) {
                $query = [];
                $filter = sanitize_text_field($filter);
                if ($key) {
                    $query['key'] = $key;
                }
                if ($filter) {
                    $query['value'] = $filter;
                }
                $meta_query[] = $query;
            }
        } else {
            $query = [];
            $filter = sanitize_text_field($filterList);
            if ($key) {
                $query['key'] = $key;
            }
            if ($filter) {
                $query['value'] = $filter;
            }
            $meta_query[] = $query;
        }
        $meta_queries[] = $meta_query;
    }

    if (!empty($meta_queries) && !empty($relation)) {
        $meta_queries['relation'] = $relation;
    }

    return $meta_queries;
}

/**
 * Проверяет содержит ли фильтр атрибуты соответствующие типу post, page
 * @param $filters
 * @return bool
 */
function checkIfPostTypeAttributes(string $filter) {
    $postAttributes = [
        'title','name','pagename','post_parent','author','author_name',
    ];

    $filter = sanitize_text_field($filter);
    if (in_array($filter, $postAttributes)) {
        return true;
    }
    return false;
}

/**
 * Подготовка параметров записи для запроса WP_Query (post_title, post_type)
 * @param array $filtersArray
 * @return array
 */
function preparePostDataArray(array $filtersArray):array {

    if (empty($filtersArray)) return [];

    $dataArray = [];

    foreach ($filtersArray as $key => $filterList) {
        $key = sanitize_text_field($key);
        if (!checkIfPostTypeAttributes($key) || get_taxonomy($key)) continue;

        if (is_array($filterList)) {
            foreach ($filterList as $k => $filter) {
                $filter = sanitize_text_field($filter);
                $dataArray[$key] = $filter;
            }
        } else {
            $filter = sanitize_text_field($filterList);
            $dataArray[$key] = $filter;
        }
    }

    return $dataArray;
}


/**
 * Список фильтров для курсов
 * @return array
 */
function getCoursesFilter():array {
//    $roles = LLMS_Roles::get_roles();

    $filters = [];

    $args = array(
        'taxonomy'     => 'course_cat',
        'orderby'      => 'name',
        'hide_empty'   => false,
        'show_count'   => false,
    );
    $categories = get_terms($args);
    $name = getFilterName('course_cat');
    $filters[] = [
        'name' => $name,
        'taxonomy' => 'course_cat',
        'type' => 'taxonomy',
        'values' => $categories,
    ];


    $args = array(
        'taxonomy'     => 'course_tag',
        'orderby'      => 'name',
        'hide_empty'   => false,
        'show_count'   => false,
    );
    $tags = get_terms($args);
    $name = getFilterName('course_tag');
    $filters[] = [
        'name' => $name,
        'taxonomy' => 'course_tag',
        'type' => 'taxonomy',
        'values' => $tags,
    ];


    $args = array(
        'taxonomy'     => 'course_difficulty',
        'orderby'      => 'name',
        'hide_empty'   => false,
        'show_count'   => false,
    );
    $difficulties = get_terms($args);
    $name = getFilterName('course_difficulty');
    $filters[] = [
        'name' => $name,
        'taxonomy' => 'course_difficulty',
        'type' => 'taxonomy',
        'values' => $difficulties,
    ];


    $args = array(
        'taxonomy'     => 'course_track',
        'orderby'      => 'name',
        'hide_empty'   => false,
        'show_count'   => false,
    );
    $difficulties = get_terms($args);
    $name = 'Level';
    $filters[] = [
        'name' => $name,
        'taxonomy' => 'course_track',
        'type' => 'taxonomy',
        'values' => $difficulties,
    ];


    global $wpdb;
    $authors = [];
    $results = $wpdb->get_results("SELECT DISTINCT post_author FROM $wpdb->posts WHERE post_type='course' AND post_status='publish' GROUP BY post_author", ARRAY_A);
    foreach ($results as $row ) {
        $id = $row['post_author'];
        if ($id && $author = get_userdata((int)$id)) {
            $authors[$author->user_nicename] = [
                'ID' => $id,
                'login' => $author->user_login,
                'name' => $author->display_name,
                'nice_name' => $author->user_nicename,
                'postData' => 'author',
                'value' => $id,
            ];
        }
    }
    if (count($authors)) {
        $filters[] = [
            'name' => 'Author',
            'type' => 'postType',//post_title, post_type (not taxonomy or post meta)
            'values' => $authors,
        ];
    }


    $videoDuration = acf_get_fields('group_65192a7840588');
    if (!empty($videoDuration) && !empty($videoDuration[0])) {
        $videoDuration = $videoDuration[0];
        $filters[] = [
            'name' => 'Video Duration',
            'meta_key' => 'video_course_duration',
            'type' => 'meta',
            'values' => $videoDuration['choices'],
        ];
    }


    $language = acf_get_fields('group_6519cd7232111');
    if (!empty($language) && !empty($language[0])) {
        $language = $language[0];
        $filters[] = [
            'name' => 'Language',
            'meta_key' => 'course_language',
            'type' => 'meta',
            'values' => $language['choices'],
        ];
    }


    $paidFree = acf_get_fields('group_651ba6e062cba');
    if (!empty($paidFree) && !empty($paidFree[0])) {
        $paidFree = $paidFree[0];
        $filters[] = [
            'name' => 'Price',
            'meta_key' => 'course_is_paid_free',
            'type' => 'meta',
            'values' => $paidFree['choices'],
        ];
    }

    return $filters;
}
function getCoursesFilterByType(): array {
    $filters = [];

    // Фильтрация курсов, у которых в поле 'type' значение 'true'
    $course_args = array(
        'post_type'   => 'course',
        'numberposts' => -1, // Получить все курсы
        'meta_query'  => array(
            array(
                'key'     => 'type', // Ключ кастомного поля
                'value'   => 1, // Значение, которое мы ищем
                'compare' => '=',    // Тип сравнения
            ),
        ),
    );

    $courses = get_posts($course_args);
    $course_ids = wp_list_pluck($courses, 'ID'); // Получаем массив ID отфильтрованных курсов

    // Фильтр по категориям курсов
    $args = array(
        'taxonomy'     => 'course_cat',
        'orderby'      => 'name',
        'hide_empty'   => false,
        'object_ids'   => $course_ids, // Фильтруем категории на основе отфильтрованных курсов
    );
    $categories = get_terms($args);
    $filters[] = [
        'name' => 'Categories',
        'taxonomy' => 'course_cat',
        'type' => 'taxonomy',
        'values' => $categories,
    ];

    // Фильтр по тегам курсов
    $args = array(
        'taxonomy'     => 'course_tag',
        'orderby'      => 'name',
        'hide_empty'   => false,
        'object_ids'   => $course_ids, // Фильтруем теги на основе отфильтрованных курсов
    );
    $tags = get_terms($args);
    $filters[] = [
        'name' => 'Tags',
        'taxonomy' => 'course_tag',
        'type' => 'taxonomy',
        'values' => $tags,
    ];

    // Дополнительные фильтры (по сложности, треку и т.д.) могут быть добавлены здесь аналогичным образом

    return $filters;
}
function getFilterName($value) {
    return getNameByTaxonomy($value);
}

function getNameByTaxonomy($taxonomy = '') {
    $taxonomyObject = get_taxonomy($taxonomy);
    $name = ($taxonomyObject instanceof WP_Taxonomy)? $taxonomyObject->labels->menu_name : '';
    return $name;
}


function setupMainQuery($query)
{
    if (!is_admin()) {

        //если есть $_GET-параметры, настройка основного запроса
        if (!empty($query['post_type']) && count($query) > 1) {

            if (!empty($_GET)) {
                $allowedTypes = ['news', 'knowledge-base', 'cases', 'course'];
                if (in_array($query['post_type'], $allowedTypes)) {
                    foreach ($query as $key => $queryItem) {
                        if ($key !== 'post_type' && $key !== 'paged') {
                            unset($query[$key]);
                        }
                    }
                }
            }

        }
    }
    return $query;
}
add_filter('request', 'setupMainQuery', 1);


add_action('pre_get_posts',  'preGetPostSetupMainQuery', 9999);
function preGetPostSetupMainQuery( $query ) {
    $queriedObject = get_queried_object();

    if (!is_admin() && $query->is_main_query()) {

        if (($query->is_post_type_archive() || is_post_type_archive())) {
            if ($queriedObject->name === 'course') {

                //применение $_GET-параметров к основному запросу
                if (!empty($_GET)) {

                    $tax_query = prepareTaxQueriesArray($_GET);
                    if (!empty($tax_query)) {
                        $query->set('tax_query', $tax_query);
                    }

                    $meta_query = prepareMetaQueriesArray($_GET);
                    if (!empty($meta_query)) {
                        $query->set('meta_query', $meta_query);
                    }

                    $data = preparePostDataArray($_GET);
                    if (!empty($data)) {
                        foreach ($data as $key => $item) {
                            if (is_string($key) && checkIfPostTypeAttributes($key) && is_string($item)) {
                                $query->set($key, $item);
                            }
                        }
                    }

                    if (isset($_SESSION) && !empty($_SESSION['sortCourses']) && is_string($_SESSION['sortCourses'])
                        && !empty($_SERVER['HTTP_REFERER']) && preg_match('/\/courses/', $_SERVER['HTTP_REFERER'])) {

                        $courseEnrollCount = [];
                        $sort = trim($_SESSION['sortCourses']);
                        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
                        if ($sort == 'popularity') {

                            //Поиск одинаковых курсов в разных языках и подсчёт количества учащихся в одном курсе на разных языках
                            $courseEnrollCountByLang = [];
                            $innerArgs = [
                                'post_type' => 'course',
                                'posts_per_page' => -1,
                                'post_status' => 'publish',
                                'suppress_filters' => true,
                            ];
                            $innerQuery = new WP_Query($innerArgs);

                            $current_lang = apply_filters( 'wpml_current_language', 'uk' );
                            $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
                            foreach ($innerQuery->posts as $key => $innerPost) {
                                $enrolledCount = $count = 0;
                                $count = (int)get_post_meta($innerPost->ID, '_llms_enrolled_students',true);
                                if (empty($count)) {
                                    $count = 0;
                                }
                                $enrolledCount += $count;
                                $courseEnrollCountByLang[$innerPost->ID]['count'] = $enrolledCount;

                                foreach ($languages as $lang => $langArray) {
                                    $courseID = apply_filters( 'wpml_object_id', $innerPost->ID, 'course', FALSE, $lang );
                                    if (empty($courseID)) continue;

                                    if ($courseID == $innerPost->ID) {
                                        $courseEnrollCountByLang[$innerPost->ID]['lang'] = $lang;
                                    } else {
                                        $count = (int)get_post_meta($courseID, '_llms_enrolled_students',true);
                                        if (empty($count)) {
                                            $count = 0;
                                        }
                                        $enrolledCount += $count;
                                        $courseEnrollCountByLang[$innerPost->ID]['count'] = $enrolledCount;
                                    }

                                }
                            }

                            foreach ($courseEnrollCountByLang as $id => $values) {
                                if ($values['lang'] == $current_lang) {
                                    $courseEnrollCount[$id] = $courseEnrollCountByLang[$id]['count'];
                                }
                            }
                            arsort($courseEnrollCount);

                            if (!empty($courseEnrollCount)) {
                                $query->set('post__in', array_keys($courseEnrollCount));
                                $query->set('orderby', 'post__in');
                            }

                        } elseif ($sort == 'name') {

                            $query->set('orderby', 'title');
                            $query->set('order', 'ASC');

                        } elseif ($sort == 'price-desc' || $sort == 'price-asc') {

                            $ascDesc = $sort == 'price-asc'? 'asc' : 'desc';
                            $argsAccessPlans = [
                                'post_type' => 'llms_access_plan',
                                'posts_per_page' => get_option( 'lifterlms_shop_courses_per_page', 10 ),
                                'paged' => $paged,
                                'post_status' => 'publish',
                                'meta_key' => '_llms_product_id',
                            ];

                            $meta_query = [
                                [
                                    'key' => '_llms_is_free',
                                    'value' => 'no',
                                ],
                                [
                                    'key' => '_llms_price',
                                ],
                            ];
                            $argsAccessPlans['meta_query'] = $meta_query;

                            add_filter( 'posts_orderby', 'course_posts_orderby_filter_'.$ascDesc );
                            add_filter( 'posts_groupby', 'course_posts_groupby_filter' );
                            $queryAccesPlans = new WP_Query($argsAccessPlans);
                            remove_filter( 'posts_orderby', 'course_posts_orderby_filter_'.$ascDesc );
                            remove_filter( 'posts_groupby', 'course_posts_groupby_filter' );

                            if (!empty($queryAccesPlans)) {
                                $ids = [];
                                foreach ($queryAccesPlans->posts as $plan) {
                                    $parentCourse = get_post_meta($plan->ID, '_llms_product_id',true);
                                    if ($parentCourse) {
                                        $ids[] = (int)$parentCourse;
                                    }
                                }
                                if (!empty($ids)) {
                                    $query->set('post__in', $ids);
                                }
                            }
                        }

                    }

                }

            }
        }
    }
    return $query;
}


function log_hook_call( $hook_name ) {
    error_log( "Hook executed: {$hook_name}" );

}
add_action( 'some_hook', function() {
    log_hook_call( 'some_hook' );
}, 10, 0 );


//function prevent_email_domain( $user_login, $user_email, $errors ) {
function prevent_email_domain() {
    $user_email = '';
    $errors = new WP_Error();
    if (!empty($_POST['email_address'])) {
        $user_email = $_POST['email_address'];
    }
    if (preg_match('/@[^\.]+\.ru|@[^\.]+\.ру/', $user_email)) {
        $_POST['email_address'] = '';
        $errors->add( 'bad_email_domain', __( '<strong>Error:</strong> Please type your email address.' ) );
//        llms_add_notice( __('<strong>ERROR</strong>: This email domain is not allowed.', 'ndp'), 'error' );
    }
}
//add_action( 'register_post', 'prevent_email_domain', 10, 3 );
add_action( 'lifterlms_before_new_user_registration', 'prevent_email_domain');


function check_invited_user($user_id) {
    // Убедитесь, что заголовки еще не отправлены, чтобы избежать ошибки
    if (!headers_sent()) {
        if ($user_id) {
            $user = get_user_by('id', $user_id);
            $email = $user->data? $user->data->user_email : '';
            $invite = '';
//            if (!empty($_GET['invite'])) {
//                $invite = $_GET['invite'];
//            }
            try{
                $inviteEvent = get_data_from_table('municipality_events', [
                    'where' => " WHERE `to_email`='{$email}' AND `eventType`='invite to municipality'",
                ]);
                if (!empty($inviteEvent)) {
                    $inviteEvent = $inviteEvent[0];
                    $invite = $inviteEvent->text;
                }
            } catch (\Throwable $ex) {

            }

            if (!empty($invite) && !empty($inviteEvent)) {
                if ($email) {
                    update_user_meta( $user_id, 'user_profile_type', 'Representative' );
                    municipality_add_request([
                        'user_id' => $user_id,
                        'type' => 'Invitation'
                    ]);
                    $head_user = get_user_by('email', $inviteEvent->from_email);
                    $invitedUser = get_invited_representatives($head_user->user_email, $email);
                    if (!empty($invitedUser)) {
                        $invitedUser = $invitedUser[0];
                        if (!empty($invitedUser['first_name'])) {
                            update_user_meta( $user_id, 'first_name', $invitedUser['first_name'] );
                        }
                        if (!empty($invitedUser['last_name'])) {
                            update_user_meta( $user_id, 'last_name', $invitedUser['last_name'] );
                        }
                        if (!empty($invitedUser['llms_phone'])) {
                            update_user_meta( $user_id, 'llms_phone', $invitedUser['llms_phone'] );
                        }
                        if (!empty($invitedUser['edrpou_code'])) {
                            update_user_meta( $user_id, 'edrpou_code', $invitedUser['edrpou_code'] );
                        }
                        if (!empty($invitedUser['user_organization'])) {
                            update_user_meta( $user_id, 'user_organization', $invitedUser['user_organization'] );
                        }
                        if (!empty($invitedUser['position'])) {
                            update_user_meta( $user_id, 'position', $invitedUser['position'] );
                        }

                        global $wpdb;
                        $table_name = $wpdb->prefix . 'municipality_events';
                        $wpdb->update( $table_name,
                            [
                                'text' => '',
                            ],
                            [
                                'from_email' => $inviteEvent->from_email,
                                'to_email' => $user->user_email,
                                'eventType' => 'invite to municipality'
                            ]
                        );
                    }
                }
            }
        }
    }
}
add_action( 'user_register', 'check_invited_user', 99);


//function redirect_after_registration($user_id) {
//    // Убедитесь, что заголовки еще не отправлены, чтобы избежать ошибки
//    if (!headers_sent()) {
//        if ($user_id) {
//            $user = get_user_by('id', $user_id);
//            $email = $user->data? $user->data->user_email : '';
//            wp_safe_redirect(esc_url( add_query_arg( 'email', $email, get_permalink(get_page_by_path('email-verification-page')) ) ));
//            exit;
//        }
//    }
//}
//add_action( 'user_register', 'redirect_after_registration', 99);

//подтверждение по email после регистрации в LMS
function redirectToDashboard()
{
    if (isset($_POST['user_verification_action']) && !empty($_POST['activation_key'])) {
        $activation_key = isset($_POST['activation_key']) ? sanitize_text_field($_POST['activation_key']) : '';

        // Ваш код для работы с базой данных и обновления данных пользователя
        global $wpdb;

        $user_id = $wpdb->get_var($wpdb->prepare(
            "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'user_activation_key' AND meta_value = %s",
            $activation_key
        ));
        $redirect = get_permalink(get_page_by_path('dashboard'));
        if (isset($_POST['redirect']) && filter_var($_POST['redirect'], FILTER_VALIDATE_URL)) {
            $redirect = sanitize_text_field($_POST['redirect']);
        }

        if ($user_id) {
            $user = get_user_by('id', $user_id);
            update_user_meta($user_id, 'user_activation_status', 1);
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);
        } else {
            $redirect = esc_url( add_query_arg( 'error', $activation_key, $redirect ) );
        }

        if (!headers_sent() && $redirect) {
            wp_safe_redirect($redirect);
            exit;
        }
    }
}
add_action( 'admin_post_redirectToDashboard', 'redirectToDashboard' );
add_action( 'admin_post_nopriv_redirectToDashboard', 'redirectToDashboard' );

add_filter( 'llms_lostpassword_url', 'my_redirect_home' );

function my_redirect_home( $lostpassword_redirect ) {
    return "/success-change-password";
}


add_action( 'show_user_profile', 'extra_user_profile_fields' );
add_action( 'edit_user_profile', 'extra_user_profile_fields' );

function extra_user_profile_fields( $user ) { ?>
    <h3><?php _e("Extra profile information", "ndp"); ?></h3>

    <table class="form-table">
        <?php if (!wp_is_mobile()): ?>
            <tr>
                <th><label for="middle_name"><?php _e("Middle name"); ?></label></th>
                <th><label for="day_of_birth"><?php _e("Day"); ?></label></th>
                <th><label for="month_of_birth"><?php _e("Month"); ?></label></th>
                <th><label for="year_of_birth"><?php _e("Year"); ?></label></th>
                <th><label for="gender"><?php _e("Gender"); ?></label></th>
            </tr>
        <?php endif; ?>
        <tr>
            <td>
                <input type="text" name="middle_name" id="middle_name" value="<?php echo esc_attr( get_the_author_meta( 'middle_name', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Enter your middle name"); ?></span>
            </td>
            <td>
                <input type="text" name="day_of_birth" id="day_of_birth" value="<?php echo esc_attr( get_the_author_meta( 'day_of_birth', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Enter your birthday"); ?></span>
            </td>
            <td>
                <input type="text" name="month_of_birth" id="month_of_birth" value="<?php echo esc_attr( get_the_author_meta( 'month_of_birth', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Enter month of birth"); ?></span>
            </td>
            <td>
                <input type="text" name="year_of_birth" id="year_of_birth" value="<?php echo esc_attr( get_the_author_meta( 'year_of_birth', $user->ID ) ); ?>" class="regular-text" /><br />
                <span class="description"><?php _e("Enter year of birth"); ?></span>
            </td>
            <td>
                <select name="gender" id="gender">
                    <option value="Male" <?php selected( 'Male', get_the_author_meta( 'gender', $user->ID ) ); ?>><?php _e('Male', 'ndp'); ?></option>
                    <option value="Female" <?php selected( 'Female', get_the_author_meta( 'gender', $user->ID ) ); ?>><?php _e('Female', 'ndp'); ?></option>
                </select>
                <span class="description"><?php _e("gender"); ?></span>
            </td>
        </tr>
    </table>
<?php }

add_action( 'personal_options_update', 'save_extra_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_extra_user_profile_fields' );

function save_extra_user_profile_fields( $user_id ) {
    if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'update-user_' . $user_id ) ) {
        return;
    }

    if ( !current_user_can( 'edit_user', $user_id ) ) {
        return false;
    }
    update_user_meta( $user_id, 'middle_name', $_POST['middle_name'] );
    update_user_meta( $user_id, 'day_of_birth', $_POST['day_of_birth'] );
    update_user_meta( $user_id, 'month_of_birth', $_POST['month_of_birth'] );
    update_user_meta( $user_id, 'year_of_birth', $_POST['year_of_birth'] );
    update_user_meta( $user_id, 'gender', $_POST['gender'] );
}


remove_action( 'llms_acces_plan_content', 'llms_template_access_plan_title', 10 );


add_filter( 'llms_get_form_fields', 'llms_get_form_fields_handler', 10, 3);
function llms_get_form_fields_handler($fields, $location, $args) {
    //Аутентификация на странице курса
    if (preg_match('/course\//', $_SERVER['REQUEST_URI'])) {
        foreach ($fields as $key => $field) {
            $fields[$key]['required'] = false;
        }
    }

    //dashboard/edit-account/
    if ($_SERVER['REQUEST_URI'] == '/dashboard/edit-account/' && !empty($_REQUEST)) {
        $value = $_REQUEST['middle_name'] ?? '';
        $field = ( new LLMS_Form_Field(
            [
                'id'             => 'middle_name',
                'name'           => 'middle_name',
                'type'           => 'hidden',
                'value'          => $value,
                'data_store_key' => 'middle_name',
            ]
        ) );
        $fields[] = $field->get_settings();

        $value = $_REQUEST['day_of_birth'] ?? '';
        $field = ( new LLMS_Form_Field(
            [
                'id'             => 'day_of_birth',
                'name'           => 'day_of_birth',
                'type'           => 'hidden',
                'value'          => $value,
                'data_store_key' => 'day_of_birth',
            ]
        ) );
        $fields[] = $field->get_settings();

        $value = $_REQUEST['month_of_birth'] ?? '';
        $field = ( new LLMS_Form_Field(
            [
                'id'             => 'month_of_birth',
                'name'           => 'month_of_birth',
                'type'           => 'hidden',
                'value'          => $value,
                'data_store_key' => 'month_of_birth',
            ]
        ) );
        $fields[] = $field->get_settings();

        $value = $_REQUEST['year_of_birth'] ?? '';
        $field = ( new LLMS_Form_Field(
            [
                'id'             => 'year_of_birth',
                'name'           => 'year_of_birth',
                'type'           => 'hidden',
                'value'          => $value,
                'data_store_key' => 'year_of_birth',
            ]
        ) );
        $fields[] = $field->get_settings();

        $value = $_REQUEST['gender'] ?? '';
        $field = ( new LLMS_Form_Field(
            [
                'id'             => 'gender',
                'name'           => 'gender',
                'type'           => 'hidden',
                'value'          => $value,
                'data_store_key' => 'gender',
            ]
        ) );
        $fields[] = $field->get_settings();
    }

    return $fields;
}

function get_initials_of_current_user() {
    // Получаем текущего пользователя
    $current_user = wp_get_current_user();

    if ( !($current_user instanceof WP_User) ) {
        return '';
    }

    // Получаем имя и фамилию
    $first_name = $current_user->user_firstname;
    $last_name = $current_user->user_lastname;

    // Вычисляем инициалы
    $initials = '';
    if ( !empty($first_name) ) {
        $initials .= mb_substr($first_name, 0, 1);
    }
    if ( !empty($last_name) ) {
        $initials .= mb_substr($last_name, 0, 1);
    }

    return $initials;
}

// Использование функции




function get_minute_ending_uk($number) {
    // Проверка текущего языка с помощью WPML
    $current_language = apply_filters('wpml_current_language', NULL);

    if ($current_language === 'en') {
        return $number == 1 ? ' minute' : ' minutes';
    }

    $last_digit = $number % 10;
    if ($number >= 11 && $number <= 19) {
        return ' хвилин';
    } elseif ($last_digit == 1) {
        return ' хвилина';
    } elseif ($last_digit >= 2 && $last_digit <= 4) {
        return ' хвилини';
    } else {
        return ' хвилин';
    }
}
function get_user_applications($user_id=null) {
    global $wpdb;
    $current_user = wp_get_current_user();
    $email = $current_user->user_email;
    $table_name = $wpdb->prefix . 'applications';

    if ($user_id) {
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE email = %s AND user_id = %d", $email, $user_id);
    } else {
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE email = %s", $email);
    }

    $applications = $wpdb->get_results($query);

    return $applications;
}

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

//Applications
function my_applications_dashboard_tabs( $tabs ) {

    // save the signout tab
    $signout = $tabs['signout'];
    // remove the signout tab
    unset( $tabs['signout'] );

    /**
     * Add custom Tabs below
     */
    // Advanced Custom tab with content displayed on the Dashboard as an endpoint
    // NOTE: you'll need to FLUSH PERMALINKS after adding a custom endpoint, if you don't the endpoint will 404!
    // 		 how to flush permalinks: https://lifterlms.com/docs/how-to-flush-wordpress-rewrite-rules-or-permalinks/
    $tabs['applications'] = array(
        'content' => 'lifterlms_template_student_dashboard_applications', // this should be a callable function that outputs your content
        'endpoint' => 'applications', // endpoint slug (eg: http://mysite.com/my-courses/my-endpoint)
        'nav_item' => true, // will add the endpoint to LifterLMS section on WP menu admin pages for use on WP nav menus
        'title' => __( 'Applications', 'ndp' ),
    );

    // restore the signout tab
    $tabs['signout'] = $signout;

    return $tabs;

}
add_filter( 'llms_get_student_dashboard_tabs', 'my_applications_dashboard_tabs', 10, 1 );

if ( ! function_exists( 'lifterlms_template_student_dashboard_applications' ) ) {

    /**
     * Template for Applications section on dashboard index
     *
     * @return void
     */
    function lifterlms_template_student_dashboard_applications() {

        llms_get_template(
            'myaccount/view-applications.php'
        );

    }
}

//Requests
function my_requests_dashboard_tabs( $tabs ) {

    // save the signout tab
    $signout = $tabs['signout'];
    // remove the signout tab
    unset( $tabs['signout'] );

    /**
     * Add custom Tabs below
     */
    // Advanced Custom tab with content displayed on the Dashboard as an endpoint
    // NOTE: you'll need to FLUSH PERMALINKS after adding a custom endpoint, if you don't the endpoint will 404!
    // 		 how to flush permalinks: https://lifterlms.com/docs/how-to-flush-wordpress-rewrite-rules-or-permalinks/
    $tabs['requests'] = array(
        'content' => 'lifterlms_template_student_dashboard_requests', // this should be a callable function that outputs your content
        'endpoint' => 'requests', // endpoint slug (eg: http://mysite.com/my-courses/my-endpoint)
        'nav_item' => false, // will add the endpoint to LifterLMS section on WP menu admin pages for use on WP nav menus
        'title' => __( 'Requests', 'ndp' ),
    );

    // restore the signout tab
    $tabs['signout'] = $signout;

    return $tabs;

}
add_filter( 'llms_get_student_dashboard_tabs', 'my_requests_dashboard_tabs', 10, 1 );

if ( ! function_exists( 'lifterlms_template_student_dashboard_requests' ) ) {

    /**
     * Template for Requests section on dashboard index
     *
     * @return void
     */
    function lifterlms_template_student_dashboard_requests() {

        llms_get_template(
            'myaccount/view-requests.php'
        );

    }
}

//Municipality
function my_municipality_dashboard_tabs( $tabs ) {

    // save the signout tab
    $signout = $tabs['signout'];
    // remove the signout tab
    unset( $tabs['signout'] );

    /**
     * Add custom Tabs below
     */
    // Advanced Custom tab with content displayed on the Dashboard as an endpoint
    // NOTE: you'll need to FLUSH PERMALINKS after adding a custom endpoint, if you don't the endpoint will 404!
    // 		 how to flush permalinks: https://lifterlms.com/docs/how-to-flush-wordpress-rewrite-rules-or-permalinks/
    $tabs['municipalities'] = array(
        'content' => 'lifterlms_template_student_dashboard_municipality', // this should be a callable function that outputs your content
        'endpoint' => 'municipalities', // endpoint slug (eg: http://mysite.com/my-courses/my-endpoint)
        'nav_item' => false, // will add the endpoint to LifterLMS section on WP menu admin pages for use on WP nav menus
        'title' => __( 'Municipality', 'ndp' ),
    );

    // restore the signout tab
    $tabs['signout'] = $signout;

    return $tabs;

}
add_filter( 'llms_get_student_dashboard_tabs', 'my_municipality_dashboard_tabs', 10, 1 );

if ( ! function_exists( 'lifterlms_template_student_dashboard_municipality' ) ) {

    /**
     * Template for Municipality section on dashboard index
     *
     * @return void
     */
    function lifterlms_template_student_dashboard_municipality() {

        llms_get_template(
            'myaccount/view-municipality.php'
        );

    }
}


add_filter( "lifterlms_user_update_failure", "lifterlms_user_update_failure_handler", 10, 3);
function lifterlms_user_update_failure_handler($error, $posted_data, $action) {
    //dashboard/edit-account
    llms()->session->set( 'llms_errors', $error );
    return $error;
}

//Автоматическое сохранение acf-поля продолжительности видео в курсе
add_action( 'save_post_lesson', 'save_post_lesson_handler', 10, 3);
function save_post_lesson_handler($post_id, $post, $update) {

    if ( wp_is_post_revision($post_id)){
        return;
    }

    $lesson = new LLMS_Lesson( $post_id );
    $course = $lesson->get_course();
    if(isset($course)){
        $lessons = $course->get_lessons();
        $totalTimeWithVideo = calculateTimeOfLessons($lessons, $type = 'video');
        $date = (int)date('H', $totalTimeWithVideo) ?? 0;
        $durationArray = [
            '0-1', '1-3', '3-6', '6-12', '12',
        ];

        foreach ($durationArray as $duration) {
            $item = explode('-', $duration);
            $start = 0;
            $end = 1000;
            if (isset($item[0])) {
                $start = (int)$item[0];
            }
            if (isset($item[1])) {
                $end = (int)$item[1];
            }
            if ($date >= $start && $date <= $end) {
                break;
            }
        }
        if (!$duration) return;

        if ($duration == '12') {
            $duration = '12+';
        }
        update_field('video_course_duration', $duration, $course->get('id'));
    }

}


//View Previous Attempts
remove_action( 'lifterlms_single_quiz_before_summary', 'lifterlms_template_quiz_results', 15 );
add_action( 'lifterlms_single_quiz_before_summary', 'lifterlms_template_quiz_results_custom', 15 );
/**
 * Quiz Results Template Include
 *
 * @return void
 * @since    1.0.0
 * @version  1.0.0
 */
if ( ! function_exists( 'lifterlms_template_quiz_results_custom' ) ) {
    function lifterlms_template_quiz_results_custom() {
        $key = llms_filter_input_sanitize_string( INPUT_GET, 'attempt_key' );
        if ($key) {
            llms_get_template( 'quiz/results.php' );
        }
    }
}
if ( ! function_exists( 'lifterlms_template_quiz_results_list' ) ) {
    function lifterlms_template_quiz_results_list() {
        llms_get_template( 'quiz/results-list.php' );
    }
}
add_action( 'lifterlms_single_quiz_before_summary', 'lifterlms_template_quiz_results_custom', 15 );

/**
 * Passing Percent Template Include
 *
 * @return void
 * @since    1.0.0
 * @version  1.0.0
 */
if ( ! function_exists( 'lifterlms_template_quiz_meta_info' ) ) {
    function lifterlms_template_quiz_meta_info() {
        $key = llms_filter_input_sanitize_string( INPUT_GET, 'attempt_key' );
        if (!$key) {
            llms_get_template( 'quiz/meta-information.php' );
        }
    }
}

remove_action( 'lifterlms_single_quiz_before_summary', 'lifterlms_template_quiz_return_link', 10 );
remove_action( 'lifterlms_single_quiz_after_summary', 'lifterlms_template_start_button', 10 );

add_filter( 'lifterlms_begin_quiz_button_text', 'lifterlms_begin_quiz_button_text_handler', 10, 3 );
function lifterlms_begin_quiz_button_text_handler($text, $quiz, $lesson) {
    $complete = llms_is_complete( get_current_user_id(), $lesson->get( 'id' ), 'lesson' );
    if ($complete) {
        $text = __('Retry quiz', 'ndp');
    }

    return $text;
}

remove_action( 'lifterlms_single_lesson_before_summary', 'lifterlms_template_single_parent_course', 10 );


//dashboard/edit-account
add_action('lifterlms_before_user_update', 'lifterlms_before_user_update_handler', 99, 3);
function lifterlms_before_user_update_handler(&$postedData, $location, &$fields) {
    $passRequired = false;
    foreach ($fields as $key => $field) {
        if ($field['id'] == 'first_name' || $field['id'] == 'last_name') {
            $fields[$key]['required'] = false;
        } elseif ($field['id'] == 'email_address') {
            $fields[$key]['required'] = true;
        } elseif ($field['id'] == 'password_current' && !empty($postedData['password_current'])) {
            $passRequired = true;
        } elseif (($field['id'] == 'password' || $field['id'] == 'password_confirm') && $passRequired) {
            $fields[$key]['required'] = true;
        }
    }
}


/**
 * Fire an action after a user has been updated.
 *
 * @since 3.0.0
 * @since 5.0.0 Moved from `LLMS_Person_Handler::update()`.
 *
 * @param int    $user_id     WP_User ID of the user.
 * @param array  $posted_data Array of user submitted data.
 * @param string $location    Form location.
 */
add_action( 'lifterlms_user_updated', 'lifterlms_user_updated_handler', 10, 3 );
function lifterlms_user_updated_handler($user_id, $posted_data, $location) {

    if (!$user_id || empty($posted_data['password_current'])) {
        return;
    }

    $now = time();
    update_user_meta($user_id, 'user_pass_last_edit', $now);

}



/**
 * Регистрация кастомного типа постов для сертификатов
 */
function register_user_certificate_post_type()
{
    register_post_type('custom_certificate',
        array(
            'public' => true,
            'exclude_from_search' => false,
            'show_in_admin_bar'   => false,
            'show_in_nav_menus'   => false,
            'publicly_queryable'  => false,
            'has_archive' => false,
            'supports' => false,
            'capability_type' => 'post',
        )
    );
}
add_action('init', 'register_user_certificate_post_type');


function customCertificateScript()
{
    global $current_screen;
    if (!current_user_can('install_plugins') || $current_screen->base != 'toplevel_page_wp_posts' || $current_screen->parent_base != 'wp_posts') return;

    ?>
    <script>
        jQuery(document).ready(function ($) {

            $('.btn-approve').on('click', function(event) {
                let $target = $(event.target);
                let approved = 'no';
                if ($target.is('.btn-approve-yes')) {
                    approved = 'yes';
                }
                let post_id = '';
                let id = $target.closest('tr').attr('data-id');
                if (id) {
                    id = id.replace(/[\[\]]*/g,'');
                }
                if (!id) return;

                post_id = id;

                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'certificateApproveHandler',
                        post_id: post_id,
                        approved: approved,
                    },
                    success: function (response) {
                        if (response && response.hasOwnProperty('message') && response['message']) {
                            $target.closest('tr').find('td[data-colname="approved"]').text(response['message'])
                        }
                    }
                })
            });

            $('.btn-delete').on('click', function(event) {
                if (!confirm("Delete?")) return;

                let $target = $(event.target);
                let post_id = '';
                let id = $target.closest('tr').attr('data-id');
                if (id) {
                    id = id.replace(/[\[\]]*/g,'');
                }
                if (!id) return;

                post_id = id;

                $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'certificateDeleteHandler',
                        post_id: post_id,
                    },
                    success: function (response) {
                        if (response && response.hasOwnProperty('message') && response['message'] === 'ok') {
                            $target.closest('tr').remove();
                        }
                    }
                })
            })
        })
    </script>
    <?php
}

function certificateApproveHandler()
{
    if (!current_user_can('install_plugins')) return;

    $post_id = sanitize_text_field($_POST['post_id']);
    $approved = sanitize_text_field($_POST['approved']);
    if (!$post_id || !$approved) return;

    wp_update_post(array(
        'ID'    =>  $post_id,
        'comment_status'   =>  $approved
    ));

    wp_send_json(['message' => $approved]);
}
function certificateDeleteHandler()
{
    if (!current_user_can('install_plugins')) return;

    $post_id = sanitize_text_field($_POST['post_id']);
    if (!$post_id) return;

    $deleted = wp_delete_post($post_id, true);
    if ($deleted) {
        wp_send_json(['message' => 'ok']);
    }
    die();
}

add_action('admin_footer', 'customCertificateScript');
add_action('wp_ajax_certificateApproveHandler', 'certificateApproveHandler');
add_action('wp_ajax_certificateDeleteHandler', 'certificateDeleteHandler');


add_filter("crudiator_custom_column_wp_posts_post_content", function ($value, $item) {

    $button = "<button type='button' class='btn-approve btn-approve-yes' data-id='".$item['ID']."'>".__('Yes', 'ndp')."</button>";
    $button .= "<button type='button' class='btn-approve btn-approve-no' data-id='".$item['ID']."'>".__('No', 'ndp')."</button>";

    return $button;

}, 10, 2);

add_filter("crudiator_custom_column_wp_posts_to_ping", function ($value, $item) {

    $button = "<button type='button' class='btn-delete' data-id='".$item['ID']."'>".__('Delete', 'ndp')."</button>";

    return $button;

}, 10, 2);

add_filter("crudiator_detail_custom_column_wp_posts_post_content_filtered", function ($value, $item) {

    $content = '';
    $certData = get_post_meta($item['ID'], 'custom_certificate_data', true);
    foreach ($certData as $key => $data) {
        $content .= '<p class="cert-data">' . $key . ' - ' . $data . '</p>';
    }

    return $content;

}, 10, 2);

add_filter("crudiator_custom_column_wp_posts_post_excerpt", function ($value, $item) {

    $certData = get_post_meta($item['ID'], 'custom_certificate_data', true);
    $pdfLink = '';
    if ($certData && is_array($certData) && !empty($certData['pdf_url']) && filter_var($certData['pdf_url'], FILTER_VALIDATE_URL) !== FALSE) {
        $pdfLink = '<a href="'.$certData['pdf_url'].'" download>'.__('Download', 'ndp')."</a>";
    }

    return $pdfLink;

}, 10, 2);


//Объенинение загруженных пользователем сертификатов с существующими
add_filter( 'llms_awards_query_get_awards', 'llms_awards_query_get_awards', 10, 2 );
function llms_awards_query_get_awards($awards, $query) {

    $cols     = llms_get_certificates_loop_columns();
    $per_page = $cols * 5;
    $result = [];
    $student = llms_get_student();
    if (!$student) {
        return $awards;
    }

    $args = array(
        'post_type'        => 'custom_certificate',
        'posts_per_page'   => $per_page,
        'paged'     => max( 1, get_query_var( 'paged' ) ),
        'page'     => max( 1, get_query_var( 'paged' ) ),
        'author' => $student->get('id'),
    );

    $customQuery = new WP_Query( $args );

    if ( $customQuery->have_posts() ) {
        foreach ($customQuery->posts as $post) {
            $result[] = new LLMS_User_Certificate( $post );
        }
    }

    wp_reset_query();

//    $this->number_results = $this->wp_query->post_count;
//    $this->found_results  = $this->found_results();
//    $this->max_pages      = (int) $this->wp_query->max_num_pages;

//    $newCount = $query->number_results + count($result);

//    $query1 = $query->wp_query;
//    $query2 = $customQuery;
//
////create new empty query and populate it with the other two
//    $wp_query = new WP_Query();
//    $wp_query->posts = array_merge( $query1->posts, $query2->posts );
//
////populate post_count count for the loop to work correctly
//    $wp_query->post_count = $query1->post_count + $query2->post_count;
//
//    $query->wp_query = $wp_query;

    $awards = array_merge($awards, $result);

    return $awards;
}


function add_categories_to_attachments() {
    register_taxonomy_for_object_type( 'category', 'attachment' );
}
add_action( 'init' , 'add_categories_to_attachments' );


function wporg_simple_role_caps() {
    // Gets the simple_role role object.
    $role = get_role( 'engineer' );

    // Add a new capability.
    $role->add_cap( 'delete_requests', true );
    $role->add_cap( 'reject_requests', true );
    $role->add_cap( 'edit_requests', true );
    $role->add_cap( 'read_requests', true );
    $role->add_cap( 'read', true );
}

// Add simple_role capabilities, priority must be after the initial role definition.
add_action( 'init', 'wporg_simple_role_caps', 11 );


//запросы оператоту представителей муниципалитета с пагинацией
function get_municipality_requests($args = []) {
    global $wpdb;
    if (!current_user_can('read_requests') ) return [];

    $requestsArray = [];
    $table_name = $wpdb->prefix . 'municipality_requests';
    $query             = "SELECT * FROM {$table_name}";
    if (!empty($args) && !empty($args['where'])) {
        $query .= " " . $args['where'];
    }
    $total_query     = "SELECT COUNT(1) FROM (${query}) AS combined_table";
    $total             = $wpdb->get_var( $total_query );
    $items_per_page = 7;
    $page             = isset( $_GET['page'] ) ? abs( (int) $_GET['page'] ) : 1;
    if (!empty($args['page'])) {
        $page = (int)$args['page'];
    }
    $offset         = ( $page * $items_per_page ) - $items_per_page;
    $requests         = $wpdb->get_results( $query . " ORDER BY `received` DESC LIMIT ${offset}, ${items_per_page}" );
    if (!empty($args['parseRequests']) && $args['parseRequests']) {
        foreach ($requests as $key => $request) {
            $requests[$key]->received = date( 'd.m.Y', strtotime( $request->received ) );
            $requests[$key]->due_to = !empty($request->due_to) && !preg_match('/0000/', $request->due_to)? date( 'd.m.Y', strtotime( $request->due_to ) ) : '';
            $requests[$key]->link = llms_get_endpoint_url('requests', '', llms_get_page_url('myaccount')) . '?id=' . $request->id;
        }
    }
    if (!empty($args['translate']) && $args['translate']) {//может понадобиться в пагинации
        foreach ($requests as $key => $request) {
            $requests[$key]->status = __($requests[$key]->status, 'ndp');
            $requests[$key]->type = __($requests[$key]->type, 'ndp');
            $requests[$key]->assigned = __($requests[$key]->assigned, 'ndp');
        }
    }
    $totalPage         = ceil($total / $items_per_page);

    $pagination = '';
    if($totalPage > 1) {
        if (!empty($args['pathname'])) {
            $base = $args['pathname'];
            $orig_req_uri = $_SERVER['REQUEST_URI'];

            //admin-ajax.php/page/ issue
            // Overwrite the REQUEST_URI variable
            $_SERVER['REQUEST_URI'] = $base;
        }

        $pagination = '<nav class="pagination">' . paginate_links([
                'base' => add_query_arg('page', '%#%'),
                'format' => '',
                'prev_text' => is_rtl() ? '<span><i class="arrow arrow-right"></i></span>' : '<span><i class="arrow arrow-left"></i></span>',
                'next_text' => is_rtl() ? '<span><i class="arrow arrow-left"></i></span>' : '<span><i class="arrow arrow-right"></i></span>',
                'total' => $totalPage,
                'current' => $page
            ]) . '</nav>';

        if (!empty($args['pathname'])) {
            // Restore the original REQUEST_URI - in case anything else would resort on it
            $_SERVER['REQUEST_URI'] = $orig_req_uri;
        }
    }
    if (!empty($requests)) {
        $requestsArray['requests'] = $requests;
        $requestsArray['pagination'] = $pagination;
    }

    return $requestsArray;
}

function get_current_user_role() {
    if(is_user_logged_in()) {
        $user = wp_get_current_user();
        $role = (array) $user->roles;
        return $role[0];
    }
    else {
        return false;
    }
}

function get_municipality_data() {
    // Убедитесь, что функции WordPress доступны
    if (!function_exists('is_user_logged_in')) {
        return false;
    }

    // Проверяем, авторизован ли пользователь
    if (!is_user_logged_in()) {
        return false;
    }

    // Получаем ID текущего пользователя
    $user_id = get_current_user_id();
    $organization = get_user_meta($user_id, 'user_organization', true);

    // Подключаемся к глобальной переменной базы данных WordPress
    global $wpdb;

    // Ищем пользователя в таблице wp_municipalities
    $municipality = $wpdb->get_row($wpdb->prepare("SELECT * FROM wp_municipalities WHERE head_user = %d", $user_id), ARRAY_A);

    // Если пользователь найден в wp_municipalities
    if ($municipality) {
        $municipality['user_organization'] = $organization;
        return json_encode($municipality);
    }

    // Если нет, ищем в wp_users_of_municipality
    $user_municipality = $wpdb->get_row($wpdb->prepare("SELECT * FROM wp_users_of_municipality WHERE user_id = %d", $user_id), ARRAY_A);

    // Если пользователь найден в wp_users_of_municipality
    if ($user_municipality) {
        $user_municipality['user_organization'] = $organization;
        $edr = get_user_meta($user_id, 'edrpou_code', true);
        $user_municipality['edr'] = $edr;

        return json_encode($user_municipality);
    }

    // Возвращаем false, если ничего не найдено
    return false;
}

function get_new_jwt_token($code, $state, $uuid = 0) {
    $user_id = get_user_id_from_uuid($uuid);
    if(!$uuid){
        $user_id=false;
    }
    // Получение refresh_token и запрос на обновление токена
    if ($user_id) {
        $refresh_token = get_user_meta($user_id, 'refresh_token', true);
        $response = wp_remote_get("https://uandp.com.ua/api/v1/auth/refresh-token", array(
            'headers' => array('refreshToken' => $refresh_token)
        ));

        if (is_wp_error($response)) {
            // Обработка ошибки запроса
            return $response;
        }

        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        // Проверка и обновление refresh_token
        if (isset($data['refresh_token'])) {
            update_user_meta($user_id, 'refresh_token', $data['refresh_token']);
        }

        return $data;
    } else {
        $token_response = wp_remote_get("https://uandp.com.ua/api/v1/auth/token?code={$code}&state={$state}");
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/J.txt',print_r($token_response,true));
        if (is_wp_error($token_response)) {
            // Обработка ошибки запроса
            return $token_response;
        }

        $body = wp_remote_retrieve_body($token_response);
        $data = json_decode($body, true);
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/J2.txt',print_r($data,true));

        return $data;
    }
}

// Функция для получения user_id по uuid
function get_user_id_from_uuid($uuid) {
    global $wpdb;

    // Предполагаем, что uuid сохраняется в таблице usermeta
    $user_id = $wpdb->get_var($wpdb->prepare(
        "SELECT user_id FROM $wpdb->usermeta WHERE meta_key = 'uuid' AND meta_value = %s",
        $uuid
    ));

    return $user_id ?: null;
}
add_action('rest_api_init', function () {
    register_rest_route('redirect/v1', '/redirect/', array(
        'methods' => 'GET',
        'callback' => 'redirectDia',
    ));
});

function redirectDia(WP_REST_Request $request) {
    $state = wp_generate_password(32,false);
    $cookieName = '901a6b96dbc8033f4d411c6e0fb53113'; // Название cookie
    setcookie($cookieName, $state, time() + (86400 * 30), "/");
    wp_redirect(GOV_UA_URL . '?state='.$state.'&redirect_url=b01f93bdd9b79b4f0ae07e44847c64bb', 301);
    exit;
}

function get_user_data($jwt_token) {



    $user_response = wp_remote_get("https://uandp.com.ua/api/v1/users/profile", array(
        'headers' => array(
            'Authorization' => 'Bearer ' . $jwt_token
        )
    ));

    if (!is_wp_error($user_response)) {
        $body = wp_remote_retrieve_body($user_response);

        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/user_info2.txt',$body);
        return json_decode($body, true); // Возвращает данные пользователя
    } else {
        // Обработка ошибки
        return null;
    }
}



function my_delete_user_action($user_id) {
    // Получение refresh token для пользователя
    $refresh_token = get_user_meta($user_id, 'refresh_token', true);
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test_us.txt',$refresh_token);
    // Запрос на обновление токена
    $response = wp_remote_get("https://uandp.com.ua/api/v1/auth/refresh-token", array(
        'headers' => array(
            'refreshToken' =>$refresh_token
        )
    ));
    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test_us2.txt',print_r($response,true));
    if (is_wp_error($response)) {
        // Обработка ошибки при запросе на обновление токена
        $error_message = $response->get_error_message();
        // Действия в случае ошибки
    } else {
        // Получение тела ответа и декодирование JSON
        $body = wp_remote_retrieve_body($response);
        $data = json_decode($body, true);

        // Проверка наличия JWT токена в ответе
        if (isset($data['jwt_token'])) {
            $jwt_token = $data['jwt_token'];

            // Отправка запроса на удаление пользователя
            $delete_response = wp_remote_request("https://uandp.com.ua/api/v1/user/delete", array(
                'method' => 'DELETE',
                'headers' => array(
                    'Authorization' => 'Bearer ' . $jwt_token
                )
            ));

            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/ttt.txt',print_r($delete_response,true));

            // Проверка ответа от API
            if (is_wp_error($delete_response)) {
                // Обработка ошибки при запросе на удаление
                $delete_error_message = $delete_response->get_error_message();
                // Действия в случае ошибки
            } else {
                // Здесь можно добавить действия в случае успешного удаления, если необходимо
            }
        }
    }
}

// Подключение функции к хуку удаления пользователя
add_action('delete_user', 'my_delete_user_action');


function authDia()

{

    // Проверка, была ли функция уже вызвана


    // Остальная логика функции...

    // Установка cookie на короткий период (например, на 5 минут)

//    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test.txt',print_r($_GET,true));
    $isDia = isset($_GET['dia']) ? $_GET['dia'] : false;
    $code = isset($_GET['code']) ? $_GET['code'] : false;
    $uuid = isset($_GET['uuid']) ? $_GET['uuid'] : false;
    $state =  isset($_GET['state']) ? $_GET['state'] : false; // Ваше состояние

// 	 if (isset($_COOKIE['authDiaCalled'])) {
//         $uuid=false;
//     }

//    if(!isset($_COOKIE['901a6b96dbc8033f4d411c6e0fb53113'])) return;
//    if($_COOKIE['901a6b96dbc8033f4d411c6e0fb53113']!=$state) return;

    if ($isDia && $code) {
        if($uuid){
            $data = get_new_jwt_token($code,$state,$uuid);
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/testjwt.txt',print_r($data,true),FILE_APPEND);
        }else{
            $data =get_new_jwt_token($code,$state,0);
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/testjwt2.txt',print_r($data,true),FILE_APPEND);
        }

        setcookie('authDiaCalled', '1', time() + 60, '/');
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/jwt_actual.txt',print_r($data,true),FILE_APPEND);
        $jwt_token =$data['token'];
        $refresh_token =$data['refresh_token'];
        if($uuid){

            $user_data = get_user_data($jwt_token);
            $user_data['uuid']= $uuid;
            $user_id = create_or_authenticate_wp_user($user_data);

        }else{
            $user_data = get_user_data($jwt_token);
            $user_id = create_or_authenticate_wp_user($user_data);

        }



        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/jwt.txt',print_r($data,true));
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test233.txt',print_r($user_data,true));




        update_user_meta($user_id, 'refresh_token', $refresh_token);

        if(isset($user_data['date_of_birth'])){
            $date_birth = explode('.',$user_data['date_of_birth']);
        }


        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test2.txt',print_r($user_data,true));


        if(!isset($user_data['email'])){
            $user_data['email']= $user_data['uuid']."@noreply.com";
        }
        if (isset($user_data['uuid'])) {
            update_user_meta($user_id, 'uuid', $user_data['uuid']);
        }


        if (isset($data['name'])) {
            update_user_meta($user_id, 'first_name', $data['name']);
        }

        if (isset($data['lastname'])) {
            update_user_meta($user_id, 'last_name', $data['lastname']);
        }

        if (isset($data['middleName'])) {
            update_user_meta($user_id, 'middle_name', $data['middleName']);
        }

        if (isset($data['drfoCode'])) {
            update_user_meta($user_id, 'edrpou_code', $data['drfoCode']);
        }

        if (isset($user_data['phone'])) {
            update_user_meta($user_id, 'llms_phone', $user_data['phone']);
        }

        if (isset($date_birth[0])) {
            update_user_meta($user_id, 'day_of_birth', $date_birth[0]);
        }

        if (isset($date_birth[1])) {
            update_user_meta($user_id, 'month_of_birth', $date_birth[1]);
        }

        if (isset($date_birth[2])) {
            update_user_meta($user_id, 'year_of_birth', $date_birth[2]);
        }

        if (isset($user_data['gender'])) {
            update_user_meta($user_id, 'gender', $user_data['gender']);
        }
        update_user_meta($user_id, 'llms_billing_country', 'UA');

        if (!is_wp_error($user_id)) {

            $user = get_user_by('id',$user_id);
            // Аутентификация пользователя
            wp_clear_auth_cookie();
            if(isset($user->user_login)){
                $login = $user->user_login;
            }else{
                $login= $user_data['uuid']."@noreply.com";
            }
            file_put_contents($_SERVER['DOCUMENT_ROOT'].'/nor.txt',$login);
            if ($user && !is_wp_error($user)) {
                wp_set_current_user($user->ID);
                wp_set_auth_cookie($user->ID);

                // wp_authenticate не требуется, если выше установлены cookie
                // Если все же нужна, используйте ее осторожно
                wp_authenticate($user->user_login, $user->user_pass);
            }
            if(isset($_COOKIE['old_url'])){
                wp_redirect($_COOKIE['old_url']);
                exit;
            }
            if(isset($_GET['uuid'])){
                header('Location: ' . '/register-step-1/');
            }
            header('Location: ' . '/dashboard');


        } else {

            echo 'Ошибка при создании или аутентификации пользователя: ' . $user_id->get_error_message();

        }
    }
}




function create_or_authenticate_wp_user($data) {

    file_put_contents($_SERVER['DOCUMENT_ROOT'].'/user_info.txt',print_r($data,true));

    if(empty($data['email'])){
        $email= $data['uuid']."@noreply.com";
    }else{
        $email = $data['email'];
    }
    if(isset($data['uuid'])){
        $uuid = $data['uuid'];
    }else{
        $uuid=false;
    }
    $user_id =get_user_id_from_uuid($uuid);
    $user = get_user_by('id', $user_id);

    if (!$user) {
        // Создание нового пользователя, если он не существует
        $password = wp_generate_password();
        $user_id = wp_create_user($email, $password, $email);
        $user = get_user_by('email', $email);
        $user_id = $user->ID;
        if (is_wp_error($user_id)) {
            return $user_id;
        }

        // Обновление основных данных пользователя
        wp_update_user([
            'ID' => $user_id,
            'first_name' =>isset( $data['first_name']) ?  $data['first_name'] : 'Empty',
            'last_name' => isset( $data['last_name']) ?  $data['first_name'] : 'Empty'
        ]);
        if(isset($data['date_of_birth'])){
            $date_birth = explode('.',$data['date_of_birth']);
        }

        // Сохранение дополнительных метаданных пользователя
        if (isset($uuid)) {
            update_user_meta($user_id, 'uuid', $uuid);

        }
        if(isset($data['refresh_token'])){
            update_user_meta($user_id, 'refresh_token', $data['refresh_token']);
        }

        if (isset($data['name'])) {
            update_user_meta($user_id, 'first_name', $data['name']);
        }

        if (isset($data['lastname'])) {
            update_user_meta($user_id, 'last_name', $data['lastname']);
        }

        if (isset($data['middleName'])) {
            update_user_meta($user_id, 'middle_name', $data['middleName']);
        }

        if (isset($data['drfoCode'])) {
            update_user_meta($user_id, 'edrpou_code', $data['drfoCode']);
        }

        if (isset($data['phone'])) {
            update_user_meta($user_id, 'llms_phone', $data['phone']);
        }

        if (isset($date_birth[0])) {
            update_user_meta($user_id, 'day_of_birth', $date_birth[0]);
        }

        if (isset($date_birth[1])) {
            update_user_meta($user_id, 'month_of_birth', $date_birth[1]);
        }

        if (isset($date_birth[2])) {
            update_user_meta($user_id, 'year_of_birth', $date_birth[2]);
        }

        if (isset($data['gender'])) {
            update_user_meta($user_id, 'gender', $data['gender']);
        }

        update_user_meta($user_id, 'llms_billing_country', 'UA');
        $data['user_id'] =$user_id;
        $data['password'] =$password;
        return $data;
    } else {
        // Возвращаем ID существующего пользователя

        return $user->ID;
    }
}
if(!is_user_logged_in()) {
    add_action('init', 'authDia');
}

if(is_user_logged_in()){

    if(isset($_GET['uuid'])){
        header('Location: ' . '/dashboard/');
        die;
    }
    if(isset($_GET['code'])){
        header('Location: ' . '/dashboard/');
        die;
    }


    unset($_COOKIE['901a6b96dbc8033f4d411c6e0fb53113']);
    $user = wp_get_current_user();


    $status= get_user_meta($user->ID,'verify_end');

    if(empty($status) || !$status){
        $currentUrlPath = $_SERVER['REQUEST_URI'];

        if (strpos($currentUrlPath, 'dashboard') !== false) {
            // Your code for when 'dashboard' is in the URL
            $get_type = get_user_meta($user->ID,'user_profile_type');

            if(is_user_logged_in()){
                if(empty($get_type)){
                    header('Location: ' . '/register-step-1/');
                    die;
                }else{
                    header('Location: ' . '/register-step-2/');
                    die;
                }
            }

        }
    }
}

global $wpdb;
add_filter("crudiator_before_delete_{$wpdb->prefix}posts", 'checkCrudiatorPostHandler', 10, 1);
add_filter("crudiator_before_bulk_delete_{$wpdb->prefix}posts", 'checkCrudiatorPostHandler', 10, 1);
add_filter("crudiator_before_update_{$wpdb->prefix}posts", 'checkCrudiatorPostHandler', 10, 1);
function checkCrudiatorPostHandler($pre_delete_data) {
    if (!current_user_can('install_plugins')) {
        return __('Error', 'ndp');
    }
    return $pre_delete_data;  // validation ok.
}
add_filter("crudiator_before_delete_{$wpdb->prefix}municipality_requests", 'checkCrudiatorMunicipalityRequestHandler', 10, 1);
add_filter("crudiator_before_bulk_delete_{$wpdb->prefix}municipality_requests", 'checkCrudiatorMunicipalityRequestHandler', 10, 1);
add_filter("crudiator_before_update_{$wpdb->prefix}municipality_requests", 'checkCrudiatorMunicipalityRequestHandler', 10, 1);
function checkCrudiatorMunicipalityRequestHandler($pre_data) {
    if (!current_user_can('edit_requests')) {
        return __('Error', 'ndp');
    }
    global $wpdb;

    $action = current_action();
    if ($action == "crudiator_before_update_{$wpdb->prefix}municipality_requests" && !empty($_GET['id'])) {
        $table_name = $wpdb->prefix . 'municipality_requests';
        $id = is_array($_GET['id'])? (int)$_GET['id'][0] : (int)$_GET['id'];
        $currentUser = wp_get_current_user();
        $wpdb->update( $table_name,
            [
                'assigned' => 'Admin',
                'operator_id' => $currentUser->ID,
            ],
            [ 'id' => $id ]
        );
    }
    return $pre_data;  // validation ok.
}

//Получение муниципалитета
function head_of_municipality(int $user_id=null, int $municipality_id=null) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'municipalities';
    $sql = "SELECT * FROM {$table_name} WHERE 1=1";
    if ($user_id) {
        $sql .= " AND `head_user`={$user_id}";
    }
    if ($municipality_id) {
        $sql .= " AND id={$municipality_id}";
    }
    return $wpdb->get_results($sql, ARRAY_A);
}
function get_applications_with_engineer() {
    global $wpdb; // Используем глобальную переменную для работы с базой данных WordPress

    // Запрос к базе данных для получения заявок с непустым apply_engineer и сортировкой по дате подачи по убыванию
    $query = "SELECT * FROM wp_applications WHERE status!='draft' ORDER BY id DESC";

    // Выполнение запроса
    $results = $wpdb->get_results($query, ARRAY_A);

    // Проверяем, есть ли результаты
    if (!empty($results)) {
        // Возвращаем результаты в формате JSON
        return $results;
    } else {
        // Если результатов нет, возвращаем false
        return false;
    }
}

// Вызов функции и вывод результатов

//является ли представитель муниципалитета
function representative_of_municipality(int $user_id, int $municipality_id=null) {
    $representative = wp_cache_get('representative_'.$user_id);
    if (false === $representative) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'users_of_municipality';
        $sql = "SELECT * FROM {$table_name} WHERE `user_id`={$user_id}";
        if ($municipality_id) {
            $sql .= " AND municipality_id={$municipality_id}";
        }
        $representative = $wpdb->get_results($sql, ARRAY_A);
        wp_cache_set('representative_'.$user_id, $representative);
    }

    return $representative;
}

/**
 * representatives_of_municipality_all_data($user_id)
 * representatives_of_municipality_all_data($user_id, [
    'municipality_id' => $municipality['id'],
    'limit' => 10,
]);
 * @param int $user_id
 * @param array $args
 * @return array|object|stdClass[]|null
 */
function representatives_of_municipality_all_data(int $user_id, array $args = []) {
  global $wpdb;

  $and = "";
  if (!empty($args) && !empty((int)$municipality_id = $args['municipality_id'])) {
      $and = " and m.id={$municipality_id} ";
  }
  $limit = "";
  if (!empty($args) && !empty($args['limit'])) {
      $limit = "limit {$args['limit']} ";
  }
  $offset = "";
  if (!empty($args) && !empty($args['offset'])) {
      $offset = ", {$args['offset']}";
  }

  $sql = "select m.id,m.name,m.edr,m.head_user,wujt.position,wu.ID as user_id,wu.user_login,wu.user_email,
(select um1.meta_value from {$wpdb->prefix}usermeta um1 where um1.user_id=wu.ID and um1.meta_key='first_name') as first_name,
(select um2.meta_value from {$wpdb->prefix}usermeta um2 where um2.user_id=wu.ID and um2.meta_key='last_name') as last_name,
(select um3.meta_value from {$wpdb->prefix}usermeta um3 where um3.user_id=wu.ID and um3.meta_key='llms_phone') as llms_phone,
(select um4.meta_value from {$wpdb->prefix}usermeta um4 where um4.user_id=wu.ID and um4.meta_key='edrpou_code') as edrpou_code,
(select um5.meta_value from {$wpdb->prefix}usermeta um5 where um5.user_id=wu.ID and um5.meta_key='llms_billing_country') as country,
(select um6.meta_value from {$wpdb->prefix}usermeta um6 where um6.user_id=wu.ID and um6.meta_key='year_of_birth') as year_of_birth,
(select um7.meta_value from {$wpdb->prefix}usermeta um7 where um7.user_id=wu.ID and um7.meta_key='month_of_birth') as month_of_birth,
(select um8.meta_value from {$wpdb->prefix}usermeta um8 where um8.user_id=wu.ID and um8.meta_key='day_of_birth') as day_of_birth,
(select um9.meta_value from {$wpdb->prefix}usermeta um9 where um9.user_id=wu.ID and um9.meta_key='user_organization') as user_organization 
from {$wpdb->prefix}municipalities m
inner join {$wpdb->prefix}users_of_municipality wuom on m.id = wuom.municipality_id
inner join {$wpdb->prefix}users_job_title wujt on wuom.position_id = wujt.id
inner join {$wpdb->prefix}users wu on wuom.user_id = wu.ID
where m.head_user={$user_id} {$and} {$limit}{$offset}";

    return $wpdb->get_results($sql, ARRAY_A);
}

//Приглашённые главой муниципалитета
function get_invited_representatives(string $email='', string $invitedEmail='', array $args=[]) {
    $fromEmail = "";
    if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $fromEmail = " AND `from_email`='{$email}'";
    }
    $toEmail = "";
    if ($invitedEmail && filter_var($invitedEmail, FILTER_VALIDATE_EMAIL)) {
      $toEmail = " AND `to_email`='{$invitedEmail}'";
    }
    $inviteEvent = get_data_from_table('municipality_events', [
        'where' => " WHERE 1=1 {$fromEmail} {$toEmail} AND `eventType`='invite to municipality'",
    ]);
    if (empty($inviteEvent)) return [];

    $invitedRepresentatives = [];
    foreach ($inviteEvent as $invite) {
        $invite = (array)$invite;
        $data = unserialize($invite['data']);
        $data = is_array($data)? $data : [];
//        if (!empty($invite['text'])) { //uuid приглашения
//            $data['invited'] = true;
//        }

        if (!empty($args) && !empty($args['user_id']) && !empty($data['user_id']) && $data['user_id'] != $args['user_id']) continue;
        if (!empty($args) && !empty($args['user_email']) && !empty($data['user_email']) && $data['user_email'] != $args['user_email']) continue;
        if (!empty($args) && !empty($args['edrpou_code']) && !empty($data['edrpou_code']) && $data['edrpou_code'] != $args['edrpou_code']) continue;

        if (!empty($data) && is_array($data)) {
            $invitedRepresentatives[] = $data;
        }
    }
    return $invitedRepresentatives;
}

function change_invited_representatives(string $email, array $args=[], array $changeArgs=[]) {
    global $wpdb;

    if (!empty($args['user_email']) && $invitedUser = get_invited_representatives($email, '', $args)) {
        $invitedUser = $invitedUser[0];
        foreach ($changeArgs as $key => $arg) {
            if (isset($invitedUser[$key])) {
                $invitedUser[$key] = $arg;
            }
        }
        $table_name = $wpdb->prefix . 'municipality_events';
        if ($wpdb->update( $table_name,
            [
                'data' => serialize($invitedUser),
            ],
            [
                'from_email' => $email,
                'to_email' => $args['user_email'],
                'eventType' => 'invite to municipality'
            ]
        )) {
            return true;
        }
    }
    return false;
}

//Состояние подачи заявки в муниципалитет
function add_representative_of_municipality(int $municipality_id=null) {
    $user = wp_get_current_user();
    $representative = representative_of_municipality($user->ID, $municipality_id);
    $municipalityAdd = get_user_meta( $user->ID, 'user_profile_type', true );
    if (empty($representative) && !empty($municipalityAdd) && $municipalityAdd == 'Representative') {
        return true;
    }
    return false;
}

//запись события в таблице municipality_events
function add_municipality_event(string $text, string $eventType, WP_User $user, $toEmail=null, string $eventData=null) {
    global $wpdb;
    if (!empty($text) && !empty($eventType) && $user) {
        $table_name = $wpdb->prefix . 'municipality_events';
        $data = [
            'text' => $text,
            'from_email' => $user->user_email,
            'eventType' => $eventType,
            'date' => date('Y-m-d H:i:s'),
        ];
        if (!empty($toEmail) && filter_var($toEmail, FILTER_VALIDATE_EMAIL)) {
            $data['to_email'] = $toEmail;
        }
        if (!empty($eventData)) {
            $data['data'] = $eventData;
        }
        return $wpdb->insert($table_name, $data);
    }
}


//Добавление запроса муниципалитета на проверку оператором
function municipality_add_request(array $params=[]) {
    global $wpdb;
    date_default_timezone_set("Europe/Kiev");

    $table_name = $wpdb->prefix . 'municipality_requests';
    $currentUser = wp_get_current_user();
    $user_id = $currentUser? $currentUser->ID : null;
    if (!empty($params['user_id'])) {
        $user_id = (int)$params['user_id'];
    }
    if (!$user_id) return;

    $sql = "SELECT * FROM {$table_name} WHERE `user_id`={$user_id} AND (`type`='Registration' OR `type`='Invitation')";
    $result = $wpdb->get_results($sql, ARRAY_A);
    if ($result) return;

    $status = !empty($params['status'])? $params['status'] : 'Await processing';
    $type = !empty($params['type'])? $params['type'] : 'Registration';
    $assigned = !empty($params['assigned'])? $params['assigned'] : '';

    $result = $wpdb->insert(
        $table_name,
        array(
            'status' => $status,
            'received' => date("Y-m-d H:i:s"),
            'due_to' => date("Y-m-d H:i:s", strtotime('+1000000 days')),
            'type' => $type,
            'assigned' => $assigned,
            'user_id' => $user_id,
            'email' => $currentUser->user_email,
        ),
        array('%s', '%s', '%s', '%s', '%s', '%d')
    );

    return $result;
}

function get_data_from_table(string $table, array $args = []) {
    global $wpdb;

    $table_name = $wpdb->prefix . $table;
    $sql = "SELECT * FROM {$table_name}";
    if (!empty($args) && !empty($args['where'])) {
        $sql .= " " . $args['where'];
    }
    return $wpdb->get_results($sql);
}


function register_step1_register_endpoint() {
    register_rest_route('register/v1', '/step1/', array(
        'methods' => 'POST',
        'callback' => 'handle_form_submission',
        'permission_callback' => 'check_nonce_permission'
    ));
}


add_action('rest_api_init', 'register_step1_register_endpoint');

// Функция обработки отправленных данных
function handle_form_submission($request) {
    // Получение данных из запроса
    $data = $request->get_params();
    $user_id = get_current_user_id();
    if($data['account-type']=="Personal"){
        update_user_meta( $user_id, 'user_profile_type', '' );
        update_user_meta( $user_id, 'step1', '1' );
        $data['redirect'] = "/register-step-2";
    }else{
        update_user_meta( $user_id, 'edrpou_code', $data['tin']);
        update_user_meta( $user_id, 'edr', $data['tin'] );
        update_user_meta( $user_id, 'user_profile_type', 'Representative' );
        municipality_add_request();
        $data['redirect'] = "/register-step-2";
    }

    // Возвращаем ответ
    return new WP_REST_Response(array('message' => 'Данные формы успешно обработаны', 'data' => $data), 200);
}
function register_update_password_endpoint() {
    register_rest_route('custom/v1', '/update-password/', array(
        'methods' => 'POST',
        'callback' => 'update_user_password',
        'permission_callback' => 'check_nonce_permission'
    ));
}
add_action('rest_api_init', 'register_update_password_endpoint');

function loginDiaUser(){

    if(isset($_COOKIE['7f4b7fbdc641bb3d81f300b63696ed60'])){
        $creds = array(
            'user_login'    => wp_get_current_user()->user_login,
            'user_password' => $_COOKIE['7f4b7fbdc641bb3d81f300b63696ed60'],
            'remember'      => true
        );
        unset($_COOKIE['7f4b7fbdc641bb3d81f300b63696ed60']);
        wp_signon($creds, false);

    }

}
add_action('init','loginDiaUser');
// Функция обработки запроса на обновление пароля

// Функция для обновления пароля пользователя
function update_wp_user_password($new_password, $user_id) {
    // Хеширование и обновление пароля
    wp_set_password($new_password, $user_id);
}

// Функция проверки nonce
function check_nonce_permission($request) {
    $nonce = $request->get_header('X-WP-Nonce');

    // Проверка nonce
    if (!wp_verify_nonce($nonce, 'wp_rest')) {
        return new WP_Error('invalid_nonce', 'Invalid nonce', array('status' => 401));
    }

    return true;
}

function update_user_password($request) {
    $permission = check_nonce_permission($request);
    if (is_wp_error($permission)) {
        return $permission;
    }

    $user_id = get_current_user_id();
    $data = $request->get_json_params();
    $password = $data['password'];
    $confirm_password = $data['confirm_password'];
    $email = isset($data['email']) ? $data['email'] : false;

    // Проверка совпадения паролей
    if ($password !== $confirm_password) {
        return new WP_Error('password_mismatch', 'Passwords do not match', array('status' => 400));
    }

    // Обновление электронной почты
    if ($email) {
        $update_result = wp_update_user(array('ID' => $user_id, 'user_email' => $email));
        if (is_wp_error($update_result)) {
            return $update_result;
        }
    }

    // Обновление пароля пользователя
    $update_result = wp_set_password($password, $user_id);
    if (is_wp_error($update_result)) {
        return $update_result;
    }

    // Нет необходимости в очистке и установке cookie, если это не требуется для логики работы вашего приложения

    update_user_meta($user_id, 'verify_end', 1);
    // Очистка всех сессий пользователя
    wp_clear_auth_cookie();

// Установка текущего пользователя и инициализация новой сессии
    wp_set_current_user($user_id);
    wp_set_auth_cookie($user_id);

    return new WP_REST_Response(array('message' => 'Password updated successfully'), 200);
}


//Возможность смотреть сертификаты других пользователей
function llms_certificate_can_user_view_handler($result, $user_id, $th) {
    return true;
}
add_filter('llms_certificate_can_user_view', 'llms_certificate_can_user_view_handler', 10, 3);


//Сообщение при завершении урока,курса
function llms_notification_viewlesson_complete_get_merged_string_handler($title, $th) {
    return mb_ucfirst(mb_strtolower($title));
}
add_filter('llms_notification_viewlesson_complete_get_merged_string', 'llms_notification_viewlesson_complete_get_merged_string_handler', 10, 2);
add_filter('llms_notification_viewsection_complete_get_merged_string', 'llms_notification_viewlesson_complete_get_merged_string_handler', 10, 2);
add_filter('llms_notification_viewcourse_complete_get_merged_string', 'llms_notification_viewlesson_complete_get_merged_string_handler', 10, 2);


//Текст на кнопке страницы курса
function llms_plan_get_enroll_text_handler($title, $th) {
    return __($title, 'ndp');
}
add_filter('llms_plan_get_enroll_text', 'llms_plan_get_enroll_text_handler', 10, 2);

// попап сообщения
function enqueue_custom_script() {
    wp_enqueue_script('custom-script', get_template_directory_uri() . '/js/script.js', array('jquery'), '1.0', true);
}

add_action('wp_enqueue_scripts', 'enqueue_custom_script');

