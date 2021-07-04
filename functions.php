<?php
// require_once(__DIR__ . '/config.php');

add_action('wp_enqueue_scripts', 'enqueue_parent_theme_style');

function enqueue_parent_theme_style()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}


// TODO: manage WP NONCE in AJAX CALL
add_action('wp_ajax_shipping_area_validation', 'shipping_area_validation'); // wp_ajax_{ACTION HERE}
add_action('wp_ajax_nopriv_shipping_area_validation', 'shipping_area_validation');
function shipping_area_validation()
{
    $requestFrom = $_POST["request_id"];

    if ($requestFrom === "cep-form") {
        $package = array(
            'destination' => array(
                'country'  => $_POST["country"],
                'state'    => $_POST["state"],
                'postcode' => $_POST["postcode"]
            ),
        );

        $country          = strtoupper(wc_clean($package['destination']['country']));
        $state            = strtoupper(wc_clean($package['destination']['state']));
        $postcode         = wc_normalize_postcode(wc_clean($package['destination']['postcode']));

        // $cache_key        = WC_Cache_Helper::get_cache_prefix( 'shipping_zones' ) . 'wc_shipping_zone_' . md5( sprintf( '%s+%s+%s', $country, $state, $postcode ) );
        // $matching_zone_id = wp_cache_get( $cache_key, 'shipping_zones' );

        $matching_zone_id = false;

        if (false === $matching_zone_id) {
            $data_store       = WC_Data_Store::load('shipping-zone');
            $matching_zone_id = $data_store->get_zone_id_from_package($package);
            // wp_cache_set( $cache_key, $matching_zone_id, 'shipping_zones' );
        }

        $result = array(
            'country_requested' => $country,
            'state_requested' => $state,
            'postcode_requested' => $postcode,
            'result' => $matching_zone_id ? true : false,
        );

        wp_send_json_success($result);
    }

    die();
}

// TODO: shortcode should manage favorite Country code and State Code
function woo_cep_form($atts)
{
    global $wp;
    define("WP_ADMIN_AJAX", home_url($wp->request) . '/wp-admin/admin-ajax.php');

    define("BRASILE", "Brazil");
    define("BRAZIL_CC", "BR"); // Country code
    define("PARANA_SC", "PR"); // State code

    // get list of countries
    // $woo_countries_data_store = WC()->countries;
    // $countries = $woo_countries_data_store->countries;

    // Get list of states
    $statesCode = WC()->countries->states[BRAZIL_CC];

    // Start output
    $output = '<div class="woo-cep-form-container">';

    // List of states
    $output .= '<label for="cep-form-states">Select a country:</label>';
    $output .= '<select name="cep-form-states" id="cep-form-states">';
    foreach ($statesCode as $key => $value) {
        $selected = $key === PARANA_SC ? 'selected' : ''; 
        $output .= "<option value=$key $selected>$value</option>";
    }
    $output .= '</select>';

    // TODO: input inputmode="numeric" not supported by Firefox23+ Safari
    // CEP
    $output .= '<label for="cep-user">CEP</label>';
    $output .= '<input type="input" inputmode="numeric" name="cep-user" id="cep-form-usercep-input" placeholder="CEP" required maxlength="8"></input>';

    // $output .= '<input type="hidden" name="action" value="shipping_area_validation">';

    // CEP Submit
    $output .= '<button id="cep-form-submit">Avançar</button>';

    // CEP Notification
    $output .= '<div id="cep-form-notice"/></div>';

    // TODO: manage response from server
    // TODO: managing errors (send to external services)
    $output .= '<script type="text/javascript">
    const cepUserState = document.getElementById("cep-form-states");
    if(cepUserState) {
        cepUserState.addEventListener("change", e => {
            cepUserState.value = e.target.value;
        });
    }
    
    const cepUserInput = document.getElementById("cep-form-usercep-input");
    if(cepUserInput) {
        cepUserInput.addEventListener("onchange", e => {
            cepUserInput.value = e.target.value;
        });
    }

    const cepFormSubmitButton = document.getElementById("cep-form-submit");
    if(cepFormSubmitButton) {
        cepFormSubmitButton.addEventListener("click", (e) => {
      
        if(cepUserInput.value > 0) {
            setLoadingState({status: "pending"});

            const body = new URLSearchParams({
                action: "shipping_area_validation",
                request_id: "cep-form",
                field: "cep-form-countries",
                country: "' . BRAZIL_CC . '",
                state: cepUserState.value,
                postcode: cepUserInput.value,
            })

            fetch("' . WP_ADMIN_AJAX . '" , {
                method: "POST",
                credentials: "same-origin",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
                    "Cache-Control": "no-cache",
                },
                body: body
              
            }).then(res => {
                setLoadingState({status: "success"});
                return res.json();
            })
            .then(res => {
                console.log(res)
                
            })
            .catch(err => {
                setLoadingState({status: "error"});
                console.log(err);
            });
        }
        })
    };


    function setLoadingState({status = "pending"}){
            if(status === "pending"){
                setNotice({message: "Loading...."});
            }
            
            if(status === "success"){
                setNotice({message: ""});
            }

            if(status === "rejected"){
                setNotice({message: "Some error occured"});
            }
    }

    function setNotice({message = ""}){
        const cepFormNotice = document.getElementById("cep-form-notice"); 

        if(cepFormNotice) {
           cepFormNotice.innerText = message;
        }
    }
    
    </script>
    ';







    /*
    // Country dropdown
    $output .='<label for="cep-form-countries">Select a country:</label>';
    $output .= '<select name="cep-form-countries" id="cep-form-countries">';
    foreach ($countries as $country) {
        $selected = $country === BRASILE ? 'selected' : ''; 
        $output .= "<option value='$country' $selected>$country</option>";
      }
    $output .= '</select>';

    // Country eventListner
    $output .= '<script type="text/javascript">
    
    const cepCountry = document.getElementById("cep-form-countries");
    cepCountry.addEventListener("change", (e) => {
      console.log(e.target.value);
   
      fetch("' . $url . '?action=shipping_area_validation" , {
        method: "POST",
        headers: {
            "Content-Type": "application/x-www-form-urlencoded;charset=UTF-8",
          },
        body: JSON.stringify({
            "request_id": "cep-form",
            "field": "cep-form-countries",
            "value": e.target.value
        })
      }).then(res => console.log(res.ok));
    });
    
    </script>
    ';


    // WC()->countries->get_states( $country )
    */

    $output .= '</div>';



    return $output;
}

add_shortcode('woo_cep_form', 'woo_cep_form');








/*


// require_once(__DIR__ . '/includes/disable-woocommerce-scripts.php');

require_once(__DIR__ . '/includes/global-style/index.php');

require_once(__DIR__ . '/includes/nav-menu/index.php');

require_once(__DIR__ . '/includes/header-search-form/index.php');

require_once(__DIR__ . '/includes/woo-product-description-shortcode/index.php');

require_once(__DIR__ . '/includes/woo-product-attributes-shortcode/index.php');

require_once(__DIR__ . '/includes/woo-product-related-shortcode/index.php');

require_once(__DIR__ . '/includes/woo-product-page-wishlist/index.php');

require_once(__DIR__ . '/includes/woo-product-page-comments/index.php');

// require_once(__DIR__ . '/includes/back-to-the-top/index.php');

require_once(__DIR__ . '/includes/woo-product-page-hide-section/index.php');

// require_once(__DIR__ . '/includes/woo-product-page-modal/index.php');

require_once(__DIR__ . '/includes/woo-product-page-product-related/index.php');

*/