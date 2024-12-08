<?php
/**
 * Lifterlms code
 */

/**
 * Проверка срока действия сертификата
 */
function getCertificateCreateDateTimestamp(LLMS_User_Certificate $certificate) {
    return strtotime($certificate->get('date'));
}
function getCertificateCreateDate(LLMS_User_Certificate $certificate) {
    $date = getCertificateCreateDateTimestamp($certificate);
    return date('d.m.Y', $date);
}
//expired timestamp
function getCertificateExpired(LLMS_User_Certificate $certificate) {
    $expire = get_field('lms_certificate_expiration', $certificate->get('parent'));
    $date = 0;
    if (preg_match('/^[0-9]+$/', (int)trim($expire))) {
        $createDate = getCertificateCreateDateTimestamp($certificate);
        $date = $createDate + ((int)$expire * 86400);
    }
    return $date;
}
//expired date('d.m.Y')
function getCertificateExpiredDate(LLMS_User_Certificate $certificate) {
    $expire = getCertificateExpired($certificate);
    return date('d.m.Y', $expire);
}

/**
 * Проверяет истёк ли срок
 * @param LLMS_User_Certificate $certificate
 * @return bool
 */
function checkCertificateIsExpired(LLMS_User_Certificate $certificate) {
    $today = strtotime("today midnight");
    $expireDate = getCertificateExpired($certificate);
    if($today >= $expireDate){
        return true;
    }
    return false;
}

function getCertificateExpiredDays(LLMS_User_Certificate $certificate) {
    $today = strtotime("today midnight");
    $expireDate = getCertificateExpired($certificate);
    return (int)(abs($expireDate - $today)/60/60/24);
}

function getCertificateValidData(LLMS_User_Certificate $certificate) {
    return getCertificateExpiredDays($certificate);
}


function compareValueAndReplace($args) {
    if (!$args) return '';

    $map_legacy = array(
        'video' => 'play',
        'audio' => 'headphones',
        'text' => 'document-text',
        'article' => 'document-text',
        'quiz' => 'light-bulb',
    );

    foreach ( $map_legacy as $from => $to ) {
        if (is_array($args) && isset( $args[ $from ] ) ) {
            $args[ $to ] = $args[ $from ];
        } elseif (is_string($args) && $from == $args) {
            $args = $to;
        }
    }
    return $args;
}

function calculate_time_to_seconds($time) { //explode time and convert into seconds
    if (!$time) return 0;

    $time = explode(':', $time);
    $time = $time[0] * 3600 + $time[1] * 60;
    return $time;
}
function second_to_hhmm($time) { //convert seconds to hh:mm
    $hour = floor($time / 3600);
    $minute = strval(floor(($time % 3600) / 60));
    if ($minute == 0) {
        $minute = "00";
    } else {
        $minute = $minute;
    }
    $time = $hour . ":" . $minute;
    return $time;
}

function calculateTimeOfLessons($lessons, $type = '') {
    $totalTime = 0;
    if ($lessons) {
        foreach ( $lessons as $k => $lesson ) {
            //type - 'video', 'audio', 'slides', 'article', 'quiz'
            if ($type) {
                $lessonType = get_field('lesson_type', $lesson->get( 'id' )) ?? '';
                if ($type != $lessonType) continue;
            }
            $lesson_total_time = get_field('lesson_total_time', $lesson->get( 'id' ), false);
            $totalTime += calculate_time_to_seconds($lesson_total_time);
            $lessons[$k]->lessonTime = $lesson_total_time;
        }
    }

    return $totalTime;
}

function calculateTimeOfCourse($course) {
    $sections = $course->get_sections();
    $totalTime = 0;
    foreach ( $sections as $key => $section ) {
        $lessons = $section->get_lessons();
        if ($lessons) {
            $totalTime += calculateTimeOfLessons($lessons);
        }
    }

    return $totalTime;
}

function prepareCourseTime(int $totalTime):string {
    if (!$totalTime) return 0;

    $totalLength = second_to_hhmm($totalTime) ?? '';
    $totalLengthArray = explode(':', $totalLength);
    if (!empty($totalLengthArray) && count($totalLengthArray) >= 2) {
        $totalLength = $totalLengthArray[0].__('hr', 'ndp') . ' ' . $totalLengthArray[1].__('min', 'ndp');
    }

    return $totalLength;
}


if ( ! function_exists( 'lifterlms_template_student_dashboard_wrapper_open' ) ) :
    /**
     * Output the student dashboard wrapper opening tags
     *
     * @since 3.0.0
     * @since 3.10.0 Unknown.
     *
     * @return void
     */
    function lifterlms_template_student_dashboard_wrapper_open() {
        $current = LLMS_Student_Dashboard::get_current_tab( 'slug' );
        if ($current == 'view-certificates' && (isset($_GET['upload']) || isset($_GET['edit']) || isset($_GET['view'])) ) return;
        if ($current == 'requests' && isset($_GET['id'])) return;
        if ($current == 'edit-account' && isset($_GET['password-change'])) return;

        echo '<section class="account ' . $current . '" data-current="' . $current . '"><div class="container"><div class="account__block">';
    }
endif;

if ( ! function_exists( 'lifterlms_template_student_dashboard_wrapper_close' ) ) :
    /**
     * Output the student dashboard wrapper closing tags
     *
     * @since 3.0.0
     *
     * @return void
     */
    function lifterlms_template_student_dashboard_wrapper_close() {
        $current = LLMS_Student_Dashboard::get_current_tab( 'slug' );
        if ($current == 'view-certificates' && (isset($_GET['upload']) || isset($_GET['edit']) || isset($_GET['view'])) ) return;
        if ($current == 'requests' && isset($_GET['id'])) return;
        if ($current == 'edit-account' && isset($_GET['password-change'])) return;

        echo '</section></div></div><!-- .llms-student-dashboard -->';
    }
endif;


