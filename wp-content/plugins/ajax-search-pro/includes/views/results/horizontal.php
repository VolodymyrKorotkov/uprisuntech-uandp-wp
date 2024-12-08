<?php
/* Prevent direct access */
defined('ABSPATH') or die("You can't access this file directly.");

/**
 * This is the default template for one horizontal result
 *
 * !!!IMPORTANT!!!
 * Do not make changes directly to this file! To have permanent changes copy this
 * file to your theme directory under the "asp" folder like so:
 *    wp-content/themes/your-theme-name/asp/horizontal.php
 *
 * It's also a good idea to use the actions to insert content instead of modifications.
 *
 * You can use any WordPress function here.
 * Variables to mention:
 *      Object() $r - holding the result details
 *      Array[]  $s_options - holding the search options
 *
 * DO NOT OUTPUT ANYTHING BEFORE OR AFTER THE <div class='item'>..</div> element
 *
 * You can leave empty lines for better visibility, they are cleared before output.
 *
 * MORE INFO: https://knowledgebase.ajaxsearchpro.com/hooks/templating/result-templating
 *
 * @since: 4.0
 */
?>
<div id="asp-res-<?php echo $r->id; ?>"
    class='item<?php echo apply_filters('asp_result_css_class', $asp_res_css_class, $r->id, $r); ?>'>

    <?php do_action('asp_res_horizontal_begin_item'); ?>

    <?php if (!empty($r->image)): ?>
        <a class='asp_res_image_url' href='<?php echo $r->link; ?>' <?php echo ($s_options['results_click_blank']) ? " target='_blank'" : ""; ?>>
            <?php if ($load_lazy == 1): ?>
                <div class='asp_image<?php echo $s_options['image_display_mode'] == "contain" ? " asp_image_auto" : ""; ?> asp_lazy'
                    data-src="<?php echo esc_attr($r->image); ?>">
                    <div class='void'></div>
                </div>
            <?php else: ?>
                <div class='asp_image<?php echo $s_options['image_display_mode'] == "contain" ? " asp_image_auto" : ""; ?>'
                    data-src="<?php echo esc_attr($r->image); ?>" style="background-image: url('<?php echo $r->image; ?>');">
                    <div class='void'></div>
                </div>
            <?php endif; ?>
        </a>
    <?php endif; ?>

    <?php do_action('asp_res_horizontal_after_image'); ?>

    <div class='asp_content '>


        <?php
        /* Tags */
        $tag_slug = '';

        if ($r->post_type === 'news') {
            $tag_slug = 'news_tag';
        } elseif ($r->post_type === 'knowledge-base') {
            $tag_slug = 'knowledge-base_tag';
        } elseif ($r->post_type === 'cases') {
            $tag_slug = 'cases_tag';
        }

        $news_tags = get_terms(
            array(
                'taxonomy' => $tag_slug,
                'hide_empty' => true,
            )
        );
        /* --- */


        /* Categories */
        $category_slug = '';
        //$pt = get_post_type_object($r->post_type);
        
        if ($r->post_type === 'news') {
            $category_slug = 'news_category';
            $cpt_label = "Новини";

        } elseif ($r->post_type === 'knowledge-base') {
            $category_slug = 'knowledge-base_category';
            $cpt_label = "База знань";


        } elseif ($r->post_type === 'cases') {
            $category_slug = 'cases_category';
            $cpt_label = "Реалізовані проєкти";

        } elseif ($r->post_type === 'cases') {
            $category_slug = 'cases_category';
            $cpt_label = "Реалізовані проєкти";
        } elseif ($r->post_type === 'course') {
            $category_slug = 'course_cat';
            $cpt_label = "Центр навчання";
        } elseif ($r->post_type === 'product') {
            $category_slug = 'product_cat';
            $cpt_label = "Рішення";

            $product = wc_get_product($r->id);
            $productID = $product->get_id();
            $categories = get_the_terms($productID, 'product_cat');
            $categoryName = '';
            if ($categories && !is_wp_error($categories)) {
                $categoryName = $categories[0]->name;
            }

            $brands = get_the_terms($productID, 'sp_smart_brand');
            $brand_url = '';
            if ($brands && !is_wp_error($brands)) {
                $brand_name = $brands[0]->name;
                $term_all_meta = get_term_meta($brands[0]->term_id, 'sp_smart_brand_taxonomy_meta', true);
                $brand_url = isset($term_all_meta['smart_brand_term_logo']['url']) ? $term_all_meta['smart_brand_term_logo']['url'] : '';
            }

            $current_lang = apply_filters('wpml_current_language', 'uk');
            $comparisonArray = [];
            $added = '';
            if (!empty($_SESSION['comparisonArray']) && !empty($_SESSION['comparisonArray'][$current_lang]) && in_array($productID, $_SESSION['comparisonArray'][$current_lang])) {
                $added = 'added';
            }
        } elseif ($r->post_type === 'project') {
            $category_slug = 'project_category';
            $cpt_label = "Проєкти";
        }

        // Получаем список категорий
        $categories = get_terms([
            'taxonomy' => $category_slug,
            'hide_empty' => true,
        ]);
        /* --- */

        // echo "<pre>";
        // print_r($pt);
        // echo "</pre>";
        ?>
        <div class='block-post-item-labels'>
            <?php
            echo '<div class="block-post-item-label taxonomy">' . $cpt_label . '</div>';
            $categories = get_the_terms($r->id, $category_slug);
            if ($categories && !is_wp_error($categories) && isset($categories[0])) {
                $category = $categories[0];
                $link = get_category_link($category->term_id);
                echo '<a href="' . $link . '" class="block-post-item-label active">' . $category->name . '</a>';
            }
            $tags = get_the_terms($r->id, $tag_slug);
            /*
            if ($tags && !is_wp_error($tags)) {
                foreach ($tags as $tag) {
                    echo '<a href="' . get_post_type_archive_link($post_type) . '?' . $tag_slug . '[0]=' . $tag->slug . '" class="block-post-item-label">' . $tag->name . '</a>';
                }
            }
            */
            ?>

            <?php
            $status = get_the_terms($r->id, 'project_status');
            if ($status) {
                $term_id = $status[0]->term_id;
                $status_style = get_field('status_style', 'project_status_' . $term_id);
                //print_r($status_style);
                ?>
                <div class="status"
                    style="color: rgb(<?php echo $status_style['red']; ?>, <?php echo $status_style['green']; ?>, <?php echo $status_style['blue']; ?>, 1); background: rgb(<?php echo $status_style['red']; ?>, <?php echo $status_style['green']; ?>, <?php echo $status_style['blue']; ?>, 0.3)">
                    <?php echo $status[0]->name; ?>
                </div>
                <?php
            }
            ?>


            <?php if ($brand_url): ?>
                <img src="<?php echo $brand_url; ?>" alt="<?php echo $brand_name; ?>">
            <?php endif; ?>
        </div>


        <h3><a class="asp_res_url" href='<?php echo $r->link; ?>' <?php echo ($s_options['results_click_blank']) ? " target='_blank'" : ""; ?>>
                <?php echo $r->title; ?>
                <?php if ($s_options['resultareaclickable'] == 1): ?>
                    <span class='overlap'></span>
                <?php endif; ?>
            </a></h3>

        <div class='etc'>

            <?php if ($s_options['showauthor'] == 1): ?>
                <span class='asp_author'>
                    <?php echo $r->author; ?>
                </span>
            <?php endif; ?>



        </div>

        <?php //if ($show_description == 1):               ?>
        <?php //if (empty($r->image) || $s_options['hhidedesc'] == 0):               ?>


        <?php //if ($s_options['showdate'] == 1): ?>
        <?php if ($r->post_type === 'course') {
            $course = new LLMS_Course($r->id);
            $product = new LLMS_Product($r->id);
            $plans = $product->get_access_plans();
            $course_total_time = prepareCourseTime(calculateTimeOfCourse($course));
            $instructors = $course->get_instructors();
            $instructor = llms_get_instructor($instructors[0]['id']);
            $instructor_id = $instructor->get('id');
            $instructor_name = get_the_author_meta('display_name', $instructor_id);

            //print_r($course);
            ?>
            <div class="asp_res_text">
                <?php echo substr($course->content, 0, strpos($course->content, ' ', 250)); ?>...
            </div>


            <div class="metadate-block course__info">
                <div class="course__author">
                    <span><?php _e('Author', 'ndp'); ?>:</span>
                    <strong><?php echo $instructor_name ?></strong>
                </div>
                <?php if ($course_total_time): ?>
                    <div class="course__totalTime">
                        <span><?php _e('Total time', 'ndp'); ?>:</span>
                        <strong><?php echo $course_total_time; ?></strong>
                    </div>
                <?php endif; ?>

                <div class="read-more"><a href="<?php echo $r->link; ?>">
                        <?php echo __('Read more', 'ndp'); ?>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.99998 3.33398L8.82498 4.50898L13.475 9.16732H3.33331V10.834H13.475L8.82498 15.4923L9.99998 16.6673L16.6666 10.0007L9.99998 3.33398Z"
                                fill="#1B4EB2" />
                        </svg>
                    </a></div>
            </div>

        <?php } elseif ($r->post_type === 'project') { ?>
            <div class="project-cart">
                <div class="project-info">
                    <div class="location">
                        <?php
                        $location = get_field_object('location', $r->id);
                        // echo "<pre>";
                        // print_r($location);
                        // echo "</pre>";
                    
                        if ($location) {
                            ?>

                            <div class="project-location">
                                <span>
                                    <?php echo $location['label']; ?>
                                </span>
                                <p class='sidebar_text'>
                                    <?php echo $location['value']; ?>
                                </p>
                            </div>
                        <?php } ?>

                    </div>
                    <div class="update">
                        <?php
                        $last_updated = get_field_object('last_updated', $r->id);
                        if ($last_updated) {
                            ?>
                            <div class="project-update">
                                <span>
                                    <?php echo $last_updated['label']; ?>
                                </span>

                                <?php echo $last_updated['value']; ?>

                            </div>
                        <?php } ?>


                    </div>

                </div>

                <div class="project-details">
                    <div class="column">

                        <?php
                        $required = get_field_object('required', $r->id);
                        // echo "<pre>";
                        // print_r($required);
                        // echo "</pre>";
                    
                        if ($required) {
                            ?>

                            <div class="project-required financing_item">
                                <span>
                                    <?php echo $required['label']; ?>
                                </span>
                                <p class='sidebar_text'>
                                    <?php echo number_format($required['value'], 0, '', ' '); ?>
                                    <?php echo $required['append']; ?>
                                </p>

                            </div>
                        <?php } ?>

                        <?php
                        $payback_period = get_field_object('payback_period', $r->id);
                        if ($payback_period) {
                            ?>

                            <div class="project-payback financing_item">
                                <span>
                                    <?php echo $payback_period['label']; ?>
                                </span>
                                <p class='sidebar_text'>
                                    <?php echo $payback_period['value']; ?>
                                    <?php echo $payback_period['append']; ?>
                                </p>
                            </div>
                        <?php } ?>

                        <?php
                        $ppp = get_field_object('ppp', $r->id);
                        // echo "<pre>";
                        // print_r($ppp);
                        // echo "</pre>";
                        if ($ppp) {
                            ?>

                            <div class="project-partnership financing_item">
                                <span>
                                    <?php echo $ppp['label']; ?>:
                                </span>

                                <?php if ($ppp['value']) { ?>

                                    <div class="info-icon">
                                        <?php echo __('Yes', 'ndp-projects-plugin'); ?><br>

                                    </div>

                                <?php } else { ?>
                                    <?php echo __('No', 'ndp-projects'); ?>
                                <?php } ?>

                            </div>
                        <?php } ?>
                        <?php
                        $funds_participation = get_field_object('funds_participation', $r->id);
                        // echo "<pre>";
                        // print_r($funds_participation);
                        // echo "</pre>";
                        if ($funds_participation) {
                            ?>

                            <div class="project-funds financing_item">
                                <span>
                                    <?php echo $funds_participation['label']; ?>:
                                </span>

                                <?php if ($funds_participation['value']) { ?>

                                    <div class='info-icon'>

                                        <?php echo __('Yes', 'ndp-projects-plugin'); ?>

                                    </div>
                                <?php } else { ?>
                                    <?php echo __('No', 'ndp-projects-plugin'); ?>
                                <?php } ?>



                            </div>
                        <?php } ?>

                    </div>
                    <div class='column'>
                        <?php
                        $funded_by_applicant = get_field_object('funded_by_applicant', $r->id);
                        if ($funded_by_applicant) {
                            ?>

                            <div class="project-funded financing_item">
                                <span class='sidebar_title'>
                                    <?php echo $funded_by_applicant['label']; ?>
                                </span>
                                <p class='sidebar_text'>
                                    <?php echo $funded_by_applicant['value']; ?>
                                    <?php echo $funded_by_applicant['append']; ?>
                                </p>
                            </div>
                        <?php } ?>

                        <?php
                        $irr = get_field_object('irr', $r->id);
                        if ($irr) {
                            ?>

                            <div class="project-funded financing_item">
                                <span class='sidebar_title'>
                                    <?php echo $irr['label']; ?>
                                </span>
                                <p class='sidebar_text'>
                                    <?php echo $irr['value']; ?>
                                    <?php echo $irr['append']; ?>
                                </p>
                            </div>
                        <?php } ?>



                        <?php
                        $co2_reducation_rate = get_field_object('co2_reducation_rate', $r->id);
                        if ($co2_reducation_rate) {
                            ?>

                            <div class="project-reducation financing_item">
                                <span>
                                    <?php echo $co2_reducation_rate['label']; ?>:
                                </span>
                                <p class='sidebar_text'>
                                    <?php echo $co2_reducation_rate['value']; ?>
                                    <?php echo $co2_reducation_rate['append']; ?>
                                </p>
                            </div>
                        <?php } ?>

                        <?php
                        $un_goals = get_field_object('un_goals', $r->id);
                        if ($un_goals) {
                            ?>

                            <div class="project-goals financing_item">
                                <span>
                                    <?php echo $un_goals['label']; ?>:
                                </span>
                                <div class='icon-info'>

                                    <?php echo $un_goals['value']; ?>
                                    <strong> /
                                        <?php echo $un_goals['append']; ?>
                                    </strong>

                                </div>
                            </div>
                        <?php } ?>




                    </div>

                </div>

            </div>


        <?php } elseif ($r->post_type === 'product') {




            //echo "<pre>";
            //print_r($product);
            //echo "</pre>";
            ?>


            <div class="product-item__content">

                <div class="product-item__text">
                    <?php

                    // Удаление тегов из описания и его обрезка
                    $description = $product->get_description();
                    $description = strip_tags($description); // Удаление HTML-тегов
                    if (mb_strlen($description) > 120) {
                        $description = mb_substr($description, 0, 120) . '...';
                    }
                    ?>


                    <p><?php echo $description; ?></p>
                </div>
                <div class="metadate-block product-item__bottom">
                    <div class="read-more"><a href="<?php echo $r->link; ?>">
                            <?php echo __('Read more', 'ndp'); ?>
                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.99998 3.33398L8.82498 4.50898L13.475 9.16732H3.33331V10.834H13.475L8.82498 15.4923L9.99998 16.6673L16.6666 10.0007L9.99998 3.33398Z"
                                    fill="#1B4EB2" />
                            </svg>
                        </a></div>
                    <div class="d-flex">
                        <a href="" data-item-id="<?php echo $productID; ?>"
                            class="add-to btn btn_compare add_to_comparison me-2 <?php echo $added; ?> btn product__buttons__balance add-to  add_to_comparison"></a>
                        <a href="/?add-to-cart=<?php echo $productID; ?>" data-quantity="1"
                            data-product_id="<?php echo $productID; ?>"
                            class="btn btn_bg_primary add_to_cart_button ajax_add_to_cart"
                            target="_blank"><?php echo esc_html($product->single_add_to_cart_text()); ?></a>
                    </div>
                </div>
            </div>




        <?php } else { ?>
            <div class="asp_res_text">
                <?php echo $r->content; ?>
            </div>
            <div class="metadate-block">
                <span class='asp_date'>
                    <?php
                    $date = new DateTimeImmutable($r->date);
                    echo $date->format('d.m.y H:i');
                    //echo $r->date; 
                    ?>
                </span>
                <?php //endif; ?>

                <div class="read-more"><a href="<?php echo $r->link; ?>">
                        <?php echo __('Read more', 'ndp'); ?>
                        <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.99998 3.33398L8.82498 4.50898L13.475 9.16732H3.33331V10.834H13.475L8.82498 15.4923L9.99998 16.6673L16.6666 10.0007L9.99998 3.33398Z"
                                fill="#1B4EB2" />
                        </svg>
                    </a></div>
            </div>
        <?php } ?>

        <?php //endif;               ?>
        <?php //endif;               ?>

    </div>

    <?php do_action('asp_res_horizontal_after_content'); ?>

    <?php do_action('asp_res_horizontal_end_item'); ?>

</div>