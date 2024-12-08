<?php
/**
 * Requests account page
 */
?>

<?php

if (!current_user_can('read_requests') ) return;

if (!isset($_GET['id'])) return;

$id = $_GET['id'];
$request = get_municipality_requests([
    'where' => ' WHERE `id`='.$id,
]);
if (empty($request)) {
    wp_redirect( llms_get_endpoint_url( 'requests', '', llms_get_page_url( 'myaccount' ) ));
    die();
}

date_default_timezone_set("Europe/Kiev");

$request = $request['requests'][0];
$user = get_userdata($request->user_id);

$current_time = date("Y-m-d H:i:s");
$due_to = $request->due_to;

global $wpdb;
//проверка срока действия запроса 7 дней
$expired = false;
if ($due_to && !preg_match('/0000/', $due_to) && $request->status == 'Await processing') {
    $due_to = date("Y-m-d H:i:s", strtotime($due_to));
    if ($current_time > $due_to) {

        $table_name = $wpdb->prefix . 'municipality_requests';
        if ($wpdb->update( $table_name,
            [
                'status' => 'Rejected',
                'assigned' => __('Automatically', 'ndp'),
                'last_change' => $current_time,
            ],
            [ 'id' => $id ]
        )) {
            $request->status = 'Rejected';
            $request->last_change = $current_time;
            $expired = true;
        }
    }
}

if ($request->status == 'Approved') {
    $municipality = head_of_municipality((int)$request->user_id);
    if (!empty($municipality)) {
        $municipality = $municipality[0];
    }
}

?>

<section class="account">
  <div class="container">
    <div class="row">
      <div class="col-4">
        <nav class="account__nav">
          <div class="account__nav-box">
            <div class="account__nav-header">
              <h3 class="h3"><?php _e('Request', 'ndp'); ?> №<?php echo $id; ?></h3>
              <p><?php _e('Verify provided information about the manager/head and organization.', 'ndp'); ?></p>
            </div>
          </div>
          <div class="account__nav-box">
            <div class="account__nav-buttons">
                <?php
                $isProcessing = $request->status == 'Await processing';
                $btnApproveText = $isProcessing ? __('Approve', 'ndp') : __($request->status, 'ndp');
                $btnRejectText = $isProcessing ? __('Reject', 'ndp') : __($request->status, 'ndp');
                ?>
                <?php if ($isProcessing): ?>
                  <?php if ($user): ?>
                  <a href="#" data-izimodal-open="#modalInvite"
                     class="btn btn_bg_primary nav-buttons--approve"><?php echo $btnApproveText; ?></a>
                  <?php endif; ?>
                  <a href="#" data-izimodal-open="#modalReject"
                     class="btn btn-outline-primary nav-buttons--reject"><?php echo $btnRejectText; ?></a>
                <?php else: ?>
                    <?php if ($request->status == 'Approved'): ?>
                    <a href="#"
                       class="btn btn_bg_primary disabled"><?php echo $btnApproveText; ?></a>
                    <?php endif; ?>
                    <?php if ($request->status == 'Rejected' || $request->status == 'Cancelled'): ?>
                    <a href="#"
                       class="btn btn-outline-primary disabled"><?php echo $btnRejectText; ?></a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
          </div>
        </nav>
      </div>
      <div class="account__content col-8" data-id="<?php echo $id; ?>">
        <div class="d-flex align-items-center mb-3 mb-lg-4">
          <a href="<?php echo llms_get_endpoint_url( 'requests', '', llms_get_page_url( 'myaccount' ) ); ?>" class="back-home">
            <svg width="8" height="12" viewBox="0 0 8 12" fill="none"
                 xmlns="http://www.w3.org/2000/svg">
              <path
                      d="M7.705 1.41L6.295 0L0.294998 6L6.295 12L7.705 10.59L3.125 6L7.705 1.41Z"
                      fill="#2A59BD"/>
            </svg>
          </a>
          <h1 class="h1"><?php _e('Requests', 'ndp'); ?></h1>
        </div>
        <div class="acc-box acc-box--indent">
          <div class="acc-request">
            <div class="acc-request__header">
              <div class="d-flex justify-content-between align-items-center">
                <h3 class="h3"><?php _e('General info', 'ndp'); ?></h3>
              </div>
            </div>
            <div class="acc-request__body">
              <?php if ($expired): ?>
                <div class="alert-wrapper">
                  <div class="alert-block alert-red">
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM9 15V13H11V15H9ZM9 5V11H11V5H9Z"
                            fill="#BA1A1A"/>
                    </svg>
                    <span><?php _e('Expired', 'ndp'); ?></span>
                  </div>
                </div>
              <?php endif; ?>
              <div class="acc-request__row">
                <div class="acc-request__name"><?php _e('Status', 'ndp'); ?></div>
                <div class="acc-request__text"><?php echo __($request->status, "ndp"); ?></div>
              </div>
              <div class="acc-request__row">
                <div class="acc-request__name"><?php _e('Received', 'ndp'); ?></div>
                <div class="acc-request__text"><?php echo date('d.m.Y, H:i', strtotime($request->received)); ?></div>
              </div>
              <!-- <div class="acc-request__row">
                <div class="acc-request__name"><?php _e('Last status change date', 'ndp'); ?></div>
              <?php
              $last_change = $request->last_change;
              $last_change = !empty($last_change) && !preg_match('/0000/', $last_change) ? date('d.m.Y, H:i', strtotime($last_change)) : '';
              ?>
                <div class="acc-request__text"><?php echo $last_change; ?></div>
              </div> -->


              <!-- <div class="acc-request__row">
                <div class="acc-request__name"><?php //_e('Valid until', 'ndp'); ?></div>
                <div class="acc-request__text"><?php //echo !empty($request->due_to) && !preg_match('/0000/', $request->due_to) ? date('d.m.Y, H:i', strtotime($request->due_to)) : ''; ?></div>
              </div> -->


              <div class="acc-request__row">
                <div class="acc-request__name"><?php _e('Type', 'ndp'); ?></div>
                <div class="acc-request__text"><?php _e($request->type, 'ndp'); ?></div>
              </div>
