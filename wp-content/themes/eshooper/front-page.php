<?php get_header(); ?>

<!-- Featured Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0"><?php the_field('quality_product') ?></h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                <h5 class="font-weight-semi-bold m-0"><?php the_field('free_shipping') ?></h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0"><?php the_field('14-day_return') ?></h5>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
            <div class="d-flex align-items-center border mb-4" style="padding: 30px;">
                <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                <h5 class="font-weight-semi-bold m-0"><?php the_field('247_support') ?></h5>
            </div>
        </div>
    </div>
</div>
<!-- Featured End -->


<!-- Categories Start -->
<div class="container-fluid pt-5">
    <div class="row px-xl-5 pb-3">
        <?php
        // Check if the repeater field has rows of data
        if (have_rows('category_rep')):
            // Loop through the rows of data
            while (have_rows('category_rep')):
                the_row();
                // Get sub-field values
                $category_name = get_sub_field('category_name');
                $category_image = get_sub_field('category_img');
                $product_count = get_sub_field('product_quantity');
                $category_link = get_sub_field('category_link');
                ?>
                <div class="col-lg-4 col-md-6 pb-1">
                    <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                        <?php if ($product_count): ?>
                            <p class="text-right"><?php echo $product_count; ?> </p>
                        <?php endif; ?>
                        <a href="<?php echo esc_url($category_link); ?>" class="cat-img position-relative overflow-hidden mb-3">
                            <img class="img-fluid" src="<?php echo esc_url($category_image['url']); ?>"
                                alt="<?php echo esc_attr($category_image['alt']); ?>">
                        </a>
                        <h5 class="font-weight-semi-bold m-0"><?php echo $category_name; ?></h5>
                    </div>
                </div>
                <?php
            endwhile;
        endif;
        ?>
    </div>
</div>

<!-- Categories End -->


<!-- Offer Start -->
<?php if (have_rows('offer_rep')): ?>
    <div class="container-fluid offer pt-5">
        <div class="row px-xl-5">
            <?php while (have_rows('offer_rep')):
                the_row(); ?>
                <div class="col-md-6 pb-4">
                    <div
                        class="position-relative bg-secondary text-center <?php echo (get_row_index() % 2 == 0) ? 'text-md-left' : 'text-md-right'; ?> text-white mb-2 py-5 px-5">
                        <?php $offer_img = get_sub_field('offer_img'); ?>
                        <img src="<?php echo esc_url($offer_img['url']); ?>" alt="<?php echo esc_attr($offer_img['alt']); ?>">
                        <div class="position-relative" style="z-index: 1;">
                            <h5 class="text-uppercase text-primary mb-3"><?php the_sub_field('discount_text'); ?></h5>
                            <h1 class="mb-4 font-weight-semi-bold"><?php the_sub_field('offer_name'); ?></h1>
                            <?php
                            $link = get_sub_field('shop_link');
                            if ($link):
                                $link_url = $link['url'];
                                $link_title = $link['title'];
                                $link_target = $link['target'] ? $link['target'] : '_self';
                                ?>
                                <a class="btn btn-outline-primary py-md-2 px-md-3" href="<?php echo esc_url($link_url); ?>"
                                    target="<?php echo esc_attr($link_target); ?>">Shop Now</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
<?php endif; ?>



<!-- Offer End -->


<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Trandy Products</span></h2>
    </div>
    <?php
    // Use do_shortcode() to call the best_sellers shortcode
    echo do_shortcode('[best_selling_products]');
    ?>
</div>
<!-- Products End -->


<!-- Subscribe Start -->
<div class="container-fluid bg-secondary subscribe-box  my-5">
    <div class="row justify-content-md-center py-5 px-xl-5">
        <div class="col-md-6 col-12 py-5">
            <div class="text-center mb-2 pb-2">
                <h2 class="section-title px-5 mb-3"><span
                        class="bg-secondary px-2"><?php the_field('sub_text') ?></span>
                </h2>
                <p><?php the_field('sub_desc') ?></p>
            </div>
            <?php echo do_shortcode('[newsletter_form form="1"]'); ?>
        </div>
    </div>
</div>

<!-- Subscribe End -->


<!-- Products Start -->
<div class="container-fluid pt-5">
    <div class="text-center mb-4">
        <h2 class="section-title px-5"><span class="px-2">Just Arrived</span></h2>
    </div>
    <div class="row px-xl-5 pb-3">
        <?php echo do_shortcode('[latest_products]'); ?>    
    </div>
</div>
<!-- Products End -->


<!-- Vendor Start -->
<div class="container-fluid py-5">
    <div class="row px-xl-5">
        <div class="col">
            <div class="owl-carousel vendor-carousel">
                <?php
                // Check if the repeater field has rows of data
                if (have_rows('vendor_rep')):
                    // Loop through the rows of data
                    while (have_rows('vendor_rep')):
                        the_row();
                        // Get image field value
                        $image = get_sub_field('vendor_img');
                        ?>
                        <div class="vendor-item border p-4">
                            <img src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>">
                        </div>
                    <?php endwhile;
                endif;
                ?>
            </div>
        </div>
    </div>
</div>

<?php get_footer(); ?>