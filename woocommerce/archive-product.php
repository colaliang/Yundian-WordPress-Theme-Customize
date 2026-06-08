<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template overrides the default WooCommerce archive-product.php for B2B catalog structure.
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

get_header('shop');

// Determine Hero content based on current term or fallback
$hero_title = woocommerce_page_title(false);
$hero_desc = '';
$hero_bg = 'https://images.unsplash.com/photo-1565814329452-e1efa11c5b89?w=1200'; // Default fallback

if (is_product_category() || is_product_tag()) {
    global $wp_query;
    $term = $wp_query->get_queried_object();
    
    if ($term) {
        $hero_desc = $term->description;
        
        // Try ACF Banner
        $acf_banner = get_field('category_banner_image', $term);
        if ($acf_banner) {
            $hero_bg = $acf_banner;
        } else {
            // Try WooCommerce thumbnail
            $thumbnail_id = get_term_meta($term->term_id, 'thumbnail_id', true);
            if ($thumbnail_id) {
                $hero_bg = wp_get_attachment_url($thumbnail_id);
            }
        }
        
        // Try ACF Subtitle if desc is empty
        if (empty($hero_desc)) {
            $hero_desc = get_field('category_subtitle', $term);
        }
    }
}
?>

<!-- Hero Section -->
<section class="relative py-20 erdu-bg-dark">
    <div class="absolute inset-0 opacity-20" style="background-image: url('<?php echo esc_url($hero_bg); ?>'); background-size: cover; background-position: center;"></div>
    <div class="relative erdu-container text-center">
        <?php erdu_breadcrumb(); ?>
        <h1 class="text-3xl md:text-4xl font-bold text-white"><?php echo esc_html($hero_title); ?></h1>
        <?php if ($hero_desc) : ?>
            <p class="text-blue-100 mt-4 max-w-2xl mx-auto"><?php echo wp_kses_post($hero_desc); ?></p>
        <?php endif; ?>
    </div>
</section>

<section class="py-16 bg-gray-50">
    <div class="erdu-container">
        <div class="flex flex-col lg:flex-row gap-8">
            
            <!-- Sidebar: Categories Navigation -->
            <aside class="lg:w-1/4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 sticky top-24">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b border-gray-100"><?php esc_html_e('Product Categories', 'erdu-wp'); ?></h3>
                    <ul class="space-y-2">
                        <?php
                        $args = array(
                            'taxonomy'   => 'product_cat',
                            'hide_empty' => true,
                            'parent'     => 0,
                            'title_li'   => '',
                            'show_count' => true,
                        );
                        // A simple custom walker could be used here, but wp_list_categories is fine for now
                        wp_list_categories($args);
                        ?>
                    </ul>
                </div>
            </aside>

            <!-- Main Content: Product Grid -->
            <main class="lg:w-3/4">
                <?php
                if (woocommerce_product_loop()) {
                    
                    /**
                     * Hook: woocommerce_before_shop_loop.
                     *
                     * @hooked woocommerce_output_all_notices - 10
                     * @hooked woocommerce_result_count - 20
                     * @hooked woocommerce_catalog_ordering - 30
                     */
                    do_action('woocommerce_before_shop_loop');

                    woocommerce_product_loop_start();

                    if (wc_get_loop_prop('total')) {
                        while (have_posts()) {
                            the_post();

                            /**
                             * Hook: woocommerce_shop_loop.
                             */
                            do_action('woocommerce_shop_loop');

                            wc_get_template_part('content', 'product');
                        }
                    }

                    woocommerce_product_loop_end();

                    /**
                     * Hook: woocommerce_after_shop_loop.
                     *
                     * @hooked woocommerce_pagination - 10
                     */
                    do_action('woocommerce_after_shop_loop');
                } else {
                    /**
                     * Hook: woocommerce_no_products_found.
                     *
                     * @hooked wc_no_products_found - 10
                     */
                    do_action('woocommerce_no_products_found');
                }
                ?>
            </main>
        </div>
    </div>
</section>

<?php
get_footer('shop');
