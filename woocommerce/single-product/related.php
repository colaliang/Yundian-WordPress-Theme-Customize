<?php
/**
 * Related Products
 *
 * This template overrides the default WooCommerce related.php for Tailwind CSS styling.
 *
 * @package ERDU_Lighting/WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

if ($related_products) : ?>

    <section class="related products mt-16 pt-12 border-t border-gray-200">
        <?php
        $heading = apply_filters('woocommerce_product_related_products_heading', __('Related Products', 'erdu-wp'));

        if ($heading) :
            ?>
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-gray-900"><?php echo esc_html($heading); ?></h2>
            </div>
        <?php endif; ?>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php
            // We use our custom B2B content-product.php card structure
            woocommerce_product_loop_start();

            foreach ($related_products as $related_product) : ?>

                <?php
                $post_object = get_post($related_product->get_id());

                setup_postdata($GLOBALS['post'] = &$post_object); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found

                wc_get_template_part('content', 'product');
                ?>

            <?php endforeach;

            woocommerce_product_loop_end();
            ?>
        </div>
    </section>

<?php
endif;

wp_reset_postdata();
