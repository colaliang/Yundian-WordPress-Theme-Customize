<?php
/**
 * Template Name: News & Events
 *
 * @package ERDU_Lighting
 */

get_header();

$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'news';

if (have_posts()) :
    while (have_posts()) :
        the_post();

        // ---- Hero (independent page fields — NOT from Page Settings) ----
        $hero_title    = erdu_page_field('news_hero_title', get_the_title());
        $hero_subtitle = erdu_page_field('news_hero_subtitle', __('Stay updated with the latest from ERDU Lighting', 'erdu-wp'));
        $hero_bg       = erdu_page_field('news_hero_bg', 'https://images.unsplash.com/photo-1504711434969-e33886168f5c?w=1200');
        $hero_btn      = erdu_page_field('news_hero_btn', '');
        $hero_btn_link = erdu_page_field('news_hero_btn_link', '');
        $hero_btn2     = erdu_page_field('news_hero_btn2', '');
        $hero_btn2_link = erdu_page_field('news_hero_btn2_link', '');

        // ---- Page Content ----
        $page_content = erdu_page_field('news_page_editor', '');

        // ---- Introduction ----
        $intro = erdu_page_field('news_intro', '');

        // ---- News Settings ----
        $news_count = erdu_page_field('news_count', 6);

        // ---- Exhibitions Settings ----
        $expo_source = erdu_page_field('news_expo_source', 'custom');
        $expo_count  = erdu_page_field('news_expo_count', 3);

        // ---- Tab Labels ----
        $tab_news_label = erdu_page_field('news_tab_news_label', __('News', 'erdu-wp'));
        $tab_expo_label = erdu_page_field('news_tab_expo_label', __('Exhibitions', 'erdu-wp'));
        $empty_news_title = erdu_page_field('news_empty_title', __('Stay Tuned for Latest Updates', 'erdu-wp'));
        $empty_news_text  = erdu_page_field('news_empty_text', __('News articles will be published here soon.', 'erdu-wp'));

        // ---- Load News from CPT ----
        $news_articles = array();
        $news_query = new WP_Query(array(
            'post_type'      => 'erdu_news',
            'posts_per_page' => intval($news_count),
            'post_status'    => 'publish',
            'orderby'        => 'date',
            'order'          => 'DESC',
        ));
        if ($news_query->have_posts()) {
            while ($news_query->have_posts()) {
                $news_query->the_post();
                $news_id = get_the_ID();
                $thumb_url = get_the_post_thumbnail_url($news_id, 'medium');
                $news_articles[] = array(
                    'title'   => get_the_title(),
                    'date'    => get_the_date(),
                    'excerpt' => get_the_excerpt(),
                    'image'   => $thumb_url ? $thumb_url : '',
                    'link'    => get_permalink(),
                );
            }
            wp_reset_postdata();
        }

        // ---- Load Exhibitions ----
        $exhibitions = array();
        if ($expo_source === 'cpt') {
            // Load from Exhibition CPT
            $expo_query = new WP_Query(array(
                'post_type'      => 'erdu_exhibition',
                'posts_per_page' => intval($expo_count),
                'post_status'    => 'publish',
                'orderby'        => 'date',
                'order'          => 'DESC',
            ));
            if ($expo_query->have_posts()) {
                while ($expo_query->have_posts()) {
                    $expo_query->the_post();
                    $expo_id = get_the_ID();
                    $exhibitions[] = array(
                        'name'     => get_the_title(),
                        'date'     => get_post_meta($expo_id, 'exhibition_date', true) ?: get_the_date(),
                        'location' => get_post_meta($expo_id, 'exhibition_location', true) ?: '',
                        'booth'    => get_post_meta($expo_id, 'exhibition_booth', true) ?: '',
                        'link'     => get_post_meta($expo_id, 'exhibition_link', true) ?: '',
                    );
                }
                wp_reset_postdata();
            }
        }
        // Fallback to ACF if CPT has no data
        if (empty($exhibitions)) {
            $exhibitions = erdu_page_field('news_exhibitions', array(
                array('name' => __('Hong Kong International Lighting Fair', 'erdu-wp'), 'date' => __('October 27-30, 2026', 'erdu-wp'), 'location' => __('Hong Kong', 'erdu-wp'), 'booth' => __('Hall 1A-C12', 'erdu-wp'), 'link' => ''),
                array('name' => __('Frankfurt Light + Building', 'erdu-wp'), 'date' => __('March 8-13, 2026', 'erdu-wp'), 'location' => __('Frankfurt, Germany', 'erdu-wp'), 'booth' => __('Hall 4.0-B20', 'erdu-wp'), 'link' => ''),
                array('name' => __('Dubai LED Expo', 'erdu-wp'), 'date' => __('January 16-18, 2026', 'erdu-wp'), 'location' => __('Dubai, UAE', 'erdu-wp'), 'booth' => __('Zabeel Hall 3', 'erdu-wp'), 'link' => ''),
            ));
        }
        ?>

        <!-- Hero -->
        <section class="relative py-20" style="background: linear-gradient(135deg, #2D1810 0%, #4A2510 100%);">
            <div class="absolute inset-0 opacity-20" style="background-image: url('<?php echo esc_url($hero_bg); ?>'); background-size: cover; background-position: center;"></div>
            <div class="relative erdu-container text-center">
                <?php erdu_breadcrumb(); ?>
                <h1 class="text-3xl md:text-4xl font-bold text-white"><?php echo esc_html($hero_title); ?></h1>
                <p class="text-orange-100 mt-4 max-w-2xl mx-auto"><?php echo esc_html($hero_subtitle); ?></p>
                <?php if ($hero_btn || $hero_btn2) : ?>
                    <div class="flex flex-wrap gap-4 justify-center mt-8">
                        <?php if ($hero_btn && $hero_btn_link) : ?>
                            <a href="<?php echo esc_url($hero_btn_link); ?>" class="px-6 py-3 font-semibold rounded-lg text-white transition-colors" style="background-color: #F37021;"><?php echo esc_html($hero_btn); ?></a>
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

        <!-- Tabs -->
        <section class="py-16" style="background-color: #F9FAFB;">
            <div class="erdu-container">
                <!-- Tab Navigation -->
                <div class="flex gap-1 mb-8">
                    <a href="?tab=news" class="px-6 py-3 rounded-lg font-medium text-sm border transition-all <?php echo $active_tab === 'news' ? 'text-white border-orange-500' : 'bg-white text-gray-600 border-gray-200 hover:border-orange-300'; ?>" <?php echo $active_tab === 'news' ? 'style="background-color: #F37021;"' : ''; ?>><?php echo esc_html($tab_news_label); ?></a>
                    <a href="?tab=exhibitions" class="px-6 py-3 rounded-lg font-medium text-sm border transition-all <?php echo $active_tab === 'exhibitions' ? 'text-white border-orange-500' : 'bg-white text-gray-600 border-gray-200 hover:border-orange-300'; ?>" <?php echo $active_tab === 'exhibitions' ? 'style="background-color: #F37021;"' : ''; ?>><?php echo esc_html($tab_expo_label); ?></a>
                </div>

                <?php if ($active_tab === 'news') : ?>
                    <!-- News Articles from CPT -->
                    <?php if (!empty($news_articles)) : ?>
                        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                            <?php foreach ($news_articles as $article) : ?>
                                <a href="<?php echo esc_url($article['link']); ?>" class="block group">
                                    <div class="bg-white rounded-xl overflow-hidden border border-gray-200 hover:shadow-lg transition-shadow group-hover:shadow-xl">
                                        <?php if (!empty($article['image'])) : ?>
                                            <div class="h-48 overflow-hidden">
                                                <img src="<?php echo esc_url($article['image']); ?>" alt="<?php echo esc_attr($article['title']); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform">
                                            </div>
                                        <?php endif; ?>
                                        <div class="p-5">
                                            <p class="text-xs text-gray-400 mb-1"><?php echo esc_html($article['date']); ?></p>
                                            <h3 class="font-semibold mb-2" style="color: #333;"><?php echo esc_html($article['title']); ?></h3>
                                            <?php if (!empty($article['excerpt'])) : ?><p class="text-sm text-gray-500 line-clamp-3"><?php echo esc_html($article['excerpt']); ?></p><?php endif; ?>
                                            <span class="text-sm font-medium mt-3 inline-block" style="color: #F37021;"><?php _e('Read More', 'erdu-wp'); ?> &rarr;</span>
                                        </div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <!-- Empty State -->
                        <div class="text-center py-16">
                            <svg class="w-16 h-16 mx-auto mb-4" style="color: #F37021; opacity: 0.3;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15"/></svg>
                            <h3 class="text-lg font-semibold mb-2" style="color: #333;"><?php echo esc_html($empty_news_title); ?></h3>
                            <p class="text-gray-500"><?php echo esc_html($empty_news_text); ?></p>
                        </div>
                    <?php endif; ?>

                <?php else : ?>
                    <!-- Exhibitions -->
                    <?php if (!empty($exhibitions)) : ?>
                        <h3 class="erdu-h3 mb-6"><?php _e('Upcoming Exhibitions', 'erdu-wp'); ?></h3>
                        <div class="grid md:grid-cols-3 gap-6 mb-12">
                            <?php foreach ($exhibitions as $e) :
                                $e_link = !empty($e['link']) ? $e['link'] : '';
                            ?>
                                <?php if ($e_link) : ?><a href="<?php echo esc_url($e_link); ?>" target="_blank" rel="noopener" class="block group"><?php endif; ?>
                                <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow<?php echo $e_link ? ' group-hover:shadow-xl' : ''; ?>">
                                    <div class="flex items-center gap-2 mb-3">
                                        <span class="px-2 py-1 text-xs rounded-full" style="background-color: #FFF5ED; color: #F37021;"><?php _e('Upcoming', 'erdu-wp'); ?></span>
                                    </div>
                                    <h4 class="font-semibold mb-2" style="color: #333;"><?php echo esc_html($e['name']); ?></h4>
                                    <?php if (!empty($e['date'])) : ?><p class="text-sm text-gray-500 mb-1"><?php echo esc_html($e['date']); ?></p><?php endif; ?>
                                    <?php if (!empty($e['location'])) : ?><p class="text-sm text-gray-500 mb-1"><?php echo esc_html($e['location']); ?></p><?php endif; ?>
                                    <?php if (!empty($e['booth'])) : ?><p class="text-sm font-medium" style="color: #F37021;"><?php printf(__('Booth: %s', 'erdu-wp'), esc_html($e['booth'])); ?></p><?php endif; ?>
                                </div>
                                <?php if ($e_link) : ?></a><?php endif; ?>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="text-center py-16">
                            <p class="text-gray-500"><?php _e('No upcoming exhibitions at the moment. Check back soon!', 'erdu-wp'); ?></p>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </section>

        <?php
    endwhile;
endif;

// ---- CTA (independent page field — NOT from Page Settings) ----
$cta_override = erdu_page_field('news_cta_override', false);
if ($cta_override) {
    erdu_cta_section(
        erdu_page_field('news_cta_title', __('Want Product Updates?', 'erdu-wp')),
        erdu_page_field('news_cta_button', __('Subscribe to Newsletter', 'erdu-wp')),
        erdu_page_field('news_cta_link', '#newsletter')
    );
} else {
    erdu_cta_section(__('Want Product Updates?', 'erdu-wp'), __('Subscribe to Newsletter', 'erdu-wp'), '#newsletter', __('Contact Us', 'erdu-wp'), erdu_get_page_url('contact'));
}

get_footer();
