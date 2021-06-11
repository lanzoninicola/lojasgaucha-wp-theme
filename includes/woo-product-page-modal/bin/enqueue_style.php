<?php
define('PM_MODULE_NAME', 'woo-product-page-modal');
define('PM_MODULE_PATH', get_stylesheet_directory_uri() . '/includes/'. PM_MODULE_NAME . '/style.css');

add_action('init', 'register_product_page_modal');

if (!function_exists('register_product_page_modal')) {
    function register_product_page_modal()
    {
        wp_register_style(
            PM_MODULE_NAME,
            PM_MODULE_PATH,
            [],
            null
        );
    }
}


add_action('woocommerce_before_single_product', 'enqueue_product_page_modal');

if (!function_exists('enqueue_product_page_modal')) {
    function enqueue_product_page_modal()
    {
        if (!is_admin()) {
            wp_enqueue_style(PM_MODULE_NAME);
        }
    }
}
