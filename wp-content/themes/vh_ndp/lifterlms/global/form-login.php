<?php
/**
 * LifterLMS Login Form
 *
 * @package LifterLMS/Templates
 *
 * @since 3.0.0
 * @since 5.0.0 Moved setup logic for passed arguments to the function llms_get_login_form().
 * @version 5.0.0
 *
 * @param string $message (Optional) Messages to display before login form.
 * @param string $redirect (Optional) URL to redirect to after login.
 * @param string $layout (Optional) Form layout [columns|stacked].
 */

defined( 'ABSPATH' ) || exit;

$hideForm = false;
if ( apply_filters( 'llms_hide_registration_form', is_user_logged_in() ) ) {
    $hideForm = true;
}
//file_put_contents($_SERVER['DOCUMENT_ROOT'].'/test5.txt',print_r($_GET,true));
$isuuid = isset($_GET['uuid']) ? true:false;
if($isuuid){
//  	header('Location: /register-step-1');
// exit;
}


$isCreateAppEmail = isset($_GET['app_created']) ? $_GET['app_created'] : false;

if (isset($_GET['invite']) && !empty($_GET['invite']) && isset($_SESSION)) {
    $_SESSION['invite'] = $_GET['invite'];
}


$form_fields = llms_get_form_html( 'account' );//нужно чтобы работала валидация пароля
?>

