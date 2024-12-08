<?php
/**
 * Account Edit Template / Form
 *
 * @since 1.0.0
 * @since 5.0.0 Utilize fields from LLMS_Forms.
 * @version 5.0.0
 */

defined( 'ABSPATH' ) || exit;

//llms_print_notices();

if (isset($_GET['password-change'])): ?>
    <?php
    require get_template_directory() . '/lifterlms/myaccount/password-change.php';
    ?>
<?php else:

$form_title  = llms_get_form_title( 'account' );
$form_fields = llms_get_form_html( 'account' );
    wp_localize_script('lifterlms-profile', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('update-email-nonce'),
    ));

$student = llms_get_student();
$user = $student->get('user');
$user_id = $user->ID;
$uuid = get_user_meta($user_id, 'uuid');
$refresh_token = get_user_meta($user_id, 'refresh_token');

$edrpou_code = get_user_meta($user_id, 'edrpou_code',true);
$TIN = get_user_meta($user_id, 'edrpouCode',true);


$municipality = head_of_municipality($user->ID);
$isHead = false;

if (!empty($municipality)) {
    $municipality = $municipality[0];
    if ((int)$municipality['head_user'] == (int)$user->ID) {
        $isHead = true;
    }
}

$viaDia = false;
if (!empty($uuid) || !empty($refresh_token)) {
    $viaDia = true;
}


$wpError = (array)llms()->session->get( 'llms_errors', array() ) ?? [];
llms()->session->set( 'llms_errors', array() );


function getErrorMessage(string $field, array $wpError) {
    if (empty($wpError['error_data']) || !$field) return false;

    $num = 0;
    $found = false;
    foreach ($wpError['error_data'] as $k => $errors) {
        foreach ($errors as $key => $error) {
            if (is_string($key) && !is_string($error)) {
                if ($field == $key) {
                    $found = true;
                    break;
                }
            } elseif (!is_string($key) && is_array($error)) {

                foreach ($error as $errorItem) {
                    if (is_array($errorItem) && !empty($errorItem['name']) && $errorItem['name'] == $field) {
                        $found = true;
                        break;
                    }
                }

            }
            if (!$found) {
                $num++;
            }
        }
    }
    if ($found && !empty($wpError['errors'][$k]) && !empty($wpError['errors'][$k][$num])) {
        return $wpError['errors'][$k][$num];
    }
    return false;
}


function user_pass_last_edit($user_id){
    if ( ! $user_id ) return '';

    $format = 'j F Y';

    $time = get_user_meta( $user_id, 'user_pass_last_edit', true );
    if (!$time) {
        $udata = get_userdata( $user_id );
        $registered = $udata->user_registered;
        return date( $format, strtotime( $registered ) );
    }

    return wp_date( $format, $time );
}

$request = get_data_from_table('municipality_requests', [
    'where' => " WHERE `user_id`={$user->ID}",
]);

$requestStatus = '';
if ($request) {
    $request = $request[0];
    $requestStatus = $request->status;
}
?>

<?php do_action( 'lifterlms_my_account_navigation' ); ?>

<?php
llms_get_template(
    'myaccount/dashboard-sidebar.php',
);
?>

<?php do_action( 'lifterlms_before_person_edit_account_form' ); ?>