if ( ! function_exists( 'lifterlms_student_dashboard' ) ) {

    /**
     * Output the LifterLMS Student Dashboard
     *
     * @since 3.25.1
     * @since 3.35.0 unslash `$_GET` data.
     * @since 3.37.10 Add filter `llms_enable_open_registration`.
     * @since 5.0.0 During password reset, retrieve reset key and login from cookie instead of query string.
     *              Use `llms_get_open_registration_status()`.
     *
     * @param array $options Optional. Array of options. Default empty array.
     * @return void
     */
    function lifterlms_student_dashboard( $options = array() ) {

        $options = wp_parse_args(
            $options,
            array(
                'login_redirect' => get_permalink( llms_get_page_id( 'myaccount' ) ),
            )
        );

        /**
         * Filters whether or not to display the student dashboard
         *
         * By default, this condition will show the dashboard to a logged in user
         * and the login/registration forms (as well as the password recovery flow)
         * to logged out users.
         *
         * The `LLMS_View_Manager` class uses this filter to modify the dashboard view
         * conditionally based on the requested view role.
         *
         * @since 4.16.0
         *
         * @param bool $is_user_logged-in Whether or not the user is logged in.
         */
        $display_dashboard = apply_filters( 'llms_display_student_dashboard', is_user_logged_in() );

        /**
         * Fires before the student dashboard output.
         *
         * @since Unknown
         *
         * @hooked lifterlms_template_student_dashboard_wrapper_open - 10
         */
        if ($display_dashboard) {
            do_action( 'lifterlms_before_student_dashboard' );
        }


        // Not displaying the dashboard (the user is not logged in), we'll show login/registration forms.
        if ( ! $display_dashboard ) {

            /**
             * Allow adding a notice message to be displayed in the student dashboard where `llms_print_notices()` will be invoked.
             *
             * @since unknown
             *
             * @param string $message The notice message to be displayed in the student dashboard. Default empty string.
             */
            $message = apply_filters( 'lifterlms_my_account_message', '' );
            if ( ! empty( $message ) ) {
                llms_add_notice( $message );
            }

            global $wp;
            if ( isset( $wp->query_vars['lost-password'] ) ) {

                $args = array();
                if ( llms_filter_input( INPUT_GET, 'reset-pass', FILTER_SANITIZE_NUMBER_INT ) ) {
                    $args['form'] = 'reset_password';
                    $cookie       = llms_parse_password_reset_cookie();
                    $key          = '';
                    $login        = '';
                    $fields       = array();
                    if ( is_wp_error( $cookie ) ) {
                        llms_add_notice( $cookie->get_error_message(), 'error' );
                    } else {
                        $fields = LLMS_Person_Handler::get_password_reset_fields( $cookie['key'], $cookie['login'] );
                    }
                    $args['fields'] = $fields;
                } else {
                    $args['form']   = 'lost_password';
                    $args['fields'] = LLMS_Person_Handler::get_lost_password_fields();
                }

                llms_get_template( 'myaccount/form-lost-password.php', $args );

            } else {

                llms_print_notices();

                llms_get_login_form(
                    null,
                    /**
                     * Filter login form redirect URL
                     *
                     * @since unknown
                     *
                     * @param string $login_redirect The login redirect URL.
                     */
                    apply_filters( 'llms_student_dashboard_login_redirect', $options['login_redirect'] )
                );

                if ( llms_parse_bool( llms_get_open_registration_status() ) ) {

//                    llms_get_template( 'global/form-registration.php' );

                }
            }
        } else {

            $tabs = LLMS_Student_Dashboard::get_tabs();

            $current_tab = LLMS_Student_Dashboard::get_current_tab( 'slug' );

            /**
             * Fires before the student dashboard content output.
             *
             * @since unknown
             *
             * @hooked lifterlms_template_student_dashboard_header - 10
             */
//            do_action( 'lifterlms_before_student_dashboard_content' );

            if ( isset( $tabs[ $current_tab ] ) && isset( $tabs[ $current_tab ]['content'] ) && is_callable( $tabs[ $current_tab ]['content'] ) ) {

                call_user_func( $tabs[ $current_tab ]['content'] );

            }
        }

        /**
         * Fires after the student dashboard output.
         *
         * @since unknown
         *
         * @hooked lifterlms_template_student_dashboard_wrapper_close - 10
         */
        do_action( 'lifterlms_after_student_dashboard' );

    }
}


/**
 * Output a LifterLMS Loop
 *
 * @param    obj $query  WP_Query, uses global $wp_query if not supplied
 * @param    string $template  template
 * @return   void
 * @since    3.14.0
 * @version  3.14.0
 */
function lifterlms_loop_custom( $query = null, string $template='loop/dashboard', $survey = false ) {

    global $wp_query;
    $temp = null;

    if ( $query ) {
        $temp     = $wp_query;
        $wp_query = $query;
    }

    if ( have_posts() ) {

        /**
         * lifterlms_before_loop hook
         *
         * @hooked lifterlms_loop_start - 10
         */
        if (!$survey) {
            do_action( 'lifterlms_before_loop' );
        }

        while ( have_posts() ) {
            the_post();
            llms_get_template_part( $template, get_post_type() );
        }

        /**
         * lifterlms_before_loop hook
         *
         * @hooked lifterlms_loop_end - 10
         */
        if (!$survey) {
            do_action( 'lifterlms_after_loop' );
        }

        llms_get_template_part( 'loop/pagination' );

    } else {

        llms_get_template( 'loop/dashboard-none-found.php', ['survey' => $survey] );
    }

    if ( $query ) {
        $wp_query = $temp;
        wp_reset_postdata();
    }

}

