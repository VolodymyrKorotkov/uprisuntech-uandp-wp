<?php
/**
 * Password change
 */


$current_lang = apply_filters( 'wpml_current_language', 'uk' );
?>

<section class="password-change">
    <div class="container">
        <div class="password-change__block col-12 col-sm-8">
            <nav class="breadcrumb">
                <?php yoast_breadcrumb(); ?>
            </nav>
            <div class="password-change__title">
                <a href="<?php echo get_permalink( llms_get_page_id( 'myaccount' ) ); ?>edit-account">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M15.7049 7.41L14.2949 6L8.29492 12L14.2949 18L15.7049 16.59L11.1249 12L15.7049 7.41Z" fill="#2A59BD"/>
                    </svg>
                </a>
                <h1><?php _e('Password change', 'ndp'); ?></h1>
            </div>
            <form action="#" class="password-change__form d-flex flex-column">
                <div class="password-change__form-block">
                    <div class="mdc-text-field mdc-text-field--outlined">
                        <input type="password" class="mdc-text-field__input password-input-field" name="old_password" id="old_password" required>
                        <i class="material-icons mdc-text-field__icon toggle-password" tabindex="0" role="button">visibility</i>
                        <div class="mdc-notched-outline">
                            <div class="mdc-notched-outline__leading"></div>
                            <div class="mdc-notched-outline__notch">
                                <label for="old-password" class="mdc-floating-label"><?php _e('Old Password', 'ndp'); ?></label>
                            </div>
                            <div class="mdc-notched-outline__trailing">
                                <i class="material-icons error-icon" aria-hidden="true">error</i>
                            </div>
                        </div>
                    </div>

                    <div class="mdc-text-field mdc-text-field--outlined">
                        <input type="password" class="mdc-text-field__input password-input-field" name="password" id="password" required>
                        <i class="material-icons mdc-text-field__icon toggle-password" tabindex="0" role="button">visibility</i>
                        <div class="mdc-notched-outline">
                            <div class="mdc-notched-outline__leading"></div>
                            <div class="mdc-notched-outline__notch">
                                <label for="new-password" class="mdc-floating-label"><?php _e('New password', 'ndp'); ?></label>
                            </div>
                            <div class="mdc-notched-outline__trailing">
                                <i class="material-icons error-icon" aria-hidden="true">error</i>
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

                    <div class="mdc-text-field mdc-text-field--outlined">
                        <input type="password" class="mdc-text-field__input password-input-field" name="confirm_password" id="confirm_password" required>
                        <i class="material-icons mdc-text-field__icon toggle-password" tabindex="0" role="button">visibility</i>
                        <div class="mdc-notched-outline">
                            <div class="mdc-notched-outline__leading"></div>
                            <div class="mdc-notched-outline__notch">
                                <label for="confirm-password" class="mdc-floating-label"><?php _e('Confirm Password', 'ndp'); ?></label>
                            </div>
                            <div class="mdc-notched-outline__trailing">
                                <i class="material-icons error-icon" aria-hidden="true">error</i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="password-change__form-buttons">
                    <a href="<?php echo get_permalink( llms_get_page_id( 'myaccount' ) ); ?>edit-account" class="password-change__form-cancel"><?php _e('Cancel', 'ndp'); ?></a>
                    <button type="submit" class="password-change__form-save"><?php _e('Save', 'ndp'); ?></button>
                </div>
                <?php wp_nonce_field( 'password_change', 'password_change_nonce' ); ?>
            </form>
        </div>
    </div>
</section>
