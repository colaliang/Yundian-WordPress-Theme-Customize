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
    
    <!-- SECTION 1: Gallery (Left) & Info (Right) -->
    <div class="flex flex-col lg:flex-row gap-12 xl:gap-16 mb-16">
        
        <!-- Left Column: Gallery -->
        <div class="w-full lg:w-1/2">
            <!-- Main Product Gallery -->
            <div class="bg-white rounded-2xl p-2 lg:p-8 shadow-sm border border-gray-100">
                <?php 
                // Display standard WooCommerce product gallery
                woocommerce_show_product_images(); 
                ?>
            </div>
        </div>

        <!-- Right Column: Product Info -->
        <div class="w-full lg:w-1/2 self-start lg:sticky lg:top-24">
            
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
            <div class="flex flex-wrap items-center gap-4 mb-6">
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

            <!-- Short Description -->
            <?php if (has_excerpt()) : ?>
                <div class="prose prose-sm max-w-none text-gray-600 mb-8 leading-relaxed">
                    <?php the_excerpt(); ?>
                </div>
            <?php endif; ?>

            <!-- Action Buttons (Inquire & WhatsApp) -->
            <div class="flex flex-col sm:flex-row items-center gap-4">
                <?php
                $inquiry_link = erdu_get_page_url('contact');
                $url = add_query_arg('product', urlencode($product->get_name()), $inquiry_link);
                ?>
                <a href="<?php echo esc_url($url); ?>" class="w-full sm:flex-1 inline-flex items-center justify-center bg-gray-900 text-white font-bold py-3.5 px-6 rounded-lg transition-all text-base shadow-sm hover:shadow-md hover:-translate-y-0.5" style="background-color: #111827;" onmouseover="this.style.backgroundColor='#ea580c'" onmouseout="this.style.backgroundColor='#111827'">
                    <?php esc_html_e('Inquire Now', 'erdu-wp'); ?>
                </a>

                <?php 
                $show_wa = function_exists('get_field') ? get_field('show_whatsapp_button') : false;
                $wa_number = function_exists('get_field') ? get_field('whatsapp_number') : '';
                if ($show_wa && $wa_number) : 
                    $wa_text = rawurlencode("Hi, I'm interested in " . $product->get_name());
                    $wa_url = "https://wa.me/" . preg_replace('/[^0-9]/', '', $wa_number) . "?text=" . $wa_text;
                ?>
                <a href="<?php echo esc_url($wa_url); ?>" target="_blank" class="w-full sm:flex-1 inline-flex items-center justify-center text-white font-bold py-3.5 px-6 rounded-lg transition-all text-base shadow-sm hover:shadow-md hover:-translate-y-0.5" style="background-color: #25D366;" onmouseover="this.style.backgroundColor='#128C7E'" onmouseout="this.style.backgroundColor='#25D366'">
                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 0C5.385 0 0 5.385 0 12.031c0 2.122.553 4.195 1.603 6.01L.524 23.475l5.584-1.464A11.97 11.97 0 0012.031 24c6.646 0 12.031-5.385 12.031-12.031S18.677 0 12.031 0zm0 22.015a9.924 9.924 0 01-5.074-1.39l-.364-.216-3.771.989.998-3.676-.237-.377a9.94 9.94 0 01-1.522-5.314c0-5.513 4.487-10 10-10 5.513 0 10 4.487 10 10s-4.487 10-10 10zm5.495-7.513c-.301-.151-1.782-.881-2.057-.981-.275-.101-.476-.151-.676.151-.2.301-.776.981-.951 1.182-.175.201-.35.226-.651.075-.301-.151-1.271-.468-2.42-1.332-.894-.672-1.498-1.503-1.673-1.804-.175-.301-.019-.464.132-.614.136-.135.301-.351.451-.526.151-.175.201-.301.301-.501.101-.201.05-.376-.025-.526-.075-.151-.676-1.628-.926-2.228-.244-.585-.492-.505-.676-.514-.175-.01-.376-.01-.576-.01s-.526.075-.801.376c-.275.301-1.052 1.027-1.052 2.505s1.077 2.905 1.227 3.105c.151.201 2.118 3.228 5.129 4.526 2.063.89 2.853.957 3.914.857 1.135-.106 3.483-1.425 3.984-2.805.501-1.38.501-2.555.351-2.805-.151-.25-.551-.401-.852-.551z"/></svg>
                    WhatsApp
                </a>
                <?php endif; ?>
            </div>
            
        </div>
        
    </div>

    <!-- SECTION 2: Horizontal Tabs (Bottom) -->
    <div class="product-tabs-section w-full border-t border-gray-200 pt-12">
        <div class="product-tabs-container max-w-5xl mx-auto">
                <!-- Tab Navigation -->
                <div class="flex flex-wrap border-b border-gray-200 mb-6 gap-x-8 gap-y-4">
                    <?php 
                    $content = get_the_content(); 
                    $has_desc = trim(strip_tags($content));
                    $has_features = function_exists('have_rows') && have_rows('product_features');
                    $attributes = $product->get_attributes();
                    $has_specs = !empty($attributes);
                    $has_downloads = function_exists('have_rows') && have_rows('product_downloads');
                    
                    $first_tab_active = false;
                    ?>
                    
                    <?php if ($has_desc) : ?>
                    <button class="erdu-tab-btn pb-3 text-lg font-bold border-b-2 border-orange-600 text-orange-600 transition-colors" data-target="tab-desc">
                        <?php esc_html_e('Description', 'erdu-wp'); ?>
                    </button>
                    <?php $first_tab_active = true; endif; ?>
                    
                    <?php if ($has_features) : ?>
                    <button class="erdu-tab-btn pb-3 text-lg font-bold border-b-2 <?php echo !$first_tab_active ? 'border-orange-600 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-900'; ?> transition-colors" data-target="tab-features">
                        <?php esc_html_e('Features', 'erdu-wp'); ?>
                    </button>
                    <?php if(!$first_tab_active) $first_tab_active = true; endif; ?>
                    
                    <?php if ($has_specs) : ?>
                    <button class="erdu-tab-btn pb-3 text-lg font-bold border-b-2 <?php echo !$first_tab_active ? 'border-orange-600 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-900'; ?> transition-colors" data-target="tab-specs">
                        <?php esc_html_e('Specs', 'erdu-wp'); ?>
                    </button>
                    <?php if(!$first_tab_active) $first_tab_active = true; endif; ?>
                    
                    <?php if ($has_downloads) : ?>
                    <button class="erdu-tab-btn pb-3 text-lg font-bold border-b-2 <?php echo !$first_tab_active ? 'border-orange-600 text-orange-600' : 'border-transparent text-gray-500 hover:text-gray-900'; ?> transition-colors" data-target="tab-downloads">
                        <?php esc_html_e('Downloads', 'erdu-wp'); ?>
                    </button>
                    <?php endif; ?>
                </div>

                <!-- Tab Contents -->
                <div class="erdu-tab-contents bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:p-8">
                    
                    <?php $first_pane_active = false; ?>
                    
                    <!-- Pane: Description -->
                    <?php if ($has_desc) : ?>
                    <div id="tab-desc" class="erdu-tab-pane prose prose-sm max-w-none text-base text-gray-600">
                        <?php echo apply_filters('the_content', $content); ?>
                    </div>
                    <?php $first_pane_active = true; endif; ?>

                    <!-- Pane: Product Features -->
                    <?php if ($has_features) : ?>
                    <div id="tab-features" class="erdu-tab-pane <?php echo $first_pane_active ? 'hidden' : ''; ?> prose prose-sm max-w-none text-base text-gray-600">
                        <ul class="list-disc pl-5 space-y-3">
                            <?php while (have_rows('product_features')) : the_row(); 
                                $f_title = get_sub_field('title');
                                $f_desc = get_sub_field('description');
                            ?>
                                <li><strong><?php echo esc_html($f_title); ?></strong> <?php echo esc_html($f_desc); ?></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                    <?php if(!$first_pane_active) $first_pane_active = true; endif; ?>
                    
                    <!-- Pane: Technical Specs -->
                    <?php if ($has_specs) : ?>
                    <div id="tab-specs" class="erdu-tab-pane <?php echo $first_pane_active ? 'hidden' : ''; ?> text-gray-600">
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
                    <?php if(!$first_pane_active) $first_pane_active = true; endif; ?>

                    <!-- Pane: Downloads -->
                    <?php if ($has_downloads) : ?>
                    <div id="tab-downloads" class="erdu-tab-pane <?php echo $first_pane_active ? 'hidden' : ''; ?> text-gray-600">
                        <div class="space-y-4">
                            <?php while (have_rows('product_downloads')) : the_row(); 
                                $title = get_sub_field('title');
                                $file = get_sub_field('file');
                            ?>
                                <a href="<?php echo esc_url($file); ?>" target="_blank" class="inline-flex items-center text-base font-medium text-orange-600 hover:text-orange-800 transition-colors bg-orange-50 hover:bg-orange-100 px-5 py-3 rounded-lg w-full sm:w-auto">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    <?php echo esc_html($title); ?>
                                </a>
                            <?php endwhile; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>

</div>

<!-- Tab JS Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.erdu-tab-btn');
    const tabPanes = document.querySelectorAll('.erdu-tab-pane');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active classes from all buttons
            tabBtns.forEach(b => {
                b.classList.remove('border-orange-600', 'text-orange-600');
                b.classList.add('border-transparent', 'text-gray-500', 'hover:text-gray-900');
            });
            
            // Add active class to clicked button
            btn.classList.remove('border-transparent', 'text-gray-500', 'hover:text-gray-900');
            btn.classList.add('border-orange-600', 'text-orange-600');
            
            // Hide all panes
            tabPanes.forEach(pane => {
                pane.classList.add('hidden');
            });
            
            // Show target pane
            const targetId = btn.getAttribute('data-target');
            const targetPane = document.getElementById(targetId);
            if(targetPane) {
                targetPane.classList.remove('hidden');
            }
        });
    });
});
</script>

<?php 
do_action('woocommerce_after_single_product'); 
?>