//WP_Query по курсам и опросам в dashboard
if ( ! function_exists( 'lifterlms_template_my_courses_loop' ) ) {

    /**
     * Get course tiles for a student's courses
     *
     * @since 3.14.0
     * @since 3.26.3 Unknown.
     * @since 3.37.15 Added secondary sorting by `post_title` when the primary sort is `menu_order`.
     * @since 6.3.0 Fix paged query not working when using plain permalinks.
     * @since 7.1.3 Added filter for filtering 'Not enrolled text'.
     *
     * @param LLMS_Student $student Optional. LLMS_Student (current student if none supplied). Default `null`.
     * @param bool         $preview Optional. If true, outputs a short list of courses (based on dashboard_recent_courses filter). Default `false`.
     * @return void
     */
    function lifterlms_template_my_courses_loop( $student = null, $preview = false, $survey=false ) {

        $student = llms_get_student( $student );
        if ( ! $student ) {
            return;
        }
        $limit = 500;

        if ($survey && $student) {
            $user = $student->get('user');
            $user_id = $user->ID;
            $user_roles = $user->roles;
            $user_role = $user_roles[0];
            $municipality = get_user_meta( $user_id, 'user_profile_type', true );
            if (!empty($municipality)) {
                $user_role = 'municipality';
            }
            $coursesQuery = getSurveyQuery($user_role);
            $post_ids = wp_list_pluck( $coursesQuery->posts, 'ID' );
            $courses = [
                'found' => count($post_ids),
                'limit' => $limit,
                'more'  => ( count($post_ids) > $limit ),
                'skip'  => 0,
                'results' => $post_ids,
            ];
        } else {
            $courses = $student->get_courses(
            /**
             * Filter the query args to retrieve the courses ids to be used for the "my_courses" loop.
             *
             * @since unknown
             *
             * @param array $args The query args.
             */
                apply_filters(
                    'llms_my_courses_loop_courses_query_args',
                    array(
                        'limit' => $limit,
                    ),
                    $student
                )
            );
        }

        if ( ! $courses['results'] ) {
            if ($survey) {
                echo '<p>'.__('You are not enrolled in any surveys.', 'ndp').'</p>';
            } else {
                printf(
                    '<p>%s</p>',
                    /**
                     * Not enrolled text.
                     *
                     * Allows developers to filter the text to be displayed when the student is not enrolled in any courses.
                     *
                     * @since 7.1.3
                     *
                     * @param string $not_enrolled_text The text to be displayed when the student is not enrolled in any course.
                     */
                    apply_filters( 'lifterlms_dashboard_courses_not_enrolled_text', esc_html__( 'You are not enrolled in any courses.', 'lifterlms' ) )
                );
            }
        } else {

            add_action( 'lifterlms_after_loop_item_title', 'lifterlms_template_loop_enroll_status', 25 );
            add_action( 'lifterlms_after_loop_item_title', 'lifterlms_template_loop_enroll_date', 30 );

            // get sorting option.
            $option = get_option( 'lifterlms_myaccount_courses_in_progress_sorting', 'date,DESC' );
            // parse to order & orderby.
            $option  = explode( ',', $option );
            $orderby = ! empty( $option[0] ) ? $option[0] : 'date';
            $order   = ! empty( $option[1] ) ? $option[1] : 'DESC';

            // Enrollment date will obey the results order.
            if ( 'date' === $orderby ) {
                $orderby = 'post__in';
            } elseif ( 'order' === $orderby ) {
                // Add secondary sorting by `post_title` when the primary sort is `menu_order`.
                $orderby = 'menu_order post_title';
            }

            /**
             * Filter the number of courses per page to be displayed in the dashboard.
             *
             * @since unknown
             *
             * @param int $per_page The number or courses per page to be displayed. Defaults to the 'Courses per page' course catalog's setting.
             */
            $per_page = apply_filters( 'llms_dashboard_courses_per_page', get_option( 'lifterlms_shop_courses_per_page', 9 ) );
            if ( $preview ) {
                /**
                 * Filter the number of courses per page to be displayed in the dashboard, when outputting a short list of courses.
                 *
                 * @since unknown
                 *
                 * @param int $per_page The number or courses per page to be displayed. Default is `3`.
                 */
                $per_page = apply_filters( 'llms_dashboard_recent_courses_count', llms_get_loop_columns() );
            }

            $endpointSlug  = LLMS_Student_Dashboard::get_current_tab( 'slug' );
            $isSurvey = $endpointSlug == 'surveys'? true : false;

            /**
             * Filter the wp query args to retrieve the courses for the "my_courses" loop.
             *
             * @since unknown
             *
             * @param array $args The query args.
             */
            $query_args = apply_filters(
                'llms_dashboard_courses_wp_query_args',
                array(
                    'paged'          => llms_get_paged_query_var(),
                    'orderby'        => $orderby,
                    'order'          => $order,
                    'post__in'       => $courses['results'],
                    'post_status'    => 'publish',
                    'post_type'      => 'course',
                    'posts_per_page' => $per_page,
                    'meta_query' => [
                        [
                            'key' => 'type',
                            'value' => 1,
                            'compare' => $isSurvey? '=' : '!='//is survey
                        ]
                    ]
                )
            );

            $query = new WP_Query( $query_args );

            // Prevent pagination on the preview.
            if ( $preview ) {
                $query->max_num_pages = 1;
            }

            add_filter( 'paginate_links', 'llms_modify_dashboard_pagination_links' );

            $template = 'loop/dashboard';
            if ($endpointSlug == 'dashboard' || $endpointSlug == 'view-courses' || $endpointSlug == 'surveys') {
                $template = 'loop/'.$endpointSlug;
            }

            lifterlms_loop_custom($query, $template, $isSurvey);

            remove_filter( 'paginate_links', 'llms_modify_dashboard_pagination_links' );

            remove_action( 'lifterlms_after_loop_item_title', 'lifterlms_template_loop_enroll_status', 25 );
            remove_action( 'lifterlms_after_loop_item_title', 'lifterlms_template_loop_enroll_date', 30 );

        }

    }
}


if ( ! function_exists( 'lifterlms_template_student_dashboard_my_courses' ) ) {

    /**
     * Template for My Courses section on dashboard index
     *
     * @since 3.14.0
     * @since 3.19.0 Unknown.
     *
     * @param bool $preview Optional. If true, outputs a short list of courses (based on dashboard_recent_courses filter). Default `false`.
     * @return void
     */
    function lifterlms_template_student_dashboard_my_courses( $preview = false ) {

        $student = llms_get_student();
        if ( ! $student ) {
            return;
        }

        $more = false;
        if ( $preview && LLMS_Student_Dashboard::is_endpoint_enabled( 'view-courses' ) ) {
            $more = array(
                'url'  => llms_get_endpoint_url( 'view-courses', '', llms_get_page_url( 'myaccount' ) ),
                'text' => __( 'View All My Courses', 'lifterlms' ),
            );
        }

        ob_start();
        lifterlms_template_my_courses_loop( $student, $preview );

        llms_get_template(
            'myaccount/my-courses.php',
            array(
                'action'  => 'my_courses',
                'slug'    => 'llms-my-courses',
                'title'   => $preview ? __( 'My Courses', 'lifterlms' ) : '',
                'content' => ob_get_clean(),
                'more'    => $more,
            )
        );

    }
}