<section class="authorization registration">
    <div class="container">
        <div class="authorization__block col-5">
            <?php if (!$isCreateAppEmail) { ?>
                <div class="authorization__header">
                    <h1 class="authorization__title"><?php _e('UANDP Account', 'ndp'); ?></h1>
                    <div class="authorization__tabs d-flex align-center">
                        <span class="authorization__tabs-item tabs__item-active col-6"><?php _e('Authorization', 'ndp'); ?></span>
                        <span class="authorization__tabs-item col-6"><?php _e('Registration', 'ndp'); ?></span>
                    </div>
                </div>
            <?php } else {?>
                <div class='authorization__header_create_app'>
                    <div class="authorization__header_create_app-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <path d="M12 21.5598L6.43999 15.9998L4.54666 17.8798L12 25.3331L28 9.33312L26.12 7.45312L12 21.5598Z" fill="#2A59BD"/>
                        </svg>
                    </div>
                    <div class="authorization__header_create_app-title"><?php _e('Application has been created', 'ndp'); ?></div>
                    <div class="authorization__header_create_app-text"><?php _e('Log in with your email to view the request', 'ndp'); ?></div>
                </div>
            <?php }?>
            <div class="llms-person-login-form-wrapper tabs-content tab-active">
                <?php
                /**
                 * Fire an action prior to the output of the login form.
                 *
                 * @since Unknown
                 */
                do_action( 'llms_before_person_login_form' );
                ?>

                <form action="" class="authorization__form d-flex flex-column llms-login" method="POST">
                    <button type="button" class="dia_verify registration__form-button">
                        <?php _e('via ID GOV UA','ndp');?>
                    </button>

                    <script>
                        $('.dia_verify').click(function(){

                            window.location.href="/wp-json/redirect/v1/redirect/"
                        });
                    </script>
                    <?php
                    /**
                     * Fire an action prior to the output of the login form fields.
                     *
                     * @since Unknown
                     */
                    do_action( 'lifterlms_login_form_start' );
                    ?>
                    <div class="mdc-text-field mdc-text-field--outlined llms-form-field type-email llms-is-required mdc-text-field--label-floating">
                        <input autocomplete="off" type="text" class="mdc-text-field__input llms-field-input" id="llms_login" name="llms_login" required>
                        <div class="mdc-notched-outline">
                            <div class="mdc-notched-outline__leading"></div>
                            <div class="mdc-notched-outline__notch mdc-notched-outline--notched">
                                <label for="email" class="mdc-floating-label"><?php _e('Email (login)','ndp'); ?> </label>
                            </div>
                            <div class="mdc-notched-outline__trailing">
                                <i class="material-icons error-icon" aria-hidden="true">error</i>
                            </div>
                        </div>
                    </div>
                    <div class="mdc-text-field mdc-text-field--outlined llms-form-field type-password llms-is-required mdc-text-field--label-floating">
                        <input autocomplete="off" type="password" class="mdc-text-field__input password-input-field " id="llms_password" name="llms_password" required>
                        <i class="material-icons mdc-text-field__icon toggle-password" tabindex="0" role="button">visibility</i>
                        <div class="mdc-notched-outline">
                            <div class="mdc-notched-outline__leading"></div>
                            <div class="mdc-notched-outline__notch mdc-notched-outline--notched">
                                <label for="password" class="mdc-floating-label"><?php _e('Password', 'ndp'); ?></label>
                            </div>
                            <div class="mdc-notched-outline__trailing">
                                <i class="material-icons error-icon" aria-hidden="true">error</i>
                            </div>
                        </div>
                    </div>
                    <button class="authorization__form-button llms-field-button llms-button-action" id="llms_login_button" name="llms_login_button" type="submit"><?php _e('Log In', 'ndp'); ?></button>
                    <a href="/dashboard/lost-password/" class="authorization__form-forgot"><?php _e('Forgot password', 'ndp'); ?>?</a>
                    <span class="authorization__error-message"><?php _e('Wrong email or password', 'ndp'); ?></span>

                    <?php wp_nonce_field( 'llms_login_user', '_llms_login_user_nonce' ); ?>
                    <?php
                    $redirectLink = get_permalink();
                    if (isset($_GET['survey']) && $_GET['survey'] == 'create' && isset($_GET['lang']) && !empty($_GET['lang'])) {
                        $redirectLink = '/wp-admin/post-new.php?post_type=course&lang='.$_GET['lang'].'&survey=create';
                    } elseif (isset($_GET['survey']) && $_GET['survey'] == 'edit' && !empty($_GET['post']) && isset($_GET['lang']) && !empty($_GET['lang'])) {
                        $redirectLink = '/wp-admin/post.php?post='.$_GET['post'].'&action=edit&lang='.$_GET['lang'].'&survey';
                    }
                    ?>
                    <input type="hidden" name="redirect" value="<?php echo $redirectLink; ?>" />
                    <input type="hidden" name="action" value="llms_login_user" />

                    <?php
                    /**
                     * Fire an action after the output of the login form fields.
                     *
                     * @since Unknown
                     */
                    do_action( 'lifterlms_login_form_end' );
                    ?>
                </form>
                <?php
                /**
                 * Fire an action after the output of the login form.
                 *
                 * @since Unknown
                 */
                do_action( 'llms_after_person_login_form' );

                /**
                 * Registration
                 */
                ?>
            </div>
            <div class="llms-new-person-form-wrapper tabs-content">
                <?php if (!$hideForm): ?>
                <?php do_action( 'lifterlms_before_person_register_form' ); ?>

                <div class="registration__main">
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/registration-govua/govua-logo.svg" alt="govua-logo">
                    <p class="registration__main-text"><?php _e('Authorization with an additional integrated electronic identification system ID.GOV.UA'); ?></p>
                    <button class="dia_verify registration__button"><?php _e('Sign Up','ndp');?></button>
                </div>
            </div>

            <script>
                $('.dia_verify').click(function(){

                    window.location.href="/wp-json/redirect/v1/redirect/"
                });
            </script>
        </div>
        <?php endif; ?>
    </div>
    </div>
    </div>
</section>

<style>
    .black{
        background:black !important;
    }
</style>
<script>
    $ = jQuery;
    if($('.llms-error').length){
        $('.authorization__error-message').text($('.llms-error li:first').text());
        $('.mdc-text-field').addClass('mdc-text-field--invalid');
        $('.authorization__error-message').show();
    }else{
        $('.mdc-text-field').removeClass('mdc-text-field--invalid');
        $('.authorization__error-message').hide();
    }


</script>
<style>
    ul.llms-notice.llms-error{
        display:none;
    }

</style>
