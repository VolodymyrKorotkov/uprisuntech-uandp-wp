<div class="cart-dropdown__overlay">
 <div class="cart-dropdown">
  <div class="cart-dropdown__header">
    <div class="cart-dropdown__header__text">
      <h2 class="cart-dropdown__title">Approve solutions</h2>
      <span class="cart-dropdown__item__amount">(2 items)</span>
    </div>
    <button class="cart-dropdown__close"></button>
  </div>
  <div class="cart-dropdown-block">
    <div class="cart-dropdown__item">
      <div class="cart-dropdown__item__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/buttons/solution-1.png" alt="solution-photo"></div>
      <h3 class="cart-dropdown__item__title">PH1800 PLUS Series (2-5.5KW)</h3>
      <div class="cart-dropdown__item__buttons">
        <div class="cart-dropdown__item__count">
          <button class="cart-dropdown__item__button cart-dropdown__item__minus"></button>
          <span class="cart-dropdown__item__value">1</span>
          <button class="cart-dropdown__item__button cart-dropdown__item__plus"></button>
        </div>
        <button class="cart-dropdown__item__delete"></button>
      </div>
    </div>
    <div class="cart-dropdown__item">
      <div class="cart-dropdown__item__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/buttons/solution-2.png" alt="solution-photo"></div>
      <h3 class="cart-dropdown__item__title">Solar panel</h3>
      <div class="cart-dropdown__item__buttons">
        <div class="cart-dropdown__item__count">
          <button class="cart-dropdown__item__button cart-dropdown__item__minus"></button>
          <span class="cart-dropdown__item__value">1</span>
          <button class="cart-dropdown__item__button cart-dropdown__item__plus"></button>
        </div>
        <button class="cart-dropdown__item__delete"></button>
      </div>
    </div>
  </div>
  <button class="cart-dropdown__button">Create application</button>
 </div>
 </div>
 <div class="static-nav">
  <div class="static-nav-block">
    <div class="static-nav__item">
      <div class="static-nav__button static-nav__button__comprasion"><button></button><span>0</span></div>
      <h4 class="static-nav__title">Comprasion</h4>
    </div>
    <div class="static-nav__item static-nav__item__application">
      <div class="static-nav__button static-nav__button__application"><button></button><span>0</span></div>
      <h4 class="static-nav__title">Application</h4>
    </div>
  </div>
 </div>
 <script>
  $ = jQuery;
  const toggle = function() { 
    $('.static-nav__item__application').click(function() { 
      $('.cart-dropdown').addClass('cart-dropdown__active'); 
      $('.cart-dropdown__overlay').addClass('cart-dropdown__overlay__active');
      $('body').css({'overflow': 'hidden', 'padding-right': '17px'});
    });

    $('.cart-dropdown__close').click(function() {
      $('.cart-dropdown').removeClass('cart-dropdown__active');
      $('.cart-dropdown__overlay').removeClass('cart-dropdown__overlay__active');
      $('body').css({'overflow': '', 'padding-right': ''});
    });
  };
  $(document).ready(toggle);
 </script>