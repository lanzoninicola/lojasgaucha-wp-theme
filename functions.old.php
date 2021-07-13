<?php
// require_once(__DIR__ . '/config.php');

add_action('wp_enqueue_scripts', 'enqueue_parent_theme_style');

function enqueue_parent_theme_style()
{
    wp_enqueue_style('parent-style', get_template_directory_uri() . '/style.css');
}


// SELECT 
// 	p.*,
//     t.name,
//     t.slug,
//     pm_product.*
// FROM lojasgaucha.wp_postmeta pm_ui
// INNER JOIN lojasgaucha.wp_terms t on (t.term_id = pm_ui.meta_value
// 										and pm_ui.meta_key = "ui_archive_product_category"
// 										)
// INNER JOIN lojasgaucha.wp_posts p on (p.id = pm_ui.post_id
// 										and p.post_type = "product"
// 										and p.post_status = "publish")
// INNER JOIN lojasgaucha.wp_postmeta pm_product on (pm_ui.post_id = pm_product.post_id
// 													and pm_product.meta_key in ("_wc_average_rating",
// "_wc_review_count",
// "_regular_price",
// "_thumbnail_id",
// "_price"))
// WHERE 1=1;

add_action('woocommerce_before_shop_loop', function () {

    $args = array(
        'taxonomy'   => 'product_cat',
        'number'     => 999,
        'orderby'    => 'title',
        'order'      => 'ASC',
        'hide_empty' => true,
        // 'include'    => $ids
    );
    $product_categories = get_terms($args);

    $count = count($product_categories);
    if ($count > 0) {
        foreach ($product_categories as $product_category) {

            // print_r($product_category->term_id)

?>
            <div id="trww-category-card" data-category-id="<?php echo $product_category->term_id ?>">
                <a href="<?php echo get_term_link($product_category) ?> "><?php echo $product_category->name ?></a>

                <?php
                $args = array(
                    'posts_per_page' => -1,
                    'tax_query' => array(
                        'relation' => 'AND',
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'slug',
                            'terms' => 'decor'
                            //'terms' => $product_category->slug
                        )
                    ),
                    'post_type' => 'product',
                    'orderby' => 'title,'
                );
                $products = new WP_Query($args);
                ?>

                <ul>
                    <?php
                    global $wpdb;
                    while ($products->have_posts()) {
                        $products->the_post();
                        $productID = $products->post->ID;

                        $product_meta_data_raw = $wpdb->get_results("
                        SELECT 
	                        meta_key,
                            meta_value
                        FROM lojasgaucha.wp_postmeta 
                            where post_id = '" . $productID . "' 
                            and meta_key in (
                            '_wc_average_rating',
                            '_wc_review_count',
                            '_regular_price',
                            '_thumbnail_id',
                            '_price') ;
                        ");

                        // $obj = $product_meta_data_raw[4];
                        // var_dump($obj->meta_value); die();


                        // var_dump($product_meta_data); die();

                        $product_meta_data = [];

                        foreach ($product_meta_data_raw as $product_meta_record_raw) {
                            $product_meta_data[$product_meta_record_raw->meta_key] = $product_meta_record_raw->meta_value;
                        }

                        // var_dump($product_meta_data); die();

                        $product_url_image = "";

                        if (has_post_thumbnail($productID)) {
                            $img = wp_get_attachment_image_src(get_post_thumbnail_id($productID), '300');
                            // returns an array, the first item is the image URL
                            // var_dump($img[0]); die;
                            $product_url_image = $img[0];
                        }

                    ?>
                        <li>
                            <div>
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_title(); ?>
                                </a>
                                <p>
                                    <?php echo $product_meta_data["_wc_average_rating"]; ?>
                                </p>
                                <p>
                                    <?php echo $product_meta_data["_wc_review_count"]; ?>
                                </p>

                                <img src="<?php echo $product_url_image ?>" width="300" height="300" alt loading="lazy"/>
                                <p>
                                    <?php echo $product_meta_data["_regular_price"]; ?>
                                </p>
                                <p>
                                    <?php echo $product_meta_data["_price"]; ?>
                                </p>
                            </div>
                        </li>
                    <?php
                    }
                    ?>
                </ul>

            </div>
<?php }
    }
});



// require_once(__DIR__ . '/includes/nl-cep-popup/index.php');


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