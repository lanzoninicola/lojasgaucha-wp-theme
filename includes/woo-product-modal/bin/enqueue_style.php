<?php

//TODO: draft

if (!function_exists('enqueue_woo_product_modal')) {
    function enqueue_woo_product_modal()
    {
        $module_name = 'woo-product-modal';
        $path = '/includes/' . $module_name . '/style.css';

        wp_enqueue_style(
            $style_tag,
            get_stylesheet_directory_uri() . $path,
            array(),
            null,
        );
    }
    do_action('enqueue_woo_product_modal');
}


add_action('enqueue_woo_product_modal', 'enqueue_woo_product_modal');
