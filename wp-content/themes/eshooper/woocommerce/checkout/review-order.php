<?php
/**
 * Review order
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/review-order.php.
 *
 * @package WooCommerce\Templates
 * @version 5.2.0
 */

defined( 'ABSPATH' ) || exit;
?>

<div class="woocommerce-checkout-review-order">
    <?php
    do_action( 'woocommerce_review_order_before_cart_contents' );

    foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
        $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );

        if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_checkout_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
            ?>
            <div class="d-flex justify-content-between">
                <p><?php echo wp_kses_post( apply_filters( 'woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key ) ); ?></p>
                <p><?php echo wc_price( $_product->get_price() * $cart_item['quantity'] ); ?></p>
            </div>
            <?php
        }
    }

    do_action( 'woocommerce_review_order_after_cart_contents' );
    ?>

    <div class="d-flex justify-content-between">
        <p><?php esc_html_e( 'Subtotal', 'woocommerce' ); ?></p>
        <p><?php wc_cart_totals_subtotal_html(); ?></p>
    </div>

    <?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
        <div class="d-flex justify-content-between">
            <p><?php wc_cart_totals_coupon_label( $coupon ); ?></p>
            <p><?php wc_cart_totals_coupon_html( $coupon ); ?></p>
        </div>
    <?php endforeach; ?>

    <?php if ( WC()->cart->needs_shipping() && WC()->cart->show_shipping() ) : ?>
        <?php do_action( 'woocommerce_review_order_before_shipping' ); ?>
        <?php wc_cart_totals_shipping_html(); ?>
        <?php do_action( 'woocommerce_review_order_after_shipping' ); ?>
    <?php endif; ?>

    <?php foreach ( WC()->cart->get_fees() as $fee ) : ?>
        <div class="d-flex justify-content-between">
            <p><?php echo esc_html( $fee->name ); ?></p>
            <p><?php wc_cart_totals_fee_html( $fee ); ?></p>
        </div>
    <?php endforeach; ?>

    <?php if ( wc_tax_enabled() && ! WC()->cart->display_prices_including_tax() ) : ?>
        <?php if ( 'itemized' === get_option( 'woocommerce_tax_total_display' ) ) : ?>
            <?php foreach ( WC()->cart->get_tax_totals() as $code => $tax ) : ?>
                <div class="d-flex justify-content-between">
                    <p><?php echo esc_html( $tax->label ); ?></p>
                    <p><?php echo wp_kses_post( $tax->formatted_amount ); ?></p>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <div class="d-flex justify-content-between">
                <p><?php echo esc_html( WC()->countries->tax_or_vat() ); ?></p>
                <p><?php wc_cart_totals_taxes_total_html(); ?></p>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php do_action( 'woocommerce_review_order_before_order_total' ); ?>

    <div class="d-flex justify-content-between">
        <p><?php esc_html_e( 'Total', 'woocommerce' ); ?></p>
        <p><?php wc_cart_totals_order_total_html(); ?></p>
    </div>

    <?php do_action( 'woocommerce_review_order_after_order_total' ); ?>
</div>
