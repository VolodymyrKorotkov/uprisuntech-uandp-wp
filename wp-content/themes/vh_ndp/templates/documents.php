<?php
$isUA = false;
$lng_url = '';
$language_code = '';
$languages = icl_get_languages('skip_missing=0&orderby=code');
if(!empty($languages)){
    foreach($languages as $l){
        if($l['active']){
            $lng_url = $l['url'];
            $language_code = $l['language_code'];
        }
    }
}
$isUA = $language_code == 'uk';

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
$category_ids = array();
foreach ($category_names as $category_name) {
    $category = get_term_by('name', $category_name, 'category');
    if ($category) {
        $category_ids[] = $category->term_id;
    }
}

$args = array(
    'post_type' => 'attachment',
    'posts_per_page'                     => 4,
    'order'=>'date',
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

$count = count(get_posts($args));
$attachments = get_posts($args);
?>


<div class='gu-documets documents-items'>
  <div class='container'>
    <div class='row'>
      <div class='col-md-12'>
        <div class='gu-documents-header'>
          <div class='gu-title'><?php _e('Documents', 'ndp') ?></div>
          <a href='<?= $isUA ? "/documents" : '/en/documents'?>' class='gu-see-all'><?php _e('See all documents', 'ndp') ?><img
              src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_arrow2.svg' /></a>
        </div>
      </div>
    </div>
    <div class='row'>
      <?php 
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
            </div>
          <?php
        }
      ?>
    </div>
  </div>

</div>
