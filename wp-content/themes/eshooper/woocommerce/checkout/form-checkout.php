<?php
/**
 * Checkout Form
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/form-checkout.php.
 *
 * @package WooCommerce/Templates
 * @version 4.0.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_checkout_form', $checkout);

// Get base country
$default_country = WC()->countries->get_base_country();
$countries = WC()->countries->get_countries();
$states = WC()->countries->get_states($default_country);

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

<div class="container-fluid pt-5">
    <div class="row px-xl-5">
        <div class="col-lg-8">
            <form name="checkout" method="post" class="checkout woocommerce-checkout" action="<?php echo esc_url(wc_get_checkout_url()); ?>" enctype="multipart/form-data" id="woocommerce-checkout-form">

                <div id="customer_details" class="mb-4">
                    <h4 class="font-weight-semi-bold mb-4"><?php esc_html_e('Billing Address', 'woocommerce'); ?></h4>

                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label><?php esc_html_e('First Name', 'woocommerce'); ?></label>
                            <input class="form-control" type="text" name="billing_first_name" placeholder="<?php esc_attr_e('John', 'woocommerce'); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label><?php esc_html_e('Last Name', 'woocommerce'); ?></label>
                            <input class="form-control" type="text" name="billing_last_name" placeholder="<?php esc_attr_e('Doe', 'woocommerce'); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label><?php esc_html_e('E-mail', 'woocommerce'); ?></label>
                            <input class="form-control" type="email" name="billing_email" placeholder="<?php esc_attr_e('example@email.com', 'woocommerce'); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label><?php esc_html_e('Mobile No', 'woocommerce'); ?></label>
                            <input class="form-control" type="tel" name="billing_phone" placeholder="<?php esc_attr_e('+123 456 789', 'woocommerce'); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label><?php esc_html_e('Address Line 1', 'woocommerce'); ?></label>
                            <input class="form-control" type="text" name="billing_address_1" placeholder="<?php esc_attr_e('123 Street', 'woocommerce'); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label><?php esc_html_e('Address Line 2', 'woocommerce'); ?></label>
                            <input class="form-control" type="text" name="billing_address_2" placeholder="<?php esc_attr_e('123 Street', 'woocommerce'); ?>">
                        </div>
                        <div class="col-md-6 form-group">
                            <label><?php esc_html_e('Country', 'woocommerce'); ?></label>
                            <?php
                            woocommerce_form_field(
                                'billing_country',
                                array(
                                    'type' => 'select',
                                    'class' => array('form-control', 'custom-select'),
                                    'label_class' => array('control-label'),
                                    'options' => $countries,
                                    'default' => $default_country,
                                    'required' => true,
                                    'ajax' => true, // Add ajax attribute
                                    'custom_attributes' => array(
                                        'data-placeholder' => __('Select a country&hellip;', 'woocommerce'),
                                    ),
                                )
                            );
                            ?>
                        </div>
                        <div class="col-md-6 form-group">
                            <label><?php esc_html_e('City', 'woocommerce'); ?></label>
                            <input class="form-control" type="text" name="billing_city" placeholder="<?php esc_attr_e('New York', 'woocommerce'); ?>" required>
                        </div>
                        <div class="col-md-6 form-group">
                            <label><?php esc_html_e('State', 'woocommerce'); ?></label>
                            <?php
                            woocommerce_form_field(
                                'billing_state',
                                array(
                                    'type' => 'select',
                                    'class' => array('form-control', 'custom-select'),
                                    'label_class' => array('control-label'),
                                    'options' => $states,
                                    'required' => true,
                                    'custom_attributes' => array(
                                        'data-placeholder' => __('Select a state&hellip;', 'woocommerce'),
                                    ),
                                )
                            );
                            ?>
                        </div>
                        <div class="col-md-6 form-group">
                            <label><?php esc_html_e('ZIP Code', 'woocommerce'); ?></label>
                            <input class="form-control" type="text" name="billing_postcode" placeholder="<?php esc_attr_e('123', 'woocommerce'); ?>" required>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="createaccount" name="createaccount">
                                <label class="custom-control-label" for="createaccount"><?php esc_html_e('Create an account', 'woocommerce'); ?></label>
                            </div>
                        </div>
                        <div class="col-md-12 form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="ship-to-different-address" name="ship_to_different_address" data-toggle="collapse" data-target="#shipping-address">
                                <label class="custom-control-label" for="ship-to-different-address"><?php esc_html_e('Ship to a different address', 'woocommerce'); ?></label>
                            </div>
                        </div>
                    </div>

                    <div class="collapse mb-4" id="shipping-address">
                        <h4 class="font-weight-semi-bold mb-4"><?php esc_html_e('Shipping Address', 'woocommerce'); ?></h4>
                        <div class="row">
                            <div class="col-md-6 form-group">
                                <label><?php esc_html_e('First Name', 'woocommerce'); ?></label>
                                <input class="form-control" type="text" name="shipping_first_name" placeholder="<?php esc_attr_e('John', 'woocommerce'); ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php esc_html_e('Last Name', 'woocommerce'); ?></label>
                                <input class="form-control" type="text" name="shipping_last_name" placeholder="<?php esc_attr_e('Doe', 'woocommerce'); ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php esc_html_e('E-mail', 'woocommerce'); ?></label>
                                <input class="form-control" type="email" name="shipping_email" placeholder="<?php esc_attr_e('example@email.com', 'woocommerce'); ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php esc_html_e('Mobile No', 'woocommerce'); ?></label>
                                <input class="form-control" type="tel" name="shipping_phone" placeholder="<?php esc_attr_e('+123 456 789', 'woocommerce'); ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php esc_html_e('Address Line 1', 'woocommerce'); ?></label>
                                <input class="form-control" type="text" name="shipping_address_1" placeholder="<?php esc_attr_e('123 Street', 'woocommerce'); ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php esc_html_e('Address Line 2', 'woocommerce'); ?></label>
                                <input class="form-control" type="text" name="shipping_address_2" placeholder="<?php esc_attr_e('123 Street', 'woocommerce'); ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php esc_html_e('Country', 'woocommerce'); ?></label>
                                <?php
                                woocommerce_form_field(
                                    'shipping_country',
                                    array(
                                        'type' => 'select',
                                        'class' => array('form-control', 'custom-select'),
                                        'label_class' => array('control-label'),
                                        'options' => $countries,
                                        'default' => $default_country,
                                    )
                                );
                                ?>
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php esc_html_e('City', 'woocommerce'); ?></label>
                                <input class="form-control" type="text" name="shipping_city" placeholder="<?php esc_attr_e('New York', 'woocommerce'); ?>">
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php esc_html_e('State', 'woocommerce'); ?></label>
                                <?php
                                woocommerce_form_field(
                                    'shipping_state',
                                    array(
                                        'type' => 'select',
                                        'class' => array('form-control', 'custom-select'),
                                        'label_class' => array('control-label'),
                                        'options' => $states,
                                    )
                                );
                                ?>
                            </div>
                            <div class="col-md-6 form-group">
                                <label><?php esc_html_e('ZIP Code', 'woocommerce'); ?></label>
                                <input class="form-control" type="text" name="shipping_postcode" placeholder="<?php esc_attr_e('123', 'woocommerce'); ?>">
                            </div>
                        </div>
                    </div>

                    <?php do_action('woocommerce_before_checkout_billing_form', $checkout); ?>

                    <?php foreach ($checkout->checkout_fields['billing'] as $key => $field) : ?>
                        <div class="form-group">
                            <?php woocommerce_form_field($key, $field, $checkout->get_value($key)); ?>
                        </div>
                    <?php endforeach; ?>

                    <?php do_action('woocommerce_after_checkout_billing_form', $checkout); ?>
                </div>

                <?php do_action('woocommerce_checkout_before_order_review_heading'); ?>

                <div id="order_review" class="woocommerce-checkout-review-order mb-4">
                    <h4 class="font-weight-semi-bold mb-4"><?php esc_html_e('Payment Methos', 'woocommerce'); ?></h4>

                    <div class="woocommerce-checkout-payment">
                        <?php do_action('woocommerce_checkout_payment'); ?>
                    </div>

                    <?php do_action('woocommerce_checkout_after_order_review'); ?>
                </div>

            </form>
        </div>

        <div class="col-lg-4">
            <div id="order_review" class="woocommerce-checkout-review-order">
                <?php do_action('woocommerce_checkout_before_order_review'); ?>

                <h4 class="font-weight-semi-bold mb-4"><?php esc_html_e('Order Summary', 'woocommerce'); ?></h4>

                <div class="woocommerce-checkout-order-review">
                    <?php woocommerce_order_review(); ?>
                </div>

                <?php do_action('woocommerce_checkout_after_order_review'); ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    jQuery(function($) {
        // On country change
        $('select#billing_country').change(function() {
            var country = $(this).val();
            var stateField = $('select#billing_state');

            // Make AJAX request
            $.ajax({
                type: 'POST',
                url: wc_checkout_params.ajax_url,
                data: {
                    'action': 'get_states',
                    'country': country
                },
                success: function(states) {
                    // Replace state field HTML with new options
                    stateField.html(states);
                    stateField.change(); // Trigger change event to refresh state field display
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Trigger country change on page load
        $('select#billing_country').change();
    });
</script>
