<?php
defined( 'ABSPATH' ) || exit;
?>

<?php


ob_start(); // начинаем буферизацию вывода
llms_print_notices(); // выводим уведомления
$notices = ob_get_clean(); // получаем и очищаем буфер


ob_start();
wp_nonce_field('llms_' . $form, '_' . $form . '_nonce');
$hidden_inputs =  ob_get_clean();

?>

<?php
if(isset($_GET['reset-pass'])){
    $is_code = $_GET['reset-pass'];
}else{
    $is_code = false;
}

?>
<?php if(!$is_code) { ?>
    <?php
    wp_enqueue_script('recovery', get_template_directory_uri() . '/assets/js/recovery-password.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_style('recovery', get_template_directory_uri() . '/assets/css/recovery-password.css');?>
    <section class="recovery-password">
        <div class="container">
            <div class="recovery-password__block col-5">
                <div class="recovery-password__header">
                    <h1 class="recovery-password__title"><?php _e('Recovery password', 'ndp'); ?></h1>
                    <p class="recovery-password__text"><?php _e('A 6-digit code will send to your email address', 'ndp'); ?></p>
                </div>
                <form action="" class="llms-lost-password-form recovery-password__form d-flex flex-column" method="POST">
                    <div class="mdc-text-field mdc-text-field--outlined <?php if (!empty($notices)) {
                        echo "mdc-text-field--invalid";
                    }?>"">
                    <input type="email" class="mdc-text-field__input <?php if (!empty($notices)) {
                        echo "mdc-text-field--invalid";
                    }?>" id="email" name="llms_login" required="required">
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label for="email" class="mdc-floating-label"><?php _e('Email (login)', 'ndp'); ?></label>
                        </div>
                        <div class="mdc-notched-outline__trailing">
                            <i class="material-icons error-icon" aria-hidden="true">error</i>
                        </div>
                    </div>
            </div>

            <?php echo $notices; ?>
            <button type="submit" name="llms_lost_password_button" class="recovery-password__form-button"><?php _e('Reset password', 'ndp'); ?></button>
            <div class="recovery-password__signin"><span><?php _e('Remembered Your Password?', 'ndp'); ?></span><a href="/dashboard"><?php _e('Sign in', 'ndp'); ?></a></div>
            <?php wp_nonce_field( 'llms_' . $form, '_' . $form . '_nonce' ); ?>
            </form>
        </div>
        </div>
    </section>


<?php }else { ?>

    <?php wp_enqueue_script('change', get_template_directory_uri() . '/assets/js/create-new-password.js', array('jquery'), _S_VERSION, true);
    wp_enqueue_style('change', get_template_directory_uri() . '/assets/css/create-new-password.css'); ?>
    <section class="create-new-password">
        <div class="container">
            <div class="create-new-password__block col-5">
                <div class="create-new-password__header">
                    <h1 class="create-new-password__title"><?php _e('Create new password', 'ndp'); ?></h1>
                </div>
                <form action="" class="llms-lost-password-form create-new-password__form d-flex flex-column" method="POST">

                    <div class="llms-form-field mdc-text-field mdc-text-field--outlined">
                        <input class="llms-field-input mdc-text-field__input" data-match="password_confirm" id="password" minlength="8" name="password" required="required" type="password">
                        <i class="material-icons mdc-text-field__icon toggle-password" tabindex="0" role="button">visibility</i>
                        <div class="mdc-notched-outline">
                            <div class="mdc-notched-outline__leading"></div>
                            <div class="mdc-notched-outline__notch">
                                <label for="password" class="mdc-floating-label"><?php _e('New password', 'ndp'); ?></label>
                            </div>
                            <div class="mdc-notched-outline__trailing">
                                <i class="material-icons error-icon" aria-hidden="true">error</i>
                            </div>
                        </div>
                    </div>
                    <p class="create-new-password__condition"><?php _e('Must be at least 8 characters', 'ndp'); ?></p>
                    <p class="create-new-password__error-message"><?php _e('Must be at least 8 characters', 'ndp'); ?></p>
                    <div class="llms-form-field mdc-text-field mdc-text-field--outlined">
                        <input type="password" class="mdc-text-field__input llms-field-input" data-match="password" name="password_confirm" minlength="8" id="password-confirm" required>
                        <i class="material-icons mdc-text-field__icon toggle-password-confirm" tabindex="0" role="button">visibility</i>
                        <div class="mdc-notched-outline">
                            <div class="mdc-notched-outline__leading"></div>
                            <div class="mdc-notched-outline__notch">
                                <label for="password" class="mdc-floating-label"><?php _e('Confirm Password', 'ndp'); ?></label>
                            </div>
                            <div class="mdc-notched-outline__trailing">
                                <i class="material-icons error-icon" aria-hidden="true">error</i>
                            </div>
                        </div>
                    </div>
                    <?php llms_print_notices();?>

                    <button name="llms_lost_password_button" type="submit" value="<?php _e('Reset Password', 'ndp'); ?>" class="llms-field-button llms-button-action auto create-new-password__form-button"><?php _e('Create password', 'ndp'); ?></button>
                    <?php foreach ( $fields as $field ) : ?>
                        <?php if($field['type'] =='hidden') : ?>
                            <?php llms_form_field( $field ); ?>

                        <?php endif; ?>
                    <?php endforeach; ?>
                    <?php wp_nonce_field( 'llms_' . $form, '_' . $form . '_nonce' ); ?>

                </form>
            </div>

        </div>
    </section>



<?php } ?>
<script>
    $ = jQuery;
    if($('.llms-success').length){
        $('div').removeClass('mdc-text-field--invalid');
        $('#email').removeClass('mdc-text-field--invalid');
    }
</script>
<script>
    $(document).on('click','.toggle-password,.toggle-password-confirm',function(){

        if($(this).prev().attr('type')=="text"){
            $(this).prev().attr('type','password');
        }else{
            $(this).prev().attr('type','text')
        }

    })
</script>












