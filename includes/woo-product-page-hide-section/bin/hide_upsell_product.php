<?php
// require_once(FULL_SITE_NAME . '/wp-content/themes/hello-elementor-child/includes/utils/add_script_attribute.php');

define('WC_P_HIDE_SECTION_MODULE_NAME', 'woo-product-page-hide-section');
define('WC_P_HIDE_SECTION_MODULE_PATH', get_stylesheet_directory_uri() . '/includes/' . WC_P_HIDE_SECTION_MODULE_NAME . '/bin/hide_upsell_product.js');

add_action('init', 'register_woo_product_hide_section');

if (!function_exists('register_woo_product_hide_section')) {
    function register_woo_product_hide_section()
    {
        wp_register_script(
            WC_P_HIDE_SECTION_MODULE_NAME,
            WC_P_HIDE_SECTION_MODULE_PATH,
            [],
            null,
            true
        );
    }
}

// This action works only in single product page with the hook "woocommerce_before_single_product"
add_action('woocommerce_after_single_product', 'hide_upsell_products');

if (!function_exists('has_upsell_product')) {
    function has_upsell_product()
    {
        global $product;
        if (is_a($product, 'WC_Product')) {
            return count($product->get_upsell_ids()) == 0 ? false : true;
        }
    }
}


if (!function_exists('hide_upsell_products')) {
    function hide_upsell_products()
    {
        if (!has_upsell_product()) {
            wp_enqueue_script(WC_P_HIDE_SECTION_MODULE_NAME);
        }
    }
}


function add_async_to_script($tag, $handle, $src)
{
    if ($handle === 'woo-product-page-hide-section') {
        if (false === stripos($tag, 'async')) {
            $tag = '<script async="async" type="text/javascript" src="' . $src . '" id="'. $handle .'"></script>';
        }
    }
    return $tag;
}

add_filter('script_loader_tag', 'add_async_to_script', 10, 3);
