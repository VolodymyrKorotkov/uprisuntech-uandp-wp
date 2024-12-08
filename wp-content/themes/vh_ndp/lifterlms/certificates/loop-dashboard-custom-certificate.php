<?php
/**
 * Certificates Loop
 *
 * @package LifterLMS/Templates/Certificates
 *
 * @since 3.14.0
 * @since 6.0.0 Add pagination.
 * @version 3.14.0
 *
 * @param LLMS_User_Certificate[] $certificates Array of certificates to display.
 * @param int                     $cols         Number of columns.
 * @param false|array             $pagination   Pagination arguments to pass to {@see llms_paginate_links()} or `false`
 *                                              when pagination is disabled.
 */

defined( 'ABSPATH' ) || exit;
?>

<?php
$certData = get_post_meta($certificate->get('id'), 'custom_certificate_data', true);
$cert_name = '';
$organizationName = '';
$dateObtaining = '';
$validityDate = '';
$courseTitle = '';
$courseAuthor = '';
$link_to_course = '';
if (!empty($certData) && is_array($certData)) {
    $cert_name = !empty($certData['cert_name'])? $certData['cert_name'] : '';
    $organizationName = !empty($certData['organizationName'])? $certData['organizationName'] : '';
    $dateObtaining = !empty($certData['dateObtaining'])? $certData['dateObtaining'] : '';
    $validityDate = !empty($certData['validityDate'])? $certData['validityDate'] : '';
    $courseTitle = !empty($certData['courseTitle'])? $certData['courseTitle'] : '';
    $courseAuthor = !empty($certData['courseAuthor'])? $certData['courseAuthor'] : '';
    $link_to_course = !empty($certData['link_to_course'])? $certData['link_to_course'] : '';
}

$approved = $certificate->get('comment_status');

if ($validityDate) {
    $startdate = $validityDate;
    $expire = strtotime($startdate);
    $today = strtotime("today midnight");

    if($today >= $expire){
        $expired = true;
    } else {
        $expired = false;
    }

    $expireDays = ($expire - $today) / 86400;

    $valid = !$expired? __('valid', 'ndp') : __('invalid', 'ndp');
    if ($approved && $approved == 'no' ) {
        $valid = __('invalid', 'ndp');
    }
    $expiredClass = $expired? 'certificates__item-tag__invalid' : '';
    if ($expireDays >= 0 && $expireDays < 21) {
        $expiredClass = 'certificates__item-tag__yellow';
    }
}
if ($approved && $approved == 'no' ) {
    $valid = __('invalid', 'ndp');
    $expiredClass = 'certificates__item-tag__invalid';
}

?>
<div class="dashboard__certificates-item llms-certificate-loop-item certificate-item">
    <h2 class="dashboard__certificates-item__title"><?php echo $cert_name; ?></h2>

    <div class="dashboard__certificates-item__status">
        <span class="dashboard__certificates-item__tag <?php echo $expiredClass; ?>"><?php echo $valid; ?></span>
        <?php if ($validityDate): ?>
        <span class="dashboard__certificates-item__date"><?php _e('due to', 'ndp'); ?> <?php echo $validityDate; ?>,</span>
        <span class="dashboard__certificates-item__date"><?php echo sprintf( _n( '%s day', '%s days', $expireDays, 'ndp' ), $expireDays ); ?></span>
        <?php endif; ?>
    </div>
    <div class="dashboard__certificates-item__granted">
        <?php if ($dateObtaining): ?>
        <span><?php _e('Granted', 'ndp'); ?> <?php echo $dateObtaining; ?></span>
        <?php endif; ?>
    </div>
    <div class="dashboard__certificates-item__sourse">
        <span><?php _e('Organization', 'ndp'); ?>:</span>
        <strong><?php echo $organizationName; ?></strong>
    </div>
    <div class="dashboard__certificates-item__sourse">
        <span><?php _e('Course link', 'ndp'); ?>:</span>
        <a href="<?php echo $link_to_course; ?>" target="_blank"><strong><?php _e('link', 'ndp'); ?></strong></a>
    </div>
    <?php if ($courseTitle): ?>
    <div class="dashboard__certificates-item__sourse">
        <span><?php _e('Sourse', 'ndp'); ?>:</span>
        <p><strong><?php echo $courseTitle; ?></strong></p>
    </div>
    <?php endif; ?>
    <?php if ($courseAuthor): ?>
    <div class="dashboard__certificates-item__sourse">
        <span><?php _e('Course author', 'ndp'); ?>:</span>
        <strong><?php echo $courseAuthor; ?></strong>
    </div>
    <?php endif; ?>
    <?php
    /**
     * Action run to display the preview for a single certificate.
     *
     * @since 3.14.0
     *
     * @param LLMS_User_Certificate $certificate Certificate object being displayed.
     */
    //                do_action( 'llms_certificate_preview', $certificate );
    ?>
</div>
