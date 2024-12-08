<?php
// print_r($args);
?>

<div class='join-the-community <?= isset($args['bg']) && $args['bg']? 'bg' : ''?>'>
  <div class='row'>
    <div class='col-md-6'>
      <div class='join-the-community-left'>
        <img src='<?php bloginfo('template_url');?>/assets/img/financing/Graphic_Elements.png'
          class='join-the-community-left-bg' />
        <div class='join-the-community-left-title'> <?php _e('Join the community!','ndp'); ?> </div>
        <p><?php _e('Get the latest news and exclusive offers. Subscribe now with your phone or email. Stay connected, stay informed.','ndp'); ?></p>

       <?php
       $current_language = apply_filters('wpml_current_language', NULL);
       if($current_language=="en"){
           $link = "/en/contacts/";
       }else{
           $link = "/contacts/";
       }

       ?>

        <a href="<?php echo $link; ?>" class="btn btn_bg_primary"><img
            src='<?php bloginfo('template_url');?>/assets/img/financing/mail.svg' /><?php _e('Subscribe to newsletter','ndp'); ?>
        </a>
      </div>
    </div>
    <div class='col-md-6'>
      <div class='join-the-community-right'>
        <img src='<?php bloginfo('template_url');?>/assets/img/financing/img.png' />
        <svg class='join-the-community-right-bg-desctop' xmlns="http://www.w3.org/2000/svg" width="347" height="228" viewBox="0 0 347 228" fill="none">
          <path d="M0.0407104 -9.99999C32 134 125 228 360.5 228V-9.99999H0.0407104Z" fill="<?= isset($args['bg']) && $args['bg'] ? '#B2C5FF' : '#EEF0FF'?>"/>
        </svg>
        <!-- <img src='<?php bloginfo('template_url');?>/assets/img/financing/ellipse_bg.png'  /> -->
        <!-- <img src='<?php bloginfo('template_url');?>/assets/img/financing/mobile_bg.png' class='join-the-community-right-bg-mobile' /> -->
        <svg class='join-the-community-right-bg-mobile' xmlns="http://www.w3.org/2000/svg" width="270" height="179" viewBox="0 0 270 179" fill="none">
          <path d="M0 179C23.9695 71 93.7195 0.5 270.344 0.5V179H0Z" fill="<?= isset($args['bg']) && $args['bg'] ? '#B2C5FF' : '#EEF0FF'?>"/>
        </svg>
      </div>
    </div>
  </div>
</div>
