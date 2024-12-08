<?php
/**
 * Certificates account page
 */

?>

<?php if (isset($_GET['upload']) || isset($_GET['edit']) || isset($_GET['view'])): ?>
<?php
require get_template_directory() . '/lifterlms/myaccount/upload-certificate.php';
?>
<?php else: ?>

<?php
llms_get_template(
    'myaccount/dashboard-sidebar.php',
);
?>

<div class="account__content col-8">
  <section class="certificates">
    <nav class="breadcrumb">
        <?php yoast_breadcrumb(); ?>
    </nav>
    <div class="certificates__title">
      <h1><?php _e('Certificates', 'ndp'); ?></h1>
        <?php global $wp; ?>
      <a href="<?php echo home_url( $wp->request ) . '?upload' ?>" class="upload-certificate-btn">
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
          <path d="M13.5 11.25V13.5H4.5V11.25H3V13.5C3 14.325 3.675 15 4.5 15H13.5C14.325 15 15 14.325 15 13.5V11.25H13.5ZM5.25 6.75L6.3075 7.8075L8.25 5.8725V12H9.75V5.8725L11.6925 7.8075L12.75 6.75L9 3L5.25 6.75Z" fill="#2A59BD"/>
        </svg>
        <?php _e('Upload certificate', 'ndp'); ?>
      </a>
    </div>
    <div class="certificates__block">

        <?php echo $content; ?>

    </div>

    <?php if (isset($_GET['uploaded']) && isset($_SESSION['certificate_uploaded'])):
        $translates = [
            'messageUploaded' => __('Certificate uploaded successfully. Information sent for review', 'ndp'),
        ];
        unset($_SESSION['certificate_uploaded']); ?>
    <script>
        var translatesArray = <?php echo json_encode($translates); ?>;
    </script>
    <?php endif; ?>
  </section>
</div>
<?php endif; ?>