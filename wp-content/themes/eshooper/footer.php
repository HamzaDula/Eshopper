<!-- Footer Start -->
<div class="container-fluid bg-secondary text-dark mt-5 pt-5">

    <div class="row px-xl-5 pt-5">

        <div class="col-lg-4 col-md-12 mb-5 pr-3 pr-xl-5">

            <a href="<?php echo esc_url(home_url('/')) ?>" class="text-decoration-none">

                <h1 class="mb-4 display-5 font-weight-semi-bold"><span
                        class="text-primary font-weight-bold border border-white px-3 mr-1">E</span>Shopper</h1>

            </a>

            <p></p>

            <p class="mb-2"><i class="fa fa-map-marker-alt text-primary mr-3"></i>Ahmedabad</p>

            <p class="mb-2"><i class="fa fa-envelope text-primary mr-3"></i>eshopper@gmail.com</p>

            <p class="mb-0"><i class="fa fa-phone-alt text-primary mr-3"></i>1234567890</p>

        </div>

        <div class="col-lg-8 col-md-12">

            <div class="row">

                <div class="col-md-8 mb-5" style="display: flex;gap: 20px;">

                    <?php

                    // Check if the footer widget area is active
                    
                    if (is_active_sidebar('footer-widget-area')):

                        dynamic_sidebar('footer-widget-area');

                        // If no widget is active, display default quick links
                    
                        ?>

                    <?php endif; ?>

                </div>
                <div class="col-md-4 mb-5">
                    <h5 class="font-weight-bold text-dark mb-4">Newsletter</h5>
                    <?php echo do_shortcode('[newsletter_form]'); ?>
                    <!--   [text* your-name class:form-control class:border-0 class:py-4 placeholder "Your Name"]
    [email* your-email class:form-control class:border-0 class:py-4 placeholder "Your Email"]
[submit class:btn class:btn-primary class:btn-block class:border-0 class:py-3 "Subscribe Now"] -->
                </div>
            </div>
        </div>



    </div>

</div>

</div>

<div class="row border-top border-light mx-xl-5 py-4">

    <div class="col-md-6 px-xl-0">

        <p class="mb-md-0 text-center text-md-left text-dark">

            &copy; <a class="text-dark font-weight-semi-bold" href="#">EShopper</a>. All Rights Reserved.

        </p>

    </div>

    <div class="col-md-6 px-xl-0 text-center text-md-right">

        <img class="img-fluid" src="<?php echo get_template_directory_uri(  )?>/img/payments.png" alt="">

    </div>

</div>

</div>

<!-- Footer End -->





<!-- Back to Top -->

<a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>





<?php wp_footer(); ?>

</body>



</html>