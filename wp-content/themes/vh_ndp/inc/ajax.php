<?php
/**
 * Ajax hundlers
 *
 * @package NDP
 */

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
function generate_posts_html($query, $post_type, $paged = 1)
{
    $response = [];
    $filters = !empty($_POST['filters'])? $_POST['filters'] : [];
    $pathname = !empty($_POST['pathname'])? sanitize_text_field($_POST['pathname']) : '';

    ob_start();
//    if ($have_sticky === '1') {
//        $is_have_sticky = true;
//    } else {
//        $is_have_sticky = false;
//    }

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

    // var_dump($is_have_sticky);

    if ($query->have_posts()) {
        $counterPost = 0;

        while ($query->have_posts()) {
            $query->the_post();
            $counterPost++;
            $custom_sticky = get_post_meta(get_the_ID(), 'custom_sticky', true);
            get_template_part( 'template-parts/content-custom',null, compact('post_type','counterPost','category_slug','tag_slug','custom_sticky'));
        }
    } else {
        get_template_part( 'template-parts/content-none', '', ['post_type' => $post_type]);
    }
    wp_reset_postdata();
    $response['data'] = ob_get_clean();


    //pagination
    ob_start();
    $total = $query->max_num_pages;
    $current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
    $base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
    $format  = isset( $format ) ? $format : '';

    if ( $total <= 1 || !$pathname) {
        $response['pagination'] = ob_get_clean();
        return $response;
    }

    $base = $pathname;
    $orig_req_uri = $_SERVER['REQUEST_URI'];

    //admin-ajax.php/page/ issue
    // Overwrite the REQUEST_URI variable
    $_SERVER['REQUEST_URI'] = preg_replace('/page\/[0-9]+\/?/', '', $base);
    ?>
    <nav class="pagination">
        <?php
        echo paginate_links(array(
            'base' => get_pagenum_link( $paged - 1 ) . '%_%',
            'format' => 'page/%#%',
            'current' => $current,
            'total' => $total,
            'prev_text' => '<img src="' . get_template_directory_uri() . '/assets/img/icon/icon-pagination.svg" alt="prev">',
            'next_text' => '<img src="' . get_template_directory_uri() . '/assets/img/icon/icon-pagination.svg" alt="next">',
            'add_args' => $filters,
        ));
        ?>
    </nav>
    <?php
    // Restore the original REQUEST_URI - in case anything else would resort on it
    $_SERVER['REQUEST_URI'] = $orig_req_uri;

    wp_reset_postdata();
    $response['pagination'] = ob_get_clean();

    return $response;
}


//настройка sticky при выводе популярных записей
function filter_case($orderby = '') {
    global $wpdb;
    $orderby = preg_replace("/{$wpdb->prefix}postmeta\.meta_value DESC, {$wpdb->prefix}postmeta\.meta_value\+0 DESC/", "{$wpdb->prefix}postmeta.meta_value DESC, mt1.meta_value+0 DESC", $orderby);
    return $orderby;
}

/**
 * By Category
 */
add_action('wp_ajax_filter_posts_by_category', 'filter_posts_by_category');
add_action('wp_ajax_nopriv_filter_posts_by_category', 'filter_posts_by_category');

