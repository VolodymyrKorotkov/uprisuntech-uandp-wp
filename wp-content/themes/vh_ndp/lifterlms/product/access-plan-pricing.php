<?php
/**
 * Single Access Plan Pricing
 *
 * @property  obj  $plan  Instance of the LLMS_Access_Plan
 * @author    LifterLMS
 * @package   LifterLMS/Templates
 * @since     3.23.0
 * @version   3.29.0
 */

defined( 'ABSPATH' ) || exit;

$schedule = $plan->get_schedule_details();
$expires  = $plan->get_expiration_details();

$isFree = $plan->is_free();
if (!get_field('type')): ?>
<div class="course__card-header">
    <?php if (!$isFree): ?>
        <span class="course__card-price"><?php echo $plan->get_price( 'price' ); ?></span>
    <?php endif; ?>

    <?php if ($isFree): ?>
        <span class="course__card-free"><?php _e('Free lesson', 'ndp'); ?></span>
    <?php endif; ?>
</div>
<?php endif; ?>