<?php
/**
 * Plugin Name: Simple Login Custom
 * Description: Custom login form with customizable options.
 * Version: 1.6.0
 * Author: tlloancy
 * Requires at least: 4.0
 * Tested up to: 6.6.2
 * Requires PHP: 7.0
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: simple-login-custom
 * Domain Path: /languages
 */
defined('ABSPATH') || exit;

// Activation hook
register_activation_hook(__FILE__, 'customlogin_plugin_activate');

// Load plugin text domain for translations
function simplelogincustom_load_textdomain() {
    load_plugin_textdomain('simple-login-custom', false, dirname(plugin_basename(__FILE__)) . '/languages/');
}
add_action('plugins_loaded', 'simplelogincustom_load_textdomain');

// Activation function
function customlogin_plugin_activate() {
    // Set default values for styling options
    $default_form_background_color = '#ffffff';
    $default_form_text_color = '#000000';
    $default_link_color = '#0000ff';
    $default_link_underline_style = 'underline';
	$default_login_form_id = 'login-desc';

    // Save default values in WordPress options
    update_option('customlogin_form_background_color', $default_form_background_color);
    update_option('customlogin_form_text_color', $default_form_text_color);
    update_option('customlogin_link_color', $default_link_color);
    update_option('customlogin_link_underline_style', $default_link_underline_style);
	update_option('customlogin_domain', parse_url(home_url(), PHP_URL_HOST));
	update_option('customlogin_desc_id', $default_login_form_id);
}

// Include the other files of the plugin
include_once(plugin_dir_path(__FILE__) . '/admin/includes/settings.php');
include_once(plugin_dir_path(__FILE__) . '/admin/includes/ajax-handler.php');
include_once(plugin_dir_path(__FILE__) . '/public/includes/shortcodes.php');
include_once(plugin_dir_path(__FILE__) . '/public/includes/scripts.php');

// Add a settings page for the plugin
function customlogin_plugin_settings_page() {
    add_options_page(
        esc_html__('Custom Login Plugin Settings', 'simple-login-custom'),
        esc_html__('Custom Login Settings', 'simple-login-custom'),
        'manage_options',
        'custom-login-plugin-settings',
        'customlogin_plugin_settings_page_content'
    );
}
add_action('admin_menu', 'customlogin_plugin_settings_page');

function simple_editor_control_record_login($user_login, $user) {
    $login_data = array(
        'timestamp' => current_time('mysql'),
        'ip' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
        'user' => $user_login
    );

    $logins = get_option('simple_editor_control_logins', array());
    array_unshift($logins, $login_data);
    $logins = array_slice($logins, 0, 10); // Limiter à 10 entrées
    update_option('simple_editor_control_logins', $logins);
}
add_action('wp_login', 'simple_editor_control_record_login', 10, 2);

function get_latest_logins() {
    $logins = get_option('simple_editor_control_logins', array());
    wp_send_json_success(array('logins' => array_slice($logins, 0, 10)));
}
add_action('wp_ajax_get_latest_logins', 'get_latest_logins');
add_action('wp_ajax_nopriv_get_latest_logins', 'get_latest_logins');
