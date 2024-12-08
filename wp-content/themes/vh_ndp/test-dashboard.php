<?php
/*
Template Name: Dashboard1
для тестов и проверки вёрстки
*/

get_header();
?>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/material-components-web.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/dashboard.css">

  <section class="account">
    <div class="container">
      <div class="account__block">
        <nav class="account__block-nav col-4">
          <div class="account__block-nav__wrapper">
            <div class="account__block-nav__item account__block-nav__item-current">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <mask id="mask0_3459_11711" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                  <rect width="24" height="24" fill="#D9D9D9"/>
                </mask>
                <g mask="url(#mask0_3459_11711)">
                  <path d="M5 21C4.45 21 3.97917 20.8042 3.5875 20.4125C3.19583 20.0208 3 19.55 3 19V5C3 4.45 3.19583 3.97917 3.5875 3.5875C3.97917 3.19583 4.45 3 5 3H19C19.55 3 20.0208 3.19583 20.4125 3.5875C20.8042 3.97917 21 4.45 21 5V19C21 19.55 20.8042 20.0208 20.4125 20.4125C20.0208 20.8042 19.55 21 19 21H5ZM5 19H11V5H5V19ZM13 19H19V12H13V19ZM13 10H19V5H13V10Z" fill="#1C1B1F"/>
                </g>
              </svg>
              Dashboard
            </div>
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
            <a href="#" class="account__block-nav__item">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.3102 21.0298C15.2102 21.7098 14.5902 22.2498 13.8502 22.2498H10.1502C9.41023 22.2498 8.79023 21.7098 8.70023 20.9798L8.43023 19.0898C8.16023 18.9498 7.90023 18.7998 7.64023 18.6298L5.84023 19.3498C5.14023 19.6098 4.37023 19.3198 4.03023 18.6998L2.20023 15.5298C1.85023 14.8698 2.00023 14.0898 2.56023 13.6498L4.09023 12.4598C4.08023 12.3098 4.07023 12.1598 4.07023 11.9998C4.07023 11.8498 4.08023 11.6898 4.09023 11.5398L2.57023 10.3498C1.98023 9.89977 1.83023 9.08977 2.20023 8.46977L4.05023 5.27977C4.39023 4.65977 5.16023 4.37977 5.84023 4.64977L7.65023 5.37977C7.91023 5.20977 8.17023 5.05977 8.43023 4.91977L8.70023 3.00977C8.79023 2.30977 9.41023 1.75977 10.1402 1.75977H13.8402C14.5802 1.75977 15.2002 2.29977 15.2902 3.02977L15.5602 4.91977C15.8302 5.05977 16.0902 5.20977 16.3502 5.37977L18.1502 4.65977C18.8602 4.39977 19.6302 4.68977 19.9702 5.30977L21.8102 8.48977C22.1702 9.14977 22.0102 9.92977 21.4502 10.3698L19.9302 11.5598C19.9402 11.7098 19.9502 11.8598 19.9502 12.0198C19.9502 12.1798 19.9402 12.3298 19.9302 12.4798L21.4502 13.6698C22.0102 14.1198 22.1702 14.8998 21.8202 15.5298L19.9602 18.7498C19.6202 19.3698 18.8502 19.6498 18.1602 19.3798L16.3602 18.6598C16.1002 18.8298 15.8402 18.9798 15.5802 19.1198L15.3102 21.0298ZM10.6202 20.2498H13.3802L13.7502 17.6998L14.2802 17.4798C14.7202 17.2998 15.1602 17.0398 15.6202 16.6998L16.0702 16.3598L18.4502 17.3198L19.8302 14.9198L17.8002 13.3398L17.8702 12.7798L17.8733 12.7528C17.9023 12.5025 17.9302 12.2604 17.9302 11.9998C17.9302 11.7298 17.9002 11.4698 17.8702 11.2198L17.8002 10.6598L19.8302 9.07977L18.4402 6.67977L16.0502 7.63977L15.6002 7.28977C15.1802 6.96977 14.7302 6.70977 14.2702 6.51977L13.7502 6.29977L13.3802 3.74977H10.6202L10.2502 6.29977L9.72023 6.50977C9.28023 6.69977 8.84023 6.94977 8.38023 7.29977L7.93023 7.62977L5.55023 6.67977L4.16023 9.06977L6.19023 10.6498L6.12023 11.2098C6.09023 11.4698 6.06023 11.7398 6.06023 11.9998C6.06023 12.2598 6.08023 12.5298 6.12023 12.7798L6.19023 13.3398L4.16023 14.9198L5.54023 17.3198L7.93023 16.3598L8.38023 16.7098C8.81023 17.0398 9.24023 17.2898 9.71023 17.4798L10.2402 17.6998L10.6202 20.2498ZM15.5002 11.9998C15.5002 13.9328 13.9332 15.4998 12.0002 15.4998C10.0672 15.4998 8.50023 13.9328 8.50023 11.9998C8.50023 10.0668 10.0672 8.49977 12.0002 8.49977C13.9332 8.49977 15.5002 10.0668 15.5002 11.9998Z" fill="#151B2C"/>
              </svg>
              Profile settings
            </a>
          </div>
        </nav>
        <div class="account__content col-8">
          <section class="dashboard">
            <h1 class="dashboard__title">Dashboard</h1>
            <div class="dashboard__block dashboard__applications">
              <div class="dashboard__applications-title">
                <h2>Last applications</h2>
                <a href="#">View all
                  <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                    <path d="M9.5 3L8.4425 4.0575L12.6275 8.25H3.5V9.75H12.6275L8.4425 13.9425L9.5 15L15.5 9L9.5 3Z" fill="#2A59BD"/>
                  </svg>
                </a>
              </div>
              <table>
                <colgroup>
                  <col style="width: auto;">
                  <col style="width: auto;">
                  <col style="width: auto;">
                  <col style="width: 96px;">
                </colgroup>
                <tr>
                  <td class="dashboard__applications-table__title dashboard__applications-table__hidden-mobile">Application</td>
                  <td class="dashboard__applications-table__title dashboard__applications-table__hidden-desktop">App.</td>
                  <td class="dashboard__applications-table__title">Status</td>
                  <td class="dashboard__applications-table__title">Amount</td>
                  <td class="dashboard__applications-table__title dashboard__applications-table__title-last">Action</td>
                </tr>
                <tr>
                  <td class="dashboard__applications-table__number">№312</td>
                  <td>Draft</td>
                  <td class="dashboard__applications-table__empty">Amount N/A</td>
                  <td class="dashboard__applications-table__image" style="text-align: center;">
                    <!--  <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/notifications.svg" alt="notifications-icon"> -->
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow-right.svg" alt="arrow-right" class="dashboard__applications-table__hidden-mobile">
                  </td>
                </tr>
                <tr>
                  <td class="dashboard__applications-table__number">№431</td>
                  <td>Submitted</td>
                  <td>$15,000.00</td>
                  <td class="dashboard__applications-table__image" style="text-align: center;">
                     <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/notifications.svg" alt="notifications-icon"> -->
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow-right.svg" alt="arrow-right" class="dashboard__applications-table__hidden-mobile">
                  </td>
                </tr>
                <tr>
                  <td class="dashboard__applications-table__number">№5</td>
                  <td>Not approved</td>
                  <td>$12,000.00</td>
                  <td class="dashboard__applications-table__image" style="text-align: center;">
                     <!-- <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/notifications.svg" alt="notifications-icon"> -->
                    <img src="<?php echo get_template_directory_uri(); ?>/assets/img/icon/arrow-right.svg" alt="arrow-right" class="dashboard__applications-table__hidden-mobile">
                  </td>
                </tr>
              </table>

            </div>
            <div class="dashboard__block dashboard__inProgress">
              <div class="dashboard__inProgress-title">
                <h2>Courses in progress</h2>
                <a href="#">View all
                  <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                    <path d="M9.5 3L8.4425 4.0575L12.6275 8.25H3.5V9.75H12.6275L8.4425 13.9425L9.5 15L15.5 9L9.5 3Z" fill="#2A59BD"/>
                  </svg>
                </a>
              </div>
              <div class="dashboard__inProgress-item">
                <div class="dashboard__inProgress-item__about">
                  <span class="dashboard__inProgress-item__category">Solar Solutions</span>
                  <span class="dashboard__inProgress-item__level">Level 1</span>
                  <span class="dashboard__inProgress-item__more">+3</span>
                </div>
                <div class="dashboard__inProgress-item__header">
                  <h2>Complete solar energy design course from Zero to Hero
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <mask id="mask0_3519_14015" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                        <rect width="24" height="24" fill="#D9D9D9"/>
                      </mask>
                      <g mask="url(#mask0_3519_14015)">
                        <path d="M5.4001 20.4001C4.9051 20.4001 4.48135 20.2238 4.12885 19.8713C3.77635 19.5188 3.6001 19.0951 3.6001 18.6001V5.4001C3.6001 4.9051 3.77635 4.48135 4.12885 4.12885C4.48135 3.77635 4.9051 3.6001 5.4001 3.6001H12.0001V5.4001H5.4001V18.6001H18.6001V12.0001H20.4001V18.6001C20.4001 19.0951 20.2238 19.5188 19.8713 19.8713C19.5188 20.2238 19.0951 20.4001 18.6001 20.4001H5.4001ZM9.6751 15.6001L8.4001 14.3251L17.3251 5.4001H14.4001V3.6001H20.4001V9.6001H18.6001V6.6751L9.6751 15.6001Z" fill="#131316"/>
                      </g>
                    </svg>
                  </h2>
                  <a href="#">Continue learning</a>
                </div>
                <div class="dashboard__inProgress-item__info">
                  <div class="dashboard__inProgress-item__provider">
                    <span>Provider:</span><strong>Tesla, Inc.</strong>
                  </div>
                  <div class="dashboard__inProgress-item__time">
                    <span>Total time:</span><strong>11 h</strong>
                  </div>
                </div>
                <div class="dashboard__inProgress-item__status">
              <span class="dashboard__inProgress-item__value">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path d="M6.375 6.48L10.3275 9L6.375 11.52V6.48ZM4.875 3.75V14.25L13.125 9L4.875 3.75Z" fill="#151B2C"/>
                </svg>
                In progress</span>
                  <div class="dashboard__inProgress-item__progress">
                    <span class="dashboard__inProgress-item__progress-current"></span>
                  </div>
                  <span class="dashboard__inProgress-item__percent">25%</span>
                </div>
              </div>
              <div class="dashboard__inProgress-item">
                <div class="dashboard__inProgress-item__about">
                  <span class="dashboard__inProgress-item__category">Solar Solutions</span>
                  <span class="dashboard__inProgress-item__level">Level 1</span>
                  <span class="dashboard__inProgress-item__more">+3</span>
                </div>
                <div class="dashboard__inProgress-item__header">
                  <h2>Complete solar energy design course from Zero to Hero
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                      <mask id="mask0_3519_14015" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                        <rect width="24" height="24" fill="#D9D9D9"/>
                      </mask>
                      <g mask="url(#mask0_3519_14015)">
                        <path d="M5.4001 20.4001C4.9051 20.4001 4.48135 20.2238 4.12885 19.8713C3.77635 19.5188 3.6001 19.0951 3.6001 18.6001V5.4001C3.6001 4.9051 3.77635 4.48135 4.12885 4.12885C4.48135 3.77635 4.9051 3.6001 5.4001 3.6001H12.0001V5.4001H5.4001V18.6001H18.6001V12.0001H20.4001V18.6001C20.4001 19.0951 20.2238 19.5188 19.8713 19.8713C19.5188 20.2238 19.0951 20.4001 18.6001 20.4001H5.4001ZM9.6751 15.6001L8.4001 14.3251L17.3251 5.4001H14.4001V3.6001H20.4001V9.6001H18.6001V6.6751L9.6751 15.6001Z" fill="#131316"/>
                      </g>
                    </svg>
                  </h2>
                  <a href="#">Continue learning</a>
                </div>
                <div class="dashboard__inProgress-item__info">
                  <div class="dashboard__inProgress-item__provider">
                    <span>Provider:</span><strong>Tesla, Inc.</strong>
                  </div>
                  <div class="dashboard__inProgress-item__time">
                    <span>Total time:</span><strong>11 h</strong>
                  </div>
                </div>
                <div class="dashboard__inProgress-item__status">
              <span class="dashboard__inProgress-item__value">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                <path d="M6.375 6.48L10.3275 9L6.375 11.52V6.48ZM4.875 3.75V14.25L13.125 9L4.875 3.75Z" fill="#151B2C"/>
                </svg>
                In progress</span>
                  <div class="dashboard__inProgress-item__progress dashboard__inProgress-item__progress-2">
                    <span class="dashboard__inProgress-item__progress-current dashboard__inProgress-item__progress-current-2"></span>
                  </div>
                  <span class="dashboard__inProgress-item__percent">75%</span>
                </div>
              </div>
            </div>
            <div class="dashboard__block dashboard__certificates">
              <div class="dashboard__certificates-title">
                <h2>Certificates
                  <span class="dashboard__certificates-count">(5)</span>
                </h2>
                <a href="#">View all
                  <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                    <path d="M9.5 3L8.4425 4.0575L12.6275 8.25H3.5V9.75H12.6275L8.4425 13.9425L9.5 15L15.5 9L9.5 3Z" fill="#2A59BD"/>
                  </svg>
                </a>
              </div>
              <div class="dashboard__certificates-block">
                <div class="dashboard__certificates-item">
                  <h2 class="dashboard__certificates-item__title">Heading Certificate</h2>
                  <div class="dashboard__certificates-item__status">
                    <span class="dashboard__certificates-item__tag">Valid</span>
                    <span class="dashboard__certificates-item__date">due to 06.09.25,</span>
                    <span class="dashboard__certificates-item__date">320 days</span>
                  </div>
                  <div class="dashboard__certificates-item__granted">
                    <span>Granted 15.09.23:</span>
                    <strong>Company name</strong>
                  </div>
                  <div class="dashboard__certificates-item__sourse">
                    <span>Sourse:</span>
                    <strong>Organization certificate</strong>
                  </div>
                </div>
                <div class="dashboard__certificates-item">
                  <h2 class="dashboard__certificates-item__title">Heading Certificate</h2>
                  <div class="dashboard__certificates-item__status">
                    <span class="dashboard__certificates-item__tag dashboard__certificates-item__tag-expires">Valid</span>
                    <span>due to 20.10.23,</span>
                    <span>20 days</span>
                  </div>
                  <div class="dashboard__certificates-item__granted">
                    <span>Granted 15.09.23:</span>
                    <strong>Company name</strong>
                  </div>
                  <div class="dashboard__certificates-item__sourse">
                    <span>Sourse:</span>
                    <strong>Organization certificate</strong>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </section>

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/material-components-web.min.js?ver=1.0.0"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/dashboard.js"></script>

<?php

get_footer();