"# NDP-WP" 

<h2 align="center">Install</h2>

Generating a certificate via cerbot and set env variables ()
```shell
sh ./docker/install_ssl.sh
```

Set env vars (example .env.example). Add database dump (.docker_data/backup/dump.sql). 
Then run install script

```shell
sh ./install.sh
```

<h2 align="center">Шорткод галереи</h2>

## Пример использования

```php
[my_extended_gallery gallery_title="Gallery example (dots)" gallery_id="174" gallery="field_64ef6e3effe22"]  
[my_extended_gallery gallery_title="Gallery example (dots)" images="174,175,176"]
```

* gallery_id - custom post type
* gallery - acf field
* images - image id

Инициализация шорткода в файле
wp-content/themes/vh_ndp/inc/template-functions.php

```php
add_shortcode('my_extended_gallery', 'my_extended_gallery_shortcode');
```

Шаблон галереи находится в файле wp-content/themes/vh_ndp/template-parts/gallery_shortcode_template.php


## Роуты для регистрации муниципалитета

```php
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
```