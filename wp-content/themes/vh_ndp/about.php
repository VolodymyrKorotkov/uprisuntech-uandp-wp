<?php
/*
Template Name: About
*/

get_header();
?>

<div class='about-us'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-6'>
        <div class='about-us-left'>
          <div class='as_breadcrumbs'>
          <?php yoast_breadcrumb();?>
          </div>
          <h1 class='about-us-title'>About Platform</h1>
          <p>
          We are just beginning our journey. Everything you need to create a modern, environmentally 
          friendly energy solution can be found on our Platform. We are the perfect starting point for
           any project to "Start your energy journey with ease and consciousness".<br /><br/> Our expert team 
           collaborates with businesses and communities to seamlessly integrate green solutions, from energy-efficient
            technologies to waste reduction strategies.
          </p>
        </div>
      </div>
      <div class='col-md-6'>
        <div class='about-us-right'>
          <img src='<?php bloginfo('template_url');?>/assets/img/about/about_right.png' />
        </div>
      </div>
    </div>
  </div>
</div>
<div class='about-us-green-energy'>
  <img class='about-us-green-energy-bg'
    src='<?php bloginfo('template_url');?>/assets/img/about/Graphic_Elements_BG.png' />
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='about-us-green-energy-title'>Green energy — is the <span>way to a sustainable</span> future</div>
      </div>
    </div>
    <div class='row'>
      <div class='col-md-4'>
        <p class='about-us-green-energy-text1'>
          Green energy is a key response to the challenges of climate change and sustainable development.
        </p>
      </div>
      <div class='col-md-8'>
        <p class='about-us-green-energy-text2'>
          It is focused on the use of renewable energy sources such as solar, wind, hydropower and others to generate
          electricity without emitting greenhouse gases and other harmful substances. This is not only a way to reduce
          environmental impact, but also to ensure a stable energy supply in the future.<br /><br />
          One of the most notable green energy <a href='/marketplace' target='_blank'>solutions</a> is the development of solar and wind power
          plants. Solar panels convert sunlight into electricity, while wind turbines use wind energy to generate
          electricity. These technologies are becoming more efficient and affordable, helping to reduce dependence on
          fossil fuels and reduce carbon emissions.
        </p>
      </div>
    </div>
      <div class='row about-us-green-energy-items'>
          <?php
          $energy_green_items = get_field('greenenergyitem');
          if ($energy_green_items) {
              $counter=1;
              foreach ($energy_green_items as $item) {
                  $greenEnergyBlock = $item['greenenergyblock'];
                  ?>
                  <div class="col-md-3">
                      <div class="about-us-green-energy-item op<?php echo $counter;?>" style="background-color: <?php echo $greenEnergyBlock['green_energy_item_color']; ?>;">
                          <img src="<?php echo $greenEnergyBlock['green_energy_item_img']; ?>" />
                          <p><?php echo $greenEnergyBlock['green_energy_item_text']; ?></p>
                      </div>
                  </div>
                  <?php
                  $counter++;
              }
          }
          ?>
      </div>
  </div>
</div>
<div class='about-us-key-organizations'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='about-us-key-organizations-title'>Key organizations</div>
      </div>
    </div>
    <div class='row'>
      <div class='col-md-6'>
        <div class='about-us-key-organizations-item'>
          <div class='about-us-key-organizations-item-img'>
            <img src='<?php bloginfo('template_url');?>/assets/img/about/uprisun_logo.png' />
          </div>
          <div class='about-us-key-organizations-item-title'>Uprisun Technology</div>
          <p>With its expertise in energy efficiency technologies, financial instruments, and process management, Uprisun Technology 
            offers a new generation of software solutions for residential and commercial renewable energy businesses, as well as sales and management teams.</p>
          <a href='https://uprisuntechnology.com' target='_blank'>uprisuntechnology.com <img
              src='<?php bloginfo('template_url');?>/assets/img/about/link.svg' /></a>
        </div>
      </div>
      <div class='col-md-6'>
        <div class='about-us-key-organizations-item'>
          <div class='about-us-key-organizations-item-img'>
            <img src='<?php bloginfo('template_url');?>/assets/img/about/SAEE_logo.png' />
          </div>
          <div class='about-us-key-organizations-item-title'>SAEE</div>
          <p>State Agency on Energy Efficiency and Energy Saving of Ukraine implements the policy of energy transformation 
            of Ukraine, decarbonization of Ukraine, green transition in accordance with the principles of European policy.</p>
          <a href='https://saee.gov.ua' target='_blank'>saee.gov.ua <img
              src='<?php bloginfo('template_url');?>/assets/img/about/link.svg' /></a>
        </div>
      </div>
      <div class='row' style="margin-top: 24px; justify-content: center;">
        <div class='col-md-6'>
          <div class='about-us-key-organizations-item'>
            <div class='about-us-key-organizations-item-img'>
              <img src='<?php bloginfo('template_url');?>/assets/img/about/cogen_en.png' />
            </div>
            <div class='about-us-key-organizations-item-title'>Association of Decarbonization “Cogen Ukraine“</div>
            <p>Association of Decarbonization “Cogen Ukraine“ (ADCU) aims to play a central role in the development of the cogeneration industry, which is an integral part of Ukraine's energy efficiency strategy. In addition to ensure an effective dialogue between the authorities, enterprises and other interested parties, the association will promote the development of the latest technologies and research that can significantly improve the efficiency and competitiveness of the Ukrainian cogeneration industry.</p>
            <a href='http://adcu.com.ua/' target='_blank'>adcu.com.ua<img
                src='<?php bloginfo('template_url');?>/assets/img/about/link.svg' /></a>
          </div>
        </div>
    </div>
    </div>
  </div>
