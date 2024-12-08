<?php

//Begin Really Simple SSL session cookie settings
@ini_set('session.cookie_httponly', true);
@ini_set('session.cookie_secure', true);
@ini_set('session.use_only_cookies', true);
//END Really Simple SSL cookie settings

define( 'ITSEC_ENCRYPTION_KEY', 'IUJ3YndOTU9+LzVbKl1YMzRuKjVhOnRSPiZTTHJpLTZAV3FaeSQ+WVJyMT18X2QhLWUwWFtZb05VanlrfCEqTw==' );

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */
define('FS_METHOD', 'direct');
// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', $_ENV['WORDPRESS_DB_NAME'] );

/** Database username */
define( 'DB_USER', $_ENV['WORDPRESS_DB_USER'] );

/** Database password */
define( 'DB_PASSWORD', $_ENV['WORDPRESS_DB_PASSWORD'] );

/** Database hostname */
define( 'DB_HOST', $_ENV['WORDPRESS_DB_HOST'] );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'jt=UWx63Y[m 58c^F`~T,b,,O}x!yXXz@NuG*aj2OwQ.~zaqRc|Hmjk~[1h<XNoj' );
define( 'SECURE_AUTH_KEY',  '8)$~p4U.NnjZ!Qs~N*k0pzu,kgn_zWBS# A!5%+[-z/c([d)-bTk#Dp6VrAnRQy^' );
define( 'LOGGED_IN_KEY',    '4HHVlHcU,=fE;{P!xoNMRo[E[p_k@]|oaR/qC{3^$OKI%0;mJ^v&d!4hMak0n$Au' );
define( 'NONCE_KEY',        'Ftl%rv>LinKSLsq4FX#pnq~m[/N{[Yw|&^ESyGfO$KPpz~|na$gKB(++Z,19{rB,' );
define( 'AUTH_SALT',        'vJ43zHHA^Y.$cu!$MeTMKZB/EprH~t(i~$[@gSqSBn/|EvlU^^r;)RdbIma(#i-~' );
define( 'SECURE_AUTH_SALT', '.#dUT586?$&!H@fieRh8%$F!gN|kO5s}B93d{ij`;1IKJDToFkXYL@:IW|PI1Jw ' );
define( 'LOGGED_IN_SALT',   'Z|#k$tPP~FG<sC:u~z`+>!ctlLdhCiQE3BbdoD|.Kc)= ZwExwvv#01?;!V^N[Lc' );
define( 'NONCE_SALT',       'F&)d)9%#@:/DJ=J7bEH>Fab&iZx,Y,2=34/ncG!=-{[Hcp)3n0nSw0)F^B}ACYy ' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );
ini_set('display_errors','Off');
ini_set('error_reporting', E_ALL );
define('WP_DEBUG', false);
define('WP_DEBUG_DISPLAY', false);

/* Add any custom values between this line and the "stop editing" line. */
define( 'WP_MEMORY_LIMIT', '512M' );


define( 'WP_SITEURL', $_ENV['WORDPRESS_URL'] );
define( 'WP_HOME', $_ENV['WORDPRESS_URL'].'/' );
/* That's all, stop editing! Happy publishing. */

$_ENV["PRODUCTION_ENV"] = true;
$_ENV["STAGING_ENV"] = false;

if ($_SERVER['HTTP_HOST'] != 'uandp.com.ua') {
    $_ENV["PRODUCTION_ENV"] = false;
}
define('PRODUCTION_ENV', $_ENV["PRODUCTION_ENV"]);
if ($_SERVER['HTTP_HOST'] == 'staging-ndp.netvision.pro') {
    $_ENV["STAGING_ENV"] = true;
}
define('STAGING_ENV', $_ENV["STAGING_ENV"]);

define('GOV_UA_URL', $_ENV['OAUTH_URL']."/oauth/".$_ENV['API_OAUTH_CLIENT_ID']."/login");
define('GOV_UA_REFRESH_TOKEN', $_ENV['API_URL'].'/api/v1/auth/refresh-token');
define('GOV_UA_AUTH_TOKEN', $_ENV['API_URL'].'/api/v1/auth/token');
define('GOV_UA_USERS_PROFILE', $_ENV['API_URL'].'/api/v1/users/profile');
define('GOV_UA_USERS_DELETE', $_ENV['API_URL'].'/api/v1/user/delete');


/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', dirname(__FILE__) . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';

//Begin Really Simple SSL Server variable fix

//END Really Simple SSL