if (!function_exists( 'lifterlms_template_student_dashboard_my_notifications' ) ) {

    /**
     * Template for My Notifications student dashboard endpoint
     *
     * @since 3.26.3
     * @since 3.35.0 Sanitize `$_GET` data.
     * @since 3.37.15 Use `in_array()`'s strict comparison.
     * @since 3.37.16 Fixed typo when comparing the current view.
     * @since 5.9.0 Stop using deprecated `FILTER_SANITIZE_STRING`.
     *              Fix how the protected {@see LLMS_Notifications_Query::$max_pages} property is accessed.
     * @since 6.3.0 Fix paged query not working when using plain permalinks.
     *
     * @return void
     */
    function lifterlms_template_student_dashboard_my_notifications() {

        $url = llms_get_endpoint_url( 'notifications', '', llms_get_page_url( 'myaccount' ) );

        $sections = array(
            array(
                'url'  => $url,
                'name' => __( 'View Notifications', 'lifterlms' ),
            ),
            array(
                'url'  => add_query_arg( 'sdview', 'prefs', $url ),
                'name' => __( 'Manage Preferences', 'lifterlms' ),
            ),
        );

        $view = isset( $_GET['sdview'] ) ? llms_filter_input( INPUT_GET, 'sdview' ) : 'view';

        if ( 'view' === $view ) {

            $page = llms_get_paged_query_var();

            $notifications = new LLMS_Notifications_Query(
                array(
                    'page'       => $page,
                    /**
                     * Filter the number of notifications per page to be displayed in the dashboard's "my_notifications" tab.
                     *
                     * @since unknown
                     *
                     * @param int $per_page The number of notifications per page to be displayed. Default `25`.
                     */
                    'per_page'   => apply_filters( 'llms_sd_my_notifications_per_page', 25 ),
                    'subscriber' => get_current_user_id(),
                    'sort'       => array(
                        'created' => 'DESC',
                        'id'      => 'DESC',
                    ),
                    'types'      => 'basic',
                )
            );
            wp_cache_set('dashboardNotifications', $notifications);

            $pagination = array(
                'max'     => $notifications->get_max_pages(),
                'current' => $page,
            );

            $args = array(
                'notifications' => $notifications->get_notifications(),
                'pagination'    => $pagination,
                'sections'      => $sections,
            );

        } else {

            /**
             * Filter the types of subscriber notification which can be managed
             *
             * @since unknown
             *
             * @param array $types The array of manageable types. Default is `array( 'email' )`.
             */
            $types = apply_filters( 'llms_notification_subscriber_manageable_types', array( 'email' ) );

            $settings = array();
            $student  = new LLMS_Student( get_current_user_id() );

            foreach ( llms()->notifications()->get_controllers() as $controller ) {

                foreach ( $types as $type ) {

                    $configs = $controller->get_subscribers_settings( $type );

                    if ( in_array( 'student', array_keys( $configs ), true ) && 'yes' === $configs['student'] ) {

                        if ( ! isset( $settings[ $type ] ) ) {
                            $settings[ $type ] = array();
                        }

                        $settings[ $type ][ $controller->id ] = array(
                            'name'  => $controller->get_title(),
                            'value' => $student->get_notification_subscription( $type, $controller->id, 'yes' ),
                        );
                    }
                }
            }

            $args = array(
                'sections' => $sections,
                'settings' => $settings,
            );

        }

        add_filter( 'paginate_links', 'llms_modify_dashboard_pagination_links' );

        llms_get_template( 'myaccount/my-notifications.php', $args );

        remove_filter( 'paginate_links', 'llms_modify_dashboard_pagination_links' );

    }
}


if ( ! function_exists( 'lifterlms_template_student_dashboard_my_certificates' ) ) {

    /**
     * Template for My Certificates on dashboard
     *
     * @since 3.14.0
     * @since 3.19.0 Unknown
     * @since 6.0.0 Output short list when `$preview` is `true`.
     *               Don't output any HTML when the endpoint is disabled.
     *
     * @param bool $preview If `true`, outputs a short list of certificates to display on the dashboard
     *                      landing page. Otherwise displays all of the earned certificates for display
     *                      on the view-certificates endpoint.
     * @return void
     */
    function lifterlms_template_student_dashboard_my_certificates( $preview = false ) {

        $student = llms_get_student();
        if ( ! $student ) {
            return;
        }

        $enabled = LLMS_Student_Dashboard::is_endpoint_enabled( 'view-certificates' );
        if ( ! $enabled ) {
            return;
        }

        $more = false;
        if ( $preview ) {
            $more = array(
                'url'  => llms_get_endpoint_url( 'view-certificates', '', llms_get_page_url( 'myaccount' ) ),
                'text' => __( 'View All My Certificates', 'lifterlms' ),
            );
        }

        ob_start();
        lifterlms_template_certificates_loop( $student, $preview ? llms_get_certificates_loop_columns() : false );

        llms_get_template(
            'myaccount/view-certificates.php',
            array(
                'action'  => 'my_certificates',
                'slug'    => 'llms-my-certificates',
                'title'   => $preview ? __( 'My Certificates', 'lifterlms' ) : '',
                'content' => ob_get_clean(),
                'more'    => $more,
            )
        );

    }
}

if ( ! function_exists( 'lifterlms_template_certificates_loop' ) ) {
    function lifterlms_template_certificates_loop( $student = null, $limit = false ) {

        // Get the current student if none supplied.
        if ( ! $student ) {
            $student = llms_get_student();
        }

        // Don't proceed without a student.
        if ( ! $student ) {
            return;
        }

        $cols     = llms_get_certificates_loop_columns();
        $per_page = $cols * 5;

        // Get certificates.
        $query        = $student->get_certificates(
            array(
                'page'     => max( 1, get_query_var( 'paged' ) ),
                'per_page' => $limit ? min( $limit, $per_page ) : $per_page,
            )
        );
        $certificates = $query->get_awards();

        /**
         * If no columns are specified and we have a specified limit
         * and results and the limit is less than the number of columns
         * force the columns to equal the limit.
         */
        if ( $limit && $limit < $cols && $query->get_number_results() ) {
            $cols = $limit;
        }

        $pagination = 'dashboard' === LLMS_Student_Dashboard::get_current_tab( 'slug' ) ? false : array(
            'total'   => $query->get_max_pages(),
            'context' => 'student_dashboard',
        );

        $endpointSlug  = LLMS_Student_Dashboard::get_current_tab( 'slug' );
        $template = 'dashboard';
        if ($endpointSlug == 'view-certificates') {
            $template = 'loop';
        }
        llms_get_template(
            'certificates/'.$template.'.php',
            compact( 'cols', 'certificates', 'pagination' )
        );

    }
}


