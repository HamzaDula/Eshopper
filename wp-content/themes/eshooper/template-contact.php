<?php
/**
 * Template Name:Contact US
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


    <!-- Contact Start -->
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2"><?php the_field('heading')?></span></h2>
        </div>
        <div class="row px-xl-5">
            <div class="col-lg-7 mb-5">
                <div class="contact-form">
                    <div id="success"></div>
                    <?php echo do_shortcode('[contact-form-7 id="09c7493" title="Contac Us"]')?>
                      
                </div>
            </div>
            <div class="col-lg-5 mb-5">
                <h5 class="font-weight-semi-bold mb-3"><?php the_field('get_in_touch')?></h5>
                <p><?php the_field('touch_desc')?></p>
                <div class="d-flex flex-column mb-3">
                    <h5 class="font-weight-semi-bold mb-3">Store 1</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i><?php the_field('address')?></p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i><?php the_field('email')?></p>
                    <p class="mb-2"><i class="fa fa-phone-alt text-primary mr-3"></i><?php the_field('phone')?></p>
                </div>
                <div class="d-flex flex-column">
                    <h5 class="font-weight-semi-bold mb-3">Store 2</h5>
                    <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i><?php the_field('address')?></p>
                    <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i><?php the_field('email')?></p>
                    <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i><?php the_field('phone')?></p>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->

    <?php get_footer();?>