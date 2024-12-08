<?php
/**
 * Municipality account page
 */
?>

<?php
$user = wp_get_current_user();
$user_id = $user->ID;
$isRepresentative = false;
$representative = representative_of_municipality($user_id);
$municipalityAdd = add_representative_of_municipality();//ещё не одобренная оператором заявка

if (!empty($representative) || $municipalityAdd) {
    $isRepresentative = true;
}

llms_get_template(
    'myaccount/dashboard-sidebar.php',
);
if (!$isRepresentative || current_user_can('read_requests')) return;


if ($municipalityAdd): ?>
    <?php
    require get_template_directory() . '/lifterlms/myaccount/view-add-municipality.php';
    ?>
<?php else: ?>

    <?php
    $representative = $representative[0];
    $isInvited = false;
    if ($invitedUser = get_invited_representatives('', $user->user_email)) {
        $invitedUser = $invitedUser[0];
        $isInvited = true;
    }

    if ($municipality = head_of_municipality(null, (int)$representative['municipality_id'])) {
        $municipality = $municipality[0];
    }
    if (empty($municipality)) return;

    $municipality_id = (int)$municipality['id'];
    $head_user_id = (int)$municipality['head_user'];
    $head_user = get_userdata($head_user_id);
    $isHead = $head_user_id == $user_id;
    $job = get_data_from_table('users_job_title', [
        'where' => " WHERE `id`='{$representative['position_id']}'",
    ]);
    $job = !empty($job)? (array)$job[0] : '';

    $current_lang = apply_filters( 'wpml_current_language', 'uk' );

    global $wpdb;
    ?>

<script>
    let $tinInput;
    let $emailInput;

