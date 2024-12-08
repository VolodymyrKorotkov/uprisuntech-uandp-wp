<?php
/*
Template Name: Solitions
*/

get_header();
$solutions_title = get_field('solutions_title');
?>
<div class="breadcrumb">
    <div class="wrap">
        <div class="breadcrumb-block">
            <div class='fn_breadcrumbs'>
                <?php yoast_breadcrumb(); ?>
            </div>
        </div>
    </div>
</div>
<?php
// Получаем значения полей ACF

$blocks = get_field('solutions_blocks');
?>

    <section class="solutions">
        <div class="container">
            <h1 class="solutions__title"><?php echo esc_html($solutions_title); ?></h1>
            <div class="solutions-block">
                <?php if($blocks): ?>
                    <?php foreach($blocks as $block): ?>
                        <div class="solutions-block__item">
                            <a href="<?php echo esc_url($block['block_link']); ?>">
                                <h2 class="solutions-block__title"><?php echo esc_html($block['block_title']); ?></h2>
                                <img src="<?php echo esc_url($block['block_image']); ?>" alt="<?php echo esc_attr($block['block_title']); ?>" class="solutions-block__image">
                            </a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
<style>
    .main {
        background: white;
        /* z-index: 1; */
    }
</style>
    <?php include(get_template_directory() . '/templates/ticker_text.php'); ?>
<?php require "template-parts/content-cart.php"?>
<?php

get_footer();
