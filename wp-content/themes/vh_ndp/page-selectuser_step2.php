<?php
/*
Template Name: Register step 2
*/
if(!get_current_user_id()){
    print_r('Ви не авторизовані');
    return;
}
wp_enqueue_style('lifterlms-authorization-icon', 'https://fonts.googleapis.com/icon?family=Material+Icons');
wp_enqueue_style('lifterlms-authorization', get_template_directory_uri() . '/assets/css/registration-govua.css');

wp_enqueue_script('vh_ndp-authorization', get_template_directory_uri() . '/assets/js/registration-govua.js', array(), _S_VERSION, true);
wp_enqueue_style('lifterlms-material', get_template_directory_uri() . '/assets/css/material-components-web.min.css');
wp_enqueue_script('lifterlms-material', get_template_directory_uri() . '/assets/js/material-components-web.min.js', array('jquery'), _S_VERSION, true);
$user_data=get_user_by('ID',get_current_user_id());
get_header();
?>
<style>
    input#email {
        top: -23px;
        position: relative;
        height: 54px;
        left: -15px;
        right: -15px;
        padding-left: 15px;

        z-index: -1;
    }
    #email+.mdc-notched-outline__trailing {
        opacity: 0;
    }
</style>


<!-- СТВОРЕННЯ ПАРОЛЯ  -->
<section class="registration">
    <div class="container">
        <div class="registration__block" id="create__password">
            <div class="registration__header">
                <h1 class="registration__title"><?php _e('UANDP Account', 'ndp'); ?></h1>
                <p class="registration__subtitle"><?php _e('Create password', 'ndp'); ?></p>
            </div>
            <form action="#" class="registration__form d-flex flex-column" id="form__create-password">

                <?php
                $user_id = get_current_user_id();
                $user_uuid = get_user_meta($user_id, 'uuid', true);
                $current_user = wp_get_current_user();
                $user_email = $current_user->user_email;
                $email_required = '';
                $email_disabled = '';
                if (!$user_email || ($user_email && $user_email == $user_uuid."@noreply.com")) {
                    $email_required = 'required';
                    $email_disabled = '';
                    $user_email = '';
                }
                ?>
                <div class="mdc-text-field mdc-text-field--outlined custom-input__field custom-input__email">
                    <input type="email" name="email" value="<?php echo $user_email; ?>" class="mdc-text-field__input" id="email" <?php echo $email_disabled; ?> <?php echo $email_required; ?>>
                    <div class="mdc-notched-outline__trailing">
                        <span class="registration__error-message" id="email-error-message"></span>
                    </div>
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label for="email" class="mdc-floating-label"><?php _e('Email', 'ndp'); ?></label>
                        </div>
                        <div class="mdc-notched-outline__trailing">
                            <i class="material-icons error-icon" aria-hidden="true">
                                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/error.svg" alt="upload-icon">
                            </i>
                        </div>
                    </div>
                </div>

                <div class="mdc-text-field mdc-text-field--outlined custom-input__field">
                    <input type="password" class="mdc-text-field__input" id="password" required>
                    <i class="material-icons mdc-text-field__icon toggle-password" tabindex="0"
                       role="button">visibility</i>
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label for="password" class="mdc-floating-label"><?php _e('Password', 'ndp'); ?></label>
                        </div>
                        <div class="mdc-notched-outline__trailing">
                            <i class="material-icons error-icon" aria-hidden="true"><?php _e('error', 'ndp'); ?></i>
                        </div>
                    </div>
                </div>
                <p class="registration__condition registration__condition-characters">
                    <svg class="svg-error" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.0625 10.5L0 9.4375L3.9375 5.5L0 1.5625L1.0625 0.5L5 4.4375L8.9375 0.5L10 1.5625L6.0625 5.5L10 9.4375L8.9375 10.5L5 6.5625L1.0625 10.5Z" fill="#BA1A1A"/>
                    </svg>
                    <svg class="svg-ok" width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.22933 8.5625L0.708496 5.02083L1.75016 3.97917L4.22933 6.4375L10.2502 0.4375L11.2918 1.5L4.22933 8.5625Z" fill="#77777A"/>
                    </svg>
                    <span><?php _e('at least 8 characters', 'ndp'); ?></span>
                </p>
                <p class="registration__condition registration__condition-small">
                    <svg class="svg-error" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.0625 10.5L0 9.4375L3.9375 5.5L0 1.5625L1.0625 0.5L5 4.4375L8.9375 0.5L10 1.5625L6.0625 5.5L10 9.4375L8.9375 10.5L5 6.5625L1.0625 10.5Z" fill="#BA1A1A"/>
                    </svg>
                    <svg class="svg-ok" width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.22933 8.5625L0.708496 5.02083L1.75016 3.97917L4.22933 6.4375L10.2502 0.4375L11.2918 1.5L4.22933 8.5625Z" fill="#77777A"/>
                    </svg>
                    <span><?php _e('small letter', 'ndp'); ?></span>
                </p>
                <p class="registration__condition registration__condition-capital">
                    <svg class="svg-error" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.0625 10.5L0 9.4375L3.9375 5.5L0 1.5625L1.0625 0.5L5 4.4375L8.9375 0.5L10 1.5625L6.0625 5.5L10 9.4375L8.9375 10.5L5 6.5625L1.0625 10.5Z" fill="#BA1A1A"/>
                    </svg>
                    <svg class="svg-ok" width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.22933 8.5625L0.708496 5.02083L1.75016 3.97917L4.22933 6.4375L10.2502 0.4375L11.2918 1.5L4.22933 8.5625Z" fill="#77777A"/>
                    </svg>
                    <span><?php _e('capital letter', 'ndp'); ?></span>
                </p>
                <p class="registration__condition registration__condition-special">
                    <svg class="svg-error" width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1.0625 10.5L0 9.4375L3.9375 5.5L0 1.5625L1.0625 0.5L5 4.4375L8.9375 0.5L10 1.5625L6.0625 5.5L10 9.4375L8.9375 10.5L5 6.5625L1.0625 10.5Z" fill="#BA1A1A"/>
                    </svg>
                    <svg class="svg-ok" width="12" height="9" viewBox="0 0 12 9" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M4.22933 8.5625L0.708496 5.02083L1.75016 3.97917L4.22933 6.4375L10.2502 0.4375L11.2918 1.5L4.22933 8.5625Z" fill="#77777A"/>
                    </svg>
                    <span><?php _e('special character', 'ndp'); ?></span>
                </p>
                <p class="registration__error-message" id="registration__error-message"><?php _e('Must be at least 8 characters', 'ndp'); ?></p>
                <div class="mdc-text-field mdc-text-field--outlined custom-input__field">
                    <input type="password" class="mdc-text-field__input" id="password-confirm" required>
                    <i class="material-icons mdc-text-field__icon toggle-password-confirm" tabindex="0" role="button">visibility</i>
                    <div class="mdc-notched-outline">
                        <div class="mdc-notched-outline__leading"></div>
                        <div class="mdc-notched-outline__notch">
                            <label for="password" class="mdc-floating-label"><?php _e('Confirm Password', 'ndp'); ?></label>
                        </div>
                        <div class="mdc-notched-outline__trailing">
                            <i class="material-icons error-icon" aria-hidden="true"><?php _e('error', 'ndp'); ?></i>
                        </div>
                    </div>
                </div>
                <span class="registration__error-message" id="registration__error-message__strength"><?php _e('Weak password', 'ndp'); ?></span>
                <span class="registration__error-message" id="registration__error-message__doNotMatch"><?php _e('Passwords do not match', 'ndp'); ?></span>
                <button class="registration__form-button"><?php _e('Create password', 'ndp'); ?></button>
            </form>
        </div>

    </div>
