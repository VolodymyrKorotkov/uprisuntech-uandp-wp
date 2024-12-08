<?php
/*
Template Name: Courses Library
*/

get_header();
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/courses-library.css">

<?php
/**
 * Survey main template, библиотека опросов
 *
 * @since 5.8.0
 * @version 5.8.0
 */

defined( 'ABSPATH' ) || exit;

$current_lang = apply_filters( 'wpml_current_language', 'uk' );

$sort = 'popularity';
if (isset($_SESSION) && !empty($_SESSION['sortCourses']) && is_string($_SESSION['sortCourses'])) {
    if (!empty($_SERVER['HTTP_REFERER']) && preg_match('/\/survey/', $_SERVER['HTTP_REFERER'])) {
        $sort = trim($_SESSION['sortCourses']);
    }
}

$paged = 1;
$paged = (get_query_var('paged')) ? get_query_var('paged') : $paged;

$user = null;
$user_role = '';
if (is_user_logged_in()) {
    $student = llms_get_student();
    $user = $student->get('user');
    $user_id = $user->ID;
    $user_roles = $user->roles;
    $user_role = $user_roles[0];
    $municipality = get_user_meta( $user_id, 'user_profile_type', true );
    if (!empty($municipality)) {
        $user_role = 'municipality';
    }
}
?>

