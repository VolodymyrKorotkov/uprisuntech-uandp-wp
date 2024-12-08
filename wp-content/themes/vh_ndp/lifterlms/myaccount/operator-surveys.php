<?php
/**
 * Operator Survey account page
 */
?>

<?php

if (!current_user_can('read_requests') ) return;

$current_lang = apply_filters( 'wpml_current_language', 'uk' );

$rolesArray = [
    'administrator' => 'Administrator',
    'municipality' => 'Municipality',
    'student' => 'Registered users',
    'operator' => 'Operators',
    'engineer' => 'Engineers',
];
?>

<div class="account__content col-8">
  <nav class="breadcrumb">
      <?php yoast_breadcrumb(); ?>
  </nav>
  <h1 class="h1 mb-20"><?php _e('Surveys', 'ndp'); ?></h1>
  <?php
  $statuses = [
      'Active', 'Scheduled', 'Finished',
  ];
  ?>
  <div class="d-lg-flex justify-content-between align-items-center mb-20">
    <div class="acc-tabs__nav">
      <div class="acc-tabs__nav-btn active"><?php _e('Active', 'ndp'); ?></div>
      <div class="acc-tabs__nav-btn"><?php _e('Scheduled', 'ndp'); ?></div>
      <div class="acc-tabs__nav-btn"><?php _e('Finished', 'ndp'); ?></div>
    </div>
    <a href="<?php echo wp_logout_url(llms_get_page_url('myaccount').'?lang='.$current_lang.'&survey=create'); ?>" target="_blank" class="btn btn-lightblue btn-flex d-none d-lg-inline-flex">
      <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M11.25 3V1.5M11.25 12V10.5M6 6.75H7.5M15 6.75H16.5M13.35 8.85L14.25 9.75M13.35 4.65L14.25 3.75M2.25 15.75L9 9M9.15 4.65L8.25 3.75"
                stroke="#151B2C" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
      </svg>
      <span><?php _e('Create Survey', 'ndp'); ?></span>
    </a>
  </div>
  <div class="acc-tabs__content">
    <?php
    foreach ($statuses as $status):
    ?>
    <div class="acc-tabs__content-item">
      <div class="acc-box acc-box--indent">
        <div class="acc-table-scroll-y">
          <div class="acc-table-scroll-x">
            <table class="acc-table">
              <tr>
                <th><?php _e('Survey', 'ndp'); ?></th>
                <th><?php _e('Title', 'ndp'); ?></th>
                <th><?php _e('Start', 'ndp'); ?></th>
                <th><?php _e('Ends', 'ndp'); ?></th>
                <th><?php _e('Responses', 'ndp'); ?></th>
                <th><?php _e('User group', 'ndp'); ?></th>
              </tr>
              <?php
              $paged = 1;
              $meta_query = [];
              $args = array(
                  'post_type'      => 'course',
                  'posts_per_page' => get_option( 'lifterlms_shop_courses_per_page', 10 ),       // получить все опросы
                  'post_status'    => 'publish',
                  'paged' => $paged,
              );
              $meta_query[] = [//survey
                  'key' => 'type',
                  'value' => 1,
                  'compare' => '='
              ];
              $today = date('Ymd');
              if ($status == 'Active') {
                  $meta_query[] = [
                      'key' => 'survey_start_date',
                      'value' => $today, // Lowest date value
                      'compare' => '<=',
                  ];
                  $meta_query[] = [
                      'key' => 'survey_finish_date',
                      'value' => $today, // Highest date value
                      'compare' => '>=',
                  ];
              } elseif ($status == 'Scheduled') {
                  $meta_query[] = [
                      'key' => 'survey_start_date',
                      'value' => $today,
                      'compare' => '>',
                  ];
              } elseif ($status == 'Finished') {
                  $meta_query[] = [
                      'key' => 'survey_finish_date',
                      'value' => $today,
                      'compare' => '<',
                  ];
              }

              $args['meta_query'] = $meta_query;

              // Создание нового WP_Query
              $surveys = new WP_Query( $args );

              foreach ($surveys->posts as $survey):
                  $allowed_users_roles = get_post_meta( $survey->ID, 'survey_user_roles', 1 );
                  if (!empty($allowed_users_roles)) {
                    $userRolesArray = explode(',', $allowed_users_roles);
                    foreach ($userRolesArray as $k => $role) {
                      if (!empty($rolesArray[$role])) {
                          $userRolesArray[$k] = $rolesArray[$role];
                      }
                    }
                    $allowed_users_roles = implode(',', $userRolesArray);
                  }
                  $startDate = get_field('survey_start_date', $survey->ID);
                  $finishDate = get_field('survey_finish_date', $survey->ID);

                  //количество завершённых опросов
                  $_survey = llms_get_post( $survey->ID );
                  $countCompleted = 0;
                  $enrolledUsers = $_survey->get_enrolled_students(1000, 0);
                  foreach ($enrolledUsers as $enrolledUser) {
                      $student = llms_get_student($enrolledUser);
                      $date = $student->get_completion_date($survey->ID, 'd.m.Y');
                      if ($date) {
                          $countCompleted++;
                      }
                  }
              ?>
              <tr data-id="<?php echo $survey->ID; ?>">
                <td class="blue-color semi">№<?php echo $survey->ID; ?></td>
                <td class="survey-title"><?php echo $survey->post_title; ?></td>
                <td class="start-date"><?php echo $startDate; ?></td>
                <td class="finish-date"><?php echo $finishDate; ?></td>
                <td><?php echo $countCompleted; ?></td>
                <td>
                  <div class="acc-table__nav">
                    <span class="survey-roles"><?php echo $allowed_users_roles; ?></span>
                    <button class="acc-table__nav-btn mdc-button">
                      <svg width="4" height="16" viewBox="0 0 4 16"
                           fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M2 4C3.1 4 4 3.1 4 2C4 0.9 3.1 0 2 0C0.9 0 0 0.9 0 2C0 3.1 0.9 4 2 4ZM2 6C0.9 6 0 6.9 0 8C0 9.1 0.9 10 2 10C3.1 10 4 9.1 4 8C4 6.9 3.1 6 2 6ZM0 14C0 12.9 0.9 12 2 12C3.1 12 4 12.9 4 14C4 15.1 3.1 16 2 16C0.9 16 0 15.1 0 14Z"
                              fill="#45464F"></path>
                      </svg>
                    </button>
                    <div class="mdc-menu-surface--anchor mdc-menu--custom">
                      <div class="mdc-menu mdc-menu-surface">
                        <ul class="mdc-list">
                          <li class="mdc-list-item">
                            <a href="<?php echo get_the_permalink($survey->ID); ?>">
                                <?php _e('See the survey', 'ndp'); ?>
                            </a>
                          </li>
                          <?php if ($status == 'Scheduled'): ?>
                          <li class="mdc-list-item">
                              <a href="#" data-izimodal-open="#modalLaunch" class="btn-izimodal"><?php _e('Launch survey right now', 'ndp'); ?></a>
                          </li>
                          <?php endif; ?>
                          <?php if ($status == 'Active'): ?>
                          <li class="mdc-list-item">
                            <a href="#" data-izimodal-open="#modalFinish" class="btn-izimodal"><?php _e('Finish survey right now', 'ndp'); ?></a>
                          </li>
                          <?php endif; ?>
                          <li class="mdc-list-item">
                            <a href="#" data-izimodal-open="#modalSend"><?php _e('Send notifications', 'ndp'); ?></a>
                          </li>
                          <?php if ($status == 'Finished'): ?>
                          <li class="mdc-list-item btn-collect-data">
                              <?php _e('Collect the data', 'ndp'); ?>
                          </li>
                          <?php endif; ?>
                        </ul>
                      </div>
                    </div>
                  </div>
                </td>
              </tr>
              <?php endforeach; ?>
            </table>
          </div>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <a href="<?php echo wp_logout_url(llms_get_page_url('myaccount').'?lang='.$current_lang.'&survey'); ?>" data-izimodal-open="#modalSend"
     class="mt-3 btn btn-lightblue btn-flex d-lg-none w100">
    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
         xmlns="http://www.w3.org/2000/svg">
      <path
              d="M11.25 3V1.5M11.25 12V10.5M6 6.75H7.5M15 6.75H16.5M13.35 8.85L14.25 9.75M13.35 4.65L14.25 3.75M2.25 15.75L9 9M9.15 4.65L8.25 3.75"
              stroke="#151B2C" stroke-width="2" stroke-linecap="round"
              stroke-linejoin="round" />
    </svg>
    <span><?php _e('Create Survey', 'ndp'); ?></span>
  </a>