/**
 * Output a course continue button linking to the incomplete lesson for a given student.
 *
 * If the course is complete "Course Complete" is displayed.
 *
 * @since 3.11.1
 * @since 3.15.0 Unknown.
 * @since 7.1.0 Remove check on student existence, now included in the enrollment check.
 *
 * @param int          $post_id  WP Post ID for a course, lesson, or quiz.
 * @param LLMS_Student $student  Instance of an LLMS_Student, defaults to current student.
 * @param int          $progress Current progress of the student through the course.
 * @return void
 */
if ( ! function_exists( 'lifterlms_course_continue_button' ) ) {

    function lifterlms_course_continue_button( $post_id = null, $student = null, $progress = null ) {

        if ( ! $post_id ) {
            $post_id = get_the_ID();
            if ( ! $post_id ) {
                return '';
            }
        }

        $course = llms_get_post( $post_id );
        if ( ! $course || ! is_a( $course, 'LLMS_Post_Model' ) ) {
            return '';
        }
        if ( in_array( $course->get( 'type' ), array( 'lesson', 'quiz' ) ) ) {
            $course = llms_get_post_parent_course( $course->get( 'id' ) );
            if ( ! $course ) {
                return '';
            }
        }

        if ( ! $student ) {
            $student = llms_get_student();
        }
        if ( ! $student || ! llms_is_user_enrolled( $student->get_id(), $course->get( 'id' ) ) ) {
            return '';
        }

        if ( is_null( $progress ) ) {
            $progress = $student->get_progress( $course->get( 'id' ), 'course' );
        }

        $isSurvey = get_field('type');

        if ( 100 == $progress ) { ?>

            <div class="my-courses__item-status">
                <span class="my-courses__item-value">
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                  <path d="M15 5.25L7.41819 12.75L3 9" stroke="#151B2C" stroke-width="2" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <?php _e('Finished', 'ndp'); ?></span>
                <?php
                $certificate = getUserCertificate($student->get('id'), $course->get('id'));
                if ($certificate && is_a($certificate, 'LLMS_User_Certificate')) {
                    $expireDate = getCertificateExpiredDate($certificate);
                    $expired = checkCertificateIsExpired($certificate);
                    $expireDays = getCertificateExpiredDays($certificate);

                    echo '<div class="certificates-wrapper">';
                    if (!$expired) { ?>
                        <?php $until = sprintf(__("Until %s", 'ndp' ), $expireDate); ?>
                        <span class="certificates-item__tag"><?php _e('Certificate Valid','ndp') ?> (<?php echo sprintf( _n( '%s day', '%s days', $expireDays, 'ndp' ), $expireDays ) ?>)</span>
                        <span class="certificates-item__date"><?php echo $until; ?></span>
                    <?php } else { ?>
                        <?php $expireDate = sprintf(__("Expired %s", 'ndp' ), $expireDate); ?>
                        <span class="certificates-item__tag certificates-item__tag-expires"><?php _e('Certificate Invalid','ndp') ?></span>
                        <span><?php echo $expireDate; ?></span>
                    <?php }
                    echo '</div>';
                }
                ?>
                <?php $lessons = $course->get_lessons() ?? []; ?>
                <?php if (isset($expired) && !$expired): ?>

                <?php else: ?>
                    <?php if($lessons[0] !== null): ?>
                        <form method="post" action="<?php echo get_permalink($lessons[0]->get('post')); ?>" class="form-retake-course">
                            <button type="submit" class="btn btn_bg_primary course__card-button"><?php _e('Retake the Сourse', 'ndp'); ?></button>
                            <input type="hidden" name="retake_user_id" value="<?php echo $student->get('id'); ?>">
                            <input type="hidden" name="retake_course_id" value="<?php echo $course->get('id'); ?>">
                            <?php wp_nonce_field( 'llms_reset_course', '_llms_reset_course_nonce' ); ?>
                        </form>
                    <?php endif; ?>
                <?php endif; ?>
            </div>

        <?php } else {

            $lesson = apply_filters( 'llms_course_continue_button_next_lesson', $student->get_next_lesson( $course->get( 'id' ) ), $course, $student );
            if ( $lesson ) { ?>
                <?php
                $classStartCourse = '';
                if ( 0 == $progress ) {
                    $classStartCourse = 'first-start-course';
                }
                ?>
                <?php if (!$isSurvey): ?>
                    <div class="my-courses__item-status">
                  <span class="my-courses__item-value">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M6.375 6.48L10.3275 9L6.375 11.52V6.48ZM4.875 3.75V14.25L13.125 9L4.875 3.75Z" fill="#151B2C"/>
                    </svg>
                   <?php _e('In progress', 'ndp'); ?></span>
                        <div class="my-courses__item-progress-wrapper">
                            <div class="my-courses__item-progress">
                                <span class="my-courses__item-progress-current" style="width: <?php echo $progress.'%'; ?>"></span>
                            </div>
                            <span class="my-courses__item-percent"><?php echo $progress; ?>%</span>
                        </div>
                    </div>
                <?php endif; ?>
                <a class="llms-button-primary llms-course-continue-button btn btn_bg_primary <?php echo $classStartCourse; ?>" href="<?php echo get_permalink( $lesson ); ?>">

                    <?php if ( 0 == $progress ) : ?>

                        <?php _e( 'Get Started', 'lifterlms' ); ?>

                    <?php else : ?>

                        <?php _e( 'Go to the training page', 'ndp' ); ?>

                    <?php endif; ?>

                </a>

                <?php
            }
        }

    }
}

/**
 * @param $user_id
 * @param $course_id
 * @return false|LLMS_User_Certificate
 */
function getUserCertificate($user_id, $course_id) {
    $student = llms_get_student($user_id);
    $course = new LLMS_Course($course_id);
    if (!$student || !$course) {
        return false;
    }

    $certificates = $student->get_certificates();
    $key = array_search($course->get('id'), array_column($certificates, 'post_id'));
    if ($key !== false && !empty($cert = (array)$certificates[$key])) {
        if (!empty($cert['certificate_id']) && $certificate = new LLMS_User_Certificate($cert['certificate_id'])) {
            return $certificate;
        }
    }
}


