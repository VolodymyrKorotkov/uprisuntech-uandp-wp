<?php
/*
Plugin Name: Create custom tables
Description: migrations and REST route
*/


function create_the_custom_tables() {
    global $wpdb;

    $charset_collate = $wpdb->get_charset_collate();
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

    /**
     * Таблица number_of_views для подсчёта количества просмотров
     * entity_type - posts, taxonomy
     * type_id - post_id, term_id
     */
    $table_name = $wpdb->prefix . 'number_of_views';

    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
	id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
	entity_type VARCHAR(50) NOT NULL,
	type_id INT NOT NULL,
	views INT DEFAULT 0
    ) $charset_collate";

    dbDelta($sql);
    /////////////////////////////


    /**
     * Сохранение вопросов и фильтров
     * wizard_filter table
     */
    $table_name = $wpdb->prefix . 'wizard_filter';

    $sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
	id int(10) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	question_uk VARCHAR(255) NOT NULL,
	question_en VARCHAR(255) NOT NULL,
	question_de VARCHAR(255) NOT NULL,
	category TINYINT NOT NULL,
	filters_uk TEXT NOT NULL,
	filters_en TEXT NOT NULL,
	filters_de TEXT NOT NULL
    ) {$charset_collate}";

    dbDelta($sql);
    /////////////////////////////



    ////////////////////////////////////////////////////////////////////
    //////////////////////////  MUNICIPALITY  //////////////////////////
    ////////////////////////////////////////////////////////////////////