<div class="account__content col-8">
    <section class="profile-settings">
        <nav class="breadcrumb">
            <?php yoast_breadcrumb(); ?>
        </nav>
        <h1 class="profile-settings__title"><?php _e('Profile settings', 'ndp'); ?></h1>
        <?php do_action( 'lifterlms_before_person_edit_account_form' ); ?>

        <?php if ($requestStatus && $requestStatus == 'Await processing'): ?>
        <div class="alert-wrapper">
            <div class="alert-block alert-blue">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <mask id="mask0_4417_77400" style="mask-type:alpha"
                          maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                        <rect width="24" height="24" fill="#D9D9D9" />
                    </mask>
                    <g mask="url(#mask0_4417_77400)">
                        <path
                                d="M11 17H13V11H11V17ZM12 9C12.2833 9 12.5208 8.90417 12.7125 8.7125C12.9042 8.52083 13 8.28333 13 8C13 7.71667 12.9042 7.47917 12.7125 7.2875C12.5208 7.09583 12.2833 7 12 7C11.7167 7 11.4792 7.09583 11.2875 7.2875C11.0958 7.47917 11 7.71667 11 8C11 8.28333 11.0958 8.52083 11.2875 8.7125C11.4792 8.90417 11.7167 9 12 9ZM12 22C10.6167 22 9.31667 21.7375 8.1 21.2125C6.88333 20.6875 5.825 19.975 4.925 19.075C4.025 18.175 3.3125 17.1167 2.7875 15.9C2.2625 14.6833 2 13.3833 2 12C2 10.6167 2.2625 9.31667 2.7875 8.1C3.3125 6.88333 4.025 5.825 4.925 4.925C5.825 4.025 6.88333 3.3125 8.1 2.7875C9.31667 2.2625 10.6167 2 12 2C13.3833 2 14.6833 2.2625 15.9 2.7875C17.1167 3.3125 18.175 4.025 19.075 4.925C19.975 5.825 20.6875 6.88333 21.2125 8.1C21.7375 9.31667 22 10.6167 22 12C22 13.3833 21.7375 14.6833 21.2125 15.9C20.6875 17.1167 19.975 18.175 19.075 19.075C18.175 19.975 17.1167 20.6875 15.9 21.2125C14.6833 21.7375 13.3833 22 12 22ZM12 20C14.2333 20 16.125 19.225 17.675 17.675C19.225 16.125 20 14.2333 20 12C20 9.76667 19.225 7.875 17.675 6.325C16.125 4.775 14.2333 4 12 4C9.76667 4 7.875 4.775 6.325 6.325C4.775 7.875 4 9.76667 4 12C4 14.2333 4.775 16.125 6.325 17.675C7.875 19.225 9.76667 20 12 20Z"
                                fill="#2A59BD" />
                    </g>
                </svg>
                <span><?php _e('Verification of your data in progress', 'ndp'); ?></span>
            </div>
        </div>
        <?php endif; ?>
        <?php if ($requestStatus && ($requestStatus == 'Rejected' || $requestStatus == 'Cancelled')): ?>
        <div class="alert-wrapper">
            <div class="alert-block alert-red">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM9 15V13H11V15H9ZM9 5V11H11V5H9Z" fill="#BA1A1A"/>
                </svg>
                <span><?php _e('Your details have not been verified', 'ndp'); ?></span>
            </div>
        </div>
        <?php endif; ?>

        <form method="post" class="llms-person-form edit-account">
        <?php do_action( 'lifterlms_edit_account_start' ); ?>
            <?php //echo $form_fields; ?>
            <div class="profile-settings__block">
                <div class="form__inputtitle-wrapper">
                    <h2 class="profile-settings__block-title"><?php _e('Personal data','ndp'); ?></h2>
                    <?php if ($viaDia): ?>
                    <div class="profile-settings__block-title--right">
                        <svg width="16" height="12" viewBox="0 0 16 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M1 7L5 11L15 1" stroke="#8A90A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        <?php _e('Verified via id gov.ua', 'ndp'); ?>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="form__input-wrapper">
                    <label for="full_name" class="form__input-title"><?php _e('Full name', 'ndp'); ?></label>
                    <?php
                    $fullName = esc_attr( get_the_author_meta( 'user_lastname', $user->ID ) )." ";
                    $fullName .= esc_attr( get_the_author_meta( 'user_firstname', $user->ID ) )." ";
                    $fullName .= esc_attr( get_the_author_meta( 'middle_name', $user->ID ) );
                    ?>
                    <input type="text" id="full_name" name="full_name" value="<?php echo trim($fullName); ?>"
                           class="form__input-field" disabled
                           placeholder="<?php _e('No data available','ndp'); ?>">