//add_action('template_redirect', 'retakeCourseHandler');
function retakeCourseHandler() {
    if (!is_singular('lesson')) return;

    if (empty($_POST['retake_user_id']) || !llms_verify_nonce( '_llms_reset_course_nonce', 'llms_reset_course' ) ) {
        return;
    }

    $user_id = absint( llms_filter_input( INPUT_POST, 'retake_user_id', FILTER_SANITIZE_NUMBER_INT ) );
    $course_id = absint( llms_filter_input( INPUT_POST, 'retake_course_id', FILTER_SANITIZE_NUMBER_INT ) );
    $student = llms_get_student($user_id);
    $course = llms_get_post($course_id);
    if (!$student || !$course) return;

    //Копирование основного сертификата(шаблона, не award) и установка нового срока действия
    $certificates = $student->get_certificates() ?? [];
    foreach ($certificates as $certificate) {
        if ($certificate->post_id != $course_id) continue;

        $awardedCert = new LLMS_User_Certificate( $certificate->certificate_id );

        $copiedCertificate = (array) get_post( $awardedCert->get('parent') );
        $copyDate = strtotime($copiedCertificate['post_date']);
        if (!$copyDate) continue;

        unset( $copiedCertificate['ID'] );
        unset( $copiedCertificate['post_date'] );
        $new_id = wp_insert_post( $copiedCertificate );

        foreach ( get_post_custom( $awardedCert->get('parent') ) as $key => $values ) {
            if ($key == 'lms_certificate_expiration') {
                $today = strtotime("today midnight");
                $expireDate = getCertificateExpired($awardedCert);
                $date = (int)($expireDate - $copyDate);
                $newExpireDate = date('d.m.Y', ($today + $date));
                update_field('lms_certificate_expiration', $newExpireDate, $new_id);
            } else {
                foreach ( $values as $value ) {
                    add_post_meta( $new_id, $key, maybe_unserialize( $value ) );
                }
            }
        }
//        llms_delete_student_enrollment($user_id, $course_id);
//        wp_delete_post( $certificate->certificate_id, true );//awarded certificate
    }
}

