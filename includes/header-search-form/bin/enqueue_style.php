<?php
define('HSF_MODULE_NAME', 'header-search-form');
define('HSF_MODULE_PATH', get_stylesheet_directory_uri() . '/includes/'. HSF_MODULE_NAME . '/asset/css/style.css');

add_action('init', 'register_header_search_form_style');

if (!function_exists('register_header_search_form_style')) {
    function register_header_search_form_style()
    {
        wp_register_style(
            HSF_MODULE_NAME,
            HSF_MODULE_PATH,
            [],
            null
        );
    }
}


add_action('wp_enqueue_scripts', 'enqueue_header_search_form_style');

if (!function_exists('enqueue_header_search_form_style')) {
    function enqueue_header_search_form_style()
    {
        if (!is_admin()) {
            wp_enqueue_style(HSF_MODULE_NAME);
        }
    }
}
