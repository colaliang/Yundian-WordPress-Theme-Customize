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

$product_id    = $product->get_id();
$mode          = get_field('related_products_mode', $product_id) ?: 'auto';
$max_count     = max(1, (int) (get_field('related_products_max', $product_id) ?: 4));
$section_title = get_field('related_section_title', $product_id) ?: __('Related Products', 'erdu-wp');

// True/false ACF fields return falsy values when unchecked, so read raw meta to
// distinguish between "field not saved yet" and an intentional off state.
$show_title = metadata_exists('post', $product_id, 'related_show_title')
    ? (bool) get_post_meta($product_id, 'related_show_title', true)
    : true;
$show_price = metadata_exists('post', $product_id, 'related_show_price')
    ? (bool) get_post_meta($product_id, 'related_show_price', true)
    : true;
$show_moq = metadata_exists('post', $product_id, 'related_show_moq')
    ? (bool) get_post_meta($product_id, 'related_show_moq', true)
    : true;
$show_certs = metadata_exists('post', $product_id, 'related_show_certs')
    ? (bool) get_post_meta($product_id, 'related_show_certs', true)
    : true;

$related_ids = array();

if ($mode === 'manual') {
    $manual_ids = get_field('related_products_manual', $product_id);
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

$related_ids = array_values(array_filter(array_unique(array_map('intval', $related_ids)), function ($related_id) use ($product_id) {
    return $related_id > 0 && $related_id !== $product_id;
}));

if (empty($related_ids)) {
    return;
}

$related_ids = array_slice($related_ids, 0, $max_count);
?>

<!-- Section: Related Products -->
<section class="erdu-related-products-section">
    <div class="erdu-container erdu-related-products-inner">
        <h2 class="erdu-related-products-title">
            <?php echo esc_html($section_title); ?>
        </h2>

        <div class="erdu-related-products-grid">
            <?php foreach ($related_ids as $related_id) :
                $related_product = wc_get_product($related_id);
                if (!$related_product) {
                    continue;
                }

                $related_image = get_the_post_thumbnail_url($related_id, 'woocommerce_thumbnail');
                $related_title = get_the_title($related_id);
                $related_permalink = get_permalink($related_id);
                $related_moq = get_field('product_moq', $related_id);
                $related_certs = get_field('product_certificates', $related_id);
                $price_html = $related_product->get_price_html();

                $cert_badges = array();
                if ($show_certs && !empty($related_certs) && is_array($related_certs)) {
                    foreach ($related_certs as $cert) {
                        if (empty($cert['cert_image'])) {
                            continue;
                        }

                        $cert_badges[] = array(
                            'image' => $cert['cert_image'],
                            'name'  => isset($cert['cert_name']) ? $cert['cert_name'] : '',
                        );

                        if (count($cert_badges) >= 3) {
                            break;
                        }
                    }
                }
            ?>
                <a href="<?php echo esc_url($related_permalink); ?>" class="erdu-related-product-card">
                    <div class="erdu-related-product-media">
                        <?php if ($related_image) : ?>
                            <img src="<?php echo esc_url($related_image); ?>" alt="<?php echo esc_attr($related_title); ?>" class="erdu-related-product-image" loading="lazy">
                        <?php else : ?>
                            <div class="erdu-related-product-placeholder" aria-hidden="true">
                                <svg class="erdu-related-product-placeholder-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($cert_badges)) : ?>
                            <div class="erdu-related-product-badges" aria-hidden="true">
                                <?php foreach ($cert_badges as $badge) : ?>
                                    <img src="<?php echo esc_url($badge['image']); ?>" alt="<?php echo esc_attr($badge['name']); ?>" class="erdu-related-product-badge" loading="lazy">
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="erdu-related-product-body">
                        <?php if ($show_title) : ?>
                            <h3 class="erdu-related-product-title">
                                <?php echo esc_html($related_title); ?>
                            </h3>
                        <?php endif; ?>

                        <?php if ($show_price && $price_html) : ?>
                            <div class="erdu-related-product-price">
                                <?php echo wp_kses_post($price_html); ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($show_moq && $related_moq) : ?>
                            <div class="erdu-related-product-meta">
                                <?php esc_html_e('MOQ:', 'erdu-wp'); ?>
                                <span class="erdu-related-product-meta-value"><?php echo esc_html($related_moq); ?></span>
                            </div>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
