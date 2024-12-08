<?php
/*
Template Name: Green_ua
*/

get_header();
?>

<main id="primary" class="site-main hero-title" style="overflow: hidden;">
		<section class="gu_block">
      <div class='bg-image'>
        <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_bg_icon.png' />
      </div>
      <div class='container'>
        <div class='row'>
          <div class='col-md-6'>
            <div class='gu_block_left'>
              <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_left1.png' />
              <div class='gu-image-row'>
                <div class='gu-image-row-item1'>
                  <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_left2.png' />
                </div>
                <div class='gu-image-row-item2'>
                  <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_left3.png' />
                  <div class='gu-green-university'>
                    <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_university.png' class='gu-green-university-text' />
                    <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_icon-graduation-hat.svg' class='gu-green-university-icon' />
                  </div>
                </div>
              </div>    
            </div>
          </div>
          <div class='col-md-6'>
            <div class='gu_block_right'>
              <div>
                <div class='gu_breadcrumbs'>
                    <?php yoast_breadcrumb(); ?>
                </div>
                <h1 class='gu_title'>Green <img src='<?php bloginfo('template_url');?>/assets/img/green_university/heading-icon.svg' /> U</h1>
                <p>Green-U – це комплексна онлайн-платформа, розроблена з метою подолання бар'єрів та  спрямована на підтримку впровадження енергоефективних рішень, що є дуже актуальним та важливим напрямком в сучасному світі.</p>
              </div>
              <div class='gu_comment'>
                <p>“Green-U відіграє важливу роль у навчанні та розширенні можливостей осіб та організацій для сприяння переходу України до більш <span>сталого</span> та <span>енергоефективного</span> ландшафту.”</p>
                <div class='gu_user-info'>
                  <div class='gu_avatar'>
                    <img src='<?php bloginfo('template_url');?>/assets/img/green_university/hanna_zamazieieva.jpg' />
                  </div>
                  <div class='gu_user-content'>
                    <div class='gu_user-name'>Ганна Замазєєва</div>
                    <div class='gu_user-info'>Голова Держенергоефективності. </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

	<?php include(get_template_directory() . '/templates/latest-cases.php'); ?>

	<section class="gu-training-platform">
      <div class='gu-container-bg'>
        <div class='gu-bg-image'>
          <img class='gu-bg1' src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_bg1.png' />
          <img class='gu-bg2' src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_bg2.png' />
        </div>
        <div class='container'>
          <div class='row'>
            <div class='col-md-6'>
              <div class='gu-training-platform-block-left'>
                <h2 class='title'>Центр навчання</h2>
                <p>Комплексна навчальна платформа надає користувачам поглиблені знання та практичні навички, необхідні для успішних ініціатив з енергоефективності.
                   Відстежуйте та зберігайте свій прогрес, отримуйте персоналізовані сповіщення та доступ до рекомендованих курсів для індивідуального навчання.
                <br><br>Платформа включає в себе інтерактивні модулі, презентації, програми сертифікації, які дозволяють користувачам отримати знання і навички, необхідні для досягнення більш сталого та енергоефективного майбутнього.</p>
                <button onclick="window.location.href='/training-center/'" class='btn btn_bg_primary'>Більше інформації</button>
              </div>
            </div>
            <div class='col-md-6'>
              <div class='gu-training-platform-block-right'>
                <div class='gu-image'>
                  <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_image2.png' />
                  <div class='gu-info'>
                    <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_dottts.svg' />
                    <p>Обізнаність і знання відкривають шлях до сталого майбутнього.</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

	<?php include(get_template_directory() . '/templates/latest-news.php'); ?>

	<div class='gu-knowledge-base'>
      <div class='container'>
        <div class='row'>
          <div class='col-md-6'>
            <div class='gu-knowledge-base-image'>
              <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_knowledge_base.png' />
              <div class='gu-green-university'>
                <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_university.png' class='gu-green-university-text' />
                <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_icon-graduation-hat.svg' class='gu-green-university-icon' />
              </div>
            </div>
          </div>
          <div class='col-md-6'>
            <div class='gu-knowledge-base-block-right'>
              <div class='title'>База знань</div>
              <p>База знань - це централізоване сховище інформації та ресурсів, яке виступає цінним довідковим та навчальним інструментом. Вона містить різноманітні статті, керівництва, навчальні матеріали та популярні запитання з різних тем, що дозволяє користувачам отримувати доступ до поглибленої інформації на різні теми та вирішувати проблеми.<br/><br/>База знань використовується для самостійного пошуку користувачами, клієнтами, партнерами відповідей і рішень за їхніми запитами.</p>
              <a href='/knowledge-base' class='btn btn_bg_primary'>Детальніше</a>
            </div>
          </div>
        </div>
      </div>
    </div>
<!-- 
		<div class='gu-interactive-tools'>
      <div class='container'>
        <div class='row'>
          <div class='col-md-12'>
            <div class='title'>Інтерактивні інструменти</div>
            <div class='gu-interactive-tools-item'>
              <div class='gu-it-icon'>
                <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_calculator.svg' />
              </div>
              <div class='gu-it-text'>Інтегровані калькулятори</div>
              <div class='gu-it-action'>
                <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_arrow.svg' />
              </div>
            </div>
            <div class='gu-interactive-tools-item'>
              <div class='gu-it-icon'>
                <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_icon-data.svg' />
              </div>
              <div class='gu-it-text'>Демо програмного забезпечення з дизайну</div>
              <div class='gu-it-action'>
                <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_arrow.svg' />
              </div>
            </div>
            <div class='gu-interactive-tools-item'>
              <div class='gu-it-icon'>
                <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_icon-coins.svg' />
              </div>
              <div class='gu-it-text'>Демо процесу лізингу</div>
              <div class='gu-it-action'>
                <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_arrow.svg' />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div> -->

		<?php include(get_template_directory() . '/templates/documents.php'); ?>

</main><!-- #main -->

<?php

get_footer();
