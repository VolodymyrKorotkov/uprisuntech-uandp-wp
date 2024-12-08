<?php
/**
 * Basic Notification Template
 *
 * @package LifterLMS/Templates
 *
 * @since 3.8.0
 * @version 3.29.0
 */


defined( 'ABSPATH' ) || exit;
?>
<div class="notifications__item <?php echo $classes; ?>" <?php echo $atts; ?> id="llms-notification-<?php echo $id; ?>">
    <?php do_action( 'llms_before_basic_notification', $id ); ?>

    <div class="notifications__item-image notifications__item-image__new" style="text-align: center;">
         <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/notifications.svg" alt="notifications-icon"> -->
    </div>
    <div class="notifications__item-text">
        <h2 class="notifications__item-title"><?php echo $title; ?></h2>
        <div class="notifications__item-subtitle notifications__item-subtitle__new"><?php echo $body; ?></div>
    </div>
    <span class="notifications__item-time"><?php echo $date; ?></span>

    <?php do_action( 'llms_after_basic_notification', $id ); ?>
</div>
