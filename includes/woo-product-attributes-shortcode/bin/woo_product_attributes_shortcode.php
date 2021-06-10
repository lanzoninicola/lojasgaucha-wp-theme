<?php

// TODO: separate logic and view

function woo_product_attributes_shortcode($atts)
{
    global $product;

    // // Shortcode attributes
    // $atts = shortcode_atts(
    //     array(
    //         'attribute'            => '',
    //         'orderby'            => 'name',
    //         'order'                => 'asc',
    //         'hide_empty'        => 1, // must be 1 not true
    //         'show_counts'        => 0, // must be 0 not false
    //         'archive_links'        => 0, // must be 0 not false
    //     ),
    //     $atts,
    //     'wcpas_product_attributes'
    // );

    // Start output
    $output = '<div class="woo-product-attributes-container">';

    if (is_a($product, 'WC_Product')) {
        $attributes = array_filter($product->get_attributes(), 'wc_attributes_array_filter_visible');

        foreach ($attributes as $attribute) {
            $values = array();

            if ($attribute->is_taxonomy()) {// attributes from WC -> Product -> Attributes 
                $attribute_values   = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'all'));

                foreach ($attribute_values as $attribute_value) {
                    $value_name = $attribute_value->name;
                    $values[] = $value_name;
                }
            } else { // Custom product attributes
                $values = $attribute->get_options();
            }

            $attribute_name = ucfirst(wc_attribute_label(sanitize_title_with_dashes($attribute->get_name())));
            $attribute_value = apply_filters('woocommerce_attribute', wptexturize(implode(', ', $values)), $attribute, $values);

            $output .= '<div class="woo-product-attribute">';
            $output .= '<div class="woo-product-attribute-name">' . $attribute_name . '</div>';
            $output .= '<div class="woo-product-attribute-value">' . $attribute_value . '</div>';
            $output .= '</div>';
            $output .= '<div class="woo-product-attribute-divider"></div>';
            
          
        }
    }

    $output .= '</div>';

    return $output;
}

add_shortcode('woo_product_attributes', 'woo_product_attributes_shortcode');





// if (is_plugin_active('woocommerce/woocommerce.php')) { // If WooCommerce is active, works for standalone and multisite network





// 'Product Attributes Shortcode cannot be used as WooCommerce is not active, to use Product Attributes Shortcode activate WooCommerce.', 'wcpas-product-attributes-shortcode'