<?php

add_action('enqueue_back_to_the_top', 'enqueue_back_to_the_top_script');

    if (!function_exists('enqueue_back_to_the_top_script')) {
        function enqueue_back_to_the_top_script()
        {

            // TODO: Is it work?
            // $product = new WC_Product( get_the_ID() );
            // echo $product->data; 

            $module_name = 'back-to-the-top';
            $path = '/includes/' . $module_name . '/script.js';

            wp_enqueue_script(
                $module_name,
                get_stylesheet_directory_uri() . $path,
                array(),
                null,
                true 
            );
        }
        do_action('enqueue_back_to_the_top');
    };



