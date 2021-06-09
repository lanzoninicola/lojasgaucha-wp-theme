<?php
add_action('wp_enqueue_custom_product_page_style', 'enqueue_custom_product_page_style');
if (!function_exists('enqueue_custom_product_page_style')) {
    function enqueue_custom_product_page_style()
    {
        $style_tag = 'custom-product-page-style';
        $path = '/css/custom-product-page-style.css';
        wp_enqueue_style(
            $style_tag,
            get_stylesheet_directory_uri() . $path,
            array(),
            null,
        );
    }
    do_action('wp_enqueue_custom_product_page_style');
}
