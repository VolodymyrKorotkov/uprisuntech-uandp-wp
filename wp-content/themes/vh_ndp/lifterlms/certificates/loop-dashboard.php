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
$current_lang = apply_filters( 'wpml_current_language', 'uk' );

$expireDate = getCertificateExpiredDate($certificate);
$expired = checkCertificateIsExpired($certificate);
$valid = !$expired? __('valid', 'ndp') : __('invalid', 'ndp');
$expiredClass = $expired? 'certificates__item-tag__invalid' : '';

if ($current_lang == 'uk') {
    $company = get_field('lms_certificate_company', $certificate->get('parent')) ?? '';
} elseif ($current_lang == 'en') {
    $company = get_field('lms_certificate_company_en', $certificate->get('parent')) ?? '';
}
$source = get_field('lms_certificate_source', $certificate->get('parent')) ?? '';
$description = get_field('lms_certificate_description', $certificate->get('parent')) ?? '';
$footer_text = get_field('lms_certificate_footer_text', $certificate->get('parent')) ?? '';
$expireDays = getCertificateExpiredDays($certificate);
$title = llms_get_certificate_title($certificate->get('id'))? llms_get_certificate_title($certificate->get('id')) : get_the_title($certificate->get('parent'));
?>
<div class="dashboard__certificates-item llms-certificate-loop-item certificate-item">
    <a data-id="<?php echo $certificate->get( 'id' ); ?>" href="<?php echo esc_url( get_permalink( $certificate->get( 'id' ) ) ); ?>" id="<?php printf( 'llms-certificate-%d', $certificate->get( 'id' ) ); ?>">
        <h2 class="dashboard__certificates-item__title"><?php echo $title; ?></h2>
    </a>
    <div class="dashboard__certificates-item__status">
        <span class="dashboard__certificates-item__tag <?php echo $expiredClass; ?>"><?php echo $valid; ?></span>
        <span class="dashboard__certificates-item__date"><?php _e('due to', 'ndp'); ?> <?php echo $expireDate; ?>,</span>
        <span class="dashboard__certificates-item__date"><?php echo sprintf( _n( '%s day', '%s days', $expireDays, 'ndp' ), $expireDays ); ?></span>
    </div>
    <div class="dashboard__certificates-item__granted">
        <!--                    <span>Granted 15.09.23:</span>-->
        <strong><?php echo $company; ?></strong>
    </div>
    <?php if ($source): ?>
        <div class="dashboard__certificates-item__sourse">
            <span><?php _e('Sourse', 'ndp'); ?>:</span>
            <strong><?php echo $source; ?></strong>
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
