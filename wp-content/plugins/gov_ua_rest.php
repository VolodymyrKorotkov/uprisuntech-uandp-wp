<?php
/**
 * Plugin Name: WP User Creation and Authentication API
 */

add_action('rest_api_init', function () {
    register_rest_route('user-api/v1', '/create-or-authenticate', array(
        'methods' => 'POST',
        'callback' => 'create_or_authenticate_wp_user',
    ));
});

function create_or_authenticate_wp_user($request) {
    $email = $request->get_param('email');
    $uuid = $request->get_param('uuid');

    if (email_exists($email)) {
        // Аутентификация существующего пользователя
        $user = get_user_by('email', $email);
        authenticate_user($user);
        return rest_ensure_response(['message' => 'User authenticated', 'user_id' => $user->ID]);
    } else {
        // Создание нового пользователя
        $password = wp_generate_password();
        $user_id = wp_create_user($email, $password, $email);

        if (is_wp_error($user_id)) {
            return $user_id;
        }

        wp_update_user([
            'ID' => $user_id,
            'first_name' => 'Default',
            'last_name' => 'Default'
        ]);

        update_user_meta($user_id, 'uuid', $uuid);

        // Аутентификация только что созданного пользователя
        $user = get_user_by('id', $user_id);
        authenticate_user($user);
        return rest_ensure_response(['message' => 'User created and authenticated', 'user_id' => $user_id]);
    }
}

function authenticate_user($user) {
    wp_clear_auth_cookie();
    wp_set_current_user($user->ID);
    wp_set_auth_cookie($user->ID);
}
?>
