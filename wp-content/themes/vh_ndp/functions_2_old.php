<?php
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

    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@400;500&display=swap');
    wp_enqueue_style('swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css');
    wp_enqueue_style('vh_ndp-bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap-grid.min.css');
    wp_enqueue_style('theme_carousel', get_template_directory_uri() . '/assets/css/owl.carousel.css');
	
	wp_enqueue_style('theme_default', get_template_directory_uri() . '/assets/css/owl.theme.default.css');
   
    wp_enqueue_style('main-min', get_template_directory_uri() . '/assets/css/style.min.css', ['swiper']);

    wp_enqueue_script('vh_ndp-bootstrap-js', get_template_directory_uri() . '/js/bootstrap.min.js', array(), _S_VERSION, true);
    wp_enqueue_script('vh_ndp-marqueee', get_template_directory_uri() . '/assets/js/marquee.js', array(), _S_VERSION, true);
    wp_enqueue_script('vh_ndp-navigation', get_template_directory_uri() . '/js/navigation.js', array(), _S_VERSION, true);
    wp_enqueue_script('js_carousel', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array(), _S_VERSION, true);
    wp_enqueue_script('swiper', 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js');
   
    wp_enqueue_script('main', get_template_directory_uri() . '/assets/js/app.js', array('jquery', 'swiper'), _S_VERSION, true);

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
    if (is_page('marketplace')) {
        wp_enqueue_style('vh_ndp-marketplace', get_template_directory_uri() . '/assets/css/marketplace.css');
        wp_enqueue_script('vh_ndp-marketplace', get_template_directory_uri() . '/assets/js/marketplace.js', array(), _S_VERSION, true);
    }

    if (is_page('green-university')) {
        wp_enqueue_style('vh_ndp-green', get_template_directory_uri() . '/assets/css/green.css');
        wp_enqueue_script('vh_ndp-green', get_template_directory_uri() . '/assets/js/green.js', array(), _S_VERSION, true);
    }

}

