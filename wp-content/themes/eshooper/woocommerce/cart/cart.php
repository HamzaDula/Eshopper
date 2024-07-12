<?php
/**
 * WooCommerce Cart Page
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/cart/cart.php.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.8.0
 */

defined('ABSPATH') || exit;

do_action('woocommerce_before_cart'); ?>

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

<form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <?php do_action('woocommerce_before_cart_table'); ?>

                <table class="woocommerce-cart-form__contents table table-bordered text-center mb-0">
                    <thead class="bg-secondary text-dark">
                        <tr>
                            <th><?php esc_html_e('Product', 'woocommerce'); ?></th>
                            <th><?php esc_html_e('Image', 'woocommerce'); ?></th>
                            <th><?php esc_html_e('Price', 'woocommerce'); ?></th>
                            <th><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                            <th><?php esc_html_e('Total', 'woocommerce'); ?></th>
                            <th><?php esc_html_e('Remove', 'woocommerce'); ?></th>
                        </tr>
                    </thead>
                    <tbody class="woocommerce-cart-form__cart-items">
                        <?php
                        foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) :
                            $_product = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                            $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                            if ($_product && $_product->exists() && $cart_item['quantity'] > 0) {
                                ?>
                                <tr class="woocommerce-cart-form__cart-item">
                                    <td class="product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key);

                                        // Meta data
                                        echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                                        // Backorder notification
                                        if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                            echo '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>';
                                        }
                                        ?>
                                    </td>

                                    <td class="product-thumbnail" data-title="<?php esc_attr_e('Image', 'woocommerce'); ?>">
                                        <?php
                                        $thumbnail = $_product->get_image(array(100, 100));
                                        if (!$_product->is_visible()) {
                                            echo $thumbnail;
                                        } else {
                                            printf('<a href="%s">%s</a>', esc_url($_product->get_permalink($cart_item)), $thumbnail);
                                        }
                                        ?>
                                    </td>

                                    <td class="product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                        ?>
                                    </td>

                                    <td class="product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                                        <?php
                                        if ($_product->is_sold_individually()) {
                                            $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                        } else {
                                            $product_quantity = woocommerce_quantity_input(array(
                                                'input_name'  => "cart[{$cart_item_key}][qty]",
                                                'input_value' => $cart_item['quantity'],
                                                'max_value'   => $_product->get_max_purchase_quantity(),
                                                'min_value'   => '0',
                                            ), $_product, false);
                                        }

                                        echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                                        ?>
                                    </td>

                                    <td class="product-subtotal" data-title="<?php esc_attr_e('Total', 'woocommerce'); ?>">
                                        <?php
                                        echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                        ?>
                                    </td>

                                    <td class="product-remove">
                                        <?php
                                        echo apply_filters(
                                            'woocommerce_cart_item_remove_link',
                                            sprintf(
                                                '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
                                                esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                esc_html__('Remove this item', 'woocommerce'),
                                                esc_attr($product_id),
                                                esc_attr($_product->get_sku())
                                            ),
                                            $cart_item_key
                                        );
                                        ?>
                                    </td>
                                </tr>
                        <?php }
                        endforeach; ?>

                    </tbody>
                </table>

                <?php do_action('woocommerce_after_cart_table'); ?>
            </div>

            <div class="col-lg-4">
                <form class="woocommerce-cart-form mb-5" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                    <div class="input-group">
                        <input type="text" class="form-control p-4" name="coupon_code" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>" />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_html_e('Apply coupon', 'woocommerce'); ?></button>
                        </div>
                    </div>
                </form>

                <?php do_action('woocommerce_cart_collaterals'); ?>
            </div>
        </div>
    </div>
    <?php do_action('woocommerce_cart_actions'); ?>
    <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
</form>

<?php do_action('woocommerce_after_cart'); ?>

<?php get_footer('woocommerce'); ?>