function filter_posts_by_category()
{
    $filters = !empty($_POST['filters'])? $_POST['filters'] : [];
    $post_type = isset($_POST['post_type']) ? sanitize_text_field($_POST['post_type']) : '';
    $sort_by = isset($_POST['sort_by']) ? sanitize_text_field($_POST['sort_by']) : '';
    $paged = !empty($_POST['page'])? sanitize_text_field($_POST['page']) : 1;
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

    add_filter( 'posts_orderby', 'filter_case' );
    $query = new WP_Query($args);
    remove_filter( 'posts_orderby', 'filter_case' );

    $output = generate_posts_html($query, $post_type, $paged);

    $filters = array_filter($filters, function($value, $key) {
        return !preg_match('/category/', $key);
    }, ARRAY_FILTER_USE_BOTH);
    $httpGetParams = http_build_query($filters);
    $output['httpGetParams'] = $httpGetParams;
    $output['sql'] = $query->request;

    wp_send_json($output);
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
    $have_sticky = isset($_POST['is_have_sticky'])? sanitize_text_field($_POST['is_have_sticky']) : false;

    $args = array(
        'post_type' => $post_type,
        'posts_per_page' => 10,
        'post_status' => 'publish',
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

    $query = new WP_Query($args);
    $output = generate_posts_html($query, $post_type, $have_sticky);

    wp_send_json($output);
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
        'post_status' => 'publish',
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

    wp_send_json($output);
}



/**
 * Фильтр товаров
 */
add_action('wp_ajax_filterAction', 'filterAction');
add_action('wp_ajax_nopriv_filterAction', 'filterAction');

function filterAction()
{
    $filters = !empty($_POST['filters'])? $_POST['filters'] : [];
    $template = !empty($_POST['template'])? sanitize_text_field($_POST['template']) : false;
    $pathname = !empty($_POST['pathname'])? sanitize_text_field($_POST['pathname']) : '';
    $paged = !empty($_POST['page'])? sanitize_text_field($_POST['page']) : 1;
    $category = !empty($_POST['category'])? sanitize_text_field($_POST['category']) : '';
    $sortCount = !empty($_POST['sortCount'])? sanitize_text_field($_POST['sortCount']) : -1;
    $response = [];

    $_SESSION['showCount'] = $sortCount;

    $args = [
        'post_type' => 'product',
        'posts_per_page' => $sortCount,
        'post_status' => 'publish',
        'paged' => $paged,
    ];

    $tax_queries = prepareTaxQueriesArray($filters);

    if (!empty($tax_queries)) {
        $args['tax_query'] = $tax_queries;
    }

    if (!empty($category)) {
        $args['product_cat'] = $category;
    }

    $query = new WP_Query($args);

    if ($template) {
        $response = [];
        if ($category) {
            $category = get_term_by( 'slug', $category, 'product_cat' );
            $description = get_field('single_category_description', $category);
            if ($description) {
                $response['category_description'] = $description;
            }
        }

        ob_start();
        if ($query->have_posts()) {
            while ($query->have_posts()) :
                $query->the_post();
                wc_get_template_part( 'content', 'product' );
            endwhile;
        } else {
            do_action( 'woocommerce_no_products_found' );
        }
        $response['products'] = ob_get_clean();

        $httpGetFilterParams = http_build_query($filters);
        $response['httpGetFilterParams'] = $httpGetFilterParams;

        //pagination
        ob_start();
        $total = $query->max_num_pages;
        $current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
        $base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
        $format  = isset( $format ) ? $format : '';

        if ( $total <= 1 || !$pathname) {
            $response['pagination'] = ob_get_clean();
            wp_send_json($response);
        }

        $base = $pathname;
        $orig_req_uri = $_SERVER['REQUEST_URI'];

        //admin-ajax.php/page/ issue
        // Overwrite the REQUEST_URI variable
        $_SERVER['REQUEST_URI'] = preg_replace('/page\/[0-9]+\/?/', '', $base);
        ?>
        <div class="pagination">
            <div class="pagination__wrap">
                <?php
                echo paginate_links(array(
                    'base' => get_pagenum_link( $paged - 1 ) . '%_%',
                    'format' => 'page/%#%',
                    'current' => $current,
                    'total' => $total,
                    'prev_text'    => '<span><i class="arrow arrow-left"></i></span>',
                    'next_text'    => '<span><i class="arrow arrow-right"></i></span>',
                    'custom_pagination' => true,
                    'add_args' => $filters,
                ));
                ?>
            </div>
        </div>
        <?php
        // Restore the original REQUEST_URI - in case anything else would resort on it
        $_SERVER['REQUEST_URI'] = $orig_req_uri;

        wp_reset_postdata();
        $response['pagination'] = ob_get_clean();

        wp_send_json($response);
    }
    wp_reset_postdata();

    wp_send_json($query->posts);
}


/**
 * Add to comparison
 */
add_action('wp_ajax_addToComparison', 'addToComparison');
add_action('wp_ajax_nopriv_addToComparison', 'addToComparison');

function addToComparison()
{
    $response = [];
    $productId = !empty($_POST['productId'])? (int)sanitize_text_field($_POST['productId']) : false;
    if ($productId) {
        $current_lang = apply_filters( 'wpml_current_language', 'uk');
        if (!isset($_SESSION['comparisonArray'][$current_lang])) {
            $_SESSION['comparisonArray'][$current_lang] = [];
        }
        if (!in_array($productId, $_SESSION['comparisonArray'][$current_lang])) {
            $_SESSION['comparisonArray'][$current_lang][] = $productId;
        }

        $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
        foreach ($languages as $lang => $langArray) {
            if (!isset($_SESSION['comparisonArray'][$lang])) {
                $_SESSION['comparisonArray'][$lang] = [];
            }
            $translatedId = apply_filters( 'wpml_object_id', $productId, 'product', true, $lang );
            if (empty($translatedId)) continue;

            if (!in_array($translatedId, $_SESSION['comparisonArray'][$lang])) {
                $_SESSION['comparisonArray'][$lang][] = $translatedId;
            }
        }
        $response['message'] = count($_SESSION['comparisonArray'][$current_lang]);
    }

    wp_send_json($response);
}

/**
 * Remove from comparison
 */
add_action('wp_ajax_removeFromComparison', 'removeFromComparison');
add_action('wp_ajax_nopriv_removeFromComparison', 'removeFromComparison');

function removeFromComparison()
{
    $response = [];
    $productId = !empty($_POST['productId'])? (int)sanitize_text_field($_POST['productId']) : false;
    if ($productId) {
        $current_lang = apply_filters( 'wpml_current_language', 'uk');
        if (isset($_SESSION['comparisonArray']) && is_array($_SESSION['comparisonArray'][$current_lang]) && in_array($productId, $_SESSION['comparisonArray'][$current_lang])) {
            if (($key = array_search($productId, $_SESSION['comparisonArray'][$current_lang])) !== false) {
                unset($_SESSION['comparisonArray'][$current_lang][$key]);
            }
        }
        $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
        foreach ($languages as $lang => $langArray) {
            $translatedId = apply_filters( 'wpml_object_id', $productId, 'product', true, $lang );
            if (isset($_SESSION['comparisonArray']) && is_array($_SESSION['comparisonArray'][$lang]) && in_array($translatedId, $_SESSION['comparisonArray'][$lang])) {
                if (($key = array_search($translatedId, $_SESSION['comparisonArray'][$lang])) !== false) {
                    unset($_SESSION['comparisonArray'][$lang][$key]);
                }
            }
        }
        $count = count($_SESSION['comparisonArray'][$current_lang]);
        if ($count == 0) {
            unset($_SESSION['comparisonArray']);
        }
        $response['message'] = $count;
    }

    wp_send_json($response);
}

//Количество просмотров
add_action('wp_ajax_updateNumberOfViews', 'updateNumberOfViews');
add_action('wp_ajax_nopriv_updateNumberOfViews', 'updateNumberOfViews');

function updateNumberOfViews()
{
    global $wpdb;

    preg_match('/product-brands/', $_SERVER['HTTP_REFERER'], $result);
    if (!empty($result)) {
        $type_id = !empty($_POST['id'])? (int)sanitize_text_field($_POST['id']) : false;
        $type = !empty($_POST['type'])? sanitize_text_field($_POST['type']) : false;
        if ($type_id && $type) {
            $tableName = $wpdb->prefix .'number_of_views';
            $sql = "UPDATE {$tableName} SET views = views + 1 WHERE entity_type='{$type}' AND type_id='{$type_id}'";
            $result = $wpdb->query($sql);
            if ($result === FALSE || $result < 1) {
                $wpdb->insert($tableName, ['entity_type' => $type, 'type_id' => $type_id]);
            }
        }
    }

    wp_die();
}

/**
 * зарегистрированные на курсы в разных языках, популярность курса
 * @param string $courseType course, survey
 * @return array
 */
function getEnrolledIdsByPopularity($courseType = 'course', $user_role = '') {
    $innerArgs = [
        'post_type' => 'course',
        'posts_per_page' => -1,
        'post_status' => 'publish',
        'suppress_filters' => true,
    ];
    if ($courseType == 'course') {
        $innerArgs['meta_query'] = [
            [
                'key' => 'type',
                'value' => 1,
                'compare' => '!='
            ]
        ];
    } elseif ($courseType == 'survey') {
        $innerArgs['meta_query'] = [
            'relation' => 'AND',
            [
                'key' => 'type',
                'value' => 1,
                'compare' => '='
            ],
            [
                'key' => 'survey_start_date',
                'value' => date('Ymd'), // Lowest date value
                'compare' => '<=',
            ],
            [
                'key' => 'survey_finish_date',
                'value' => date('Ymd'), // Highest date value
                'compare' => '>=',
            ],
        ];
        if (!empty($user_role)) {
            $innerArgs['meta_query'][] = [
                'key' => 'survey_user_roles',
                'value' => $user_role,
                'compare' => 'LIKE',
            ];
        }
    }
    $innerQuery = new WP_Query($innerArgs);

    $courseEnrollCount = [];
    $courseEnrollCountByLang = [];
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

    return $courseEnrollCount;
}


/**
 * Фильтр курсов
 */
add_action('wp_ajax_filterCoursesAction', 'filterCoursesAction');
add_action('wp_ajax_nopriv_filterCoursesAction', 'filterCoursesAction');

function filterCoursesAction()
{
    $filtersTax = !empty($_POST['filtersTax'])? $_POST['filtersTax'] : [];
    $filtersMeta = !empty($_POST['filtersMeta'])? $_POST['filtersMeta'] : [];
    $filtersPost = !empty($_POST['filtersPost'])? $_POST['filtersPost'] : [];
    $template = !empty($_POST['template'])? sanitize_text_field($_POST['template']) : false;
    $pathname = !empty($_POST['pathname'])? sanitize_text_field($_POST['pathname']) : '';
    $paged = !empty($_POST['paged'])? sanitize_text_field($_POST['paged']) : 1;
    $courseType = !empty($_POST['courseType'])? sanitize_text_field($_POST['courseType']) : 'course';
    $user_role = !empty($_POST['user_role'])? sanitize_text_field($_POST['user_role']) : '';
    $response = [];

    if (!in_array($courseType, ['course', 'survey'])) {
        $courseType = 'course';
    }

    $args = [
        'post_type' => 'course',
        'posts_per_page' => $template? get_option( 'lifterlms_shop_courses_per_page', 10 ) : -1,
        'post_status' => 'publish',
        'paged' => $paged,
    ];

    if (isset($_SESSION) && !empty($_SESSION['sortCourses']) && is_string($_SESSION['sortCourses'])) {
        $sort = $_SESSION['sortCourses'];
        if ($sort == 'popularity') {
            $courseEnrollCount = getEnrolledIdsByPopularity($courseType, $user_role);
            if (!empty($courseEnrollCount)) {
                $args['post__in'] = array_keys($courseEnrollCount);
                $args['orderby'] = 'post__in';
            }
        } elseif ($sort == 'name') {
            $args['order'] = 'ASC';
            $args['orderby'] = 'title';
        }
    } else {
        $args['order'] = 'ASC';
        $args['orderby'] = 'title';
    }

    $tax_query = prepareTaxQueriesArray($filtersTax);

    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    $meta_query = prepareMetaQueriesArray($filtersMeta);
    if ($courseType == 'course') {
        $meta_query[] = [
            'key' => 'type',
            'value' => 1,
            'compare' => '!='
        ];
    } elseif ($courseType == 'survey') {
        $meta_query['relation'] = 'AND';
        $meta_query[] = [
            'key' => 'type',
            'value' => 1,
            'compare' => '='
        ];
        $meta_query[] = [
            'key' => 'survey_start_date',
            'value' => date('Ymd'), // Lowest date value
            'compare' => '<=',
        ];
        $meta_query[] = [
            'key' => 'survey_finish_date',
            'value' => date('Ymd'), // Highest date value
            'compare' => '>=',
        ];
        if (!empty($user_role)) {
            $meta_query[] = [
                'key' => 'survey_user_roles',
                'value' => $user_role,
                'compare' => 'LIKE',
            ];
        }
    }
    if (!empty($meta_query)) {
        $args['meta_query'] = $meta_query;
    }

    if (!empty($filtersPost)) {
        $data = preparePostDataArray($filtersPost);
        if (!empty($data)) {
            $args = array_merge($args, $data);
        }
    }

    $query = new WP_Query($args);

    //return html
    if ($template) {
        $response = [];

        ob_start();
        if ($query->have_posts()) {
            while ($query->have_posts()) :
                $query->the_post();
                llms_get_template( 'loop/content.php' );
            endwhile;
        } else {
            llms_get_template( 'loop/none-found.php' );
        }
        $response['courses'] = ob_get_clean();
        $response['coursesCount'] = $query->posts;

        $httpGetFilterParams = http_build_query(array_merge($filtersTax, $filtersMeta, $filtersPost));
        $response['httpGetFilterParams'] = $httpGetFilterParams;


        //pagination
        ob_start();
        $total = $query->max_num_pages;
        $current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
        $base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
        $format  = isset( $format ) ? $format : '';

        if ( $total <= 1 || !$pathname) {
            $response['pagination'] = ob_get_clean();
            wp_send_json($response);
        }

        $base = $pathname;
        $orig_req_uri = $_SERVER['REQUEST_URI'];

        //admin-ajax.php/page/ issue
        // Overwrite the REQUEST_URI variable
        $_SERVER['REQUEST_URI'] = preg_replace('/page\/[0-9]+\/?/', '', $base);
        ?>
        <div class="pagination">
            <div class="pagination__wrap">
                <?php
                echo paginate_links(
                    array( // WPCS: XSS ok.
                        'base' => get_pagenum_link( $paged - 1 ) . '%_%',
                        'format' => 'page/%#%',
                        'current'   => max( 1, $paged),
                        'total'     => $total,
                        'prev_text' => is_rtl() ? '<span><i class="arrow arrow-right"></i></span>' : '<span><i class="arrow arrow-left"></i></span>',
                        'next_text' => is_rtl() ? '<span><i class="arrow arrow-left"></i></span>' : '<span><i class="arrow arrow-right"></i></span>',
                        'end_size'  => 3,
                        'mid_size'  => 3,
                        'add_args' => array_merge($filtersTax, $filtersMeta, $filtersPost),
                        'custom_pagination' => true,
                    )
                );
                ?>
            </div>
        </div>
        <?php
        // Restore the original REQUEST_URI - in case anything else would resort on it
        $_SERVER['REQUEST_URI'] = $orig_req_uri;

        wp_reset_postdata();
        $response['pagination'] = ob_get_clean();
        wp_send_json($response);
    }
    wp_reset_postdata();

    wp_send_json($query->posts);//count
}

// Допустим, что функции prepareTaxQueriesArray, prepareMetaQueriesArray и preparePostDataArray уже определены

function course_posts_orderby_filter_desc( $orderby ){

    $orderby = "mt2.meta_value+0 DESC";

    return $orderby;
}
function course_posts_orderby_filter_asc( $orderby ){

    $orderby = "mt2.meta_value+0 ASC";

    return $orderby;
}
function course_posts_groupby_filter( $groupby ){

    global $wpdb;
    $groupby = "{$wpdb->prefix}postmeta.meta_value";

    return $groupby;
}

/**
 * Сортировка курсов
 */
add_action('wp_ajax_sortCoursesAction', 'sortCoursesAction');
add_action('wp_ajax_nopriv_sortCoursesAction', 'sortCoursesAction');

function sortCoursesAction()
{
    $sort = !empty($_POST['sort'])? trim($_POST['sort']) : '';
    $filtersTax = !empty($_POST['filtersTax'])? $_POST['filtersTax'] : [];
    $filtersMeta = !empty($_POST['filtersMeta'])? $_POST['filtersMeta'] : [];
    $filtersPost = !empty($_POST['filtersPost'])? $_POST['filtersPost'] : [];
    $template = !empty($_POST['template'])? sanitize_text_field($_POST['template']) : false;
    $pathname = !empty($_POST['pathname'])? sanitize_text_field($_POST['pathname']) : '';
    $paged = !empty($_POST['paged'])? sanitize_text_field($_POST['paged']) : 1;
    $courseType = !empty($_POST['courseType'])? sanitize_text_field($_POST['courseType']) : 'course';
    $user_role = !empty($_POST['user_role'])? sanitize_text_field($_POST['user_role']) : '';
    $response = [];
    if (!$sort) return;

    if (!in_array($courseType, ['course', 'survey'])) {
        $courseType = 'course';
    }

    if (isset($_SESSION)) {
        $_SESSION['sortCourses'] = $sort;
    }

    $args = [
        'post_type' => 'course',
        'posts_per_page' => $template? get_option( 'lifterlms_shop_courses_per_page', 10 ) : -1,
        'paged' => $paged,
        'post_status' => 'publish',
    ];

    $courseEnrollCount = [];
    if ($sort == 'popularity') {

        //Поиск одинаковых курсов в разных языках и подсчёт количества учащихся в одном курсе на разных языках
        $courseEnrollCount = getEnrolledIdsByPopularity($courseType, $user_role);

    } elseif ($sort == 'name') {

        $args['order'] = 'ASC';
        $args['orderby'] = 'title';

    } elseif ($sort == 'price-desc' || $sort == 'price-asc') {

        $ascDesc = $sort == 'price-asc'? 'asc' : 'desc';
        $argsAccessPlans = [
            'post_type' => 'llms_access_plan',
            'posts_per_page' => $template? get_option( 'lifterlms_shop_courses_per_page', 10 ) : -1,
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
                $args['post__in'] = $ids;
            }
        }
    }


    $tax_query = prepareTaxQueriesArray($filtersTax);
    if (!empty($tax_query)) {
        $args['tax_query'] = $tax_query;
    }

    $meta_query = prepareMetaQueriesArray($filtersMeta);
//    if (!empty($meta_query)) {
//        $args['meta_query'] = $meta_query;
//    }

    if (!empty($filtersPost)) {
        $data = preparePostDataArray($filtersPost);
        if (!empty($data)) {
            $args = array_merge($args, $data);
        }
    }

    if (!empty($courseEnrollCount)) {
        $args['post__in'] = array_keys($courseEnrollCount);
        $args['orderby'] = 'post__in';
    }

    if ($courseType == 'course') {
        $meta_query[] = [
            'key' => 'type',
            'value' => 1,
            'compare' => '!='
        ];
    } elseif ($courseType == 'survey') {
        $meta_query[] = [
            'key' => 'type',
            'value' => 1,
            'compare' => '='
        ];
        $meta_query[] = [
            'key' => 'survey_start_date',
            'value' => date('Ymd'), // Lowest date value
            'compare' => '<=',
        ];
        $meta_query[] = [
            'key' => 'survey_finish_date',
            'value' => date('Ymd'), // Highest date value
            'compare' => '>=',
        ];
        if (!empty($user_role)) {
            $meta_query[] = [
                'key' => 'survey_user_roles',
                'value' => $user_role,
                'compare' => 'LIKE',
            ];
        }
    }
    $args['meta_query'] = $meta_query;

    $query = new WP_Query($args);

    //return html
    if ($template) {
        $response = [];

        ob_start();
        if ($query->have_posts()) {
            while ($query->have_posts()) :
                $query->the_post();
                llms_get_template( 'loop/content.php' );
            endwhile;
        } else {
            llms_get_template( 'loop/none-found.php' );
        }
        $response['courses'] = ob_get_clean();
        $response['coursesCount'] = $query->posts;

        $httpGetFilterParams = http_build_query(array_merge($filtersTax, $filtersMeta, $filtersPost));
        $response['httpGetFilterParams'] = $httpGetFilterParams;

        //pagination
        ob_start();
        $total = $query->max_num_pages;
        $current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
        $base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999, '%#%', remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
        $format  = isset( $format ) ? $format : '';

        if ( $total <= 1 || !$pathname) {
            $response['pagination'] = ob_get_clean();
            wp_send_json($response);
        }

        $base = $pathname;
        $orig_req_uri = $_SERVER['REQUEST_URI'];

        //admin-ajax.php/page/ issue
        // Overwrite the REQUEST_URI variable
        $_SERVER['REQUEST_URI'] = preg_replace('/page\/[0-9]+\/?/', '', $base);
        ?>
        <div class="pagination">
            <div class="pagination__wrap">
                <?php
                echo paginate_links(
                    array( // WPCS: XSS ok.
                        'base' => get_pagenum_link( $paged - 1 ) . '%_%',
                        'format' => 'page/%#%',
                        'current'   => max( 1, $paged),
                        'total'     => $total,
                        'prev_text' => is_rtl() ? '<span><i class="arrow arrow-right"></i></span>' : '<span><i class="arrow arrow-left"></i></span>',
                        'next_text' => is_rtl() ? '<span><i class="arrow arrow-left"></i></span>' : '<span><i class="arrow arrow-right"></i></span>',
                        'end_size'  => 3,
                        'mid_size'  => 3,
                        'add_args' => array_merge($filtersTax, $filtersMeta, $filtersPost),
                        'custom_pagination' => true,
                    )
                );
                ?>
            </div>
        </div>
        <?php
        // Restore the original REQUEST_URI - in case anything else would resort on it
        $_SERVER['REQUEST_URI'] = $orig_req_uri;

        wp_reset_postdata();
        $response['pagination'] = ob_get_clean();
        wp_send_json($response);
    }
    wp_reset_postdata();

    wp_send_json($response);//count
}


