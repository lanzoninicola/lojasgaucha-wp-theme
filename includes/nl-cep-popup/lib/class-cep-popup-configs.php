<?php

class CEP_Popup_Configs
{
    const PLUGIN_FOLDERNAME = "nl-cep-popup";

    const SHOW_POPUP_TIMEOUT = 1000; // time in seconds

    const DEFAULT_COUNTRY = 'Brazil';

    const DEFAULT_STATE = 'Paraná';

    const DEFAULT_COUNTRY_CODE = "BR";

    const DEFAULT_STATE_CODE = "PR";

    public static function get_plugin_root_path(){
        return get_stylesheet_directory() . '/includes/' . self::PLUGIN_FOLDERNAME;
    }

    public static function get_plugin_lib_path(){
        return self::get_plugin_root_path() . '/lib';
    }

    public static function get_plugin_includes_path(){
        return self::get_plugin_root_path() . '/includes';
    }

    public static function get_userstories_config()
    {
        return array(
            "starting_point" => "start",
            "ending_point" => "end"
        );
    }

    public static function first_userstory_name()
    {
        return self::get_userstories_config()["starting_point"];
    }


    public static function last_userstory_name()
    {
        return self::get_userstories_config()["ending_point"];
    }


    public static function get_wp_ajax_endpoint()
    {
        global $wp;
        return home_url($wp->request) . '/wp-admin/admin-ajax.php';
    }
}
