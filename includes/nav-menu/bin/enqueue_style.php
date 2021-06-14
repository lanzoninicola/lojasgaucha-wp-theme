<?php
define('NM_MODULE_NAME', 'nav-menu');
define('NM_MODULE_PATH', get_stylesheet_directory_uri() . '/includes/'. NM_MODULE_NAME . '/asset/css/style.css');

add_action('init', 'register_navmenu_style');

if (!function_exists('register_navmenu_style')) {
    function register_navmenu_style()
    {
        wp_register_style(
            NM_MODULE_NAME,
            NM_MODULE_PATH,
            [],
            null
        );
    }
}


add_action('wp_enqueue_scripts', 'enqueue_navmenu_style');

if (!function_exists('enqueue_navmenu_style')) {
    function enqueue_navmenu_style()
    {
        if (!is_admin()) {
            wp_enqueue_style(NM_MODULE_NAME);
        }
    }
}
