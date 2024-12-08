<?php
  $where = array(
      'post_type' => $args['post_type'],
      'posts_per_page' => $args['posts_per_page'],
      'order' => 'DESC',
      'orderby' => 'date',
      'order' => 'DESC',
      'post__not_in' => [$args['post_id']],
  );
// $query = new WP_Query($where);

// if ($query->have_posts()) {
//   while ($query->have_posts()) {
//       $query->the_post();
//       $categories = get_the_terms(get_the_ID(), 'news_tag');
//   }
//   wp_reset_postdata();
// }

$seeAll = [
  'news' => 'See all news',
  'cases' => 'See all cases',
  'knowledge-base' => 'See all articles',
];
?>

<div class='more-post-items'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='more-post-items-block'>
          <div class='home-block-header'>
            <div class='home-block-title'><?php _e($args['title'], 'ndp') ?></div>
            <a href='<?=get_post_type_archive_link($args['post_type'])?>' class='btn_link'><?php _e($seeAll[$args['post_type']], 'ndp') ?> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                viewBox="0 0 18 18" fill="none">
                <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#2A59BD" />
              </svg></a>
          </div>
          <div class='more-post-items-block-items'>
            <div class='owl-carousel' id="more_posts">
              <?php
              $query = new WP_Query($where);

              if ($query->have_posts()) {
                while ($query->have_posts()) {
                  $query->the_post();
                  $category_slug= $args['post_type'] . '_category';
                  $tag_slug= $args['post_type'] . '_tag';
                  $post_type=$args['post_type'];
                  $hide_col = true;
                  $counterPost=2;
                  get_template_part( 'template-parts/content-custom',null, compact('post_type','counterPost','category_slug','tag_slug','custom_sticky', 'hide_col'));
              ?>
                <!-- <div class='block-post-item'>
                  <a href="<?php the_permalink(); ?>" class='block-post-item-img'>
                    <?php
                      $thumbnail_url = get_the_post_thumbnail_url();
                      if ($thumbnail_url) {
                        ?><img src='<?= esc_url($thumbnail_url);?>' /><?php
                      } else {
                        ?><img src='<?php bloginfo('template_url');?>/assets/img/home/new4.png' /><?php
                      }
                    ?>
                    
                  </a>
                  <div class='block-post-item-content'>
                    <a href='<?php the_permalink(); ?>' class='block-post-item-title'><?php the_title(); ?></a>
                    <div class='block-post-item-labels'>
                      <?php
                        $categories = get_the_terms(get_the_ID(), $args['post_type'] . '_category');
                        if ($categories && !is_wp_error($categories) && isset($categories[0])) {
                          echo '<a href="'. get_post_type_archive_link($args['post_type']) .'?'. $args['post_type'] .'_category[0]='. $categories[0]->slug .'" class="block-post-item-label active">'. $categories[0]->name .'</a>';
                        }
                        $categories = get_the_terms(get_the_ID(), $args['post_type'] . '_tag');
                        if ($categories && !is_wp_error($categories)) {
                          foreach ($categories as $category) {
                            echo '<a href="'. get_post_type_archive_link($args['post_type']) .'?'. $args['post_type'] .'_tag[0]='. $categories[0]->slug .'" class="block-post-item-label">'. $category->name .'</a>';
                          }
                        }
                      ?>
                    </div>
                    <div class="block-post-item-desc">
                      <?= custom_get_the_excerpt(get_post()); ?>
                    </div>
                    <div class='block-post-item-time'>
                      <?php
                        $post_date = get_the_date();
                        $time_diff = human_time_diff(get_the_time('U'), current_time('timestamp'));
                        echo $post_date; 
                      ?>
                    </div>
                  </div>
                </div> -->
              <?php 
                }
                wp_reset_postdata();
              }?>
            </div>
            <div class="more_post__slider__navigation">
              <div class="more_post__slider__navigation__dots"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