<!--              <div class="acc-request__row">-->
<!--                <div class="acc-request__name">--><?php //_e('Assigned', 'ndp'); ?><!--</div>-->
<!--                <div class="acc-request__text">--><?php //_e($request->assigned, "ndp"); ?><!--</div>-->
<!--              </div>-->
            </div>
          </div>
        </div>
        <div class="acc-box acc-box--indent">
          <div class="acc-request">
            <div class="acc-request__header">
              <div class="d-flex justify-content-between align-items-center">
                <h3 class="h3"><?php _e('Registrant', 'ndp'); ?></h3>
                <div class="acc-verify">
                  <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                       xmlns="http://www.w3.org/2000/svg">
                    <path d="M5 13L9 17L19 7" stroke="#8A90A5" stroke-width="2"
                          stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  <span><?php _e('Verified via id.gov.ua', 'ndp'); ?></span>
                </div>
              </div>
            </div>
            <div class="acc-request__body">
                <?php if (!$user): ?>
                  <div class="alert-wrapper">
                    <div class="alert-block alert-red">
                      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                              d="M10 0C4.48 0 0 4.48 0 10C0 15.52 4.48 20 10 20C15.52 20 20 15.52 20 10C20 4.48 15.52 0 10 0ZM9 15V13H11V15H9ZM9 5V11H11V5H9Z"
                              fill="#BA1A1A"/>
                      </svg>
                      <span><?php _e('User not exists', 'ndp'); ?></span>
                    </div>
                  </div>
                    <?php
                    $email = '';
                    if (!empty($request->email)) {
                      $email = $request->email;
                    }
                    ?>
                <?php if ($email): ?>
                  <div class="acc-request__row">
                    <div class="acc-request__name"><?php _e('Email', 'ndp'); ?></div>
                    <div class="acc-request__text"><?php echo $email; ?></div>
                  </div>
                <?php endif; ?>
                <?php else: ?>

              <div class="acc-request__row">
                <div class="acc-request__name"><?php _e('Full name', 'ndp'); ?></div>
                <div class="acc-request__text"><?php echo $user->last_name . ' ' . $user->first_name . ' '.$user->middle_name ?></div>
              </div>
              <?php if (!empty($municipality)): ?>
              <div class="acc-request__row">
                <?php
                $organization = get_user_meta($user->ID, 'user_organization', true);
                $organization = $organization? $organization : '';
                ?>
                  <div class="acc-request__name"><?php _e('Municipality name', 'ndp'); ?></div>
                  <div class="acc-request__text"><?php echo $organization; ?></div>
              </div>
              <?php endif; ?>
              <div class="acc-request__row">
                  <?php
                  $edrpou_code = get_user_meta($user->ID, 'edrpou_code', true);
                  $edrpouCode = get_user_meta($user->ID, 'edrpouCode', true);
                  ?>
                <div class="acc-request__name"><?php _e('edrpou', 'ndp'); ?></div>
                <div class="acc-request__text"><?php echo $edrpou_code; ?></div>
              </div>
                <div class="acc-request__row">
                    <?php

                    ?>
                    <div class="acc-request__name"><?php _e('TIN', 'ndp'); ?></div>
                    <div class="acc-request__text"><?php echo $edrpouCode; ?></div>
                </div>
              <div class="acc-request__row">
                <div class="acc-request__name"><?php _e('Job title', 'ndp'); ?></div>
                  <?php
                  $job = __('Head of municipality', 'ndp');
                  $position = get_user_meta($user->ID, 'position', true);
                  if ($position && preg_match('/[A-Za-z]+/', $position)) {
                      $position = __($position, 'ndp');
                  }
                  $job = !empty($position)? $position : $job;
                  if (empty($position) && $request->type == 'Invitation') {
                      $job = '';
                  }
                  ?>
                <div class="acc-request__text"><?php echo $job; ?></div>
              </div>
              <div class="acc-request__row">
                  <?php
                  $email = '';
                  if (!empty($request->email)) {
                      $email = $request->email;
                  } else {
                      $email = $user->user_email;
                  }
                  ?>
                <div class="acc-request__name"><?php _e('Email', 'ndp'); ?></div>
                <div class="acc-request__text"><?php echo $email; ?></div>
              </div>
              <div class="acc-request__row">
              <?php
              $phone = get_user_meta($user->ID, 'llms_phone', true);
              ?>
                <div class="acc-request__name"><?php _e('Phone', 'ndp'); ?></div>
                <div class="acc-request__text"><?php echo $phone; ?></div>
              </div>
            </div>
          <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- MAIN CONTENT  END -->


