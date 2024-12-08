<?php
/*
Template Name: Search Page
*/

get_header();

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
<div class="container">
    <div class="row">
        <div class="col-md-12 seach-head">
            <h1>
                <?php echo get_the_title(); ?>
            </h1>

            <div class="search-tools">

                <?php echo do_shortcode("[wd_asp elements='search' ratio='100%' id=3]"); ?>
            </div>
        </div>

    </div>
</div>

<section class="search-results">
    <div class="container">


        <div class="row">


            <div class="filters col-md-4">
                <div class="filters-sidebar">
                    <!-- <button class="toggle-filter">

                    <svg class="closed-f" width="18" height="19" viewBox="0 0 18 19" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17 0H1C0.447 0 0 0.447 0 1V3.59C0 4.113 0.213 4.627 0.583 4.997L6 10.414V18C6 18.347 6.18 18.668 6.475 18.851C6.635 18.95 6.817 19 7 19C7.153 19 7.306 18.965 7.447 18.895L11.447 16.895C11.786 16.725 12 16.379 12 16V10.414L17.417 4.997C17.787 4.627 18 4.113 18 3.59V1C18 0.447 17.553 0 17 0ZM10.293 9.293C10.105 9.48 10 9.734 10 10V15.382L8 16.382V10C8 9.734 7.895 9.48 7.707 9.293L2 3.59V2H16.001L16.003 3.583L10.293 9.293Z"
                            fill="#2E324D" />
                    </svg>

                    <svg class="open-f" width="19" height="22" viewBox="0 0 19 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M5.41417 0.414062L3.99995 1.82828L5.17162 2.99994H1C0.447 2.99994 0 3.44694 0 3.99994V6.58994C0 7.11294 0.213 7.62694 0.583 7.99694L6 13.4139L6 20.9999C6 21.3469 6.18 21.6679 6.475 21.8509C6.635 21.9499 6.817 21.9999 7 21.9999C7.153 21.9999 7.306 21.9649 7.447 21.8949L11.447 19.8949C11.786 19.7249 12 19.3789 12 18.9999L12 13.4139L13.7928 11.6211L16.7279 14.5562L18.1421 13.142L5.41417 0.414062ZM12.3788 10.2071L10.293 12.2929C10.105 12.4799 10 12.7339 10 12.9999L10 18.3819L8 19.3819V12.9999C8 12.7339 7.895 12.4799 7.707 12.2929L2 6.58994V4.99994L7.17162 4.99994L12.3788 10.2071Z"
                            fill="#2E324D" />
                        <path
                            d="M17 2.99994H10.8284L12.8284 4.99994H16.001L16.003 6.58294L15.2072 7.37872L16.6212 8.79272L17.417 7.99694C17.787 7.62694 18 7.11294 18 6.58994V3.99994C18 3.44694 17.553 2.99994 17 2.99994Z"
                            fill="#2E324D" />
                    </svg>


                </button> -->

                    <div class="filter-head">
                        <h2>Filters</h2>
                    </div>
                    <div class="filter-wrapp">

                        <?php echo do_shortcode("[wpdreams_asp_settings id=3]"); ?>


                    </div>
                </div>
            </div>
            <div class="search-result-content col-md-8" id="content">

                <div class="search-body">

                    <?php echo do_shortcode("[wd_asp elements='results' ratio='100%' id=3]"); ?>
                </div>
            </div>
        </div>
    </div>

    </div>
</section>

<?php

get_footer();