/**
 * Сохранение вопросов Wizard в админке
 */
add_action('wp_ajax_saveWizardAction', 'saveWizardAction');
add_action('wp_ajax_nopriv_saveWizardAction', 'saveWizardAction');

function saveWizardAction()
{
    $response = [];
    $wizardData = $_POST['data'] ?? [];
    if (empty($wizardData)) wp_die();

    global $wpdb;
    $tableName = $wpdb->prefix .'wizard_filter';

    foreach ($wizardData as $data) {
        $question_uk = !empty($data['question_uk'])? sanitize_text_field($data['question_uk']) : '';
        $question_en = !empty($data['question_en'])? sanitize_text_field($data['question_en']) : '';
        $question_de = !empty($data['question_de'])? sanitize_text_field($data['question_de']) : '';
        $questionsArray = [];
        $questionsArray[] = "question_uk = '{$question_uk}'";
        $questionsArray[] = "question_en = '{$question_en}'";
        $questionsArray[] = "question_de = '{$question_de}'";

        $lang = !empty($data['lang'])? sanitize_text_field($data['lang']) : '';
        $category = !empty($data['category'])? sanitize_text_field($data['category']) : '';
        $id = !empty($data['id'])? (int)sanitize_text_field($data['id']) : '';
        if (empty($questionsArray) || !$category || empty($data['filters']) || empty($lang)) continue;

        $filtersData = [];
        foreach ($data['filters'] as $type => $filters) {
            if (!is_array($filters)) continue;
            foreach ($filters as $filter) {
                $filtersData[$type][] = [
                    'value' => $filter['value'],
                    'name' => $filter['name'],
                ];
            }
        }
        if (empty($filtersData)) continue;

        $filters = maybe_serialize($filtersData);

        if ($id) {
            $questions = implode(',', $questionsArray);

            $sql = "UPDATE {$tableName} SET {$questions}, category = '{$category}', filters_{$lang} = '{$filters}' WHERE id='{$id}'";
            $result = $wpdb->query($sql);
        } else {
            $data = [
                'category' => $category,
                'filters_'.$lang => $filters,
            ];
            if (!empty($question_uk)) {
                $data['question_uk'] = $question_uk;
            }
            if (!empty($question_en)) {
                $data['question_en'] = $question_en;
            }
            if (!empty($question_de)) {
                $data['question_de'] = $question_de;
            }
            $result = $wpdb->insert($tableName, $data);
        }
    }

    $questions = $wpdb->get_results("SELECT * FROM {$tableName}", ARRAY_A);
    $response['questions'] = $questions;
    $response['wizardData'] = $wizardData;

    wp_send_json($response);
}

