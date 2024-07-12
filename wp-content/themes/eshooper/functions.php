<?php



// function mailtrap($phpmailer) {

//     $phpmailer->isSMTP();

//     $phpmailer->Host = 'sandbox.smtp.mailtrap.io';

//     $phpmailer->SMTPAuth = true;

//     $phpmailer->Port = 2525;

//     $phpmailer->Username = '80808ba7e72e74';

//     $phpmailer->Password = '85fe9ff240abf2';

//   }

  

//   add_action('phpmailer_init', 'mailtrap');

function custom_theme_styles() {

    // Enqueue the favicon

    echo '<link rel="icon" href="' . get_template_directory_uri() . '/img/favicon.ico" />';



    // Enqueue Google Web Fonts

    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap', false);



    // Enqueue Font Awesome

    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css', array(), '5.10.0');



    // Enqueue Owl Carousel CSS

    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/lib/owlcarousel/assets/owl.carousel.min.css', array(), '2.3.4');



    // Enqueue the main stylesheet

    wp_enqueue_style('custom-style', get_template_directory_uri() . '/css/style.css');

}

add_action('wp_enqueue_scripts', 'custom_theme_styles');





function custom_theme_scripts() {

    // Deregister the default jQuery and register a new version

    wp_deregister_script('jquery');

    wp_register_script('jquery', 'https://code.jquery.com/jquery-3.4.1.min.js', array(), '3.4.1', true);

    wp_enqueue_script('jquery');



    // Enqueue Bootstrap Bundle

    wp_enqueue_script('bootstrap-bundle', 'https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js', array('jquery'), '4.4.1', true);



    // Enqueue Easing Library

    wp_enqueue_script('easing', get_template_directory_uri() . '/lib/easing/easing.min.js', array('jquery'), null, true);



    // Enqueue Owl Carousel Library

    wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/lib/owlcarousel/owl.carousel.min.js', array('jquery'), null, true);



    // Enqueue jqBootstrapValidation for contact form validation

    wp_enqueue_script('jqbootstrapvalidation', get_template_directory_uri() . '/mail/jqBootstrapValidation.min.js', array('jquery'), null, true);



    // Enqueue Contact Form Script

    wp_enqueue_script('contact', get_template_directory_uri() . '/mail/contact.js', array('jquery'), null, true);



    // Enqueue Main Template Script

    wp_enqueue_script('main', get_template_directory_uri() . '/js/main.js', array('jquery'), null, true);

}

add_action('wp_enqueue_scripts', 'custom_theme_scripts');











function register_custom_menus() {

    register_nav_menus(

        array(

            'primary-menu' => __( 'Primary Menu' ),

        )

    );

}

add_action( 'init', 'register_custom_menus' );










function custom_theme_setup() {

    // Add WooCommerce support

    add_theme_support('woocommerce');

}

add_action('after_setup_theme', 'custom_theme_setup');





// Function to display best-selling products

function display_best_selling_products() {

    ob_start(); // Start output buffering



    // Define the WooCommerce query arguments

    $args = array(

        'post_type' => 'product',

        'posts_per_page' => 5, // Number of products to display

        'meta_key' => 'total_sales', // Meta key for best-selling products

        'orderby' => 'meta_value_num', // Order by sales number

        'order' => 'DESC' // Descending order

    );



    // Execute the WooCommerce query

    $loop = new WP_Query($args);



    // Check if there are products

    if ($loop->have_posts()) :

        echo '<div class="row px-xl-5 pb-3">';

        while ($loop->have_posts()) : $loop->the_post();

            global $product;

            ?>

            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">

                <div class="card product-item border-0 mb-4">

                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">

                        <img class="img-fluid w-100" src="<?php echo get_the_post_thumbnail_url($product->get_id(), 'full'); ?>" alt="<?php the_title(); ?>">

                    </div>

                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">

                        <h6 class="text-truncate mb-3"><?php the_title(); ?></h6>

                        <div class="d-flex justify-content-center">

                            <h6><?php echo $product->get_price_html(); ?></h6>

                        </div>

                    </div>

                    <div class="card-footer d-flex justify-content-between bg-light border">

                        <a href="<?php echo get_permalink($product->get_id()); ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>

                        <a href="?add-to-cart=<?php echo $product->get_id(); ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>

                    </div>

                </div>

            </div>

            <?php

        endwhile;

        echo '</div>';

    else :

        echo '<p>No products found</p>';

    endif;



    wp_reset_postdata(); // Reset post data

    return ob_get_clean(); // Return the output buffer content

}