</div>
<div class='about-us-our-team'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='about-us-our-team-title'>
            A team of ambassadors:
        </div>
      </div>
    </div>
    <div class='row about-us-our-team-items'>
        <?php
        $team_ambasador_item = get_field('team_ambasador_item');
        if ($team_ambasador_item) {
            foreach ($team_ambasador_item as $item) {
                $team_ambasador_block = $item['team_ambasador_block'];
                ?>
                <div class='col-md-3 col-6'>
                    <div class='about-us-our-team-item'>
                        <div class='about-us-our-team-item-avatar'>
                            <img src='<?php echo $team_ambasador_block['team_ambasador_avatar']; ?>' />
                        </div>
                        <div class='about-us-our-team-item-name'><?php echo $team_ambasador_block['team_ambasador_name']; ?></div>
                        <div class='about-us-our-team-item-desc'><?php echo $team_ambasador_block['team_ambasador_description']; ?>
                        </div>
                        <div class='about-us-our-team-item-social'>
                            <?php
                            $team_ambasador_socials = $team_ambasador_block['team_ambasador_socials'];
                            if ($team_ambasador_socials) {
                                foreach ($team_ambasador_socials as $item) {
                                    $team_ambasador_social = $item['team_ambasador_social'];
                                    ?>
                                    <a href='<?php echo $team_ambasador_social['team_ambasador_social_link']; ?>' target="_blank"><img src='<?php echo $team_ambasador_social['team_ambasador_social_icon']; ?>' /></a>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
  </div>
</div>
<div class='about-us-our-team'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='about-us-our-team-title'>
             UANDP team:
        </div>
      </div>
    </div>
    <div class='row about-us-our-team-items'>
        <?php
        $team_uandp_item = get_field('team_uandp_item');
        if ($team_uandp_item) {
            foreach ($team_uandp_item as $item) {
                $team_uandp_block = $item['team_uandp_block'];
                ?>
                <div class='col-md-3 col-6'>
                    <div class='about-us-our-team-item'>
                        <div class='about-us-our-team-item-avatar'>
                            <img src='<?php echo $team_uandp_block['team_uandp_avatar']; ?>' />
                        </div>
                        <div class='about-us-our-team-item-name'><?php echo $team_uandp_block['team_uandp_name']; ?></div>
                        <div class='about-us-our-team-item-desc'><?php echo $team_uandp_block['team_uandp_description']; ?>
                        </div>
                        <div class='about-us-our-team-item-social'>
                            <?php
                            $team_uandp_socials = $team_uandp_block['team_uandp_socials'];
                            if ($team_uandp_socials) {
                                foreach ($team_uandp_socials as $item) {
                                    $team_uandp_social = $item['team_uandp_social'];
                                    ?>
                                    <a href='<?php echo $team_uandp_social['$team_uandp_social_link']; ?>' target="_blank"><img src='<?php echo $team_uandp_social['team_uandp_social_icon']; ?>' /></a>
                                    <?php
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <?php
            }
        }
        ?>
    </div>
  </div>
</div>
<div class='about-us-contact-us'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='about-us-contact-us-bg'>
          <img class='about-us-contact-us-img1' src='<?php bloginfo('template_url');?>/assets/img/about/as_bg1.png' />
          <img class='about-us-contact-us-img2' src='<?php bloginfo('template_url');?>/assets/img/about/as_bg2.png' />
          <div class='about-us-contact-us-title'>Contact us</div>
          <div class='about-us-contact-us-text'>Our friendly team would love to hear from you</div>
          <a href='/en/contacts/' class='btn btn_bg_primary'>Get in touch</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

get_footer();
