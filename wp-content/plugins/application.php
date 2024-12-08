<?php
/**
 * Plugin Name: Application Plugin
 * Description: A simple plugin to create a table and add a REST route.
 * Version: 1.0
 * Author: Maxim Kondaurov
 */

// Activation hook to create the table
register_activation_hook(__FILE__, 'create_applications');
function create_applications() {
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
    $table_name = $wpdb->prefix . 'applications';

    $sql = "CREATE TABLE $table_name (
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
        PRIMARY KEY  (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

// Deactivation hook to drop the table
register_deactivation_hook(__FILE__, 'drop_applications');
function drop_applications() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'applications';
    $wpdb->query("DROP TABLE IF EXISTS $table_name");
}

// Add REST route
add_action('rest_api_init', function () {
    register_rest_route('application/v1', '/add_entry', array(
        'methods' => 'POST',
        'callback' => 'add_entry_to_table',
    ));
    register_rest_route('application/v1', '/get_entry/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_entry_from_table',
        'permission_callback' => function () {
            return is_user_logged_in();
        }
    ));
//    Видалити з прода
    register_rest_route('application/v1', '/get_entry_debug/(?P<id>\d+)', array(
        'methods' => 'GET',
        'callback' => 'get_entry_debug',
    ));
    register_rest_route('application/v1', '/update_entry/(?P<id>\d+)', array(
        'methods' => 'POST',
        'callback' => 'update_entry_in_table',
    ));
});

function get_entry_from_table(WP_REST_Request $request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'applications';
    $users_of_municipality_table = $wpdb->prefix . 'users_of_municipality';
    $municipalities_table = $wpdb->prefix . 'municipalities';
    $user_id = get_current_user_id();
    $id = $request->get_param('id');

    $current_user = wp_get_current_user();
    $municipality = $wpdb->get_row($wpdb->prepare("SELECT * FROM $municipalities_table WHERE head_user = %d", $user_id), ARRAY_A);

    if ($municipality) {
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id);
    } else if (in_array('engineer', $current_user->roles)) {
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id);
    } else {
        $user_municipality = $wpdb->get_row($wpdb->prepare("SELECT * FROM $users_of_municipality_table WHERE user_id = %d", $user_id), ARRAY_A);

        if ($user_municipality) {
            $municipality_id_of_application = $wpdb->get_var($wpdb->prepare("SELECT municipality_id FROM $table_name WHERE id = %d", $id));

            if ($municipality_id_of_application != $user_municipality['municipality_id']) {
                // Пользователь больше не принадлежит к муниципалитету заявки
                return new WP_Error('access_denied', 'User does not belong to the municipality of this application', array('status' => 404));
            }

            $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d AND municipality_id = %d", $id, $user_municipality['municipality_id']);
        } else {
            $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d AND user_id = %d", $id, $user_id);
        }
    }

    $entry = $wpdb->get_row($query, ARRAY_A);

    if ($entry) {
        return new WP_REST_Response($entry, 200);
    } else {
        return new WP_Error('no_entry', 'Entry not found', array('status' => 404));
    }
}




function get_entry_debug(WP_REST_Request $request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'applications';
    $id = $request->get_param('id');

    $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $id);
    $entry = $wpdb->get_row($query, ARRAY_A);

    if ($entry) {
        return new WP_REST_Response($entry, 200);
    } else {
        return new WP_Error('no_entry', 'Entry not found', array('status' => 404));
    }
}