<!--                    --><?php //if ($error = getErrorMessage('first_name', $wpError)): ?>
<!--                    <span class="error-tip">--><?php //echo $error; ?><!--</span>-->
<!--                    --><?php //endif; ?>
                </div>
                <div class="form__input-wrapper">
                    <?php
                    $day_of_birth = esc_attr( get_the_author_meta( 'day_of_birth', $user->ID ) );
                    $month_of_birth = esc_attr( get_the_author_meta( 'month_of_birth', $user->ID ) );
                    if (!is_numeric($month_of_birth)) {
                        $date = date_parse($month_of_birth);
                        if (!empty($date) && !empty($date['month'])) {
                            $month_of_birth = $date['month'];
                            $month_of_birth = str_pad($month_of_birth, 2, "0", STR_PAD_LEFT);
                        }
                    }
                    $year_of_birth = esc_attr( get_the_author_meta( 'year_of_birth', $user->ID ) );
                    $date_of_birth = '';
                    if (!empty($day_of_birth) && !empty($month_of_birth) && !empty($year_of_birth)) {
                        $date_of_birth = $day_of_birth.'.'.$month_of_birth.'.'.$year_of_birth;
                    }
                    ?>
                    <label class="form__input-title"><?php _e('Date of Birth','ndp'); ?></label>
                    <input type="text" id="date_of_birth" name="date_of_birth" value="<?php echo $date_of_birth; ?>"
                           class="form__input-field"
                           placeholder="<?php _e('No data available', 'ndp'); ?>" disabled>
                    <button type="button" class="form__input-button" data-modal="date_of_birth"><?php _e('Edit', 'ndp'); ?></button>
                    <?php if ($error = getErrorMessage('date_of_birth', $wpError)): ?>
                        <span class="error-tip"><?php echo $error; ?></span>
                    <?php endif; ?>
                </div>
                <div class="form__input-wrapper">
                    <?php
                    $gender = esc_attr( __(get_the_author_meta( 'gender', $user->ID ),'ndp' ));
                    ?>
                    <label class="form__input-title"><?php _e('Gender','ndp'); ?></label>
                    <input type="text" id="gender_input" name="gender" value="<?php _e($gender, 'ndp'); ?>"
                           class="form__input-field"
                           placeholder="<?php _e('No data available', 'ndp'); ?>" disabled>
                    <button type="button" class="form__input-button" data-modal="gender"><?php _e('Edit', 'ndp'); ?></button>
                    <?php if ($error = getErrorMessage('gender', $wpError)): ?>
                        <span class="error-tip"><?php echo $error; ?></span>
                    <?php endif; ?>
                </div>
                <?php
                $edr = '';
                if (!empty($municipality) && !empty($municipality['edr'])) {
                    $edr = $municipality['edr'];
                }
                ?>
                <?php if (strlen($TIN)): ?>

                <div class="form__input-wrapper">
                    <label class="form__input-title"><?php _e('TIN', 'ndp'); ?></label>
                    <?php if (isset($TIN)) :?>
                        <input maxlength="10" type="text" value="<?php echo $TIN ; ?>"
                               class="form__input-field <?php if ($viaDia) echo 'cancelEdit'; ?>"
                               placeholder="<?php _e('No data available', 'ndp'); ?>" disabled>
                    <?php endif; ?>

                    <?php if ($error = getErrorMessage('edrpouCode', $wpError)): ?>
                        <span class="error-tip error-tip-tin"><?php echo $error; ?></span>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                    <div class="form__input-wrapper">
                        <label class="form__input-title"><?php _e('TIN', 'ndp'); ?></label>
                        <input maxlength="10"  name="edrpou_code"  value=""
                               class="form__input-field form__input-field-tin <?php if ($viaDia) echo 'cancelEdit'; ?>"
                               data-title="<?php _e('Need 6 or 9 digits for TIN', 'ndp'); ?>"
                               placeholder="<?php _e('No data available', 'ndp'); ?>">
                        <button type="button" class="edrpou_Edit form__input-button" data-modal="edrpou_code"><?php _e('Edit', 'ndp'); ?></button>

                        <?php if ($error = getErrorMessage('edrpou_code', $wpError)): ?>
                            <span class="error-tip"><?php echo $error; ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form__input-wrapper">
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
                    <p class="error-tip error-tip-tin" style="display:none;"><?php _e('TIN must be 10 digits', 'ndp'); ?></p>
                    <p class="error-tip error-tip-tin-old" style="display:none;"><?php _e('Need 6 or 9 digits for TIN', 'ndp'); ?></p>
                    <p class="error-tip muni_error" ></p>
                <?php endif; ?>



                <?php
                global $wpdb;
                //meta_key user_profile_type - Representative имеют все представителя муниципалитета
                //meta_key role_representative - municipality только у главы муниципалитета
                $table_name = $wpdb->prefix . 'municipalities';
                $accountType = __('Personal', 'ndp');
                $representative = get_user_meta( $user->ID, 'user_profile_type', true );
                $styles = '';
                if (!empty($representative)) {
                    $accountType = __($representative, 'ndp');
                    $styles = 'style="opacity: 0;pointer-events: none;"';
                }
                $roles = ( array ) $user->roles;
                if (empty($municipality) && in_array( 'student', $roles, true )): ?>
                <div class="form__input-wrapper">
                    <label class="form__input-title"><?php _e('Account type', 'ndp'); ?></label>
                    <input type="text" value="<?php echo $accountType; ?>"
                           class="form__input-field account-type"
                           disabled>
                    <button type="button" class="form__input-button js-switch-account" <?php echo $styles; ?> data-izimodal-open="#switchAccount" title="<?php _e('Switch to the account of a municipal representative', 'ndp'); ?>"><?php _e('Switch', 'ndp'); ?></button>
                </div>
                <?php endif; ?>
            </div>

            <div class="profile-settings__block profile-settings__contacts">
                <h2 class="profile-settings__block-title profile-settings__contacts-title"><?php _e('Contacts', 'ndp'); ?></h2>