// Register the shortcode

function register_best_selling_products_shortcode() {

    add_shortcode('best_selling_products', 'display_best_selling_products');

}

add_action('init', 'register_best_selling_products_shortcode');



// Register Footer Widget Area
function custom_theme_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Footer Widget Area', 'custom-theme' ),
        'id'            => 'footer-widget-area',
        'description'   => __( 'Widgets added here will appear in the footer.', 'custom-theme' ),
        'before_widget' => '<div id="%1$s" class="widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h5 class="font-weight-bold text-dark mb-4">',
        'after_title'   => '</h5>',
    ) );
}

// Hook into the 'widgets_init' action hook
add_action( 'widgets_init', 'custom_theme_widgets_init' );



add_action('wp_ajax_get_states_based_on_country', 'get_states_based_on_country');
add_action('wp_ajax_nopriv_get_states_based_on_country', 'get_states_based_on_country');

function get_states_based_on_country(){
    check_ajax_referer('get_states', 'security');
    
    $country_code = sanitize_text_field($_POST['country']);
    $states = WC()->countries->get_states($country_code);
    
    echo json_encode($states);
    
    wp_die();
}


// Filter products AJAX handler
add_action('wp_ajax_filter_products', 'filter_products');
add_action('wp_ajax_nopriv_filter_products', 'filter_products');

function filter_products() {
    $data = json_decode(file_get_contents('php://input'), true);
    $args = [
        'post_type' => 'product',
        'posts_per_page' => -1,
        'meta_query' => [],
        'tax_query' => [
            'relation' => 'AND'
        ]
    ];

    if (!empty($data['prices'])) {
        $price_meta_query = [
            'relation' => 'OR'
        ];
        foreach ($data['prices'] as $price) {
            $price_meta_query[] = [
                'key' => '_price',
                'value' => [$price['min'], $price['max']],
                'compare' => 'BETWEEN',
                'type' => 'NUMERIC'
            ];
        }
        $args['meta_query'][] = $price_meta_query;
    }

    if (!empty($data['colors'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'pa_color',
            'field' => 'slug',
            'terms' => $data['colors'],
            'operator' => 'IN'
        ];
    }

    if (!empty($data['sizes'])) {
        $args['tax_query'][] = [
            'taxonomy' => 'pa_size',
            'field' => 'slug',
            'terms' => $data['sizes'],
            'operator' => 'IN'
        ];
    }

    if (!empty($data['sort'])) {
        switch ($data['sort']) {
            case 'latest':
                $args['orderby'] = 'date';
                $args['order'] = 'DESC';
                break;
            case 'rating':
                $args['meta_key'] = '_wc_average_rating';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
            case 'popularity':
                $args['meta_key'] = 'total_sales';
                $args['orderby'] = 'meta_value_num';
                $args['order'] = 'DESC';
                break;
        }
    }

    $query = new WP_Query($args);
    $products = [];

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            global $product;

            $product_data = [
                'name' => get_the_title(),
                'price' => $product->get_price(),
                'image' => get_the_post_thumbnail_url(), // Always fetch the main product thumbnail
                'permalink' => get_permalink(),
                'type' => $product->get_type()
            ];

            $products[] = $product_data;
        }
    }

    wp_reset_postdata();

    wp_send_json($products);
    wp_die();
}
function display_latest_products() {
    ob_start();

    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 4,
        'orderby' => 'date',
        'order' => 'DESC'
    );

    $loop = new WP_Query( $args );

    if ( $loop->have_posts() ) : 
        while ( $loop->have_posts() ) : $loop->the_post();
            global $product; ?>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="card product-item border-0 mb-4">
                    <div class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                        <?php if ( has_post_thumbnail() ) : ?>
                            <img class="img-fluid w-100" src="<?php the_post_thumbnail_url('full'); ?>" alt="<?php the_title(); ?>">
                        <?php else : ?>
                            <img class="img-fluid w-100" src="<?php get_template_directory_uri()?>/img/placeholder.png" alt="<?php the_title(); ?>">
                        <?php endif; ?>
                    </div>
                    <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                        <h6 class="text-truncate mb-3"><?php the_title(); ?></h6>
                        <div class="d-flex justify-content-center">
                            <h6><?php echo $product->get_price_html(); ?></h6>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-between bg-light border">
                        <a href="<?php the_permalink(); ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                        <a href="<?php echo esc_url( $product->add_to_cart_url() ); ?>" class="btn btn-sm text-dark p-0"><i class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                    </div>
                </div>
            </div>
        <?php endwhile;
    else :
        echo __( 'No products found' );
    endif;

    wp_reset_postdata();

    return ob_get_clean();
}