$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}municipalities (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
    `name` VARCHAR(255) NOT NULL,
    `edr` INT NOT NULL,
    `head_user` bigint UNSIGNED NOT NULL,
    `date` DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `name` (`name`),
    CONSTRAINT {$wpdb->prefix}municipalities_head_user_foreign FOREIGN KEY (`head_user`) REFERENCES {$wpdb->prefix}users(`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) {$charset_collate};";
    dbDelta($sql);

$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}users_job_title (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
    `lang_code` VARCHAR(255) NOT NULL DEFAULT '',
    `text` TEXT NOT NULL DEFAULT '',
    `position` VARCHAR(255) NOT NULL,
    PRIMARY KEY (`id`),
    KEY `position` (`position`)
) {$charset_collate};";
    dbDelta($sql);

    $table = $wpdb->prefix . 'users_job_title';

    $sql = "SELECT * FROM {$table} WHERE `position`='Head of municipality'";
    if (!$wpdb->get_results($sql)) {
        $data = [
            'position' => 'Head of municipality',
        ];
        $result = $wpdb->insert($table, $data);
    }
    $sql = "SELECT * FROM {$table} WHERE `position`='Senior energy safety specialist'";
    if (!$wpdb->get_results($sql)) {
        $data = [
            'position' => 'Senior energy safety specialist',
        ];
        $result = $wpdb->insert($table, $data);
    }
    $sql = "SELECT * FROM {$table} WHERE `position`='Manager'";
    if (!$wpdb->get_results($sql)) {
        $data = [
            'position' => 'Manager',
        ];
        $result = $wpdb->insert($table, $data);
    }


$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}users_of_municipality (
	`user_id` bigint UNSIGNED NOT NULL,
	`municipality_id` bigint UNSIGNED NOT NULL,
	`position_id` bigint UNSIGNED NOT NULL,
	CONSTRAINT {$wpdb->prefix}users_of_municipality_user_id_foreign FOREIGN KEY (`user_id`) REFERENCES {$wpdb->prefix}users(`ID`) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT {$wpdb->prefix}users_of_municipality_municipality_id_foreign FOREIGN KEY (`municipality_id`) REFERENCES {$wpdb->prefix}municipalities(`id`) ON DELETE CASCADE ON UPDATE CASCADE,
	CONSTRAINT {$wpdb->prefix}users_of_municipality_position_foreign FOREIGN KEY (`position_id`) REFERENCES {$wpdb->prefix}users_job_title(`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) {$charset_collate};";
    dbDelta($sql);

/**
 * status 'Await processing', 'Approved', 'Rejected', 'Cancelled'
 */
$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}municipality_requests (
	`id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
	`status` VARCHAR(55) NOT NULL DEFAULT 'Await processing',
	`received` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`due_to` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`type` VARCHAR(55) NOT NULL,
	`assigned` VARCHAR(255) NOT NULL DEFAULT '',
    `user_id` bigint UNSIGNED NOT NULL,
	`operator_id` bigint UNSIGNED DEFAULT NULL,
	PRIMARY KEY (`id`),
	KEY `status` (`status`),
	KEY `received` (`received`),
	KEY `due_to` (`due_to`),
	KEY `type` (`type`),
	KEY `user_id` (`user_id`),
	KEY `operator_id` (`operator_id`)
) {$charset_collate};";
    dbDelta($sql);


$sql = "CREATE TABLE {$wpdb->prefix}applications (
    id mediumint(9) NOT NULL AUTO_INCREMENT,
    date_added datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    amount float DEFAULT NULL,
    status varchar(55) DEFAULT '' NOT NULL,
    email varchar(55) DEFAULT '' NOT NULL,
    apply_info text DEFAULT NULL,
    apply_engineer text DEFAULT NULL,
    feedback text DEFAULT NULL,
    created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    updated_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    status_updated_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
    user_id mediumint(9) DEFAULT NULL,
  PRIMARY KEY  (`id`)
) {$charset_collate};";

    maybe_create_table( $wpdb->prefix . 'applications', $sql );

    $db = DB_NAME;
    $table = $wpdb->prefix . 'applications';
    $sql = "ALTER TABLE `{$table}`
    ADD `ipn` INT NOT NULL;";

    $checkSql = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='{$db}' AND TABLE_NAME='{$table}' AND COLUMN_NAME='ipn'";
    if (!$wpdb->query( $checkSql )) {
        $query_result = $wpdb->query( $sql );
    }

$sql = "ALTER TABLE `{$table}`
    ADD `municipality_id` bigint UNSIGNED DEFAULT NULL;";
    $checkSql = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='{$db}' AND TABLE_NAME='{$table}' AND COLUMN_NAME='municipality_id'";
    if (!$wpdb->query( $checkSql )) {
        $query_result = $wpdb->query( $sql );
    }

$sql = "ALTER TABLE `{$table}`
    ADD CONSTRAINT {$wpdb->prefix}applications_municipality_id_foreign FOREIGN KEY (`municipality_id`) REFERENCES {$wpdb->prefix}municipalities(`id`) ON DELETE SET NULL ON UPDATE CASCADE;";
    $query_result = $wpdb->query( $sql );


    $table = $wpdb->prefix . 'users';
$sql = "ALTER TABLE `{$table}`
    ADD `dia_verify` INT NOT NULL;";
    $query_result = $wpdb->query( $sql );
$sql = "ALTER TABLE `{$table}`
    ADD `dia_refresh_token` VARCHAR(255) NOT NULL;";
    $query_result = $wpdb->query( $sql );

/**
 * text - произвольные данные, для приглашения сюда записывается uuid
 * data - произвольные данные, для приглашения сюда записывается массив с email, edrpou_code, $job
 */
$sql = "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}municipality_events (
    `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
    `text` TEXT NOT NULL DEFAULT '',
    `data` TEXT NOT NULL DEFAULT '',
    `from_email` varchar(55) NOT NULL,
    `to_email` varchar(55) NOT NULL DEFAULT '',
    `eventType` VARCHAR(55) NOT NULL,
    `date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `from_email` (`from_email`)
) {$charset_collate};";
    dbDelta($sql);


    $table = $wpdb->prefix . 'municipality_requests';

    $sql = "ALTER TABLE `{$table}`
    ADD `last_change` DATETIME DEFAULT '0000-00-00 00:00:00';";

    $checkSql = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='{$db}' AND TABLE_NAME='{$table}' AND COLUMN_NAME='last_change'";
    if (!$wpdb->query( $checkSql )) {
        $query_result = $wpdb->query( $sql );
    }

    $table = $wpdb->prefix . 'municipality_requests';
    $sql = "ALTER TABLE `{$table}`
    ADD `email` varchar(55) DEFAULT '' NOT NULL";

    $checkSql = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='{$db}' AND TABLE_NAME='{$table}' AND COLUMN_NAME='email'";
    if (!$wpdb->query( $checkSql )) {
        $query_result = $wpdb->query( $sql );
    }

    $table = $wpdb->prefix . 'users_of_municipality';
    $sql = "ALTER TABLE `{$table}`
    ADD `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST";

    $checkSql = "SELECT column_name FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='{$db}' AND TABLE_NAME='{$table}' AND COLUMN_NAME='id'";
    if (!$wpdb->query( $checkSql )) {
        $query_result = $wpdb->query( $sql );
    }

    $table = $wpdb->prefix . 'applications';
    $sql = "ALTER TABLE `{$table}`
    DROP FOREIGN KEY {$wpdb->prefix}applications_municipality_id_foreign;";
    $query_result = $wpdb->query( $sql );


    ////////////////////////////////////////////////////////////////////
    //////////////////////////  MUNICIPALITY  //////////////////////////
    ////////////////////////////////////////////////////////////////////


    addNewRoles();
}

