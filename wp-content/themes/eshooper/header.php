<!DOCTYPE html>

<html lang="en">



<head>

    <meta charset="utf-8">

    <title><?php echo get_bloginfo('title') ?></title>

    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <meta content="Free HTML Templates" name="keywords">

    <meta content="Free HTML Templates" name="description">



    <?php wp_head(); ?>

    <style>
        /* Custom CSS for the navbar vertical */

        #navbar-vertical {

            display: none;

            /* Initially hide the dropdown */

        }



        #navbar-vertical.show {

            display: block;

            /* Show the dropdown when the 'show' class is added */

        }
    </style>

</head>



<body>

    <!-- Topbar Start -->

    <div class="container-fluid">

        <div class="row bg-secondary py-2 px-xl-5">

            <div class="col-lg-6 d-none d-lg-block">

                <div class="d-inline-flex align-items-center">

                    <a class="text-dark" href="">FAQs</a>

                    <span class="text-muted px-2">|</span>

                    <a class="text-dark" href="">Help</a>

                    <span class="text-muted px-2">|</span>

                    <a class="text-dark" href="<?php echo esc_url('/contact') ?>">Support</a>

                </div>

            </div>

            <div class="col-lg-6 text-center text-lg-right">

                <div class="d-inline-flex align-items-center">

                    <a class="text-dark px-2" href="www.facebook.com">

                        <i class="fab fa-facebook-f"></i>

                    </a>

                    <a class="text-dark px-2" href="www.twitter.com">

                        <i class="fab fa-twitter"></i>

                    </a>

                    <a class="text-dark px-2" href="www.linkedin.in">

                        <i class="fab fa-linkedin-in"></i>

                    </a>

                    <a class="text-dark px-2" href="www.instagram.com">

                        <i class="fab fa-instagram"></i>

                    </a>

                    <a class="text-dark pl-2" href="www.youtube.com">

                        <i class="fab fa-youtube"></i>

                    </a>

                </div>

            </div>

        </div>

        <div class="row align-items-center py-3 px-xl-5">

            <div class="col-lg-3 d-none d-lg-block">

                <a href="<?php echo esc_url(home_url('/')) ?>" class="text-decoration-none">

                    <h1 class="m-0 display-5 font-weight-semi-bold"><span
                            class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>

                </a>

            </div>

            <div class="col-lg-6 col-6 text-left">


                <form role="search" method="get" class="woocommerce-product-search input-group mb-3"
                    action="<?php echo esc_url(home_url('/')); ?>">
                    <input type="search" class="form-control p-3" placeholder="Search for products"
                        aria-describedby="search-icon-1" value="<?php echo get_search_query(); ?>" name="s">
                    <div class="input-group-append">
                        <button type="submit" id="search-icon-1" class="input-group-text p-3"
                            value="<?php echo esc_attr_x('Search', 'submit button', 'woocommerce'); ?>"><i
                                class="fa fa-search"></i></button>
                    </div>
                    <input type="hidden" name="post_type" value="product" />
                </form>

            </div>

            <div class="col-lg-3 col-6 text-right">
                <a href="#" class="btn border" id="wishlistBtn">
                    <i class="fas fa-heart text-primary"></i>
                    <span class="badge" id="wishlistCount"></span>
                </a>
                <a href="<?php echo wc_get_cart_url(); ?>" class="btn border" id="cartBtn">
                    <i class="fas fa-shopping-cart text-primary"></i>
                    <span class="badge" id="cartCount"></span>
                </a>
            </div>

            <script>
                jQuery(function ($) {
                    // Function to update cart count
                    function updateCartCount() {
                        $.ajax({
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            type: 'POST',
                            data: {
                                'action': 'update_cart_count'
                            },
                            success: function (response) {
                                $('#cartCount').text(response);
                            }
                        });
                    }

                    // Function to update wishlist count
                    function updateWishlistCount() {
                        $.ajax({
                            url: '<?php echo admin_url('admin-ajax.php'); ?>',
                            type: 'POST',
                            data: {
                                'action': 'update_wishlist_count'
                            },
                            success: function (response) {
                                $('#wishlistCount').text(response);
                            }
                        });
                    }

                    // Call functions initially to get current counts
                    updateCartCount();
                    updateWishlistCount();

                    // AJAX action handler for adding to cart
                    $(document).on('added_to_cart', function () {
                        updateCartCount();
                    });

                    // AJAX action handler for adding to wishlist (assuming you have wishlist AJAX events)
                    // Example: $(document).on('added_to_wishlist', function() { updateWishlistCount(); });

                    // Additional handlers for removing from cart or wishlist, if applicable
                });

            </script>
        </div>

    </div>

    <!-- Topbar End -->





    <!-- Navbar Start -->

    <div class="container-fluid mb-5">

        <div class="row border-top px-xl-5">

            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn shadow-none d-flex align-items-center justify-content-between bg-primary text-white w-100 navbar-vertical-toggle"
                    data-toggle="collapse" href="#navbar-vertical"
                    style="height: 65px; margin-top: -1px; padding: 0 30px;">
                    <h6 class="m-0">Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0"
                    id="navbar-vertical" style="
    position: absolute;
    z-index: 1;
    width: 90.5%;
    background: rgb(255, 255, 255);
