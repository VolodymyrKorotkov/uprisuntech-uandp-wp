<?php
/**
 * Lesson navigation template
 *
 * @package LifterLMS/Templates
 *
 * @since Unknown Introduced.
 * @since 5.7.0 Replaced the call to the deprecated `LLMS_Lesson::get_parent_course()` method with `LLMS_Lesson::get( 'parent_course' )`.
 * @version 5.7.0
 */

defined( 'ABSPATH' ) || exit;

global $post;

$lesson = new LLMS_Lesson( $post->ID );
$student = llms_get_student();

$files = get_field('files_group');
if (!empty($files)): ?>
    <div class="files-block">
        <div class="files-row">
            <?php foreach ($files as $key => $file): ?>
                <?php $file = $file['file'] ?? []; ?>
                <?php if (empty($file)) continue; ?>
                <div class="files__column">
                    <div class="files__item">
                        <div class="files__item__img">
                            <a download="" href="<?php echo $file['url']; ?>">PDF</a>
                        </div>
                        <div class="files__item__text">
                            <a download="" href="<?php echo $file['url']; ?>"><?php echo $file['filename']; ?></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endif;

$prev_id = $lesson->get_previous_lesson();
$next_id = $lesson->get_next_lesson();
?>
<div class="course-training-page-left-box-description course-training-page-buttons">
    <div class='course-training-page-left-box-description-text-actions'>
        <?php if ( $prev_id ) : ?>
            <div class='btn btn-outline-link'>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path opacity="0.38" d="M15 8.25H5.8725L10.065 4.0575L9 3L3 9L9 15L10.0575 13.9425L5.8725 9.75H15V8.25Z" fill="#1B1B1F"/>
                </svg>
                <a href="<?php echo get_permalink($prev_id); ?>">
                    <?php _e('Prev lesson', 'ndp'); ?>
                </a>
            </div>
        <?php endif; ?>

        <?php if ( ! $next_id ) : ?>
            <?php
            $status = $student->is_complete( $lesson->get( 'id' ), 'lesson' );
            ?>
            <div class='btn btn-outline-link'>
                <?php if (!$status): ?>
                    <form action="" class="llms-complete-lesson-form" method="POST" name="mark_complete">

                        <?php do_action( 'lifterlms_before_mark_complete_lesson' ); ?>

                        <input type="hidden" name="mark-complete" value="<?php echo esc_attr( $lesson->get( 'id' ) ); ?>" />
                        <input type="hidden" name="action" value="mark_complete" />
                        <?php wp_nonce_field( 'mark_complete' ); ?>

                        <?php
                        llms_form_field(
                            array(
                                'columns'     => 12,
                                'classes'     => 'llms-button-primary auto button',
                                'id'          => 'llms_mark_complete2',
                                'value'       =>  __( 'Finish lesson', 'ndp' ),
                                'last_column' => true,
                                'name'        => 'mark_complete',
                                'required'    => false,
                                'type'        => 'submit',
                            )
                        );
                        ?>

                        <?php do_action( 'lifterlms_after_mark_complete_lesson' ); ?>

                    </form>
                <?php else: ?>
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                        <path opacity="0.38" d="M15 8.25H5.8725L10.065 4.0575L9 3L3 9L9 15L10.0575 13.9425L5.8725 9.75H15V8.25Z" fill="#1B1B1F"/>
                    </svg>
                    <a href="<?php echo get_permalink( $lesson->get( 'parent_course' ) ); ?>" title="<?php echo get_the_title( $lesson->get( 'parent_course' ) ); ?>">
                        <?php echo __( 'Back to Course', 'lifterlms' ); ?>
                    </a>
                <?php endif; ?>
            </div>

        <?php elseif ( ! $prev_id || ! $next_id ) : ?>
            <div class='btn btn-outline-link'>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path opacity="0.38" d="M15 8.25H5.8725L10.065 4.0575L9 3L3 9L9 15L10.0575 13.9425L5.8725 9.75H15V8.25Z" fill="#1B1B1F"/>
                </svg>
                <a href="<?php echo get_permalink( $lesson->get( 'parent_course' ) ); ?>" title="<?php echo get_the_title( $lesson->get( 'parent_course' ) ); ?>">
                    <?php echo __( 'Back to Course', 'lifterlms' ); ?>
                </a>
            </div>
        <?php endif; ?>

        <?php if ( $next_id ) : ?>
            <div class='btn btn-outline-link btn-next'>
                <a href="<?php echo get_permalink($next_id); ?>">
                    <?php _e('Next lesson', 'ndp'); ?>
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#2A59BD"/>
                </svg>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="clear"></div>