</div>


<!-- MODAL -->
<div class="c-modal c-modal-medium iziModal" id="modalLaunch">
  <button type="button" data-iziModal-close class="c-modal__close">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
              d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
              fill="#919094" />
    </svg>
  </button>
  <div class="c-modal__wrap">
    <div class="c-modal__header">
      <h2 class="h2"><?php _e('Launch survey right now','ndp'); ?></h2>
      <p><?php _e('Are you sure you want to launch the survey?','ndp'); ?></p>
    </div>
    <div class="c-modal__nav">
      <button type="button" class="btn btn-outline-primary" data-iziModal-close><?php _e('Cancel', 'ndp'); ?></button>
      <button class="btn btn_bg_primary btn-launch-survey"><?php _e('Launch', 'ndp'); ?></button>
    </div>
  </div>
</div>

<div class="c-modal c-modal-medium iziModal" id="modalFinish">
  <button type="button" data-iziModal-close class="c-modal__close">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
              d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
              fill="#919094" />
    </svg>
  </button>
  <div class="c-modal__wrap">
    <div class="c-modal__header">
      <h2 class="h2"><?php _e('Finish survey right now','ndp'); ?></h2>
      <p><?php _e('Are you sure you want to finish the survey?','ndp'); ?></p>
    </div>
    <div class="c-modal__nav">
      <button type="button" class="btn btn-outline-primary" data-iziModal-close><?php _e('Cancel', 'ndp'); ?></button>
      <button class="btn btn_bg_primary btn-finish-survey"><?php _e('Finish', 'ndp'); ?></button>
    </div>
  </div>
