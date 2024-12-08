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
$expireDate = getCertificateExpiredDate($certificate);
$expired = checkCertificateIsExpired($certificate);
$valid = !$expired? __('valid', 'ndp') : __('Invalid');
$expiredClass = $expired? 'certificates__item-tag__invalid' : '';

$company = get_field('lms_certificate_company', $certificate->get('parent')) ?? '';
$source = get_field('lms_certificate_source', $certificate->get('parent')) ?? '';
$description = get_field('lms_certificate_description', $certificate->get('parent')) ?? '';
$footer_text = get_field('lms_certificate_footer_text', $certificate->get('parent')) ?? '';
$expireDays = getCertificateExpiredDays($certificate);
$title = llms_get_certificate_title($certificate->get('id'))? llms_get_certificate_title($certificate->get('id')) : get_the_title($certificate->get('parent'));
?>
<div class="certificates__item">
    <div class="certificates__header">
        <a data-id="<?php echo $certificate->get( 'id' ); ?>" href="<?php echo esc_url( get_permalink( $certificate->get( 'id' ) ) ); ?>" id="<?php printf( 'llms-certificate-%d', $certificate->get( 'id' ) ); ?>">
            <h2><?php echo $title; ?></h2>
        </a>
    </div>
    <div class="certificates__item-status">
        <span class="certificates__item-tag <?php echo $expiredClass; ?>"><?php echo $valid; ?></span>
        <span class="certificates__item-date"><?php _e('due to', 'ndp'); ?> <?php echo $expireDate; ?>,</span>
        <span class="certificates__item-date"><?php echo sprintf( _n( '%s day', '%s days', $expireDays, 'ndp' ), $expireDays ); ?></span>
        <div class="certificates__item-granted">
            <span><?php _e('Granted', 'ndp'); ?>: <?php echo getCertificateCreateDate($certificate); ?></span>
            <strong><?php echo $company; ?></strong>
        </div>
    </div>
    <?php if ($description): ?>
        <div class="certificates__item-description">
            <p><?php echo $description; ?></p>
        </div>
    <?php endif; ?>
    <?php if ($source): ?>
        <div class="certificates__item-sourse">
            <span><?php _e('Sourse', 'ndp'); ?>:</span>
            <strong><?php echo $source; ?></strong>
        </div>
    <?php endif; ?>
    <?php if ($footer_text): ?>
        <div class="certificates__item-footer">
            <p><?php echo $footer_text; ?></p>
        </div>
    <?php endif; ?>
</div>
