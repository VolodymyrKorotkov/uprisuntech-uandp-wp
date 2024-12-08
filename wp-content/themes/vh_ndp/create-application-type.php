<?php
/*
Template Name: Create Application Type
*/
$isLoggedIn = is_user_logged_in();
$current_user = wp_get_current_user();
$municipality_info = get_municipality_data();
$current_user_json = json_encode($current_user);

$userData = get_userdata($current_user->ID);
$role = $userData->roles[0];
if ($role == 'operator') {
    include 'access_denied.php';
    get_header();
    die();
    get_footer();
}

if($isLoggedIn){
  $user_id = get_current_user_id();
  $user_meta = json_encode(get_user_meta( $user_id ));
}

get_header();
?>
<style>
    body.page-template-create-application-type main.main:has(#root:empty)  {
        min-height: 638px;
    }
    @media (max-width: 991px) {
        body.page-template-create-application-type main.main:has(#root:empty)  {
            min-height: 1000px;
        }
    }
    .header{
      width: 100vw !important;
    }
</style>
<script>
  var currentUser = <?php echo $current_user_json; ?>;
  var metaUser = <?php echo $user_meta ? $user_meta : 0; ?>;
  var municipality_info = <?php echo $municipality_info ? $municipality_info : 0; ?>;
  // if(municipality_info){
  //   municipality_info.organization_name = <?php //echo $organization_name ?>
  // }
  localStorage.setItem('municipality_info', municipality_info ? JSON.stringify(municipality_info) : '');
  localStorage.setItem('current_user', JSON.stringify({...currentUser, meta: metaUser ? metaUser : {}}));
  localStorage.setItem('isLoggedIn', '<?=$isLoggedIn?>');
</script>
<div id='root'></div>

<?php

get_footer();