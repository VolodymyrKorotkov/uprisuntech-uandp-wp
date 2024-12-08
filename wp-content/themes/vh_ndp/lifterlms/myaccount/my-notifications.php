<?php
/**
 * Student Dashboard: Notifications Tab
 *
 * @since 3.8.0
 * @version 3.30.3
 */

defined( 'ABSPATH' ) || exit;
?>

<?php
llms_get_template(
    'myaccount/dashboard-sidebar.php',
);
?>

<div class="account__content col-8">
    <section class="notifications">
        <nav class="breadcrumb">
            <div class="breadcrumb-block">

                <?php yoast_breadcrumb(); ?>

            </div>
        </nav>
        <div class="notifications__title">
            <h1><?php _e('Notifications', 'ndp'); ?></h1>
            <!-- <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M11.9824 15.7726C11.9074 16.2826 11.4424 16.6876 10.8874 16.6876H8.11243C7.55743 16.6876 7.09243 16.2826 7.02493 15.7351L6.82243 14.3176C6.61993 14.2126 6.42493 14.1001 6.22993 13.9726L4.87993 14.5126C4.35493 14.7076 3.77743 14.4901 3.52243 14.0251L2.14993 11.6476C1.88743 11.1526 1.99993 10.5676 2.41993 10.2376L3.56743 9.34507C3.55993 9.23257 3.55243 9.12007 3.55243 9.00007C3.55243 8.88757 3.55993 8.76757 3.56743 8.65507L2.42743 7.76257C1.98493 7.42507 1.87243 6.81757 2.14993 6.35257L3.53743 3.96007C3.79243 3.49507 4.36993 3.28507 4.87993 3.48757L6.23743 4.03507C6.43243 3.90757 6.62743 3.79507 6.82243 3.69007L7.02493 2.25757C7.09243 1.73257 7.55743 1.32007 8.10493 1.32007H10.8799C11.4349 1.32007 11.8999 1.72507 11.9674 2.27257L12.1699 3.69007C12.3724 3.79507 12.5674 3.90757 12.7624 4.03507L14.1124 3.49507C14.6449 3.30007 15.2224 3.51757 15.4774 3.98257L16.8574 6.36757C17.1274 6.86257 17.0074 7.44757 16.5874 7.77757L15.4474 8.67007C15.4549 8.78257 15.4624 8.89507 15.4624 9.01507C15.4624 9.13507 15.4549 9.24757 15.4474 9.36007L16.5874 10.2526C17.0074 10.5901 17.1274 11.1751 16.8649 11.6476L15.4699 14.0626C15.2149 14.5276 14.6374 14.7376 14.1199 14.5351L12.7699 13.9951C12.5749 14.1226 12.3799 14.2351 12.1849 14.3401L11.9824 15.7726ZM8.46493 15.1876H10.5349L10.8124 13.2751L11.2099 13.1101C11.5399 12.9751 11.8699 12.7801 12.2149 12.5251L12.5524 12.2701L14.3374 12.9901L15.3724 11.1901L13.8499 10.0051L13.9024 9.58507L13.9048 9.56488C13.9265 9.3771 13.9474 9.19556 13.9474 9.00007C13.9474 8.79757 13.9249 8.60257 13.9024 8.41507L13.8499 7.99507L15.3724 6.81007L14.3299 5.01007L12.5374 5.73007L12.1999 5.46757C11.8849 5.22757 11.5474 5.03257 11.2024 4.89007L10.8124 4.72507L10.5349 2.81257H8.46493L8.18743 4.72507L7.78993 4.88257C7.45993 5.02507 7.12993 5.21257 6.78493 5.47507L6.44743 5.72257L4.66243 5.01007L3.61993 6.80257L5.14243 7.98757L5.08993 8.40757C5.06743 8.60257 5.04493 8.80507 5.04493 9.00007C5.04493 9.19507 5.05993 9.39757 5.08993 9.58507L5.14243 10.0051L3.61993 11.1901L4.65493 12.9901L6.44743 12.2701L6.78493 12.5326C7.10743 12.7801 7.42993 12.9676 7.78243 13.1101L8.17993 13.2751L8.46493 15.1876ZM12.1249 9.00007C12.1249 10.4498 10.9497 11.6251 9.49993 11.6251C8.05018 11.6251 6.87493 10.4498 6.87493 9.00007C6.87493 7.55032 8.05018 6.37507 9.49993 6.37507C10.9497 6.37507 12.1249 7.55032 12.1249 9.00007Z" fill="#2A59BD"/>
                </svg>
                <?php _e('Settings', 'ndp'); ?>
            </button> -->
        </div>
        <div class="notifications__block llms-sd-notification-center">
            <?php if ( !empty( $notifications ) ) : ?>
                <?php foreach ( $notifications as $noti ) : ?>
                    <?php echo $noti->get_html(); ?>
                <?php endforeach; ?>

                <?php if (!empty($pagination)): ?>
                    <footer class="llms-sd-pagination llms-my-notifications-pagination">
                        <nav class="llms-pagination">
                            <?php
                            echo paginate_links(
                                array(
                                    'base'      => str_replace( 999999, '%#%', esc_url( get_pagenum_link( 999999 ) ) ),
                                    'format'    => '?page=%#%',
                                    'total'     => $pagination['max'],
                                    'current'   => $pagination['current'],
                                    'prev_next' => true,
                                    'prev_text'    => '<span><i class="arrow arrow-left"></i></span>',
                                    'next_text'    => '<span><i class="arrow arrow-right"></i></span>',
                                    'type'      => 'list',
                                    'custom_pagination' => true,
                                )
                            );
                            ?>
                        </nav>
                    </footer>
                <?php endif; ?>

            <?php elseif ( isset( $settings ) ) : ?>

                <?php foreach ( $settings as $type => $triggers ) : ?>

                    <h4><?php echo apply_filters( 'llms_notification_' . $type . '_title', $type ); ?></h4>
                    <p><?php echo apply_filters( 'llms_notification_' . $type . '_desc', '' ); ?></p>
                    <?php foreach ( $triggers as $id => $data ) : ?>
                        <?php
                        llms_form_field(
                            array(
                                'description' => '',
                                'id'          => $id,
                                'label'       => $data['name'],
                                'last_column' => true,
                                'name'        => 'llms_notification_pref[' . $type . '][' . $id . ']',
                                'selected'    => ( 'yes' === $data['value'] ),
                                'type'        => 'checkbox',
                                'value'       => 'yes',
                            )
                        );
                        ?>
                    <?php endforeach; ?>

                <?php endforeach; ?>
            <?php else: ?>
                <p><?php _e( 'You have no notifications.', 'lifterlms' ); ?></p>
            <?php endif; ?>
        </div>
    </section>
</div>
