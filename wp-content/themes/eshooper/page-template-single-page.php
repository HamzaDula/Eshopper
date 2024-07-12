<?php
/**
 * Template Name: Single Detail Page
 */
get_header();
?>

<!-- Page Header Start -->
<div class="container-fluid bg-secondary mb-5">
    <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
        <h1 class="font-weight-semi-bold text-uppercase mb-3"><?php the_title(); ?></h1>
        <div class="d-inline-flex">
            <p class="m-0"><a href="<?php echo home_url(); ?>">Home</a></p>
            <p class="m-0 px-2">-</p>
            <p class="m-0"><?php the_title(); ?></p>
        </div>
    </div>
</div>
<!-- Page Header End -->

<!-- Shop Detail Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col-lg-5 pb-5">
            <?php
            // Query products from 'Men's Dresses' category
            $args = array(
                'post_type' => 'product',
                'posts_per_page' => 1,
                'product_cat' => 'mens-dresses',
            );

            $main_query = new WP_Query($args);

            if ($main_query->have_posts()) : while ($main_query->have_posts()) : $main_query->the_post();
                global $product;
                ?>
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        <div class="carousel-item active">
                            <?php if (has_post_thumbnail()) : ?>
                                <?php the_post_thumbnail('large', array('class' => 'w-100 h-100')); ?>
                            <?php endif; ?>
                        </div>
                        <?php
                        // Display gallery images
                        $attachment_ids = $product->get_gallery_image_ids();
                        foreach ($attachment_ids as $attachment_id) :
                            $image_url = wp_get_attachment_image_url($attachment_id, 'large');
                        ?>
                            <div class="carousel-item">
                                <img class="w-100 h-100" src="<?php echo esc_url($image_url); ?>" alt="Product Image">
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <a class="carousel-control-prev" href="#product-carousel" data-slide="prev">
                        <i class="fa fa-2x fa-angle-left text-dark"></i>
                    </a>
                    <a class="carousel-control-next" href="#product-carousel" data-slide="next">
                        <i class="fa fa-2x fa-angle-right text-dark"></i>
                    </a>
                </div>
            <?php endwhile;
            endif;
            wp_reset_postdata(); ?>
        </div>

        <div class="col-lg-7 pb-5">
            <?php
            // Display main product details
            if ($main_query->have_posts()) : while ($main_query->have_posts()) : $main_query->the_post();
                ?>
                <h3 class="font-weight-semi-bold"><?php the_title(); ?></h3>
                <div class="d-flex mb-3">
                    <div class="text-primary mr-2">
                        <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                    </div>
                    <small class="pt-1">(<?php echo esc_html($product->get_review_count()); ?> Reviews)</small>
                </div>
                <h3 class="font-weight-semi-bold mb-4"><?php echo $product->get_price_html(); ?></h3>
                <div class="mb-4">
                    <?php the_content(); ?>
                </div>
            <?php endwhile;
            endif;
            ?>
            
            <div class="d-flex align-items-center mb-4 quantity-box">
                <?php woocommerce_template_single_add_to_cart(); ?>
            </div>
            <!-- Quantity input -->
            
            <!-- End quantity input -->
            
        </div>
    </div>
    
    <!-- Related Products Start -->
    <div class="row px-xl-5">
        <div class="col">
            <h3 class="font-weight-semi-bold mb-4">Related Products</h3>
            <div class="row">
                <?php
                // Query related products
                $related_args = array(
                    'post_type' => 'product',
                    'posts_per_page' => 4, // Adjust as needed
                    'product_cat' => 'mens-dresses',
                    'post__not_in' => array($product->get_id()), // Exclude current product
                );

                $related_query = new WP_Query($related_args);

                if ($related_query->have_posts()) :
                    while ($related_query->have_posts()) : $related_query->the_post();
                        ?>
                        <div class="col-md-3">
                            <div class="card">
                                <?php if (has_post_thumbnail()) : ?>
                                    <img class="card-img-top" src="<?php the_post_thumbnail_url('thumbnail'); ?>" alt="<?php the_title_attribute(); ?>">
                                <?php endif; ?>
                                <div class="card-body">
                                    <h5 class="card-title"><?php the_title(); ?></h5>
                                    <a href="<?php the_permalink(); ?>" class="btn btn-primary">View Product</a>
                                </div>
                            </div>
                        </div>
                <?php
                    endwhile;
                endif;
                wp_reset_postdata();
                ?>
            </div>
        </div>
    </div>
    <!-- Related Products End -->
</div>
<!-- Shop Detail End -->

<?php
get_footer();
?>
