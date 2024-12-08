<?php
/**
 * Add representative page
 */
?>

<?php
$user = wp_get_current_user();
$user_id = $user->ID;

$isInvited = false;
if ($invitedUser = get_invited_representatives('', $user->user_email)) {
    $invitedUser = $invitedUser[0];
    $isInvited = true;
}

if (!add_representative_of_municipality() || !$user) return;

$request = get_data_from_table('municipality_requests', [
    'where' => " WHERE `user_id`={$user->ID}",
]);

$requestStatus = '';
if ($request) {
    $request = $request[0];
    $requestStatus = $request->status;
}

$current_lang = apply_filters( 'wpml_current_language', 'uk' );
$fieldsDisabled = !empty($request) && $requestStatus != 'Approved';
?>

<div class="account__content col-8">
  <nav class="breadcrumb">
      <?php yoast_breadcrumb(); ?>
  </nav>
  <h1 class="h1 mb-20"><?php _e('Municipality', 'ndp'); ?></h1>
  <div class="acc-box">
    <h3 class="h3 mb-12"><?php _e('Representative details', 'ndp'); ?></h3>
    <form action="" class="acc-form">
      <div class="acc-form__row">
        <div class="mdc-select mdc-select-job mdc-select--outlined mdc--full <?php if ($fieldsDisabled) echo 'mdc-text-field--disabled mdc-select--disabled'; ?>">
            <div class="mdc-select__anchor">
              <span class="mdc-notched-outline">
                <span class="mdc-notched-outline__leading"></span>
                <span class="mdc-notched-outline__notch">
                  <span class="mdc-floating-label"><?php _e('Type of representative', 'ndp'); ?></span>
                </span>
                <span class="mdc-notched-outline__trailing"></span>
              </span>
                <span class="mdc-select__selected-text-container">
					<span class="mdc-select__selected-text"></span>
				</span>
                <span class="mdc-select__dropdown-icon">
                    <svg class="mdc-select__dropdown-icon-graphic" viewBox="7 10 10 5"
                         focusable="false">
                        <polygon class="mdc-select__dropdown-icon-inactive"
                                 stroke="none" fill-rule="evenodd"
                                 points="7 10 12 15 17 10">
                        </polygon>
                        <polygon class="mdc-select__dropdown-icon-active" stroke="none"
                                 fill-rule="evenodd" points="7 15 12 10 17 15">
                        </polygon>
                    </svg>
                </span>
            </div>
          <div class="mdc-select__menu mdc-menu mdc-menu-surface mdc-menu-surface--fullwidth">
            <ul class="mdc-deprecated-list">
              <li class="mdc-deprecated-list-item" data-value="grains">
                <span class="mdc-deprecated-list-item__ripple"></span>
                  <?php
                  $job = __('Head of municipality', 'ndp');
                  $position = get_user_meta($user->ID, 'position', true);
                  if ($position && preg_match('/[A-Za-z]+/', $position)) {
                      $position = __($position, 'ndp');
                  }
                  $job = !empty($position)? $position : $job;
