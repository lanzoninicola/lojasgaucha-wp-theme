<?php

// TODO: set brand colors to wrapper form (background, text etc...)
// TODO: set brand font to wrapper form
// TODO: manage css versioning

/* ------------------------------------------
// Enqueue JS & CSS -------------------------------
--------------------------------------------- */
if (!function_exists('nl_cep_popup_popup_style')) {
    function nl_cep_popup_popup_style()
    {
        wp_enqueue_style(
            'css-nl-cep-popup',
            get_stylesheet_directory_uri() . '/includes/nl-cep-popup/css/cep-popup-style.css',
            array(),
            null
        );
    }
}
add_action('wp_enqueue_scripts', 'nl_cep_popup_popup_style');