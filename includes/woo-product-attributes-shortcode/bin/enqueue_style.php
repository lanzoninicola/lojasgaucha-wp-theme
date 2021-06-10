<?php

add_action('enqueue_woo_product_attributes_style', 'enqueue_product_attributes_style');
if (!function_exists('enqueue_product_attributes_style')) {
    function enqueue_product_attributes_style()
    {
        $module_name = 'woo-product-attributes-shortcode';
        $path = '/includes/' . $module_name . '/style.css';
        
        wp_enqueue_style(
            $module_name,
            get_stylesheet_directory_uri() . $path,
            array(),
            null,
        );
    }
    do_action('enqueue_woo_product_attributes_style');
};
