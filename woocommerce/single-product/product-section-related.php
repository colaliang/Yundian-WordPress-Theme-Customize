<?php
/**
 * Single Product: Related Products Section (Between Section 1 and Section 2)
 *
 * Expected variables:
 *   $product (WC_Product)
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

if (!function_exists('get_field')) {
    return;
}

$mode       = get_field('related_products_mode') ?: 'auto';
$max_count  = (int) (get_field('related_products_max') ?: 4);
$show_title = get_field('related_show_title') !== false ? get_field('related_show_title') : true;
$show_price = get_field('related_show_price') !== false ? get_field('related_show_price') : true;
$show_moq   = get_field('related_show_moq') !== false ? get_field('related_show_moq') : true;
$show_certs = get_field('related_show_certs') !== false ? get_field('related_show_certs') : true;
$section_title = get_field('related_section_title') ?: __('Related Products', 'erdu-wp');

$related_ids = array();

if ($mode === 'manual') {
    $manual_ids = get_field('related_products_manual');
    if (!empty($manual_ids)) {
        $related_ids = is_array($manual_ids) ? $manual_ids : array($manual_ids);
    }
} else {
    // Auto match by category
    $category_ids = wp_get_post_terms($product->get_id(), 'product_cat', array('fields' => 'ids'));
    if (!empty($category_ids)) {
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => $max_count,
            'post__not_in'   => array($product->get_id()),
            'tax_query'      => array(
                array(
                    'taxonomy' => 'product_cat',
                    'field'    => 'id',
                    'terms'    => $category_ids,
                    'operator' => 'IN',
                ),
            ),
            'orderby'        => 'rand',
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $related_ids[] = get_the_ID();
            }
        }
        wp_reset_postdata();
    }
}

if (empty($related_ids)) {
    return;
}

// Limit to max count
$related_ids = array_slice($related_ids, 0, $max_count);
?>

<!-- Section: Related Products -->
<section class="erdu-related-products-section py-12 mb-8">
    <div class="erdu-container">
        <h2 class="text-2xl font-bold text-gray-900 mb-8 text-center">
            <?php echo esc_html($section_title); ?>
        </h2>

        <div class="erdu-related-products-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <?php foreach ($related_ids as $related_id) :
                $related_product = wc_get_product($related_id);
                if (!$related_product) continue;

                $related_image = get_the_post_thumbnail_url($related_id, 'woocommerce_thumbnail');
                $related_title = get_the_title($related_id);
                $related_permalink = get_permalink($related_id);
                $related_moq = get_field('product_moq', $related_id);
                $related_certs = get_field('product_certificates', $related_id);
            ?>
                <a href="<?php echo esc_url($related_permalink); ?>" class="erdu-related-product-card group block bg-white rounded-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-lg hover:border-gray-200">
                    <!-- Product Image -->
                    <div class="relative aspect-square overflow-hidden bg-gray-50">
                        <?php if ($related_image) : ?>
                            <img src="<?php echo esc_url($related_image); ?>" alt="<?php echo esc_attr($related_title); ?>" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy">
                        <?php else : ?>
                            <div class="w-full h-full flex items-center justify-center bg-gray-100">
                                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        <?php endif; ?>

                        <!-- Certification Badges Overlay -->
                        <?php if ($show_certs && !empty($related_certs) && is_array($related_certs)) : ?>
                            <div class="absolute bottom-2 left-2 flex flex-wrap gap-1">
                                <?php
                                $cert_count = 0;
                                foreach ($related_certs as $cert) :
                                    if ($cert_count >= 3) break;
                                    if (!empty($cert['cert_image'])) :
                                        $cert_count++;
                                ?>
                                    <img src="<?php echo esc_url($cert['cert_image']); ?>" alt="<?php echo esc_attr($cert['cert_name'] ?? ''); ?>" class="w-8 h-8 rounded-full object-cover border border-white shadow-sm" loading="lazy">
                                <?php
                                    endif;
                                endforeach;
                                ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Product Info -->
                    <div class="p-4">
                        <?php if ($show_title) : ?>
                            <h3 class="text-sm font-semibold text-gray-900 leading-snug mb-2 line-clamp-2 group-hover:text-orange-600 transition-colors">
                                <?php echo esc_html($related_title); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ($show_price && $related_product->get_price_html()) : ?>
                            <div class="text-lg font-bold text-gray-900 mb-1">
                                <?php echo $related_product->get_price_html(); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($show_moq && $related_moq) : ?>
                            <div class="text-xs text-gray-500">
                                <?php esc_html_e('MOQ:', 'erdu-wp'); ?> <span class="font-medium text-gray-700"><?php echo esc_html($related_moq); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
