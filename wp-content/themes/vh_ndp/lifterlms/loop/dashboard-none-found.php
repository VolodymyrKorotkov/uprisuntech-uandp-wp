<?php
/**
 * Template: No items found.
 *
 * @package LifterLMS/Templates
 *
 * @since Unknown
 * @version Unknown
 */

defined( 'ABSPATH' ) || exit;

$survey = false;
$noFountText = __('You are not enrolled in any courses.', 'lifterlms');
if (!empty($args) && !empty($args['survey'])) {
    $survey = $args['survey'];
    $noFountText = __('You are not enrolled in any surveys.', 'ndp');
}
?>
<div class="library__course">
    <div class="not-found template">
        <p><span><?php echo $noFountText; ?></span></p>
    </div>
</div>

