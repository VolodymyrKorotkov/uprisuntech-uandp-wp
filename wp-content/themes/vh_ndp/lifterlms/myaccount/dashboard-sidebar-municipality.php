<?php
/**
 * Municipality template part of sidebar
 * используется также в ajax
 */
$endpointSlug  = LLMS_Student_Dashboard::get_current_tab( 'slug' );
?>
<a href="<?php echo llms_get_endpoint_url( 'municipalities', '', llms_get_page_url( 'myaccount' ) ); ?>" class="account__block-nav__item <?php if ($endpointSlug === 'municipalities'): ?> account__block-nav__item-current <?php endif; ?>">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
        <mask id="mask0_3459_11718" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="24"
              height="24">
            <rect width="24" height="24" fill="#D9D9D9"/>
        </mask>
        <g>
            <path d="M5.55 18.9998L2 15.4498L3.4 14.0498L5.525 16.1748L9.775 11.9248L11.175 13.3498L5.55 18.9998ZM5.55 10.9998L2 7.4498L3.4 6.0498L5.525 8.1748L9.775 3.9248L11.175 5.3498L5.55 10.9998ZM13 16.9998V14.9998H22V16.9998H13ZM13 8.9998V6.9998H22V8.9998H13Z"
                  fill="#1C1B1F"/>
        </g>
    </svg>
    <?php _e('Municipality', 'ndp'); ?>
</a>