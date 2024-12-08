<?php
/*
Template Name: Confirm email
*/

get_header();
//HTTP_REFERER
$email = !empty($_GET['email'])? $_GET['email'] : '';
$redirect = '';
if (!empty($_SERVER['HTTP_REFERER']) && preg_match('/course\//', $_SERVER['HTTP_REFERER']) !== false && filter_var($_SERVER['HTTP_REFERER'], FILTER_VALIDATE_URL)) {
    $redirect = $_SERVER['HTTP_REFERER'];
}
?>
<section class="confirm-email">
  <div class="container">
    <div class="confirm-email__block col-5">
      <div class="confirm-email__header">
       <h1 class="confirm-email__title"><?php _e('Confirm your email', 'ndp'); ?></h1>
       <p class="confirm-email__text"><?php _e('A 6-digit code has been sent to your email address', 'ndp'); ?> <?php echo $email; ?></p>
      </div>
      <form action="<?= esc_url(admin_url('admin-post.php')) ?>" class="confirm-email__form d-flex flex-column" method="post">
        <input type="hidden" class="user_verification_action" name="user_verification_action" value="autologin">
        <input type="hidden" class="activation_key" name="activation_key" value="">
        <input type="hidden" name="action" value="redirectToDashboard"/>
        <?php if (!empty($redirect)): ?>
        <input type="hidden" name="redirect" value="<?php echo $redirect; ?>"/>
        <?php endif; ?>
        <div class="confirm-email__form-block d-flex">
        <div class="mdc-text-field mdc-text-field--outlined">
        <input type="text" class="mdc-text-field__input" maxlength="1">
        <label class="mdc-floating-label" for="">X</label>
        <div class="mdc-notched-outline">
            <div class="mdc-notched-outline__leading"></div>
            <div class="mdc-notched-outline__notch">
            </div>
            <div class="mdc-notched-outline__trailing"></div>
        </div>
    </div>
        <div class="mdc-text-field mdc-text-field--outlined">
        <input type="text" class="mdc-text-field__input" maxlength="1">
        <label class="mdc-floating-label" for="">X</label>
        <div class="mdc-notched-outline">
            <div class="mdc-notched-outline__leading"></div>
            <div class="mdc-notched-outline__notch">
            </div>
            <div class="mdc-notched-outline__trailing"></div>
        </div>
    </div>
        <div class="mdc-text-field mdc-text-field--outlined">
        <input type="text" class="mdc-text-field__input" maxlength="1">
        <label class="mdc-floating-label" for="">X</label>
        <div class="mdc-notched-outline">
            <div class="mdc-notched-outline__leading"></div>
            <div class="mdc-notched-outline__notch">
            </div>
            <div class="mdc-notched-outline__trailing"></div>
        </div>
    </div>
        <div class="mdc-text-field mdc-text-field--outlined">
        <input type="text" class="mdc-text-field__input" maxlength="1">
        <label class="mdc-floating-label" for="">X</label>
        <div class="mdc-notched-outline">
            <div class="mdc-notched-outline__leading"></div>
            <div class="mdc-notched-outline__notch">
            </div>
            <div class="mdc-notched-outline__trailing"></div>
        </div>
    </div>
        <div class="mdc-text-field mdc-text-field--outlined">
        <input type="text" class="mdc-text-field__input" maxlength="1">
        <label class="mdc-floating-label" for="">X</label>
        <div class="mdc-notched-outline">
            <div class="mdc-notched-outline__leading"></div>
            <div class="mdc-notched-outline__notch">
            </div>
            <div class="mdc-notched-outline__trailing"></div>
        </div>
    </div>
        <div class="mdc-text-field mdc-text-field--outlined">
        <input type="text" class="mdc-text-field__input" maxlength="1">
        <label class="mdc-floating-label" for="">X</label>
        <div class="mdc-notched-outline">
            <div class="mdc-notched-outline__leading"></div>
            <div class="mdc-notched-outline__notch">
            </div>
            <div class="mdc-notched-outline__trailing"></div>
        </div>
    </div>
</div>
    <span class="confirm-email__error-message"><?php _e('Wrong code', 'ndp'); ?></span>
        <button type="submit" class="confirm-email__form-button"><?php _e('Confirm', 'ndp'); ?></button>
          <div class="confirm-email__resend"><span><?php _e('Resend verification code:', 'ndp'); ?></span><span>In <span id="counter">59</span> seconds</span></div>
      </form>
    </div>

      <?php echo do_shortcode('[uv_resend_verification_form]'); ?>

    <!-- <div class="confirm-email__success">
      <div class="confirm-email__success-image">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/confirm-email/check-circle.svg" alt="check-circle">
      </div>
      <h2 class="confirm-email__success-title">Email confirmed</h2>
      <p class="confirm-email__success-subtitle">Your email has been successfully confirmed. Click below to Account.</p>
      <button class="confirm-email__success-button">Continue</button>
    </div> -->
  </div>
</section>


<script>
    let params = new URLSearchParams(document.location.search);
    $ = jQuery;
    $('#user-verification-resend input[name="email"]').val(params.get('email'));
    $(document).on('click','.confirm-email__resend a',function(e){
        e.preventDefault();
        $('.confirm-email__resend').text('Verification mail has been sent.');
        $('input[value="Resend"]').click();

    });

</script>

<style>
    #user-verification-resend {
        display: none;
    }
</style>
<?php

get_footer();
