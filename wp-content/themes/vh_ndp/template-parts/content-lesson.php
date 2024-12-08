<?php
/**
 * Template part for displaying posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

global $post;

$student = llms_get_student();
$lesson   = new LLMS_Lesson($post);
$course = $lesson->get_course();
$courseProgress = 0;
if ($student) {
    $courseProgress = (int)$student->get_progress($course->get('id'));
}
$sections = $course->get_sections();
$totalLength = prepareCourseTime(calculateTimeOfCourse($course));


$countLessons = 0;
$completedLessonsCount = 0;
foreach ($sections as $key => $section) {

    $lessons = $section->get_lessons();
    if ($lessons) {
        $countLessons += count($lessons);
        $sections[$key]->lessons = $lessons;
    }
    $completedLessons = 0;
    foreach ($lessons as $_lesson) {
        if ($_lesson->get('id') == $post->ID) {
            $sections[$key]->currentSection = true;
        }
        if ($_lesson->is_complete()) {
            $completedLessons++;
        }
    }
    $sections[$key]->completedLessons = $completedLessons;
    $completedLessonsCount += $completedLessons;
}



$is_survey = get_post_meta($course->get('id'), 'type', true);
if ($is_survey && $lesson->has_quiz()) {
    wp_safe_redirect(get_permalink( $lesson->get( 'quiz' ) ));
    exit;
}
?>

<section class="course">
    <div class="container">
        <div class="course__header">
            <div class="course__title">
                <a href="#">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M15.7049 7.41L14.2949 6L8.29492 12L14.2949 18L15.7049 16.59L11.1249 12L15.7049 7.41Z" fill="#2A59BD"/>
                    </svg>
                </a>
                <h1><?php the_title(); ?></h1>
            </div>
            <div class="course__title-right">
<!--                <div class="course__header-limit">-->
<!--                    <div class="course__header-limit__time">00:09:42:16</div>-->
<!--                    <div class="course__header-limit__text">-->
<!--                        <h4 class="course__header-limit__title">Time left</h4>-->
<!--                        <span class="course__header-limit__subtitle">Progress will be reset</span>-->
<!--                    </div>-->
<!--                </div>-->
                <div class="course__progress">
                    <div class="course__progress-text">
                        <h2 class="course__progress-title"><?php _e('Your progress', 'ndp'); ?></h2>
                        <span class="course__progress-subtitle">
                            <?php echo sprintf( __( '%d of %d', 'ndp' ), $completedLessonsCount, $countLessons ); ?> <?php _e('completed', 'ndp'); ?>
                        </span>
                    </div>
                    <div class="course__progress-item" data-inner-circle-color="white" data-percentage="<?php echo $courseProgress; ?>" data-progress-color="#4770c6" data-bg-color="#dce2f9">
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
                    <div class="course-training-page-left-box-article">
                        <div class="course-training-page-left-box-article-content">
                        <?php
                        the_content();
                        ?>
                        </div>
                        <button class="course-training-page-left-box-article-button" data-collapse="<?php _e('Collapse', 'ndp'); ?>" data-expand="<?php _e('Expand', 'ndp'); ?>">
                            <span></span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                                <mask id="mask0_3481_33304" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="19" height="18">
                                    <rect x="0.5" width="18" height="18" fill="#D9D9D9"/>
                                </mask>
                                <g mask="url(#mask0_3481_33304)">
                                    <path d="M5.95625 11.6999L5 10.7437L9.5 6.24365L14 10.7437L13.0437 11.6999L9.5 8.15615L5.95625 11.6999Z" fill="#151B2C"/>
                                </g>
                            </svg>
                            <strong><?php _e('Collapse', 'ndp'); ?></strong>
                        </button>
                    </div>

<!--                    <div class="course-training-page-left-box-limit">-->
<!--                        <h2 class="course-training-page-left-box-limit-title">Time to complete the course is limited</h2>-->
<!--                        <div class="course-training-page-left-box-limit-alert">-->
<!--                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">-->
<!--                                <path d="M11.9995 9V11M11.9995 15H12.0095M5.07134 19H18.9277C20.4673 19 21.4296 17.3333 20.6598 16L13.7316 4C12.9618 2.66667 11.0373 2.66667 10.2675 4L3.33929 16C2.56949 17.3333 3.53174 19 5.07134 19Z" stroke="#B38307" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>-->
<!--                            </svg>-->
<!--                            <span class="course-training-page-left-box-limit-alert-text">You must complete the course within 48 hours. Otherwise, the course progress will be reset.</span>-->
<!--                        </div>-->
<!--                        <button class="course-training-page-left-box-limit-button">Get Started</button>-->
<!--                    </div>-->

                    <div class='course-training-page-left-box-description'>
                        <div class='course-training-page-left-box-description-title'>
                            <span><?php _e('About this course', 'ndp'); ?></span>
                            <div class='btn btn-outline-link-circle active'>
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
                        <div class="course-training-page-description-accordion">
                            <?php
                            $courseDescription = get_field('course_training_page_description', $course->get('id')) ?? '';
                            echo $courseDescription;

                            lifterlms_template_single_parent_course();

                            $author_id = $course->get('author');
                            $name = get_the_author_meta( 'display_name', $author_id );
                            $img = get_avatar( $author_id, 100, apply_filters( 'lifterlms_author_avatar_placeholder', '' ), $name );
                            $desc = get_the_author_meta( 'description', $author_id );
                            $desc = $desc? $desc : '';
                            ?>
                            <div class='course-training-page-left-box-description-instruction'>
                                <div class='course-training-page-left-box-description-instruction-title'><?php _e('Author', 'ndp'); ?></div>
                                <div class='course-training-page-left-box-description-instruction-content'>
                                    <div class='course-training-page-left-box-description-instruction-content-img'>
                                        <div class="course__instructor-image"><?php echo $img; ?></div>
                                    </div>
                                    <div class='course-training-page-left-box-description-instruction-content-box'>
                                        <div class='course-training-page-left-box-description-instruction-content-box-title'><?php echo $name; ?></div>
                                        <div class='course-training-page-left-box-description-instruction-content-box-text'><?php echo $desc; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="course__content col-md-4">
                <div class="course__content-title">
                    <h2><?php _e('Course content', 'ndp'); ?></h2>
                </div>
                <?php if ( ! $sections ) : ?>

                    <p><?php _e( 'This course does not have any sections.', 'lifterlms' ); ?></p>

                <?php else : ?>
                <div class="course__accordion">
                    <?php foreach ( $sections as $section ) : ?>
                    <?php
                    $lessons = $section->lessons ?? [];
                    $lesson_order = 0;
                    $sectionTime = prepareCourseTime(calculateTimeOfLessons($lessons));
                    $countLessons = count($lessons);
                    $completedLessons = $section->completedLessons ?? 0;
                    $currentSection = !empty($section->currentSection)? true : false;
                    ?>
                    <div class="course__accordion-item">
                        <div class="course__accordion-header">
                            <span class="accordion-plus <?php if ($currentSection) echo 'accordion-plus-active'; ?>"></span>
                            <div class="course__accordion-header__text">
                                <h3 class="course__accordion-title"><?php echo get_the_title( $section->get( 'id' ) ); ?></h3>
                                <div class="course__accordion-info">
                                    <span class="course__accordion-info__text"><?php echo $completedLessons; ?>/<?php echo $countLessons; ?></span>
                                    <span class="course__accordion-info__text"><?php echo $sectionTime; ?></span>
                                    <?php if ($countLessons == $completedLessons): ?>
                                    <span class="course__accordion-info__label"><?php _e('Completed', 'ndp'); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="course__accordion-hidden" <?php if ($currentSection) echo 'style="display: block"'; ?>>
                            <ul class="course__accordion-list">
                            <?php foreach ( $lessons as $_lesson ) : ?>
                            <?php
                            llms_get_template(
                                'course/lesson-training-preview.php',
                                array(
                                    'lesson'        => $_lesson,
                                    'total_lessons' => count( $lessons ),
                                    'order'         => ++$lesson_order,
                                )
                            );
                            ?>
                            <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>