/**
 * Удаление вопросов Wizard
 */
add_action('wp_ajax_deleteWizardQuestion', 'deleteWizardQuestion');

function deleteWizardQuestion()
{
    $response = [];
    $id = !empty($_POST['id'])? (int)sanitize_text_field($_POST['id']) : '';
    if ($id) {
        global $wpdb;

        $tableName = $wpdb->prefix .'wizard_filter';
        $wpdb->delete($tableName, [ 'id' => $id ], [ '%d' ]);
    }

    wp_send_json($response);
}


/**
 * Проверка ответа quiz
 */
add_action('wp_ajax_checkQuizAnswer', 'checkQuizAnswer');
add_action('wp_ajax_nopriv_checkQuizAnswer', 'checkQuizAnswer');

function checkQuizAnswer()
{
    $response = [];
    $id = !empty($_POST['questionID'])? (int)sanitize_text_field($_POST['questionID']) : '';
    $values = !empty($_POST['values'])? (array)$_POST['values'] : [];
    if (!$id || empty($values) || !$question = new LLMS_Question($id)) wp_die();

    $rightAnswers = 0;
    $choceRightAnswers = 0;
    foreach ( $question->get_choices() as $choice ) {
        $chiceId = $choice->get('id');
        $data = $choice->get_data();
        if (!$data['correct']) continue;

        $rightAnswers++;
        foreach ($values as $value) {
            if ($chiceId != $value) continue;

            if (!$data['correct']) {
                wp_die();
            }
            $choceRightAnswers++;
        }
    }

    if ($rightAnswers == count($values) && $rightAnswers == $choceRightAnswers) {
        $response['result'] = true;
    }
    wp_send_json($response);
}


//Сохранение сертификата
function redirectAfterSubmitCertificate() {
    if (! wp_verify_nonce( sanitize_text_field($_POST['upload_certificate_nonce']), 'upload_certificate') ) {
        return;
    }

    if (isset($_POST["user_id"])) {
        $cert_name = isset($_POST['cert_name'])? sanitize_text_field($_POST['cert_name']) : '';
        $organizationName = isset($_POST['organizationName'])? sanitize_text_field($_POST['organizationName']) : '';
        $dateObtaining = isset($_POST['dateObtaining'])? sanitize_text_field($_POST['dateObtaining']) : '';
        $validityDate = isset($_POST['validityDate'])? sanitize_text_field($_POST['validityDate']) : '';
        $indefinite = isset($_POST['indefinite'])? sanitize_text_field($_POST['indefinite']) : '';
        $courseTitle = isset($_POST['courseTitle'])? sanitize_text_field($_POST['courseTitle']) : '';
        $courseAuthor = isset($_POST['courseAuthor'])? sanitize_text_field($_POST['courseAuthor']) : '';
        $link_to_course = isset($_POST['link_to_course'])? sanitize_text_field($_POST['link_to_course']) : '';
        $formType = isset($_POST['formType'])? sanitize_text_field($_POST['formType']) : '';
        $certID = isset($_POST['certID'])? (int)sanitize_text_field($_POST['certID']) : '';
        $user_id = sanitize_text_field($_POST['user_id']);
        $user = get_userdata( $user_id );
        $errors = [];
        if ($user === false) {
            wp_redirect( "/dashboard/my-certificates", 301 );
            die();
        }
        if (empty($cert_name)) {
            $errors['cert_name'] = 'cert_name error';
        }
        if (empty($organizationName)) {
            $errors['organizationName'] = 'organizationName error';
        }
        if ($indefinite != 'on' && empty($dateObtaining)) {
            $errors['dateObtaining'] = 'dateObtaining error';
        }
        if ($indefinite != 'on' && empty($validityDate)) {
            $errors['validityDate'] = 'validityDate error';
        }
        if (empty($link_to_course)) {
            $errors['link_to_course'] = 'link_to_course error';
        }
        if (isset($_FILES['fileToUpload']) && !empty($_FILES['fileToUpload']['name'])) {
            $filetype = wp_check_filetype($_FILES['fileToUpload']['name']);
            if ($filetype && $filetype['type'] != 'application/pdf') {
                $errors['fileToUpload'] = 'fileToUpload error';
            }
        }
        if (!empty($errors) && isset($_SESSION)) {
            $_SESSION['cert_errors'] = $errors;
            wp_send_json(['errors' => $errors]);
//            wp_redirect( "/dashboard/my-certificates/?upload&error", 301 );
            die();
        }

        $cert_data = [
            'cert_name' => $cert_name,
            'organizationName' => $organizationName,
            'dateObtaining' => $dateObtaining,
            'validityDate' => $validityDate,
            'indefinite' => $indefinite,
            'courseTitle' => $courseTitle,
            'courseAuthor' => $courseAuthor,
            'user_id' => $user_id,
            'link_to_course' => $link_to_course,
        ];

        $post_data = [
            'post_type' => 'custom_certificate',
            'post_title' => $cert_name,
            'post_content' => '',
            'post_status' => 'publish',
            'post_author' => $user_id,
            'comment_status' => 'under_review',
        ];
        if ($formType == 'upload') {
            $post_id = wp_insert_post($post_data);
        } elseif ($formType == 'edit' && !empty($certID)) {
            $post_data['ID'] = $certID;
            $post_id = wp_update_post($post_data);
        }


        if ($post_id) {
            if (isset($_FILES['fileToUpload']) && !empty($_FILES['fileToUpload']['name'])) {

                $filetype = wp_check_filetype($_FILES['fileToUpload']['name']);
                if ($filetype && $filetype['type'] == 'application/pdf') {
                    $upload_file = wp_upload_bits($_FILES['fileToUpload']['name'], null, file_get_contents($_FILES['fileToUpload']["tmp_name"]));
                    if (!$upload_file['error']) {
                        $cert_data['pdf_url'] = $upload_file['url'];
                        $cert_data['pdf_size'] = $_FILES['fileToUpload']['size'];
                    }
                }
            }

            if ($formType == 'upload') {
                add_post_meta($post_id, 'custom_certificate_data', $cert_data);
            } elseif ($formType == 'edit' && !empty($certID)) {
                update_post_meta($post_id, 'custom_certificate_data', $cert_data);
            }

            $_SESSION['certificate_uploaded'] = true;
            wp_send_json(['message' => 'ok']);
        }

        wp_send_json(['message' => 'error']);
    }
}
add_action('wp_ajax_redirectAfterSubmitCertificate', 'redirectAfterSubmitCertificate');
add_action('wp_ajax_nopriv_redirectAfterSubmitCertificate', 'redirectAfterSubmitCertificate');

//Удаление сертификата
function customCertificateDeleteHandler()
{
    $post_id = sanitize_text_field($_POST['post_id']);
    if (!$post_id) return;

    $certData = get_post_meta($post_id, 'custom_certificate_data', true);

    $deleted = wp_delete_post($post_id, true);
    if ($deleted) {

        if (!empty($certData) && !empty($certData['pdf_url'])) {
            $pathToPdf = realpath($_SERVER['DOCUMENT_ROOT'] . parse_url( $certData['pdf_url'], PHP_URL_PATH ));
            if ($pathToPdf) {
                wp_delete_file( $pathToPdf );
            }
        }

        wp_send_json(['message' => 'ok']);
    }
    die();
}

add_action('wp_ajax_customCertificateDeleteHandler', 'customCertificateDeleteHandler');
add_action('wp_ajax_nopriv_customCertificateDeleteHandler', 'customCertificateDeleteHandler');


function invitationToMunicipality(WP_User $user, string $uuid='') {
    global $wpdb;
    $response = [];
    if ($uuid) {
        $invitedUser = get_invited_representatives('', '', ['invite' => $uuid]);
    } else {
        $invitedUser = get_invited_representatives('', $user->user_email);
    }
    if (!empty($invitedUser)) {
        $invitedUser = $invitedUser[0];
        $head_user = (int)$invitedUser['head_user'];
        if ($head_user && $municipality = head_of_municipality($head_user)) {
            $municipality = !empty($municipality)? $municipality[0] : null;
            if (empty(representative_of_municipality($user->ID, $municipality['id']))) {
                $job = get_data_from_table('users_job_title', [
                    'where' => " WHERE `position`='{$invitedUser['position']}'",
                ]);
                if ($job) {
                    $job = $job[0];
                    $table_name = $wpdb->prefix . 'users_of_municipality';
                    if ($result = $wpdb->insert(
                        $table_name,
                        array(
                            'user_id' => $user->ID,
                            'municipality_id' => $municipality['id'],
                            'position_id' => $job->id,
                        ),
                        array('%s', '%s', '%s', '%s', '%s', '%d')
                    )) {
                        if (!empty($textOrganization)) {
                            update_user_meta( $user->ID, 'user_organization', $textOrganization );
                        }
//                        if (!empty($invitedUser['first_name'])) {
//                            update_user_meta( $user->ID, 'first_name', $invitedUser['first_name'] );
//                        }
                        $response = [
                            'status' => __('Approved', 'ndp'),
                            'message' => __('Request successfully approved', 'ndp'),
                        ];
                    }
                }
            }
        }
    }
    return $response;
}
/**
 * Одобрение или отклонение запросов муниципалитета оператором
 */