</div>

<div class="c-modal c-modal-medium iziModal" id="modalSend">
  <button type="button" data-iziModal-close class="c-modal__close">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
              d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
              fill="#919094" />
    </svg>
  </button>
  <div class="c-modal__wrap">
    <div class="c-modal__header">
      <h2 class="h2">Send notification with a reminder about the survey</h2>
      <p>The notification will be sent to the user group Municipality, Government</p>
    </div>
    <form action="/" class="form mb-3">
      <div class="mdc-form-field">
        <div class="mdc-checkbox">
          <input type="checkbox" class="mdc-checkbox__native-control" id="checkbox-1" />
          <div class="mdc-checkbox__background">
            <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
              <path class="mdc-checkbox__checkmark-path" fill="none"
                    d="M1.73,12.91 8.1,19.28 22.79,4.59" />
            </svg>
            <div class="mdc-checkbox__mixedmark"></div>
          </div>
          <div class="mdc-checkbox__ripple"></div>
          <div class="mdc-checkbox__focus-ring"></div>
        </div>
        <label for="checkbox-1">Send also to the Emails</label>
      </div>
    </form>
    <div class="c-modal__nav">
      <button type="button" class="btn btn-outline-primary" data-iziModal-close>Cancel</button>
      <button class="btn btn_bg_primary">Send</button>
    </div>
  </div>
</div>

<div class="fixed-alert hidden">
    <div class="fixed-alert__text"></div>
    <div class="fixed-alert__close">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                    d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
                    fill="#F2F0F4" />
        </svg>
    </div>
</div>