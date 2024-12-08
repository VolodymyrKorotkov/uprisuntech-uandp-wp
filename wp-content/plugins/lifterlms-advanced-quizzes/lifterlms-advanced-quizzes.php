<?php
/**
 * LifterLMS Advanced Quizzes Main Plugin File
 *
 * @package LifterLMS_Advanced_Quizzes/Main
 *
 * @since 1.0.0
 * @version 2.0.0
 *
 * Plugin Name: LifterLMS Advanced Quizzes
 * Plugin URI: https://lifterlms.com/product/advanced-quizzes
 * Description: Add advanced question types like essays, uploads, and more to LifterLMS quizzes
 * Version: 3.2.0
 * Author: LifterLMS
 * Author URI: https://lifterlms.com/
 * Text Domain: lifterlms-advanced-quizzes
 * Domain Path: /i18n
 * License: GPLv3
 * License URI: https://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least: 5.6
 * Tested up to: 6.3
 * Requires PHP: 7.4
 * LLMS requires at least: 7.4.0-alpha
 * LLMS tested up to: 7.4.0
 *
 * * * * * * * * * * * * * * * * * * * * * *
 *                                         *
 * Reporting a Security Vulnerability      *
 *                                         *
 * Please disclose any security issues or  *
 * vulnerabilities to team@lifterlms.com   *
 *                                         *
 * See our full Security Policy at         *
 * https://lifterlms.com/security          *
 *                                         *
 * * * * * * * * * * * * * * * * * * * * * *
 */

defined( 'ABSPATH' ) || exit;

if ( ! defined( 'LLMS_ADVANCED_QUIZZES_PLUGIN_FILE' ) ) {
	define( 'LLMS_ADVANCED_QUIZZES_PLUGIN_FILE', __FILE__ );
}

if ( ! defined( 'LLMS_ADVANCED_QUIZZES_PLUGIN_DIR' ) ) {
	define( 'LLMS_ADVANCED_QUIZZES_PLUGIN_DIR', dirname( __FILE__ ) . '/' );
}

if ( ! defined( 'LLMS_ADVANCED_QUIZZES_PLUGIN_URL' ) ) {
	define( 'LLMS_ADVANCED_QUIZZES_PLUGIN_URL', trailingslashit( plugin_dir_url( __FILE__ ) ) );
}

// Load plugin.
if ( ! class_exists( 'LifterLMS_Advanced_Quizzes' ) ) {
	require_once LLMS_ADVANCED_QUIZZES_PLUGIN_DIR . 'class-lifterlms-advanced-quizzes.php';
}

/**
 * Retrieve the main plugin instance
 *
 * @since 1.1.0
 *
 * @return LifterLMS_Advanced_Quizzes
 */
function llms_aq() {
	return LifterLMS_Advanced_Quizzes::instance();
}

return llms_aq();
