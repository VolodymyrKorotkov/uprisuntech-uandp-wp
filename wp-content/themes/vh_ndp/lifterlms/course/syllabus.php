<?php
/**
 * Template for the Course Syllabus Displayed on individual course pages
 *
 * @author LifterLMS
 * @package LifterLMS/Templates
 *
 * @since 1.0.0
 * @since 3.24.0 Unknown.
 * @since 4.4.0 Pass the progressive lesson order value to the lesson-preview template.
 * @since 7.1.3 Add paragraph tag to wrap message when sections or lessons are empty.
 * @version 7.1.3
 */
defined( 'ABSPATH' ) || exit;
global $post;
$course   = new LLMS_Course( $post );
$sections = $course->get_sections();

$totalLength = prepareCourseTime(calculateTimeOfCourse($course));
?>

<div class="clear"></div>

<div class="llms-syllabus-wrapper">

	<?php if ( ! $sections ) : ?>

		<p><?php _e( 'This course does not have any sections.', 'lifterlms' ); ?></p>

	<?php else : ?>

    <?php

    $countLessons = 0;
    foreach ( $sections as $key => $section ) {

        $lessons = $section->get_lessons();

        if ($lessons) {
            $countLessons += count($lessons);
            $sections[$key]->lessons = $lessons;
        }
    }
    ?>
    <h3 class="course__program"><?php _e('Program', 'ndp'); ?></h3>
    <div class="course__program-info">
        <?php
        $current_lang = apply_filters( 'wpml_current_language', 'uk');
        if ($current_lang == 'uk') {
            $sectionsCountText = declOfNum(count($sections), ['секція', 'секції', 'секцій']);
            $lessonsCountText = declOfNum($countLessons, ['частина', 'частини', 'частин']);
        } else {
            $sectionsCountText = sprintf( _n( '%s section', '%s sections', count($sections), 'ndp' ), count($sections) );
            $lessonsCountText = sprintf( _n( '%s part', '%s parts', $countLessons, 'ndp' ), $countLessons );
        }
        ?>
        <span class="course__program-info__text course__program-section"><?php echo $sectionsCountText; ?></span>
        <span class="course__program-info__text course__program-lectures"><?php echo $lessonsCountText; ?></span>
        <span class="course__program-info__text course__program-total"><?php echo $totalLength; ?> <?php _e('total length', 'ndp'); ?></span>
    </div>
    <div class="course__accordion">
		<?php foreach ( $sections as $section ) : ?>
        <?php $lessons = $section->lessons ?? []; ?>
        <?php $lesson_order = 0; ?>
        <?php $sectionTime = prepareCourseTime(calculateTimeOfLessons($lessons)); ?>
      <div class="course__accordion-item">
			<?php if ( apply_filters( 'llms_display_outline_section_titles', true ) ) : ?>
        <div class="course__accordion-header">
          <span class="accordion-plus"></span>
          <h3 class="course__accordion-title"><?php echo get_the_title( $section->get( 'id' ) ); ?></h3>
          <div class="course__accordion-info">
            <span class="course__program-info__text course__accordion-section"><?php echo sprintf( _n( '%s '.__('part','ndp'), '%s '.__('parts','ndp'), count($lessons), 'ndp' ), count($lessons) ); ?></span>
            <span class="course__program-info__text course__accordion-time"><?php echo $sectionTime; ?></span>
          </div>
        </div>
			<?php endif; ?>

			<?php if ( $lessons ) : ?>
        <ul class="course__accordion-list">
        <?php foreach ( $lessons as $lesson ) : ?>
        <?php
            llms_get_template(
                'course/lesson-preview.php',
                array(
                    'lesson'        => $lesson,
                    'total_lessons' => count( $lessons ),
                    'order'         => ++$lesson_order,
                )
            );
        ?>
        <?php endforeach; ?>
        </ul>
			<?php else : ?>

				<p><?php _e( 'This section does not have any lessons.', 'lifterlms' ); ?></p>

			<?php endif; ?>
      </div>
		<?php endforeach; ?>
    </div>

	<?php endif; ?>

	<div class="clear"></div>

</div>
