<?php
  $args = array(
      'post_type' => 'cases',
      'posts_per_page' => 3,
      'order' => 'DESC',
  );
// $query = new WP_Query($args);

// if ($query->have_posts()) {
//   while ($query->have_posts()) {
//       $query->the_post();
//       $categories = get_the_terms(get_the_ID(), 'news_tag');
//   }
//   wp_reset_postdata();
// }
?>
<div class='home-case'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='home-case-block'>
          <div class='home-block-header'>
            <div class='home-block-title'><?php _e('Cases', 'ndp') ?></div>
            <a href='<?=get_post_type_archive_link('cases')?>' class='btn_link'><?php _e('See all cases', 'ndp') ?><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                viewBox="0 0 18 18" fill="none">
                <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#2A59BD" />
              </svg></a>
          </div>
          <div class='home-case-block-items'>
            <div class='owl-carousel' id="cases">
              <?php
              // Добавить параметр 'lang' к запросу, чтобы учесть текущий язык в WPML
              if (defined('ICL_LANGUAGE_CODE')) {
                  $args['lang'] = ICL_LANGUAGE_CODE; // Получить текущий язык
              }
              $query = new WP_Query($args);

              if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $category_slug='cases_category';
                    $tag_slug='cases_tag';
                    $post_type='cases';
                    $hide_col = true;
                    get_template_part( 'template-parts/content-custom',null, compact('post_type','counterPost','category_slug','tag_slug','custom_sticky', 'hide_col'));
                }
                wp_reset_postdata();
              }?>
            </div>
            <div class="cases__slider__navigation">
              <div class="cases__slider__navigation__dots"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
