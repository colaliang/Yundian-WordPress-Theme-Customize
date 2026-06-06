<?php
/**
 * Template Name: Case Studies
 *
 * @package ERDU_Lighting
 */

get_header();

// ---- Industry filter from URL ----
$industry = isset($_GET['industry']) ? sanitize_text_field($_GET['industry']) : '';

// ---- Build industry filter list (from ACF or fallback) ----
$industries_raw = erdu_page_field('cases_industries', array(
    array('key' => '', 'label' => 'All Industries'),
    array('key' => 'commercial', 'label' => 'Commercial'),
    array('key' => 'hospitality', 'label' => 'Hospitality'),
    array('key' => 'retail', 'label' => 'Retail'),
    array('key' => 'office', 'label' => 'Office'),
    array('key' => 'residential', 'label' => 'Residential'),
));
$industries = array();
foreach ($industries_raw as $ir) {
    $industries[$ir['key']] = $ir['label'];
}

if (have_posts()) :
    while (have_posts()) :
        the_post();

        // ---- Hero (independent page fields — NOT from Page Settings) ----
        $hero_title    = erdu_page_field('cases_hero_title', get_the_title());
        $hero_subtitle = erdu_page_field('cases_hero_subtitle', __('Discover how ERDU lighting transforms spaces worldwide', 'erdu-wp'));
        $hero_bg       = erdu_page_field('cases_hero_bg', 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=1200');
        $hero_btn      = erdu_page_field('cases_hero_btn', '');
        $hero_btn_link = erdu_page_field('cases_hero_btn_link', '');
        $hero_btn2     = erdu_page_field('cases_hero_btn2', '');
        $hero_btn2_link = erdu_page_field('cases_hero_btn2_link', '');

        // ---- Page Content ----
        $page_content = erdu_page_field('cases_page_editor', '');

        // ---- Introduction ----
        $intro = erdu_page_field('cases_intro', '');

        // ---- Case Studies Source ----
        $cases_source = erdu_page_field('cases_source', 'cpt');
        $cases_count  = erdu_page_field('cases_count', 6);

        // Build cases array based on source
        $cases = array();

        if ($cases_source === 'cpt') {
            // Dynamic: Load from Case Studies CPT
            $cpt_args = array(
                'post_type'      => 'erdu_case',
                'posts_per_page' => intval($cases_count),
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            );

            // Add industry taxonomy filter if applicable
            if (!empty($industry)) {
                $cpt_args['tax_query'] = array(
                    array(
                        'taxonomy' => 'erdu_case_industry',
                        'field'    => 'slug',
                        'terms'    => $industry,
                    ),
                );
            }

            $cpt_query = new WP_Query($cpt_args);
            if ($cpt_query->have_posts()) {
                while ($cpt_query->have_posts()) {
                    $cpt_query->the_post();
                    $case_id = get_the_ID();

                    // Get industry terms
                    $industry_terms = get_the_terms($case_id, 'erdu_case_industry');
                    $industry_slugs = array();
                    $industry_names = array();
                    if ($industry_terms && !is_wp_error($industry_terms)) {
                        foreach ($industry_terms as $term) {
                            $industry_slugs[] = $term->slug;
                            $industry_names[] = $term->name;
                        }
                    }

                    // Get featured image
                    $thumb_url = get_the_post_thumbnail_url($case_id, 'medium');
                    if (!$thumb_url) {
                        $thumb_url = 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600';
                    }

                    // Build meta array: location · area · year
                    $meta = array();
                    $location = get_post_meta($case_id, 'case_location', true);
                    $area     = get_post_meta($case_id, 'case_area', true);
                    $year     = get_post_meta($case_id, 'case_year', true);
                    if ($location) $meta[] = $location;
                    if ($area)     $meta[] = $area;
                    if ($year)     $meta[] = $year;

                    // Tags
                    $tags = get_post_meta($case_id, 'case_tags', true);
                    if (!is_array($tags)) $tags = array();

                    $cases[] = array(
                        'title'          => get_the_title(),
                        'industry'       => !empty($industry_slugs) ? $industry_slugs[0] : '',
                        'industry_label' => !empty($industry_names) ? $industry_names[0] : '',
                        'image'          => get_post_meta($case_id, 'case_image_url', true) ?: $thumb_url,
                        'description'    => get_the_excerpt(),
                        'link'           => get_permalink(),
                        'meta'           => $meta,
                        'tags'           => $tags,
                        'is_cpt'         => true,
                    );
                }
                wp_reset_postdata();
            }
        } else {
            // Manual: Load from ACF repeater
            $acf_cases = erdu_page_field('cases_list', array());
            $limit = intval($cases_count);
            $count = 0;
            foreach ($acf_cases as $c) {
                if ($count >= $limit) break;

                // Filter by industry if set
                if (!empty($industry) && (!isset($c['industry']) || $c['industry'] !== $industry)) {
                    continue;
                }

                $ind_label = (!empty($c['industry']) && isset($industries[$c['industry']])) ? $industries[$c['industry']] : (isset($c['industry']) ? $c['industry'] : '');

                $meta = array();
                if (!empty($c['location'])) $meta[] = $c['location'];
                if (!empty($c['area']))     $meta[] = $c['area'];
                if (!empty($c['year']))     $meta[] = $c['year'];

                $tags = !empty($c['tags']) && is_array($c['tags']) ? $c['tags'] : array();

                $cases[] = array(
                    'title'          => $c['title'],
                    'industry'       => isset($c['industry']) ? $c['industry'] : '',
                    'industry_label' => $ind_label,
                    'image'          => !empty($c['image']) ? $c['image'] : 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600',
                    'description'    => isset($c['description']) ? $c['description'] : '',
                    'link'           => !empty($c['link']) ? $c['link'] : '',
                    'meta'           => $meta,
                    'tags'           => $tags,
                    'is_cpt'         => false,
                );
                $count++;
            }
        }

        // If no cases found, use fallback demo data matching the reference design
        if (empty($cases)) {
            $fallback_cases = array(
                array('title' => 'Luxury Boutique', 'industry' => 'retail', 'industry_label' => 'Retail & Commercial', 'image' => 'https://images.unsplash.com/photo-1441986300917-64674bd600d8?w=600', 'description' => '68% energy reduction, zero heat emission near merchandise, and customers reported the store felt more luxurious and inviting.', 'link' => '', 'meta' => array('Shanghai, China', '150m²', '2024'), 'tags' => array('48V Magnetic Track', '48V Magnetic Track')),
                array('title' => 'Modern Hotel Lobby', 'industry' => 'hospitality', 'industry_label' => 'Hospitality', 'image' => 'https://images.unsplash.com/photo-1542314831-068cd1dbfeeb?w=600', 'description' => '50% energy savings, guest satisfaction scores for \'lobby ambiance\' increased from 7.2 to 9.1, and the installation was completed in 5 days.', 'link' => '', 'meta' => array('Dubai, UAE', '800m²', '2023'), 'tags' => array('Magnetic Pendant Light', 'Magnetic Flood Light')),
                array('title' => 'Creative Office', 'industry' => 'office', 'industry_label' => 'Office & Public', 'image' => 'https://images.unsplash.com/photo-1497366216548-37526070297c?w=600', 'description' => 'UGR<19 achieved across all work areas, 45% energy reduction, and the company received a Green Building certification.', 'link' => '', 'meta' => array('Singapore', '600m²', '2024'), 'tags' => array('Linear Magnetic Light', 'Spotlight SPT-01')),
                array('title' => 'Minimalist Living', 'industry' => 'residential', 'industry_label' => 'Residential', 'image' => 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?w=600', 'description' => 'Achieved the desired minimalist aesthetic with full lighting flexibility. The homeowner has reconfigured the layout 4 times since installation.', 'link' => '', 'meta' => array('Melbourne, Australia', '120m²', '2024'), 'tags' => array('48V Magnetic Track', 'Folding Light EMF-02')),
                array('title' => 'Art Gallery', 'industry' => 'retail', 'industry_label' => 'Retail & Commercial', 'image' => 'https://images.unsplash.com/photo-1518998053901-5348d3961a04?w=600', 'description' => 'CRI95+ across all fixtures, zero UV emission (art-safe), and the gallery reported a 30% increase in visitor dwell time.', 'link' => '', 'meta' => array('Paris, France', '400m²', '2023'), 'tags' => array('48V Magnetic Track', 'Magnetic Track (2m)')),
                array('title' => 'Industrial Warehouse', 'industry' => 'office', 'industry_label' => 'Office & Public', 'image' => 'https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?w=600', 'description' => '62.5% energy reduction, improved color recognition for quality control, and maintenance costs dropped by 70%.', 'link' => '', 'meta' => array('Sao Paulo, Brazil', '2000m²', '2023'), 'tags' => array('High Watt Magnetic', 'High Bay Light')),
            );
            foreach ($fallback_cases as $fc) {
                if (!empty($industry) && $fc['industry'] !== $industry) continue;
                $cases[] = $fc;
            }
        }
        ?>

        <!-- Hero -->
        <section class="relative py-20 erdu-bg-secondary">
            <div class="absolute inset-0 opacity-20" style="background-image: url('<?php echo esc_url($hero_bg); ?>'); background-size: cover; background-position: center;"></div>
            <div class="relative erdu-container text-center">
                <?php erdu_breadcrumb(); ?>
                <h1 class="text-3xl md:text-4xl font-bold text-white"><?php echo esc_html($hero_title); ?></h1>
                <p class="text-orange-100 mt-4 max-w-2xl mx-auto"><?php echo esc_html($hero_subtitle); ?></p>
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

        <!-- Intro -->
        <?php if ($intro) : ?>
        <section class="py-8 bg-white">
            <div class="erdu-container"><div class="prose max-w-none"><?php echo wp_kses_post($intro); ?></div></div>
        </section>
        <?php endif; ?>

        <!-- Filter + Grid -->
        <section class="py-12 bg-gray-50">
            <div class="erdu-container">
                <!-- Industry Filters -->
                <div class="flex flex-wrap gap-2 mb-8">
                    <?php foreach ($industries as $key => $label) : ?>
                        <a href="<?php echo $key ? add_query_arg('industry', $key) : remove_query_arg('industry'); ?>" class="px-4 py-2 rounded-full text-sm font-medium transition-colors <?php echo $industry === $key ? 'bg-[#F37021] text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-100'; ?>"><?php echo esc_html($label); ?></a>
                    <?php endforeach; ?>
                </div>

                <!-- Cases Grid -->
                <?php if (!empty($cases)) : ?>
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                        <?php foreach ($cases as $case) :
                            $case_link = !empty($case['link']) ? $case['link'] : '';
                        ?>
                            <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow group cursor-pointer">
                                <div class="relative h-52 overflow-hidden">
                                    <img src="<?php echo esc_url(!empty($case['image']) ? $case['image'] : 'https://images.unsplash.com/photo-1558618666-fcd25c85f82e?w=600'); ?>" alt="<?php echo esc_attr($case['title']); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                    <?php if (!empty($case['industry_label'])) : ?>
                                        <span class="absolute top-3 left-3 px-3 py-1 bg-[#F37021] text-white text-xs rounded-full"><?php echo esc_html($case['industry_label']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="p-5">
                                    <?php if (!empty($case['meta'])) : ?>
                                        <div class="flex items-center gap-2 text-xs text-gray-400 mb-2">
                                            <?php foreach ($case['meta'] as $idx => $meta_item) : ?>
                                                <?php if ($idx > 0) : ?><span>·</span><?php endif; ?>
                                                <span><?php echo esc_html($meta_item); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <h3 class="font-semibold text-[#333] text-lg mb-2"><?php echo esc_html($case['title']); ?></h3>
                                    <?php if (!empty($case['description'])) : ?><p class="text-sm text-gray-500 mb-3"><?php echo esc_html($case['description']); ?></p><?php endif; ?>
                                    <?php if (!empty($case['tags'])) : ?>
                                        <div class="flex flex-wrap gap-1 mb-3">
                                            <?php foreach ($case['tags'] as $tag) : ?>
                                                <span class="px-2 py-0.5 bg-orange-50 text-[#F37021] text-xs rounded"><?php echo esc_html($tag); ?></span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if ($case_link) : ?>
                                        <a href="<?php echo esc_url($case_link); ?>" class="text-sm text-[#F37021] font-medium inline-flex items-center gap-1 hover:underline">
                                            <?php _e('View Case Study', 'erdu-wp'); ?>
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/></svg>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else : ?>
                    <div class="text-center py-12">
                        <p class="text-gray-500"><?php _e('No case studies found for the selected filter.', 'erdu-wp'); ?></p>
                        <a href="<?php echo esc_url(remove_query_arg('industry')); ?>" class="inline-block mt-4 text-sm font-medium erdu-text-primary"><?php _e('View All Cases', 'erdu-wp'); ?></a>
                    </div>
                <?php endif; ?>
            </div>
        </section>

        <?php
    endwhile;
endif;

// ---- CTA (independent page field — NOT from Page Settings) ----
$cta_override = erdu_page_field('cases_cta_override', false);
if ($cta_override) {
    erdu_cta_section(
        erdu_page_field('cases_cta_title', __('Have a Project in Mind?', 'erdu-wp')),
        erdu_page_field('cases_cta_button', __('Discuss Your Project', 'erdu-wp')),
        erdu_page_field('cases_cta_link', erdu_get_page_url('contact'))
    );
} else {
    erdu_cta_section(__('Have a Project in Mind?', 'erdu-wp'), __('Discuss Your Project', 'erdu-wp'), erdu_get_page_url('contact'));
}

get_footer();
