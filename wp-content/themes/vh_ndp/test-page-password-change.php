<?php
/*
Template Name: Password change
*/

get_header('home');
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/material-components-web.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/password-change.css">

<section class="password-change">
  <div class="container">
    <div class="password-change__block col-12 col-sm-8">
      <nav class="breadcrumb">
        <div class="breadcrumb-block">
          <a href="">Dashboard</a>
          <a href="">Profile settings</a>
          <span>Password change</span>
        </div>
      </nav>
      <div class="password-change__title">
        <a href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M15.7049 7.41L14.2949 6L8.29492 12L14.2949 18L15.7049 16.59L11.1249 12L15.7049 7.41Z" fill="#2A59BD"/>
          </svg>
        </a>
        <h1>Password change</h1>
      </div>
      <form action="#" class="password-change__form d-flex flex-column">
        <div class="password-change__form-block">
        <div class="mdc-text-field mdc-text-field--outlined">
        <input type="password" class="mdc-text-field__input password-input-field" id="old-password" required>
        <i class="material-icons mdc-text-field__icon toggle-password" tabindex="0" role="button">visibility</i>
        <div class="mdc-notched-outline">
            <div class="mdc-notched-outline__leading"></div>
            <div class="mdc-notched-outline__notch">
                <label for="old-password" class="mdc-floating-label">Old Password</label>
            </div>
            <div class="mdc-notched-outline__trailing">
            <i class="material-icons error-icon" aria-hidden="true">error</i>
            </div>
          </div>
        </div>
        <span class="error-message">Incorrect the old password</span>
        <div class="mdc-text-field mdc-text-field--outlined">
        <input type="password" class="mdc-text-field__input password-input-field" id="new-password" required>
        <i class="material-icons mdc-text-field__icon toggle-password" tabindex="0" role="button">visibility</i>
        <div class="mdc-notched-outline">
            <div class="mdc-notched-outline__leading"></div>
            <div class="mdc-notched-outline__notch">
                <label for="new-password" class="mdc-floating-label">New password</label>
            </div>
            <div class="mdc-notched-outline__trailing">
            <i class="material-icons error-icon" aria-hidden="true">error</i>
            </div>
          </div>
        </div>
        <span class="password-change__form-condition">Must be at least 8 characters</span>
        <span class="error-message">Must be at least 8 characters</span>
        <div class="mdc-text-field mdc-text-field--outlined">
        <input type="password" class="mdc-text-field__input password-input-field" id="confirm-password" required>
        <i class="material-icons mdc-text-field__icon toggle-password" tabindex="0" role="button">visibility</i>
        <div class="mdc-notched-outline">
            <div class="mdc-notched-outline__leading"></div>
            <div class="mdc-notched-outline__notch">
                <label for="confirm-password" class="mdc-floating-label">Confirm Password</label>
            </div>
            <div class="mdc-notched-outline__trailing">
            <i class="material-icons error-icon" aria-hidden="true">error</i>
            </div>
          </div>
        </div>
        <span class="error-message">Passwords do not match</span>
        </div>
        <div class="password-change__form-buttons">
          <button class="password-change__form-cancel">Cancel</button>
          <button class="password-change__form-save">Save</button>
        </div>
      </form>
    </div>
  </div>
</section>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/material-components-web.min.js?ver=1.0.0"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/password-change.js"></script>


<?php

get_footer();