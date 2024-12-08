<?php
/*
Template Name: Green
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
          <div class='col-6'>
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
                <h1 class='gu_title'>Green <img src='<?php bloginfo('template_url');?>/assets/img/green_university/heading-icon.svg' /> University</h1>
                <p>Green Energy University is a comprehensive online platform designed to overcome barriers and support the implementation of energy-efficient solutions, which is a very relevant and important direction in the modern world.</p>
              </div>
              <div class='gu_comment'>
                <p>“Green University will play a significant role in educating and empowering individuals and organizations to contribute to Ukraine's transition to a more <span>sustainable</span> and <span>efficient energy</span> landscape”</p>
                <div class='gu_user-info'>
                  <div class='gu_avatar'>
                    <img src='<?php bloginfo('template_url');?>/assets/img/green_university/hanna_zamazieieva.jpg' />
                  </div>
                  <div class='gu_user-content'>
                    <div class='gu_user-name'>Anna Zamazeeva</div>
                    <div class='gu_user-info'>Head of SAEE</div>
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
                <h2 class='title'>Training Center</h2>
                <p><br/>Training Center is a comprehensive learning platform that provides users with the in-depth knowledge and practical skills needed for successful energy efficiency initiatives. Track and save your progress, receive personalized notifications, and access recommended courses for customized learning.<br/>The platform includes interactive modules, presentations, certification programs, enabling users to acquire the knowledge and skills needed to contribute to a more sustainable and energy-efficient future.</p>
                <button onclick="window.location.href='/en/training-center/'" class='btn btn_bg_primary'>See more information</button>
              </div>
            </div>
            <div class='col-md-6'>
              <div class='gu-training-platform-block-right'>
                <div class='gu-image'>
                  <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_image2.png' />
                  <div class='gu-info'>
                    <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_dottts.svg' />
                    <p>Awareness and knowledge pave the way to sustainable future</p>
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
              <div class='title'>Knowledge Base</div>
              <p>Knowledge base is a centralized repository of information and resources that serves as a valuable information and learning tool. It contains a variety of articles, guides, training materials, and common questions on various topics, allowing users to access in-depth information on multiple subjects and solve problems<br/><br/>Knowledge base is used by users, clients, and partners to find answers and solutions to their requests.
</p>
              <a href='/en/knowledge-base/' class='btn btn_bg_primary'>See more</a>
            </div>
          </div>
        </div>
      </div>
    </div>

		<!-- <div class='gu-interactive-tools'>
      <div class='container'>
        <div class='row'>
          <div class='col-md-12'>
            <div class='title'>Interactive Tools</div>
            <div class='gu-interactive-tools-item'>
              <div class='gu-it-icon'>
                <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_calculator.svg' />
              </div>
              <div class='gu-it-text'>Integrated calculators</div>
              <div class='gu-it-action'>
                 <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_arrow.svg' /> 
              </div>
            </div>
            <div class='gu-interactive-tools-item'>
              <div class='gu-it-icon'>
                <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_icon-data.svg' />
              </div>
              <div class='gu-it-text'>Design software demos</div>
              <div class='gu-it-action'>
                <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_arrow.svg' /> 
              </div>
            </div>
            <div class='gu-interactive-tools-item'>
              <div class='gu-it-icon'>
                <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_icon-coins.svg' />
              </div>
              <div class='gu-it-text'>Project leasing pipeline demos</div>
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