add_action('wp_ajax_approveMunicipalityRequest', 'approveMunicipalityRequest');
add_action('wp_ajax_nopriv_approveMunicipalityRequest', 'approveMunicipalityRequest');

function approveMunicipalityRequest()
{
    if (!current_user_can('edit_requests')) exit();

    $statuses = [
        'Await processing', 'Approved', 'Rejected'
    ];
    $operator = wp_get_current_user();
    $response = [];
    $request_id = !empty($_POST['request_id'])? (int)sanitize_text_field($_POST['request_id']) : '';
    $operator_id = $operator? (int)$operator->ID : null;
    $status = !empty($_POST['status'])? sanitize_text_field($_POST['status']) : '';
    $textOrganization = !empty($_POST['text'])? sanitize_text_field($_POST['text']) : '';
    if (!$request_id || !$operator_id || !$status || !in_array($status, $statuses)) exit();

    global $wpdb;

    $table_name = $wpdb->prefix . 'municipality_requests';
    $request = $wpdb->get_results("SELECT * FROM {$table_name} WHERE id={$request_id}", ARRAY_A);
    if (!empty($request)) {
        $request = $request[0];
        $wpdb->update( $table_name,
            [
                'operator_id' => $operator_id,
                'status' => $status,
                'assigned' => 'Operator',
                'last_change' => date("Y-m-d H:i:s"),
            ],
            [ 'id' => $request_id ]
        );

        $wpdb->update( $wpdb->prefix ."municipality_requests_clone",
            [
                'operator_id' => $operator_id,
                'status' => $status,
                'assigned' => 'Operator',
                'last_change' => date("Y-m-d H:i:s"),
            ],
            [ 'id' => $request_id ]
        );
        $user = get_userdata($request['user_id']);
        $user_id = $user->ID;

        if ($status == 'Approved') {
            //регистрация главы муниципалитета
            if ($request['type'] == 'Registration') {
                //создание муниципалитета в таблице municipalities
                $municipality = head_of_municipality((int)$request['user_id']);
                if (empty($municipality) && $user) {
                    $table_name = $wpdb->prefix . 'municipalities';
                    $edr = get_user_meta($user->ID, 'edrpou_code', true);
                    $data = [
                        'name' => $user->data->display_name,
                        'edr' => $edr,
                        'head_user' => $user->ID,
                        'date' => date('Y-m-d H:i:s'),
                    ];
                    if ($result = $wpdb->insert($table_name, $data)) {
                        $municipality_id = (int)$wpdb->insert_id;
                    }

                    update_user_meta( $user->ID, 'user_profile_type', 'Representative' );
                    update_user_meta( $user->ID, 'role_representative', 'municipality' );
                    if (!empty($textOrganization)) {
                        update_user_meta( $user->ID, 'user_organization', $textOrganization );
                    }

                    if ($result && !empty($municipality_id)) {
                        $representative = representative_of_municipality($user->ID, $municipality_id);
                        $municipality = head_of_municipality($user->ID, $municipality_id);
                        $municipality = !empty($municipality)? $municipality[0] : null;
                        $job_table_name = $wpdb->prefix . 'users_job_title';
                        $job_position = $wpdb->get_results("SELECT * FROM {$job_table_name} WHERE `position`='Head of municipality'", ARRAY_A);
                        $job_position = !empty($job_position)? $job_position[0] : null;

                        if (empty($representative) && !empty($municipality) && !empty($job_position)) {
                            $table_name = $wpdb->prefix . 'users_of_municipality';
                            $data = [
                                'user_id' => $user->ID,
                                'municipality_id' => $municipality_id,
                                'position_id' => $job_position['id'],
                            ];
                            $result = $wpdb->insert($table_name, $data);
                        }
                        $response = [
                            'status' => __('Approved', 'ndp'),
                            'message' => __('Request successfully approved', 'ndp'),
                        ];
                    }
                }
            } elseif ($request['type'] == 'Invitation') { //приглашение в муниципалитет

                $response = invitationToMunicipality($user);

            }
        } elseif ($status == 'Rejected') {
            $response = [
                'status' => __('Rejected', 'ndp'),
                'message' => __('Request successfully rejected', 'ndp'),
            ];

            $messageText = !empty($_POST['text'])? sanitize_text_field($_POST['text']) : '';
            if (!empty($messageText)) {
                $to = $user->user_email;
                $subject = __("Rejected request", 'ndp');
                $headers = array('Content-Type: text/html; charset=UTF-8');
                ob_start();
                get_template_part('templates/email/email-invitation-reject', '', [
                    'message' => $messageText,
                ]);
                $message = ob_get_clean();
                wp_mail($to, $subject, $message, $headers);
            }

        }

    }

    wp_send_json($response);
}


//Проверяет существует ли запрос к оператору от муниципалитета
add_action('wp_ajax_checkIfOperatorRequestExists', 'checkIfOperatorRequestExists');
add_action('wp_ajax_nopriv_checkIfOperatorRequestExists', 'checkIfOperatorRequestExists');

function checkIfOperatorRequestExists()
{
    $response = [];
    $operator = wp_get_current_user();
    $request_id = !empty($_POST['request_id'])? (int)sanitize_text_field($_POST['request_id']) : '';
    $operator_id = $operator? (int)$operator->ID : null;
    if (!$request_id || !$operator_id) {
        $response['success'] = 'error';
        $response['message'] = __('Error', 'ndp');
        exit();
    }

    global $wpdb;
    $table_name = $wpdb->prefix . 'municipality_requests';
    $request = $wpdb->get_results("SELECT * FROM {$table_name} WHERE id={$request_id}", ARRAY_A);
    if (!empty($request)) {
        $response['success'] = 'ok';
    } else {
        $response['success'] = 'not';
        $response['message'] = __('Request does not exists', 'ndp');
    }

    wp_send_json($response);
}

/**
 * user_profile_type Representative - поле есть у всех представителей муниципалитета,
 * user_profile_type проверяется для появления в боковом меню пункта Municipality,
 * и появляется возможность подачи заявки оператору
 */
add_action('wp_ajax_switchUserToRepresentative', 'switchUserToRepresentative');
add_action('wp_ajax_nopriv_switchUserToRepresentative', 'switchUserToRepresentative');

function switchUserToRepresentative()
{
    $response = [];
    $currentUser = wp_get_current_user();
    $user_id = $currentUser? $currentUser->ID : null;
    if (!$user_id) exit();

    update_user_meta( $user_id, 'user_profile_type', 'Representative' );

    $response = [
        'accountType' => __('Representative', 'ndp'),
        'municipality' => llms_get_template_ajax('myaccount/dashboard-sidebar-municipality.php'),
    ];

    wp_send_json($response);
}


/**
 * Municipality requests pagination
 */
add_action('wp_ajax_municipality_requests_ajax', 'municipality_requests_ajax');
add_action('wp_ajax_nopriv_municipality_requests_ajax', 'municipality_requests_ajax');

function municipality_requests_ajax()
{
    $response = [];
    $page = !empty($_POST['page'])? (int)sanitize_text_field($_POST['page']) : 1;
    $status = !empty($_POST['status'])? sanitize_text_field($_POST['status']) : '';
    $pathname = !empty($_POST['pathname'])? sanitize_text_field($_POST['pathname']) : '';
    if (!$page) exit();

    $args = [
        'page' => $page,
        'parseRequests' => true,
        'translate' => true,//для пагинации
    ];
    if (!empty($status)) {
        $args['where'] = " WHERE `status`='{$status}'";
    }
    if (!empty($pathname)) {
        $args['pathname'] = $pathname;
    }
    $args['template'] = true;

    $requests = get_municipality_requests($args);

    $response = [
        'requests' => $requests,
    ];

    wp_send_json($response);
}

/**
 * dashboard/municipalities/ запрос к оператору на регистрацию
 * Проверка и создание запроса муниципалитета
 */
add_action('wp_ajax_addMunicipalityToRequestTable', 'addMunicipalityToRequestTable');
add_action('wp_ajax_nopriv_addMunicipalityToRequestTable', 'addMunicipalityToRequestTable');

