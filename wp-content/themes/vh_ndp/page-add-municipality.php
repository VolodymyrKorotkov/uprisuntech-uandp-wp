<?php
/*
Template Name: Add municipality
*/

get_header();
?>
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/material-components-web.min.css">
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/add-municipality.css">

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
          <section class="addMunicipality">
            <nav class="breadcrumb">
              <div class="breadcrumb-block">
                <a href="">Dashboard</a>
                <span>Municipality</span>
              </div>
            </nav>
            <h1 class="addMunicipality__title">Municipality</h1>
            <div class="addMunicipality__block">
              <h2 class="addMunicipality__block-title">Representative details</h2>
              <div class="mdc-select mdc-select--outlined">
                <div class="mdc-select__anchor" role="button" aria-haspopup="listbox" aria-expanded="false" tabindex="0">
                  <span class="mdc-notched-outline">
                    <span class="mdc-notched-outline__leading"></span>
                    <span class="mdc-notched-outline__notch">
                      <span class="mdc-floating-label">Type of representative</span>
                    </span>
                    <span class="mdc-notched-outline__trailing"></span>
                  </span>
                  <div class="mdc-select__selected-text"></div>
                  <div class="addMunicipality__selected"></div>
                  <span class="mdc-select__dropdown-icon">
                    <svg
                      class="mdc-select__dropdown-icon-graphic"
                      viewBox="7 10 10 5"
                      focusable="false"
                    >
                      <polygon
                        class="mdc-select__dropdown-icon-inactive"
                        stroke="none"
                        fill-rule="evenodd"
                        points="7 10 12 15 17 10"
                      />
                      <polygon
                        class="mdc-select__dropdown-icon-active"
                        stroke="none"
                        fill-rule="evenodd"
                        points="7 15 12 10 17 15"
                      />
                    </svg>
                  </span>
                </div>
                <div class="mdc-select__menu mdc-menu mdc-menu-surface">
                  <ul class="mdc-list">
                    <li class="mdc-list-item" data-value="option1">Head of municipality</li>
                  </ul>
                </div>
              </div>

              <!-- ПОЛЕ З'ЯВЛЯЄТЬСЯ ЯКЩО ПОПЕРЕДНІЙ ЕЛЕМЕНТ НЕ ПУСТИЙ -->
              <div class="mdc-text-field mdc-text-field--outlined" id="hidden__field">
                <input type="text" class="mdc-text-field__input" id="TIN-organization">
                <div class="mdc-notched-outline">
                    <div class="mdc-notched-outline__leading"></div>
                    <div class="mdc-notched-outline__notch">
                        <label for="TIN-organization" class="mdc-floating-label">TIN of the organization</label>
                    </div>
                    <div class="mdc-notched-outline__trailing"></div>
                </div>
              </div>
              <div class="addMunicipality__alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M11.9995 9V11M11.9995 15H12.0095M5.07134 19H18.9277C20.4673 19 21.4296 17.3333 20.6598 16L13.7316 4C12.9618 2.66667 11.0373 2.66667 10.2675 4L3.33929 16C2.56949 17.3333 3.53174 19 5.07134 19Z" stroke="#B38307" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <p class="addMunicipality__alert-text">We were unable to automatically verify your credentials. But you have access to manual verification by an operator.</p>
              </div>
              <div class="addMunicipality__alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <path d="M11.9995 9V11M11.9995 15H12.0095M5.07134 19H18.9277C20.4673 19 21.4296 17.3333 20.6598 16L13.7316 4C12.9618 2.66667 11.0373 2.66667 10.2675 4L3.33929 16C2.56949 17.3333 3.53174 19 5.07134 19Z" stroke="#B38307" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <p class="addMunicipality__alert-text">We were unable to verify your credentials. But you can still write us a message in the feedback form.</p>
              </div>
              <div class="addMunicipality__verification">
                <span class="addMunicipality__verification-text">Verify identity</span>
                <button class="addMunicipality__verification-button govua addMunicipality__button">via ID GOV UA</button>
              </div>
              <div class="addMunicipality__verification">
                <span class="addMunicipality__verification-text">Manual validation by operator</span>
                <button class="addMunicipality__verification-button addMunicipality__button">Request a review</button>
              </div>
              <button class="addMunicipality__message-button addMunicipality__button">Send a message</button>
              <div class="addMunicipality__inProgress">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                  <mask id="mask0_4417_77400" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
                    <rect width="24" height="24" fill="#D9D9D9"/>
                  </mask>
                  <g mask="url(#mask0_4417_77400)">
                    <path d="M11 17H13V11H11V17ZM12 9C12.2833 9 12.5208 8.90417 12.7125 8.7125C12.9042 8.52083 13 8.28333 13 8C13 7.71667 12.9042 7.47917 12.7125 7.2875C12.5208 7.09583 12.2833 7 12 7C11.7167 7 11.4792 7.09583 11.2875 7.2875C11.0958 7.47917 11 7.71667 11 8C11 8.28333 11.0958 8.52083 11.2875 8.7125C11.4792 8.90417 11.7167 9 12 9ZM12 22C10.6167 22 9.31667 21.7375 8.1 21.2125C6.88333 20.6875 5.825 19.975 4.925 19.075C4.025 18.175 3.3125 17.1167 2.7875 15.9C2.2625 14.6833 2 13.3833 2 12C2 10.6167 2.2625 9.31667 2.7875 8.1C3.3125 6.88333 4.025 5.825 4.925 4.925C5.825 4.025 6.88333 3.3125 8.1 2.7875C9.31667 2.2625 10.6167 2 12 2C13.3833 2 14.6833 2.2625 15.9 2.7875C17.1167 3.3125 18.175 4.025 19.075 4.925C19.975 5.825 20.6875 6.88333 21.2125 8.1C21.7375 9.31667 22 10.6167 22 12C22 13.3833 21.7375 14.6833 21.2125 15.9C20.6875 17.1167 19.975 18.175 19.075 19.075C18.175 19.975 17.1167 20.6875 15.9 21.2125C14.6833 21.7375 13.3833 22 12 22ZM12 20C14.2333 20 16.125 19.225 17.675 17.675C19.225 16.125 20 14.2333 20 12C20 9.76667 19.225 7.875 17.675 6.325C16.125 4.775 14.2333 4 12 4C9.76667 4 7.875 4.775 6.325 6.325C4.775 7.875 4 9.76667 4 12C4 14.2333 4.775 16.125 6.325 17.675C7.875 19.225 9.76667 20 12 20Z" fill="#2A59BD"/>
                  </g>
                </svg>
                <p class="addMunicipality__inProgress-text">Verification of your data in progress</p>
              </div>
            </div>
          </section>
        </div>
      </div>
    </div>
  </section>
  
  <!-- З'ЯВЛЯЄТЬСЯ ПРИ НАТИСКАННІ НА addMunicipality__message-button -->
  <div class="addMunicipality__modal">
    <div class="addMunicipality__modal-item">
      <button class="addMunicipality__modal-close"></button>
      <h2 class="addMunicipality__modal-title">Send a message</h2>
      <form action="#" class="addMunicipality__modal-form">
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
        <div class="addMunicipality__modal-buttons">
          <button type="button" class="addMunicipality__modal-buttons__cancel">Cancel</button>
          <button type="submit" class="addMunicipality__modal-buttons__confirm">Send</button> 
        </div>
      </form>
    </div>
  </div>
  <!-- ВСПЛИВАШКИ ДЛЯ РІЗНИХ ПОДІЙ ПРИ ПРОХОДЖЕННІ ВЕРИФІКАЦІЇ -->

  <!-- <div class="addMunicipality__message addMunicipality__message-notMatch">
    <p>Identity does not match</p>
    <button><img src="<?php echo get_template_directory_uri(); ?>/assets/img/add-municipality/close.svg" alt="close-btn"></button>
  </div> -->

  <!-- <div class="addMunicipality__message addMunicipality__message-manualSent">
    <p>A request for manual verification by the <br> operator has been sent.</p>
    <button><img src="<?php echo get_template_directory_uri(); ?>/assets/img/add-municipality/close.svg" alt="close-btn"></button>
  </div> -->

  <!-- <div class="addMunicipality__message addMunicipality__message-success">
    <p>Your message has been sent</p>
    <button><img src="<?php echo get_template_directory_uri(); ?>/assets/img/add-municipality/close.svg" alt="close-btn"></button>
  </div> -->
  
  <!-- <div class="addMunicipality__message addMunicipality__message-confirmed">
    <p>Your credentials have been successfully <br> confirmed</p>
    <button><img src="<?php echo get_template_directory_uri(); ?>/assets/img/add-municipality/close.svg" alt="close-btn"></button>
  </div> -->

<script src="<?php echo get_template_directory_uri(); ?>/assets/js/material-components-web.min.js"></script>
<script src="<?php echo get_template_directory_uri(); ?>/assets/js/add-municipality.js"></script>

<?php
echo apply_filters( 'the_content', $post->post_content );
?>


<?php

get_footer();