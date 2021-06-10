<?php
add_action('wp_enqueue_product_reviews_style', 'enqueue_product_reviews_style');
if (!function_exists('enqueue_product_reviews_style')) {
    function enqueue_product_reviews_style()
    {
        $module_name = 'woo-product-reviews';
        $path = '/includes/' . $module_name . '/style.css';

         if (!is_admin()) {
            wp_enqueue_style(
                $module_name,
                get_stylesheet_directory_uri() . $path,
                array(),
                null,
            );
        }
    }
    do_action('wp_enqueue_product_reviews_style');
}
