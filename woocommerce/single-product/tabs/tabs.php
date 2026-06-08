<?php
/**
 * Single Product tabs
 *
 * This template overrides the default WooCommerce tabs.php for Tailwind CSS styling.
 *
 * @package ERDU_Lighting/WooCommerce
 */

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Filter tabs and allow third parties to add their own.
 *
 * Each tab is an array containing title, callback and priority.
 *
 * @see woocommerce_default_product_tabs()
 */
$product_tabs = apply_filters('woocommerce_product_tabs', array());

if (!empty($product_tabs)) : ?>

    <div class="woocommerce-tabs wc-tabs-wrapper erdu-product-tabs">
        <!-- Tab Navigation -->
        <div class="border-b border-gray-200 bg-gray-50 px-6 lg:px-10">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center wc-tabs" role="tablist">
                <?php foreach ($product_tabs as $key => $product_tab) : ?>
                    <li class="<?php echo esc_attr($key); ?>_tab mr-2" id="tab-title-<?php echo esc_attr($key); ?>" role="presentation">
                        <a href="#tab-<?php echo esc_attr($key); ?>" class="inline-block p-4 border-b-2 border-transparent rounded-t-lg hover:text-orange-600 hover:border-orange-300 transition-colors" role="tab" aria-controls="tab-<?php echo esc_attr($key); ?>">
                            <?php echo wp_kses_post(apply_filters('woocommerce_product_' . $key . '_tab_title', $product_tab['title'], $key)); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <!-- Tab Content -->
        <div class="p-6 lg:p-10">
            <?php foreach ($product_tabs as $key => $product_tab) : ?>
                <div class="woocommerce-Tabs-panel woocommerce-Tabs-panel--<?php echo esc_attr($key); ?> panel entry-content wc-tab prose max-w-none" id="tab-<?php echo esc_attr($key); ?>" role="tabpanel" aria-labelledby="tab-title-<?php echo esc_attr($key); ?>">
                    <?php
                    if (isset($product_tab['callback'])) {
                        call_user_func($product_tab['callback'], $key, $product_tab);
                    }
                    ?>
                </div>
            <?php endforeach; ?>

            <?php 
            // Append custom Downloads Tab Content via ACF if exists
            if (function_exists('have_rows') && have_rows('product_downloads')) : 
            ?>
                <!-- Downloads Content (if not injected via filter) -->
                <div class="mt-12 pt-8 border-t border-gray-100">
                    <h3 class="text-xl font-bold mb-6"><?php esc_html_e('Downloads & Resources', 'erdu-wp'); ?></h3>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php while (have_rows('product_downloads')) : the_row(); 
                            $title = get_sub_field('title');
                            $file = get_sub_field('file');
                        ?>
                            <a href="<?php echo esc_url($file); ?>" target="_blank" class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-orange-50 hover:border-orange-200 transition-colors group">
                                <svg class="w-8 h-8 text-gray-400 group-hover:text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                <span class="font-medium text-gray-800 group-hover:text-orange-700"><?php echo esc_html($title); ?></span>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
            <?php 
            // Free version fallback for downloads
            elseif (function_exists('get_field') && !class_exists('acf_field_repeater')) :
                $downloads = get_field('product_downloads');
                if ($downloads) :
            ?>
                <div class="mt-12 pt-8 border-t border-gray-100">
                    <h3 class="text-xl font-bold mb-6"><?php esc_html_e('Downloads & Resources', 'erdu-wp'); ?></h3>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php 
                        $lines = explode("\n", $downloads);
                        foreach ($lines as $line) {
                            $parts = explode('|', $line);
                            if (count($parts) >= 2) {
                                $title = trim($parts[0]);
                                $url = trim($parts[1]);
                                echo '<a href="' . esc_url($url) . '" target="_blank" class="flex items-center p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-orange-50 hover:border-orange-200 transition-colors group">';
                                echo '<svg class="w-8 h-8 text-gray-400 group-hover:text-orange-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>';
                                echo '<span class="font-medium text-gray-800 group-hover:text-orange-700">' . esc_html($title) . '</span></a>';
                            }
                        }
                        ?>
                    </div>
                </div>
            <?php
                endif;
            endif; 
            ?>
        </div>
    </div>

<?php endif; ?>