<!--                <div class="profile-settings__contacts-item profile-settings__item">-->
<!--                    <h3 class="profile-settings__contacts-name">--><?php //_e('Email', 'ndp'); ?><!--</h3>-->
<!--                    <input type="text" id="email_address" name="email_address" value="--><?php //echo esc_attr( get_the_author_meta( 'user_email', $user->ID ) ); ?><!--" readonly class="profile-settings__contacts-value --><?php //if ($viaDia) echo 'cancelEdit'; ?><!--">-->
<!--                    <button type="button" class="form__input-button profile-settings__contacts-button js-input-edit --><?php //if ($viaDia) echo 'cancelEdit'; ?><!--">--><?php //_e('Edit', 'ndp'); ?><!--</button>-->
<!--                </div>-->
<!--                --><?php //if ($error = getErrorMessage('email_address', $wpError)): ?>
<!--                    <span class="error-tip">--><?php //echo $error; ?><!--</span>-->
<!--                --><?php //endif; ?>
                <div class="form__input-wrapper">
                    <label for="full_name" class="form__input-title"><?php _e('Email', 'ndp'); ?></label>
                    <input disabled type="text" id="email_address" name="email_address" value="<?php echo esc_attr( get_the_author_meta( 'user_email', $user->ID ) ); ?>"
                           class="form__input-field"
                           placeholder="<?php _e('No data available','ndp'); ?>">

                    <button type="button" class="form__input-button change_email"><?php _e('Edit', 'ndp'); ?></button>
                </div>
                <div class="form__input-wrapper wrapper-error-email hidden">
                    <p class="error-tip error-email"><?php _e('The email format is incorrect.', 'ndp'); ?></p>
                    <p class="error-tip error-email-ajax"><?php _e('The email format is incorrect.', 'ndp'); ?></p>
                </div>
                <div class="form__input-wrapper">
                    <label class="form__input-title"><?php _e('Phone', 'ndp'); ?></label>
                    <input type="text" id="phone_input" value="<?php echo esc_attr( get_the_author_meta( 'llms_phone', $user->ID ) ); ?>"
                           class="form__input-field" readonly
                           placeholder="(XXX) XXX XX XX">
                    <button type="button" class="form__input-button" data-modal="phone"><?php _e('Edit', 'ndp'); ?></button>
                </div>
            </div>

            <div class="profile-settings__block profile-settings__password">
                <h2 class="profile-settings__block-title profile-settings__password-title"><?php _e('Password','ndp'); ?></h2>
                <div class="profile-settings__password-item profile-settings__item">
                    <label for="password_current" class="profile-settings__password-name profile-settings__password-name--password_current"><?php _e('Current password', 'ndp'); ?></label>
                    <input class="llms-field-input profile-settings__contacts-value hidden" id="password_current" name="password_current" type="password">
                    <span class="profile-settings__password-value"><?php _e('Last updated','ndp'); ?>: <?php echo date_i18n('d.m.Y', strtotime(user_pass_last_edit($student->get('id')))); ?></span>
                    <?php global $wp; ?>
                    <a href="<?php echo home_url( $wp->request ) . '?password-change' ?>" type="button" class="profile-settings__password-button"><?php _e('Edit', 'ndp'); ?></a>
                </div>
