<?php
/*
Template Name: Registration LMS
*/

get_header();
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/material-components-web.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/registration.css">

<section class="registration">
  <div class="container">
    <div class="registration__block col-5">
      <div class="registration__header">
       <h1 class="registration__title">NDP Account</h1>
       <div class="registration__tabs d-flex align-center">
        <span class="registration__tabs-item col-6">Authorization</span>
        <span class="registration__tabs-item tabs__item-active col-6">Registration</span>
       </div>
      </div>
      <form action="#" class="registration__form d-flex flex-column">
      <div class="mdc-text-field mdc-text-field--outlined">
        <input type="text" class="mdc-text-field__input" id="email" required>
        <div class="mdc-notched-outline">
            <div class="mdc-notched-outline__leading"></div>
            <div class="mdc-notched-outline__notch">
                <label for="email" class="mdc-floating-label">Email (login)</label>
            </div>
            <div class="mdc-notched-outline__trailing">
            <i class="material-icons error-icon" aria-hidden="true">error</i>
            </div>
        </div>
    </div>
      <div class="mdc-text-field mdc-text-field--outlined">
        <input type="password" class="mdc-text-field__input" id="password" required>
        <i class="material-icons mdc-text-field__icon toggle-password" tabindex="0" role="button">visibility</i>
        <div class="mdc-notched-outline">
            <div class="mdc-notched-outline__leading"></div>
            <div class="mdc-notched-outline__notch">
                <label for="password" class="mdc-floating-label">Password</label>
            </div>
            <div class="mdc-notched-outline__trailing">
            <i class="material-icons error-icon" aria-hidden="true">error</i>
            </div>
          </div>
        </div>
        <p class="registration__condition">Must be at least 8 characters</p>
      <div class="mdc-text-field mdc-text-field--outlined">
        <input type="password" class="mdc-text-field__input" id="password-confirm" required>
        <i class="material-icons mdc-text-field__icon toggle-password-confirm" tabindex="0" role="button">visibility</i>
        <div class="mdc-notched-outline">
            <div class="mdc-notched-outline__leading"></div>
            <div class="mdc-notched-outline__notch">
                <label for="password" class="mdc-floating-label">Confirm Password</label>
            </div>
            <div class="mdc-notched-outline__trailing">
            <i class="material-icons error-icon" aria-hidden="true">error</i>
            </div>
        </div>
    </div>
        <a href="#" class="registration__form-forgot">Forgot password?</a>
        <button class="registration__form-button">Sign up</button> 
        <span class="registration__error-message">Wrong email or password</span>
      </form>
    </div>
  </div>
</section>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/material-components-web.min.js?ver=1.0.0"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/registration.js"></script>


<?php

get_footer();