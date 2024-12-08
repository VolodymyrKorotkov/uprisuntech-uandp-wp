<?php
/**
 * Template part for displaying course
 */


global $post;
wp_enqueue_style('course-survey', get_template_directory_uri() . '/assets/css/main.min.css');
//llms_print_notices();

$current_lang = apply_filters( 'wpml_current_language', 'uk' );

$course = new LLMS_Course( $post );
$isSurvey = get_field('type');
$userAllowed = true;
if ($isSurvey) {
    $allowed_users_roles = get_post_meta( $course->get('id'), 'survey_user_roles', 1 );
    if (is_user_logged_in()) {
        $student = llms_get_student();
        $user = $student->get('user');
        $user_id = $user->ID;
        $user_roles = $user->roles;
        $user_role = $user_roles[0];
        $municipality = get_user_meta( $user_id, 'user_profile_type', true );
        if (!empty($municipality)) {
            $municipality_role = 'municipality';
            $user_role = null;
        }
        $allowedUserRolesArray = explode(',', $allowed_users_roles);
        if (($user_role && !in_array($user_role, $allowedUserRolesArray)) || (!empty($municipality_role) && !in_array($municipality_role, $allowedUserRolesArray))) {
            $userAllowed = false;
        }
    }
}

$product = new LLMS_Product( $post );
$plans = $product->get_access_plans();
$course_total_time = prepareCourseTime(calculateTimeOfCourse($course));

$instructors = $course->get_instructors();
if (empty($instructors)) return;

$instructor = llms_get_instructor($instructors[0]['id']);
$author_id = $course->get('author');
$name = get_the_author_meta( 'display_name', $author_id );
$avatar = get_avatar( $author_id, 100, apply_filters( 'lifterlms_author_avatar_placeholder', '' ), $name );

