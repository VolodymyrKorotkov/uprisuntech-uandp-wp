<?php
/**
 * My Account page
 *
 * @package LifterLMS/Templates
 *
 * @since    1.0.0
 * @version  3.14.0
 */
do_action('lifterlms_before_student_dashboard_tab');
wp_enqueue_script('error', get_template_directory_uri() . '/assets/js/error.js', array('jquery'), '1.0', true);
wp_enqueue_style('error', get_template_directory_uri() . '/assets/css/error.css');
$student = llms_get_student();
$user = $student->get('user');
$user_id = $user->ID;
$userData = get_userdata($user->ID);
$role = $userData->roles[0];
if ($role == 'operator') {
    $url = llms_get_endpoint_url( 'requests', '', llms_get_page_url( 'myaccount' ) );
    wp_safe_redirect($url);
    exit;
}

$courses = $student->get_courses();

$applications = get_user_applications($user_id) ?? [];
$current_language = apply_filters('wpml_current_language', NULL);

$get_type = get_user_meta($user_id, 'user_profile_type');
if(isset($_GET['invite'])){
    $invite= $_GET['invite'];
}else{
    $invite =  get_user_meta($user_id, 'invite', true);
}


if (strlen($invite)) {
    $_SESSION['invite'] = $invite;

    if (is_user_logged_in()) {
        $currentUser = wp_get_current_user();
        if (isset($_SESSION['invite'])) {
            $invitedUser = get_invited_representatives('', '', ['invite' => $_SESSION['invite']]);
        } else {
            $invitedUser = array();
        }

        if (!empty($invitedUser)) {
            // Используем 'textInvite' как уникальный идентификатор приглашения
            $invite_id = isset($_GET['invite']) ? $_GET['invite'] : $invite ; // Убедитесь, что это правильный ключ

            delete_user_meta($user_id,'invite');
            // Выполнить проверку edrpouCode
            if (is_user_edrpouCode_matched($currentUser->ID, $invite_id)) {



                addInvitedRequestToOperatorAndApprove($currentUser, $invitedUser, $user->user_email);
                deleteInvite($invite_id);
                delete_user_meta($user_id,'invite');
                header('Location: /dashboard');
            } else if(!empty($get_type) and isset($invite)) {

                unset($_SESSION['show_notify']);

                deleteInvite($_SESSION['invite']);
                delete_user_meta($user_id,'invite');

                ?>


                <div class="error__modal">
                    <div class="error__modal-item">
                        <button class="error__modal-close"></button>
                        <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg"
                             class="error__modal-icon">
                            <rect width="80" height="80" rx="40" fill="#FFDAD6"/>
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                  d="M40 30C34.48 30 30 34.48 30 40C30 45.52 34.48 50 40 50C45.52 50 50 45.52 50 40C50 34.48 45.52 30 40 30ZM39 45V43H41V45H39ZM39 35V41H41V35H39Z"
                                  fill="#BA1A1A"/>
                        </svg>
                        <h2 class="error__modal-title"><?php _e('Error checked', 'ndp'); ?></h2>
                        <p class="error__modal-subtitle"><?php _e('Your data does not match the information in the invitation. Please contact the head of the organization that sent the invitation.', 'ndp'); ?></p>
                        <button class="error__modal-button"><?php _e('Okay', 'ndp'); ?></button>
                    </div>
                </div>
            <?php } ?>
        <?php } ?>
    <?php } ?>
<?php } ?>




<?php
llms_get_template(
    'myaccount/dashboard-sidebar.php',
);
?>

