<?php
/**
 * Template part for displaying custom posts (news,casts)
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package NDP
 */


if (empty($args))
    return;

$post_type = $args['post_type'] ?? 'project';
$counterPost = $args['counterPost'] ?? '';
$category_slug = $args['category_slug'] ?? '';
$tag_slug = $args['tag_slug'] ?? 'project_tag';
$custom_sticky = $args['custom_sticky'] ?? '';
$hide_col = $args['hide_col'] ?? false;
$isFull = $post_type === 'news' && $counterPost < 2;
?>


<?php if (!$hide_col) { ?>
    <div class="col-12 <?= $isFull ? '' : 'col-sm-12 col-lg-12' ?> " style='margin-bottom: 24px;'>
    <?php } ?>
    <div class='block-post-item full'>
        <?php if ((isset($custom_sticky) && !empty($custom_sticky) && $custom_sticky !== 'off')) { ?>
            <div class='block-post-item-icon'>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path
                        d="M8.3767 15.6162L2.71985 21.273M11.6944 6.64169L10.1335 8.20258C10.0062 8.3299 9.94252 8.39357 9.86999 8.44415C9.80561 8.48905 9.73616 8.52622 9.66309 8.55488C9.58077 8.58717 9.49249 8.60482 9.31592 8.64014L5.65145 9.37303C4.69915 9.56349 4.223 9.65872 4.00024 9.90977C3.80617 10.1285 3.71755 10.4212 3.75771 10.7108C3.8038 11.0433 4.14715 11.3866 4.83387 12.0733L11.9196 19.1591C12.6063 19.8458 12.9497 20.1891 13.2821 20.2352C13.5718 20.2754 13.8645 20.1868 14.0832 19.9927C14.3342 19.7699 14.4294 19.2938 14.6199 18.3415L15.3528 14.677C15.3881 14.5005 15.4058 14.4122 15.4381 14.3298C15.4667 14.2568 15.5039 14.1873 15.5488 14.123C15.5994 14.0504 15.663 13.9868 15.7904 13.8594L17.3512 12.2985C17.4326 12.2171 17.4734 12.1764 17.5181 12.1409C17.5578 12.1093 17.5999 12.0808 17.644 12.0557C17.6936 12.0273 17.7465 12.0046 17.8523 11.9593L20.3467 10.8903C21.0744 10.5784 21.4383 10.4225 21.6035 10.1705C21.7481 9.95013 21.7998 9.68163 21.7474 9.42335C21.6875 9.12801 21.4076 8.8481 20.8478 8.28827L15.7047 3.14514C15.1448 2.58531 14.8649 2.3054 14.5696 2.24552C14.3113 2.19317 14.0428 2.24488 13.8225 2.38941C13.5705 2.55469 13.4145 2.91854 13.1027 3.64624L12.0337 6.14059C11.9883 6.24641 11.9656 6.29932 11.9373 6.34893C11.9121 6.393 11.8836 6.4351 11.852 6.47484C11.8165 6.51958 11.7758 6.56029 11.6944 6.64169Z"
                        stroke="white" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
            </div>
        <?php } ?>
        <a href="<?php the_permalink(); ?>" class='block-post-item-img'>
            <div class='block-post-item-img-bg'></div>
            <?php
            $thumbnail_url = get_the_post_thumbnail_url();
            if ($thumbnail_url) {
                ?><img src='<?= esc_url($thumbnail_url); ?>' />
                <?php
            } else {
                ?><img src='<?php bloginfo('template_url'); ?>/assets/img/home/no-image.jpg' />
                <?php
            }
            ?>
        </a>
        <div class='block-post-item-content'>

            <div class="project-info-head">

                <?php
                $location = get_field_object('location');
                // echo "<pre>";
                // print_r($location);
                // echo "</pre>";
                
                if ($location) {
                    ?>

                    <div class="project-location">
                        <label>
                            <?php echo $location['label']; ?>:
                        </label>
                        <?php echo $location['value']; ?>
                    </div>
                <?php } ?>
                <?php
                $last_updated = get_field_object('last_updated');
                if ($last_updated) {
                    ?>

                    <div class="project-update">
                        <label>
                            <?php echo $last_updated['label']; ?>:&nbsp;
                        </label>
                        <?php echo $last_updated['value']; ?>
                    </div>
                <?php } ?>


                <?php
                $status = get_the_terms($post->ID, 'project_status');
                if ($status) {


                    $term_id = $status[0]->term_id;
                    $status_style = get_field('status_style', 'project_status_' . $term_id);

                    //print_r($status_style);
                    ?>



                    <div class="project-status"
                        style="color: rgb(<?php echo $status_style['red']; ?>, <?php echo $status_style['green']; ?>, <?php echo $status_style['blue']; ?>, 1); background: rgb(<?php echo $status_style['red']; ?>, <?php echo $status_style['green']; ?>, <?php echo $status_style['blue']; ?>, 0.3)">
                        <?php echo $status[0]->name; ?>

                    </div>


                    <?php
                }
                ?>

            </div>

            <h3>
                <a href='<?php the_permalink(); ?>'>
                    <?php the_title(); ?>
                </a>
            </h3>

            <div class="project-info-meta">
                <div class='block-post-item-labels'>
                    <?php
                    $categories = get_the_terms(get_the_ID(), $category_slug);
                    if ($categories && !is_wp_error($categories) && isset($categories[0])) {
                        $category = $categories[0];
                        $link = get_category_link($category->term_id);
                        echo '<a href="' . $link . '" class="block-post-item-label active">' . $category->name . '</a>';
                    }
                    $tags = get_the_terms(get_the_ID(), $tag_slug);
                    if ($tags && !is_wp_error($tags)) {
                        foreach ($tags as $tag) {
                            echo '<a href="' . get_post_type_archive_link($post_type) . '?' . $tag_slug . '[0]=' . $tag->slug . '" class="block-post-item-label">' . $tag->name . '</a>';
                        }
                    }
                    ?>
                </div>

                <?php
                $project_rating = get_field_object('rating');
                if ($project_rating) {
                    ?>

                    <div class="project-rating">
                        <label>
                            <?php echo $project_rating['label']; ?>:
                        </label>
                        <?php echo $project_rating['value']; ?>
                    </div>
                <?php } ?>


            </div>



            <div class="project-info">
                <div class="general-params">

                    <?php
                    $required = get_field_object('required');
                    // echo "<pre>";
                    // print_r($required);
                    // echo "</pre>";
                    
                    if ($required) {
                        ?>

                        <div class="project-required item">
                            <label>
                                <?php echo $required['label']; ?>
                            </label>
                            <?php echo number_format($required['value'], 0, '', ' '); ?>
                            <span>
                                <?php echo $required['append']; ?>
                            </span>

                        </div>
                    <?php } ?>



                    <?php
                    $funded_by_applicant = get_field_object('funded_by_applicant');
                    if ($funded_by_applicant) {
                        ?>

                        <div class="project-funded item">
                            <label>
                                <?php echo $funded_by_applicant['label']; ?>
                            </label>
                            <?php echo $funded_by_applicant['value']; ?>
                            <span>
                                <?php echo $funded_by_applicant['append']; ?>
                            </span>
                        </div>
                    <?php } ?>





                    <?php
                    $payback_period = get_field_object('payback_period');
                    if ($payback_period) {
                        ?>

                        <div class="project-payback item">
                            <label>
                                <?php echo $payback_period['label']; ?>
                            </label>
                            <?php echo $payback_period['value']; ?>
                            <span>
                                <?php echo $payback_period['append']; ?>
                            </span>
                        </div>
                    <?php } ?>



                    <?php
                    $irr = get_field_object('irr');
                    // echo "<pre>";
                    // print_r($ppp);
                    // echo "</pre>";
                    if ($irr) {
                        ?>

                        <div class="project-irr item">
                            <label>
                                <?php echo $irr['label']; ?>
                            </label>
                            <?php echo $irr['value']; ?>
                            <span>
                                <?php echo $irr['append']; ?>
                            </span>
                        </div>
                    <?php } ?>

                </div>
                <div class="advanced-params column">




                    <?php
                    $ppp = get_field_object('ppp');
                    // echo "<pre>";
                    // print_r($ppp);
                    // echo "</pre>";
                    if ($ppp) {
                        ?>

                        <div class="project-partnership financing_item item">
                            <label>
                                <?php echo $ppp['label']; ?>:
                            </label>

                            <?php if ($ppp['value']) { ?>

                                <div class='financing_tooltip'>
                                    <p class='sidebar_text'>
                                        <?php echo __('Yes', 'ndp-projects-plugin'); ?><br>
                                    </p>
                                    <div class='sidebar_tooltip'>
                                        <div class='tooltip_label'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                                fill="none">
                                                <path
                                                    d="M9.1665 15.0013H10.8332V13.3346H9.1665V15.0013ZM9.99984 1.66797C5.39984 1.66797 1.6665 5.4013 1.6665 10.0013C1.6665 14.6013 5.39984 18.3346 9.99984 18.3346C14.5998 18.3346 18.3332 14.6013 18.3332 10.0013C18.3332 5.4013 14.5998 1.66797 9.99984 1.66797ZM9.99984 16.668C6.32484 16.668 3.33317 13.6763 3.33317 10.0013C3.33317 6.3263 6.32484 3.33464 9.99984 3.33464C13.6748 3.33464 16.6665 6.3263 16.6665 10.0013C16.6665 13.6763 13.6748 16.668 9.99984 16.668ZM9.99984 5.0013C8.15817 5.0013 6.6665 6.49297 6.6665 8.33464H8.33317C8.33317 7.41797 9.08317 6.66797 9.99984 6.66797C10.9165 6.66797 11.6665 7.41797 11.6665 8.33464C11.6665 10.0013 9.1665 9.79297 9.1665 12.5013H10.8332C10.8332 10.6263 13.3332 10.418 13.3332 8.33464C13.3332 6.49297 11.8415 5.0013 9.99984 5.0013Z" />
                                            </svg>
                                        </div>
                                        <div class='tooltip_more_block'>
                                            <div class='tooltip_more_container'>
                                                <p class='tooltip_more_content'>
                                                    <span>
                                                        <?php echo $ppp['instructions']; ?>
                                                    </span>


                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } else { ?>
                                <?php echo __('No', 'ndp-projects'); ?>
                            <?php } ?>

                        </div>
                    <?php } ?>


                    <?php
                    $co2_reducation_rate = get_field_object('co2_reducation_rate');
                    if ($co2_reducation_rate) {
                        ?>

                        <div class="project-reducation item">
                            <label>
                                <?php echo $co2_reducation_rate['label']; ?>:
                            </label>
                            <?php echo $co2_reducation_rate['value']; ?>
                            <span>
                                <?php echo $co2_reducation_rate['append']; ?>
                            </span>
                        </div>
                    <?php } ?>



                    <?php
                    $funds_participation = get_field_object('funds_participation');
                    // echo "<pre>";
                    // print_r($ppp);
                    // echo "</pre>";
                    if ($funds_participation) {
                        ?>

                        <div class="project-partnership financing_item item">
                            <label>
                                <?php echo $funds_participation['label']; ?>:
                            </label>

                            <?php if ($funds_participation['value']) { ?>

                                <div class='financing_tooltip'>
                                    <p class='sidebar_text'>
                                        <?php echo __('Yes', 'ndp-projects-plugin'); ?><br>
                                    </p>
                                    <?php if ($funds_participation['instructions']) { ?>
                                        <div class='sidebar_tooltip'>
                                            <div class='tooltip_label'>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                                    fill="none">
                                                    <path
                                                        d="M9.1665 15.0013H10.8332V13.3346H9.1665V15.0013ZM9.99984 1.66797C5.39984 1.66797 1.6665 5.4013 1.6665 10.0013C1.6665 14.6013 5.39984 18.3346 9.99984 18.3346C14.5998 18.3346 18.3332 14.6013 18.3332 10.0013C18.3332 5.4013 14.5998 1.66797 9.99984 1.66797ZM9.99984 16.668C6.32484 16.668 3.33317 13.6763 3.33317 10.0013C3.33317 6.3263 6.32484 3.33464 9.99984 3.33464C13.6748 3.33464 16.6665 6.3263 16.6665 10.0013C16.6665 13.6763 13.6748 16.668 9.99984 16.668ZM9.99984 5.0013C8.15817 5.0013 6.6665 6.49297 6.6665 8.33464H8.33317C8.33317 7.41797 9.08317 6.66797 9.99984 6.66797C10.9165 6.66797 11.6665 7.41797 11.6665 8.33464C11.6665 10.0013 9.1665 9.79297 9.1665 12.5013H10.8332C10.8332 10.6263 13.3332 10.418 13.3332 8.33464C13.3332 6.49297 11.8415 5.0013 9.99984 5.0013Z" />
                                                </svg>
                                            </div>
                                            <div class='tooltip_more_block'>
                                                <div class='tooltip_more_container'>
                                                    <p class='tooltip_more_content'>
                                                        <span>
                                                            <?php echo $funds_participation['instructions']; ?>
                                                        </span>


                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            <?php } else { ?>
                                <?php echo __('No', 'ndp-projects'); ?>
                            <?php } ?>

                        </div>
                    <?php } ?>






                    <?php
                    $un_goals = get_field_object('un_goals');
                    if ($un_goals) {
                        ?>

                        <div class="project-partnership financing_item item">
                            <label>
                                <?php echo $un_goals['label']; ?>:
                            </label>



                            <?php //if ($un_goals['value']) {                 ?>

                            <div class='financing_tooltip'>
                                <p class='sidebar_text'>
                                    <?php echo $un_goals['value']; ?>
                                    <span> /
                                        <?php echo $un_goals['append']; ?>
                                    </span>
                                </p>
                                <?php if ($un_goals['instructions']) { ?>
                                    <div class='sidebar_tooltip'>
                                        <div class='tooltip_label'>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"
                                                fill="none">
                                                <path
                                                    d="M9.1665 15.0013H10.8332V13.3346H9.1665V15.0013ZM9.99984 1.66797C5.39984 1.66797 1.6665 5.4013 1.6665 10.0013C1.6665 14.6013 5.39984 18.3346 9.99984 18.3346C14.5998 18.3346 18.3332 14.6013 18.3332 10.0013C18.3332 5.4013 14.5998 1.66797 9.99984 1.66797ZM9.99984 16.668C6.32484 16.668 3.33317 13.6763 3.33317 10.0013C3.33317 6.3263 6.32484 3.33464 9.99984 3.33464C13.6748 3.33464 16.6665 6.3263 16.6665 10.0013C16.6665 13.6763 13.6748 16.668 9.99984 16.668ZM9.99984 5.0013C8.15817 5.0013 6.6665 6.49297 6.6665 8.33464H8.33317C8.33317 7.41797 9.08317 6.66797 9.99984 6.66797C10.9165 6.66797 11.6665 7.41797 11.6665 8.33464C11.6665 10.0013 9.1665 9.79297 9.1665 12.5013H10.8332C10.8332 10.6263 13.3332 10.418 13.3332 8.33464C13.3332 6.49297 11.8415 5.0013 9.99984 5.0013Z" />
                                            </svg>
                                        </div>
                                        <div class='tooltip_more_block'>
                                            <div class='tooltip_more_container'>
                                                <p class='tooltip_more_content'>
                                                    <span>
                                                        <?php echo $un_goals['instructions']; ?>
                                                    </span>


                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php //}                 ?>


                        </div>
                    <?php } ?>



                </div>
            </div>




        </div>
    </div>
    <?php if (!$hide_col) { ?>
    </div>
<?php } ?>