global $sitepress;
$courseUrl = '/courses/';
if ($sitepress) {
    $courseUrl = $sitepress->convert_url( $sitepress->get_wp_api()->get_post_type_archive_link( 'course' ), $current_lang );
}
$url = $courseUrl.'?'.http_build_query(['author' => [$author_id]]);
?>
<section class="course <?php if ($isSurvey) echo 'survey-page'; ?>" data-course-id="<?php echo get_the_ID(); ?>">
    <div class="container">
        <div class="course__block">
            <div class="course__main">
                <nav class="breadcrumb">
                    <div class="breadcrumb-block">
                        <?php yoast_breadcrumb(); ?>
                    </div>
                </nav>
                <div class="errors">
                    <?php if (!empty($_REQUEST['error'])): ?>
                    <div class="error" style="color: red;font-weight: bold;"><?php _e('Key validation error', 'ndp'); ?></div>
                    <?php endif; ?>
                </div>
                <h1 class="course__title"><?php echo get_the_title(); ?></h1>
                <?php
                $shortDescription = get_field('course_short_description') ?? '';
                $categories = wp_get_post_terms(get_the_ID(), 'course_cat');
                $tags = wp_get_post_terms(get_the_ID(), 'course_tag');
                ?>
                <p class="course__subheading"><?php echo $shortDescription; ?></p>
                <div class="course__tags">
                    <?php if (!empty($categories)): ?>
                        <span class="course__category"><?php echo $categories[0]->name; ?></span>
                    <?php endif; ?>
                    <?php if ($course->get_difficulty()): ?>
                        <span class="course__complexity" title="<?php _e('Difficulty', 'ndp'); ?>"><?php echo $course->get_difficulty(); ?></span>
                    <?php endif; ?>
                    <?php if (!empty($tags)): ?>
                        <?php
                        if (!$isSurvey):
                            foreach ($tags as $k => $tag): ?>
                                <span class="course__level"><?php echo $tag->name; ?></span>
                            <?php endforeach;
                        else: ?>
                            <span class="course__level"><?php echo $tags[0]->name; ?></span>
                            <?php if (count($tags) > 1): ?>
                                <?php
                                $hover = '<div class="wrapper-hover-block tooltip-bottom"><div class="wrapper-hover-block__container">';
                                $more = '';
                                foreach ($tags as $k => $tag) {
                                    $hover .= '<span class="course__level more-hover-item-'.$k.'">'. $tag->name .'</span>';
                                }
                                $count = count($tags) - 1;
                                $hover .= '</div></div>';
                                $more .= '<div class="library__course-more more-hover">+<span class="more-hover-count" data-count="'. $count .'" data-count-mob="'. ($count+1) .'"></span>'. $hover . '</div>';
                                echo $more;
                                ?>
                            <?php endif; ?>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="course__info">
                    <div class="course__author course__info-item">
                        <span><?php _e('Author', 'ndp'); ?>:</span>
                        <strong><?php echo llms_get_author(
                                array(
                                    'avatar' => false,
                                )
                            ); ?></strong>
                    </div>
                    <?php if ($course_total_time): ?>
                        <div class="course__totalTime course__info-item">
                            <span><?php _e('Total time', 'ndp'); ?>:</span>
                            <strong><?php echo $course_total_time; ?></strong>
                        </div>
                    <?php endif; ?>
                    <?php
                    if ($isSurvey) {
                        $startDate = get_field('survey_start_date', $course->get('id'));
                        $finishDate = get_field('survey_finish_date', $course->get('id'));
                    ?>
                    <div class="course__info-item">
                        <span><?php _e('Start', 'ndp'); ?>:</span>
                        <strong><?php echo $startDate; ?></strong>
                    </div>
                    <div class="course__info-item">
                        <span><?php _e('Ends', 'ndp'); ?>:</span>
                        <strong><?php echo $finishDate; ?></strong>
                    </div>
                    <?php } ?>
                </div>
                <div class="course__about">
                    <h2 class="course__description"><?php _e('Description', 'ndp'); ?></h2>
                    <?php the_content(); ?>
                </div>
            </div>

            <?php if (get_field('type')): ?>
            <div class="col-md-12">
                <div class="c-survey__aside">
                    <div class="c-label">
                        <div class="c-label__item c-label__item--gold"><?php _e('Available', 'ndp'); ?></div>
                    </div>
                    <div class="c-survey__aside-head"><?php _e('This survay includes', 'ndp'); ?>:</div>
                    <?php
                    $surveyDesc = get_field('survey_opis_pered_knopkoyu');
                    if ($surveyDesc) {
                        echo $surveyDesc;
                    } else {
                        $lessons = $course->get_lessons();
                        $countQuestions = 0;
                        foreach ($lessons as $lesson) {
                            $quiz = $lesson->get_quiz();
                            if ($quiz) {
                                $countQuestions += count($quiz->get_questions());
                            }
                        }
                        if ($current_lang == 'uk') {
                            $quizzesCountText = declOfNum($countQuestions, ['питання', 'питання', 'питань']);
                        } else {
                            $quizzesCountText = sprintf( _n( '%s question', '%s questions', $countQuestions, 'ndp' ), $countQuestions );
                        } ?>
                        <div class="course__card-header">
                            <span class="course__card-free"><?php echo $quizzesCountText; ?></span>
                        </div>
                        <?php
                    }
                    lifterlms_template_pricing_table();

                    if ($userAllowed) {
                        lifterlms_course_continue_button();
                    } else {
                        echo '<div class="not-allowed">'.__('Not allowed', 'ndp').'</div>';
                    }
                    ?>
                </div>
            </div>
            <?php else: ?>
            <div class="course__card-overlay">
                <div class="course__card">
                    <?php
                    $img = '';
                    if ( has_post_thumbnail( $post->ID ) ) {
                        $img = llms_featured_img( $post->ID, 'full' );
                    } elseif ( llms_placeholder_img_src() ) {
                        $img = llms_placeholder_img();
                    }

                    $price = '';
                    $isFree = false;
                    foreach ($plans as $plan) {
                        $planPrice = (int)$plan->get_initial_price();
                        if (!$price && $planPrice && $planPrice > 0) {
                            $price = $planPrice;
                        }
                        if (!$isFree && $planPrice && $planPrice === 0) {
                            $isFree = true;
                        }
                    }
                    if (!$price) {
                        $isFree = true;
                    }
                    ?>

                    <div class="course__card-image">
                        <?php echo $img; ?>
                    </div>

                    <div class="course__card-content">
                        <?php
                        if (!get_field('type')):
                        lifterlms_template_pricing_table();




                        endif;
                        lifterlms_course_continue_button();
                        ?>




                        <!-- <div class="course__card-choice">
                          <span class="course__card-choice__item">Complete a Level 1 course</span>
                          <span class="course__card-choice__item">Upload your certificate</span>
                        </div> -->
                    </div>

                    <div class="course__card__footer">
                        <div class="course__card-footer__image"><?php echo $avatar; ?></div>
                        <div class="course__card-footer__text">
                            <span class="course__card-footer__title"><?php _e('Author', 'ndp'); ?></span>
                            <span class="course__card-footer__subtitle"><?php echo $name ?></span>
                            <a href="<?php echo $url; ?>" class="course__card-footer__link"><?php _e('See all courses', 'ndp'); ?></a>
                        </div>
                    </div>
                </div>

            </div>
            <?php endif; ?>
        </div>
        <?php if (!get_field('type')): ?>
        <div class="subscribe">
            <div class='row'>
                <div class='col-md-12'>
                    <div class='subscribe-block bg'>
                        <div class='row'>
                            <div class='col-md-6'>
                                <div class='subscribe-left'>
                                    <img src='<?php bloginfo('template_url');?>/assets/img/courses-library/Graphic_Elements.png'
                                         class='subscribe-left-bg' />
                                    <div class='subscribe-left-title'><?php _e('Subscribe to new courses', 'ndp'); ?></div>
                                    <p><?php _e('And be the first to know about new courses and trainings on our platform.', 'ndp'); ?></p>
                                    <a href="<?php echo $courseUrl; ?>" class="btn btn_bg_primary">
                                        <img src='<?php bloginfo('template_url');?>/assets/img/courses-library/mail.svg' /> <?php _e('Subscribe Now', 'ndp'); ?>
                                    </a>
                                </div>
                            </div>
                            <div class='col-md-6'>
                                <div class='subscribe-right'>
                                    <img src='<?php bloginfo('template_url');?>/assets/img/courses-library/right-small.png' />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php if (!is_user_logged_in()): ?>
<div class="modal">
  <div class="modal__block modal__login">
    <div class="modal__body">
        <?php
        llms_get_login_form();
        ?>
    </div>
  </div>
</div>
<?php endif; ?>