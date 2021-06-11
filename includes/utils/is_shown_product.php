<?php

add_action('woocommerce_before_single_product', 'is_shown_product');

if (!function_exists('is_shown_product')) {
    function is_shown_product()
    {
        return is_product() ? true : false;
    }
}
