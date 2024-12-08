<?php
/**
 * The template for displaying NDP Single Projects
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package NDP
 */

get_header();

wp_reset_query();
$query_parent_page = new WP_Query(
    array(
        'post_type' => 'any',
        'meta_key' => '_wp_page_template',
        'meta_value' => 'projects.php'
    )
);

if ($query_parent_page->have_posts()) {
    while ($query_parent_page->have_posts()):
        $query_parent_page->the_post(); // WP loop
        $array_parent_pages[] = get_the_ID();
    endwhile;
} else {
    //echo 'No Pages with this template';
}

//print_r($parent_page_id);
wp_reset_query();
//print_r($array_parent_pages[0]);
$parent_page_id = $array_parent_pages[0];
?>



<section class="ndp-single-project">
    <div class="alignwide">

        <div class="entry-top">

            <div class='fn_breadcrumbs'>


                <span class="breadcrumb_wrap">
                    <span>
                        <a href="<?php echo get_home_url(); ?>">
                            <?php _e('Home page', 'ndp-projects-plugin'); ?>
                        </a>
                    </span>
                    <i class="separator">·</i>

                    <?php
                    if (wp_get_post_parent_id($parent_page_id)) { ?>
                        <span>
                            <a href="<?php echo get_permalink(wp_get_post_parent_id($parent_page_id)); ?>">
                                <?php echo get_the_title(wp_get_post_parent_id($parent_page_id)); ?>
                            </a>
                        </span>
                        <i class="separator">·</i>
                    <?php } ?>

                    <span>
                        <a href="<?php echo get_permalink($parent_page_id); ?>">
                            <?php echo get_the_title($parent_page_id); ?>
                        </a>
                    </span>
                    <i class="separator">·</i>
                    <span class="breadcrumb_last" aria-current="page">
                        <?php echo get_the_title(); ?>
                    </span>
                </span>

            </div>

            <h1 class='page_title'>
                <?php echo get_the_title(); ?>
            </h1>


            <img class="project_image" src="<?php echo get_the_post_thumbnail_url($post->ID, 'full'); ?>"
                title="<?php echo get_the_title(); ?>">


        </div>

        <div class="entry-content">
            <div class="content-wrapper">
                <?php // Page content                                                                                    ?>

                <?php echo get_the_content(); ?>

                <?php // END Page content                                                                                    ?>

                <?php // Project Documents repeater // Check rows exists.
                
                if (have_rows('project_documents')):

                    $documents = get_field_object('project_documents');

                    //print_r($participants['label']);
                    ?>

                    <div class='divider'></div>

                    <div class="project-documents content_block">
                        <h2 class='content_title'>
                            <?php echo $documents['label']; ?>
                        </h2>

                        <div class="documents-list">
                            <?php
                            // Loop through rows.
                            while (have_rows('project_documents')):
                                the_row();

                                // Load sub field value.
                                $file = get_sub_field_object('file');

                                // echo "<pre>";
                                // print_r($file);
                                // echo "</pre>";
                        
                                $filesize = $file['value']['filesize'];
                                $filesize_m = round($filesize / 1024 / 1024, 2);

                                $fileurl = $file['value']['url'];
                                $ext = pathinfo($fileurl, PATHINFO_EXTENSION);


                                if ($ext == 'docx') {
                                    $extStyle = '#1B5CC1';
                                } elseif ($ext == 'xlsx') {
                                    $extStyle = '#107B43';
                                } elseif ($ext == 'pdf') {
                                    $extStyle = '#E82526';
                                } else {
                                    $extStyle = '#1B4EB2';
                                }


                                ?>
                                <a href="<?php echo $fileurl; ?>" class="item" title="<?php echo $file['value']['title']; ?>">




                                    <div class='icon-wrapper'>
                                        <div class="file-type">
                                            <?php echo $ext; ?>
                                        </div>

                                        <svg width="48" height="64" viewBox="0 0 48 64" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_9696_3217)">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M8.33966 0H29.8214L48 18.9197V55.6613C48 60.2628 44.2753 64 39.6603 64H8.33966C3.74815 64 1.31606e-09 60.2628 1.31606e-09 55.6613V8.31531C-8.10994e-05 3.7372 3.74815 0 8.33966 0Z"
                                                    fill="<?php echo $extStyle; ?>" />
                                                <path opacity="0.302" fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M29.7979 0V18.7562H48L29.7979 0Z" fill="white" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_9696_3217">
                                                    <rect width="48" height="64" rx="10" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                    </div>
                                    <div class='content'>
                                        <p class='document_title'>
                                            <?php echo $file['value']['title']; ?>
                                        </p>
                                        <span class='size'>
                                            <?php echo $filesize_m; ?> MB
                                        </span>
                                    </div>
                                </a>
                                <?php
                                // End loop.
                            endwhile;
                            ?>
                        </div>

                    </div>

                    <div class='divider'></div>

                    <?php
                    // No value.
                else:
                    // Do something...
                endif;

                // END Project Participants repeater
                ?>


                <?php
                // Project Participants repeater
                // Check rows exists.
                if (have_rows('project_participants')):

                    $participants = get_field_object('project_participants');

                    //print_r($participants['label']);
                    ?>
                    <div class="project-participants content_block">
                        <h2 class='content_title'>
                            <?php echo $participants['label']; ?>
                        </h2>

                        <div class="participants-list">
                            <?php
                            // Loop through rows.
                            while (have_rows('project_participants')):
                                the_row();

                                // Load sub field value.
                                $logo = get_sub_field('logo');
                                $participant = get_sub_field('participant');
                                ?>
                                <div class="item">

                                    <p class='label'>
                                        <?php echo $participant; ?>
                                    </p>

                                    <?php if ($logo) { ?>

                                        <img src="<?php echo $logo['url']; ?>" title="<?php echo $participant; ?>">

                                    <?php } ?>


                                </div>
                                <?php
                                // End loop.
                            endwhile;
                            ?>
                        </div>

                    </div>
                    <?php
                    // No value.
                else:
                    // Do something...
                endif;

                // END Project Participants repeater
                ?>


            </div>

            <aside class="sidebar">

                <?php
                $tags = get_the_terms($post->ID, 'project_tag');
                //print_r($tags);
                if ($tags) { ?>

                    <div class="project-tags">
                        <?php
                        foreach ($tags as $tag) {
                            ?>
                            <a href="<?php echo get_permalink($parent_page_id); ?>?project_tag[0]=<?php echo $tag->slug; ?>"
                                class="item">
                                <?php echo $tag->name; ?>
                            </a>
                            <?php
                        }
                        ?>
                    </div>
                <?php } ?>

                <?php
                $status = get_the_terms($post->ID, 'project_status');
                /*
                foreach ($terms as $term) {
                echo $term->name;
                }
                */
                if ($status) { ?>

                    <div class="project-status">
                        <p class='sidebar_title'>
                            <?php echo __('Status', 'ndp-projects-plugin'); ?>
                        </p>

                        <div class='content'>
                            <?php
                            $status = get_the_terms($post->ID, 'project_status');
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

                            <?php
                            $last_updated = get_field_object('last_updated');
                            if ($last_updated) {
                                ?>
                                <div class="project-update">
                                    <span>
                                        <?php echo $last_updated['label']; ?>
                                    </span>
                                    <span>
                                        <?php echo $last_updated['value']; ?>
                                    </span>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <?php
                }
                ?>

                <?php
                $location = get_field_object('location');
                // echo "<pre>";
                // print_r($location);
                // echo "</pre>";
                
                if ($location) {
                    ?>

                    <div class="project-location">
                        <p class='sidebar_title'>
                            <?php echo $location['label']; ?>
                        </p>
                        <p class='sidebar_text'>
                            <?php echo $location['value']; ?>
                        </p>
                    </div>
                <?php } ?>

                <div class='divider'></div>

                <div class='project-financing'>
                    <div class='column'>
                        <?php
                        $required = get_field_object('required');
                        // echo "<pre>";
                        // print_r($required);
                        // echo "</pre>";
                        
                        if ($required) {
                            ?>

                            <div class="project-required financing_item">
                                <p class='sidebar_title'>
                                    <?php echo $required['label']; ?>
                                </p>
                                <p class='sidebar_text'>
                                    <?php echo number_format($required['value'], 0, '', ' '); ?>
                                    <?php echo $required['append']; ?>
                                </p>

                            </div>
                        <?php } ?>

                        <?php
                        $payback_period = get_field_object('payback_period');
                        if ($payback_period) {
                            ?>

                            <div class="project-payback financing_item">
                                <p class='sidebar_title'>
                                    <?php echo $payback_period['label']; ?>
                                </p>
                                <p class='sidebar_text'>
                                    <?php echo $payback_period['value']; ?>
                                    <?php echo $payback_period['append']; ?>
                                </p>
                            </div>
                        <?php } ?>

                    </div>
                    <div class='column'>
                        <?php
                        $funded_by_applicant = get_field_object('funded_by_applicant');
                        if ($funded_by_applicant) {
                            ?>

                            <div class="project-funded financing_item">
                                <p class='sidebar_title'>
                                    <?php echo $funded_by_applicant['label']; ?>
                                </p>
                                <p class='sidebar_text'>
                                    <?php echo $funded_by_applicant['value']; ?>
                                    <?php echo $funded_by_applicant['append']; ?>
                                </p>
                            </div>
                        <?php } ?>

                        <?php
                        $irr = get_field_object('irr');
                        if ($irr) {
                            ?>

                            <div class="project-funded financing_item">
                                <p class='sidebar_title'>
                                    <?php echo $irr['label']; ?>
                                </p>
                                <p class='sidebar_text'>
                                    <?php echo $irr['value']; ?>
                                    <?php echo $irr['append']; ?>
                                </p>
                            </div>
                        <?php } ?>
                    </div>

                </div>

                <div class='project-financing background'>
                    <div class='column'>
                        <?php
                        $ppp = get_field_object('ppp');
                        // echo "<pre>";
                        // print_r($ppp);
                        // echo "</pre>";
                        if ($ppp) {
                            ?>

                            <div class="project-partnership financing_item">
                                <p class='sidebar_title'>
                                    <?php echo $ppp['label']; ?>:
                                </p>

                                <?php if ($ppp['value']) { ?>

                                    <div class='financing_tooltip'>
                                        <p class='sidebar_text'>
                                            <?php echo __('Yes', 'ndp-projects-plugin'); ?><br>
                                        </p>
                                        <div class='sidebar_tooltip'>
                                            <div class='tooltip_label'>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none">
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
                        $funds_participation = get_field_object('funds_participation');
                        // echo "<pre>";
                        // print_r($funds_participation);
                        // echo "</pre>";
                        if ($funds_participation) {
                            ?>

                            <div class="project-funds financing_item">
                                <p class='sidebar_title'>
                                    <?php echo $funds_participation['label']; ?>:
                                </p>

                                <?php if ($funds_participation['value']) { ?>

                                    <div class='financing_tooltip'>
                                        <p class='sidebar_text'>
                                            <?php echo __('Yes', 'ndp-projects-plugin'); ?><br>
                                        </p>
                                        <?php if ($funds_participation['instructions']) { ?>
                                            <div class='sidebar_tooltip'>
                                                <div class='tooltip_label'>
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                        viewBox="0 0 20 20" fill="none">
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
                                    <?php echo __('No', 'ndp-projects-plugin'); ?>
                                <?php } ?>



                            </div>
                        <?php } ?>

                    </div>
                    <div class='column'>


                        <?php
                        $co2_reducation_rate = get_field_object('co2_reducation_rate');
                        if ($co2_reducation_rate) {
                            ?>

                            <div class="project-reducation financing_item">
                                <p class='sidebar_title'>
                                    <?php echo $co2_reducation_rate['label']; ?>:
                                </p>
                                <p class='sidebar_text'>
                                    <?php echo $co2_reducation_rate['value']; ?>
                                    <?php echo $co2_reducation_rate['append']; ?>
                                </p>
                            </div>
                        <?php } ?>

                        <?php
                        $un_goals = get_field_object('un_goals');
                        if ($un_goals) {
                            ?>

                            <div class="project-goals financing_item">
                                <p class='sidebar_title'>
                                    <?php echo $un_goals['label']; ?>:
                                </p>
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
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 20 20" fill="none">
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
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <?php
                $application_link = get_field('application_link', $parent_page_id);
                if ($application_link) {

                    //print_r($application_link);
                    ?>

                    <a href="<?php echo $application_link['url']; ?>" target="<?php echo $application_link['target']; ?>"
                        class="btn btn_bg_primary">
                        <?php echo $application_link['title']; ?>
                    </a>

                <?php } ?>

            </aside>
        </div>

    </div>
</section>

<?php
get_footer();
