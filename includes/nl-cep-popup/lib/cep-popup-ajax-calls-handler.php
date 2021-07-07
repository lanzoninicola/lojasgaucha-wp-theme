<?php

// TODO: manage WP NONCE in AJAX CALL

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

add_action('wp_ajax_shipping_area_validation', 'shipping_area_validation'); // wp_ajax_{ACTION HERE}
add_action('wp_ajax_nopriv_shipping_area_validation', 'shipping_area_validation');




