<?php

require __DIR__ . '/lib/class-cep-popup-configs.php';
$plugin_lib_path = CEP_Popup_Configs::get_plugin_lib_path();
$plugin_includes_path = CEP_Popup_Configs::get_plugin_includes_path();

require $plugin_lib_path . '/class-cep-popup.php';
require $plugin_lib_path . '/class-cep-popup-userstory.php';

require $plugin_includes_path . '/cep-popup-styles.php';
require $plugin_includes_path . '/cep-popup-scripts.php';

require $plugin_lib_path . '/cep-popup-userstories-data.php';


$cep_popup = new CEP_Popup([
    "user_stories_data" => $user_stories_data,
    "configs" => array(
        "first_userstory_name" => CEP_Popup_Configs::first_userstory_name(),
        "last_userstory_name" => CEP_Popup_Configs::last_userstory_name(),
    )
]);

/* ------------------------------------------
// Print out PopUp Content -----------------
--------------------------------------------- */
function nl_cep_popup_print_content($cep_popup, $next_action = false)
{

    $plugin_lib_path = CEP_Popup_Configs::get_plugin_lib_path();
    require $plugin_lib_path . '/cep-popup-userstories-data.php';


    $cep_popup = new CEP_Popup([
        "user_stories_data" => $user_stories_data,
        "configs" => array(
            "first_userstory_name" => CEP_Popup_Configs::first_userstory_name(),
            "last_userstory_name" => CEP_Popup_Configs::last_userstory_name(),
        )
    ]);

?>
    <div id="cep-form-container" class="nl-cep-form-hidden nl-cep-form-overlay">
        <div id="cep-form-wrapper">

            <?php

            try {

                if(!$next_action) {
                    $cep_popup->show_content();
                } else {
                    $cep_popup->next_content();
                }
                
            } catch (\Throwable $th) {
                //throw $th;
                // TODO: redirect to home page or send request
            }

            ?>

        </div>
        <div id="cep-form-notice"></div>
    </div>
<?php
}

add_action('adding_cep_popup', 'nl_cep_popup_print_content', 100, 2);


function boo() {
    $plugin_lib_path = CEP_Popup_Configs::get_plugin_lib_path();
    require $plugin_lib_path . '/cep-popup-userstories-data.php';

    $cep_popup = new CEP_Popup([
        "user_stories_data" => $user_stories_data,
        "configs" => array(
            "first_userstory_name" => CEP_Popup_Configs::first_userstory_name(),
            "last_userstory_name" => CEP_Popup_Configs::last_userstory_name(),
        )
    ]);


    do_action('adding_cep_popup', $cep_popup);
}

add_action("wp_head", "boo", 100);


function foo(){
  
    remove_action("adding_cep_popup", "nl_cep_popup_print_content");


}

add_action('foo', 'foo', 100);


include $plugin_includes_path . "/cep-popup-scripts-bootstrap.php";
include $plugin_lib_path . "/cep-popup-ajax-calls-handler.php";
