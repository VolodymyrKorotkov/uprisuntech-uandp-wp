<?php
if (empty($args) && empty($args['represent'])) return;

$represent = $args['represent'];
$user = wp_get_current_user();
$user_id = $user->ID;
$isHead = !empty($args['isHead'])? $args['isHead'] : false;
$municipality_id = $args['municipality_id'];
$representatives = wp_cache_get('representatives_'.$municipality_id);
$invitedNotRegistered = wp_cache_get('invitedNotRegistered_'.$municipality_id);
$existsUser = false;
if ($representatives) {
    $user_email = !empty($represent['user_email'])? $represent['user_email'] : '';
    if (array_search($user_email, array_column($representatives, 'user_email')) !== false) {
        $existsUser = true;//добавлен в муниципалитет
    }
}
$invitedEmail = '';
if (is_array($invitedNotRegistered)) {
    foreach ($invitedNotRegistered as $invited) {
        if (isset($invited['invited_email']) && !empty($invited['invited_email'])) {
            $invitedEmail = $invited['invited_email'];
        }
    }
}
?>


<?php if (!empty($invitedEmail)): ?>
<?php $attr = 'data-invited-email="'.$invitedEmail.'"'; ?>

<?php else : ?>
<?php $attr = 'data-invited-email="'.$represent['user_email'].'"'; ?>
<?php endif; ?>

<?php
    $userName = [];
    if (!empty($represent['first_name'])) {
        array_push($userName, $represent['first_name']);
    }
    if (!empty($represent['last_name'])) {
        array_push($userName, $represent['last_name']);
    }
    if (!empty($represent['middle_name'])) {
        array_push($userName, $represent['middle_name']);
    }
    $userName = join(' ', $userName);
?>

<tr <?php echo $attr; ?>>
    <td class="td-first_name"><?php echo $userName; ?></td>
    <td class="td-position"><?php _e($represent['position'], 'ndp'); ?></td>
    <td class="td-user_email"><?php echo $represent['user_email']; ?></td>
    <td>
        <div class="acc-table__nav">
            <span class="td-phone"><?php echo $represent['llms_phone']; ?></span>
            <button class="acc-table__nav-btn mdc-button" <?php if (!$isHead) echo 'style="opacity:0"'; ?>>
                <svg width="4" height="16" viewBox="0 0 4 16" fill="none"
                     xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M2 4C3.1 4 4 3.1 4 2C4 0.9 3.1 0 2 0C0.9 0 0 0.9 0 2C0 3.1 0.9 4 2 4ZM2 6C0.9 6 0 6.9 0 8C0 9.1 0.9 10 2 10C3.1 10 4 9.1 4 8C4 6.9 3.1 6 2 6ZM0 14C0 12.9 0.9 12 2 12C3.1 12 4 12.9 4 14C4 15.1 3.1 16 2 16C0.9 16 0 15.1 0 14Z"
                          fill="#45464F" />
                </svg>
            </button>
            <?php if ($isHead): ?>
            <div class="mdc-menu-surface--anchor mdc-menu--custom">
                <div class="mdc-menu mdc-menu-surface">
                    <ul class="mdc-list">
                        <li class="mdc-list-item">
                            <a href="#"
                               data-izimodal-open="#modalJob" class="btn-izimodal <?php if (isset($represent['invited']) && $represent['invited']) echo 'invited'; ?>">
                                <?php _e('Change job title', 'ndp'); ?></a>
                        </li>
                        <?php if ($existsUser || !isset($represent['invited'])): ?>
                        <li class="mdc-list-item">
                            <a href="#" data-izimodal-open="#modalRemove" class="btn-izimodal"><?php _e('Remove user', 'ndp'); ?></a>
                        </li>
                        <?php endif; ?>
                        <?php if (isset($represent['invited']) && $represent['invited']): ?>
                        <li class="mdc-list-item">
                            <a href="#" data-izimodal-open="#modalRevoke" class="btn-izimodal <?php if (isset($represent['invited']) && $represent['invited']) echo 'invited'; ?>"><?php _e('Revoke invite', 'ndp'); ?></a>
                        </li>

                            <li class="mdc-list-item">
                                <a href="#" onclick="event.preventDefault(); navigator.clipboard.writeText('https://<?php echo $_SERVER['HTTP_HOST']; ?>/dashboard/?invite=<?php echo $represent['textInvite']; ?>');" class="btn-izimodal <?php if (isset($represent['invited']) && $represent['invited']) echo 'invited'; ?>"><?php _e('Copy invite link', 'ndp'); ?></a>
                            </li>

                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </td>
</tr>