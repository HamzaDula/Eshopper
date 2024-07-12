<?php
get_header();

if (is_shop() || is_product_category() || is_product_tag()) {
    woocommerce_content();
} elseif (is_cart()) {
    // Load custom cart template
    wc_get_template_part('cart/cart');
} elseif (is_checkout()) {
    // Load WooCommerce checkout template
    wc_get_template_part('checkout/form-checkout');
} else {
    // Default content for other pages
    if (have_posts()) {
        while (have_posts()) {
            the_post();
            the_content();
        }
    }
}

get_footer();
?>