add_action('wp_enqueue_scripts', 'vh_ndp_scripts');

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
                            parent.css('opacity', '1')
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

    $newest_post_args = array();

    if ($post_type === 'news') {
        $newest_post_args = array(
            'post_type' => $post_type,
            'posts_per_page' => 5,
        );
    } else {
        $newest_post_args = array(
            'post_type' => $post_type,
            'posts_per_page' => 4,
        );
    }


    $newest_post = new WP_Query($newest_post_args);
    $new_dates = array();

    if ($newest_post->have_posts()) {
        while ($newest_post->have_posts()) {
            $newest_post->the_post();

            $newest_post_date = get_the_date('Y-m-d H:i:s');
            $new_dates[] = $newest_post_date;
        }
    }

    // $new_date = date('Y-m-d H:i:s', strtotime(max($new_dates)) + 60);

    var_dump($new_dates);

    if ($is_sticky === 'on') {
        var_dump('1');
        var_dump(date('Y-m-d H:i:s', strtotime(max($new_dates)) + 15));
        $new_date = date('Y-m-d H:i:s', strtotime(max($new_dates)) + 15);
    } else {
        var_dump('2');
        var_dump(date('Y-m-d H:i:s', strtotime(min($new_dates)) + 15));
        $new_date = date('Y-m-d H:i:s', strtotime(min($new_dates)) + 15);
    }

    $post_data = array(
        'ID' => $post_id,
        'post_date' => $new_date,
        'post_date_gmt' => get_gmt_from_date($new_date)
    );

    wp_reset_postdata();

    wp_update_post($post_data);
    update_post_meta($post_id, 'custom_sticky', $is_sticky);
    wp_die();
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
    $breadcrumbs = '<nav class="breadcrumb">';
    $breadcrumbs .= '<a href="' . esc_url(home_url('/')) . '">Home</a>';

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

        $breadcrumbs .= '<span class="delimiter">  </span>';
        if (!empty($taxonomy_cat)) {
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
            return "1 min ago";
        } else {
            return "" . $minutes . " mins ago";
        }
    } elseif ($post_time_diff < 86400) {
        $hours = floor($post_time_diff / 3600);
        if ($hours === 1) {
            return "1 hour ago";
        } else {
            return "" . $hours . " hours ago";
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


/**
 * Фильтрацию контента с помощью AJAX при клике на категории
 */
// Выводим переменную ajaxurl в глобальный контекст JavaScript
add_action('wp_head', 'add_ajax_url_to_frontend');

function add_ajax_url_to_frontend()
{
    echo '<script>
        const ajaxurl = "' . admin_url('admin-ajax.php') . '";
    </script>';
}

/**
 * HTML
 */
function generate_posts_html($query, $post_type, $have_sticky = 1)
{
    ob_start();

    if ($have_sticky === '1') {
        $is_have_sticky = true;
    } else {
        $is_have_sticky = false;
    }

    $tag_slug = '';
    $category_slug = '';

    if ($post_type === 'news') {
        $tag_slug = 'news_tag';
        $category_slug = 'news_category';
    } elseif ($post_type === 'knowledge-base') {
        $tag_slug = 'knowledge-base_tag';
        $category_slug = 'knowledge-base_category';
    } elseif ($post_type === 'cases') {
        $tag_slug = 'cases_tag';
        $category_slug = 'cases_category';
    }

    $news_tags = get_terms(array(
        'taxonomy' => $tag_slug,
        'hide_empty' => true,
    ));

    // Получаем список категорий
    $categories = get_terms([
        'taxonomy' => $category_slug,
        'hide_empty' => true,
    ]);

    if ($query->have_posts()) {
        $counterPost = 0;

        while ($query->have_posts()) {
            $query->the_post();
            $counterPost++;
            ?>
            <div <?php post_class(['card-nw', (get_post_type() === 'news' && $counterPost < 2 && $is_have_sticky === false) ? 'card-nw-full' : '']); ?>
                    data-views="<?php echo get_post_views(get_the_ID()); ?>">
                <a href="<?php echo get_the_permalink(); ?>" class="card-nw__img">
                    <?php if (get_the_post_thumbnail_url()) {
                        echo '<img src="' . get_the_post_thumbnail_url() . '"
                                                     alt="' . get_the_title() . '">';
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/assets/img/img/Imagenews__img0.png"
                                                     alt="' . get_the_title() . '">';
                    } ?>
                </a>
                <div class="card-nw__block">
                    <a href="<?php echo get_the_permalink(); ?>" class="block-title">
                        <?php echo get_the_title(); ?>
                    </a>

                    <div class="category-tags">
                        <?php
                        $categories = wp_get_post_terms(get_the_ID(), $category_slug);

                        if (isset($categories) && !empty($categories)) {
                            $counterCat = 0;
                            foreach ($categories as $category) {
                                $counterCat++;
                                if ($counterCat < 2) {
                                    ?>
                                    <a href="<?php echo get_category_link($category->term_id); ?>"
                                       class="btn__accessory btn_bg_complementary category-tags__category"
                                       data-term-id="<?php echo $category->term_id; ?>">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                    <?php
                                }
                            }
                        }
                        ?>

                        <?php
                        // Получаем массив объектов тегов текущего поста
                        // $post_tags = get_the_tags();

                        $post_tags = wp_get_post_terms(get_the_ID(), $tag_slug);

                        $counterTags = 0;
                        $tagsListFirst = '';
                        $tagsList = '';

                        // Проверяем, есть ли теги для текущего поста
                        if ($post_tags) {
                            foreach ($post_tags as $tag) {
                                $counterTags++;
                                $tag_name = $tag->name;
                                $tag_url = get_tag_link($tag->term_id);

                                if ($counterTags <= 1) {
                                    $tagsListFirst .= '<li><a href="' . esc_url($tag_url) . '" class="btn__accessory btn_bg_no-selected" data-term-id="' . $tag->term_id . '">' . esc_html($tag_name) . '</a></li>';
                                } else {
                                    $tagsList .= '<li><a href="' . esc_url($tag_url) . '" class="btn__accessory btn_bg_no-selected" data-term-id="' . $tag->term_id . '">' . esc_html($tag_name) . '</a></li>';
                                }
                            }
                        }

                        echo '<ul class="category-tags__tags-list">';
                        echo $tagsListFirst;
                        echo !empty($tagsList) ? '<li class="tooltip"><span class="category-tags__count-element btn__accessory btn_bg_no-selected">+' . ($counterTags - 1) . '</span><ul class="tooltiptext">' . $tagsList . '</ul>' : '';
                        echo '</ul>';
                        ?>

                    </div>

                    <div class="text-sm">
                        <?php
                        //                                            if ($counterPost < 2) {
                        //                                                echo custom_get_the_excerpt(get_post(), 180, '...');
                        //                                            } else {
                        echo custom_get_the_excerpt(get_post(), 130, '...');
                        //                                            }
                        ?>
                    </div>

                    <div class="card-nw__info">
                        <div class="card-nw__date text-sm-scnd">
                            <?php
                            $post_time = get_the_time('U');
                            echo custom_time_ago($post_time);
                            ?>
                        </div>
                        <span></span>
                        <div class="card-nw__vol text-sm-scnd">
                            <?php
                            $post_content = get_the_content();
                            $reading_time = approximate_reading_time($post_content);
                            echo $reading_time . ' minute(s) read'; //  5 min read
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    wp_reset_postdata();
    return ob_get_clean();
}

function generate_posts_html_sticky($query, $post_type, $have_sticky = 1)
{
    ob_start();

    if ($have_sticky === '1') {
        $is_have_sticky = true;
    } else {
        $is_have_sticky = false;
    }

    $tag_slug = '';
    $category_slug = '';

    if ($post_type === 'news') {
        $tag_slug = 'news_tag';
        $category_slug = 'news_category';
    } elseif ($post_type === 'knowledge-base') {
        $tag_slug = 'knowledge-base_tag';
        $category_slug = 'knowledge-base_category';
    } elseif ($post_type === 'cases') {
        $tag_slug = 'cases_tag';
        $category_slug = 'cases_category';
    }

    $news_tags = get_terms(array(
        'taxonomy' => $tag_slug,
        'hide_empty' => true,
    ));

    // Получаем список категорий
    $categories = get_terms([
        'taxonomy' => $category_slug,
        'hide_empty' => true,
    ]);

    if ($query->have_posts()) {
        $counterPost = 0;

        while ($query->have_posts()) {
            $query->the_post();
            $counterPost++;
            $custom_sticky = get_post_meta(get_the_ID(), 'custom_sticky', true);
            ?>
            <div <?php post_class(['card-nw', (get_post_type() === 'news' && $counterPost < 2 && $is_have_sticky === true) ? 'card-nw-full' : '', (isset($custom_sticky) && !empty($custom_sticky) && $custom_sticky !== 'off') ? 'card-nw-fixed' : '']); ?>
                 data-views="<?php echo get_post_views(get_the_ID()); ?>">
                <a href="<?php echo get_the_permalink(); ?>" class="card-nw__img">
                    <?php if (get_the_post_thumbnail_url()) {
                        echo '<img src="' . get_the_post_thumbnail_url() . '"
                                                     alt="' . get_the_title() . '">';
                    } else {
                        echo '<img src="' . get_template_directory_uri() . '/assets/img/img/Imagenews__img0.png"
                                                     alt="' . get_the_title() . '">';
                    } ?>
                </a>
                <div class="card-nw__block">
                    <a href="<?php echo get_the_permalink(); ?>" class="block-title">
                        <?php echo get_the_title(); ?>
                    </a>

                    <div class="category-tags">
                        <?php
                        $categories = wp_get_post_terms(get_the_ID(), $category_slug);

                        if (isset($categories) && !empty($categories)) {
                            $counterCat = 0;
                            foreach ($categories as $category) {
                                $counterCat++;
                                if ($counterCat < 2) {
                                    ?>
                                    <a href="<?php echo get_category_link($category->term_id); ?>"
                                       class="btn__accessory btn_bg_complementary category-tags__category"
                                       data-term-id="<?php echo $category->term_id; ?>">
                                        <?php echo esc_html($category->name); ?>
                                    </a>
                                    <?php
                                }
                            }
                        }
                        ?>

                        <?php
                        // Получаем массив объектов тегов текущего поста
                        // $post_tags = get_the_tags();

                        $post_tags = wp_get_post_terms(get_the_ID(), $tag_slug);

                        $counterTags = 0;
                        $tagsListFirst = '';
                        $tagsList = '';

                        // Проверяем, есть ли теги для текущего поста
                        if ($post_tags) {
                            foreach ($post_tags as $tag) {
                                $counterTags++;
                                $tag_name = $tag->name;
                                $tag_url = get_tag_link($tag->term_id);

                                if ($counterTags <= 1) {
                                    $tagsListFirst .= '<li><a href="' . esc_url($tag_url) . '" class="btn__accessory btn_bg_no-selected" data-term-id="' . $tag->term_id . '">' . esc_html($tag_name) . '</a></li>';
                                } else {
                                    $tagsList .= '<li><a href="' . esc_url($tag_url) . '" class="btn__accessory btn_bg_no-selected" data-term-id="' . $tag->term_id . '">' . esc_html($tag_name) . '</a></li>';
                                }
                            }
                        }

                        echo '<ul class="category-tags__tags-list">';
                        echo $tagsListFirst;
                        echo !empty($tagsList) ? '<li class="tooltip"><span class="category-tags__count-element btn__accessory btn_bg_no-selected">+' . ($counterTags - 1) . '</span><ul class="tooltiptext">' . $tagsList . '</ul>' : '';
                        echo '</ul>';
                        ?>

                    </div>

                    <div class="text-sm">
                        <?php
                        //                                            if ($counterPost < 2) {
                        //                                                echo custom_get_the_excerpt(get_post(), 180, '...');
                        //                                            } else {
                        echo custom_get_the_excerpt(get_post(), 130, '...');
                        //                                            }
                        ?>
                    </div>

                    <div class="card-nw__info">
                        <div class="card-nw__date text-sm-scnd">
                            <?php
                            $post_time = get_the_time('U');
                            echo custom_time_ago($post_time);
                            ?>
                        </div>
                        <span></span>
                        <div class="card-nw__vol text-sm-scnd">
                            <?php
                            $post_content = get_the_content();
                            $reading_time = approximate_reading_time($post_content);
                            echo $reading_time . ' minute(s) read'; //  5 min read
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    wp_reset_postdata();
    return ob_get_clean();
}


/**
 * By Category
 */
add_action('wp_ajax_filter_posts_by_category', 'filter_posts_by_category');
add_action('wp_ajax_nopriv_filter_posts_by_category', 'filter_posts_by_category');

function filter_posts_by_category()
{
    $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : '';
    $sort_by = isset($_POST['sort_by']) ? $_POST['sort_by'] : '';
    $taxonomy = isset($_POST['taxonomy']) ? $_POST['taxonomy'] : '';
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
    $tagTaxonomy = sanitize_text_field($_POST['tagTaxonomy']);
    $tagIds = sanitize_text_field($_POST['tagIds']);
    $have_sticky = sanitize_text_field($_POST['is_have_sticky']);

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => 10,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if ($sort_by === 'date-asc') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    } elseif ($sort_by === 'views') {
        $args['orderby'] = 'meta_value_num'; // Сортировка по числовому значению метаполя
        $args['meta_key'] = 'post_views_count'; // Имя метаполя для количества просмотров
    }

    $tax_queries = array();

    if (!empty($category_id)) {
        $tax_queries[] = array(
            'taxonomy' => $taxonomy,
            'field' => 'term_id',
            'terms' => intval($category_id),
        );
    }

    if (!empty($tagIds)) {
        $tax_queries[] = array(
            'taxonomy' => $tagTaxonomy,
            'field' => 'term_id',
            'terms' => array_map('intval', explode(',', $tagIds)),
        );
    }

    if (!empty($tax_queries)) {
        $args['tax_query'] = $tax_queries;
    }

    $meta_query = array(
        'relation' => 'OR',
        array(
            'key' => 'custom_sticky',
            'value' => 'on',
            'compare' => '!=',
        ),
        array(
            'key' => 'custom_sticky',
            'compare' => 'NOT EXISTS',
        ),
    );
    $args['meta_query'] = $meta_query;

    $query = new WP_Query($args);
    $output = generate_posts_html($query, $post_type, $have_sticky);

    echo $output;
    wp_die();
}

// Sticky
add_action('wp_ajax_filter_posts_by_category_sticky', 'filter_posts_by_category_sticky');
add_action('wp_ajax_nopriv_filter_posts_by_category_sticky', 'filter_posts_by_category_sticky');

function filter_posts_by_category_sticky()
{
    $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : '';
    $sort_by = isset($_POST['sort_by']) ? $_POST['sort_by'] : '';
    $taxonomy = isset($_POST['taxonomy']) ? $_POST['taxonomy'] : '';
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
    $tagTaxonomy = sanitize_text_field($_POST['tagTaxonomy']);
    $tagIds = sanitize_text_field($_POST['tagIds']);
    $have_sticky = sanitize_text_field($_POST['is_have_sticky']);

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => 10,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if ($sort_by === 'date-asc') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    } elseif ($sort_by === 'views') {
        $args['orderby'] = 'meta_value_num'; // Сортировка по числовому значению метаполя
        $args['meta_key'] = 'post_views_count'; // Имя метаполя для количества просмотров
    }

    $tax_queries = array();

    if (!empty($category_id)) {
        $tax_queries[] = array(
            'taxonomy' => $taxonomy,
            'field' => 'term_id',
            'terms' => intval($category_id),
        );
    }

    if (!empty($tagIds)) {
        $tax_queries[] = array(
            'taxonomy' => $tagTaxonomy,
            'field' => 'term_id',
            'terms' => array_map('intval', explode(',', $tagIds)),
        );
    }

    if (!empty($tax_queries)) {
        $args['tax_query'] = $tax_queries;
    }

    $meta_query = array(
        array(
            'key' => 'custom_sticky',
            'value' => 'on',
            'compare' => '==',
        )
    );
    $args['meta_query'] = $meta_query;

    $query = new WP_Query($args);
    $output = generate_posts_html_sticky($query, $post_type, $have_sticky);

    echo $output;
    wp_die();
}


/**
 * By Tag
 */
add_action('wp_ajax_filter_posts_by_tag', 'filter_posts_by_tag');
add_action('wp_ajax_nopriv_filter_posts_by_tag', 'filter_posts_by_tag');

function filter_posts_by_tag()
{
    $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : '';
    $sort_by = isset($_POST['sort_by']) ? $_POST['sort_by'] : '';
    $taxonomy = isset($_POST['taxonomy']) ? $_POST['taxonomy'] : '';
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
    $tagTaxonomy = isset($_POST['tagTaxonomy']) ? $_POST['tagTaxonomy'] : '';
    $tagIds = isset($_POST['tagIds']) ? $_POST['tagIds'] : '';
    $have_sticky = sanitize_text_field($_POST['is_have_sticky']);

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => 10,
        'orderby' => 'date',
        'order' => 'DESC',
        // 'tag__in' => array($tag_id),
    );

    if ($sort_by === 'date-asc') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    } elseif ($sort_by === 'views') {
        $args['orderby'] = 'meta_value_num'; // Сортировка по числовому значению метаполя
        $args['meta_key'] = 'post_views_count'; // Имя метаполя для количества просмотров
    }

    $tax_queries = array();

    if (!empty($category_id)) {
        $tax_queries[] = array(
            'taxonomy' => $taxonomy,
            'field' => 'term_id',
            'terms' => intval($category_id),
        );
    }

    if (!empty($tagIds)) {
        $tax_queries[] = array(
            'taxonomy' => $tagTaxonomy,
            'field' => 'term_id',
            'terms' => array_map('intval', explode(',', $tagIds)),
        );
    }

    if (!empty($tax_queries)) {
        $args['tax_query'] = $tax_queries;
    }

    $meta_query = array(
        'relation' => 'OR',
        array(
            'key' => 'custom_sticky',
            'value' => 'on',
            'compare' => '!=',
        ),
        array(
            'key' => 'custom_sticky',
            'compare' => 'NOT EXISTS',
        ),
    );
    $args['meta_query'] = $meta_query;

    $query = new WP_Query($args);
    $output = generate_posts_html($query, $post_type, $have_sticky);

    echo $output;
    wp_die();
}

// Sticky
add_action('wp_ajax_filter_posts_by_tag_sticky', 'filter_posts_by_tag_sticky');
add_action('wp_ajax_nopriv_filter_posts_by_tag_sticky', 'filter_posts_by_tag_sticky');

function filter_posts_by_tag_sticky()
{
    $post_type = isset($_POST['post_type']) ? $_POST['post_type'] : '';
    $sort_by = isset($_POST['sort_by']) ? $_POST['sort_by'] : '';
    $taxonomy = isset($_POST['taxonomy']) ? $_POST['taxonomy'] : '';
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
    $tagTaxonomy = isset($_POST['tagTaxonomy']) ? $_POST['tagTaxonomy'] : '';
    $tagIds = isset($_POST['tagIds']) ? $_POST['tagIds'] : '';
    $have_sticky = sanitize_text_field($_POST['is_have_sticky']);

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => 10,
        'orderby' => 'date',
        'order' => 'DESC',
        // 'tag__in' => array($tag_id),
    );

    if ($sort_by === 'date-asc') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    } elseif ($sort_by === 'views') {
        $args['orderby'] = 'meta_value_num'; // Сортировка по числовому значению метаполя
        $args['meta_key'] = 'post_views_count'; // Имя метаполя для количества просмотров
    }

    $tax_queries = array();

    if (!empty($category_id)) {
        $tax_queries[] = array(
            'taxonomy' => $taxonomy,
            'field' => 'term_id',
            'terms' => intval($category_id),
        );
    }

    if (!empty($tagIds)) {
        $tax_queries[] = array(
            'taxonomy' => $tagTaxonomy,
            'field' => 'term_id',
            'terms' => array_map('intval', explode(',', $tagIds)),
        );
    }

    if (!empty($tax_queries)) {
        $args['tax_query'] = $tax_queries;
    }

    $meta_query = array(
        array(
            'key' => 'custom_sticky',
            'value' => 'on',
            'compare' => '==',
        )
    );
    $args['meta_query'] = $meta_query;

    $query = new WP_Query($args);
    $output = generate_posts_html_sticky($query, $post_type, $have_sticky);

    echo $output;
    wp_die();
}


