<?php

function trww_woocommerce_ajax_add_to_cart_js()
{
    wp_enqueue_script(
        'trww_add_to_cart',
        get_stylesheet_directory_uri() . '/includes/trww-archive-product/assets/js/ajax_add_to_cart.js',
        array('wc-add-to-cart'),
        '1.0',
        true
    );

    wp_enqueue_style(
        'trww_product_archive',
        get_stylesheet_directory_uri() . '/includes/trww-archive-product/assets/css/style.css',
        array(),
        '1.0'
    );
}
add_action('wp_enqueue_scripts', 'trww_woocommerce_ajax_add_to_cart_js');


function trww_product_archive()
{

    // TODO: check requirements, check below

    /**
     *      Woocommerce plugin enabled
     *          WC_Product_Simple class exists
     *          
     *      ACF plugin enabled
     *          ACF field with name "ui_archive_product_category" exists
     *      
     *      YITH bundle plugin exists and enabled
     *          WC_Product_Yith_Bundle class exists
     */

    $acf_field_name = 'ui_archive_product_category';

    global $wpdb;
    $product_categories = $wpdb->get_results("
                    SELECT distinct
                        t.term_id as id,
                        t.name,
                        t.slug
                        FROM (SELECT meta_key, meta_value FROM wp_postmeta WHERE meta_key = '" . $acf_field_name . "') pm_ui
                        INNER JOIN wp_terms t on (t.term_id = pm_ui.meta_value
                                                                and t.slug <> 'uncategorized'
                                                                and pm_ui.meta_key = '" . $acf_field_name . "'
                                                                );
                    ");

    $output = "";

    $output .= "<div id='trww-product-archive'>";

    $product_categories_count = count($product_categories);

    if ($product_categories_count > 0) {

        foreach ($product_categories as $product_category) {

            // $product_category_term = get_term($product_category->id);
            // $product_category_link = get_term_link($product_category_term);

            $output .= "<div class='trww-category-card' data-category-id='$product_category->id'>";


            // category inner start
            $output .= "<div class='trww-category-inner-card'>";
            // category thumbnail - start
            $product_category_thumbnail_id = get_term_meta($product_category->id, 'thumbnail_id', true);
            $product_category_thumbnail = wp_get_attachment_url($product_category_thumbnail_id);
            $output .= "<div class='trww-category-inner-image'>
                            <img src='" . $product_category_thumbnail . "' width='80px' alt loading='lazy' />
                        </div>";
            // category thumbnail - end


            // category content - start
            $output .= "<div class='trww-category-content'>";

            $output .= "<div class='trww-category-name'>" . $product_category->name . "</div>";

            // category info custom fields - start
            $output .= "<div class='trww-category-info'>";

            $product_category_abv = get_term_meta($product_category->id, 'abv', true);
            if ($product_category_abv) {
                $output .= "<div class='category-info-details'>";
                $output .= "<div>ABV</div>";
                $output .= "<div>" . $product_category_abv . "</div>";
                $output .= "</div>";
            }

            $product_category_ibu = get_term_meta($product_category->id, 'ibu', true);
            if ($product_category_ibu) {
                $output .= "<div class='category-info-details'>";
                $output .= "<div>IBU</div>";
                $output .= "<div>" . $product_category_ibu . "</div>";
                $output .= "</div>";
            }

            $output .= "</div>";
            // category info custom field - end

            $output .= "<div class='product-category-explode' data-category-id=" . $product_category->id . ">VEJA</div>";

            $output .= "</div>";
            // category content - end

            $output .= "</div>";
            // category inner - end


            $products = $wpdb->get_results("
                     SELECT 
                         p.ID as id,
                         p.post_title as name,
                         p.post_content as description,
                         pm_product.meta_value as product_category_id
                     FROM wp_posts p
                     INNER JOIN wp_postmeta pm_product on (p.ID = pm_product.post_id
                                                                         and pm_product.meta_key = '" . $acf_field_name . "')
                     WHERE 1=1
                     AND p.post_type = 'product'
                     AND p.post_status = 'publish'
                     AND pm_product.meta_value = '" . $product_category->id . "'
                 ");

            $product_counts = count($products);

            if ($product_counts > 0) {

                $output .= "<ul class='reset' data-product-count='" . $product_counts . "'>";

                foreach ($products as $product) {

                    // Adding validation used in "add_to_cart()" WC function
                    // It will elige a product to be added in the cart
                    // It excludes product like type "External/Affiliate product"
                    $product_data = wc_get_product($product->id);

                    // Adding extra validation:
                    // product must be an object type "WC_Product_Simple" and "WC_Product_Yith_Bundle"
                    $product_data_type = get_class($product_data);
                    $allowed_product_data_types = array('WC_Product_Simple', 'WC_Product_Yith_Bundle');

                    $product_is_valid =  count(array_intersect($allowed_product_data_types, array($product_data_type))) > 0 ? true : false;

                    /**
                     *  Managing user notices - end
                     */

                    if ($product_data && $product_is_valid) {

                        $output .= "<li class='trww-product trww-hidden'>";

                        // Product image
                        $product_url_image = "";

                        if (has_post_thumbnail($product->id)) {
                            $img = wp_get_attachment_image_src(get_post_thumbnail_id($product->id), '300');
                            // returns an array, the first item is the image URL
                            // var_dump($img[0]); die;
                            $product_url_image = $img[0];
                        }

                        $woo_placeholder_image = wc_placeholder_img_src();
                        // var_dump($product_url_image);

                        $product_url_image = $product_url_image == "" ? $woo_placeholder_image : $product_url_image;

                        $output .= "<img src='" . $product_url_image . "' width='150' height='150' alt loading='lazy' />";


                        // Product name
                        $output .= "<a href='" . get_permalink(intval($product->id)) . "'>" . $product->name . "</a>";


                        // Product information details
                        $product_meta_data_raw = $wpdb->get_results("
                        SELECT 
                            pm.post_id as meta_product_id,
                            pm.meta_key as meta_product_key,
                            pm.meta_value as meta_product_value
                        FROM wp_postmeta pm
                        WHERE pm.post_id = '" . $product->id . "'
                        AND pm.meta_key in ('_wc_average_rating',
                            '_wc_review_count',
                            '_regular_price',
                            '_thumbnail_id',
                            '_price');
                        
                        ");

                        // $product_meta_data = [];

                        // foreach ($product_meta_data_raw as $product_meta_record_raw) {
                        //     $product_meta_data[$product_meta_record_raw->meta_product_key] = $product_meta_record_raw->meta_product_value;
                        // }



                        // var_dump($product->id);

                        // $output .= "<p>" . $product_meta_data["_regular_price"] . "</p>";

                        // $output .= "<p>" . $product_meta_data["_price"] . "</p>";

                        // $output .= "<p>" . $product_meta_data["_wc_average_rating"] . "</p>";

                        // $output .= "<p>" . $product_meta_data["_wc_review_count"] . "</p>";

                        // $output .= "<div>";


                        // Product cart actions
                        $output .= "<button class='add-to-cart-plus-qty' data-product-id=" . $product->id . ">+</button>";
                        $output .= "<button class='add-to-cart-minus-qty' data-product-id=" . $product->id . ">-</button>";
                        $output .= "<input id='add-to-cart-quantity-input-" . $product->id . "' type='number' value='0' data-product-id=" . $product->id . " min=0 max=999 size=4 />";
                        $output .= "<button class='add-to-cart-button' data-product-id=" . $product->id . ">Add to cart</button>";

                        $output .= "</li>";
                    }
                }

                $output .= "</ul>";
            }
            $output .= "</div>";
        }
    }

    $output .= "</div>";

    return $output;
}
add_shortcode('trww_product_archive', 'trww_product_archive');


include get_stylesheet_directory() . "/includes/trww-archive-product/lib/trww-ajax-calls-handler.php";
