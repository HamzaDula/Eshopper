<?php
/**
 * Template Name: Single Page
 */
get_header();
?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?php the_title()?></h1>
        <div class="d-inline-flex">
            <?php
            if (function_exists('woocommerce_breadcrumb')) {
                woocommerce_breadcrumb(array(
                    'wrap_before' => '<p class="m-0">',
                    'wrap_after'  => '</p>',
                    'delimiter'   => '<p class="m-0 px-2">-</p>',
                    'before'      => '',
                    'after'       => ''
                ));
            }
            ?>
        </div>
    </div>
</div>

<!-- Page Header End -->

<!-- Shop Detail Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <?php global $product; ?>
                <?php
                // Ensure $product is properly set up
                if (function_exists('wc_get_product') && is_product()) {
                    $product = wc_get_product(get_the_ID());
                }
                ?>
                <div id="product-images" class="border">
                    <?php
                    // Output main product image
                    if (has_post_thumbnail()) : ?>
                        <div class="product-image">
                            <?php the_post_thumbnail('large', array('class' => 'w-100 h-100', 'id' => 'main-product-image')); ?>
                        </div>
                    <?php endif;

                    // Output variation images based on color selection
                    if ($product && $product->is_type('variable')) {
                        $variations = $product->get_available_variations();
                        if (!empty($variations)) {
                            foreach ($variations as $variation) {
                                $variation_id = $variation['variation_id'];
                                $image_id = $variation['image']['id']; // Get the image ID of the variation

                                // Display variation image
                                $image_url = wp_get_attachment_image_url($image_id, 'large');
                                if ($image_url) : ?>
                                    <div class="product-image variation-image" data-variation-id="<?php echo esc_attr($variation_id); ?>" style="display: none;">
                                        <img src="<?php echo esc_url($image_url); ?>" class="w-100 h-100" alt="Product Image">
                                    </div>
                                <?php endif;
                            }
                        }
                    }
                    ?>
                </div>
            <?php endwhile;
            endif; ?>
        </div>

        <div class="col-lg-7 pb-5">
            <h3 class="font-weight-semi-bold"><?php the_title(); ?></h3>
            <div class="d-flex mb-3">
                <div class="text-primary mr-2">
                    <?php if ($product && wc_review_ratings_enabled()) : ?>
                        <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                    <?php endif; ?>
                </div>
                <?php if ($product) : ?>
                    <small class="pt-1">(<?php echo esc_html($product->get_review_count()); ?> Reviews)</small>
                <?php endif; ?>
            </div>
            <?php if ($product) : ?>
                <h3 class="font-weight-semi-bold mb-4"><?php echo $product->get_price_html(); ?></h3>
            <?php endif; ?>
            <div class="mb-4">
                <?php the_content(); ?>
            </div>
            <div class="d-flex align-items-center mb-4 pt-2 quantity-box">
                <?php if ($product && ($product->is_type('simple') || $product->is_type('variable') || $product->is_type('grouped'))) : ?>
                    <?php woocommerce_template_single_add_to_cart(); ?>
                <?php endif; ?>
            </div>
            <div class="d-flex pt-2">
                <p class="text-dark font-weight-medium mb-0 mr-2">Share on:</p>
                <div class="d-inline-flex">
                    <a class="text-dark px-2" href="#">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a class="text-dark px-2" href="#">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a class="text-dark px-2" href="#">
                        <i class="fab fa-linkedin-in"></i>
                    </a>
                    <a class="text-dark px-2" href="#">
                        <i class="fab fa-pinterest"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="row px-xl-5">
        <div class="col">
            <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Description</a>
                <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-2">Information</a>
                <?php if ($product) : ?>
                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews (<?php echo esc_html($product->get_review_count()); ?>)</a>
                <?php endif; ?>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="tab-pane-1">
                    <h4 class="mb-3">Product Description</h4>
                    <p><?php the_content(); ?></p>
                </div>
                <div class="tab-pane fade" id="tab-pane-2">
                    <h4 class="mb-3">Additional Information</h4>
                    <?php if ($product) {
                        do_action('woocommerce_product_additional_information', $product);
                    } ?>
                </div>
                <?php if ($product) : ?>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-4"><?php echo esc_html($product->get_review_count()); ?> review for "<?php the_title(); ?>"</h4>
                                <?php comments_template(); ?>
                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <?php
                                if (comments_open()) {
                                    comment_form(array(
                                        'title_reply' => '',
                                        'comment_notes_after' => '',
                                    ));
                                } else {
                                    echo '<p class="no-comments">' . esc_html__('Reviews are closed.', 'textdomain') . '</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Shop Detail End -->

<script>
    jQuery(function($) {
        // Change main product image based on variation selection
        $('.variations_form').on('change', 'select', function() {
            var variation_id = $(this).val();
            if (variation_id) {
                // Hide all variation images
                $('.product-image').hide();
                // Show selected variation image
                $('.variation-image[data-variation-id="' + variation_id + '"]').show();
            } else {
                // Show default main product image if no variation is selected
                $('.product-image').show();
            }
        });
    });
</script>

<?php
get_footer();
?>
