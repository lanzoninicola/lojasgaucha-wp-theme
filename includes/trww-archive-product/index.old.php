<?php

function ql_woocommerce_ajax_add_to_cart_js()
{
    wp_enqueue_script(
        'trww_add_to_cart',
        get_stylesheet_directory_uri() . '/includes/trww-archive-product/js/ajax_add_to_cart.js',
        array('wc-add-to-cart'),
        '1.0',
        true
    );
}
add_action('wp_enqueue_scripts', 'ql_woocommerce_ajax_add_to_cart_js');


// var_dump("Im here before woocommerce action");die;

add_action( 'elementor/frontend/element/before_render', function ( \Elementor\Element_Base $element ) {
	if ( ! $element->get_settings( 'my-custom-settings' ) ) {
		return;
	}

	$element->add_render_attribute( '_wrapper', [
		'class' => 'my-custom-class',
		'data-my_data' => 'my-data-value',
	] );
} );


/**
include get_stylesheet_directory() . '/includes/trww-archive-product/includes/class-browser_detector.php';
$browserDetector = new browserDetector();

if ($browserDetector->isAndroid($browser) or $browserDetector->isIphone($browser)) {
    
    

    add_action('woocommerce_before_shop_loop', function () {

        var_dump("Im here");die;

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


        $product_categories_count = count($product_categories);
        if ($product_categories_count > 0) {
            foreach ($product_categories as $product_category) {
?>
                <div id="trww-category-card" data-category-id="<?php echo $product_category->id ?>">
                    <a href="<?php echo get_term_link($product_category) ?> "><?php echo $product_category->name ?></a>

                    <?php

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

                    if ($product_counts > 0) :
                    ?>


                        <ul>
                            <?php
                            foreach ($products as $product) {

                                // Adding validation used in "add_to_cart()" WC function
                                // It will elige a product to be added in the cart
                                // It excludes product like type "External/Affiliate product"
                                $product_data = wc_get_product($product->id);

                                if ($product_data) {

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

                                    $product_meta_data = [];

                                    foreach ($product_meta_data_raw as $product_meta_record_raw) {
                                        $product_meta_data[$product_meta_record_raw->meta_product_key] = $product_meta_record_raw->meta_product_value;
                                    }

                                    $product_url_image = "";

                                    if (has_post_thumbnail($product->id)) {
                                        $img = wp_get_attachment_image_src(get_post_thumbnail_id($product->id), '300');
                                        // returns an array, the first item is the image URL
                                        // var_dump($img[0]); die;
                                        $product_url_image = $img[0];
                                    }
                                }

                            ?>
                                <li>
                                    <div>

                                        <!-- <img src="<?php echo $product_url_image ?>" width="300" height="300" alt loading="lazy" /> -->
                                        <a href="<?php the_permalink(); ?>">
                                            <?php echo $product->name; ?>
                                        </a>
                                        <p>
                                            <?php echo $product_meta_data["_regular_price"]; ?>
                                        </p>
                                        <p>
                                            <?php echo $product_meta_data["_price"]; ?>
                                        </p>
                                        <p>
                                            <?php echo $product_meta_data["_wc_average_rating"]; ?>
                                        </p>
                                        <p>
                                            <?php echo $product_meta_data["_wc_review_count"]; ?>
                                        </p>
                                        <div>

                                            <?php

                                            // js dependency when add script wc-add-to-cart-js-extra

                                            ?>

                                            <button class="add-to-cart-plus-qty" data-product-id="<?php echo $product->id; ?>">+</button>
                                            <button class="add-to-cart-minus-qty" data-product-id="<?php echo $product->id; ?>">-</button>
                                            <input id="add-to-cart-quantity-input-<?php echo $product->id; ?>" type="number" value="0" data-product-id="<?php echo $product->id; ?>" min=0 max=999 size=4 />
                                            <button class="add-to-cart-button" data-product-id="<?php echo $product->id; ?>">Add to cart</button>
                                        </div>



                                    </div>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>


                    <?php endif ?>

                </div>
<?php }
        }
    });


    include get_stylesheet_directory() . "/includes/trww-archive-product/lib/trww-ajax-calls-handler.php";
}
 */