<?php
// require_once(__DIR__ . '/config.php');

add_action('wp_enqueue_scripts', 'enqueue_parent_theme_style');

function enqueue_parent_theme_style()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}



require_once(__DIR__ . '/includes/trww-archive-product/index.php');

// require_once(__DIR__ . '/includes/nl-cep-popup/index.php');


/*


// require_once(__DIR__ . '/includes/disable-woocommerce-scripts.php');

require_once(__DIR__ . '/includes/global-style/index.php');

require_once(__DIR__ . '/includes/nav-menu/index.php');

require_once(__DIR__ . '/includes/header-search-form/index.php');

require_once(__DIR__ . '/includes/woo-product-description-shortcode/index.php');

require_once(__DIR__ . '/includes/woo-product-attributes-shortcode/index.php');

require_once(__DIR__ . '/includes/woo-product-related-shortcode/index.php');

require_once(__DIR__ . '/includes/woo-product-page-wishlist/index.php');

require_once(__DIR__ . '/includes/woo-product-page-comments/index.php');

// require_once(__DIR__ . '/includes/back-to-the-top/index.php');

require_once(__DIR__ . '/includes/woo-product-page-hide-section/index.php');

// require_once(__DIR__ . '/includes/woo-product-page-modal/index.php');

require_once(__DIR__ . '/includes/woo-product-page-product-related/index.php');

*/