//получение опросов отфильтрованных по дате и роли
function getSurveyQuery($user_role = '') {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
    $args = array(
        'post_type'      => 'course', // тип поста - курс
        'posts_per_page' => get_option( 'lifterlms_shop_courses_per_page', 10 ),       // получить все опросы
        'post_status'    => 'publish',
        'paged' => $paged,
    );

    // Фильтр по кастомному полю ACF survey
    $args['meta_query'] = array(
        'relation' => 'AND',
        [
            'key'   => 'type',   // имя кастомного поля
            'value' => 1,   // значение, которое мы ищем
            'compare' => '=',    // тип сравнения
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
    );
    if (!empty($user_role)) {
        $args['meta_query'][] = [
            'key' => 'survey_user_roles',
            'value' => $user_role,
            'compare' => 'LIKE',
        ];
    }

    $courseType = 'survey';
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

    // Создание нового WP_Query
    return new WP_Query( $args );
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


//    $args = array(
//        'taxonomy'     => 'course_track',
//        'orderby'      => 'name',
//        'hide_empty'   => false,
//        'show_count'   => false,
//    );
//    $track = get_terms($args);
//    $name = 'Level';
//    $filters[] = [
//        'name' => $name,
//        'taxonomy' => 'course_track',
//        'type' => 'taxonomy',
//        'values' => $track,
//    ];


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

/**
 * Список фильтров для Survey
 * @return array
 */
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


    $args = array(
        'taxonomy'     => 'course_difficulty',
        'orderby'      => 'name',
        'hide_empty'   => false,
        'show_count'   => false,
        'object_ids'   => $course_ids,
    );
    $difficulties = get_terms($args);
    $filters[] = [
        'name' => 'Difficulty',
        'taxonomy' => 'course_difficulty',
        'type' => 'taxonomy',
        'values' => $difficulties,
    ];


    $args = array(
        'taxonomy'     => 'course_track',
        'orderby'      => 'name',
        'hide_empty'   => false,
        'show_count'   => false,
        'object_ids'   => $course_ids,
    );
    $track = get_terms($args);
    $name = 'Level';
    $filters[] = [
        'name' => $name,
        'taxonomy' => 'course_track',
        'type' => 'taxonomy',
        'values' => $track,
    ];


    $authors = [];
    foreach ($courses as $course) {
        $id = $course->post_author;
        $author = get_userdata((int)$id);
        if ($id && $author && !in_array($author->user_nicename, $authors)) {
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
        $totalTimeWithVideo = calculateTimeOfLessons($lessons);
        if ($totalTimeWithVideo) {
            $date = (int)date('H', $totalTimeWithVideo);
            $date = $date? $date : 0;
        } else {
            return;
        }
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


## Добавляем блоки в основную колонку на страницах постов и пост. страниц
add_action('add_meta_boxes', 'survey_field_users_roles_add_custom_box');
function survey_field_users_roles_add_custom_box(){
    $screens = array( 'course' );
    add_meta_box( 'survey_field_sectionid', __('List of roles', 'ndp'), 'survey_field_meta_box_callback', $screens );
}

// HTML код блока
function survey_field_meta_box_callback( $post, $meta ){
//    $screens = $meta['args'];

    // Используем nonce для верификации
    wp_nonce_field( 'survey_field_users_roles', 'survey_field_users_roles_nonce' );

    // значение поля
    $users_roles = get_post_meta( $post->ID, 'survey_user_roles', 1 );

    // Поля формы для введения данных
    $rolesArray = [
        'administrator' => 'Administrator',
        'municipality' => 'Municipality',
        'student' => 'Registered users',
        'operator' => 'Operators',
        'engineer' => 'Engineers',
    ];
    ?>
    <div class="survey_field_meta_title"><p><?php _e("Select the roles the survey is intended for", 'ndp' ); ?></p></div>
    <div class="survey_field_meta_select">
        <select id="survey_meta_select">
            <?php
            echo '<option></option>';
            foreach ($rolesArray as $key => $role) {
                echo '<option value="'.$key.'">'.$role.'</option>';
            }
            ?>
        </select>
        <button id="clear_survey_user_roles"><?php _e('Clear', 'ndp'); ?></button>
    </div>
    <div class="survey_field_meta_input">
        <input type="text" id="survey_input_users_roles" name="survey_input_users_roles" value="<?php echo $users_roles; ?>" />
    </div>
    <style>
        #survey_input_users_roles {
            width: 100%;
            margin: 1em 0;
        }
    </style>
    <script>
        var inputUserRoles = document.getElementById('survey_input_users_roles');
        var survey_field_sectionid = document.getElementById('survey_field_sectionid');
        document.getElementById('survey_meta_select').addEventListener('change', function() {
            let value = this.value;
            let userRolesValue = inputUserRoles.value.trim()? inputUserRoles.value.trim().split(',') : [];
            if (!userRolesValue.includes(value)) {
                userRolesValue.push(value);
                inputUserRoles.value = userRolesValue.join();
            }
        });
        document.querySelector('#survey_checkbox input[type="checkbox"]').addEventListener('change', function() {
            let checked = this.checked;
            if (checked) {
                inputUserRoles.value = '';
                survey_field_sectionid.style.display = 'block';
                document.getElementById('acf-group_65a928d0733a1').style.display = 'block';//start date
                document.getElementById('acf-group_65a92a7d0d69d').style.display = 'block';//finish date
            } else {
                survey_field_sectionid.style.display = 'none';
                document.getElementById('acf-group_65a928d0733a1').style.display = 'none';
                document.getElementById('acf-group_65a92a7d0d69d').style.display = 'none';
            }
        });
        document.querySelector('#clear_survey_user_roles').addEventListener('click', function() {
            inputUserRoles.value = '';
        });
    </script>
    <?php
    $surveyType = get_field('type', $post->ID);
    if (!$surveyType): ?>
        <script>
            jQuery(document).ready(function ($) {
                survey_field_sectionid.style.display = 'none';
                $('#acf-group_65a928d0733a1').hide();
                $('#acf-group_65a92a7d0d69d').hide();
            })
        </script>
    <?php endif;
}

## Сохраняем данные опроса, когда пост сохраняется
add_action( 'save_post_course', 'survey_field_save_postdata' );
function survey_field_save_postdata( $post_id ) {
    // Убедимся что поле установлено.
    if ( ! isset( $_POST['survey_input_users_roles'] ) || empty(trim($_POST['survey_input_users_roles']) )
        || (isset($_POST['acf']) && isset($_POST['acf']['field_656faf7ad6022']) && $_POST['acf']['field_656faf7ad6022']=='0') )
        return;

    // проверяем nonce нашей страницы, потому что save_post может быть вызван с другого места.
    if (! wp_verify_nonce( sanitize_text_field($_POST['survey_field_users_roles_nonce']), 'survey_field_users_roles') ) {
        return;
    }

    // если это автосохранение ничего не делаем
    if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
        return;

    // проверяем права юзера
    if( ! current_user_can( 'edit_post', $post_id ) )
        return;

    // Все ОК. Теперь, нужно найти и сохранить данные
    // Очищаем значение поля input.
    $users_roles = sanitize_text_field( trim($_POST['survey_input_users_roles']) );

    // Обновляем данные в базе данных.
    if (!empty($users_roles)) {
        update_post_meta( $post_id, 'survey_user_roles', $users_roles );
    }
}

//удалениние блока Инструкторы из админки при создании курса/опроса
add_filter( 'lifterlms_register_post_type_course', 'add_course_template_custom_handler', 5 );
function add_course_template_custom_handler($block_types) {
    if (!empty($block_types['template'])) {
        foreach ($block_types['template'] as $k => $block) {
            if (!empty($block[0]) && $block[0] == 'llms/instructors') {
                unset($block_types['template'][$k]);
            }
        }
    }
    $block_types['template'] = array_values($block_types['template']);

    return $block_types;
}


//шорткоды шаблона сертификата
add_filter( 'llms_certificate_merge_data', 'llms_certificate_merge_data_handler', 10, 4 );
function llms_certificate_merge_data_handler($codes, $user_id, $template_id, $related_id) {
    $current_lang = apply_filters( 'wpml_current_language', 'uk');
    $companyFieldTitle = $current_lang == 'uk'? 'lms_certificate_company' : 'lms_certificate_company_'.$current_lang;
    $company_name = get_field($companyFieldTitle, $template_id);
    $description = get_field('lms_certificate_description', $template_id);
    $source = get_field('lms_certificate_source', $template_id);
    $expiration = get_field('lms_certificate_expiration', $template_id);
    $today = strtotime("today midnight");
    if (preg_match('/^[0-9]+$/', (int)trim($expiration))) {
        $date = $today + ((int)$expiration * 86400);
        $expiredDate = date('d.m.Y', $date);
    }
    $expire = !empty($expiredDate)? $expiredDate : $expiration;
    $expire = $expire? $expire : '';
    $codes['{company_name}'] = $company_name? $company_name : '';
    $codes['{description}'] = $description? $description : '';
    $codes['{source}'] = $source? $source : '';
    $codes['{expiration}'] = $expire;
    return $codes;
}

//проверка результата опроса (survey), hook wp-content/plugins/lifterlms/includes/models/model.llms.question.php
add_filter( "llms_short_answer_question_grade", 'llms_question_result_handler', 10, 3 );
add_filter( "llms_long_answer_question_grade", 'llms_question_result_handler', 10, 3 );
add_filter( "llms_upload_question_grade", 'llms_question_result_handler', 10, 3 );
add_filter( "llms_blank_question_grade", 'llms_question_result_handler', 10, 3 );
add_filter( "llms_code_question_grade", 'llms_question_result_handler', 10, 3 );
function llms_question_result_handler($grade, $answer, $question) {
    $question_type = $question->get( 'question_type' );
    $correct_value = $question->get('correct_value');
    $questionsArray = ['short_answer', 'long_answer', 'upload', 'blank', 'reorder', 'picture_reorder', 'code', 'scale'];
    if (!empty($question_type) && in_array($question_type, $questionsArray)) {
        if ($question_type == 'blank' && !empty($correct_value) && !empty($answer) && is_array($answer)) {
            if ($correct_value == $answer[0]) {
                $grade = 'yes';
            }else {
                $grade = 'no';
            }
        } else {
            if (!empty($answer)) {
                $grade = 'yes';
            } else {
                $grade = 'no';
            }
        }
    }
    return $grade;
}
//квизы, поле blank
add_filter( 'llms_quiz_attempt_question_get_answer_pre', 'llms_quiz_attempt_question_get_answer_pre_handler', 20, 3 );
function llms_quiz_attempt_question_get_answer_pre_handler($answers, $answer, $question) {
    $question_type = $question->get( 'question_type' );
    if ($question_type == 'blank') {
        $correct_value = $question->get('correct_value');
        if (!empty($correct_value) && !empty($answer)) {
            if ($correct_value == $answer[0]) {
                return $answer[0];
            } else {
                return '';
            }
        }
    }
    return $answers;
}


add_filter( 'llms_table_get_quizzes_columns', 'llms_table_get_quizzes_columns_handler', 10, 2);
function llms_table_get_quizzes_columns_handler($cols, $context) {
    if (!empty($_POST) && !empty($_POST['all_quizzes_data']) && $_POST['all_quizzes_data']) {
        $columns = [
            '_course' => ['title' => __('Course', 'ndp'), 'exportable' => true],
            '_title' => ['title' => __('Title', 'ndp'), 'exportable' => true],
            '_fio' => ['title' => __('Full name', 'ndp'), 'exportable' => true],
            '_tin' => ['title' => __('TIN', 'ndp'), 'exportable' => true],
            '_email' => ['title' => 'Email', 'exportable' => true],
            '_numAttempt' => ['title' => '№', 'exportable' => true],
            '_finish' => ['title' => __('Finish date', 'ndp'), 'exportable' => true],
            '_time' => ['title' => __('Completed', 'ndp'), 'exportable' => true],
            '_answers' => ['title' => __('Answers', 'ndp'), 'exportable' => true],
        ];
        $cols = $columns;
    }
    return $cols;
}

//настройка полей для экспорта
add_filter( 'llms_table_get_quizzes_tbody_data', 'llms_table_get_quizzes_tbody_data_handler');
function llms_table_get_quizzes_tbody_data_handler($tbody_data) {
    if (!empty($_POST) && !empty($_POST['all_quizzes_data']) && filter_var($_POST['all_quizzes_data'], FILTER_VALIDATE_BOOLEAN)) {
        if (!empty($_POST['course_id'])) {
            $course = new LLMS_Course($_POST['course_id']);
            if ($course) {
                $quizzes = $course->get_quizzes();
                if (!empty($quizzes) && is_array($quizzes)) {
                    $query_args = array(
                        'order'          => 'ASC',
                        'post_type'      => 'llms_quiz',
                        'posts_per_page' => -1,
                        'post__in' => $quizzes,
                    );
                    $query = new WP_Query( $query_args );
                    $tbody_data = $query->posts;
                } else {
                    $tbody_data = [];
                }
            }
        }
        $attemptsResult = [];
        foreach ($tbody_data as $k => $quizPost) {
            $queryAttempts = new LLMS_Query_Quiz_Attempt(
                [
                    'quiz_id'    => $quizPost->ID,
                    'per_page' => 5000,
                    'status_exclude' => array( 'incomplete' ),
                    'sort'           => array(
                        'attempt'    => 'ASC',
                    ),
                ]
            );
            $attempts = $queryAttempts->get_attempts();
            $quiz = llms_get_post( $quizPost->ID );
            foreach ( $attempts as $attempt ) {
                $attemptsArray = [];
                $lesson   = new LLMS_Lesson($attempt->get( 'lesson_id' ));
                $course = $lesson->get_course();
                $attemptsArray['_course'] = $course? trim($course->get('title')) : '';
                $attemptsArray['_title'] = trim($quiz->get('title'));
                $student = llms_get_student( $attempt->get( 'student_id' ) );
                $user = $student? $student->get('user') : '';
                $userData = get_userdata($user->ID);
                $fullNameArray = [];
                if ($lastName = $userData->last_name) {
                    $fullNameArray[] = $lastName;
                }
                if ($firstName = $userData->first_name) {
                    $fullNameArray[] = $firstName;
                }
                if ($middleName = $userData->middle_name) {
                    $fullNameArray[] = $middleName;
                }
                $fullName = join(' ', $fullNameArray);
                $attemptsArray['_fio'] = $fullName;
                $attemptsArray['_tin'] = $userData->edrpouCode;
                $attemptsArray['_email'] = $userData->user_email;
                $attemptsArray['_numAttempt'] = $attempt->get( 'attempt' );
                $attemptsArray['_finish'] = $attempt->get( 'end_date' );
                $time = $attempt->get_time();
                $time = preg_replace(['/година/','/хвилина/','/секунда/','/годин/','/хвилин/','/секунд/'], ['год.','хв.','сек.','год.','хв.','сек.'], $time);
                $attemptsArray['_time'] = $time;
                $questions = $attempt->get_questions();
                $questionsArray = [];
                foreach ( $attempt->get_question_objects() as $q => $attempt_question ) {
                    $quiz_question = $attempt_question->get_question();
                    if ($quiz_question) {
                        $question_type = $quiz_question->get_question_type();
                        $questionTitle = $quiz_question->get_question( 'plain' );
                        $answersArray  = $attempt_question->get_answer_array();
                        $answer = '';
                        if (!empty($questions[$q]['answer'])) {
                            $currentAnswer = $answersArray;
                            if (!empty($question_type)) {
                                if ($question_type['id'] == 'upload') {
                                    $currentAnswer = wp_get_attachment_image_url( $currentAnswer[0], 'full' );
                                } elseif ($question_type['id'] == 'picture_choice') {
                                    preg_match('/src="([^"]+)"/', $currentAnswer[0], $pictureUrl);
                                    if (!empty($pictureUrl) && !empty($pictureUrl[1])) {
                                        $currentAnswer = $pictureUrl[1];
                                    }
                                }
                            }
                            $answer = join(';', (array)$currentAnswer);
                        }
                        if (!empty($answer)) {
                            $questionsArray[] = trim($questionTitle) . ':' . trim($answer);
                        }
                    }
                }
                if (!empty($questionsArray)) {
                    $attemptsArray['_answers'] = join('|', $questionsArray);
                }
                if (!empty($attemptsArray)) {
                    $attemptsResult[] = $attemptsArray;
                }
            }
        }
        if (!empty($attemptsResult)) {
            $tbody_data = $attemptsResult;
        }
    }
    return $tbody_data;
}
//экспорт квизов, настройка вывода полей
add_filter( 'llms_table_get_data_quizzes', 'llms_table_get_data_quizzes_handler', 10, 5);
function llms_table_get_data_quizzes_handler($value, $key, $data, $context, $table) {
    if (!empty($_POST) && !empty($_POST['all_quizzes_data']) && filter_var($_POST['all_quizzes_data'], FILTER_VALIDATE_BOOLEAN)) {
        if (is_array($data) && !empty($data[$key])) {
            $value = $data[$key];
        } else {
            $value = '';
        }
    }
    return $value;
}

function getAllCourses(array $args = []) {
    $defaults = [
        'post_type'      => 'course',
        'posts_per_page' => -1,
        'post_status'    => 'publish',
        'fields' => 'ids',
    ];
    $args = wp_parse_args( $args, $defaults );
    return get_posts($args);
}