">
                    <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
                        <?php
                        $args = array(
                            'taxonomy' => 'product_cat',
                            'orderby' => 'name',
                            'show_count' => 0,
                            'pad_counts' => 0,
                            'hierarchical' => 1,
                            'title_li' => '',
                            'hide_empty' => 0,
                            'exclude' => array(get_option('default_product_cat')), // Exclude the default uncategorized category
                        );
                        $all_categories = get_categories($args);
                        foreach ($all_categories as $cat) {
                            if ($cat->category_parent == 0) {
                                $category_id = $cat->term_id;
                                $sub_cats = get_categories(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'child_of' => $category_id,
                                        'orderby' => 'name',
                                        'show_count' => 0,
                                        'pad_counts' => 0,
                                        'hierarchical' => 1,
                                        'title_li' => '',
                                        'hide_empty' => 0
                                    )
                                );

                                echo '<div class="nav-item' . ($sub_cats ? ' dropdown' : '') . '">';
                                echo '<a href="' . get_term_link($cat->slug, 'product_cat') . '" class="nav-link" ' . ($sub_cats ? 'data-toggle="dropdown"' : '') . '>' . $cat->name . ($sub_cats ? '<i class="fa fa-angle-down float-right mt-1"></i>' : '') . '</a>';

                                if ($sub_cats) {
                                    echo '<div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0">';
                                    foreach ($sub_cats as $sub_category) {
                                        echo '<a href="' . get_term_link($sub_category->slug, 'product_cat') . '" class="dropdown-item">' . $sub_category->name . '</a>';
                                    }
                                    echo '</div>';
                                }
                                echo '</div>';
                            }
                        }
                        ?>
                    </div>
                </nav>
            </div>

            <div class="col-lg-9">

                <nav class="navbar navbar-expand-lg bg-light navbar-light py-3 py-lg-0 px-0">

                    <a href="<?php echo home_url(); ?>" class="text-decoration-none d-block d-lg-none">

                        <h1 class="m-0 display-5 font-weight-semi-bold"><span
                                class="text-primary font-weight-bold border px-3 mr-1">E</span>Shopper</h1>

                    </a>

                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">

                        <span class="navbar-toggler-icon"></span>

                    </button>

                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">

                        <div class="navbar-nav mr-auto py-0">

                            <?php

                            wp_nav_menu(

                                array(

                                    'theme_location' => 'primary-menu',

                                    'depth' => 2,

                                    'container' => false,

                                    'menu_class' => 'navbar-nav mr-auto py-0',

                                )

                            );

                            ?>

                        </div>

                        <div class="navbar-nav ml-auto py-0">
                            <?php
                            if (is_user_logged_in()): ?>
                                <a style="margin-right: 10px;" class="btn btn-primary"
                                    href="<?php echo get_permalink(get_option("woocommerce_myaccount_page_id")) ?>">My
                                    Account</a>

                                <a class="btn btn-danger"
                                    href="<?php echo wp_logout_url(get_permalink(get_option("woocommerce_myaccount_page_id"))) ?>">Logout</a>

                            <?php else: ?>
                                <a class="btn btn-primary"
                                    href="<?php echo get_permalink(get_option("woocommerce_myaccount_page_id")) ?>">Login/Register</a>
                            <?php endif; ?>
                        </div>


                    </div>

                </nav>

                <?php if (is_front_page()): ?>

                    <div id="header-carousel" class="carousel slide" data-ride="carousel">

                        <div class="carousel-inner">

                            <div class="carousel-item active" style="height: 410px;">

                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/carousel-1.jpg"
                                    alt="Image">

                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">

                                    <div class="p-3" style="max-width: 700px;">

                                        <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First

                                            Order</h4>

                                        <h3 class="display-4 text-white font-weight-semi-bold mb-4">Fashionable Dress</h3>

                                        <a href="<?php echo esc_url(home_url('/shop-page')); ?>"
                                            class="btn btn-light py-2 px-3">Shop Now</a>

                                    </div>

                                </div>

                            </div>

                            <div class="carousel-item" style="height: 410px;">

                                <img class="img-fluid" src="<?php echo get_template_directory_uri(); ?>/img/carousel-2.jpg"
                                    alt="Image">

                                <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">

                                    <div class="p-3" style="max-width: 700px;">

                                        <h4 class="text-light text-uppercase font-weight-medium mb-3">10% Off Your First

                                            Order</h4>

                                        <h3 class="display-4 text-white font-weight-semi-bold mb-4">Reasonable Price</h3>

                                        <a href="<?php echo esc_url(home_url('/shop-page')); ?>"
                                            class="btn btn-light py-2 px-3">Shop Now</a>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <a class="carousel-control-prev" href="#header-carousel" data-slide="prev">

                            <div class="btn btn-dark" style="width: 45px; height: 45px;">

                                <span class="carousel-control-prev-icon mb-n2"></span>

                            </div>

                        </a>

                        <a class="carousel-control-next" href="#header-carousel" data-slide="next">

                            <div class="btn btn-dark" style="width: 45px; height: 45px;">

                                <span class="carousel-control-next-icon mb-n2"></span>

                            </div>

                        </a>

                    </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <!-- Navbar End -->



    <!-- Content here -->





    <script>

        jQuery(document).ready(function ($) {

            // Toggle the 'show' class on the #navbar-vertical when the button is clicked

            $('.navbar-vertical-toggle').click(function (event) {

                event.preventDefault();

                $('#navbar-vertical').collapse('toggle');

            });

        });
    </script>