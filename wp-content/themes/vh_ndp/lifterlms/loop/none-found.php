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

global $wp_query;
$meta_query = $wp_query->get('meta_query',[]);
$isSurvey = false;
$title = 'Courses not found';
if (!empty($meta_query)) {
    foreach ($meta_query as $query) {
        if (!empty($query['key']) && !empty($query['value']) && $query['key'] == 'type' && $query['value'] == '1') {
            $title = 'Surveys not found';
            $isSurvey = true; break;
        }
    }
}
?>
<div class="library__course">
    <div class="not-found template">
        <span><?php _e($title, 'ndp'); ?></span>
        <?php if (!$isSurvey): ?>
        <p><?php _e('Please try selecting different filters', 'ndp'); ?></p>
        <button class="js-clear-filter btn btn-primary"><?php _e('Clear filters', 'ndp'); ?></button>
        <?php endif; ?>
    </div>
</div>

