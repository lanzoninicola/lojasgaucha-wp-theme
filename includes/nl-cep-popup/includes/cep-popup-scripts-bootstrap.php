<?php

/* ------------------------------------------
// Print out  JS ----------------------------
--------------------------------------------- */
function nl_cep_popup_print_script()
{
    $show_popup_timeout = CEP_Popup_Configs::SHOW_POPUP_TIMEOUT;

    echo '
<script async>
(
    function() {
        function showPopUpNode(){
            const cepFormNode = document.getElementById("cep-form-container");
            if(cepFormNode) {
                cepFormNode.classList.remove("nl-cep-form-hidden");
                cepFormNode.classList.add("nl-cep-form-show");
            }
        }

        setTimeout(showPopUpNode, ' . $show_popup_timeout . ');
    }
 )();
</script>
';
}
add_action('wp_footer', 'nl_cep_popup_print_script', 100);