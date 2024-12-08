<!doctype html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport"
    content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">

  <?php wp_head(); ?>
  <script>
    window.restNonce = '<?php echo wp_create_nonce('wp_rest'); ?>';
  </script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700;1,900&display=swap"
    rel="stylesheet">

  <?php
  $user = wp_get_current_user();
  $status = get_user_meta($user->ID, 'verify_end');

  if (empty($status) || !$status) {
    $currentUrlPath = $_SERVER['REQUEST_URI'];

    if (strpos($currentUrlPath, 'logout') === false) {
      if (strpos($currentUrlPath, 'dashboard') !== false) {
        $get_type = get_user_meta($user->ID, 'user_profile_type');

        if (is_user_logged_in()) {
          if (empty($get_type)) {
            echo "<script>window.location.href = '/register-step-1/';</script>";
          } else {
            echo "<script>window.location.href = '/register-step-2/';</script>";
          }
        }
      }
    }
  }
  ?>

</head>
<script>
  let lang_tags = '<?php _e('Select tags', 'ndp'); ?>';
</script>
<script>
  const addressBarHeight = window.visualViewport.height - window.innerHeight;
  document.documentElement.style.setProperty('--address-bar-height', addressBarHeight + 'px');

  // Викликати цей код також при зміні розміру вікна браузера
  window.addEventListener('resize', function () {
    const addressBarHeight = window.visualViewport.height - window.innerHeight;
    document.documentElement.style.setProperty('--address-bar-height', addressBarHeight + 'px');
  });
</script>
<script>
  (function () {
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.has('uuid')) {
      window.location.reload();
    }
  })();</script>

