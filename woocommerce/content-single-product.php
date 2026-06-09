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
    
    <!-- Breadcrumbs -->
    <?php 
    $erdu_settings = function_exists('erdu_default_settings') ? get_option('erdu_settings', erdu_default_settings()) : get_option('erdu_settings', array());
    $show_breadcrumb = isset($erdu_settings['show_breadcrumb']) ? $erdu_settings['show_breadcrumb'] : true;
    
    if ($show_breadcrumb) {
        woocommerce_breadcrumb(array(
            'wrap_before' => '<nav class="woocommerce-breadcrumb text-sm text-gray-500 mb-6 font-medium flex flex-wrap items-center gap-2">',
            'wrap_after'  => '</nav>',
            'delimiter'   => '<span class="text-gray-300">/</span>',
        ));
    }
    ?>

    <!-- SECTION 1: Gallery (Left) & Info (Right) -->
    <div class="flex flex-col lg:flex-row gap-12 xl:gap-16 mb-16">
        
        <!-- Left Column: Gallery & Video -->
        <div class="w-full lg:w-1/2 flex flex-col">
            
            <?php 
            $video_url = function_exists('get_field') ? get_field('product_video_url') : ''; 
            $has_video = !empty($video_url);
            ?>

            <!-- Media Container (Gallery or Video) -->
            <div class="w-full flex-grow flex flex-col relative">
                <!-- Main Product Gallery (Option B Custom Implementation) -->
                <?php
                global $product;
                $main_image_id = $product->get_image_id();
                $attachment_ids = $product->get_gallery_image_ids();
                $all_image_ids = array_filter(array_merge(array($main_image_id), $attachment_ids));
                ?>
                <div id="erdu-gallery-container" class="w-full relative flex flex-row gap-4" style="aspect-ratio: 1/1;">
                    
                    <?php if (count($all_image_ids) > 1) : ?>
                    <!-- Thumbnail Rail -->
                    <div class="w-16 lg:w-[64px] flex-shrink-0 flex flex-col gap-3 overflow-y-auto erdu-hide-scrollbar" style="scrollbar-width: none;">
                        <style>
                            .erdu-hide-scrollbar::-webkit-scrollbar { display: none; }
                        </style>
                        <?php foreach ($all_image_ids as $index => $img_id) : 
                            $thumb_url = wp_get_attachment_image_url($img_id, 'gallery_thumbnail');
                            $full_url = wp_get_attachment_image_url($img_id, 'full');
                        ?>
                            <img src="<?php echo esc_url($thumb_url); ?>" 
                                 data-full="<?php echo esc_url($full_url); ?>" 
                                 data-index="<?php echo $index; ?>"
                                 class="erdu-gallery-thumb w-full aspect-square rounded-xl object-cover border-2 cursor-pointer transition-all <?php echo $index === 0 ? 'border-[#f97316] opacity-100' : 'border-gray-200 opacity-70 hover:opacity-100 hover:border-gray-400'; ?>" 
                                 alt="<?php echo esc_attr(get_post_meta($img_id, '_wp_attachment_image_alt', true)); ?>" />
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                    <!-- Main Image Stage -->
                    <div class="flex-grow bg-[#f3f4f6] rounded-xl overflow-hidden relative flex items-center justify-center cursor-zoom-in group" id="erdu-main-image-wrapper">
                        <?php 
                        $first_full = !empty($all_image_ids) ? wp_get_attachment_image_url(array_values($all_image_ids)[0], 'full') : wc_placeholder_img_src('full'); 
                        ?>
                        <img src="<?php echo esc_url($first_full); ?>" id="erdu-main-image" class="w-full h-full object-contain transition-transform duration-300 group-hover:scale-[1.02]" alt="<?php echo esc_attr($product->get_name()); ?>" data-current-index="0" />
                        
                        <!-- Lightbox Hint Icon -->
                        <div class="absolute top-4 right-4 bg-white/80 backdrop-blur-sm p-2 rounded-full text-gray-600 opacity-0 group-hover:opacity-100 transition-opacity pointer-events-none shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Lightbox Overlay -->
                <div id="erdu-lightbox" class="fixed inset-0 z-[99999] bg-black/95 hidden flex-col items-center justify-center opacity-0 transition-opacity duration-300 backdrop-blur-sm">
                    <button id="erdu-lightbox-close" class="absolute top-6 right-8 text-white/70 hover:text-white text-5xl transition-colors cursor-pointer z-50">&times;</button>
                    
                    <!-- Prev Button -->
                    <button id="erdu-lightbox-prev" class="absolute left-4 md:left-8 top-1/2 -translate-y-1/2 text-white/70 hover:text-white text-4xl md:text-6xl transition-colors z-50 hidden">
                        &#8249;
                    </button>
                    
                    <img id="erdu-lightbox-img" src="" class="max-w-[90vw] max-h-[90vh] object-contain select-none transition-opacity duration-200" />
                    
                    <!-- Next Button -->
                    <button id="erdu-lightbox-next" class="absolute right-4 md:right-8 top-1/2 -translate-y-1/2 text-white/70 hover:text-white text-4xl md:text-6xl transition-colors z-50 hidden">
                        &#8250;
                    </button>
                </div>

                <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const galleryContainer = document.getElementById('erdu-gallery-container');
                    const mainImage = document.getElementById('erdu-main-image');
                    const thumbs = Array.from(document.querySelectorAll('.erdu-gallery-thumb'));
                    const lightbox = document.getElementById('erdu-lightbox');
                    const lightboxImg = document.getElementById('erdu-lightbox-img');
                    const lightboxClose = document.getElementById('erdu-lightbox-close');
                    const lightboxPrev = document.getElementById('erdu-lightbox-prev');
                    const lightboxNext = document.getElementById('erdu-lightbox-next');

                    if (!galleryContainer || !mainImage) return;

                    // Update main image logic
                    const updateMainImage = (thumb) => {
                        const fullUrl = thumb.getAttribute('data-full');
                        const index = thumb.getAttribute('data-index');
                        mainImage.src = fullUrl;
                        mainImage.setAttribute('data-current-index', index);

                        // Update thumbnail states
                        thumbs.forEach(t => {
                            t.classList.remove('border-[#f97316]', 'opacity-100');
                            t.classList.add('border-gray-200', 'opacity-70');
                        });
                        thumb.classList.remove('border-gray-200', 'opacity-70');
                        thumb.classList.add('border-[#f97316]', 'opacity-100');
                    };

                    // Thumbnail Hover Logic (and click for mobile fallback)
                    thumbs.forEach(thumb => {
                        thumb.addEventListener('mouseenter', function() { updateMainImage(this); });
                        thumb.addEventListener('click', function() { updateMainImage(this); });
                    });

                    // Lightbox Open
                    if (lightbox && lightboxImg) {
                        const updateLightboxNav = () => {
                            if (thumbs.length <= 1) return;
                            const currentIndex = parseInt(mainImage.getAttribute('data-current-index') || '0', 10);
                            lightboxPrev.classList.toggle('hidden', currentIndex <= 0);
                            lightboxNext.classList.toggle('hidden', currentIndex >= thumbs.length - 1);
                        };

                        const changeLightboxImage = (newIndex) => {
                            if (newIndex >= 0 && newIndex < thumbs.length) {
                                lightboxImg.classList.add('opacity-0'); // Quick fade out
                                setTimeout(() => {
                                    updateMainImage(thumbs[newIndex]);
                                    lightboxImg.src = mainImage.src;
                                    updateLightboxNav();
                                    lightboxImg.classList.remove('opacity-0'); // Fade back in
                                }, 150);
                            }
                        };

                        mainImage.parentElement.addEventListener('click', function() {
                            lightboxImg.src = mainImage.src;
                            updateLightboxNav();
                            lightbox.classList.remove('hidden');
                            lightbox.classList.add('flex');
                            // Small delay to allow display:flex to apply before animating opacity
                            setTimeout(() => {
                                lightbox.classList.remove('opacity-0');
                                lightbox.classList.add('opacity-100');
                            }, 10);
                            document.body.style.overflow = 'hidden'; // Prevent background scrolling
                        });

                        // Lightbox Close
                        const closeLightbox = () => {
                            lightbox.classList.remove('opacity-100');
                            lightbox.classList.add('opacity-0');
                            setTimeout(() => {
                                lightbox.classList.add('hidden');
                                lightbox.classList.remove('flex');
                                document.body.style.overflow = '';
                            }, 300); // match duration-300
                        };

                        lightboxClose.addEventListener('click', closeLightbox);
                        lightbox.addEventListener('click', function(e) {
                            if (e.target === lightbox || e.target === lightboxImg) {
                                closeLightbox();
                            }
                        });

                        // Lightbox Navigation
                        lightboxPrev.addEventListener('click', (e) => {
                            e.stopPropagation();
                            const currentIndex = parseInt(mainImage.getAttribute('data-current-index') || '0', 10);
                            changeLightboxImage(currentIndex - 1);
                        });

                        lightboxNext.addEventListener('click', (e) => {
                            e.stopPropagation();
                            const currentIndex = parseInt(mainImage.getAttribute('data-current-index') || '0', 10);
                            changeLightboxImage(currentIndex + 1);
                        });
                        
                        // Keyboard Navigation
                        document.addEventListener('keydown', function(e) {
                            if (lightbox.classList.contains('hidden')) return;
                            
                            if (e.key === 'Escape') {
                                closeLightbox();
                            } else if (e.key === 'ArrowLeft') {
                                const currentIndex = parseInt(mainImage.getAttribute('data-current-index') || '0', 10);
                                changeLightboxImage(currentIndex - 1);
                            } else if (e.key === 'ArrowRight') {
                                const currentIndex = parseInt(mainImage.getAttribute('data-current-index') || '0', 10);
                                changeLightboxImage(currentIndex + 1);
                            }
                        });
                    }
                });
                </script>

                <?php if ($has_video) : ?>
                <!-- Video Container (Hidden by default) -->
                <div id="erdu-video-container" class="hidden w-full bg-black rounded-2xl overflow-hidden shadow-sm relative" style="aspect-ratio: 1/1;">
                    <?php 
                    $is_youtube = strpos($video_url, 'youtube.com') !== false || strpos($video_url, 'youtu.be') !== false;
                    $is_vimeo = strpos($video_url, 'vimeo.com') !== false;
                    
                    if ($is_youtube) : 
                        // Extract YouTube Video ID
                        $yt_id = '';
                        if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $video_url, $match)) {
                            $yt_id = $match[1];
                        }
                        $embed_url = $yt_id ? 'https://www.youtube.com/embed/' . $yt_id . '?rel=0&showinfo=0' : $video_url;
                    ?>
                        <iframe src="<?php echo esc_url($embed_url); ?>" title="YouTube video player" class="absolute inset-0 w-full h-full border-0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                    <?php elseif ($is_vimeo) : ?>
                        <iframe src="<?php echo esc_url($video_url); ?>" class="absolute inset-0 w-full h-full border-0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                    <?php else : ?>
                        <video controls class="absolute inset-0 w-full h-full object-contain bg-black">
                            <source src="<?php echo esc_url($video_url); ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <?php if ($has_video) : ?>
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
            <div class="flex flex-col sm:flex-row items-center gap-4 mb-8">
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

    <!-- SECTION 2: Vertical Flow Content (Bottom) -->
    <div class="product-tabs-section w-full border-t border-gray-200 pt-12">
        <div class="w-full">
            <?php 
            $content = get_the_content(); 
            $has_desc = trim(strip_tags($content));
            $has_features = function_exists('have_rows') && have_rows('product_features');
            $has_specs = function_exists('have_rows') && have_rows('product_specifications');
            $has_downloads = function_exists('have_rows') && have_rows('product_downloads');
            ?>

            <!-- Sticky Navigation Menu -->
            <div class="sticky top-[70px] z-40 bg-white/95 backdrop-blur-sm border-b border-gray-200 mb-8 -mx-4 px-4 sm:mx-0 sm:px-0">
                <nav class="flex overflow-x-auto hide-scrollbar gap-x-8 gap-y-4 py-4" aria-label="Product Sections">
                    <?php if ($has_desc) : ?>
                    <a href="#section-desc" class="erdu-nav-link whitespace-nowrap text-lg font-bold text-gray-500 hover:text-orange-600 transition-colors">
                        <?php esc_html_e('Description', 'erdu-wp'); ?>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($has_features) : ?>
                    <a href="#section-features" class="erdu-nav-link whitespace-nowrap text-lg font-bold text-gray-500 hover:text-orange-600 transition-colors">
                        <?php esc_html_e('Features', 'erdu-wp'); ?>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($has_specs) : ?>
                    <a href="#section-specs" class="erdu-nav-link whitespace-nowrap text-lg font-bold text-gray-500 hover:text-orange-600 transition-colors">
                        <?php esc_html_e('Specs', 'erdu-wp'); ?>
                    </a>
                    <?php endif; ?>
                    
                    <?php if ($has_downloads) : ?>
                    <a href="#section-downloads" class="erdu-nav-link whitespace-nowrap text-lg font-bold text-gray-500 hover:text-orange-600 transition-colors">
                        <?php esc_html_e('Downloads', 'erdu-wp'); ?>
                    </a>
                    <?php endif; ?>
                </nav>
            </div>

            <!-- Content Blocks -->
            <div class="erdu-content-blocks bg-white rounded-xl shadow-sm border border-gray-100 p-6 lg:p-10 space-y-16 max-w-full overflow-hidden">
                
                <!-- Block: Description -->
                <?php if ($has_desc) : ?>
                <div id="section-desc" class="erdu-content-block scroll-mt-32">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100"><?php esc_html_e('Description', 'erdu-wp'); ?></h2>
                    <div class="prose prose-lg max-w-none text-gray-600">
                        <?php echo apply_filters('the_content', $content); ?>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Block: Product Features -->
                <?php if ($has_features) : ?>
                <div id="section-features" class="erdu-content-block scroll-mt-32">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100"><?php esc_html_e('Features', 'erdu-wp'); ?></h2>
                    <div class="prose prose-lg max-w-none text-gray-600">
                        <ul class="list-disc pl-5 space-y-4">
                            <?php while (have_rows('product_features')) : the_row(); 
                                $f_title = get_sub_field('title');
                                $f_desc = get_sub_field('description');
                            ?>
                                <li><strong class="text-gray-900"><?php echo esc_html($f_title); ?></strong> - <?php echo esc_html($f_desc); ?></li>
                            <?php endwhile; ?>
                        </ul>
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Block: Technical Specs -->
                <?php if ($has_specs) : ?>
                <div id="section-specs" class="erdu-content-block scroll-mt-32">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100"><?php esc_html_e('Specifications', 'erdu-wp'); ?></h2>
                    <div class="text-gray-600 bg-gray-50 rounded-xl p-1 overflow-hidden">
                        <table class="w-full text-left text-base border-collapse bg-white rounded-lg">
                            <tbody class="divide-y divide-gray-100">
                                <?php while (have_rows('product_specifications')) : the_row(); 
                                    $spec_name = get_sub_field('spec_name');
                                    $spec_value = get_sub_field('spec_value');
                                ?>
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <th class="py-4 px-6 font-medium text-gray-500 w-1/3 lg:w-1/4 border-r border-gray-100"><?php echo esc_html($spec_name); ?></th>
                                    <td class="py-4 px-6 font-bold text-gray-900"><?php echo esc_html($spec_value); ?></td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Block: Downloads -->
                <?php if ($has_downloads) : ?>
                <div id="section-downloads" class="erdu-content-block scroll-mt-32">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6 pb-4 border-b border-gray-100"><?php esc_html_e('Downloads', 'erdu-wp'); ?></h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <?php while (have_rows('product_downloads')) : the_row(); 
                            $title = get_sub_field('title');
                            $file = get_sub_field('file');
                        ?>
                            <a href="<?php echo esc_url($file); ?>" target="_blank" class="inline-flex items-center justify-between text-base font-medium text-orange-600 hover:text-orange-800 transition-all bg-orange-50 hover:bg-orange-100 border border-orange-100 px-6 py-4 rounded-xl shadow-sm hover:shadow-md">
                                <span class="flex items-center">
                                    <svg class="w-6 h-6 mr-3 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    <?php echo esc_html($title); ?>
                                </span>
                            </a>
                        <?php endwhile; ?>
                    </div>
                </div>
                <?php endif; ?>

            </div>
        </div>
    </div>

</div>

<!-- Smooth Scroll & Active Nav State Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.erdu-nav-link');
    const sections = document.querySelectorAll('.erdu-content-block');
    
    // Smooth scrolling for navigation links
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Intersection Observer to highlight active nav link on scroll
    const observerOptions = {
        root: null,
        rootMargin: '-100px 0px -60% 0px', // Trigger slightly above center
        threshold: 0
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                // Remove active styling from all links
                navLinks.forEach(link => {
                    link.classList.remove('text-orange-600', 'border-b-2', 'border-orange-600');
                    link.classList.add('text-gray-500');
                });
                
                // Add active styling to current section's link
                const activeId = '#' + entry.target.id;
                const activeLink = document.querySelector(`.erdu-nav-link[href="${activeId}"]`);
                if (activeLink) {
                    activeLink.classList.remove('text-gray-500');
                    activeLink.classList.add('text-orange-600', 'border-b-2', 'border-orange-600');
                }
            }
        });
    }, observerOptions);

    sections.forEach(section => {
        observer.observe(section);
    });
});
</script>
<?php 
do_action('woocommerce_after_single_product'); 
?>
