<?php
add_action('wp_enqueue_global_style', 'enqueue_global_style');

if (!function_exists('enqueue_global_style')) {
    function enqueue_global_style()
    {
        $module_name = 'global-style';
        $path = '/includes/' . $module_name . '/style.css';
        $version = wp_get_theme()->get('Version');

        if (!is_admin()) {
            wp_enqueue_style(
                $module_name,
                get_stylesheet_directory_uri() . $path,
                array(),
                $version,
            );
        }
    }
    do_action('wp_enqueue_global_style');
}