<body <?php body_class(); ?>>
  <?php wp_body_open(); ?>

  <?php

  $lng_url = '';
  $language_code = '';
  $languages = icl_get_languages('skip_missing=0&orderby=code');
  if (!empty($languages)) {
    foreach ($languages as $l) {
      if ($l['active']) {
        $lng_url = $l['url'];
        $language_code = $l['language_code'];
      }
    }
  }

  $lng_url = strpos($lng_url, '/' . $language_code . '/') !== false ? '/' . $language_code : '';
  $queryString = (strpos($_SERVER['REQUEST_URI'], 'create-application') !== false) || (strpos($_SERVER['REQUEST_URI'], 'application-engineer') !== false) ? $_SERVER['QUERY_STRING'] : '';
  ?>

  <!-- Header -->
  <header class="header">
    <div class="container">
      <div class='row'>
        <div class="col-md-12">
          <div class="wrap-menu">

            <!-- Logo -->
            <a href="<?php echo home_url(); ?>" class="logo">
              <span class="logo_img" style="width: 140px;">
                <img src="<?php echo get_template_directory_uri() ?>/assets/img/icon/logo.svg" alt="">
              </span>
            </a>

            <!-- Menu -->
            <nav class="main-menu">
              <div class="burger-menu">
                <span></span>
              </div>
              <div class="main-menu-container">
                <?php
                $menu_name = 'Header';
                $menu_args = array(
                  'menu' => $menu_name,
                  'menu_class' => 'menu',
                  'container' => false,

                );
                wp_nav_menu($menu_args);
                ?>
                <div class="menu__btn-show">
                  <a href="<?= $lng_url ?>/create-application" class="btn btn_bg_primary">
                    <?php _e('Create Application', 'ndp') ?>
                  </a>
                  <div class="language">
                    <?php
                    if (!empty($languages)) {
                      foreach ($languages as $l) {
                        $lang = ($l['language_code'] == "uk") ? "UA" : $l['language_code'];
                        if ($l['active']) {
                          echo '<a href="#" class="language__toggle-btn current" data-lang-current="' . $l['language_code'] . '">' . $lang . '</a>';
                          break; // exit the loop after finding the active language
                        }
                      }
                      echo '<ul class="language__list">';
                      foreach ($languages as $l) {
                        $lang = ($l['language_code'] == "uk") ? "UA" : $l['language_code'];
                        echo '<li class="language__item">';
                        if (!$l['active']) {
                          echo '<a data-lang="' . $l['language_code'] . '" href="' . $l['url'] . ($queryString ? '?' . $queryString : '') . '" class="link-to-another-lang">' . $lang . '</a>';
                        }
                        echo '</li>';
                      }
                      echo '</ul>';
                    }
                    ?>
                  </div>
                </div>
              </div>
            </nav>

            <div class="header__rgt-column">

              <!-- Search block  search-popup-->
              <div class="search-block	">
                <a href="/search-results/">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                      d="M14.76 13.27L20.49 19L19 20.49L13.27 14.76C12.2 15.53 10.91 16 9.5 16C5.91 16 3 13.09 3 9.5C3 5.91 5.91 3 9.5 3C13.09 3 16 5.91 16 9.5C16 10.91 15.53 12.2 14.76 13.27ZM9.5 5C7.01 5 5 7.01 5 9.5C5 11.99 7.01 14 9.5 14C11.99 14 14 11.99 14 9.5C14 7.01 11.99 5 9.5 5Z"
                      fill="#2A59BD" />
                  </svg>
                </a>

                <!--
                        <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                            <label>
                                <span class="screen-reader-text">Search for:</span>
                                <input type="search" class="search-field" placeholder="Search …"
                                    value="<?php echo get_search_query(); ?>" name="s"/>
                            </label>
                            <button type="submit" class="search-submit">
                                <span class="screen-reader-text">Search</span>
                            </button>
                        </form>
                        -->

              </div>

              <!-- Cta -->
              <a href="<?= $lng_url ?>/create-application" class="btn btn_bg_primary">
                <?php _e('Create Application', 'ndp') ?>
              </a>

              <!-- Language -->
              <div class="language">
                <?php
                if (!empty($languages)) {
                  // Display the active language toggle button
                  foreach ($languages as $l) {
                    $lang = ($l['language_code'] == "uk") ? "UA" : $l['language_code'];
                    if ($l['active']) {
                      echo '<a href="#" class="language__toggle-btn current" data-lang-current="' . $l['language_code'] . '">' . $lang . '</a>';
                      break; // exit the loop after finding the active language
                    }
                  }

                  // Display the list of non-active languages
                  echo '<ul class="language__list">';
                  foreach ($languages as $l) {
                    $lang = ($l['language_code'] == "uk") ? "UA" : $l['language_code'];
                    echo '<li class="language__item">';
                    if (!$l['active']) {
                      echo '<a data-lang="' . $l['language_code'] . '" href="' . $l['url'] . ($queryString ? '?' . $queryString : '') . '" class="link-to-another-lang">' . $lang . '</a>';
                    }
                    echo '</li>';
                  }
                  echo '</ul>';
                }
                ?>
              </div>

              <!-- User -->
              <?php $initials = get_initials_of_current_user(); ?>
              <div class="user-dashboard <?php if (is_user_logged_in())
                echo 'dashboard-active'; ?>">
                <a href="/dashboard" class="user">
                  <?php if (is_user_logged_in()) { ?>
                    <span class="user initial">
                      <?php echo $initials; ?>
                    </span>
                    <span class="notify_color" style="display:none">0</span>
                  <?php } else { ?>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M12 4C9.79 4 8 5.79 8 8C8 10.21 9.79 12 12 12C14.21 12 16 10.21 16 8C16 5.79 14.21 4 12 4ZM14 8C14 6.9 13.1 6 12 6C10.9 6 10 6.9 10 8C10 9.1 10.9 10 12 10C13.1 10 14 9.1 14 8ZM18 17C17.8 16.29 14.7 15 12 15C9.3 15 6.2 16.29 6 17.01V18H18V17ZM4 17C4 14.34 9.33 13 12 13C14.67 13 20 14.34 20 17V20H4V17Z"
                        fill="#2A59BD" />
                    </svg>
                  <?php } ?>
                </a>
                <?php if (is_user_logged_in()) { ?>
                  <?php $endpointSlug = LLMS_Student_Dashboard::get_current_tab('slug'); ?>
                  <div class="account__nav-mobile__overlay">
                    <nav class="account__nav-mobile">
                      <a href="<?php echo llms_get_page_url('myaccount'); ?>"
                        class="account__nav-mobile__item <?php if ($endpointSlug === 'dashboard'): ?> account__block-nav__item-current <?php endif; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <mask id="mask0_3459_11711" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                            width="24" height="24">
                            <rect width="24" height="24" fill="#D9D9D9" />
                          </mask>
                          <g mask="url(#mask0_3459_11711)">
                            <path
                              d="M5 21C4.45 21 3.97917 20.8042 3.5875 20.4125C3.19583 20.0208 3 19.55 3 19V5C3 4.45 3.19583 3.97917 3.5875 3.5875C3.97917 3.19583 4.45 3 5 3H19C19.55 3 20.0208 3.19583 20.4125 3.5875C20.8042 3.97917 21 4.45 21 5V19C21 19.55 20.8042 20.0208 20.4125 20.4125C20.0208 20.8042 19.55 21 19 21H5ZM5 19H11V5H5V19ZM13 19H19V12H13V19ZM13 10H19V5H13V10Z"
                              fill="#1C1B1F" />
                          </g>
                        </svg>
                        <?php _e('Dashboard', 'ndp'); ?>
                      </a>
                      <a href="<?php echo llms_get_endpoint_url('applications', '', llms_get_page_url('myaccount')); ?>"
                        class="account__nav-mobile__item <?php if ($endpointSlug === 'applications'): ?> account__block-nav__item-current <?php endif; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <mask id="mask0_3459_11718" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                            width="24" height="24">
                            <rect width="24" height="24" fill="#D9D9D9" />
                          </mask>
                          <g mask="url(#mask0_3459_11718)">
                            <path
                              d="M5.55 18.9998L2 15.4498L3.4 14.0498L5.525 16.1748L9.775 11.9248L11.175 13.3498L5.55 18.9998ZM5.55 10.9998L2 7.4498L3.4 6.0498L5.525 8.1748L9.775 3.9248L11.175 5.3498L5.55 10.9998ZM13 16.9998V14.9998H22V16.9998H13ZM13 8.9998V6.9998H22V8.9998H13Z"
                              fill="#1C1B1F" />
                          </g>
                        </svg>
                        <?php _e('Applications', 'ndp'); ?>
                      </a>
                      <?php if (current_user_can('read_requests')): ?>
                        <a href="<?php echo llms_get_endpoint_url('requests', '', llms_get_page_url('myaccount')); ?>"
                          class="account__nav-mobile__item <?php if ($endpointSlug === 'requests'): ?> account__block-nav__item-current <?php endif; ?>">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M19 3H5C3.9 3 3 3.9 3 5V19C3 20.1 3.9 21 5 21H19C20.1 21 21 20.1 21 19V5C21 3.9 20.1 3 19 3ZM19 19H5V5H19V19ZM17.99 9L16.58 7.58L9.99 14.17L7.41 11.6L5.99 13.01L9.99 17L17.99 9Z"
                              fill="black" />
                          </svg>
                          <?php _e('Requests', 'ndp'); ?>
                        </a>
                      <?php endif; ?>
                      <?php if (!current_user_can('read_requests')): ?>
                        <a href="<?php echo llms_get_endpoint_url('view-courses', '', llms_get_page_url('myaccount')); ?>"
                          class="account__nav-mobile__item <?php if ($endpointSlug === 'view-courses'): ?> account__block-nav__item-current <?php endif; ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <mask id="mask0_3459_11730" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                              width="24" height="24">
                              <rect width="24" height="24" fill="#D9D9D9" />
                            </mask>
                            <g mask="url(#mask0_3459_11730)">
                              <path
                                d="M12 21L5 17.2V11.2L1 9L12 3L23 9V17H21V10.1L19 11.2V17.2L12 21ZM12 12.7L18.85 9L12 5.3L5.15 9L12 12.7ZM12 18.725L17 16.025V12.25L12 15L7 12.25V16.025L12 18.725Z"
                                fill="#1C1B1F" />
                            </g>
                          </svg>
                          <?php _e('My courses', 'ndp'); ?>
                        </a>
                        <a href="<?php echo llms_get_endpoint_url('view-certificates', '', llms_get_page_url('myaccount')); ?>"
                          class="account__nav-mobile__item <?php if ($endpointSlug === 'view-certificates'): ?> account__block-nav__item-current <?php endif; ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <mask id="mask0_3459_11737" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                              width="24" height="24">
                              <rect width="24" height="24" fill="#D9D9D9" />
                            </mask>
                            <g mask="url(#mask0_3459_11737)">
                              <path
                                d="M7 17H14V15H7V17ZM7 13H17V11H7V13ZM7 9H17V7H7V9ZM5 21C4.45 21 3.97917 20.8042 3.5875 20.4125C3.19583 20.0208 3 19.55 3 19V5C3 4.45 3.19583 3.97917 3.5875 3.5875C3.97917 3.19583 4.45 3 5 3H19C19.55 3 20.0208 3.19583 20.4125 3.5875C20.8042 3.97917 21 4.45 21 5V19C21 19.55 20.8042 20.0208 20.4125 20.4125C20.0208 20.8042 19.55 21 19 21H5ZM5 19H19V5H5V19Z"
                                fill="#1C1B1F" />
                            </g>
                          </svg>
                          <?php _e('Certificates', 'ndp'); ?>
                        </a>
                      <?php endif; ?>
                      <a href="<?php echo llms_get_endpoint_url('surveys', '', llms_get_page_url('myaccount')); ?>"
                        class="account__nav-mobile__item <?php if ($endpointSlug === 'surveys'): ?> account__block-nav__item-current <?php endif; ?>">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <mask id="mask0_7912_6521" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                            width="24" height="24">
                            <rect width="24" height="24" fill="#D9D9D9" />
                          </mask>
                          <g mask="url(#mask0_7912_6521)">
                            <path
                              d="M11.95 18C12.3 18 12.5958 17.8792 12.8375 17.6375C13.0792 17.3958 13.2 17.1 13.2 16.75C13.2 16.4 13.0792 16.1042 12.8375 15.8625C12.5958 15.6208 12.3 15.5 11.95 15.5C11.6 15.5 11.3042 15.6208 11.0625 15.8625C10.8208 16.1042 10.7 16.4 10.7 16.75C10.7 17.1 10.8208 17.3958 11.0625 17.6375C11.3042 17.8792 11.6 18 11.95 18ZM11.05 14.15H12.9C12.9 13.6 12.9625 13.1667 13.0875 12.85C13.2125 12.5333 13.5667 12.1 14.15 11.55C14.5833 11.1167 14.925 10.7042 15.175 10.3125C15.425 9.92083 15.55 9.45 15.55 8.9C15.55 7.96667 15.2083 7.25 14.525 6.75C13.8417 6.25 13.0333 6 12.1 6C11.15 6 10.3792 6.25 9.7875 6.75C9.19583 7.25 8.78333 7.85 8.55 8.55L10.2 9.2C10.2833 8.9 10.4708 8.575 10.7625 8.225C11.0542 7.875 11.5 7.7 12.1 7.7C12.6333 7.7 13.0333 7.84583 13.3 8.1375C13.5667 8.42917 13.7 8.75 13.7 9.1C13.7 9.43333 13.6 9.74583 13.4 10.0375C13.2 10.3292 12.95 10.6 12.65 10.85C11.9167 11.5 11.4667 11.9917 11.3 12.325C11.1333 12.6583 11.05 13.2667 11.05 14.15ZM12 22C10.6167 22 9.31667 21.7375 8.1 21.2125C6.88333 20.6875 5.825 19.975 4.925 19.075C4.025 18.175 3.3125 17.1167 2.7875 15.9C2.2625 14.6833 2 13.3833 2 12C2 10.6167 2.2625 9.31667 2.7875 8.1C3.3125 6.88333 4.025 5.825 4.925 4.925C5.825 4.025 6.88333 3.3125 8.1 2.7875C9.31667 2.2625 10.6167 2 12 2C13.3833 2 14.6833 2.2625 15.9 2.7875C17.1167 3.3125 18.175 4.025 19.075 4.925C19.975 5.825 20.6875 6.88333 21.2125 8.1C21.7375 9.31667 22 10.6167 22 12C22 13.3833 21.7375 14.6833 21.2125 15.9C20.6875 17.1167 19.975 18.175 19.075 19.075C18.175 19.975 17.1167 20.6875 15.9 21.2125C14.6833 21.7375 13.3833 22 12 22ZM12 20C14.2333 20 16.125 19.225 17.675 17.675C19.225 16.125 20 14.2333 20 12C20 9.76667 19.225 7.875 17.675 6.325C16.125 4.775 14.2333 4 12 4C9.76667 4 7.875 4.775 6.325 6.325C4.775 7.875 4 9.76667 4 12C4 14.2333 4.775 16.125 6.325 17.675C7.875 19.225 9.76667 20 12 20Z"
                              fill="#1C1B1F" />
                          </g>
                        </svg>
                        <?php _e('Surveys', 'ndp'); ?>
                      </a>
                      <!-- <a href="<?php echo llms_get_endpoint_url('notifications', '', llms_get_page_url('myaccount')); ?>" class="account__nav-mobile__item <?php if ($endpointSlug === 'notifications'): ?> account__block-nav__item-current <?php endif; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                  <mask id="mask0_3459_11749" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                                        width="24" height="24">
                                    <rect width="24" height="24" fill="#D9D9D9"/>
                                  </mask>
                                  <g mask="url(#mask0_3459_11749)">
                                    <path d="M4 19V17H6V10C6 8.61667 6.41667 7.3875 7.25 6.3125C8.08333 5.2375 9.16667 4.53333 10.5 4.2V3.5C10.5 3.08333 10.6458 2.72917 10.9375 2.4375C11.2292 2.14583 11.5833 2 12 2C12.4167 2 12.7708 2.14583 13.0625 2.4375C13.3542 2.72917 13.5 3.08333 13.5 3.5V4.2C14.8333 4.53333 15.9167 5.2375 16.75 6.3125C17.5833 7.3875 18 8.61667 18 10V17H20V19H4ZM12 22C11.45 22 10.9792 21.8042 10.5875 21.4125C10.1958 21.0208 10 20.55 10 20H14C14 20.55 13.8042 21.0208 13.4125 21.4125C13.0208 21.8042 12.55 22 12 22ZM8 17H16V10C16 8.9 15.6083 7.95833 14.825 7.175C14.0417 6.39167 13.1 6 12 6C10.9 6 9.95833 6.39167 9.175 7.175C8.39167 7.95833 8 8.9 8 10V17Z"
                                          fill="#1C1B1F"/>
                                  </g>
                                </svg>
                                  <?php _e('Notifications', 'ndp'); ?>
                                  <?php
                                  $notificationsCount = 0;
                                  $notifications = wp_cache_get('dashboardNotifications');
                                  if (false !== $notifications) {
                                    $notificationsCount = count($notifications->get_notifications());
                                  } else {
                                    $page = llms_get_paged_query_var();
                                    $notifications = new LLMS_Notifications_Query(
                                      array(
                                        'page' => $page,
                                        /**
                                         * Filter the number of notifications per page to be displayed in the dashboard's "my_notifications" tab.
                                         *
                                         * @since unknown
                                         *
                                         * @param int $per_page The number of notifications per page to be displayed. Default `25`.
                                         */
                                        'per_page' => apply_filters('llms_sd_my_notifications_per_page', 25),
                                        'subscriber' => get_current_user_id(),
                                        'sort' => array(
                                          'created' => 'DESC',
                                          'id' => 'DESC',
                                        ),
                                        'types' => 'basic',
                                      )
                                    );
                                    $notificationsCount = count($notifications->get_notifications());
                                  }
                                  ?>
                                <span class="account__block-nav__item-count"><?php if ($notificationsCount > 0)
                                  echo $notificationsCount; ?></span>
                              </a> -->
                      <a href="<?php echo llms_get_endpoint_url('edit-account', '', llms_get_page_url('myaccount')); ?>"
                        class="account__nav-mobile__item <?php if ($endpointSlug === 'edit-account'): ?> account__block-nav__item-current <?php endif; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                          <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M15.3102 21.0298C15.2102 21.7098 14.5902 22.2498 13.8502 22.2498H10.1502C9.41023 22.2498 8.79023 21.7098 8.70023 20.9798L8.43023 19.0898C8.16023 18.9498 7.90023 18.7998 7.64023 18.6298L5.84023 19.3498C5.14023 19.6098 4.37023 19.3198 4.03023 18.6998L2.20023 15.5298C1.85023 14.8698 2.00023 14.0898 2.56023 13.6498L4.09023 12.4598C4.08023 12.3098 4.07023 12.1598 4.07023 11.9998C4.07023 11.8498 4.08023 11.6898 4.09023 11.5398L2.57023 10.3498C1.98023 9.89977 1.83023 9.08977 2.20023 8.46977L4.05023 5.27977C4.39023 4.65977 5.16023 4.37977 5.84023 4.64977L7.65023 5.37977C7.91023 5.20977 8.17023 5.05977 8.43023 4.91977L8.70023 3.00977C8.79023 2.30977 9.41023 1.75977 10.1402 1.75977H13.8402C14.5802 1.75977 15.2002 2.29977 15.2902 3.02977L15.5602 4.91977C15.8302 5.05977 16.0902 5.20977 16.3502 5.37977L18.1502 4.65977C18.8602 4.39977 19.6302 4.68977 19.9702 5.30977L21.8102 8.48977C22.1702 9.14977 22.0102 9.92977 21.4502 10.3698L19.9302 11.5598C19.9402 11.7098 19.9502 11.8598 19.9502 12.0198C19.9502 12.1798 19.9402 12.3298 19.9302 12.4798L21.4502 13.6698C22.0102 14.1198 22.1702 14.8998 21.8202 15.5298L19.9602 18.7498C19.6202 19.3698 18.8502 19.6498 18.1602 19.3798L16.3602 18.6598C16.1002 18.8298 15.8402 18.9798 15.5802 19.1198L15.3102 21.0298ZM10.6202 20.2498H13.3802L13.7502 17.6998L14.2802 17.4798C14.7202 17.2998 15.1602 17.0398 15.6202 16.6998L16.0702 16.3598L18.4502 17.3198L19.8302 14.9198L17.8002 13.3398L17.8702 12.7798L17.8733 12.7528C17.9023 12.5025 17.9302 12.2604 17.9302 11.9998C17.9302 11.7298 17.9002 11.4698 17.8702 11.2198L17.8002 10.6598L19.8302 9.07977L18.4402 6.67977L16.0502 7.63977L15.6002 7.28977C15.1802 6.96977 14.7302 6.70977 14.2702 6.51977L13.7502 6.29977L13.3802 3.74977H10.6202L10.2502 6.29977L9.72023 6.50977C9.28023 6.69977 8.84023 6.94977 8.38023 7.29977L7.93023 7.62977L5.55023 6.67977L4.16023 9.06977L6.19023 10.6498L6.12023 11.2098C6.09023 11.4698 6.06023 11.7398 6.06023 11.9998C6.06023 12.2598 6.08023 12.5298 6.12023 12.7798L6.19023 13.3398L4.16023 14.9198L5.54023 17.3198L7.93023 16.3598L8.38023 16.7098C8.81023 17.0398 9.24023 17.2898 9.71023 17.4798L10.2402 17.6998L10.6202 20.2498ZM15.5002 11.9998C15.5002 13.9328 13.9332 15.4998 12.0002 15.4998C10.0672 15.4998 8.50023 13.9328 8.50023 11.9998C8.50023 10.0668 10.0672 8.49977 12.0002 8.49977C13.9332 8.49977 15.5002 10.0668 15.5002 11.9998Z"
                            fill="#151B2C" />
                        </svg>
                        <?php _e('Profile settings', 'ndp'); ?>
                      </a>
                      <div class="account__nav-mobile__logout">
                        <a href="#" class="profile-settings__modal-mob-confirm profile-settings__out--header">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                            <mask id="mask0_3627_20052" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0"
                              width="24" height="24">
                              <rect width="24" height="24" fill="#D9D9D9" />
                            </mask>
                            <g mask="url(#mask0_3627_20052)">
                              <path
                                d="M5 21C4.45 21 3.97917 20.8042 3.5875 20.4125C3.19583 20.0208 3 19.55 3 19V5C3 4.45 3.19583 3.97917 3.5875 3.5875C3.97917 3.19583 4.45 3 5 3H12V5H5V19H12V21H5ZM16 17L14.625 15.55L17.175 13H9V11H17.175L14.625 8.45L16 7L21 12L16 17Z"
                                fill="#8A90A5" />
                            </g>
                          </svg>
                          <?php _e('Log out', 'ndp'); ?>
                        </a>
                      </div>
                    </nav>
                  </div>
                <?php } ?>
              </div>

              <?php
              do_action('lifterlms_after_person_edit_account_form');
              ?>

              <div class="profile-settings__modal" id="modal__logout">
                <div class="profile-settings__modal-item">
                  <button class="profile-settings__modal-close"></button>
                  <h2 class="profile-settings__modal-title">
                    <?php _e('Log out of the account', 'ndp'); ?>
                  </h2>
                  <span class="profile-settings__modal-subtitle">
                    <?php _e('Are you sure you want to log out of your account?', 'ndp'); ?>
                  </span>
                  <div class="profile-settings__modal-buttons">
                    <button class="profile-settings__modal-cancel">
                      <?php _e('Cancel', 'ndp'); ?>
                    </button>
                    <a class="profile-settings__modal-confirm"
                      href="<?php echo wp_logout_url(llms_get_page_url('myaccount')); ?>">
                      <?php _e('Log out', 'ndp'); ?>
                    </a>
                  </div>
                </div>
              </div>

              <div class="profile-settings__modal" id="modal__language">
                <div class="profile-settings__modal-item">
                  <button class="profile-settings__modal-close"></button>
                  <svg width="80" height="80" viewBox="0 0 80 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="80" height="80" rx="40" fill="#EEF0FF" />
                    <path
                      d="M40.913 45H48.087M40.913 45L39 49M40.913 45L43.7783 39.009C44.0092 38.5263 44.1246 38.2849 44.2826 38.2086C44.4199 38.1423 44.5801 38.1423 44.7174 38.2086C44.8754 38.2849 44.9908 38.5263 45.2217 39.009L48.087 45M48.087 45L50 49M30 33H36M36 33H39.5M36 33V31M39.5 33H42M39.5 33C39.0039 35.9573 37.8526 38.6362 36.1655 40.8844M38 42C37.3875 41.7248 36.7626 41.3421 36.1655 40.8844M36.1655 40.8844C34.813 39.8478 33.6028 38.4266 33 37M36.1655 40.8844C34.5609 43.0229 32.4714 44.7718 30 46"
                      stroke="#2A59BD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <h2 class="profile-settings__modal-title">
                    <?php _e('This page is not available in English', 'ndp'); ?>
                  </h2>
                  <span class="profile-settings__modal-subtitle">
                    <?php _e('You can go to the main page in English or remain on the current page in Ukrainian', 'ndp'); ?>
                  </span>
                  <div class="profile-settings__modal-buttons">
                    <button class="profile-settings__modal-cancel">
                      <?php _e('Stay on current', 'ndp'); ?>
                    </button>
                    <a class="profile-settings__modal-confirm" href="/">
                      <?php _e('Go to main page', 'ndp'); ?>
                    </a>
                  </div>
                </div>
              </div>
              <?php
              $translatesArray = [
                'title_uk' => __('This page is not available in English', 'ndp'),
                'subtitle_uk' => __('You can go to the main page in English or remain on the current page in Ukrainian', 'ndp'),
                'title_en' => __('This page is not available in Ukrainian', 'ndp'),
                'subtitle_en' => __('You can go to the main page in Ukrainian or remain on the current page in English', 'ndp'),
              ];
              ?>
              <script>
                var translatesArray = <?php echo json_encode($translatesArray); ?>;
              </script>

            </div>
            <style>
              .initial {
                color: #2A59BD;
                background: #DCE2F9;
                padding: 15px;
                border-radius: 90px;
                text-transform: uppercase;
                font-weight: 600;
              }

              .notify_color {
                font-size: 11px;
                color: #FFFFFF;
                padding: 3px;
                background: #d63638;
                border: 3px solid white;
                position: absolute;
                width: 20px;
                height: 20px;
                border-radius: 100px;
                padding: 0;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-top: -35px;
                margin-left: 25px;
              }
            </style>
          </div>
        </div>
      </div>
    </div>

  </header>
  <div class="header-block-line"></div>
  <!-- Main -->
  <main class="main">