<!--                <div class="profile-settings__password-item profile-settings__item profile-settings__item-hidden hidden" style="padding: 14px 16px 14px 0;">-->
<!--                    <label for="password" class="profile-settings__password-name profile-settings__password-name--password">--><?php //_e('Password', 'ndp'); ?><!--</label>-->
<!--                    <input class="llms-field-input profile-settings__contacts-value" data-match="password_confirm" id="password" minlength="8" name="password" type="password">-->
<!--                </div>-->
<!--                <div class="profile-settings__password-item profile-settings__item profile-settings__item-hidden hidden" style="padding: 14px 16px 14px 0;">-->
<!--                    <label for="password_confirm" class="profile-settings__password-name profile-settings__password-name--password_confirm">--><?php //_e('Confirm', 'ndp'); ?><!--</label>-->
<!--                    <input class="llms-field-input profile-settings__contacts-value" data-match="password" id="password_confirm" minlength="8" name="password_confirm" type="password">-->
<!--                </div>-->
<!--                <div class="llms-form-field type-html llms-cols-12 llms-cols-last llms-visually-hidden-field password-strength-meter" style="display: none;">-->
<!--                    <div aria-live="polite" class="llms-field-html llms-password-strength-meter" id="llms-password-strength-meter"></div>-->
<!--                </div>-->
                <?php
                $errors = [];
                if ($error = getErrorMessage('password_current', $wpError)) {
                    if (!in_array($error, $errors)) {
                        $errors[] = $error;
                    }
                }
                if ($error = getErrorMessage('password', $wpError)) {
                    if (!in_array($error, $errors)) {
                        $errors[] = $error;
                    }
                }
                if ($error = getErrorMessage('password_confirm', $wpError)) {
                    if (!in_array($error, $errors)) {
                        $errors[] = $error;
                    }
                }
                $errorsMessage = !empty($errors)? implode(' ', $errors) : '';
                ?>
                <?php if ($errorsMessage): ?>
                    <span class="error-tip"><?php echo $errorsMessage; ?></span>
                <?php endif; ?>
            </div>
            <!-- <div class="profile-settings__block profile-settings__notifications">
                <h2 class="profile-settings__block-title profile-settings__notifications-title"><?php _e('Notifications','ndp'); ?></h2>
                <div class="profile-settings__notifications-item">
                    <h3 class="profile-settings__notifications-name"><?php _e('System messages','ndp'); ?></h3>
                    <div class="profile-settings__notifications-switch">
                        <input type="checkbox" class="profile-settings__notifications-switch__input" id="messages">
                        <label for="messages" class="profile-settings__notifications-switch__label"></label>
                    </div>
                </div>
                <div class="profile-settings__notifications-item">
                    <h3 class="profile-settings__notifications-name"><?php _e('News','ndp'); ?></h3>
                    <div class="profile-settings__notifications-switch">
                        <input type="checkbox" class="profile-settings__notifications-switch__input" id="news">
                        <label for="news" class="profile-settings__notifications-switch__label"></label>
                    </div>
                </div>
                <div class="profile-settings__notifications-item">
                    <h3 class="profile-settings__notifications-name"><?php _e('Articles','ndp'); ?></h3>
                    <div class="profile-settings__notifications-switch">
                        <input type="checkbox" class="profile-settings__notifications-switch__input" id="articles">
                        <label for="articles" class="profile-settings__notifications-switch__label"></label>
                    </div>
                </div>
                <div class="profile-settings__notifications-item">
                    <h3 class="profile-settings__notifications-name"><?php _e('Cases','ndp'); ?></h3>
                    <div class="profile-settings__notifications-switch">
                        <input type="checkbox" class="profile-settings__notifications-switch__input" id="cases">
                        <label for="cases" class="profile-settings__notifications-switch__label"></label>
                    </div>
                </div>
                <div class="profile-settings__notifications-item">
                    <h3 class="profile-settings__notifications-name profile-settings__notifications-name__disable1"><?php _e('New courses','lifterlms'); ?></h3>
                    <div class="profile-settings__notifications-switch">
                        <input type="checkbox"
                               class="profile-settings__notifications-switch__input profile-settings__notifications-switch__input-disable1"
                               id="courses">
                        <label for="courses"
                               class="profile-settings__notifications-switch__label profile-settings__notifications-switch__disable1"></label>
                    </div>
                </div>
            </div> -->

            <?php wp_nonce_field( 'llms_update_person', '_llms_update_person_nonce' ); ?>
            <input name="action" type="hidden" value="llms_update_person">

            <?php do_action( 'lifterlms_edit_account_form_end' ); ?>
        </form>
      <button class="profile-settings__out"><?php _e('Log out', 'ndp'); ?></button>
    </section>