function update_entry_in_table(WP_REST_Request $request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'applications';




    if($request->get_param('municipality_id') == null){
        $municipality_id=0;
    }else{
        $data['municipality_id']=$request->get_param('municipality_id');
    }


    $id = $request->get_param('id');

    $current_time = current_time('mysql'); // Текущее время
    $data = array(

        'date_added' => $current_time,
        'amount' => $request->get_param('amount'),
        'status' => $request->get_param('status'),
        'email' => $request->get_param('email'),
        'apply_info' => json_encode($request->get_param('apply_info')),
        'apply_engineer' => json_encode($request->get_param('apply_engineer')),
        'feedback' => json_encode($request->get_param('feedback')),
        'updated_at' =>  date('Y-m-d H:i:s'),
        'user_id' => $request->get_param('user_id'),
        'currency_code' => $request->get_param('currency_code') !== null ? $request->get_param('currency_code') : "UAH",

    );
    if($request->get_param('municipality_id') == null){
        $municipality_id=0;
    }else{
        $data['municipality_id']=$request->get_param('municipality_id');
    }

    // Update the status_updated_at field if status is changed
    if (isset($data['status'])) {
        $data['status_updated_at'] = current_time('mysql');
    }

    $result = $wpdb->update(
        $table_name,
        $data,
        array('id' => $id),
        array('%s', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%d'),
        array('%d')
    );

    if ($result !== false) {

        $current_application= get_application_data_from_external_api($id);

        if($current_application['status'] !== $request->get_param('status')){
            $user = get_user_by( "id", $request->get_param('user_id'));
            $userName=$user->first_name." ".$user->last_name;
            $message = PrepareEmailMessage($userName,$id,$request->get_param('status'),$_COOKIE['wp-wpml_current_language']);
            ChangeStatusApplicationNotify($user->user_email,__('Status change for application number ','ndp').$id,$message,$current_application['municipality_id']);
        }


        return new WP_REST_Response(array('success' => true), 200);
    } else {
        return new WP_Error('db_update_error', 'Failed to update the data in the table', array('status' => 500));
    }
}

function add_entry_to_table(WP_REST_Request $request) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'applications';
    date_default_timezone_set("Europe/Kiev");

    $date_added = $request->get_param('date_added');
    $amount = $request->get_param('amount');
    $status = $request->get_param('status');
    $email = $request->get_param('email');
    $apply_info = $request->get_param('apply_info');
    $apply_engineer = $request->get_param('apply_engineer');
    $feedback = $request->get_param('feedback');
    $user_id = $request->get_param('user_id');
//    $current_time = current_time('mysql'); // Текущее время
    $current_time = date("Y-m-d H:i:s"); // Текущее время


    $data =array(
        'date_added' => $current_time,
        'amount' => $amount,
        'status' => $status,
        'email' => $email,
        'apply_info' => json_encode($apply_info),
        'apply_engineer' => json_encode($apply_engineer),
        'feedback' => json_encode($feedback),
        'created_at' => $current_time,
        'updated_at' => $current_time,
        'status_updated_at' => $request->get_param('status_updated_at'),
        'user_id' => $user_id
    );
    $placeholder = array('%s', '%f', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d');

    if($request->get_param('municipality_id') == null){
        $data['municipality_id']=0;
    }else{
        $data['municipality_id']=$request->get_param('municipality_id');
        array_push($placeholder, "%d");
    }




    $result = $wpdb->insert(
        $table_name,
        $data,
        $placeholder
    );

    if ($result !== false) {

        $id=  $wpdb->insert_id;
        $user = get_user_by( "id", $request->get_param('user_id'));
        $userName=$user->first_name." ".$user->last_name;
        $message = PrepareEmailMessage($userName,$id,$request->get_param('status'),$_COOKIE['wp-wpml_current_language']);
        ChangeStatusApplicationNotify($user->user_email,__('Status change for application number ','ndp').$id,$message, $data['municipality_id']);



        return new WP_REST_Response(array('success' => true), 200);
    } else {
        return new WP_Error('db_insert_error', 'Failed to insert data to the table', array('status' => 500));
    }
}

add_action( 'rest_api_init', function () {
    register_rest_route( 'application/v1', '/woocommerce-terms/', array(
        'methods' => 'GET',
        'callback' => 'get_woocommerce_terms',
    ) );
});

function get_woocommerce_terms( $data ) {
    global $wpdb;
    $default_language = 'en'; // Замените на ваш язык по умолчанию
    $language = isset( $data['lang'] ) ? $data['lang'] : $default_language;



    $attributes = $wpdb->get_results( "SELECT 
    t.*, 
    tt.taxonomy, 
    tt.description, 
    wat.attribute_id, 
    tml.language_code
FROM 
    wp_terms AS t
    INNER JOIN wp_term_taxonomy AS tt ON t.term_id = tt.term_id
    INNER JOIN wp_woocommerce_attribute_taxonomies AS wat ON SUBSTRING(tt.taxonomy, 4) = wat.attribute_name
    LEFT JOIN wp_icl_translations AS tml ON tt.term_taxonomy_id = tml.element_id AND tml.element_type LIKE 'tax_%'
WHERE 
    tt.taxonomy LIKE 'pa_%' 
    AND (tml.language_code = '${language}' OR tml.language_code IS NULL);" );

    if ( empty( $attributes ) ) {
        return new WP_Error( 'no_attributes', 'No attributes found', array( 'status' => 404 ) );
    }

    return new WP_REST_Response( $attributes, 200 );
}



function PrepareEmailMessage($userName, $applicationId, $newStatus, $language = 'en') {
    // Определение содержимого сообщения на английском языке
    $subject = "Change of application status $applicationId";
    $greeting = "Hello, $userName";
    $body = "The status of your application #$applicationId has been changed";
    $detailsLink = "To view details, please go to your account.";
    $signature = "Regards,<br>UANDP Team<br><a href=\"https://uandp.com.ua\">https://uandp.com.ua</a>";

    // Переключение на украинский язык, если указан 'ua'
    if ($language === 'uk') {
        $subject = "Зміна статусу заявки $applicationId";
        $greeting = "Вітаємо, $userName";
        $body = "Статус вашої заявки №$applicationId змінено";
        $detailsLink = "Для перегляду деталей перейдіть за посиланням в Особистий кабінет.";
        $signature = "З повагою,<br>Команда UANDP<br><a href=\"https://uandp.com.ua\">https://uandp.com.ua</a>";
    }

    // Формирование HTML-сообщения
    $message = "<html><body>";
    $message .= "<h1>$greeting</h1>";
    $message .= "<p>$body</p>";
    $message .= "<p>$detailsLink</p>";
    $message .= "$signature";
    $message .= "</body></html>";

    return $message;
}
function ChangeStatusApplicationNotify($to, $subject, $message, $municipality_id = 0) {
    global $wpdb;

    // Устанавливаем тип содержимого письма в HTML
    $headers = array('Content-Type: text/html; charset=UTF-8');

    // Инициализация массива email'ов для отправки
    $emails = array($to);

    // Действия, если указан municipality_id
    if ($municipality_id > 0) {
        // Получаем список пользователей, связанных с муниципалитетом
        $user_ids = $wpdb->get_col($wpdb->prepare("SELECT user_id FROM wp_users_of_municipality WHERE municipality_id = %d", $municipality_id));

        // Получаем email каждого пользователя и добавляем в массив $emails
        foreach ($user_ids as $user_id) {
            $user_info = get_userdata($user_id);
            if ($user_info && $user_info->user_email) {
                $emails[] = $user_info->user_email;
            }
        }

        // Получаем head_user из таблицы wp_municipalities
        $head_user_email = $wpdb->get_var($wpdb->prepare("SELECT user_email FROM wp_users INNER JOIN wp_municipalities ON wp_users.ID = wp_municipalities.head_user WHERE wp_municipalities.id = %d", $municipality_id));

        // Если email руководителя муниципалитета найден, добавляем его в массив
        if ($head_user_email) {
            $emails[] = $head_user_email;
        }
    }

    // Удаляем дубликаты email'ов
    $emails = array_unique($emails);

    // Отправляем письмо каждому получателю из массива $emails
    $all_sent = true;
    foreach ($emails as $email) {
        if (!wp_mail($email, $subject, $message, $headers)) {
            $all_sent = false; // Если отправка хотя бы одного письма не удалась, флаг в false
        }
    }

    return $all_sent; // Возвращаем true, если все письма отправлены, иначе false
}
function get_application_data_from_external_api( $entry_id ) {
    // Получаем имя хоста из текущего запроса.
    $host_name = $_SERVER['HTTP_HOST'];

    // Формируем URL с использованием динамического хоста.
    $request_url = 'https://' . $host_name . '/wp-json/application/v1/get_entry/' . $entry_id;

    // Отправляем GET-запрос к внешнему API.
    $response = wp_remote_get( $request_url );

    // Проверяем на наличие ошибок.
    if ( is_wp_error( $response ) ) {
        // Обработка ошибки.
        error_log( 'Ошибка при получении данных: ' . $response->get_error_message() );
        return null;
    }

    // Получаем тело ответа и декодируем его из JSON.
    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );

    if ( json_last_error() !== JSON_ERROR_NONE ) {
        // Обработка ошибки декодирования JSON.
        error_log( 'Ошибка декодирования JSON: ' . json_last_error_msg() );
        return null;
    }

    // Возвращаем данные.
    return $data;
}
?>