//                  if (empty($position) && $isInvited) {
//                      $job = '';
//                  }
                  ?>
                <span class="mdc-deprecated-list-item__text js-job-title-add"><?php echo $job; ?></span>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="acc-form__row">
        <?php
        $edr = get_user_meta($user_id, 'edrpou_code', true);
        $edr = $edr? $edr : '';
        $edrTitle = __('edrpou', 'ndp');
        ?>
        <label class="mdc-text-field mdc-text-field-tin mdc--full mdc-text-field--outlined <?php if ($fieldsDisabled) echo 'mdc-text-field--disabled mdc-select--disabled'; ?>">
            <span class="mdc-notched-outline">
                <span class="mdc-notched-outline__leading"></span>
                <span class="mdc-notched-outline__notch">
                    <span class="mdc-floating-label"><?php echo $edrTitle; ?></span>
                </span>
                <span class="mdc-notched-outline__trailing"></span>
            </span>
          <input type="text" class="mdc-text-field__input field-input-tin" value="<?php echo $edr; ?>" <?php if ($fieldsDisabled) echo 'disabled'; ?>>
            <span class="error in-valid tin_error" style="display:none"><?php _e("This field must contain 8 symbols",'ndp');?></span>
        </label>
      </div>
      <?php if (!$requestStatus): ?>
        <div class="acc-form__row acc-form__row--operator">
            <div class="acc-form__label"><?php _e('Manual validation by operator', 'ndp'); ?></div>
            <a href="" class="btn btn_bg_primary btn_inline btn_full_mob reject_all btn-manual-request <?php if ($isInvited) echo 'invited'; ?>"><?php _e('Request a review', 'ndp'); ?></a>


        </div>
        <?php endif; ?>
      <div class="acc-form__row acc-form__row--in-progress <?php if ($requestStatus != 'Await processing') echo 'hidden'; ?>">
        <div class="alert-blue">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
               xmlns="http://www.w3.org/2000/svg">
            <mask id="mask0_4417_77400" style="mask-type:alpha"
                  maskUnits="userSpaceOnUse" x="0" y="0" width="24" height="24">
              <rect width="24" height="24" fill="#D9D9D9" />
            </mask>
            <g mask="url(#mask0_4417_77400)">
              <path
                      d="M11 17H13V11H11V17ZM12 9C12.2833 9 12.5208 8.90417 12.7125 8.7125C12.9042 8.52083 13 8.28333 13 8C13 7.71667 12.9042 7.47917 12.7125 7.2875C12.5208 7.09583 12.2833 7 12 7C11.7167 7 11.4792 7.09583 11.2875 7.2875C11.0958 7.47917 11 7.71667 11 8C11 8.28333 11.0958 8.52083 11.2875 8.7125C11.4792 8.90417 11.7167 9 12 9ZM12 22C10.6167 22 9.31667 21.7375 8.1 21.2125C6.88333 20.6875 5.825 19.975 4.925 19.075C4.025 18.175 3.3125 17.1167 2.7875 15.9C2.2625 14.6833 2 13.3833 2 12C2 10.6167 2.2625 9.31667 2.7875 8.1C3.3125 6.88333 4.025 5.825 4.925 4.925C5.825 4.025 6.88333 3.3125 8.1 2.7875C9.31667 2.2625 10.6167 2 12 2C13.3833 2 14.6833 2.2625 15.9 2.7875C17.1167 3.3125 18.175 4.025 19.075 4.925C19.975 5.825 20.6875 6.88333 21.2125 8.1C21.7375 9.31667 22 10.6167 22 12C22 13.3833 21.7375 14.6833 21.2125 15.9C20.6875 17.1167 19.975 18.175 19.075 19.075C18.175 19.975 17.1167 20.6875 15.9 21.2125C14.6833 21.7375 13.3833 22 12 22ZM12 20C14.2333 20 16.125 19.225 17.675 17.675C19.225 16.125 20 14.2333 20 12C20 9.76667 19.225 7.875 17.675 6.325C16.125 4.775 14.2333 4 12 4C9.76667 4 7.875 4.775 6.325 6.325C4.775 7.875 4 9.76667 4 12C4 14.2333 4.775 16.125 6.325 17.675C7.875 19.225 9.76667 20 12 20Z"
                      fill="#2A59BD" />
            </g>
          </svg>
          <span><?php _e('Verification of your data in progress', 'ndp'); ?></span>
        </div>
      </div>
        <?php if ($requestStatus=="Await processing"): ?>
          <a href="" class="reject btn btn_bg_primary btn_inline btn_full_mob"><?php _e('Revoke', 'ndp'); ?></a>
        <?php endif; ?>

      <?php if ($requestStatus == 'Rejected'): ?>
      <div class="acc-form__row acc-form__row--rejected">
        <div class="alert-orange">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
               xmlns="http://www.w3.org/2000/svg">
            <path
                    d="M11.9995 9V11M11.9995 15H12.0095M5.07134 19H18.9277C20.4673 19 21.4296 17.3333 20.6598 16L13.7316 4C12.9618 2.66667 11.0373 2.66667 10.2675 4L3.33929 16C2.56949 17.3333 3.53174 19 5.07134 19Z"
                    stroke="#B38307" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" />
          </svg>
          <span><?php _e('We were unable to verify your credentials. But you can still write us a message in the feedback form.', 'ndp'); ?></span>
        </div>
      </div>
      <div class="acc-form__row">
        <div class="acc-form__label"><?php _e('Manual validation by operator', 'ndp'); ?></div>
        <a href="#" data-izimodal-open="#modalSend"
           class="btn btn_bg_primary btn_inline btn_full_mob"><?php _e('Send a message', 'ndp'); ?></a>
          <?php if ($requestStatus): ?>
              <a href="" class="reject btn btn_bg_primary btn_inline btn_full_mob"><?php _e('Revoke', 'ndp'); ?></a>
          <?php endif; ?>
      </div>
      <?php endif; ?>
    </form>


      <script>

          jQuery(document).ready(function($) {
              $('.reject').click(function(e) {
                  e.preventDefault();
                  $.ajax({
                      url: ajaxurl, // Використання глобальної змінної ajaxurl
                      method: 'POST',
                      data: {
                          action: 'rejectAllMunicipalityRequests', // Дія, за якою буде викликаний обробник на сервері
                      },
                      success: function(response) {
                         location.reload();
                      },
                      error: function(response) {
                          alert(response.responseJSON.data.message); // Повідомлення про помилку
                      }
                  });
              });
          });

          $(document).ready(function() {
              $('form').submit(function(e) {
                  var isValid = true;

                  // Проверка текстового поля на длину 8 символов
                  var textField = $('.field-input-tin').val().trim();
                  if (textField.length !== 8) {
                    $('.tin_error').show();
                      isValid = false;
                      $('.field-input-tin').addClass('mdc-text-field--invalid')
                  }else{
                      $('.tin_error').hide();
                      $('.field-input-tin').removeClass('mdc-text-field--invalid')
                  }

                  // Добавьте здесь другие проверки, если необходимо

                  // Если форма не валидна, предотвратите её отправку
                  if (!isValid) {
                      e.preventDefault();
                  }
              });
          });
      </script>
  </div>