<?php do_action( 'lifterlms_before_main_content' ); ?>

  <nav class="breadcrumb">
    <div class="container">
      <div class="breadcrumb-block">
          <?php yoast_breadcrumb();?>
      </div>
    </div>
  </nav>
    <section class="library">
        <div class="container">
            <div class="library__header">
                <div class="library__title">
                    <?php if ( apply_filters( 'lifterlms_show_page_title', true ) ) : ?>
                        <h1 class="page-title"><?php _e('Surveys','ndp'); ?></h1>
                    <?php endif; ?>
                    <?php
                    $courseSortArray = [
                        'popularity' => __('Popularity', 'ndp'),
                        'name' => __('Name', 'ndp'),
                        'price-desc' => __('Price desc', 'ndp'),
                        'price-asc' => __('Price asc', 'ndp'),
                    ];
                    $currentSort = !empty($courseSortArray[$sort])? $courseSortArray[$sort] : __('Popularity', 'ndp');
                    ?>
                    <script>
                        var courseSortArray = JSON.parse(atob('<?php echo base64_encode(json_encode($courseSortArray)); ?>'));
                    </script>
                </div>
                <div class="library__sort">
                    <div class="library__sort-block" data-paged="<?php echo $paged; ?>">
                        <span class="library__sort-text"><?php _e('Sort by', 'ndp'); ?></span>
                        <span class="library__sort-current"><?php echo $currentSort; ?></span>
                        <div class="library__sort-button"></div>
                        <ul class="library__sort-list">
                            <li data-sort="popularity" class="library__sort-list__item <?php if ($sort == 'popularity') echo 'library__sort-list__item-current'; ?>"><?php _e($courseSortArray['popularity'], 'ndp'); ?></li>
                            <li data-sort="name" class="library__sort-list__item <?php if ($sort == 'name') echo 'library__sort-list__item-current'; ?>"><?php _e($courseSortArray['name'], 'ndp'); ?></li>
                            <!--                        <li data-sort="price-desc" class="library__sort-list__item --><?php //if ($sort == 'price-desc') echo 'library__sort-list__item-current'; ?><!--">--><?php //_e($courseSortArray['price-desc'], 'ndp'); ?><!--</li>-->
                            <!--                        <li data-sort="price-asc" class="library__sort-list__item --><?php //if ($sort == 'price-asc') echo 'library__sort-list__item-current'; ?><!--">--><?php //_e($courseSortArray['price-asc'], 'ndp'); ?><!--</li>-->
                        </ul>
                    </div>
                </div>
                <div class="library__navigation-mobile">
                    <a href="<?php echo apply_filters( 'wpml_permalink', '/training-center/', $current_lang, true ); ?>" class="library__navigation-mobile__wizard">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/courses-library/wizard-mob.svg" alt="magic wand">
                        <?php _e('Go to Wizard', 'ndp'); ?></a>
                    <button class="library__navigation-mobile__filter">
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/courses-library/settings.svg" alt="settings">
                        <?php _e('Filters', 'ndp'); ?></button>
                </div>
                <div class="library__tags library__tags-mobile">
                    <div class="library__tags-item library__tags-item__clear">
                        <button class="js-clear-filter library__filter-clear"><?php _e('Clear all filters') ?></button>
                    </div>
                </div>
            </div>
            <div class="library__block">
                <div class="library__content">
                    <div class="library__tags">
                        <div class="library__tags-item library__tags-item__clear">
                            <button class="js-clear-filter library__filter-clear"><?php _e('Clear all filters') ?></button>
                        </div>
                    </div>
                    <?php

                    //WP_Query survey
                    $query = getSurveyQuery($user_role);

                    do_action('lifterlms_loop',$query);

                    ?>
                    <!-- FILTERS NOT FOUND -->
                    <!-- <div class="library__notfound">
                      <h2 class="library__notfound-title">Courses not found</h2>
                      <span class="library__notfound-description">Please try selecting different filters</span>
                      <button class="btn btn_bg_primary library__notfound-button">Clear filters</button>
                    </div> -->
                    <!-- FILTERS NOT FOUND -->

                </div>
                <div class="library__right" style="display:none;">
                    <div class="library__filter" data-paged="<?php echo get_query_var('paged'); ?>">
                        <div class="library__filter-header 1234">
                            <h2 class="library__filter-title"><?php _e('Filters','ndp'); ?></h2>
                            <!--                        <button class="library__filter-clear">Clear all filters</button>-->
                            <button class="library__filter-close"></button>
                        </div>
                        <?php
                        foreach ($_GET as $key => $value) {
                            $_GET[$key] = (array)$value;
                        }
                        $filters = getCoursesFilterByType();
                        ?>
                        <div class="library__filter-content">
                            <?php
                            print_r($filters);
                            if (!empty($filters)): ?>
                                <?php foreach ($filters as $k => $filterArray): ?>
                                    <?php $isHidden = ''; ?>
                                    <div class="library__filter-section" data-type="<?php echo $filterArray['type']; ?>">
                                         <h3 class="library__filter-section__title"><?php _e($filterArray['name'], 'ndp'); ?></h3> 
                                        <ul class="library__filter-section__list">

                                            <?php $num = 0; ?>
                                            <?php foreach ($filterArray['values'] as $key => $filter): ?>
                                                <?php
                                                $num++;
                                                if ($num > 6) {
                                                    $isHidden = 'hidden';
                                                }
                                                ?>
                                                <li class="<?php echo $isHidden; ?>">
                                                    <label>
                                                        <?php if ($filterArray['type'] == 'taxonomy'): ?>
                                                            <?php $checked = '';
                                                            if (!empty($_GET[$filterArray['taxonomy']]) && array_search($filter->slug, $_GET[$filterArray['taxonomy']]) !== false) {
                                                                $checked = 'checked';
                                                            } ?>
                                                            <input type="checkbox" <?php echo $checked; ?> data-taxonomy="<?php echo $filterArray['taxonomy']; ?>" data-input-type="<?php echo $filterArray['taxonomy']; ?>" value="<?php echo $filter->slug; ?>" data-name="<?php echo $filter->name; ?>">
                                                            <span class="library__filter-section__list-name"><?php _e($filter->name, 'ndp'); ?></span>
                                                        <?php elseif ($filterArray['type'] == 'meta' && is_string($filter)): ?>
                                                            <?php $checked = '';
                                                            if (!empty($_GET[$filterArray['meta_key']]) && array_search($key, $_GET[$filterArray['meta_key']]) !== false) {
                                                                $checked = 'checked';
                                                            } ?>
                                                            <input type="checkbox" <?php echo $checked; ?> value="<?php echo $key; ?>" data-meta_key="<?php echo $filterArray['meta_key']; ?>" data-input-type="<?php echo $filterArray['meta_key']; ?>" data-name="<?php echo $filter; ?>">
                                                            <span class="library__filter-section__list-name"><?php _e($filter, 'ndp'); ?></span>
                                                        <?php elseif ($filterArray['type'] == 'postType'): ?>
                                                            <?php $checked = '';
                                                            if (!empty($_GET[$filter['postData']]) && array_search($filter['value'], $_GET[$filter['postData']]) !== false) {
                                                                $checked = 'checked';
                                                            } ?>
                                                            <input type="checkbox" <?php echo $checked; ?> value="<?php echo $filter['value']; ?>" data-input-type="<?php echo $filter['postData']; ?>" data-name="<?php echo $filter['name']; ?>">
                                                            <span class="library__filter-section__list-name"><?php _e($filter['name'], 'ndp'); ?></span>
                                                        <?php endif; ?>
                                                    </label>
                                                </li>
                                            <?php endforeach; ?>
                                            <button class="library__filter-add__button <?php if ($isHidden) echo 'active'; ?>" rel="filter1"><?php _e('See all filters', 'ndp'); ?></button>
                                        </ul>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>

                        </div>
                        <div class="library__filter-footer">
                            <a href="" class="btn btn_bg_primary-default library__filter-reset js-filter-reset"><?php _e('Reset', 'ndp'); ?></a>
                            <a href="" class="btn btn_bg_primary library__filter-show js-btn-filter"><?php _e('Show', 'ndp'); ?> <span class="js-filter-count"></span></a>
                        </div>
                    </div>
                    <div class="library__filter-overlay"></div>
                    <div class="library__wizard">
                        <h2 class="library__wizard-title"><?php _e('Need help choosing a course?', 'ndp'); ?></h2>
                        <span class="library__wizard-description"><?php _e('Use our helper', 'ndp'); ?></span>
                        <a href="<?php echo apply_filters( 'wpml_permalink', '/training-center/', $current_lang, true ); ?>#wizard__block" class="btn btn_bg_primary library__wizard-button">
                            <img src="<?php echo get_template_directory_uri(); ?>/assets/img/courses-library/wizard.svg" alt="magic wand"> <?php _e('Go to Wizard', 'ndp'); ?>
                        </a>


                    </div>
                </div>
            </div>
            <div class="subscribe">
                <div class='row'>
                    <div class='col-md-12'>
                        <div class='subscribe-block bg'>
                            <div class='row'>
                                <div class='col-md-6'>
                                    <div class='subscribe-left'>
                                        <img src='<?php bloginfo('template_url');?>/assets/img/courses-library/Graphic_Elements.png'
                                             class='subscribe-left-bg' />
                                        <div class='subscribe-left-title'><?php _e('Subscribe to new courses', 'ndp'); ?></div>
                                        <p><?php _e('And be the first to know about new courses and trainings on our platform.', 'ndp'); ?></p>
                                        <a href="<?php echo apply_filters( 'wpml_permalink', '/contacts/', $current_lang, true ); ?>" class="btn btn_bg_primary">
                                            <img src='<?php bloginfo('template_url');?>/assets/img/courses-library/mail.svg' /> <?php _e('Subscribe Now', 'ndp'); ?>
                                        </a>
                                    </div>
                                </div>
                                <div class='col-md-6'>
                                    <div class='subscribe-right'>
                                        <img src='<?php bloginfo('template_url');?>/assets/img/courses-library/right-small.png' />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<?php do_action( 'lifterlms_after_main_content' ); ?>

<?php //do_action( 'lifterlms_sidebar' ); ?>

    <script>
        var courseType = 'survey';
        <?php echo 'user_role = "'.$user_role.'"'; ?>;
    </script>


<script src="<?php echo get_template_directory_uri(); ?>/assets/js/courses-library.js?v=2"></script>

<style>
@media(min-width: 992px){
    .library__block {
        display: flex;
        grid-template-columns: initial;
        column-gap: 24px;
        position: relative;
        padding-top: 32px;
        padding-bottom: 40px;
    }
    .library__content {
        width: 100%;
    }
    .library__course{
        flex-wrap:wrap;;
        width:100%;
    }
    .library__course-category {
        max-width: max-content;
    }
    .library__course-item {
        width: 49%;
        height: max-content;
    }
    .library__course {
        display: flex;
        flex-direction: row;
        width: 100%;
        justify-content: space-between;
    }
    h2.library__course-title {
        min-height: 60px;
    }
}

</style>
<?php

get_footer();