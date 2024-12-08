<?php
  $currentUrl = $_SERVER['REQUEST_URI'];
  
  $isUA = false;
  $lng_url;
  $language_code;
  $languages = icl_get_languages('skip_missing=0&orderby=code');
  if(!empty($languages)){
      foreach($languages as $l){
          if($l['active']){
              $lng_url = $l['url'];
              $language_code = $l['language_code'];
          }
      }
  }
  $isUA = $language_code == 'uk';
?>
<div class="ticker <?= $isUA ? "long" : ""?>">
  <div class="ticker-title">
    <div class='ticker-title-item'>
      <img src='<?php bloginfo('template_url');?>/assets/img/home/logo.png' />
      <?php _e('Ukrainian National Decarbonization Platform', 'ndp') ?>
    </div>
    <div class='ticker-title-item'>
      <img src='<?php bloginfo('template_url');?>/assets/img/home/logo.png' />
      <?php _e('Ukrainian National Decarbonization Platform', 'ndp') ?>
    </div>
    <div class='ticker-title-item'>
      <img src='<?php bloginfo('template_url');?>/assets/img/home/logo.png' />
      <?php _e('Ukrainian National Decarbonization Platform', 'ndp') ?>
    </div>
    <div class='ticker-title-item'>
      <img src='<?php bloginfo('template_url');?>/assets/img/home/logo.png' />
      <?php _e('Ukrainian National Decarbonization Platform', 'ndp') ?>
    </div>
    <div class='ticker-title-item'>
      <img src='<?php bloginfo('template_url');?>/assets/img/home/logo.png' />
      <?php _e('Ukrainian National Decarbonization Platform', 'ndp') ?>
    </div>
    <div class='ticker-title-item'>
      <img src='<?php bloginfo('template_url');?>/assets/img/home/logo.png' />
      <?php _e('Ukrainian National Decarbonization Platform', 'ndp') ?>
    </div>
    <div class='ticker-title-item'>
      <img src='<?php bloginfo('template_url');?>/assets/img/home/logo.png' />
      <?php _e('Ukrainian National Decarbonization Platform', 'ndp') ?>
    </div>
    <div class='ticker-title-item'>
      <img src='<?php bloginfo('template_url');?>/assets/img/home/logo.png' />
      <?php _e('Ukrainian National Decarbonization Platform', 'ndp') ?>
    </div>
    <div class='ticker-title-item'>
      <img src='<?php bloginfo('template_url');?>/assets/img/home/logo.png' />
      <?php _e('Ukrainian National Decarbonization Platform', 'ndp') ?>
    </div>
    <div class='ticker-title-item'>
      <img src='<?php bloginfo('template_url');?>/assets/img/home/logo.png' />
      <?php _e('Ukrainian National Decarbonization Platform', 'ndp') ?>
    </div>
  </div>
</div>