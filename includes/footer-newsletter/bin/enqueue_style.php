<?php
define('FN_MODULE_NAME', 'footer-newsletter');
define('FN_MODULE_PATH', get_stylesheet_directory_uri() . '/includes/'. FN_MODULE_NAME . '/asset/css/style.css');

add_action('init', 'register_footer_newsletter_style');

if (!function_exists('register_footer_newsletter_style')) {
    function register_footer_newsletter_style()
    {
        wp_register_style(
            FN_MODULE_NAME,
            FN_MODULE_PATH,
            [],
            null
        );
    }
}


add_action('wp_enqueue_scripts', 'enqueue_footer_newsletter_style');

if (!function_exists('enqueue_footer_newsletter_style')) {
    function enqueue_footer_newsletter_style()
    {
        if (!is_admin()) {
            wp_enqueue_style(FN_MODULE_NAME);
        }
    }
}
