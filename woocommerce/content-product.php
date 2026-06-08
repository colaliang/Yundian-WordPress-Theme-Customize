<?php
/**
 * The template for displaying product content within loops
 *
 * This template overrides the default WooCommerce content-product.php for a B2B catalog card.
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

global $product;

// Ensure visibility.
if (empty($product) || !$product->is_visible()) {
    return;
}

// Extract attributes for B2B summary (e.g., Power, CCT)
$power = $product->get_attribute('power');
$cct = $product->get_attribute('cct');
$beam_angle = $product->get_attribute('beam-angle');

?>
<li <?php wc_product_class('group', $product); ?>>
    <div class="bg-white rounded-lg overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow h-full flex flex-col group-hover:border-orange-200">
        <!-- Thumbnail -->
        <a href="<?php echo esc_url($product->get_permalink()); ?>" class="block relative overflow-hidden bg-gray-100 aspect-w-4 aspect-h-3">
            <?php
            $image_size = apply_filters('single_product_archive_thumbnail_size', 'woocommerce_thumbnail');
            echo $product->get_image($image_size, array('class' => 'w-full h-full object-cover object-center group-hover:scale-105 transition-transform duration-300'));
            ?>
        </a>

        <!-- Content -->
        <div class="p-5 flex flex-col flex-grow">
            <!-- Category / Tag -->
            <div class="text-xs text-orange-600 font-semibold uppercase tracking-wider mb-2">
                <?php echo wc_get_product_category_list($product->get_id(), ', ', '', ''); ?>
            </div>
            
            <!-- Title -->
            <h2 class="text-lg font-bold text-gray-900 mb-3 leading-tight line-clamp-2">
                <a href="<?php echo esc_url($product->get_permalink()); ?>" class="hover:text-orange-600 transition-colors">
                    <?php echo esc_html($product->get_name()); ?>
                </a>
            </h2>

            <!-- Key Attributes Snippet -->
            <div class="mt-auto grid grid-cols-2 gap-2 text-xs text-gray-600 mb-4 bg-gray-50 p-3 rounded-md">
                <?php if ($power) : ?>
                    <div><span class="text-gray-400 block text-[10px] uppercase">Power</span><span class="font-medium"><?php echo esc_html($power); ?></span></div>
                <?php endif; ?>
                <?php if ($cct) : ?>
                    <div><span class="text-gray-400 block text-[10px] uppercase">CCT</span><span class="font-medium"><?php echo esc_html($cct); ?></span></div>
                <?php endif; ?>
                <?php if ($beam_angle) : ?>
                    <div><span class="text-gray-400 block text-[10px] uppercase">Beam</span><span class="font-medium"><?php echo esc_html($beam_angle); ?></span></div>
                <?php endif; ?>
            </div>

            <!-- Action -->
            <a href="<?php echo esc_url($product->get_permalink()); ?>" class="inline-flex items-center justify-center w-full py-2.5 px-4 text-sm font-medium text-orange-600 bg-orange-50 rounded hover:bg-orange-600 hover:text-white transition-colors">
                <?php esc_html_e('View Details', 'erdu-wp'); ?> &rarr;
            </a>
        </div>
    </div>
</li>
