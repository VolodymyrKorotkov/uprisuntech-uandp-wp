<?php
/*
Template Name: Documents
*/

$args = array(
    'taxonomy' => 'category',
    'hide_empty' => false,
    'post_type'=>'attachment',
    'exclude'    => array(get_option('default_category'), get_term_by('slug', 'uncategorized', 'category')->term_id),
    'lang' => '', // Оставьте пустым, чтобы WPML автоматически использовал текущий язык
);

$categories = get_terms($args);

$category_names = array();
foreach ($categories as $category) {
    // Получаем код языка для текущего термина
    $term_language = apply_filters('wpml_element_language_code', null, array('element_id' => $category->term_id, 'element_type' => 'category'));

    // Сравниваем с текущим языком сайта, если не совпадает, пропускаем
    if ($term_language != ICL_LANGUAGE_CODE) {
        continue; // Пропустить термин, так как он не соответствует текущему языку
    }
    // Проверяем, есть ли у термина связанные записи типа 'attachment'
    $attachments = get_posts([
        'post_type'   => 'attachment',
        'numberposts' => -1,
        'tax_query'   => [
            [
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => $category->term_id,
            ],
        ],
    ]);
    if (strtolower($category->slug) === 'uncategorized') {
        continue;
    }
    // Если у термина есть связанные записи 'attachment', добавляем его имя в массив
    if (!empty($attachments)) {
        $category_names[] = $category->name;
    }

}

$get_category = $_GET['category'];
$get_types = isset($_GET['types']) ? explode(',', $_GET['types']) : [];

get_header();
?>

