<?php
/**
 * Edit account
 */

$isLoggedIn = is_user_logged_in();
$current_user = wp_get_current_user();
$user_is_student = false;
$current_userID = null;
$courseProgress = 0;
$student = '';
if ($isLoggedIn) {
    $user = get_userdata($current_user->ID);
    $user_roles = $user->roles;
    $user_is_student = in_array( 'student', $user_roles, true );
    $current_userID = $current_user->ID;
    if ($user_is_student) {
        $student = new LLMS_Student($current_userID);
        $courseProgress = $student->get_progress(get_the_ID());
    }
}
$userData = (array)$current_user->data;
?>

<div class="account__content col-8">
  <section class="profile-settings">
    <nav class="breadcrumb">
        <div class="breadcrumb-block">

            <?php yoast_breadcrumb(); ?>

        </div>
    </nav>
    <h1 class="profile-settings__title">Profile settings</h1>
    <div class="profile-settings__block profile-settings__personalData">
      <h2 class="profile-settings__block-title">Personal data</h2>
      <div class="profile-settings__personalData-wrapper">
        <input type="text" id="firstName" class="profile-settings__personalData-input"
               placeholder="Enter your first name">
        <label for="firstName" class="profile-settings__personalData-label">First name</label>
      </div>
      <div class="profile-settings__personalData-wrapper">
        <input type="text" id="lastName" class="profile-settings__personalData-input"
               placeholder="Enter your last name">
        <label for="lastName" class="profile-settings__personalData-label">Last name</label>
      </div>
      <div class="profile-settings__personalData-birthday d-flex justify-content-between">
        <div class="profile-settings__personalData-wrapper">
          <input type="text" id="day" class="profile-settings__personalData-input" placeholder="XX">
          <label for="day" class="profile-settings__personalData-label">Day</label>
        </div>
        <div class="profile-settings__personalData-wrapper">
          <input type="text" id="month" class="profile-settings__personalData-input" placeholder="Select month">
          <label for="month" class="profile-settings__personalData-label">Month</label>
          <div class="profile-settings__personalData-image">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow-dropdown.svg" alt="arrow">
          </div>
          <ul class="profile-settings__personalData-list">
            <li class="profile-settings__personalData-list__item">January</li>
            <li class="profile-settings__personalData-list__item">February</li>
            <li class="profile-settings__personalData-list__item">March</li>
            <li class="profile-settings__personalData-list__item">April</li>
            <li class="profile-settings__personalData-list__item">May</li>
            <li class="profile-settings__personalData-list__item">June</li>
            <li class="profile-settings__personalData-list__item">July</li>
            <li class="profile-settings__personalData-list__item">August</li>
            <li class="profile-settings__personalData-list__item">September</li>
            <li class="profile-settings__personalData-list__item">October</li>
            <li class="profile-settings__personalData-list__item">November</li>
            <li class="profile-settings__personalData-list__item">December</li>
          </ul>
        </div>
        <div class="profile-settings__personalData-wrapper">
          <input type="text" id="year" class="profile-settings__personalData-input" placeholder="XXXX">
          <label for="year" class="profile-settings__personalData-label">Year</label>
        </div>
      </div>
      <div class="profile-settings__personalData-wrapper">
        <input type="text" id="gender" class="profile-settings__personalData-input" placeholder="Select gender">
        <label for="gender" class="profile-settings__personalData-label">Gender</label>
        <div class="profile-settings__personalData-image">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow-dropdown.svg" alt="arrow">
        </div>
        <ul class="profile-settings__personalData-list profile-settings__personalData-list__gender">
          <li class="profile-settings__personalData-list__item">Male</li>
          <li class="profile-settings__personalData-list__item">Female</li>
        </ul>
      </div>
      <div class="profile-settings__personalData-phone d-flex justify-content-between">
        <div class="profile-settings__personalData-wrapper col-3">
          <input type="text" id="country" class="profile-settings__personalData-input" placeholder="UA (+38)">
          <label for="country" class="profile-settings__personalData-label">Country</label>
          <div class="profile-settings__personalData-image">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow-dropdown.svg" alt="arrow">
          </div>
          <ul class="profile-settings__personalData-list">
            <li class="profile-settings__personalData-list__item profile-settings__personalData-list__item-current">
              UA (+38)
            </li>
            <li class="profile-settings__personalData-list__item">EN (+1)</li>
            <li class="profile-settings__personalData-list__item">FE (+33)</li>
            <li class="profile-settings__personalData-list__item">LT (+39)</li>
            <li class="profile-settings__personalData-list__item">ES (+34)</li>
            <li class="profile-settings__personalData-list__item">UK (+44)</li>
            <li class="profile-settings__personalData-list__item">UK (+44)</li>
            <li class="profile-settings__personalData-list__item">UK (+44)</li>
          </ul>
        </div>
        <div class="profile-settings__personalData-wrapper flex-grow-1">
          <input type="text" id="phone" class="profile-settings__personalData-input"
                 placeholder="(XXX) XXX XX XX">
          <label for="phone" class="profile-settings__personalData-label">Phone</label>
        </div>
      </div>
      <button class="profile-settings__personalData-button">Save</button>
    </div>
    <div class="profile-settings__block profile-settings__contacts">
      <h2 class="profile-settings__block-title profile-settings__contacts-title">Contacts</h2>
      <div class="profile-settings__contacts-item">
        <h3 class="profile-settings__contacts-name">Email</h3>
        <span class="profile-settings__contacts-value"><?php echo $userData['user_email']; ?></span>
        <button class="profile-settings__contacts-button">Edit</button>
      </div>
      <div class="profile-settings__contacts-item">
        <h3 class="profile-settings__contacts-name">Phone</h3>
        <span class="profile-settings__contacts-value profile-settings__nodata">No data available</span>
        <button class="profile-settings__contacts-button">Edit</button>
      </div>
    </div>
    <div class="profile-settings__block profile-settings__password">
      <h2 class="profile-settings__block-title profile-settings__password-title">Password</h2>
      <div class="profile-settings__password-item">
        <h3 class="profile-settings__password-name">********</h3>
        <span class="profile-settings__password-value">Last updated: 12 Sep 2023</span>
        <button class="profile-settings__password-button">Edit</button>
      </div>
    </div>
    <!-- <div class="profile-settings__block profile-settings__notifications">
      <h2 class="profile-settings__block-title profile-settings__notifications-title">Notifications</h2>
      <div class="profile-settings__notifications-item">
        <h3 class="profile-settings__notifications-name">System messages</h3>
        <div class="profile-settings__notifications-switch">
          <input type="checkbox" class="profile-settings__notifications-switch__input" id="messages">
          <label for="messages" class="profile-settings__notifications-switch__label"></label>
        </div>
      </div>
      <div class="profile-settings__notifications-item">
        <h3 class="profile-settings__notifications-name">News</h3>
        <div class="profile-settings__notifications-switch">
          <input type="checkbox" class="profile-settings__notifications-switch__input" id="news">
          <label for="news" class="profile-settings__notifications-switch__label"></label>
        </div>
      </div>
      <div class="profile-settings__notifications-item">
        <h3 class="profile-settings__notifications-name">Articles</h3>
        <div class="profile-settings__notifications-switch">
          <input type="checkbox" class="profile-settings__notifications-switch__input" id="articles">
          <label for="articles" class="profile-settings__notifications-switch__label"></label>
        </div>
      </div>
      <div class="profile-settings__notifications-item">
        <h3 class="profile-settings__notifications-name">Cases</h3>
        <div class="profile-settings__notifications-switch">
          <input type="checkbox" class="profile-settings__notifications-switch__input" id="cases">
          <label for="cases" class="profile-settings__notifications-switch__label"></label>
        </div>
      </div>
      <div class="profile-settings__notifications-item">
        <h3 class="profile-settings__notifications-name profile-settings__notifications-name__disable">New
          courses</h3>
        <div class="profile-settings__notifications-switch">
          <input type="checkbox"
                 class="profile-settings__notifications-switch__input profile-settings__notifications-switch__input-disable"
                 id="courses">
          <label for="courses"
                 class="profile-settings__notifications-switch__label profile-settings__notifications-switch__disable"></label>
        </div>
      </div>
    </div> -->
    <a class="llms-sd-link profile-settings__out"
       href="<?php echo wp_logout_url(llms_get_page_url('myaccount')); ?>"><?php _e('Log out', 'ndp'); ?></a>
  </section>
</div>
