<?php
  wp_enqueue_style('post-document-item', get_template_directory_uri() . '/assets/css/post-document-item.css');

$attachments = get_field('custom_type_files_group', $post_id);
?>

<div class="row post-document-row">
  <?php foreach ($attachments as $key => $attachment) {
    $file = $attachment['posts_files_group'];
//    $attachment_url = wp_get_attachment_url($attachment->ID);
    $attachment_url = $file['url'];
    $attachment_title = get_the_title($attachment->ID);
    $attachment_title = $file['filename'];
    $attachment_metadata = wp_get_attachment_metadata($attachment->ID);
    $type = $file['subtype'];
    if ($type == 'plain') {
      $type = 'txt';
    } elseif ($type == 'vnd.openxmlformats-officedocument.wordprocessingml.document') {
      $type = 'docx';
    }
  ?>
    <div class='col-6 col-md-3'>
      <div class='post-document-item'>
        <a class='post-document-item-format' href="<?=$attachment_url?>" target="_blank">
          <svg width="48" height="64" viewBox="0 0 48 64" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M8.38538 0H29.8043L47.9299 18.9197V55.6613C47.9299 60.2628 44.2161 64 39.6146 64H8.38538C3.80727 64 0.0700684 60.2628 0.0700684 55.6613V8.31531C0.0699875 3.7372 3.80727 0 8.38538 0Z" fill="#2A59BD"/>
            <path opacity="0.302" fill-rule="evenodd" clip-rule="evenodd" d="M29.7809 0V18.7562H47.9299L29.7809 0Z" fill="white"/>
          </svg>
          <div class='post-document-item-format-text'><?= $type; ?></div>
        </a>
        <a class='post-document-item-title' href="<?=$attachment_url?>" target="_blank"><?=$attachment_title?></a>
        <div class='post-document-item-text'><?php echo size_format( $file['filesize'] ); ?></div>
      </div>
    </div>
  <?php } ?>
  
</div>