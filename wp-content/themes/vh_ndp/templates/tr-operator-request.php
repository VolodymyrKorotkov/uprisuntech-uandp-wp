<?php
if (empty($args) && empty($args['request'])) return;

$request = $args['request'];
$request->received = date("d.m.y", strtotime($request->received));
$request->due_to = date("d.m.y", strtotime($request->due_to));
?>

<tr class="tr-request-data" data-status="<?php echo $request->status; ?>">
  <td class="blue-color semi">№<?php echo $request->id; ?></td>
  <td>
    <div class="c-label">
        <?php
        $colorClass = 'c-label__item--gold';
        if ($request->status == 'Approved') {
            $colorClass = 'c-label__item--green';
        } elseif ($request->status == 'Rejected') {
            $colorClass = 'c-label__item--red';
        }
        ?>
      <div class="c-label__item <?php echo $colorClass; ?>"><?php echo mb_ucfirst(__($request->status, 'ndp')); ?></div>
    </div>
  </td>
  <td class="date_added-time"><?php echo $request->received; ?></td>
    <?php /* echo $request->due_to; */ ?>
  <td><?php _e($request->type, 'ndp'); ?></td>
  <td><span><?php _e($request->assigned, 'ndp'); ?></span></td>
  <td>
    <div class="acc-table__nav">
      <a href="<?php echo llms_get_endpoint_url('requests', '', llms_get_page_url('myaccount')); ?>?id=<?php echo $request->id; ?>"
         class="acc-table__nav-btn">
        <svg width="8" height="12" viewBox="0 0 8 12"
             fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
                  d="M5.05001 6L0.325012 1.275L1.60001 0L7.60001 6L1.60001 12L0.325012 10.725L5.05001 6Z"
                  fill="black"/>
        </svg>
      </a>
    </div>
  </td>
</tr>