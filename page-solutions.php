<?php
/**
 * Template Name: Solutions
 *
 * @package ERDU_Lighting
 */

get_header();

// Fallback categories (used when ACF has no data)
$categories = array(
    'commercial'   => __('Commercial Lighting', 'erdu-wp'),
    'residential'  => __('Residential Lighting', 'erdu-wp'),
    'hospitality'  => __('Hospitality Lighting', 'erdu-wp'),
    'industrial'   => __('Industrial Lighting', 'erdu-wp'),
    'custom'       => __('Custom Projects', 'erdu-wp'),
);

$cat = isset($_GET['category']) ? sanitize_text_field($_GET['category']) : '';

if (have_posts()) :
    while (have_posts()) :
        the_post();

        // ---- Hero (independent page fields — NOT from Page Settings) ----
        $hero_title    = erdu_page_field('solutions_hero_title', get_the_title());
        $hero_subtitle = erdu_page_field('solutions_hero_subtitle', __('Tailored magnetic track lighting solutions for every application scenario', 'erdu-wp'));
        $hero_bg       = erdu_page_field('solutions_hero_bg', 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=1200');
        $hero_btn      = erdu_page_field('solutions_hero_btn', '');
        $hero_btn_link = erdu_page_field('solutions_hero_btn_link', '');
        $hero_btn2     = erdu_page_field('solutions_hero_btn2', '');
        $hero_btn2_link = erdu_page_field('solutions_hero_btn2_link', '');

        // ---- Page Content (between Hero and Categories) ----
        $page_content = erdu_page_field('solutions_page_editor', '');

        // ---- Solutions Introduction ----
        $sol_intro = erdu_page_field('solutions_intro', '');

        // ---- Solution Categories (ACF repeater or fallback) ----
        $custom_cats = erdu_page_field('solutions_categories', array());

        // Build filter categories from ACF if available, otherwise use fallback
        if ($custom_cats) {
            $filter_cats = array();
            foreach ($custom_cats as $c) {
                $key = !empty($c['key']) ? $c['key'] : sanitize_title($c['name']);
                $filter_cats[$key] = $c['name'];
            }
        } else {
            $filter_cats = $categories;
        }
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

        <!-- Category Filter + Content -->
        <section class="py-16 bg-gray-50">
            <div class="erdu-container">
                <div class="max-w-3xl mx-auto text-center mb-12">
                    <?php if ($sol_intro) : ?>
                        <div class="prose max-w-none mb-8"><?php echo wp_kses_post($sol_intro); ?></div>
                    <?php else : ?>
                        <p class="text-gray-600"><?php _e('ERDU provides tailored lighting solutions for commercial, residential, hospitality, and industrial applications. Our 48V magnetic track system offers the flexibility to adapt to any project requirement.', 'erdu-wp'); ?></p>
                    <?php endif; ?>
                </div>

                <!-- Category Filters -->
                <div class="grid md:grid-cols-<?php echo esc_attr(min(count($filter_cats), 5)); ?> gap-4 mb-12">
                    <?php foreach ($filter_cats as $id => $label) : ?>
                        <a href="?category=<?php echo esc_attr($id); ?>#content" class="p-6 rounded-xl text-left transition-all border <?php echo $cat === $id ? 'text-white border-orange-500 shadow-lg erdu-bg-primary' : 'bg-white text-gray-700 border-gray-200 hover:shadow-md'; ?>">
                            <h3 class="font-semibold text-sm mb-1"><?php echo esc_html($label); ?></h3>
                            <p class="text-xs <?php echo $cat === $id ? 'text-orange-100' : 'text-gray-500'; ?>"><?php _e('View solution', 'erdu-wp'); ?> &rarr;</p>
                        </a>
                    <?php endforeach; ?>
                </div>

                <!-- Category Cards -->
                <?php if ($custom_cats) : ?>
                    <div class="grid md:grid-cols-3 gap-6">
                        <?php foreach ($custom_cats as $c) :
                            $card_link = !empty($c['link']) ? $c['link'] : '';
                        ?>
                            <?php if ($card_link) : ?><a href="<?php echo esc_url($card_link); ?>" class="block group"><?php endif; ?>
                            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow<?php echo $card_link ? ' group-hover:shadow-xl' : ''; ?>">
                                <?php if (!empty($c['image'])) : ?>
                                    <div class="h-40 overflow-hidden">
                                        <img src="<?php echo esc_url($c['image']); ?>" alt="<?php echo esc_attr($c['name']); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform">
                                    </div>
                                <?php endif; ?>
                                <div class="p-5">
                                    <h4 class="font-semibold mb-1 text-gray-800"><?php echo esc_html($c['name']); ?></h4>
                                    <?php if (!empty($c['description'])) : ?>
                                        <p class="text-sm text-gray-500"><?php echo esc_html($c['description']); ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <?php if ($card_link) : ?></a><?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
    endwhile;
endif;

// ---- CTA (independent page field — NOT from Page Settings) ----
$cta_override = erdu_page_field('solutions_cta_override', false);
if ($cta_override) {
    erdu_cta_section(
        erdu_page_field('solutions_cta_title', __('Need a Custom Solution?', 'erdu-wp')),
        erdu_page_field('solutions_cta_button', __('Get Free Consultation', 'erdu-wp')),
        erdu_page_field('solutions_cta_link', erdu_get_page_url('contact'))
    );
} else {
    erdu_cta_section(__('Need a Custom Solution?', 'erdu-wp'), __('Get Free Consultation', 'erdu-wp'), erdu_get_page_url('contact'));
}

get_footer();
