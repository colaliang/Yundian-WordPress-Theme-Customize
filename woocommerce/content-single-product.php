<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 *
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden', $product); ?>>

    <!-- Top Section: Image & Summary -->
    <div class="grid lg:grid-cols-2 gap-0 lg:gap-8 p-6 lg:p-10">
        
        <!-- Left: Product Image Gallery -->
        <div class="product-gallery-wrapper relative mb-8 lg:mb-0">
            <?php
            /**
             * Hook: woocommerce_before_single_product_summary.
             *
             * @hooked woocommerce_show_product_sale_flash - 10 (Removed/Not relevant for B2B usually, but kept for structure)
             * @hooked woocommerce_show_product_images - 20
             */
            do_action('woocommerce_before_single_product_summary');
            ?>
        </div>

        <!-- Right: Product Summary -->
        <div class="product-summary-wrapper flex flex-col">
            
            <?php
            // Custom B2B Subtitle via ACF
            $subtitle = function_exists('get_field') ? get_field('product_subtitle') : '';
            if ($subtitle) {
                echo '<div class="text-orange-600 font-medium mb-2 uppercase tracking-wide text-sm">' . esc_html($subtitle) . '</div>';
            }
            ?>

            <h1 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                <?php the_title(); ?>
            </h1>

            <div class="prose prose-sm text-gray-600 mb-8 max-w-none">
                <?php the_excerpt(); ?>
            </div>

            <!-- Key Features / Attributes Grid -->
            <div class="bg-gray-50 rounded-lg p-5 mb-8">
                <h4 class="text-sm font-bold text-gray-800 mb-3 uppercase"><?php esc_html_e('Key Specifications', 'erdu-wp'); ?></h4>
                <div class="grid grid-cols-2 gap-y-4 gap-x-4">
                    <?php 
                    // Render selected attributes automatically
                    $attributes = $product->get_attributes();
                    $display_limit = 6;
                    $count = 0;
                    foreach ($attributes as $attribute) {
                        if ($count >= $display_limit) break;
                        // Skip non-visible attributes
                        if (!$attribute->get_visible()) continue;
                        
                        $name = wc_attribute_label($attribute->get_name());
                        $value = '';
                        
                        if ($attribute->is_taxonomy()) {
                            $terms = wp_get_post_terms($product->get_id(), $attribute->get_name(), 'all');
                            $values = array();
                            foreach ($terms as $term) {
                                $values[] = $term->name;
                            }
                            $value = implode(', ', $values);
                        } else {
                            $value = $attribute->get_options()[0];
                        }
                        
                        if ($value) {
                            echo '<div>';
                            echo '<span class="block text-xs text-gray-400 uppercase mb-1">' . esc_html($name) . '</span>';
                            echo '<span class="block text-sm font-medium text-gray-900">' . esc_html($value) . '</span>';
                            echo '</div>';
                            $count++;
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="mt-auto">
                <?php
                /**
                 * Hook: woocommerce_single_product_summary.
                 *
                 * @hooked woocommerce_template_single_title - 5 (Removed via theme setup usually, but we output manually above)
                 * @hooked woocommerce_template_single_rating - 10 (Removed in B2B setup)
                 * @hooked woocommerce_template_single_price - 10 (Removed in B2B setup)
                 * @hooked woocommerce_template_single_excerpt - 20 (Removed via theme setup usually, we output manually above)
                 * @hooked woocommerce_template_single_add_to_cart - 30 (Removed in B2B setup)
                 * @hooked woocommerce_template_single_meta - 40
                 * @hooked woocommerce_template_single_sharing - 50
                 * @hooked erdu_add_b2b_inquiry_button - 30 (Added in B2B setup)
                 */
                
                // Remove the default title and excerpt since we hardcoded them for layout control
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_title', 5);
                remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20);
                
                do_action('woocommerce_single_product_summary');
                ?>
            </div>

        </div>
    </div>

    <!-- Bottom Section: Tabs & Detailed Content -->
    <div class="border-t border-gray-200">
        <?php
        /**
         * Hook: woocommerce_after_single_product_summary.
         *
         * @hooked woocommerce_output_product_data_tabs - 10
         * @hooked woocommerce_upsell_display - 15
         * @hooked woocommerce_output_related_products - 20
         */
        
        // We'll customize the tabs appearance via CSS (Tailwind) in our theme stylesheet
        // or by overriding the tabs template if needed.
        do_action('woocommerce_after_single_product_summary');
        ?>
    </div>
</div>

<?php do_action('woocommerce_after_single_product'); ?>
