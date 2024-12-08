
<?php
$post_types = [
    'news' => __('News', 'ndp'),
    'knowledge-base' => __('Knowledge Base','ndp'),
    'cases' => __('Cases','ndp'),
];
  // wp_enqueue_style('vh_ndp-documents-item', get_template_directory_uri() . '/assets/css/documents-item.css');
?>

<div class='documents-item'>
  <a href='<?=$args['file_url']?>' target="_blank" class='documents-item-image'>
    <svg width="48" height="64" viewBox="0 0 48 64" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd" d="M8.38538 0H29.8043L47.9299 18.9197V55.6613C47.9299 60.2628 44.2161 64 39.6146 64H8.38538C3.80727 64 0.0700684 60.2628 0.0700684 55.6613V8.31531C0.0699875 3.7372 3.80727 0 8.38538 0Z" fill="#2A59BD"/>
      <path opacity="0.302" fill-rule="evenodd" clip-rule="evenodd" d="M29.7809 0V18.7562H47.9299L29.7809 0Z" fill="white"/>
    </svg>
    <div class="documents-item-image-text"><?= end(explode('.', $args['file_url'])) ?></div>
  </a>
  <div class='documents-item-content'>
    <div class="documents-item-content-block">
      <div class='documents-item-title-tooltip'>
        <div class='documents-item-title-tooltip-text'><?php echo $args['title']; ?></div>
        <a href='<?=$args['file_url']?>' target="_blank" class='documents-item-title'><?php echo $args['title']; ?></a>
      </div>
      <?php if(isset($args['parentCategory']) && $args['parentCategory']){?><div class='documents-item-label'><?= $args['parentCategory']?></div><?php } ?>
      <?php if(isset($args['post_url']) && $args['post_url']){?><a href="<?=$args['post_url']?>" target="_blank" class='documents-item-link'><img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_link_icon.svg' /> <?= $post_types[$args['post_type']]?></a><?php } ?>
      <?php  if(isset($args['post_title']) && $args['post_title']){?><div class='documents-item-title-tooltip'>
        <div class='documents-item-title-tooltip-text'><?php echo $args['post_title']; ?></div>
        <div class='documents-item-text'><?php echo $args['post_title']; ?></div>
      </div><?php } ?>
    </div>
    <div class='documents-item-footer'>
      <div class='doc-item-date'><?php echo $args['date']; ?></div>
      <a href='<?=$args['file_url']?>' target="_blank" class='doc-item-dowload'> <?php _e('Download')?> <img src='<?php bloginfo('template_url');?>/assets/img/green_university/gu_file_download.svg' /></a>
    </div>
  </div>
</div>
