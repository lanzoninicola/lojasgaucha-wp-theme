<?php
add_action('wp_enqueue_custom_global_style', 'enqueue_custom_global_style');
if (!function_exists('enqueue_custom_global_style')) {
    function enqueue_custom_global_style()
    {
        $style_tag = 'custom-global-style';
        $path = '/css/custom-global-style.css';
        wp_enqueue_style(
            $style_tag,
            get_stylesheet_directory_uri() . $path,
            array(),
            null,
        );
    }
    do_action('wp_enqueue_custom_global_style');
}