function addNewRoles() {
    add_role( 'operator', __('Operator'),
        [
            'edit_requests' => true,
            'read_requests' => true,
            'reject_requests' => true,
            'delete_requests' => true,
            'switch_municipality' => true,
            'send_message' => true,
            'read' => true,
        ]
    );
    add_role( 'engineer', __('Engineer'),
        [
            'edit_requests' => true,
            'read_requests' => true,
            'reject_requests' => true,
            'delete_requests' => true,
            'switch_municipality' => false,
            'send_message' => false,
            'read' => true,
        ]);
}

register_activation_hook(__FILE__, 'create_the_custom_tables');


/**
 * REST route
 *
$url = 'http://ndp.loc/wp-json/municipality/v1/requests';
$url = 'http://ndp.loc/wp-json/municipality/v1/add_user';
//регистрация юзера в таблице wp_users
$post_data = [
'user_login' => 'logintest',
'user_email' => 'student5@gmail.com',
'user_pass'  => 'Student5gmail.com',
'first_name' => 'first_name',
'nickname'   => 'nickname',
];
//добавление данных в таблицу wp_municipality_requests
//$post_data = [
//    'type' => 'Registration',
//    'user_id' => 4,
//];

$post_string = json_encode($post_data);// make json string of post data

$ch = curl_init();   //curl initialisation
curl_setopt($ch, CURLOPT_URL, $url); // add url
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // get return value
curl_setopt($ch, CURLOPT_POST, true); // false for GET request
curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string); // add post data
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
'Content-Type: application/json',
'Content-Length: ' . strlen($post_string))
);// add header
$output = curl_exec($ch);
curl_close($ch); // close curl
$error = curl_error($ch); // get error
 */
add_action('rest_api_init', function () {
    register_rest_route('municipality/v1', '/add_user',
        [
            'methods'  => 'POST',
            'callback' => 'municipality_rest_add_user',
        ],
    );
    register_rest_route('municipality/v1', '/requests',
        [
            'methods'  => 'POST',
            'callback' => 'municipality_rest_add_request',
            'permission_callback' => 'municipality_rest_permission_callback_requests'
        ],
    );
});

function municipality_rest_add_user(WP_REST_Request $request) {

    $login = $request->get_param('user_login');
    $email = $request->get_param('user_email');
    $pass = $request->get_param('user_pass');
    $first_name = $request->get_param('first_name');
    $nickname = $request->get_param('nickname');

    $userdata = [
        'user_login' => $login,
        'user_email' => $email,
        'user_pass'  => $pass,
        'first_name' => $first_name,
        'nickname'   => $nickname,
    ];

    $user_id = wp_insert_user( $userdata ) ;

    if( ! is_wp_error( $user_id ) ){
        return new WP_REST_Response(array('success' => true, 'user_id' => $user_id), 200);
    }
    else {
        return $user_id->get_error_message();
    }
}

function municipality_rest_add_request(WP_REST_Request $request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'municipality_requests';

    $due_to = $request->get_param('due_to') ?? '';
    $assigned = $request->get_param('assigned') ?? '';
    $type = $request->get_param('type');
    $user_id = $request->get_param('user_id');
    $errors = new WP_Error();

    $user = get_userdata( $user_id );
    if ( $user === false ) {
        $errors->add( 'user_insert_error', __( 'Failed to insert user' ) );
    }

    $result = $wpdb->insert(
        $table_name,
        array(
            'received' => date("Y-m-d H:i:s"),
            'due_to' => $due_to,
            'type' => $type,
            'assigned' => $assigned,
            'user_id' => $user_id,
        ),
        array('%s', '%s', '%s', '%s', '%s', '%d')
    );

    if ($result !== false) {
        return new WP_REST_Response(array('success' => true, 'request_id' => $wpdb->insert_id), 200);
    } else {
        $errors->add( 'db_insert_error', __( 'Failed to insert data to the table' ), array('status' => 500) );
    }
    if ($errors->has_errors()) {
        return $errors;
    }
}
function municipality_rest_permission_callback_requests ( WP_REST_Request $request ) {
//    return current_user_can( 'edit_others_posts' );
    return true;
}
