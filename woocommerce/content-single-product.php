<?php
/**
 * The template for displaying product content in the single-product.php template
 * Split Screen Accordion Style (Astra Reference)
 *
 * @package ERDU_Lighting/WooCommerce
 */

defined('ABSPATH') || exit;

global $product;

/**
 * Hook: woocommerce_before_single_product.
 * @hooked woocommerce_output_all_notices - 10
 */
do_action('woocommerce_before_single_product');

if (post_password_required()) {
    echo get_the_password_form(); // WPCS: XSS ok.
    return;
}

$subtitle = function_exists('get_field') ? get_field('product_subtitle') : '';
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('product-split-wrapper erdu-container py-12', $product); ?>>
    
    <div class="flex flex-col lg:flex-row gap-12 xl:gap-16">
        
        <!-- Left Column: Content & Accordion -->
        <div class="w-full lg:w-1/2 lg:sticky lg:top-24 self-start">
            
            <!-- Breadcrumbs -->
            <?php
            woocommerce_breadcrumb(array(
                'wrap_before' => '<nav class="woocommerce-breadcrumb text-sm text-gray-500 mb-6 font-medium flex flex-wrap items-center gap-2">',
                'wrap_after'  => '</nav>',
                'delimiter'   => '<span class="text-gray-300">/</span>',
            ));
            ?>
            
            <!-- Title & Subtitle -->
            <h1 class="text-3xl lg:text-4xl font-extrabold text-gray-900 mb-2 leading-tight">
                <?php the_title(); ?>
            </h1>
            <?php if ($subtitle) : ?>
                <div class="text-lg text-gray-500 mb-4"><?php echo esc_html($subtitle); ?></div>
            <?php endif; ?>

            <!-- SKU & Price (Conditional based on ACF toggles) -->
            <?php 
            $show_sku = function_exists('get_field') ? get_field('show_product_sku') : false;
            $show_price = function_exists('get_field') ? get_field('show_product_price') : false;
            
            if ($show_sku || $show_price) : 
            ?>
            <div class="flex flex-wrap items-center gap-4 mb-6 pb-6 border-b border-gray-100">
                <?php if ($show_sku && wc_product_sku_enabled() && ($sku = $product->get_sku())) : ?>
                    <div class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-md">
                        <span class="font-medium text-gray-500 mr-1"><?php esc_html_e('SKU:', 'erdu-wp'); ?></span>
                        <span class="font-bold text-gray-800"><?php echo esc_html($sku); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($show_price && $product->get_price_html()) : ?>
                    <div class="text-2xl font-extrabold text-orange-600">
                        <?php echo $product->get_price_html(); ?>
                    </div>
                <?php endif; ?>
            </div>
            <?php endif; ?>
            
            <!-- Specification Badge -->
            <div class="mb-8">
                <span class="inline-flex items-center justify-center bg-orange-50 text-orange-700 rounded-full px-5 py-2 text-sm font-bold border border-orange-100 shadow-sm cursor-default">
                    Specification
                </span>
            </div>
            
            <!-- Accordion -->
            <div class="border border-gray-200 rounded-xl overflow-hidden bg-white shadow-sm" id="product-accordion">
                
                <!-- Panel: Product Features -->
                <?php if (function_exists('have_rows') && have_rows('product_features')) : ?>
                <div class="erdu-accordion-item border-b border-gray-200">
                    <button class="erdu-accordion-header w-full flex justify-between items-center p-5 lg:p-6 bg-white hover:bg-gray-50 text-left font-bold text-gray-900 transition-colors focus:outline-none" aria-expanded="true">
                        <span class="text-lg">Product Features:</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-300 rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="erdu-accordion-content p-5 lg:p-6 pt-0 bg-white text-gray-600 prose prose-sm max-w-none">
                        <ul class="list-disc pl-5 space-y-2 mt-2 text-base">
                            <?php while (have_rows('product_features')) : the_row(); 
                                $f_title = get_sub_field('title');
                                $f_desc = get_sub_field('description');
                            ?>
                                <li><strong><?php echo esc_html($f_title); ?></strong> <?php echo esc_html($f_desc); ?></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Panel: Description -->
                <?php $content = get_the_content(); ?>
                <?php if (trim(strip_tags($content))) : ?>
                <div class="erdu-accordion-item border-b border-gray-200">
                    <button class="erdu-accordion-header w-full flex justify-between items-center p-5 lg:p-6 bg-white hover:bg-gray-50 text-left font-bold text-gray-900 transition-colors focus:outline-none" aria-expanded="false">
                        <span class="text-lg">Description:</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="erdu-accordion-content hidden p-5 lg:p-6 pt-0 bg-white text-gray-600 prose prose-sm max-w-none text-base">
                        <?php echo apply_filters('the_content', $content); ?>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Panel: Technical Specs -->
                <?php 
                $attributes = $product->get_attributes();
                if (!empty($attributes)) : 
                ?>
                <div class="erdu-accordion-item border-b border-gray-200">
                    <button class="erdu-accordion-header w-full flex justify-between items-center p-5 lg:p-6 bg-white hover:bg-gray-50 text-left font-bold text-gray-900 transition-colors focus:outline-none" aria-expanded="false">
                        <span class="text-lg">Technical Specs:</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="erdu-accordion-content hidden p-5 lg:p-6 pt-0 bg-white text-gray-600">
                        <table class="w-full text-left text-sm lg:text-base border-collapse">
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach ($attributes as $attribute) : 
                                    if (!$attribute->get_visible()) continue;
                                    $name = wc_attribute_label($attribute->get_name());
                                    $value = $attribute->is_taxonomy() ? implode(', ', wp_list_pluck(wp_get_post_terms($product->get_id(), $attribute->get_name(), 'all'), 'name')) : $attribute->get_options()[0];
                                    if ($value) :
                                ?>
                                <tr>
                                    <th class="py-3 pr-4 font-medium text-gray-500 w-1/3"><?php echo esc_html($name); ?></th>
                                    <td class="py-3 font-bold text-gray-900"><?php echo esc_html($value); ?></td>
                                </tr>
                                <?php endif; endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Panel: Downloads -->
                <?php if (function_exists('have_rows') && have_rows('product_downloads')) : ?>
                <div class="erdu-accordion-item">
                    <button class="erdu-accordion-header w-full flex justify-between items-center p-5 lg:p-6 bg-white hover:bg-gray-50 text-left font-bold text-gray-900 transition-colors focus:outline-none" aria-expanded="false">
                        <span class="text-lg">Downloads:</span>
                        <svg class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>
                    <div class="erdu-accordion-content hidden p-5 lg:p-6 pt-0 bg-white text-gray-600">
                        <div class="space-y-4">
                            <?php while (have_rows('product_downloads')) : the_row(); 
                                $title = get_sub_field('title');
                                $file = get_sub_field('file');
                            ?>
                                <a href="<?php echo esc_url($file); ?>" target="_blank" class="flex items-center text-base font-medium text-orange-600 hover:text-orange-800 transition-colors">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    <?php echo esc_html($title); ?>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

            </div>
            
            <!-- Inquiry CTA Below Accordion -->
            <div class="mt-8">
                <?php
                $inquiry_link = erdu_get_page_url('contact');
                $url = add_query_arg('product', urlencode($product->get_name()), $inquiry_link);
                ?>
                <a href="<?php echo esc_url($url); ?>" class="flex items-center justify-center w-full bg-gray-900 hover:bg-orange-600 text-white font-bold py-4 px-8 rounded-lg transition-colors text-lg shadow-md hover:shadow-lg">
                    <?php esc_html_e('Inquire Now', 'erdu-wp'); ?>
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </div>

        </div>

        <!-- Right Column: Gallery & Applications -->
        <div class="w-full lg:w-1/2">
            <!-- Main Product Gallery -->
            <div class="bg-white rounded-2xl p-2 lg:p-8 shadow-sm border border-gray-100 mb-8">
                <?php 
                // Display standard WooCommerce product gallery
                woocommerce_show_product_images(); 
                ?>
            </div>

            <!-- Application Scenarios Gallery (Below Product Gallery) -->
            <?php 
            $app_images = function_exists('get_field') ? get_field('application_images') : false;
            if ($app_images) : 
            ?>
            <div class="bg-white rounded-2xl p-6 lg:p-8 shadow-sm border border-gray-100">
                <h3 class="text-2xl font-bold text-gray-900 mb-6"><?php esc_html_e('Application Scenarios', 'erdu-wp'); ?></h3>
                <div class="grid grid-cols-2 gap-4">
                    <?php foreach ($app_images as $image_url) : ?>
                        <div class="group overflow-hidden rounded-xl bg-gray-100 relative" style="aspect-ratio: 4/3;">
                            <img src="<?php echo esc_url($image_url); ?>" alt="" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                            <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        
    </div>

</div>

<!-- Accordion JS Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const headers = document.querySelectorAll('.erdu-accordion-header');
    
    headers.forEach(header => {
        header.addEventListener('click', () => {
            const content = header.nextElementSibling;
            const icon = header.querySelector('svg');
            const isExpanded = header.getAttribute('aria-expanded') === 'true';
            
            // Toggle current
            if (isExpanded) {
                header.setAttribute('aria-expanded', 'false');
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            } else {
                header.setAttribute('aria-expanded', 'true');
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            }
        });
    });
});
</script>

<?php 
do_action('woocommerce_after_single_product'); 
?>