</script>
  <div class="account__content col-8" data-municipality_id="<?php echo $municipality_id; ?>">
    <nav class="breadcrumb">
        <?php yoast_breadcrumb(); ?>
    </nav>
    <div class="d-md-flex justify-content-between align-items-center mb-32">
      <h1 class="h1"><?php _e('Municipality', 'ndp'); ?></h1>
      <a href="#" data-izimodal-open="#modalSend"
         class="btn btn-lightblue btn-flex d-none d-md-inline-flex">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
             xmlns="http://www.w3.org/2000/svg">
          <path
                  d="M15 3H3C2.175 3 1.5075 3.675 1.5075 4.5L1.5 13.5C1.5 14.325 2.175 15 3 15H15C15.825 15 16.5 14.325 16.5 13.5V4.5C16.5 3.675 15.825 3 15 3ZM15 13.5H3V6L9 9.75L15 6V13.5ZM9 8.25L3 4.5H15L9 8.25Z"
                  fill="#151B2C" />
        </svg>
        <span><?php _e('Send a message', 'ndp'); ?></span>
      </a>
    </div>
    <div class="acc-header mb-12">
      <h3 class="h3"><?php _e('Representative details', 'ndp'); ?></h3>
      <div class="acc-verify">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
             xmlns="http://www.w3.org/2000/svg">
          <path d="M5 13L9 17L19 7" stroke="#8A90A5" stroke-width="2"
                stroke-linecap="round" stroke-linejoin="round" />
        </svg>
        <span><?php _e('Checked', 'ndp'); ?></span>
      </div>
    </div>
    <div class="acc-box">
      <div class="acc-data">
        <div class="acc-data__row">
            <?php
            $organization = get_user_meta($head_user_id, 'user_organization', true);
            $organization = $organization? $organization : '';
            ?>
          <div class="acc-data__name"><?php _e('Name of Municipality', 'ndp'); ?></div>
          <div class="acc-data__value"><?php echo $organization; ?></div>
        </div>
        <div class="acc-data__row">
            <?php
            $fullName = 'Full name';
            if ($current_lang == 'uk') {
                $fullName = 'Full name short';
            }
            ?>
          <div class="acc-data__name"><?php _e($fullName, 'ndp'); ?></div>
            <?php
            $last_name = $user->last_name;
            if (!$last_name && !empty($invitedUser) && !empty($invitedUser['last_name'])) {
                $last_name = $invitedUser['last_name'];
            }
            $first_name = $user->first_name;
            if (!$first_name && !empty($invitedUser) && !empty($invitedUser['first_name'])) {
                $first_name = $invitedUser['first_name'];
            }

            $middle_name = $user->middle_name;
            if (!$middle_name && !empty($invitedUser) && !empty($invitedUser['middle_name'])) {
                $middle_name = $invitedUser['middle_name'];
            }

            ?>
          <div class="acc-data__value"><?php echo $last_name . ' ' . $first_name. " ".$middle_name; ?></div>
        </div>
        <div class="acc-data__row">
          <div class="acc-data__name"><?php _e('Job Title', 'ndp'); ?></div>
          <div class="acc-data__value"><?php _e($job['position'], 'ndp'); ?></div>
        </div>
          <?php
          /**
           * ЕДР ПОУ == edrpou_code
           * ИНН == edrpouCode
           */
          $edr = $municipality['edr'];
          $edrpou_code = get_user_meta($user->ID, 'edrpou_code', true);
          if ($edrpou_code) {
              $edr = $edrpou_code;
          }
          if (!empty($edr)): ?>
            <div class="acc-data__row">
              <div class="acc-data__name"><?php _e('edrpou', 'ndp'); ?></div>
              <div class="acc-data__value"><?php echo $edr; ?></div>
            </div>
          <?php endif; ?>
      </div>
    </div>

    <div class="acc-header mb-12">
      <h3 class="h3"><?php _e('Applications', 'ndp'); ?></h3>
        <?php
        $appLink = '/';
        if ($current_lang != 'uk') {
            $appLink .= $current_lang . '/';
        }
        $appLink .= 'create-application';
        ?>
      <a href="<?php echo $appLink; ?>" class="btn btn-outline-link btn-flex"><?php _e('Create application', 'ndp'); ?>
        <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18"
             fill="none">
          <path
                  d="M9.5 3L8.4425 4.0575L12.6275 8.25H3.5V9.75H12.6275L8.4425 13.9425L9.5 15L15.5 9L9.5 3Z"
                  fill="#2A59BD"></path>
        </svg>
      </a>
    </div>
      <?php
      $table_name = $wpdb->prefix . 'applications';
      $email = $user->user_email;
      $query = $wpdb->prepare("SELECT * FROM {$table_name} WHERE  `municipality_id` = %d ORDER BY id DESC", $municipality_id);
      $applications = $wpdb->get_results($query);
      ?>
    <?php if (empty($applications)): ?>
      <div class="acc-box acc-box--empty">
        <span><?php _e('No applications from the organization', 'ndp'); ?></span>
      </div>
    <?php else: ?>
    <div class="acc-box acc-box--indent">
      <div class="acc-table-scroll-y">
        <div class="acc-table-scroll-x">
          <table class="acc-table acc-table--data">
            <tr>
              <th><?php _e('Application', 'ndp'); ?></th>
              <th><?php _e('Status', 'ndp'); ?></th>
              <th><?php _e('Amount', 'ndp'); ?></th>
              <th class="text-right"><?php _e('Action', 'ndp'); ?></th>
            </tr>
              <?php foreach ($applications as $application) : ?>
                <tr>
                  <td class="blue-color semi">№<?php echo $application->id; ?></td>
                    <?php
                    $appStatus = mb_ucfirst(__($application->status, 'ndp'));
                    ?>
                  <td><?php echo $appStatus; ?></td>
                    <?php
                    $amount = '0';
                    if (!empty($application->amount) && $application->amount != '0') {
                        $amount = number_format($application->amount, 2);
                    }
                    if (!empty($application->currency_code)) {
                        $amount = $amount . ' '. __($application->currency_code, 'ndp');
                    }