<?php if (isset($_SESSION['show_notify']) and $_SESSION['show_notify']) {

    unset($_SESSION['show_notify']);
    ?>

    <div class="error__modal">
        <div class="error__modal-item">
            <button class="error__modal-close"></button>
            <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg"
                 class="error__modal-icon">
                <rect width="80" height="80" rx="40" fill="#FFDAD6"/>
                <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M40 30C34.48 30 30 34.48 30 40C30 45.52 34.48 50 40 50C45.52 50 50 45.52 50 40C50 34.48 45.52 30 40 30ZM39 45V43H41V45H39ZM39 35V41H41V35H39Z"
                      fill="#BA1A1A"/>
            </svg>
            <h2 class="error__modal-title"><?php _e('Error checked', 'ndp'); ?></h2>
            <p class="error__modal-subtitle"><?php _e('Your data does not match the information in the invitation. Please contact the head of the organization that sent the invitation.', 'ndp'); ?></p>
            <button class="error__modal-button"><?php _e('Okay', 'ndp'); ?></button>
        </div>
    </div>

<?php } ?>
<script>
    // Функция для получения значения cookie по имени
    function getCookie(name) {
        let matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    // Функция для удаления cookie
    function deleteCookie(name) {
        document.cookie = name + '=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    }

    // Проверяем наличие параметра 'old_url' в cookies
    let oldUrl = getCookie('old_url');
    console.log('oldUrl', oldUrl);
    if (oldUrl) {
        // Удаляем cookie 'old_url'
        deleteCookie('old_url');

        // Переадресовываем на полученный URL
        window.location.href = oldUrl;
    }
</script>
<div class="account__content col-8">
    <section class="dashboard">
        <h1 class="dashboard__title"><?php _e('Dashboard', 'ndp'); ?></h1>
        <div class="dashboard__block dashboard__applications">
            <div class="dashboard__applications-title">
                <h2><?php _e('Last applications', 'ndp'); ?></h2>
                <?php
                if (count($applications) > 0):
                    ?>
                    <a href="<?php echo llms_get_endpoint_url('applications', '', llms_get_page_url('myaccount')); ?>"><?php _e('View all', 'ndp'); ?>
                        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                            <path d="M9.5 3L8.4425 4.0575L12.6275 8.25H3.5V9.75H12.6275L8.4425 13.9425L9.5 15L15.5 9L9.5 3Z"
                                  fill="#2A59BD"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
            <?php if (count($applications) > 0): ?>
                <table>
                    <colgroup>
                        <col style="width: auto;">
                        <col style="width: auto;">
                        <col style="width: auto;">
                        <col style="width: 96px;">
                    </colgroup>
                    <tr>
                        <td class="dashboard__applications-table__title dashboard__applications-table__hidden-mobile"><?php _e('Application', 'ndp'); ?></td>
                        <td class="dashboard__applications-table__title dashboard__applications-table__hidden-desktop"><?php _e('App.', 'ndp'); ?></td>
                        <td class="dashboard__applications-table__title"><?php _e('Status', 'ndp'); ?></td>
                        <td class="dashboard__applications-table__title"><?php _e('Amount', 'ndp'); ?></td>
                        <td class="dashboard__applications-table__title dashboard__applications-table__title-last"><?php _e('Action', 'ndp'); ?></td>
                    </tr>
                    <?php
                    foreach ($applications as $key => $application) :
                        if ($key > 2) break;
                        ?>
                        <tr>
                            <td class="dashboard__applications-table__number">№<?php echo $application->id; ?></td>
                            <td><?php echo mb_ucfirst(__($application->status, 'ndp')); ?></td>
                            <?php
                            $amount = __('Amount N/A', 'ndp');
                            if (property_exists($application, 'amount') && $application->amount != '0') {
                                $amount = number_format($application->amount, 2);
                            }
                            if (property_exists($application, 'currency_code')) {
                                $amount = $amount . ' '. __($application->currency_code, 'ndp');
                            }
                            ?>
                            <td><?php echo $amount; ?></td>
                            <td class="applications__table-image" style="text-align: center;">
                                <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/notifications.svg" alt="notifications-icon"> -->

                                <?php
                                if ($current_language == "en") {
                                    $link = "/en/create-application/?id=$application->id";
                                } else {
                                    $link = "/create-application/?id=$application->id";
                                }

                                ?>

                                <img onclick="window.location.href='<?php echo $link; ?>'"
                                     src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow-right.svg"
                                     alt="arrow-right" class="applications__table-hidden-mobile">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php else: ?>
                <div class="dashboard__block-wrapper dashboard__block-applications">
                    <p><?php _e('No applications created', 'ndp'); ?></p>
                    <?php
                    $lng_url = '';
                    if ($current_language && $current_language != 'uk') {
                        $lng_url = '/' . $current_language;
                    }
                    ?>
                    <a href="<?= $lng_url ?>/create-application">
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M12 6.75H6.75V12H5.25V6.75H0V5.25H5.25V0H6.75V5.25H12V6.75Z" fill="#2A59BD"/>
                        </svg>
                        <?php _e('Create Application', 'ndp') ?></a>
                </div>
            <?php endif; ?>
        </div>
        <?php
        wp_enqueue_script('application', get_template_directory_uri() . '/react-aplication/build_modal/application_modal.js', array(), _S_VERSION, true);
        wp_enqueue_style('application', get_template_directory_uri() . '/react-aplication/build_modal/application_modal.css');

        ?>
        <script>
            function showModal(id) {
                fetch('/wp-json/application/v1/get_entry/' + id)
                    .then(response => response.json())
                    .then(data => {
                        if (data.id) {

                            window.openResultApplicationModal(JSON.parse(data.apply_info));
                        } else {
                            console.error("Произошла ошибка при получении записи.");
                        }
                    })
                    .catch((error) => {
                        console.error('Ошибка:', error);
                    });
            }

        </script>

        <?php if (!current_user_can('read_requests') && (!empty($courses['found']) && $courses['found'] > 0)): ?>
            <div class="dashboard__block dashboard__inProgress">
                <div class="dashboard__inProgress-title">
                    <h2><?php _e('Courses in progress', 'ndp'); ?></h2>
                    <?php if (!empty($courses['found']) && $courses['found'] > 0): ?>
                        <a href="<?php echo llms_get_endpoint_url('view-courses'); ?>"><?php _e('View all', 'ndp'); ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18"
                                 fill="none">
                                <path d="M9.5 3L8.4425 4.0575L12.6275 8.25H3.5V9.75H12.6275L8.4425 13.9425L9.5 15L15.5 9L9.5 3Z"
                                      fill="#2A59BD"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
                <?php
                add_filter('llms_my_courses_loop_courses_query_args', function ($args) {
                    $args['limit'] = 2;
                    return $args;
                });
                lifterlms_template_my_courses_loop();
                ?>
            </div>
        <?php endif; ?>
        <?php
        $certificates = $student->get_certificates() ?? [];
        if (!current_user_can('read_requests') && count($certificates)):
            ?>
            <div class="dashboard__block dashboard__certificates">
                <div class="dashboard__certificates-title">
                    <h2><?php _e('Certificates', 'ndp'); ?>
                        <?php
                        if (count($certificates) < 2) {
                            $args = array(
                                'post_type' => 'custom_certificate',
                                'posts_per_page' => 2 - count($certificates),
                                'paged' => max(1, get_query_var('paged')),
                                'author' => $student->get('id'),
                            );

                            $customQuery = new WP_Query($args);
                            $result = [];
                            if ($customQuery->have_posts()) {
                                foreach ($customQuery->posts as $post) {
                                    $result[] = new LLMS_User_Certificate($post);
                                }
                            }
                            $certificates = array_merge($certificates, $result);
                        }
                        ?>
                        <span class="dashboard__certificates-count">(<?php echo count($certificates); ?>)</span>
                    </h2>
                    <?php if (count($certificates) > 0): ?>
                        <a href="<?php echo llms_get_endpoint_url('view-certificates'); ?>"><?php _e('View all', 'ndp'); ?>
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18"
                                 fill="none">
                                <path d="M9.5 3L8.4425 4.0575L12.6275 8.25H3.5V9.75H12.6275L8.4425 13.9425L9.5 15L15.5 9L9.5 3Z"
                                      fill="#2A59BD"/>
                            </svg>
                        </a>
                    <?php endif; ?>
                </div>
                <?php
                lifterlms_template_certificates_loop($student, 2);
                ?>
            </div>
        <?php endif; ?>
    </section>
</div>

