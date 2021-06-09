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


require_once(__DIR__ . '/includes/custom-global-style.php');

require_once(__DIR__ . '/includes/custom-product-description-shortcode.php');

require_once(__DIR__ . '/includes/custom-product-page-style.php');

// $isproduct = is_product();
// echo $isproduct ? "true" : "false";
// echo is_a($product, 'WC_Product') ? "true" : "false";

// if (is_a($product, 'WC_Product')) {
//     require_once(__DIR__ . '/includes/custom-product-page-style.php');
// }