//                    if (!$amount) {
//                        $amount = __('Amount N/A', 'ndp');
//                    }
                    ?>
                  <td><?php echo $application->amount ? number_format($application->amount, 2) . ' '. __($application->currency_code, 'ndp') : __('Amount N/A', 'ndp'); ?></td>
                  <td>
                    <div class="acc-table__nav justify-content-end">
                      <!-- <button class="acc-table__nav-btn">
                        <svg width="16" height="20" viewBox="0 0 16 20" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                          <path
                                  d="M0 17V15H2V8C2 6.61667 2.41667 5.3875 3.25 4.3125C4.08333 3.2375 5.16667 2.53333 6.5 2.2V1.5C6.5 1.08333 6.64583 0.729167 6.9375 0.4375C7.22917 0.145833 7.58333 0 8 0C8.41667 0 8.77083 0.145833 9.0625 0.4375C9.35417 0.729167 9.5 1.08333 9.5 1.5V2.2C10.8333 2.53333 11.9167 3.2375 12.75 4.3125C13.5833 5.3875 14 6.61667 14 8V15H16V17H0ZM8 20C7.45 20 6.97917 19.8042 6.5875 19.4125C6.19583 19.0208 6 18.55 6 18H10C10 18.55 9.80417 19.0208 9.4125 19.4125C9.02083 19.8042 8.55 20 8 20ZM4 15H12V8C12 6.9 11.6083 5.95833 10.825 5.175C10.0417 4.39167 9.1 4 8 4C6.9 4 5.95833 4.39167 5.175 5.175C4.39167 5.95833 4 6.9 4 8V15Z"
                                  fill="#1C1B1F" />
                        </svg>
                      </button> -->
                        <?php
                        $current_language = apply_filters('wpml_current_language', NULL);
                        if($current_language=="en"){
                            $link = "/en/create-application/?id=$application->id";
                        }else{
                            $link = "/create-application/?id=$application->id";
                        }
                        ?>
                      <button class="acc-table__nav-btn" onclick="window.location.href='<?php echo $link; ?>'">
                        <svg width="8" height="12" viewBox="0 0 8 12" fill="none"
                             xmlns="http://www.w3.org/2000/svg">
                          <path
                                  d="M5.05001 6L0.325012 1.275L1.60001 0L7.60001 6L1.60001 12L0.325012 10.725L5.05001 6Z"
                                  fill="black" />
                        </svg>
                      </button>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
          </table>
        </div>
      </div>
    </div>
    <?php endif; ?>

      <?php
      $paged = 1;
      $meta_query = [];
      $surveysArray = [];
      $statuses = [
          'Active', 'Finished',
      ];
      $args = array(
          'post_type'      => 'course',
          'posts_per_page' => get_option( 'lifterlms_shop_courses_per_page', 10 ),
          'post_status'    => 'publish',
          'paged' => $paged,
      );
      $meta_query[] = [//survey
          'key' => 'type',
          'value' => 1,
          'compare' => '='
      ];
      $today = date('Ymd');
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
      $meta_query[] = [
          'key' => 'survey_user_roles',
          'value' => 'municipality',
          'compare' => 'LIKE',
      ];
      $args['meta_query'] = $meta_query;
      $surveys = new WP_Query( $args );
      $artiveSurveys = $surveys->posts;


      //завершённые опросы муниципалитета
      $meta_query = [];
      $args = array(
          'post_type'      => 'course',
          'posts_per_page' => get_option( 'lifterlms_shop_courses_per_page', 10 ),
          'post_status'    => 'publish',
          'paged' => $paged,
      );
      $meta_query[] = [//survey
          'key' => 'type',
          'value' => 1,
          'compare' => '='
      ];
      $meta_query[] = [
          'key' => 'survey_finish_date',
          'value' => $today, // Lowest date value
          'compare' => '<',
      ];
      $meta_query[] = [
          'key' => 'survey_user_roles',
          'value' => 'municipality',
          'compare' => 'LIKE',
      ];
      $args['meta_query'] = $meta_query;
      $surveys = new WP_Query( $args );
      $finishedSurveys = $surveys->posts;

      if (!empty($artiveSurveys) || !empty($finishedSurveys)): ?>
    <div class="acc-header mb-12">
      <h3 class="h3"><?php _e('Surveys', 'ndp'); ?></h3>
      <div class="acc-tabs__nav">
        <div class="acc-tabs__nav-btn active"><?php _e('Active', 'ndp'); ?></div>
        <div class="acc-tabs__nav-btn"><?php _e('Finished', 'ndp'); ?></div>
      </div>
    </div>
    <div class="acc-tabs__content mb-4">
        <?php
        foreach ($statuses as $status): ?>
          <div class="acc-tabs__content-item">
            <div class="acc-box acc-box--indent">
              <div class="acc-table-scroll-y">
                <div class="acc-table-scroll-x">
                  <table class="acc-table acc-table--survey">
                    <tr>

                      <th style="min-width: 250px"><?php _e('Title', 'ndp'); ?></th>
                      <th><?php _e('Start', 'ndp'); ?></th>
                      <th><?php _e('Ends', 'ndp'); ?></th>
                      <th><?php _e('Responses', 'ndp'); ?></th>
                    </tr>
                      <?php
                      if ($status == 'Active') {
                          $surveys = $artiveSurveys;
                      } elseif ($status == 'Finished') {
                          $surveys = $finishedSurveys;
                      }

                      foreach ($surveys as $survey):
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

                          <td class="survey-title"><?php echo $survey->post_title; ?></td>
                          <td class="start-date"><?php echo $startDate; ?></td>
                          <td class="finish-date"><?php echo $finishDate; ?></td>
                          <td>
                            <div class="acc-table__nav">
                            <span><?php echo $countCompleted; ?></span>
                              <button class="acc-table__nav-btn mdc-button">
                                  <svg width="4" height="16" viewBox="0 0 4 16"
                                       fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M2 4C3.1 4 4 3.1 4 2C4 0.9 3.1 0 2 0C0.9 0 0 0.9 0 2C0 3.1 0.9 4 2 4ZM2 6C0.9 6 0 6.9 0 8C0 9.1 0.9 10 2 10C3.1 10 4 9.1 4 8C4 6.9 3.1 6 2 6ZM0 14C0 12.9 0.9 12 2 12C3.1 12 4 12.9 4 14C4 15.1 3.1 16 2 16C0.9 16 0 15.1 0 14Z"
                                          fill="#45464F" />
                                  </svg>
                                </button>
                              <div class="mdc-menu-surface--anchor mdc-menu--custom">
                                <div class="mdc-menu mdc-menu-surface">
                                  <ul class="mdc-list">
                                    <?php if ($status == 'Active'): ?>
                                    <li class="mdc-list-item">
                                        <a href="<?php echo get_permalink($survey->ID); ?>"><?php _e('Take the survey', 'ndp'); ?></a>
                                    </li>
                                    <?php elseif ($status == 'Finished'): ?>
                                    <li class="mdc-list-item">
                                        <a href="<?php echo get_permalink($survey->ID); ?>"><?php _e('View responses', 'ndp'); ?></a>
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
    <?php endif; ?>

    <div class="acc-header mb-12">
      <h3 class="h3"><?php _e('Registered representatives', 'ndp'); ?></h3>
        <?php if ($isHead): ?>
          <a href="#" data-izimodal-open="#modalInvite" class="btn btn-outline-link btn-flex"><?php _e('Send invite', 'ndp'); ?>
            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18"
                 fill="none">
              <path
                      d="M9.5 3L8.4425 4.0575L12.6275 8.25H3.5V9.75H12.6275L8.4425 13.9425L9.5 15L15.5 9L9.5 3Z"
                      fill="#2A59BD"></path>
            </svg>
          </a>
        <?php endif; ?>
    </div>
    <?php
    //уже одобренные оператором представители муниципалитета
    $representatives = representatives_of_municipality_all_data($head_user_id, [
        'municipality_id' => $municipality['id'],
//              'limit' => 10,
    ]);
    wp_cache_set('representatives_'.$municipality_id, $representatives);

    $invitedRepresentatives = get_invited_representatives($head_user->user_email);
    wp_cache_set('invitedNotRegistered_'.$municipality_id, $invitedRepresentatives);
    foreach ($invitedRepresentatives as $key => $invitedRepresentative) {
        $k = array_search($invitedRepresentative['user_email'], array_column($representatives, 'user_email'));
        if ($k || $invitedRepresentative['user_email'] == $email && $isRepresentative || (isset($invitedRepresentative['invited']) && !$invitedRepresentative['invited'])) {
            unset($invitedRepresentatives[$key]);
        }
    }
    $representatives = array_merge($representatives, $invitedRepresentatives);

    //$representatives первый элемент массива текущий пользователь
    if (empty($invitedRepresentatives) AND (count($representatives)==1)): ?>
    <div class="acc-box acc-box-invited acc-box--indent acc-box--empty">
      <span class="no-registered"><?php _e('No registered representatives', 'ndp'); ?></span>
      <div class="acc-table-scroll-y hidden">
        <div class="acc-table-scroll-x">
          <table class="acc-table acc-table--registr">
            <tr>
              <th><?php _e($fullName, 'ndp'); ?></th>
              <th><?php _e('Job Title', 'ndp'); ?></th>
              <th><?php _e('Email', 'ndp'); ?></th>
              <th><?php _e('Phone', 'ndp'); ?></th>
            </tr>
          </table>
        </div>
      </div>
    </div>
    <?php else: ?>
    <div class="acc-box acc-box-invited acc-box--indent">
      <div class="acc-table-scroll-y">
        <div class="acc-table-scroll-x">
          <table class="acc-table acc-table--registr">
            <tr>
              <th><?php _e($fullName, 'ndp'); ?></th>
              <th><?php _e('Job Title', 'ndp'); ?></th>
              <th><?php _e('Email', 'ndp'); ?></th>
              <th><?php _e('Phone', 'ndp'); ?></th>
            </tr>
              <?php foreach ($representatives as $represent): ?>
                  <?php if ($represent['user_id'] == $municipality['head_user']) continue; ?>
                  <?php get_template_part('templates/tr-municipality', '', [
                      'represent' => $represent,
                      'isHead' => $isHead,
                      'municipality_id' => $municipality['id'],
                  ]); ?>
              <?php endforeach; ?>
          </table>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <a href="#" class="btn btn-lightblue d-inline-flex d-md-none btn-flex btn_full_mob">
      <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
           xmlns="http://www.w3.org/2000/svg">
        <path
                d="M15 3H3C2.175 3 1.5075 3.675 1.5075 4.5L1.5 13.5C1.5 14.325 2.175 15 3 15H15C15.825 15 16.5 14.325 16.5 13.5V4.5C16.5 3.675 15.825 3 15 3ZM15 13.5H3V6L9 9.75L15 6V13.5ZM9 8.25L3 4.5H15L9 8.25Z"
                fill="#151B2C" />
      </svg>
      <span><?php _e('Send a message', 'ndp'); ?></span>
    </a>
  </div>


  <!-- MODAL -->

  <div class="c-modal c-modal-medium iziModal" id="modalInvite">

    <button type="button" data-iziModal-close class="c-modal__close">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
                d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
                fill="#919094" />
      </svg>
    </button>
    <div class="c-modal__wrap">
      <div class="c-modal__header">
        <h2 class="h2"><?php _e('Invite another representative', 'ndp'); ?></h2>
        <p><?php _e('A link will be sent to the representative by email', 'ndp'); ?></p>
      </div>
      <form action="" class="c-modal__form form-invitation">
        <div class="c-modal__row">
          <label class="mdc-text-field mdc--full mdc-text-field--outlined">
            <span class="mdc-notched-outline">
              <span class="mdc-notched-outline__leading"></span>
              <span class="mdc-notched-outline__notch">
                <span class="mdc-floating-label mdc-floating-label-tin" data-title="<?php _e('Need 6 or 9 digits for TIN', 'ndp'); ?>"><span><?php _e('TIN', 'ndp'); ?></span></span>
              </span>
              <span class="mdc-notched-outline__trailing"></span>
            </span>
            <input type="text" class="mdc-text-field__input field__input--invite field__input--invite-tin" required>
          </label>

          <p class="error error-tin"><?php _e('Need 10 digits for TIN', 'ndp'); ?></p>
          <p class="error error-tin-old"><?php _e('Need 6 or 9 digits for TIN', 'ndp'); ?></p>
          <p class="muni_error" style="display:none;"><?php _e('A user with this TIN is already linked to another organization', 'ndp'); ?></p>

          <label class="mdc-checkbox tin-checkbox full-width">
            <input type="checkbox" class="mdc-checkbox__native-control" id="not_have_tin" />

            <div class="mdc-checkbox__background">
              <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                <path class="mdc-checkbox__checkmark-path" fill="none" d="M1.73,12.91 8.1,19.28 22.79,4.59" />
              </svg>
              <div class="mdc-checkbox__mixedmark"></div>
            </div>
            <p><?php _e('A person does not have a TIN', 'ndp'); ?></p>
          </label>
        </div>
        <div class="c-modal__row">
          <label class="mdc-text-field mdc--full mdc-text-field--outlined">
              <span class="mdc-notched-outline">
                <span class="mdc-notched-outline__leading"></span>
                <span class="mdc-notched-outline__notch">
                  <span class="mdc-floating-label"><?php _e('Name', 'ndp'); ?></span>
                </span>
                <span class="mdc-notched-outline__trailing"></span>
              </span>
            <input type="text" class="mdc-text-field__input field__input--invite field__input--invite-name" required>
          </label>
          <p class="error error-name"><?php _e('Enter your name', 'ndp'); ?></p>
        </div>
        <div class="c-modal__row">
          <div class="acc-form__row">
            <div class="mdc-select mdc-select--outlined mdc--full">
              <div class="mdc-select__anchor">
              <span class="mdc-notched-outline">
                <span class="mdc-notched-outline__leading"></span>
                <span class="mdc-notched-outline__notch">
                  <span class="mdc-floating-label"><?php _e('Job title', 'ndp'); ?></span>
                </span>
                <span class="mdc-notched-outline__trailing"></span>
              </span>
                <span class="mdc-select__selected-text-container">
					<span class="mdc-select__selected-text field__input--invite job-text"></span>
				</span>
                <span class="mdc-select__dropdown-icon">
                    <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5"
                         focusable="false">
                        <polygon class="mdc-select__dropdown-icon-inactive"
                                 stroke="none" fill-rule="evenodd"
                                 points="7 10 12 15 17 10">
                        </polygon>
                        <polygon class="mdc-select__dropdown-icon-active" stroke="none"
                                 fill-rule="evenodd" points="7 15 12 10 17 15">
                        </polygon>
                    </svg>
                </span>
              </div>
              <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu-surface--fullwidth">
                <ul class="mdc-deprecated-list">
                    <?php
                    $jobs = get_data_from_table('users_job_title', [
                        'where' => " WHERE `position`<>'Head of municipality'",
                    ]);
                    foreach ($jobs as $job): ?>
                      <li class="mdc-deprecated-list-item item-text-position" data-value="grains">
                        <span class="mdc-deprecated-list-item__ripple"></span>
                        <span class="mdc-deprecated-list-item__text" data-position="<?php echo $job->position; ?>"><?php _e($job->position, 'ndp'); ?></span>
                      </li>
                    <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="c-modal__row">
          <label class="mdc-text-field mdc--full mdc-text-field--outlined">
          <span class="mdc-notched-outline">
            <span class="mdc-notched-outline__leading"></span>
            <span class="mdc-notched-outline__notch">
              <span class="mdc-floating-label"><?php _e('Phone', 'ndp'); ?></span>
            </span>
            <span class="mdc-notched-outline__trailing"></span>
          </span>
            <input type="text" class="mdc-text-field__input field__input--invite field__input--invite-phone phone-input" required>
          </label>
        </div>
        <div class="c-modal__row" style="position: relative">
          <label class="mdc-text-field mdc--full mdc-text-field--outlined mdc-text-field--with-trailing-icon">
          <span class="mdc-notched-outline">
            <span class="mdc-notched-outline__leading"></span>
            <span class="mdc-notched-outline__notch">
              <span class="email_label mdc-floating-label"><?php _e('Email to send a link', 'ndp'); ?> </span>
            </span>
              <span class="mdc-notched-outline__trailing"></span>
          </span>
            <input type="email" class="mdc-text-field__input field__input--invite field__input--invite-email" required>
            <i class="mdc-text-field__icon">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                   xmlns="http://www.w3.org/2000/svg">
                <path
                        d="M20 4H4C2.9 4 2.01 4.9 2.01 6L2 18C2 19.1 2.9 20 4 20H20C21.1 20 22 19.1 22 18V6C22 4.9 21.1 4 20 4ZM20 18H4V8L12 13L20 8V18ZM12 11L4 6H20L12 11Z"
                        fill="#45464F" />
              </svg>
            </i>

          </label>
          <p class="text_grey" style="display:none;"><?php _e('This email was filled in automatically because a user with this Tax Identification Number (TIN) is already registered.','ndp'); ?></p>
          <p id="email-error-message" class="error"><?php _e('Wrong email', 'ndp'); ?></p>
        </div>
        <div class="c-modal__nav">
          <button type="button" class="btn btn-outline-primary" data-iziModal-close><?php _e('Cancel', 'ndp'); ?></button>
          <button class="btn btn_bg_primary btn-send-invite disabled"><?php _e('Send invite', 'ndp'); ?></button>
        </div>
      </form>
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
        <h2 class="h2"><?php _e('Send a message', 'ndp'); ?></h2>
      </div>
      <form action="" class="c-modal__form">
        <div class="c-modal__row">
          <label class="mdc-text-field mdc--full mdc-text-field--outlined mdc-text-field--textarea">
          <span class="mdc-notched-outline">
            <span class="mdc-notched-outline__leading"></span>
            <span class="mdc-notched-outline__notch">
              <span class="mdc-floating-label"><?php _e('Message text', 'ndp'); ?></span>
            </span>
            <span class="mdc-notched-outline__trailing"></span>
          </span>
            <span class="mdc-text-field__resizer">
            <textarea class="mdc-text-field__input textarea-admin"></textarea>
          </span>
          </label>
        </div>
        <div class="c-modal__nav">
          <button type="button" class="btn btn-outline-primary" data-iziModal-close><?php _e('Cancel', 'ndp'); ?></button>
          <button class="btn btn_bg_primary btn-send-admin-message"><?php _e('Send', 'ndp'); ?></button>
        </div>
      </form>
    </div>
  </div>

  <div class="c-modal c-modal-medium iziModal" id="modalJob">
    <button type="button" data-iziModal-close class="c-modal__close">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
                d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
                fill="#919094" />
      </svg>
    </button>
    <div class="c-modal__wrap">
      <div class="c-modal__header">
        <h2 class="h2"><?php _e('Change job title', 'ndp'); ?></h2>
        <p><?php _e('Select a new job title of municipal representative', 'ndp'); ?></p>
      </div>
      <form action="" class="c-modal__form">
        <div class="c-modal__row">
          <div class="acc-form__row">
            <div class="mdc-select mdc-select--outlined mdc--full">
              <div class="mdc-select__anchor">
              <span class="mdc-notched-outline">
                <span class="mdc-notched-outline__leading"></span>
                <span class="mdc-notched-outline__notch">
                  <span class="mdc-floating-label"><?php _e('Job title', 'ndp'); ?></span>
                </span>
                <span class="mdc-notched-outline__trailing"></span>
              </span>
                <span class="mdc-select__selected-text-container">
					<span class="mdc-select__selected-text change-job-text"></span>
				</span>
                <span class="mdc-select__dropdown-icon">
                    <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5"
                         focusable="false">
                        <polygon class="mdc-select__dropdown-icon-inactive"
                                 stroke="none" fill-rule="evenodd"
                                 points="7 10 12 15 17 10">
                        </polygon>
                        <polygon class="mdc-select__dropdown-icon-active" stroke="none"
                                 fill-rule="evenodd" points="7 15 12 10 17 15">
                        </polygon>
                    </svg>
                </span>
              </div>
              <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu-surface--fullwidth">
                <ul class="mdc-deprecated-list">
                    <?php
                    foreach ($jobs as $job): ?>
                      <li class="mdc-deprecated-list-item" data-value="grains">
                        <span class="mdc-deprecated-list-item__ripple"></span>
                        <span class="mdc-deprecated-list-item__text"><?php _e($job->position) ?></span>
                      </li>
                    <?php endforeach; ?>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="c-modal__nav">
          <button type="button" class="btn btn-outline-primary" data-iziModal-close><?php _e('Cancel', 'ndp'); ?></button>
          <button class="btn btn_bg_primary btn-change-job"><?php _e('Save', 'ndp'); ?></button>
        </div>
      </form>
    </div>
  </div>

  <div class="c-modal c-modal-medium iziModal" id="modalRevoke">
    <button type="button" data-iziModal-close class="c-modal__close">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
                d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
                fill="#919094" />
      </svg>
    </button>
    <div class="c-modal__wrap">
      <div class="c-modal__header">
        <h2 class="h2"><?php _e('Revoke user invite?', 'ndp'); ?></h2>
        <p><?php _e('Are you sure you want to Revoke user invite?', 'ndp'); ?></p>
      </div>
      <div class="c-modal__nav">
        <button type="button" class="btn btn-outline-primary" data-iziModal-close><?php _e('Cancel', 'ndp'); ?></button>
        <button class="btn btn_bg_primary btn-revoke-invite"><?php _e('Revoke', 'ndp'); ?></button>
      </div>
    </div>
  </div>

  <div class="c-modal c-modal-medium iziModal" id="modalRemove">
    <button type="button" data-iziModal-close class="c-modal__close">
      <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
                d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
                fill="#919094" />
      </svg>
    </button>
    <div class="c-modal__wrap">
      <div class="c-modal__header">
        <h2 class="h2"><?php _e('Remove representative from the list?', 'ndp'); ?></h2>
        <p><?php _e('Are you sure you want to remove the representative from the list?', 'ndp'); ?></p>
      </div>
      <div class="c-modal__nav">
        <button type="button" class="btn btn-outline-primary" data-iziModal-close><?php _e('Cancel', 'ndp'); ?></button>
        <button class="btn btn_bg_primary btn-remove-user"><?php _e('Remove', 'ndp'); ?></button>
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

