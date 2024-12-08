<?php
/**
 * Survey account page
 */
?>

<?php
llms_get_template(
    'myaccount/dashboard-sidebar.php',
);

$student = llms_get_student();
$user = $student->get('user');
$user_id = $user->ID;
$user_roles = $user->roles;
$user_role = $user_roles[0];

if (current_user_can('read_requests') && $user_role && $user_role == 'operator'):
require get_template_directory() . '/lifterlms/myaccount/operator-surveys.php';
else:

if ( ! $student ) {
    return;
}

$current_lang = apply_filters( 'wpml_current_language', 'uk' );
?>

<div class="account__content col-8">
    <nav class="breadcrumb">
        <?php yoast_breadcrumb(); ?>
    </nav>
    <div class="d-flex justify-content-between align-items-center mb-1 mb-md-3">
        <h1 class="h1"><?php _e('My surveys', 'ndp'); ?></h1>
        <?php
        $libraryLink = '/survey';
        if ($current_lang != 'uk') {
            $libraryLink = '/'.$current_lang . $libraryLink;
        }
        ?>
        <a href="<?php echo $libraryLink; ?>" target="_blank" class="btn btn-outline-link btn-outline-library btn-flex">
            <?php _e('Survey library', 'ndp'); ?>
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#2A59BD" />
            </svg>
        </a>
    </div>
    <?php
    ob_start();
    lifterlms_template_my_courses_loop( $student, false, $survey=true );
    echo ob_get_clean();
    ?>
</div>


<!-- MODAL -->
<div class="c-modal c-modal-medium iziModal" id="modalFinish">
    <button type="button" data-iziModal-close class="c-modal__close">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                    d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
                    fill="#919094" />
        </svg>
    </button>
    <div class="c-modal__wrap">
        <div class="c-modal__header">
            <h2 class="h2"><?php _e('Finish survey right now', 'ndp'); ?></h2>
            <p><?php _e('Are you sure you want to finish the survey?', 'ndp'); ?></p>
        </div>
        <div class="c-modal__nav">
            <button type="button" class="btn btn-outline-primary" data-iziModal-close><?php _e('Cancel', 'ndp'); ?></button>
            <button class="btn btn_bg_primary"><?php _e('Finish', 'ndp'); ?></button>
        </div>
    </div>
</div>

<div class="c-modal c-modal-medium iziModal" id="modalSend">
    <button type="button" data-iziModal-close class="c-modal__close">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
                    d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
                    fill="#919094" />
        </svg>
    </button>
    <div class="c-modal__wrap">
        <div class="c-modal__header">
            <h2 class="h2"><?php _e('Send notification with a reminder about the survey', 'ndp'); ?></h2>
            <p>The notification will be sent to the user group Municipality, Government</p>
        </div>
        <form action="/" class="form mb-3">
            <div class="mdc-form-field">
                <div class="mdc-checkbox">
                    <input type="checkbox" class="mdc-checkbox__native-control" id="checkbox-1" />
                    <div class="mdc-checkbox__background">
                        <svg class="mdc-checkbox__checkmark" viewBox="0 0 24 24">
                            <path class="mdc-checkbox__checkmark-path" fill="none"
                                  d="M1.73,12.91 8.1,19.28 22.79,4.59" />
                        </svg>
                        <div class="mdc-checkbox__mixedmark"></div>
                    </div>
                    <div class="mdc-checkbox__ripple"></div>
                    <div class="mdc-checkbox__focus-ring"></div>
                </div>
                <label for="checkbox-1"><?php _e('Send also to the Emails', 'ndp'); ?></label>
            </div>
        </form>
        <div class="c-modal__nav">
            <button type="button" class="btn btn-outline-primary" data-iziModal-close><?php _e('Cancel', 'ndp'); ?></button>
            <button class="btn btn_bg_primary"><?php _e('Send', 'ndp'); ?></button>
        </div>
    </div>
</div>
<?php endif; ?>