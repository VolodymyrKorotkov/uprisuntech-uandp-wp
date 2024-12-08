<?php
/*
Template Name: Product
*/

get_header();
?>

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/product.css">

 <nav class="breadcrumb">
  <div class="container">
    <div class="breadcrumb-block">
      <a href="">Main page</a>
      <a href="">Marketplace</a>
      <a href="">Solar Power Systems</a>
      <span>PH1800 PLUS Series (2-5.5KW)</span>
    </div>
  </div>
 </nav>
 <section class="product">
  <div class="container">
    <div class="product-block d-flex justify-content-between flex-column flex-md-row">
      <div class="photo col-12 col-md-6">
        <div class="photo__main"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/gallery-1.png" alt="photo-1"></div>
        <div class="photo__gallery">
        <div class="photo__arrow__left">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/arrow-left.svg" alt="arrow-left">
        </div>
        <div class="photo__gallery-block">
          <div class="photo__gallery__item photo__gallery__item__active">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/gallery-2.png" alt="photo-2">
          </div>
          <div class="photo__gallery__item">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/gallery-3.png" alt="photo-3">
          </div>
          <div class="photo__gallery__item">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/gallery-4.png" alt="photo-4">
          </div>
        </div>
        <div class="photo__arrow__right">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/arrow-right.svg" alt="arrow-right">
        </div>
        </div>
      </div>
      <div class="product__main col-12 col-md-6">
        <h1 class="product__title">PH1800 PLUS Series (2-5.5KW)</h1>
        <div class="product__subtitle"><span>Solar inverters</span><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/mark-icon-1.png" alt="mark-icon"></div>
        <p class="product__description">PH1800 Plus series hybrid solar inverter, it can realize self-consumption and feed-in to the grid from solar energy with best solution according to your setting. During the daytime solar power can run your home appliances and if there is extra solar power it will feed-in to the grid or you can choose to save them on the battery to backup when power failure or nighttime.</p>
        <div class="product__buttons"><a href="" class="btn btn_bg_primary product__buttons__add">Add to cart</a><a href="" class="btn product__buttons__balance"></a></div>
        <div class="product__howitworks">
                        <p class="product__howitworks__title d-flex align-items-center">
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM9 15V13H11V15H9ZM9 5V11H11V5H9Z" fill="#2A59BD"></path>
                            </svg>
                            <span class="ms-2">How it works</span></p>
                        <p class="product__howitworks__content">
                        <?php _e('This section contains information about the vendors and solutions presented on the platform. Once you have selected several solutions, you can compare them with each other or add them to your funding application.','ndp'); ?>
                        </p>
                    </div>
      </div>
    </div>
  </div>
 </section>
 <section class="info">
  <div class="container">
    <div class="info-block d-flex justify-content-between flex-column flex-md-row">
    <div class="info-block__left col-12 col-md-6">
      <div class="about">
      <h2 class="about__title">About solution</h2>
      <p class="about__subtitle">PH1800 Plus series hybrid solar inverter, it can realize self-consumption and feed-in to the grid from solar energy with best solution according to your setting. During the daytime solar power can run your home appliances and if there is extra solar power it will feed-in to the grid or you can choose to save them on the battery to backup when power failure or nighttime.</p>
      <h4 class="about__features">Features:</h4>
      <ul class="about-list">
        <li class="about-list__item">Pure sine wave output</li>
        <li class="about-list__item">Self-consumption and Feed-in to the grid</li>
        <li class="about-list__item">Programmable supply priority for PV, Battery or Grid</li>
        <li class="about-list__item">User-adjustable battery charging current suits different types of batteries</li>
        <li class="about-list__item">Programmable multiple operation modes: Grid-tie, off-grid and grid-tie with backup</li>
        <li class="about-list__item">Monitoring software & Wifi Kit for real-time status display and control</li>
        <li class="about-list__item">Parallel operation up to 3 units</li>
      </ul>
      <div class="about__link">
      <a href="">Vendor website</a>
      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
  <mask id="mask0_502_6527" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="18" height="18">
    <rect width="18" height="18" fill="#D9D9D9"/>
  </mask>
  <g mask="url(#mask0_502_6527)">
    <path d="M4.0502 15.3C3.67895 15.3 3.36113 15.1678 3.09676 14.9034C2.83238 14.639 2.7002 14.3212 2.7002 13.95V4.04995C2.7002 3.6787 2.83238 3.36089 3.09676 3.09651C3.36113 2.83214 3.67895 2.69995 4.0502 2.69995H9.0002V4.04995H4.0502V13.95H13.9502V8.99995H15.3002V13.95C15.3002 14.3212 15.168 14.639 14.9036 14.9034C14.6393 15.1678 14.3214 15.3 13.9502 15.3H4.0502ZM7.25645 11.7L6.3002 10.7437L12.9939 4.04995H10.8002V2.69995H15.3002V7.19995H13.9502V5.0062L7.25645 11.7Z" fill="#2A59BD"/>
  </g>
 </svg>
      </div>
    </div>
      <div class="files"><h2 class="files__title">Files</h2>
      <div class="files-block">
        <div class="files__item">
          <div class="files__item__img"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/pdf-icon.svg" alt="pdf-icon"></div>
          <div class="files__item__text">
          <span class="files__item__name">All_Solar_Companies.pdf</span>
          <span class="files__item__size">2.45 MB</span>
        </div>
        </div>
        <div class="files__item">
          <div class="files__item__img"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/pdf-icon.svg" alt="pdf-icon"></div>
          <div class="files__item__text">
          <span class="files__item__name">All_Solar_Companies.pdf</span>
          <span class="files__item__size">2.45 MB</span>
        </div>
        </div>
        <div class="files__item">
          <div class="files__item__img"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/pdf-icon.svg" alt="pdf-icon"></div>
          <div class="files__item__text">
          <span class="files__item__name">All_Solar_Companies.pdf</span>
          <span class="files__item__size">2.45 MB</span>
        </div>
        </div>
      </div></div>
    </div>
    <div class="info-block__right col-12 col-md-6">
      <div class="properties">
        <h2 class="properties__title">Properties</h2>
      <ul class="properties-list">
        <li class="properties-list__item">
          <span>Nominal Battery System Voltage</span><strong>24VDC</strong>
        </li>
      </ul>
      <h4 class="properties-list__title">Inverter output</h4>
      <ul class="properties-list">
        <li class="properties-list__item"><span>Rated Power</span><strong>2000W</strong></li>
        <li class="properties-list__item"><span>Surge Power</span><strong>4000W</strong></li>
        <li class="properties-list__item"><span>Waveform</span><strong>Pure Sine Wave</strong></li>
        <li class="properties-list__item"><span>AC Voltage Regulation (Batt.Mode)</span><strong>220VAC~240VAC(setting)</strong></li>
        <li class="properties-list__item"><span>Electric Current</span><strong>8.7A</strong></li>
        <li class="properties-list__item"><span>Inverter Efficiency(Peak)</span><strong>93%</strong></li>
        <li class="properties-list__item"><span>Transfer Time</span><strong>10ms(UPS /VDE4105 ) 20ms( APL)</strong></li>
      </ul>
      <h4 class="acinput__title">AC input</h4>
      <ul class="acinput-list">
        <li class="acinput-list__item"><span>Voltage</span><strong>230VAC</strong></li>
        <li class="acinput-list__item"><span>Selectable Voltage Range</span><strong>170~280VAC(UPS), 90~280VAC(APL), 184~253VAC(VDE4105)</strong></li>
        <li class="acinput-list__item"><span>Frequency Range</span><strong>50Hz / 60Hz (Auto Sensing)</strong></li>
      </ul>
      <h4 class="battery__title">Battery</h4>
      <ul class="battery-list">
        <li class="battery-list__item"><span>Normal Voltage</span><strong>24VDC</strong></li>
        <li class="battery-list__item"><span>Floating Charge Voltage</span><strong>27.4VDC</strong></li>
        <li class="battery-list__item"><span>Overcharge Protection</span><strong>30VDC</strong></li>
      </ul>
    </div>
    </div>
    </div>
  </div>
 </section>
 <section class="related">
  <div class="container">
    <div class="related-block">
      <h2 class="related__title">Related Case Studies</h2>
      <div class="related__slider">
        <div class="related__slider-block owl-carousel" id="owl1">       
          <div class="related__slider__item">       
            <div class="related__slider__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/related-1.jpg" alt="photo-1"></div>
            <div class="related__slider__text">
              <h4 class="related__slider__title">CleanCapital secures $500M funding commitment to expand distributed solar and storage platform</h4>
              <div class="related__slider__type">
                <div class="related__slider__type__item related__slider__type__item__current"><span>Global</span></div>
                <div class="related__slider__type__item"><span>Storage</span></div>
                <div class="related__slider__type__item"><span>+2</span></div>
              </div>
              <p class="related__slider__description">CleanCapital secures $500M funding commitment to expand distributed solar and storage platform.</p>
              <div class="related__slider__date">
                <span>31.07.23, </span><span>13:53</span>
              </div> 
            </div>
          </div>
          <div class="related__slider__item">
            <div class="related__slider__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/related-2.jpg" alt="photo-2"></div>
            <div class="related__slider__text">
              <h4 class="related__slider__title">Maine passes bill to jumpstart offshore wind projects</h4>
              <div class="related__slider__type">
                <div class="related__slider__type__item related__slider__type__item__current"><span>Local</span></div>
                <div class="related__slider__type__item"><span>Storage</span></div>
                <div class="related__slider__type__item"><span>+2</span></div>
              </div>
              <p class="related__slider__description">The legislation, which was endorsed by lawmakers July 25, calls for requests for proposals to be issued for 3,000 MW of electricity from offshore wind turbines by 2040</p>
              <div class="related__slider__date">
                <span>31.07.23, </span><span>13:53</span>
              </div>  
            </div>
          </div>
          <div class="related__slider__item">
            <div class="related__slider__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/related-3.jpg" alt="photo-3"></div>
            <div class="related__slider__text">
              <h4 class="related__slider__title">New tech under development to monitor bird and bat contact with wind turbines</h4>
              <div class="related__slider__type">
                <div class="related__slider__type__item related__slider__type__item__current"><span>Local</span></div>
                <div class="related__slider__type__item"><span>Storage</span></div>
                <div class="related__slider__type__item"><span>+2</span></div>
              </div>
              <p class="related__slider__description">New tech under development to monitor bird and bat contact with wind turbines. New tech under development to monitor bird and bat contact with wind turbines</p>
              <div class="related__slider__date">
                <span>31.07.23, </span><span>13:53</span>
              </div>
              </div>
          </div>
          <div class="related__slider__item">
            <div class="related__slider__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/related-3.jpg" alt="photo-3"></div>
            <div class="related__slider__text">
              <h4 class="related__slider__title">New tech under development to monitor bird and bat contact with wind turbines</h4>
              <div class="related__slider__type">
                <div class="related__slider__type__item related__slider__type__item__current"><span>Local</span></div>
                <div class="related__slider__type__item"><span>Storage</span></div>
                <div class="related__slider__type__item"><span>+2</span></div>
              </div>
              <p class="related__slider__description">New tech under development to monitor bird and bat contact with wind turbines. New tech under development to monitor bird and bat contact with wind turbines</p>
              <div class="related__slider__date">
                <span>31.07.23, </span><span>13:53</span>
              </div>
              </div>
          </div>
        </div>
        <div class="related__slider__navigation">
          <div class="related__slider__navigation__dots"> 
          </div>
        </div>
      </div>
    </div>
  </div>
 </section>
 <section class="other">
  <div class="container">
    <div class="other-block">
      <div class="other__header">
        <h2 class="other__title">Other solutions</h2>
        <div class="other__link">
          <a href="">See all solutions</a>
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/arrow-link.svg" alt="arrow">
        </div>
      </div>
      <div class="other__slider">
        <div class="other__slider-block owl-carousel" id="owl2">
          <div class="other__slider__item">
            <div class="other__slider__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/other-1.png" alt="product-photo"></div>
            <div class="other__slider__text">
              <div class="other__slider__type"><span>Solar inverters</span><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/mark-icon-1.png" alt="mark-icon"></div>
              <h4 class="other__slider__title">PH1000 PRO Series (5KW)</h4>
              <p class="other__slider__description">This is a flexible and intelligent energy storage solar inverter with a wide range of MPPT Voltage. Combining functions of off grid and on grid. This hybrid solar inverter can power all kinds of appliances in home or office, and can also be used in power stations.</p>
              <div class="other__slider__buttons"><a href="" class="other__slider__buttons__more">Read more</a><a href="" class="other__slider__buttons__balance"></a><a href="" class="btn btn_bg_primary other__slider__buttons__add">Add to cart</a></div>
            </div>
          </div>
          <div class="other__slider__item">
            <div class="other__slider__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/other-2.png" alt="product-photo"></div>
            <div class="other__slider__text">
              <div class="other__slider__type"><span>Solar inverters</span><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/mark-icon-2.png" alt="mark-icon"></div>
              <h4 class="other__slider__title">GoodWe GW17KN-DT</h4>
              <p class="other__slider__description">The GoodWe SmartDT series, three phase, 2-MPPT, Solar inverter is specially designed for three-phase rooftop systems, the power range of 12kW, 15kW, 17KW and 20kW are ideal for small commercial usage. The integrated two MPPTs allow two-array inputs from different roof orientations. The SDT series inverter is small, light and easy to install. Suitable for both outdoor and indoor installations, this inverter offers a quiet operation due to its fan-less, natural convection cooling.</p>
              <div class="other__slider__buttons"><a href="" class="other__slider__buttons__more">Read more</a><a href="" class="other__slider__buttons__balance"></a><a href="" class="btn btn_bg_primary other__slider__buttons__add">Add to cart</a></div>
            </div>
          </div>
          <div class="other__slider__item">
            <div class="other__slider__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/other-3.png" alt="product-photo"></div>
            <div class="other__slider__text">
              <div class="other__slider__type"><span>Solar inverters</span><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/mark-icon-2.png" alt="mark-icon"></div>
              <h4 class="other__slider__title">GoodWe GW4200D-NS</h4>
              <p class="other__slider__description">GoodWe’s DNS series is a single-phase Residental solar on-grid inverter with excellent compact size, comprehensive software and hardware technology. Manufactured for durability and longevity under modern industrial standards, the DNS series offers high efficiency and class-leading functionality, IP65, dustproofing and waterproofing and a fan-less, low-noise design. Tigo integrated (optional)</p>
              <div class="other__slider__buttons"><a href="" class="other__slider__buttons__more">Read more</a><a href="" class="other__slider__buttons__balance"></a><a href="" class="btn btn_bg_primary other__slider__buttons__add">Add to cart</a></div>
            </div>
          </div>
          <div class="other__slider__item">
            <div class="other__slider__image"><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/other-3.png" alt="product-photo"></div>
            <div class="other__slider__text">
              <div class="other__slider__type"><span>Solar inverters</span><img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/mark-icon-2.png" alt="mark-icon"></div>
              <h4 class="other__slider__title">GoodWe GW4200D-NS</h4>
              <p class="other__slider__description">GoodWe’s DNS series is a single-phase Residental solar on-grid inverter with excellent compact size, comprehensive software and hardware technology. Manufactured for durability and longevity under modern industrial standards, the DNS series offers high efficiency and class-leading functionality, IP65, dustproofing and waterproofing and a fan-less, low-noise design. Tigo integrated (optional)</p>
              <div class="other__slider__buttons"><a href="" class="other__slider__buttons__more">Read more</a><a href="" class="other__slider__buttons__balance"></a><a href="" class="btn btn_bg_primary other__slider__buttons__add">Add to cart</a></div>
            </div>
          </div>
        </div>
        <div class="other__slider__navigation">
          <div class="other__slider__navigation__dots">
          </div>
        </div>
      </div>
    </div>
  </div>
 </section>
 <script>
  $ = jQuery;
  $(document).ready(function(){
    $('#owl1').owlCarousel({
    loop:false,
    margin:24,
    dotsEach:true,
    nav:true,
    dots:true,
    navContainer: ".related__slider__navigation",
    dotsContainer: ".related__slider__navigation__dots",
    navText: ['<img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/arrow-left.svg">', '<img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/arrow-right.svg">'],
    responsive:{
        0:{
            items:1
        },
        575:{
            items:2
        },
        1000:{
            items:3
        }
    }
  })
    $('#owl2').owlCarousel({
    loop:false,
    margin:24,
    dotsEach:true,
    nav:true,
    dots:true,
    navContainer: ".other__slider__navigation",
    dotsContainer: ".other__slider__navigation__dots",
    navText: ['<img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/arrow-left.svg">', '<img src="<?php echo get_template_directory_uri(); ?>/assets/img/product/arrow-right.svg">'],
    responsive:{
        0:{
            items:1
        },
        575:{
            items:2
        },
        1000:{
            items:3
        }
    }
  })
});
  
 </script>
<?php

echo apply_filters( 'the_content', $post->post_content );
?>


<?php

get_footer();
