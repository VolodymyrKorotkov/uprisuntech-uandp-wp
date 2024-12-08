<?php
/*
Template Name: About_ua
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
          <h1 class='about-us-title'>Про Платформу</h1>
          <p>
              Ми тільки починаємо нашу подорож. Все, що вам потрібно для створення сучасного екологічно чистого енергетичного рішення, ви знайдете на нашій Платформі.<br/> Ми ідеальна відправна точка для будь-якого проєкту "Розпочніть свою енергетичну подорож з легкістю та свідомістю".<br/>Наша команда фахівців співпрацює з підприємствами та громадами, щоб безперешкодно інтегрувати екологічні рішення: від енергоефективних технологій до стратегій зменшення відходів.
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
        <div class='about-us-green-energy-title'>Зелена енергія — це <span>шлях до сталого </span> майбутнього.</div>
      </div>
    </div>
    <div class='row'>
      <div class='col-md-4'>
        <p class='about-us-green-energy-text1'>
         Зелена енергетика є ключовою відповіддю на виклики зміни клімату та сталого розвитку.
        </p>
      </div>
      <div class='col-md-8'>
        <p class='about-us-green-energy-text2'>
        Вона спрямована на використання відновлюваних джерел енергії, таких як сонце, вітер, гідроенергія та інших, для виробництва 
        електроенергії без викидів парникових газів та інших шкідливих речовин. Це не тільки спосіб зменшити вплив на навколишнє середовище,
         а й забезпечити стабільне енергопостачання в майбутньому.<br /><br />
         Одним із найбільш визначних <a href='/marketplace' target='_blank'>рішень</a> у сфері зеленої енергетики   є розвиток сонячних та вітряних
          електростанцій. Сонячні батареї перетворюють сонячне світло на електроенергію, а вітряні турбіни - енергію вітру на електричну. Ці технології
           стають більш ефективними та доступними, допомагаючи зменшити залежність від викопного палива та скоротити викиди вуглецю.

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
        <div class='about-us-key-organizations-title'>Ключові організації</div>
      </div>
    </div>
    <div class='row'>
      <div class='col-md-6'>
        <div class='about-us-key-organizations-item'>
          <div class='about-us-key-organizations-item-img'>
            <img src='<?php bloginfo('template_url');?>/assets/img/about/uprisun_logo.png' />
          </div>
          <div class='about-us-key-organizations-item-title'>Uprisun Technology</div>
          <p>Завдяки своєму досвіду в сфері енергоефективних технологій, фінансових інструментів 
            та управління процесами, Uprisun Technology пропонує нове покоління програмних рішень
             для житлового і комерційного бізнесу в галузі відновлюваної енергетики, а також команд з продажів та управління. </p>
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
          <p>Державне агентство з енергоефективності та енергозбереження України реалізує державну політику енергетичної трансформації України, декарбонізації України, зеленого переходу у відповідності із принципами європейської політики.</p>
          <a href='https://saee.gov.ua' target='_blank'>saee.gov.ua <img
              src='<?php bloginfo('template_url');?>/assets/img/about/link.svg' /></a>
        </div>
      </div>
    </div>
    <div class='row' style="margin-top: 24px; justify-content: center;">
      <div class='col-md-6'>
        <div class='about-us-key-organizations-item'>
          <div class='about-us-key-organizations-item-img'>
            <img src='<?php bloginfo('template_url');?>/assets/img/about/cogen_ua.png' />
          </div>
          <div class='about-us-key-organizations-item-title'>Асоціація Декарбонізації “Коген Україна”</div>
          <p>Асоціація Декарбонізації “Коген Украіна” (АДКУ) має на меті відігравати центральну роль у розвитку когенераційної галузі, яка є невід'ємною частиною стратегії енергоефективності України. Окрім забезпечення ефективного діалогу між органами влади, підприємствами та іншими зацікавленими сторонами, асоціація сприятиме розвитку новітніх технологій та досліджень, які можуть значно підвищити ефективність та конкурентоспроможність української когенераційної галузі.</p>
          <a href='http://adcu.com.ua/' target='_blank'>adcu.com.ua<img
                src='<?php bloginfo('template_url');?>/assets/img/about/link.svg' /></a>
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
           Команда амбасадорів:
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
  
</div>

<div class='about-us-our-team'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='about-us-our-team-title'>
           Команда UANDP:
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
          <div class='about-us-contact-us-title'>Зв'яжіться з нами</div>
          <div class='about-us-contact-us-text'>Наша дружня команда буде рада почути вашу думку</div>
          <a href='/contacts/' class='btn btn_bg_primary'>Написати</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php

get_footer();