<div class="c-fix-menu js-request">
  <div class="c-fix-menu__icon">
    <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd"
            d="M3.5 8V6H21.5V8H3.5ZM3.5 13H21.5V11H3.5V13ZM3.5 18H21.5V16H3.5V18Z" fill="#2A59BD" />
    </svg>
    <svg class="hide" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
              d="M19 6.41L17.59 5L12 10.59L6.41 5L5 6.41L10.59 12L5 17.59L6.41 19L12 13.41L17.59 19L19 17.59L13.41 12L19 6.41Z"
              fill="#2A59BD" />
    </svg>
  </div>
  <span><?php _e('Action', 'ndp'); ?></span>
</div>

<!-- MODAL -->

<div class="c-modal c-modal-large c-modal-part iziModal" id="modalReject">
  <form accept="/" class="c-modal-part__box">
    <div class="c-modal-part__header">
      <h2 class="h2"><?php _e('Reject request', 'ndp'); ?></h2>
      <button type="button" data-iziModal-close class="c-modal__close">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
                  d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
                  fill="#919094"/>
        </svg>
      </button>
    </div>
    <div class="c-modal-part__body">
      <div class="c-modal-part__label"><?php _e('You need to write the reason for reject. Describe the details of your decision.', 'ndp'); ?></div>
      <label
              class="mdc-text-field mdc--full mdc-text-field--outlined mdc-text-field--textarea mdc-text-field--textarea--240">
					<span class="mdc-notched-outline">
						<span class="mdc-notched-outline__leading"></span>
						<span class="mdc-notched-outline__notch">
							<span class="mdc-floating-label"><?php _e('Your comment', 'ndp'); ?></span>
						</span>
						<span class="mdc-notched-outline__trailing"></span>
					</span>
        <span class="mdc-text-field__resizer">
						<textarea class="mdc-text-field__input reject-text"></textarea>
					</span>
      </label>
    </div>
    <div class="c-modal-part__footer">
      <button type="button" class="btn btn-outline-primary" data-iziModal-close><?php _e('Cancel', 'ndp'); ?></button>
      <button class="btn btn_bg_primary btn-reject"><?php _e('Reject', 'ndp'); ?></button>
    </div>
  </form>
</div>

<div class="c-modal c-modal-medium iziModal" id="modalInvite">
  <button type="button" data-iziModal-close class="c-modal__close">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
              d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
              fill="#919094"/>
    </svg>
  </button>
  <div class="c-modal__wrap">
    <div class="c-modal__header">
      <h2 class="h2"><?php _e('Approve request', 'ndp'); ?></h2>
      <p><?php _e('You need to enter the name of the organization', 'ndp'); ?></p>
    </div>
    <form action="" class="c-modal__form">
      <div class="c-modal__row">
        <label class="mdc-text-field mdc--full mdc-text-field--outlined">
						<span class="mdc-notched-outline">
							<span class="mdc-notched-outline__leading"></span>
							<span class="mdc-notched-outline__notch">
								<span class="mdc-floating-label"><?php _e('Organization', 'ndp'); ?></span>
							</span>
							<span class="mdc-notched-outline__trailing"></span>
						</span>
          <input type="text" class="mdc-text-field__input field__input--approve-organization" required>
        </label>
      </div>
      <div class="c-modal__nav">
        <button type="button" class="btn btn-outline-primary" data-iziModal-close><?php _e('Cancel', 'ndp'); ?></button>
        <button class="btn btn_bg_primary btn-approve disabled"><?php _e('Approve', 'ndp'); ?></button>
      </div>
    </form>
  </div>
</div>

<div class="fixed-alert hidden">
  <div class="fixed-alert__text"></div>
  <div class="fixed-alert__close">
    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
              d="M14 1.41L12.59 0L7 5.59L1.41 0L0 1.41L5.59 7L0 12.59L1.41 14L7 8.41L12.59 14L14 12.59L8.41 7L14 1.41Z"
              fill="#F2F0F4"/>
    </svg>
  </div>
</div>

<script>
    var requestsEndpoint = '<?php echo llms_get_endpoint_url( 'requests', '', llms_get_page_url( 'myaccount' ) ); ?>';
</script>