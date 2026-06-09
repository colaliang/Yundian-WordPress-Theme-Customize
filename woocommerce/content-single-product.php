<?php
/**
 * The template for displaying product content in the single-product.php template
 * Landing Page Style (Option A)
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

// Fetch ACF Data
$hero_bg = function_exists('get_field') ? get_field('hero_background_image') : '';
if (!$hero_bg) {
    // Fallback to product thumbnail
    $hero_bg = get_the_post_thumbnail_url($product->get_id(), 'full') ?: 'https://images.unsplash.com/photo-1565814329452-e1efa11c5b89?w=1920';
}
$hero_img = function_exists('get_field') ? get_field('hero_product_image') : '';
$subtitle = function_exists('get_field') ? get_field('product_subtitle') : '';

// 1. Hero Section
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class('product-landing-wrapper', $product); ?>>
    
    <section class="relative bg-gray-900 overflow-hidden" style="min-height: 80vh; display: flex; align-items: center;">
        <!-- Background -->
        <div class="absolute inset-0 z-0">
            <img src="<?php echo esc_url($hero_bg); ?>" alt="" class="w-full h-full object-cover opacity-30">
        </div>
        
        <div class="erdu-container relative z-10 py-20 w-full">
            <div class="flex flex-col lg:flex-row items-center justify-between gap-12">
                <!-- Text Content -->
                <div class="lg:w-1/2 text-white">
                    <?php
                    // Breadcrumb over hero
                    woocommerce_breadcrumb(array(
                        'wrap_before' => '<nav class="woocommerce-breadcrumb text-sm text-gray-400 mb-6 font-medium tracking-wide">',
                        'wrap_after'  => '</nav>',
                    ));
                    ?>
                    
                    <?php if ($subtitle) : ?>
                        <div class="text-orange-500 font-bold tracking-widest uppercase mb-3 text-sm"><?php echo esc_html($subtitle); ?></div>
                    <?php endif; ?>
                    
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold mb-6 leading-tight">
                        <?php the_title(); ?>
                    </h1>
                    
                    <div class="prose prose-lg text-gray-300 mb-10 max-w-xl">
                        <?php the_excerpt(); ?>
                    </div>
                    
                    <div>
                        <a href="#inquiry" class="inline-block bg-orange-600 hover:bg-orange-500 text-white font-bold py-4 px-10 rounded-full transition-colors text-lg shadow-[0_0_20px_rgba(243,112,33,0.4)] hover:shadow-[0_0_30px_rgba(243,112,33,0.6)]">
                            <?php esc_html_e('Inquire Now', 'erdu-wp'); ?>
                        </a>
                        <a href="#specs" class="inline-block ml-4 text-white hover:text-orange-400 font-medium py-4 px-6 transition-colors">
                            <?php esc_html_e('View Specs &darr;', 'erdu-wp'); ?>
                        </a>
                    </div>
                </div>
                
                <!-- Optional Cutout Image -->
                <?php if ($hero_img) : ?>
                <div class="lg:w-1/2 flex justify-center lg:justify-end">
                    <img src="<?php echo esc_url($hero_img); ?>" alt="<?php the_title_attribute(); ?>" class="max-w-full h-auto drop-shadow-2xl animate-fade-in-up">
                </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- 2. Overview Content -->
    <?php $content = get_the_content(); ?>
    <?php if (trim(strip_tags($content))) : ?>
    <section class="py-20 bg-white">
        <div class="erdu-container max-w-4xl text-center">
            <h2 class="text-3xl font-bold mb-10 text-gray-900"><?php esc_html_e('Product Overview', 'erdu-wp'); ?></h2>
            <div class="prose prose-lg mx-auto text-gray-600">
                <?php echo apply_filters('the_content', $content); ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- 3. Features Blocks (Alternating) -->
    <?php 
    if (function_exists('have_rows') && have_rows('product_features')) : 
        $idx = 0;
    ?>
    <div class="product-features-wrap bg-gray-50 py-10">
        <?php while (have_rows('product_features')) : the_row(); 
            $f_title = get_sub_field('title');
            $f_desc = get_sub_field('description');
            $f_img = get_sub_field('image');
            $f_align = get_sub_field('alignment'); // 'left' or 'right'
            $idx++;
            
            // If align is not set, alternate based on index
            if (!$f_align) {
                $f_align = ($idx % 2 == 0) ? 'right' : 'left';
            }
            
            $flex_dir = ($f_align === 'right') ? 'lg:flex-row-reverse' : 'lg:flex-row';
        ?>
        <section class="py-16 lg:py-24">
            <div class="erdu-container">
                <div class="flex flex-col <?php echo esc_attr($flex_dir); ?> items-center gap-12 lg:gap-20">
                    <div class="lg:w-1/2 w-full">
                        <?php if ($f_img) : ?>
                            <img src="<?php echo esc_url($f_img); ?>" alt="<?php echo esc_attr($f_title); ?>" class="w-full h-auto rounded-2xl shadow-xl">
                        <?php endif; ?>
                    </div>
                    <div class="lg:w-1/2 w-full">
                        <div class="inline-block text-orange-600 font-bold tracking-widest text-sm mb-4">0<?php echo $idx; ?></div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-6"><?php echo esc_html($f_title); ?></h2>
                        <div class="prose prose-lg text-gray-600 max-w-none">
                            <?php echo wpautop(wp_kses_post($f_desc)); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>

    <!-- 4. Applications Gallery -->
    <?php 
    $app_images = function_exists('get_field') ? get_field('application_images') : false;
    if ($app_images) : 
    ?>
    <section class="py-20 bg-white">
        <div class="erdu-container">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4"><?php esc_html_e('Application Scenarios', 'erdu-wp'); ?></h2>
                <p class="text-gray-500 max-w-2xl mx-auto"><?php esc_html_e('See how this product illuminates real-world spaces.', 'erdu-wp'); ?></p>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach ($app_images as $image_url) : ?>
                    <div class="group overflow-hidden rounded-xl bg-gray-100 aspect-w-4 aspect-h-3 relative">
                        <img src="<?php echo esc_url($image_url); ?>" alt="" class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-20 transition-all duration-300"></div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- 5. Technical Specifications -->
    <?php 
    $attributes = $product->get_attributes();
    if (!empty($attributes)) : 
    ?>
    <section id="specs" class="py-20 bg-gray-900 text-white">
        <div class="erdu-container max-w-5xl">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-bold mb-4"><?php esc_html_e('Technical Specifications', 'erdu-wp'); ?></h2>
            </div>
            
            <div class="bg-gray-800 rounded-2xl overflow-hidden border border-gray-700 shadow-2xl">
                <table class="w-full text-left text-sm md:text-base">
                    <tbody class="divide-y divide-gray-700">
                        <?php foreach ($attributes as $attribute) : 
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
                            
                            if ($value) :
                        ?>
                        <tr class="hover:bg-gray-750 transition-colors">
                            <th class="py-5 px-6 md:px-10 font-medium text-gray-400 w-1/3 border-r border-gray-700"><?php echo esc_html($name); ?></th>
                            <td class="py-5 px-6 md:px-10 font-bold text-white"><?php echo esc_html($value); ?></td>
                        </tr>
                        <?php 
                            endif;
                        endforeach; 
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- 6. Downloads -->
    <?php if (function_exists('have_rows') && have_rows('product_downloads')) : ?>
    <section class="py-16 bg-white border-b border-gray-200">
        <div class="erdu-container max-w-5xl">
            <h3 class="text-2xl font-bold mb-8 text-center"><?php esc_html_e('Downloads & Resources', 'erdu-wp'); ?></h3>
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php while (have_rows('product_downloads')) : the_row(); 
                    $title = get_sub_field('title');
                    $file = get_sub_field('file');
                ?>
                    <a href="<?php echo esc_url($file); ?>" target="_blank" class="flex items-center p-5 bg-gray-50 rounded-xl border border-gray-200 hover:bg-orange-50 hover:border-orange-200 transition-colors group">
                        <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center shadow-sm text-gray-400 group-hover:text-orange-500 mr-4 transition-colors">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        </div>
                        <span class="font-bold text-gray-800 group-hover:text-orange-700"><?php echo esc_html($title); ?></span>
                    </a>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>

    <!-- 7. Bottom CTA -->
    <section id="inquiry" class="py-24 bg-orange-600 text-white text-center">
        <div class="erdu-container max-w-3xl">
            <h2 class="text-4xl md:text-5xl font-extrabold mb-6"><?php esc_html_e('Ready to Upgrade Your Lighting?', 'erdu-wp'); ?></h2>
            <p class="text-xl text-orange-100 mb-10"><?php esc_html_e('Get a customized quote and expert advice for your project.', 'erdu-wp'); ?></p>
            <?php
            $inquiry_link = erdu_get_page_url('contact');
            $url = add_query_arg('product', urlencode($product->get_name()), $inquiry_link);
            ?>
            <a href="<?php echo esc_url($url); ?>" class="inline-block bg-white text-orange-600 hover:bg-gray-100 font-bold py-5 px-12 rounded-full transition-colors text-xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                <?php esc_html_e('Request a Quote', 'erdu-wp'); ?>
            </a>
        </div>
    </section>

</div>

<?php 
// We completely bypassed the default WooCommerce layout hooks to build our own.
// But we still fire this to allow plugins to hook after the product.
do_action('woocommerce_after_single_product'); 
?>