<?php endif; ?>

<script>
    $=jQuery;
    let init_modal = 0;
    let button_send_invite
    $(document).on('closing', '#modal', function (e) {
        //console.log('Modal is closing');
        $('.error').hide();

    });

    $(document).on('opening', '#modalInvite', function() {
        button_send_invite=$('.btn-send-invite');

        if(init_modal){
           return;
        }

        $('.field__input--invite-tin').on('input', function(e) {
            var cursorPosition = this.selectionStart; // Сохраняем текущую позицию курсора
            var originalLength = this.value.length; // Длина строки до изменения
            var value = $(this).val();

            // Удаляем все пробелы для чистой обработки ввода и повторно добавляем пробелы где нужно
            var newValue = value.replace(/\s+/g, '').replace(/([а-яА-Яa-zA-Z]{2})/g, '$1 ').trim();

            $(this).val(newValue);

            // Регулируем позицию курсора после изменения значения
            var newLength = newValue.length; // Длина строки после изменения
            if (originalLength < newLength) { // Если добавили пробел
                cursorPosition += newLength - originalLength;
            } else if (originalLength > newLength) { // Если удалили символ
                // Позиционирование курсора при удалении пробела требует индивидуальной логики
                cursorPosition -= originalLength - newLength - 1;
            }
            this.setSelectionRange(cursorPosition, cursorPosition);
        });



        // Установка обработчика событий ввода для текстового поля внутри модального окна
        $(document).on('input', ".field__input--invite-tin", function() {
            var inputValue = $(this).val().trim();
            var inputValue_checked = $(this).val();

            if($('#not_have_tin').prop('checked')){
                valid_length=9;
            }else{
                valid_length=10
            }

            if (inputValue_checked.length === valid_length) {
                $.ajax({
                    url: '/wp-admin/admin-ajax.php',
                    type: 'POST',
                    data: {
                        action: 'find_user_by_edrpou',
                        edrpouCode: inputValue
                    },
                    success: function(response) {
                        if (response.success && response.data.email) {
                            // Предполагается, что $emailInput уже определен в вашем коде
                            $('.field__input--invite-email').val(response.data.email).prop('disabled', true);
                            $('.text_grey').show();
                            button_send_invite.removeClass('disabled');
                            const foos = [].map.call(document.querySelectorAll('.mdc-text-field'), function (el) {
                                return new mdc.textField.MDCTextField(el);
                            });
                        }
                        if(response.data.error){
                            $('.muni_error').show();
                            button_send_invite.addClass('disabled');
                        }else{
                            $('.muni_error').hide();
                            $('#email-error-message').removeClass('show');
                            // button_send_invite.removeClass('disabled');
                        }
                    },
                    error: function() {
                        console.error('Ошибка запроса');
                    }
                });
            } else {
                // Очистка поля email и снятие блокировки, если значение изменяется
                $('.field__input--invite-email').val('').prop('disabled', false);
                $('.mdc-floating-label.mdc-floating-label--required').removeAttr('style');
                $('.text_grey').hide();
            }
        });
        init_modal= 1;
    });


</script>
<style>
    p.text_grey {
        font-family: Inter;
        font-size: 12px;
        font-style: normal;
        font-weight: 400;
        line-height: 16px;
        color: #b0b0b0;
    }/* 133.333% */
    p.muni_error {
        font-size: 12px;
        font-weight: 400;
        line-height: 16px;
        letter-spacing: 0;
        text-align: left;
        color: #BA1A1A;
        padding-left: 16px;
    }
</style>
