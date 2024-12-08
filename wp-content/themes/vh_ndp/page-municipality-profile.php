<?php
/*
Template Name: Municipality profile
*/

get_header();
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/material-components-web.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/municipality-profile.css">

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
            <a href="#" class="account__block-nav__item">
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
            </a>
            <div class="account__block-nav__item account__block-nav__item-current">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <mask id="mask0_5269_11993" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="25">
                  <rect y="0.00012207" width="24" height="24" fill="#D9D9D9"/>
                </mask>
                <g mask="url(#mask0_5269_11993)">
                  <path d="M2 21.0001V3.00012H11.8333V7.08345H22V21.0001H2ZM3.66665 19.3335H6.08333V16.9168H3.66665V19.3335ZM3.66665 15.2501H6.08333V12.8334H3.66665V15.2501ZM3.66665 11.1668H6.08333V8.75012H3.66665V11.1668ZM3.66665 7.08345H6.08333V4.66677H3.66665V7.08345ZM7.75 19.3335H10.1667V16.9168H7.75V19.3335ZM7.75 15.2501H10.1667V12.8334H7.75V15.2501ZM7.75 11.1668H10.1667V8.75012H7.75V11.1668ZM7.75 7.08345H10.1667V4.66677H7.75V7.08345ZM11.8333 19.3335H20.3334V8.75012H11.8333V11.1668H13.8333V12.8334H11.8333V15.2501H13.8333V16.9168H11.8333V19.3335ZM16.25 12.8334V11.1668H17.9167V12.8334H16.25ZM16.25 16.9168V15.2501H17.9167V16.9168H16.25Z" fill="#1C1B1F"/>
                </g>
              </svg>
              Municipality
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
          <section class="municipalityProfile">
            <nav class="breadcrumb">
              <div class="breadcrumb-block">
                <a href="">Dashboard</a>
                <span>Municipality</span>
              </div>
            </nav>
            <div class="municipalityProfile__title">
              <h1>Municipality</h1>
              <button class="municipalityProfile__title-button">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                  <path d="M15 3H3C2.175 3 1.5075 3.675 1.5075 4.5L1.5 13.5C1.5 14.325 2.175 15 3 15H15C15.825 15 16.5 14.325 16.5 13.5V4.5C16.5 3.675 15.825 3 15 3ZM15 13.5H3V6L9 9.75L15 6V13.5ZM9 8.25L3 4.5H15L9 8.25Z" fill="#151B2C"/>
                </svg>
                Send a message
              </button>
            </div>
            <div class="municipalityProfile__section municipalityProfile__details">
              <div class="municipalityProfile__section-title">
                <h2>Representative details</h2>
                <span>
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M5 13L9 17L19 7" stroke="#8A90A5" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  Verified via id.gov.ua 
                </span>
              </div>
              <div class="municipalityProfile__block municipalityProfile__details-block">
                <div class="municipalityProfile__details-block__item">
                  <span>Name of Municipality</span>
                  <strong>Poltava City Council</strong>
                </div>
                <div class="municipalityProfile__details-block__item">
                  <span>Full Name</span>
                  <strong>Alexandr Lelyukh</strong>
                </div>
                <div class="municipalityProfile__details-block__item">
                  <span>Job Title</span>
                  <strong>Head of the municipality</strong>
                </div>
              </div>
            </div>
            <div class="municipalityProfile__section municipality__notifications">
              <div class="municipalityProfile__section-title">
                <h2>Municipality notifications</h2>
              </div>
              <div class="municipalityProfile__block municipality__notifications-block">
                <div class="municipality__notifications-item">
                  <div class="municipality__notifications-image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <mask id="mask0_5362_40261" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                        <rect width="24" height="24" fill="#D9D9D9"/>
                      </mask>
                      <g mask="url(#mask0_5362_40261)">
                        <path d="M2 21V3H12V7H22V21H2ZM4 19H6V17H4V19ZM4 15H6V13H4V15ZM4 11H6V9H4V11ZM4 7H6V5H4V7ZM8 19H10V17H8V19ZM8 15H10V13H8V15ZM8 11H10V9H8V11ZM8 7H10V5H8V7ZM12 19H20V9H12V11H14V13H12V15H14V17H12V19ZM16 13V11H18V13H16ZM16 17V15H18V17H16Z" fill="#2A59BD"/>
                      </g>
                    </svg>
                  </div>
                  <div class="municipality__notifications-text">
                    <div class="municipality__notifications-text__top">
                      <h3 class="municipality__notifications-title">Notification #2</h3>
                      <span class="municipality__notifications-time">15:20</span>
                    </div>
                    <p class="municipality__notifications-subtitle">Notification for the entire organization</p>
                  </div>
                </div>
                <div class="municipality__notifications-item disabled">
                  <div class="municipality__notifications-image">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <mask id="mask0_5362_40261" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                        <rect width="24" height="24" fill="#D9D9D9"/>
                      </mask>
                      <g mask="url(#mask0_5362_40261)">
                        <path d="M2 21V3H12V7H22V21H2ZM4 19H6V17H4V19ZM4 15H6V13H4V15ZM4 11H6V9H4V11ZM4 7H6V5H4V7ZM8 19H10V17H8V19ZM8 15H10V13H8V15ZM8 11H10V9H8V11ZM8 7H10V5H8V7ZM12 19H20V9H12V11H14V13H12V15H14V17H12V19ZM16 13V11H18V13H16ZM16 17V15H18V17H16Z" fill="#2A59BD"/>
                      </g>
                    </svg>
                  </div>
                  <div class="municipality__notifications-text">
                    <div class="municipality__notifications-text__top">
                      <h3 class="municipality__notifications-title">Notification #1</h3>
                      <span class="municipality__notifications-time">10:03</span>
                    </div>
                    <p class="municipality__notifications-subtitle">Notification for the entire organization</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="municipalityProfile__section municipalityProfile__applications">
              <div class="municipalityProfile__section-title">
                <h2>Applications</h2>
                <a href="#">
                  Submit an application
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#2A59BD"/>
                  </svg>
                </a>
              </div>
              <table class="municipalityProfile__applications-table">
                <colgroup>
                    <col style="width: auto;">
                    <col style="width: auto;">
                    <col style="width: auto;">
                    <col style="width: 96px;">
                </colgroup>
                <tr>
                    <td class="municipalityProfile__applications-table__title municipalityProfile__applications-table__hidden-mobile">Application</td>
                    <td class="municipalityProfile__applications-table__title municipalityProfile__applications-table__hidden-desktop">App.</td>
                    <td class="municipalityProfile__applications-table__title">Status</td>
                    <td class="municipalityProfile__applications-table__title">Amount</td>
                    <td class="municipalityProfile__applications-table__title municipalityProfile__applications-table__title-last">Action</td>
                </tr>
                <tr>
                    <td class="municipalityProfile__applications-table__number">№431</td>
                    <td>Submitted</td>
                    <td>$15 000,00</td>
                    <td class="municipalityProfile__applications-table__image">
                        <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/img/municipality-profile/notifications.svg" alt="notifications-icon"> -->
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/municipality-profile/arrow-right.svg" alt="arrow-right" class="municipalityProfile__applications-table__hidden-mobile">
                    </td>
                </tr>
                <tr>
                    <td class="municipalityProfile__applications-table__number">№110</td>
                    <td>Submitted</td>
                    <td>$8 200,00</td>
                    <td class="municipalityProfile__applications-table__image">
                        <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/img/municipality-profile/notifications.svg" alt="notifications-icon"> -->
                        <img src="<?php echo get_template_directory_uri(); ?>/assets/img/municipality-profile/arrow-right.svg" alt="arrow-right" class="municipalityProfile__applications-table__hidden-mobile">
                    </td>
                </tr>
            </table>
            </div>
            <div class="municipalityProfile__section municipalityProfile__representatives">
              <div class="municipalityProfile__section-title">
                <h2>Registered representatives</h2>
                <span>
                  Send invite
                  <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                    <path d="M9 3L7.9425 4.0575L12.1275 8.25H3V9.75H12.1275L7.9425 13.9425L9 15L15 9L9 3Z" fill="#2A59BD"/>
                  </svg>
                </span>
              </div>
              <div class="table-overlay">
                <table class="municipalityProfile__representatives-table">
                  <colgroup>
                    <col style="width: auto;">
                    <col style="width: 159px;">
                    <col style="width: auto;">
                    <col style="width: 159px;">
                    <col style="width: 56px;">
                  </colgroup>
                  <tr>
                    <td class="municipalityProfile__representatives-table__title">Full Name</td>
                    <td class="municipalityProfile__representatives-table__title">Job Title</td>
                    <td class="municipalityProfile__representatives-table__title">Email</td>
                    <td class="municipalityProfile__representatives-table__title">Phone</td>
                    <td class="municipalityProfile__representatives-table__title"></td>
                  </tr>
                  <tr>
                    <td class="municipalityProfile__representatives-table__text">
                      Ivan Mazepa
                      <p class="municipalityProfile__representatives-table__label">Invite sent</p>
                    </td>
                    <td class="municipalityProfile__representatives-table__text">Senior manager</td>
                    <td class="municipalityProfile__representatives-table__text">ivanmazepa@polt.gov.ua</td>
                    <td class="municipalityProfile__representatives-table__text">+38 050 123 45 67</td>
                    <td class="municipalityProfile__representatives-table__options">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 8C13.1 8 14 7.1 14 6C14 4.9 13.1 4 12 4C10.9 4 10 4.9 10 6C10 7.1 10.9 8 12 8ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10ZM10 18C10 16.9 10.9 16 12 16C13.1 16 14 16.9 14 18C14 19.1 13.1 20 12 20C10.9 20 10 19.1 10 18Z" fill="#45464F"/>
                      </svg>
                      <!-- <ul class="municipalityProfile__representatives-table__list">
                        <li class="municipalityProfile__representatives-table__list-item">Revoke invite</li>
                      </ul> -->
                    </td>
                  </tr>
                  <tr>
                    <td class="municipalityProfile__representatives-table__text">Konstantin Konstantinopolsky</td>
                    <td class="municipalityProfile__representatives-table__text">Senior energy safety specialist</td>
                    <td class="municipalityProfile__representatives-table__text">konstantink@gmail.com</td>
                    <td class="municipalityProfile__representatives-table__text">+38 050 123 45 67</td>
                    <td class="municipalityProfile__representatives-table__options">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 8C13.1 8 14 7.1 14 6C14 4.9 13.1 4 12 4C10.9 4 10 4.9 10 6C10 7.1 10.9 8 12 8ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10ZM10 18C10 16.9 10.9 16 12 16C13.1 16 14 16.9 14 18C14 19.1 13.1 20 12 20C10.9 20 10 19.1 10 18Z" fill="#45464F"/>
                      </svg>
                      <!-- <ul class="municipalityProfile__representatives-table__list">
                        <li class="municipalityProfile__representatives-table__list-item">Change job title</li>
                        <li class="municipalityProfile__representatives-table__list-item">Remove user</li>
                      </ul> -->
                    </td>
                  </tr>
                  <tr>
                    <td class="municipalityProfile__representatives-table__text">Roman Romanyukh</td>
                    <td class="municipalityProfile__representatives-table__text">Manager</td>
                    <td class="municipalityProfile__representatives-table__text">romanr@gmail.com</td>
                    <td class="municipalityProfile__representatives-table__text">+38 050 123 45 67</td>
                    <td class="municipalityProfile__representatives-table__options">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 8C13.1 8 14 7.1 14 6C14 4.9 13.1 4 12 4C10.9 4 10 4.9 10 6C10 7.1 10.9 8 12 8ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10ZM10 18C10 16.9 10.9 16 12 16C13.1 16 14 16.9 14 18C14 19.1 13.1 20 12 20C10.9 20 10 19.1 10 18Z" fill="#45464F"/>
                      </svg>
                      <!-- <ul class="municipalityProfile__representatives-table__list">
                        <li class="municipalityProfile__representatives-table__list-item">Change job title</li>
                        <li class="municipalityProfile__representatives-table__list-item">Remove user</li>
                      </ul> -->
                    </td>
                  </tr>
                  <tr>
                    <td class="municipalityProfile__representatives-table__text">Olga Olschaska</td>
                    <td class="municipalityProfile__representatives-table__text">Manager</td>
                    <td class="municipalityProfile__representatives-table__text">olgao@gmail.com</td>
                    <td class="municipalityProfile__representatives-table__text">+38 050 123 45 67</td>
                    <td class="municipalityProfile__representatives-table__options">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 8C13.1 8 14 7.1 14 6C14 4.9 13.1 4 12 4C10.9 4 10 4.9 10 6C10 7.1 10.9 8 12 8ZM12 10C10.9 10 10 10.9 10 12C10 13.1 10.9 14 12 14C13.1 14 14 13.1 14 12C14 10.9 13.1 10 12 10ZM10 18C10 16.9 10.9 16 12 16C13.1 16 14 16.9 14 18C14 19.1 13.1 20 12 20C10.9 20 10 19.1 10 18Z" fill="#45464F"/>
                      </svg>
                      <!-- <ul class="municipalityProfile__representatives-table__list">
                        <li class="municipalityProfile__representatives-table__list-item">Change job title</li>
                        <li class="municipalityProfile__representatives-table__list-item">Remove user</li>
                      </ul> -->
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <button class="municipalityProfile__title-button__mobile">
              <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path d="M15 3H3C2.175 3 1.5075 3.675 1.5075 4.5L1.5 13.5C1.5 14.325 2.175 15 3 15H15C15.825 15 16.5 14.325 16.5 13.5V4.5C16.5 3.675 15.825 3 15 3ZM15 13.5H3V6L9 9.75L15 6V13.5ZM9 8.25L3 4.5H15L9 8.25Z" fill="#151B2C"/>
              </svg>
              Send a message
            </button>
          </section>
        </div>
      </div>
    </div>
  </section>

  <!-- МОДАЛКИ -->
  <div class="municipalityProfile__modal" id="modal__change-jobTitle">
    <div class="municipalityProfile__modal-item">
      <button class="municipalityProfile__modal-close"></button>
      <h2 class="municipalityProfile__modal-title">Change job title</h2>
      <p class="municipalityProfile__modal-subtitle">Enter a new job title of municipal representative</p>
      <form action="#" class="municipalityProfile__modal-form">
        <div class="mdc-text-field mdc-text-field--outlined">
          <input type="text" id="jobTitle" class="mdc-text-field__input" aria-controls="jobTitle">
          <div class="mdc-notched-outline">
              <div class="mdc-notched-outline__leading"></div>
              <div class="mdc-notched-outline__notch">
                  <label for="jobTitle" class="mdc-floating-label">Job title</label>
              </div>
              <div class="mdc-notched-outline__trailing"></div>
          </div>
      </div>
        <div class="municipalityProfile__modal-buttons">
          <button type="button" class="municipalityProfile__modal-buttons__cancel">Cancel</button>
          <button type="button" class="municipalityProfile__modal-buttons__confirm modal__button disabled__button">Save</button> 
        </div>
      </form>
    </div>
  </div>

  <div class="municipalityProfile__modal" id="modal__remove-representative">
    <div class="municipalityProfile__modal-item">
      <button class="municipalityProfile__modal-close"></button>
      <h2 class="municipalityProfile__modal-title">Remove representative from the list?</h2>
      <p class="municipalityProfile__modal-subtitle">Are you sure you want to remove the representative from the list?</p>
        <div class="municipalityProfile__modal-buttons">
          <button type="button" class="municipalityProfile__modal-buttons__cancel">Cancel</button>
          <button type="submit" class="municipalityProfile__modal-buttons__confirm">Remove</button> 
        </div>
    </div>
  </div>

  <div class="municipalityProfile__modal" id="modal__send-message">
    <div class="municipalityProfile__modal-item">
      <button class="municipalityProfile__modal-close"></button>
      <h2 class="municipalityProfile__modal-title">Send a message</h2>
      <form action="#" class="municipalityProfile__modal-form">
        <div class="mdc-text-field mdc-text-field--outlined mdc-text-field--textarea">
          <textarea class="mdc-text-field__input" rows="5" id="message"></textarea>
          <div class="mdc-notched-outline">
              <div class="mdc-notched-outline__leading"></div>
              <div class="mdc-notched-outline__notch">
                  <label for="message" class="mdc-floating-label">Message text</label>
              </div>
              <div class="mdc-notched-outline__trailing"></div>
          </div>
        </div>
        <div class="municipalityProfile__modal-buttons">
          <button type="button" class="municipalityProfile__modal-buttons__cancel">Cancel</button>
          <button type="button" class="municipalityProfile__modal-buttons__confirm modal__button disabled__button">Send</button> 
        </div>
      </form>
    </div>
  </div>

  <div class="municipalityProfile__modal" id="modal__invite">
    <div class="municipalityProfile__modal-item">
      <button class="municipalityProfile__modal-close"></button>
      <h2 class="municipalityProfile__modal-title">Invite another representative</h2>
      <p class="municipalityProfile__modal-subtitle">A link will be sent to the representative by email</p>
      <form action="#" novalidate class="municipalityProfile__modal-form" id="modal__invite-form">
        <div class="mdc-text-field mdc-text-field--outlined">
          <input type="text" id="TIN" class="mdc-text-field__input" aria-controls="TIN">
          <div class="mdc-notched-outline">
              <div class="mdc-notched-outline__leading"></div>
              <div class="mdc-notched-outline__notch">
                  <label for="TIN" class="mdc-floating-label">TIN</label>
              </div>
              <div class="mdc-notched-outline__trailing"></div>
          </div>
      </div>
        <div class="mdc-text-field mdc-text-field--outlined">
          <input type="text" id="jobTitle" class="mdc-text-field__input" aria-controls="jobTitle">
          <div class="mdc-notched-outline">
              <div class="mdc-notched-outline__leading"></div>
              <div class="mdc-notched-outline__notch">
                  <label for="jobTitle" class="mdc-floating-label">Job title</label>
              </div>
              <div class="mdc-notched-outline__trailing"></div>
          </div>
      </div>
        <div class="mdc-text-field mdc-text-field--outlined custom-input__field">
          <input type="text" id="email" class="mdc-text-field__input" aria-controls="email" required>
          <div class="mdc-notched-outline">
              <div class="mdc-notched-outline__leading"></div>
              <div class="mdc-notched-outline__notch">
                  <label for="email" class="mdc-floating-label">Email to send a link</label>
              </div>
              <div class="mdc-notched-outline__trailing">
                <i class="material-icons mail-icon">mail_outline</i>
                <i class="material-icons error-icon">error</i>
              </div>
          </div>
      </div>
      <span class="error-message">A user with this email already exists</span>
        <div class="municipalityProfile__modal-buttons">
          <button type="button" class="municipalityProfile__modal-buttons__cancel">Cancel</button>
          <button type="button" class="municipalityProfile__modal-buttons__confirm modal__button disabled__button">Send invite</button> 
        </div>
      </form>
    </div>
  </div>

  <div class="municipalityProfile__modal" id="modal__revoke-invite">
    <div class="municipalityProfile__modal-item">
      <button class="municipalityProfile__modal-close"></button>
      <h2 class="municipalityProfile__modal-title">Revoke user invite?</h2>
      <p class="municipalityProfile__modal-subtitle">Are you sure you want to Revoke user invite?</p>
        <div class="municipalityProfile__modal-buttons">
          <button type="button" class="municipalityProfile__modal-buttons__cancel">Cancel</button>
          <button type="submit" class="municipalityProfile__modal-buttons__confirm">Revoke</button> 
        </div>
    </div>
  </div>
  <!-- ВСПЛИВАШКИ ДЛЯ РІЗНИХ ПОДІЙ -->
  
  <div class="municipalityProfile__message" id="message__change-jobTitle">
    <p><?php _e('Job title successfully changed','ndp'); ?></p>
    <button><img src="<?php echo get_template_directory_uri(); ?>/assets/img/municipality-profile/close.svg" alt="close-btn"></button>
  </div>
  <div class="municipalityProfile__message" id="message__remove-representative">
    <p><?php _e('Representative removed from the list','ndp'); ?></p>
    <button><img src="<?php echo get_template_directory_uri(); ?>/assets/img/municipality-profile/close.svg" alt="close-btn"></button>
  </div>
  <div class="municipalityProfile__message" id="message__sent-invitation">
    <p><?php _e('The invitation was sent successfully','ndp'); ?></p>
    <button><img src="<?php echo get_template_directory_uri(); ?>/assets/img/municipality-profile/close.svg" alt="close-btn"></button>
  </div>
  <div class="municipalityProfile__message" id="message__revoke-invitation">
    <p><?php _e('Invite successfully revoked','ndp'); ?></p>
    <button><img src="<?php echo get_template_directory_uri(); ?>/assets/img/municipality-profile/close.svg" alt="close-btn"></button>
  </div>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/material-components-web.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/municipality-profile.js"></script>

<?php
echo apply_filters( 'the_content', $post->post_content );
?>


<?php

get_footer();