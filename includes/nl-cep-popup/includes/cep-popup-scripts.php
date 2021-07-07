<?php


if (!function_exists('nl_cep_popup_register_scripts')) {
    function nl_cep_popup_register_scripts()
    {
        $ajax_endpoint = CEP_Popup_Configs::get_wp_ajax_endpoint();
        $default_country_code = CEP_Popup_Configs::DEFAULT_COUNTRY_CODE;
        $default_state_code = CEP_Popup_Configs::DEFAULT_STATE_CODE;

        // TODO: think if require to register first and register only is_home() 
        wp_register_script(
            'script-nl-cep-popup',
            get_stylesheet_directory_uri() . '/includes/nl-cep-popup/js/cep-popup-main.js',
            array(),
            null,
            true
        );

        wp_localize_script('script-nl-cep-popup', 'jsDataLake', array(
            "adminAjax" => $ajax_endpoint,
            "countryCode" => $default_country_code,
            "stateCode" => $default_state_code,
        ));

        wp_enqueue_script(
            'script-nl-cep-popup',
        );
    }
}
add_action('wp_enqueue_scripts', 'nl_cep_popup_register_scripts');
