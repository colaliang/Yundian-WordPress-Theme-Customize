<?php
/**
 * The Template for displaying all single products
 *
 * This template overrides the default WooCommerce single-product.php for B2B catalog structure.
 *
 * @package ERDU_Lighting/WooCommerce
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

get_header('shop'); ?>

<div class="erdu-product-landing-page bg-white">
    <?php
        /**
         * woocommerce_before_main_content hook.
         *
         * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
         * @hooked woocommerce_breadcrumb - 20 (Removed for landing page style, or moved inside content)
         */
        remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20);
        do_action('woocommerce_before_main_content');
    ?>

    <?php while (have_posts()) : ?>
        <?php the_post(); ?>

        <?php wc_get_template_part('content', 'single-product'); ?>

    <?php endwhile; // end of the loop. ?>

    <?php
        /**
         * woocommerce_after_main_content hook.
         *
         * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
         */
        do_action('woocommerce_after_main_content');
    ?>
</div>

<?php
get_footer('shop');
