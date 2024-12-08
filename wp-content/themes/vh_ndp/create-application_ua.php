<?php
/*
Template Name: Create Application UA
*/

$isLoggedIn = is_user_logged_in();
if($isLoggedIn){
  $new_url = "/create-application-type";
  header("Location: $new_url");
  exit;
}


get_header();
?>
<div class='create-aplication-page'>
  <div class='create-aplication-page-content'>
    <div class='create-aplication-page-content-text'>Створення заявки</div>
    <div class='create-aplication-page-content-title'>У вас є обліковий запис?</div>
    <div class='create-aplication-page-content-actions'>
      <a href='/create-application-type' class='create-aplication-page-content-actions-btn'>
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
          <mask id="mask0_3913_33085" maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="40">
            <rect width="40" height="40" fill="#D9D9D9"/>
          </mask>
          <g mask="url(#mask0_3913_33085)">
            <path d="M28.0557 30V10H30.8334V30H28.0557ZM9.16675 30V10L23.7778 20L9.16675 30ZM11.9445 24.7223L18.8612 20L11.9445 15.2778V24.7223Z" fill="#2A59BD"/>
          </g>
        </svg>
        <div class='create-aplication-page-content-actions-btn-text'>Пропустити цей крок</div>
      </a>
      <a href='/dashboard' class='create-aplication-page-content-actions-btn'>
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
          <mask id="mask0_3913_34664" maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="40">
            <rect width="40" height="40" fill="#D9D9D9"/>
          </mask>
          <g mask="url(#mask0_3913_34664)">
            <path d="M30.2779 23.3333V18.0555H25.0001V15.2778H30.2779V10H33.0556V15.2778H38.3334V18.0555H33.0556V23.3333H30.2779ZM15.0001 19.9722C13.1667 19.9722 11.6436 19.3657 10.4306 18.1528C9.21768 16.9398 8.61121 15.4167 8.61121 13.5833C8.61121 11.75 9.21768 10.2269 10.4306 9.01392C11.6436 7.80094 13.1667 7.19446 15.0001 7.19446C16.8334 7.19446 18.3566 7.80094 19.5695 9.01392C20.7825 10.2269 21.389 11.75 21.389 13.5833C21.389 15.4167 20.7825 16.9398 19.5695 18.1528C18.3566 19.3657 16.8334 19.9722 15.0001 19.9722ZM1.66675 33.3333V29.1667C1.66675 28.2037 1.9098 27.3264 2.39591 26.5348C2.88203 25.7431 3.5649 25.1482 4.44454 24.75C6.40751 23.8519 8.22546 23.206 9.89837 22.8125C11.5713 22.419 13.2704 22.2223 14.9956 22.2223C16.7208 22.2223 18.4167 22.419 20.0834 22.8125C21.7501 23.206 23.5649 23.8519 25.5279 24.75C26.4075 25.1667 27.095 25.7662 27.5904 26.5486C28.0857 27.331 28.3334 28.2037 28.3334 29.1667V33.3333H1.66675ZM4.4445 30.5556H25.5557V29.1667C25.5557 28.7685 25.4469 28.3935 25.2292 28.0417C25.0117 27.6898 24.7223 27.4259 24.3612 27.25C22.5464 26.3889 20.9306 25.7986 19.514 25.4792C18.0973 25.1597 16.5927 25 15.0001 25C13.4075 25 11.8982 25.1597 10.4723 25.4792C9.04637 25.7986 7.42601 26.3889 5.61121 27.25C5.25007 27.4259 4.96533 27.6898 4.757 28.0417C4.54866 28.3935 4.4445 28.7685 4.4445 29.1667V30.5556ZM15.0001 17.1945C16.0279 17.1945 16.8867 16.8496 17.5765 16.1597C18.2663 15.4699 18.6112 14.6111 18.6112 13.5833C18.6112 12.5556 18.2663 11.6968 17.5765 11.007C16.8867 10.3171 16.0279 9.97221 15.0001 9.97221C13.9723 9.97221 13.1135 10.3171 12.4237 11.007C11.7339 11.6968 11.389 12.5556 11.389 13.5833C11.389 14.6111 11.7339 15.4699 12.4237 16.1597C13.1135 16.8496 13.9723 17.1945 15.0001 17.1945Z" fill="#2A59BD"/>
          </g>
        </svg>
        <div class='create-aplication-page-content-actions-btn-text'>Створити обліковий запис</div>
      </a>
      <a href='/dashboard' class='create-aplication-page-content-actions-btn'>
        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
          <mask id="mask0_3913_35037" maskUnits="userSpaceOnUse" x="0" y="0" width="40" height="40">
            <rect width="40" height="40" fill="#D9D9D9"/>
          </mask>
          <g mask="url(#mask0_3913_35037)">
            <path d="M7.77775 35C7.02775 35 6.37729 34.7245 5.82637 34.1736C5.27546 33.6227 5 32.9722 5 32.2222V7.77775C5 7.02775 5.27546 6.37729 5.82637 5.82638C6.37729 5.27546 7.02775 5 7.77775 5H19.9722V7.77775H7.77775V32.2222H19.9722V35H7.77775ZM27.3889 27.6389L25.4306 25.6389L29.6806 21.3889H15V18.6111H29.625L25.375 14.3611L27.3333 12.3611L35 20.0278L27.3889 27.6389Z" fill="#2A59BD"/>
          </g>
        </svg>
        <div class='create-aplication-page-content-actions-btn-text'>Увійдіть в систему</div>
      </a>
    </div>
  </div>
</div>
<?php

get_footer();