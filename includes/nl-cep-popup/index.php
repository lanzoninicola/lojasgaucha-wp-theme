<?php
// TODO: ask for email when the user shipping-zone is available
// TODO: create check to cep shortcode to add to site (option adding class for styling)

// TODO: cep-popup-main.js - manage response from server
// TODO: cep-popup-main.js - managing errors (send to external services)

require __DIR__ . '/lib/class-cep-popup-configs.php';
$plugin_lib_path = CEP_Popup_Configs::get_plugin_lib_path();
$plugin_includes_path = CEP_Popup_Configs::get_plugin_includes_path();

require $plugin_includes_path . '/cep-popup-styles.php';
require $plugin_includes_path . '/cep-popup-scripts.php';


/* ------------------------------------------
// Print out PopUp Content -----------------
--------------------------------------------- */
function nl_cep_popup_print_content()
{

    if (is_front_page() or is_shop()) :
?>

        <div id="cep-popup-container" class="cep-popup-overlay cep-popup-flex-center cep-popup-hidden ">
            <div id="cep-popup-wrapper" class="cep-popup-flex-center">

                <?php
                $plugin_views_path = CEP_Popup_Configs::get_plugin_views_path();

                include $plugin_views_path . '/view-cep-popup-welcome.php';
                include $plugin_views_path . '/view-cep-popup-check-cep.php';
                include $plugin_views_path . '/view-cep-popup-check-cep-success.php';
                include $plugin_views_path . '/view-cep-popup-check-cep-failed.php';
                ?>
                <div id="cep-popup-notice">NOTICE NOTICE NOTICE</div>
                <?php
                include $plugin_views_path . '/components/link-donot-remind-me.php';
                ?>

            </div>

        </div>

<?php
    endif;
}

add_action('wp_head', 'nl_cep_popup_print_content', 100, 2);

include $plugin_lib_path . "/cep-popup-ajax-calls-handler.php";