function addMunicipalityToRequestTable()
{
    if (!add_representative_of_municipality()) exit();

    $response = [];
    $currentUser = wp_get_current_user();
    $user_id = $currentUser? $currentUser->ID : null;
    $tin = !empty($_POST['tin'])? sanitize_text_field($_POST['tin']) : '';
    $invited = !empty($_POST['invited'])? filter_var(sanitize_text_field($_POST['invited']), FILTER_VALIDATE_BOOLEAN) : false;
    if (!$user_id) exit();

    $request = get_data_from_table('municipality_requests', [
        'where' => " WHERE `user_id`={$user_id} AND (`type`='Registration' OR `type`='Invitation')"
    ]);

    if (empty($request)) {
        $args = ['assigned' => ''];
        if ($invited) {
            $args['type'] = 'Invitation';
        }
        municipality_add_request($args);
        if ($tin) {
            $edr = get_user_meta($user_id, 'edrpou_code', true);
            if (!$edr) {
                  update_user_meta($user_id, 'edrpou_code', $tin);
            }
        }
        update_user_meta($user_id,'edrpou_code',$tin);
        $response = [
            'message' => 'ok',
            'user_id'=>$user_id,
            'approved' => __('Approved', 'ndp'),
        ];
    }

    wp_send_json($response);
}


/**
 * Отправка сообщения оператору
 */
add_action('wp_ajax_municipality_send_message_to_operator', 'municipality_send_message_to_operator');
add_action('wp_ajax_nopriv_municipality_send_message_to_operator', 'municipality_send_message_to_operator');

function municipality_send_message_to_operator()
{
    $response = [];
    $messageText = !empty($_POST['message'])? sanitize_text_field($_POST['message']) : '';
    $user = wp_get_current_user();
    if (!$messageText || !$user) exit();

    $eventType = 'message to admin';
    $messageText = $messageText . ' ' . __('Sent from page', 'ndp') . ' dashboard/municipalities/';
    if (add_municipality_event($messageText, $eventType, $user)) {
        $response = [
            'message' => __('Your message has been sent', 'ndp'),
        ];
        wp_send_json($response);
    }
    exit;
}

/**
 * Отправка приглашения в муниципалитет
 */
add_action('wp_ajax_send_invite_to_municipality', 'send_invite_to_municipality');
add_action('wp_ajax_nopriv_send_invite_to_municipality', 'send_invite_to_municipality');