</div>

<div class="fixed-alert fixed-alert--sent <?php if ($requestStatus != 'Await processing') echo 'hidden'; ?>">
  <div class="fixed-alert__text"><?php _e('A request for manual verification by the operator has been sent.', 'ndp'); ?></div>
  <div class="fixed-alert__close">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
          d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
          fill="#F2F0F4" />
    </svg>
  </div>
</div>

<div class="fixed-alert--message hidden">
  <div class="fixed-alert__text"><?php _e('Your message has been sent', 'ndp'); ?></div>
  <div class="fixed-alert__close">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
          d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
          fill="#F2F0F4" />
    </svg>
  </div>
</div>


<!-- MODAL -->
<div class="c-modal c-modal-medium iziModal" id="modalDiaInit">
  <button type="button" data-iziModal-close class="c-modal__close">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
              d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
              fill="#919094" />
    </svg>
  </button>
  <div class="c-modal__wrap">
    <div class="c-modal__login">
      <img src="<?php echo get_template_directory_uri(); ?>/assets/img/img/dia-login.png" alt="alt" class="c-modal__dia">
    </div>
  </div>
</div>

<div class="c-modal c-modal-medium iziModal" id="modalSend">
  <button type="button" data-iziModal-close class="c-modal__close">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
              d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
              fill="#919094" />
    </svg>
  </button>
  <div class="c-modal__wrap">
    <div class="c-modal__header">
      <h2 class="h2"><?php _e('Send a message', 'ndp'); ?></h2>
    </div>
    <form class="c-modal__form">
      <div class="c-modal__row">
        <label class="mdc-text-field mdc--full mdc-text-field--outlined mdc-text-field--textarea">
						<span class="mdc-notched-outline">
							<span class="mdc-notched-outline__leading"></span>
							<span class="mdc-notched-outline__notch">
								<span class="mdc-floating-label"><?php _e('Message text', 'ndp'); ?></span>
							</span>
							<span class="mdc-notched-outline__trailing"></span>
						</span>
          <span class="mdc-text-field__resizer">
							<textarea
                      class="mdc-text-field__input textarea-message"><?php _e('I cannot pass verification on the platform. Help me!', 'ndp'); ?></textarea>
						</span>
        </label>
      </div>
      <div class="c-modal__nav">
        <button type="button" class="btn btn-outline-primary" data-iziModal-close><?php _e('Cancel', 'ndp'); ?></button>
        <button class="btn btn_bg_primary btn-send-message"><?php _e('Send', 'ndp'); ?></button>
      </div>
    </form>
  </div>
</div>