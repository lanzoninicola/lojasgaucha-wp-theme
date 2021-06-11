<?php
define('MODULE_NAME', 'global-style');

add_action('init', 'register_global_style');

if (!function_exists('register_global_style')) {
    function register_global_style()
    {
        wp_register_style(
            MODULE_NAME,
            get_stylesheet_directory_uri() . '/includes/'. MODULE_NAME . '/style.css',
            [],
            null
        );
    }
}


add_action('wp_enqueue_scripts', 'enqueue_global_style');

if (!function_exists('enqueue_global_style')) {
    function enqueue_global_style()
    {
        
        if (!is_admin()) {
            wp_enqueue_style(MODULE_NAME);
        }
    }
}