function send_invite_to_municipality()
{
    $response = [];
    $email = !empty($_POST['email'])? sanitize_text_field($_POST['email']) : '';
    $tin = !empty($_POST['tin'])? sanitize_text_field($_POST['tin']) : '';
    $userName = !empty($_POST['name'])? sanitize_text_field($_POST['name']) : '';
    $job = !empty($_POST['job'])? sanitize_text_field($_POST['job']) : '';
    $phone = !empty($_POST['phone'])? sanitize_text_field($_POST['phone']) : '';
    $eventType = 'invite to municipality';
    $currentUser = wp_get_current_user();
    $user_id = $currentUser? $currentUser->ID : null;
    if (!$email || ($email && $currentUser->user_email == $email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$user_id || !$tin || !$userName || !$job || !$phone) {
        $response = [
            'status' => 'error',
            'message' => __('Error', 'ndp'),
        ];
        wp_send_json($response);
        exit();
    }

//    if (get_user_by( 'email', $email )) {
//        $response = [
//            'status' => 'exists',
//            'message' => __('A user with this email already exists', 'ndp'),
//        ];
//        wp_send_json($response);
//    }

    $inviteEvent = get_data_from_table('municipality_events', [
        'where' => " WHERE `from_email`='{$currentUser->user_email}' AND `to_email`='{$email}' AND `eventType`='invite to municipality'",
    ]);
    if (!empty($inviteEvent)) {
        $response = [
            'status' => 'already sent',
            'message' => __('invitation has already been sent', 'ndp'),
        ];
        wp_send_json($response);
    }

    function generateUUID($length) {
        $random = '';
        for ($i = 0; $i < $length; $i++) {
            $random .= rand(0, 1) ? rand(0, 9) : chr(rand(ord('a'), ord('z')));
        }
        return $random;
    }
    $textInvite = generateUUID(31);
    $link = get_site_url() . '/dashboard/?invite=' . $textInvite;

    $to = $email;
    $subject = __("You have been sent an invitation to join the organization", 'ndp');
    $headers = array('Content-Type: text/html; charset=UTF-8');


    ob_start();
    $organization = get_user_meta($user_id, 'user_organization', true);
    $text = 'Start work with and your team. You can view what your team is doing.';
    if ($organization) {
        $text = sprintf(__("To join the organization %s, please use the link", 'ndp' ), $organization);
    }
    get_template_part('templates/email/email-invitation', '', [
        'link' => $link,
        'text' => $text,
        'name' => $userName,
    ]);
    $message = ob_get_clean();

    $municipality = head_of_municipality($user_id);
    if (empty($inviteEvent) && !empty($municipality)) {
        $municipality = $municipality[0];
        wp_mail($to, $subject, $message, $headers);
        $represent = [
            'id' => $municipality['id'],
            'name' => $municipality['name'],
            'edr' => $municipality['edr'],
            'head_user' => $municipality['head_user'],
            'position' => $job,
            'user_id' => '',
            'user_login' => '',
            'user_email' => $email,
            'first_name' => $userName,
            'last_name' => '',
            'llms_phone' => $phone,
            'edrpou_code' => $municipality['edr'],
            'edrpouCode' => $tin,//инн
            'country' => '',
            'year_of_birth' => '',
            'month_of_birth' => '',
            'day_of_birth' => '',
            'user_organization' => '',
            'invited' => true,
            'textInvite' => $textInvite,
        ];
        add_municipality_event($textInvite, $eventType, $currentUser, $email, serialize($represent));
        ob_start();
        get_template_part('templates/tr-municipality', '', [
            'represent' => $represent,
            'isHead' => true,
            'municipality_id' => $municipality['id'],
        ]);
        $tr = ob_get_clean();
        $response = [
            'status' => 'invited',
            'message' => __('The invitation was sent successfully', 'ndp'),
            'tr' => $tr,
        ];
    }

    wp_send_json($response);
}

/**
 * Смена должности
 */
add_action('wp_ajax_change_job', 'change_job');
add_action('wp_ajax_nopriv_change_job', 'change_job');

function change_job()
{
    $response = [];
    $job = !empty($_POST['job'])? sanitize_text_field($_POST['job']) : '';
    $municipality_id = !empty($_POST['municipality_id'])? (int)sanitize_text_field($_POST['municipality_id']) : '';
    $user_email = !empty($_POST['user_email'])? sanitize_text_field($_POST['user_email']) : '';
    $invited = !empty($_POST['invited'])? filter_var(sanitize_text_field($_POST['invited']), FILTER_VALIDATE_BOOLEAN) : false;
    $currentUser = wp_get_current_user();
    if (!$job || !$municipality_id || !$user_email || !$currentUser) exit();

    if ($invited) {
        if ($invitedUser = get_invited_representatives($currentUser->user_email, '', [
            'user_email' => $user_email,
        ])) {
            if (change_invited_representatives($currentUser->user_email, [
                'user_email' => $user_email,
            ], ['position' => $job])) {
                $response = ['message' => 'ok'];
            }
        }
    } else {
        $user = get_user_by( 'email', $user_email );
        if ($user && $representative = representative_of_municipality($user->ID, (int)$municipality_id)) {
            $representative = $representative[0];
            if ($jobData = get_data_from_table('users_job_title', [
                'where' => " WHERE `position`='{$job}'",
            ])) {
                global $wpdb;
                $jobData = $jobData[0];
                $table_name = $wpdb->prefix . 'users_of_municipality';
                if ($wpdb->update( $table_name,
                    [
                        'position_id' => $jobData->id,
                    ],
                    [
                        'user_id' => $user->ID,
                        'municipality_id' => (int)$municipality_id,
                    ]
                )) {
                    $response = ['message' => 'ok'];
                }
            }
        }
    }

    if (empty($response)) {
        $response = ['message' => __('Error', 'ndp')];
    }

    wp_send_json($response);
}

/**
 * Отправка сообщения админу
 */
add_action('wp_ajax_send_message_to_admin', 'send_message_to_admin');
add_action('wp_ajax_nopriv_send_message_to_admin', 'send_message_to_admin');

function send_message_to_admin()
{
    $response = [];
    $message = !empty($_POST['message'])? sanitize_text_field($_POST['message']) : '';
    $currentUser = wp_get_current_user();
    if (!$message || !$currentUser) exit();

    $eventType = 'message to admin';
    if (add_municipality_event($message, $eventType, $currentUser)) {
        $response = [
            'message' => __('Your message has been sent', 'ndp'),
        ];
    }

    if ($email = get_option('duplicate_messages_by_email', '')) {
        $subject = __('Message from municipality', 'ndp');
        $to = $email;
        $headers = array('Content-Type: text/html; charset=UTF-8');
        ob_start();
        get_template_part('templates/email/email-some-message', '', [
            'message' => $message,
        ]);
        $message = ob_get_clean();
        wp_mail($to, $subject, $message, $headers);
    }

    wp_send_json($response);
}

/**
 * Отмена приглашения в муниципалитет
 */
add_action('wp_ajax_remove_invite_by_municipality', 'remove_invite_by_municipality');
add_action('wp_ajax_nopriv_remove_invite_by_municipality', 'remove_invite_by_municipality');

function remove_invite_by_municipality()
{
    $response = [];
    $municipality_id = !empty($_POST['municipality_id'])? (int)sanitize_text_field($_POST['municipality_id']) : '';
    $user_email = !empty($_POST['user_email'])? sanitize_text_field($_POST['user_email']) : '';
    $invited = !empty($_POST['invited'])? filter_var(sanitize_text_field($_POST['invited']), FILTER_VALIDATE_BOOLEAN) : false;
    $currentUser = wp_get_current_user();
    if (!$municipality_id || !$user_email || !$currentUser) exit();

    if ($invited) {
        if ($invitedUser = get_invited_representatives($currentUser->user_email, '', [
            'user_email' => $user_email,
        ])) {

            global $wpdb;
            $table_name = $wpdb->prefix . 'municipality_events';
            if ($wpdb->delete( $table_name, [
                'from_email' => $currentUser->user_email,
                'to_email' => $invitedUser[0]['to_email'],
                'eventType' => 'invite to municipality'
            ] )) {
                $response = ['message' => 'ok'];
            }
        }

    }

    wp_send_json($response);
}


/**
 * Удаление представителя из муниципалитета
 */
add_action('wp_ajax_remove_representative_by_municipality', 'remove_representative_by_municipality');
add_action('wp_ajax_nopriv_remove_representative_by_municipality', 'remove_representative_by_municipality');

function remove_representative_by_municipality()
{
    $response = [];
    $municipality_id = !empty($_POST['municipality_id'])? (int)sanitize_text_field($_POST['municipality_id']) : '';
    $user_email = !empty($_POST['user_email'])? sanitize_text_field($_POST['user_email']) : '';
    $invited_email = !empty($_POST['invited_email'])? sanitize_text_field($_POST['invited_email']) : '';
    $currentUser = wp_get_current_user();
    if (!$municipality_id || !$user_email || !$currentUser) exit();

    global $wpdb;

    $user = get_user_by( 'email', $user_email );


    $table_name = $wpdb->prefix . 'users_of_municipality';
    if ($wpdb->delete( $table_name, [
        'user_id' => $user->ID,
        'municipality_id' => $municipality_id,
    ] )) {
        update_user_meta( $user->ID, 'user_profile_type', '' );

        $wpdb->update('wp_applications',[
            'user_id'=>$currentUser->ID
        ],['municipality_id'=>$municipality_id,'user_id'=>$user->ID]);

        $response = ['message' => 'ok'];
        $params = [
            'from_email' => $currentUser->user_email,
            'eventType' => 'invite to municipality'
        ];
        if (!empty($invited_email)) {
            $params['to_email'] = $invited_email;
        } else {
            $params['to_email'] = $user_email;
        }
        $table_name = $wpdb->prefix . 'municipality_events';
        if ($wpdb->delete( $table_name, $params )) {
            $response['params'] = $params;
        }
    }

    clear_user_municipality_meta($user->ID);
    update_user_meta( $user->ID, 'user_profile_type', '' );
    $wpdb->delete($wpdb->prefix ."municipality_requests",['user_id' => $user->ID]);
    wp_send_json($response);
}


/**
 * Сохранение даты рождения
 */
add_action('wp_ajax_profile_settings_save_date_of_birth', 'profile_settings_save_date_of_birth');
add_action('wp_ajax_nopriv_profile_settings_save_date_of_birth', 'profile_settings_save_date_of_birth');

function profile_settings_save_date_of_birth()
{
    $day = !empty($_POST['day'])? sanitize_text_field($_POST['day']) : '';
    $month = !empty($_POST['month'])? sanitize_text_field($_POST['month']) : '';
    if (!is_numeric($month)) {
        $month = date("m", strtotime($month));
    }
    $month = str_pad($month, 2, "0", STR_PAD_LEFT);
    $year = !empty($_POST['year'])? sanitize_text_field($_POST['year']) : '';
    $currentUser = wp_get_current_user();
    $user_id = $currentUser? $currentUser->ID : null;
    if (!$day || !$month || !$year || !$user_id) exit();

    update_user_meta( $user_id, 'day_of_birth', $day );
    update_user_meta( $user_id, 'month_of_birth', $month );
    update_user_meta( $user_id, 'year_of_birth', $year );

    $response = [
        'message' => $day.'.'.$month.'.'.$year, 'ndp',
        'modaltext' => __('Data edited successfully','ndp'),
    ];

    wp_send_json($response);
}

/**
 * Сохранение gender
 */
add_action('wp_ajax_profile_settings_save_gender', 'profile_settings_save_gender');
add_action('wp_ajax_nopriv_profile_settings_save_gender', 'profile_settings_save_gender');

function profile_settings_save_gender() {
    $gender = !empty($_POST['gender'])? sanitize_text_field($_POST['gender']) : '';
    $currentUser = wp_get_current_user();
    $user_id = $currentUser? $currentUser->ID : null;
    if (!$gender || !$user_id) exit();

    update_user_meta( $user_id, 'gender', $gender );

    $response = [
        'message' => __($gender, 'ndp'),
        'modaltext' => __('Data edited successfully','ndp'),
    ];

    wp_send_json($response);
}

/**
 * Сохранение телефона
 */
add_action('wp_ajax_profile_settings_save_phone', 'profile_settings_save_phone');
add_action('wp_ajax_nopriv_profile_settings_save_phone', 'profile_settings_save_phone');

function profile_settings_save_phone() {
    $phone = !empty($_POST['phone'])? sanitize_text_field($_POST['phone']) : '';
    $currentUser = wp_get_current_user();
    $user_id = $currentUser? $currentUser->ID : null;
    if (!$phone || !$user_id || !preg_match('/^\+38\(0\d{2}\) \d{3} \d{2} \d{2}$/', $phone)) exit();

    update_user_meta( $user_id, 'llms_phone', $phone );

    $response = [
        'message' => $phone,
        'modaltext' => __('Data edited successfully','ndp'),
    ];

    wp_send_json($response);
}

/**
 * Password change
 */
add_action('wp_ajax_profile_settings_password_change', 'profile_settings_password_change');
add_action('wp_ajax_nopriv_profile_settings_password_change', 'profile_settings_password_change');

function profile_settings_password_change() {
    if (! wp_verify_nonce( sanitize_text_field($_POST['password_change_nonce']), 'password_change') ) {
        return;
    }

    $oldPassword = !empty($_POST['oldPassword'])? sanitize_text_field($_POST['oldPassword']) : '';
    $password = !empty($_POST['password'])? sanitize_text_field($_POST['password']) : '';
    $confirmPassword = !empty($_POST['confirmPassword'])? sanitize_text_field($_POST['confirmPassword']) : '';
    $currentUser = wp_get_current_user();
    $user_id = $currentUser? $currentUser->ID : null;
    $error = false;
    if (!$oldPassword || !$password || !$confirmPassword || !$user_id) exit();

    if ($password !== $confirmPassword) {
        $error = true;
    }

    if (!$error && wp_check_password( $oldPassword, $currentUser->user_pass, $user_id )) {
        // Обновление пароля пользователя
        $update_result = wp_set_password($password, $user_id);
        if (is_wp_error($update_result)) {
            $error = true;
        } else {
            // Очистка всех сессий пользователя
            wp_clear_auth_cookie();

            // Установка текущего пользователя и инициализация новой сессии
            wp_set_current_user($user_id);
            wp_set_auth_cookie($user_id);
        }
    } else {
        $error = true;
    }

    if ($error) {
        $response = [
            'message' => __('Error', 'ndp')
        ];
    } else {
        $response = [
            'message' => __('Password updated successfully', 'ndp')
        ];
    }

    wp_send_json($response);
}

/**
 * Существует ли пользователь при регистрации
 */
add_action('wp_ajax_checkIfUserExists', 'checkIfUserExists');
add_action('wp_ajax_nopriv_checkIfUserExists', 'checkIfUserExists');

function checkIfUserExists() {
    $email = !empty($_POST['email']) ? sanitize_text_field($_POST['email']) : '';
    if (!$email) exit();

    $current_user = wp_get_current_user();
    $current_user_email = $current_user->user_email;

    // Проверяем, является ли email текущего пользователя тем же, что и переданный email
    if (email_exists($email)) {
        if ($email === $current_user_email) {
            // Email принадлежит текущему пользователю, возвращаем 'ok'
            wp_send_json([
                'message' => 'ok'
            ]);
        } else {
            // Email существует и принадлежит другому пользователю, возвращаем ошибку
            wp_send_json([
                'message' => __('A user with this email already exists', 'ndp')
            ]);
        }
    } else {
        wp_send_json([
            'message' => 'ok'
        ]);
    }
}


/**
 * Смена даты старта опроса
 */
add_action('wp_ajax_launchSurveyByOperator', 'launchSurveyByOperator');
add_action('wp_ajax_nopriv_launchSurveyByOperator', 'launchSurveyByOperator');

function launchSurveyByOperator() {
    $survey_id = !empty($_POST['survey_id'])? (int)sanitize_text_field($_POST['survey_id']) : '';
    if (!$survey_id) exit();

    $survey = get_post($survey_id);
    if (!$survey) exit();

    update_post_meta($survey_id, 'survey_start_date', date('Ymd'));

    $response = [
        'message' => __('The survey is launched', 'ndp'),
        'date' => date('d.m.Y')
    ];
    wp_send_json($response);
}

/**
 * Смена дыты финиша опроса
 */
add_action('wp_ajax_finishSurveyByOperator', 'finishSurveyByOperator');
add_action('wp_ajax_nopriv_finishSurveyByOperator', 'finishSurveyByOperator');

function finishSurveyByOperator() {
    $survey_id = !empty($_POST['survey_id'])? (int)sanitize_text_field($_POST['survey_id']) : '';
    if (!$survey_id) exit();

    $survey = get_post($survey_id);
    if (!$survey) exit();

    update_post_meta($survey_id, 'survey_finish_date', date('Ymd'));

    $response = [
        'message' => __('The survey is finished', 'ndp'),
        'date' => date('d.m.Y')
    ];
    wp_send_json($response);
}

/**
 * Результаты опросов в csv
 */
add_action('wp_ajax_getSurveyResults', 'getSurveyResults');
add_action('wp_ajax_nopriv_getSurveyResults', 'getSurveyResults');

function getSurveyResults()
{
    $survey_id = !empty($_POST['survey_id'])? (int)sanitize_text_field($_POST['survey_id']) : '';
    if (!$survey_id) exit();

    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $today = date('Ymd');

    $survey    = llms_get_post( $survey_id );
    $enrolledUsers = $survey->get_enrolled_students(1000, 0);
    $table     = new LLMS_Table_Student_Course();
    $results = [];
    foreach ($enrolledUsers as $n => $user) {
        $student = llms_get_student($user);
        $table->get_results(
            array(
                'course_id' => $survey_id,
                'student'   => $student,
            )
        );
        $csvRow = [];
        $data = $table->get_tbody_data();
        if ($n==0) {
            $csvRow[] = 'user_id';
            foreach ( $table->get_columns() as $id => $title ) {
                if ($id == 'quiz') {
                    continue;
                } elseif ($id == 'actions') {
                    $csvRow[] = __('Progress', 'ndp');
                    continue;
                }
                $title = $title['title'];
                if ($title == 'ID') {
                    $title = 'lesson_id';
                }
                $csvRow[] = $title;
            }
            $results[$user][] = $csvRow;
        }

        foreach ( $data as $row ) {
            $csvRow = [];
            $csvRow[] = $user;
            foreach ( $table->get_columns() as $id => $title ) {
                if ($id == 'id') {
                    $csvRow[] = $row->get('id');
                    continue;
                } elseif ($id == 'quiz') {
                    continue;
                } elseif ($id == 'actions') {
                    $progress = $student->get_progress($survey_id);
                    $csvRow[] = $progress;
                    continue;
                }
                $rowData = $table->get_data( $id, $row );
                if ($rowData == '&ndash;') {
                    $rowData = '';
                }
                $csvRow[] = $rowData;
            }
            $results[$user][] = $csvRow;
        }
    }

    $filename    = 'survey_data_'.$survey_id.'_'.date('H_i_d_m_Y').'.csv';

    return outputCsv($results, $filename);
}
function outputCsv( $assocDataArray, $filename ) {
    if ( !empty( $assocDataArray ) ):

        $fp = fopen( 'php://output', 'w' );
        foreach ( $assocDataArray as $user => $rows ) {
            foreach ($rows as $row) {
                fputcsv( $fp, $row, ',' );
            }
        }

        fclose( $fp );
    endif;
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$filename.'";');

    exit();
}


