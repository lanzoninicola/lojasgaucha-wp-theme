<?php
define('GS_MODULE_NAME', 'global-style');
define('GS_MODULE_PATH', get_stylesheet_directory_uri() . '/includes/'. GS_MODULE_NAME . '/style.css');

add_action('init', 'register_global_style');

if (!function_exists('register_global_style')) {
    function register_global_style()
    {
        wp_register_style(
            GS_MODULE_NAME,
            GS_MODULE_PATH,
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
            wp_enqueue_style(GS_MODULE_NAME);
        }
    }
}