<div class='documents-header'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='documents-header-block'>
          <h1 class='documents-header-block-title'><?php _e('Documents','ndp'); ?></h1>
          <div class="input-container types-search-container c-select c-multiselect active">
            <label class="sort-label"><?php _e('All file formats','ndp'); ?></label>
            <input id="filterTypes" value="<?=$_GET['types']?>" type="hidden" name="text-services" class="styled-select" />
            <div class="select__btn" data-post-custom-tag="documents_types">
              <?php if(count($get_types) == 0){ ?><?php _e('All file formats','ndp'); ?> <?php } else {?>
                <span><?=$get_types[0] ?><a href="" class="remove-tag"><img src="/wp-content/themes/vh_ndp/assets/img/icon/close.svg" alt="Remove Tag"></a></span>
                <?php if(count($get_types) > 1){?><span class="count">+ <?=count($get_types)-1?></span><?php }?>
              <?php } ?>
            </div>
            <div class="select__list" style="display: none">
              <div class="select__item <?= in_array('PDF', $get_types) ? 'active' : ''?>" data-sort-by="PDF">PDF</div>
              <div class="select__item <?= in_array('DOCX', $get_types) ? 'active' : ''?>" data-sort-by="DOCX">DOCX</div>
              <div class="select__item <?= in_array('TXT', $get_types) ? 'active' : ''?>" data-sort-by="TXT">TXT</div>
              <div class="select__item <?= in_array('ZIP', $get_types) ? 'active' : ''?>" data-sort-by="ZIP">ZIP</div>
            </div>
          </div>
        </div>
      </div>
      <div class='col-md-12'>
        <div class='documents-header-categories'>
          <a href="/documets" class='documents-header-categories-item <?= !isset($get_category) ? 'active' : ''?>'>
            <?php _e('All categories','ndp'); ?>
          </a>
          <?php foreach ($category_names as $item) {

              if(ICL_LANGUAGE_CODE=='uk'){
                  $lang="";
              }else{
                  $lang="en";
              }
          ?>
            <a href="?category=<?=$item?>"  class='documents-header-categories-item <?= isset($get_category) && $get_category == $item? 'active' : '' ?>'>
              <?=$item?>
            </a>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</div>


<div class='documents-items'>
  <div class='container'>
    <div class='row documents_list'>
      <?php
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $category_ids = array();
        foreach ($category_names as $category_name) {
          $category = get_term_by('name', $category_name, 'category');
          if ($category) {
            $category_ids[] = $category->term_id;
          }
        }

        $args = array(
          'post_type' => 'attachment',
          // 'category_name' => $category_names,
          'post_mime_type' => array(
            'application/pdf', 
            'text/plain', 
            'application/zip', 
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
          ),
          'tax_query' => array(
            array(
                'taxonomy' => 'category', 
                'field'    => 'id', 
                'terms'    => $category_ids, 
                'operator' => 'IN',
            ),
          ),
        );
      $args['lang'] = ICL_LANGUAGE_CODE;
        $post_mime_types = ['PDF' => 'application/pdf', 'DOCX' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'TXT' => 'text/plain', 'ZIP' => 'application/zip'];

        if(count($get_types) > 0){
          $args['post_mime_type'] = [];
          foreach ($post_mime_types as $key => $item) {
            if(in_array($key, $get_types)){
              $args['post_mime_type'][] = $item;
            }
          }
        }

      if(isset($get_category)){
          unset($args['tax_query']);
          $category_obj = get_term_by('name', $get_category, 'category');
          if($category_obj) {
              $args['category__in'] = array($category_obj->term_id);
          }
      }
        $args['posts_per_page'] = -1;
        $count = count(get_posts($args));
        $posts_per_page = 12;
        $args['posts_per_page'] = $posts_per_page;
        $args['paged'] = $paged;
        $attachments = get_posts($args);
      ?>
    </div>
    <div class="row">
        <?php 
        if($count == 0){
          ?>
            <div class='col-md-12'>
              <div class='documents-not-data'>
                <div class='documents-not-data-icon'>
                  <svg width="48" height="64" viewBox="0 0 48 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8.38562 0H29.8046L47.9301 18.9197V55.6613C47.9301 60.2628 44.2163 64 39.6148 64H8.38562C3.80752 64 0.0703125 60.2628 0.0703125 55.6613V8.31531C0.0702316 3.7372 3.80752 0 8.38562 0Z" fill="#A5AAC1"/>
                    <path opacity="0.302" fill-rule="evenodd" clip-rule="evenodd" d="M29.7808 0V18.7562H47.9297L29.7808 0Z" fill="white"/>
                    <path d="M16.2922 39.9091C16.2922 40.9962 16.0933 41.9309 15.6956 42.7131C15.2979 43.492 14.7526 44.0919 14.0599 44.5128C13.3705 44.9304 12.5867 45.1392 11.7084 45.1392C10.8267 45.1392 10.0396 44.9304 9.34686 44.5128C8.65746 44.0919 8.1139 43.4903 7.71618 42.7081C7.31845 41.9259 7.11958 40.9929 7.11958 39.9091C7.11958 38.822 7.31845 37.889 7.71618 37.1101C8.1139 36.3279 8.65746 35.728 9.34686 35.3104C10.0396 34.8894 10.8267 34.679 11.7084 34.679C12.5867 34.679 13.3705 34.8894 14.0599 35.3104C14.7526 35.728 15.2979 36.3279 15.6956 37.1101C16.0933 37.889 16.2922 38.822 16.2922 39.9091ZM14.7709 39.9091C14.7709 39.0805 14.6366 38.3828 14.3682 37.8161C14.103 37.246 13.7384 36.8151 13.2744 36.5234C12.8137 36.2285 12.2917 36.081 11.7084 36.081C11.1217 36.081 10.598 36.2285 10.1373 36.5234C9.67664 36.8151 9.31206 37.246 9.04359 37.8161C8.77844 38.3828 8.64586 39.0805 8.64586 39.9091C8.64586 40.7377 8.77844 41.437 9.04359 42.0071C9.31206 42.5739 9.67664 43.0047 10.1373 43.2997C10.598 43.5914 11.1217 43.7372 11.7084 43.7372C12.2917 43.7372 12.8137 43.5914 13.2744 43.2997C13.7384 43.0047 14.103 42.5739 14.3682 42.0071C14.6366 41.437 14.7709 40.7377 14.7709 39.9091ZM21.3048 45.1541C20.5889 45.1541 19.9641 44.9901 19.4305 44.6619C18.8969 44.3338 18.4826 43.8748 18.1876 43.2848C17.8926 42.6948 17.7451 42.0054 17.7451 41.2166C17.7451 40.4245 17.8926 39.7318 18.1876 39.1385C18.4826 38.5452 18.8969 38.0845 19.4305 37.7564C19.9641 37.4283 20.5889 37.2642 21.3048 37.2642C22.0207 37.2642 22.6454 37.4283 23.1791 37.7564C23.7127 38.0845 24.127 38.5452 24.422 39.1385C24.7169 39.7318 24.8644 40.4245 24.8644 41.2166C24.8644 42.0054 24.7169 42.6948 24.422 43.2848C24.127 43.8748 23.7127 44.3338 23.1791 44.6619C22.6454 44.9901 22.0207 45.1541 21.3048 45.1541ZM21.3097 43.9062C21.7738 43.9062 22.1582 43.7836 22.4632 43.5384C22.7681 43.2931 22.9935 42.9666 23.1393 42.5589C23.2884 42.1513 23.363 41.7022 23.363 41.2116C23.363 40.7244 23.2884 40.277 23.1393 39.8693C22.9935 39.4583 22.7681 39.1286 22.4632 38.88C22.1582 38.6314 21.7738 38.5071 21.3097 38.5071C20.8424 38.5071 20.4546 38.6314 20.1464 38.88C19.8415 39.1286 19.6144 39.4583 19.4653 39.8693C19.3195 40.277 19.2465 40.7244 19.2465 41.2116C19.2465 41.7022 19.3195 42.1513 19.4653 42.5589C19.6144 42.9666 19.8415 43.2931 20.1464 43.5384C20.4546 43.7836 20.8424 43.9062 21.3097 43.9062ZM26.5237 47.8636V37.3636H27.9754V38.6016H28.0997C28.1859 38.4425 28.3102 38.2585 28.4726 38.0497C28.635 37.8409 28.8604 37.6586 29.1487 37.5028C29.4371 37.3438 29.8182 37.2642 30.2922 37.2642C30.9086 37.2642 31.4588 37.42 31.9427 37.7315C32.4266 38.0431 32.8061 38.4922 33.0812 39.0788C33.3596 39.6655 33.4988 40.3714 33.4988 41.1967C33.4988 42.022 33.3613 42.7296 33.0862 43.3196C32.8111 43.9062 32.4333 44.3587 31.9527 44.6768C31.4721 44.9917 30.9236 45.1491 30.3071 45.1491C29.8431 45.1491 29.4636 45.0713 29.1686 44.9155C28.8769 44.7597 28.6482 44.5774 28.4825 44.3686C28.3168 44.1598 28.1892 43.9742 28.0997 43.8118H28.0102V47.8636H26.5237ZM27.9804 41.1818C27.9804 41.7187 28.0583 42.1894 28.214 42.5938C28.3698 42.9981 28.5952 43.3146 28.8902 43.5433C29.1852 43.7687 29.5464 43.8814 29.974 43.8814C30.4181 43.8814 30.7893 43.7637 31.0876 43.5284C31.3859 43.2898 31.6113 42.9666 31.7638 42.5589C31.9195 42.1513 31.9974 41.6922 31.9974 41.1818C31.9974 40.678 31.9212 40.2256 31.7687 39.8246C31.6196 39.4235 31.3942 39.107 31.0926 38.875C30.7943 38.643 30.4214 38.527 29.974 38.527C29.5431 38.527 29.1785 38.638 28.8802 38.8601C28.5853 39.0821 28.3615 39.392 28.2091 39.7898C28.0566 40.1875 27.9804 40.6515 27.9804 41.1818ZM40.8866 39.228L39.5393 39.4666C39.483 39.2943 39.3935 39.1302 39.2709 38.9744C39.1515 38.8187 38.9891 38.6911 38.7836 38.5916C38.5782 38.4922 38.3213 38.4425 38.0131 38.4425C37.5921 38.4425 37.2408 38.5369 36.9591 38.7259C36.6773 38.9115 36.5365 39.1518 36.5365 39.4467C36.5365 39.7019 36.6309 39.9074 36.8199 40.0632C37.0088 40.219 37.3137 40.3466 37.7346 40.446L38.9477 40.7244C39.6504 40.8868 40.174 41.1371 40.5187 41.4751C40.8634 41.8132 41.0358 42.2524 41.0358 42.7926C41.0358 43.25 40.9032 43.6577 40.6381 44.0156C40.3762 44.3703 40.01 44.6487 39.5393 44.8509C39.072 45.053 38.5301 45.1541 37.9136 45.1541C37.0585 45.1541 36.3608 44.9718 35.8206 44.6072C35.2803 44.2393 34.9489 43.7173 34.8263 43.0412L36.2631 42.8224C36.3525 43.197 36.5365 43.4804 36.8149 43.6726C37.0933 43.8615 37.4562 43.956 37.9037 43.956C38.3909 43.956 38.7803 43.8549 39.072 43.6527C39.3637 43.4472 39.5095 43.197 39.5095 42.902C39.5095 42.6634 39.42 42.4628 39.241 42.3004C39.0654 42.138 38.7952 42.0154 38.4307 41.9325L37.1381 41.6491C36.4255 41.4867 35.8985 41.2282 35.5571 40.8736C35.219 40.5189 35.05 40.0698 35.05 39.5263C35.05 39.0755 35.1759 38.6811 35.4278 38.343C35.6797 38.005 36.0277 37.7415 36.4719 37.5526C36.916 37.3603 37.4247 37.2642 37.9981 37.2642C38.8234 37.2642 39.473 37.4432 39.947 37.8011C40.421 38.1558 40.7342 38.6314 40.8866 39.228Z" fill="white"/>
                  </svg>
                </div>
                <div class='documents-not-data-title'><?php _e('No Documents in this category','ndp'); ?></div>
                <div class='documents-not-data-text'><?php _e('Choose another category or change filter settings','ndp'); ?></div>
              </div>
            </div>
          <?php
        } else {
          $max_num_pages = $count;
          $current_page = max(1, get_query_var('paged')); 
          $post_types = ['news' => 'Article'];

          foreach ($attachments as $attachment) {
            $file_url = wp_get_attachment_url($attachment->ID);
            $file_date = get_the_date('d.m.y H:i', $attachment->ID);
            $file_category = get_the_category($attachment->ID);

            global $wpdb;

            $meta_key = 'files_for_post'; 
            $meta_value = $attachment->ID;

            $query = $wpdb->prepare("
                SELECT post_id
                FROM {$wpdb->postmeta}
                WHERE meta_key = %s
                AND meta_value LIKE %s
            ", $meta_key, '%' . $wpdb->esc_like($meta_value) . '%');

            $post_ids = $wpdb->get_col($query);
            $post_url = get_permalink($post_ids[0]);
            $post_title = get_the_title($post_ids[0]);
            $post_type = get_post_type($post_ids[0]);
            ?>
              <div class='col-md-3'>
                <?php get_template_part('template-parts/item', 'document', array(
                  'category' => isset($file_category[0]) ? $file_category[0]->name : '',
                  'post_url' => isset($post_ids[0]) ? $post_url : '',
                  'post_title' => isset($post_ids[0]) ? $post_title : '',
                  'post_type' => isset($post_ids[0]) ? $post_type : '',
                  'title' => $attachment->post_title,
                  'date' => $file_date,
                  'file_url' => $file_url,
                )); ?>
                <!-- <div class='documents-item'>
                  <a href='<?=$file_url?>' target="_blank" class='documents-item-image'>
                    <svg width="48" height="64" viewBox="0 0 48 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M8.38538 0H29.8043L47.9299 18.9197V55.6613C47.9299 60.2628 44.2161 64 39.6146 64H8.38538C3.80727 64 0.0700684 60.2628 0.0700684 55.6613V8.31531C0.0699875 3.7372 3.80727 0 8.38538 0Z" fill="#2A59BD"/>
                      <path opacity="0.302" fill-rule="evenodd" clip-rule="evenodd" d="M29.7809 0V18.7562H47.9299L29.7809 0Z" fill="white"/>
                    </svg>
                    <div class="documents-item-image-text"><?= end(explode('.', $file_url)) ?></div>
                  </a>
                  <div class='documents-item-content'>
                    <div class="documents-item-content-block">
                      <div class='documents-item-title-tooltip'>
                        <div class='documents-item-title-tooltip-text'><?php echo $attachment->post_title; ?></div>
                        <a href='<?=$file_url?>' target="_blank" class='documents-item-title'><?php echo $attachment->post_title; ?></a>
                      </div>
                      <?php if(isset($file_category[0])){?><div class='documents-item-label'><?= $file_category[0]->name?></div><?php } ?>
                      <?php if(isset($post_ids[0])){?><a href="<?=$post_url?>" target="_blank" class='documents-item-link'><img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_link_icon.svg' /> <?= $post_types[$post_type]?></a><?php } ?>
                      <?php  if(isset($post_ids[0]) && isset($post_title) && $post_title){?><div class='documents-item-title-tooltip'>
                        <div class='documents-item-title-tooltip-text'><?php echo $post_title; ?></div>
                        <div class='documents-item-text'><?php echo $post_title; ?></div>
                      </div><?php } ?>
                    </div>
                    <div class='documents-item-footer'>
                      <div class='doc-item-date'><?php echo $file_date; ?></div>
                      <a href='<?=$file_url?>' target="_blank" class='doc-item-dowload'>Download <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_file_download.svg' /></a>
                    </div>
                  </div>
                </div> -->
              </div>
            <?php
          }
            $totalPages = ceil($max_num_pages/$posts_per_page);
            // Вивести пагінацію
            $big = 999999999;
            if ($totalPages > 1) {
                echo '<div class=""><div class="pagination">';
                echo paginate_links(array(
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $totalPages,
                    'prev_text' => '<img src="' . get_template_directory_uri() . '/assets/img/icon/icon-pagination.svg" alt="prev">',
                    'next_text' => '<img src="' . get_template_directory_uri() . '/assets/img/icon/icon-pagination.svg" alt="next">',
                ));
                echo '</div></div>';
            }
          }
    
        wp_reset_postdata();
        ?>
    </div>
  </div>
</div>

<?php

get_footer();
