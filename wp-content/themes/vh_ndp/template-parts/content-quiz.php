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
$quiz = new LLMS_Quiz($post);
$lesson = $quiz->get_lesson();
$course = $lesson->get_course();
$courseProgress = (int)$student->get_progress($course->get('id'));
$sections = $course->get_sections();
$totalLength = prepareCourseTime(calculateTimeOfCourse($course));

$isSurvey = false;
if ($course) {
    $isSurvey = get_post_meta($course->get('id'), 'type', true);
}


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
        if ($_lesson->get('id') == $lesson->get('id')) {
            $sections[$key]->currentSection = true;
        }
        if ($_lesson->is_complete()) {
            $completedLessons++;
        }
    }
    $sections[$key]->completedLessons = $completedLessons;
    $completedLessonsCount += $completedLessons;
}
?>

<section class="course">
    <div class="container">
        <div class="course__header">
            <div class="course__title">
                <a href="<?php echo get_permalink($lesson->get('id')); ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M15.7049 7.41L14.2949 6L8.29492 12L14.2949 18L15.7049 16.59L11.1249 12L15.7049 7.41Z" fill="#2A59BD"/>
                    </svg>
                </a>
                <h1><?php echo $lesson->get('title') ?></h1>
            </div>
            <div class="course__title-right">
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
                <div class="course__quiz <?php if ($isSurvey) echo 'course__quiz--survey'; ?>">
                    <?php the_content(); ?>
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
