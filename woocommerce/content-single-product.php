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
        
        <!-- Left Column: Gallery & Video -->
        <div class="w-full lg:w-1/2">
            
            <?php 
            $video_url = function_exists('get_field') ? get_field('product_video_url') : ''; 
            $has_video = !empty($video_url);
            ?>

            <!-- Main Product Gallery -->
            <div id="erdu-gallery-container" class="bg-white rounded-2xl p-2 lg:p-8 shadow-sm border border-gray-100 <?php echo $has_video ? 'mb-4' : ''; ?>">
                <?php 
                // Display standard WooCommerce product gallery
                woocommerce_show_product_images(); 
                ?>
            </div>

            <?php if ($has_video) : ?>
            <!-- Video Container (Hidden by default) -->
            <div id="erdu-video-container" class="hidden bg-black rounded-2xl overflow-hidden shadow-sm mb-4 relative" style="aspect-ratio: 1/1;">
                <?php if (strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false || strpos($video_url, 'vimeo.com') !== false) : ?>
                    <iframe src="<?php echo esc_url($video_url); ?>" class="absolute inset-0 w-full h-full border-0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                <?php else : ?>
                    <video controls class="absolute inset-0 w-full h-full object-contain bg-black">
                        <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                <?php endif; ?>
            </div>

            <!-- Media Switcher (Photos / Video) -->
            <div class="flex justify-center mt-6">
                <div class="inline-flex bg-gray-100 rounded-lg p-1">
                    <button id="btn-show-photos" class="px-6 py-2 rounded-md text-sm font-bold bg-white text-gray-900 shadow-sm transition-all">
                        Photos
                    </button>
                    <button id="btn-show-video" class="px-6 py-2 rounded-md text-sm font-bold text-gray-500 hover:text-gray-900 transition-all">
                        Video
                    </button>
                </div>
            </div>
            
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                const btnPhotos = document.getElementById('btn-show-photos');
                const btnVideo = document.getElementById('btn-show-video');
                const galleryContainer = document.getElementById('erdu-gallery-container');
                const videoContainer = document.getElementById('erdu-video-container');

                if(btnPhotos && btnVideo) {
                    btnPhotos.addEventListener('click', () => {
                        // Show Photos
                        galleryContainer.classList.remove('hidden');
                        videoContainer.classList.add('hidden');
                        // Update Button Styles
                        btnPhotos.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
                        btnPhotos.classList.remove('text-gray-500');
                        btnVideo.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
                        btnVideo.classList.add('text-gray-500');
                        
                        // Pause video if playing
                        const videoEl = videoContainer.querySelector('video');
                        if(videoEl) videoEl.pause();
                    });

                    btnVideo.addEventListener('click', () => {
                        // Show Video
                        videoContainer.classList.remove('hidden');
                        galleryContainer.classList.add('hidden');
                        // Update Button Styles
                        btnVideo.classList.add('bg-white', 'text-gray-900', 'shadow-sm');
                        btnVideo.classList.remove('text-gray-500');
                        btnPhotos.classList.remove('bg-white', 'text-gray-900', 'shadow-sm');
                        btnPhotos.classList.add('text-gray-500');
                    });
                }
            });
            </script>
            <?php endif; ?>

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

            <!-- SKU & Price & MOQ -->
            <?php 
            $show_sku = function_exists('get_field') ? get_field('show_product_sku') : false;
            $show_price = function_exists('get_field') ? get_field('show_product_price') : false;
            $moq = function_exists('get_field') ? get_field('product_moq') : '';
            
            if ($show_sku || $show_price || $moq) : 
            ?>
            <div class="flex flex-wrap items-center gap-4 mb-6">
                <?php if ($show_sku && wc_product_sku_enabled() && ($sku = $product->get_sku())) : ?>
                    <div class="text-sm text-gray-600 bg-gray-100 px-3 py-1 rounded-md">
                        <span class="font-medium text-gray-500 mr-1"><?php esc_html_e('SKU:', 'erdu-wp'); ?></span>
                        <span class="font-bold text-gray-800"><?php echo esc_html($sku); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($moq) : ?>
                    <div class="text-sm text-gray-600 bg-orange-50 px-3 py-1 rounded-md border border-orange-100">
                        <span class="font-medium text-orange-600 mr-1"><?php esc_html_e('MOQ:', 'erdu-wp'); ?></span>
                        <span class="font-bold text-orange-800"><?php echo esc_html($moq); ?></span>
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
                <div class="prose prose-sm max-w-none text-gray-600 mb-6 leading-relaxed">
                    <?php the_excerpt(); ?>
                </div>
            <?php endif; ?>

            <!-- Key Attributes Grid -->
            <?php if (function_exists('have_rows') && have_rows('product_key_attributes')) : ?>
                <div class="mb-8">
                    <h3 class="text-lg font-bold text-gray-900 mb-4"><?php esc_html_e('Key attributes', 'erdu-wp'); ?></h3>
                    <div class="bg-gray-50 rounded-xl p-6 border border-gray-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-8">
                            <?php while (have_rows('product_key_attributes')) : the_row(); 
                                $ka_label = get_sub_field('label');
                                $ka_value = get_sub_field('value');
                            ?>
                            <div class="flex flex-col relative <?php echo (get_row_index() % 3 !== 1) ? 'lg:before:content-[\'\'] lg:before:absolute lg:before:left-[-1rem] lg:before:top-1 lg:before:bottom-1 lg:before:w-px lg:before:bg-gray-200' : ''; ?>">
                                <span class="text-sm text-gray-500 mb-1"><?php echo esc_html($ka_label); ?></span>
                                <span class="font-bold text-gray-900 text-base leading-tight"><?php echo esc_html($ka_value); ?></span>
                            </div>
                            <?php endwhile; ?>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Product Variations / Attributes -->
            <?php 
            $attributes = $product->get_attributes();
            if (!empty($attributes)) : 
                $has_visible_attributes = false;
                ob_start();
                foreach ($attributes as $attribute) : 
                    if (!$attribute->get_visible()) continue;
                    
                    $name = wc_attribute_label($attribute->get_name());
                    $options = $attribute->is_taxonomy() ? wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'names')) : $attribute->get_options();
                    
                    if (!empty($options)) : 
                        $has_visible_attributes = true;
            ?>
                    <div class="mb-6">
                        <h4 class="text-base font-bold text-gray-900 mb-3"><?php echo esc_html($name); ?></h4>
                        <div class="flex flex-wrap gap-2 sm:gap-3">
                            <?php foreach ($options as $index => $option) : ?>
                                <?php if ($index === 0) : ?>
                                    <span class="px-4 py-2 border border-gray-900 rounded-md text-sm font-bold text-gray-900 bg-gray-50 shadow-sm"><?php echo esc_html($option); ?></span>
                                <?php else : ?>
                                    <span class="px-4 py-2 bg-gray-100 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-200 transition-colors"><?php echo esc_html($option); ?></span>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
            <?php 
                    endif;
                endforeach; 
                $attr_html = ob_get_clean();
                
                if ($has_visible_attributes) :
                    echo '<div class="mb-8">' . $attr_html . '</div>';
                endif;
            endif; 
            ?>

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
        <div class="product-tabs-container w-full mx-auto">
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