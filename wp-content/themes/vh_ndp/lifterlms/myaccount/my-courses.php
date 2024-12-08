<?php
/**
 * Courses account page
 */

$isLoggedIn = is_user_logged_in();
$current_user = wp_get_current_user();
$user_is_student = false;
$current_userID = null;
$courseProgress = 0;
$student = '';
if ($isLoggedIn) {
    $user = get_userdata($current_user->ID);
    $user_roles = $user->roles;
    $user_is_student = in_array( 'student', $user_roles, true );
    $current_userID = $current_user->ID;
    if ($user_is_student) {
        $student = new LLMS_Student($current_userID);
        $courseProgress = $student->get_progress(get_the_ID());
    }
}
$userData = (array)$current_user->data;
?>

<?php
llms_get_template(
    'myaccount/dashboard-sidebar.php',
);
?>

<div class="account__content col-8">
  <section class="my-courses">
    <nav class="breadcrumb">
        <?php yoast_breadcrumb(); ?>
    </nav>
    <div class="my-courses__title">
      <h1><?php _e('My courses', 'ndp'); ?></h1>
    </div>
    <div class="my-courses__block">

        <?php echo $content; ?>

    </div>
  </section>
</div>
