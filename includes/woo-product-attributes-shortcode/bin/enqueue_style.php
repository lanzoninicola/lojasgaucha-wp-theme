<?php

// add_action('enqueue_woo_product_attributes_style', 'enqueue_product_attributes_style');
// if (!function_exists('enqueue_product_attributes_style')) {
//     function enqueue_product_attributes_style()
//     {
//         $module_name = 'woo-product-attributes-shortcode';
//         $path = '/includes/' . $module_name . '/style.css';
        
//         wp_enqueue_style(
//             $module_name,
//             get_stylesheet_directory_uri() . $path,
//             array(),
//             null,
//         );
//     }
//     do_action('enqueue_woo_product_attributes_style');
// };



define('WC_P_PRODUCT_ATTRIBUTES_MODULE_NAME', 'woo-product-attributes-shortcode');
define('WC_P_PRODUCT_ATTRIBUTES_MODULE_PATH', get_stylesheet_directory_uri() . '/includes/' . WC_P_PRODUCT_ATTRIBUTES_MODULE_NAME . '/style.css');


add_action('init', 'register_woo_product_attributes_style');

if (!function_exists('register_woo_product_attributes_style')) {
    function register_woo_product_attributes_style()
    {
        wp_register_style(
            WC_P_PRODUCT_ATTRIBUTES_MODULE_NAME,
            WC_P_PRODUCT_ATTRIBUTES_MODULE_PATH,
            [],
            null
        );
    }
}

// This action works only in single product page with the hook "woocommerce_before_single_product"
add_action('woocommerce_before_single_product', 'enqueue_woo_product_attributes_style');

if (!function_exists('enqueue_woo_product_attributes_style')) {
    function enqueue_woo_product_attributes_style()
    {
        wp_enqueue_style(WC_P_PRODUCT_ATTRIBUTES_MODULE_NAME);
    }
}