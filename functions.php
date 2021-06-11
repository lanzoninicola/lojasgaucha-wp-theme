<?php
add_action('wp_enqueue_scripts', 'enqueue_parent_theme_style');
function enqueue_parent_theme_style()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}



// if ( ! function_exists( 'register_custom_elementor_styles' ) ) {
//     function register_custom_elementor_styles() {
//         wp_register_style( 'remove-elementor-p-margins', get_template_directory_uri() . '/style1.css' );
//         wp_register_style( 'style2', get_template_directory_uri() . '/style2.css' );
//         wp_register_style( 'style3', get_template_directory_uri() . '/style3.css' );
//     }
// }


// require_once(__DIR__ . '/includes/disable-woocommerce-scripts.php');

require_once(__DIR__ . '/includes/global-style/index.php');

require_once(__DIR__ . '/includes/woo-product-description-shortcode/index.php');

require_once(__DIR__ . '/includes/woo-product-attributes-shortcode/index.php');

require_once(__DIR__ . '/includes/woo-product-related-shortcode/index.php');

require_once(__DIR__ . '/includes/woo-product-page-wishlist/index.php');

require_once(__DIR__ . '/includes/woo-product-reviews/index.php');

require_once(__DIR__ . '/includes/back-to-the-top/index.php');

