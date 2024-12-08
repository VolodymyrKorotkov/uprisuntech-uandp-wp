<?php
/**
 * Applications account page
 */
?>

<?php
$user_id = get_current_user_id();
$user = get_userdata($user_id);
$student = llms_get_student();
//$user = get_current_user();
llms_get_template(
    'myaccount/dashboard-sidebar.php',
);


$current_language = apply_filters('wpml_current_language', NULL);
$applications = get_user_applications($user_id);
?>
    <div id="root" style="display:none"></div>
<div class="account__content col-8">
  <section class="applications">
    <nav class="breadcrumb">
        <?php yoast_breadcrumb(); ?>
    </nav>
    <h1 class="applications__title"><?php _e('Applications','ndp'); ?></h1>
    <?php if (count($applications) > 0): ?>
    <div class="applications__block">
        <table>
            <colgroup>
                <col style="width: auto;">
                <col style="width: auto;">
                <col style="width: auto;">
                <col style="width: 96px;">
            </colgroup>
            <tr>
                <td class="applications__table-title applications__table-hidden-mobile"><?php _e('Application','ndp'); ?></td>
                <td class="applications__table-title applications__table-hidden-desktop"><?php _e('App.','ndp'); ?></td>
                <td class="applications__table-title"><?php _e('Status','ndp'); ?> </td>
                <td class="applications__table-title"><?php _e('Amount','ndp'); ?> </td>
                <td class="applications__table-title applications__table-title-last"><?php _e('Action','ndp'); ?></td>
            </tr>
            <?php
            

            foreach ($applications as $application) :
                ?>
                <tr>
                    <td class="applications__table-number">№<?php echo $application->id; ?></td>
                    <td><?php echo mb_ucfirst(__($application->status, 'ndp')); ?></td>
                    <td><?php echo $application->amount ? number_format($application->amount, 2) . ' '. __($application->currency_code, 'ndp') : __('Amount N/A', 'ndp'); ?></td>
                    <td class="applications__table-image" style="text-align: center;">
                         <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/notifications.svg" alt="notifications-icon"> -->

                        <?php
                        $current_language = apply_filters('wpml_current_language', NULL);
                        if($current_language=="en"){
                            $link = "/en/create-application/?id=$application->id";
                        }else{
                            $link = "/create-application/?id=$application->id";
                        }

                            ?>

                        <img onclick="window.location.href='<?php echo $link; ?>'" src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow-right.svg" alt="arrow-right" class="applications__table-hidden-mobile">

                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

    </div>
    <?php else: ?>
        <div class="dashboard__block-wrapper dashboard__block-applications">
            <p><?php _e('No applications created', 'ndp'); ?></p>
            <?php
            $lng_url = '';
            if ($current_language && $current_language != 'uk') {
                $lng_url = '/' . $current_language;
            }
            ?>
            <a href="<?= $lng_url ?>/create-application">
                <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 6.75H6.75V12H5.25V6.75H0V5.25H5.25V0H6.75V5.25H12V6.75Z" fill="#2A59BD"/>
                </svg>
                <?php _e('Create Application', 'ndp') ?></a>
        </div>
    <?php endif; ?>
  </section>
</div>
<?php
wp_enqueue_script('application', get_template_directory_uri() . '/react-aplication/build_modal/application_modal.js', array(), _S_VERSION, true);
wp_enqueue_style('application', get_template_directory_uri() . '/react-aplication/build_modal/application_modal.css');

?>
<script>
    function showModal(id){
        fetch('/wp-json/application/v1/get_entry/'+id)
    .then(response => response.json())
            .then(data => {
                if (data.id) {

                    window.openResultApplicationModal(JSON.parse(data.apply_info));
                } else {
                    console.error("Произошла ошибка при получении записи.");
                }
            })
            .catch((error) => {
                console.error('Ошибка:', error);
            });
    }

</script>

