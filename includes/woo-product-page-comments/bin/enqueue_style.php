<?php
define('WC_P_COMMENTS_MODULE_NAME', 'woo-product-page-comments');
define('WC_P_COMMENTS_MODULE_PATH', get_stylesheet_directory_uri() . '/includes/' . WC_P_COMMENTS_MODULE_NAME . '/style.css');


add_action('init', 'register_woo_product_comments_style');

if (!function_exists('register_woo_product_comments_style')) {
    function register_woo_product_comments_style()
    {
        wp_register_style(
            WC_P_COMMENTS_MODULE_NAME,
            WC_P_COMMENTS_MODULE_PATH,
            [],
            null
        );
    }
}

// This action works only in single product page with the hook "woocommerce_before_single_product"
add_action('woocommerce_before_single_product', 'enqueue_woo_product_comments_style');

if (!function_exists('enqueue_woo_product_comments_style')) {
    function enqueue_woo_product_comments_style()
    {
        wp_enqueue_style(WC_P_COMMENTS_MODULE_NAME);
    }
}
