<?php
/**
 * Template Name: Products
 *
 * Displays WooCommerce product categories. Falls back to demo data when WooCommerce is not active.
 *
 * @package ERDU_Lighting
 */

get_header();

// Fallback series data (used when WooCommerce is not active)
$series_data = array(
    'ut' => array('name' => 'UT Series', 'tag' => __('Track Light', 'erdu-wp'), 'power' => '10-35W', 'angle' => '24°/36°', 'cri' => '90+', 'cct' => '2700K-5000K', 'description' => __('Universal track light for commercial spaces. High CRI, multiple beam angles, compatible with all 48V magnetic tracks.', 'erdu-wp'), 'image' => 'https://images.unsplash.com/photo-1565814329452-e1efa11c5b89?w=600'),
    'gs' => array('name' => 'GS Series', 'tag' => __('Grille Spot', 'erdu-wp'), 'power' => '10-30W', 'angle' => '24°/36°/60°', 'cri' => '90+', 'cct' => '3000K-4000K', 'description' => __('Grille spot light with anti-glare design. Single, double, and triple head options for flexible lighting layouts.', 'erdu-wp'), 'image' => 'https://images.unsplash.com/photo-1540932296774-3ed6d23f9b58?w=600'),
    'dt' => array('name' => 'DT Series', 'tag' => __('Down Light', 'erdu-wp'), 'power' => '7-30W', 'angle' => '60°/120°', 'cri' => '90+', 'cct' => '2700K-6000K', 'description' => __('Recessed down light with deep anti-glare reflector. Ideal for hotels, offices, and residential projects.', 'erdu-wp'), 'image' => 'https://images.unsplash.com/photo-1513506003901-1e6a229e2d15?w=600'),
    'lt' => array('name' => 'LT Series', 'tag' => __('Linear Light', 'erdu-wp'), 'power' => '10-40W/m', 'angle' => '120°', 'cri' => '90+', 'cct' => '3000K-5000K', 'description' => __('Linear light bar for continuous illumination. Perfect for corridors, shelves, and accent lighting.', 'erdu-wp'), 'image' => 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600'),
);

if (have_posts()) :
    while (have_posts()) :
        the_post();

        // ---- Hero (independent page fields) ----
        $hero_title    = erdu_page_field('products_hero_title', get_the_title());
        $hero_subtitle = erdu_page_field('products_hero_subtitle', __('Professional 48V magnetic track lighting series for commercial, residential, and industrial applications', 'erdu-wp'));
        $hero_bg       = erdu_page_field('products_hero_bg', 'https://images.unsplash.com/photo-1565814329452-e1efa11c5b89?w=1200');
        $hero_btn      = erdu_page_field('products_hero_btn', '');
        $hero_btn_link = erdu_page_field('products_hero_btn_link', '');
        $hero_btn2     = erdu_page_field('products_hero_btn2', '');
        $hero_btn2_link = erdu_page_field('products_hero_btn2_link', '');

        // ---- Page Content ----
        $page_content = erdu_page_field('products_page_editor', '');

        // ---- Products Introduction ----
        $prod_intro = erdu_page_field('products_intro', '');
        ?>

        <!-- Hero -->
        <section class="relative py-20 erdu-bg-dark">
            <div class="absolute inset-0 opacity-20" style="background-image: url('<?php echo esc_url($hero_bg); ?>'); background-size: cover; background-position: center;"></div>
            <div class="relative erdu-container text-center">
                <?php erdu_breadcrumb(); ?>
                <h1 class="text-3xl md:text-4xl font-bold text-white"><?php echo esc_html($hero_title); ?></h1>
                <p class="text-blue-100 mt-4 max-w-2xl mx-auto"><?php echo esc_html($hero_subtitle); ?></p>
                <?php if ($hero_btn || $hero_btn2) : ?>
                    <div class="flex flex-wrap gap-4 justify-center mt-8">
                        <?php if ($hero_btn && $hero_btn_link) : ?>
                            <a href="<?php echo esc_url($hero_btn_link); ?>" class="px-6 py-3 font-semibold rounded-lg text-white transition-colors erdu-bg-primary"><?php echo esc_html($hero_btn); ?></a>
                        <?php endif; ?>
                        <?php if ($hero_btn2 && $hero_btn2_link) : ?>
                            <a href="<?php echo esc_url($hero_btn2_link); ?>" class="px-6 py-3 font-semibold rounded-lg border-2 border-white text-white hover:bg-white hover:text-gray-900 transition-colors"><?php echo esc_html($hero_btn2); ?></a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <!-- Editable Page Content -->
        <?php if ($page_content) : ?>
        <section class="py-12 bg-white">
            <div class="erdu-container"><div class="prose prose-lg max-w-none"><?php echo wp_kses_post($page_content); ?></div></div>
        </section>
        <?php endif; ?>

        <!-- Products Grid -->
        <section class="py-16 bg-gray-50">
            <div class="erdu-container">
                <div class="text-center mb-12 max-w-2xl mx-auto">
                    <?php if ($prod_intro) : ?>
                        <div class="prose max-w-none mb-8"><?php echo wp_kses_post($prod_intro); ?></div>
                    <?php else : ?>
                        <p class="text-gray-600"><?php _e('Explore our comprehensive range of 48V magnetic track lighting products. All series are designed for seamless compatibility and professional performance.', 'erdu-wp'); ?></p>
                    <?php endif; ?>
                </div>

                <?php if (class_exists('WooCommerce')) : ?>

                    <?php
                    // Fetch all top-level WooCommerce product categories
                    $categories = get_terms(array(
                        'taxonomy'   => 'product_cat',
                        'hide_empty' => true,
                        'parent'     => 0,
                        'orderby'    => 'name',
                        'order'      => 'ASC',
                    ));
                    ?>

                    <?php if (!empty($categories) && !is_wp_error($categories)) : ?>
                        <?php foreach ($categories as $cat_obj) :
                            $cat_id        = $cat_obj->term_id;
                            $cat_name      = $cat_obj->name;
                            $cat_desc      = $cat_obj->description;
                            $cat_link      = get_term_link($cat_obj);
                            $thumbnail_id  = get_term_meta($cat_id, 'thumbnail_id', true);
                            $cat_image     = $thumbnail_id ? wp_get_attachment_url($thumbnail_id) : '';
                            $product_count = $cat_obj->count;

                            // Query products in this category (show up to 4)
                            $products_in_cat = array();
                            $wc_query = new WP_Query(array(
                                'post_type'      => 'product',
                                'posts_per_page' => 4,
                                'post_status'    => 'publish',
                                'tax_query'      => array(
                                    array(
                                        'taxonomy' => 'product_cat',
                                        'field'    => 'term_id',
                                        'terms'    => $cat_id,
                                    ),
                                ),
                            ));
                            if ($wc_query->have_posts()) {
                                while ($wc_query->have_posts()) {
                                    $wc_query->the_post();
                                    global $product;
                                    $products_in_cat[] = array(
                                        'id'     => get_the_ID(),
                                        'title'  => get_the_title(),
                                        'url'    => get_permalink(),
                                        'image'  => get_the_post_thumbnail_url(get_the_ID(), 'medium'),
                                        'price'  => $product ? $product->get_price_html() : '',
                                    );
                                }
                                wp_reset_postdata();
                            }
                        ?>
                            <!-- Series Section -->
                            <div class="mb-16 last:mb-0">
                                <!-- Series Header Card -->
                                <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow mb-6">
                                    <div class="grid md:grid-cols-5 gap-0">
                                        <?php if ($cat_image) : ?>
                                            <div class="md:col-span-2 h-48 md:h-auto overflow-hidden">
                                                <img src="<?php echo esc_url($cat_image); ?>" alt="<?php echo esc_attr($cat_name); ?>" class="w-full h-full object-cover">
                                            </div>
                                        <?php endif; ?>
                                        <div class="md:col-span-<?php echo $cat_image ? '3' : '5'; ?> p-6 flex flex-col justify-center">
                                            <div class="flex items-center gap-3 mb-2">
                                                <h3 class="font-semibold text-xl text-gray-800"><?php echo esc_html($cat_name); ?></h3>
                                                <span class="px-2 py-1 text-xs rounded-full bg-orange-50 erdu-text-primary"><?php printf(__('%d Products', 'erdu-wp'), intval($product_count)); ?></span>
                                            </div>
                                            <?php if ($cat_desc) : ?><p class="text-sm text-gray-600 mb-4"><?php echo esc_html($cat_desc); ?></p><?php endif; ?>
                                            <a href="<?php echo esc_url($cat_link); ?>" class="inline-flex items-center gap-1 text-sm font-medium erdu-text-primary"><?php _e('View All', 'erdu-wp'); ?> &rarr;</a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Products in this Series -->
                                <?php if (!empty($products_in_cat)) : ?>
                                    <div class="grid sm:grid-cols-2 lg:grid-cols-<?php echo esc_attr(min(count($products_in_cat), 4)); ?> gap-4">
                                        <?php foreach ($products_in_cat as $p) : ?>
                                            <a href="<?php echo esc_url($p['url']); ?>" class="block group">
                                                <div class="bg-white rounded-lg overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow group-hover:shadow-xl">
                                                    <?php if ($p['image']) : ?>
                                                        <div class="h-40 overflow-hidden">
                                                            <img src="<?php echo esc_url($p['image']); ?>" alt="<?php echo esc_attr($p['title']); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform">
                                                        </div>
                                                    <?php endif; ?>
                                                    <div class="p-4">
                                                        <h4 class="font-medium text-sm mb-1 text-gray-800"><?php echo esc_html($p['title']); ?></h4>
                                                        <?php if ($p['price']) : ?><p class="text-sm font-semibold erdu-text-primary"><?php echo wp_kses_post($p['price']); ?></p><?php endif; ?>
                                                    </div>
                                                </div>
                                            </a>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="text-center py-12">
                            <p class="text-gray-500"><?php _e('No WooCommerce product categories found. Please create categories in Products > Categories.', 'erdu-wp'); ?></p>
                        </div>
                    <?php endif; ?>

                <?php else : ?>
                    <!-- WooCommerce not active — render fallback demo data -->
                    <div class="grid md:grid-cols-2 gap-6">
                        <?php foreach ($series_data as $key => $s) : ?>
                            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow">
                                <div class="h-48 overflow-hidden">
                                    <img src="<?php echo esc_url($s['image']); ?>" alt="<?php echo esc_attr($s['name']); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform">
                                </div>
                                <div class="p-6">
                                    <div class="flex justify-between items-start mb-2">
                                        <h3 class="font-semibold text-lg text-gray-800"><?php echo esc_html($s['name']); ?></h3>
                                        <span class="px-2 py-1 text-xs rounded-full bg-orange-50 erdu-text-primary"><?php echo esc_html($s['tag']); ?></span>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-3"><?php echo esc_html($s['description']); ?></p>
                                    <div class="grid grid-cols-2 gap-2 text-xs">
                                        <div class="p-2 rounded bg-gray-50"><span class="text-gray-500"><?php _e('Power:', 'erdu-wp'); ?></span> <span class="font-medium"><?php echo esc_html($s['power']); ?></span></div>
                                        <div class="p-2 rounded bg-gray-50"><span class="text-gray-500"><?php _e('Beam:', 'erdu-wp'); ?></span> <span class="font-medium"><?php echo esc_html($s['angle']); ?></span></div>
                                        <div class="p-2 rounded bg-gray-50"><span class="text-gray-500">CRI:</span> <span class="font-medium"><?php echo esc_html($s['cri']); ?></span></div>
                                        <div class="p-2 rounded bg-gray-50"><span class="text-gray-500">CCT:</span> <span class="font-medium"><?php echo esc_html($s['cct']); ?></span></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
    endwhile;
endif;

// ---- CTA ----
$cta_override = erdu_page_field('products_cta_override', false);
if ($cta_override) {
    erdu_cta_section(
        erdu_page_field('products_cta_title', __('Need a Custom Solution?', 'erdu-wp')),
        erdu_page_field('products_cta_button', __('Discuss Your Project', 'erdu-wp')),
        erdu_page_field('products_cta_link', erdu_get_page_url('contact'))
    );
} else {
    erdu_cta_section(__('Need a Custom Solution?', 'erdu-wp'), __('Discuss Your Project', 'erdu-wp'), erdu_get_page_url('contact'));
}

get_footer();
