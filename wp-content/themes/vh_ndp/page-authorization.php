<?php
/*
Template Name: Authorization
*/

get_header();
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/material-components-web.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/authorization.css">

<section class="authorization">
  <div class="container">
    <div class="authorization__block col-5">
      <div class="authorization__header">
       <h1 class="authorization__title">NDP Account</h1>
       <div class="authorization__tabs d-flex align-center">
        <span class="authorization__tabs-item tabs__item-active col-6">Authorization</span>
        <span class="authorization__tabs-item col-6">Registration</span>
       </div>
      </div>
      <form action="#" class="authorization__form d-flex flex-column">
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
        <a href="#" class="authorization__form-forgot">Forgot password?</a>
        <button class="authorization__form-button">Log In</button> 
        <span class="authorization__error-message">Wrong email or password</span>
      </form>
    </div>
  </div>
</section>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/material-components-web.min.js?ver=1.0.0"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/authorization.js"></script>
<?php
echo apply_filters( 'the_content', $post->post_content );
?>


<?php

get_footer();