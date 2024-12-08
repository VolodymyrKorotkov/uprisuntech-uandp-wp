<?php
  $args = array(
      'post_type' => 'news',
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

<div class='home-last-news'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='home-last-news-block'>
          <div class='home-block-header'>
            <div class='home-block-title'><?php _e('Last news', 'ndp') ?></div>
            <a href='<?=get_post_type_archive_link('news')?>' class='btn_link'><?php _e('See all news', 'ndp') ?> <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                viewBox="0 0 18 18" fill="none">
                <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#2A59BD" />
              </svg></a>
          </div>
          <div class='home-last-news-block-items'>
            <div class='owl-carousel' id="last_news">
              <?php
              $query = new WP_Query($args);

              if ($query->have_posts()) {
                while ($query->have_posts()) {
                    $query->the_post();
                    $category_slug='news_category';
                    $tag_slug='news_tag';
                    $post_type='news';
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
                        $categories = get_the_terms(get_the_ID(), 'news_category');
                        if ($categories && isset($categories[0])) {
                          echo '<a href="'. get_post_type_archive_link('news') .'?news_category[0]='. $categories[0]->slug .'" class="block-post-item-label active">'. $categories[0]->name .'</a>';
                        }
                        $categories = get_the_terms(get_the_ID(), 'news_tag');
                        if ($categories) {
                          foreach ($categories as $category) {
                            echo '<a href="'. get_post_type_archive_link('news') .'?news_tag[0]='. $categories[0]->slug .'" class="block-post-item-label">'. $category->name .'</a>';
                          }
                        }
                      ?>
                    </div>
                    <div class="block-post-item-desc">
                      <?= custom_get_the_excerpt(get_post(), 130, '...'); ?>
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


              <!-- <div class='block-post-item'>
                <div class='block-post-item-img'>
                  <img src='<?php bloginfo('template_url');?>/assets/img/home/new5.png' />
                </div>
                <div class='block-post-item-content'>
                  <a href='' class='block-post-item-title'>Welsh government joins forces with industry leaders to
                    speed up wind development</a>
                  <div class='block-post-item-labels'>
                    <a href='#' class='block-post-item-label active'>
                      Green news
                    </a>
                  </div>
                  <p>Aiming to develop wind projects on publicly owned land, the RED Programme aligns with the Welsh
                    government’s commitment to renewable</p>
                  <div class='block-post-item-time'>2 day ago · 6 min read</div>
                </div>
              </div>
              <div class='block-post-item'>
                <div class='block-post-item-img'>
                  <img src='<?php bloginfo('template_url');?>/assets/img/home/new6.png' />
                </div>
                <div class='block-post-item-content'>
                  <a href='' class='block-post-item-title'>World’s First Rewilding Center Breathes Life into
                    Scottish Highlands</a>
                  <div class='block-post-item-labels'>
                    <a href='#' class='block-post-item-label active'>
                      Conservation
                    </a>
                    <div class='block-post-item-label-more'>
                      <a href='#' class='block-post-item-label'>
                        +2
                      </a>
                      <div class='block-post-item-label-more-block'>
                        <div class='block-post-item-label-more-container'>
                          <a href='#' class='block-post-item-label'>
                            Green news
                          </a>
                          <a href='#' class='block-post-item-label'>
                            Storage
                          </a>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="17" height="7" viewBox="0 0 17 7" fill="none">
                          <path d="M16.5 0L8.73038 6.44061C8.34418 6.76075 7.78055 6.74522 7.41257 6.40429L0.5 0H16.5Z"
                            fill="white" />
                        </svg>
                      </div>

                    </div>

                  </div>
                  <p>Dundreggan’s innovative rewilding center opens, educating about landscape restoration in the
                    Scottish Highlands. A hub for community, culture, and conservation, it’s free to all.</p>
                  <div class='block-post-item-time'>20.07.23 · 6 min read</div>
                </div>
              </div> -->
            </div>
            <div class="news__slider__navigation">
              <div class="news__slider__navigation__dots"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