add_shortcode('latest_products', 'display_latest_products');

// Add to cart AJAX handler
function add_to_cart() {
    $data = json_decode(file_get_contents('php://input'), true);
    $product_id = isset($data['product_id']) ? $data['product_id'] : 0;

    if ($product_id) {
        $added = WC()->cart->add_to_cart($product_id);
        if ($added) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false]);
        }
    } else {
        echo json_encode(['success' => false]);
    }

    wp_die();
}
add_action('wp_ajax_add_to_cart', 'add_to_cart');
add_action('wp_ajax_nopriv_add_to_cart', 'add_to_cart');


add_action('wp_ajax_update_cart_count', 'update_cart_count_callback');
add_action('wp_ajax_nopriv_update_cart_count', 'update_cart_count_callback');

function update_cart_count_callback() {
    echo WC()->cart->get_cart_contents_count();
    wp_die();
}

add_action('wp_ajax_update_wishlist_count', 'update_wishlist_count_callback');
add_action('wp_ajax_nopriv_update_wishlist_count', 'update_wishlist_count_callback');

function update_wishlist_count_callback() {
    // Logic to get wishlist count (if applicable)
    echo '0'; // Replace with your actual count logic
    wp_die();
}

// AJAX action to get states based on country
add_action('wp_ajax_get_states', 'get_states_callback');
add_action('wp_ajax_nopriv_get_states', 'get_states_callback');

function get_states_callback(){
    $country = $_POST['country'];

    // Get states for the selected country
    $states = WC()->countries->get_states($country);

    if(!$states){
        $states = array('' => __('Select an option', 'woocommerce'));
    }

    // Output options
    $options = '<option value="">'.__('Select a state', 'woocommerce').'</option>';
    foreach($states as $key => $state){
    }

    $options .= '<option value="'.$key.'">'.$state.'</option>';
    echo $options;

    wp_die();
}


add_action('rest_api_init', function() {
    register_rest_route('custom/v1', '/trending-products', array(
        'methods' => 'GET',
        'callback' => 'get_trending_products',
    ));
});
function get_trending_products() {
    $args = array(
        'post_type' => 'product',
        'posts_per_page' => 5,
        'meta_key' => 'product_views',  // Replace with your custom field for views
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
    );

    $query = new WP_Query($args);
    $output = '<ul class="trending-products">';

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
    
            // Get product information
            $product_id = get_the_ID();
            $product_title = get_the_title();
            $product_permalink = get_the_permalink();
            $product_image = get_the_post_thumbnail($product_id, 'thumbnail');
            $product_price = wc_get_product($product_id)->get_price(); // WooCommerce product price
            
            // Output product information
            $output .= '<div class="product">';
            $output .= '<h3><a href="' . $product_permalink . '">' . $product_image . '</a></h3>'; // Product image
            $output .= '<h3><a href="' . $product_permalink . '">' . $product_title . '</a></h3>'; // Product title
            $output .= '<p>Price: ' . wc_price($product_price) . '</p>'; // Product price formatted with WooCommerce function
            $output .= '<p><a href="' . esc_url(wc_get_cart_url()) . '" class="button add_to_cart_button">Add to Cart</a></p>'; // Add to cart button
            $output .= '</div>';
        }
        wp_reset_postdata();
    } else {
        $output .= '<li>No trending products found</li>';
    }

    $output .= '</ul>';
    return $output;
}

add_shortcode('trending_products', 'get_trending_products');


// Remove default WooCommerce breadcrumb
remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
