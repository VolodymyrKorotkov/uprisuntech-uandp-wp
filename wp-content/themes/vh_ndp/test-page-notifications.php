<?php
/*
Template Name: LMS Notifications
для тестов и проверки вёрстки
*/

get_header();
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/material-components-web.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/notifications.css">

<section class="account">
  <div class="container">
    <div class="account__block">
      <nav class="account__block-nav col-4">
        <div class="account__block-nav__wrapper">
        <a href="#" class="account__block-nav__item">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <mask id="mask0_3459_11711" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
          <rect width="24" height="24" fill="#D9D9D9"/>
          </mask>
          <g mask="url(#mask0_3459_11711)">
          <path d="M5 21C4.45 21 3.97917 20.8042 3.5875 20.4125C3.19583 20.0208 3 19.55 3 19V5C3 4.45 3.19583 3.97917 3.5875 3.5875C3.97917 3.19583 4.45 3 5 3H19C19.55 3 20.0208 3.19583 20.4125 3.5875C20.8042 3.97917 21 4.45 21 5V19C21 19.55 20.8042 20.0208 20.4125 20.4125C20.0208 20.8042 19.55 21 19 21H5ZM5 19H11V5H5V19ZM13 19H19V12H13V19ZM13 10H19V5H13V10Z" fill="#1C1B1F"/>
          </g>
          </svg>
          Dashboard
        </a>
        <a href="#" class="account__block-nav__item">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <mask id="mask0_3459_11718" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
          <rect width="24" height="24" fill="#D9D9D9"/>
          </mask>
          <g mask="url(#mask0_3459_11718)">
          <path d="M5.55 18.9998L2 15.4498L3.4 14.0498L5.525 16.1748L9.775 11.9248L11.175 13.3498L5.55 18.9998ZM5.55 10.9998L2 7.4498L3.4 6.0498L5.525 8.1748L9.775 3.9248L11.175 5.3498L5.55 10.9998ZM13 16.9998V14.9998H22V16.9998H13ZM13 8.9998V6.9998H22V8.9998H13Z" fill="#1C1B1F"/>
          </g>
          </svg>
          Applications
        </a>
        </div>
        <div class="account__block-nav__wrapper">
        <a href="#" class="account__block-nav__item">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <mask id="mask0_3459_11730" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
          <rect width="24" height="24" fill="#D9D9D9"/>
          </mask>
          <g mask="url(#mask0_3459_11730)">
          <path d="M12 21L5 17.2V11.2L1 9L12 3L23 9V17H21V10.1L19 11.2V17.2L12 21ZM12 12.7L18.85 9L12 5.3L5.15 9L12 12.7ZM12 18.725L17 16.025V12.25L12 15L7 12.25V16.025L12 18.725Z" fill="#1C1B1F"/>
          </g>
          </svg>
          My courses
        </a>
        <a href="#" class="account__block-nav__item">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <mask id="mask0_3459_11737" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
          <rect width="24" height="24" fill="#D9D9D9"/>
          </mask>
          <g mask="url(#mask0_3459_11737)">
          <path d="M7 17H14V15H7V17ZM7 13H17V11H7V13ZM7 9H17V7H7V9ZM5 21C4.45 21 3.97917 20.8042 3.5875 20.4125C3.19583 20.0208 3 19.55 3 19V5C3 4.45 3.19583 3.97917 3.5875 3.5875C3.97917 3.19583 4.45 3 5 3H19C19.55 3 20.0208 3.19583 20.4125 3.5875C20.8042 3.97917 21 4.45 21 5V19C21 19.55 20.8042 20.0208 20.4125 20.4125C20.0208 20.8042 19.55 21 19 21H5ZM5 19H19V5H5V19Z" fill="#1C1B1F"/>
          </g>
          </svg>
          Certificates
        </a>
        </div>
        <div class="account__block-nav__wrapper">
          <div class="account__block-nav__item account__block-nav__item-current">
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <mask id="mask0_3459_11749" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
            <rect width="24" height="24" fill="#D9D9D9"/>
            </mask>
            <g mask="url(#mask0_3459_11749)">
            <path d="M4 19V17H6V10C6 8.61667 6.41667 7.3875 7.25 6.3125C8.08333 5.2375 9.16667 4.53333 10.5 4.2V3.5C10.5 3.08333 10.6458 2.72917 10.9375 2.4375C11.2292 2.14583 11.5833 2 12 2C12.4167 2 12.7708 2.14583 13.0625 2.4375C13.3542 2.72917 13.5 3.08333 13.5 3.5V4.2C14.8333 4.53333 15.9167 5.2375 16.75 6.3125C17.5833 7.3875 18 8.61667 18 10V17H20V19H4ZM12 22C11.45 22 10.9792 21.8042 10.5875 21.4125C10.1958 21.0208 10 20.55 10 20H14C14 20.55 13.8042 21.0208 13.4125 21.4125C13.0208 21.8042 12.55 22 12 22ZM8 17H16V10C16 8.9 15.6083 7.95833 14.825 7.175C14.0417 6.39167 13.1 6 12 6C10.9 6 9.95833 6.39167 9.175 7.175C8.39167 7.95833 8 8.9 8 10V17Z" fill="#1C1B1F"/>
            </g>
            </svg>
            Notifications
            <span class="account__block-nav__item-count">3</span>
          </div>
          <a href="#" class="account__block-nav__item">
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M15.3102 21.0298C15.2102 21.7098 14.5902 22.2498 13.8502 22.2498H10.1502C9.41023 22.2498 8.79023 21.7098 8.70023 20.9798L8.43023 19.0898C8.16023 18.9498 7.90023 18.7998 7.64023 18.6298L5.84023 19.3498C5.14023 19.6098 4.37023 19.3198 4.03023 18.6998L2.20023 15.5298C1.85023 14.8698 2.00023 14.0898 2.56023 13.6498L4.09023 12.4598C4.08023 12.3098 4.07023 12.1598 4.07023 11.9998C4.07023 11.8498 4.08023 11.6898 4.09023 11.5398L2.57023 10.3498C1.98023 9.89977 1.83023 9.08977 2.20023 8.46977L4.05023 5.27977C4.39023 4.65977 5.16023 4.37977 5.84023 4.64977L7.65023 5.37977C7.91023 5.20977 8.17023 5.05977 8.43023 4.91977L8.70023 3.00977C8.79023 2.30977 9.41023 1.75977 10.1402 1.75977H13.8402C14.5802 1.75977 15.2002 2.29977 15.2902 3.02977L15.5602 4.91977C15.8302 5.05977 16.0902 5.20977 16.3502 5.37977L18.1502 4.65977C18.8602 4.39977 19.6302 4.68977 19.9702 5.30977L21.8102 8.48977C22.1702 9.14977 22.0102 9.92977 21.4502 10.3698L19.9302 11.5598C19.9402 11.7098 19.9502 11.8598 19.9502 12.0198C19.9502 12.1798 19.9402 12.3298 19.9302 12.4798L21.4502 13.6698C22.0102 14.1198 22.1702 14.8998 21.8202 15.5298L19.9602 18.7498C19.6202 19.3698 18.8502 19.6498 18.1602 19.3798L16.3602 18.6598C16.1002 18.8298 15.8402 18.9798 15.5802 19.1198L15.3102 21.0298ZM10.6202 20.2498H13.3802L13.7502 17.6998L14.2802 17.4798C14.7202 17.2998 15.1602 17.0398 15.6202 16.6998L16.0702 16.3598L18.4502 17.3198L19.8302 14.9198L17.8002 13.3398L17.8702 12.7798L17.8733 12.7528C17.9023 12.5025 17.9302 12.2604 17.9302 11.9998C17.9302 11.7298 17.9002 11.4698 17.8702 11.2198L17.8002 10.6598L19.8302 9.07977L18.4402 6.67977L16.0502 7.63977L15.6002 7.28977C15.1802 6.96977 14.7302 6.70977 14.2702 6.51977L13.7502 6.29977L13.3802 3.74977H10.6202L10.2502 6.29977L9.72023 6.50977C9.28023 6.69977 8.84023 6.94977 8.38023 7.29977L7.93023 7.62977L5.55023 6.67977L4.16023 9.06977L6.19023 10.6498L6.12023 11.2098C6.09023 11.4698 6.06023 11.7398 6.06023 11.9998C6.06023 12.2598 6.08023 12.5298 6.12023 12.7798L6.19023 13.3398L4.16023 14.9198L5.54023 17.3198L7.93023 16.3598L8.38023 16.7098C8.81023 17.0398 9.24023 17.2898 9.71023 17.4798L10.2402 17.6998L10.6202 20.2498ZM15.5002 11.9998C15.5002 13.9328 13.9332 15.4998 12.0002 15.4998C10.0672 15.4998 8.50023 13.9328 8.50023 11.9998C8.50023 10.0668 10.0672 8.49977 12.0002 8.49977C13.9332 8.49977 15.5002 10.0668 15.5002 11.9998Z" fill="#151B2C"/>
            </svg>
            Profile settings
          </a>
        </div>
      </nav>
      <div class="account__content col-8">
        <section class="notifications">
        <nav class="breadcrumb">
          <div class="breadcrumb-block">
            <a href="">Dashboard</a>
            <span>Notifications</span>
          </div>
        </nav>
        <div class="notifications__title">
            <h1>Notifications</h1>
            <!-- <button>
              <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9824 15.7726C11.9074 16.2826 11.4424 16.6876 10.8874 16.6876H8.11243C7.55743 16.6876 7.09243 16.2826 7.02493 15.7351L6.82243 14.3176C6.61993 14.2126 6.42493 14.1001 6.22993 13.9726L4.87993 14.5126C4.35493 14.7076 3.77743 14.4901 3.52243 14.0251L2.14993 11.6476C1.88743 11.1526 1.99993 10.5676 2.41993 10.2376L3.56743 9.34507C3.55993 9.23257 3.55243 9.12007 3.55243 9.00007C3.55243 8.88757 3.55993 8.76757 3.56743 8.65507L2.42743 7.76257C1.98493 7.42507 1.87243 6.81757 2.14993 6.35257L3.53743 3.96007C3.79243 3.49507 4.36993 3.28507 4.87993 3.48757L6.23743 4.03507C6.43243 3.90757 6.62743 3.79507 6.82243 3.69007L7.02493 2.25757C7.09243 1.73257 7.55743 1.32007 8.10493 1.32007H10.8799C11.4349 1.32007 11.8999 1.72507 11.9674 2.27257L12.1699 3.69007C12.3724 3.79507 12.5674 3.90757 12.7624 4.03507L14.1124 3.49507C14.6449 3.30007 15.2224 3.51757 15.4774 3.98257L16.8574 6.36757C17.1274 6.86257 17.0074 7.44757 16.5874 7.77757L15.4474 8.67007C15.4549 8.78257 15.4624 8.89507 15.4624 9.01507C15.4624 9.13507 15.4549 9.24757 15.4474 9.36007L16.5874 10.2526C17.0074 10.5901 17.1274 11.1751 16.8649 11.6476L15.4699 14.0626C15.2149 14.5276 14.6374 14.7376 14.1199 14.5351L12.7699 13.9951C12.5749 14.1226 12.3799 14.2351 12.1849 14.3401L11.9824 15.7726ZM8.46493 15.1876H10.5349L10.8124 13.2751L11.2099 13.1101C11.5399 12.9751 11.8699 12.7801 12.2149 12.5251L12.5524 12.2701L14.3374 12.9901L15.3724 11.1901L13.8499 10.0051L13.9024 9.58507L13.9048 9.56488C13.9265 9.3771 13.9474 9.19556 13.9474 9.00007C13.9474 8.79757 13.9249 8.60257 13.9024 8.41507L13.8499 7.99507L15.3724 6.81007L14.3299 5.01007L12.5374 5.73007L12.1999 5.46757C11.8849 5.22757 11.5474 5.03257 11.2024 4.89007L10.8124 4.72507L10.5349 2.81257H8.46493L8.18743 4.72507L7.78993 4.88257C7.45993 5.02507 7.12993 5.21257 6.78493 5.47507L6.44743 5.72257L4.66243 5.01007L3.61993 6.80257L5.14243 7.98757L5.08993 8.40757C5.06743 8.60257 5.04493 8.80507 5.04493 9.00007C5.04493 9.19507 5.05993 9.39757 5.08993 9.58507L5.14243 10.0051L3.61993 11.1901L4.65493 12.9901L6.44743 12.2701L6.78493 12.5326C7.10743 12.7801 7.42993 12.9676 7.78243 13.1101L8.17993 13.2751L8.46493 15.1876ZM12.1249 9.00007C12.1249 10.4498 10.9497 11.6251 9.49993 11.6251C8.05018 11.6251 6.87493 10.4498 6.87493 9.00007C6.87493 7.55032 8.05018 6.37507 9.49993 6.37507C10.9497 6.37507 12.1249 7.55032 12.1249 9.00007Z" fill="#2A59BD"/>
              </svg>
              Settings
            </button> -->
          </div>
          <div class="notifications__block">
            <div class="notifications__item">
              <div class="notifications__item-image notifications__item-image__new" style="text-align: center;">
               <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/notifications.svg" alt="notifications-icon"> -->
              </div>
              <div class="notifications__item-text">
                <h2 class="notifications__item-title">You’ve got notification!</h2>
                <span class="notifications__item-subtitle notifications__item-subtitle__new">No god! No god, please no, no, no, NOOOOO</span>
              </div>
              <span class="notifications__item-time">14:52</span>
            </div>
            <div class="notifications__item">
              <div class="notifications__item-image" style="text-align: center;">
               <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/notifications.svg" alt="notifications-icon"> -->
              </div>
              <div class="notifications__item-text">
                <h2 class="notifications__item-title">Update on application #312</h2>
                <span class="notifications__item-subtitle">You god damn right!</span>
              </div>
              <span class="notifications__item-time">12:58</span>
            </div>
            <div class="notifications__item">
              <div class="notifications__item-image" style="text-align: center;">
               <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/notifications.svg" alt="notifications-icon"> -->
              </div>
              <div class="notifications__item-text">
                <h2 class="notifications__item-title">Your application is now a project!</h2>
                <span class="notifications__item-subtitle">Oh my god, WOW!</span>
              </div>
              <span class="notifications__item-time">10:03</span>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</section>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/material-components-web.min.js?ver=1.0.0"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/notifications.js"></script>

<?php

get_footer();