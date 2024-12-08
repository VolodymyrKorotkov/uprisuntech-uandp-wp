<?php
/*
Template Name: Success change
*/
wp_enqueue_script('recovery', get_template_directory_uri() . '/assets/js/create-new-password.js', array('jquery'), _S_VERSION, true);
wp_enqueue_style('recovery', get_template_directory_uri() . '/assets/css/create-new-password.css');
get_header();
?>
    <section class="create-new-password">
    <div class="container">
   <div class="create-new-password__success">
      <div class="create-new-password__success-image">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/create-new-password/check-circle.svg" alt="check-circle">
      </div>
      <h2 class="create-new-password__success-title">Password reset</h2>
      <p class="create-new-password__success-subtitle">Your password has been successfully reset. Click below to log in.</p>
      <button onclick="window.location.href='/dashboard'" class="create-new-password__success-button">Continue</button>
    </div>
    </div>
    </section>
<?php

get_footer();