/**
 * Sort By
 */
add_action('wp_ajax_sort_posts', 'sort_posts');
add_action('wp_ajax_nopriv_sort_posts', 'sort_posts');

function sort_posts()
{
    $post_type = sanitize_text_field($_POST['post_type']);
    $sort_by = sanitize_text_field($_POST['sort_by']);
    $taxonomy = sanitize_text_field($_POST['taxonomy']); // cat
    $category_id = sanitize_text_field($_POST['category_id']);
    $tagTaxonomy = sanitize_text_field($_POST['tagTaxonomy']);
    $tagIds = sanitize_text_field($_POST['tagIds']);
    $have_sticky = sanitize_text_field($_POST['is_have_sticky']);

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if ($sort_by === 'date-asc') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    } elseif ($sort_by === 'views') {
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = 'post_views_count';
    }

    $tax_queries = array();

    if (!empty($category_id)) {
        $tax_queries[] = array(
            'taxonomy' => $taxonomy,
            'field' => 'term_id',
            'terms' => intval($category_id),
        );
    }

    if (!empty($tagIds)) {
        $tax_queries[] = array(
            'taxonomy' => $tagTaxonomy,
            'field' => 'term_id',
            'terms' => array_map('intval', explode(',', $tagIds)),
        );
    }

    if (!empty($tax_queries)) {
        $args['tax_query'] = $tax_queries;
    }

    $meta_query = array(
        'relation' => 'OR',
        array(
            'key' => 'custom_sticky',
            'value' => 'on',
            'compare' => '!=',
        ),
        array(
            'key' => 'custom_sticky',
            'compare' => 'NOT EXISTS',
        ),
    );
    $args['meta_query'] = $meta_query;

    $query = new WP_Query($args);
    $output = generate_posts_html($query, $post_type, $have_sticky);

    echo $output;
    wp_die();
}

