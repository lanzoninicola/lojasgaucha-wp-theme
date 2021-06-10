<?php
//* https://stackoverflow.com/questions/53288621/is-there-a-shortcode-for-product-description-in-woocommerce
function woo_product_description($atts){
    global $product;

    try {
        if( is_a($product, 'WC_Product') ) {
            return wc_format_content( $product->get_description("shortcode") );
        }

        return "Product description shortcode run outside of product context";
    } catch (Exception $e) {
        return "Product description shortcode encountered an exception";
    }
}
add_shortcode( 'woo_product_description', 'woo_product_description' );