</div>

<?php
do_action( 'lifterlms_after_person_edit_account_form' );
?>

<div class="c-modal c-modal-medium iziModal" id="switchAccount">
  <button type="button" data-iziModal-close class="c-modal__close">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
              d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
              fill="#919094"/>
    </svg>
  </button>
  <div class="c-modal__wrap">
    <div class="c-modal__header">
      <h2 class="h2"><?php _e('Сhange your account type?','ndp'); ?></h2>
      <p><?php _e('Are you sure you want to change your account type?', 'ndp'); ?></p>
    </div>
    <div class="c-modal__nav">
      <button type="button" class="btn btn-outline-primary" data-iziModal-close><?php _e('Cancel', 'ndp'); ?></button>
      <button type="button" class="btn btn_bg_primary js-switch-account-change"><?php _e('Yes, change', 'ndp'); ?></button>
    </div>
  </div>
</div>

<div class="profile-settings__modal" id="modal__date_of_birth">
    <div class="profile-settings__modal-item">
        <button class="profile-settings__modal-close"></button>
        <h2 class="profile-settings__modal-title"><?php _e('Enter date of birth', 'ndp'); ?></h2>
<!--        <span class="profile-settings__modal-subtitle">--><?php //_e('This data cannot be changed later', 'ndp'); ?><!--</span>-->

        <div class="profile-settings__modal-content profile-settings__personalData-birthday d-flex justify-content-between">
            <div class="profile-settings__personalData-wrapper">
                <input type="text" id="day_of_birth" name="day_of_birth" value="<?php echo esc_attr( get_the_author_meta( 'day_of_birth', $user->ID ) ); ?>" class="profile-settings__personalData-input" placeholder="XX">
                <label for="day" class="profile-settings__personalData-label"><?php _e('Day', 'ndp'); ?></label>
            </div>
            <div class="profile-settings__personalData-wrapper">
                <?php
                $month = $month_of_birth;
                if (is_numeric($month_of_birth)) {
                    $month = date('F', mktime(0, 0, 0, $month_of_birth, 10));
                    $month = __($month, 'ndp');
                }
                ?>
                <input type="text" id="month_of_birth" name="month_of_birth" value="<?php echo $month; ?>" class="profile-settings__personalData-input" placeholder="<?php _e('Select month','ndp');?>">
                <label for="month" class="profile-settings__personalData-label"><?php _e('Month', 'ndp'); ?></label>
                <div class="profile-settings__personalData-image">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow-dropdown.svg" alt="arrow">
                </div>
                <ul class="profile-settings__personalData-list personalData-list--text">
                    <li data-value="1" class="profile-settings__personalData-list__item"><?php _e('January', 'ndp'); ?></li>
                    <li data-value="2" class="profile-settings__personalData-list__item"><?php _e('February', 'ndp'); ?></li>
                    <li data-value="3" class="profile-settings__personalData-list__item"><?php _e('March', 'ndp'); ?></li>
                    <li data-value="4" class="profile-settings__personalData-list__item"><?php _e('April','ndp'); ?></li>
                    <li data-value="5" class="profile-settings__personalData-list__item"><?php _e('May','ndp'); ?></li>
                    <li data-value="6" class="profile-settings__personalData-list__item"><?php _e('June', 'ndp'); ?></li>
                    <li data-value="7" class="profile-settings__personalData-list__item"><?php _e('July','ndp'); ?></li>
                    <li data-value="8" class="profile-settings__personalData-list__item"><?php _e('August', 'ndp'); ?></li>
                    <li data-value="9" class="profile-settings__personalData-list__item"><?php _e('September','ndp'); ?></li>
                    <li data-value="10" class="profile-settings__personalData-list__item"><?php _e('October', 'ndp'); ?></li>
                    <li data-value="11" class="profile-settings__personalData-list__item"><?php _e('November','ndp'); ?></li>
                    <li data-value="12" class="profile-settings__personalData-list__item"><?php _e('December','ndp'); ?></li>
                </ul>
            </div>
            <div class="profile-settings__personalData-wrapper">
                <input type="text" id="year_of_birth" name="year_of_birth" value="<?php echo esc_attr( get_the_author_meta( 'year_of_birth', $user->ID ) ); ?>" class="profile-settings__personalData-input" placeholder="XXXX">
                <label for="year" class="profile-settings__personalData-label"><?php _e('Year', 'ndp'); ?></label>
            </div>
            <?php if ($error = getErrorMessage('year_of_birth', $wpError)): ?>
                <span class="error-tip"><?php echo $error; ?></span>
            <?php endif; ?>
        </div>

        <div class="profile-settings__modal-buttons">
            <button class="profile-settings__modal-cancel"><?php _e('Cancel', 'ndp'); ?></button>
            <a class="profile-settings__modal-confirm profile-settings__modal-save"
               data-ajax="profile_settings_save_date_of_birth"
               href=""><?php _e('Save', 'ndp'); ?></a>
        </div>
    </div>