add_action('wp_ajax_updateUserEmail', 'updateUserEmail');
add_action('wp_ajax_nopriv_updateUserEmail', 'updateUserEmail');
add_action('wp_ajax_rejectAllMunicipalityRequests', 'rejectAllMunicipalityRequests');

function rejectAllMunicipalityRequests(){
    $user_id =get_current_user_id();
    global $wpdb;
    $table_name = $wpdb->prefix . 'municipality_requests';
    $wpdb->delete($table_name,['user_id'=>$user_id]);
    return true;
}
function updateUserEmail() {
    // Перевіряємо nonce
    check_ajax_referer('update-email-nonce', 'nonce');

    $email = sanitize_email($_POST['email']);
    if (!is_email($email)) {
        wp_send_json_error([
            'message' => __('The email format is incorrect.','ndp'),
            'status' => 'canceled',
        ]);
    }

    $user_id = get_current_user_id();
    if (!$user_id) {
        wp_send_json_error(['message' => __('User not found.','ndp')]);
    }

    $current_user_email = wp_get_current_user()->user_email;
    if ($email === $current_user_email) {
        wp_send_json_error([
            'message' => __('The email address has not been changed. It already belongs to the current user.','ndp'),
            'status' => 'canceled',
        ]);
        return;
    }

    if (email_exists($email)) {
        wp_send_json_error([
            'message' => __('A user with this email address already exists.','ndp'),
            'status' => 'canceled',
        ]);
        return;
    }

    $result = wp_update_user(array('ID' => $user_id, 'user_email' => $email));
    if (is_wp_error($result)) {
        wp_send_json_error(['message' => $result->get_error_message()]);
    } else {
        wp_send_json_success(['message' => __('Email address has been successfully updated.','ndp')]);
    }
}

/**
 * Сохранение дыты старта опроса
 */
add_action('wp_ajax_saveCourseStartDate', 'saveCourseStartDate');
add_action('wp_ajax_nopriv_saveCourseStartDate', 'saveCourseStartDate');
function saveCourseStartDate()
{
    $id = !empty($_POST['id'])? (int)sanitize_text_field($_POST['id']) : '';
    $currentUser = wp_get_current_user();
    $user_id = $currentUser? $currentUser->ID : null;
    if (!$id || !$user_id) exit();

    $courses_start_date = get_user_meta($user_id, 'courses_start_date', true);
    if (empty($courses_start_date)) {
        $courses_start_date = [];
    }
    $courses_start_date[$id] = date('d.m.Y');
    update_user_meta( $user_id, 'courses_start_date', $courses_start_date );
    $response = [
        'message' => 'ok',
    ];

    wp_send_json($response);
}


function clear_user_municipality_meta($user_id) {
    // Установить значение edrpou_code пользователя в пустое
    update_user_meta($user_id, 'edrpou_code', '');
    // Установить значение user_profile_type пользователя в пустое
    update_user_meta($user_id, 'user_profile_type', '');

    // Можно добавить дополнительные действия здесь, если нужно
}

//смена почты
function wp_email_change_email_hook( $email_change_email, $user, $userdata ) {
    $subject = str_replace($email_change_email['subject'], __( '[%s] Email Changed', 'ndp' ), $email_change_email['subject']);
    $email_change_email['subject'] = $subject;

    $email_change_text = $email_change_email['message'];
    $email_change_text = str_replace('Hi ###USERNAME###,', __( 'Hi ###USERNAME###,', 'ndp' ), $email_change_text);
    $email_change_text = str_replace('This notice confirms that your email address on ###SITENAME### was changed to ###NEW_EMAIL###.', __( 'This notice confirms that your email address on ###SITENAME### was changed to ###NEW_EMAIL###.', 'ndp' ), $email_change_text);
    $email_change_text = str_replace('If you did not change your email, please contact UANDP administration',  __( 'If you did not change your email, please contact UANDP administration', 'ndp' ), $email_change_text);
    $email_change_text = preg_replace('/If you did not change your email, please contact the Site Administrator at\s?(\r\n|\r|\n)###ADMIN_EMAIL###/',  __( 'If you did not change your email, please contact UANDP administration', 'ndp' ), $email_change_text);
    $email_change_text = str_replace('This email has been sent to ###EMAIL###',  __( 'This email has been sent to ###EMAIL###', 'ndp' ), $email_change_text);
    $email_change_text = preg_replace('/Regards,\s?(\r\n|\r|\n)All at UANDP\s?(\r\n|\r|\n)###SITEURL###/is',  __( 'Regards,
All at UANDP
###SITEURL###', 'ndp' ), $email_change_text);
    $email_change_text = preg_replace('/Regards,\s?(\r\n|\r|\n)All at ###SITENAME###\s?(\r\n|\r|\n)###SITEURL###/is',  __( 'Regards,
All at UANDP
###SITEURL###', 'ndp' ), $email_change_text);

    $email_change_email['message'] = $email_change_text;

    return $email_change_email;
}
add_filter( 'email_change_email', 'wp_email_change_email_hook', 10, 3 );

/**
 * Сохранение email для дублирования сообщений от муниципалитета из админки на почту
 */
add_action('wp_ajax_duplicateMunicipalityEmail', 'duplicateMunicipalityEmail');
add_action('wp_ajax_nopriv_duplicateMunicipalityEmail', 'duplicateMunicipalityEmail');
function duplicateMunicipalityEmail() {
    $email = !empty($_POST['email'])? sanitize_text_field($_POST['email']) : '';
    $duplicateEmailChecked = !empty($_POST['duplicateEmailChecked'])? filter_var(sanitize_text_field($_POST['duplicateEmailChecked']), FILTER_VALIDATE_BOOLEAN) : false;

    $response = [];
    if ($email && $duplicateEmailChecked && update_option( 'duplicate_messages_by_email', $email, 'no' )) {
        $response = [
            'message' => 'ok',
        ];
    } elseif (!$duplicateEmailChecked && delete_option('duplicate_messages_by_email')) {
        $response = [
            'message' => 'ok',
        ];
    }
    wp_send_json($response);
}