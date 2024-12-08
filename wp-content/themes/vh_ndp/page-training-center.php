<?php
/*
Template Name: Training center
*/

get_header();

$student = llms_get_student();
$courses = [];
if ($student) {
    $courses = $student->get_courses();
}
//$current_lang = apply_filters( 'wpml_current_language', 'en' );
$current_lang = 'en';
?>
    <div class='training-page-training'>
        <div class='container'>
            <div class='row'>
                <div class='col-md-6'>
                    <div class='training-page-training-left'>
                        <div class="breadcrumb breadcrumb-block">
                            <div class='fn_breadcrumbs'>
                                <?php yoast_breadcrumb(); ?>
                            </div>
                        </div>
                        <h1 class='training-page-training-left-title'>Training center</h1>
                        <p>The comprehensive learning platform provides users with the in-depth education and practical skills required for successful energy efficiency initiatives. Track and save your progress, receive personalized notifications, and access recommended courses for a personalized learning experience.</p>
                        <div class="training-buttons">
                            <a href='/en/courses' class='btn btn_bg_primary'>See all courses</a>
                            <?php if ($student && !empty($courses)): ?>
                            <a href='<?php echo llms_get_endpoint_url( 'view-courses', '', llms_get_page_url( 'myaccount' ) ); ?>' class='btn btn_bg_light training-btn__continue'>Continue learning</a>
                          <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class='col-md-6'>
                    <div class='training-page-training-rigth'>
                        <img src='<?php bloginfo('template_url');?>/assets/img/training-center/left.png' />
                        <div class='training-page-training-rigth-bottom'>
                          <svg xmlns="http://www.w3.org/2000/svg" width="150" height="150" viewBox="0 0 150 150" fill="none">
                            <circle opacity="0.45" cx="44" cy="44" r="44" fill="#B2C5FF"/>
                            <circle opacity="0.25" cx="44" cy="106" r="44" fill="#B2C5FF"/>
                            <circle opacity="0.35" cx="106" cy="44" r="44" fill="#B2C5FF"/>
                            <circle opacity="0.18" cx="106" cy="106" r="44" fill="#B2C5FF"/>
                          </svg>
                          <div class='training-page-training-rigth-bottom-block'>
                            <svg xmlns="http://www.w3.org/2000/svg" width="203" height="110" viewBox="0 0 203 110" fill="none">
                              <g opacity="0.5" clip-path="url(#clip0_1828_4237)">
                                <g opacity="0.9">
                                  <path d="M175.629 78.6182C192.968 61.2789 174.734 14.9322 134.902 -24.9C95.0694 -64.7323 48.7227 -82.9664 31.3834 -65.627C14.0441 -48.2877 32.2782 -1.94105 72.1104 37.8912C111.943 77.7234 158.289 95.9575 175.629 78.6182Z" stroke="#2A59BD" stroke-miterlimit="10"/>
                                  <path d="M166.329 87.9199C183.669 70.5806 165.434 24.2339 125.602 -15.5983C85.77 -55.4305 39.4233 -73.6646 22.084 -56.3253C4.74469 -38.986 22.9788 7.3607 62.811 47.1929C102.643 87.0251 148.99 105.259 166.329 87.9199Z" stroke="#2A59BD" stroke-miterlimit="10"/>
                                  <path d="M180.269 73.9805C197.609 56.6412 179.375 10.2945 139.542 -29.5377C99.7102 -69.3699 53.3635 -87.6041 36.0242 -70.2647C18.6849 -52.9254 36.919 -6.57875 76.7512 33.2535C116.583 73.0857 162.93 91.3198 180.269 73.9805Z" stroke="#2A59BD" stroke-miterlimit="10"/>
                                  <path d="M189.558 64.668C206.897 47.3287 188.663 0.981987 148.831 -38.8502C108.999 -78.6825 62.6518 -96.9166 45.3125 -79.5772C27.9732 -62.2379 46.2073 -15.8912 86.0395 23.941C125.872 63.7732 172.218 82.0073 189.558 64.668Z" stroke="#2A59BD" stroke-miterlimit="10"/>
                                  <path d="M194.221 60.0303C211.56 42.691 193.326 -3.6557 153.494 -43.4879C113.662 -83.3201 67.315 -101.554 49.9757 -84.2149C32.6364 -66.8756 50.8705 -20.5289 90.7027 19.3033C130.535 59.1355 176.882 77.3696 194.221 60.0303Z" stroke="#2A59BD" stroke-miterlimit="10"/>
                                  <path d="M184.906 69.332C202.245 51.9927 184.011 5.64603 144.179 -34.1862C104.346 -74.0184 57.9998 -92.2525 40.6604 -74.9132C23.3211 -57.5739 41.5552 -11.2272 81.3874 28.605C121.22 68.4372 167.566 86.6713 184.906 69.332Z" stroke="#2A59BD" stroke-miterlimit="10"/>
                                  <path d="M170.965 83.2705C188.305 65.9312 170.071 19.5845 130.238 -20.2477C90.4061 -60.0799 44.0594 -78.314 26.7201 -60.9747C9.38078 -43.6354 27.6149 2.7113 67.4471 42.5435C107.279 82.3757 153.626 100.61 170.965 83.2705Z" stroke="#2A59BD" stroke-miterlimit="10"/>
                                  <path d="M152.373 101.858C169.712 84.5191 151.478 38.1724 111.646 -1.6598C71.8138 -41.492 25.4671 -59.7261 8.12781 -42.3868C-9.2115 -25.0475 9.02261 21.2992 48.8548 61.1314C88.6871 100.964 135.034 119.198 152.373 101.858Z" stroke="#2A59BD" stroke-miterlimit="10"/>
                                  <path d="M161.688 92.5567C179.028 75.2174 160.794 28.8707 120.961 -10.9616C81.1291 -50.7938 34.7824 -69.0279 17.4431 -51.6886C0.103773 -34.3493 18.3379 11.9974 58.1701 51.8296C98.0023 91.6619 144.349 109.896 161.688 92.5567Z" stroke="#2A59BD" stroke-miterlimit="10"/>
                                  <path d="M157.025 97.21C174.364 79.8707 156.13 33.524 116.298 -6.30823C76.4659 -46.1404 30.1192 -64.3746 12.7798 -47.0352C-4.55947 -29.6959 13.6747 16.6508 53.5069 56.483C93.3391 96.3152 139.686 114.549 157.025 97.21Z" stroke="#2A59BD" stroke-miterlimit="10"/>
                                  <path d="M198.862 55.3926C216.201 38.0533 197.967 -8.2934 158.135 -48.1256C118.303 -87.9578 71.9559 -106.192 54.6166 -88.8526C37.2773 -71.5133 55.5114 -25.1666 95.3436 14.6656C135.176 54.4978 181.523 72.7319 198.862 55.3926Z" stroke="#2A59BD" stroke-miterlimit="10"/>
                                </g>
                              </g>
                              <defs>
                                <clipPath id="clip0_1828_4237">
                                  <rect width="207" height="207" fill="white" transform="translate(0 -97)"/>
                                </clipPath>
                              </defs>
                            </svg>
                            <p>We constantly update training programs and materials</p>
                          </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include(get_template_directory() . '/templates/ticker_text.php'); ?>
    <div class='about-us'>
        <img class='about-us-bg'
             src='<?php bloginfo('template_url');?>/assets/img/training-center/about-bg.png' />
        <div class='container'>
            <div class='row'>
                <div class='col-md-4'>
                    <p class='about-us-title'>
                          Learning objectives for the 1st year of the platform's operation
                    </p>
                </div>
                <div class='col-md-8'>
                    <p class='about-us-text2'>
                        The Green Energy Training Center is a place where you can get the comprehensive education and tools you need to participate in important environmental conservation and energy efficiency projects. Our goal is to train qualified professionals capable of contributing to a sustainable future for the planet.<br /><br />
                        Organized into connected modules, courses provide a variety of materials such as articles, videos, and interactive quizzes to provide a comprehensive learning experience.
                    </p>
                </div>
            </div>
            <div class='row about-us-items' style="display:none">
                <?php
                $train_center_items = get_field('traincenteritem');
                if ($train_center_items) {
                    $counter=1;
                    foreach ($train_center_items as $item) {
                        $trainCenterBlock = $item['traincenterblock'];
                        ?>
                        <div class="col-md-3">
                            <div class="about-us-item op<?php echo $counter;?>" style="background-color: <?php echo $trainCenterBlock['train_center_item_color']; ?>;">
                                <p class="train_center_item_count"><?php echo $trainCenterBlock['train_center_item_value']; ?></p>
                                <p><?php echo $trainCenterBlock['train_center_item_text']; ?></p>
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
<?php
global $wpdb;
$tableName = $wpdb->prefix . 'wizard_filter';
$questions = $wpdb->get_results("SELECT * FROM {$tableName}", ARRAY_A);
?>
    <div class="wizard" id="wizard" data-lang="<?php echo $current_lang; ?>">
        <div class="container">
              <div id="wizard__block" class="wizard__block">
                <h2 class="wizard__title">Wizard</h2>
                <p class="wizard__subtitle">The Wizard consists of multiple small stages, on each stage the user must choose one or more options. </p>
                <div class="wizard__options">
                    <div class="wizard__options-item">
                        <h3 class="wizard__options-title"><?php _e('What are you doing?', 'ndp'); ?></h3>
                        <p class="wizard__nothing"><?php _e('Nothing selected', 'ndp'); ?></p>
                         <ul class="wizard__options-list hidden">
                         <?php if (!empty($questions)): ?>
                         <?php foreach ($questions as $question): ?>
                         <?php if ((int)$question['category'] === 1): ?>
                             <?php $question_lang = $question['question_'.$current_lang] ?? ''; ?>
                          <li>
                            <label>
                              <input type="checkbox" class="wizard__options-list__input" value="<?php echo $question['id']; ?>"><span class="wizard__options-list__name"><?php echo $question_lang; ?></span>
                            </label>
                          </li>
                         <?php endif; ?>
                         <?php endforeach; ?>
                         <?php endif; ?>
                         <li>
                             <label>
                                 <input type="checkbox" checked value="" class="js-not-sure wizard__options-list__input"><span class="wizard__options-list__name"><?php _e("I'm not sure", "ndp"); ?></span>
                             </label>
                         </li>
                        </ul>
                        <button class="wizard__options-button__select"><?php _e('Select options', 'ndp'); ?></button>
                        <button class="wizard__options-button__save hidden"><?php _e('Save options', 'ndp'); ?></button>
                    </div>
                    <div class="wizard__options-item wizard__options-item__main">
                        <h3 class="wizard__options-title"><?php _e('What do you want to do?', 'ndp'); ?></h3>
                        <!-- <div class="wizard__nothing-main">Learn more about how the Platform works, Obtain or update existing certificate</div> -->
                        <ul class="wizard__options-list">
                        <?php if (!empty($questions)): ?>
                        <?php foreach ($questions as $question): ?>
                            <?php if ((int)$question['category'] === 2): ?>
                                <?php $question_lang = $question['question_'.$current_lang] ?? ''; ?>
                            <li>
                                <label>
                                    <input type="checkbox" class="wizard__options-list__input" value="<?php echo $question['id']; ?>"><span class="wizard__options-list__name"><?php echo $question_lang; ?></span>
                                </label>
                            </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        </ul>
                        <button class="wizard__options-button__select hidden"><?php _e('Select options', 'ndp'); ?></button>
                        <button class="wizard__options-button__save"><?php _e('Save options', 'ndp'); ?></button>
                    </div>
                    <div class="wizard__options-item">
                        <h3 class="wizard__options-title"><?php _e('In what field?', 'ndp'); ?></h3>
                        <p class="wizard__nothing"><?php _e('Nothing selected', 'ndp'); ?></p>
                        <ul class="wizard__options-list hidden">
                        <?php if (!empty($questions)): ?>
                        <?php foreach ($questions as $question): ?>
                            <?php if ((int)$question['category'] === 3): ?>
                                <?php $question_lang = $question['question_'.$current_lang] ?? ''; ?>
                            <li>
                                <label>
                                    <input type="checkbox" class="wizard__options-list__input" value="<?php echo $question['id']; ?>"><span class="wizard__options-list__name"><?php echo $question_lang; ?></span>
                                </label>
                            </li>
                            <?php endif; ?>
                        <?php endforeach; ?>
                        <?php endif; ?>
                        <li>
                            <label>
                                <input type="checkbox" checked value="" class="js-not-sure wizard__options-list__input"><span class="wizard__options-list__name"><?php _e("I'm not sure", "ndp"); ?></span>
                            </label>
                        </li>
                        </ul>
                        <button class="wizard__options-button__select"><?php _e('Select options', 'ndp'); ?></button>
                        <button class="wizard__options-button__save hidden"><?php _e('Save options', 'ndp'); ?></button>
                    </div>
                </div>
                <a href="" class="wizard__button"><?php _e("Show courses", "ndp"); ?></a>
            </div>
        </div>
    </div>
    <div class='training-paths'>
      <div class='container'>
        <div class='row'>
          <div class='col-md-5'>
            <div class='training-paths-left'>
              <img src='<?php bloginfo('template_url');?>/assets/img/training-center/training-left.png' />
              <div class='training-paths-left-block'>
                <svg xmlns="http://www.w3.org/2000/svg" width="66" height="60" viewBox="0 0 66 60" fill="none">
                  <g clip-path="url(#clip0_2557_23583)">
                    <g opacity="0.9">
                      <path d="M16.4636 18.0361C16.4636 19.7352 17.8509 21.1127 19.5622 21.1127C21.2735 21.1127 22.6607 19.7352 22.6607 18.0361C22.6607 16.3369 21.2735 14.9595 19.5622 14.9595C17.8509 14.9595 16.4636 16.3369 16.4636 18.0361Z" fill="white"/>
                      <path d="M11.0036 27.0658C11.0036 28.7039 12.341 30.0318 13.9907 30.0318C15.6405 30.0318 16.9779 28.7039 16.9779 27.0658C16.9779 25.4278 15.6405 24.0999 13.9907 24.0999C12.341 24.0999 11.0036 25.4278 11.0036 27.0658Z" fill="white"/>
                      <path d="M10.245 37.2745C10.245 38.8515 11.5325 40.1298 13.1207 40.1298C14.7089 40.1298 15.9964 38.8515 15.9964 37.2745C15.9964 35.6976 14.7089 34.4192 13.1207 34.4192C11.5325 34.4192 10.245 35.6976 10.245 37.2745Z" fill="white"/>
                      <path d="M14.1879 46.9383C14.1879 48.4541 15.4255 49.683 16.9521 49.683C18.4788 49.683 19.7164 48.4541 19.7164 46.9383C19.7164 45.4224 18.4788 44.1936 16.9521 44.1936C15.4255 44.1936 14.1879 45.4224 14.1879 46.9383Z" fill="white"/>
                      <path d="M25.0136 51.5254C25.5383 51.5254 26.0512 51.6799 26.4874 51.9693C26.9237 52.2587 27.2637 52.6701 27.4645 53.1514C27.6653 53.6327 27.7178 54.1623 27.6155 54.6733C27.5131 55.1843 27.2604 55.6536 26.8894 56.022C26.5184 56.3903 26.0457 56.6412 25.5311 56.7429C25.0165 56.8445 24.4831 56.7923 23.9984 56.593C23.5136 56.3936 23.0993 56.056 22.8078 55.6228C22.5163 55.1897 22.3607 54.6804 22.3607 54.1594C22.3607 53.4608 22.6402 52.7909 23.1377 52.2969C23.6352 51.8029 24.31 51.5254 25.0136 51.5254Z" fill="white"/>
                      <path d="M34.9522 54.751C35.4548 54.751 35.9462 54.899 36.3641 55.1762C36.7821 55.4535 37.1078 55.8476 37.3002 56.3087C37.4925 56.7698 37.5428 57.2772 37.4448 57.7667C37.3467 58.2562 37.1046 58.7058 36.7492 59.0587C36.3938 59.4116 35.9409 59.6519 35.448 59.7493C34.955 59.8467 34.444 59.7967 33.9796 59.6057C33.5152 59.4147 33.1183 59.0913 32.8391 58.6763C32.5598 58.2613 32.4108 57.7735 32.4108 57.2744C32.4108 56.6051 32.6785 55.9633 33.1551 55.4901C33.6317 55.0168 34.2781 54.751 34.9522 54.751Z" fill="white"/>
                      <path d="M42.7993 56.185C42.7993 57.5175 43.8873 58.5978 45.2293 58.5978C46.5714 58.5978 47.6593 57.5175 47.6593 56.185C47.6593 54.8525 46.5714 53.7722 45.2293 53.7722C43.8873 53.7722 42.7993 54.8525 42.7993 56.185Z" fill="white"/>
                      <path d="M52.1207 50.8956C52.1207 52.1671 53.1588 53.1978 54.4393 53.1978C55.7198 53.1978 56.7579 52.1671 56.7579 50.8956C56.7579 49.6242 55.7198 48.5935 54.4393 48.5935C53.1588 48.5935 52.1207 49.6242 52.1207 50.8956Z" fill="white"/>
                      <path d="M60.8764 40.0701C61.3128 40.0709 61.7391 40.2002 62.1015 40.4415C62.4639 40.6828 62.7461 41.0253 62.9125 41.4259C63.0789 41.8264 63.122 42.2669 63.0364 42.6917C62.9507 43.1165 62.7402 43.5066 62.4313 43.8127C62.1225 44.1187 61.7292 44.327 61.3012 44.4113C60.8731 44.4955 60.4296 44.4518 60.0265 44.2858C59.6235 44.1198 59.279 43.8389 59.0367 43.4786C58.7943 43.1183 58.665 42.6948 58.665 42.2616C58.665 41.9734 58.7222 41.6881 58.8334 41.4219C58.9446 41.1558 59.1075 40.914 59.313 40.7104C59.5184 40.5069 59.7622 40.3456 60.0305 40.2357C60.2987 40.1258 60.5862 40.0695 60.8764 40.0701Z" fill="white"/>
                      <path d="M63.5036 30.1851C63.9191 30.1842 64.3255 30.3058 64.6715 30.5344C65.0174 30.763 65.2872 31.0883 65.4468 31.4693C65.6064 31.8502 65.6486 32.2696 65.568 32.6743C65.4875 33.0791 65.2878 33.451 64.9943 33.743C64.7008 34.0351 64.3266 34.2341 63.9192 34.3149C63.5117 34.3957 63.0892 34.3547 62.7052 34.197C62.3213 34.0393 61.993 33.772 61.7621 33.429C61.5312 33.0861 61.4079 32.6828 61.4079 32.2702C61.4073 31.9966 61.4611 31.7255 61.5662 31.4725C61.6712 31.2196 61.8255 30.9897 62.0202 30.796C62.2149 30.6024 62.4461 30.4487 62.7006 30.3439C62.9552 30.239 63.228 30.1851 63.5036 30.1851Z" fill="white"/>
                      <path d="M62.3207 20.0916C62.713 20.0924 63.0962 20.2087 63.422 20.4257C63.7477 20.6427 64.0014 20.9507 64.1509 21.3108C64.3005 21.6708 64.3391 22.0669 64.2621 22.4488C64.1851 22.8307 63.9957 23.1813 63.718 23.4564C63.4404 23.7316 63.0868 23.9188 62.702 23.9944C62.3172 24.0701 61.9184 24.0309 61.5561 23.8816C61.1938 23.7324 60.8841 23.4798 60.6663 23.1559C60.4485 22.832 60.3322 22.4513 60.3322 22.0618C60.3322 21.8027 60.3837 21.5461 60.4836 21.3068C60.5836 21.0675 60.7302 20.8501 60.9149 20.6671C61.0996 20.4841 61.3189 20.3391 61.5601 20.2403C61.8013 20.1416 62.0598 20.091 62.3207 20.0916Z" fill="white"/>
                      <path d="M57.3236 10.9128C57.6938 10.9137 58.0555 11.0235 58.3629 11.2283C58.6703 11.4332 58.9097 11.7239 59.0508 12.0637C59.1919 12.4036 59.2284 12.7774 59.1557 13.1378C59.0829 13.4982 58.9042 13.8292 58.6421 14.0888C58.38 14.3485 58.0463 14.5252 57.6831 14.5966C57.3199 14.668 56.9436 14.6309 56.6016 14.49C56.2596 14.3492 55.9674 14.1108 55.7618 13.8051C55.5562 13.4994 55.4464 13.14 55.4464 12.7724C55.4464 12.5279 55.495 12.2857 55.5894 12.0598C55.6838 11.8339 55.8222 11.6287 55.9965 11.456C56.1709 11.2832 56.3778 11.1464 56.6056 11.0532C56.8333 10.96 57.0773 10.9123 57.3236 10.9128Z" fill="white"/>
                      <path d="M49.0222 3.99366C49.3718 3.99282 49.7137 4.09503 50.0048 4.28735C50.2958 4.47967 50.5228 4.75343 50.6569 5.07395C50.7911 5.39448 50.8265 5.74733 50.7585 6.08781C50.6905 6.42829 50.5222 6.74109 50.275 6.98654C50.0278 7.23198 49.7128 7.39905 49.3699 7.46656C49.027 7.53407 48.6716 7.49898 48.3488 7.36576C48.0259 7.23254 47.7502 7.00718 47.5565 6.71821C47.3629 6.42925 47.2599 6.0897 47.2608 5.74259C47.2619 5.27909 47.4478 4.83488 47.7779 4.50713C48.108 4.17939 48.5554 3.99478 49.0222 3.99366Z" fill="white"/>
                      <path d="M39.2122 0.444586C39.5395 0.444587 39.8595 0.541036 40.1317 0.721711C40.4038 0.902386 40.6158 1.15918 40.7409 1.45956C40.866 1.75995 40.8985 2.09042 40.8343 2.40916C40.7701 2.7279 40.6122 3.02055 40.3804 3.2501C40.1486 3.47964 39.8534 3.63575 39.5322 3.69864C39.2111 3.76154 38.8783 3.7284 38.5761 3.60343C38.2739 3.47845 38.0158 3.26728 37.8346 2.99661C37.6533 2.72593 37.557 2.40795 37.5578 2.0829C37.5578 1.8674 37.6007 1.65401 37.6839 1.45496C37.767 1.25592 37.889 1.07511 38.0426 0.922919C38.1963 0.770734 38.3787 0.650166 38.5794 0.568084C38.7801 0.486003 38.9951 0.444026 39.2122 0.444586Z" fill="white"/>
                      <path d="M28.8708 0.304199C29.1759 0.304199 29.4742 0.394062 29.7279 0.562391C29.9816 0.73072 30.1794 0.96996 30.2962 1.24988C30.4129 1.5298 30.4435 1.83783 30.384 2.13499C30.3244 2.43216 30.1775 2.70512 29.9617 2.91936C29.7459 3.1336 29.471 3.2795 29.1717 3.33861C28.8725 3.39772 28.5623 3.36736 28.2803 3.25142C27.9984 3.13547 27.7575 2.93914 27.5879 2.68722C27.4184 2.4353 27.3279 2.13911 27.3279 1.83613C27.3279 1.42984 27.4904 1.04019 27.7798 0.752898C28.0691 0.465609 28.4616 0.304199 28.8708 0.304199Z" fill="white"/>
                      <path d="M18.9236 3.57666C19.2067 3.57666 19.4834 3.66003 19.7188 3.8162C19.9542 3.97238 20.1377 4.19436 20.2461 4.45406C20.3544 4.71376 20.3828 4.99953 20.3275 5.27523C20.2723 5.55093 20.136 5.80418 19.9358 6.00295C19.7356 6.20172 19.4805 6.33707 19.2029 6.39191C18.9252 6.44675 18.6374 6.41861 18.3758 6.31103C18.1143 6.20346 17.8907 6.02129 17.7334 5.78756C17.5761 5.55383 17.4922 5.27905 17.4922 4.99795C17.4933 4.62135 17.6445 4.26049 17.9127 3.99419C18.1809 3.72789 18.5443 3.57778 18.9236 3.57666Z" fill="white"/>
                      <path d="M8.98073 11.5594C8.98073 12.2833 9.57171 12.8701 10.3007 12.8701C11.0297 12.8701 11.6207 12.2833 11.6207 11.5594C11.6207 10.8356 11.0297 10.2488 10.3007 10.2488C9.57171 10.2488 8.98073 10.8356 8.98073 11.5594Z" fill="white"/>
                      <path d="M3.09217 20.4319C3.09217 21.0947 3.63326 21.6319 4.30074 21.6319C4.96822 21.6319 5.50931 21.0947 5.50931 20.4319C5.50931 19.7692 4.96822 19.2319 4.30074 19.2319C3.63326 19.2319 3.09217 19.7692 3.09217 20.4319Z" fill="white"/>
                      <path d="M0.297873 30.3809C0.297873 30.9825 0.78908 31.4702 1.39502 31.4702C2.00095 31.4702 2.49216 30.9825 2.49216 30.3809C2.49216 29.7792 2.00095 29.2915 1.39502 29.2915C0.78908 29.2915 0.297873 29.7792 0.297873 30.3809Z" fill="white"/>
                      <path d="M1.58361 39.6829C1.77857 39.6829 1.96915 39.7403 2.13125 39.8478C2.29335 39.9554 2.41966 40.1082 2.49427 40.287C2.56888 40.4659 2.58844 40.6627 2.55041 40.8525C2.51237 41.0424 2.41847 41.2168 2.28061 41.3536C2.14276 41.4905 1.96713 41.5837 1.77592 41.6215C1.58471 41.6593 1.38653 41.6399 1.20641 41.5658C1.0263 41.4917 0.872341 41.3663 0.764029 41.2053C0.655717 41.0444 0.597874 40.8552 0.597874 40.6616C0.597874 40.402 0.701748 40.1531 0.886605 39.9695C1.07146 39.786 1.32218 39.6829 1.58361 39.6829Z" fill="white"/>
                      <path d="M4.86646 49.6531C5.03599 49.6531 5.20169 49.703 5.34264 49.7965C5.4836 49.89 5.59349 50.0229 5.65837 50.1784C5.72324 50.334 5.7402 50.5051 5.70713 50.6702C5.67405 50.8353 5.59242 50.9869 5.47254 51.1059C5.35267 51.2249 5.19994 51.306 5.03367 51.3388C4.8674 51.3717 4.69507 51.3548 4.53844 51.2904C4.38182 51.226 4.24795 51.1169 4.15377 50.977C4.05958 50.837 4.00932 50.6725 4.00932 50.5041C4.00932 50.2784 4.09959 50.0619 4.26033 49.9023C4.42108 49.7427 4.63914 49.6531 4.86646 49.6531Z" fill="white"/>
                      <path d="M10.4765 59.215C10.4765 59.6333 10.818 59.9724 11.2393 59.9724C11.6606 59.9724 12.0022 59.6333 12.0022 59.215C12.0022 58.7966 11.6606 58.4575 11.2393 58.4575C10.818 58.4575 10.4765 58.7966 10.4765 59.215Z" fill="white"/>
                    </g>
                  </g>
                  <defs>
                    <clipPath id="clip0_2557_23583">
                      <rect width="66" height="60" fill="white" transform="matrix(-1 0 0 -1 66 60)"/>
                    </clipPath>
                  </defs>
                </svg>
                <p>Awareness and knowledge pave the way to sustainable future</p>
              </div>
            </div>
          </div>
          <div class='col-md-7'>
            <div class='training-paths-ringht'>
              <div class='training-paths-ringht-title'>Training programs</div>
              <div class='training-paths-ringht-text'>Training programs consist of a series of structured courses and modules designed to guide users on the path to energy efficiency expertise.</br>Users can choose from a variety of learning programs tailored to their interests or professional goals, making it easy to acquire the knowledge and skills they need to become agents of positive change towards a sustainable future, or even part of the Platform.</div>
              <div class='training-paths-ringht-text2'>Coming soon</div>
              <div class='btn-disable'>Go to Training programs</div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
    <?php include(get_template_directory() . '/templates/partners.php'); ?>
    <div class="subscribe">
        <div class='container'>
            <div class='row'>
                <div class='col-md-12'>
                    <div class='subscribe-block bg'>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='subscribe-left'>
                                    <img src='<?php bloginfo('template_url');?>/assets/img/training-center/Graphic_Elements.png'
                                         class='subscribe-left-bg' />
                                    <div class='subscribe-left-title'>Subscribe to new courses</div>
                                    <p>And be the first to know about new courses and trainings on our platform.</p>
                                    <a href="/en/contacts/" class="btn btn_bg_primary"><img
                                                src='<?php bloginfo('template_url');?>/assets/img/training-center/mail.svg' /> Subscribe Now
                                    </a>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='subscribe-right'>
                                    <img src='<?php bloginfo('template_url');?>/assets/img/training-center/right-small.png' />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include(get_template_directory() . '/templates/ticker_text.php'); ?>

<?php
$questionsArray = [];
if (!empty($questions)) {
    foreach ($questions as $question) {
        $filterKeys = preg_grep('/^filters_[A-Za-z]+/', array_keys($question));
        foreach ($filterKeys as $filterKey) {
            if ($filterKey != 'filters_'.$current_lang) {
                unset($question[$filterKey]);
            }
        }
        $filters = unserialize($question['filters_'.$current_lang]);
        $filters = $filters? $filters : [];
        $question['filters_'.$current_lang] = $filters;
        $questionsArray[] = $question;
    }
}
?>
<script>
    var questionsArray = JSON.parse(atob('<?php echo base64_encode(json_encode($questionsArray)); ?>'));
</script>

<?php

get_footer();