</div>


<div class="profile-settings__modal" id="modal__gender">
    <div class="profile-settings__modal-item">
        <button class="profile-settings__modal-close"></button>
        <h2 class="profile-settings__modal-title"><?php _e('Indicate your gender', 'ndp'); ?></h2>

        <div class="profile-settings__modal-content profile-settings__personalData-wrapper">
            <input type="text" id="gender" name="gender" data-value="" value="<?php _e($gender, 'ndp'); ?>" class="profile-settings__personalData-input" placeholder="<?php _e('Select gender', 'ndp'); ?>">
            <label for="gender" class="profile-settings__personalData-label"><?php _e('Gender','ndp'); ?></label>
            <div class="profile-settings__personalData-image">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow-dropdown.svg" alt="arrow">
            </div>
            <ul class="profile-settings__personalData-list profile-settings__personalData-list__gender personalData-list--text">
                <li data-value="Male" class="profile-settings__personalData-list__item"><?php _e('Male','ndp'); ?></li>
                <li data-value="Female" class="profile-settings__personalData-list__item"><?php _e('Female', 'ndp'); ?></li>
            </ul>
            <?php if ($error = getErrorMessage('gender', $wpError)): ?>
                <span class="error-tip"><?php echo $error; ?></span>
            <?php endif; ?>
        </div>

        <div class="profile-settings__modal-buttons">
            <button class="profile-settings__modal-cancel"><?php _e('Cancel', 'ndp'); ?></button>
            <a class="profile-settings__modal-confirm profile-settings__modal-save"
               data-ajax="profile_settings_save_gender"
               href=""><?php _e('Save', 'ndp'); ?></a>
        </div>
    </div>
