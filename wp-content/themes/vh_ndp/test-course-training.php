<?php
/*
Template Name: Lesson Training page
для тестов и проверки вёрстки
*/

get_header('home');
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/course-training.css">

<section class="course">
  <div class="container">
    <div class="course__header">
      <div class="course__title">
        <a href="#">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M15.7049 7.41L14.2949 6L8.29492 12L14.2949 18L15.7049 16.59L11.1249 12L15.7049 7.41Z" fill="#2A59BD"/>
          </svg>
        </a>
        <h1>Thermal Modeling of Solar Energy Systems</h1>
      </div>
      <div class="course__title-right">
      <div class="course__header-limit">
          <div class="course__header-limit__time">00:09:42:16</div>
          <div class="course__header-limit__text">
            <h4 class="course__header-limit__title">Time left</h4>
            <span class="course__header-limit__subtitle">Progress will be reset</span>
          </div>
        </div>
        <div class="course__progress">
          <div class="course__progress-text">
            <h2 class="course__progress-title">Your progress</h2>
            <span class="course__progress-subtitle">0 of 30 complete</span>
          </div>
          <div class="course__progress-item" data-inner-circle-color="white" data-percentage="20" data-progress-color="#4770c6" data-bg-color="#dce2f9">
            <div class="course__progress-inner__circle"></div>
           </div>
           <span class="course__progress-details">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 8C13.1 8 14 7.1 14 6C14 4.9 13.1 4 12 4C10.9 4 10 4.9 10 6C10 7.1 10.9 8 12 8ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10ZM10 18C10 16.9 10.9 16 12 16C13.1 16 14 16.9 14 18C14 19.1 13.1 20 12 20C10.9 20 10 19.1 10 18Z" fill="#45464F"/>
              </svg>
            </span>
        </div>
      </div>
    </div>
    <div class="course__block">
     <div class="course__main col-md-7 col-lg-8">
  <div class='course-training-page-left-box'>
    <div class='course-training-page-left-box-completed'>
      <div class='course-training-page-left-box-completed-img'>
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
          <path d="M12.5002 20L17.5002 25L27.5002 15M36.6668 20C36.6668 29.2048 29.2049 36.6667 20.0002 36.6667C10.7954 36.6667 3.3335 29.2048 3.3335 20C3.3335 10.7953 10.7954 3.33337 20.0002 3.33337C29.2049 3.33337 36.6668 10.7953 36.6668 20Z" stroke="#2A59BD" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
      <div class='course-training-page-left-box-completed-text'>You have completed this course</div>
    </div>
    <div class="course-training-page-certificate">
      <h2 class="course-training-page-certificate-title">Certificate received</h2>
      <div class="course-training-page-certificate-item">
          <div class="course-training-page-certificate-header">
            <h2>Heading Certificate</h2>
            <div class="course-training-page-certificate-header-buttons">
              <button class="course-training-page-certificate-header-buttons__item">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/visibility.svg" alt="visibility-icon">
              </button>
            </div>
          </div>
          <div class="course-training-page-certificate-item-status">
            <span class="course-training-page-certificate-item-tag">Valid</span>
            <span class="course-training-page-certificate-item-date">due to 06.09.25,</span>
            <span class="course-training-page-certificate-item-date">320 days</span>
            <div class="course-training-page-certificate-item-granted">
                <span>Granted 15.09.23:</span>
                <strong>NDP</strong>
              </div>
           </div>
           <div class="course-training-page-certificate-item-description">
            <p>
            <?php _e('Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut al Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatu','ndp'); ?>
            </p>
           </div>
           <div class="course-training-page-certificate-item-sourse">
              <span>Sourse:</span>
              <strong>NDP certification</strong>
            </div>
            <div class="course-training-page-certificate-item-footer">
              <p>
              Thermal Modeling of Solar Energy Systems 
              </p>
            </div>
        </div> 
    </div>
    <div class="course-training-page-left-box-limit">
      <h2 class="course-training-page-left-box-limit-title">Time to complete the course is limited</h2>
      <div class="course-training-page-left-box-limit-alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <path d="M11.9995 9V11M11.9995 15H12.0095M5.07134 19H18.9277C20.4673 19 21.4296 17.3333 20.6598 16L13.7316 4C12.9618 2.66667 11.0373 2.66667 10.2675 4L3.33929 16C2.56949 17.3333 3.53174 19 5.07134 19Z" stroke="#B38307" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="course-training-page-left-box-limit-alert-text">You must complete the course within 48 hours. Otherwise, the course progress will be reset.</span>
      </div>
      <button class="course-training-page-left-box-limit-button">Get Started</button>
    </div>
    <div class="course-training-page-left-box-article">
      <div class="course-training-page-left-box-article-content">
        <h2 class="course-training-page-left-box-article-title">Green University</h2>
        <p class="course-training-page-left-box-article-text">Green Energy University is a comprehensive online platform designed to break down barriers and facilitate the adoption of energy efficiency practices. The goal is to provide a wealth of knowledge, training, and expertise to empower individuals and organizations seeking to embrace sustainable energy solutions. </p>
        <p class="course-training-page-left-box-article-text">By offering educational resources, case studies, interactive tools, a training platform, and public events, we aim to catalyze the transition towards a greener and more energy-efficient future.</p>
        <div class="course-training-page-left-box-article-image">
          <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/course-img.png" alt="course-img">
        </div>
        <p class="course-training-page-left-box-article-text">Green Energy University is a comprehensive online platform designed to break down barriers and facilitate the adoption of energy efficiency practices. The goal is to provide a wealth of knowledge, training, and expertise to empower individuals and organizations seeking to embrace sustainable energy solutions. </p>
        <p class="course-training-page-left-box-article-text">By offering educational resources, case studies, interactive tools, a training platform, and public events, we aim to catalyze the transition towards a greener and more energy-efficient future.</p>
        <h3 class="course-training-page-left-box-article-subheading">Subheading</h3>
        <div class="course-training-page-left-box-article-subheading-text">
          <p>The most comprehensive and detailed course on designing off-grid, on-grid, and solar water pumping systems for beginners</p>
          <h4>Subtitle</h4>
          <ul>
            <li>Nam pulvinar blandit velit</li>
            <li>id condimentum diam faucibus at</li>
            <li>Aliquam lacus nisi, sollicitudin at nisi nec</li>
            <li>Fermentum congue felis. Quisque mauris dolor</li>
          </ul>
          <p>Nulla varius volutpat turpis sed lacinia. Nam eget mi in purus lobortis eleifend. Sed nec ante dictum sem condimentum ullamcorper quis venenatis nisi. Proin vitae facilisis nisi, ac posuere leo.</p>
        </div>
        <p class="course-training-page-left-box-article-text">Green Energy University is a comprehensive online platform designed to break down barriers and facilitate the adoption of energy efficiency practices. The goal is to provide a wealth of knowledge, training, and expertise to empower individuals and organizations seeking to embrace sustainable energy solutions. </p>
        <p class="course-training-page-left-box-article-text">By offering educational resources, case studies, interactive tools, a training platform, and public events, we aim to catalyze the transition towards a greener and more energy-efficient future.</p>
      </div>
      <button class="course-training-page-left-box-article-button">
        <span></span>
      <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
        <mask id="mask0_3481_33304" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="19" height="18">
        <rect x="0.5" width="18" height="18" fill="#D9D9D9"/>
        </mask>
        <g mask="url(#mask0_3481_33304)">
        <path d="M5.95625 11.6999L5 10.7437L9.5 6.24365L14 10.7437L13.0437 11.6999L9.5 8.15615L5.95625 11.6999Z" fill="#151B2C"/>
        </g>
      </svg>
      <strong>Collapse</strong>
      </button>
    </div>
     <div class='course-training-page-left-box-course'>
      <div class='course-training-page-left-box-course-content'></div>
      <div class='course-training-page-left-box-course-name'><span>File name</span></div>
    </div> 
    <div class='course-training-page-left-box-description'>
      <div class='course-training-page-left-box-description-title'>Description</div>
      <div class='course-training-page-left-box-description-text'>
        <p>Curabitur tempor quis eros tempus lacinia. Nam bibendum pellentesque quam a convallis. Sed ut vulputate nisi. Integer in felis sed leo vestibulum venenatis. Suspendisse quis arcu sem. Aenean feugiat ex eu vestibulum vestibulum. Morbi a eleifend magna. Nam metus lacus, porttitor eu mauris a, blandit ultrices nibh. Mauris sit amet magna non ligula vestibulum eleifend.</p>
        <br/>
        <h4>Subtitle</h4>
        <br/>
        <ul>
          <li>Nam pulvinar blandit velit</li>
          <li>id condimentum diam faucibus at</li>
          <li>Aliquam lacus nisi, sollicitudin at nisi nec</li>
          <li>Fermentum congue felis. Quisque mauris dolor</li>
        </ul>
        <br/>
        <p>Nulla varius volutpat turpis sed lacinia. Nam eget mi in purus lobortis eleifend. Sed nec ante dictum sem condimentum ullamcorper quis venenatis nisi. Proin vitae facilisis nisi, ac posuere leo.</p>
      </div>
      <div class='course-training-page-left-box-description-text-actions'>
        <div class='btn btn-outline-link disable'>
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
            <path opacity="0.38" d="M15 8.25H5.8725L10.065 4.0575L9 3L3 9L9 15L10.0575 13.9425L5.8725 9.75H15V8.25Z" fill="#1B1B1F"/>
          </svg><span>Prev lesson</span></div>
        <div class='btn btn-outline-link'>
          <span>Next lesson</span> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
          <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#2A59BD"/>
          </svg>
        </div>
      </div>
    </div>
    <div class='course-training-page-left-box-description'>
      <div class='course-training-page-left-box-description-title'>
        <span>About this course</span>
        <div class='btn btn-outline-link-circle'>
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <mask id="mask0_3354_29755" 
              // style="mask-type:alpha" 
            maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
              <rect width="24" height="24" fill="#D9D9D9"/>
            </mask>
            <g mask="url(#mask0_3354_29755)">
              <path d="M7.275 15.6L6 14.325L12 8.32495L18 14.325L16.725 15.6L12 10.875L7.275 15.6Z" fill="#2A59BD"/>
            </g>
          </svg>
        </div>
      </div>
      <div class='course-training-page-left-box-description-text'>
        <p>Curabitur tempor quis eros tempus lacinia. Nam bibendum pellentesque quam a convallis. Sed ut vulputate nisi. Integer in felis sed leo vestibulum venenatis. Suspendisse quis arcu sem. Aenean feugiat ex eu vestibulum vestibulum. Morbi a eleifend magna. Nam metus lacus, porttitor eu mauris a, blandit ultrices nibh. Mauris sit amet magna non ligula vestibulum eleifend.</p>
        <br/>
        <h4>Subtitle</h4>
        <br/>
        <ul>
          <li>Nam pulvinar blandit velit</li>
          <li>id condimentum diam faucibus at</li>
          <li>Aliquam lacus nisi, sollicitudin at nisi nec</li>
          <li>Fermentum congue felis. Quisque mauris dolor</li>
        </ul>
        <br/>
        <p>Nulla varius volutpat turpis sed lacinia. Nam eget mi in purus lobortis eleifend. Sed nec ante dictum sem condimentum ullamcorper quis venenatis nisi. Proin vitae facilisis nisi, ac posuere leo.</p>
      </div>
      <div class='course-training-page-left-box-description-text-actions'>
        <div class='btn btn-outline-link'>
          <span>Next lesson</span> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
          <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#2A59BD"/>
          </svg>
        </div>
      </div>
      <div class='course-training-page-left-box-description-instruction'>
        <div class='course-training-page-left-box-description-instruction-title'>Instructor</div>
        <div class='course-training-page-left-box-description-instruction-content'>
          <div class='course-training-page-left-box-description-instruction-content-img'>
            <svg xmlns="http://www.w3.org/2000/svg" width="70" height="11" viewBox="0 0 70 11" fill="none">
              <g clip-path="url(#clip0_3359_28334)">
                <path d="M0.452637 0.939582C0.653497 1.72299 1.33177 2.52372 2.26236 2.72433H5.07489L5.21836 2.78098V9.87818H6.97465V2.78098L7.1342 2.72433H9.94921C10.8902 2.48191 11.5539 1.72299 11.7513 0.939582V0.922265H0.452637V0.939582Z" fill="#5d5d5e"/>
                <path d="M17.8352 9.89813H24.5168C25.4464 9.71335 26.1373 8.89432 26.3309 8.10151H16.021C16.2135 8.89457 16.9145 9.71335 17.8352 9.89813Z" fill="#5d5d5e"/>
                <path d="M17.8352 6.25768H24.5168C25.4464 6.07438 26.1373 5.2551 26.3309 4.4613H16.021C16.2135 5.25535 16.9145 6.07438 17.8352 6.25768Z" fill="#5d5d5e"/>
                <path d="M17.8352 2.71484H24.5168C25.4464 2.52956 26.1373 1.71103 26.3309 0.917725H16.021C16.2135 1.71103 16.9145 2.52956 17.8352 2.71484Z" fill="#5d5d5e"/>
                <path d="M33.0736 2.69779H39.2463C40.1769 2.42742 40.9583 1.71847 41.1488 0.932581H31.3433V6.22994H39.3688V8.0889L33.0736 8.09384C32.0871 8.36892 31.2505 9.03136 30.8332 9.9063L31.3433 9.8969H41.0931V4.46868H33.0736V2.69779Z" fill="#5d5d5e"/>
                <path d="M54.0801 9.89907C54.9565 9.52752 55.428 8.88487 55.6086 8.13287H47.8124L47.8173 0.930045L46.0697 0.934989V9.89907H54.0801Z" fill="#5d5d5e"/>
                <path d="M60.889 2.72195H67.5728C68.5012 2.53742 69.1916 1.71814 69.3862 0.925576H59.0758C59.2685 1.71839 59.9691 2.53742 60.889 2.72195Z" fill="#5d5d5e"/>
                <path d="M59.3445 4.47531V9.89561H61.0827V6.28678H67.409V9.89561H69.146V4.48471L59.3445 4.47531Z" fill="#5d5d5e"/>
              </g>
              <defs>
                <clipPath id="clip0_3359_28334">
                  <rect width="69.0147" height="9.15257" fill="white" transform="translate(0.452637 0.893066)"/>
                </clipPath>
              </defs>
            </svg>
          </div>
          <div class='course-training-page-left-box-description-instruction-content-box'>
            <div class='course-training-page-left-box-description-instruction-content-box-title'>Tesla, Inc.</div>
            <div class='course-training-page-left-box-description-instruction-content-box-text'>Nam eget mi in purus lobortis eleifend. Sed nec ante dictum sem condimentum ullamcorper quis venenatis nisi.</div>
          </div>
        </div>
      </div>
    </div>
  </div>
     </div>

     <div class="course__content col-md-4">
      <div class="course__content-title">
        <h2>Course content</h2>
        <button class="btn btn-outline-link">
        Show result
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
            <path d="M16.5 7.305L11.1075 6.84L9 1.875L6.8925 6.8475L1.5 7.305L5.595 10.8525L4.365 16.125L9 13.3275L13.635 16.125L12.4125 10.8525L16.5 7.305ZM9 11.925L6.18 13.6275L6.93 10.4175L4.44 8.2575L7.725 7.9725L9 4.95L10.2825 7.98L13.5675 8.265L11.0775 10.425L11.8275 13.635L9 11.925Z" fill="#2A59BD"/>
          </svg>
        </button>
        </div>
     <div class="course__accordion">
    <div class="course__accordion-item">
      <div class="course__accordion-header">
      <span class="accordion-plus"></span>
        <div class="course__accordion-header__text">
        <h3 class="course__accordion-title">Title of the module/section</h3>
        <div class="course__accordion-info">
          <span class="course__accordion-info__text">0/5</span>
          <span class="course__accordion-info__text">1hr 28min</span>
          <span class="course__accordion-info__label">Complete</span>
        </div>
        </div>
      </div>
      <div class="course__accordion-hidden">
        <ul class="course__accordion-list">
          <li class="course__accordion-list__item course__accordion-list__item-current">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/headphones.svg" alt="headphones">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Audio)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/slides.svg" alt="slides">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Slides)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/document-text.svg" alt="document-text">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Article)</h4>
              <span class="course__accordion-list__subtitle">12 min read</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/light-bulb.svg" alt="light-bulb">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (QUIZ)</h4>
              <span class="course__accordion-list__subtitle">10 questions</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="course__accordion-item">
      <div class="course__accordion-header">
      <span class="accordion-plus"></span>
        <div class="course__accordion-header__text">
        <h3 class="course__accordion-title">Title of the module/section</h3>
        <div class="course__accordion-info">
          <span class="course__accordion-info__text">0/5</span>
          <span class="course__accordion-info__text">1hr 28min</span>
        </div>
        </div>
      </div>
      <div class="course__accordion-hidden">
        <ul class="course__accordion-list">
          <li class="course__accordion-list__item course__accordion-list__item-current">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/headphones.svg" alt="headphones">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Audio)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/slides.svg" alt="slides">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Slides)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/document-text.svg" alt="document-text">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Article)</h4>
              <span class="course__accordion-list__subtitle">12 min read</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/light-bulb.svg" alt="light-bulb">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (QUIZ)</h4>
              <span class="course__accordion-list__subtitle">10 questions</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="course__accordion-item">
      <div class="course__accordion-header">
      <span class="accordion-plus"></span>
        <div class="course__accordion-header__text">
        <h3 class="course__accordion-title">Title of the module/section</h3>
        <div class="course__accordion-info">
          <span class="course__accordion-info__text">0/5</span>
          <span class="course__accordion-info__text">1hr 28min</span>
          <span class="course__accordion-info__label">Limit 2 h 45 m</span>
        </div>
      </div>
    </div>
    <div class="course__accordion-hidden">
        <div class="course__accordion-limit">
          <div class="course__accordion-limit__time">00:09:42:16</div>
          <div class="course__accordion-limit__text">
            <h4 class="course__accordion-limit__title">Time left</h4>
            <span class="course__accordion-limit__subtitle">Progress will be reset</span>
          </div>
        </div>
        <ul class="course__accordion-list">
          <li class="course__accordion-list__item course__accordion-list__item-current">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/headphones.svg" alt="headphones">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Audio)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/slides.svg" alt="slides">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Slides)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/document-text.svg" alt="document-text">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Article)</h4>
              <span class="course__accordion-list__subtitle">12 min read</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/light-bulb.svg" alt="light-bulb">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (QUIZ)</h4>
              <span class="course__accordion-list__subtitle">10 questions</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="course__accordion-item">
      <div class="course__accordion-header">
      <span class="accordion-plus"></span>
        <div class="course__accordion-header__text">
        <h3 class="course__accordion-title">Title of the module/section</h3>
        <div class="course__accordion-info">
          <span class="course__accordion-info__text">0/5</span>
          <span class="course__accordion-info__text">1hr 28min</span>
        </div>
        </div>
      </div>
      <div class="course__accordion-hidden">
        <ul class="course__accordion-list">
          <li class="course__accordion-list__item course__accordion-list__item-current">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/headphones.svg" alt="headphones">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Audio)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/slides.svg" alt="slides">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Slides)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/document-text.svg" alt="document-text">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Article)</h4>
              <span class="course__accordion-list__subtitle">12 min read</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/light-bulb.svg" alt="light-bulb">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (QUIZ)</h4>
              <span class="course__accordion-list__subtitle">10 questions</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="course__accordion-item">
      <div class="course__accordion-header">
      <span class="accordion-plus"></span>
        <div class="course__accordion-header__text">
        <h3 class="course__accordion-title">Title of the module/section</h3>
        <div class="course__accordion-info">
          <span class="course__accordion-info__text">0/5</span>
          <span class="course__accordion-info__text">1hr 28min</span>
        </div>
        </div>
      </div>
      <div class="course__accordion-hidden">
        <ul class="course__accordion-list">
          <li class="course__accordion-list__item course__accordion-list__item-current">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/headphones.svg" alt="headphones">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Audio)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/slides.svg" alt="slides">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Slides)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/document-text.svg" alt="document-text">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Article)</h4>
              <span class="course__accordion-list__subtitle">12 min read</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/light-bulb.svg" alt="light-bulb">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (QUIZ)</h4>
              <span class="course__accordion-list__subtitle">10 questions</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
    <div class="course__accordion-item course__accordion-item__locked">
      <div class="course__accordion-header">
      <span class="accordion-plus"></span>
        <div class="course__accordion-header__text">
        <h3 class="course__accordion-title">Title of the module/section</h3>
        <div class="course__accordion-info">
          <span class="course__accordion-info__text">0/5</span>
          <span class="course__accordion-info__text">1hr 28min</span>
          <span class="course__accordion-info__label course__accordion-info__label-locked">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
            <path d="M12.75 7.5V6C12.75 3.92893 11.0711 2.25 9 2.25C6.92893 2.25 5.25 3.92893 5.25 6V7.5M9 10.875V12.375M6.6 15.75H11.4C12.6601 15.75 13.2902 15.75 13.7715 15.5048C14.1948 15.289 14.539 14.9448 14.7548 14.5215C15 14.0402 15 13.4101 15 12.15V11.1C15 9.83988 15 9.20982 14.7548 8.72852C14.539 8.30516 14.1948 7.96095 13.7715 7.74524C13.2902 7.5 12.6601 7.5 11.4 7.5H6.6C5.33988 7.5 4.70982 7.5 4.22852 7.74524C3.80516 7.96095 3.46095 8.30516 3.24524 8.72852C3 9.20982 3 9.83988 3 11.1V12.15C3 13.4101 3 14.0402 3.24524 14.5215C3.46095 14.9448 3.80516 15.289 4.22852 15.5048C4.70982 15.75 5.33988 15.75 6.6 15.75Z" stroke="#919094" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            Locked</span>
        </div>
        </div>
      </div>
      <div class="course__accordion-hidden">
        <ul class="course__accordion-list">
          <li class="course__accordion-list__item course__accordion-list__item-current">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/play.svg" alt="play">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Video)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/headphones.svg" alt="headphones">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Audio)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/slides.svg" alt="slides">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Slides)</h4>
              <span class="course__accordion-list__subtitle">10:13</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/document-text.svg" alt="document-text">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (Article)</h4>
              <span class="course__accordion-list__subtitle">12 min read</span>
            </div>
          </li>
          <li class="course__accordion-list__item">
            <input type="checkbox" name="" id="" class="course__accordion-list__checkbox">
            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/course/light-bulb.svg" alt="light-bulb">
            <div class="course__accordion-list__info">
              <h4 class="course__accordion-list__title">Title of the lesson/action (QUIZ)</h4>
              <span class="course__accordion-list__subtitle">10 questions</span>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </div>
     </div>
    </div>
  </div>
</section>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/course-training.js"></script>


<?php

get_footer();