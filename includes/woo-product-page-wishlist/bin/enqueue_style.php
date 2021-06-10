<?php
add_action('enqueue_woo_product_wishlist_style', 'enqueue_woo_product_wishlist_style');
if (!function_exists('enqueue_woo_product_wishlist_style')) {
    function enqueue_woo_product_wishlist_style()
    {
        $style_tag = 'woo-product-page-wishlist';
        $path = '/includes/woo-product-page-wishlist/style.css';
        wp_enqueue_style(
            $style_tag,
            get_stylesheet_directory_uri() . $path,
            array(),
            null,
        );
    }
    do_action('enqueue_woo_product_wishlist_style');
}