<?php

// TODO: separate logic and view

function woo_product_modal_shortcode($atts)
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
    $output = '<div class="modal-container">';
    $output .= '<h1>Hello Shortcode</h1>';

 

    if (is_a($product, 'WC_Product')) {
       
    }

    $output .= '</div>';

    return $output;
}

add_shortcode('woo_product_modal', 'woo_product_modal_shortcode');