</section>
<script>
    $(document).ready(function () {
        // $('#email').width($('.custom-input__field').width());
        let errorCharacters = true;
        let errorSmall = true;
        let errorCapital = true;
        let errorSpecial = true;
        const passwordInput = $('#password');

        passwordInput.on('input', function () {
            let password = $(this).val();
            let $charactersMessage = $('.registration__condition-characters');
            let $smallMessage = $('.registration__condition-small');
            let $capitalMessage = $('.registration__condition-capital');
            let $specialMessage = $('.registration__condition-special');

            if (password && password.length >= 8 && /[0-9]/.test(password)) {
                $charactersMessage.find('.svg-ok').show();
                $charactersMessage.find('.svg-error').hide();
                errorCharacters = false;
            } else {
                $charactersMessage.find('.svg-ok').hide();
                $charactersMessage.find('.svg-error').show();
                errorCharacters = true;
            }

            if (password && /[a-z]/.test(password)) {
                $smallMessage.find('.svg-ok').show();
                $smallMessage.find('.svg-error').hide();
                errorSmall = false;
            } else {
                $smallMessage.find('.svg-ok').hide();
                $smallMessage.find('.svg-error').show();
                errorSmall = true;
            }

            if (password && /[A-Z]/.test(password)) {
                $capitalMessage.find('.svg-ok').show();
                $capitalMessage.find('.svg-error').hide();
                errorCapital = false;
            } else {
                $capitalMessage.find('.svg-ok').hide();
                $capitalMessage.find('.svg-error').show();
                errorCapital = true;
            }

            if (password && /[!@#$%^&*_]/.test(password)) {
                $specialMessage.find('.svg-ok').show();
                $specialMessage.find('.svg-error').hide();
                errorSpecial = false;
            } else {
                $specialMessage.find('.svg-ok').hide();
                $specialMessage.find('.svg-error').show();
                errorSpecial = true;
            }
        });

        var newUser = false;

        $('#email').on('blur', function(event) {
            let $target = $(event.target);
            let $field = $target.closest('.custom-input__field');
            let email = $target.val().trim();
            let errorEmail = /@[^\.]+\.ru/.test(email);
            let validEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email);
            if (errorEmail || !validEmail) {
                setTimeout(function() {
                    $field.addClass('mdc-text-field--invalid');
                    $field.find('.material-icons.error-icon').show()
                }, 100)
            } else {
                $field.removeClass('mdc-text-field--invalid');
                $field.find('.material-icons.error-icon').hide();

                let data = {
                    action: 'checkIfUserExists',
                    email: email,
                };

                let $errorMessage = $('#email-error-message');

                email && $.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: data,
                    success: function(response) {
                        // console.log(response);
                        if (response && response.hasOwnProperty('message') && response['message'] !== 'ok') {
                            $errorMessage.parent().css({opacity: 1, border: 'none'});
                            $errorMessage.show();
                            $errorMessage.text(response['message']);
                            $field.addClass('mdc-text-field--invalid');
                            $field.find('.material-icons.error-icon').show();
                            newUser = false;
                        } else {
                            $errorMessage.parent().css('opacity', 0);
                            $errorMessage.hide();
                            $field.removeClass('mdc-text-field--invalid');
                            $field.find('.material-icons.error-icon').hide();
                            newUser = true;
                        }
                    },
                    error: function (jqXHR, exception) {
                        // console.log('error');
                        // console.log(jqXHR);
                        // console.log(exception);
                    },
                })
            }
        });

        $('#form__create-password').submit(function (e) {
            e.preventDefault();

            var emailInput = $('#email');
            let emailInputRequired = emailInput.length? emailInput.prop('required') : false;
            let validEmail = true;
            let errorEmail = false;
            var email = '';
            if(emailInput.val()){
                email = $('#email').val().trim();
            }
            if (emailInputRequired) {
                email = emailInput.val().trim() || '';
                errorEmail = /@[^\.]+\.ru/.test(email);
                validEmail = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/.test(email);
            } else {
                newUser = true;
            }

            var password = $('#password').val().trim();
            var confirmPassword = $('#password-confirm').val();

            // Проверка совпадения паролей перед отправкой
            if (password !== confirmPassword) {
                $('#registration__error-message__doNotMatch').show();
                return;
            }
            if (!password || errorCharacters || errorSmall || errorCapital || errorSpecial || errorEmail || !validEmail || !newUser) {
                return;
            }

            let req;
            if(email.length){
                 req =  JSON.stringify({password: password, confirm_password: confirmPassword,email:email});
            }else{
                 req = JSON.stringify({password: password, confirm_password: confirmPassword})
            }
            // console.log('req', req);

            // Скрыть сообщение об ошибке, если оно было показано ранее
            $('.registration__error-message').hide();

            // Отправка запроса на обновление пароля
            $.ajax({
                url: '/wp-json/custom/v1/update-password/',
                type: 'POST',
                contentType: 'application/json',
                headers: {
                    'X-WP-Nonce': '<?php echo wp_create_nonce('wp_rest'); ?>'  // Add the nonce here
                },
                data: req,
                success: function (response) {
                    console.log(response);
                    // Переадресация после успешного обновления пароля
                    window.location.href = '/dashboard?dia_verify=1';
                },
                error: function (response) {
                    console.error(response);
                    if (response && response.status === 500) {
                        // Проверяем, содержит ли ответ сервера информацию о том, что email существует
                        var responseText = response.responseText || "";
                        if (responseText.includes("email exists")) { // замените это условие в соответствии с фактическим ответом сервера
                            $('#email-error-message').text('<?php _e('Email exists','ndp');?>').show();
                        } else {
                            // Обработка других ошибок
                        }
                    } else {
                        // Обработка других ошибок
                    }
                }
            });
        });
    });

</script>
<style>
    input[type="password"] {
        margin-top: 0 !important;
    }
    form#form__create-password input {
        margin-top: 0;
    }
    input#password {
        height: 47px;
        position: relative;
        top: 7px;
        left: -15px;
        padding-left: 15px;
    }
    .svg-ok {
        display: none;
    }
    .custom-input__email {
        margin-bottom: 20px;
    }
    .custom-input__email .material-icons {
        width: 20px;
        position: absolute;
        right: 0;
    }
    #email-error-message {
        position: absolute;
        bottom: -20px;
        left: 0;
    }
</style>
<?php get_footer(); ?>
