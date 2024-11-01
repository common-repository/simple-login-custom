<?php
defined ('ABSPATH') || exit;
// Ajouter les scripts du plugin
function customlogin_add_scripts() {
    // Ajouter le fichier CSS
    wp_enqueue_style('custom-login-style', plugin_dir_url(__FILE__) . '../css/custom-login.css');
    wp_enqueue_script('custom-login-script', plugin_dir_url(__FILE__) . '../js/login-register.js');
	
	// Générer un nonce et le passer au script JavaScript
      wp_localize_script('custom-login-script', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('custom_register_nonce'),
    ));
	//$nonce = wp_create_nonce('custom-register-nonce');
//wp_localize_script('custom-login-script', 'yourNonceObject', array('nonce' => $nonce));
}

// Hook pour ajouter les scripts
add_action('wp_enqueue_scripts', 'customlogin_add_scripts');

// Inclure le fichier AJAX handler
function include_ajax_handler() {
    //include_once get_template_directory() . '/public/includes/ajax-handler.php';
    //include_once plugin_dir_url(__FILE__) . 'ajax-handler.php';
    include_once plugin_dir_path( __FILE__ ) . 'ajax-handler.php';
}
add_action('init', 'include_ajax_handler');