</div>


<div class="profile-settings__modal" id="modal__phone">
    <div class="profile-settings__modal-item">
        <button class="profile-settings__modal-close"></button>
        <h2 class="profile-settings__modal-title"><?php _e('Enter phone number', 'ndp'); ?></h2>

        <div class="profile-settings__modal-content profile-settings__personalData-wrapper">
            <label for="llms_phone" class="form__input-title"><?php _e('Phone', 'ndp'); ?></label>
            <input type="text" id="llms_phone" name="llms_phone" value="<?php echo esc_attr( get_the_author_meta( 'llms_phone', $user->ID ) ); ?>"
                   class="form__input-field"
                   placeholder="+38(XXX) XXX XX XX">
            <span class="error-tip hidden" style="position: absolute;left: 0;display:block;"><?php _e('Invalid phone number format +38(099) 999 99 99', 'ndp') ?></span>
        </div>

        <div class="profile-settings__modal-buttons">
            <button class="profile-settings__modal-cancel"><?php _e('Cancel', 'ndp'); ?></button>
            <a class="profile-settings__modal-confirm profile-settings__modal-save"
               data-ajax="profile_settings_save_phone"
               href=""><?php _e('Save', 'ndp'); ?></a>
        </div>
    </div>
</div>
<?php endif; ?>


<style>
    p.length_Error {
        font-size: 12px;
        color: red;
    }
    p.muni_error {
        font-size: 12px;
        color: red;
    }
    button.edrpou_Edit.form__input-button.saveInn.disabled:before {
        display: none;
    }

    button.edrpou_Edit.form__input-button.saveInn.disabled {
        color: #ddd;
        cursor: no-drop;
    }
</style>
<script>

        jQuery(document).ready(function($) {
            $('.change_email').click(function() {
                var button = $(this); // Зберігаємо кнопку для використання у колбеках
                var email_address = $('#email_address');
                if (!button.hasClass('active')) {
                    email_address.removeAttr('disabled');
                    button.text('<?php _e("Save","ndp"); ?>');
                    button.attr('data-email', email_address.val())
                } else {
                    email_address.prop('disabled', true);
                    var newEmail = email_address.val(); // Отримуємо новий email з форми
                    button.text('<?php _e("Edit","ndp"); ?>');
                    $.ajax({
                        url: ajax_object.ajax_url, // Використання глобальної змінної ajaxurl
                        method: 'POST',
                        data: {
                            action: 'updateUserEmail', // Дія, за якою буде викликаний обробник на сервері
                            email: newEmail,
                            nonce:ajax_object.nonce
                        },
                        success: function(response) {
                            if (response && response.hasOwnProperty('data') && response['data'].hasOwnProperty('message')) {
                                $('.error-tip').hide();
                                if (response.hasOwnProperty('success') && !response['success']) {
                                    email_address.val(button.attr('data-email'));
                                    $('.error-email-ajax').text(response.data.message).show();
                                    $('.wrapper-error-email').removeClass('hidden');
                                } else if (response.hasOwnProperty('success') && response['success']) {
                                    $('.error-email-ajax').text(response.data.message).show();
                                    let $field = $('.wrapper-error-email');
                                    $field.removeClass('hidden');
                                    setTimeout(function() {
                                        $field.addClass('hidden');
                                        $('.error-email-ajax').hide();
                                    },2000)
                                }
                            }
                        },
                        error: function(response) {
                            email_address.val(button.attr('data-email'));
                            $('.error-email').text(response.responseJSON.data.message).show()
                        }
                    });
                }
                button.toggleClass('active');
            });
        });



</script>
