<?php
/**
 * Template for the free enrollment form
 *
 * Displays to logged in users on pricing tables for free access plans if free checkout is not disabled via filter
 *
 * @package LifterLMS/Templates
 *
 * @since 3.4.0
 * @since 3.30.0 Added redirect field.
 * @since 5.0.0 Use `LLMS_Forms::get_free_enroll_form_html()` in favor of deprecated `LLMS_Person_Handler::get_available_fields()`.
 * @version 5.0.0
 *
 * @property LLMS_Access_Plan $plan Instance of the plan object.
 */

defined( 'ABSPATH' ) || exit;

$uid = get_current_user_id();
if (!$uid) {
  echo '<button class="button btn btn_bg_primary course__card-button modal-btn" data-modal="login" type="submit">'.__('Enroll Now', 'ndp').'</button>';
  return;
}

if (empty( $plan ) || ! $plan->has_free_checkout() ) {
    return;
}

$isSurvey = get_field('type');
$userAllowed = true;
if ($isSurvey) {
    $allowed_users_roles = get_post_meta( get_the_ID(), 'survey_user_roles', 1 );
    if (is_user_logged_in()) {
        $student = llms_get_student();
        $user = $student->get('user');
        $user_id = $user->ID;
        $user_roles = $user->roles;
        $user_role = $user_roles[0];
        $municipality = get_user_meta( $user_id, 'user_profile_type', true );
        if (!empty($municipality)) {
            $user_role = 'municipality';
        }
        $allowedUserRolesArray = explode(',', $allowed_users_roles);
        if ($user_role && !in_array($user_role, $allowedUserRolesArray)) {
            $userAllowed = false;
        }
    }
    $today = date('d.m.Y');
    $startDate = get_field('survey_start_date');
    $finishDate = get_field('survey_finish_date');
    if ($today > $finishDate) {
        $userAllowed = false;
    }
}
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Обработка отправки формы

    // Получаем текущий URL
    if (isset($_SERVER['HTTPS']) &&
        ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
        isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
        $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
        $protocol = 'https';
    }
    else {
        $protocol = 'http';
    }
    $current_url = "$protocol://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

    // Убираем параметр order-complete из URL
    $new_url = preg_replace('/[?&]order-complete=[^&]+(&|$)/', '', $current_url);

    // Проверяем, изменился ли URL
    if ($new_url !== $current_url) {
        header("Location: $new_url");
        exit();
    }
}
?>
<?php if ($userAllowed): ?>
<form action="" class="llms-free-enroll-form" method="POST" id="enrollForm">

    <?php echo LLMS_Forms::instance()->get_free_enroll_form_html( $plan ); ?>

    <?php wp_nonce_field( 'create_pending_order', '_llms_checkout_nonce' ); ?>

    <input name="action" type="hidden" value="create_pending_order">
    <input name="form" type="hidden" value="free_enroll">
    <input name="llms_agree_to_terms" type="hidden" value="yes">
    <input name="redirect" type="hidden" value="">


    <button class="llms-button-action button btn btn_bg_primary course__card-button" type="submit"><?php echo $plan->get_enroll_text(); ?></button>

</form>

<script>
document.getElementById('enrollForm').addEventListener('submit', function(event) {
    //не получается записаться на опрос
    // event.preventDefault(); // Остановить отправку формы
    //
    // // Получаем текущий URL
    // let currentUrl = window.location.href;
    //
    // // Убираем параметр order-complete из URL
    // let newUrl = currentUrl.replace(/[?&]order-complete=[^&]+(&|$)/, '');
    //
    // // Записываем новый URL в поле "redirect"
    // document.querySelector('input[name="redirect"]').value = newUrl;
    //
    // // Создаем XMLHttpRequest для отправки формы
    // let xhr = new XMLHttpRequest();
    // xhr.open('POST', ''); // указываем URL обработчика формы, если необходимо
    // xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    // xhr.send(new FormData(event.target));

    // После отправки формы, выполняем редирект
    // window.location.href = newUrl;
});
</script>
<?php endif; ?>