// Sticky
add_action('wp_ajax_sort_posts_sticky', 'sort_posts_sticky');
add_action('wp_ajax_nopriv_sort_posts', 'sort_posts_sticky');

function sort_posts_sticky()
{
    $post_type = sanitize_text_field($_POST['post_type']);
    $sort_by = sanitize_text_field($_POST['sort_by']);
    $taxonomy = sanitize_text_field($_POST['taxonomy']); // cat
    $category_id = sanitize_text_field($_POST['category_id']);
    $tagTaxonomy = sanitize_text_field($_POST['tagTaxonomy']);
    $tagIds = sanitize_text_field($_POST['tagIds']);
    $have_sticky = sanitize_text_field($_POST['is_have_sticky']);

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => -1,
        'orderby' => 'date',
        'order' => 'DESC',
    );

    if ($sort_by === 'date-asc') {
        $args['orderby'] = 'date';
        $args['order'] = 'ASC';
    } elseif ($sort_by === 'views') {
        $args['orderby'] = 'meta_value_num';
        $args['meta_key'] = 'post_views_count';
    }

    $tax_queries = array();

    if (!empty($category_id)) {
        $tax_queries[] = array(
            'taxonomy' => $taxonomy,
            'field' => 'term_id',
            'terms' => intval($category_id),
        );
    }

    if (!empty($tagIds)) {
        $tax_queries[] = array(
            'taxonomy' => $tagTaxonomy,
            'field' => 'term_id',
            'terms' => array_map('intval', explode(',', $tagIds)),
        );
    }

    if (!empty($tax_queries)) {
        $args['tax_query'] = $tax_queries;
    }

    $meta_query = array(
        array(
            'key' => 'custom_sticky',
            'value' => 'on',
            'compare' => '==',
        )
    );
    $args['meta_query'] = $meta_query;

    $query = new WP_Query($args);
    $output = generate_posts_html_sticky($query, $post_type, $have_sticky);

    echo $output;
    wp_die();
}

