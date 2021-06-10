<?php

// add_action('wp_enqueue_custom_product_attributes_style', 'enqueue_custom_product_attributes_style');
// if (!function_exists('enqueue_custom_product_attributes_style')) {
//      function enqueue_custom_product_attributes_style()
//     {
//         $style_tag = 'custom_product_attributes';
//         $path = '/css/custom-product-attributes-style.css';
//         wp_enqueue_style(
//             $style_tag,
//             get_stylesheet_directory_uri() . $path,
//             array(),
//             null,
//         );
//     }
//     do_action('wp_enqueue_custom_product_attributes_style');
// }

// if (is_plugin_active('woocommerce/woocommerce.php')) { // If WooCommerce is active, works for standalone and multisite network

function wc_custom_product_related($atts)
{
    global $product;

    // Start output
    $output = '<div class="wc-custom-product-attributes-container">';

    if (is_a($product, 'WC_Product')) {
        $product = wc_get_product(get_the_id());

        	$args = array(
			'posts_per_page' => 4,
			'columns'        => 4,
			'orderby'        => 'rand', // @codingStandardsIgnoreLine.
		);

		$foo = woocommerce_related_products( apply_filters( 'woocommerce_output_related_products_args', $args ) );

        echo $foo;
    }

    $output .= '</div>';

    return $output;
}

add_shortcode('wc_custom_product_related', 'wc_custom_product_related');



// 'Product Attributes Shortcode cannot be used as WooCommerce is not active, to use Product Attributes Shortcode activate WooCommerce.', 'wcpas-product-attributes-shortcode'



